<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;                 // ✅ សំខាន់!
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class PaywayController extends Controller
{
    protected function baseUrl(): string
    {
        $cfg = config('payway');
        return $cfg['env'] === 'prod' ? $cfg['urls']['prod'] : $cfg['urls']['sandbox'];
    }

    protected function endpoint(): string
    {
        // e.g. https://checkout-sandbox.payway.com.kh/api/payment-gateway/v1/payments/purchase
        return rtrim($this->baseUrl(), '/') . '/' . ltrim(config('payway.endpoint_path'), '/');
    }

    /** ✅ RSA-SHA256 over RAW JSON, return base64(signature) */
    protected function signRsa(string $rawJson): string
    {
        if (!function_exists('openssl_sign')) {
            throw new \RuntimeException('OpenSSL not available');
        }

        // Load private key (prefer file path)
        $pem = '';
        $path = (string) config('payway.rsa_private_path');
        if ($path && file_exists($path)) {
            $pem = (string) file_get_contents($path);
        }
        if (!$pem) {
            $pem = (string) config('payway.rsa_private_pem'); // full PEM in env (optional)
        }
        if (!$pem || !str_contains($pem, 'BEGIN')) {
            // fallback: base64 raw blob in env (optional)
            $raw = trim((string) config('payway.rsa_private'));
            if ($raw !== '') {
                $pem = "-----BEGIN RSA PRIVATE KEY-----\n{$raw}\n-----END RSA PRIVATE KEY-----";
            }
        }

        Log::info('payway.pem.debug', [
            'path'  => $path,
            'len'   => strlen($pem),
            'begin' => substr($pem, 0, 30),
            'end'   => substr($pem, -30),
        ]);

        $key = @openssl_pkey_get_private($pem, config('payway.rsa_pass') ?: null);
        if (!$key) {
            $errs = [];
            while ($e = openssl_error_string()) {
                $errs[] = $e;
            }
            throw new \RuntimeException('Invalid RSA Private Key. ' . implode(' | ', $errs));
        }

        $sig = '';
        $ok = @openssl_sign($rawJson, $sig, $key, OPENSSL_ALGO_SHA256);
        openssl_free_key($key);

        if (!$ok) {
            $errs = [];
            while ($e = openssl_error_string()) {
                $errs[] = $e;
            }
            throw new \RuntimeException('openssl_sign failed. ' . implode(' | ', $errs));
        }

        return base64_encode($sig);
    }

    /** ✅ Create payment: return qrImage/qrString/payment_url */
    public function purchase(Request $request)
    {
        try {
            $amountFloat = (float) $request->input('amount', 10.00);
            $amount      = number_format($amountFloat, 2, '.', '');
            $currency    = strtoupper(config('payway.currency', 'USD'));
            $merchant    = (string) config('payway.merchant_id');
            $tranId      = 'ORD-' . now()->format('YmdHis') . '-' . Str::upper(Str::random(5));
            $desc        = 'Order ' . $tranId;

            // 1) Save local order
            $order = Order::create([
                'user_id'        => Auth::id(),
                'product_id'     => $request->input('product_id'),
                'name'           => $request->input('receiver_name'),
                'rec_address'    => $request->input('receiver_address'),
                'phone'          => $request->input('receiver_phone'),
                'tran_id'        => $tranId,
                'amount'         => $amount,
                'currency'       => $currency,
                'payment_status' => 'pending',
                'status'         => 'in progress',
                'meta'           => ['cart' => $request->input('cart', [])],
            ]);

            // 2) Build payload for RSA JSON flow
            $payload = [
                'merchant_id'          => $merchant,
                'tran_id'              => $tranId,
                'amount'               => $amountFloat, // number
                'currency'             => $currency,
                'payment_description'  => $desc,
                'items'                => base64_encode(json_encode([
                    ['name' => 'Cart', 'quantity' => 1, 'price' => $amountFloat]
                ])),
                'return_url'           => (string) config('payway.return_url'),
                'cancel_url'           => (string) config('payway.cancel_url'),
                'continue_success_url' => (string) config('payway.continue_success_url'),
                'ipn_url'              => route('payway.ipn'),
            ];

            $rawJson   = json_encode($payload, JSON_UNESCAPED_SLASHES);
            $signature = $this->signRsa($rawJson);

            // 3) Send
            $resp = Http::timeout(25)
                ->withHeaders([
                    'Content-Type' => 'application/json',
                    'Key-Id'       => (string) config('payway.key_id'),
                    'Signature'    => $signature,
                ])
                ->post($this->endpoint(), $rawJson);

            if (!$resp->ok()) {
                $order->update([
                    'payment_status' => 'failed',
                    'status'         => 'failed',
                    'meta'           => array_merge($order->meta ?? [], ['purchase_error' => $resp->body()])
                ]);
                Log::error('PayWay Gateway error', ['status' => $resp->status(), 'body' => $resp->body()]);
                return response()->json(['ok' => false, 'message' => 'Gateway error'], 502);
            }

            $data = json_decode($resp->body(), true);
            if (!is_array($data)) {
                Log::error('Non-JSON gateway response', ['body' => $resp->body()]);
                return response()->json(['ok' => false, 'message' => 'Invalid gateway response'], 502);
            }

            $order->update(['meta' => array_merge($order->meta ?? [], ['purchase_response' => $data])]);

            return response()->json([
                'ok'      => true,
                'tran_id' => $tranId,
                'gateway' => $data,   // may include qrImage / qrString / payment_url
            ]);
        } catch (\Throwable $e) {
            Log::error('Purchase exception', ['error' => $e->getMessage()]);
            return response()->json(['ok' => false, 'message' => 'Server error: ' . $e->getMessage()], 500);
        }
    }

    /** ✅ IPN (server->server) */
    public function ipn(Request $request)
    {
        $merchant  = (string) $request->input('merchant_id');
        $tranId    = (string) $request->input('tran_id');
        $amountStr = number_format((float)$request->input('amount', 0), 2, '.', '');
        $currency  = (string) $request->input('currency');
        $status    = (string) $request->input('status');
        $hash      = (string) $request->input('hash');
        $signature = (string) $request->input('signature');

        $order = Order::where('tran_id', $tranId)->first();
        if (!$order) return response('UNKNOWN ORDER', 404);

        $valid = false;
        if ($signature) {
            // Verify RSA signature (some profiles sign this concatenation)
            $pem = '';
            $pubPath = (string) config('payway.rsa_public_path');
            if ($pubPath && file_exists($pubPath)) $pem = (string) file_get_contents($pubPath);
            if (!$pem) $pem = (string) config('payway.rsa_public_pem');
            if (!$pem || !str_contains($pem, 'BEGIN')) {
                $raw = trim((string) config('payway.rsa_public'));
                $pem = "-----BEGIN PUBLIC KEY-----\n{$raw}\n-----END PUBLIC KEY-----";
            }
            $key = @openssl_pkey_get_public($pem);
            if ($key) {
                $plain = $merchant . $tranId . $amountStr . $currency;
                $valid = (@openssl_verify($plain, base64_decode($signature), $key, OPENSSL_ALGO_SHA256) === 1);
                openssl_free_key($key);
            }
        } else {
            // HMAC fallback (legacy)
            $apiKey  = (string) config('payway.public_key');
            $expect  = hash('sha256', (string) config('payway.merchant_id') . $tranId . $amountStr . $currency . $apiKey);
            $valid   = hash_equals($expect, $hash);
        }

        if (!$valid) {
            Log::warning('PayWay IPN invalid signature', $request->all());
            return response('INVALID', 400);
        }

        if (number_format((float)$order->amount, 2, '.', '') !== $amountStr || $order->currency !== $currency) {
            Log::warning('PayWay IPN amount/currency mismatch', ['tran_id' => $tranId]);
            return response('MISMATCH', 400);
        }

        if ($status === '0') {
            $order->update([
                'payment_status' => 'paid',
                'status'         => 'completed',
                'meta'           => array_merge($order->meta ?? [], ['ipn' => $request->all()])
            ]);
        } else {
            $order->update([
                'payment_status' => 'failed',
                'status'         => 'failed',
                'meta'           => array_merge($order->meta ?? [], ['ipn' => $request->all()])
            ]);
        }

        Log::info('PayWay IPN OK', ['tran_id' => $tranId, 'status' => $status]);
        return response('OK', 200);
    }

    /** ✅ Return page (UI) */
    public function pushback(Request $request)
    {
        $tranId = $request->query('tran_id');
        $status = $request->query('status');
        $order  = $tranId ? Order::where('tran_id', $tranId)->first() : null;

        return view('home.payway_return', compact('tranId', 'status', 'order'));
    }
}

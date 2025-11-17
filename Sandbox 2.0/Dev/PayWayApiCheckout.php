<?php
class PayWayApiCheckout
{
    private $merchantId = 'ec462059';
    private $keyId      = 'b2e406b1c708e301da366179fdef5d587bd3371c';
    private $apiUrl     = 'https://checkout-sandbox.payway.com.kh/api/payment-gateway/v1/payments/purchase';
    private $publicKeyPath  = __DIR__ . '/keys/public.pem';
    private $privateKeyPath = __DIR__ . '/keys/private.pem';

    private function getPrivateKey()
    {
        $pem = file_get_contents($this->privateKeyPath);
        if (!$pem) throw new Exception('Private key not found.');
        $pkey = openssl_pkey_get_private($pem);
        if (!$pkey) throw new Exception('Invalid private key format.');
        return $pkey;
    }

    private function sign(string $payload): string
    {
        $pkey = $this->getPrivateKey();
        if (!openssl_sign($payload, $signature, $pkey, OPENSSL_ALGO_SHA256)) {
            throw new Exception('Unable to sign payload');
        }
        return base64_encode($signature);
    }

    public function purchase(float $amount, string $currency = 'USD'): array
    {
        $tranId = 'ORDER-' . time();
        $payload = [
            'merchant_id'  => $this->merchantId,
            'tran_id'      => $tranId,
            'amount'       => (float) number_format($amount, 2, '.', ''),
            'currency'     => $currency,
            'items'        => base64_encode(json_encode([
                ['name' => 'Cart Total', 'quantity' => 1, 'price' => (float)$amount]
            ])),
            'return_url'   => 'https://yourdomain.com/payway/return',
            'callback_url' => 'https://yourdomain.com/payway/callback'
        ];

        $raw = json_encode($payload, JSON_UNESCAPED_SLASHES);
        $signature = $this->sign($raw);

        $headers = [
            'Content-Type: application/json',
            'Key-Id: ' . $this->keyId,
            'Signature: ' . $signature
        ];

        $ch = curl_init($this->apiUrl);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $raw);
        $resp = curl_exec($ch);
        if ($resp === false) throw new Exception('cURL error: ' . curl_error($ch));
        $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        $data = json_decode($resp, true);
        if ($code >= 400) throw new Exception("HTTP $code: $resp");
        if (!is_array($data)) throw new Exception('Invalid JSON: ' . $resp);

        return $data;
    }
}

<?php

namespace App\Services;

class PayWayService
{
    /**
     * Generate HMAC hash for ABA PayWay
     */
    public function getHash($dataString)
    {
        $publicKey = env('PAYWAY_PUBLIC_KEY', 'b2e406b1c708e301da366179fdef5d587bd3371c'); // Sandbox key
        return base64_encode(hash_hmac('sha512', $dataString, $publicKey, true));
    }
}

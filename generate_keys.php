<?php
$privateKeyPath = __DIR__ . '/storage/keys/aba_sandbox_private_key.pem';
$publicKeyPath  = __DIR__ . '/storage/keys/aba_sandbox_public_key.pem';

// Generate new private key
$privateKey = openssl_pkey_new([
    "private_key_bits" => 2048,
    "private_key_type" => OPENSSL_KEYTYPE_RSA,
]);

if (!$privateKey) {
    die("❌ Failed to generate private key. Check OpenSSL is enabled in php.ini\n");
}

// Export private key
if (!openssl_pkey_export($privateKey, $privateKeyString)) {
    die("❌ Failed to export private key\n");
}
file_put_contents($privateKeyPath, $privateKeyString);

// Export public key
$details = openssl_pkey_get_details($privateKey);
if (!$details) {
    die("❌ Failed to get public key details\n");
}
file_put_contents($publicKeyPath, $details['key']);

echo "✅ Keys generated:\nPrivate: $privateKeyPath\nPublic: $publicKeyPath\n";

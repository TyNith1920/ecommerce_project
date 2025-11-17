<?php
require __DIR__ . '/PayWayApiCheckout.php';
header('Content-Type: application/json');

$input = json_decode(file_get_contents('php://input'), true) ?: [];
$amount = (float)($input['amount'] ?? 2.00);
$currency = $input['currency'] ?? 'USD';

try {
    $api = new PayWayApiCheckout();
    $res = $api->purchase($amount, $currency);
    echo json_encode(['ok' => true, 'data' => $res]);
} catch (Throwable $e) {
    echo json_encode(['ok' => false, 'error' => $e->getMessage()]);
}

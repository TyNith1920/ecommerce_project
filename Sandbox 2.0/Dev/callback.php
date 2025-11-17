<?php
$raw = file_get_contents('php://input');
file_put_contents(__DIR__.'/callback.log', date('c')."\n".$raw."\n\n", FILE_APPEND);
http_response_code(200);
echo json_encode(['received'=>true]);

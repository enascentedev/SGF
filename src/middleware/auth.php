<?php
function authenticate() {
    $headers = apache_request_headers();
    if (!isset($headers['Authorization'])) {
        http_response_code(401);
        echo json_encode(["message" => "Não autorizado"]);
        exit();
    }
    $token = $headers['Authorization'];
    return $token === "seu-token-seguro"; // Em produção, implemente JWT ou outra solução.
}

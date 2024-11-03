<?php
function authenticate() {
    $headers = apache_request_headers();
    
    // Verifica se o cabeçalho Authorization está presente
    if (!isset($headers['Authorization']) || empty($headers['Authorization'])) {
        http_response_code(401);
        echo json_encode(["message" => "Não autorizado"]);
        exit();
    }
    
    // Token existe; retorna sucesso
    return true;
}

<?php
include_once '../controllers/ContaController.php';
$controller = new ContaController('pagar'); // ou 'receber'
header("Content-Type: application/json; charset=UTF-8");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);
    $controller->create($data);
}

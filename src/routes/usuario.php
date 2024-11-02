<?php
include_once '../controllers/UsuarioController.php';
$controller = new UsuarioController();
header("Content-Type: application/json; charset=UTF-8");

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_GET['action'] === 'register') {
    $data = json_decode(file_get_contents("php://input"), true);
    $controller->register($data);
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST' && $_GET['action'] === 'login') {
    $data = json_decode(file_get_contents("php://input"), true);
    $controller->login($data);
}

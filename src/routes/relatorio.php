<?php
include_once '../controllers/RelatorioController.php';
$controller = new RelatorioController();
header("Content-Type: application/json; charset=UTF-8");

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $mes = $_GET['mes'];
    $ano = $_GET['ano'];
    $controller->despesasPorCategoria($mes, $ano);
}

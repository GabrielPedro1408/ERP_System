<?php
// Ativar exibição de erros
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Carregar configuração do banco
require_once __DIR__ . '/config/Database.php';

// Capturar a URL
$url = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// Remover o prefixo da pasta do projeto
$basePath = '/SistemaERP-NeoGestao';
$url = str_replace($basePath, '', $url);


// Definir rotas
switch ($url) {
    case '/login':
        require_once __DIR__ . '/app/Controllers/LoginController.php';
        $controller = new LoginController($pdo);
        $controller->autenticar();
        break;

    case '/dashboard':
        require_once __DIR__ . '/app/Controllers/DashboardController.php';
        $controller = new DashboardController($pdo);
        $controller->index($id_empresa);
        break;

    default:
        http_response_code(404);
        echo "Página não encontrada.";
        break;
}

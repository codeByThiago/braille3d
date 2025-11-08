<?php

include dirname(__FILE__, 2) . "/src/Core/Autoload.php";
include dirname(__FILE__, 2) . "/src/Core/Config.php";

use Controllers\UserController;
use Controllers\AuthController;
use Controllers\PlacaController;
use Core\Autoload;
Autoload::register();

if(session_status() === PHP_SESSION_NONE) {
    session_start();
}

$placaController = new PlacaController();
$userController = new UserController();
$authController = new AuthController;

$url = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH); // "/historico"

switch ($url) {
    case '/':
        if($_SERVER["REQUEST_METHOD"] === 'POST' && isset($_SESSION['logado'])) {
            $placaController->savePlaca();
        } else {
            $userController->index();

        }
        break;
    case '/login':
        if($_SERVER["REQUEST_METHOD"] === 'POST') {
           $authController->login(); 
        } else {
            $authController->showLoginForm();
        }
        break;
    case '/cadastro':
        if($_SERVER["REQUEST_METHOD"] === 'POST') {
           $authController->cadastro(); 
        } else {
            $authController->showCadastroForm();
        }
        break;
    case '/logout':
        $authController->logout();
        break;
    case '/perfil':
        if(isset($_SESSION['user_id'])) {

        if($_SERVER['REQUEST_METHOD'] === 'POST') {

            if(isset($_FILES['foto_perfil']) && $_FILES['foto_perfil']['error'] === 0) {
                $userController->atualizarFoto();
            } else {
                $userController->atualizarDadosPessoais();
            }

        } else {
            $userController->userProfile();
        }

    } else {
        header('Location: /login');
        exit;
    }
    break;
    case "/historico":
        $placaController->historico();
        break;
    default:
        echo "Página de Erro 404";
        break;
}

?>
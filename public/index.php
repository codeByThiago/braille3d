<?php

include dirname(__FILE__, 2) . "/src/Core/Autoload.php";
include dirname(__FILE__, 2) . "/src/Core/Config.php";
require_once __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

use Controllers\UserController;
use Controllers\AuthController;
use Controllers\EmailChangesController;
use Controllers\PasswordResetsController;
use Controllers\PlacaController;
use Core\Autoload;

Autoload::register();

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$placaController = new PlacaController();
$userController = new UserController();
$emailController = new EmailChangesController();
$passwordController = new PasswordResetsController();
$authController = new AuthController();

$placa = null;

$url = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);

switch ($url) {
    case '/':
        if ($_SERVER["REQUEST_METHOD"] === 'POST' && isset($_SESSION['logado'])) {
            $placaController->savePlaca();
        } else {
            $userController->index();
        }
        break;

    case '/atualizar':
        if(isset($_SESSION['user_id'])) {
            $placaController->atualizarPlaca();
        } else {
            header('Location: /');
        }
        break;

    case '/ajuda':
        $userController->ajuda();
        break;

    case '/login':
        if ($_SERVER["REQUEST_METHOD"] === 'POST') {
            $authController->login();
        } else {
            $authController->showLoginForm();
        }
        break;

    case '/cadastro':
        if ($_SERVER["REQUEST_METHOD"] === 'POST') {
            $authController->cadastro();
        } else {
            $authController->showCadastroForm();
        }
        break;

    case '/logout':
        $authController->logout();
        break;

    case '/user/google-login':
        $authController->googleLogin();
        break;

    case '/user/google-callback':
        $authController->googleCallback();
        break;
        
    case '/perfil':
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_FILES['foto_perfil']) && $_FILES['foto_perfil']['error'] === 0) {
                $userController->atualizarFoto();
            }
        } else {
            $userController->userProfile();
        }
        break;

    // ✅ FORMULÁRIO DE ALTERAÇÃO DE NOME
    case '/perfil/atualizar-nome':
        if (isset($_SESSION['user_id'])) {
            $userController->atualizaNome();
        } else {
            header('Location: /login');
        }
        break;

    // FORMULÁRIO DE ALTERAÇÃO DE EMAIL
    case '/perfil/atualizar-email':
        if (isset($_SESSION['user_id'])) {
            $emailController->solicitarTrocaEmail($_SESSION['user_id'], $_POST['email'], 'http://localhost:8000');
        } else {
            header('Location: /login');
        }
        break;

    // FORMULÁRIO DE TROCA DE SENHA (ENVIA EMAIL)
    case '/perfil/solicitar-troca-senha':
        if (isset($_SESSION['user_id'])) {
            $user = $userController->getUserById($_SESSION['user_id']); // precisa ter esse método
            $email = $user['email'];
            $passwordController->solicitarTrocaSenha($_SESSION['user_id'], $email, 'http://localhost:8000');
        } else {
            header('Location: /login');
        }
        break;

    // CONFIRMAR TROCA DE EMAIL
    case '/user/confirm-email-change':
        if (isset($_GET['token'])) {
            $resultado = $emailController->confirmarTrocaEmail($_GET['token']);

            $_SESSION[$resultado['success'] ? 'success_message' : 'error_message'] = $resultado['message'];
            header("Location: /perfil");
            exit;
        } else {
            $_SESSION['error_message'] = "Token inválido.";
            header("Location: /perfil");
            exit;
        }
        break;

    case '/user/reset-password':

        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            // Exibe o formulário de redefinição (usuário clicou no link)
            $passwordController->showResetForm();
        } elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Usuário enviou a nova senha
            $passwordController->handleReset();
        }
        break;
    
    case '/user/esqueci-a-senha':

        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $passwordController->showForgotForm();
            
        } elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Usuário enviou o email
            $passwordController->handleForgot();
        }
        break;

    case '/historico':
        $placaController->historico();
        break;

    default:
        $userController->notFound();
        break;
}

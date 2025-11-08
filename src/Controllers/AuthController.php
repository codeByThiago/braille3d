<?php 

namespace Controllers;

use Models\User;
use DAOs\UserDAO;

class AuthController {
    private UserDAO $userDAO;

    public function __construct() {
        $this->userDAO = new UserDAO();
    }

    public function showLoginForm() {
        if(!isset($_SESSION['user_id'])) {
            require_once (VIEWS . 'user/login.php');
        } else {
            $_SESSION['error_message'] = "Você já está logado!";
            header('Location: /');
        }
    }

    public function login() {
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $dataUser = [
                'name' => $_POST['nome'] ?? '',
                'password' => $_POST['senha'] ?? '',
                'email' => $_POST['email'] ?? '',
            ];

            $usuario = $this->userDAO->getByEmail($dataUser['email']);
            if(is_array($usuario)) {
                if($dataUser['email'] == $usuario['email'] && password_verify($dataUser['password'], $usuario['password'])) {
                    $_SESSION['logado'] = TRUE;
                    $_SESSION['user_id'] = $usuario['id'];
                    $_SESSION['username'] = $usuario['name'];
                    $_SESSION['sucess_message'] = 'Login realizado com sucesso!';
                    header('Location: /');
                } else {
                    $_SESSION['error_message'] = 'Email ou senha incorretos. Tente novamente!';
                    header('Location: /login');
                }
            } else {
                $_SESSION['error_message'] = 'Email ou senha incorretos. Tente novamente!';
                header('Location: /login');
            }
        }
    }

    public function showCadastroForm() {
        if(!isset($_SESSION['user_id'])) {
            require_once (VIEWS . 'user/cadastro.php');
        } else {
            $_SESSION['error_message'] = "Você já está logado! Por favor saia da conta caso queira cadastrar outro email.";
            header('Location: /');
        }
    }

    public function cadastro() {
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            
            $dataUser = [
                'name' => $_POST['nome'] ?? '',
                'password' => $_POST['senha'] ?? '',
                'email' => $_POST['email'] ?? '',
            ];

            $user = new User($dataUser);
            $newId = $this->userDAO->create($user->toArray());

            $user->setId($newId);

            $_SESSION['sucess_message'] = 'Seja bem vindo,' . $dataUser['name'] . 'Você se cadastrou com sucesso!';
            header('Location: /login');
        }
    }

    public function logout() : void {
        if(session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        $_SESSION = [];

        session_unset();
        session_destroy();

        header('Location: /');
    }
}

?>
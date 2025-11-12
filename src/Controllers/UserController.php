<?php 

namespace Controllers;

use Models\User;
use DAOs\UserDAO;
use Models\Placa;
use DAOs\PlacaDAO;
use Services\MailerService;

class UserController {
    public UserDAO $userDAO;
    public PlacaDAO $placaDAO;
    public MailerService $mailerService;
    
    public function __construct() {
        $this->userDAO = new UserDAO();
        $this->placaDAO = new PlacaDAO();
        $this->mailerService = new MailerService();
    }

    public function index() : void {
        if (isset($_SESSION['placa_id'])) {
            $placa = $this->placaDAO->selectById($_SESSION['placaID']);
            require_once VIEWS . "user\home.php";
        } else {
            require_once VIEWS . "user\home.php";
        }
    }
    
    public function getUserById(int $userId): ?array {
    try {
        $userDAO = new \DAOs\UserDAO();
        $usuario = $userDAO->selectById($userId);
        return $usuario ?: null;
    } catch (\Exception $e) {
        error_log("Erro ao buscar usuário por ID: " . $e->getMessage());
        return null;
    }
}

    public function userProfile() : void {
        if (!isset($_SESSION['user_id'])) {
            header("Location: /login");
            exit;
        }

        $user_id = $_SESSION['user_id'];
        $usuario = $this->userDAO->selectById($user_id);
        require_once VIEWS . 'user\perfil.php';
    }

    public function atualizarFoto() {
        if (!isset($_SESSION['user_id'])) {
            echo json_encode(['success' => false, 'message' => 'Usuário não logado']);
            exit;
        }

        $userId = $_SESSION['user_id'];

        if (isset($_FILES['foto_perfil'])) {
            if ($_FILES['foto_perfil']['error'] !== UPLOAD_ERR_OK) {
                echo json_encode(['success' => false, 'message' => 'Erro no upload!']);
                exit;
            }

            $ext = pathinfo($_FILES['foto_perfil']['name'], PATHINFO_EXTENSION);
            $allowed = ['jpg','jpeg','png','gif'];

            if (!in_array(strtolower($ext), $allowed)) {
                echo json_encode(['success' => false, 'message' => 'Formato inválido!']);
                exit;
            }

            $novoNome = 'perfil_' . $userId . '.' . $ext;
            $caminhoDestino = dirname(__FILE__, 3) . '/public/assets/img/uploads/' . $novoNome;

            if (move_uploaded_file($_FILES['foto_perfil']['tmp_name'], $caminhoDestino)) {
                $this->userDAO->atualizarFoto($userId, $novoNome);
                echo json_encode([
                    'success' => true,
                    // 'message' => 'Foto atualizada com sucesso!',
                    'filePath' => '/assets/img/uploads/' . $novoNome
                ]);
            } else {
                // echo json_encode(['success' => false, 'message' => 'Erro ao enviar arquivo!']);
            }
        } else {
            // echo json_encode(['success' => false, 'message' => 'Nenhum arquivo enviado!']);
        }
        exit;
    }

    public function atualizaNome() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['user_id'])) {
            $novoNome = trim($_POST['nome'] ?? '');

            if (empty($novoNome)) {
                $_SESSION['error_message'] = "O nome não pode estar vazio.";
                header("Location: /perfil");
                exit;
            }

            $usuarioId = $_SESSION['user_id'];

            if ($this->userDAO->atualizarNome($usuarioId, $novoNome)) {
                $_SESSION['sucess_message'] = "Nome atualizado com sucesso!";
                $_SESSION['username'] = $novoNome;
            } else {
                $_SESSION['error_message'] = "Erro ao atualizar o nome. Tente novamente.";
            }

            header("Location: /perfil");
            exit;
        }
    }

    public function atualizaEmail() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['user_id'])) {
            $novoEmail = trim($_POST['email'] ?? '');

            if (empty($novoEmail)) {
                $_SESSION['error_message'] = "O e-mail não pode estar vazio.";
                header("Location: /perfil");
                exit;
            }

            if (!filter_var($novoEmail, FILTER_VALIDATE_EMAIL)) {
                $_SESSION['error_message'] = "Formato de e-mail inválido.";
                header("Location: /perfil");
                exit;
            }

            $usuarioId = $_SESSION['user_id'];
            $usuarioExistente = $this->userDAO->getByEmail($novoEmail);

            if ($usuarioExistente && $usuarioExistente['id'] != $usuarioId) {
                $_SESSION['error_message'] = "Este e-mail já está em uso.";
                header("Location: /perfil");
                exit;
            }

            if ($this->userDAO->atualizarEmail($usuarioId, $novoEmail)) {
                $_SESSION['sucess_message'] = "E-mail atualizado com sucesso!";
                $_SESSION['email'] = $novoEmail;
            } else {
                $_SESSION['error_message'] = "Erro ao atualizar o e-mail. Tente novamente.";
            }

            header("Location: /perfil");
            exit;
        }
    }

    public function atualizaSenha() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['user_id'])) {
            $senhaAtual = $_POST['senha_atual'] ?? '';
            $novaSenha = $_POST['nova_senha'] ?? '';
            $confirmarSenha = $_POST['confirmar_senha'] ?? '';

            if (empty($senhaAtual) || empty($novaSenha) || empty($confirmarSenha)) {
                $_SESSION['error_message'] = "Preencha todos os campos.";
                header("Location: /perfil");
                exit;
            }

            if ($novaSenha !== $confirmarSenha) {
                $_SESSION['error_message'] = "As senhas novas não coincidem.";
                header("Location: /perfil");
                exit;
            }

            $usuarioId = $_SESSION['user_id'];
            $usuario = $this->userDAO->selectById($usuarioId);

            if (!$usuario || !password_verify($senhaAtual, $usuario['password'])) {
                $_SESSION['error_message'] = "Senha atual incorreta.";
                header("Location: /perfil");
                exit;
            }

            $hash = password_hash($novaSenha, PASSWORD_DEFAULT);

            if ($this->userDAO->atualizarSenha($usuarioId, $hash)) {
                $_SESSION['sucess_message'] = "Senha atualizada com sucesso!";
            } else {
                $_SESSION['error_message'] = "Erro ao atualizar a senha. Tente novamente.";
            }

            header("Location: /perfil");
            exit;
        }
    }
}

?>
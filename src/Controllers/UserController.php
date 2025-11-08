<?php 

namespace Controllers;

use Models\User;
use DAOs\UserDAO;
use Models\Placa;
use DAOs\PlacaDAO;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class UserController {
    public UserDAO $userDAO;
    public PlacaDAO $placaDAO;
    
    public function __construct() {
        $this->userDAO = new UserDAO();
        $this->placaDAO = new PlacaDAO();
    }

    public function index() : void {
        if (isset($_SESSION['placa_id'])) {
            $placa = $this->placaDAO->selectById($_SESSION['placaID']);
            require_once VIEWS . "user\home.php";
        } else {
            require_once VIEWS . "user\home.php";
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

    public function atualizarDadosPessoais () {
        if (!isset($_SESSION['user_id'])) {
            echo json_encode(['success' => false, 'message' => 'Usuário não logado']);
            header('Location: /login');
            exit;
        }

        $user_id = $_SESSION['user_id'];
        $usuario = $this->userDAO->selectById($user_id);

        $data = [
            'name' => $_POST['nome'],
            'email' => $_POST['email']
        ];

        if(!empty($_POST['senha'])) {
            $data = [
            'password' => password_hash($_POST['senha'], PASSWORD_BCRYPT)
            ];
        }

        $this->userDAO->update($user_id, $data);

        header('Location: /perfil');

    }
}

?>
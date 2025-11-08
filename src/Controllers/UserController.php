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
        
        $mail = new PHPMailer(true);

        try {
            // 1. Configurações do Servidor SMTP (Gmail)
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            
            // **USO SEGURO DE CREDENCIAIS AQUI**
            $mail->Username = $_ENV['GMAIL_USER'];
            $mail->Password = $_ENV['GMAIL_PASS'];
            
            // Configurações de segurança e porta
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->Port  = 465;

            // 2. Remetente e Destinatário
            $mail->setFrom($_ENV['GMAIL_USER'], 'Braille3D Suporte');
            $mail->addAddress($_POST['email']);

            // 3. Conteúdo do E-mail
            $mail->isHTML(true);
            $mail->Subject = 'Sua Mensagem Importante';
            $mail->Body    = 'Este é o corpo da mensagem em **HTML**.';
            $mail->AltBody = 'Este é o corpo da mensagem em texto puro (para clientes que não suportam HTML).';

            $mail->send();
            echo 'Mensagem enviada com sucesso!';
            
        } catch (Exception $e) {
            echo "A mensagem não pôde ser enviada. Erro do PHPMailer: {$mail->ErrorInfo}";
        }
    }
}

?>
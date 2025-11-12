<?php

namespace Controllers;

use DAOs\PasswordResetsDAO;
use DAOs\UserDAO;
use Services\MailerService;
use Exception;

class PasswordResetsController {
    public MailerService $mailerService;
    public PasswordResetsDAO $passwordResetsDAO;
    public UserDAO $userDAO;

    public function __construct() {
        $this->mailerService = new MailerService();
        $this->passwordResetsDAO = new PasswordResetsDAO();
        $this->userDAO = new UserDAO();
    }

    public function solicitarTrocaSenha(int $userId, string $email, string $baseUrl): void {
        try {
            $tokenPuro = bin2hex(random_bytes(32));
            $tokenHash = hash('sha256', $tokenPuro);
            $expiresAt = date('Y-m-d H:i:s', time() + 3600); // 1 hora

            $this->passwordResetsDAO->criarToken($userId, $email, $tokenHash, $expiresAt);

            $enviado = $this->enviaEmailDeRedefinicao($email, $tokenPuro, $baseUrl);

            if ($enviado) {
                $_SESSION['success_message'] = "Enviamos um e-mail para <strong>{$email}</strong> com o link para redefinir sua senha. Verifique sua caixa de entrada (e também a pasta de spam).";
            } else {
                $_SESSION['error_message'] = "Ocorreu um erro ao enviar o e-mail de redefinição. Tente novamente em alguns minutos.";
            }

        } catch (Exception $e) {
            error_log("Erro ao solicitar troca de senha: " . $e->getMessage());
            $_SESSION['error_message'] = "Não foi possível processar sua solicitação no momento. Por favor, tente novamente mais tarde.";
        }

        header("Location: /perfil");
        exit;
    }

    public function enviaEmailDeRedefinicao(string $email, string $tokenPuro, string $baseUrl): bool {
        $link = "{$baseUrl}/user/reset-password?token={$tokenPuro}";
        $assunto = '🔒 Redefinição de Senha - Braille3D';

        $bodyHTML = '
            <div style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;">
                <h2 style="color: #007bff;">Redefinição de Senha</h2>
                <p>Olá,</p>
                <p>Recebemos uma solicitação para redefinir sua senha da conta <strong>Braille3D</strong>.</p>
                <p>Para continuar, clique no botão abaixo:</p>
                
                <table role="presentation" cellspacing="0" cellpadding="0" border="0" align="center" style="margin: 20px 0;">
                    <tr>
                        <td style="border-radius: 5px; background-color: #007bff; text-align: center;">
                            <a href="' . $link . '" target="_blank" style="display: inline-block; padding: 10px 20px; font-size: 16px; color: #ffffff; text-decoration: none; border-radius: 5px; font-weight: bold;">
                                Redefinir Senha
                            </a>
                        </td>
                    </tr>
                </table>

                <p style="font-size: 14px; color: #777;">
                    Este link expira em <strong>1 hora</strong>.<br>
                    Se você não solicitou essa alteração, ignore este e-mail — sua senha permanecerá a mesma.
                </p>

                <p>Atenciosamente,<br>Equipe Braille3D</p>
            </div>
        ';

        try {
            $altBody = "Acesse o link para redefinir sua senha: {$link}";
            $this->mailerService->sendMessage($email, $assunto, $bodyHTML, $altBody);
            return true;
        } catch (Exception $e) {
            error_log('Erro ao enviar e-mail de redefinição: ' . $e->getMessage());
            return false;
        }
    }

    public function confirmarTrocaSenha(string $tokenPuro, string $novaSenha): array {
        try {
            $tokenHash = hash('sha256', $tokenPuro);
            $registro = $this->passwordResetsDAO->buscarPorToken($tokenHash);

            if (!$registro) {
                return ['success' => false, 'message' => 'O link de redefinição é inválido ou já expirou.'];
            }

            $senhaHash = password_hash($novaSenha, PASSWORD_DEFAULT);
            $sql = "UPDATE users SET password = :senha WHERE id = :id";
            $stmt = $this->passwordResetsDAO->conexao->prepare($sql);
            $stmt->execute([
                ':senha' => $senhaHash,
                ':id'    => $registro['user_id']
            ]);

            $this->passwordResetsDAO->deletarPorId($registro['id']);
            return ['success' => true, 'message' => 'Sua senha foi redefinida com sucesso! Você já pode fazer login com a nova senha.'];

        } catch (Exception $e) {
            error_log("Erro ao redefinir senha: " . $e->getMessage());
            return ['success' => false, 'message' => 'Ocorreu um erro interno ao redefinir sua senha. Tente novamente mais tarde.'];
        }
    }

    public function showForgotForm(): void {
        require_once(VIEWS . 'user/forgot_password.php');
    }

    public function handleForgot(): void {
        $email = trim($_POST['email'] ?? '');
        if (empty($email)) {
            $_SESSION['error_message'] = 'Por favor, informe um e-mail válido.';
            header('Location: /user/esqueci-a-senha');
            exit;
        }

        $user = $this->userDAO->getByEmail($email);

        if (!$user) {
            $_SESSION['error_message'] = 'Nenhuma conta foi encontrada com esse e-mail.';
            header('Location: /user/esqueci-a-senha');
            exit;
        }

        $baseUrl = "http://" . $_SERVER['HTTP_HOST'];
        $this->solicitarTrocaSenha($user['id'], $email, $baseUrl);
    }

    public function showResetForm(): void {
        $tokenPuro = $_GET['token'] ?? '';

        if (empty($tokenPuro)) {
            $_SESSION['error_message'] = 'O link de redefinição é inválido.';
            header('Location: /perfil');
            exit;
        }

        $tokenHash = hash('sha256', $tokenPuro);
        $registro = $this->passwordResetsDAO->buscarPorToken($tokenHash);

        if (!$registro) {
            $_SESSION['error_message'] = 'Este link é inválido ou já foi utilizado.';
            header('Location: /perfil');
            exit;
        }

        $agora = date('Y-m-d H:i:s');
        if ($registro['expires_at'] < $agora) {
            $_SESSION['error_message'] = 'O link de redefinição expirou. Solicite um novo link.';
            $this->passwordResetsDAO->deletarPorId($registro['id']);
            header('Location: /perfil');
            exit;
        }

        require_once(VIEWS . 'user/reset_password.php');
    }

    public function handleReset(): void {
        $token = $_POST['token'] ?? '';
        $novaSenha = $_POST['senha'] ?? '';
        $confirmarSenha = $_POST['confirme-senha'] ?? '';

        if (empty($novaSenha) || $novaSenha !== $confirmarSenha) {
            $_SESSION['error_message'] = 'As senhas informadas não coincidem.';
            header("Location: /user/reset-password?token={$token}");
            exit;
        }

        $resultado = $this->confirmarTrocaSenha($token, $novaSenha);

        if ($resultado['success']) {
            $_SESSION['success_message'] = $resultado['message'];
            header('Location: /perfil');
        } else {
            $_SESSION['error_message'] = $resultado['message'];
            header("Location: /user/reset-password?token={$token}");
        }

        exit;
    }
}

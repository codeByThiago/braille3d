<?php

namespace Controllers;

use DAOs\PasswordResetsDAO;
use Services\MailerService;
use Exception;

class PasswordResetsController {
    public MailerService $mailerService;
    public PasswordResetsDAO $passwordResetsDAO;

    public function __construct() {
        $this->mailerService = new MailerService();
        $this->passwordResetsDAO = new PasswordResetsDAO();
    }

    public function solicitarTrocaSenha(int $userId, string $email, string $baseUrl): void {
        try {
            $tokenPuro = bin2hex(random_bytes(32));
            $tokenHash = hash('sha256', $tokenPuro);
            $expiresAt = date('Y-m-d H:i:s', time() + 3600); // 1h

            $this->passwordResetsDAO->criarToken($userId, $email, $tokenHash, $expiresAt);

            $enviado = $this->enviaEmailDeRedefinicao($email, $tokenPuro, $baseUrl);

            if ($enviado) {
                $_SESSION['success_message'] = "Um link de redefinição foi enviado para {$email}.";
            } else {
                $_SESSION['error_message'] = "Erro ao enviar e-mail de redefinição.";
            }

        } catch (Exception $e) {
            error_log("Erro ao solicitar troca de senha: " . $e->getMessage());
            $_SESSION['error_message'] = "Erro interno ao solicitar redefinição.";
        }

        header("Location: /perfil");
        exit;
    }

    public function enviaEmailDeRedefinicao(string $email, string $tokenPuro, string $baseUrl): bool {
        $link = "{$baseUrl}/user/reset-password?token={$tokenPuro}";
        $assunto = 'Redefinição de Senha (Braille3D)';

        $bodyHTML = "
            <h2>Redefinição de Senha</h2>
            <p>Olá,</p>
            <p>Clique no botão abaixo para redefinir sua senha:</p>
            <a href='{$link}' style='background:#007bff;color:white;padding:10px 20px;border-radius:5px;text-decoration:none;'>Redefinir Senha</a>
            <p style='color:#777;font-size:0.9rem;'>O link expira em 1 hora.</p>
        ";

        try {
            $altBody = "Clique no link para redefinir sua senha: {$link}";
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
                return ['success' => false, 'message' => 'Token inválido ou expirado.'];
            }

            $senhaHash = password_hash($novaSenha, PASSWORD_DEFAULT);
            $sql = "UPDATE users SET password = :senha WHERE id = :id";
            $stmt = $this->passwordResetsDAO->conexao->prepare($sql);
            $stmt->execute([
                ':senha' => $senhaHash,
                ':id'    => $registro['user_id']
            ]);

            $this->passwordResetsDAO->deletarPorId($registro['id']);
            return ['success' => true, 'message' => 'Senha redefinida com sucesso!'];

        } catch (Exception $e) {
            error_log("Erro ao redefinir senha: " . $e->getMessage());
            return ['success' => false, 'message' => 'Erro interno ao redefinir senha.'];
        }
    }

    public function showResetForm(): void {
        $tokenPuro = $_GET['token'] ?? '';

        if (empty($tokenPuro)) {
            $_SESSION['error_message'] = 'Token de redefinição ausente ou inválido.';
            header('Location: /perfil');
            exit;
        }

        // Gera o hash para comparar com o banco (porque o token salvo é o hash)
        $tokenHash = hash('sha256', $tokenPuro);

        // Busca o registro no banco
        $registro = $this->passwordResetsDAO->buscarPorToken($tokenHash);

        if (!$registro) {
            $_SESSION['error_message'] = 'Token inválido ou não encontrado.';
            header('Location: /perfil');
            exit;
        }

        // Verifica se o token expirou
        $agora = date('Y-m-d H:i:s');
        if ($registro['expires_at'] < $agora) {
            $_SESSION['error_message'] = 'O link de redefinição expirou. Solicite um novo.';
            $this->passwordResetsDAO->deletarPorId($registro['id']);
            header('Location: /perfil');
            exit;
        }

        // Token é válido → mostra o formulário
        require_once(VIEWS . 'user/reset_password.php');
    }

    public function handleReset(): void {
        $token = $_POST['token'] ?? '';
        $novaSenha = $_POST['nova_senha'] ?? '';
        $confirmarSenha = $_POST['confirmar_senha'] ?? '';

        if (empty($novaSenha) || $novaSenha !== $confirmarSenha) {
            $_SESSION['error_message'] = 'As senhas não coincidem.';
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

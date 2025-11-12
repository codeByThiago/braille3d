<?php 

namespace Controllers;

use DAOs\EmailChangesDAO;
use Services\MailerService;
use Exception; // Não esqueça de incluir para usar no catch

class EmailChangesController {
    public MailerService $mailerService;
    public EmailChangesDAO $emailChangesDAO; 

    public function __construct() {
        $this->mailerService = new MailerService();
        $this->emailChangesDAO = new EmailChangesDAO();
    }

    public function solicitarTrocaEmail(int $userId, string $novoEmail, string $baseUrl): void {
        try {
            $tokenPuro = bin2hex(random_bytes(32));
            $tokenHash = hash('sha256', $tokenPuro);
            $expiresAt = date('Y-m-d H:i:s', time() + 3600); // 1h

            $this->emailChangesDAO->criarToken($userId, $novoEmail, $tokenHash, $expiresAt);

            $resultado = $this->enviaEmailComToken($novoEmail, $tokenPuro, $baseUrl);

            if ($resultado) {
                $_SESSION['success_message'] = "Um e-mail de confirmação foi enviado para {$novoEmail}.";
            } else {
                $_SESSION['error_message'] = "Erro ao enviar e-mail de confirmação.";
            }

        } catch (Exception $e) {
            error_log("Erro ao solicitar troca de e-mail: " . $e->getMessage());
            $_SESSION['error_message'] = "Erro interno ao solicitar troca de e-mail.";
        }

        // Redireciona de volta para o perfil (evita reenvio ao atualizar a página)
        header("Location: /perfil");
        exit;
    }


    public function enviaEmailComToken(string $novoEmail, string $tokenPuro, string $baseUrl): bool {
        $confirmationLink = "{$baseUrl}/user/confirm-email-change?token={$tokenPuro}";
        $assunto = '📧 Confirme seu novo endereço de e-mail - Braille3D';

        $bodyHTML = '
            <div style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;">
                <h2 style="color: #007bff;">Confirmação de Alteração de E-mail</h2>

                <p>Olá,</p>
                <p>Recebemos uma solicitação para alterar o e-mail associado à sua conta <strong>Braille3D</strong> para: <strong>' . htmlspecialchars($novoEmail) . '</strong>.</p>

                <p>Para confirmar essa alteração, clique no botão abaixo:</p>
                
                <table role="presentation" cellspacing="0" cellpadding="0" border="0" align="center" style="margin: 20px 0;">
                    <tr>
                        <td style="border-radius: 5px; background-color: #28a745; text-align: center;">
                            <a href="' . $confirmationLink . '" target="_blank" style="display: inline-block; padding: 10px 20px; font-size: 16px; color: #ffffff; text-decoration: none; border-radius: 5px; font-weight: bold;">
                                Confirmar Novo E-mail
                            </a>
                        </td>
                    </tr>
                </table>

                <p style="font-size: 14px; color: #777;">
                    Este link expira em <strong>1 hora</strong>.<br>
                    Se você não solicitou essa alteração, ignore este e-mail — nenhuma mudança será feita.
                </p>

                <p>Atenciosamente,<br>Equipe Braille3D</p>
            </div>
        ';

        $altBody = "Confirme a alteração do e-mail acessando: {$confirmationLink}";

        try {
            $this->mailerService->sendMessage($novoEmail, $assunto, $bodyHTML, $altBody);
            return true;
        } catch (Exception $e) {
            error_log('Erro ao enviar e-mail: ' . $e->getMessage());
            return false;
        }
}


    public function confirmarTrocaEmail(string $tokenPuro): array {
        try {
            $tokenHash = hash('sha256', $tokenPuro);
            $registro = $this->emailChangesDAO->buscarPorToken($tokenHash);

            if (!$registro) {
                return ['success' => false, 'message' => 'Token inválido ou expirado.'];
            }

            // Atualiza e-mail do usuário
            $sql = "UPDATE users SET email = :email WHERE id = :id";
            $stmt = $this->emailChangesDAO->conexao->prepare($sql);
            $stmt->execute([
                ':email' => $registro['new_email'],
                ':id'    => $registro['user_id']
            ]);

            // Deleta o token
            $this->emailChangesDAO->deletarPorId($registro['id']);

            return ['success' => true, 'message' => 'E-mail alterado com sucesso!'];
        } catch (Exception $e) {
            error_log("Erro ao confirmar troca de e-mail: " . $e->getMessage());
            return ['success' => false, 'message' => 'Erro interno ao confirmar e-mail.'];
        }
    }

    
}
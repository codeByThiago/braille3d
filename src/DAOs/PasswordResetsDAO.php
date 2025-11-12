<?php

namespace DAOs;

use DAOs\BaseDAO;
use PDO;

class PasswordResetsDAO extends BaseDAO {
    public function __construct() {
        parent::__construct('password_resets');
    }

    public function criarToken(int $userId, string $email, string $tokenHash, string $expiresAt): void {
        $sql = "INSERT INTO password_resets (user_id, email, token_hash, expires_at) 
                VALUES (:user_id, :email, :token_hash, :expires_at)";
        $stmt = $this->conexao->prepare($sql);
        $stmt->execute([
            ':user_id' => $userId,
            ':email' => $email,
            ':token_hash' => $tokenHash,
            ':expires_at' => $expiresAt
        ]);
    }

    public function buscarPorToken(string $tokenHash): ?array {
        $sql = "SELECT * FROM password_resets WHERE token_hash = :token_hash AND expires_at > NOW() LIMIT 1";
        $stmt = $this->conexao->prepare($sql);
        $stmt->execute([':token_hash' => $tokenHash]);
        $dados = $stmt->fetch(PDO::FETCH_ASSOC);
        return $dados ?: null;
    }

    public function deletarPorId(int $id): void {
        $sql = "DELETE FROM password_resets WHERE id = :id";
        $stmt = $this->conexao->prepare($sql);
        $stmt->execute([':id' => $id]);
    }
}

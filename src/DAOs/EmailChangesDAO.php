<?php

namespace DAOs;

use PDO;
use Exception;

class EmailChangesDAO extends BaseDAO {

    public function __construct() {
        parent::__construct('email_changes');
    }

    public function criarToken(int $userId, string $novoEmail, string $tokenHash, string $expiresAt): int {
        $data = [
            'user_id'    => $userId,
            'new_email'  => $novoEmail,
            'token_hash' => $tokenHash,
            'expires_at' => $expiresAt
        ];
        return $this->create($data);
    }

    public function buscarPorToken(string $tokenHash): ?array {
        try {
            $sql = "SELECT * FROM {$this->table} 
                    WHERE token_hash = :token_hash 
                    AND expires_at > NOW()
                    LIMIT 1";
            $stmt = $this->conexao->prepare($sql);
            $stmt->bindValue(':token_hash', $tokenHash);
            $stmt->execute();

            $data = $stmt->fetch(PDO::FETCH_ASSOC);
            return $data ?: null;
        } catch (Exception $e) {
            throw new Exception("Erro ao buscar token em {$this->table}: " . $e->getMessage());
        }
    }

    public function deletarPorId(int $id): bool {
        return $this->delete($id);
    }
}

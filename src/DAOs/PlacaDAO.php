<?php 

namespace DAOs;

use DAOs\BaseDAO;
use PDO;
use PDOException;
use Exception;

class PlacaDAO extends BaseDAO {
    public function __construct() {
        parent::__construct('placa');
    }

    public function create(array $data) : int {
        try {
            $sql = "INSERT INTO placa (user_id, texto, uppercase, contracoes, conversao_direta, tam_forma, altura_ponto, diametro_ponto, espessura, margem, canto_referencia, suporte) VALUES(:user_id, :texto, :uppercase, :contracoes, :conversao_direta, :tam_forma, :altura_ponto, :diametro_ponto, :espessura, :margem, :canto_referencia, :suporte)";

            $stmt = $this->conexao->prepare($sql);
            
            $stmt->bindParam(":user_id", $data['user_id']);
            $stmt->bindParam(":texto", $data['texto']);
            $stmt->bindParam(":uppercase", $_POST['uppercase']);
            $stmt->bindParam(":contracoes", $_POST['contracoes']);
            $stmt->bindParam(":conversao_direta", $_POST['conversao_direta']);
            $stmt->bindParam(":tam_forma", $data['tam_forma']);
            $stmt->bindParam(":altura_ponto", $data['altura_ponto']);
            $stmt->bindParam(":diametro_ponto", $data['diametro_ponto']);
            $stmt->bindParam(":espessura", $data['espessura']);
            $stmt->bindParam(":margem", $data['margem']);
            $stmt->bindParam(":canto_referencia", $_POST['canto_referencia']);
            $stmt->bindParam(":suporte", $_POST['suporte']);

            $stmt->execute();

            return $newID = $this->conexao->lastInsertId();

        } catch (PDOException $e) {
            throw new Exception("Erro ao inserir placa: " . $e->getMessage());
        }
    }

    public function update(int $id, array $data): bool {
        try {
            $sql = "UPDATE placa SET 
                        texto = :texto,
                        uppercase = :uppercase,
                        contracoes = :contracoes,
                        conversao_direta = :conversao_direta,
                        tam_forma = :tam_forma,
                        altura_ponto = :altura_ponto,
                        diametro_ponto = :diametro_ponto,
                        espessura = :espessura,
                        margem = :margem,
                        canto_referencia = :canto_referencia,
                        suporte = :suporte
                    WHERE id = :id";

            $stmt = $this->conexao->prepare($sql);

            $stmt->bindParam(":texto", $data['texto']);
            $stmt->bindParam(":uppercase", $_POST['uppercase']);
            $stmt->bindParam(":contracoes", $_POST['contracoes']);
            $stmt->bindParam(":conversao_direta", $_POST['conversao_direta']);
            $stmt->bindParam(":tam_forma", $data['tam_forma']);
            $stmt->bindParam(":altura_ponto", $data['altura_ponto']);
            $stmt->bindParam(":diametro_ponto", $data['diametro_ponto']);
            $stmt->bindParam(":espessura", $data['espessura']);
            $stmt->bindParam(":margem", $data['margem']);
            $stmt->bindParam(":canto_referencia", $_POST['canto_referencia']);
            $stmt->bindParam(":suporte", $_POST['suporte']);

            $stmt->bindParam(":id", $id);

            return $stmt->execute();

        } catch (PDOException $e) {
            throw new Exception("Erro ao atualizar placa: " . $e->getMessage());
        }
    }

    public function selectByIdAndUserId(int $id, int $user_id) {
        try {
            $sql = "SELECT * FROM placa WHERE id = :id AND user_id = :user_id";
            $stmt = $this->conexao->prepare($sql);

            $stmt->bindParam(':id', $id);
            $stmt->bindParam(':user_id', $user_id);

            $stmt->execute();

            $placa = $stmt->fetch(PDO::FETCH_ASSOC);

            return $placa;

        } catch (PDOException $e) {
            throw new Exception("Erro ao selecionar placa: " . $e->getMessage());
        }
    }

    public function listAllById(int $user_id) : array {
        try {
        
            $sql = "SELECT * FROM placa WHERE user_id = :user_id";
            $stmt = $this->conexao->prepare($sql);
            $stmt->bindParam(':user_id', $user_id);
            
            $stmt->execute();
            $placas = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $placas ?? [];

        } catch (PDOException $e) {
            throw new Exception("Erro ao listar placas: " . $e->getMessage());
        }     
    }
}

?>
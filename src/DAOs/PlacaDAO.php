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
            
            echo $data['user_id'];
            echo $data['texto'];
            echo $data['uppercase'];
            echo $data['contracoes'];
            echo $data['tam_forma'];
            echo $data['altura_ponto'];
            echo $data['diametro_ponto'];
            echo $data['espessura'];
            echo $data['margem'];
            echo $data['canto_referencia'];
            echo $data['suporte'];

            throw new Exception("Erro ao inserir placa: " . $e->getMessage());
        }
    }

    public function listAllById() : array {
        try {
            $user_id = $_SESSION['user_id'];
        
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
<?php 

namespace Controllers;

use Models\Placa;
use DAOs\PlacaDAO;
use Exception;

class PlacaController {
    private PlacaDAO $placaDAO;

    public function __construct() {
        $this->placaDAO = new PlacaDAO();
    }

    public function getPlacaByID(int $id, int $user_id) {
        if (!isset($_SESSION['logado']) || $_SESSION['logado'] !== TRUE) {
            header('Location: /');
        }

        if (!isset($_SESSION['user_id']) || $_SESSION['user_id'] != $user_id) {
            header('Location: /');
        }

        try {
            $placa = $this->placaDAO->selectByIdAndUserId($id, $user_id);

            if ($placa) {
                return $placa;
            }

            return null;

        } catch (Exception $e) {
            $_SESSION['error_message'] = 'Erro ao selecionar placa';
            header('Location: /');
        }
    }

    public function savePlaca() {
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            if(true) {
                try {

                    $dataPlaca = [
                        'user_id' => $_SESSION['user_id'],
                        'texto' => $_POST['texto'],
                        // 'uppercase' => $_POST['uppercase'],
                        // 'contracoes' => $_POST['contracoes'],
                        // 'conversao_direta' => $_POST['conversao_direta'],
                        'tam_forma' => $_POST['tam_forma'],
                        'altura_ponto' => $_POST['altura_ponto'],
                        'diametro_ponto' => $_POST['diametro_ponto'],
                        'espessura' => $_POST['espessura'],
                        'margem' => $_POST['margem'],
                        // 'canto_referencia' => $_POST['canto_referencia'],
                        // 'suporte' => $_POST['suporte']
                    ];
    
                
                    $placa = new Placa($dataPlaca);

                    $newId = $this->placaDAO->create($placa->toArray());

                    $_SESSION['sucess_message'] = "Placa salva com sucesso!";

                    header('Location: /');
                } catch (Exception $e) {
                    $_SESSION['error_message'] = "Erro ao salvar placa, tente novamente mais tarde!";
                    header('Location: /');
                }  
            }
        }
    }

    public function atualizarPlaca() {
        try {
            if(isset($_POST['id'])) {
                $placa = $this->getPlacaByID($_POST['id'], $_SESSION['user_id']);
            
                if($placa) {
                    $dataPlaca = [
                        'texto' => $_POST['texto'],
                        // 'uppercase' => $_POST['uppercase'],
                        // 'contracoes' => $_POST['contracoes'],
                        // 'conversao_direta' => $_POST['conversao_direta'],
                        'tam_forma' => $_POST['tam_forma'],
                        'altura_ponto' => $_POST['altura_ponto'],
                        'diametro_ponto' => $_POST['diametro_ponto'],
                        'espessura' => $_POST['espessura'],
                        'margem' => $_POST['margem'],
                        // 'canto_referencia' => $_POST['canto_referencia'],
                        // 'suporte' => $_POST['suporte']
                    ];

                    $this->placaDAO->update($_POST['id'], $dataPlaca);
                    $_SESSION['sucess_message'] = "Placa atualizada com sucesso!";
                    header('Location: /');
                } else {
                    $_SESSION['error_message'] = 'Erro ao atualizar placa!';
                    
                    header('Location: /');
                }
            } else {
                $_SESSION['error_message'] = 'Erro ao atualizar placa!';
                header('Location: /'); 
            }
        } catch (Exception $e) {
            $_SESSION['error_message'] = "Erro ao atualizar placa!";
            header('Location: /');
        }
    }

    public function historico() : void {
        if(isset($_SESSION['logado']) && $_SESSION['logado'] == TRUE) {
            $user_id = $_SESSION['user_id'];
            $placas = $this->placaDAO->listAllById($user_id);
            require_once VIEWS . "placas/historico.php";
        } else {
            header('Location: /');
        }
    }
}

?>
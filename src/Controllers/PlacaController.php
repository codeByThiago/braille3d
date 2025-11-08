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

    public function savePlaca() {
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            if(true) {
                try {

                    $dataPlaca = [
                        'id' => 1,
                        'user_id' => $_SESSION['user_id'] ?? 2,
                        'texto' => $_POST['texto'],
                        // 'uppercase' => $_POST['uppercase'],
                        // 'contracoes' => $_POST['contracoes'],
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

                    $_SESSION['sucess_message'] = "Placa salva com sucesso! <a href='/placa/$newId'>Clique aqui</a> para ver.";

                    header('Location: /');
                } catch (Exception $e) {
                    $_SESSION['error_message'] = "Erro ao salvar placa, tente novamente mais tarde!";
                    throw new Exception("Erro ao salvar placa: " . $e->getMessage());
                    header('Location: /');
                }  
            }
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
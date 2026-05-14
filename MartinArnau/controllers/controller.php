<?php

if ($_SERVER['REQUEST_METHOD'] == 'GET') {

    if (isset($_GET['credencials'])) {
        //Aquest és el cas en que cal validar usuari i passord

        require_once '../models/usuariValidarModel.php';

        //He de decodificar
        $json = json_decode($_GET['credencials'], true);

        //Ens assegurem no arriben vuits

        if (isset($json['usuari'])) {
            $user = $json['usuari'];
        } else {
            $user = '';
        }

        //El mateix amb la forma més actual
        if (isset($json['password'])) {
            $pass = $json['password'];
        } else {
            $pass = '';
        }

        // Instanciem el model (això executa el __construct i connecta a la BD)
        $uModel = new usuariValidarModel();

        // Cridem a la funció de validació
        if ($uModel->validarCredencials($user, $pass)) {
            // Tot correcte, he de serialitzar
            $resposta = array('resposta' => 1);
            echo json_encode($resposta);
        } else {
            // Credencials incorrectes, he de serialitzar
            $resposta = array('resposta' => 0);
            echo json_encode($resposta);
        }
    }


    if (isset($_GET['mclients'])) {
        //Aquest és el cas en que llisto els clients

        require_once '../models/adminModel.php';

        //He de decodificar
        $json = json_decode($_GET['mclients'], true);

        // Instanciem el model (això executa el __construct i connecta a la BD)
        $aModel = new adminModel();

        echo json_encode($aModel->llistaClients());
    }

    //Llistar llibres
    if (isset($_GET['mllibres'])) {
        require_once '../models/adminModel.php';
        $aModel = new adminModel();
        echo json_encode($aModel->llistaLlibres());
    }
}

if($_SERVER['REQUEST_METHOD'] == 'POST'){

        require_once '../models/adminModel.php';
        $aModel = new adminModel();
        
        //gestió de clients
        if(isset($_POST['accio_client'])){
            $json = json_decode($_POST['accio_client'], true);

            if($json['client'] == "esborraclient"){
                $aModel->esborraClients($json['ids']);
                echo json_encode(array("resposta" => "ok"));
            }
            else if($json['client'] == "actualitzaclient"){
                $aModel->actualitzaClients($json['dades']);
                echo json_encode(array("resposta" => "ok"));
            }
        }
        //gestió de llibres
        if(isset($_POST['accio_llibre'])){
            $json = json_decode($_POST['accio_llibre'], true);
        
            if($json['llibre'] == "esborrallibre"){
                $aModel->esborraLlibres($json['isbns']);
                echo json_encode(array("resposta" => "ok"));
            }
            else if($json['llibre'] == "actualitzallibre"){
                $aModel->actualitzaLlibres($json['dades']);
                echo json_encode(array("resposta" => "ok"));
            }
        }
}
?>

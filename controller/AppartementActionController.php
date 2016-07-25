<?php
    //classes loading begin
    function classLoad ($myClass) {
        if(file_exists('../model/'.$myClass.'.php')){
            include('../model/'.$myClass.'.php');
        }
        elseif(file_exists('../controller/'.$myClass.'.php')){
            include('../controller/'.$myClass.'.php');
        }
    }
    spl_autoload_register("classLoad"); 
    include('../config.php');  
    include('../lib/image-processing.php');
    //classes loading end
    session_start();
    
    //post input processing
    $action = htmlentities($_POST['action']);
    //This var contains result message of CRUD action
    $actionMessage = "";
    $typeMessage = "";
    $appartementManager = new AppartementManager($pdo);
    $projetManager = new ProjetManager($pdo);
    //The History Component is used in all ActionControllers to mention a historical version of each action
    $historyManager = new HistoryManager($pdo);
    $idProjet = htmlentities($_POST['idProjet']);
    $nomProjet = $projetManager->getProjetById($idProjet)->nom();
    if($action == "add"){
        if( !empty($_POST['code']) ){
            $code = htmlentities($_POST['code']);
            $niveau = htmlentities($_POST['niveau']);
            $prix = htmlentities($_POST['prix']);
            $superficie = htmlentities($_POST['superficie']);
            $facade = htmlentities($_POST['facade']);
            $nombrePiece = htmlentities($_POST['nombrePiece']);
            $cave = htmlentities($_POST['cave']);
            $status = htmlentities($_POST['status']);
            $par = htmlentities($_POST['par']);
            $createdBy = $_SESSION['userMerlaTrav']->login();
            $created = date('Y-m-d h:i:s');
            //create object
            $appartement = 
            new Appartement(array('nom' => $code, 'niveau' => $niveau, 'prix' => $prix, 
            'superficie' => $superficie, 'facade' => $facade, 'nombrePiece' => $nombrePiece, 
            'cave' => $cave, 'idProjet' => $idProjet, 'status' => $status, 'par' => $par,'createdBy' => $createdBy, 'created' => $created));
            //add it to db
            $appartementManager->add($appartement);
            //add history data to db
            $history = new History(array(
                'action' => "Ajout",
                'target' => "Table des appartements",
                'description' => "Ajout de l'appartement : ".$code." - Projet : ".$nomProjet,
                'created' => $created,
                'createdBy' => $createdBy
            ));
            //add it to db
            $historyManager->add($history);
            $actionMessage = "Opération Valide : Appartement Ajouté avec succès.";  
            $typeMessage = "success";
        }
        else{
            $actionMessage = "Erreur Ajout Appartement : Vous devez remplir le champ <strong>Nom</strong>.";
            $typeMessage = "error";
        }
    }
    else if($action == "update"){
        if(!empty($_POST['code'])){
            $id = htmlentities($_POST['idAppartement']);
            $code = htmlentities($_POST['code']);
            $niveau = htmlentities($_POST['niveau']);
            $prix = htmlentities($_POST['prix']);
            $superficie = htmlentities($_POST['superficie']);
            $facade = htmlentities($_POST['facade']);
            $nombrePiece = htmlentities($_POST['nombrePiece']);
            $cave = htmlentities($_POST['cave']);
            $status = htmlentities($_POST['status']);
            $par = htmlentities($_POST['par']);
            $updatedBy = $_SESSION['userMerlaTrav']->login();
            $updated = date('Y-m-d h:i:s');
            $appartement = 
            new Appartement(array('id' => $id, 'nom' => $code, 'niveau' => $niveau, 'prix' => $prix, 
            'superficie' => $superficie, 'facade' => $facade, 'nombrePiece' => $nombrePiece, 
            'cave' => $cave, 'status' => $status, 'par' => $par, 'updatedBy' => $updatedBy, 'updated' => $updated));
            $appartementManager->update($appartement);
            //add history data to db
            $createdBy = $_SESSION['userMerlaTrav']->login();
            $created = date('Y-m-d h:i:s');
            $history = new History(array(
                'action' => "Modification",
                'target' => "Table des appartements",
                'description' => "Modification de l'appartement : ".$code." - Projet : ".$nomProjet,
                'created' => $created,
                'createdBy' => $createdBy
            ));
            //add it to db
            $historyManager->add($history);
            $actionMessage = "Opération Valide : Appartement Modifié avec succès.";
            $typeMessage = "success";
        }
        else{
            $actionMessage = "Erreur Modification Appartement : Vous devez remplir le champ <strong>Code</strong>.";
            $typeMessage = "error";
        }
    }
    else if($action=="updateStatus"){
        $idAppartement = $_POST['idAppartement'];
        $status = htmlentities($_POST['status']);
        $nomAppartement = $appartementManager->getAppartementById($idAppartement)->nom();
        $appartementManager->changeStatus($idAppartement, $status);
        //add history data to db
        $createdBy = $_SESSION['userMerlaTrav']->login();
        $created = date('Y-m-d h:i:s');
        $history = new History(array(
            'action' => "Modification Status",
            'target' => "Table des appartements",
            'description' => "Changement de status de l'appartement ".$nomAppartement." vers le status : ".$status." - Projet : ".$nomProjet,
            'created' => $created,
            'createdBy' => $createdBy
        ));
        //add it to db
        $historyManager->add($history);
        $actionMessage = "Opération Valide : Appartement Status Modifié avec succès.";
        $typeMessage = "success";
    }
    else if($action=="updateClient"){
        $idAppartement = $_POST['idAppartement'];
        $par = htmlentities($_POST['par']);
        $nomAppartement = $appartementManager->getAppartementById($idAppartement)->nom();
        $appartementManager->updatePar($par, $idAppartement);
        //add history data to db
        $createdBy = $_SESSION['userMerlaTrav']->login();
        $created = date('Y-m-d h:i:s');
        $history = new History(array(
            'action' => "Modification Client",
            'target' => "Table des appartements",
            'description' => "Changement de réservation de l'appartement ".$nomAppartement." pour  : ".$par." - Projet : ".$nomProjet,
            'created' => $created,
            'createdBy' => $createdBy
        ));
        //add it to db
        $historyManager->add($history);
        $actionMessage = "Opération Valide : Appartement Réservation Modifiée avec succès.";
        $typeMessage = "success";
    }
    else if($action=="delete"){
        $idAppartement = $_POST['idAppartement'];
        $nomAppartement = $appartementManager->getAppartementById($idAppartement)->nom();
        $appartementManager->delete($idAppartement);
        //add history data to db
        $createdBy = $_SESSION['userMerlaTrav']->login();
        $created = date('Y-m-d h:i:s');
        $history = new History(array(
            'action' => "Suppression",
            'target' => "Table des appartements",
            'description' => "Suppression de l'appartement ".$nomAppartement." - Projet : ".$nomProjet,
            'created' => $created,
            'createdBy' => $createdBy
        ));
        //add it to db
        $historyManager->add($history);
        $actionMessage = "Opération Valide : Appartement Supprimé avec succès.";
        $typeMessage = "success";
    }
    
    $_SESSION['appartement-action-message'] = $actionMessage;
    $_SESSION['appartement-type-message'] = $typeMessage;
    header('Location:../appartements.php?idProjet='.$idProjet);
    
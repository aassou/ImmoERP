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
    $appartementPiecesManager = new AppartementPiecesManager($pdo);
    $idProjet = htmlentities($_POST['idProjet']);
    $idAppartement = htmlentities($_POST['idAppartement']);
    
    if($action == "add"){
        if( file_exists($_FILES['url']['tmp_name']) || is_uploaded_file($_FILES['url']['tmp_name']) ){
            $url = imageProcessing($_FILES['url'], '/pieces/pieces_appartement/');
            $nom = htmlentities($_POST['nom']);
            $createdBy = $_SESSION['userMerlaTrav']->login();
            $created = date('Y-m-d h:i:s');
            //create object
            $appartementPiece = 
            new AppartementPieces(array(
                'nom'=>$nom, 'url'=>$url, 'idAppartement'=>$idAppartement,
                'created'=>$created, 'createdBy'=>$createdBy));
            //add it to db
            $appartementPiecesManager->add($appartementPiece);
            $actionMessage = "Opération Valide : Pièce Appartement Ajouté(e) avec succès.";  
            $typeMessage = "success";
        }
        else{
            $actionMessage = "Erreur Ajout Appartement Pièce : Vous devez sélectionner un fichier !";
            $typeMessage = "error";
        }
    }
    else if($action == "update"){
        if( file_exists($_FILES['url']['tmp_name']) || is_uploaded_file($_FILES['url']['tmp_name']) ){
            $url = imageProcessing($_FILES['url'], '/pieces/pieces_appartement/');
            $nom = htmlentities($_POST['nom']);
            $updatedBy = $_SESSION['userMerlaTrav']->login();
            $updated = date('Y-m-d h:i:s');
            //create object
            $appartementPiece = 
            new AppartementPieces(array(
                'nom'=>$nom, 'url'=>$url, 'idAppartement'=>$idAppartement,
                'updated'=>$updated, 'updatedBy'=>$updatedBy));
            //add it to db
            $appartementPiecesManager->update($appartementPiece);
            $actionMessage = "Opération Valide : Pièce Appartement Modifié(e) avec succès.";
            $typeMessage = "success";
        }
        else{
            $actionMessage = "Erreur Ajout Appartement Pièce : Vous devez sélectionner un fichier !";
            $typeMessage = "error";
        }
    }
    else if($action=="delete"){
        $idAppartementPiece = $_POST['idAppartementPiece'];
        $appartementManager->delete($idAppartementPiece);
        $actionMessage = "Opération Valide : Pièce Appartement Supprimé(e) avec succès.";
        $typeMessage = "success";
    }
    
    $_SESSION['appartement-piece-action-message'] = $actionMessage;
    $_SESSION['appartement-piece-type-message'] = $typeMessage;
    header('Location:../appartements.php?idProjet='.$idProjet);
    
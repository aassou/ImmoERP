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

    //Component Class Manager

    $alertManager = new AlertManager($pdo);
	//Action Add Processing Begin
    if($action == "add"){
        if( !empty($_POST['alert']) ){
			$alert = htmlentities($_POST['alert']);
			$status = 0;
			$createdBy = $_SESSION['userMerlaTrav']->login();
            $created = date('Y-m-d h:i:s');
            //create object
            $alert = new Alert(array(
				'alert' => $alert,
				'status' => $status,
				'created' => $created,
            	'createdBy' => $createdBy
			));
            //add it to db
            $alertManager->add($alert);
            $actionMessage = "Opération Valide : Alert Ajouté(e) avec succès.";  
            $typeMessage = "success";
        }
        else{
            $actionMessage = "Erreur Ajout alert : Vous devez remplir le champ 'Description'.";
            $typeMessage = "error";
        }
    }
    //Action Add Processing End
    //Action Update Processing Begin
    else if($action == "update"){
        $idAlert = htmlentities($_POST['idAlert']);
        if(!empty($_POST['alert'])){
			$alert = htmlentities($_POST['alert']);
			$status = htmlentities($_POST['status']);
			$updatedBy = $_SESSION['userMerlaTrav']->login();
            $updated = date('Y-m-d h:i:s');
            $alert = new Alert(array(
				'id' => $idAlert,
				'alert' => $alert,
				'status' => $status,
				'updated' => $updated,
            	'updatedBy' => $updatedBy
			));
            $alertManager->update($alert);
            $actionMessage = "Opération Valide : Alert Modifié(e) avec succès.";
            $typeMessage = "success";
        }
        else{
            $actionMessage = "Erreur Modification Alert : Vous devez remplir le champ 'alert'.";
            $typeMessage = "error";
        }
    }
    //Action Update Processing End
    //Action UpdateStatus Processing Begin
    else if($action == "updateStatus"){
        $idAlert = htmlentities($_POST['idAlert']);
        $status = htmlentities($_POST['status']);
        $alertManager->updateStatus($idAlert, $status);
        $actionMessage = "Opération Valide : Status Alert Modifié(e) avec succès.";
        $typeMessage = "success";
    }
    //Action Update Processing End
    //Action Delete Processing Begin
    else if($action == "delete"){
        $idAlert = htmlentities($_POST['idAlert']);
        $alertManager->delete($idAlert);
        $actionMessage = "Opération Valide : Alert supprimé(e) avec succès.";
        $typeMessage = "success";
    }
    //Action Delete Processing End
    $_SESSION['alert-action-message'] = $actionMessage;
    $_SESSION['alert-type-message'] = $typeMessage;
    header('Location:../alert.php');


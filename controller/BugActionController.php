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

    $bugManager = new BugManager($pdo);
	//Action Add Processing Begin
    	if($action == "add"){
        if( !empty($_POST['bug']) ){
			$bug = htmlentities($_POST['bug']);
			$lien = htmlentities($_POST['lien']);
			$status = 0;
			$createdBy = $_SESSION['userMerlaTrav']->login();
            $created = date('Y-m-d h:i:s');
            //create object
            $bug = new Bug(array(
				'bug' => $bug,
				'lien' => $lien,
				'status' => $status,
				'created' => $created,
            	'createdBy' => $createdBy
			));
            //add it to db
            $bugManager->add($bug);
            $actionMessage = "Opération Valide : Bug Ajouté(e) avec succès.";  
            $typeMessage = "success";
        }
        else{
            $actionMessage = "Erreur Ajout bug : Vous devez remplir le champ 'bug'.";
            $typeMessage = "error";
        }
    }
    //Action Add Processing End
    //Action Update Processing Begin
    else if($action == "update"){
        $idBug = htmlentities($_POST['idBug']);
        if(!empty($_POST['bug'])){
			$bug = htmlentities($_POST['bug']);
			$lien = htmlentities($_POST['lien']);
			$updatedBy = $_SESSION['userMerlaTrav']->login();
            $updated = date('Y-m-d h:i:s');
            $bug = new Bug(array(
				'id' => $idBug,
				'bug' => $bug,
				'lien' => $lien,
				'updated' => $updated,
            	'updatedBy' => $updatedBy
			));
            $bugManager->update($bug);
            $actionMessage = "Opération Valide : Bug Modifié(e) avec succès.";
            $typeMessage = "success";
        }
        else{
            $actionMessage = "Erreur Modification Bug : Vous devez remplir le champ 'bug'.";
            $typeMessage = "error";
        }
    }
    //Action Update Processing End
    //Action Delete Processing Begin
    else if($action == "delete"){
        $idBug = htmlentities($_POST['idBug']);
        $bugManager->delete($idBug);
        $actionMessage = "Opération Valide : Bug supprimé(e) avec succès.";
        $typeMessage = "success";
    }
    //Action Delete Processing End
    $_SESSION['bug-action-message'] = $actionMessage;
    $_SESSION['bug-type-message'] = $typeMessage;
    header('Location:../bugs.php');


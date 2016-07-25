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

    $historyManager = new HistoryManager($pdo);
	//Action Add Processing Begin
    	if($action == "add"){
        if( !empty($_POST['action']) ){
			$action = htmlentities($_POST['action']);
			$target = htmlentities($_POST['target']);
			$description = htmlentities($_POST['description']);
			$createdBy = $_SESSION['userMerlaTrav']->login();
            $created = date('Y-m-d h:i:s');
            //create object
            $history = new History(array(
				'action' => $action,
				'target' => $target,
				'description' => $description,
				'created' => $created,
            	'createdBy' => $createdBy
			));
            //add it to db
            $historyManager->add($history);
            $actionMessage = "Opération Valide : History Ajouté(e) avec succès.";  
            $typeMessage = "success";
        }
        else{
            $actionMessage = "Erreur Ajout history : Vous devez remplir le champ 'action'.";
            $typeMessage = "error";
        }
    }
    //Action Add Processing End
    //Action Update Processing Begin
    else if($action == "update"){
        $idHistory = htmlentities($_POST['idHistory']);
        if(!empty($_POST['action'])){
			$action = htmlentities($_POST['action']);
			$target = htmlentities($_POST['target']);
			$description = htmlentities($_POST['description']);
			$updatedBy = $_SESSION['userMerlaTrav']->login();
            $updated = date('Y-m-d h:i:s');
            			$history = new History(array(
				'id' => $idHistory,
				'action' => $action,
				'target' => $target,
				'description' => $description,
				'updated' => $updated,
            	'updatedBy' => $updatedBy
			));
            $historyManager->update($history);
            $actionMessage = "Opération Valide : History Modifié(e) avec succès.";
            $typeMessage = "success";
        }
        else{
            $actionMessage = "Erreur Modification History : Vous devez remplir le champ 'action'.";
            $typeMessage = "error";
        }
    }
    //Action Update Processing End
    //Action Delete Processing Begin
    else if($action == "delete"){
        $idHistory = htmlentities($_POST['idHistory']);
        $historyManager->delete($idHistory);
        $actionMessage = "Opération Valide : History supprimé(e) avec succès.";
        $typeMessage = "success";
    }
    //Action Delete Processing End
    $_SESSION['history-action-message'] = $actionMessage;
    $_SESSION['history-type-message'] = $typeMessage;
    header('Location:../file-name-please.php');


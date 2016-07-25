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
    $chargeManager = new ChargeManager($pdo);
    $typeChargeManager = new TypeChargeManager($pdo);
    $projetManager = new ProjetManager($pdo);
    //The History Component is used in all ActionControllers to mention a historical version of each action
    $historyManager = new HistoryManager($pdo);
	//Action Add Processing Begin
	$idProjet = htmlentities($_POST['idProjet']);
    $nomProjet = $projetManager->getProjetById($idProjet)->nom();
    //begin process: test the action
    //Action Add Processing Begin
    if($action == "add"){
        if( !empty($_POST['type']) ){
			$type = htmlentities($_POST['type']);
            $typeCharge = $typeChargeManager->getTypeChargeById($type)->nom();
			$dateOperation = htmlentities($_POST['dateOperation']);
			$montant = htmlentities($_POST['montant']);
			$societe = htmlentities($_POST['societe']);
			$designation = htmlentities($_POST['designation']);
			$createdBy = $_SESSION['userMerlaTrav']->login();
            $created = date('Y-m-d h:i:s');
            //create object
            $charge = new Charge(array(
				'type' => $type,
				'dateOperation' => $dateOperation,
				'montant' => $montant,
				'societe' => $societe,
				'designation' => $designation,
				'idProjet' => $idProjet,
				'created' => $created,
            	'createdBy' => $createdBy
			));
            //add it to db
            $chargeManager->add($charge);
            //add history data to db
            $history = new History(array(
                'action' => "Ajout",
                'target' => "Table des charges",
                'description' => "Ajout d'une charge de type : ".$typeCharge.", le : ".$dateOperation.", d'un montant de : ".$montant.", dont la designation est : ".$designation." - Projet : ".$nomProjet,
                'created' => $created,
                'createdBy' => $createdBy
            ));
            //add it to db
            $historyManager->add($history);
            $actionMessage = "<strong>Opération Valide</strong> : Charge Ajouté(e) avec succès.";  
            $typeMessage = "success";
        }
        else{
            $actionMessage = "<strong>Erreur Ajout Charge</strong> : Vous devez remplir le champ 'type'.";
            $typeMessage = "error";
        }
    }
    //Action Add Processing End
    //Action Update Processing Begin
    else if($action == "update"){
        $idCharge = htmlentities($_POST['idCharge']);
        if(!empty($_POST['type'])){
			$type = htmlentities($_POST['type']);
            $typeCharge = $typeChargeManager->getTypeChargeById($type)->nom();
			$dateOperation = htmlentities($_POST['dateOperation']);
			$montant = htmlentities($_POST['montant']);
			$societe = htmlentities($_POST['societe']);
			$designation = htmlentities($_POST['designation']);
            $updatedBy = $_SESSION['userMerlaTrav']->login();
            $updated = date('Y-m-d h:i:s');
			$charge = new Charge(array(
				'id' => $idCharge,
				'type' => $type,
				'dateOperation' => $dateOperation,
				'montant' => $montant,
				'societe' => $societe,
				'designation' => $designation,
				'updated' => $updated,
				'updatedBy' => $updatedBy
			));
            $chargeManager->update($charge);
            //add history data to db
            $createdBy = $_SESSION['userMerlaTrav']->login();
            $created = date('Y-m-d h:i:s');
            $history = new History(array(
                'action' => "Modification",
                'target' => "Table des charges",
                'description' => "Modification de la charge dont l'identifiant est : ".$idCharge." de type : ".$typeCharge.", le : ".$dateOperation.", d'un montant de : ".$montant.", dont la designation est : ".$designation." - Projet : ".$nomProjet,
                'created' => $created,
                'createdBy' => $createdBy
            ));
            //add it to db
            $historyManager->add($history);
            $actionMessage = "<strong>Opération Valide</strong> : Charge Modifié(e) avec succès.";
            $typeMessage = "success";
        }
        else{
            $actionMessage = "<strong>Erreur Modification Charge</strong> : Vous devez remplir le champ 'type'.";
            $typeMessage = "error";
        }
    }
    //Action Update Processing End
    //Action Delete Processing Begin
    else if($action == "delete"){
        $idCharge = htmlentities($_POST['idCharge']);
        $charge = $chargeManager->getChargeById($idCharge);
        $typeCharge = $typeChargeManager->getTypeChargeById($charge->type())->nom();
        $chargeManager->delete($idCharge);
        //add history data to db
        $createdBy = $_SESSION['userMerlaTrav']->login();
        $created = date('Y-m-d h:i:s');
        $history = new History(array(
            'action' => "Suppression",
            'target' => "Table des charges",
            'description' => "Suppression de la charge dont l'identifiant est : ".$idCharge." de type : ".$typeCharge.", le : ".$charge->dateOperation().", d'un montant de : ".$charge->montant().", dont la designation est : ".$charge->designation()." - Projet : ".$nomProjet,
            'created' => $created,
            'createdBy' => $createdBy
        ));
        //add it to db
        $historyManager->add($history);
        $actionMessage = "<strong>Opération Valide</strong> : Charge supprimé(e) avec succès.";
        $typeMessage = "success";
    }
    //Action Delete Processing End
    $_SESSION['charge-action-message'] = $actionMessage;
    $_SESSION['charge-type-message'] = $typeMessage;
    $redirectLink = "Location:../projet-charges-grouped.php?idProjet=".$idProjet;
    if( isset($_POST['typeCharge']) and isset($_POST['source']) and $_POST['source']=="projet-charges-type" ) {
        $typeCharge = htmlentities($_POST['typeCharge']);
        $redirectLink = "Location:../projet-charges-type.php?idProjet=".$idProjet."&type=".$typeCharge;
    }
    header($redirectLink);


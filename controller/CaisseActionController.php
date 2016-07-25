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
    //The History Component is used in all ActionControllers to mention a historical version of each action
    $historyManager = new HistoryManager($pdo);
    $caisseManager = new CaisseManager($pdo);
	//Action Add Processing Begin
    	if($action == "add"){
        if( !empty($_POST['type']) ){
			$type = htmlentities($_POST['type']);
			$dateOperation = htmlentities($_POST['dateOperation']);
			$montant = htmlentities($_POST['montant']);
			$designation = htmlentities($_POST['designation']);
			$destination = htmlentities($_POST['destination']);
			$createdBy = $_SESSION['userMerlaTrav']->login();
            $created = date('Y-m-d h:i:s');
            //create object
            $caisse = new Caisse(array(
				'type' => $type,
				'dateOperation' => $dateOperation,
				'montant' => $montant,
				'designation' => $designation,
				'destination' => $destination,
				'created' => $created,
            	'createdBy' => $createdBy
			));
            //add it to db
            $caisseManager->add($caisse);
            //add history data to db
            $history = new History(array(
                'action' => "Ajout",
                'target' => "Table de caisse",
                'description' => "Ajout d'une opération de type : ".$type.", le ".$dateOperation.", d'un montant de : ".$montant."DH, en désignation : ".$designation,
                'created' => $created,
                'createdBy' => $createdBy
            ));
            //add it to db
            $historyManager->add($history);
            $actionMessage = "<strong>Opération Valide</strong> : Opération Ajouté(e) avec succès.";  
            $typeMessage = "success";
        }
        else{
            $actionMessage = "<strong>Erreur Ajout caisse</strong> : Vous devez remplir le champ <strong>Montant</strong>.";
            $typeMessage = "error";
        }
    }
    //Action Add Processing End
    //Action Update Processing Begin
    else if($action == "update"){
        $idCaisse = htmlentities($_POST['idCaisse']);
        if(!empty($_POST['montant'])){
			$type = htmlentities($_POST['type']);
			$dateOperation = htmlentities($_POST['dateOperation']);
			$montant = htmlentities($_POST['montant']);
			$designation = htmlentities($_POST['designation']);
			$destination = htmlentities($_POST['destination']);
			$updatedBy = $_SESSION['userMerlaTrav']->login();
            $updated = date('Y-m-d h:i:s');
            $caisse = new Caisse(array(
				'id' => $idCaisse,
				'type' => $type,
				'dateOperation' => $dateOperation,
				'montant' => $montant,
				'designation' => $designation,
				'destination' => $destination,
				'updated' => $updated,
            	'updatedBy' => $updatedBy
			));
            $caisseManager->update($caisse);
            //add history data to db
            $createdBy = $_SESSION['userMerlaTrav']->login();
            $created = date('Y-m-d h:i:s');
            $history = new History(array(
                'action' => "Modification",
                'target' => "Table de caisse",
                'description' => "Modification de l'opération dont l'identifiant est : ".$idCaisse.", de type : ".$type.", le ".$dateOperation.", d'un montant de : ".$montant."DH, en désignation : ".$designation,
                'created' => $created,
                'createdBy' => $createdBy
            ));
            //add it to db
            $historyManager->add($history);
            $actionMessage = "<strong>Opération Valide</strong> : Opération Modifié(e) avec succès.";
            $typeMessage = "success";
        }
        else{
            $actionMessage = "<strong>Erreur Modification Caisse</strong> : Vous devez remplir le champ <strong>Montant</strong>.";
            $typeMessage = "error";
        }
    }
    //Action Update Processing End
    //Action Delete Processing Begin
    else if($action == "delete"){
        $idCaisse = htmlentities($_POST['idCaisse']);
        $caisse = $caisseManager->getCaisseById($idCaisse);
        $caisseManager->delete($idCaisse);
        //add history data to db
        $createdBy = $_SESSION['userMerlaTrav']->login();
        $created = date('Y-m-d h:i:s');
        $history = new History(array(
            'action' => "Suppression",
            'target' => "Table de caisse",
            'description' => "Suppression de l'opération dont l'identifiant est : ".$idCaisse.", de type : ".$caisse->type().", le ".$caisse->dateOperation().", d'un montant de : ".$montant."DH, en désignation : ".$caisse->designation(),
            'created' => $created,
            'createdBy' => $createdBy
        ));
        //add it to db
        $historyManager->add($history);
        $actionMessage = "<strong>Opération Valide</strong> : Opération supprimé(e) avec succès.";
        $typeMessage = "success";
    }
    //Action Delete Processing End
    $_SESSION['caisse-action-message'] = $actionMessage;
    $_SESSION['caisse-type-message'] = $typeMessage;
    $redirecktLink = 'Location:../caisse.php';
    if ( isset ($_POST['source']) and $_POST['source'] == "caisse-group" ) {
        $redirecktLink = "Location:../caisse-group.php";
    }
    else if ( isset($_POST['source']) and $_POST['source'] == "caisse-mois-annee" ) {
        $mois = $_POST['mois'];
        $annee = $_POST['annee'];
        $redirecktLink = "Location:../caisse-mois-annee.php?mois=".$mois."&annee=".$annee;
    } 
    header($redirecktLink);


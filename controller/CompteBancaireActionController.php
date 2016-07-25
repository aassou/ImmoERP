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
    $CompteBancaireManager = new CompteBancaireManager($pdo);
    //The History Component is used in all ActionControllers to mention a historical version of each action
    $historyManager = new HistoryManager($pdo);
	//Action Add Processing Begin
    	if($action == "add"){
        if( !empty($_POST['numero']) ){
			$numero = htmlentities($_POST['numero']);
            $denomination = htmlentities($_POST['denomination']);
			$dateCreation = htmlentities($_POST['dateCreation']);
			$createdBy = $_SESSION['userMerlaTrav']->login();
            $created = date('Y-m-d h:i:s');
            //create object
            $CompteBancaire = new CompteBancaire(array(
				'numero' => $numero,
				'denomination' => $denomination,
				'dateCreation' => $dateCreation,
				'created' => $created,
            	'createdBy' => $createdBy
			));
            //add it to db
            $CompteBancaireManager->add($CompteBancaire);
            //add history data to db
            $history = new History(array(
                'action' => "Ajout",
                'target' => "Table des comptes bancaires",
                'description' => "Ajouter le compte bancaire numéro : ".$numero.", avec la dénomination : ".$denomination,
                'created' => $created,
                'createdBy' => $createdBy
            ));
            //add it to db
            $historyManager->add($history);
            $actionMessage = "Opération Valide : CompteBancaire Ajouté(e) avec succès.";  
            $typeMessage = "success";
        }
        else{
            $actionMessage = "Erreur Ajout CompteBancaire : Vous devez remplir le champ <strong>Numero Compte Bancaire</strong>.";
            $typeMessage = "error";
        }
    }
    //Action Add Processing End
    //Action Update Processing Begin
    else if($action == "update"){
        $idCompteBancaire = htmlentities($_POST['idCompteBancaire']);
        if(!empty($_POST['numero'])){
			$numero = htmlentities($_POST['numero']);
            $denomination = htmlentities($_POST['denomination']);
			$dateCreation = htmlentities($_POST['dateCreation']);
            $updatedBy = $_SESSION['userMerlaTrav']->login();
            $updated = date('Y-m-d h:i:s');
			$CompteBancaire = new CompteBancaire(array(
				'id' => $idCompteBancaire,
				'numero' => $numero,
				'denomination' => $denomination,
				'dateCreation' => $dateCreation,
				'updated' => $updated,
				'updatedBy' => $updatedBy
			));
            $CompteBancaireManager->update($CompteBancaire);
            //add history data to db
            $createdBy = $_SESSION['userMerlaTrav']->login();
            $created = date('Y-m-d h:i:s');
            $history = new History(array(
                'action' => "Modification",
                'target' => "Table des comptes bancaires",
                'description' => "Modifier le compte bancaire numéro : ".$numero.", avec la dénomination : ".$denomination,
                'created' => $created,
                'createdBy' => $createdBy
            ));
            //add it to db
            $historyManager->add($history);
            $actionMessage = "Opération Valide : CompteBancaire Modifié(e) avec succès.";
            $typeMessage = "success";
            echo print_r($CompteBancaire);
        }
        else{
            $actionMessage = "Erreur Modification CompteBancaire : Vous devez remplir le champ <strong>Numero Compte Bancaire</strong>.";
            $typeMessage = "error";
        }
    }
    //Action Update Processing End
    //Action Delete Processing Begin
    else if($action == "delete"){
        $idCompteBancaire = htmlentities($_POST['idCompteBancaire']);
        $compteBancaire = $CompteBancaireManager->getCaisseById($idCompteBancaire); 
        $CompteBancaireManager->delete($idCompteBancaire);
        //add history data to db
        $createdBy = $_SESSION['userMerlaTrav']->login();
        $created = date('Y-m-d h:i:s');
        $history = new History(array(
            'action' => "Suppression",
            'target' => "Table des comptes bancaires",
            'description' => "Suppression du compte bancaire numéro : ".$compteBancaire->numero().", la dénomination : ".$compteBancaire->denomination(),
            'created' => $created,
            'createdBy' => $createdBy
        ));
        //add it to db
        $historyManager->add($history);
        $actionMessage = "Opération Valide : CompteBancaire supprimée avec succès.";
        $typeMessage = "success";
    }
    //Action Delete Processing End
    $_SESSION['CompteBancaire-action-message'] = $actionMessage;
    $_SESSION['CompteBancaire-type-message'] = $typeMessage;
    header('Location:../compte-bancaire.php');


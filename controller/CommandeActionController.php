<?php
    require('../app/classLoad.php');
    require('../db/PDOFactory.php');  
    include('../lib/image-processing.php');
    //classes loading end
    session_start();
    
    //post input processing
    $action = htmlentities($_POST['action']);
    //This var contains result message of CRUD action
    $actionMessage = "";
    $typeMessage = "";
    $redirectLink = "";
    $companyID = htmlentities($_POST['companyID']);
    //Component Class Manager
    $commandeManager = new CommandeManager(PDOFactory::getMysqlConnection());
	
	//Action Add Processing Begin
    if($action == "add"){
        if( !empty($_POST['numeroCommande']) ){
			$idFournisseur = htmlentities($_POST['idFournisseur']);
			$idProjet = htmlentities($_POST['idProjet']);
			$dateCommande = htmlentities($_POST['dateCommande']);
			$numeroCommande = htmlentities($_POST['numeroCommande']);
			$designation = htmlentities($_POST['designation']);
			$status = 0;
			$codeLivraison = uniqid().date('YmdHis');;
			$createdBy = $_SESSION['userImmoERPV2']->login();
            $created = date('Y-m-d h:i:s');
             //these next data are used to know the month and the year of a supply demand
            $mois = date('m', strtotime($dateCommande));
            $annee = date('Y', strtotime($dateCommande));
            //create object
            $commande = new Commande(array(
				'idFournisseur' => $idFournisseur,
				'idProjet' => $idProjet,
				'dateCommande' => $dateCommande,
				'numeroCommande' => $numeroCommande,
				'designation' => $designation,
				'status' => $status,
				'companyID' => $companyID,
				'codeLivraison' => $codeLivraison,
				'created' => $created,
            	'createdBy' => $createdBy
			));
            //add it to db
            $commandeManager->add($commande);
            $actionMessage = "Opération Valide : Commande Ajouté(e) avec succès.";  
            $typeMessage = "success";
            $redirectLink = "Location:../views/commande-details.php?codeCommande=".$codeLivraison."&mois=".$mois."&annee=".$annee."&companyID=".$companyID;;
        }
        else{
            if ( isset($_POST['source']) and $_POST['source'] == "commande-group" ) {
                $redirectLink = "Location:../views/commande-group.php?companyID=".$companyID;
            } 
            $actionMessage = "Erreur Ajout commande : Vous devez remplir le champ 'Numéro Commande'.";
            $typeMessage = "error";
        }
    }
    //Action Add Processing End
    
    //Action Update Processing Begin
    else if($action == "update"){
        $idCommande = htmlentities($_POST['idCommande']);
        $codeCommande = htmlentities($_POST['codeCommande']);
        $mois = $_POST['mois'];
        $annee = $_POST['annee'];
        if(!empty($_POST['idFournisseur'])){
			$idFournisseur = htmlentities($_POST['idFournisseur']);
			$idProjet = htmlentities($_POST['idProjet']);
			$dateCommande = htmlentities($_POST['dateCommande']);
			$numeroCommande = htmlentities($_POST['numeroCommande']);
			$designation = htmlentities($_POST['designation']);
			$updatedBy = $_SESSION['userImmoERPV2']->login();
            $updated = date('Y-m-d h:i:s');
            $commande = new Commande(array(
				'id' => $idCommande,
				'idFournisseur' => $idFournisseur,
				'idProjet' => $idProjet,
				'dateCommande' => $dateCommande,
				'numeroCommande' => $numeroCommande,
				'designation' => $designation,
				'companyID' => $companyID,
				'updated' => $updated,
            	'updatedBy' => $updatedBy
			));
            $commandeManager->update($commande);
            $actionMessage = "Opération Valide : Commande Modifié(e) avec succès.";
            $typeMessage = "success";
        }
        else{
            $actionMessage = "Erreur Modification Commande : Vous devez remplir le champ 'idFournisseur'.";
            $typeMessage = "error";
        }
        if ( isset($_POST['source']) and $_POST['source'] == "commande-mois-annee" ) {
            $redirectLink = "Location:../views/commande-mois-annee.php?mois=".$mois."&annee=".$annee."&companyID=".$companyID;    
        }
        else if ( isset($_POST['source']) and $_POST['source'] == "commande-details" ) {
            $redirectLink = "Location:../views/commande-details.php?codeCommande=".$codeCommande."&mois=".$mois."&annee=".$annee."&companyID=".$companyID;;
        }
    }
    //Action Update Processing End
    
    //Action Delete Processing Begin
    else if($action == "delete"){
        $idCommande = htmlentities($_POST['idCommande']);
        $codeCommande = htmlentities($_POST['codeCommande']);
        $mois = $_POST['mois'];
        $annee = $_POST['annee'];
        //delete commande and its details
        $commandeDetailsManager = new CommandeDetailManager(PDOFactory::getMysqlConnection());
        $commandeDetailsManager->deleteCommande($idCommande);
        $commandeManager->delete($idCommande);
        $actionMessage = "Opération Valide : Commande supprimé(e) avec succès.";
        $typeMessage = "success";
        if ( isset($_POST['source']) and $_POST['source'] == "commande-mois-annee" ) {
            $redirectLink = "Location:../views/commande-mois-annee.php?mois=".$mois."&annee=".$annee."&companyID=".$companyID;;    
        }
    }
    //Action Delete Processing End
    
    //set session inforamtions
    $_SESSION['commande-action-message'] = $actionMessage;
    $_SESSION['commande-type-message'] = $typeMessage;
    
    //set redirection link
    header($redirectLink);
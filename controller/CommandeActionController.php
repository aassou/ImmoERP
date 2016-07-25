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
    $redirectLink = "";
    //Component Class Manager
    $commandeManager = new CommandeManager($pdo);
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
			$createdBy = $_SESSION['userMerlaTrav']->login();
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
				'codeLivraison' => $codeLivraison,
				'created' => $created,
            	'createdBy' => $createdBy
			));
            //add it to db
            $commandeManager->add($commande);
            $actionMessage = "Opération Valide : Commande Ajouté(e) avec succès.";  
            $typeMessage = "success";
            $redirectLink = "Location:../commande-details-iaaza.php?codeCommande=".$codeLivraison."&mois=".$mois."&annee=".$annee;
        }
        else{
            if ( isset($_POST['source']) and $_POST['source'] == "commande-group-iaaza" ) {
                $redirectLink = "Location:../commande-group-iaaza.php";
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
			$updatedBy = $_SESSION['userMerlaTrav']->login();
            $updated = date('Y-m-d h:i:s');
            $commande = new Commande(array(
				'id' => $idCommande,
				'idFournisseur' => $idFournisseur,
				'idProjet' => $idProjet,
				'dateCommande' => $dateCommande,
				'numeroCommande' => $numeroCommande,
				'designation' => $designation,
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
        if ( isset($_POST['source']) and $_POST['source'] == "commande-mois-annee-iaaza" ) {
            $redirectLink = "Location:../commande-mois-annee-iaaza.php?mois=".$mois."&annee=".$annee;    
        }
        else if ( isset($_POST['source']) and $_POST['source'] == "commande-details-iaaza" ) {
            $redirectLink = "Location:../commande-details-iaaza.php?codeCommande=".$codeCommande."&mois=".$mois."&annee=".$annee;
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
        $commandeDetailsManager = new CommandeDetailManager($pdo);
        $commandeDetailsManager->deleteCommande($idCommande);
        $commandeManager->delete($idCommande);
        $actionMessage = "Opération Valide : Commande supprimé(e) avec succès.";
        $typeMessage = "success";
        if ( isset($_POST['source']) and $_POST['source'] == "commande-mois-annee-iaaza" ) {
            $redirectLink = "Location:../commande-mois-annee-iaaza.php?mois=".$mois."&annee=".$annee;    
        }
    }
    //Action Delete Processing End
    $_SESSION['commande-action-message'] = $actionMessage;
    $_SESSION['commande-type-message'] = $typeMessage;
    header($redirectLink);


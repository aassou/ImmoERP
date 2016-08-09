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
    $companyID = htmlentities($_POST['companyID']);
    $mois = htmlentities($_POST['mois']);
    $annee = htmlentities($_POST['annee']);
    $codeCommande = htmlentities($_POST['codeCommande']);
    $redirectLink = "Location:../commande-details.php?codeCommande=".$codeCommande."&mois=".$mois."&annee=".$annee."&companyID=".$companyID;
    //Component Class Manager
    $commandeDetailManager = new CommandeDetailManager($pdo);
	//Action Add Processing Begin
    if($action == "add"){
        if( !empty($_POST['reference']) ){
			$reference = htmlentities($_POST['reference']);
			$libelle = htmlentities($_POST['libelle']);
			$quantite = htmlentities($_POST['quantite']);
			$idCommande = htmlentities($_POST['idCommande']);
			$createdBy = $_SESSION['userImmoERPV2']->login();
            $created = date('Y-m-d h:i:s');
            //create object
            $commandeDetail = new CommandeDetail(array(
				'reference' => $reference,
				'libelle' => $libelle,
				'quantite' => $quantite,
				'idCommande' => $idCommande,
				'created' => $created,
            	'createdBy' => $createdBy
			));
            //add it to db
            $commandeDetailManager->add($commandeDetail);
            $actionMessage = "Opération Valide : Article Commande Ajouté(e) avec succès.";  
            $typeMessage = "success";
        }
        else{
            $actionMessage = "Erreur Ajout Article Commande : Vous devez remplir le champ 'reference'.";
            $typeMessage = "error";
        }
    }
    //Action Add Processing End
    //Action Update Processing Begin
    else if($action == "update"){
        $idCommandeDetail = htmlentities($_POST['idCommandeDetail']);
        if(!empty($_POST['reference'])){
			$reference = htmlentities($_POST['reference']);
			$libelle = htmlentities($_POST['libelle']);
			$quantite = htmlentities($_POST['quantite']);
			$updatedBy = $_SESSION['userImmoERPV2']->login();
            $updated = date('Y-m-d h:i:s');
            $commandeDetail = new CommandeDetail(array(
				'id' => $idCommandeDetail,
				'reference' => $reference,
				'libelle' => $libelle,
				'quantite' => $quantite,
				'updated' => $updated,
            	'updatedBy' => $updatedBy
			));
            $commandeDetailManager->update($commandeDetail);
            $actionMessage = "Opération Valide : Article Commande Modifié(e) avec succès.";
            $typeMessage = "success";
        }
        else{
            $actionMessage = "Erreur Modification Article Commande : Vous devez remplir le champ 'reference'.";
            $typeMessage = "error";
        }
    }
    //Action Update Processing End
    //Action Delete Processing Begin
    else if($action == "delete"){
        $idCommandeDetail = htmlentities($_POST['idCommandeDetail']);
        $commandeDetailManager->delete($idCommandeDetail);
        $actionMessage = "Opération Valide : Article Commande supprimé(e) avec succès.";
        $typeMessage = "success";
    }
    //Action Delete Processing End
    $_SESSION['commande-detail-action-message'] = $actionMessage;
    $_SESSION['commande-detail-type-message'] = $typeMessage;
    header($redirectLink);


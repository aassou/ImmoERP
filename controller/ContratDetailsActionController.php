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
    $idContratEmploye = htmlentities($_POST['idContratEmploye']);
    $idProjet = htmlentities($_POST['idProjet']);
    //Component Class Manager

    $contratDetailsManager = new ContratDetailsManager($pdo);
	//Action Add Processing Begin
    	if($action == "add"){
            if( !empty($_POST['montant']) ){
    			$dateOperation = htmlentities($_POST['dateOperation']);
    			$montant = htmlentities($_POST['montant']);
    			$numeroCheque = htmlentities($_POST['numeroCheque']);
    			$createdBy = $_SESSION['userMerlaTrav']->login();
                $created = date('Y-m-d h:i:s');
                //create object
                $contratDetails = new ContratDetails(array(
    				'dateOperation' => $dateOperation,
    				'montant' => $montant,
    				'numeroCheque' => $numeroCheque,
    				'idContratEmploye' => $idContratEmploye,
    				':created' => $created,
    				':createdBy' => $createdBy
    			));
                //add it to db
                $contratDetailsManager->add($contratDetails);
                $actionMessage = "Opération Valide : ContratDetails Ajouté(e) avec succès.";  
                $typeMessage = "success";
            }
            else{
                $actionMessage = "Erreur Ajout contratDetails : Vous devez remplir le champ 'dateOperation'.";
                $typeMessage = "error";
            }
        }
    //Action Add Processing End
    //Action Update Processing Begin
    else if($action == "update"){
        $idContratDetails = htmlentities($_POST['idContratDetails']);
        if(!empty($_POST['dateOperation'])){
			$dateOperation = htmlentities($_POST['dateOperation']);
			$montant = htmlentities($_POST['montant']);
			$numeroCheque = htmlentities($_POST['numeroCheque']);
			$contratDetails = new ContratDetails(array(
				'id' => $idContratDetails,
				'dateOperation' => $dateOperation,
				'montant' => $montant,
				'numeroCheque' => $numeroCheque
			));
            $contratDetailsManager->update($contratDetails);
            $actionMessage = "Opération Valide : ContratDetails Modifié(e) avec succès.";
            $typeMessage = "success";
        }
        else{
            $actionMessage = "Erreur Modification ContratDetails : Vous devez remplir le champ 'dateOperation'.";
            $typeMessage = "error";
        }
    }
    //Action Update Processing End
    //Action Delete Processing Begin
    else if($action == "delete"){
        $idContratDetails = htmlentities($_POST['idContratDetails']);
        $contratDetailsManager->delete($idContratDetails);
        $actionMessage = "Opération Valide : ContratDetails supprimée avec succès.";
        $typeMessage = "success";
    }
    //Action Delete Processing End
    $_SESSION['contratDetails-action-message'] = $actionMessage;
    $_SESSION['contratDetails-type-message'] = $typeMessage;
    header('Location:../contrat-employe-detail.php?idContratEmploye='.$idContratEmploye."&idProjet=".$idProjet);


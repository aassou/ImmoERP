<?php
    require('../app/classLoad.php'); 
    require('../db/PDOFactory.php');  
    include('../lib/image-processing.php');
    
    session_start();
    //post input processing
    $action = htmlentities($_POST['action']);
    //This var contains result message of CRUD action
    $actionMessage = "";
    $typeMessage = "";
    //Component Class Manager
    $typeChargeManager = new TypeChargeCommunManager(PDOFactory::getMysqlConnection());
	//Action Add Processing Begin
    if ( $action == "add" ) {
        if( !empty($_POST['nom']) ){
            $nom = htmlentities($_POST['nom']);
            if ( !$typeChargeManager->exists($nom) ){
                $createdBy = $_SESSION['userImmoERPV2']->login();
                $created = date('Y-m-d h:i:s');
                //create object
                $typeCharge = new TypeChargeCommun(array(
                    'nom' => $nom,
                    'created' => $created,
                    'createdBy' => $createdBy
                ));
                //add it to db
                $typeChargeManager->add($typeCharge);
                $actionMessage = "Opération Valide : Type Charge Ajouté(e) avec succès.";  
                $typeMessage = "success";   
            }
            else{
                $actionMessage = "Erreur Ajout Type Charge : Un type de charge existe déjà avec ce nom <strong>".$nom."</strong>.";
                $typeMessage = "error";
            }
        }
        else{
            $actionMessage = "Erreur Ajout Type Charge : Vous devez remplir le champ <strong>Nom Charge</strong>.";
            $typeMessage = "error";
        }
    }
    //Action Add Processing End
    //Action Update Processing Begin
    else if($action == "update"){
        $idTypeCharge = htmlentities($_POST['idTypeCharge']);
        if(!empty($_POST['nom'])){
			$nom = htmlentities($_POST['nom']);
			$updatedBy = $_SESSION['userImmoERPV2']->login();
            $updated = date('Y-m-d h:i:s');
            $typeCharge = new TypeChargeCommun(array(
				'id' => $idTypeCharge,
				'nom' => $nom,
				'updated' => $updated,
            	'updatedBy' => $updatedBy
			));
            $typeChargeManager->update($typeCharge);
            $actionMessage = "Opération Valide : TypeCharge Modifié(e) avec succès.";
            $typeMessage = "success";
        }
        else{
            $actionMessage = "Erreur Modification TypeCharge : Vous devez remplir le champ <strong>Nom Charge</strong>.";
            $typeMessage = "error";
        }
    }
    //Action Update Processing End
    //Action Delete Processing Begin
    else if($action == "delete"){
        $idTypeCharge = htmlentities($_POST['idTypeCharge']);
        $typeChargeManager->delete($idTypeCharge);
        $actionMessage = "Opération Valide : TypeCharge supprimé(e) avec succès.";
        $typeMessage = "success";
    }
    //Action Delete Processing End
    $_SESSION['typeCharge-action-message'] = $actionMessage;
    $_SESSION['typeCharge-type-message'] = $typeMessage;
    //We have 3 forms that can request this resource, so we test which one of these forms requested this action
    //and we will set the redirection link based on it.
    //the first one and the normal case
    $redirectLink = "Location:../views/charges-communs-grouped.php";
    //the second one which comes from "charges-communs-type" url
    if( isset($_POST['typeCharge']) and isset($_POST['source']) and $_POST['source']=="charges-communs-type" ) {
        $typeCharge = htmlentities($_POST['typeCharge']);
        $redirectLink = "Location:../views/charges-communs-type.php?type=".$typeCharge;
    }
    //the third one which comes from "type-charges-communs" url
    else if( isset($_POST['source']) and $_POST['source'] == "type-charges-communs" ) {
        $redirectLink = "Location:../views/type-charges-communs.php";
    }
    
    header($redirectLink);
    
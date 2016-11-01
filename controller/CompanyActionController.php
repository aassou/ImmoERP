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
    
    //Component Class Manager
    $companyManager = new CompanyManager(PDOFactory::getMysqlConnection());
    
	//Action Add Processing Begin
    if($action == "add"){
        if( !empty($_POST['nom']) ){
			$nom = htmlentities($_POST['nom']);
			$adresse = htmlentities($_POST['adresse']);
			$nomArabe = htmlentities($_POST['nomArabe']);
			$adresseArabe = htmlentities($_POST['adresseArabe']);
			$directeur = htmlentities($_POST['directeur']);
			$createdBy = $_SESSION['userImmoERPV2']->login();
            $created = date('Y-m-d h:i:s');
            //create object
            $company = new Company(array(
				'nom' => $nom,
				'adresse' => $adresse,
				'nomArabe' => $nomArabe,
				'adresseArabe' => $adresseArabe,
				'directeur' => $directeur,
				'created' => $created,
            	'createdBy' => $createdBy
			));
            //add it to db
            $companyManager->add($company);
            $actionMessage = "Opération Valide : Company Ajouté(e) avec succès.";  
            $typeMessage = "success";
        }
        else{
            $actionMessage = "Erreur Ajout company : Vous devez remplir le champ 'nom'.";
            $typeMessage = "error";
        }
        $redirectLink = "Location:../views/company-choice.php";
    }
    //Action Add Processing End
    
    //Action Update Processing Begin
    else if($action == "update"){
        $idCompany = htmlentities($_POST['idCompany']);
        if(!empty($_POST['nom'])){
			$nom = htmlentities($_POST['nom']);
			$adresse = htmlentities($_POST['adresse']);
			$nomArabe = htmlentities($_POST['nomArabe']);
			$adresseArabe = htmlentities($_POST['adresseArabe']);
			$directeur = htmlentities($_POST['directeur']);
			$updatedBy = $_SESSION['userImmoERPV2']->login();
            $updated = date('Y-m-d h:i:s');
            			$company = new Company(array(
				'id' => $idCompany,
				'nom' => $nom,
				'adresse' => $adresse,
				'nomArabe' => $nomArabe,
				'adresseArabe' => $adresseArabe,
				'directeur' => $directeur,
				'updated' => $updated,
            	'updatedBy' => $updatedBy
			));
            $companyManager->update($company);
            $actionMessage = "Opération Valide : Company Modifié(e) avec succès.";
            $typeMessage = "success";
        }
        else{
            $actionMessage = "Erreur Modification Company : Vous devez remplir le champ 'nom'.";
            $typeMessage = "error";
        }
        $redirectLink = "Location:../views/companies.php";
    }
    //Action Update Processing End
    
    //Action Delete Processing Begin
    else if($action == "delete"){
        $idCompany = htmlentities($_POST['idCompany']);
        $companyManager->delete($idCompany);
        $actionMessage = "Opération Valide : Company supprimé(e) avec succès.";
        $typeMessage = "success";
        $redirectLink = "Location:../views/companies.php";
    }
    //Action Delete Processing End
    
    //set session informations
    $_SESSION['company-action-message'] = $actionMessage;
    $_SESSION['company-type-message'] = $typeMessage;
    
    //set redirection link
    header($redirectLink);


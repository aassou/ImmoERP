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
    $employeManager = new EmployeManager($pdo);
	//Action Add Processing Begin
    if($action == "add"){
        if( !empty($_POST['nom']) ){
			$nom = htmlentities($_POST['nom']);
			$adresse = htmlentities($_POST['adresse']);
			$nomArabe = htmlentities($_POST['nomArabe']);
			$adresseArabe = htmlentities($_POST['adresseArabe']);
			$cin = htmlentities($_POST['cin']);
			$telephone = htmlentities($_POST['telephone']);
			$createdBy = $_SESSION['userMerlaTrav']->login();
            $created = date('Y-m-d h:i:s');
            //create object
            $employe = new Employe(array(
				'nom' => $nom,
				'adresse' => $adresse,
				'nomArabe' => $nomArabe,
				'adresseArabe' => $adresseArabe,
				'cin' => $cin,
				'telephone' => $telephone,
				'created' => $created,
            	'createdBy' => $createdBy
			));
            //add it to db
            $employeManager->add($employe);
            //add history data to db
            $history = new History(array(
                'action' => "Ajout",
                'target' => "Table des employés",
                'description' => "Ajout de l'employé : ".$nom,
                'created' => $created,
                'createdBy' => $createdBy
            ));
            //add it to db
            $historyManager->add($history);
            $actionMessage = "Opération Valide : Employe Ajouté(e) avec succès.";  
            $typeMessage = "success";
        }
        else{
            $actionMessage = "Erreur Ajout employe : Vous devez remplir le champ 'nom'.";
            $typeMessage = "error";
        }
    }
    //Action Add Processing End
    //Action Update Processing Begin
    else if($action == "update"){
        $idEmploye = htmlentities($_POST['idEmploye']);
        if(!empty($_POST['nom'])){
			$nom = htmlentities($_POST['nom']);
			$adresse = htmlentities($_POST['adresse']);
			$nomArabe = htmlentities($_POST['nomArabe']);
			$adresseArabe = htmlentities($_POST['adresseArabe']);
			$cin = htmlentities($_POST['cin']);
			$telephone = htmlentities($_POST['telephone']);
			$updatedBy = $_SESSION['userMerlaTrav']->login();
            $updated = date('Y-m-d h:i:s');
            $employe = new Employe(array(
				'id' => $idEmploye,
				'nom' => $nom,
				'adresse' => $adresse,
				'nomArabe' => $nomArabe,
				'adresseArabe' => $adresseArabe,
				'cin' => $cin,
				'telephone' => $telephone,
				'updated' => $updated,
            	'updatedBy' => $updatedBy
			));
            $employeManager->update($employe);
            //add history data to db
            $history = new History(array(
                'action' => "Modification",
                'target' => "Table des employés",
                'description' => "Modification de l'employé : ".$nom,
                'created' => $updated,
                'createdBy' => $updatedBy
            ));
            //add it to db
            $historyManager->add($history);
            $actionMessage = "Opération Valide : Employe Modifié(e) avec succès.";
            $typeMessage = "success";
        }
        else{
            $actionMessage = "Erreur Modification Employe : Vous devez remplir le champ 'nom'.";
            $typeMessage = "error";
        }
    }
    //Action Update Processing End
    //Action Delete Processing Begin
    else if($action == "delete"){
        $idEmploye = htmlentities($_POST['idEmploye']);
        $nomEmploye = $employeManager->getEmployeById($idEmploye)->nom();
        $employeManager->delete($idEmploye);
        //add history data to db
        $createdBy = $_SESSION['userMerlaTrav']->login();
        $created = date('Y-m-d h:i:s');
        $history = new History(array(
            'action' => "Suppression",
            'target' => "Table des employés",
            'description' => "Suppression de l'employé : ".$nomEmploye,
            'created' => $created,
            'createdBy' => $createdBy
        ));
        //add it to db
        $historyManager->add($history);
        $actionMessage = "Opération Valide : Employe supprimé(e) avec succès.";
        $typeMessage = "success";
    }
    //Action Delete Processing End
    $_SESSION['employe-action-message'] = $actionMessage;
    $_SESSION['employe-type-message'] = $typeMessage;
    //Redirect according to the source
    $redirectLink = 'Location:../employes-contrats.php';
    if( isset($_POST['source']) and $_POST['source'] == "projet-contrat-employe" ) {
        $idProjet = htmlentities($_POST['idProjet']);
        $redirectLink = 'Location:../projet-contrat-employe.php?idProjet='.$idProjet;    
    }
    header($redirectLink);


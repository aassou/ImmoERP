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
    $idProjet = htmlentities($_POST['idProjet']);
    //This var contains result message of CRUD action
    $actionMessage = "";
    $typeMessage = "";
    //Comonent Manager
    $contratEmployeManager = new ContratEmployeManager($pdo);
	//Action Add Processing Begin
    if($action == "add"){
        if( !empty($_POST['employe']) ){
			$dateContrat = htmlentities($_POST['dateContrat']);
            $dateFinContrat = htmlentities($_POST['dateFinContrat']);
            $nombreUnites = htmlentities($_POST['nombreUnites']);
            $prixUnitaire = htmlentities($_POST['prixUnitaire']);
            $unite = htmlentities($_POST['unite']);
            $nomUnite = htmlentities($_POST['nomUnite']);
            $nomUniteArabe = htmlentities($_POST['nomUniteArabe']);
            //if we want to set unite2 : begin
            $nombreUnites2 = htmlentities($_POST['nombreUnites2']);
            $prixUnitaire2 = htmlentities($_POST['prixUnitaire2']);
            $unite2 = htmlentities($_POST['unite2']);
            $nomUnite2 = htmlentities($_POST['nomUnite2']);
            $nomUniteArabe2 = htmlentities($_POST['nomUniteArabe']);
            //if we want to set unite2 : end
            $traveaux = htmlentities($_POST['traveaux']);
            $traveauxArabe = htmlentities($_POST['traveauxArabe']);
			$total = htmlentities($_POST['total']);
            $articlesArabes = htmlentities($_POST['articlesArabes']);
			$employe = htmlentities($_POST['employe']);
            $idSociete = htmlentities($_POST['idSociete']);
			$idProjet = htmlentities($_POST['idProjet']);
			$createdBy = $_SESSION['userMerlaTrav']->login();
            $created = date('Y-m-d h:i:s');
            //create object
            $contratEmploye = new ContratEmploye(array(
				'dateContrat' => $dateContrat,
				'dateFinContrat' => $dateFinContrat,
				'nombreUnites' => $nombreUnites,
				'prixUnitaire' => $prixUnitaire,
				'unite' => $unite,
				'nomUnite' => $nomUnite,
				'nomUniteArabe' => $nomUniteArabe,
				'nombreUnites2' => $nombreUnites2,
                'prixUnitaire2' => $prixUnitaire2,
                'unite2' => $unite2,
                'nomUnite2' => $nomUnite2,
                'nomUniteArabe2' => $nomUniteArabe2,
				'total' => $total,
				'traveaux' => $traveaux,
				'traveauxArabe' => $traveauxArabe,
				'articlesArabes' => $articlesArabes,
				'employe' => $employe,
				'idSociete' => $idSociete,
				'idProjet' => $idProjet,
				'created' => $created,
				'createdBy' => $createdBy
			));
            //add it to db
            $contratEmployeManager->add($contratEmploye);
            $actionMessage = "Opération Valide : ContratEmploye Ajouté(e) avec succès.";  
            $typeMessage = "success";
        }
        else{
            $actionMessage = "Erreur Ajout contratEmploye : Vous devez remplir le champ 'Employé'.";
            $typeMessage = "error";
        }
    }
    //Action Add Processing End
    //Action Update Processing Begin
    else if($action == "update"){
        $idContratEmploye = htmlentities($_POST['idContratEmploye']);
        if(!empty($_POST['employe'])){
            $dateContrat = htmlentities($_POST['dateContrat']);
            $dateFinContrat = htmlentities($_POST['dateFinContrat']);
            $nombreUnites = htmlentities($_POST['nombreUnites']);
            $prixUnitaire = htmlentities($_POST['prixUnitaire']);
            $unite = htmlentities($_POST['unite']);
            $nomUnite = htmlentities($_POST['nomUnite']);
            $nomUniteArabe = htmlentities($_POST['nomUniteArabe']);
            //if we want to set unite2 : begin
            $nombreUnites2 = htmlentities($_POST['nombreUnites2']);
            $prixUnitaire2 = htmlentities($_POST['prixUnitaire2']);
            $unite2 = htmlentities($_POST['unite2']);
            $nomUnite2 = htmlentities($_POST['nomUnite2']);
            $nomUniteArabe2 = htmlentities($_POST['nomUniteArabe2']);
            //if we want to set unite2 : end
            $traveaux = htmlentities($_POST['traveaux']);
            $traveauxArabe = htmlentities($_POST['traveauxArabe']);
            $articlesArabes = htmlentities($_POST['articlesArabes']);
            $total = ($nombreUnites * $prixUnitaire) + ($nombreUnites2 * $prixUnitaire2);//htmlentities($_POST['total']);
            $employe = htmlentities($_POST['employe']);
            $idSociete = htmlentities($_POST['idSociete']);
            //create object
            $contratEmploye = new ContratEmploye(array(
				'id' => $idContratEmploye,
				'dateContrat' => $dateContrat,
				'dateFinContrat' => $dateFinContrat,
				'nombreUnites' => $nombreUnites,
                'prixUnitaire' => $prixUnitaire,
                'unite' => $unite,
                'nomUnite' => $nomUnite,
                'nomUniteArabe' => $nomUniteArabe,
                'nombreUnites2' => $nombreUnites2,
                'prixUnitaire2' => $prixUnitaire2,
                'unite2' => $unite2,
                'nomUnite2' => $nomUnite2,
                'nomUniteArabe2' => $nomUniteArabe2,
				'total' => $total,
				'traveaux' => $traveaux,
                'traveauxArabe' => $traveauxArabe,
                'articlesArabes' => $articlesArabes,
				'employe' => $employe,
				'idSociete' => $idSociete,
				'idProjet' => $idProjet,
			));
            $contratEmployeManager->update($contratEmploye);
            $actionMessage = "Opération Valide : ContratEmploye Modifié(e) avec succès.";
            $typeMessage = "success";
        }
        else{
            $actionMessage = "Erreur Modification ContratEmploye : Vous devez remplir le champ 'Employé'.";
            $typeMessage = "error";
        }
    }
    //Action Update Processing End
    //Action Delete Processing Begin
    else if($action == "delete"){
        $idContratEmploye = htmlentities($_POST['idContratEmploye']);
        $contratEmployeManager->delete($idContratEmploye);
        $actionMessage = "Opération Valide : ContratEmploye supprimée avec succès.";
        $typeMessage = "success";
    }
    //Action Delete Processing End
    $_SESSION['contratEmploye-action-message'] = $actionMessage;
    $_SESSION['contratEmploye-type-message'] = $typeMessage;
    header('Location:../projet-contrat-employe.php?idProjet='.$idProjet);


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
    $param = $_GET['param'];
    $idEmploye = htmlentities($_POST['idEmploye']);
	$idProjet = htmlentities($_POST['idProjet']);
	if( !empty($_POST['nom'])){
		$nom = htmlentities($_POST['nom']);    
        $cin = htmlentities($_POST['cin']);
		$email = htmlentities($_POST['email']);
		$telephone = htmlentities($_POST['telephone']);
		$etatCivile = htmlentities($_POST['etatCivile']);
		$dateDebut = htmlentities($_POST['dateDebut']);
		$dateSortie = htmlentities($_POST['dateSortie']);
		$photo = htmlentities($_POST['photo']);
		if( !empty($_FILES['newPhoto']) and $_FILES['newPhoto']['error']==0 ){
			$photo = imageProcessing($_FILES['newPhoto'], '/photo_employes_societe/');	
		}
		$employe = new EmployeProjet(array('id' => $idEmploye, 'nom' => $nom, 'cin' => $cin, 'etatCivile' => $etatCivile,'telephone' => $telephone, 
        'photo' =>$photo, 'email' => $email, 'dateDebut' => $dateDebut, 'dateSortie' => $dateSortie));
        $employeManager = new EmployeProjetManager($pdo);
        $employeManager->update($employe);
		$_SESSION['employe-update-success'] = "<strong>Opération valide : </strong>Les informations de l'employé '".$nom."' sont modifiées avec succès.";
		$location = "employes-projet.php?idProjet=".$idProjet;
		if( $param==2 ){
			$location = "employe-projet-profile.php?idEmploye=".$idEmploye; 
		}
		header('Location:../'.$location);
	}
	else{
        $_SESSION['employe-update-error'] = "<strong>Erreur Modification Employé : </strong>Vous devez remplir au moins le champ 'Nom'.";
		$location = "employes-projet.php?idProjet=".$idProjet;
		if( $param==2 ){
			$location = "employe-societe-profile.php?idEmploye=".$idEmploye; 
		}
		header('Location:../'.$location);
		exit;
    }
	
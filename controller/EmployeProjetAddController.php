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
    $idProjet = htmlentities($_POST['idProjet']);
	if( !empty($_POST['nom'])){
		$employeManager = new EmployeProjetManager($pdo);
		$nom = htmlentities($_POST['nom']);    
		if( $employeManager->exists($nom) ){
			$_SESSION['employe-add-error'] = "<strong>Erreur Ajout Employé : </strong>Un employé existe déjà avec ce nom : ".$nom.".";
			header('Location:../employes-projet.php?idProjet='.$idProjet);
			exit;
		}
		else{
			$cin = htmlentities($_POST['cin']);
			$email = htmlentities($_POST['email']);
			$telephone = htmlentities($_POST['telephone']);
			$etatCivile = htmlentities($_POST['etatCivile']);
			$email = htmlentities($_POST['email']);
			$dateDebut = htmlentities($_POST['dateDebut']);
			$dateSortie = htmlentities($_POST['dateSortie']);
			$photo = imageProcessing($_FILES['photo'], '/photo_employes_societe/');
			$employe = new EmployeProjet(array('nom' => $nom, 'cin' => $cin, 'etatCivile' => $etatCivile,'telephone' => $telephone, 
	        'photo' =>$photo, 'email' => $email, 'dateDebut' => $dateDebut, 'dateSortie' => $dateSortie, 'idProjet' => $idProjet));
	        
	        $employeManager->add($employe);
			$_SESSION['employe-add-success'] = "<strong>Opération valide : </strong>L'employé '".$nom."' est ajouté au système avec succès.";
			header('Location:../employes-projet.php?idProjet='.$idProjet);	
		}
	}
	else{
        $_SESSION['employe-add-error'] = "<strong>Erreur Ajout Employé : </strong>Vous devez remplir au moins le champ 'Nom'.";
		header('Location:../employes-projet.php?idProjet='.$idProjet);
		exit;
    }
	
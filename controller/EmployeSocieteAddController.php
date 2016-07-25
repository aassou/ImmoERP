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
	if( !empty($_POST['nom'])){
		$employeManager = new EmployeSocieteManager($pdo);
		$nom = htmlentities($_POST['nom']);    
		if( $employeManager->exists($nom) ){
			$_SESSION['employe-add-error'] = "<strong>Erreur Ajout Employé : </strong>Un employé existe déjà avec ce nom : ".$nom.".";
			header('Location:../employes-societe.php');
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
			$employe = new EmployeSociete(array('nom' => $nom, 'cin' => $cin, 'etatCivile' => $etatCivile,'telephone' => $telephone, 
	        'photo' =>$photo, 'email' => $email, 'dateDebut' => $dateDebut, 'dateSortie' => $dateSortie));
	        
	        $employeManager->add($employe);
			$_SESSION['employe-add-success'] = "<strong>Opération valide : </strong>L'employé '".$nom."' est ajouté au système avec succès.";
			header('Location:../employes-societe.php');	
		}
	}
	else{
        $_SESSION['employe-add-error'] = "<strong>Erreur Ajout Employé : </strong>Vous devez remplir au moins le champ 'Nom'.";
		header('Location:../employes-societe.php');
		exit;
    }
	
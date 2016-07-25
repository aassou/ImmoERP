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
    $idEmploye = htmlentities($_POST['idEmploye']);
	if( !empty($_POST['salaire'])){
		$salaire = htmlentities($_POST['salaire']);    
        $nombreJours = htmlentities($_POST['nombreJours']);
		$dateOperation = htmlentities($_POST['dateOperation']);
		//create class
		$salaire = new EmployeProjetSalaire(array('salaire' => $salaire, 'nombreJours' => $nombreJours, 
		'dateOperation' => $dateOperation,'idEmploye' => $idEmploye ));
		//create class manager
        $salaireManager = new EmployeProjetSalaireManager($pdo);
        $salaireManager->add($salaire);
		$_SESSION['salaire-add-success'] = "<strong>Opération valide : </strong>Le salaire est ajouté avec succès.";
		header('Location:../employe-projet-profile.php?idEmploye='.$idEmploye);
	}
	else{
        $_SESSION['salaire-add-error'] = "<strong>Erreur Ajout Salaire : </strong>Vous devez remplir au moins le champ 'Salaire'.";
		header('Location:../employe-projet-profile.php?idEmploye='.$idEmploye);
		exit;
    }
	
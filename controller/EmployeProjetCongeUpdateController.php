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
	if( !empty($_POST['dateDebut']) and !empty($_POST['dateFin']) ){
		$idConge = htmlentities($_POST['idConge']);
		$dateDebut = htmlentities($_POST['dateDebut']);
		$dateFin = htmlentities($_POST['dateFin']);
		//create class
		$conge = new EmployeProjetConge(array('id' => $idConge, 'dateDebut' => $dateDebut, 'dateFin' => $dateFin ));
		//create class manager
        $congeManager = new EmployeProjetCongeManager($pdo);
        $congeManager->update($conge);
		$_SESSION['conge-update-success'] = "<strong>Opération valide : </strong>Les infos du congé sont modifiées avec succès.";
		header('Location:../employe-projet-profile.php?idEmploye='.$idEmploye);
	}
	else{
        $_SESSION['conge-update-error'] = "<strong>Erreur Modification Congé : </strong>Vous devez remplir tous les champs";
		header('Location:../employe-projet-profile.php?idEmploye='.$idEmploye);
		exit;
    }
	
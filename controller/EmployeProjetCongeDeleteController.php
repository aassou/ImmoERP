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
    //classes loading end
    session_start();
    
    //post input processing
	$idEmploye = $_POST['idEmploye'];   
	$idConge = $_POST['idConge'];  
    $congeManager = new EmployeProjetCongeManager($pdo);
	$congeManager->delete($idConge);
	$_SESSION['conge-delete-success'] = "<strong>Opération valide : </strong>Congé supprimé avec succès.";
	header('Location:../employe-projet-profile.php?idEmploye='.$idEmploye);
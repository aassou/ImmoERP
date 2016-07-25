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
    $employeManager = new EmployeSocieteManager($pdo);
	$employeManager->delete($idEmploye);
	$_SESSION['employe-delete-success'] = "<strong>Opération valide : </strong>Employé supprimé avec succès.";
	header('Location:../employes-societe.php');
    
    
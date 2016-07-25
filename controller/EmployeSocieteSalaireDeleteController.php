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
	$idSalaire = $_POST['idSalaire'];  
    $salaireManager = new EmployeSocieteSalaireManager($pdo);
	$salaireManager->delete($idSalaire);
	$_SESSION['salaire-delete-success'] = "<strong>Opération valide : </strong>Salaire supprimé avec succès.";
	header('Location:../employe-societe-profile.php?idEmploye='.$idEmploye);
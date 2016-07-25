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
	$idProjet = $_POST['idProjet'];
	$idContrat = $_POST['idContrat'];
    $contratTravailManager = new ContratTravailManager($pdo);
	$contratTravailManager->delete($idContrat);
	$_SESSION['contrat-delete-success']="<strong>تم حذف العقد بنجاح</strong>";
	header('Location:../contrats-travail.php?idProjet='.$idProjet);
    
    
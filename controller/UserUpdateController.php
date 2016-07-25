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
	$idUser = $_POST['idUser'];   
	$profil = $_POST['profil'];
    $userManager = new UserManager($pdo);
	$userManager->updateProfil($idUser, $profil);
	$_SESSION['user-update-success'] = "<strong>Opération valide</strong> : Profil Utlisateur est modifié avec succès.";
	header('Location:../users.php');
    
    
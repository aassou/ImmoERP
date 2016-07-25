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
    $userManager = new UserManager($pdo);
	$userManager->delete($idUser);
	$_SESSION['user-delete-success'] = "<strong>Opération valide</strong> : Utlisateur supprimé avec succès.";
	header('Location:../users.php');
    
    
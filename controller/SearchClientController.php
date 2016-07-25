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
    if(!empty($_POST['searchOption']) and !empty($_POST['search'])){
		$testRadio = 0;	    
		if(isset($_POST['searchOption'])){
			if($_POST['searchOption']=="searchByName"){
				$testRadio = 1;	
			}
			else if($_POST['searchOption']=="searchByCIN"){
				$testRadio = 2;	
			}
		}
		$recherche = htmlentities($_POST['search']);
		$clientManager = new ClientManager($pdo);
		$_SESSION['searchClientResult'] = $clientManager->getClientBySearch($recherche, $testRadio);
		header('Location:../clients-search.php');
    }
    else{
        $_SESSION['client-search-error'] = 
        "<strong>Erreur Recherche Client</strong> : Vous devez séléctionner un choix 'Nom' ou 'CIN' 
        et 'Tapez votre recherche'";
		header('Location:../clients-search.php');
    }
    
    
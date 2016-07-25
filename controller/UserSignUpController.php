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
include("../config.php");
//classes loading end
session_start();

$redirectLink='../signup.php';

if(empty($_POST['login']) || empty($_POST['password']) || empty($_POST['rpassword'])){
    $_SESSION['signup-error'] = "<strong>Erreur Inscription</strong> : Tous les champs sont obligatoires";
}
else{
    $userManager = new UserManager($pdo);
    if($userManager->exists2($login)){
        $_SESSION['signup-error'] = "<strong>Erreur Inscription</strong> : Ce login existe déjà.";
    }
	else{
		$login = htmlspecialchars($_POST['login']);
    	$password = htmlspecialchars($_POST['password']);
		$rpassword = htmlentities($_POST['rpassword']);
		if($password==$rpassword){
			$user = new User(array('login'=>$login, 'password'=>$password, 'created'=>date('Y-m-d'), 'profil'=>'user', 'status'=>0));
			$userManager->add($user);
			$_SESSION['signup-success'] = "<strong>Inscription Validée</strong> : Votre demande est ajoutée avec succès.";	
		}
		else{
			$_SESSION['signup-error'] = "<strong>Erreur Inscription</strong> : Les mots de passe doivent être identiques.";
		}
	}
}
header('Location:'.$redirectLink);
exit;
?>
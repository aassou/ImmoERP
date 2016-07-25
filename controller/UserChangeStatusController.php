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

$redirectLink='../users.php';
$idUser = $_GET['idUser'];
$userManager = new UserManager($pdo);
$status = $userManager->getStatusById($idUser);
if ( $status == 0 ) {
	$userManager->changeStatus(1, $idUser);
}
else {
	$userManager->changeStatus(0, $idUser);
}
$_SESSION['user-status-success'] = "<strong>Opération valide</strong> : Status Utilisateur est changé avec succès.";
header('Location:'.$redirectLink);
exit;
?>
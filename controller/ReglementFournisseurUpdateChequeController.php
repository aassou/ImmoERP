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
	$idFournisseur = htmlentities($_POST['idFournisseur']);
    if( !empty($_POST['numeroCheque']) ){
        $idReglement = htmlentities($_POST['idReglement']);
        $numeroCheque = htmlentities($_POST['numeroCheque']);
        $reglementFournisseurManager = new ReglementFournisseurManager($pdo);
        $reglementFournisseurManager->updateNumeroCheque($numeroCheque, $idReglement);
    }
    header('Location:../fournisseurs-reglements.php?idFournisseur='.$idFournisseur.'#listFournisseurs');
    
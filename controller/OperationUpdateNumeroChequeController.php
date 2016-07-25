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
	$idContrat = $_POST['idContrat'];
	$idProjet = $_POST['idProjet'];
	$idOperation = $_POST['idOperation'];
    if( !empty($_POST['numeroCheque'])){    
        $numeroCheque = htmlentities($_POST['numeroCheque']);
        $operationsManager = new OperationManager($pdo);
        $operationsManager->updateNumeroCheque($numeroCheque, $idOperation);
        $_SESSION['operation-update-success']="<strong>Opération valide : </strong>Numéro de chèque modifiée avec succès.";
        header('Location:../operations.php?idContrat='.$idContrat.'&idProjet='.$idProjet);
    }
    else{
        $_SESSION['operation-update-error'] = "<strong>Erreur modification opération : </strong>Vous devez remplir le champ 'Numéro de chèque'.";
        header('Location:../operations.php?idContrat='.$idContrat.'&idProjet='.$idProjet);
    }
    
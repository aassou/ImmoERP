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
	$idLocaux = $_POST['idLocaux'];
	$idPieceLocaux = $_POST['idPieceLocaux'];   
    $piecesLocauxManager = new PiecesLocauxManager($pdo);
	$piecesLocauxManager->delete($idPieceLocaux);
	//delete file from the disk
	$_SESSION['pieces-delete-success'] = "<strong>Opération valide : </strong>Pièce supprimé avec succès.";
	header('Location:../locaux-detail.php?idLocaux='.$idLocaux.'&idProjet='.$idProjet);
    
    
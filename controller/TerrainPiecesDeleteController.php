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
	$idPieceTerrain = $_POST['idPieceTerrain'];   
    $piecesTerrainManager = new PiecesTerrainManager($pdo);
	$piecesTerrainManager->delete($idPieceTerrain);
	//delete file from the disk
	$_SESSION['pieces-delete-success'] = "<strong>Opération valide : </strong>Pièce supprimé avec succès.";
	header('Location:../terrain.php?idProjet='.$idProjet.'#listTerrain');
    
    
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
	$idTerrain = $_POST['idTerrain'];   
    $terrainManager = new TerrainManager($pdo);
	$terrainManager->delete($idTerrain);
	$_SESSION['terrain-delete-success'] = "<strong>Opération valide : </strong>Terrain supprimé avec succès.";
	header('Location:../terrain.php?idProjet='.$idProjet.'#listTerrain');
    
    
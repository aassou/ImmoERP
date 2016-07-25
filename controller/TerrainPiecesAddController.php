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
	include('../lib/image-processing.php');
    //classes loading end
    session_start();
	
	$idProjet = htmlentities($_POST['idProjet']);
	$idTerrain = htmlentities($_POST['idTerrain']);
	if(file_exists($_FILES['url']['tmp_name']) || is_uploaded_file($_FILES['url']['tmp_name'])) {
		$url = imageProcessing($_FILES['url'], '/pieces/pieces_terrain/');
		$nom = htmlentities($_POST['nom']);
		$pieceTerrain = new PiecesTerrain(array('nom'=>$nom, 'url'=>$url, 'idTerrain'=>$idTerrain));
		$pieceTerrainManager = new PiecesTerrainManager($pdo);
		$pieceTerrainManager->add($pieceTerrain);
		$_SESSION['pieces-add-success'] = "<strong>Opération valide : </strong>La pièce a été ajouté avec succès.";
		header('Location:../terrain.php?idProjet='.$idProjet.'#listTerrain');
	}
	else{
		$_SESSION['pieces-add-error'] = "<strong>Erreur Ajout Pièces Terrain : </strong>Vous devez ajouté un lien.";
		header('Location:../terrain.php?idProjet='.$idProjet.'#listTerrain');
	}

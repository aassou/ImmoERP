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
    if( !empty($_POST['vendeur'])){
        $vendeur = htmlentities($_POST['vendeur']);    
        $emplacement = htmlentities($_POST['emplacement']);
        $superficie = 0;
        $prix = 0;
		$fraisAchat = 0;
        if(filter_var($_POST['superficie'], FILTER_VALIDATE_FLOAT)==true){
            $superficie = htmlentities($_POST['superficie']);
        }
        else {
            $_SESSION['terrain-update-error']="<strong>Erreur Modification Terrain</strong> : La valeur du champ 'Superficie' est incorrecte !";
            header('Location:../terrain.php?idProjet='.$idProjet.'#listTerrain');
            exit;
        }
        if(filter_var($_POST['prix'], FILTER_VALIDATE_FLOAT)==true){
            $prix = htmlentities($_POST['prix']);
        }
        else {
            $_SESSION['terrain-update-error']="<strong>Erreur Modification Terrain</strong> : La valeur du champ 'Prix' est incorrecte !";
            header('Location:../terrain.php?idProjet='.$idProjet.'#listTerrain');
            exit;
        }
		if(filter_var($_POST['fraisAchat'], FILTER_VALIDATE_FLOAT)==true){
            $fraisAchat = htmlentities($_POST['fraisAchat']);
        }
        else {
            $_SESSION['terrain-update-error']="<strong>Erreur Modification Terrain</strong> : La valeur du champ 'Fais d'achat' est incorrecte !";
            header('Location:../terrain.php?idProjet='.$idProjet.'#listTerrain');
            exit;
        }
        
        $terrain = new Terrain(array('id' => $idTerrain, 'vendeur' => $vendeur, 'prix' => $prix,'superficie' => $superficie, 
        'fraisAchat' =>$fraisAchat, 'emplacement' => $emplacement));
        $terrainManager = new TerrainManager($pdo);
        $terrainManager->update($terrain);
        $_SESSION['terrain-update-success']="<strong>Opération valide : </strong>Le terrain est modifié avec succès !";
    }
    else{
        $_SESSION['terrain-update-error'] = "<strong>Erreur Modification Terrain : </strong>Vous devez remplir au moins le champ 'Vendeur'.";
    }
	header('Location:../terrain.php?idProjet='.$idProjet.'#listTerrain');
    
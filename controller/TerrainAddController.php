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
            $_SESSION['terrain-add-error']="<strong>Erreur Ajout Terrain</strong> : La valeur du champ 'Superficie' est incorrecte !";
            header('Location:../terrain.php?idProjet='.$idProjet);
            exit;
        }
        if(filter_var($_POST['prix'], FILTER_VALIDATE_FLOAT)==true){
            $prix = htmlentities($_POST['prix']);
        }
        else {
            $_SESSION['terrain-add-error']="<strong>Erreur Ajout Terrain</strong> : La valeur du champ 'Prix' est incorrecte !";
            header('Location:../terrain.php?idProjet='.$idProjet);
            exit;
        }
		if(filter_var($_POST['fraisAchat'], FILTER_VALIDATE_FLOAT)==true){
            $fraisAchat = htmlentities($_POST['fraisAchat']);
        }
        else {
            $_SESSION['terrain-add-error']="<strong>Erreur Ajout Terrain</strong> : La valeur du champ 'Fais d'achat' est incorrecte !";
            header('Location:../terrain.php?idProjet='.$idProjet);
            exit;
        }
        $createdBy = $_SESSION['userMerlaTrav']->login();
        $created = date('Y-m-d h:i:s');
        $terrain = new Terrain(array('vendeur' => $vendeur, 'prix' => $prix,'superficie' => $superficie, 
        'fraisAchat' =>$fraisAchat, 'emplacement' => $emplacement, 'idProjet' => $idProjet, 
        'created' => $created, 'createdBy' => $createdBy));
        $terrainManager = new TerrainManager($pdo);
        $terrainManager->add($terrain);
        $_SESSION['terrain-add-success']="<strong>Opération valide : </strong>Le terrain est ajouté avec succès !";
    }
    else{
        $_SESSION['terrain-add-error'] = "<strong>Erreur Ajout Terrain : </strong>Vous devez remplir au moins le champ 'Vendeur'.";
    }
	header('Location:../terrain.php?idProjet='.$idProjet);
    
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
	$idLivraison = $_POST['idLivraison'];
	$idPieceLivraison = $_POST['idPieceLivraison'];   
    $livraisonPiecesManager = new LivraisonPiecesManager($pdo);
	$livraisonPiecesManager->delete($idPieceLivraison);
	//delete file from the disk
	$_SESSION['piece-delete-success'] = "<strong>Opération valide : </strong>Pièce supprimée avec succès.";
	header('Location:../livraison-pieces.php?idProjet='.$idProjet.'&idLivraison='.$idLivraison);
    
    
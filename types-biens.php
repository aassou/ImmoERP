<?php
include('config.php');  
if(isset($_POST['typeBien'])){
	$typeBien = htmlentities($_POST['typeBien']);
	$idProjet = htmlentities($_POST['idProjet']);
	if($typeBien=="appartement"){
		$requete = 
		"SELECT * FROM t_appartement WHERE idProjet=".$idProjet." AND (status = 'Disponible' OR status = 'R&eacute;serv&eacute;') ORDER BY niveau, nom";	
	}
	else if($typeBien=="localCommercial"){
		$requete = 
		"SELECT * FROM t_locaux WHERE idProjet=".$idProjet." AND (status = 'Disponible' OR status = 'R&eacute;serv&eacute;') ORDER BY nom";
	}
	
	// connexion à la base de données
    try{
        $bdd = $pdo;
    } 
	catch(Exception $e){
        exit('Impossible de se connecter à la base de données.');
    }
    // exécution de la requête
    $resultat = $bdd->query($requete) or die(print_r($bdd->errorInfo()));
     
    // résultats: if typeBien is appartement show niveau (etage)
    if($typeBien=="appartement"){
        while($donnees = $resultat->fetch(PDO::FETCH_ASSOC)) {
    		$res = 
    		'<option value="'.$donnees['id'].'">'.$donnees['niveau'].'e- '
    		.$donnees['nom'].
    		'- '.number_format($donnees['prix'], 2, ',', ' ').'DH - '.$donnees['par'].'</option>';
    		echo $res;
    	}
    }
    // résultats: if typeBien is localCommercial there is no niveau to show (etage)
    else{
        while($donnees = $resultat->fetch(PDO::FETCH_ASSOC)) {
            $res = 
            '<option value="'.$donnees['id'].'">'
            .$donnees['nom'].
            ' - '.number_format($donnees['prix'], 2, ',', ' ').'DH - '.$donnees['par'].'</option>';
            echo $res;
        }
    }
}
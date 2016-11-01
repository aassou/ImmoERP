<?php
    require('../app/classLoad.php');    
    require('../db/PDOFactory.php');;  
    //process begin
    if ( isset($_POST['idProjet']) ) {
        //load classes managers
        $clientManager = new ClientManager(PDOFactory::getMysqlConnection());
        $contratManager = new ContratManager(PDOFactory::getMysqlConnection());
        $projetManager = new ProjetManager(PDOFactory::getMysqlConnection());
        $appartementManager = new AppartementManager(PDOFactory::getMysqlConnection());
        $locauxManager = new LocauxManager(PDOFactory::getMysqlConnection());
        //begin processing
        $idProjet = htmlentities($_POST['idProjet']);
        $requete = "SELECT * FROM t_contrat WHERE idProjet = '".$idProjet."' AND status='actif'";
        $projet = $projetManager->getProjetById($idProjet);
        // connexion à la base de données
        //try{
            //$bdd = new PDO('mysql:host=localhost;dbname=maroccar', 'root', '');
        //} 
        //catch(Exception $e){
            //exit('Impossible de se connecter à la base de données.');
        //}
        // exécution de la requête
        $resultat = PDOFactory::getMysqlConnection()->query($requete) or die(print_r($bdd->errorInfo()));
         
        // résultats
        $res = '<option value="">Vous pouvez séléctionnez un contrat</option>';
        echo $res;
        while ( $contrat = $resultat->fetch(PDO::FETCH_ASSOC)) {
            $client = $clientManager->getClientById($contrat['idClient']);
            $typeBien = "";
            $bien = "";
            $etage  = "";
            if ( $contrat['typeBien'] == "appartement" ) {
                $typeBien = "Appartement";
                $bien = $appartementManager->getAppartementById($contrat['idBien']);
                $etage = "Etage : ".$bien->niveau();
            }
            else {
                $typeBien = "Local.Com";
                $bien = $locauxManager->getLocauxById($contrat['idBien']);
            }
            $res = '<option value="'.$contrat['id'].'">'.$client->nom().' - '.$projet->nom().' - '.$typeBien.' : '.$bien->nom().' - '.$etage.'</option>';
            echo $res;
        }
    }
?>
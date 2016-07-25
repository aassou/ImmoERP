<?php
//classes loading begin
    function classLoad ($myClass) {
        if(file_exists('model/'.$myClass.'.php')){
            include('model/'.$myClass.'.php');
        }
        elseif(file_exists('controller/'.$myClass.'.php')){
            include('controller/'.$myClass.'.php');
        }
    }
    spl_autoload_register("classLoad"); 
    include('config.php');  
    //process begin
    if ( isset($_POST['idProjet']) ) {
        //load classes managers
        $clientManager = new ClientManager($pdo);
        $contratManager = new ContratManager($pdo);
        $projetManager = new ProjetManager($pdo);
        $appartementManager = new AppartementManager($pdo);
        $locauxManager = new LocauxManager($pdo);
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
        $resultat = $pdo->query($requete) or die(print_r($bdd->errorInfo()));
         
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
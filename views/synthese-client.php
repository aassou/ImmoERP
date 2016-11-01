<?php
    require('../app/classLoad.php');
    require('../db/PDOFactory.php');;  
    //process begin
    if ( isset($_POST['idContrat']) ) {
        //load classes managers
        $clientManager = new ClientManager(PDOFactory::getMysqlConnection());
        $contratManager = new ContratManager(PDOFactory::getMysqlConnection());
        $projetManager = new ProjetManager(PDOFactory::getMysqlConnection());
        $appartementManager = new AppartementManager(PDOFactory::getMysqlConnection());
        $locauxManager = new LocauxManager(PDOFactory::getMysqlConnection());
        $operationManager = new OperationManager(PDOFactory::getMysqlConnection());
        //begin processing
        $idContrat = htmlentities($_POST['idContrat']);
        $requete = "SELECT * FROM t_operation WHERE idContrat = '".$idContrat."'";
        //$projet = $projetManager->getProjetById($idProjet);
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
        while ( $operation = $resultat->fetch(PDO::FETCH_ASSOC)) {
            $status = "Non Validé";
            $classStatus = "input-error-text";
            if ( $operation['status'] != 0 ) {
                $status = "Validé";
                $classStatus = "input-success-text";
            }
            //$res = '<div class="alert alert-'.$colorStatus.'">DateOpe: '.$operation['date'].' - DateRég: '.$operation['dateReglement'].' - Compte: '.$operation['compteBancaire'].' - Montant: '.$operation['montant'].'DH - Chèque: '.$operation['numeroCheque'].'</div>';
            //$res = '<div class="alert alert-'.$colorStatus.'">DateOpe: '.$operation['date'].' - DateRég: '.$operation['dateReglement'].' - Compte: '.$operation['compteBancaire'].' - Montant: '.$operation['montant'].'DH - Chèque: '.$operation['numeroCheque'].'</div>';
            $res = '<div class="controls controls-row">'.
                        '<input disabled="disabled" class="span2 m-wrap '.$classStatus.'" type="text" value="'.date('d/m/y', strtotime($operation['date'])).'" />'.
                        '<input disabled="disabled" class="span2 m-wrap '.$classStatus.'" type="text" value="'.date('d/m/y' , strtotime($operation['dateReglement'])).'" />'.
                        '<input disabled="disabled" class="span4 m-wrap '.$classStatus.'" type="text" value="'.number_format($operation['montant'], 2, ',', ' ').'" />'.
                        '<input disabled="disabled" class="span2 m-wrap '.$classStatus.'" type="text" value="'.$operation['compteBancaire'].'" />'.
                        '<input disabled="disabled" class="span2 m-wrap '.$classStatus.'" type="text" value="'.$operation['numeroCheque'].'" />'.
                    '</div>';
            echo $res;
        }
    }
?>
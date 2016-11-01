<?php
    require('../app/classLoad.php');
    require('../db/PDOFactory.php');  
    include('../lib/image-processing.php');
    include('../lib/ForeignExchange.php');
    //classes loading end
    session_start();
    
    //post input processing
    $action = htmlentities($_POST['action']);
    //In this session variable we put all the POST, to get it in the contrats-add file
    //in case of error, and this help the user to do not put again what he filled out.
    $_SESSION['operation-data-form'] = $_POST;
    //This var contains result message of CRUD action
    $actionMessage = "";
    $typeMessage = "";
    $redirectLink = "";
    //process begins
    //The History Component is used in all ActionControllers to mention a historical version of each action
    $historyManager = new HistoryManager(PDOFactory::getMysqlConnection());
    $operationManager = new OperationManager(PDOFactory::getMysqlConnection());
    $projetManager = new ProjetManager(PDOFactory::getMysqlConnection());
    $clientManager = new ClientManager(PDOFactory::getMysqlConnection());
    
    //Action Add Process Begins
    if( $action == "add" ) {
        if( !empty($_POST['montant']) and !empty($_POST['numeroOperation']) ) {
            $reference = 'Q'.date('Ymd-his');
            $currency = $_POST['currency'];
            if ( $currency == "DH" ) {
                $montant = htmlentities($_POST['montant']);    
                $observation = htmlentities($_POST['observation']);
            }
            else {
                //$fx = new ForeignExchange('EUR', 'MAD');
                //$montant = $fx->toForeign(htmlentities($_POST['montant']));
                $montant = $_POST['montant'] * $_POST['tauxDeChange'];
                $observation = htmlentities($_POST['observation']).' - (Payé En Euro)';
            }
            //$montant = htmlentities($_POST['montant']);
            $modePaiement = htmlentities($_POST['modePaiement']);
            $numeroOperation = htmlentities($_POST['numeroOperation']);
            $dateOperation = htmlentities($_POST['dateOperation']);
            $dateReglement = htmlentities($_POST['dateReglement']);
            $compteBancaire = htmlentities($_POST['compteBancaire']);
            $status = 0;
            $idContrat = htmlentities($_POST['idContrat']);
            $createdBy = $_SESSION['userImmoERPV2']->login();
            $created = date('Y-m-d h:i:s');
            $url = "";
            if(file_exists($_FILES['urlCheque']['tmp_name']) || is_uploaded_file($_FILES['urlCheque']['tmp_name'])) {
                $url = imageProcessing($_FILES['urlCheque'], '/pieces/pieces_reglements/');
            }
            $operation = 
            new Operation(array('date' => $dateOperation, 'dateReglement' => $dateReglement, 'status' => $status,
            'montant' => $montant, 'compteBancaire' => $compteBancaire, 'observation' => $observation, 'reference' => $reference,
            'modePaiement'=>$modePaiement, 'idContrat' => $idContrat, 'numeroCheque' => $numeroOperation, 'url' => $url,  
            'createdBy' => $createdBy, 'created' => $created));
            $operationManager->add($operation);
            //add History data
            $history = new History(array(
                'action' => "Ajout",
                'target' => "Table des paiements clients ",
                'description' => "Ajout d'un paiement client, pour le contrat : ".$idContrat.", montant : ".$montant,
                'created' => $created,
                'createdBy' => $createdBy
            ));
            //add it to db
            $historyManager->add($history);
            $actionMessage = "<strong>Opération Valide</strong> : Paiement Ajouté avec succès.";
            $typeMessage = "success";
        }
        else{
            $actionMessage = "<strong>Erreur Ajout Paiement Client</strong> : Vous devez remplir les champs <strong>Montant</strong> et <strong>Numéro Opération</strong>.";
            $typeMessage = "error";
        }
    }
    //Action Add Process Ends
    
    //Action UpdatePiece Process Begins
    else if ($action == "updatePiece") {
        $codeContrat = htmlentities($_POST['codeContrat']);
        $url = "";
        $idOperation = htmlentities($_POST['idOperation']);
        if(file_exists($_FILES['urlPiece']['tmp_name']) || is_uploaded_file($_FILES['urlPiece']['tmp_name'])) {
            $url = imageProcessing($_FILES['urlPiece'], '/pieces/pieces_reglements/');
            $operationManager = new OperationManager(PDOFactory::getMysqlConnection());
            $operationManager->updatePiece($idOperation, $url);
            $actionMessage = "<strong>Opération valide : </strong>La pièce de réglement est modifiée avec succès.";
            $typeMessage = "success";
            //add history data to db
            $historyManager = new HistoryManager(PDOFactory::getMysqlConnection());
            $createdBy = $_SESSION['userImmoERPV2']->login();
            $created = date('Y-m-d h:i:s');
            $history = new History(array(
                'action' => "Modification Pièce réglement",
                'target' => "Table des réglements clients",
                'description' => "Modification de la pièce de régelement - Opération : ".$idOperation,
                'created' => $created,
                'createdBy' => $createdBy
            ));
            //add it to db
            $historyManager->add($history);
        }
        else{
            $actionMessage = "<strong>Erreur Modification Pièce de réglement : </strong>Vous devez séléctionner un fichier.";
            $typeMessage = "error";
        }
    }
    //Action UpdatePiece Process Ends
    
    //Action Update Process Begins 
    else if($action == "update"){
        if( !empty($_POST['montant']) and !empty($_POST['numeroOperation']) ) {
            $idOperation = htmlentities($_POST['idOperation']);
            $dateOperation = htmlentities($_POST['dateOperation']);
            $dateReglement = htmlentities($_POST['dateReglement']);
            $compteBancaire = htmlentities($_POST['compteBancaire']);
            $observation = htmlentities($_POST['observation']);
            $montant = htmlentities($_POST['montant']);
            $modePaiement = htmlentities($_POST['modePaiement']);
            $numeroOperation = htmlentities($_POST['numeroOperation']);
            $updatedBy = $_SESSION['userImmoERPV2']->login();
            $updated = date('Y-m-d h:i:s');
            $operation = 
            new Operation(array('id' => $idOperation, 'date' => $dateOperation,
            'dateReglement' => $dateReglement, 'compteBancaire' => $compteBancaire, 
            'observation' => $observation, 'montant' => $montant, 'numeroCheque' => $numeroOperation, 
            'modePaiement' => $modePaiement, 'updatedBy' => $updatedBy, 'updated' => $updated));
            $operationManager->update($operation);
            //add History data
            $createdBy = $_SESSION['userImmoERPV2']->login();
            $created = date('Y-m-d h:i:s');
            $history = new History(array(
                'action' => "Modification",
                'target' => "Table des paiements clients",
                'description' => "Modification du paiement client, montant : ".$montant,
                'created' => $created,
                'createdBy' => $createdBy
            ));
            //add it to db
            $historyManager->add($history);
            $actionMessage = "<strong>Opération Valide</strong> : Paiement Client Modifié avec succès.";
            $typeMessage = "success";
        }
        else{
            $actionMessage = "<strong>Erreur Modification Paiement Client</strong> : Vous devez remplir les champs <strong>Montant</strong> et <strong>Numéro Opération</strong>.";
            $typeMessage = "error";
        }
    }
    //Action Update Process Ends
    
    //Action Validate Process Begins
    else if($action=="validate"){
        $idOperation = $_POST['idOperation'];
        $operationManager->validate($idOperation, 1);
        //add History data
        $createdBy = $_SESSION['userImmoERPV2']->login();
        $created = date('Y-m-d h:i:s');
        $history = new History(array(
            'action' => "Validation",
            'target' => "Table des paiements clients",
            'description' => "Validation de paiement client",
            'created' => $created,
            'createdBy' => $createdBy
        ));
        //add it to db
        $historyManager->add($history);
        $actionMessage = "<strong>Opération Valide</strong> : Paiement client validé avec succès.";
        $typeMessage = "success";
    }
    //Action Validate Process Ends
    
    //Action Cancel Process Begins
    else if($action=="cancel"){
        $idOperation = $_POST['idOperation'];
        $operationManager->cancel($idOperation, 0);
        //add History data
        $createdBy = $_SESSION['userImmoERPV2']->login();
        $created = date('Y-m-d h:i:s');
        $history = new History(array(
            'action' => "Annulation",
            'target' => "Table des paiements clients",
            'description' => "Annulation de paiement client",
            'created' => $created,
            'createdBy' => $createdBy
        ));
        //add it to db
        $historyManager->add($history);
        $actionMessage = "<strong>Opération Valide</strong> : Paiement client annulé avec succès.";
        $typeMessage = "success";
    }
    //Action Cancel Process Ends
    
    //Action Hide Process Begins
    else if($action=="hide"){
        $idOperation = $_POST['idOperation'];
        $operationManager->hide($idOperation, 2);
        //add History data
        $createdBy = $_SESSION['userImmoERPV2']->login();
        $created = date('Y-m-d h:i:s');
        $history = new History(array(
            'action' => "Retirage",
            'target' => "Table des paiements clients",
            'description' => "Retirage de paiement client de la page des états des paiements",
            'created' => $created,
            'createdBy' => $createdBy
        ));
        //add it to db
        $historyManager->add($history);
        $actionMessage = "<strong>Opération Valide</strong> : Paiement retiré  avec succès.";
        $typeMessage = "success";
    }
    //Action Hide Process Ends
    
    //Action Delete Process Begins
    else if($action=="delete"){
        $idOperation = $_POST['idOperation'];
        $operationManager->delete($idOperation);
        //add History data
        $createdBy = $_SESSION['userImmoERPV2']->login();
        $created = date('Y-m-d h:i:s');
        $history = new History(array(
            'action' => "Suppression",
            'target' => "Table des paiements clients",
            'description' => "Suppression de paiement client",
            'created' => $created,
            'createdBy' => $createdBy
        ));
        //add it to db
        $historyManager->add($history);
        $actionMessage = "<strong>Opération Valide</strong> : Paiement Client Supprimé avec succès.";
        $typeMessage = "success";
    }
    //Action Hide Process Ends
    
    //define the redirection url based on the source page
    if ( isset($_POST['source']) and $_POST['source'] == "contrat" ) {
        $codeContrat = htmlentities($_POST['codeContrat']);
        $idProjet = htmlentities($_POST['idProjet']);
        $redirectLink = "Location:../views/contrat.php?codeContrat=".$codeContrat."&idProjet=".$idProjet."#detailsReglements";   
    }
    else if ( isset($_POST['source']) and $_POST['source'] == "operations-status" ) {
        $mois = $_POST['mois'];
        $annee = $_POST['annee'];
        $redirectLink = "Location:../views/operations-status.php?mois=".$mois."&annee=".$annee;
        if ($action == "hide") {
            $redirectLink = "Location:../views/operations-status-group.php";
        } 
    }
    else if ( isset($_POST['source']) and $_POST['source'] == "operations-status-group" ) {
        $redirectLink = "Location:../views/operations-status-group.php";
    }
    else if ( isset($_POST['source']) and $_POST['source'] == "contrats-list" ) {
        $idProjet = htmlentities($_POST['idProjet']);
        $redirectLink = "Location:../views/contrats-list.php?idProjet=".$idProjet;
    }
    else if ( isset($_POST['source']) and $_POST['source'] == "clients-search" ) {
    	$redirectLink = "Location:../views/clients-search.php";
    }
    
    //set session informations
    $_SESSION['operation-action-message'] = $actionMessage;
    $_SESSION['operation-type-message'] = $typeMessage;
    
    //set redirection link
    header($redirectLink);
    
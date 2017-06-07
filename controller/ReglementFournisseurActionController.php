<?php
    require('../app/classLoad.php');  
    require('../db/PDOFactory.php');  
    include('../lib/image-processing.php');
    //classes loading end
    session_start();
    
    //post input processing
    $action    = htmlentities($_POST['action']);
    $companyID = htmlentities($_POST['companyID']);
    //In this session variable we put all the POST, to get it in the contrats-add file
    //in case of error, and this help the user to do not put again what he filled out.
    $_SESSION['reglement-data-form'] = $_POST;
    //This var contains result message of CRUD action
    $actionMessage = "";
    $typeMessage   = "";
    $redirectLink  = "";
    //process begins
    //The History Component is used in all ActionControllers to mention a historical version of each action
    $historyManager     = new HistoryManager(PDOFactory::getMysqlConnection());
    $reglementManager   = new ReglementFournisseurManager(PDOFactory::getMysqlConnection());
    $fournisseurManager = new FournisseurManager(PDOFactory::getMysqlConnection());
    
    //Action Add Process Begin
    if( $action == "add" ) {
        if( !empty($_POST['montant']) ) {
            $idFournisseur = htmlentities($_POST['idFournisseur']);
            $idProjet = htmlentities($_POST['idProjet']);
            $companyID = htmlentities($_POST['companyID']);
            $dateReglement = htmlentities($_POST['dateReglement']);
            $montant = htmlentities($_POST['montant']);
            $modePaiement = htmlentities($_POST['modePaiement']);
            $numeroOperation = htmlentities($_POST['numeroCheque']);
            $createdBy = $_SESSION['userImmoERPV2']->login();
            $created = date('Y-m-d h:i:s');
            $reglement = 
            new ReglementFournisseur(array('idFournisseur' => $idFournisseur, 'idProjet' => $idProjet, 
            'companyID' => $companyID, 'dateReglement' => $dateReglement, 'montant' => $montant,   
            'modePaiement' => $modePaiement, 'numeroCheque' => $numeroOperation, 
            'createdBy' => $createdBy, 'created' => $created));
            $reglementManager->add($reglement);
            //add History data
            $nomFournisseur = $fournisseurManager->getFournisseurById($idFournisseur)->nom();
            $history = new History(array(
                'action' => "Ajout",
                'target' => "Table des réglements fournisseurs Annahda",
                'description' => "Ajout du réglement, montant : ".$montant.", fournisseur : ".$nomFournisseur." - Société : Annahda",
                'created' => $created,
                'createdBy' => $createdBy
            ));
            //add it to db
            $historyManager->add($history);
            $actionMessage = "<strong>Opération Valide</strong> : Réglement Ajouté avec succès.";
            $typeMessage = "success";
        }
        else{
            $actionMessage = "<strong>Erreur Ajout Réglement</strong> : Vous devez remplir le champ <strong>Montant</strong>.";
            $typeMessage = "error";
        }
        //in this line we specify the response url based on the source of our request
        $redirectLink = "";
        if( isset($_POST['source']) ) {
            if( $_POST['source'] == 'livraisons-group' ) {
                $redirectLink = "Location:../views/livraisons-group.php?companyID=$companyID";   
            }
            else if( $_POST['source'] == 'livraisons-fournisseur-mois' ) {
                $idFournisseur = htmlentities($_POST['idFournisseur']);
                $redirectLink = "Location:../views/livraisons-fournisseur-mois.php?idFournisseur=$idFournisseur&companyID=$companyID";   
            }
            else if ( $_POST['source'] == "livraisons-fournisseur-mois-list" ) {
                $idFournisseur = htmlentities($_POST['idFournisseur']);
                $mois = htmlentities($_POST['mois']);
                $annee = htmlentities($_POST['annee']);
                $redirectLink = "Location:../views/livraisons-fournisseur-mois-list.php?idFournisseur=$idFournisseur&mois=$mois&annee=$annee&companyID=$companyID";
            }
            else if( $_POST['source'] == 'reglements-fournisseur' ) {
                $idFournisseur = htmlentities($_POST['idFournisseur']);
                $redirectLink = "Location:../views/reglements-fournisseur.php?idFournisseur=$idFournisseur&companyID=$companyID";   
            }   
        }
    }
    //Action Add Process End
    
    //Action Update Process Begin
    else if($action == "update"){
        $idReglement = htmlentities($_POST['idReglement']);
        $idFournisseur = htmlentities($_POST['idFournisseur']);
        if( !empty($_POST['montant']) ) {
            $idProjet = htmlentities($_POST['idProjet']);
            $dateReglement = htmlentities($_POST['dateReglement']);
            $montant = htmlentities($_POST['montant']);
            $modePaiement = htmlentities($_POST['modePaiement']);
            $numeroOperation = htmlentities($_POST['numeroCheque']);
            $updatedBy = $_SESSION['userImmoERPV2']->login();
            $updated = date('Y-m-d h:i:s');
            $reglement = 
            new ReglementFournisseur(array('id' => $idReglement, 'idFournisseur' => $idFournisseur, 
            'idProjet' => $idProjet, 'dateReglement' => $dateReglement, 'montant' => $montant,   
            'modePaiement' => $modePaiement, 'numeroCheque' => $numeroOperation, 
            'updatedBy' => $updatedBy, 'updated' => $updated));
            $reglementManager->update($reglement);
            //add History data
            $nomFournisseur = $fournisseurManager->getFournisseurById($idFournisseur)->nom();
            $createdBy = $_SESSION['userImmoERPV2']->login();
            $created = date('Y-m-d h:i:s');
            $history = new History(array(
                'action' => "Modification",
                'target' => "Table des réglements fournisseurs Annahda",
                'description' => "Modification du réglement, montant : ".$montant.", fournisseur : ".$nomFournisseur." - Société : Annahda",
                'created' => $created,
                'createdBy' => $createdBy
            ));
            //add it to db
            $historyManager->add($history);
            $actionMessage = "<strong>Opération Valide</strong> : Réglement Modifié avec succès.";
            $typeMessage = "success";
        }
        else{
            $actionMessage = "<strong>Erreur Modification Réglement</strong> : Vous devez remplir les champs <strong>Montant</strong>.";
            $typeMessage = "error";
        }
        $redirectLink = "Location:../views/reglements-fournisseur.php?idFournisseur=$idFournisseur&companyID=$companyID";
    }
    //Action Update Process Ends
    
    //Action Delete Process Begins
    else if($action=="delete"){
        $idReglement = $_POST['idReglement'];
        $idFournisseur = $_POST['idFournisseur'];
        $reglement = $reglementManager->getReglementFournisseurById($idReglement);
        $nomFournisseur = $fournisseurManager->getFournisseurById($reglement->idFournisseur())->nom();
        $reglementManager->delete($idReglement);
        //add History data
        $createdBy = $_SESSION['userImmoERPV2']->login();
        $created = date('Y-m-d h:i:s');
        $history = new History(array(
            'action' => "Suppression",
            'target' => "Table des réglements fournisseurs Annahda",
            'description' => "Suppression du réglement, montant : ".$reglement->montant().", fournisseur : ".$nomFournisseur." - Société : Annahda",
            'created' => $created,
            'createdBy' => $createdBy
        ));
        //add it to db
        $historyManager->add($history);
        $actionMessage = "<strong>Opération Valide</strong> : Réglement Supprimé avec succès.";
        $typeMessage = "success";
        $redirectLink = "Location:../views/reglements-fournisseur.php?idFournisseur=$idFournisseur&companyID=$companyID";
    }
    //Action Delete Process Ends
    
    //set session informations
    $_SESSION['reglement-action-message'] = $actionMessage;
    $_SESSION['reglement-type-message'] = $typeMessage;
    
    //set redirection link 
    header($redirectLink);
    
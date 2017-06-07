<?php
    require('../app/classLoad.php');
    require('../db/PDOFactory.php');  
    include('../lib/image-processing.php');
    //classes loading end
    session_start();
    
    //post input processing
    $action    = htmlentities($_POST['action']);
    $companyID = htmlentities($_POST['companyID']);
    //This var contains result message of CRUD action
    $actionMessage = "";
    $typeMessage   = "";
    $redirectLink  = "";
    
    //process begins
    
    //class managers
    //The History Component is used in all ActionControllers to mention a historical version of each action
    $historyManager     = new HistoryManager(PDOFactory::getMysqlConnection());
    $livraisonManager   = new LivraisonManager(PDOFactory::getMysqlConnection());
    $fournisseurManager = new FournisseurManager(PDOFactory::getMysqlConnection());
    $projetManager      = new ProjetManager(PDOFactory::getMysqlConnection());
    
    //objs and vars
    $idFournisseur = htmlentities($_POST['idFournisseur']);
    
    //Action Add Process Begins
    if($action == "add"){
        if( !empty($_POST['libelle']) and !empty($_POST['dateLivraison']) ){
            $idProjet = htmlentities($_POST['idProjet']);
            $libelle = htmlentities($_POST['libelle']);
            $designation = htmlentities($_POST['designation']);
            $dateLivraison = htmlentities($_POST['dateLivraison']);
            $codeLivraison = uniqid().date('YmdHis');
            $createdBy = $_SESSION['userImmoERPV2']->login();
            $created = date('Y-m-d h:i:s');
            //these next data are used to know the month and the year of a supply demand
            $mois = date('m', strtotime($dateLivraison));
            $annee = date('Y', strtotime($dateLivraison));
            //create object
            $livraison = 
            new Livraison(array('dateLivraison' => $dateLivraison, 'libelle' => $libelle,
            'designation' => $designation, 'idProjet' => $idProjet, 'idFournisseur' => $idFournisseur, 
            'code' => $codeLivraison, 'companyID' => $companyID, 'createdBy' => $createdBy, 'created' => $created));
            //add it to db
            $livraisonManager->add($livraison);
            //add history data to db
            $nomFournisseur = $fournisseurManager->getFournisseurById($idFournisseur)->nom();
            $nomProjet = $projetManager->getProjetById($idProjet)->nom();
            $history = new History(array(
                'action' => "Ajout",
                'target' => "Table des livraisons",
                'description' => "Ajout de la livraison, libelle : ".$libelle.", fournisseur : ".$nomFournisseur." - Projet : ".$nomProjet." - "."Société : Annahda",
                'created' => $created,
                'createdBy' => $createdBy
            ));
            //add it to db
            $historyManager->add($history);
            $actionMessage = "<strong>Opération Valide</strong> : Livraison Ajoutée avec succès.";  
            $typeMessage = "success";
            $redirectLink = "Location:../views/livraisons-details.php?codeLivraison=$codeLivraison&mois=$mois&annee=$annee&companyID=$companyID";
        }
        else{
            $actionMessage = "<strong>Erreur Ajout Livraison</strong> : Vous devez remplir le champ <strong>N° BL</strong>.";
            $typeMessage = "error";
            //test the source of this request for the reason of exact redirection
            if ( isset($_POST['source']) and $_POST['source'] == "livraisons-group" ) {
                $redirectLink = "Location:../views/livraisons-group.php?companyID=$companyID";    
            }
            else if ( isset($_POST['source']) and $_POST['source'] == "livraisons-fournisseur-mois" ) {
                $redirectLink = "Location:../views/livraisons-fournisseur-mois.php?idFournisseur=$idFournisseur&companyID=$companyID";    
            }
            else if ( isset($_POST['source']) and $_POST['source'] == "livraisons-fournisseur-mois-list" ) {
                $mois = htmlentities($_POST['mois']);
                $annee = htmlentities($_POST['annee']);
                $redirectLink = "Location:../views/livraisons-fournisseur-mois-list.php?idFournisseur=$idFournisseur&mois=$mois&annee=$annee&companyID=.$companyID";    
            }
        }
    }
    //Action Add Process Ends
    
    //Action Update Process Begins
    else if($action == "update"){
        $mois = htmlentities($_POST['mois']);
        $annee = htmlentities($_POST['annee']);
        if(!empty($_POST['libelle'])){
            $idProjet = htmlentities($_POST['idProjet']);
            $id = htmlentities($_POST['idLivraison']);
            $libelle = htmlentities($_POST['libelle']);
            $designation = htmlentities($_POST['designation']);
            $dateLivraison = htmlentities($_POST['dateLivraison']);
            $updatedBy = $_SESSION['userImmoERPV2']->login();
            $updated = date('Y-m-d h:i:s');
            //these next data are used to know the month and the year of a supply demand
            $mois = date('m', strtotime($dateLivraison));
            $annee = date('Y', strtotime($dateLivraison));
            $livraison = 
            new Livraison(array('id' => $id, 'dateLivraison' => $dateLivraison, 'libelle' => $libelle,
            'designation' => $designation, 'idProjet' => $idProjet, 'idFournisseur' => $idFournisseur, 
            'companyID' => $companyID, 'updatedBy' => $updatedBy, 'updated' => $updated));
            $livraisonManager->update($livraison);
            //add history data to db
            $nomFournisseur = $fournisseurManager->getFournisseurById($idFournisseur)->nom();
            $nomProjet = $projetManager->getProjetById($idProjet)->nom();
            $createdBy = $_SESSION['userImmoERPV2']->login();
            $created = date('Y-m-d h:i:s');
            $history = new History(array(
                'action' => "Modification",
                'target' => "Table des livraisons",
                'description' => "Modification de la livraison, libelle : ".$libelle.", fournisseur : ".$nomFournisseur." - Projet : ".$nomProjet." - "."Société : Annahda",
                'created' => $created,
                'createdBy' => $createdBy
            ));
            //add it to db
            $historyManager->add($history);
            $actionMessage = "<strong>Opération Valide</strong> : Livraison Modifiée avec succès.";
            $typeMessage = "success";
        }
        else{
            $actionMessage = "<strong>Erreur Modification Livraison</strong> : Vous devez remplir le champ <strong>N° BL</strong>.";
            $typeMessage = "error";
        }
        
        $redirectLink = "Location:../views/livraisons-fournisseur-mois-list.php?idFournisseur=".$idFournisseur."&mois=".$mois."&annee=".$annee."&companyID=".$companyID;
        //this case treat the updated request comming from livraisons-details.php page,
        //not livraisons-fournisseur.php page
        if( isset($_POST['source']) and $_POST['source']=="details-livraison" ){
            $codeLivraison = $_POST['codeLivraison'];
            $redirectLink = "Location:../views/livraisons-details.php?codeLivraison=".$codeLivraison."&mois=".$mois."&annee=".$annee."&companyID=".$companyID;
        }
    }
    //Action Update Process Ends
    
    //Action UpdateStatus Process Begins
    else if($action == "updateStatus"){
        $mois = htmlentities($_POST['mois']);
        $annee = htmlentities($_POST['annee']);
        $status = htmlentities($_POST['status']);
        if ( !empty($_POST['bl']) ) {
            foreach ( $_POST['bl'] as $bl ) {
                $livraisonManager->updateStatus($bl, $status);       
            }
        }
        //add history data to db
        $createdBy = $_SESSION['userImmoERPV2']->login();
        $created = date('Y-m-d h:i:s');
        $history = new History(array(
            'action' => "Modification",
            'target' => "Table des livraisons",
            'description' => "Modification du status de la livraison, idLivraison : ".$idLivraison,
            'created' => $created,
            'createdBy' => $createdBy
        ));
        //add it to db
        $historyManager->add($history);
        $actionMessage = "<strong>Opération Valide</strong> : Livraison Status Modifiée avec succès.";
        $typeMessage = "success";
        $redirectLink = "Location:../views/livraisons-fournisseur-mois-list.php?idFournisseur=".$idFournisseur."&mois=".$mois."&annee=".$annee."&companyID=".$companyID;
        
    }
    //Action UpdateStatus Process Ends
    
    //Action Delete Process Begins
    else if($action=="delete"){
        $livraisonDetailManager = new LivraisonDetailManager(PDOFactory::getMysqlConnection());
        $idLivraison = $_POST['idLivraison'];
        $mois = htmlentities($_POST['mois']);
        $annee = htmlentities($_POST['annee']);
        $livraisonManager->delete($idLivraison);
        //add history data to db
        $createdBy = $_SESSION['userImmoERPV2']->login();
        $created = date('Y-m-d h:i:s');
        $history = new History(array(
            'action' => "Suppression",
            'target' => "Table des livraisons, Table détails livraisons",
            'description' => "Suppression de la livraison ".$idLivraison." ainsi que ses détails"." - Société : Annahda",
            'created' => $created,
            'createdBy' => $createdBy
        ));
        //add it to db
        $historyManager->add($history);
        //After we delete our Livraison record from the database, we should remove all LivraisonDetails
        //records that corresponds to the idLivraison
        $livraisonDetailManager->deleteLivraison($idLivraison);
        $actionMessage = "<strong>Opération Valide</strong> : Livraison Supprimée avec succès.";
        $typeMessage = "success";
        $redirectLink = "Location:../views/livraisons-fournisseur-mois-list.php?idFournisseur=".$idFournisseur."&mois=".$mois."&annee=".$annee."&companyID=".$companyID;
        
    }
    
    //set session informations
    $_SESSION['livraison-action-message'] = $actionMessage;
    $_SESSION['livraison-type-message'] = $typeMessage;
    
    //set redirection link
    header($redirectLink);
    
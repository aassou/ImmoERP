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
    include('../lib/image-processing.php');
    //classes loading end
    session_start();
    
    //post input processing
    $action = htmlentities($_POST['action']);
    //In this session variable we put all the POST, to get it in the contrats-add file
    //in case of error, and this help the user to do not put again what he filled out.
    $_SESSION['livraison-data-form'] = $_POST;
    //This var contains result message of CRUD action
    $actionMessage = "";
    $typeMessage = "";
    $redirectLink = "";
    //process begins
    //The History Component is used in all ActionControllers to mention a historical version of each action
    $historyManager = new HistoryManager($pdo);
    $livraisonManager = new LivraisonManager($pdo);
    $fournisseurManager = new FournisseurManager($pdo);
    $projetManager = new ProjetManager($pdo);
    $idFournisseur = htmlentities($_POST['idFournisseur']);
    if($action == "add"){
        if( !empty($_POST['libelle']) and !empty($_POST['dateLivraison']) ){
            $idProjet = htmlentities($_POST['idProjet']);
            $libelle = htmlentities($_POST['libelle']);
            $designation = htmlentities($_POST['designation']);
            $dateLivraison = htmlentities($_POST['dateLivraison']);
            $codeLivraison = uniqid().date('YmdHis');
            $createdBy = $_SESSION['userMerlaTrav']->login();
            $created = date('Y-m-d h:i:s');
            //these next data are used to know the month and the year of a supply demand
            $mois = date('m', strtotime($dateLivraison));
            $annee = date('Y', strtotime($dateLivraison));
            //create object
            $livraison = 
            new Livraison(array('dateLivraison' => $dateLivraison, 'libelle' => $libelle,
            'designation' => $designation, 'idProjet' => $idProjet, 'idFournisseur' => $idFournisseur, 
            'code' => $codeLivraison, 'createdBy' => $createdBy, 'created' => $created));
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
            $redirectLink = "Location:../livraisons-details.php?codeLivraison=".$codeLivraison."&mois=".$mois."&annee=".$annee;
        }
        else{
            $actionMessage = "<strong>Erreur Ajout Livraison</strong> : Vous devez remplir le champ <strong>N° BL</strong>.";
            $typeMessage = "error";
            //test the source of this request for the reason of exact redirection
            if ( isset($_POST['source']) and $_POST['source'] == "livraisons-group" ) {
                $redirectLink = "Location:../livraisons-group.php";    
            }
            else if ( isset($_POST['source']) and $_POST['source'] == "livraisons-fournisseur-mois" ) {
                $redirectLink = "Location:../livraisons-fournisseur-mois.php?idFournisseur=".$idFournisseur;    
            }
            else if ( isset($_POST['source']) and $_POST['source'] == "livraisons-fournisseur-mois-list" ) {
                $mois = htmlentities($_POST['mois']);
                $annee = htmlentities($_POST['annee']);
                $redirectLink = "Location:../livraisons-fournisseur-mois-list.php?idFournisseur=".$idFournisseur."&mois=".$mois."&annee=".$annee;    
            }
        }
    }
    else if($action == "update"){
        $mois = htmlentities($_POST['mois']);
        $annee = htmlentities($_POST['annee']);
        if(!empty($_POST['libelle'])){
            $idProjet = htmlentities($_POST['idProjet']);
            $id = htmlentities($_POST['idLivraison']);
            $libelle = htmlentities($_POST['libelle']);
            $designation = htmlentities($_POST['designation']);
            $dateLivraison = htmlentities($_POST['dateLivraison']);
            $updatedBy = $_SESSION['userMerlaTrav']->login();
            $updated = date('Y-m-d h:i:s');
            //these next data are used to know the month and the year of a supply demand
            $mois = date('m', strtotime($dateLivraison));
            $annee = date('Y', strtotime($dateLivraison));
            $livraison = 
            new Livraison(array('id' => $id, 'dateLivraison' => $dateLivraison, 'libelle' => $libelle,
            'designation' => $designation, 'idProjet' => $idProjet, 'idFournisseur' => $idFournisseur, 
            'updatedBy' => $updatedBy, 'updated' => $updated));
            $livraisonManager->update($livraison);
            //add history data to db
            $nomFournisseur = $fournisseurManager->getFournisseurById($idFournisseur)->nom();
            $nomProjet = $projetManager->getProjetById($idProjet)->nom();
            $createdBy = $_SESSION['userMerlaTrav']->login();
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
        //$redirectLink = "Location:../livraisons-fournisseur.php?idFournisseur=".$idFournisseur;
        $redirectLink = "Location:../livraisons-fournisseur-mois-list.php?idFournisseur=".$idFournisseur."&mois=".$mois."&annee=".$annee;
        //this case treat the updated request comming from livraisons-details.php page,
        //not livraisons-fournisseur.php page
        if( isset($_POST['source']) and $_POST['source']=="details-livraison" ){
            $codeLivraison = $_POST['codeLivraison'];
            $redirectLink = "Location:../livraisons-details.php?codeLivraison=".$codeLivraison."&mois=".$mois."&annee=".$annee;
        }
    }
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
        $createdBy = $_SESSION['userMerlaTrav']->login();
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
        $redirectLink = "Location:../livraisons-fournisseur-mois-list.php?idFournisseur=".$idFournisseur."&mois=".$mois."&annee=".$annee;
        
    }
    else if($action=="delete"){
        $livraisonDetailManager = new LivraisonDetailManager($pdo);
        $idLivraison = $_POST['idLivraison'];
        $mois = htmlentities($_POST['mois']);
        $annee = htmlentities($_POST['annee']);
        $livraisonManager->delete($idLivraison);
        //add history data to db
        $createdBy = $_SESSION['userMerlaTrav']->login();
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
        $redirectLink = "Location:../livraisons-fournisseur-mois-list.php?idFournisseur=".$idFournisseur."&mois=".$mois."&annee=".$annee;
        
    }
    
    $_SESSION['livraison-action-message'] = $actionMessage;
    $_SESSION['livraison-type-message'] = $typeMessage;
    header($redirectLink);
    
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
    $_SESSION['reglement-data-form'] = $_POST;
    //This var contains result message of CRUD action
    $actionMessage = "";
    $typeMessage = "";
    $redirectLink = "";
    //process begins
    //The History Component is used in all ActionControllers to mention a historical version of each action
    $historyManager = new HistoryManager($pdo);
    $reglementManager = new ReglementFournisseurManager($pdo);
    $fournisseurManager = new FournisseurManager($pdo);
    if( $action == "add" ) {
        if( !empty($_POST['montant']) ) {
            $idFournisseur = htmlentities($_POST['idFournisseur']);
            $idProjet = htmlentities($_POST['idProjet']);
            $dateReglement = htmlentities($_POST['dateReglement']);
            $montant = htmlentities($_POST['montant']);
            $modePaiement = htmlentities($_POST['modePaiement']);
            $numeroOperation = htmlentities($_POST['numeroCheque']);
            $createdBy = $_SESSION['userMerlaTrav']->login();
            $created = date('Y-m-d h:i:s');
            $reglement = 
            new ReglementFournisseur(array('idFournisseur' => $idFournisseur, 'idProjet' => $idProjet, 
            'dateReglement' => $dateReglement, 'montant' => $montant,   
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
        //in this line we specify the response url basing on the source of our request
        $redirectLink = "";
        if( isset($_POST['source']) ) {
            if( $_POST['source'] == 'livraisons-group' ) {
                $redirectLink = "Location:../livraisons-group.php";   
            }
            else if( $_POST['source'] == 'livraisons-fournisseur-mois' ) {
                $idFournisseur = htmlentities($_POST['idFournisseur']);
                $redirectLink = "Location:../livraisons-fournisseur-mois.php?idFournisseur=".$idFournisseur;   
            }
            else if ( $_POST['source'] == "livraisons-fournisseur-mois-list" ) {
                $idFournisseur = htmlentities($_POST['idFournisseur']);
                $mois = htmlentities($_POST['mois']);
                $annee = htmlentities($_POST['annee']);
                $redirectLink = "Location:../livraisons-fournisseur-mois.php?idFournisseur=".$idFournisseur."&mois=".$mois."&annee=".$annee;
            }
            else if( $_POST['source'] == 'reglements-fournisseur' ) {
                $idFournisseur = htmlentities($_POST['idFournisseur']);
                $redirectLink = "Location:../reglements-fournisseur.php?idFournisseur=".$idFournisseur;   
            }   
        }
    }
    else if($action == "update"){
        $idReglement = htmlentities($_POST['idReglement']);
        $idFournisseur = htmlentities($_POST['idFournisseur']);
        if( !empty($_POST['montant']) ) {
            $idProjet = htmlentities($_POST['idProjet']);
            $dateReglement = htmlentities($_POST['dateReglement']);
            $montant = htmlentities($_POST['montant']);
            $modePaiement = htmlentities($_POST['modePaiement']);
            $numeroOperation = htmlentities($_POST['numeroCheque']);
            $updatedBy = $_SESSION['userMerlaTrav']->login();
            $updated = date('Y-m-d h:i:s');
            $reglement = 
            new ReglementFournisseur(array('id' => $idReglement, 'idFournisseur' => $idFournisseur, 
            'idProjet' => $idProjet, 'dateReglement' => $dateReglement, 'montant' => $montant,   
            'modePaiement' => $modePaiement, 'numeroCheque' => $numeroOperation, 
            'updatedBy' => $updatedBy, 'updated' => $updated));
            $reglementManager->update($reglement);
            //add History data
            $nomFournisseur = $fournisseurManager->getFournisseurById($idFournisseur)->nom();
            $createdBy = $_SESSION['userMerlaTrav']->login();
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
        $redirectLink = "Location:../reglements-fournisseur.php?idFournisseur=".$idFournisseur;
    }
    else if($action=="delete"){
        $idReglement = $_POST['idReglement'];
        $idFournisseur = $_POST['idFournisseur'];
        $reglement = $reglementManager->getReglementFournisseurById($idReglement);
        $nomFournisseur = $fournisseurManager->getFournisseurById($reglement->idFournisseur())->nom();
        $reglementManager->delete($idReglement);
        //add History data
        $createdBy = $_SESSION['userMerlaTrav']->login();
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
        $redirectLink = "Location:../reglements-fournisseur.php?idFournisseur=".$idFournisseur;
    }
    
    $_SESSION['reglement-action-message'] = $actionMessage;
    $_SESSION['reglement-type-message'] = $typeMessage;
    header($redirectLink);
    
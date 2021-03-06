<?php
    require('../app/classLoad.php');
    require('../db/PDOFactory.php');  
    include('../lib/image-processing.php');
    
    session_start();
    
    //post input processing
    $action = htmlentities($_POST['action']);
    $companyID = htmlentities($_POST['companyID']);
    //In this session variable we put all the POST, to get it in the contrats-add file
    //in case of error, and this help the user to do not put again what he filled out.
    $_SESSION['livraison-detail-data-form'] = $_POST;
    //This var contains result message of CRUD action
    $actionMessage = "";
    $typeMessage = "";
    $redirectLink = "";
    //process begins
    //The History Component is used in all ActionControllers to mention a historical version of each action
    //$historyManager = new HistoryManager(PDOFactory::getMysqlConnection());
    $livraisonDetailManager = new LivraisonDetailManager(PDOFactory::getMysqlConnection());
    $codeLivraison = htmlentities($_POST['codeLivraison']);
    $mois = htmlentities($_POST['mois']);
    $annee = htmlentities($_POST['annee']);
    
    //Action Add Processing Begin
    if($action == "add"){
        if( 
            !empty($_POST['prixUnitaire']) and 
            !empty($_POST['quantite']) and
            filter_var($_POST['prixUnitaire'], FILTER_VALIDATE_FLOAT) and
            filter_var($_POST['quantite'], FILTER_VALIDATE_FLOAT) 
          ){
            $designation = htmlentities($_POST['designation']);
            $quantite = htmlentities($_POST['quantite']);
            $prixUnitaire = htmlentities($_POST['prixUnitaire']);
            $idLivraison = htmlentities($_POST['idLivraison']);
            $createdBy = $_SESSION['userImmoERPV2']->login();
            $created = date('Y-m-d h:i:s');
            //create object
            $livraisonDetail = 
            new LivraisonDetail(array('prixUnitaire' => $prixUnitaire, 'quantite' => $quantite,
            'designation' => $designation, 'idLivraison' => $idLivraison, 'createdBy' => $createdBy, 'created' => $created));
            //add it to db
            $livraisonDetailManager->add($livraisonDetail);
            $actionMessage = "<strong>Opération Valide</strong> : Article Ajouté avec succès.";  
            $typeMessage = "success";
            $redirectLink = "Location:../views/livraisons-details.php?codeLivraison=$codeLivraison&mois=$mois&annee=$annee&companyID=$companyID";
        }
        else{
            $actionMessage = "<strong>Erreur Ajout Article</strong> : Vous devez vérifier les champs <strong>Prix unitaire</strong> et <strong>Quantité</strong>.";
            $typeMessage = "error";
            $redirectLink = "Location:../views/livraisons-details.php?codeLivraison=$codeLivraison&mois=$mois&annee=$annee&companyID=$companyID";
        }
    }
    //Action Add Processing End
    
    //Action Update Processing Begin
    else if($action == "update"){
        if( !empty($_POST['prixUnitaire']) and 
            !empty($_POST['quantite']) and 
            filter_var($_POST['prixUnitaire'], FILTER_VALIDATE_FLOAT) and
            filter_var($_POST['quantite'], FILTER_VALIDATE_FLOAT) 
        ){
            $idLivraisonDetail = htmlentities($_POST['idLivraisonDetail']);
            $designation = htmlentities($_POST['designation']);
            $quantite = htmlentities($_POST['quantite']);
            $prixUnitaire = htmlentities($_POST['prixUnitaire']);
            $updatedBy = $_SESSION['userImmoERPV2']->login();
            $updated = date('Y-m-d h:i:s');
            $livraisonDetail = 
            new LivraisonDetail(array('id' => $idLivraisonDetail, 'designation' => $designation,
            'prixUnitaire' => $prixUnitaire, 'quantite' => $quantite, 'updatedBy' => $updatedBy,
            'updated' => $updated));
            $livraisonDetailManager->update($livraisonDetail);
            $actionMessage = "<strong>Opération Valide</strong> : Article Modifié avec succès.";
            $typeMessage = "success";
        }
        else{
            $actionMessage = "<strong>Erreur Modification Article</strong> : Vous devez vérifier les champs <strong>Prix unitaire</strong> et <strong>Quantité</strong>.";
            $typeMessage = "error";
        }
        $redirectLink = "Location:../views/livraisons-details.php?codeLivraison=$codeLivraison&mois=$mois&annee=$annee&companyID=$companyID";
    }
    //Action Update Processing End
    
    //Action Delete Processing Begin
    else if($action=="delete"){
        $idLivraisonDetail = htmlentities($_POST['idLivraisonDetail']);
        $livraisonDetailManager->delete($idLivraisonDetail);
        $actionMessage = "<strong>Opération Valide</strong> : Article Supprimé avec succès.";
        $typeMessage = "success";
        $redirectLink = "Location:../livraisons-details.php?codeLivraison=$codeLivraison&mois=$mois&annee=$annee&companyID=$companyID";
    }
    //Action Delete Processing End
    
    //set session informations
    $_SESSION['livraison-detail-action-message'] = $actionMessage;
    $_SESSION['livraison-detail-type-message'] = $typeMessage;
    
    //set redirection link
    header($redirectLink);
    
<?php
/**
 * This is a Model class for the Contract Component
 * 
 * Created By : AASSOU Abdelilah
 * Date       : 03/11/2015
 * Github     : aassou
 * Twitter    : @a_aassou
 * email      : aassou.abdelilah@gmail.com
 * Description: This controller is used to create a new contract based on the customer data
 *              received form the clients-add.php url.
 */
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
    //the action input precise which action the controller is going to prossed, 
    //add action, update action or delete action
    $action = htmlentities($_POST['action']);
    $idProjet = htmlentities($_POST['idProjet']);
    //In this session variable we put all the POST, to get it in the contrats-add file
    //In case of error, and this help the user to do not put again what he filled out.
    $_SESSION['contrat-form-data'] = $_POST;
    //If we get to this current ContratActionController through ClientActionController,
    //which means, that the client data are valid, so we need to destroy the session
    //"myFormData", that stores the client data form inputs 
    if( isset($_SESSION['myFormData']) ){
        unset($_SESSION['myFormData']);
    } 
    //This var contains result message of CRUD action and the redirection url link
    $actionMessage = "";
    $typeMessage = "";
    $redirectLink = "";
    //class manager
    $clientManager = new ClientManager($pdo);
    $contratManager = new ContratManager($pdo);
    $contratCasLibreManager = new ContratCasLibreManager($pdo);
    $reglementPrevuManager = new ReglementPrevuManager($pdo);
    $projetManager = new ProjetManager($pdo);
    //The History Component is used in all ActionControllers to mention a historical version of each action
    $historyManager = new HistoryManager($pdo);
    //process starts
    $nomProjet = $projetManager->getProjetById($idProjet)->nom();
    //Action Add Processing Begin
    if($action == "add"){
        $codeClient = $_POST['codeClient'];
        //post input validation
        if( !empty($_POST['typeBien']) and !empty($_POST['prixNegocie']) and !empty($_POST['numero'])
         and !empty($_POST['bien']) and !empty($_POST['dateCreation']) and !empty($_POST['avance'])
         and !empty($_POST['modePaiement']) and !empty($_POST['dureePaiement']) and !empty($_POST['nombreMois'])
         and !empty($_POST['echeance']) ){
            if( !empty($_POST['prixNegocie']) ){
                $reference = 'C'.date('Ymd-his');
                $prixNegocie = htmlentities($_POST['prixNegocie']);
                $prixNegocieArabe = htmlentities($_POST['prixNegocieArabe']);
                $numero = htmlentities($_POST['numero']);
                $typeBien = htmlentities($_POST['typeBien']);
                $idBien = htmlentities($_POST['bien']);
                $dateCreation = htmlentities($_POST['dateCreation']);
                $avance = htmlentities($_POST['avance']);
                $avanceArabe = htmlentities($_POST['avanceArabe']);
                $modePaiement = htmlentities($_POST['modePaiement']);
                $dureePaiement = htmlentities($_POST['dureePaiement']);
                $nombreMois = htmlentities($_POST['nombreMois']);
                $echeance = htmlentities($_POST['echeance']);
                $idClient = htmlentities($_POST['idClient']);
                $codeContrat = uniqid().date('YmdHis');
                $societeArabe = htmlentities($_POST['societeArabe']);
                $etatBienArabe = htmlentities($_POST['etatBienArabe']);
                $facadeArabe = htmlentities($_POST['facadeArabe']);
                $articlesArabes = htmlentities($_POST['articlesArabes']);
                $created = date('Y-m-d h:i:s');
                $createdBy = $_SESSION['userMerlaTrav']->login();
                $numeroCheque = '0';
                if( isset($_POST['numeroCheque']) ){
                    $numeroCheque = htmlentities($_POST['numeroCheque']);
                }
                //SET NOTE-CLIENT SECTION BEGIN
                $note = "";
                $noteImage = "";
                if ( isset($_POST['show-note-client']) ) {
                    $note = htmlentities($_POST['note']);
                    if(file_exists($_FILES['note-client-image']['tmp_name']) || is_uploaded_file($_FILES['note-client-image']['tmp_name'])) {
                        $noteImage = imageProcessing($_FILES['note-client-image'], '/pieces/pieces_notes_clients/');
                    }
                }
                //SET NOTE-CLIENT SECTION END
                //set the datePrevu for our object end
                //CAS LIBRE PROCESSING BEGIN
                if ( isset($_POST['show-cas-libre']) ) {
                    $dates = array();
                    $montants = array();
                    $observations = array();
                    for ( $i=1; $i<11; $i++ ) {
                        if ( 
                            ( isset($_POST['cas-libre-date'.$i]) and !empty($_POST['cas-libre-date'.$i]) ) 
                            and isset($_POST['cas-libre-montant'.$i]) and !empty($_POST['cas-libre-montant'.$i]) ) {
                            $dates[$i] = htmlentities($_POST['cas-libre-date'.$i]);
                            $montants[$i] = htmlentities($_POST['cas-libre-montant'.$i]);
                            if ( isset($_POST['cas-libre-observation'.$i]) ) {
                                $observations[$i] = htmlentities($_POST['cas-libre-observation'.$i]);   
                            }   
                            $contratCasLibreManager->add(
                                new ContratCasLibre(
                                    array(
                                        'date' => $dates[$i], 
                                        'montant' => $montants[$i], 
                                        'observation' => $observations[$i],
                                        'status' => 0,
                                        'codeContrat' => $codeContrat,
                                        'created' => $created,
                                        'createdBy' => $createdBy
                                    )
                                )
                            );
                        }
                        /*if ( isset($_POST['cas-libre-montant'.$i]) ) {
                            $montants[$i] = htmlentities($_POST['cas-libre-montant'.$i]);   
                        }
                        if ( isset($_POST['cas-libre-observation'.$i]) ) {
                            $observations[$i] = htmlentities($_POST['cas-libre-observation'.$i]);   
                        }*/
                    } 
                }
                else {
                    //set the datePrevu for our object begin
                    $condition = ceil( floatval($dureePaiement)/floatval($nombreMois) );
                    for ( $i=1; $i <= $condition; $i++ ) {
                        $monthsNumber = "+".$nombreMois*$i." months";
                        $datePrevu = date('Y-m-d', strtotime($monthsNumber, strtotime($dateCreation)));
                        $reglementPrevuManager->add(
                            new ReglementPrevu(
                                array(
                                    'datePrevu' => $datePrevu,
                                    'codeContrat' => $codeContrat,
                                    'status' => 0,
                                    'created' => $created,
                                    'createdBy' =>$createdBy
                                )
                            )
                        );
                    }
                }
                //else we have to put here our datePrevu processing
                //CAS LIBRE PROCESSING END
                //create the contract object
                $contrat = 
                new Contrat(
                array('reference' => $reference, 'numero' => $numero, 'dateCreation' => $dateCreation, 
                'prixVente' => $prixNegocie, 'prixVenteArabe' => $prixNegocieArabe, 'avance' => $avance, 
                'avanceArabe' => $avanceArabe, 'modePaiement' => $modePaiement, 'dureePaiement' => $dureePaiement, 
                'nombreMois' => $nombreMois, 'echeance' => $echeance, 'note' => $note, 'imageNote' => $noteImage, 'idClient' => $idClient, 
                'idProjet' => $idProjet, 'idBien' => $idBien, 'typeBien' => $typeBien, 'code' => $codeContrat, 
                'numeroCheque' => $numeroCheque, 'societeArabe' => $societeArabe, 'etatBienArabe' => $etatBienArabe ,
                'facadeArabe' => $facadeArabe, 'articlesArabes' => $articlesArabes, 'created' => $created, 'createdBy' => $createdBy));
                //adding the contract object to our database
                $contratManager->add($contrat);
                //add history data to db
                $nomClient = $clientManager->getClientById($idClient)->nom();
                $history = new History(array(
                    'action' => "Ajout",
                    'target' => "Table des contrats",
                    'description' => "Ajout du contrat numéro : ".$numero.", client : ".$nomClient.", ".$typeBien." : ".$idBien.", prix : ".$prixNegocie." - Projet : ".$nomProjet,
                    'created' => $created,
                    'createdBy' => $createdBy
                ));
                //add it to db
                $historyManager->add($history);
                //in the next if elseif statement, we test the type of the property to change its status
                //and its price
                if($typeBien=="appartement"){
                    $appartementManager = new AppartementManager($pdo);
                    $appartementManager->changeStatus($idBien, "Vendu");
                    $appartementManager->updatePrix($prixNegocie, $idBien);
                }
                else if($typeBien=="localCommercial"){
                    $locauxManager = new LocauxManager($pdo);
                    $locauxManager->changeStatus($idBien, "Vendu");
                    $locauxManager->updatePrix($prixNegocie, $idBien);
                }
                //add contract note into db and show it in the dashboard
                $notesClientManager = new NotesClientManager($pdo);
                $notesClient = new NotesClient(array('note' => $note, 'created' => date('Y-m-d'), 
                'idProjet' => $idProjet, 'codeContrat' => $codeContrat));
                $notesClientManager->add($notesClient);
                $actionMessage = "<strong>Opération valide : </strong>Contrat Client ajouté(e) avec succès.";
                $typeMessage = "success";
                $redirectLink = 'Location:../contrat.php?codeContrat='.$codeContrat."&idProjet=".$idProjet;
            }
        }
        else{
            $actionMessage = "<strong>Erreur Création Contrat : </strong>Veuillez vérifier les champs saisies.";
            $typeMessage = "error";    
            $redirectLink = 'Location:../contrats-add.php?idProjet='.$idProjet.'&codeClient='.$codeClient;
        }
    }
    //Action Add Processing End
    //Action Update Processing Begin
    else if($action == "update"){
        $idContrat = htmlentities($_POST['idContrat']);
        $codeContrat = htmlentities($_POST['codeContrat']);
        if(!empty($_POST['prixVente'])){
            $prixVente = htmlentities($_POST['prixVente']);
            $prixVenteArabe = htmlentities($_POST['prixVenteArabe']);
            $numero = htmlentities($_POST['numero']);
            $numeroCheque = htmlentities($_POST['numeroCheque']);
            $dateCreation = htmlentities($_POST['dateCreation']);
            $avance = htmlentities($_POST['avance']);
            $avanceArabe = htmlentities($_POST['avanceArabe']);
            $modePaiement = htmlentities($_POST['modePaiement']);
            $dureePaiement = htmlentities($_POST['dureePaiement']);
            $nombreMois = htmlentities($_POST['nombreMois']);
            $echeance = htmlentities($_POST['echeance']);
            $note = htmlentities($_POST['note']);
            $societeArabe = htmlentities($_POST['societeArabe']);
            $etatBienArabe = htmlentities($_POST['etatBienArabe']);
            $facadeArabe = htmlentities($_POST['facadeArabe']);
            $articlesArabes = htmlentities($_POST['articlesArabes']);
            $updatedBy = $_SESSION['userMerlaTrav']->login();
            $updated = date('Y-m-d h:i:s');
            //create classes managers
            $locauxManager = new LocauxManager($pdo);
            $appartementManager = new AppartementManager($pdo);
            //create classes
            //this contrat object is used to test the type of a property based of 
            //the id of the current contrat objet
            $contrat = $contratManager->getContratById($idContrat);
            $newContrat = 
            new Contrat(array('id' => $idContrat, 'numero' => $numero, 'dateCreation' => $dateCreation, 
            'prixVente' => $prixVente, 'avance' => $avance, 'prixVenteArabe' => $prixVenteArabe, 
            'avanceArabe' => $avanceArabe, 'modePaiement' => $modePaiement,'nombreMois' => $nombreMois, 
            'dureePaiement' => $dureePaiement, 'echeance' => $echeance, 'numeroCheque' => $numeroCheque, 
            'note' => $note, 'societeArabe' => $societeArabe, 'etatBienArabe' => $etatBienArabe, 
            'facadeArabe' => $facadeArabe, 'articlesArabes' => $articlesArabes, 'updated' => $updated, 'updatedBy' => $updatedBy));
            //begin processing
            $contratManager->update($newContrat);
            //Update The ReglementsPrevus Table
            //We should get the number of "ReglementPrevu" to begin our process
            $createdBy = $_SESSION['userMerlaTrav']->login();
            $created = date('Y-m-d h:i:s');
            $reglementPrevuNumber  = $reglementPrevuManager->getReglementNumberByCodeContrat($codeContrat);
            if ( $reglementPrevuNumber >= 1 ) {
                $reglementPrevuManager->deleteByCodeContrat($codeContrat);
                //set the datePrevu for our object begin
                $condition = ceil( floatval($dureePaiement)/floatval($nombreMois) );
                for ( $i=1; $i <= $condition; $i++ ) {
                    $monthsNumber = "+".$nombreMois*$i." months";
                    $datePrevu = date('Y-m-d', strtotime($monthsNumber, strtotime($dateCreation)));
                    $reglementPrevuManager->add(
                        new ReglementPrevu(
                            array(
                                'datePrevu' => $datePrevu,
                                'codeContrat' => $codeContrat,
                                'status' => 0,
                                'created' => $created,
                                'createdBy' =>$createdBy
                            )
                        )
                    );
                }
                //set the datePrevu for our object end
            }
            //add history data to db
            $history = new History(array(
                'action' => "Modification",
                'target' => "Table des contrats",
                'description' => "Modification du contrat dont l'identifiant est : ".$idContrat." - Projet : ".$nomProjet,
                'created' => $created,
                'createdBy' => $createdBy
            ));
            //add it to db
            $historyManager->add($history);
            //update client's note
            $notesClientManager = new NotesClientManager($pdo);
            $notesClient = new NotesClient(array('note' => $note, 'created' => date('Y-m-d'), 
            'idProjet' => $contrat->idProjet(), 'codeContrat' => $contrat->code()));
            $notesClientManager->add($notesClient);
            //test if the typeBien radio box is checked
            //if yes then we use our contrat object mentioned earlier
            if( isset($_POST['typeBien']) ){
                $typeBien = $_POST['typeBien'];
                $idBien = $_POST['bien'];
                //change status of the old contrat Bien from Réservé to Disponible
                if( $contrat->typeBien()=="appartement" ){
                    $appartementManager->changeStatus($contrat->idBien(), "Disponible");
                }
                else if( $contrat->typeBien()=="localCommercial" ){
                    $locauxManager->changeStatus($contrat->idBien(), "Disponible");
                }
                //change status of the new contrat Bien from Disponible to Vendu
                //and change the property price to the price of sold
                if( $typeBien=="appartement" ){
                    $contratManager->changerBien($idContrat, $idBien, $typeBien);
                    $appartementManager->changeStatus($idBien, "Vendu");
                    $appartementManager->updatePrix($prixVente, $idBien);
                }
                else if( $typeBien=="localCommercial" ){
                    $contratManager->changerBien($idContrat, $idBien, $typeBien);
                    $locauxManager->changeStatus($idBien, "Vendu");
                    $locauxManager->updatePrix($prixVente, $idBien);
                }
            }
            $actionMessage = "<strong>Opération Valide : </strong>Contrat modifié(e) avec succès.";
            $typeMessage = "success";
            $redirectLink = "Location:../contrat.php?codeContrat=".$codeContrat;
            if ( isset($_POST['source']) and $_POST['source'] == "clients-list" ) {
                $redirectLink = "Location:../clients-list.php";    
            }
        }
        else{
            $actionMessage = "<strong>Erreur Modification Client : </strong>Vous devez remplir le champ <strong>&lt;Prix de vente&gt;</strong>.";
            $typeMessage = "error";
            $redirectLink = "Location:../contrat.php?codeContrat=".$codeContrat;
        }
    }
    //Action Update Processing End
    //Action UpdateImageNote Processing Begin
    else if ($action == "updateImageNote") {
        $codeContrat = htmlentities($_POST['codeContrat']);
        $imageNote = "";
        $idContrat = htmlentities($_POST['idContrat']);
        if(file_exists($_FILES['note-client-image']['tmp_name']) || is_uploaded_file($_FILES['note-client-image']['tmp_name'])) {
            $imageNote = imageProcessing($_FILES['note-client-image'], '/pieces/pieces_notes_clients/');
            $contratManager->updateImageNote($idContrat, $imageNote);
            $actionMessage = "<strong>Opération valide : </strong>Image Note est modifiée avec succès.";
            $typeMessage = "success";
        }
        else{
            $actionMessage = "<strong>Erreur Modification Image Note : </strong>Vous devez séléctionner un fichier.";
            $typeMessage = "error";
        }
        $redirectLink = "Location:../contrat.php?codeContrat=".$codeContrat."&idProjet=".$idProjet;
        if ( isset($_POST['source']) and $_POST['source'] == "clients-modification" ) {
            $redirectLink = "Location:../clients-modification.php";    
        }
    }
    //Action UpdateImageNote Processing END 
    //Action Delete Processing Begin
    else if($action=="delete"){
        $idContrat = $_POST['idContrat'];
        $contratManager->hide($idContrat);
        //add history data to db
        $createdBy = $_SESSION['userMerlaTrav']->login();
        $created = date('Y-m-d h:i:s');
        $history = new History(array(
            'action' => "Suppression",
            'target' => "Table des contrats",
            'description' => "Suppression du contrat dont l'identifiant est : ".$idContrat." - Projet : ".$nomProjet,
            'created' => $created,
            'createdBy' => $createdBy
        ));
        //add it to db
        $historyManager->add($history);
        //after the delete of our contract, we should change the property status to "Disponible"
        $actionMessage = "<strong>Opération Valide : </strong>Contrat Supprimé(e) avec succès.";
        $typeMessage = "success";
        $redirectLink = "Location:../contrats-desistes-list.php?idProjet=".$idProjet;
    }
    //Action Delete Processing End
    //Action Desister Processing Begin
    else if ( $action == "desister" ) {
        $idContrat  = $_POST['idContrat'];
        $contrat = $contratManager->getContratById($idContrat);
        //Change status of the old contrat Bien from "Vendu" to "Disponible"
        if( $contrat->typeBien()=="appartement" ){
            $appartementManager = new AppartementManager($pdo);
            $appartementManager->changeStatus($contrat->idBien(), "Disponible");
        }
        else if( $contrat->typeBien()=="localCommercial" ){
            $locauxManager = new LocauxManager($pdo);
            $locauxManager->changeStatus($contrat->idBien(), "Disponible");
        }
        $contratManager->desisterContrat($idContrat);
        //add history data to db
        $createdBy = $_SESSION['userMerlaTrav']->login();
        $created = date('Y-m-d h:i:s');
        $history = new History(array(
            'action' => "Désistement",
            'target' => "Table des contrats",
            'description' => "Désistement du contrat dont l'identifiant est : ".$idContrat." - Projet : ".$nomProjet,
            'created' => $created,
            'createdBy' => $createdBy
        ));
        //add it to db
        $historyManager->add($history);
        $actionMessage = "<strong>Opération valide : </strong>Le contrat est désisté avec succès.";
        $typeMessage = "success";
        $redirectLink = 'Location:../contrats-list.php?idProjet='.$idProjet;
        if( isset($_POST["source"]) and $_POST["source"] == "clients-search" ){
            $redirectLink = 'Location:../clients-search.php';
        }
    }
    //Action Desister Processing End
    //Action Activer Processing Begin
    else if ( $action == "activer" ) {
        $idContrat  = $_POST['idContrat'];
        //create classes
        $contrat = $contratManager->getContratById($idContrat);
        //test property type to decide which action to do
        if( $contrat->typeBien() == "appartement" ){
            $appartementManager = new AppartementManager($pdo);
            if( $appartementManager->getAppartementById($contrat->idBien())->status() == "Disponible" ){
                $appartementManager->changeStatus($contrat->idBien(), "Vendu");
                $contratManager->activerContrat($idContrat);
                //add history data to db
                $createdBy = $_SESSION['userMerlaTrav']->login();
                $created = date('Y-m-d h:i:s');
                $history = new History(array(
                    'action' => "Activation",
                    'target' => "Table des contrats",
                    'description' => "Activer un contrat",
                    'created' => $created,
                    'createdBy' => $createdBy
                ));
                //add it to db
                $historyManager->add($history);
                $actionMessage = "<strong>Opération valide : </strong>Le contrat est activé avec succès.";
                $typeMessage = "success";
            }
            else{
                $actionMessage = "<strong>Erreur Activation Contrat : </strong>Le bien est déjà réservé par un autre client.";
                $typeMessage = "error";
            }
        }
        else if( $contrat->typeBien()=="localCommercial" ){
            $locauxManager = new LocauxManager($pdo);
            if( $locauxManager->getLocauxById($contrat->idBien())->status()=="Disponible" ){
                $locauxManager->changeStatus($contrat->idBien(), "Vendu");
                $contratManager->activerContrat($idContrat);
                //add history data to db
                $createdBy = $_SESSION['userMerlaTrav']->login();
                $created = date('Y-m-d h:i:s');
                $history = new History(array(
                    'action' => "Activation",
                    'target' => "Table des contrats",
                    'description' => "Activation du contrat dont l'identifiant est : ".$idContrat." - Projet : ".$nomProjet,
                    'created' => $created,
                    'createdBy' => $createdBy
                ));
                //add it to db
                $historyManager->add($history);
                $actionMessage = "<strong>Opération valide : </strong>Le contrat est activé avec succès.";
                $typeMessage = "success";
            }
            else{
                $actionMessage = "<strong>Erreur Activation Contrat : </strong>Le bien est déjà réservé par un autre client.";
                $typeMessage = "error";
            }
        }
        //set the redirect link
        $redirectLink = 'Location:../contrats-desistes-list.php?idProjet='.$idProjet;
        if( isset($_POST["source"]) and $_POST["source"] == "clients-search" ){
            $redirectLink = 'Location:../clients-search.php';
        }    
    }
    //Action Activer Processing End
    //Action Update Revendre Processing Begin
    else if ( $action == "revendre" ) {
        $idContrat  = $_POST['idContrat'];
        $idBien = $_POST['idBien'];
        $typeBien = $_POST['typeBien'];
        $montantRevente = $_POST['montantRevente'];
        if ( $typeBien == "appartement" ) {
            $appartementManager = new AppartementManager($pdo);
            $appartementManager->updateMontantRevente($montantRevente, $idBien);
        }
        else {
            $locauxManager = new LocauxManager($pdo);
            $locauxManager->updateMontantRevente($montantRevente, $idBien);
        }
        $contrat = $contratManager->getContratById($idContrat);
        //Change status of the old contrat Bien from "Vendu" to "Disponible"
        if( $contrat->revendre() == 0 ){
            $contratManager->updateRevendre($idContrat, 1);
        }
        else if( $contrat->revendre() == 1 ){
            $contratManager->updateRevendre($idContrat, 0);
        }
        //add history data to db
        $createdBy = $_SESSION['userMerlaTrav']->login();
        $created = date('Y-m-d h:i:s');
        $history = new History(array(
            'action' => "Modification Status Revendre",
            'target' => "Table des contrats",
            'description' => "Modification de status Revendement du contrat dont l'identifiant est : ".$idContrat." - Projet : ".$nomProjet,
            'created' => $created,
            'createdBy' => $createdBy
        ));
        //add it to db
        $historyManager->add($history);
        $actionMessage = "<strong>Opération valide : </strong>Le contrat est modifié avec succès.";
        $typeMessage = "success";
        $redirectLink = 'Location:../contrats-list.php?idProjet='.$idProjet;
        if( isset($_POST["source"]) and $_POST["source"] == "clients-search" ){
            $redirectLink = 'Location:../clients-search.php';
        }
    }
    //Action Update Revendre Processing End
    $_SESSION['contrat-action-message'] = $actionMessage;
    $_SESSION['contrat-type-message'] = $typeMessage;
    header($redirectLink);
    
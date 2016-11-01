<?php
/**
 * This is a Model class for the customer component
 * Created By  : AASSOU Abdelilah
 * Github      : @aassou
 * email       : aassou.abdelilah@gmail.com
 * Description : This controller is used to create a new customer if it doesn't exist, or get it from 
 *              the database if exists. If all goes nomrmal, this controller sends the customer 
 *              informations to the contract property url to finish the process.
 */
    require('../app/classLoad.php');
    require('../db/PDOFactory.php');  
    include('../lib/image-processing.php');
    //classes loading end
    session_start();
    
    //post input processing
    //the action input precise which action the controller is going to prossed, 
    //add action, update action or delete action
    $action = htmlentities($_POST['action']);
    //In this session variable we put all the POST, to get it in the contrats-add file
    //in case of error, and this help the user to do not put again what he filled out.
    $_SESSION['myFormData'] = $_POST;
    //This var contains result message of CRUD action and the redirection url link
    $actionMessage = "";
    $typeMessage = "";
    $redirectLink = "";
    //class manager
    $clientManager = new ClientManager(PDOFactory::getMysqlConnection());
    //The History Component is used in all ActionControllers to mention a historical version of each action
    $historyManager = new HistoryManager(PDOFactory::getMysqlConnection());
    //process starts
    //Case 1 : CRUD Add Action 
    if($action == "add"){
        $idProjet = htmlentities($_POST['idProjet']);
        $codeClient = "";
        $client = "";
        //if the client exists in the database, and we get its information from the clients-add.php file
        //we just are going to send its informations to the next url : contrats-add.php 
        if( !empty($_POST['idClient']) ){
            $idClient = htmlentities($_POST['idClient']);
            $client = $clientManager->getClientById($idClient);
            $codeClient = $client->code();
            $actionMessage = "<strong>Opération Valide : </strong>Client Récuperé avec succès.";
            $typeMessage = "info";
            $redirectLink = 'Location:../views/contrats-add.php?idProjet='.$idProjet.'&codeClient='.$codeClient;
        }
        //if we don't get any customer information from the clients-add.php page, 
        //then there is one of two cases to treat
        else if( empty($_POST['idClient']) ){
            //Case 1 :  if we tray to force the creation of an existing customer
            //we get an error message indicating that we do have a customer with that name 
            if( !empty($_POST['cin'])){
                $cin = htmlentities($_POST['cin']);
                if( $clientManager->existsCIN($cin) ){
                    $actionMessage = "<strong>Erreur Création Client : </strong>Un client existe déjà avec ce CIN : <strong>".$cin."</strong>.";
                    $typeMessage = "error";
                    $redirectLink = 'Location:../views/clients-add.php?idProjet='.$idProjet;
                }
                //Case 2 :  The customer doesn't exist, so we add to our database, 
                //and the send its generated code to the contrats-add.php url   
                else{
                    //input posts processing
                    $nom = htmlentities($_POST['nom']);
                    $nomArabe = htmlentities($_POST['nomArabe']);
                    $adresse = htmlentities($_POST['adresse']);
                    $adresseArabe = htmlentities($_POST['adresseArabe']);
                    $telephone1 = htmlentities($_POST['telephone1']);
                    $telephone2 = htmlentities($_POST['telephone2']);
                    $email = htmlentities($_POST['email']);
                    $codeClient = uniqid().date('YmdHis');
                    $created = date('Y-m-d h:i:s');
                    $createdBy =  $_SESSION['userImmoERPV2']->login();
                    //object creation
                    $client = 
                    new Client(array('nom' => $nom, 'nomArabe' => $nomArabe, 'cin' => $cin, 
                    'adresse' => $adresse, 'adresseArabe' => $adresseArabe,
                    'telephone1' => $telephone1, 'telephone2' =>$telephone2, 'email' => $email, 
                    'code' => $codeClient, 'created' => $created, 'createdBy' => $createdBy));
                    //push object to db
                    $clientManager->add($client);
                    //add history data to db
                    $history = new History(array(
                        'action' => "Ajout",
                        'target' => "Table des clients",
                        'description' => "Ajout du client : ".$nom,
                        'created' => $created,
                        'createdBy' => $createdBy
                    ));
                    //add it to db
                    $historyManager->add($history);
                    //result processes   
                    $actionMessage = "<strong>Opération Valide : </strong>Client Ajouté(e) avec succès.";
                    $typeMessage = "success";
                    $redirectLink = 'Location:../views/contrats-add.php?idProjet='.$idProjet.'&codeClient='.$codeClient;
                }
            }
            //This is a simple form validation, the field Nom should not be empty
            else{
                $actionMessage = "<strong>Erreur Création Client : </strong>Vous devez remplir au moins le champ <strong>&lt;Nom&gt;</strong>.";
                $typeMessage = "error";
                $redirectLink = 'Location:../views/clients-add.php?idProjet='.$idProjet;
            }   
        }
    }
    //Action Add Process Ends
    
    //Action Update Process Begins
    else if($action == "update"){
        if(!empty($_POST['nom'])){
            $id = htmlentities($_POST['idClient']);
            $nom = htmlentities($_POST['nom']);
            $nomArabe = htmlentities($_POST['nomArabe']);
            $cin = htmlentities($_POST['cin']);
            $adresse = htmlentities($_POST['adresse']);
            $adresseArabe = htmlentities($_POST['adresseArabe']);
            $telephone1 = htmlentities($_POST['telephone1']);
            $telephone2 = htmlentities($_POST['telephone2']);
            $email = htmlentities($_POST['email']);
            $updatedBy = $_SESSION['userImmoERPV2']->login();
            $updated = date('Y-m-d h:i:s');
            $codeContrat = htmlentities($_POST['codeContrat']);
            //This input is used to specify the redirect link. Because you can launch the update of a client
            //from one of these 2 url : contrat.php or client-list.php, so you have to specify based on the
            //source input to which one of them you'll be redirected.
            $source = htmlentities($_POST['source']);
            $client = 
            new Client(array('id' => $id, 'nom' => $nom, 'nomArabe' => $nomArabe, 'cin' => $cin, 
            'adresse' => $adresse, 'adresseArabe' => $adresseArabe, 'telephone1' => $telephone1, 'telephone2' => $telephone2, 
            'email' => $email, 'updatedBy' => $updatedBy, 'updated' => $updated));
            $clientManager->update($client);
            //add history data to db
            $createdBy = $_SESSION['userImmoERPV2']->login();
            $created = date('Y-m-d h:i:s');
            $history = new History(array(
                'action' => "Modification",
                'target' => "Table des clients",
                'description' => "Modifier le client : ".$nom,
                'created' => $created,
                'createdBy' => $createdBy
            ));
            //add it to db
            $historyManager->add($history);
            $actionMessage = "<strong>Opération Valide : </strong>Client Modifié(e) avec succès.";
            $typeMessage = "success";
            if( $source == "contrat" ){
                $redirectLink = "Location:../views/contrat.php?codeContrat=".$codeContrat;
            }
            else if( $source="clients" ){
                $redirectLink = "Location:../views/clients-list.php";   
            }
        }
        else{
            $actionMessage = "<strong>Erreur Modification Client : </strong>Vous devez remplir le champ <strong>&lt;Nom&gt;</strong>.";
            $typeMessage = "error";
            if( $source == "contrat" ){
                $redirectLink = "Location:../views/contrat.php?codeContrat=".$codeClient;
            }
            else if( $source="clients" ){
                $redirectLink = "Location:../views/clients.php";   
            }
        }
    }
    //Action Update Process Ends
    
    //Action Delete Process Begins
    else if($action=="delete"){
        //$idClient = $_POST['idClient'];
        //$clientManager->delete($idClient);
        //add history data to db
        /*$createdBy = $_SESSION['userImmoERPV2']->login();
        $created = date('Y-m-d h:i:s');
        $history = new History(array(
            'action' => "Activation",
            'target' => "Table des contrats",
            'description' => "Activer un contrat",
            'created' => $created,
            'createdBy' => $createdBy
        ));
        //add it to db
        $historyManager->add($history);*/
        $actionMessage = "<strong>Opération Valide : </strong>Client Supprimé(e) avec succès.";
        $typeMessage = "success";
        $redirectLink = "Location:../views/clients-list.php";
    }
    
    //Action Search Process Begins
    else if($action=="search"){
        $clientName = htmlentities($_POST['clientName']);
        $_SESSION['searchClientResult'] = $clientManager->getClientBySearch($clientName, 1);
        $redirectLink = "Location:../views/clients-search.php";
    }
    //Action Search Process Ends
    
    //set session informations
    $_SESSION['client-action-message'] = $actionMessage;
    $_SESSION['client-type-message'] = $typeMessage;
    
    //set redirection link
    header($redirectLink);
    
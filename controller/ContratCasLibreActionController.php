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
    //This var contains result message of CRUD action
    $actionMessage = "";
    $typeMessage = "";
    
    //Redirection link
    $redirectLink = "";
    //Component Class Manager
    $contratCasLibreManager = new ContratCasLibreManager($pdo);
    //The History Component is used in all ActionControllers to mention a historical version of each action
    $historyManager = new HistoryManager($pdo);
	//Action Add Processing Begin
    if($action == "add"){
        if( !empty($_POST['date']) ){
			$date = htmlentities($_POST['date']);
			$montant = htmlentities($_POST['montant']);
			$observation = htmlentities($_POST['observation']);
			$codeContrat = htmlentities($_POST['codeContrat']);
			$createdBy = $_SESSION['userMerlaTrav']->login();
            $created = date('Y-m-d h:i:s');
            //create object
            $contratCasLibre = new ContratCasLibre(array(
				'date' => $date,
				'montant' => $montant,
				'observation' => $observation,
				'codeContrat' => $codeContrat,
				'created' => $created,
            	'createdBy' => $createdBy
			));
            //add it to db
            $contratCasLibreManager->add($contratCasLibre);
            $actionMessage = "Opération Valide : ContratCasLibre Ajouté(e) avec succès.";  
            $typeMessage = "success";
        }
        else{
            $actionMessage = "Erreur Ajout contratCasLibre : Vous devez remplir le champ 'date'.";
            $typeMessage = "error";
        }
    }
    //Action Add Processing End
    //Action addCasLibre Processing Begin
    else if($action=="addCasLibre"){
        $codeContrat = htmlentities($_POST['codeContrat']);
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
                $createdBy = $_SESSION['userMerlaTrav']->login();
                $created = date('Y-m-d h:i:s');
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
        } 
        $actionMessage = "<strong>Opération Valide : </strong>Contrat Cas Libre ajouté avec succès.";
        $typeMessage = "success";
        $redirectLink = "Location:../contrat.php?codeContrat=".$codeContrat;
    }
    //Action addCasLibre Processing End
    //Action Update Processing Begin
    else if($action == "update"){
        $idContratCasLibre = htmlentities($_POST['idContratCasLibre']);
        if(!empty($_POST['date'])){
			$date = htmlentities($_POST['date']);
			$montant = htmlentities($_POST['montant']);
			$observation = htmlentities($_POST['observation']);
			$updatedBy = $_SESSION['userMerlaTrav']->login();
            $updated = date('Y-m-d h:i:s');
			$contratCasLibre = new ContratCasLibre(array(
	            'id' => $idContratCasLibre,
	            'date' => $date,
	            'montant' => $montant,
	            'observation' => $observation,
	            'updated' => $updated,
	            'updatedBy' => $updatedBy
			));
            $contratCasLibreManager->update($contratCasLibre);
            $actionMessage = "Opération Valide : ContratCasLibre Modifié(e) avec succès.";
            $typeMessage = "success";
        }
        else{
            $actionMessage = "Erreur Modification ContratCasLibre : Vous devez remplir le champ 'date'.";
            $typeMessage = "error";
        }
        $codeContrat = htmlentities($_POST['codeContrat']);
        $idProjet = htmlentities($_POST['idProjet']);
        $redirectLink = "Location:../contrat.php?codeContrat=".$codeContrat.'&idProjet='.$idProjet.'#contratCasLibre';
    }
    //Action Update Processing End
    //Action UpdateStatus Processing Begin
    else if ($action == "updateStatus"){
        $idContratCasLibre = htmlentities($_POST['idContratCasLibre']);
        $status = htmlentities($_POST['status']);
        $contratCasLibreManager->updateStatus($idContratCasLibre, $status);
        $codeContrat = htmlentities($_POST['codeContrat']);
        $idProjet = htmlentities($_POST['idProjet']);
        $redirectLink = "Location:../contrat.php?codeContrat=".$codeContrat.'&idProjet='.$idProjet.'#contratCasLibre';
    }
    //Action UpdateStatus Processing End
    //Action Delete Processing Begin
    else if($action == "delete"){
        $idContratCasLibre = htmlentities($_POST['idContratCasLibre']);
        $contratCasLibreManager->delete($idContratCasLibre);
        $actionMessage = "Opération Valide : ContratCasLibre supprimé(e) avec succès.";
        $typeMessage = "success";
        $codeContrat = htmlentities($_POST['codeContrat']);
        $idProjet = htmlentities($_POST['idProjet']);
        $redirectLink = "Location:../contrat.php?codeContrat=".$codeContrat.'&idProjet='.$idProjet.'#contratCasLibre';
    }
    //Action Delete Processing End
    $_SESSION['contratCasLibre-action-message'] = $actionMessage;
    $_SESSION['contratCasLibre-type-message'] = $typeMessage;
    header($redirectLink);


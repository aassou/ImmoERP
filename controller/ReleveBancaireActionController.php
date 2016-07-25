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
    /****** Include the EXCEL Reader Factory ***********/
    //error_reporting(0);
    set_include_path(get_include_path() . PATH_SEPARATOR . 'Classes/');
    include ('Classes/PHPExcel/IOFactory.php');
    //classes loading end
    session_start();
    //post input processing
    $action = htmlentities($_POST['action']);
    //This var contains result message of CRUD action
    $actionMessage = "";
    $typeMessage = "";
    //Component Class Manager
    $releveBancaireManager = new ReleveBancaireManager($pdo);
    $redirectLink = "";
	//Action Add Processing Begin
    if($action == "add"){
        $invalid = 0;
        if ( isset($_POST) && !empty($_FILES['excelupload']['name']) ) {
            //print_r($_FILES['excelupload']);
            $namearr = explode(".",$_FILES['excelupload']['name']);
            if ( end($namearr) != 'xls' && end($namearr) != 'xlsx' && end($namearr) != 'asp' && end($namearr) != 'aspx') {
                //echo '<p> Invalid File </p>';
                $invalid = 1;
                $actionMessage = "<strong>Erreur Ajout Releve Bancaire</strong> : Le type de fichier est incorrecte.";
                $typeMessage = "error";
            }
            if ( $invalid != 1 ) {
                $target_dir = "../uploads/";
                $target_file = $target_dir . basename($_FILES["excelupload"]["name"]);
                $response = move_uploaded_file($_FILES['excelupload']['tmp_name'],$target_file); // Upload the file to the current folder
                if ( $response ) {
                    try {
                        $objPHPExcel = PHPExcel_IOFactory::load($target_file);
                    } 
                    catch(Exception $e) {
                        die('Error : Unable to load the file : "'.pathinfo($_FILES['excelupload']['name'],PATHINFO_BASENAME).'": '.$e->getMessage());
                    }
                    $allDataInSheet = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
                    //print_r($allDataInSheet);
                    $arrayCount = count($allDataInSheet); // Total Number of rows in the uploaded EXCEL file
                    //echo $arrayCount;
                    $string = "INSERT INTO t_relevebancaire (dateOpe, dateVal, libelle, reference, debit, credit, projet, idCompteBancaire) VALUES ";
                    $compteBancaire = htmlentities($_POST['idCompteBancaire']);
                    for ( $i=1; $i<=$arrayCount; $i++ ) {
                        //$dateOpe= date('Y-m-d', strtotime(trim($allDataInSheet[$i]["B"])));
                        //$dateOpe = DateTime::createFromFormat('d/m/Y', trim($allDataInSheet[$i]["B"]));
                        //$dateOpe = $dateOpe->format('Y-m-d'); 
                        //$dateVal= date('Y-m-d', strtotime(trim($allDataInSheet[$i]["C"])));
                        //$dateVal = DateTime::createFromFormat('d/m/Y', trim($allDataInSheet[$i]["C"]));
                        //$dateVal = $dateVal->format('Y-m-d');
                        //echo $dateOpe.'&nbsp;&nbsp;';
                        //echo $dateVal.'<br>';
                        //echo $allDataInSheet[$i]["B"].'   ';
                        //echo $allDataInSheet[$i]["C"].'<br>';
                        //$date = DateTime::createFromFormat('d/m/Y', $allDataInSheet[$i]["B"]);
                        //echo $date->format('Y-m-d').'<br>';
                        //echo $date;
                        $dateOpe = trim($allDataInSheet[$i]["B"]);
                        $dateVal = trim($allDataInSheet[$i]["C"]);
                        $libelle = addslashes(trim($allDataInSheet[$i]["D"]));
                        $reference = addslashes(trim($allDataInSheet[$i]["E"]));
                        $debit = 0;
                        $credit = 0;
                        $projet = "_";
                        if ( strlen($allDataInSheet[$i]["F"]) > 0 ) {
                            $debit = trim($allDataInSheet[$i]["F"]);    
                        }
                        if ( strlen($allDataInSheet[$i]["G"]) > 0 ) {
                            $credit = trim($allDataInSheet[$i]["G"]);    
                        }
                        if ( strlen($allDataInSheet[$i]["H"]) > 0 ) {
                            $projet = addslashes(trim($allDataInSheet[$i]["H"]));    
                        }
                        $string .= "( '".$dateOpe."' , '".$dateVal."' , '".$libelle."' , '".$reference."' , ".$debit." , ".$credit." , '".$projet."' , '".$compteBancaire."'),";
                    }
                    $string = substr($string,0,-1);
                    //print_r(utf8_decode($string));
                    //echo $string;
                    //mysql_query($string); // Insert all the data into one query
                    $pdo->query($string);
                    $actionMessage = "<strong>Opération Valide</strong> : Releve Bancaire Ajouté(e) avec succès.";  
                    $typeMessage = "success";
                }
            }// End Invalid Condition
        }         
        else{
            $actionMessage = "<strong>Erreur Ajout Releve Bancaire</strong> : Vous devez choisir un fichier.";
            $typeMessage = "error";
        }
    }
    //Action Add Processing End
    //Action Update Processing Begin
    else if($action == "update"){
        $idReleveBancaire = htmlentities($_POST['idReleveBancaire']);
        if(!empty($_POST['dateOpe'])){
            $compteBancaire = htmlentities($_POST['idCompteBancaire']);
			$dateOpe = htmlentities($_POST['dateOpe']);
			$dateVal = htmlentities($_POST['dateVal']);
			$libelle = htmlentities($_POST['libelle']);
			$reference = htmlentities($_POST['reference']);
			$debit = htmlentities($_POST['debit']);
			$credit = htmlentities($_POST['credit']);
			$projet = htmlentities($_POST['projet']);
			$updatedBy = $_SESSION['userMerlaTrav']->login();
            $updated = date('Y-m-d h:i:s');
            $releveBancaire = new ReleveBancaire(array(
				'id' => $idReleveBancaire,
				'dateOpe' => $dateOpe,
				'dateVal' => $dateVal,
				'libelle' => $libelle,
				'reference' => $reference,
				'debit' => $debit,
				'credit' => $credit,
				'projet' => $projet,
				'idcompteBancaire' => $compteBancaire,
				'updated' => $updated,
            	'updatedBy' => $updatedBy
			));
            $releveBancaireManager->update($releveBancaire);
            $actionMessage = "<strong>Opération Valide</strong> : Releve Bancaire Modifié(e) avec succès.";
            $typeMessage = "success";
        }
        else{
            $actionMessage = "<strong>Erreur Modification Releve Bancaire</strong> : Vous devez remplir le champ <strong>Date Opération</strong>.";
            $typeMessage = "error";
        }
    }
    //Action Update Processing End
    //Action ProcessFournisseur Begin
    else if ( $action == "process-fournisseur" ) {
        $idReleveBancaire = $_POST['idReleveBancaire'];
        $destinations =htmlentities($_POST['destinations']);
        $societe = "";
        $montant = htmlentities($_POST['montant']);
        $dateOperation = htmlentities($_POST['dateOperation']);
        $dateOperation = DateTime::createFromFormat('d/m/Y', trim($dateOperation));
        $dateOperation = $dateOperation->format('Y-m-d'); 
        $designation = htmlentities($_POST['designation']);
        if ( $destinations == "ChargesCommuns" ) {
            $chargeCommunManager = new ChargeCommunManager($pdo);
            $societe = htmlentities($_POST['societe']);
            $type = htmlentities($_POST['typeChargesCommuns']);
            $createdBy = $_SESSION['userMerlaTrav']->login();
            $created = date('Y-m-d h:i:s');
            //create object
            $charge = new ChargeCommun(array(
                'type' => $type,
                'dateOperation' => $dateOperation,
                'montant' => $montant,
                'societe' => $societe,
                'designation' => $designation,
                'created' => $created,
                'createdBy' => $createdBy
            ));
            //add it to db
            $chargeCommunManager->add($charge);
            $releveBancaireManager->hide($idReleveBancaire);
        }
        else if ( $destinations == "ChargesProjets" ) {
            $chargeManager = new ChargeManager($pdo);
            $societe = htmlentities($_POST['societe2']);
            $type = htmlentities($_POST['typeChargesProjet']);
            $projet = htmlentities($_POST['projet']);
            $createdBy = $_SESSION['userMerlaTrav']->login();
            $created = date('Y-m-d h:i:s');
            //create object
            $charge = new Charge(array(
                'type' => $type,
                'dateOperation' => $dateOperation,
                'montant' => $montant,
                'societe' => $societe,
                'designation' => $designation,
                'idProjet' => $projet,
                'created' => $created,
                'createdBy' => $createdBy
            ));
            //add it to db
            $chargeManager->add($charge);
            $releveBancaireManager->hide($idReleveBancaire);
        }
        else if ( $destinations == "Ignorer" ) {
            $releveBancaireManager->delete($idReleveBancaire);
        }
        $actionMessage = "<strong>Opération Valide</strong> : Releve Bancaire traité avec succès.";
        $typeMessage = "success";
    }
    //Action ProcessFournisseur End
    //Action ProcessClient Begin
    else if ( $action == "process-client" ) {
        $idReleveBancaire = $_POST['idReleveBancaire'];
        //This variable projetContrat defines the actions choosed by the user : Ignorer || a Project
        $projetContrat = htmlentities($_POST['projet-contrat']);
        $montant = htmlentities($_POST['montant']);
        $dateOperation = htmlentities($_POST['dateOperation']);
        $dateReglement = htmlentities($_POST['dateReglement']);
        $dateOperation = DateTime::createFromFormat('d/m/Y', trim($dateOperation));
        $dateReglement = DateTime::createFromFormat('d/m/Y', trim($dateReglement));
        $dateOperation = $dateOperation->format('Y-m-d'); 
        $dateReglement = $dateReglement->format('Y-m-d'); 
        $designation = htmlentities($_POST['designation']);
        if ( $projetContrat == "Ignorer" ) {
            $releveBancaireManager->delete($idReleveBancaire);
        }
        else{
            $operationManager = new OperationManager($pdo);
            //$reference = 'Q'.date('Ymd-his');
            $reference = htmlentities($_POST['reference']);
            $modePaiement = htmlentities($_POST['mode-paiement']);
            $numeroOperation = htmlentities($_POST['reference']);
            $compteBancaire = htmlentities($_POST['compte-bancaire']);
            $status = 1;
            //$observation ="Ce réglement client fait référence à la ligne : ".$idReleveBancaire." du relevé bancaire du compte bancaire : ".$compteBancaire;
            $observation = htmlentities($_POST['observation']);
            $idContrat = htmlentities($_POST['contrat-client']);
            $createdBy = $_SESSION['userMerlaTrav']->login();
            $created = date('Y-m-d h:i:s');
            $operation = 
            new Operation(array('date' => $dateOperation, 'dateReglement' => $dateReglement, 'status' => $status,
            'montant' => $montant, 'compteBancaire' => $compteBancaire, 'observation' => $observation, 'reference' => $reference,
            'modePaiement'=>$modePaiement, 'idContrat' => $idContrat, 'numeroCheque' => $numeroOperation,   
            'createdBy' => $createdBy, 'created' => $created));
            $operationManager->add($operation);
            $releveBancaireManager->hide($idReleveBancaire);
        }
        $actionMessage = "<strong>Opération Valide</strong> : Releve Bancaire traité avec succès.";
        $typeMessage = "success";
    }
    //Action ProcessClient End
    //Action SearchArchive Processing Begin 
    else if($action == "search-archive"){
        $idCompteBancaire = htmlentities($_POST['idCompteBancaire']);
        $dateFrom = htmlentities($_POST['dateFrom']);
        $dateTo = htmlentities($_POST['dateTo']);
        $_SESSION['releve-bancaire-archive'] = $releveBancaireManager->getReleveBancairesArchiveBySearch($idCompteBancaire, $dateFrom, $dateTo);
        $actionMessage = "<strong>Opération Valide</strong> : Releve Bancaire supprimé(e) avec succès.";
        $typeMessage = "success";
    }
    //Action SearchArchive Processing End
    //Action Delete Processing Begin 
    else if($action == "delete"){
        $idReleveBancaire = htmlentities($_POST['idReleveBancaire']);
        $releveBancaireManager->delete($idReleveBancaire);
        $actionMessage = "<strong>Opération Valide</strong> : Releve Bancaire supprimé(e) avec succès.";
        $typeMessage = "success";
    }
    //Action Delete Processing End
    //Action DeleteReleveActuel Processing Begin 
    else if($action == "deleteReleveActuel"){
        $releveBancaireManager->deleteReleveActuel();
        $actionMessage = "<strong>Opération Valide</strong> : Releve Bancaire Actuel supprimé(e) avec succès.";
        $typeMessage = "success";
    }
    //Action DeleteReleveActuel Processing End
    $_SESSION['releveBancaire-action-message'] = $actionMessage;
    $_SESSION['releveBancaire-type-message'] = $typeMessage;
    $redirectLink = "Location:../releve-bancaire.php";
    if ( isset($_POST['source']) and $_POST['source'] == "releve-bancaire-archive" ) {
        $redirectLink = "Location:../releve-bancaire-archive.php";
    }
    header($redirectLink);


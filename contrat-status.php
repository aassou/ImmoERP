<?php
    //classes loading begin
    function classLoad ($myClass) {
        if(file_exists('model/'.$myClass.'.php')){
            include('model/'.$myClass.'.php');
        }
        elseif(file_exists('controller/'.$myClass.'.php')){
            include('controller/'.$myClass.'.php');
        }
    }
    spl_autoload_register("classLoad"); 
    include('config.php');  
    include('lib/pagination.php');
    //classes loading end
    session_start();
    if ( isset($_SESSION['userMerlaTrav']) ) {
        //destroy contrat-form-data session
        $projetManager = new ProjetManager($pdo);
        $clientManager = new ClientManager($pdo);
        $contratManager = new ContratManager($pdo);
        $operationManager = new OperationManager($pdo);
        $compteBancaireManager = new CompteBancaireManager($pdo);
        $contratCasLibreManager = new ContratCasLibreManager($pdo);
        $reglementPrevuManager = new ReglementPrevuManager($pdo);
        //reglements prevus
        $reglementsPrevusEnRetards = $reglementPrevuManager->getReglementPrevuEnRetard();
        $reglementsPrevusToday = $reglementPrevuManager->getReglementPrevuToday();
        $reglementsPrevusWeek = $reglementPrevuManager->getReglementPrevuWeek();
        $reglementsPrevusMonth = $reglementPrevuManager->getReglementPrevuMonth();
        //casLibre dates
        $casLibreEnRetards = $contratCasLibreManager->getReglementEnRetard();
        $casLibreToday = $contratCasLibreManager->getReglementToday();
        $casLibreWeek = $contratCasLibreManager->getReglementWeek();
        $casLibreMonth = $contratCasLibreManager->getReglementMonth();
        
?>
<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9"> <![endif]-->
<!--[if !IE]><!--> <html lang="en"> <!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
    <meta charset="utf-8" />
    <title>ImmoERP - Management Application</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <meta content="" name="description" />
    <meta content="" name="author" />
    <link href="assets/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
    <link href="assets/css/metro.css" rel="stylesheet" />
    <link href="assets/bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet" />
    <link href="assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
    <link href="assets/css/style.css" rel="stylesheet" />
    <link href="assets/css/style_responsive.css" rel="stylesheet" />
    <link href="assets/css/style_default.css" rel="stylesheet" id="style_color" />
    <link href="assets/fancybox/source/jquery.fancybox.css" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="assets/uniform/css/uniform.default.css" />
    <link rel="stylesheet" type="text/css" href="assets/bootstrap-datepicker/css/datepicker.css" />
    <link rel="stylesheet" type="text/css" href="assets/chosen-bootstrap/chosen/chosen.css" />
    <link rel="stylesheet" href="assets/data-tables/DT_bootstrap.css" />
    <link rel="stylesheet" type="text/css" href="assets/uniform/css/uniform.default.css" />
    <link rel="shortcut icon" href="favicon.ico" />
</head>
<!-- END HEAD -->
<!-- BEGIN BODY -->
<body class="fixed-top">
    <!-- BEGIN HEADER -->
    <div class="header navbar navbar-inverse navbar-fixed-top">
        <!-- BEGIN TOP NAVIGATION BAR -->
        <?php include("include/top-menu.php"); ?>   
        <!-- END TOP NAVIGATION BAR -->
    </div>
    <!-- END HEADER -->
    <!-- BEGIN CONTAINER -->
    <div class="page-container row-fluid sidebar-closed">
        <!-- BEGIN SIDEBAR -->
        <?php include("include/sidebar.php"); ?>
        <!-- END SIDEBAR -->
        <!-- BEGIN PAGE -->
        <div class="page-content">
            <!-- BEGIN PAGE CONTAINER-->            
            <div class="container-fluid">
                <!-- BEGIN PAGE HEADER-->
                <div class="row-fluid">
                    <div class="span12">
                        <!-- BEGIN PAGE TITLE & BREADCRUMB-->           
                        <h3 class="page-title">
                            État des contrats clients 
                        </h3>
                        <ul class="breadcrumb">
                            <li>
                                <i class="icon-home"></i>
                                <a href="dashboard.php">Accueil</a> 
                                <i class="icon-angle-right"></i>
                            </li>
                            <li>
                                <i class="icon-bar-chart"></i>
                                <a href="status.php">Les états</a> 
                                <i class="icon-angle-right"></i>
                            </li>
                            <li>
                                <i class="icon-group"></i>
                                <a>États des contrats clients</a>
                            </li>
                        </ul>
                        <!-- END PAGE TITLE & BREADCRUMB-->
                    </div>
                </div>
                <!-- END PAGE HEADER-->
                <!-- BEGIN PAGE CONTENT-->
                <div class="row-fluid">
                    <div class="span12">
                    <!-- CONTRAT CAS LIBRE BEGIN -->
                    <?php 
                    if( isset($_SESSION['mail-action-message'])
                    and isset($_SESSION['mail-type-message']) ){
                        $message = $_SESSION['mail-action-message']; 
                        $typeMessage = $_SESSION['mail-type-message'];
                    ?>
                    <div class="alert alert-<?= $typeMessage ?>">
                        <button class="close" data-dismiss="alert"></button>
                        <?= $message ?>     
                    </div>
                     <?php } 
                        unset($_SESSION['mail-action-message']);
                        unset($_SESSION['mail-type-message']);
                     ?>
                    <div class="portlet box light-grey" id="reglementsPrevus">
                        <div class="portlet-title">
                            <h4>Situation des réglements des clients</h4>
                            <div class="tools">
                                <a href="javascript:;" class="reload"></a>
                            </div>
                        </div>
                        <div class="portlet-body">
                            <div class="clearfix">
                                <strong>Liste des réglements en retards</strong>
                                <table class="table table-striped table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th style="width: 20%">Client</th>
                                            <th style="width: 10%">Téléphone</th>
                                            <th style="width: 10%">Projet</th>
                                            <th style="width: 20%">Bien</th>
                                            <th style="width: 10%">Montant</th>
                                            <th style="width: 10%">Date Prévu</th>
                                            <th style="width: 10%">Status</th>
                                            <th style="width: 10%">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        foreach ( $reglementsPrevusEnRetards as $element ) {
                                            $contrat = 
                                            $contratManager->getContratByCode($element->codeContrat());
                                            $client = 
                                            $clientManager->getClientById($contrat->idClient());
                                            $projet = 
                                            $projetManager->getProjetById($contrat->idProjet());
                                            $bien = "";
                                            $typeBien = "";
                                            //if the property is a "Local commercial" we don't need to mention niveau attribute
                                            $niveau = "";
                                            if($contrat->typeBien()=="appartement"){
                                                $appartementManager = new AppartementManager($pdo);
                                                $bien = $appartementManager->getAppartementById($contrat->idBien());
                                                $niveau = $bien->niveau();
                                                $typeBien = "Appartement";
                                            }
                                            else if($contrat->typeBien()=="localCommercial"){
                                                $locauxManager = new LocauxManager($pdo);
                                                $bien = $locauxManager->getLocauxById($contrat->idBien());
                                                $typeBien = "Local Commercial";
                                            }
                                            //activate the update link only for admin's profil
                                            $link = "";
                                            if ( $_SESSION['userMerlaTrav']->profil() == "admin" ) {
                                                $link = '#updateStatusReglementPrevuEnRetards'.$element->id();
                                                $link = '<a href="'.$link.'" data-toggle="modal" data-id="'.$element->id().'" class="btn mini red blink_me">En retard</a>';
                                            }
                                            else {
                                                $link = '<a class="btn mini red blink_me">En retard</a>';
                                            }
                                        ?>
                                        <tr>
                                            <td><?= $client->nom() ?></td>
                                            <td><?= $client->telephone1() ?></td>
                                            <td><?= $projet->nom() ?></td>
                                            <td><?= $typeBien.' - '.$niveau.'e: '.$bien->nom() ?></td>
                                            <td><?= number_format($contrat->echeance(), 2, ',', ' ') ?>DH</td>
                                            <td><?= date('d/m/Y', strtotime($element->datePrevu())) ?></td>
                                            <td><?= $link ?></td>
                                            <td><a href="#sendMailA<?= $element->id() ?>" data-toggle="modal" data-id="<?= $element->id() ?>" class="btn blue mini" title="Envoyer Email"><i class="icon-envelope-alt"></i></a></td>
                                        </tr>
                                        <!-- SendMail box begin-->
                                        <div id="sendMailA<?= $element->id() ?>" class="modal hide fade in" tabindex="-1" role="dialog" aria-labelledby="login" aria-hidden="false" >
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                                <h3>Envoyer Email</h3>
                                            </div>
                                            <div class="modal-body">
                                                <form class="form-horizontal loginFrm" action="controller/SendMailClientController.php" method="post">
                                                    <div class="control-group">
                                                        <p>Êtes-vous sûr de vouloir envoyer un Email à <?= $client->nom() ?> ?</p>
                                                    </div>
                                                    <div class="control-group">
                                                        <div class="controls">    
                                                            <input type="hidden" name="action" value="updateStatus" />
                                                            <input type="hidden" name="source" value="contrat" />
                                                            <input type="hidden" name="email" value="<?= $client->email() ?>" />
                                                            <input type="hidden" name="client" value="<?= $client->nom() ?>" />
                                                            <input type="hidden" name="datePaiement" value="<?= $element->datePrevu() ?>" />
                                                            <button class="btn" data-dismiss="modal"aria-hidden="true">Non</button>
                                                            <button type="submit" class="btn red" aria-hidden="true">Oui</button>
                                                        <div class="controls">
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                        <!-- SendMail box end -->
                                        <!-- updateStatusReglementPrevuEnRetards box begin-->
                                        <div id="updateStatusReglementPrevuEnRetards<?= $element->id() ?>" class="modal hide fade in" tabindex="-1" role="dialog" aria-labelledby="login" aria-hidden="false" >
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                                <h3>Modifier status</h3>
                                            </div>
                                            <div class="modal-body">
                                                <form class="form-horizontal loginFrm" action="controller/ReglementPrevuActionController.php" method="post">
                                                    <div class="control-group">
                                                        <p>Êtes-vous sûr de vouloir changer le status de la date prévu ?</p>
                                                        <label class="control-label">Status</label>
                                                        <div class="controls">
                                                            <select name="status">
                                                                <option value="<?= $element->status() ?>"><?php if($element->status()==0){echo 'En cours';}else{echo 'Réglé';} ?></option>
                                                                <option disabled="disabled">-----------</option>
                                                                <option value="0">En cours</option>
                                                                <option value="1">Réglé</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="control-group">
                                                        <div class="controls">    
                                                            <input type="hidden" name="action" value="updateStatus" />
                                                            <input type="hidden" name="source" value="contrat" />
                                                            <input type="hidden" name="idReglementPrevu" value="<?= $element->id() ?>" />
                                                            <button class="btn" data-dismiss="modal"aria-hidden="true">Non</button>
                                                            <button type="submit" class="btn red" aria-hidden="true">Oui</button>
                                                        <div class="controls">
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                        <!-- updateStatusReglementPrevuEnRetards box end -->
                                        <?php
                                        }
                                        ?>
                                        <?php
                                        foreach ( $casLibreEnRetards as $element ) {
                                            $contrat = 
                                            $contratManager->getContratByCode($element->codeContrat());
                                            $client = 
                                            $clientManager->getClientById($contrat->idClient());
                                            $projet = 
                                            $projetManager->getProjetById($contrat->idProjet());
                                            $bien = "";
                                            $typeBien = "";
                                            //if the property is a "Local commercial" we don't need to mention niveau attribute
                                            $niveau = "";
                                            if($contrat->typeBien()=="appartement"){
                                                $appartementManager = new AppartementManager($pdo);
                                                $bien = $appartementManager->getAppartementById($contrat->idBien());
                                                $niveau = $bien->niveau();
                                                $typeBien = "Appartement";
                                            }
                                            else if($contrat->typeBien()=="localCommercial"){
                                                $locauxManager = new LocauxManager($pdo);
                                                $bien = $locauxManager->getLocauxById($contrat->idBien());
                                                $typeBien = "Local Commercial";
                                            }
                                            //activate the update link only for admin's profil
                                            $link = "";
                                            if ( $_SESSION['userMerlaTrav']->profil() == "admin" ) {
                                                $link = '#updateStatusReglementCasLibreEnRetards'.$element->id();
                                                $link = '<a href="'.$link.'" data-toggle="modal" data-id="'.$element->id().'" class="btn mini red blink_me">En retard</a>';
                                            }
                                            else {
                                                $link = '<a class="btn mini red blink_me">En retard</a>';
                                            }
                                        ?>
                                        <tr>
                                            <td><?= $client->nom() ?></td>
                                            <td><?= $client->telephone1() ?></td>
                                            <td><?= $projet->nom() ?></td>
                                            <td><?= $typeBien.' - '.$niveau.'e: '.$bien->nom() ?></td>
                                            <td><?= number_format($element->montant(), 2, ',', ' ') ?>DH</td>
                                            <td><?= date('d/m/Y', strtotime($element->date())) ?></td>
                                            <td><?= $link ?></td>
                                            <td><a href="#sendMailB<?= $element->id() ?>" data-toggle="modal" data-id="<?= $element->id() ?>" class="btn blue mini" title="Envoyer Email"><i class="icon-envelope-alt"></i></a></td>
                                        </tr>
                                        <!-- SendMail box begin-->
                                        <div id="sendMailB<?= $element->id() ?>" class="modal hide fade in" tabindex="-1" role="dialog" aria-labelledby="login" aria-hidden="false" >
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                                <h3>Envoyer Email</h3>
                                            </div>
                                            <div class="modal-body">
                                                <form class="form-horizontal loginFrm" action="controller/SendMailClientController.php" method="post">
                                                    <div class="control-group">
                                                        <p>Êtes-vous sûr de vouloir envoyer un Email à <?= $client->nom() ?> ?</p>
                                                    </div>
                                                    <div class="control-group">
                                                        <div class="controls">    
                                                            <input type="hidden" name="action" value="updateStatus" />
                                                            <input type="hidden" name="source" value="contrat" />
                                                            <input type="hidden" name="email" value="<?= $client->email() ?>" />
                                                            <input type="hidden" name="client" value="<?= $client->nom() ?>" />
                                                            <input type="hidden" name="datePaiement" value="<?= $element->date() ?>" />
                                                            <button class="btn" data-dismiss="modal"aria-hidden="true">Non</button>
                                                            <button type="submit" class="btn red" aria-hidden="true">Oui</button>
                                                        <div class="controls">
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                        <!-- SendMail box end -->
                                        <!-- updateStatusReglementCasLibreEnRetards box begin-->
                                        <div id="updateStatusReglementCasLibreEnRetards<?= $element->id() ?>" class="modal hide fade in" tabindex="-1" role="dialog" aria-labelledby="login" aria-hidden="false" >
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                                <h3>Modifier status</h3>
                                            </div>
                                            <div class="modal-body">
                                                <form class="form-horizontal loginFrm" action="controller/ReglementPrevuActionController.php" method="post">
                                                    <div class="control-group">
                                                        <p>Êtes-vous sûr de vouloir changer le status de la date prévu ?</p>
                                                        <label class="control-label">Status</label>
                                                        <div class="controls">
                                                            <select name="status">
                                                                <option value="<?= $element->status() ?>"><?php if($element->status()==0){echo 'En cours';}else{echo 'Réglé';} ?></option>
                                                                <option disabled="disabled">-----------</option>
                                                                <option value="0">En cours</option>
                                                                <option value="1">Réglé</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="control-group">
                                                        <div class="controls">    
                                                            <input type="hidden" name="action" value="updateStatus">
                                                            <input type="hidden" name="source" value="contrat">
                                                            <input type="hidden" name="idReglementPrevu" value="<?= $element->id() ?>" />
                                                            <button class="btn" data-dismiss="modal"aria-hidden="true">Non</button>
                                                            <button type="submit" class="btn red" aria-hidden="true">Oui</button>
                                                        <div class="controls">
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                        <!-- updateStatusReglementCasLibreEnRetards box end -->
                                        <?php
                                        }
                                        ?>    
                                    </tbody>
                                </table>
                                <strong>Liste des réglements d'Aujourd'hui</strong>
                                <table class="table table-striped table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th style="width: 20%">Client</th>
                                            <th style="width: 10%">Téléphone</th>
                                            <th style="width: 10%">Projet</th>
                                            <th style="width: 20%">Bien</th>
                                            <th style="width: 10%">Montant</th>
                                            <th style="width: 10%">Date Prévu</th>
                                            <th style="width: 10%">Status</th>
                                            <th style="width: 10%">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        foreach ( $reglementsPrevusToday as $element ) {
                                            $contrat = 
                                            $contratManager->getContratByCode($element->codeContrat());
                                            $client = 
                                            $clientManager->getClientById($contrat->idClient());
                                            $projet = 
                                            $projetManager->getProjetById($contrat->idProjet());
                                            $bien = "";
                                            $typeBien = "";
                                            //if the property is a "Local commercial" we don't need to mention niveau attribute
                                            $niveau = "";
                                            if($contrat->typeBien()=="appartement"){
                                                $appartementManager = new AppartementManager($pdo);
                                                $bien = $appartementManager->getAppartementById($contrat->idBien());
                                                $niveau = $bien->niveau();
                                                $typeBien = "Appartement";
                                            }
                                            else if($contrat->typeBien()=="localCommercial"){
                                                $locauxManager = new LocauxManager($pdo);
                                                $bien = $locauxManager->getLocauxById($contrat->idBien());
                                                $typeBien = "Local Commercial";
                                            }
                                            //activate the update link only for admin's profil
                                            $link = "";
                                            if ( $_SESSION['userMerlaTrav']->profil() == "admin" ) {
                                                $link = '#updateStatusReglementPrevuToday'.$element->id();
                                                $link = '<a href="'.$link.'" data-toggle="modal" data-id="'.$element->id().'" class="btn mini purple blink_me">En cours</a>';
                                            }
                                            else {
                                                $link = '<a class="btn mini purple blink_me">En cours</a>';
                                            }
                                        ?>
                                        <tr>
                                            <td><?= $client->nom() ?></td>
                                            <td><?= $client->telephone1() ?></td>
                                            <td><?= $projet->nom() ?></td>
                                            <td><?= $typeBien.' - '.$niveau.'e: '.$bien->nom() ?></td>
                                            <td><?= number_format($contrat->echeance(), 2, ',', ' ') ?>DH</td>
                                            <td><?= date('d/m/Y', strtotime($element->datePrevu())) ?></td>
                                            <td><?= $link ?></td>
                                            <td><a href="#sendMailC<?= $element->id() ?>" data-toggle="modal" data-id="<?= $element->id() ?>" class="btn blue mini" title="Envoyer Email"><i class="icon-envelope-alt"></i></a></td>
                                        </tr>
                                        <!-- SendMail box begin-->
                                        <div id="sendMailC<?= $element->id() ?>" class="modal hide fade in" tabindex="-1" role="dialog" aria-labelledby="login" aria-hidden="false" >
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                                <h3>Envoyer Email</h3>
                                            </div>
                                            <div class="modal-body">
                                                <form class="form-horizontal loginFrm" action="controller/SendMailClientController.php" method="post">
                                                    <div class="control-group">
                                                        <p>Êtes-vous sûr de vouloir envoyer un Email à <?= $client->nom() ?> ?</p>
                                                    </div>
                                                    <div class="control-group">
                                                        <div class="controls">    
                                                            <input type="hidden" name="action" value="updateStatus" />
                                                            <input type="hidden" name="source" value="contrat" />
                                                            <input type="hidden" name="email" value="<?= $client->email() ?>" />
                                                            <input type="hidden" name="client" value="<?= $client->nom() ?>" />
                                                            <input type="hidden" name="datePaiement" value="<?= $element->datePrevu() ?>" />
                                                            <button class="btn" data-dismiss="modal"aria-hidden="true">Non</button>
                                                            <button type="submit" class="btn red" aria-hidden="true">Oui</button>
                                                        <div class="controls">
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                        <!-- SendMail box end -->
                                        <!-- updateStatusReglementPrevuToday box begin-->
                                        <div id="updateStatusReglementPrevuToday<?= $element->id() ?>" class="modal hide fade in" tabindex="-1" role="dialog" aria-labelledby="login" aria-hidden="false" >
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                                <h3>Modifier status</h3>
                                            </div>
                                            <div class="modal-body">
                                                <form class="form-horizontal loginFrm" action="controller/ReglementPrevuActionController.php" method="post">
                                                    <div class="control-group">
                                                        <p>Êtes-vous sûr de vouloir changer le status de la date prévu ?</p>
                                                        <label class="control-label">Status</label>
                                                        <div class="controls">
                                                            <select name="status">
                                                                <option value="<?= $element->status() ?>"><?php if($element->status()==0){echo 'En cours';}else{echo 'Réglé';} ?></option>
                                                                <option disabled="disabled">-----------</option>
                                                                <option value="0">En cours</option>
                                                                <option value="1">Réglé</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="control-group">
                                                        <div class="controls">    
                                                            <input type="hidden" name="action" value="updateStatus">
                                                            <input type="hidden" name="source" value="contrat">
                                                            <input type="hidden" name="idReglementPrevu" value="<?= $element->id() ?>" />
                                                            <button class="btn" data-dismiss="modal"aria-hidden="true">Non</button>
                                                            <button type="submit" class="btn red" aria-hidden="true">Oui</button>
                                                        <div class="controls">
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                        <!-- updateStatusReglementPrevuToday box end -->
                                        <?php
                                        }
                                        ?>  
                                        <?php
                                        foreach ( $casLibreToday as $element ) {
                                            $contrat = 
                                            $contratManager->getContratByCode($element->codeContrat());
                                            $client = 
                                            $clientManager->getClientById($contrat->idClient());
                                            $projet = 
                                            $projetManager->getProjetById($contrat->idProjet());
                                            $bien = "";
                                            $typeBien = "";
                                            //if the property is a "Local commercial" we don't need to mention niveau attribute
                                            $niveau = "";
                                            if($contrat->typeBien()=="appartement"){
                                                $appartementManager = new AppartementManager($pdo);
                                                $bien = $appartementManager->getAppartementById($contrat->idBien());
                                                $niveau = $bien->niveau();
                                                $typeBien = "Appartement";
                                            }
                                            else if($contrat->typeBien()=="localCommercial"){
                                                $locauxManager = new LocauxManager($pdo);
                                                $bien = $locauxManager->getLocauxById($contrat->idBien());
                                                $typeBien = "Local Commercial";
                                            }
                                            //activate the update link only for admin's profil
                                            $link = "";
                                            if ( $_SESSION['userMerlaTrav']->profil() == "admin" ) {
                                                $link = '#updateStatusReglementCasLibreToday'.$element->id();
                                                $link = '<a href="'.$link.'" data-toggle="modal" data-id="'.$element->id().'" class="btn mini purple blink_me">En cours</a>';
                                            }
                                            else {
                                                $link = '<a class="btn mini purple blink_me">En cours</a>';
                                            }
                                        ?>
                                        <tr>
                                            <td><?= $client->nom() ?></td>
                                            <td><?= $client->telephone1() ?></td>
                                            <td><?= $projet->nom() ?></td>
                                            <td><?= $typeBien.' - '.$niveau.'e: '.$bien->nom() ?></td>
                                            <td><?= number_format($element->montant(), 2, ',', ' ') ?>DH</td>
                                            <td><?= date('d/m/Y', strtotime($element->date())) ?></td>
                                            <td><?= $link ?></td>
                                            <td><a href="#sendMailD<?= $element->id() ?>" data-toggle="modal" data-id="<?= $element->id() ?>" class="btn blue mini" title="Envoyer Email"><i class="icon-envelope-alt"></i></a></td>
                                        </tr>
                                        <!-- SendMail box begin-->
                                        <div id="sendMailD<?= $element->id() ?>" class="modal hide fade in" tabindex="-1" role="dialog" aria-labelledby="login" aria-hidden="false" >
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                                <h3>Envoyer Email</h3>
                                            </div>
                                            <div class="modal-body">
                                                <form class="form-horizontal loginFrm" action="controller/SendMailClientController.php" method="post">
                                                    <div class="control-group">
                                                        <p>Êtes-vous sûr de vouloir envoyer un Email à <?= $client->nom() ?> ?</p>
                                                    </div>
                                                    <div class="control-group">
                                                        <div class="controls">    
                                                            <input type="hidden" name="action" value="updateStatus" />
                                                            <input type="hidden" name="source" value="contrat" />
                                                            <input type="hidden" name="email" value="<?= $client->email() ?>" />
                                                            <input type="hidden" name="client" value="<?= $client->nom() ?>" />
                                                            <input type="hidden" name="datePaiement" value="<?= $element->date() ?>" />
                                                            <button class="btn" data-dismiss="modal"aria-hidden="true">Non</button>
                                                            <button type="submit" class="btn red" aria-hidden="true">Oui</button>
                                                        <div class="controls">
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                        <!-- SendMail box end -->
                                        <!-- updateStatusReglementCasLibreToday box begin-->
                                        <div id="updateStatusReglementCasLibreToday<?= $element->id() ?>" class="modal hide fade in" tabindex="-1" role="dialog" aria-labelledby="login" aria-hidden="false" >
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                                <h3>Modifier status</h3>
                                            </div>
                                            <div class="modal-body">
                                                <form class="form-horizontal loginFrm" action="controller/ContratCasLibreActionController.php" method="post">
                                                    <div class="control-group">
                                                        <p>Êtes-vous sûr de vouloir changer le status de la date prévu ?</p>
                                                        <label class="control-label">Status</label>
                                                        <div class="controls">
                                                            <select name="status">
                                                                <option value="<?= $element->status() ?>"><?php if($element->status()==0){echo 'En cours';}else{echo 'Réglé';} ?></option>
                                                                <option disabled="disabled">-----------</option>
                                                                <option value="0">En cours</option>
                                                                <option value="1">Réglé</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="control-group">
                                                        <div class="controls">    
                                                            <input type="hidden" name="action" value="updateStatus">
                                                            <input type="hidden" name="source" value="contrat">
                                                            <input type="hidden" name="idReglementPrevu" value="<?= $element->id() ?>" />
                                                            <button class="btn" data-dismiss="modal"aria-hidden="true">Non</button>
                                                            <button type="submit" class="btn red" aria-hidden="true">Oui</button>
                                                        <div class="controls">
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                        <!-- updateStatusReglementCasLibreToday box end -->
                                        <?php
                                        }
                                        ?>
                                    </tbody>
                                </table>
                                <strong>Liste des réglements de cette semain</strong>
                                <table class="table table-striped table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th style="width: 20%">Client</th>
                                            <th style="width: 10%">Téléphone</th>
                                            <th style="width: 10%">Projet</th>
                                            <th style="width: 20%">Bien</th>
                                            <th style="width: 10%">Montant</th>
                                            <th style="width: 10%">Date Prévu</th>
                                            <th style="width: 10%">Status</th>
                                            <th style="width: 10%">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        foreach ( $reglementsPrevusWeek as $element ) {
                                            $contrat = 
                                            $contratManager->getContratByCode($element->codeContrat());
                                            $client = 
                                            $clientManager->getClientById($contrat->idClient());
                                            $projet = 
                                            $projetManager->getProjetById($contrat->idProjet());
                                            $bien = "";
                                            $typeBien = "";
                                            //if the property is a "Local commercial" we don't need to mention niveau attribute
                                            $niveau = "";
                                            if($contrat->typeBien()=="appartement"){
                                                $appartementManager = new AppartementManager($pdo);
                                                $bien = $appartementManager->getAppartementById($contrat->idBien());
                                                $niveau = $bien->niveau();
                                                $typeBien = "Appartement";
                                            }
                                            else if($contrat->typeBien()=="localCommercial"){
                                                $locauxManager = new LocauxManager($pdo);
                                                $bien = $locauxManager->getLocauxById($contrat->idBien());
                                                $typeBien = "Local Commercial";
                                            }
                                            //activate the update link only for admin's profil
                                            $link = "";
                                            if ( $_SESSION['userMerlaTrav']->profil() == "admin" ) {
                                                $link = '#updateStatusReglementPrevuWeek'.$element->id();
                                                $link = '<a href="'.$link.'" data-toggle="modal" data-id="'.$element->id().'" class="btn mini green">En cours</a>';
                                            }
                                            else {
                                                $link = '<a class="btn mini green">En cours</a>';
                                            }
                                        ?>
                                        <tr>
                                            <td><?= $client->nom() ?></td>
                                            <td><?= $client->telephone1() ?></td>
                                            <td><?= $projet->nom() ?></td>
                                            <td><?= $typeBien.' - '.$niveau.'e: '.$bien->nom() ?></td>
                                            <td><?= number_format($contrat->echeance(), 2, ',', ' ') ?>DH</td>
                                            <td><?= date('d/m/Y', strtotime($element->datePrevu())) ?></td>
                                            <td><?= $link ?></td>
                                            <td><a href="#sendMailE<?= $element->id() ?>" data-toggle="modal" data-id="<?= $element->id() ?>" class="btn blue mini" title="Envoyer Email"><i class="icon-envelope-alt"></i></a></td>
                                        </tr>
                                        <!-- SendMail box begin-->
                                        <div id="sendMailE<?= $element->id() ?>" class="modal hide fade in" tabindex="-1" role="dialog" aria-labelledby="login" aria-hidden="false" >
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                                <h3>Envoyer Email</h3>
                                            </div>
                                            <div class="modal-body">
                                                <form class="form-horizontal loginFrm" action="controller/SendMailClientController.php" method="post">
                                                    <div class="control-group">
                                                        <p>Êtes-vous sûr de vouloir envoyer un Email à <?= $client->nom() ?> ?</p>
                                                    </div>
                                                    <div class="control-group">
                                                        <div class="controls">    
                                                            <input type="hidden" name="action" value="updateStatus" />
                                                            <input type="hidden" name="source" value="contrat" />
                                                            <input type="hidden" name="email" value="<?= $client->email() ?>" />
                                                            <input type="hidden" name="client" value="<?= $client->nom() ?>" />
                                                            <input type="hidden" name="datePaiement" value="<?= $element->datePrevu() ?>" />
                                                            <button class="btn" data-dismiss="modal"aria-hidden="true">Non</button>
                                                            <button type="submit" class="btn red" aria-hidden="true">Oui</button>
                                                        <div class="controls">
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                        <!-- SendMail box end -->
                                        <!-- updateStatusReglementPrevuToday box begin-->
                                        <div id="updateStatusReglementPrevuWeek<?= $element->id() ?>" class="modal hide fade in" tabindex="-1" role="dialog" aria-labelledby="login" aria-hidden="false" >
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                                <h3>Modifier status</h3>
                                            </div>
                                            <div class="modal-body">
                                                <form class="form-horizontal loginFrm" action="controller/ReglementPrevuActionController.php" method="post">
                                                    <div class="control-group">
                                                        <p>Êtes-vous sûr de vouloir changer le status de la date prévu ?</p>
                                                        <label class="control-label">Status</label>
                                                        <div class="controls">
                                                            <select name="status">
                                                                <option value="<?= $element->status() ?>"><?php if($element->status()==0){echo 'En cours';}else{echo 'Réglé';} ?></option>
                                                                <option disabled="disabled">-----------</option>
                                                                <option value="0">En cours</option>
                                                                <option value="1">Réglé</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="control-group">
                                                        <div class="controls">    
                                                            <input type="hidden" name="action" value="updateStatus">
                                                            <input type="hidden" name="source" value="contrat">
                                                            <input type="hidden" name="idReglementPrevu" value="<?= $element->id() ?>" />
                                                            <button class="btn" data-dismiss="modal"aria-hidden="true">Non</button>
                                                            <button type="submit" class="btn red" aria-hidden="true">Oui</button>
                                                        <div class="controls">
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                        <!-- updateStatusReglementPrevuWeek box end -->
                                        <?php
                                        }
                                        ?>  
                                        <?php
                                        foreach ( $casLibreWeek as $element ) {
                                            $contrat = 
                                            $contratManager->getContratByCode($element->codeContrat());
                                            $client = 
                                            $clientManager->getClientById($contrat->idClient());
                                            $projet = 
                                            $projetManager->getProjetById($contrat->idProjet());
                                            $bien = "";
                                            $typeBien = "";
                                            //if the property is a "Local commercial" we don't need to mention niveau attribute
                                            $niveau = "";
                                            if($contrat->typeBien()=="appartement"){
                                                $appartementManager = new AppartementManager($pdo);
                                                $bien = $appartementManager->getAppartementById($contrat->idBien());
                                                $niveau = $bien->niveau();
                                                $typeBien = "Appartement";
                                            }
                                            else if($contrat->typeBien()=="localCommercial"){
                                                $locauxManager = new LocauxManager($pdo);
                                                $bien = $locauxManager->getLocauxById($contrat->idBien());
                                                $typeBien = "Local Commercial";
                                            }
                                            //activate the update link only for admin's profil
                                            $link = "";
                                            if ( $_SESSION['userMerlaTrav']->profil() == "admin" ) {
                                                $link = '#updateStatusReglementCasLibreWeek'.$element->id();
                                                $link = '<a href="'.$link.'" data-toggle="modal" data-id="'.$element->id().'" class="btn mini green">En cours</a>';
                                            }
                                            else {
                                                $link = '<a class="btn mini green">En cours</a>';
                                            }
                                        ?>
                                        <tr>
                                            <td><?= $client->nom() ?></td>
                                            <td><?= $client->telephone1() ?></td>
                                            <td><?= $projet->nom() ?></td>
                                            <td><?= $typeBien.' - '.$niveau.'e: '.$bien->nom() ?></td>
                                            <td><?= number_format($element->montant(), 2, ',', ' ') ?>DH</td>
                                            <td><?= date('d/m/Y', strtotime($element->date())) ?></td>
                                            <td><?= $link ?></td>
                                            <td><a href="#sendMailF<?= $element->id() ?>" data-toggle="modal" data-id="<?= $element->id() ?>" class="btn blue mini" title="Envoyer Email"><i class="icon-envelope-alt"></i></a></td>
                                        </tr>
                                        <!-- SendMail box begin-->
                                        <div id="sendMailF<?= $element->id() ?>" class="modal hide fade in" tabindex="-1" role="dialog" aria-labelledby="login" aria-hidden="false" >
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                                <h3>Envoyer Email</h3>
                                            </div>
                                            <div class="modal-body">
                                                <form class="form-horizontal loginFrm" action="controller/SendMailClientController.php" method="post">
                                                    <div class="control-group">
                                                        <p>Êtes-vous sûr de vouloir envoyer un Email à <?= $client->nom() ?> ?</p>
                                                    </div>
                                                    <div class="control-group">
                                                        <div class="controls">    
                                                            <input type="hidden" name="action" value="updateStatus" />
                                                            <input type="hidden" name="source" value="contrat" />
                                                            <input type="hidden" name="email" value="<?= $client->email() ?>" />
                                                            <input type="hidden" name="client" value="<?= $client->nom() ?>" />
                                                            <input type="hidden" name="datePaiement" value="<?= $element->date() ?>" />
                                                            <button class="btn" data-dismiss="modal"aria-hidden="true">Non</button>
                                                            <button type="submit" class="btn red" aria-hidden="true">Oui</button>
                                                        <div class="controls">
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                        <!-- SendMail box end -->
                                        <!-- updateStatusReglementCasLibreWeek box begin-->
                                        <div id="updateStatusReglementCasLibreWeek<?= $element->id() ?>" class="modal hide fade in" tabindex="-1" role="dialog" aria-labelledby="login" aria-hidden="false" >
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                                <h3>Modifier status</h3>
                                            </div>
                                            <div class="modal-body">
                                                <form class="form-horizontal loginFrm" action="controller/ContratCasLibreActionController.php" method="post">
                                                    <div class="control-group">
                                                        <p>Êtes-vous sûr de vouloir changer le status de la date prévu ?</p>
                                                        <label class="control-label">Status</label>
                                                        <div class="controls">
                                                            <select name="status">
                                                                <option value="<?= $element->status() ?>"><?php if($element->status()==0){echo 'En cours';}else{echo 'Réglé';} ?></option>
                                                                <option disabled="disabled">-----------</option>
                                                                <option value="0">En cours</option>
                                                                <option value="1">Réglé</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="control-group">
                                                        <div class="controls">    
                                                            <input type="hidden" name="action" value="updateStatus">
                                                            <input type="hidden" name="source" value="contrat">
                                                            <input type="hidden" name="idReglementPrevu" value="<?= $element->id() ?>" />
                                                            <button class="btn" data-dismiss="modal"aria-hidden="true">Non</button>
                                                            <button type="submit" class="btn red" aria-hidden="true">Oui</button>
                                                        <div class="controls">
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                        <!-- updateStatusReglementCasLibreWeek box end -->
                                        <?php
                                        }
                                        ?>
                                    </tbody>
                                </table>
                                <strong>Liste des réglements de ce mois</strong>
                                <table class="table table-striped table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th style="width: 20%">Client</th>
                                            <th style="width: 10%">Téléphone</th>
                                            <th style="width: 10%">Projet</th>
                                            <th style="width: 20%">Bien</th>
                                            <th style="width: 10%">Montant</th>
                                            <th style="width: 10%">Date Prévu</th>
                                            <th style="width: 10%">Status</th>
                                            <th style="width: 10%">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        foreach ( $reglementsPrevusMonth as $element ) {
                                            $contrat = 
                                            $contratManager->getContratByCode($element->codeContrat());
                                            $client = 
                                            $clientManager->getClientById($contrat->idClient());
                                            $projet = 
                                            $projetManager->getProjetById($contrat->idProjet());
                                            $bien = "";
                                            $typeBien = "";
                                            $nomBien = "";
                                            //if the property is a "Local commercial" we don't need to mention niveau attribute
                                            $niveau = "";
                                            if($contrat->typeBien()=="appartement"){
                                                $appartementManager = new AppartementManager($pdo);
                                                $bien = $appartementManager->getAppartementById($contrat->idBien());
                                                $nomBien = $bien->nom();
                                                $niveau = $bien->niveau();
                                                $typeBien = "Appartement";
                                            }
                                            else if($contrat->typeBien()=="localCommercial"){
                                                $locauxManager = new LocauxManager($pdo);
                                                $bien = $locauxManager->getLocauxById($contrat->idBien());
                                                $nomBien = $bien->nom();
                                                $typeBien = "Local Commercial";
                                            }
                                            //activate the update link only for admin's profil
                                            $link = "";
                                            if ( $_SESSION['userMerlaTrav']->profil() == "admin" ) {
                                                $link = '#updateStatusReglementPrevuMonth'.$element->id();
                                                $link = '<a href="'.$link.'" data-toggle="modal" data-id="'.$element->id().'" class="btn mini blue">En cours</a>';
                                            }
                                            else {
                                                $link = '<a class="btn mini blue">En cours</a>';
                                            }
                                        ?>
                                        <tr>
                                            <td><?= $client->nom() ?></td>
                                            <td><?= $client->telephone1() ?></td>
                                            <td><?= $projet->nom() ?></td>
                                            <td><?= $typeBien.' - '.$niveau.'e: '.$nomBien ?></td>
                                            <td><?= number_format($contrat->echeance(), 2, ',', ' ') ?>DH</td>
                                            <td><?= date('d/m/Y', strtotime($element->datePrevu())) ?></td>
                                            <td><?= $link ?></td>
                                            <td><a href="#sendMailG<?= $element->id() ?>" data-toggle="modal" data-id="<?= $element->id() ?>" class="btn blue mini" title="Envoyer Email"><i class="icon-envelope-alt"></i></a></td>
                                        </tr>
                                        <!-- SendMail box begin-->
                                        <div id="sendMailG<?= $element->id() ?>" class="modal hide fade in" tabindex="-1" role="dialog" aria-labelledby="login" aria-hidden="false" >
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                                <h3>Envoyer Email</h3>
                                            </div>
                                            <div class="modal-body">
                                                <form class="form-horizontal loginFrm" action="controller/SendMailClientController.php" method="post">
                                                    <div class="control-group">
                                                        <p>Êtes-vous sûr de vouloir envoyer un Email à <?= $client->nom() ?> ?</p>
                                                    </div>
                                                    <div class="control-group">
                                                        <div class="controls">    
                                                            <input type="hidden" name="action" value="updateStatus" />
                                                            <input type="hidden" name="source" value="contrat" />
                                                            <input type="hidden" name="email" value="<?= $client->email() ?>" />
                                                            <input type="hidden" name="client" value="<?= $client->nom() ?>" />
                                                            <input type="hidden" name="datePaiement" value="<?= $element->datePrevu() ?>" />
                                                            <button class="btn" data-dismiss="modal"aria-hidden="true">Non</button>
                                                            <button type="submit" class="btn red" aria-hidden="true">Oui</button>
                                                        <div class="controls">
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                        <!-- SendMail box end -->
                                        <!-- updateStatusReglementPrevuToday box begin-->
                                        <div id="updateStatusReglementPrevuMonth<?= $element->id() ?>" class="modal hide fade in" tabindex="-1" role="dialog" aria-labelledby="login" aria-hidden="false" >
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                                <h3>Modifier status</h3>
                                            </div>
                                            <div class="modal-body">
                                                <form class="form-horizontal loginFrm" action="controller/ReglementPrevuActionController.php" method="post">
                                                    <div class="control-group">
                                                        <p>Êtes-vous sûr de vouloir changer le status de la date prévu ?</p>
                                                        <label class="control-label">Status</label>
                                                        <div class="controls">
                                                            <select name="status">
                                                                <option value="<?= $element->status() ?>"><?php if($element->status()==0){echo 'En cours';}else{echo 'Réglé';} ?></option>
                                                                <option disabled="disabled">-----------</option>
                                                                <option value="0">En cours</option>
                                                                <option value="1">Réglé</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="control-group">
                                                        <div class="controls">    
                                                            <input type="hidden" name="action" value="updateStatus">
                                                            <input type="hidden" name="source" value="contrat">
                                                            <input type="hidden" name="idReglementPrevu" value="<?= $element->id() ?>" />
                                                            <button class="btn" data-dismiss="modal"aria-hidden="true">Non</button>
                                                            <button type="submit" class="btn red" aria-hidden="true">Oui</button>
                                                        <div class="controls">
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                        <!-- updateStatusReglementPrevuMonth box end -->
                                        <?php
                                        }
                                        ?>  
                                        <?php
                                        foreach ( $casLibreMonth as $element ) {
                                            $contrat = 
                                            $contratManager->getContratByCode($element->codeContrat());
                                            $client = 
                                            $clientManager->getClientById($contrat->idClient());
                                            $projet = 
                                            $projetManager->getProjetById($contrat->idProjet());
                                            $bien = "";
                                            $typeBien = "";
                                            //if the property is a "Local commercial" we don't need to mention niveau attribute
                                            $niveau = "";
                                            if($contrat->typeBien()=="appartement"){
                                                $appartementManager = new AppartementManager($pdo);
                                                $bien = $appartementManager->getAppartementById($contrat->idBien());
                                                $niveau = $bien->niveau();
                                                $typeBien = "Appartement";
                                            }
                                            else if($contrat->typeBien()=="localCommercial"){
                                                $locauxManager = new LocauxManager($pdo);
                                                $bien = $locauxManager->getLocauxById($contrat->idBien());
                                                $typeBien = "Local Commercial";
                                            }
                                            //activate the update link only for admin's profil
                                            $link = "";
                                            if ( $_SESSION['userMerlaTrav']->profil() == "admin" ) {
                                                $link = '#updateStatusReglementCasLibreMonth'.$element->id();
                                                $link = '<a href="'.$link.'" data-toggle="modal" data-id="'.$element->id().'" class="btn mini blue">En cours</a>';
                                            }
                                            else {
                                                $link = '<a class="btn mini blue">En cours</a>';
                                            }
                                        ?>
                                        <tr>
                                            <td><?= $client->nom() ?></td>
                                            <td><?= $client->telephone1() ?></td>
                                            <td><?= $projet->nom() ?></td>
                                            <td><?= $typeBien.' - '.$niveau.'e: '.$bien->nom() ?></td>
                                            <td><?= number_format($element->montant(), 2, ',', ' ') ?>DH</td>
                                            <td><?= date('d/m/Y', strtotime($element->date())) ?></td>
                                            <td><?= $link ?></td>
                                            <td><a href="#sendMailH<?= $element->id() ?>" data-toggle="modal" data-id="<?= $element->id() ?>" class="btn blue mini" title="Envoyer Email"><i class="icon-envelope-alt"></i></a></td>
                                        </tr>
                                        <!-- SendMail box begin-->
                                        <div id="sendMailH<?= $element->id() ?>" class="modal hide fade in" tabindex="-1" role="dialog" aria-labelledby="login" aria-hidden="false" >
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                                <h3>Envoyer Email</h3>
                                            </div>
                                            <div class="modal-body">
                                                <form class="form-horizontal loginFrm" action="controller/SendMailClientController.php" method="post">
                                                    <div class="control-group">
                                                        <p>Êtes-vous sûr de vouloir envoyer un Email à <?= $client->nom() ?> ?</p>
                                                    </div>
                                                    <div class="control-group">
                                                        <div class="controls">    
                                                            <input type="hidden" name="action" value="updateStatus" />
                                                            <input type="hidden" name="source" value="contrat" />
                                                            <input type="hidden" name="email" value="<?= $client->email() ?>" />
                                                            <input type="hidden" name="client" value="<?= $client->nom() ?>" />
                                                            <input type="hidden" name="datePaiement" value="<?= $element->date() ?>" />
                                                            <button class="btn" data-dismiss="modal"aria-hidden="true">Non</button>
                                                            <button type="submit" class="btn red" aria-hidden="true">Oui</button>
                                                        <div class="controls">
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                        <!-- SendMail box end -->
                                        <!-- updateStatusReglementCasLibreMonth box begin-->
                                        <div id="updateStatusReglementCasLibreMonth<?= $element->id() ?>" class="modal hide fade in" tabindex="-1" role="dialog" aria-labelledby="login" aria-hidden="false" >
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                                <h3>Modifier status</h3>
                                            </div>
                                            <div class="modal-body">
                                                <form class="form-horizontal loginFrm" action="controller/ContratCasLibreActionController.php" method="post">
                                                    <div class="control-group">
                                                        <p>Êtes-vous sûr de vouloir changer le status de la date prévu ?</p>
                                                        <label class="control-label">Status</label>
                                                        <div class="controls">
                                                            <select name="status">
                                                                <option value="<?= $element->status() ?>"><?php if($element->status()==0){echo 'En cours';}else{echo 'Réglé';} ?></option>
                                                                <option disabled="disabled">-----------</option>
                                                                <option value="0">En cours</option>
                                                                <option value="1">Réglé</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="control-group">
                                                        <div class="controls">    
                                                            <input type="hidden" name="action" value="updateStatus">
                                                            <input type="hidden" name="source" value="contrat">
                                                            <input type="hidden" name="idReglementPrevu" value="<?= $element->id() ?>" />
                                                            <button class="btn" data-dismiss="modal"aria-hidden="true">Non</button>
                                                            <button type="submit" class="btn red" aria-hidden="true">Oui</button>
                                                        <div class="controls">
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                        <!-- updateStatusReglementCasLibreMonth box end -->
                                        <?php
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>       
                    </div>
                    <!-- DATES REGLEMENTS PREVU END -->
                    <!-- CONTRAT CAS LIBRE BEGIN -->
                    <!-- CONTRAT CAS LIBRE END -->
                   </div>
                </div>
                <!-- END PAGE CONTENT -->
            </div>
            <!-- END PAGE CONTAINER-->
        </div>
        <!-- END PAGE -->
    </div>
    <!-- END CONTAINER -->
    <!-- BEGIN FOOTER -->
    <div class="footer">
        2015 &copy; ImmoERP. Management Application.
        <div class="span pull-right">
            <span class="go-top"><i class="icon-angle-up"></i></span>
        </div>
    </div>
    <!-- END FOOTER -->
    <!-- BEGIN JAVASCRIPTS -->
    <!-- Load javascripts at bottom, this will reduce page load time -->
    <script src="assets/js/jquery-1.8.3.min.js"></script>   
    <script src="assets/breakpoints/breakpoints.js"></script>   
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>        
    <script src="assets/js/jquery.blockui.js"></script>
    <script src="assets/js/jquery.cookie.js"></script>
    <script src="assets/fancybox/source/jquery.fancybox.pack.js"></script>
    <script src="assets/fullcalendar/fullcalendar/fullcalendar.min.js"></script>    
    <script type="text/javascript" src="assets/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
    <script type="text/javascript" src="assets/bootstrap-daterangepicker/date.js"></script>
    <!-- ie8 fixes -->
    <!--[if lt IE 9]>
    <script src="assets/js/excanvas.js"></script>
    <script src="assets/js/respond.js"></script>
    <![endif]-->    
    <script type="text/javascript" src="assets/uniform/jquery.uniform.min.js"></script>
    <script type="text/javascript" src="assets/data-tables/jquery.dataTables.js"></script>
    <script type="text/javascript" src="assets/data-tables/DT_bootstrap.js"></script>
    <script src="assets/js/app.js"></script>        
    <script>
        jQuery(document).ready(function() {         
            // initiate layout and plugins
            App.setPage("table_managed");
            $('.hidenBlock').hide();
            App.init();
        });
    </script>
    <script>
        function blinker() {
            $('.blink_me').fadeOut(500);
            $('.blink_me').fadeIn(500);
        }
        setInterval(blinker, 1500);
    </script>
</body>
<!-- END BODY -->
</html>
<?php
}
/*else if(isset($_SESSION['userMerlaTrav']) and $_SESSION->profil()!="admin"){
    header('Location:dashboard.php');
}*/
else{
    header('Location:index.php');    
}

?>
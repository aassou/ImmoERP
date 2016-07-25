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
    if( isset($_SESSION['userMerlaTrav']) ){
    	//les sources
    	$idProjet = 0;
    	$projetManager = new ProjetManager($pdo);
		if(isset($_GET['idProjet']) and ($_GET['idProjet'])>0 and $_GET['idProjet']<=$projetManager->getLastId()){
			$idProjet = $_GET['idProjet'];
			$projet = $projetManager->getProjetById($idProjet);
			$appartementManager = new AppartementManager($pdo);
            $contratManager = new ContratManager($pdo);
            $clientManager = new ClientManager($pdo);
			$appartements = "";
			//test the appartement object number: if exists get appartement else do nothing
			$appartementNumber = $appartementManager->getAppartementNumberByIdProjet($idProjet);
			if($appartementNumber != 0){
				/*$appartementPerPage = 10;
		        $pageNumber = ceil($appartementNumber/$appartementPerPage);
		        $p = 1;
		        if(isset($_GET['p']) and ($_GET['p']>0 and $_GET['p']<=$pageNumber)){
		            $p = $_GET['p'];
		        }
		        else{
		            $p = 1;
		        }
		        $begin = ($p - 1) * $appartementPerPage;
		        $pagination = paginate('appartements.php?idProjet='.$idProjet, '&p=', $pageNumber, $p);*/
				$appartements = $appartementManager->getAppartementByIdProjet($idProjet);	
			}
		}
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
							Gestion des Appartements - Projet : <strong><?= $projet->nom() ?></strong>   
						</h3>
						<ul class="breadcrumb">
							<li>
								<i class="icon-home"></i>
								<a href="dashboard.php">Accueil</a> 
								<i class="icon-angle-right"></i>
							</li>
							<li>
								<i class="icon-briefcase"></i>
								<a href="projets.php">Gestion des projets</a>
								<i class="icon-angle-right"></i>
							</li>
							<li>
                                <a href="projet-details.php?idProjet=<?= $projet->id() ?>">Projet <strong><?= $projet->nom() ?></strong></a>
                                <i class="icon-angle-right"></i>
                            </li>
							<li><a>Gestion des appartements</a></li>
						</ul>
						<!-- END PAGE TITLE & BREADCRUMB-->
					</div>
				</div>
				<!-- END PAGE HEADER-->
				<!-- BEGIN PAGE CONTENT-->
				<?php if($idProjet!=0){ ?>
				<div class="row-fluid"> 
					<div class="span12">
						<div class="get-down">
						    <input class="m-wrap" name="criteria" id="criteria" type="text" placeholder="Chercher Par Code, Status..." />
						    <?php
                            if ( 
                                $_SESSION['userMerlaTrav']->profil()=="admin" ||
                                $_SESSION['userMerlaTrav']->profil()=="manager" 
                            ) {
                            ?>
							<a href="#addAppartement" class="pull-right btn icn-only green" data-toggle="modal">Ajouter Nouvel Appartement <i class="icon-plus-sign m-icon-white"></i></a>
							<?php
                            }
                            ?>
                            <a href="controller/AppatementsListPrintController.php?idProjet=<?= $idProjet ?>" class="pull-right btn icn-only blue stay-away" data-toggle="modal"><i class="icon-print m-icon-white"></i> Version Imprimable</a>
						</div>
						<!-- addAppartement box begin-->
                        <div id="addAppartement" class="modal hide fade in" tabindex="-1" role="dialog" aria-labelledby="login" aria-hidden="false" >
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                <h3>Ajouter Nouvel Appartement</h3>
                            </div>
                            <div class="modal-body">
                                <form class="form-horizontal" action="controller/AppartementActionController.php" method="post">
                                    <div class="control-group">
                                        <label class="control-label">Code</label>
                                        <div class="controls">
                                            <input type="text" name="code" />
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label">Supérficie</label>
                                        <div class="controls">
                                            <input type="text" name="superficie" />
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label">Façade</label>
                                        <div class="controls">
                                            <input type="text" name="facade" />
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label">Nombre de pièces</label>
                                        <div class="controls">
                                            <input type="text" name="nombrePiece" />
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label">Prix</label>
                                        <div class="controls">
                                            <input type="text" name="prix" />
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label" for="niveau">Niveau</label>
                                        <div class="controls">
                                            <select style="width:150px" name="niveau" class="m-wrap">
                                                <option value="RC">RC</option>
                                                <option value="Mezzanine">Mezzanine</option>
                                                <option value="1">1</option>
                                                <option value="2">2</option>
                                                <option value="3">3</option>
                                                <option value="4">4</option>
                                                <option value="5">5</option>
                                                <option value="6">6</option>
                                                <option value="7">7</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label" for="status">Status</label>
                                        <div class="controls">
                                            <select style="width:150px" name="status" id="status" class="m-wrap">
                                                <option value="Disponible">Disponible</option>
                                                <option value="Réservé">Réservé</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label" for="cave">Cave</label>
                                        <div class="controls">
                                            <select style="width:150px" name="cave" class="m-wrap">
                                                <option value="Avec">Avec</option>
                                                <option value="Sans">Sans</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="control-group" id="par" style="display: none">
                                        <label class="control-label">Réservé par </label>
                                        <div class="controls">
                                            <input type="text" name="par" class="m-wrap">
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <div class="controls">
                                            <input type="hidden" name="action" value="add" />  
                                            <input type="hidden" name="idProjet" value="<?= $idProjet ?>" />
                                            <button class="btn" data-dismiss="modal"aria-hidden="true">Non</button>
                                            <button type="submit" class="btn red" aria-hidden="true">Oui</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <!-- addAppartement box end -->
						<!-- BEGIN Terrain TABLE PORTLET-->
						<?php 
						if(isset($_SESSION['appartement-action-message']) 
						and isset($_SESSION['appartement-type-message'])){ 
						      $message = $_SESSION['appartement-action-message'];
                              $typeMessage = $_SESSION['appartement-type-message'];
						?>
						    <br><br>
                         	<div class="alert alert-<?= $typeMessage ?>">
								<button class="close" data-dismiss="alert"></button>
							    <?= $message ?>
							</div>
                         <?php } 
                         	unset($_SESSION['appartement-action-message']);
                            unset($_SESSION['appartement-type-message']);
                         ?>
						<div class="portlet appartements">
							<div class="portlet-body">
							    <div class="scroller" data-height="500px" data-always-visible="1"><!-- BEGIN DIV SCROLLER -->
								<table class="table table-striped table-bordered table-advance table-hover">
									<thead>
										<tr>
											<th style="width: 10%">Code</th>
											<th style="width: 5%">Niveau</th>
											<!--th style="width: 15%">Prix&nbsp;DH</th-->
											<th style="width: 10%">Superficie</th>
											<th style="width: 5%">Façade</th>
											<th style="width: 30%">Nbr.Pièces</th>
											<th style="width: 5%">Cave</th>
											<th style="width: 10%">Status</th>
											<th style="width: 15%"></th>
										</tr>
									</thead>
									<tbody>
										<?php
										if($appartementNumber != 0){
										foreach($appartements as $appartement){
										?>		
										<tr class="appartements">
											<td>
												<div class="btn-group">
												    <a style="width: 50px" class="btn mini dropdown-toggle" href="#" title="Prix : <?= number_format($appartement->prix(), 2, ',', ' ') ?> DH" data-toggle="dropdown">
												    	<?= $appartement->nom() ?> 
												        <i class="icon-angle-down"></i>
												    </a>
												    <?php
                                                    if ( 
                                                        $_SESSION['userMerlaTrav']->profil()=="admin" ||
                                                        $_SESSION['userMerlaTrav']->profil()=="manager"    
                                                    ) {
                                                    ?>
												    <ul class="dropdown-menu">
												        <li>
												        	<a href="appartement-detail.php?idAppartement=<?= $appartement->id() ?>&idProjet=<?= $appartement->idProjet() ?>">
																Fiche descriptif
															</a>
												        	<a href="#addPieces<?= $appartement->id() ?>" data-toggle="modal" data-id="<?= $appartement->id() ?>">
																Ajouter Document
															</a>
												        	<a href="#updateAppartement<?= $appartement->id();?>" data-toggle="modal" data-id="<?= $appartement->id(); ?>">
																Modifier
															</a>
															<?php
															if ( $appartement->status() != "Vendu" ) {
															?>
															<a href="#deleteAppartement<?= $appartement->id();?>" data-toggle="modal" data-id="<?= $appartement->id(); ?>">
																Supprimer
															</a>
															<?php  
                                                            }
                                                            ?>
												        </li>
												    </ul>
												    <?php
                                                    }
                                                    ?>
												</div>
											</td>
											<td class="hidden-phone"><?= $appartement->niveau() ?>Et</td>
											<!--td><a></a></td-->
											<td><?= $appartement->superficie() ?> m<sup>2</sup></td>
											<td class="hidden-phone"><?= $appartement->facade() ?></td>
											<td class="hidden-phone"><?= $appartement->nombrePiece() ?> pièces</td>
											<td class="hidden-phone">
												<?php if($appartement->cave()=="Sans"){ ?><a class="btn mini black">Sans</a><?php } ?>
												<?php if($appartement->cave()=="Avec"){ ?><a class="btn mini blue">Avec</a><?php } ?>
											</td>
											<td>
												<?php
												if ( $appartement->status()=="Disponible" ) {
                                                    if ( 
                                                        $_SESSION['userMerlaTrav']->profil()=="admin" ||
                                                        $_SESSION['userMerlaTrav']->profil()=="manager"    
                                                    ) {    
												?>
													<a class="btn mini green" href="#changeToReserve<?= $appartement->id() ?>" data-toggle="modal" data-id="<?= $appartement->id() ?>">
														Disponible
													</a>
												<?php 
                                                    }
                                                    else {
                                                ?>
                                                    <a class="btn mini green">
                                                        Disponible
                                                    </a>
                                                <?php        
                                                    } 
                                                }    
                                                ?>
												<?php 
												if ( $appartement->status()=="R&eacute;serv&eacute;" ) {
												     if ( 
												        $_SESSION['userMerlaTrav']->profil()=="admin" ||
                                                        $_SESSION['userMerlaTrav']->profil()=="manager"
                                                     ) {   
												?>
													<a class="btn mini red" href="#changeToDisponible<?= $appartement->id() ?>" data-toggle="modal" data-id="<?= $appartement->id() ?>">
														Réservé
													</a>
												<?php
                                                     }
                                                     else {
                                                ?>
                                                    <a class="btn mini red">
                                                        Réservé
                                                    </a>
                                                <?php         
                                                     }
                                                } 
                                                ?>
												<?php 
												if ( $appartement->status()=="Vendu" ) { 
												?>
													<a class="btn mini blue">Vendu</a>
												<?php 
                                                } 
                                                ?>
											</td>
											<td class="hidden-phone">
												<?php
												if( $appartement->status()=="R&eacute;serv&eacute;" ){
												    if ( 
												        $_SESSION['userMerlaTrav']->profil()=="admin" || 
                                                        $_SESSION['userMerlaTrav']->profil()=="manager"    
                                                    ) {
												?>
												<a class="btn mini" title="<?= $appartement->par() ?>" href="#updateClient<?= $appartement->id() ?>" data-toggle="modal" data-id="<?= $appartement->id() ?>">
													Pour
												</a>
												<?php
                                                    }
                                                    else{
                                                ?>
                                                <a class="btn mini" title="<?= $appartement->par() ?>">
                                                    Pour
                                                </a>    
                                                <?php        
                                                    }
												}
                                                else if( $appartement->status()=="Vendu" ){
                                                ?>
                                                    <a class="btn mini" title="<?= $clientManager->getClientById($contratManager->getIdClientByIdProjetByIdBienTypeBien($idProjet, $appartement->id(), "appartement"))->nom() ?>">
                                                        Pour
                                                    </a>
                                                <?php    
                                                }
												?>
											</td>
										</tr>
										<!-- change to disponible box begin-->
										<div id="changeToDisponible<?= $appartement->id() ?>" class="modal hide fade in" tabindex="-1" role="dialog" aria-labelledby="login" aria-hidden="false" >
											<div class="modal-header">
												<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
												<h3>Changer le status vers "Disponible"</h3>
											</div>
											<div class="modal-body">
												<form class="form-horizontal" action="controller/AppartementActionController.php" method="post" enctype="multipart/form-data">
													<p>Êtes-vous sûr de vouloir changer le status de 
														<a class="btn mini red">Réservé</a> vers 
														<a class="btn mini green">Disponible</a> ?</p>
													<div class="control-group">
													    <input type="hidden" name="action" value="updateStatus" />
														<input type="hidden" name="status" value="Disponible" />
														<input type="hidden" name="idAppartement" value="<?= $appartement->id() ?>" />
														<input type="hidden" name="idProjet" value="<?= $idProjet ?>" />
														<button class="btn" data-dismiss="modal"aria-hidden="true">Non</button>
														<button type="submit" class="btn red" aria-hidden="true">Oui</button>
													</div>
												</form>
											</div>
										</div>
										<!-- change to disponible box end -->	
										<!-- change to reserve box begin-->
										<div id="changeToReserve<?= $appartement->id() ?>" class="modal hide fade in" tabindex="-1" role="dialog" aria-labelledby="login" aria-hidden="false" >
											<div class="modal-header">
												<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
												<h3>Changer le status vers "Réservé"</h3>
											</div>
											<div class="modal-body">
												<form class="form-horizontal" action="controller/AppartementActionController.php" method="post" enctype="multipart/form-data">
													<p>Êtes-vous sûr de vouloir changer le status de 
														<a class="btn mini green">Disponible</a> vers 
														<a class="btn mini red">Réservé</a> ?</p>
													<div class="control-group">
													    <input type="hidden" name="action" value="updateStatus" />
														<input type="hidden" name="status" value="Réservé" />
														<input type="hidden" name="idAppartement" value="<?= $appartement->id() ?>" />
														<input type="hidden" name="idProjet" value="<?= $idProjet ?>" />
														<button class="btn" data-dismiss="modal"aria-hidden="true">Non</button>
														<button type="submit" class="btn red" aria-hidden="true">Oui</button>
													</div>
												</form>
											</div>
										</div>
										<!-- change to reserve box end -->	
										<!-- add file box begin-->
										<div id="addPieces<?= $appartement->id() ?>" class="modal hide fade in" tabindex="-1" role="dialog" aria-labelledby="login" aria-hidden="false" >
											<div class="modal-header">
												<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
												<h3>Ajouter des pièces pour cette appartement</h3>
											</div>
											<div class="modal-body">
												<form class="form-horizontal" action="controller/AppartementActionController.php?p=1" method="post" enctype="multipart/form-data">
													<p>Êtes-vous sûr de vouloir ajouter des pièces pour cette appartement ?</p>
													<div class="control-group">
														<label class="right-label">Nom Pièce</label>
														<input type="text" name="nom" />
														<label class="right-label">Lien</label>
														<input type="file" name="url" />
														<input type="hidden" name="action" value="addPieces" />
														<input type="hidden" name="idAppartement" value="<?= $appartement->id() ?>" />
														<input type="hidden" name="idProjet" value="<?= $idProjet ?>" />
														<button class="btn" data-dismiss="modal"aria-hidden="true">Non</button>
														<button type="submit" class="btn red" aria-hidden="true">Oui</button>
													</div>
												</form>
											</div>
										</div>
										<!-- add files box end -->	
										<!-- updateAppartement box begin-->
                                        <div id="updateAppartement<?= $appartement->id() ?>" class="modal hide fade in" tabindex="-1" role="dialog" aria-labelledby="login" aria-hidden="false" >
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                                <h3>Modifier Appartement</h3>
                                            </div>
                                            <div class="modal-body">
                                                <form class="form-horizontal" action="controller/AppartementActionController.php" method="post">
                                                    <p>Êtes-vous sûr de vouloir modifier <strong>Appartement : <?= $appartement->nom() ?>- Niveau : <?= $appartement->niveau() ?></strong></p>
                                                    <div class="control-group">
                                                        <div class="controls">
                                                            <label class="control-label">Code</label>
                                                            <input type="text" name="code" value="<?= $appartement->nom() ?>" />
                                                        </div>
                                                    </div>
                                                    <div class="control-group">
                                                        <label class="control-label">Supérficie</label>
                                                        <div class="controls">
                                                            <input type="text" name="superficie" value="<?= $appartement->superficie() ?>" />
                                                        </div>
                                                    </div>
                                                    <div class="control-group">
                                                        <label class="control-label">Façade</label>
                                                        <div class="controls">
                                                            <input type="text" name="facade" value="<?= $appartement->facade() ?>" />
                                                        </div>
                                                    </div>
                                                    <div class="control-group">
                                                        <label class="control-label">Nombre de pièces</label>
                                                        <div class="controls">
                                                            <input type="text" name="nombrePiece" value="<?= $appartement->nombrePiece() ?>" />
                                                        </div>
                                                    </div>
                                                    <div class="control-group">
                                                        <label class="control-label">Prix</label>
                                                        <div class="controls">
                                                            <input type="text" name="prix" value="<?= $appartement->prix() ?>" />
                                                        </div>
                                                    </div>
                                                    <div class="control-group">
                                                        <label class="control-label" for="niveau">Niveau</label>
                                                        <div class="controls">
                                                            <select style="width:150px" name="niveau" class="m-wrap">
                                                                <option value="<?= $appartement->niveau() ?>"><?= $appartement->niveau() ?></option>
                                                                <option disabled="disabled">-----------------</option>
                                                                <option value="RC">RC</option>
                                                                <option value="Mezzanine">Mezzanine</option>
                                                                <option value="1">1</option>
                                                                <option value="2">2</option>
                                                                <option value="3">3</option>
                                                                <option value="4">4</option>
                                                                <option value="5">5</option>
                                                                <option value="6">6</option>
                                                                <option value="7">7</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <?php
                                                    if ( $appartement->status() != "Vendu" ){ 
                                                    ?>
                                                    <div class="control-group">
                                                        <label class="control-label" for="status">Status</label>
                                                        <div class="controls">
                                                            <select style="width:150px" name="status" id="status" class="m-wrap">
                                                                <option value="<?= $appartement->status() ?>"><?= $appartement->status() ?></option>
                                                                <option disabled="disabled">-----------------</option>
                                                                <option value="Disponible">Disponible</option>
                                                                <option value="Réservé">Réservé</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <?php
                                                    } 
                                                    ?>
                                                    <div class="control-group">
                                                        <label class="control-label" for="cave">Cave</label>
                                                        <div class="controls">
                                                            <select style="width:150px" name="cave" class="m-wrap">
                                                                <option value="<?= $appartement->cave() ?>"><?= $appartement->cave() ?></option>
                                                                <option disabled="disabled">-----------------</option>
                                                                <option value="Avec">Avec</option>
                                                                <option value="Sans">Sans</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="control-group">
                                                        <label class="control-label">Réservé par </label>
                                                        <div class="controls">
                                                            <input type="text" name="par" class="m-wrap" value="<?= $appartement->par() ?>">
                                                        </div>
                                                    </div>
                                                    <div class="control-group">
                                                        <div class="controls">
                                                            <input type="hidden" name="action" value="update" />  
                                                            <input type="hidden" name="idProjet" value="<?= $idProjet ?>" />
                                                            <input type="hidden" name="idAppartement" value="<?= $appartement->id() ?>" />
                                                            <button class="btn" data-dismiss="modal"aria-hidden="true">Non</button>
                                                            <button type="submit" class="btn red" aria-hidden="true">Oui</button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                        <!-- updateAppartement box end -->
										<!-- updateClient box begin -->
										<div id="updateClient<?= $appartement->id() ?>" class="modal hide fade in" tabindex="-1" role="dialog" aria-labelledby="login" aria-hidden="false" >
											<div class="modal-header">
												<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
												<h3>Changer le client <strong><?= $appartement->par() ?></strong> </h3>
											</div>
											<div class="modal-body">
												<form class="form-horizontal loginFrm" action="controller/AppartementActionController.php" method="post">
													<p>Êtes-vous sûr de vouloir changer le nom du client <strong><?= $appartement->par() ?></strong> ?</p>
													<div class="control-group">
														<label class="right-label">Réservé par</label>
														<input type="text" name="par" value="<?= $appartement->par() ?>" />
													</div>
													<div class="control-group">
														<input type="hidden" name="action" value="updateClient" />
														<input type="hidden" name="idAppartement" value="<?= $appartement->id() ?>" />
														<input type="hidden" name="idProjet" value="<?= $idProjet ?>" />
														<button class="btn" data-dismiss="modal"aria-hidden="true">Non</button>
														<button type="submit" class="btn red" aria-hidden="true">Oui</button>
													</div>
												</form>
											</div>
										</div>	
										<!-- updateClient box end -->
										<!-- delete box begin-->
										<div id="deleteAppartement<?= $appartement->id() ?>" class="modal hide fade in" tabindex="-1" role="dialog" aria-labelledby="login" aria-hidden="false" >
											<div class="modal-header">
												<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
												<h3>Supprimer Appartement <strong><?= $appartement->nom() ?></strong> </h3>
											</div>
											<div class="modal-body">
												<form class="form-horizontal loginFrm" action="controller/AppartementActionController.php" method="post">
													<p>Êtes-vous sûr de vouloir supprimer cette appartement <strong><?= $appartement->nom() ?></strong> ?</p>
													<div class="control-group">
														<label class="right-label"></label>
														<input type="hidden" name="action" value="delete" />
														<input type="hidden" name="idAppartement" value="<?= $appartement->id() ?>" />
														<input type="hidden" name="idProjet" value="<?= $idProjet ?>" />
														<button class="btn" data-dismiss="modal"aria-hidden="true">Non</button>
														<button type="submit" class="btn red" aria-hidden="true">Oui</button>
													</div>
												</form>
											</div>
										</div>
										<!-- delete box end -->	
										<?php
										}//end of loop
										}//end of if
										?>
									</tbody>
									<?php
									/*if($appartementNumber != 0){
										echo $pagination;	
									}*/
									?>
								</table>
							</div>
						</div>
						</div><!-- END DIV SCROLLER -->
						<!-- END Terrain TABLE PORTLET-->
					</div>
				</div>
				<!--div class="row-fluid">
					<div class="span12">
						<div class="tab-pane active" id="tab_1">
                           <div class="portlet box blue">
                              <div class="portlet-title">
                                 <h4><i class="icon-edit"></i>Ajouter un nouvel appartement pour le projet : <strong><?= $projet->nom() ?></strong></h4>
                                 <div class="tools">
                                    <a href="javascript:;" class="collapse"></a>
                                    <a href="javascript:;" class="remove"></a>
                                 </div>
                              </div>
                              <div class="portlet-body form">
                                 <form action="controller/AppartementAddController.php" method="POST" class="horizontal-form">
                                    <div class="row-fluid">
                                       <div class="span3">
                                          <div class="control-group">
                                             <label class="control-label" for="code">Code</label>
                                             <div class="controls">
                                                <input type="text" id="code" name="code" class="m-wrap span12">
                                             </div>
                                          </div>
                                       </div>
                                       <div class="span3">
                                          <div class="control-group">
                                             <label class="control-label" for="superficie">Supérficie</label>
                                             <div class="controls">
                                                <input type="text" id="superficie" name="superficie" class="m-wrap span12">
                                             </div>
                                          </div>
                                       </div>
                                       <div class="span3">
                                          <div class="control-group">
                                             <label class="control-label" for="facade">Façade</label>
                                             <div class="controls">
                                                <input type="text" id="facade" name="facade" class="m-wrap span12">
                                             </div>
                                          </div>
                                       </div>
                                       <div class="span3">
                                          <div class="control-group">
                                             <label class="control-label" for="nombrePiece">Nombre Pièces</label>
                                             <div class="controls">
                                                <input type="text" id="nombrePiece" name="nombrePiece" class="m-wrap span12">
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                    <div class="row-fluid">
                                    	<div class="span3">
                                          <div class="control-group">
                                             <label class="control-label" for="prix">Prix</label>
                                             <div class="controls">
                                                <input type="text" id="prix" name="prix" class="m-wrap span12">
                                             </div>
                                          </div>
                                       </div>
                                       <div class="span3">
                                          <div class="control-group">
                                             <label class="control-label" for="niveau">Niveau</label>
                                             <div class="controls">
                                             	<select style="width:150px" name="niveau" class="m-wrap">
                                             		<option value="RC">RC</option>
                                             		<option value="Mezzanine">Mezzanine</option>
                                             		<option value="1">1</option>
                                             		<option value="2">2</option>
                                             		<option value="3">3</option>
                                             		<option value="4">4</option>
                                             		<option value="5">5</option>
                                             		<option value="6">6</option>
                                             		<option value="7">7</option>
                                             	</select>
                                             </div>
                                          </div>
                                       </div>
                                       <div class="span3">
                                          <div class="control-group">
                                             <label class="control-label" for="status">Status</label>
                                             <div class="controls">
                                             	<select style="width:150px" name="status" id="status" class="m-wrap">
                                             		<option value="Non">Disponible</option>
                                             		<option value="Oui">Réservé</option>
                                             	</select>
                                             </div>
                                          </div>
                                       </div>
                                       <div class="span3">
                                          <div class="control-group">
                                             <label class="control-label" for="cave">Cave</label>
                                             <div class="controls">
                                             	<select style="width:150px" name="cave" class="m-wrap">
                                             		<option value="Avec">Avec</option>
                                             		<option value="Sans">Sans</option>
                                             	</select>
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                    <div class="row-fluid" id="par" style="display: none">
                                    	<div class="span6">
                                          <div class="control-group">
                                             <label class="control-label">Réservé par </label>
                                             <div class="controls">
                                                <input type="text" name="par" class="m-wrap">
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                    <div class="form-actions">
                                    	<input type="hidden" id="idProjet" name="idProjet" value="<?= $idProjet ?>" class="m-wrap span12">
                                    	<button type="submit" class="btn blue">Enregistrer <i class="icon-save"></i></button>
                                    	<button type="reset" class="btn red">Annuler</button>
                                    </div>
                                 </form> 
                              </div>
                           </div>
                        </div>
					</div>
				</div-->
				<?php }
				else{
				?>
				<div class="alert alert-error">
					<button class="close" data-dismiss="alert"></button>
					<strong>Erreur système : </strong>Ce projet n'existe pas sur votre système. Pour plus d'informations consulter votre administrateur.		
				</div>
				<?php
				}
				?>
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
	<!-- ie8 fixes -->
	<!--[if lt IE 9]>
	<script src="assets/js/excanvas.js"></script>
	<script src="assets/js/respond.js"></script>
	<![endif]-->
	<script src="assets/jquery-ui/jquery-ui-1.10.1.custom.min.js"></script>
    <script src="assets/jquery-slimscroll/jquery.slimscroll.min.js"></script>	
	<script type="text/javascript" src="assets/uniform/jquery.uniform.min.js"></script>
	<script type="text/javascript" src="assets/data-tables/jquery.dataTables.js"></script>
	<script type="text/javascript" src="assets/data-tables/DT_bootstrap.js"></script>
	<script src="assets/js/app.js"></script>
	<script>
        jQuery(document).ready(function() {         
            // initiate layout and plugins
            //App.setPage("table_editable");
            App.init();
        });
        $('.appartements').show();
        $('#criteria').keyup(function(){
            $('.appartements').hide();
           var txt = $('#criteria').val();
           $('.appartements').each(function(){
               if($(this).text().toUpperCase().indexOf(txt.toUpperCase()) != -1){
                   $(this).show();
               }
            });
        });
        $('#status').on('change',function(){
            if( $(this).val()!=="Disponible"){
            $("#par").show()
            }
            else{
            $("#par").hide()
            }
        });
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
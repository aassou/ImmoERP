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
        //classManagers
        $projetManager = new ProjetManager($pdo);
        $fournisseurManager = new FournisseurManager($pdo);
        $livraisonManager = new LivraisonIaazaManager($pdo);
        $livraisonDetailManager = new LivraisonDetailIaazaManager($pdo);
        $reglementsFournisseurManager = new ReglementFournisseurIaazaManager($pdo);
        //classes and vars
        $projets = $projetManager->getProjets();
        $fournisseurs = $fournisseurManager->getFournisseurs();
        $projet = $projetManager->getProjets();
        $livraisonNumber = 0;
        $totalReglement = 0;
        $totalLivraison = 0;
        $titreLivraison ="Liste de toutes les livraisons";
        $hrefLivraisonBilanPrintController = "controller/Livraison2BilanPrintController.php";
        $livraisonListDeleteLink = "";
        $titreLivraison ="Société Iaaza";
        $livraisonNumber = $livraisonManager->getLivraisonNumber();
        //if($livraisonNumber != 0){
        $idFournisseur = $_GET['idFournisseur'];
        $livraisons = $livraisonManager->getLivraisonsByFournisseurGroupByMonth($idFournisseur);
        
        $totalReglement = $reglementsFournisseurManager->getTotalReglement();
        $totalLivraison = $livraisonDetailManager->getTotalLivraison(); 
        $hrefLivraisonBilanPrintController = "controller/Livraison2BilanPrintController.php?societe=1";
        //}
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
    <link rel="stylesheet" type="text/css" href="assets/bootstrap-datepicker/css/datepicker.css" />
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
                            Gestion des livraisons - <strong><?= $titreLivraison ?></strong>
                        </h3>
                        <ul class="breadcrumb">
                            <li>
                                <i class="icon-home"></i>
                                <a href="dashboard.php">Accueil</a> 
                                <i class="icon-angle-right"></i>
                            </li>
                            <li>
                                <i class="icon-truck"></i>
                                <a href="livraisons-group-iaaza.php">Gestion des livraisons <strong>Société Iaaza</strong></a>
                                <i class="icon-angle-right"></i>
                            </li>
                            <li>
                                <a>Livraisons de <strong><?= $fournisseurManager->getFournisseurById($idFournisseur)->nom() ?></strong></a>
                            </li>
                        </ul>
                        <!-- END PAGE TITLE & BREADCRUMB-->
                    </div>
                </div>
                <!-- END PAGE HEADER-->
                <div class="row-fluid">
                    <div class="span12">
                        <?php
                        if ( 
                            $_SESSION['userMerlaTrav']->profil() == "admin" ||
                            $_SESSION['userMerlaTrav']->profil() == "manager" ||  
                            $_SESSION['userMerlaTrav']->profil() == "user"
                            ) {
                        ?>
                        <div class="row-fluid add-portfolio">
                            <div class="pull-left">
                                <?php
                                if ( 
                                    $_SESSION['userMerlaTrav']->profil() == "admin" ||
                                    $_SESSION['userMerlaTrav']->profil() == "manager" 
                                    ) {
                                ?>
                                <a href="#addReglement" data-toggle="modal" class="btn black">
                                    Ajouter Nouveau Réglement <i class="icon-plus-sign "></i>
                                </a>
                                <?php
                                }
                                ?>
                            </div>
                            <div class="pull-right">
                                <a href="#addLivraison" data-toggle="modal" class="btn green">
                                    Ajouter Nouvelle Livraison <i class="icon-plus-sign "></i>
                                </a>
                            </div>
                        </div>
                        <?php
                        }
                        ?>
                        <!-- addLivraison box begin-->
                        <div id="addLivraison" class="modal hide fade in" tabindex="-1" role="dialog" aria-labelledby="login" aria-hidden="false" >
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                <h3>Ajouter une nouvelle livraison </h3>
                            </div>
                            <div class="modal-body">
                                <form id="addLivraisonForm" class="form-horizontal" action="controller/LivraisonIaazaActionController.php" method="post">
                                    <div class="control-group">
                                        <label class="control-label">Fournisseur</label>
                                        <div class="controls">
                                            <select name="idFournisseur">
                                                <option value="<?= $idFournisseur ?>"><?= $fournisseurManager->getFournisseurById($idFournisseur)->nom() ?></option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label">Projet</label>
                                        <div class="controls">
                                            <select name="idProjet">
                                                <option value="0">Plusieurs Projets</option>
                                                <?php foreach($projets as $projet){ ?>
                                                <option value="<?= $projet->id() ?>"><?= $projet->nom() ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label">Date Livraison</label>
                                        <div class="controls date date-picker" data-date="" data-date-format="yyyy-mm-dd">
                                            <input name="dateLivraison" id="dateLivraison" class="m-wrap m-ctrl-small date-picker" type="text" value="<?= date('Y-m-d') ?>" />
                                            <span class="add-on"><i class="icon-calendar"></i></span>
                                         </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label">N° BL</label>
                                        <div class="controls">
                                            <input required="required" id="libelle" type="text" name="libelle" value="" />
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label">Désignation</label>
                                        <div class="controls">
                                            <input id="designation" type="text" name="designation" value="" />
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <div class="controls">  
                                            <input type="hidden" name="action" value="add" />    
                                            <input type="hidden" name="source" value="livraisons-fournisseur-mois-iaaza" />
                                            <input type="hidden" name="idFournisseur" value="<?= $idFournisseur ?>" />
                                            <button class="btn" data-dismiss="modal"aria-hidden="true">Non</button>
                                            <button type="submit" class="btn red" aria-hidden="true">Oui</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <!-- addLivraison box end -->
                        <!-- addReglement box begin-->
                        <div id="addReglement" class="modal hide fade in" tabindex="-1" role="dialog" aria-labelledby="login" aria-hidden="false" >
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                <h3>Ajouter un nouveau réglement </h3>
                            </div>
                            <div class="modal-body">
                                <form id="addReglementForm" class="form-horizontal" action="controller/ReglementFournisseurIaazaActionController.php" method="post">
                                    <div class="control-group">
                                        <label class="control-label">Fournisseur</label>
                                        <div class="controls">
                                            <select name="idFournisseur">
                                                <option value="<?= $idFournisseur ?>"><?= $fournisseurManager->getFournisseurById($idFournisseur)->nom() ?></option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label">Désignation</label>
                                        <div class="controls">
                                            <select name="idProjet">
                                                <option value="0">Plusieurs Projets</option>
                                                <?php foreach($projets as $projet){ ?>
                                                <option value="<?= $projet->id() ?>"><?= $projet->nom() ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label">Date Réglement</label>
                                        <div class="controls date date-picker" data-date="" data-date-format="yyyy-mm-dd">
                                            <input name="dateReglement" id="dateReglement" class="m-wrap m-ctrl-small date-picker" type="text" value="<?= date('Y-m-d') ?>" />
                                            <span class="add-on"><i class="icon-calendar"></i></span>
                                         </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label">Montant</label>
                                        <div class="controls">
                                            <input required="required" id="montant" type="text" name="montant" value="" />
                                        </div>  
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label">Mode de paiement</label>
                                        <div class="controls">
                                            <select id="modePaiement" name="modePaiement" style="width: 220px" class="m-wrap">
                                                <option value="Especes">Especes</option>
                                                <option value="Cheque">Cheque</option>
                                                <option value="Versement">Versement</option>
                                                <option value="Virement">Virement</option>
                                                <option value="LetterDeChange">Lettre De Change</option>
                                                <option value="Remise">Remise</option>
                                            </select>
                                        </div>  
                                    </div>
                                    <div class="row-fluid">
                                        <div class="span6">
                                          <div class="control-group">
                                             <label class="control-label">Numéro Operation</label>
                                             <div class="controls">
                                                <input type="text" required="required" id="numeroOperation" name="numeroCheque">
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                    <div class="control-group">
                                        <div class="controls">
                                            <input type="hidden" name="action" value="add" />
                                            <input type="hidden" name="source" value="livraisons-fournisseur-mois-iaaza" />
                                            <input type="hidden" name="idFournisseur" value="<?= $idFournisseur ?>" />  
                                            <button class="btn" data-dismiss="modal"aria-hidden="true">Non</button>
                                            <button type="submit" class="btn red" aria-hidden="true">Oui</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <!-- addReglement box end -->
                        <div class="row-fluid">
                            <div class="input-box">
                                <input class="m-wrap" name="provider" id="provider" type="text" placeholder="Fournisseur...">
                                </input>
                                <a target="_blank" href="<?= $hrefLivraisonBilanPrintController ?>" class="btn blue pull-right"><i class="icon-print"></i>&nbsp;Imprimer Bilan</a>
                            </div>
                        </div>
                        <!-- BEGIN Terrain TABLE PORTLET-->
                         <?php
                         if( isset($_SESSION['livraison-action-message'])
                         and isset($_SESSION['livraison-type-message']) ){ 
                            $message = $_SESSION['livraison-action-message'];
                            $typeMessage = $_SESSION['livraison-type-message'];    
                         ?>
                            <div class="alert alert-<?= $typeMessage ?>">
                                <button class="close" data-dismiss="alert"></button>
                                <?= $message ?>     
                            </div>
                         <?php } 
                            unset($_SESSION['livraison-action-message']);
                            unset($_SESSION['livraison-type-message']);
                         ?>
                         <?php
                         if( isset($_SESSION['reglement-action-message'])
                         and isset($_SESSION['reglement-type-message']) ){ 
                            $message = $_SESSION['reglement-action-message'];
                            $typeMessage = $_SESSION['reglement-type-message'];    
                         ?>
                            <div class="alert alert-<?= $typeMessage ?>">
                                <button class="close" data-dismiss="alert"></button>
                                <?= $message ?>     
                            </div>
                         <?php } 
                            unset($_SESSION['reglement-action-message']);
                            unset($_SESSION['reglement-type-message']);
                         ?>
                        <!--table class="table table-striped table-bordered table-advance table-hover">
                            <tbody>
                                <tr>
                                    <th style="width: 15%"><strong>Σ Total Livraisons</strong></th>
                                    <th style="width: 15%"><strong><a><?php //number_format($totalLivraison, 2, ',', ' ') ?>&nbsp;DH</a></strong></th>
                                    <th style="width: 15%"><strong>Σ Total Réglements</strong></th>
                                    <th style="width: 15%"><strong><a><?php //number_format($totalReglement, 2, ',', ' ') ?>&nbsp;DH</a></strong></th>
                                    <th style="width: 15%"><strong>Σ Solde</strong></th>
                                    <th style="width: 15%"><strong><a><?php //number_format($totalLivraison-$totalReglement, 2, ',', ' ') ?>&nbsp;DH</a></strong></th>
                                </tr>
                            </tbody>
                        </table-->    
                        <div class="portlet livraisons">
                            <div class="portlet-body">
                                <div class="scroller" data-height="500px" data-always-visible="1"><!-- BEGIN DIV SCROLLER -->
                                <table class="table table-striped table-bordered table-advance table-hover">
                                    <thead>
                                        <tr>
                                            <th style="width: 40%">Mois / Année</th>
                                            <th style="width: 20%">Total Livraisons</th>
                                            <th style="width: 20%">Total Réglements</th>
                                            <th style="width: 20%">Solde</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!--form action="LivraisonListDeleteController.php<?= $livraisonListDeleteLink ?>" method="post">
                                            <button type="submit" class="btn red">Supprimer les livraisons sélectionnées</button>
                                            <br-->                                          
                                        <?php
                                        //if($livraisonNumber != 0){
                                        //echo print_r($query);
                                        $grandTotalLivraisons = 0;
                                        $grandTotalReglements = $reglementsFournisseurManager->sommeReglementFournisseursByIdFournisseur($idFournisseur);
                                        foreach($livraisons as $livraison){
                                            $livraisonsIds = 
                                            $livraisonManager->getLivraisonsByIdFournisseurByMonthYear($livraison->idFournisseur(), $livraison->dateLivraison());
                                            $totalDetailsLivraisons = 0;
                                            foreach($livraisonsIds as $idl){
                                                $totalDetailsLivraisons += $livraisonDetailManager->getTotalLivraisonByIdLivraison($idl);
                                            }
                                            $grandTotalLivraisons += $totalDetailsLivraisons;
                                            $mois = date('m', strtotime($livraison->dateLivraison()));
                                            $annee = date('Y', strtotime($livraison->dateLivraison()));
                                            $sommeReglements = $reglementsFournisseurManager->sommeReglementFournisseursByIdFournisseurByMonthByYear($livraison->idFournisseur(), $mois, $annee);
                                        ?>      
                                        <tr class="livraisons">
                                            <td>
                                                <div style="width: 200px">
                                                    <a class="btn mini" href="livraisons-fournisseur-mois-list-iaaza.php?idFournisseur=<?= $livraison->idFournisseur() ?>&mois=<?= $mois ?>&annee=<?= $annee ?>">
                                                        <strong><?= date('m / Y', strtotime($livraison->dateLivraison())) ?></strong>
                                                    </a>
                                                </div>
                                            </td>
                                            <td>
                                                <?= number_format($totalDetailsLivraisons, 2, ',', ' '); ?>
                                            </td>
                                            <td>
                                                <?= number_format($sommeReglements, 2, ',', ' '); ?>
                                            </td>
                                            <td>
                                                <?= number_format( $totalDetailsLivraisons - $sommeReglements, 2, ',', ' '); ?>
                                            </td>
                                        </tr>
                                        <?php
                                        }//end of loop
                                        //}//end of if
                                        ?>
                                    </tbody>
                                    <tr>
                                        <th></th>
                                        <th><strong>Grand Total Livraisons</strong></th>
                                        <th><strong>Grand Total Réglements</strong></th>
                                        <th><strong>Solde</strong></th>
                                    </tr>
                                    <tr>
                                        <th></th>
                                        <th><strong><a><?= number_format($grandTotalLivraisons, 2, ',', ' ') ?>&nbsp;DH</a></strong></th>
                                        <th><strong><a><?= number_format($grandTotalReglements, 2, ',', ' ') ?>&nbsp;DH</a></strong></th>
                                        <th><strong><a><?= number_format($totalLivraison - $grandTotalReglements, 2, ',', ' ') ?>&nbsp;DH</a></strong></th>
                                    </tr>
                                </table>
                                </div><!-- END DIV SCROLLER -->
                            </div>
                        </div>
                        <!-- END Terrain TABLE PORTLET-->
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
    <!-- ie8 fixes -->
    <!--[if lt IE 9]>
    <script src="assets/js/excanvas.js"></script>
    <script src="assets/js/respond.js"></script>
    <![endif]-->    
    <script type="text/javascript" src="assets/uniform/jquery.uniform.min.js"></script>
    <script type="text/javascript" src="assets/data-tables/jquery.dataTables.js"></script>
    <script type="text/javascript" src="assets/data-tables/DT_bootstrap.js"></script>
    <script src="assets/jquery-ui/jquery-ui-1.10.1.custom.min.js"></script>
    <script src="assets/jquery-slimscroll/jquery.slimscroll.min.js"></script>
    <script type="text/javascript" src="assets/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
    <script type="text/javascript" src="assets/bootstrap-daterangepicker/date.js"></script>
    <script src="assets/js/app.js"></script>
    <script type="text/javascript" src="script.js"></script>        
    <script>
        jQuery(document).ready(function() {         
            // initiate layout and plugins
            //App.setPage("table_editable");
            App.init();
        });
        $('.livraisons').show();
        $('#provider').keyup(function(){
           $('.livraisons').hide();
           var txt = $('#provider').val();
           $('.livraisons').each(function(){
               if($(this).text().toUpperCase().indexOf(txt.toUpperCase()) != -1){
                   $(this).show();
               }
            });
        });
        $("#addLivraisonForm").validate({
            rules:{
                libelle:{
                    required:true
                }
            },
            errorClass: "error-class",
            validClass: "valid-class"
        });
        $("#addReglementForm").validate({
            rules:{
                montant:{
                    number: true,
                    required:true
                },
                numeroOperation:{
                    number: true,
                    required:true
                }
            },
            errorClass: "error-class",
            validClass: "valid-class"
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
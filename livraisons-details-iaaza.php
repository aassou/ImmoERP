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
        $livraisonDetailNumber = 0;
        $totalReglement = 0;
        $totalLivraison = 0;
        $titreLivraison ="Détail de la livraison";
        $livraison = "Vide";
        $fournisseur = "Vide";
        $nomProjet = "Non mentionné";
        $idProjet = "";
        $fournisseurs = $fournisseurManager->getFournisseurs();
        $projets = $projetManager->getProjets();
        if( isset($_GET['codeLivraison']) ){
            $livraison = $livraisonManager->getLivraisonByCode($_GET['codeLivraison']);
            $fournisseur = $fournisseurManager->getFournisseurById($livraison->idFournisseur());
            if ( $livraison->idProjet() != 0 ) {
                $nomProjet = $projetManager->getProjetById($livraison->idProjet())->nom();
                $idProjet = $projetManager->getProjetById($livraison->idProjet())->id();    
            } 
            else {
                $nomProjet = "Non mentionné";
                $idProjet = "";    
            }
            
            $livraisonDetail = $livraisonDetailManager->getLivraisonsDetailByIdLivraison($livraison->id());
            $totalLivraisonDetail = 
            $livraisonDetailManager->getTotalLivraisonByIdLivraison($livraison->id());
            $nombreArticle = 
            $livraisonDetailManager->getNombreArticleLivraisonByIdLivraison($livraison->id());
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
    <link rel="stylesheet" type="text/css" href="assets/bootstrap-datepicker/css/datepicker.css" />
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
                            Gestion des livraisons - Fournisseur : <strong><?= $fournisseur->nom() ?></strong> 
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
                                <a href="livraisons-fournisseur-mois-iaaza.php?idFournisseur=<?= $livraison->idFournisseur() ?>">
                                    Livraisons de <strong><?= $fournisseurManager->getFournisseurById($livraison->idFournisseur())->nom() ?></strong>
                                </a>
                                <i class="icon-angle-right"></i>
                            </li>
                            <li>
                                <a href="livraisons-fournisseur-mois-list-iaaza.php?idFournisseur=<?= $livraison->idFournisseur() ?>&mois=<?= $_GET['mois'] ?>&annee=<?= $_GET['annee'] ?>">
                                    <strong><?= $_GET['mois'] ?>/<?= $_GET['annee'] ?></strong>
                                </a>
                                <i class="icon-angle-right"></i>
                            </li>
                            <li><a>Détails de Livraison</a></li>
                        </ul>
                        <!-- END PAGE TITLE & BREADCRUMB-->
                    </div>
                </div>
                <!-- END PAGE HEADER-->
                <div class="row-fluid">
                    <div class="span12">
                        <!-- BEGIN ALERT MESSAGES -->
                         <?php 
                         if( isset($_SESSION['livraison-detail-action-message']) 
                         and isset($_SESSION['livraison-detail-type-message']) ){ 
                             $message = $_SESSION['livraison-detail-action-message'];
                             $typeMessage = $_SESSION['livraison-detail-type-message'];
                         ?>
                            <div class="alert alert-<?= $typeMessage ?>">
                                <button class="close" data-dismiss="alert"></button>
                                <?= $message ?>     
                            </div>
                         <?php } 
                            unset($_SESSION['livraison-detail-action-message']);
                            unset($_SESSION['livraison-detail-type-message']);
                         ?>
                         <!-- END  ALERT MESSAGES -->
                        <?php
                        $updateLink = "";
                        if ( 
                            $_SESSION['userMerlaTrav']->profil() == "admin" ||
                            $_SESSION['userMerlaTrav']->profil() == "user" 
                            ) {
                            $updateLink = "#updateLivraison";    
                        }
                        ?>
                        <div class="portlet">
                            <!-- BEGIN PORTLET BODY -->
                            <div class="portlet-body">
                                <!-- BEGIN Livraison Form -->
                                <div class="row-fluid">
                                    <div class="span3">
                                      <div class="control-group">
                                         <div class="controls">
                                           <a class="btn" href="<?= $updateLink ?>" data-toggle="modal" style="width: 200px">
                                               <strong>N° BL : <?= $livraison->libelle() ?></strong>
                                           </a>
                                         </div>
                                      </div>
                                   </div>
                                   <div class="span3">
                                      <div class="control-group">
                                         <div class="controls">
                                            <a class="btn" href="<?= $updateLink ?>" data-toggle="modal" style="width: 200px">
                                                <strong>Nombre Articles : <?= $nombreArticle ?></strong>
                                            </a>   
                                         </div>
                                      </div>
                                   </div>
                                    <div class="span3">
                                      <div class="control-group">
                                         <div class="controls">
                                            <a class="btn" href="<?= $updateLink ?>" data-toggle="modal" style="width: 200px">
                                                <strong>Date Livraison : <?= date('d/m/Y', strtotime($livraison->dateLivraison())) ?></strong>
                                            </a>
                                         </div>
                                      </div>
                                   </div>
                                    <div class="span3">
                                      <div class="control-group">
                                         <div class="controls">
                                            <a class="btn" href="<?= $updateLink ?>" data-toggle="modal" style="width: 200px">
                                                <strong>Projet : <?= $nomProjet ?></strong>
                                            </a>   
                                         </div>
                                      </div>
                                   </div>
                                </div>
                            <!-- END Livraison Form -->
                            <!-- updateLivraison box begin-->
                            <div id="updateLivraison" class="modal hide fade in" tabindex="-1" role="dialog" aria-labelledby="login" aria-hidden="false" >
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                    <h3>Modifier les informations de la livraison </h3>
                                </div>
                                <div class="modal-body">
                                    <form id="update-livraison-form" class="form-horizontal" action="controller/LivraisonIaazaActionController.php" method="post">
                                        <div class="control-group">
                                            <label class="control-label">Fournisseur</label>
                                            <div class="controls">
                                                <select name="idFournisseur">
                                                    <option value="<?= $fournisseur->id() ?>"><?= $fournisseur->nom() ?></option>
                                                    <option disabled="disabled">------------</option>
                                                    <?php foreach($fournisseurs as $fourn){ ?>
                                                    <option value="<?= $fourn->id() ?>"><?= $fourn->nom() ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">Projet</label>
                                            <div class="controls">
                                                <select name="idProjet">
                                                    <option value="0">Non mentionnée</option>
                                                    <option value="<?= $idProjet ?>"><?= $nomProjet ?></option>
                                                    <option disabled="disabled">------------</option>
                                                    <?php foreach($projets as $pro){ ?>
                                                    <option value="<?= $pro->id() ?>"><?= $pro->nom() ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">Désignation</label>
                                            <div class="controls">
                                                <input id="designation" type="text" name="designation" value="<?= $livraison->designation() ?>" />
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">Date Livraison</label>
                                            <div class="controls date date-picker" data-date="" data-date-format="yyyy-mm-dd">
                                                <input name="dateLivraison" id="dateLivraison" class="m-wrap m-ctrl-small date-picker" type="text" value="<?= $livraison->dateLivraison() ?>" />
                                                <span class="add-on"><i class="icon-calendar"></i></span>
                                             </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">N° BL</label>
                                            <div class="controls">
                                                <input required="required" id="libelle" type="text" name="libelle" value="<?= $livraison->libelle() ?>" />
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <div class="controls">  
                                                <input type="hidden" name="action" value="update" />
                                                <input type="hidden" name="source" value="details-livraison-iaaza" />
                                                <input type="hidden" name="mois" value="<?= $_GET['mois'] ?>" />
                                                <input type="hidden" name="annee" value="<?= $_GET['annee'] ?>" />
                                                <input type="hidden" name="codeLivraison" value="<?= $livraison->code() ?>" />
                                                <input type="hidden" name="idLivraison" value="<?= $livraison->id() ?>" />    
                                                <button class="btn" data-dismiss="modal"aria-hidden="true">Non</button>
                                                <button type="submit" class="btn red" aria-hidden="true">Oui</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <!-- addLivraison box end -->
                            <!-- BEGIN Ajouter Article Link -->
                            <a target="_blank" href="controller/LivraisonDetailPrintController.php?idLivraison=<?= $livraison->id() ?>&societe=2" class="get-down btn blue pull-right">
                                <i class="icon-print"></i>&nbsp;Bon de livraison
                            </a>
                            <?php  
                            if ( 
                                $_SESSION['userMerlaTrav']->profil() == "admin" || 
                                $_SESSION['userMerlaTrav']->profil() == "user" 
                                ) {
                            ?>
                            <a class="btn green" href="#addArticle" data-toggle="modal" data-id="">
                                Ajouter un article <i class="icon-plus "></i>
                            </a>
                            <?php  
                            }
                            ?>
                            <!-- END Ajouter Article Link -->
                            <!-- BEGIN addArticle Box -->
                            <div id="addArticle" class="modal hide fade in" tabindex="-1" role="dialog" aria-labelledby="login" aria-hidden="false" >
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                    <h3>Ajouter un artcile </h3>
                                </div>
                                <div class="modal-body">
                                    <form id="add-detail-livraison-form" class="form-horizontal" action="controller/LivraisonDetailsIaazaActionController.php" method="post">
                                        <!--div class="control-group">
                                            <label class="control-label">Libelle</label>
                                            <div class="controls">
                                                <input type="text" name="libelle" value="" />
                                            </div>
                                        </div-->
                                        <div class="control-group">
                                            <label class="control-label">Désignation</label>
                                            <div class="controls">
                                                <input type="text" name="designation" value="" />
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">Prix Unitaire</label>
                                            <div class="controls">
                                                <input required="required" type="text" id="prixUnitaire" name="prixUnitaire" value="" />
                                            </div>  
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">Quantité</label>
                                            <div class="controls">
                                                <input required="required" type="text" id="quantite" name="quantite" value="" />
                                            </div>  
                                        </div>
                                        <div class="control-group">
                                            <div class="controls">  
                                                <input type="hidden" name="action" value="add" />
                                                <input type="hidden" name="mois" value="<?= $_GET['mois'] ?>" />
                                                <input type="hidden" name="annee" value="<?= $_GET['annee'] ?>" />
                                                <input type="hidden" name="idLivraison" value="<?= $livraison->id() ?>">
                                                <input type="hidden" name="codeLivraison" value="<?= $livraison->code() ?>">
                                                <button class="btn" data-dismiss="modal"aria-hidden="true">Non</button>
                                                <button type="submit" class="btn red" aria-hidden="true">Oui</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <!-- END addArticle BOX -->
                            <br><br>
                            <!-- BEGIN LivraisonDetail TABLE -->
                            <?php
                            if( 1 ){
                            ?>
                            <table class="table table-striped table-bordered table-hover">
                            <tr>
                                <?php  
                                if ( 
                                    $_SESSION['userMerlaTrav']->profil() == "admin" ||
                                    $_SESSION['userMerlaTrav']->profil() == "user" 
                                    ) {
                                ?>
                                <th style="width: 10%">Actions</th>
                                <?php  
                                }
                                ?>
                                <th style="width: 20%">Désignation</th>
                                <th style="width: 20%">Quantité</th>
                                <th style="width: 20%">Prix.Uni</th>
                                <th style="width: 30%">Total</th>
                            </tr>
                            <?php
                            foreach($livraisonDetail as $detail){
                            ?>
                            <tr>
                                <?php  
                                if ( 
                                    $_SESSION['userMerlaTrav']->profil() == "admin" ||
                                    $_SESSION['userMerlaTrav']->profil() == "user" 
                                    ) {
                                ?>
                                <td class="hidden-phone">
                                    <a class="btn mini green" href="#updateLivraisonDetail<?= $detail->id();?>" data-toggle="modal" data-id="<? $detail->id(); ?>">
                                        <i class="icon-refresh "></i>
                                    </a>
                                    <a class="btn mini red" href="#deleteLivraisonDetail<?= $detail->id();?>" data-toggle="modal" data-id="<? $detail->id(); ?>">
                                        <i class="icon-remove "></i>
                                    </a>
                                </td>
                                <?php  
                                }
                                ?>
                                <td>
                                    <?= $detail->designation() ?>
                                </td>
                                <td>
                                    <?= $detail->quantite() ?>
                                </td>
                                <td>
                                    <?= number_format($detail->prixUnitaire(), '2', ',', ' ') ?>&nbsp;DH
                                </td>
                                <td>
                                    <?= number_format($detail->prixUnitaire() * $detail->quantite(), '2', ',', ' ') ?>&nbsp;DH
                                </td>
                            </tr>
                            <!-- BEGIN  updateLivraisonDetail BOX -->
                            <div id="updateLivraisonDetail<?= $detail->id() ?>" class="modal hide fade in" tabindex="-1" role="dialog" aria-labelledby="login" aria-hidden="false" >
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                    <h3>Modifier les détails de livraison </h3>
                                </div>
                                <div class="modal-body">
                                    <form id="update-detail-livraison-form" class="form-horizontal" action="controller/LivraisonDetailsIaazaActionController.php" method="post">
                                        <p>Êtes-vous sûr de vouloir modifier cet article ?</p>
                                        <div class="control-group">
                                            <label class="control-label" for="designation">Désignation</label>
                                            <div class="controls">
                                                <input name="designation" class="m-wrap" type="text" value="<?= $detail->designation() ?>" />
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label" for="quantite">Quantité</label>
                                            <div class="controls">
                                                <input required="required" id="quantite" name="quantite" class="m-wrap" type="text" value="<?= $detail->quantite() ?>" />
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label" for="prixUnitaire">Prix Unitaire</label>
                                            <div class="controls">
                                                <input required="required" id="prixUnitaire" name="prixUnitaire" class="m-wrap" type="text" value="<?= $detail->prixUnitaire() ?>" />
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <input type="hidden" name="action" value="update" />
                                            <input type="hidden" name="mois" value="<?= $_GET['mois'] ?>" />
                                            <input type="hidden" name="annee" value="<?= $_GET['annee'] ?>" />
                                            <input type="hidden" name="idLivraisonDetail" value="<?= $detail->id() ?>" />
                                            <input type="hidden" name="codeLivraison" value="<?= $livraison->code() ?>" />
                                            <div class="controls">  
                                                <button class="btn" data-dismiss="modal"aria-hidden="true">Non</button>
                                                <button type="submit" class="btn red" aria-hidden="true">Oui</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <!-- END  update LivraisonDetail   BOX -->
                            <!-- BEGIN  delete LivraisonDetail BOX -->
                            <div id="deleteLivraisonDetail<?= $detail->id();?>" class="modal hide fade in" tabindex="-1" role="dialog" aria-labelledby="login" aria-hidden="false" >
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                    <h3>Supprimer Article</h3>
                                </div>
                                <div class="modal-body">
                                    <form class="form-horizontal loginFrm" action="controller/LivraisonDetailsIaazaActionController.php" method="post">
                                        <p>Êtes-vous sûr de vouloir supprimer cet article ?</p>
                                        <div class="control-group">
                                            <input type="hidden" name="action" value="delete" />
                                            <input type="hidden" name="mois" value="<?= $_GET['mois'] ?>" />
                                            <input type="hidden" name="annee" value="<?= $_GET['annee'] ?>" />
                                            <input type="hidden" name="idLivraisonDetail" value="<?= $detail->id() ?>" />
                                            <input type="hidden" name="codeLivraison" value="<?= $livraison->code() ?>" />
                                            <button class="btn" data-dismiss="modal"aria-hidden="true">Non</button>
                                            <button type="submit" class="btn red" aria-hidden="true">Oui</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <!-- END delete LivraisonDetail BOX -->
                            <?php
                            }//end foreach
                            ?>
                            </table>
                            <table class="table table-striped table-bordered table-advance table-hover">
                                <tbody>
                                    <tr>
                                        <th style="width: 70%"><strong>Grand Total</strong></th>
                                        <th style="width: 30%"><strong><a><?= number_format($totalLivraisonDetail, 2, ',', ' ') ?>&nbsp;DH</a></strong></th>
                                    </tr>
                                </tbody>
                            </table>
                            <!--table class="table table-striped table-bordered table-advance table-hover">
                                <thead>
                                    <tr>
                                        <th><strong>Nombre d'article de la livraison</strong></th>
                                        <td><strong><a><?= $nombreArticle ?></a></strong></td>
                                    </tr>
                                <thead>
                                    <tr>
                                        <th><strong>Total de la livraison</strong></th>
                                        <td><strong><a><?= number_format($totalLivraisonDetail, 2, ',', ' ') ?></a>&nbsp;DH</strong></td>
                                    </tr>   
                                </thead>
                            </table-->
                            <?php
                            }//end if
                            ?>
                            <!-- END LivraisonDetail TABLE -->
                            </div>
                            <!-- END  PORTLET BODY  -->
                        </div>
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
    <script type="text/javascript" src="script.js"></script>        
    <script>
        jQuery(document).ready(function() {         
            // initiate layout and plugins
            //App.setPage("table_editable");
            App.init();
        });
        $("#add-detail-livraison-form").validate({
            rules:{
                quantite:{
                    number: true,
                    required:true
                },
                prixUnitaire:{
                    number: true,
                    required:true
                }
            },
            errorClass: "error-class",
            validClass: "alid-class"
        });
        $("#update-detail-livraison-form").validate({
            rules:{
                quantite:{
                    number: true,
                    required:true
                },
                prixUnitaire:{
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
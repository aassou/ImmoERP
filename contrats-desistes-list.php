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
    if(isset($_SESSION['userMerlaTrav'])){
        //les sources
        $idProjet = 0;
        $projetManager = new ProjetManager($pdo);
        $clientManager = new ClientManager($pdo);
        $companyManager = new CompanyManager($pdo);
        $contratManager = new ContratManager($pdo);
        $compteBancaireManager = new CompteBancaireManager($pdo);
        $operationManager = new OperationManager($pdo);
        $locauxManager = new LocauxManager($pdo);
        $appartementManager = new AppartementManager($pdo);
        $comptesBancaires = $compteBancaireManager->getCompteBancaires();
        if(isset($_GET['idProjet']) and ($_GET['idProjet'])>0 and $_GET['idProjet']<=$projetManager->getLastId()){
            $idProjet = $_GET['idProjet'];
            $projet = $projetManager->getProjetById($idProjet);
            $companies = $companyManager->getCompanys();
            if(isset($_POST['idClient']) and $_POST['idClient']>0){
                $idClient = $_POST['idClient'];
                $contrats = $contratManager->getContratsByIdClientByIdProjet($idClient, $idProjet);
                $contratNumber = -1;
            }
            else{
                  $contrats = $contratManager->getContratsDesistesByIdProjet($idProjet);  
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
                            Liste des contrats désistés - Projet : <strong><?= $projet->nom() ?></strong>
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
                            <li>
                                <a>Liste des contrats désistés</a>
                            </li>
                        </ul>
                        <!-- END PAGE TITLE & BREADCRUMB-->
                    </div>
                </div>
                <!-- END PAGE HEADER-->
                <div class="row-fluid">
                    <div class="span12">
                        <!-- BEGIN Terrain TABLE PORTLET-->
                        <?php 
                        if( isset($_SESSION['contrat-action-message']) 
                        and isset($_SESSION['contrat-type-message'])) {
                            $message = $_SESSION['contrat-action-message'];
                            $typeMessage = $_SESSION['contrat-type-message']; 
                        ?>
                            <div class="alert alert-<?= $typeMessage ?>">
                                <button class="close" data-dismiss="alert"></button>
                                <?= $message ?>     
                            </div>
                         <?php } 
                            unset($_SESSION['contrat-action-message']);
                            unset($_SESSION['contrat-type-message']);
                         ?>
                        <div class="portlet box light-grey">
                            <div class="portlet-title">
                                <h4>Liste des contrats clients</h4>
                                <div class="tools">
                                    <a href="javascript:;" class="reload"></a>
                                </div>
                            </div>
                            <div class="portlet-body">
                                <div class="clearfix">
                                    <div class="btn-group">
                                        <a class="btn blue pull-right" href="controller/ClientsDesistesSituationsPrintController.php?idProjet=<?= $projet->id() ?>">
                                            <i class="icon-print"></i>
                                             Version Imprimable
                                        </a>
                                    </div>
                                </div>
                                <!--div class="scroller" data-height="500px" data-always-visible="1"--><!-- BEGIN DIV SCROLLER -->
                                <table class="table table-striped table-bordered table-hover" id="sample_1">
                                    <thead>
                                        <tr>
                                            <th style="width:5%">Actions</th>
                                            <th style="width:20%">Client</th>
                                            <th style="width:20%" class="hidden-phone">Bien</th>
                                            <th style="width:10%">Date Contrat</th>
                                            <th style="width:10%" class="hidden-phone">Prix</th>
                                            <th style="width:10%" class="hidden-phone">Réglements</th>
                                            <th style="width:10%" class="hidden-phone">Reste</th>
                                            <th style="width:5%" class="hidden-phone">Status</th>
                                            <?php if(isset($_SESSION['print-quittance'])){ ?>
                                            <th style="width:10%">Quittance</th>
                                            <?php 
                                            } ?>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        foreach($contrats as $contrat){
                                            $revendreTitle = "";
                                            $montantRevente = 0;
                                            $operationsNumber = $operationManager->getOpertaionsNumberByIdContrat($contrat->id());
                                            $sommeOperations = $operationManager->sommeOperations($contrat->id());
                                            $bien = "";
                                            $typeBien = "";
                                            $etage = "";
                                            if($contrat->typeBien()=="appartement"){
                                                $bien = $appartementManager->getAppartementById($contrat->idBien());
                                                $typeBien = "Appartement";
                                                $etage = "Etage ".$bien->niveau();
                                            }
                                            else{
                                                $bien = $locauxManager->getLocauxById($contrat->idBien());
                                                $typeBien = "Local commercial";
                                                $etage = "";
                                            }
                                        ?>      
                                        <tr class="odd gradeX">
                                            <td>
                                                <div class="btn-group">
                                                    <a class="btn black mini dropdown-toggle" href="#" data-toggle="dropdown">
                                                        Choisir 
                                                        <i class="icon-angle-down"></i>
                                                    </a>
                                                    <ul class="dropdown-menu">
                                                        <li>
                                                            <a href="contrat.php?codeContrat=<?= $contrat->code() ?>" target="_blank">
                                                                Consulter Contrat
                                                            </a>
                                                            <a target="_blank" href="controller/ContratDesistementPrintController.php?idContrat=<?= $contrat->id() ?>">
                                                                Imprimer Acte de désistement AR&nbsp;
                                                            </a>
                                                            <a target="_blank" href="controller/ContratArabePrintController.php?idContrat=<?= $contrat->id() ?>">
                                                                Imprimer Contrat AR
                                                            </a>
                                                            <a target="_blank" href="controller/ContratPrintController.php?idContrat=<?= $contrat->id() ?>">
                                                                Imprimer Contrat FR
                                                            </a>
                                                            <?php
                                                            if( $_SESSION['userMerlaTrav']->profil() == "admin" ){
                                                            ?>  
                                                                <a href="#activerContrat<?= $contrat->id() ?>" data-toggle="modal" data-id="<?= $contrat->id() ?>">
                                                                    Activer
                                                                </a>
                                                                <a class="dangerous-action" href="#deleteContrat<?= $contrat->id() ?>" data-toggle="modal" data-id="<?= $contrat->id() ?>">
                                                                    Supprimer Contrat
                                                                </a>  
                                                            <?php
                                                            }//if profil is admin
                                                            ?>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </td>
                                            <td><?= $clientManager->getClientById($contrat->idClient())->nom() ?></td>
                                            <td class="hidden-phone"><?= $typeBien ?> - <?= $bien->nom() ?> - <?= $etage ?></td>
                                            <td class="hidden-phone"><?= date('d/m/Y', strtotime($contrat->dateCreation())) ?></td>
                                            <td class="hidden-phone"><?= number_format($contrat->prixVente(), 2, ',', ' ') ?></td>
                                            <td class="hidden-phone"><?= number_format($sommeOperations, 2, ',', ' ') ?></td>
                                            <td class="hidden-phone"><?= number_format($contrat->prixVente()-$sommeOperations, 2, ',', ' ') ?></td>
                                            <td class="hidden-phone">
                                                <?php if($contrat->status()=="actif"){
                                                    $status = "<a class=\"btn mini green\">Actif</a>";  
                                                }
                                                else{
                                                    $status = "<a class=\"btn mini black\">Désisté</a>";    
                                                }
                                                echo $status;
                                                ?>  
                                            </td>
                                            <?php 
                                            if(isset($_SESSION['print-quittance']) and $operationsNumber>=1){ ?>
                                                <td>
                                                    <a class="btn mini blue" href="controller/OperationPrintController.php?idOperation=<?= $operationManager->getLastIdByIdContrat($contrat->id()) ?>"> 
                                                        <i class="m-icon-white icon-print"></i> Imprimer
                                                    </a>
                                                </td>
                                            <?php 
                                            }
                                            unset($_SESSION['print-quittance']); 
                                            ?>
                                        </tr>
                                        <!-- activation box begin-->
                                        <div id="activerContrat<?= $contrat->id() ?>" class="modal hide fade in" tabindex="-1" role="dialog" aria-labelledby="login" aria-hidden="false" >
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                                <h3>Activer le contrat </h3>
                                            </div>
                                            <div class="modal-body">
                                                <form class="form-horizontal loginFrm" action="controller/ContratActionController.php" method="post">
                                                    <p>Êtes-vous sûr de vouloir activer le contrat <strong>N°<?= $contrat->id() ?></strong> ?</p>
                                                    <div class="control-group">
                                                        <input type="hidden" name="action" value="activer" />
                                                        <input type="hidden" name="source" value="contrats-desistes-list" />
                                                        <input type="hidden" name="idContrat" value="<?= $contrat->id() ?>" />
                                                        <input type="hidden" name="idProjet" value="<?= $projet->id() ?>" />
                                                        <button class="btn" data-dismiss="modal"aria-hidden="true">Non</button>
                                                        <button type="submit" class="btn red" aria-hidden="true">Oui</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                        <!-- activation box end --> 
                                        <!-- delete box begin-->
                                        <div id="deleteContrat<?= $contrat->id() ?>" class="modal hide fade in" tabindex="-1" role="dialog" aria-labelledby="login" aria-hidden="false" >
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                                <h3>Supprimer le contrat </h3>
                                            </div>
                                            <div class="modal-body">
                                                <form class="form-horizontal loginFrm" action="controller/ContratActionController.php" method="post">
                                                    <p><strong>Êtes-vous sûr de vouloir supprimer ce contrat ? <span class="dangerous-action">Attention cette action est irréversible !</span></strong></p>
                                                    <div class="control-group">
                                                        <label class="right-label"></label>
                                                        <input type="hidden" name="action" value="delete" />
                                                        <input type="hidden" name="source" value="contrats-desistes-list" />
                                                        <input type="hidden" name="idContrat" value="<?= $contrat->id() ?>" />
                                                        <input type="hidden" name="idProjet" value="<?= $projet->id() ?>" />
                                                        <button class="btn" data-dismiss="modal"aria-hidden="true">Non</button>
                                                        <button type="submit" class="btn red" aria-hidden="true">Oui</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                        <!-- delete box end --> 
                                        <?php
                                        }//end of loop
                                        ?>
                                    </tbody>
                                </table>
                                </div><!-- END DIV SCROLLER -->
                            </div>
                        </div>
                        <!-- END Terrain TABLE PORTLET-->
                    </div>
                </div>
                <?php 
                }
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
    <script type="text/javascript" src="assets/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
    <script type="text/javascript" src="assets/bootstrap-daterangepicker/date.js"></script>
    <script src="assets/js/app.js"></script>
    <script src="script.js"></script>       
    <script>
        jQuery(document).ready(function() {         
            // initiate layout and plugins
            App.setPage("table_managed");
            App.init();
        });
        $('.currency').on('change',function(){
            if( $(this).val()!=="DH"){
                $('.tauxDeChange').show()
            }
            else{
                $('.tauxDeChange').hide()
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
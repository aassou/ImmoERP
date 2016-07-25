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
        //classManagers
        $projetManager = new ProjetManager($pdo);
        $chargeManager = new ChargeManager($pdo);
        $typeChargeManager = new TypeChargeManager($pdo);
        //
        if(isset($_GET['idProjet']) and 
        ($_GET['idProjet'] >=1 and $_GET['idProjet'] <= $projetManager->getLastId()) ){
            $idProjet = $_GET['idProjet'];
            $charges = $chargeManager->getChargesByIdProjet($idProjet);
            $typeCharges = $typeChargeManager->getTypeCharges();
            $projet = $projetManager->getProjetById($idProjet);
        }       
?>
<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9"> <![endif]-->
<!--[if !IE]><!--> <html lang="en"> <!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
    <meta charset="utf-8" />
    <title>AnnahdaERP - Management Application</title>
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
                            Détails des charges - Projet : <strong><?= $projet->nom() ?></strong>
                        </h3>
                        <ul class="breadcrumb">
                            <li>
                                <i class="icon-dashboard"></i>
                                <a href="dashboard.php">Accueil</a> 
                                <i class="icon-angle-right"></i>
                            </li>
                            <li>
                                <i class="icon-briefcase"></i>
                                <a href="projets.php">Gestion des projets</a> 
                                <i class="icon-angle-right"></i>
                            </li>
                            <li>
                                <a href="projet-details.php?idProjet=<?= $idProjet ?>">Projet <strong><?= $projet->nom() ?></strong></a> 
                                <i class="icon-angle-right"></i>
                            </li>
                            <li>
                                <i class="icon-bar-chart"></i>
                                <a href="projet-charges.php?idProjet=<?= $idProjet ?>">Gestion des charges</a> 
                            </li>
                        </ul>
                        <!-- END PAGE TITLE & BREADCRUMB-->
                    </div>
                </div>
                <!-- END PAGE HEADER-->
                <div class="row-fluid">
                    <div class="span12">
                        <!-- addCharge box begin-->
                        <div id="addCharge" class="modal hide fade in" tabindex="-1" role="dialog" aria-labelledby="login" aria-hidden="false" >
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                <h3>Ajouter une nouvelle charge </h3>
                            </div>
                            <div class="modal-body">
                                <form class="form-horizontal" action="controller/ChargeActionController.php" method="post" enctype="multipart/form-data">
                                    <div class="control-group">
                                        <label class="control-label">Type Charge</label>
                                        <div class="controls">
                                            <select name="type">
                                                <?php foreach($typeCharges as $type){ ?>
                                                    <option value="<?= $type->nom() ?>"><?= $type->nom() ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label">Date Opération</label>
                                        <div class="controls date date-picker" data-date="" data-date-format="yyyy-mm-dd">
                                            <input name="dateOperation" id="dateOperation" class="m-wrap m-ctrl-small date-picker" type="text" value="<?= date('Y-m-d') ?>" />
                                            <span class="add-on"><i class="icon-calendar"></i></span>
                                         </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label">Montant</label>
                                        <div class="controls">
                                            <input type="text" name="montant" value="" />
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label">Désignation</label>
                                        <div class="controls">
                                            <input type="text" name="designation" value="" />
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label">Société</label>
                                        <div class="controls">
                                            <input type="text" name="societe" value="" />
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <div class="controls">
                                            <input type="hidden" name="idProjet" value="<?= $idProjet ?>" />
                                            <input type="hidden" name="action" value="add" />    
                                            <button class="btn" data-dismiss="modal"aria-hidden="true">Non</button>
                                            <button type="submit" class="btn red" aria-hidden="true">Oui</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <!-- addCharge box end -->
                        <!-- addTypeCharge box begin-->
                        <div id="addTypeCharge" class="modal hide fade in" tabindex="-1" role="dialog" aria-labelledby="login" aria-hidden="false" >
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                <h3>Ajouter Nouveau Type Charge </h3>
                            </div>
                            <div class="modal-body">
                                <form class="form-horizontal" action="controller/TypeChargeActionController.php" method="post">
                                    <div class="control-group">
                                        <label class="control-label">Nom Type Charge</label>
                                        <div class="controls">
                                            <input type="text" name="nom" value="" />
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <div class="controls">
                                            <input type="hidden" name="idProjet" value="<?= $idProjet ?>" />
                                            <input type="hidden" name="action" value="add" />    
                                            <button class="btn" data-dismiss="modal"aria-hidden="true">Non</button>
                                            <button type="submit" class="btn red" aria-hidden="true">Oui</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <!-- addTypeCharge box end -->
                        <!--**************************** CHARGES BEGIN ****************************-->
                        <div class="row-fluid">
                            <div class="input-box autocomplet_container">
                                <input class="m-wrap" name="type" id="type" type="text" placeholder="Type..." />
                                <input class="m-wrap" name="designation" id="designation" type="text" placeholder="Désignation..." />
                                <input class="m-wrap" name="societe" id="societe" type="text" placeholder="Société..." />
                                <a target="_blank" href="#printCharges" class="btn black" data-toggle="modal">
                                    <i class="icon-print"></i>&nbsp;Les Charges
                                </a>
                                <a href="#addTypeCharge" data-toggle="modal" class="btn blue pull-right">
                                    Type Charge <i class="icon-plus-sign "></i>
                                </a>
                                <a href="#addCharge" data-toggle="modal" class="btn green pull-right stay-away">
                                    Nouvelle Charge <i class="icon-plus-sign "></i>
                                </a>
                            </div>
                        </div>
                        <!-- printCharge box begin-->
                        <div id="printCharges" class="modal hide fade in" tabindex="-1" role="dialog" aria-labelledby="login" aria-hidden="false" >
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                <h3>Imprimer Liste des Charges </h3>
                            </div>
                            <div class="modal-body">
                                <form class="form-horizontal" action="controller/ChargePrintController.php" method="post" enctype="multipart/form-data">
                                    <p><strong>Séléctionner les charges à imprimer</strong></p>
                                    <div class="control-group">
                                      <label class="control-label">Imprimer</label>
                                      <div class="controls">
                                         <label class="radio">
                                             <div class="radio" id="toutes">
                                                 <span>
                                                     <input type="radio" class="criteriaPrint" name="criteria" value="toutesCharges" style="opacity: 0;">
                                                 </span>
                                             </div> Toutes les charges
                                         </label>
                                         <label class="radio">
                                             <div class="radio" id="date">
                                                 <span class="checked">
                                                     <input type="radio" class="criteriaPrint" name="criteria" value="parDate" checked="" style="opacity: 0;">
                                                 </span>
                                             </div> Par date
                                         </label>  
                                      </div>
                                   </div>
                                    <div class="control-group" id="showDateRange">
                                        <div class="controls date date-picker" data-date="" data-date-format="yyyy-mm-dd">
                                           <input style="width:100px" name="dateFrom" id="dateFrom" class="m-wrap m-ctrl-small date-picker" type="text" value="<?= date('Y-m-d') ?>" />
                                           &nbsp;-&nbsp;
                                           <input style="width:100px" name="dateTo" id="dateTo" class="m-wrap m-ctrl-small date-picker" type="text" value="<?= date('Y-m-d') ?>" />
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <div class="controls">
                                            <input type="hidden" name="idProjet" value="<?= $idProjet ?>" />
                                            <button class="btn" data-dismiss="modal"aria-hidden="true">Non</button>
                                            <button type="submit" class="btn red" aria-hidden="true">Oui</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <!-- printCharge box end -->
                        <!-- BEGIN Terrain TABLE PORTLET-->
                        <?php 
                        if(isset($_SESSION['charge-action-message'])
                        and isset($_SESSION['charge-type-message'])){
                            $message = $_SESSION['charge-action-message'];
                            $typeMessage = $_SESSION['charge-type-message'];
                        ?>
                            <div class="alert alert-<?= $typeMessage ?>">
                                <button class="close" data-dismiss="alert"></button>
                                <?= $message ?>      
                            </div>
                         <?php } 
                            unset($_SESSION['charge-action-message']);
                            unset($_SESSION['charge-type-message']);
                         ?>
                        <table class="table table-striped table-bordered table-advance table-hover">
                            <thead>
                                <tr>
                                    <th style="width: 20%"><strong>Total des charges</strong></th>
                                    <th style="width: 20%"></th>
                                    <th style="width: 20%"></th>
                                    <th style="width: 20%"></th>
                                    <th style="width: 20%"><a><strong><?= number_format($chargeManager->getTotalByIdProjet($idProjet), 2, ',', ' ') ?>&nbsp;DH</strong></a></th>
                                </tr>
                            </thead>
                        </table>
                        <div class="portlet charges">
                            <div class="portlet-body">
                                <div class="scroller" data-height="500px" data-always-visible="1"><!-- BEGIN DIV SCROLLER -->
                                <table class="table table-striped table-bordered table-advance table-hover">
                                    <thead>
                                        <tr>
                                            <th style="width: 20%">Type</th>
                                            <th style="width: 20%">Date Opération</th>
                                            <th style="width: 20%">Désignation</th>
                                            <th style="width: 20%">Société</th>
                                            <th style="width: 20%">Montant</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        foreach($charges as $charge){
                                        ?>      
                                        <tr class="charges">
                                            <td>
                                                <div class="btn-group">
                                                    <a class="btn black mini dropdown-toggle dropDownButton btn-fixed-width" href="#" data-toggle="dropdown">
                                                        <?= $charge->type() ?>             
                                                        <i class="icon-angle-down"></i>
                                                    </a>
                                                    <ul class="dropdown-menu">
                                                        <li>                                                                
                                                            <a href="#updateCharge<?= $charge->id();?>" data-toggle="modal" data-id="<?= $charge->id(); ?>">
                                                                Modifier
                                                            </a>
                                                            <a href="#deleteCharge<?= $charge->id() ?>" data-toggle="modal" data-id="<?= $charge->id() ?>">
                                                                Supprimer
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </td>
                                            <td><?= date('d/m/Y', strtotime($charge->dateOperation())) ?></td>
                                            <td class="hidden-phone"><?= $charge->designation() ?></td>
                                            <td class="hidden-phone"><?= $charge->societe() ?></td>
                                            <td class="hidden-phone"><?= number_format($charge->montant(), 2, ',', ' ') ?></td>
                                        </tr>
                                        <!-- updateCharge box begin-->
                                        <div id="updateCharge<?= $charge->id() ?>" class="modal hide fade in" tabindex="-1" role="dialog" aria-labelledby="login" aria-hidden="false" >
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                                <h3>Modifier Info Charge </h3>
                                            </div>
                                            <div class="modal-body">
                                                <form class="form-horizontal" action="controller/ChargeActionController.php" method="post">
                                                    <div class="control-group">
                                                        <label class="control-label">Type Charge</label>
                                                        <div class="controls">
                                                            <select name="type">
                                                                <option value="<?= $charge->type() ?>"><?= $charge->type() ?></option>
                                                                <option disabled="disabled">-------------</option>
                                                                <?php foreach($typeCharges as $type){ ?>
                                                                    <option value="<?= $type->nom() ?>"><?= $type->nom() ?></option>
                                                                <?php } ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="control-group">
                                                        <label class="control-label">Date Opération</label>
                                                        <div class="controls date date-picker" data-date="" data-date-format="yyyy-mm-dd">
                                                            <input name="dateOperation" id="dateOperation" class="m-wrap m-ctrl-small date-picker" type="text" value="<?= $charge->dateOperation() ?>" />
                                                            <span class="add-on"><i class="icon-calendar"></i></span>
                                                         </div>
                                                    </div>
                                                    <div class="control-group">
                                                        <label class="control-label">Montant</label>
                                                        <div class="controls">
                                                            <input type="text" name="montant" value="<?= $charge->montant() ?>" />
                                                        </div>
                                                    </div>
                                                    <div class="control-group">
                                                        <label class="control-label">Désignation</label>
                                                        <div class="controls">
                                                            <input type="text" name="designation" value="<?= $charge->designation() ?>" />
                                                        </div>
                                                    </div>
                                                    <div class="control-group">
                                                        <label class="control-label">Société</label>
                                                        <div class="controls">
                                                            <input type="text" name="societe" value="<?= $charge->societe() ?>" />
                                                        </div>
                                                    </div>
                                                    <div class="control-group">
                                                        <input type="hidden" name="idCharge" value="<?= $charge->id() ?>" />
                                                        <input type="hidden" name="idProjet" value="<?= $idProjet ?>" />
                                                        <input type="hidden" name="action" value="update" />
                                                        <div class="controls">  
                                                            <button class="btn" data-dismiss="modal"aria-hidden="true">Non</button>
                                                            <button type="submit" class="btn red" aria-hidden="true">Oui</button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                        <!-- updateCharge box end -->            
                                        <!-- deleteCharge box begin-->
                                        <div id="deleteCharge<?= $charge->id() ?>" class="modal hide fade in" tabindex="-1" role="dialog" aria-labelledby="login" aria-hidden="false" >
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                                <h3>Supprimer la charge</h3>
                                            </div>
                                            <div class="modal-body">
                                                <form class="form-horizontal loginFrm" action="controller/ChargeActionController.php" method="post">
                                                    <p>Êtes-vous sûr de vouloir supprimer cette charge <?= $charge->type() ?> ?</p>
                                                    <div class="control-group">
                                                        <label class="right-label"></label>
                                                        <input type="hidden" name="idCharge" value="<?= $charge->id() ?>" />
                                                        <input type="hidden" name="idProjet" value="<?= $idProjet ?>" />
                                                        <input type="hidden" name="action" value="delete" />
                                                        <button class="btn" data-dismiss="modal"aria-hidden="true">Non</button>
                                                        <button type="submit" class="btn red" aria-hidden="true">Oui</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                        <!-- deleteCharge box end -->    
                                        <?php
                                        }//end of loop
                                        ?>
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <th><strong>Total des charges</strong></th>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <th><strong><a><?= number_format($chargeManager->getTotalByIdProjet($idProjet), 2, ',', ' ') ?>&nbsp;DH</a></strong></th>
                                        </tr>
                                    </tbody>
                                </table>
                                </div><!-- END DIV SCROLLER --> 
                            </div>
                        </div>
                        <!-- END Terrain TABLE PORTLET-->
                        <!--**************************** CHARGES END ****************************-->
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
        2015 &copy; AnnahdaERP. Management Application.
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
        $('.charges').show();
        $('#type').keyup(function(){
            $('.charges').hide();
           var txt = $('#type').val();
           $('.charges').each(function(){
               if($(this).text().toUpperCase().indexOf(txt.toUpperCase()) != -1){
                   $(this).show();
               }
            });
        }); 
        $('#designation').keyup(function(){
            $('.charges').hide();
           var txt = $('#designation').val();
           $('.charges').each(function(){
               if($(this).text().toUpperCase().indexOf(txt.toUpperCase()) != -1){
                   $(this).show();
               }
            });
        }); 
        $('#societe').keyup(function(){
            $('.charges').hide();
           var txt = $('#societe').val();
           $('.charges').each(function(){
               if($(this).text().toUpperCase().indexOf(txt.toUpperCase()) != -1){
                   $(this).show();
               }
            });
        });
        $('.criteriaPrint').on('change',function(){
            if( $(this).val()==="toutesCharges"){
            $("#showDateRange").hide()
            }
            else{
            $("#showDateRange").show()
            }
        }); 
    </script>
</body>
<!-- END BODY -->
</html>
<?php
}
else{
    header('Location:index.php');    
}
?>
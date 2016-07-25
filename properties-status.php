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
        $projetManager = new ProjetManager($pdo);
        $appartementManager = new AppartementManager($pdo);
        $locauxManager = new LocauxManager($pdo);
        $contratManager = new ContratManager($pdo);
        $clientManager = new ClientManager($pdo);
        $appartements = $appartementManager->getAppartementsNonVendu();
        $appartementsRevendre = $contratManager->getAppartementsRevendre();
        $locaux = $locauxManager->getLocauxNonVendu();
        $locauxRevendre = $contratManager->getLocauxRevendre();
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
                            Les états des biens immobiliers non vendu   
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
                                <i class="icon-home"></i>
                                <a href="projets.php">Etats Immobilière</a>
                            </li>
                        </ul>
                        <!-- END PAGE TITLE & BREADCRUMB-->
                    </div>
                </div>
                <!-- END PAGE HEADER-->
                <!-- BEGIN PAGE CONTENT-->
                <div class="row-fluid"> 
                    <div class="span12">
                        <!--div class="get-down">
                            <input class="m-wrap" name="criteria" id="criteria" type="text" placeholder="Chercher Par Code, Status..." />
                        </div-->
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
                        <div class="portlet box light-grey">
                            <div class="portlet-title">
                                <h4>Liste des appartements</h4>
                                <div class="tools">
                                    <a href="javascript:;" class="reload"></a>
                                </div>
                            </div>
                            <div class="portlet-body">
                                <table class="table table-striped table-bordered table-hover" id="sample_2">
                                    <thead>
                                        <tr>
                                            <th style="width: 5%"></th>
                                            <th style="width: 5%">Code</th>
                                            <th style="width: 15%">Projet</th>
                                            <th style="width: 5%">Niveau</th>
                                            <!--th style="width: 10%">Prix&nbsp;DH</th-->
                                            <th style="width: 10%">Superficie</th>
                                            <th style="width: 10%">Façade</th>
                                            <th style="width: 25%">Nbr.Pièces</th>
                                            <th style="width: 5%">Cave</th>
                                            <th style="width: 10%">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        foreach($appartements as $appartement){
                                        ?>      
                                        <tr class="appartements">
                                            <td class="hidden-phone">
                                                <div class="btn-group">
                                                    <a class="btn green mini dropdown-toggle" data-toggle="dropdown"><i class="icon-exclamation-sign"></i></a>
                                                    <ul class="dropdown-menu info-dropdown">
                                                        <?php
                                                        if( $appartement->status()=="R&eacute;serv&eacute;" ){
                                                            if ( $_SESSION['userMerlaTrav']->profil()=="admin" ) {
                                                        ?>
                                                        <li>
                                                            <a href="#updateClient<?= $appartement->id() ?>" data-toggle="modal" data-id="<?= $appartement->id() ?>">
                                                                Pour : <strong><?= $appartement->par() ?></strong>
                                                            </a>
                                                        </li>
                                                        <?php
                                                            }
                                                            else{
                                                        ?>
                                                        <li>
                                                            <a>
                                                                Pour : <strong><?= $appartement->par() ?></strong>
                                                            </a>
                                                        </li>    
                                                        <?php        
                                                            }
                                                        }
                                                        ?>
                                                    </ul>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="btn-group">
                                                    <a style="width: 50px" class="btn mini dropdown-toggle" href="#" title="Prix : <?= number_format($appartement->prix(), 2, ',', ' ') ?> DH" data-toggle="dropdown">
                                                        <?= $appartement->nom() ?> 
                                                        <i class="icon-angle-down"></i>
                                                    </a>
                                                    <?php
                                                    if ( $_SESSION['userMerlaTrav']->profil()=="admin" ) {
                                                    ?>
                                                    <ul class="dropdown-menu">
                                                        <li>
                                                            <a href="appartement-detail.php?idAppartement=<?= $appartement->id() ?>&idProjet=<?= $appartement->idProjet() ?>">
                                                                Fiche descriptif
                                                            </a>
                                                        </li>
                                                    </ul>
                                                    <?php
                                                    }
                                                    ?>
                                                </div>
                                            </td>
                                            <td class="hidden-phone"><?= $projetManager->getProjetById($appartement->idProjet())->nom() ?></td>
                                            <td class="hidden-phone"><?= $appartement->niveau() ?></td>
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
                                                    if ( $_SESSION['userMerlaTrav']->profil()=="admin" ) {    
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
                                                     if ( $_SESSION['userMerlaTrav']->profil()=="admin" ) {   
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
                                            </td>
                                        </tr>
                                        <?php
                                        }//end of loop
                                        ?>
                                        <?php
                                        foreach($appartementsRevendre as $contrat){
                                            $appartement = $appartementManager->getAppartementById($contrat->idBien());
                                        ?>      
                                        <tr class="appartements">
                                            <td class="hidden-phone">
                                                <div class="btn-group">
                                                    <a class="btn green mini dropdown-toggle" data-toggle="dropdown"><i class="icon-exclamation-sign"></i></a>
                                                    <ul class="dropdown-menu info-dropdown">
                                                        <li>
                                                            <a>
                                                                Pour : <strong><?= $clientManager->getClientById($contrat->idClient())->nom() ?></strong> 
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a>
                                                                Montant de Revente : <strong><?= $appartement->montantRevente() ?> DH</strong> 
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </div>    
                                            </td>
                                            <td>
                                                <div class="btn-group">
                                                    <a style="width: 50px" class="btn mini dropdown-toggle" href="#" title="Prix : <?= number_format($appartement->prix(), 2, ',', ' ') ?> DH" data-toggle="dropdown">
                                                        <?= $appartement->nom() ?> 
                                                        <i class="icon-angle-down"></i>
                                                    </a>
                                                    <?php
                                                    if ( $_SESSION['userMerlaTrav']->profil()=="admin" ) {
                                                    ?>
                                                    <ul class="dropdown-menu">
                                                        <li>
                                                            <a href="appartement-detail.php?idAppartement=<?= $appartement->id() ?>&idProjet=<?= $appartement->idProjet() ?>">
                                                                Fiche descriptif
                                                            </a>
                                                        </li>
                                                    </ul>
                                                    <?php
                                                    }
                                                    ?>
                                                </div>
                                            </td>
                                            <td class="hidden-phone"><?= $projetManager->getProjetById($appartement->idProjet())->nom() ?></td>
                                            <td class="hidden-phone"><?= $appartement->niveau() ?></td>
                                            <!--td><a></a></td-->
                                            <td><?= $appartement->superficie() ?> m<sup>2</sup></td>
                                            <td class="hidden-phone"><?= $appartement->facade() ?></td>
                                            <td class="hidden-phone"><?= $appartement->nombrePiece() ?> pièces</td>
                                            <td class="hidden-phone">
                                                <?php if($appartement->cave()=="Sans"){ ?><a class="btn mini black">Sans</a><?php } ?>
                                                <?php if($appartement->cave()=="Avec"){ ?><a class="btn mini blue">Avec</a><?php } ?>
                                            </td>
                                            <td><a class="btn mini black">Revendre</a></td>
                                        </tr>
                                        <?php
                                        }//end of loop
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>*
                        <div class="portlet box light-grey">
                            <div class="portlet-title">
                                <h4>Liste des locaux commerciaux</h4>
                                <div class="tools">
                                    <a href="javascript:;" class="reload"></a>
                                </div>
                            </div>
                            <div class="portlet-body">
                                <table class="table table-striped table-bordered table-hover" id="sample_1">
                                    <thead>
                                        <tr>
                                            <th style="width:5%"></th>
                                            <th style="width:15%">Code</th>
                                            <th style="width:20%">Projet</th>
                                            <th style="width:20%">Superficie</th>
                                            <th style="width:20%">Façade</th>
                                            <th style="width:5%">Mezzanine</th>
                                            <th style="width:15%">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        foreach($locaux as $locau){
                                        ?>      
                                        <tr class="locaux">
                                            <td>
                                                <div class="btn-group">
                                                    <a class="btn black dropdown-toggle" data-toggle="dropdown"><i class="icon-exclamation-sign"></i></a>
                                                    <ul class="dropdown-menu info-dropdown">
                                                        <?php
                                                        if( $locau->status() == "R&eacute;serv&eacute;" ){
                                                            if ( $_SESSION['userMerlaTrav']->profil()=="admin" ) {  
                                                        ?>
                                                        <li>
                                                            <a href="#updateClient<?= $locau->id() ?>" data-toggle="modal" data-id="<?= $locau->id() ?>">
                                                                Pour : <?= $locau->par() ?>
                                                            </a>
                                                        </li>
                                                        <?php
                                                            }
                                                            else{
                                                        ?>
                                                            <li>
                                                                <a>
                                                                    Pour : <?= $locau->par() ?>
                                                                </a>
                                                            <li>    
                                                        <?php        
                                                            }
                                                        }
                                                        ?>
                                                    </ul>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="btn-group">
                                                    <a style="width: 50px" class="btn mini dropdown-toggle" href="#" title="Prix : <?= number_format($locau->prix(), 2, ',', ' ') ?> DH" data-toggle="dropdown">
                                                        <?= $locau->nom() ?> 
                                                        <i class="icon-angle-down"></i>
                                                    </a>
                                                    <?php
                                                    if ( $_SESSION['userMerlaTrav']->profil()=="admin" ) {    
                                                    ?>
                                                    <ul class="dropdown-menu">
                                                        <li>
                                                            <a href="locaux-detail.php?idLocaux=<?= $locau->id() ?>&idProjet=<?= $locau->idProjet() ?>">
                                                                Fiche descriptif
                                                            </a>
                                                        </li>
                                                    </ul>
                                                    <?php
                                                    }    
                                                    ?>
                                                </div>
                                            </td>
                                            <td class="hidden-phone"><?= $projetManager->getProjetById($locau->idProjet())->nom() ?></td>
                                            <td><?= $locau->superficie() ?></td>
                                            <td class="hidden-phone"><?= $locau->facade() ?></td>
                                            <!--td></td-->
                                            <td class="hidden-phone">
                                                <?php if($locau->mezzanine()=="Sans"){ ?><a class="btn mini black"><?= $locau->mezzanine() ?></a><?php } ?>
                                                <?php if($locau->mezzanine()=="Avec"){ ?><a class="btn mini blue"><?= $locau->mezzanine() ?></a><?php } ?>
                                            </td>
                                            <td>
                                                <?php
                                                if($locau->status()=="R&eacute;serv&eacute;"){ 
                                                    if ( $_SESSION['userMerlaTrav']->profil()=="admin" ) {    
                                                ?>
                                                    <a class="btn mini red" href="#changeToDisponible<?= $locau->id() ?>" data-toggle="modal" data-id="<?= $locau->id() ?>">
                                                        Réservé
                                                    </a>
                                                <?php 
                                                    }
                                                    else{
                                                ?>
                                                    <a class="btn mini red" >Réservé</a>
                                                <?php        
                                                    }
                                                } 
                                                ?>
                                                <?php 
                                                if($locau->status()=="Disponible"){ 
                                                    if ( $_SESSION['userMerlaTrav']->profil()=="admin" ) {  
                                                ?>
                                                    <a class="btn mini green" href="#changeToReserve<?= $locau->id() ?>" data-toggle="modal" data-id="<?= $locau->id() ?>">
                                                        Disponible
                                                    </a>
                                                <?php 
                                                    }
                                                    else{
                                                ?>
                                                    <a class="btn mini green">Disponible</a>
                                                <?php
                                                    }
                                                }         
                                                ?>
                                            </td>
                                        </tr>
                                        <?php
                                        }//end of loop
                                        ?>
                                        <?php
                                        foreach($locauxRevendre as $contrat){
                                            $locau = $locauxManager->getLocauxById($contrat->idBien());
                                        ?>      
                                        <tr class="locaux">
                                            <td>
                                                <div class="btn-group">
                                                    <a class="btn mini green dropdown-toggle" data-toggle="dropdown"><i class="icon-exclamation-sign"></i></a>
                                                    <ul class="dropdown-menu info-dropdown">
                                                        <li>   
                                                            <a>
                                                                Pour : <strong><?= $clientManager->getClientById($contrat->idClient())->nom() ?></strong> 
                                                            </a>
                                                        </li>
                                                        <li>   
                                                            <a>
                                                                Montant de Revente : <strong><?= number_format($locau->montantRevente(), 2, ',', ' ') ?> DH</strong> 
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </div>   
                                            </td>
                                            <td>
                                                <div class="btn-group">
                                                    <a style="width: 100px" class="btn mini dropdown-toggle" href="#" title="Prix : <?= number_format($locau->prix(), 2, ',', ' ') ?> DH" data-toggle="dropdown">
                                                        <?= $locau->nom() ?> 
                                                        <i class="icon-angle-down"></i>
                                                    </a>
                                                    <?php
                                                    if ( $_SESSION['userMerlaTrav']->profil()=="admin" ) {    
                                                    ?>
                                                    <ul class="dropdown-menu">
                                                        <li>
                                                            <a href="locaux-detail.php?idLocaux=<?= $locau->id() ?>&idProjet=<?= $locau->idProjet() ?>">
                                                                Fiche descriptif
                                                            </a>
                                                        </li>
                                                    </ul>
                                                    <?php
                                                    }    
                                                    ?>
                                                </div>
                                            </td>
                                            <td class="hidden-phone"><?= $projetManager->getProjetById($locau->idProjet())->nom() ?></td>
                                            <td><?= $locau->superficie() ?></td>
                                            <td class="hidden-phone"><?= $locau->facade() ?></td>
                                            <!--td></td-->
                                            <td class="hidden-phone">
                                                <?php if($locau->mezzanine()=="Sans"){ ?><a class="btn mini black"><?= $locau->mezzanine() ?></a><?php } ?>
                                                <?php if($locau->mezzanine()=="Avec"){ ?><a class="btn mini blue"><?= $locau->mezzanine() ?></a><?php } ?>
                                            </td>
                                            <td><a class="btn mini black">Revendre</a></td>
                                        </tr>
                                        <?php
                                        }//end of loop
                                        ?>
                                    </tbody>
                                </table>
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
    <script src="assets/jquery-ui/jquery-ui-1.10.1.custom.min.js"></script>
    <script src="assets/jquery-slimscroll/jquery.slimscroll.min.js"></script>   
    <script type="text/javascript" src="assets/uniform/jquery.uniform.min.js"></script>
    <script type="text/javascript" src="assets/data-tables/jquery.dataTables.js"></script>
    <script type="text/javascript" src="assets/data-tables/DT_bootstrap.js"></script>
    <script src="assets/js/app.js"></script>
    <script>
        jQuery(document).ready(function() {         
            // initiate layout and plugins
            App.setPage("table_managed");
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
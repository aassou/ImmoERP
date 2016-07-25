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
    //classes loading end
    session_start();
    if( isset($_SESSION['userMerlaTrav']) ){
        //classes managers  
        $projetManager = new ProjetManager($pdo);
        $clientManager = new ClientManager($pdo);
        $contratManager = new ContratManager($pdo);
        $locauxManager = new LocauxManager($pdo);
        //objs and vars
        $idProjet = $_GET['idProjet'];
        $projet = $projetManager->getProjetById($idProjet);
        $locaux = $locauxManager->getLocauxByIdProjet($idProjet);   
ob_start();
?>
<style type="text/css">
    p, h1{
        text-align: center;
        text-decoration: underline;
    }
    table, tr, td, th {
        border-collapse: collapse;
        width:auto;
        border: 1px solid black;
        font-size: 11px;
    }
    td, th{
        padding : 5px;
    }
    
    th{
        background-color: grey;
    }
    table, a{
        text-decoration: none;
    }
</style>
<page backtop="15mm" backbottom="20mm" backleft="10mm" backright="10mm">
    <!--img src="../assets/img/logo_company.png" style="width: 110px" /-->
    <h1>Locaux.Comm du Projet - <?= $projetManager->getProjetById($idProjet)->nom() ?></h1>
    <p>Imprimé le <?= date('d-m-Y') ?> | <?= date('h:i') ?> </p>
    <table>
        <tr>
            <th style="width: 10%">Code</th>
            <th style="width: 10%">Superficie</th>
            <th style="width: 10%">Façade</th>
            <th style="width: 10%">Mezzanine</th>
            <th style="width: 10%">Status</th>
            <th style="width: 50%"></th>
        </tr>
        <?php
        foreach ( $locaux as $locau ) {
        ?>      
        <tr>
            <td style="width: 10%"><?= $locau->nom() ?> </td>
            <td style="width: 10%"><?= $locau->superficie() ?> m<sup>2</sup></td>
            <td style="width: 10%"><?= $locau->facade() ?></td>
            <td style="width: 10%"><?= $locau->mezzanine() ?></td>
            <td style="width: 10%"><?= $locau->status() ?></td>
            <td style="width: 50%">Pour 
                <?php 
                if( $locau->status()=="R&eacute;serv&eacute;" ){ echo $locau->par(); }
                else if( $locau->status()=="Vendu" ){ echo $clientManager->getClientById($contratManager->getIdClientByIdProjetByIdBienTypeBien($idProjet, $locau->id(), "localCommercial"))->nom(); }
                ?>
            </td>
        </tr>
    <?php
        }//end of loop
    ?>
    </table>
    <br><br> 
    <br><br>
    <page_footer>
    <hr/>
    <p style="text-align: center;font-size: 9pt;"></p>
    </page_footer>
</page>    
<?php
    $content = ob_get_clean();
    
    require('../lib/html2pdf/html2pdf.class.php');
    try{
        $pdf = new HTML2PDF('P', 'A4', 'fr');
        $pdf->pdf->SetDisplayMode('fullpage');
        $pdf->writeHTML($content);
        $fileName = "LocauxList-".date('Ymdhi').'.pdf';
        $pdf->Output($fileName);
    }
    catch(HTML2PDF_exception $e){
        die($e->getMessage());
    }
}
else{
    header("Location:index.php");
}
?>
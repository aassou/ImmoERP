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
        $caisseManager = "";
        $projets = $projetManager->getProjets();
        $titre = "";
        $caisses = "";
        $titreDocument = "";
        $totalCaisse = 0;
        $societe = htmlentities($_POST['societe']);
        if ( $societe == 1 ) {
            $caisseManager = new CaisseManager($pdo);
            $titre = "Société Annahda";
        }
        else if ( $societe == 2 ) {
            $caisseManager = new CaisseIaazaManager($pdo);
            $titre = "Société Iaaza";
        }
        
        $criteria = htmlentities($_POST['criteria']);
        if( $criteria=="parDate" ) {
            $dateFrom = htmlentities($_POST['dateFrom']);
            $dateTo = htmlentities($_POST['dateTo']); 
            $type = htmlentities($_POST['type']);
            if( $type == "Toutes" ) {
                $caisses = $caisseManager->getCaissesByDates($dateFrom, $dateTo);
                $titreDocument = "Liste des opérations entre : ".date('d/m/Y', strtotime($dateFrom)).' - '.date('d/m/Y', strtotime($dateTo));
                $totalCaisse = 
                $caisseManager->getTotalCaisseByTypeByDate('Entree', $dateFrom, $dateTo) - $caisseManager->getTotalCaisseByTypeByDate('Sortie', $dateFrom, $dateTo);   
            }
            else {
                $caisses = $caisseManager->getCaissesByDatesByType($dateFrom, $dateTo, $type);
                $titreDocument = "Liste des opérations d'".$type." entre : ".date('d/m/Y', strtotime($dateFrom)).' - '.date('d/m/Y', strtotime($dateTo));
                $totalCaisse = 
                $caisseManager->getTotalCaisseByType($type, $dateFrom, $dateTo);
            }
        }
        else if ( $criteria=="toutesCaisse" ) {
            $caisses = $caisseManager->getCaisses();
            $titreDocument = "Bilan de toutes les opérations de caisse";
            $totalCaisse = $caisseManager->getTotalCaisseByType('Entree') - $caisseManager->getTotalCaisseByType('Sortie');   
            /*if ( isset($_POST['type']) ) {
                $type = htmlentities($_POST['type']);
                $caisses = $caisseManager->getCaissesByType($type);
                $titreDocument = "Liste des opérations de type : ".$type;
            }*/
        }

ob_start();
?>
<style type="text/css">
    p, h1{
        text-align: center;
        text-decoration: underline;
    }
    table {
            border-collapse: collapse;
            width:100%;
        }
        
        table, th, td {
            border: 1px solid black;
        }
        td, th{
            padding : 5px;
        }
        
        th{
            background-color: grey;
        }
</style>
<page backtop="15mm" backbottom="20mm" backleft="10mm" backright="10mm">
    <!--img src="../assets/img/logo_company.png" style="width: 110px" /-->
    <h1><?= $titre ?></h1>
    <h1><?= $titreDocument ?></h1>
    <p>Imprimé le <?= date('d-m-Y') ?> | <?= date('h:i') ?> </p>
    <br>
    <table>
        <tr>
            <!--th style="width: 20%">Type</th-->
            <th style="width: 20%">Date opération</th>
            <th style="width: 20%">Crédit</th>
            <th style="width: 20%">Débit</th>
            <th style="width: 20%">Désignation</th>
            <th style="width: 20%">Destination</th>
        </tr>
        <?php
        foreach($caisses as $caisse){
        ?>      
        <tr>
            <td><?= date('d/m/Y', strtotime($caisse->dateOperation())) ?></td>
            <?php
            if ( $caisse->type() == "Entree" ) {
            ?>
            <td><?= number_format($caisse->montant(), 2, ',', ' ') ?></td>
            <td></td>
            <?php  
            }
            else {
            ?>
            <td></td>
            <td><?= number_format($caisse->montant(), 2, ',', ' ') ?></td>
            <?php
            }
            ?>
            <td><?= $caisse->designation() ?></td>
            <td><?= $caisse->destination() ?></td>
        </tr>   
        <?php
        }//end of loop
        ?>
    </table>
    <table>
        <tr>
            <th style="width: 20%">Solde</th>
            <td style="width: 40%"><strong><?= number_format($totalCaisse, 2, ' ', ',') ?>&nbsp;DH</strong></td>
            <td style="width: 20%"></td>
            <td style="width: 20%"></td>
        </tr>
    </table>
    <br><br>
    <page_footer>
    <hr/>
    <p style="text-align: center;font-size: 9pt;">STE GROUPE ANNAHDA LIL IAAMAR SARL – Quartier Ouled Brahim N°B-1 en face Lycée Nador Jadid (Anaanaa), Nador. 
        <br>Tél : 05 36 33 10 31 - Fax : 05 36 33 10 32 </p>
    </page_footer>
</page>    
<?php
    $content = ob_get_clean();
    
    require('../lib/html2pdf/html2pdf.class.php');
    try{
        $pdf = new HTML2PDF('P', 'A4', 'fr');
        $pdf->pdf->SetDisplayMode('fullpage');
        $pdf->writeHTML($content);
        $fileName = "BilanCaisse-".date('Ymdhi').'.pdf';
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
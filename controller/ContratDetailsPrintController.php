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
        $idProjet = 0;
        $projetManager = new ProjetManager($pdo);
        $contratEmployeManager = new ContratEmployeManager($pdo);
        $contratDetaislManager = new ContratDetailsManager($pdo);
        $employesManager = new EmployeManager($pdo);
        if(isset($_GET['idContratEmploye']) and ($_GET['idContratEmploye'])>0 and $_GET['idContratEmploye']<=$contratEmployeManager->getLastId()){
            $idProjet = $_GET['idProjet'];
            $idContratEmploye = $_GET['idContratEmploye'];
            $projet = $projetManager->getProjetById($idProjet);
            $contratEmploye = $contratEmployeManager->getContratEmployeById($idContratEmploye);
            $contratDetails = $contratDetaislManager->getContratDetailsByIdContratEmploye($idContratEmploye);
            $totalPaye = $contratDetaislManager->getContratDetailsTotalByIdContratEmploye($idContratEmploye);
        }

ob_start();
?>
<style type="text/css">
    p, h1, h3{
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
    <h1>Détails Contrat <?= $contratEmploye->employe() ?></h1>
    <h3>Projet <?= ucfirst($projet->nom()) ?></h3>
    <p>Imprimé le <?= date('d/m/Y') ?> | <?= date('h:i') ?> </p>
    <br><br>
    <table>
        <tr>
            <th style="width:20%">Date Opération</th>
            <th style="width:20%">Numéro Chèque</th>
            <th style="width:20%">Montant</th>
            <th style="width:20%"></th>
            <th style="width:20%"></th>
        </tr>
        <?php
        foreach($contratDetails as $contrat){
        ?>      
        <tr>
            <td><?= date('d/m/Y', strtotime($contrat->dateOperation()) ) ?></td>
            <td><?= $contrat->numeroCheque() ?></td>
            <td><?= number_format($contrat->montant(), 2, ',', ' ') ?></td>
            <td></td>
            <td></td>
        </tr>  
        <?php
        }//end of loop
        ?>
    </table>
    <table>
        <tr>
            <th style="width:20%"></th>
            <th style="width:20%"></th>
            <th style="width:20%">Total Payé</th>
            <th style="width:20%">Total A Payer</th>
            <th style="width:20%">Reste</th>
        </tr>  
        <tr>
            <td></td>
            <td></td>
            <td><?= number_format($totalPaye, 2, ',', ' ') ?></td>
            <td><?= number_format($contratEmploye->total(), 2, ',', ' ') ?></td>
            <td><?= number_format($contratEmploye->total()-$totalPaye, 2, ',', ' ') ?></td>
        </tr>
    </table>
    <br><br><br>
    <table>
        <tr>
            <th style="width:30%">Signature</th>
        </tr>  
        <tr>
            <td style="height:100px"></td>
        </tr>
    </table>
    <br><br>
    <page_footer>
    <hr/>
    <p style="text-align: center;font-size: 9pt;"> </p>
    </page_footer>
</page>    
<?php
    $content = ob_get_clean();
    
    require('../lib/html2pdf/html2pdf.class.php');
    try{
        $pdf = new HTML2PDF('P', 'A4', 'fr');
        $pdf->pdf->SetDisplayMode('fullpage');
        $pdf->writeHTML($content);
        $fileName = "ContratDetails-".date('Ymdhi').'.pdf';
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
<?php
    require('../app/classLoad.php'); 
    require('../db/PDOFactory.php');  
    
    session_start();
    
    if( isset($_SESSION['userImmoERPV2']) ){
        //classes managers  
        $idProjet = 0;
        $projetManager = new ProjetManager(PDOFactory::getMysqlConnection());
        $contratEmployeManager = new ContratEmployeManager(PDOFactory::getMysqlConnection());
        $contratDetaislManager = new ContratDetailsManager(PDOFactory::getMysqlConnection());
        $employesManager = new EmployeManager(PDOFactory::getMysqlConnection());
        //obj and vars
        $contratDetails = "";
        if(isset($_GET['idContratDetail']) and ($_GET['idContratDetail'])>0 and $_GET['idContratDetail']<=$contratDetaislManager->getLastId()){
            $idProjet = $_GET['idProjet'];
            $idContratDetail = $_GET['idContratDetail'];
            $projet = $projetManager->getProjetById($idProjet);
            $contratDetails = $contratDetaislManager->getContratDetailsById($idContratDetail);
            $contrat = $contratEmployeManager->getContratEmployeById($contratDetails->idContratEmploye());
            $employe = $employesManager->getEmployeById($contrat->employe());
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
    <h3>Quittance pour <?= $employe->nom() ?> - <?= ucfirst($projet->nom()) ?> - <?= $contrat->traveaux() ?></h3>
    <p>Imprimé le <?= date('d/m/Y') ?> | <?= date('h:i') ?> </p>
    <br><br>
    <table>
        <tr>
            <th style="width:40%">Date Opération</th>
            <th style="width:30%">Numéro Chèque</th>
            <th style="width:30%">Montant</th>
        </tr>
        <?php
        ?>      
        <tr>
            <td style="width:40%"><?= date('d/m/Y', strtotime($contratDetails->dateOperation()) ) ?></td>
            <td style="width:30%"><?= $contratDetails->numeroCheque() ?></td>
            <td style="width:30%"><?= number_format($contratDetails->montant(), 2, ',', ' ') ?></td>
        </tr>  
        <?php
        ?>
    </table>
    <br><br><br>
    <table>
        <tr>
            <th style="width:30%">Signature</th>
        </tr>  
        <tr>
            <td style="height:70px"></td>
        </tr>
    </table>
    <br>
    <page_footer>
    <hr/>
    <p style="text-decoration : none; text-align: center;font-size: 9pt;">Groupe Annahda Lil Iaamar SARL</p>
    </page_footer>
</page>    
<?php
    $content = ob_get_clean();
    
    require('../lib/html2pdf/html2pdf.class.php');
    try{
        $pdf = new HTML2PDF('L', 'A5', 'fr');
        $pdf->pdf->SetDisplayMode('fullpage');
        $pdf->writeHTML($content);
        $fileName = "Quittance-Employe-".date('Ymdhi').'.pdf';
        $pdf->Output($fileName);
    }
    catch(HTML2PDF_exception $e){
        die($e->getMessage());
    }
}
else{
    header("Location:../index.php");
}
?>
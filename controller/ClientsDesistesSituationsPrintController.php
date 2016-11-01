<?php
    require('../app/classLoad.php'); 
    require('../db/PDOFactory.php');  
    //classes loading end
    session_start();
    if( isset($_SESSION['userImmoERPV2']) and $_SESSION['userImmoERPV2']->profil()=="admin" ){
        $idProjet = $_GET['idProjet'];
        //classes managers  
        $projetManager = new ProjetManager(PDOFactory::getMysqlConnection());
        $clientManager = new ClientManager(PDOFactory::getMysqlConnection());
        $contratManager = new ContratManager(PDOFactory::getMysqlConnection());
        $operationManager = new OperationManager(PDOFactory::getMysqlConnection());
        $appartementManager = new AppartementManager(PDOFactory::getMysqlConnection());
        $locauxManager = new LocauxManager(PDOFactory::getMysqlConnection());
        //objs and vars
        $contratNumber = $contratManager->getContratsNumberByIdProjet($idProjet);
        $contrats = $contratManager->getContratsDesistesByIdProjet($idProjet);
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
    <h1>Clients Désistés - <?= $projetManager->getProjetById($idProjet)->nom() ?></h1>
    <p>Imprimé le <?= date('d-m-Y') ?> | <?= date('h:i') ?> </p>
    <table>
        <tr>
            <th>Client</th>
            <th>Type</th>
            <th>Bien</th>
            <th>Prix</th>
            <th>Réglements</th>
            <th>Reste</th>
        </tr>
        <?php
        if($contratNumber != 0){
        foreach($contrats as $contrat){
            $operationsNumber = $operationManager->getOpertaionsNumberByIdContrat($contrat->id());
            $sommeOperations = $operationManager->sommeOperations($contrat->id());
            $bien = "";
            $typeBien = "";
            if($contrat->typeBien()=="appartement"){
                $bien = $appartementManager->getAppartementById($contrat->idBien());
                $typeBien = "Appart";
            }
            else{
                $bien = $locauxManager->getLocauxById($contrat->idBien());
                $typeBien = "Local.Com";
            }
        ?>      
        <tr>
            <td style="width: 25%"><a><?= $clientManager->getClientById($contrat->idClient())->nom() ?></a></td>
            <td style="width: 15%"><?= $typeBien ?></td>
            <td style="width: 15%"><?= $bien->nom() ?></td>
            <td style="width: 15%"><?= number_format($contrat->prixVente(), 2, ',', ' ') ?></td>
            <td style="width: 15%"><?= number_format($sommeOperations, 2, ',', ' ') ?></td>
            <td style="width: 15%"><?= number_format($contrat->prixVente()-$sommeOperations, 2, ',', ' ') ?></td>
        </tr>
    <?php
        }//end of loop
    }//end of if
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
        $fileName = "FicheSituationClientDesiste-".date('Ymdhi').'.pdf';
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
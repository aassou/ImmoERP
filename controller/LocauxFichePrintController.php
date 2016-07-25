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
    if( isset($_SESSION['userMerlaTrav']) and $_SESSION['userMerlaTrav']->profil()=="admin" ){
        $clientManager = new ClientManager($pdo);
        $locauxManager = new LocauxManager($pdo);
		$contratManager = new ContratManager($pdo);
		$projetManager = new ProjetManager($pdo);
		$idAppartement = 0;
		if(isset($_GET['idLocaux']) and $_GET['idLocaux']>0 and $_GET['idLocaux']<=$locauxManager->getLastId()){
			$idLocaux = $_GET['idLocaux'];
			$local = $locauxManager->getLocauxById($idLocaux);
	        $contrat = $contratManager->getContratByIdBien($local->id());
	        $client = $clientManager->getClientById($contrat->idClient());
	        $projet = $projetManager->getProjetById($contrat->idProjet());
			$piecesLocauxManager = new PiecesLocauxManager($pdo);
			$piecesNumber = $piecesLocauxManager->getPiecesLocauxNumberByIdLocaux($local->id());
			$pieces="";
			if($piecesNumber>0){
				$pieces = $piecesLocauxManager->getPiecesLocauxByIdLocaux($local->id());	
			}
		}
//property data

ob_start();
?>
<style type="text/css">
	table{
	    width:100%;
	    border: solid 1px black;
	}
</style>
<page backtop="15mm" backbottom="20mm" backleft="10mm" backright="10mm">
    <!--img src="../assets/img/logo_company.png" style="width: 110px" /-->
    <br><br><br><br>
    <h2 style="font-size:20px; text-align: center; text-decoration: underline">Fiche descriptif</h2>
    <br><br>
    <table>
        <tr>
            <td style="width:30%"><strong>Programme </strong></td>
            <td style="width:70%"> : <?= $projet->nom() ?></td>
        </tr>
        <tr>
            <td><strong>Type du bien </strong></td>
            <td> : Local commercial</td>
        </tr>
        <tr>
            <td><strong>Code du bien </strong></td>
            <td> : <?= $local->nom() ?></td>
        </tr>
        <tr>
            <td><strong>Superficie Approximative</strong></td>
            <td> : <?= $local->superficie() ?> m²</td>
        </tr>
        <tr>
            <td><strong>Façade</strong></td>
            <td> : <?= $local->facade() ?></td>
        </tr>
        <tr>
            <td><strong>Mezzanine</strong></td>
	        <?php
			if($local->mezzanine()=="Avec"){
				echo "<td> : Avec Mezzanine</td>";
			} 
			else{
				echo "<td> : Sans Mezzanine</td>";
			}
			?>
        </tr>
        <tr>
            <td><strong>Prix H.T </strong></td>
            <td> : <?= $contrat->prixVente() ?>&nbsp;DH</td>
        </tr>
    </table>
    <br>
    <?php 
    if(str_word_count($pieces>0)){
    ?>
    <img src="<?= "http://www.merlatrav.esy.es/".$pieces[0]->url() ?>" style="width:100%">
    <?php 
    }
    ?>
    <page_footer>
    <hr/>
    <p style="text-align: center"></p>
    </page_footer>
</page>    
<?php
    $content = ob_get_clean();
    
    require('../lib/html2pdf/html2pdf.class.php');
    try{
        $pdf = new HTML2PDF('P', 'A4', 'fr');
        $pdf->pdf->SetDisplayMode('fullpage');
		$pdf->setTestIsImage(false);
        $pdf->writeHTML($content);
		$fileName = "FicheDescriptifLocalCom-".$local->nom()."-".date('Y-m-d-h-i').'.pdf';
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
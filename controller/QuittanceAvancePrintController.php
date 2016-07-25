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
        //classes managers	
        $clientManager = new ClientManager($pdo);
        $contratManager = new ContratManager($pdo);
        $projetManager = new ProjetManager($pdo);
		$operationManager = new OperationManager($pdo);
        $appartementManager = new AppartementManager($pdo);
		$locauxManager = new LocauxManager($pdo);
		//classes and attributes
		$bien = "";
		$idContrat = $_GET['idContrat'];
        $contrat = $contratManager->getContratById($idContrat);
        $client = $clientManager->getClientById($contrat->idClient());
        $projet = $projetManager->getProjetById($contrat->idProjet());
		$typeBien = "";
		$etage = "";
		$expressionOrthographe = "";
        if( $contrat->typeBien()=="appartement" ){
        	$bien = $appartementManager->getAppartementById($contrat->idBien());
			$typeBien = "Appartement";
			$etage = "en ".$bien->niveau();
			$expressionOrthographe = "de l'";
        }
		else if( $contrat->typeBien()=="localCommercial" ){
			$bien = $locauxManager->getLocauxById($contrat->idBien());
			$typeBien = "Local commercial";
			$expressionOrthographe = "du";
		}
//property data

$programme  = $projet->nom();
$adresse = $projet->adresse();
$numeroBien = $bien->id();
$superficie = $bien->superficie();
$prixHt = number_format($contrat->prixVente(), 2, ',', ' ');
$nomBien = $bien->nom();
//customer data
$clientNom = $client->nom();
$cin = $client->cin();
$adresse = $client->adresse();
$telephone = $client->telephone1(); 
$email = $client->email();
$dateCreation = $contrat->dateCreation();
//quittance text
$somme = number_format($contrat->avance(), 2, ',', ' ');

$quittanceText = "Le représentant de la société <strong>MERLA TRAV SARL</strong> confirme avoir reçu<br> le 
<strong>".$dateCreation."</strong> de Mr/Mme/Mlle: <strong>".$clientNom."</strong>, le montant de<br> <strong>
".$somme." DH</strong>.";

$quittanceText2 = "Relatif à la réservation ".$expressionOrthographe." <strong>".$typeBien."</strong>
 N° <strong>".$nomBien."</strong> ".$etage.", ".$adresse.", <br>dépendant du programme <strong>".$programme."</strong>";

$remarque = "<strong>N.B</strong> : Ce reçu est délivré sous réserve de l’encaissement du chèque. 
En  cas de rejet pour quelque motif que ce soit , le présent reçu deviendra nul et non avenu.";

ob_start();
?>
<style type="text/css">
	h2{
		text-align: center;
		text-decoration: underline;
	}
	table{
	    width:100%;
	    border: solid 1px black;
	}
	p{
		font-size: 16pt;
	}
</style>
<page backtop="15mm" backbottom="20mm" backleft="10mm" backright="10mm">
    <!--img src="../assets/img/logo_company.png" style="width: 110px" /-->
    <br><br><br><br><br><br><br>
    <h2>QUITTANCE DE PAIEMENT DE L'AVANCE</h2>
    <br><br><br><br><br><br><br>
    <p><?= $quittanceText ?></p>
    <p><?= $quittanceText2 ?></p>
    <br><br><br><br>
    <p><strong>Mode de Paiement</strong> : <?= $contrat->modePaiement() ?></p>
    <br><br>
    <p style="text-align: center">EMARGEMENT SOCIETE</p>
    <br><br>
    <br><br>
    <page_footer>
    <p style="font-size: 11pt;"><?= $remarque ?></p>
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
		$fileName = "quittance-avance-".$clientNom."-".$bien->nom().'-'.$dateCreation.'.pdf';
       	$pdf->Output($fileName, 'D');
    }
    catch(HTML2PDF_exception $e){
        die($e->getMessage());
    }
}
else{
    header("Location:index.php");
}
?>
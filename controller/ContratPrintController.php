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
        $clientManager = new ClientManager($pdo);
        $contratManager = new ContratManager($pdo);
        $companyManager = new CompanyManager($pdo);
        $projetManager = new ProjetManager($pdo);
        $appartementManager = new AppartementManager($pdo);
		$locauxManager = new LocauxManager($pdo);
		$biens = "";
		$idContrat = 0;
        if( isset($_GET['idContrat']) and ($_GET['idContrat']>0 and $_GET['idContrat']<=$contratManager->getLastId()) ){
        	$idContrat = $_GET['idContrat'];
        }
		else{
			header('Location:../dashboard.php');
			exit;
		}
        $contrat = $contratManager->getContratById($idContrat);
        $client = $clientManager->getClientById($contrat->idClient());
        $projet = $projetManager->getProjetById($contrat->idProjet());
		$typeBien = "";
        if( $contrat->typeBien()=="appartement" ){
        	$biens = $appartementManager->getAppartementById($contrat->idBien());
			$typeBien = "Appartement";
        }
		else if( $contrat->typeBien()=="localCommercial" ){
			$biens = $locauxManager->getLocauxById($contrat->idBien());
			$typeBien = "Local commercial";
		}
        $idSociete = $contrat->societeArabe();
        $company = $companyManager->getCompanyById($idSociete);
//property data

$programme  = $projet->nom();
$superficie = $biens->superficie();
$prixHt = number_format($contrat->prixVente(), 2, ',', ' ');
//customer data
$clientNom = $client->nom();
$cin = $client->cin();
$adresse = $client->adresse();
$telephone = $client->telephone1(); 
$email = $client->email();
//contract text
$somme = number_format($contrat->avance(), 2, ',', ' ');
$montantMesuel = number_format($contrat->echeance(), 2, ',', ' ');
$modePaiement = $contrat->modePaiement();
$dureePaiement = $contrat->dureePaiement();

$contratTexte = "La somme de : <strong>".$somme."</strong> Dirhams, <strong>{</strong>à verser au plus tard 10 jours après la date de 
signature<strong>}</strong> , représentant un premier versement de réservation de l’appartement <strong>".$biens->nom()."</strong> dépendant 
du programme ci-dessus. 
Le client déclare accepte la désignation de l'appartement objet du présent reçu et les échéances 
de paiement fixé comme suit :";

$contratTexte2 = "<strong>Le reste à ventiler sur ".$dureePaiement." mois soit une constante mensuelle de ".$montantMesuel." DH</strong>";

$remarque = "Dans le cas où le client a marqué trois retards de paiements des mensualités fixés 
ci-dessus, la société a le droit d’annuler la réservation de l’appartement objet de cet avis de 
réservation sans accord du client, et en cas de désistement de l'acquéreur, 
le montant de l'avance ne sera remboursé qu'après vente de l'unité objet de désistement.";

ob_start();
?>
<style type="text/css">
	table{
	    width:100%;
	    border: solid 1px black;
	}
	.article{
	    font-size:11pt;
	    text-align: justify;
	}
	.article-title{
        text-decoration: underline;
    }
	.specification{
	    font-size:10.48pt;
	}
	 .specification-title{
	     text-decoration: underline;
	 }
</style>
<page backtop="15mm" backbottom="20mm" backleft="10mm" backright="10mm">
    <!--img src="../assets/img/logo_company.png" style="width: 110px" /-->
    <h2 style="font-size:20px; text-align: center; text-decoration: underline">Contrat de réservation d'un <?= $typeBien ?></h2>
    <br>
    <p style="font-size: 12pt; text-align: justify">
        <strong>PARTIE 1</strong> : Société <?= $company->nom() ?> 
        dont le siège se trouve à quartier 313 OULED BRAHIM. MIZZANINE N°B1 Nador.
    </p>
    <p style="font-size: 12pt; text-align: justify">
        <strong>PARTIE 2</strong> : Mlle/Mme/Mr <?= strtoupper($clientNom) ?>, Marocain, adulte, portant la CIN N° <?= $cin ?>,  
        demeurant à <?= $adresse ?>.
    </p>
    <p style="font-size: 12pt; text-align: center; text-decoration: underline">
        <strong>TEXTE DU CONTRAT</strong>
    </p>
    <p class="article">
        <strong class="article-title">ARTICLE 1</strong> : 
        Les parties reconnaissent a se contracter et agir en conformité avec les règles juridiques, sans conquérir et de bonne foi.
    </p>
    <p class="article">
        <strong class="article-title">ARTICLE 2</strong> : 
        Les deux parties ont convenu que ce contrat n’est pas un contrat de vente définitif. Et n’approuve pas la propriété de du bien immobilier qu’après avoir payé la totalité du prix du bien immobilier par la première partie et la conclusion finale du contrat de vente définitif chez le Notaire et le respect des formalités et conditions prévues par la loi.
    </p>
    <p class="article">
        <strong class="article-title">ARTICLE 3</strong> : 
         La première partie reconnaît qu’il garde le droit de la deuxième partie dans l’acquisition d’un <?= ucfirst($typeBien) ?> dans le projet de logements nommé <?= $programme ?>, selon les spécifications suivantes : 
    </p>
    <ul class="specification"> 
        <li><span class="specification-title">Supérifice approximative</span> : <?= $superficie ?>m<sup>2</sup>( superficie communiqué par l’architecte selon le plan de construction et la superficie utile sera déterminer ultérieurement par l’administration de la conservation foncière).</li>
        <?php if( $typeBien == "appartement" ) { ?>
        <li><span class="specification-title">Etage</span> : <?= $biens->niveau() ?></li>
        <?php } ?>
        <li><span class="specification-title">La vue</span> : <?= ucfirst($typeBien) ?> avec <?= $biens->facade() ?></li>
        <li><span class="specification-title">N° <?= ucfirst($typeBien) ?></span> : <?= $biens->nom() ?></li>
        <li><span class="specification-title">L’état de <?= ucfirst($typeBien) ?> conformément à l’accord</span> : <?= $contrat->etatBienArabe() ?></li>
        <li><span class="specification-title">Titre mère de terrain </span> : <?= $projet->titre() ?></li>
    </ul>
    <p class="article">
        <strong class="article-title">ARTICLE 4</strong> : 
          La deuxième partie paye pour la première partie une avance de <?= number_format($contrat->avance(), 2, ',', ' ') ?> DH.
          (), en contrepartie d’une quittance détaillée comme seul preuve de paiement,  et cela dans un délai ne dépasse pas 10 jours à compter de la date de signature de cette contrat. 
    </p>
    <p class="article">
        <strong class="article-title">ARTICLE 5</strong> : 
          Les deux parties sont en accord du prix définitif de <?= ucfirst($typeBien) ?> soit : <?= number_format($contrat->prixVente(), 2, ',', ' ') ?> DH.
          () payé par la deuxième partie en faveur de la première sous forme des échéances à compter de la date de première avance jusqu’au achèvement des travaux de la construction et la finition soit une échéance de 
          <?= number_format($contrat->echeance(), 2, ',', ' ') ?> DH chaque <?= $contrat->nombreMois() ?> mois, à partir de la date de signature du présente acte. 
    </p>
    <p class="article">
        <strong class="article-title">ARTICLE 6</strong> : 
        En cas retard de paiement des échéances fixé dans l’article 5, la première partie a le droit d’envoyer un écrit sous forme d’avertissement dans l’adresse fixée par la deuxième partie.
    </p>
    <p class="article">
        <strong class="article-title">ARTICLE 7</strong> : 
        La première partie détermine un délai maximum de 15 jours dans son écrit destiné à la deuxième partie à partir de la date de livraison. 
    </p>
    <p class="article">
        <strong class="article-title">ARTICLE 8</strong> : 
        La deuxième partie approuve que l’adresse choisi par elle-même dans ce contrat représente ca vrai domicile, et qu’elle assume la responsabilité total en cas de retour du courir fixé dans l’article 7 pour quelque soit le motif.
    </p>
    <p class="article">
        <strong class="article-title">ARTICLE 9</strong> : 
        La première partie s’engage en cas d’expiration du délai de 15 jours fixé dans le courir destiné a la deuxième partie, de restituer le montant de l’avance ainsi que la somme des échéances payés par la deuxième partie sans aucun prélèvement, dommage au pénalité. Et cela après récupération de toute quittance de paiement délivré par la première partie. Cette dernière s’engage aussi de faire comme en cas de livraisons de l’appartement en état des gros ouvres après expiration du délai de 90 jours pour que la deuxième partie accompli les travaux de la finition du bien immobilier.
    </p>
    <p class="article">
        <strong class="article-title">ARTICLE 10</strong> : 
        Après expiration des délais fixés dans ce contrat, le bien immobilier sera à la disposition de la première partie.
    </p>
    <p class="article">
        <strong class="article-title">ARTICLE 11</strong> : 
        La deuxième partie n’a pas le droit de demander aucune indemnité amicalement ou judiciairement après expiration des délais fixés dans les articles 7 et 9, sauf la restitution des fonds déjà versé en profit de la première partie.  
    </p>
    <p class="article">
        <strong class="article-title">ARTICLE 12</strong> : 
        En cas de litige les deux parties sont d’accord de soumettre cette contrat aux dispositions du deuxième paragraphe de l’article 114 du droit des contrats et des obligations.
    </p>
    <p class="article">
        <strong class="article-title">ARTICLE FINAL</strong> : 
        Le présent acte est un contrat coutumier et s’engage les deux parties et conserve leur droits au moment de la signature et sans l’obligation de l’égaliser les signatures dans l’attente de rédiger l’acte de vente définitif sous les dispositions et les formalités fixé par la loi marocain.  
    </p>
    <br><br><br><br><br><br><br><br><br><br><br><br>
    <strong>Nador, le <?= date('d/m/Y', strtotime($contrat->dateCreation())); ?></strong>
    <br><br><br><br><br><br><br><br>
    <table border="0">
        <tr>
            <td style="width:70%;"><strong>PARTIE 1</strong></td>
            <td style="width:30%;"><strong>PARTIE 2</strong></td>
        </tr>
    </table>
    <page_footer>
    </page_footer>
</page>    
<?php
    $content = ob_get_clean();
    
    require('../lib/html2pdf/html2pdf.class.php');
    try{
        $pdf = new HTML2PDF('P', 'A4', 'fr');
        $pdf->pdf->SetDisplayMode('fullpage');
        $pdf->writeHTML($content);
		$fileName = "contrat-".$clientNom."-".$biens->nom().'-'.date('Y-m-d-h-i').'.pdf';
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
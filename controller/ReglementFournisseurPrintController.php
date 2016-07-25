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
        $fournisseurManager = new FournisseurManager($pdo);
		$projetManager = new ProjetManager($pdo);
		$livraisonManager = new LivraisonManager($pdo);
		$idFournisseur = 0;
    	if( isset($_GET['idFournisseur']) and 
    	($_GET['idFournisseur']>0 and $_GET['idFournisseur']<=$fournisseurManager->getLastId()) ){
    		$idFournisseur = $_GET['idFournisseur'];
    		$reglementsManager = new ReglementFournisseurManager($pdo);
			$reglementNumber = $reglementsManager->getReglementsNumberByIdFournisseurOnly($idFournisseur);
			$reglements = $reglementsManager->getReglementFournisseursByIdFournisseur($idFournisseur);
			$total = $reglementsManager->getTotalReglementByIdFournisseur($idFournisseur);
			$totalLivraisons = $livraisonManager->getTotalLivraisonsIdFournisseur($idFournisseur);
			$nomFournisseur = $fournisseurManager->getFournisseurById($idFournisseur)->nom(); 
    	}

ob_start();
?>
<style type="text/css">
	p, h1, h2{
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
    <br><br><br><br><br><br><br>
    <h1>Bilan des Réglements du fournisseur</h1>
    <h2><?= $nomFournisseur ?></h2>
    <p>Imprimé le <?= date('d-m-Y') ?> | <?= date('h:i') ?> </p>
    <br><br><br><br><br><br><br>
    <table>
		<tr>
			<th style="width: 20%">Date réglement</th>
			<th style="width: 15%">Montant</th>
			<th style="width: 35%">Mode de réglement</th>
			<th style="width: 30%">Projet</th>
		</tr>
		<?php
		foreach($reglements as $reglement){
		?>		
		<tr>
			<td><?= $reglement->dateReglement() ?></td>
			<td><?= number_format($reglement->montant(), 2, ',', ' ') ?></td>
			<td>
				<?= $reglement->modePaiement() ?>
				<?php if($reglement->numeroCheque()!=0 and $reglement->numeroCheque()!='NULL'){
				?>
				 - <a>N° : <?= $reglement->numeroCheque() ?></a>
				<?php
				} 
				?>
			</td>
			<td><?= $projetManager->getProjetById($reglement->idProjet())->nom() ?></td>
		</tr>	
		<?php
		}//end of loop
		?>
	</table>
	<br />
	<table>
		<tr>
			<th style="width: 60%"><strong>Total Livraisons</strong></th>
			<td style="width: 40%">
				<strong>
					<a>
						<?= number_format($totalLivraisons, 2, ',', ' ') ?> 
					</a>
					&nbsp;DH
				</strong>
			</td>
		</tr>
		<tr>
			<th style="width: 60%"><strong>Total Réglements</strong></th>
			<td style="width: 40%">
				<strong>
					<a>
						<?= number_format($total, 2, ',', ' ') ?>
					</a>
					&nbsp;DH
				</strong>
			</td>
		</tr>
		<tr>
			<th style="width: 60%"><strong>Solde</strong></th>
			<td style="width: 40%">
				<strong>
					<a>
               			<?= number_format($totalLivraisons-$total, 2, ',', ' ') ?>
					</a>
					&nbsp;DH
				</strong>
			</td>
		</tr>
	</table>
    <!--br><br-->
    <!--h2>Total des réglements = <?= number_format($total, 2, ',', ' ') ?></h2>
    <h2>Total des livraisons = <?= number_format($totalLivraisons, 2, ',', ' ') ?></h2>
    <h2>Total Livraisons - Total Réglements = <?= number_format($totalLivraisons-$total, 2, ',', ' ') ?></h2--> 
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
		$fileName = "ReglementFournisseur-".$nomFournisseur."-".date('Ymdhi').'.pdf';
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
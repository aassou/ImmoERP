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
		$clientManager = new ClientManager($pdo);
		$contratManager = new ContratManager($pdo);
		$operationManager = new OperationManager($pdo);
        $contratCasLibreManager = new ContratCasLibreManager($pdo);
        $reglementPrevuManager = new ReglementPrevuManager($pdo);
		if(isset($_GET['codeContrat']) and (bool)$contratManager->getCodeContrat($_GET['codeContrat']) ){
			$codeContrat = $_GET['codeContrat'];
			$contrat = $contratManager->getContratByCode($codeContrat);
			$projet = $projetManager->getProjetById($contrat->idProjet());
			$client = $clientManager->getClientById($contrat->idClient());
			$sommeOperations = $operationManager->sommeOperations($contrat->id());
			$biens = "";
            $typeBien = "";
			$niveau = "";
			if($contrat->typeBien()=="appartement"){
				$appartementManager = new AppartementManager($pdo);
				$biens = $appartementManager->getAppartementById($contrat->idBien());
                $typeBien = "Appartement";
				$niveau = $biens->niveau();
			}
			else if($contrat->typeBien()=="localCommercial"){
				$locauxManager = new LocauxManager($pdo);
				$biens = $locauxManager->getLocauxById($contrat->idBien());
                $typeBien = "Local Commercial";
			}
			$operations = "";
			//test the locaux object number: if exists get operations else do nothing
			$operationsNumber = $operationManager->getOpertaionsNumberByIdContrat($contrat->id());
			if($operationsNumber != 0){
				$operations = $operationManager->getOperationsByIdContrat($contrat->id());	
			}
            //ContratCasLibre Elements
            $contratCasLibreNumber = 
            $contratCasLibreManager->getContratCasLibreNumberByCodeContrat($codeContrat);
            $contratCasLibreElements = "";
            $contratCasLibreTitle = "";
            if ( $contratCasLibreNumber > 0 ) {
                $contratCasLibreTitle = "Informations Supplémentaires";
                $contratCasLibreElements = 
                $contratCasLibreManager->getContratCasLibresByCodeContrat($codeContrat);
            }
            //ReglementPrevu Elements
            $reglementPrevuNumber = 
            $reglementPrevuManager->getReglementNumberByCodeContrat($codeContrat);
            $reglementPrevuElements = "";
            $reglementPrevuTitle = "";
            if ( $reglementPrevuNumber > 0 ) {
                $reglementPrevuTitle = "Dates des réglements prévus";
                $reglementPrevuElements =     
                $reglementPrevuManager->getReglementPrevuByCodeContrat($codeContrat);
            }
		}
		
ob_start();
?>
<style type="text/css">
	p, h2, h4{
        text-align: center;
        font-family : Arial;
        font-weight: 100;
        margin-bottom: 0px;
    }
    h4{
        font-weight : bold;
    }
    h1{
        text-align: center;
        font-family : Arial;
        font-weight: bold;
        font-size : 18px;
        margin-bottom: 0px;
    }
    h2{
        font-size: 20px;
    }
	table {
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
<page backtop="10mm" backbottom="20mm" backleft="10mm" backright="10mm">
    <!--img src="../assets/img/logo_company.png" style="width: 110px" /-->
    <h1>Résumé du Contrat Client - Projet : <?= $projet->nom() ?></h1>
    <p>Imprimé le <?= date('d/m/Y') ?> | <?= date('h:i') ?> </p>
    <hr>
    <div>
        <table style="width: 100%">
            <tr>
                <td style="width:50%"><h4>Informations du client</h4></td>
                <!--td style="width:25%"></td-->
                <td style="width:50%"><h4>Informations du contrat</h4></td>
                <!--td style="width:25%"></td-->
            </tr>
        </table>
		<table style="width: 100%">
			<!--tr>
				<td style="width:25%"><h4>Informations du client</h4></td>
				<td style="width:25%"></td>
				<td style="width:25%"><h4>Informations du contrat</h4></td>
				<td style="width:25%"></td>
			</tr-->
			<tr>
				<td style="width:25%"><strong>Client</strong></td>
				<td style="width:25%"><strong><?= $client->nom() ?></strong></td>
				<td style="width:25%"><strong>Type</strong></td> 
				<td style="width:25%"><strong><?= $typeBien ?></strong></td>
			</tr>
			<tr>
				<td style="width:25%"><strong>CIN</strong></td>
				<td style="width:25%"><strong><?= $client->cin() ?></strong></td>
				<td style="width:25%"><strong>Nom du Bien</strong></td>
				<td style="width:25%"><strong><?= $biens->nom() ?></strong></td>
			</tr>
			<tr>
				<td style="width:25%"><strong>Téléphone 1</strong></td>
                <td style="width:25%"><strong><?= $client->telephone1() ?></strong></td>
				<td style="width:25%"><strong>Superficie</strong></td>
				<td style="width:25%"><strong><?= $biens->superficie() ?>&nbsp;m<sup>2</sup></strong></td>
			</tr>
			<tr>
				<td style="width:25%"><strong>Téléphone 2</strong></td>
                <td style="width:25%"><strong><?= $client->telephone2() ?></strong></td>
				<td style="width:25%"><strong>Etage</strong></td>
				<td style="width:25%"><strong><?= $niveau ?></strong></td>
			</tr>
			<tr>
				<td style="width:25%"><strong>Email</strong></td>
                <td style="width:25%"><strong><?= $client->email() ?></strong></td>
				<td style="width:25%"><strong>Prix de Vente</strong></td>
				<td style="width:25%"><strong><?= number_format($contrat->prixVente(), 2, ',', ' ') ?>&nbsp;DH</strong></td>
			</tr>
			<tr>
				<td style="width:25%"><strong>Adresse</strong></td>
                <td style="width:25%"><strong><?= $client->adresse() ?></strong></td>
				<?php
				if($contrat->avance()!=0 or $contrat->avance()!='NULL' ){
				?>
				<td style="width:25%"><strong>Avance</strong></td>
				<td style="width:25%"><strong><?= number_format($contrat->avance(), 2, ',', ' ') ?>&nbsp;DH</strong></td>
				<?php
				}
				?>
			</tr>
			<tr>
				<td style="width:25%"></td>
				<td style="width:25%"></td>
				<td style="width:25%"><strong>Réglements</strong></td>
				<td style="width:25%"><strong><?= number_format($sommeOperations, 2, ',', ' ') ?>&nbsp;DH</strong></td>
			</tr>
			<tr>
				<td style="width:25%"></td>
                <td style="width:25%"></td>
				<td style="width:25%"><strong>Echeance</strong></td>
				<td style="width:25%"><strong><?= number_format($contrat->echeance(), 2, ',', ' ') ?>&nbsp;DH</strong></td>
			</tr>
		</table>
	</div>
	<br>
	<!-- DATES REGLEMENTS PREVU BEGIN -->
    <?php 
    if ( $reglementPrevuNumber > 0 ) { 
    ?>
    <div>
        <h4><?= $reglementPrevuTitle; ?></h4>
        <br>
        <table>
            <tr>
                <th style="width: 33%">Date Prévu de réglement</th>
                <th style="width: 33%">Echéance</th>
                <th style="width: 33%">Status du réglement</th>
            </tr>
            <?php
            $totalEcheance = 0;
            foreach ( $reglementPrevuElements as $element ) {
                $status = "";    
                $totalEcheance += $contrat->echeance();
                if($element->status()==0){
                    //comparing dates
                    $now = date('Y-m-d');
                    $now = new DateTime($now);
                    $now = $now->format('Ymd');
                    $datePrevu = $element->datePrevu();
                    $datePrevu = new DateTime($datePrevu);
                    $datePrevu = $datePrevu->format('Ymd');
                    if ( $datePrevu > $now ) {
                        $status = '<strong style="color:green">Normal</strong>';   
                    }
                    else if ( $datePrevu < $now ) {
                        $status = '<strong style="color:red">En retards</strong>';
                    }
                }
                else if($element->status()==1){
                    $status = '<strong style="color:blue">Réglé</strong>';
                }
            ?>
            <tr>
                <td><?= date('d/m/Y', strtotime($element->datePrevu())) ?></td>
                <td><?= $contrat->echeance() ?></td>
                <td><?= $status ?></td>
            </tr>
            <?php
            }
            ?>
            <tr>
                <td></td>
                <th>Total des échéances</th>
                <td></td>
            </tr>
            <tr>
                <td></td>
                <td><?= number_format($totalEcheance, 2, ',', ' ') ?>&nbsp;DH</td>
                <td></td>
            </tr>
        </table>
    </div>    
    <?php 
    } 
    ?>
    <!-- DATES REGLEMENTS PREVU END -->
    <br>
    <!-- CONTRAT CAS LIBRE BEGIN -->
    <?php 
    if ( $contratCasLibreNumber > 0 ) { 
    ?>
    <div>
        <h4><?= $contratCasLibreTitle; ?></h4>
        <br>
        <table>
            <tr>
                <th style="width: 20%">Date</th>
                <th style="width: 20%">Montant</th>
                <th style="width: 50%">Obsérvation</th>
                <th style="width: 10%">Status</th>
            </tr>
            <?php
            $totalMontantsCasLibre = 0;
            foreach ( $contratCasLibreElements as $element ) {
                $status = "";    
                $totalMontantsCasLibre += $element->montant();
                if($element->status()==0){
                    //comparing dates
                    $now = date('Y-m-d');
                    $now = new DateTime($now);
                    $now = $now->format('Ymd');
                    $dateCasLibre = $element->date();
                    $dateCasLibre = new DateTime($dateCasLibre);
                    $dateCasLibre = $dateCasLibre->format('Ymd');
                    if ( $dateCasLibre > $now ) {
                        $status = '<strong style="color: green">Normal</strong>';   
                    }
                    else if ( $dateCasLibre < $now ) {
                        $status = '<strong style="color:red">En retard</strong>';
                    }
                }
                else if($element->status()==1){
                    $status = '<strong style="color:blue">Réglé</strong>';
                }
            ?>
            <tr>
                <td><?= date('d/m/Y', strtotime($element->date())) ?></td>
                <td><?= number_format($element->montant(), 2, ' ', ',') ?></td>
                <td><?= $element->observation() ?></td>
                <td><?= $status ?></td>
            </tr>
            <?php
            }
            ?>
            <tr>
                <td></td>
                <th><?= number_format($totalMontantsCasLibre, 2, ',', ' ') ?>&nbsp;DH</th>
                <td></td>
                <td></td>
                <td></td>
            </tr>
        </table>
    </div>    
    <?php 
    } 
    ?>
    <!-- CONTRAT CAS LIBRE END -->
    <!-- REGLEMENTS PAYES BEGIN -->
    <div>
        <h4>Détails des réglements payés</h4>
        <br>
		<table>
			<tr>
				<th style="width: 30%;">Date opération</th>
				<th style="width: 40%;">Montant</th>
				<th style="width: 30%;">Mode Paiement</th>
			</tr>
			<?php
			if($operationsNumber != 0){
			foreach($operations as $operation){
			?>		
			<tr>
				<td><?= date('d/m/Y', strtotime($operation->date())) ?></td>
				<td><?= number_format($operation->montant(), 2, ',', ' ') ?>&nbsp;DH</td>
				<td><?= $operation->modePaiement() ?></td>
			</tr>	
			<?php
			}//end of loop
			}//end of if
			?>
			<!--tr>
				<td style="border: 1px solid black"><a><?= date('d/m/Y', strtotime($contrat->dateCreation())) ?></a></td>											
				<?php
				if($contrat->avance()!=0 or $contrat->avance()!='NULL' ){
				?> 
					<td style="border: 1px solid black"><?= number_format($contrat->avance(), 2, ',', ' ')." DH";?></td>
				<?php
				}
				?>
				<td style="border: 1px solid black"><?= $contrat->modePaiement() ?></td>
			</tr-->
			<tr>
				<td>Somme Réglements</td>
				<td><?= number_format($operationManager->sommeOperations($contrat->id()), 2, ',', ' ')." DH";?></td>
				<td></td>
			</tr>
			<tr>
				<td>Reste</td>
				<td><?= number_format($contrat->prixVente()-$operationManager->sommeOperations($contrat->id()), 2, ',', ' ')." DH";?></td>
				<td></td>
			</tr>
		</table>
	</div>
	<!-- REGLEMENTS PAYES BEGIN -->
    <br><br> 
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
		$fileName = "FicheSituationClient-".date('Ymdhi').'.pdf';
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
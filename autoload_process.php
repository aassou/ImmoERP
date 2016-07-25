<?php
include("config.php"); //include config file
include("model/ClientManager.php");
include("model/Client.php");
if($_POST)
{
	//sanitize post value
	$group_number = filter_var($_POST["group_no"], FILTER_SANITIZE_NUMBER_INT, FILTER_FLAG_STRIP_HIGH);
	
	//throw HTTP error if group number is not valid
	if(!is_numeric($group_number)){
		header('HTTP/1.1 500 Invalid number!');
		exit();
	}
	
	//get current starting point of records
	$position = ($group_number * $items_per_group);
	
	//Limit our results within a specified range. 
	//$results = $pdo->query("SELECT * FROM t_client ORDER BY id ASC LIMIT $position, $items_per_group");
	$clientManager = new ClientManager($pdo);
	$clients = $clientManager->getClientsByLimits($position, $items_per_group);
?>
	<?php	
	if ($clients) { 
		//output results from database
	    foreach($clients as $client){
	?>
		<tr class="clients">
			<td>
				<div class="btn-group">
					<a style="width: 200px" class="btn mini dark-cyan dropdown-toggle" href="#" data-toggle="dropdown">
						<?= $client->nom()?> 
						<i class="icon-angle-down"></i>
					</a>
					<ul class="dropdown-menu">
						<li>
							<a href="#update<?= $client->id();?>" data-toggle="modal" data-id="<?= $client->id(); ?>">
								Modifier
							</a>
							<!--a href="#delete<?= $client->id();?>" data-toggle="modal" data-id="<?= $client->id(); ?>">
								Supprimer
							</a-->
						</li>
					</ul>
				</div>
			</td>
			<td class="hidden-phone"><?= $client->cin() ?></td>
			<td class="hidden-phone"><?= $client->nomArabe()?></td>
			<td class="hidden-phone"><?= $client->adresseArabe()?></td>
			<td class="hidden-phone"><?= $client->adresse()?></td>
			<td class="hidden-phone"><?= $client->telephone1() ?></td>
			<td class="hidden-phone"><?= $client->telephone2() ?></td>
			<td class="hidden-phone"><?= $client->email() ?></td>
		</tr>
		<!-- updateClient box begin-->
		<div id="update<?= $client->id() ?>" class="modal hide fade in" tabindex="-1" role="dialog" aria-labelledby="login" aria-hidden="false" >
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
				<h3>Modifier les informations du client </h3>
			</div>
			<div class="modal-body">
				<form class="form-horizontal" action="controller/ClientActionController.php" method="post">
					<p>Êtes-vous sûr de vouloir modifier les infos du client <strong><?= $client->nom() ?></strong> ?</p>
					<div class="control-group">
						<label class="control-label">Nom</label>
						<div class="controls">
							<input type="text" name="nom" value="<?= $client->nom() ?>" />
						</div>
					</div>
					<div class="control-group">
						<label class="control-label">CIN</label>
						<div class="controls">
							<input type="text" name="cin" value="<?= $client->cin() ?>" />
						</div>
					</div>
					<div class="control-group">
						<label class="control-label">الاسم</label>
						<div class="controls">
							<input type="text" name="nomArabe" value="<?= $client->nomArabe() ?>" />
						</div>
					</div>
					<div class="control-group">
						<label class="control-label">العنوان</label>
						<div class="controls">
							<input type="text" name="adresseArabe" value="<?= $client->adresseArabe() ?>" />
						</div>
					</div>
					<div class="control-group">
						<label class="control-label">Adresse</label>
						<div class="controls">
							<input type="text" name="adresse" value="<?= $client->adresse() ?>" />
						</div>
					</div>
					<div class="control-group">
						<label class="control-label">Tél.1</label>
						<div class="controls">
							<input type="text" name="telephone1" value="<?= $client->telephone1() ?>" />
						</div>
					</div>
					<div class="control-group">
						<label class="control-label">Tél.2</label>
						<div class="controls">
							<input type="text" name="telephone2" value="<?= $client->telephone2() ?>" />
						</div>
					</div>
					<div class="control-group">
						<label class="control-label">Email</label>
						<div class="controls">
							<input type="text" name="email" value="<?= $client->email() ?>" />
						</div>  
					</div>
					<div class="control-group">
						<input type="hidden" name="idClient" value="<?= $client->id() ?>" />
						<input type="hidden" name="action" value="update" />
						<input type="hidden" name="source" value="clients" />
						<div class="controls">  
							<button class="btn" data-dismiss="modal"aria-hidden="true">Non</button>
							<button type="submit" class="btn red" aria-hidden="true">Oui</button>
						</div>
					</div>
				</form>
			</div>
		</div>
		<!-- updateFournisseur box end -->
		<!-- delete box begin-->
		<div id="delete<?= $client->id();?>" class="modal hide fade in" tabindex="-1" role="dialog" aria-labelledby="login" aria-hidden="false" >
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
				<h3>Supprimer Client</h3>
			</div>
			<div class="modal-body">
				<form class="form-horizontal loginFrm" action="controller/ClientActionController.php" method="post">
					<p>Êtes-vous sûr de vouloir supprimer ce client <?= $client->nom() ?> ?</p>
					<div class="control-group">
						<label class="right-label"></label>
						<input type="hidden" name="idClient" value="<?= $client->id() ?>" />
						<input type="hidden" name="action" value="delete" />
						<input type="hidden" name="source" value="clients" />
						<button class="btn" data-dismiss="modal"aria-hidden="true">Non</button>
						<button type="submit" class="btn red" aria-hidden="true">Oui</button>
					</div>
				</form>
			</div>
		</div>
		<!-- delete box end -->       
	<?php 
		}
	}
}
?>
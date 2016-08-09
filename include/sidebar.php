<?php
    $currentPage = basename($_SERVER['PHP_SELF']);
?>
<div class="page-sidebar nav-collapse collapse">
			<!-- BEGIN SIDEBAR MENU -->        	
			<ul>
			    <li>
                    <!-- BEGIN RESPONSIVE QUICK SEARCH FORM -->
                    <form class="sidebar-search" action="controller/ClientActionController.php" method="post">
                        <div class="input-box">
                            <a href="javascript:;" class="remove"></a>
                            <input type="hidden" name="action" value="search">
                            <input type="hidden" name="source" value="clients-search">
                            <input type="text" name="clientName" placeholder="Chercher un client">             
                            <input type="button" class="submit" value="">
                        </div>
                    </form>
                    <!-- END RESPONSIVE QUICK SEARCH FORM -->
                </li>
				<li>
					<!-- BEGIN SIDEBAR TOGGLER BUTTON -->
					<div class="sidebar-toggler hidden-phone"></div>
					<!-- BEGIN SIDEBAR TOGGLER BUTTON -->
				</li>
				<li>
				</li>
				<!---------------------------- Dashboard Begin  -------------------------------------------->
				<li class="start <?php if($currentPage=="dashboard.php" 
				or $currentPage=="recherches.php"
				or $currentPage=="compte-bancaire.php"
				or $currentPage=="conges.php"
				or $currentPage=="company-choice.php"
				or $currentPage=="company-dashboard.php"
				or $currentPage=="statistiques.php"
				or $currentPage=="messages.php"
				or $currentPage=="user-profil.php"
				or $currentPage=="clients-search.php"
				or $currentPage=="fournisseurs-search.php"
				or $currentPage=="clients.php"
				or $currentPage=="clients-synthese.php"
				or $currentPage=="clients-modification.php"
				or $currentPage=="contrats-synthese.php"
				or $currentPage=="employes-projet-search.php"
				or $currentPage=="tasks.php"
				or $currentPage=="bugs.php"
				or $currentPage=="alert.php"
				or $currentPage=="todo.php"
				or $currentPage=="contrat-status.php"
				or $currentPage=="properties-status.php"
				or $currentPage=="operations-status.php"
				or $currentPage=="operations-status-group.php"
				or $currentPage=="status.php"
				or $currentPage=="contrats-desistes.php"
				or $currentPage=="suivi-company.php"
				or $currentPage=="charges-communs-type.php"
				or $currentPage=="charges-communs-grouped.php"
				or $currentPage=="releve-bancaire.php"
				){echo "active ";} ?>">
					<a href="company-choice.php">
					<i class="icon-home"></i> 
					<span class="title">Accueil</span>
					</a>
				</li>
				<!---------------------------- Dashboard End    -------------------------------------------->
				<!---------------------------- Gestion des projets Begin ----------------------------------->
				<?php 
				if ( 
				    $_SESSION["userImmoERPV2"]->profil() == "admin" ||
				    $_SESSION['userImmoERPV2']->profil() == "manager" ||
				    $_SESSION['userImmoERPV2']->profil() == "consultant" 
                    ) { 
					$gestionProjetClass="";
					if($currentPage=="projet-list.php"
					or $currentPage=="projets.php"
					or $currentPage=="projet-details.php"
					or $currentPage=="projet-charges.php"
					or $currentPage=="projet-add.php"
					or $currentPage=="suivi-projets.php"  
					or $currentPage=="projet-update.php"
					or $currentPage=="projet-search.php"
					or $currentPage=="terrain.php"
					or $currentPage=="locaux.php"
					or $currentPage=="pieces-locaux.php"
					or $currentPage=="appartements.php"
					or $currentPage=="pieces-appartement.php"
					or $currentPage=="clients-add.php"
					or $currentPage=="contrats-add.php"
					or $currentPage=="contrat.php"
					or $currentPage=="contrats-list.php"
					or $currentPage=="contrats-desistes-list.php"
					or $currentPage=="contrat-details.php"
					or $currentPage=="operations.php"
					or $currentPage=="fournisseur-add.php"
					or $currentPage=="fournisseur-reglement.php"
					or $currentPage=="employes-projet.php"
					or $currentPage=="employe-projet-profile.php"
					or $currentPage=="fournisseurs-reglements.php"
					or $currentPage=="appartement-detail.php"
					or $currentPage=="locaux-detail.php"
					or $currentPage=="projet-charges-grouped.php"
					or $currentPage=="projet-charges-type.php"
					or $currentPage=="projet-contrat-employe.php"
					or $currentPage=="contrat-employe-detail.php"
					){
						$gestionProjetClass = "active ";
					}
				?> 
				<li class="<?= $gestionProjetClass; ?>" >
					<a href="projets.php">
					<i class="icon-briefcase"></i> 
					<span class="title">Gestion des projets</span>
					<span class="arrow "></span>
					</a>
				</li>
				<?php
				}
				?> 
				<!---------------------------- Gestion des Projets End -------------------------------------->
				<!---------------------------- Livraisons Begin  -------------------------------------------->
				<?php 
                    $gestionLivraisonClass="";
                    if(
                    $currentPage=="livraisons-group.php"
                    or $currentPage=="livraisons-fournisseur.php"
                    or $currentPage=="livraisons-details.php"
                    or $currentPage=="livraisons-group-iaaza.php"
                    or $currentPage=="livraisons-fournisseur-iaaza.php"
                    or $currentPage=="livraisons-details-iaaza.php"
                    or $currentPage=="reglements-fournisseur.php"
                    or $currentPage=="reglements-fournisseur-iaaza.php"
                    or $currentPage=="livraisons-fournisseur-mois-list.php"
                    or $currentPage=="livraisons-fournisseur-mois.php"
                    or $currentPage=="livraisons-fournisseur-mois-iaaza.php"
                    or $currentPage=="livraisons-fournisseur-mois-list-iaaza.php"
                    ){
                        $gestionLivraisonClass = "active ";
                    } 
                ?> 
                <li class="<?= $gestionLivraisonClass; ?> has-sub ">
                    <a href="javascript:;">
                    <i class="icon-truck"></i> 
                    <span class="title">Gestion des livraisons</span>
                    <span class="arrow "></span>
                    </a>
                    <ul class="sub">
                        <?php
                        if ( 
                            $_SESSION["userImmoERPV2"]->profil() == "admin" ||
                            $_SESSION['userImmoERPV2']->profil() == "manager" ||
                            $_SESSION['userImmoERPV2']->profil() == "consultant" 
                            ) {
                        ?>
                        <li <?php if($currentPage=="livraisons-group.php"
                                    or $currentPage=="livraisons-fournisseur.php"
                                    or $currentPage=="livraisons-details.php"
                                    or $currentPage=="reglements-fournisseur.php"
                                    or $currentPage=="livraisons-fournisseur-mois.php"
                                    or $currentPage=="livraisons-fournisseur-mois-list.php"
                                    ){
                            ?> class="active" <?php } ?> >
                            <a href="livraisons-group.php">Société Annahda</a>
                        </li>
                        <?php
                        }
                        ?>
                        <?php
                        if ( 
                            $_SESSION["userImmoERPV2"]->profil() == "admin" ||
                            $_SESSION["userImmoERPV2"]->profil() == "user" ||
                            $_SESSION['userImmoERPV2']->profil() == "consultant" 
                            ) {
                        ?>
                        <li <?php if($currentPage=="livraisons-group-iaaza.php"
                                    or $currentPage=="livraisons-fournisseur-iaaza.php"
                                    or $currentPage=="livraisons-details-iaaza.php"
                                    or $currentPage=="reglements-fournisseur-iaaza.php"
                                    ){?> class="active" <?php } ?> >
                            <a href="livraisons-group-iaaza.php">Société Iaaza</a>
                        </li>
                        <?php
                        }
                        ?>
                    </ul>
                </li>
                <!---------------------------- Livraisons End    -------------------------------------------->
                <!---------------------------- Commandes Begin  -------------------------------------------->
                <?php 
                    $gestionCommandeClass="";
                    if(
                    $currentPage=="commande-group.php"
                    or $currentPage=="commande-details.php"
                    or $currentPage=="commande-mois-annee.php"
                    ){
                        $gestionCommandeClass = "active ";
                    } 
                ?> 
                <li class="<?= $gestionCommandeClass; ?> has-sub ">
                    <a>
                    <i class="icon-shopping-cart"></i> 
                    <span class="title">Gestion des commandes</span>
                    <span class="arrow "></span>
                    </a>
                </li>
                <!---------------------------- Commandes End    -------------------------------------------->
                <!---------------------------- Caisse Begin  -------------------------------------------->
                <?php 
                    $gestionCaisseClass="";
                    if(
                    $currentPage=="caisse.php" or 
                    $currentPage=="caisse-iaaza.php" or
                    $currentPage=="caisse-group.php" or
                    $currentPage=="caisse-mois-annee.php" or
                    $currentPage=="caisse-group-iaaza.php" or
                    $currentPage=="caisse-mois-annee-iaaza.php"
                    ){
                        $gestionCaisseClass = "active ";
                    } 
                ?> 
                <li class="<?= $gestionCaisseClass; ?> has-sub ">
                    <a href="javascript:;">
                    <i class="icon-money"></i> 
                    <span class="title">Gestion des caisses</span>
                    <span class="arrow "></span>
                    </a>
                    <ul class="sub">
                        <?php
                        if ( 
                            $_SESSION["userImmoERPV2"]->profil() == "admin" ||
                            $_SESSION['userImmoERPV2']->profil() == "manager" ||
                            $_SESSION['userImmoERPV2']->profil() == "consultant" 
                            ) {
                        ?>
                        <li <?php if($currentPage=="caisse-group.php"){
                            ?> class="active" <?php } ?> >
                            <a href="caisse-group.php">Caisse Société Annahda</a>
                        </li>
                        <?php
                        }
                        ?>
                        <?php
                        if ( 
                            $_SESSION["userImmoERPV2"]->profil() == "admin" ||
                            $_SESSION["userImmoERPV2"]->profil() == "user" ||
                            $_SESSION['userImmoERPV2']->profil() == "consultant" 
                            ) {
                        ?>
                        <li <?php if($currentPage=="caisse-group-iaaza.php"){?> class="active" <?php } ?> >
                            <a href="caisse-group-iaaza.php">Caisse Société Iaaza</a>
                        </li>
                        <?php
                        }
                        ?>
                    </ul>
                </li>
                <!---------------------------- Caisse End    -------------------------------------------->
				<!---------------------------- Parametrage Begin  -------------------------------------------->
				<?php
                if ( $_SESSION["userImmoERPV2"]->profil() == "admin" ) {
                ?>
                <li class="start <?php if($currentPage=="configuration.php" 
                or $currentPage=="history-group.php"
                or $currentPage=="history.php"
                or $currentPage=="clients-list.php"
                or $currentPage=="employes-contrats.php"
                or $currentPage=="users.php"
                or $currentPage=="type-charges.php"
                or $currentPage=="type-charges-communs.php"
                or $currentPage=="fournisseurs.php"
                or $currentPage=="companies.php"
                or $currentPage=="operations-status-archive-group.php"
                or $currentPage=="operations-status-archive.php"
                or $currentPage=="releve-bancaire-archive.php"
                ){echo "active ";} ?>">
                    <a href="configuration.php">
                    <i class="icon-wrench"></i> 
                    <span class="title">Paramètrages</span>
                    </a>
                </li>
                <?php
                }
                ?>
                <!---------------------------- Parametrage End    -------------------------------------------->
			</ul>
			<!-- END SIDEBAR MENU -->
		</div>
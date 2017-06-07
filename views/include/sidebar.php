<?php
    $currentPage = basename($_SERVER['PHP_SELF']);
?>
<div class="page-sidebar nav-collapse collapse">
			<!-- BEGIN SIDEBAR MENU -->        	
			<ul>
			    <li>
                    <!-- BEGIN RESPONSIVE QUICK SEARCH FORM -->
                    <form class="sidebar-search" action="../controller/ClientActionController.php" method="post">
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
				<!---------------------------- Parametrage Begin  -------------------------------------------->
				<?php
                if ( $_SESSION["userImmoERPV2"]->profil() == "admin" ) {
                ?>
                <li class="start <?php if($currentPage=="configuration-global.php" 
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
                    <a href="configuration-global.php">
                    <i class="icon-wrench"></i> 
                    <span class="title">Paramètrages Globales</span>
                    </a>
                </li>
                <?php
                }
                ?>
                <!---------------------------- Parametrage End    -------------------------------------------->
			</ul>
			<!-- END SIDEBAR MENU -->
		</div>
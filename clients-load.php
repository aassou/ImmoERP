<?php
//include("config.php");
//$clientManager = new ClientManager($pdo);
$results = $clientsManager->getClientsNumber();
//$results = $pdo->query("SELECT COUNT(*) as t_records FROM clients");
//$mysqli->query("SELECT COUNT(*) as t_records FROM annonce");
$total_records = $results;//fetch_object();
$total_groups = ceil($total_records/$items_per_group);
//$results->close(); 
?> 
<!--autoload jquery -->
<script type="text/javascript" src="assets/js/jquery-1.8.3.min.js"></script>

<script type="text/javascript">
$(document).ready(function() {
	var track_load = 0; //total loaded record group(s)
	var loading  = false; //to prevents multipal ajax loads
	var total_groups = <?php echo $total_groups; ?>; //total record group(s)
	
	//load first group
	$('#results').load("autoload_process.php", {'group_no':track_load}, function() {track_load++;}); 
	
	//detect page scroll
	$(window).scroll(function() { 
		
		//user scrolled to bottom of the page?
		if($(window).scrollTop() + $(window).height() == $(document).height())  
		{
			//there's more data to load
			if(track_load <= total_groups && loading==false) 
			{
				//prevent further ajax loading
				loading = true; 
				//show loading image
				$('.animation_image').show(); 
				
				//load data from the server using a HTTP POST request
				$.post('autoload_process.php',{'group_no': track_load}, function(data){
									
					//append received data into the element
					$("#results").append(data); 

					//hide loading image
					//hide loading image once data is received
					$('.animation_image').hide(); 
					
					//loaded group increment
					track_load++; 
					loading = false; 
				
				}).fail(function(xhr, ajaxOptions, thrownError) { //any errors?
					
					//alert with HTTP error
					alert(thrownError); 
					//hide loading image
					$('.animation_image').hide(); 
					loading = false;
				
				});
				
			}
		}
	});
});
</script>

<!--autoload jquery -->
<div class="portlet clients">
	<div class="portlet-body">
		<div class="scroller" data-height="500px" data-always-visible="1"><!-- BEGIN DIV SCROLLER -->
			<table class="table table-striped table-bordered table-advance table-hover" id="sample_editable_1">
				<thead>
					<tr>
						<th style="width:25%">Nom</th>
						<th style="width:10%">CIN</th>
						<th style="width:10%">الاسم</th>
						<th style="width:10%">العنوان</th>
						<th style="width:30%">Adresse</th>
						<th style="width:10%">Tél1</th>
						<th style="width:10%">Tél2</th>
						<th style="width:15%">Email</th>
					</tr>
				</thead>
				<tbody id="results">
					<div class="animation_image" style="display:none" align="center"><img src="assets/img/ajax-loader.gif"></div>
				</tbody>
			</table>
		</div><!-- END DIV SCROLLER -->
	</div>
</div>
<!-- latest products end -->
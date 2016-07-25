<html>	
	<head>
		<meta charset="utf-8">
	</head>
	<body>
		<?php
			$arrayVars = array();
			$arrayVars[0] = "4";
			$arrayVars[1] = "4";
			$arrayVars[2] = "4";
            $dateLivraison = new DateTime('2015-03-12');
            print_r($dateLivraison);
            echo date('m', strtotime('2015-03-12'));
		?>
		<div id="container" style="width:100%; height:400px;"></div>
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
		<script src="http://code.highcharts.com/highcharts.js"></script>
		<script src="http://code.highcharts.com/themes/dark-unica.js"></script>
		<script>
			var test1 = <?= $arrayVars[0] ?>;
			$(function () { 
				$('#container').highcharts({
					chart: {
						type: 'bar'
					},
					title: {
						text: 'Montants des contrats annuels'
					},
					xAxis: {
						categories: ['Contrat', 'Client', 'Opérations']
					},
					yAxis: {
						title: {
							text: 'Statistiques'
						}
					},
					series: [{
						name: 'MerlaTrav',
						data: [test1, 1, 1]
					}, {
						name: 'AquaTrav',
						data: [1, 1, 1]
					}]
				});
			});
		</script>
	</body>
</html>
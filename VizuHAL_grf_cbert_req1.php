<?php
function grf_cbert($year, $resHAL, $team, $orig) {
	//Tableau de couleurs
	$tabCol = array('rgba(78, 121, 167, 1)', 'rgba(160, 203, 232, 1)', 'rgba(242, 142, 43, 1)', 'rgba(255, 190, 125, 1)', 'rgba(89, 161, 79, 1)', 'rgba(140, 209, 125, 1)', 'rgba(182, 153, 45, 1)', 'rgba(241, 206, 99, 1)', 'rgba(73, 152, 148, 1)', 'rgba(134, 188, 182, 1)', 'rgba(225, 87, 89, 1)', 'rgba(225, 157, 154, 1)', 'rgba(121, 112, 110, 1)', 'rgba(186, 176, 172, 1)', 'rgba(211, 114, 149, 1)', 'rgba(250, 191, 210, 1)', 'rgba(176, 122, 161, 1)', 'rgba(212, 166, 200, 1)', 'rgba(157, 118, 196, 1)', 'rgba(215, 181, 166, 1)');
	
	$nbnoTI = $resHAL[$year][$team]["nfPronoTI"] - $resHAL[$year][$team]["nfPronoTIavOA"];
	$nbavTI = $resHAL[$year][$team]["nfProavTI"];
	$nbavOA = $resHAL[$year][$team]["nfPronoTIavOA"];
	
	echo '<div class="col-8 chartjs-chart">';
	echo '	<canvas id="productions '.$team.' '.$year.'" width="500" height="280" class="border border-gray p-1"></canvas>';
	echo '	<script>';
	echo '			new Chart(document.getElementById("productions '.$team.' '.$year.'"), {';
	echo '					type: "pie",';
	echo '					data: {';
	echo '						labels: ["Sans TI", "Avec TI", "Avec lien externe vers PDF en OA"],';
	echo '						datasets: [';

										echo '{';
										echo 'label: ["Sans TI", "Avec TI", "Avec lien externe vers PDF en OA"],';
										echo 'data: ['.$nbnoTI.', '.$nbavTI.', '.$nbavOA.'],';
										echo 'backgroundColor: '.json_encode($tabCol);
										echo '},';

	echo '						]';
	echo '					},';
	echo '					options: {';
	echo '						legend: { display: true },';
	echo '						title: {';
	echo '							display: true,';
	echo '							text: "Productions '.$team.' '.$year.'",';
	echo '							fontStyle: "bold",';
	echo '							fontSize: 18';
	echo '						},';
	echo '						tooltips: {';
	echo '							callbacks: {';
	echo '								label: function(tooltipItem, data) {';
	echo '									var allData = data.datasets[tooltipItem.datasetIndex].data;';
	echo '									var tooltipLabel = data.labels[tooltipItem.index];';
	echo '									var tooltipData = allData[tooltipItem.index];';
	echo '									var total = 0;';
	echo '									for (var i in allData) {';
	echo '										total += parseFloat(allData[i]);';
	echo '									}';
	echo '									var tooltipPercentage = Math.round((tooltipData / total) * 100);';
	echo '									return tooltipLabel + ": " + tooltipData + " (" + tooltipPercentage + "%)";';
	echo '								}';
	echo '							}';
	echo '						}';
	echo '					}';
	echo '			});';
	echo '	</script>';
	echo '</div>';
}
?>
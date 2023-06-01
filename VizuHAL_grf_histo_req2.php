<?php
/*
 * VizuHAL - Générez des stats HAL - Generate HAL stats
 *
 * Copyright (C) 2023 Olivier Troccaz (olivier.troccaz@cnrs.fr) and Laurent Jonchère (laurent.jonchere@univ-rennes.fr)
 * Released under the terms and conditions of the GNU General Public License (https://www.gnu.org/licenses/gpl-3.0.txt)
 *
 * Graphes histogrammes pour la requête 2 - Histogram graphs for query 2
 */
 
function grf_histo($anneedeb, $anneefin, $arrRes, $team, $orig) {
	//Tableau de couleurs
	$tabCol = array('rgba(78, 121, 167, 1)', 'rgba(160, 203, 232, 1)', 'rgba(242, 142, 43, 1)', 'rgba(255, 190, 125, 1)', 'rgba(89, 161, 79, 1)', 'rgba(140, 209, 125, 1)', 'rgba(182, 153, 45, 1)', 'rgba(241, 206, 99, 1)', 'rgba(73, 152, 148, 1)', 'rgba(134, 188, 182, 1)', 'rgba(225, 87, 89, 1)', 'rgba(225, 157, 154, 1)', 'rgba(121, 112, 110, 1)', 'rgba(186, 176, 172, 1)', 'rgba(211, 114, 149, 1)', 'rgba(250, 191, 210, 1)', 'rgba(176, 122, 161, 1)', 'rgba(212, 166, 200, 1)', 'rgba(157, 118, 196, 1)', 'rgba(215, 181, 166, 1)');
	
	//Création du tableau d'années de la période
	$rYearArr = array();
	for($year = $anneedeb; $year <= $anneefin; $year++) {
		$rYearArr[] = $year;
	}
	
	echo '<div class="col-8 chartjs-chart">';
	echo '		<canvas id="productions '.$team.'" width="700" height="280" class="border border-gray p-1"></canvas>';
	echo '			<script>';
	echo '				new Chart(document.getElementById("productions '.$team.'"), {';
	echo '						type: "bar",';
	echo '						data: {';
	echo '							labels: '.json_encode($rYearArr).',';
	echo '							datasets: [';

									$col = 0;
								
									echo '{';
									echo 'label: ["Sans TI"],';
									echo 'data: [';
									for($year = $anneedeb; $year <= $anneefin; $year++) {
										echo $arrRes[$year][$team]["nfPronoTI"] - $arrRes[$year][$team]["nfPronoTIavOA"].',';
									}
									echo '],';
									echo 'backgroundColor: "'.$tabCol[$col].'"';
									echo '},';
									$col++;
									
									echo '{';
									echo 'label: ["Avec TI"],';
									echo 'data: [';
									for($year = $anneedeb; $year <= $anneefin; $year++) {
										echo $arrRes[$year][$team]["nfProavTI"].',';
									}
									echo '],';
									echo 'backgroundColor: "'.$tabCol[$col].'"';
									echo '},';
									$col++;
									
									echo '{';
									echo 'label: ["Avec lien externe vers PDF en OA"],';
									echo 'data: [';
									for($year = $anneedeb; $year <= $anneefin; $year++) {
										echo $arrRes[$year][$team]["nfPronoTIavOA"].',';
									}
									echo '],';
									echo 'backgroundColor: "'.$tabCol[$col].'"';
									echo '},';

	echo '							]';
	echo '						},';
	echo '						options: {';
	echo '							legend: { display: true },';
	echo '							title: {';
	echo '								display: true,';
	echo '								text: "Productions HAL '.$team.'",';
	echo '								fontStyle: "bold",';
	echo '								fontSize: 18';
	echo '							},';
	echo '							scales: {';
	echo '								yAxes: [{';
	echo '									stacked: true,';
	echo '									ticks: {';
	echo '										min: 0';
	echo '									},';
	echo '									scaleLabel: {';
	echo '										display: true,';
	echo '										labelString: "Nombre",';
	echo '										fontStyle: "bold",';
	echo '										fontSize: 16';
	echo '									}';
	echo '								}],';
	echo '								xAxes: [{';
	echo '									stacked: true,';
	echo '									scaleLabel: {';
	echo '										display: true,';
	echo '										labelString: "Année",';
	echo '										fontStyle: "bold",';
	echo '										fontSize: 16';
	echo '									}';
	echo '								}]';
	echo '							}';
	echo '						}';
	echo '				});';
	echo '		</script>';
	echo '</div>';   
}
?>
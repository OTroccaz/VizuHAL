<?php
//Intitulé
echo '<span class="btn btn-secondary mt-2"><strong>2. Portail ou collection : évolution sur une période</strong></span><br><br>';

//Descriptif
echo '<div class="alert alert-secondary">Cette requête présente, sur une période donnée, le nombre de publications référencées dans le portail HAL institutionnel (secteurs disciplinaires, le cas échéant) ou une collection, avec ou sans texte intégral, avec ou sans lien vers un PDF librement disponible hors de HAL (via <a target="_blank" href="https://unpaywall.org/">Unpaywall</a>). Pour le portail, les résultats sont déclinés par secteurs (le cas échéant). <a href="#DT">Voir détails techniques en bas de page</a>.</div><br>';

//Export CSV
$Fnm = "./csv/req2.csv";
$inF = fopen($Fnm,"w+");
fseek($inF, 0);
$chaine = "\xEF\xBB\xBF";
fwrite($inF,$chaine);

echo '<table id="scroll-horizontal-datatable" class="table table-hover table-bordered nowrap w-100">';
echo '<thead class="thead-dark">';
echo '<tr>';
echo '<th scope="col">&nbsp;</th>';
$chaine = ";";
$ils = 0;
$sect = array();
$is = 0;

if (isset($port) && $port != "choix") {
	$sectI = $LAB_SECT[1]["secteur"];
	$sectF = $LAB_SECT[1]["secteur"];
	$codeSI = $LAB_SECT[1]["code_secteur"];
	$codeSF = $LAB_SECT[1]["code_secteur"];
}else{
	$sectI = $team;
	$sectF = $team;
	$codeSI = $team;
	$codeSF = $team;
}
//Recherche des différents secteurs
while (isset($LAB_SECT[$ils]["code_collection"])) {
	if ($ils == 0) {
		$sect[$is] = $LAB_SECT[$ils]["code_collection"];
		$is++;
		echo '<th scope="col" colspan="6" style="text-align:center">'.$LAB_SECT[$ils]["code_collection"].'</th>';
		$chaine .= $LAB_SECT[$ils]["code_collection"].";;;;;;";
	}else{
		$sectF = $LAB_SECT[$ils]["secteur"];
		if ($sectI != $sectF && isset($port) && $port != "choix") {//Total secteur à inclure
			echo '<th scope="col" colspan="6" style="text-align:center">'.$sectI.'</th>';
			$chaine .= $sectI.";;;;;;";
			$sect[$is] = $sectI;
			$sectI = $sectF;
			$codeSI = $codeSF;
			$is++;
		}
	}
	$ils++;
}
//Total dernier secteur à inclure
if (isset($port) && $port != "choix") {
	echo '<th scope="col" colspan="6" style="text-align:center">'.$sectF.'</th>';
	$chaine .= $sectF.";;;;;;";
	$sect[$is] = $sectF;
	$is++;
}
echo '</tr>';
$chaine .= chr(13).chr(10);
fwrite($inF,$chaine);

echo '<tr>';
echo '<th scope="col">Année</th>';
$chaine = "Année;";
for($ils=0; $ils<$is; $ils++) {
	echo '<th scope="col" style="text-align:center">Productions</th>';
	$chaine .= "Productions;";
	echo '<th scope="col" style="text-align:center">Productions<br>avec texte<br>intégral<br>déposé<br>dans HAL</th>';
	$chaine .= "Productions avec texte intégral déposé dans HAL;";
	echo '<th scope="col" style="text-align:center">Taux de<br>texte<br>intégral<br>déposé<br>dans<br>HAL</th>';
	$chaine .= "Taux de texte intégral déposé dans HAL;";
	echo '<th scope="col" style="text-align:center">Productions<br>sans texte<br>intégral<br>déposé<br>dans HAL</th>';
	$chaine .= "Productions sans texte intégral déposé dans HAL;";
	echo '<th scope="col" style="text-align:center">Productions<br>sans texte<br>intégral<br>déposé<br>dans HAL<br>mais avec<br>texte<br>intégral<br>librement<br>accessible<br>hors HAL</th>';
	$chaine .= "Productions sans texte intégral déposé dans HAL mais avec texte intégral déposé dans HAL librement accessible hors HAL;";
	echo '<th scope="col" style="text-align:center">Taux de<br>productions<br>sans texte<br>intégral<br>déposé<br>dans HAL<br>mais avec<br>texte<br>intégral<br>déposé<br>dans HAL<br>librement<br>accessible<br>hors HAL</th>';
	$chaine .= "Taux de productions sans texte intégral déposé dans HAL mais avec texte intégral déposé dans HAL librement accessible hors HAL;";
}   
echo '</tr>';
echo '</thead>';
$chaine .= chr(13).chr(10);
fwrite($inF,$chaine);

//Calculs
if (isset($port) && $port != "choix") {
	$sectI = $LAB_SECT[0]["secteur"];
	$sectF = $LAB_SECT[0]["secteur"];
	$codeSI = $LAB_SECT[0]["code_secteur"];
	$codeSF = $LAB_SECT[0]["code_secteur"];
}else{
	$sectI = $team;
	$sectF = $team;
}

for($year = $anneedeb; $year <= $anneefin; $year++) {
	$ils = 0;
	$is = 0;
	while (isset($LAB_SECT[$ils]["code_collection"])) {
		if ($ils == 0) {
			$team = $LAB_SECT[$ils]["code_collection"];
			extractHAL($team, $year, $reqt, $resHAL, $cstCA);
			$tabPro[$year][$sect[$is]][$cstNfD] = intval($resHAL[$year][$team][$cstNfD]);
			$tabPro[$year][$sect[$is]][$cstAvTI] = intval($resHAL[$year][$team][$cstAvTI]);
			$tabPro[$year][$sect[$is]]["taux"] = 0;
			if ($resHAL[$year][$team][$cstNfD] != 0) {
				$tabPro[$year][$sect[$is]]["taux"] = round($resHAL[$year][$team][$cstAvTI]*100/$resHAL[$year][$team][$cstNfD]);
			}
			$tabPro[$year][$sect[$is]][$cstNoTI] = intval($resHAL[$year][$team][$cstNoTI]);
			$tabPro[$year][$sect[$is]][$cstNoTIAvOA] = intval($resHAL[$year][$team][$cstNoTIAvOA]);
			$tabPro[$year][$sect[$is]]["tauxnoTIavOA"] = 0;
			if ($resHAL[$year][$team][$cstNoTI] != 0) {
				$tabPro[$year][$sect[$is]]["tauxnoTIavOA"] = round($resHAL[$year][$team][$cstNoTIAvOA]*100/$resHAL[$year][$team][$cstNoTI]);
			}
			$is++;
		}else{
			$sectF = $LAB_SECT[$ils]["secteur"];
			if ($sectI != $sectF && isset($port) && $port != "choix") {//Secteur suivant
				$team = $LAB_SECT[$ils]["code_secteur"];
				extractHAL(strtoupper($team), $year, $reqt, $resHAL, $cstCA);
				$tabPro[$year][$sect[$is]][$cstNfD] = intval($resHAL[$year][$team][$cstNfD]);
				$tabPro[$year][$sect[$is]][$cstAvTI] = intval($resHAL[$year][$team][$cstAvTI]);
				$tabPro[$year][$sect[$is]]["taux"] = 0;
				if ($resHAL[$year][$team][$cstNfD] != 0) {
					$tabPro[$year][$sect[$is]]["taux"] = round($resHAL[$year][$team][$cstAvTI]*100/$resHAL[$year][$team][$cstNfD]);
				}
				$tabPro[$year][$sect[$is]][$cstNoTI] = intval($resHAL[$year][$team][$cstNoTI]);
				$tabPro[$year][$sect[$is]][$cstNoTIAvOA] = intval($resHAL[$year][$team][$cstNoTIAvOA]);
				$tabPro[$year][$sect[$is]]["tauxnoTIavOA"] = 0;
				if ($resHAL[$year][$team][$cstNoTI] != 0) {
					$tabPro[$year][$sect[$is]]["tauxnoTIavOA"] = round($resHAL[$year][$team][$cstNoTIAvOA]*100/$resHAL[$year][$team][$cstNoTI]);
				}
				$sectI = $sectF;
				$codeSI = $codeSF;
				$is++;
			}
		}
		$ils++;
	}
}
//var_dump($resHAL);
//var_dump($tabPro);

//Affichage
echo '<tbody>';
for($year = $anneedeb; $year <= $anneefin; $year++) {
	echo '<tr class="table-light">';
	echo '<th scope="row">'.$year.'</th>';
	$chaine = $year.";";
	$is = 0;
	while (isset($sect[$is])) {
		echo '<th scope="row" style="text-align:center">'.$tabPro[$year][$sect[$is]][$cstNfD].'</th>';
		$chaine .= $tabPro[$year][$sect[$is]][$cstNfD].";";
		echo '<th scope="row" style="text-align:center">'.$tabPro[$year][$sect[$is]][$cstAvTI].'</th>';
		$chaine .= $tabPro[$year][$sect[$is]][$cstAvTI].";";
		echo '<th scope="row" style="text-align:center">'.$tabPro[$year][$sect[$is]]["taux"].'%</th>';
		$chaine .= $tabPro[$year][$sect[$is]]["taux"]."%;";
		echo '<th scope="row" style="text-align:center">'.$tabPro[$year][$sect[$is]][$cstNoTI].'</th>';
		$chaine .= $tabPro[$year][$sect[$is]][$cstNoTI].";";
		echo '<th scope="row" style="text-align:center">'.$tabPro[$year][$sect[$is]][$cstNoTIAvOA].'</th>';
		$chaine .= $tabPro[$year][$sect[$is]][$cstNoTIAvOA].";";
		echo '<th scope="row" style="text-align:center">'.$tabPro[$year][$sect[$is]]["tauxnoTIavOA"].'%</th>';
		$chaine .= $tabPro[$year][$sect[$is]]["tauxnoTIavOA"]."%;";
		$is++;
	}      
	echo '</tr>';
	$chaine .= chr(13).chr(10);
	fwrite($inF,$chaine);
}
echo '</tbody>';
echo '</table>';

echo '<a class="btn btn-secondary mt-2" href="./csv/req2.csv">Exporter le tableau au format CSV</a><br><br>';
?>
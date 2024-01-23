<?php
/*
 * VizuHAL - Générez des stats HAL - Generate HAL stats
 *
 * Copyright (C) 2024 Olivier Troccaz (olivier.troccaz@cnrs.fr) and Laurent Jonchère (laurent.jonchere@univ-rennes.fr)
 * Released under the terms and conditions of the GNU General Public License (https://www.gnu.org/licenses/gpl-3.0.txt)
 *
 * Requête 26 - Request 26
 */
 
//Intitulé
echo '<span class="btn btn-secondary mt-2"><strong>26. Croisement structures/collections</strong></span><br><br>';

//Descriptif
echo '<div class="alert alert-secondary">Cette requête ...</div><br>';

//Export CSV
$Fnm = "./csv/req26.csv";
$inF = fopen($Fnm,"w+");
fseek($inF, 0);
$chaine = "\xEF\xBB\xBF";
fwrite($inF,$chaine);

include('./VizuHAL_PortHAL-RENNES.php');
//include('./VizuHAL_PortHAL-TEST.php');
$tabTeam = explode(';', $team);
//var_dump($LAB_SECT);

echo '<table id="basic-datatable" class="table table-hover table-striped table-bordered table-responsive">';
echo '<thead class="thead-dark">';
echo '<tr>';
echo '<th scope="col">Unité</th>';
$chaine .= 'Unité;';
foreach($tabTeam as $team) {
	echo '<th scope="col">Structure '.$team.'</th>';
	$chaine .= 'Structure '.$team.';';
}
echo '<th scope="col">Total</th>';
$chaine .= 'Total';
echo '</tr>';
echo '</thead>';
$chaine .= chr(13).chr(10);
fwrite($inF,$chaine);
$chaine = '';
echo '<tbody>';

$ils = 0;
while (isset($LAB_SECT[$ils]["code_collection"])) {
	if ($ils != 0) {
		$tot = 0;
		echo '<tr>';
		echo '<th scope="row">'.$LAB_SECT[$ils]["code_collection"].'</th>';
		$chaine .= $LAB_SECT[$ils]["code_collection"].';';
		foreach($tabTeam as $team) {
			//echo $LAB_SECT[$ils]["code_collection"].'<br>';
			//echo 'https://api.archives-ouvertes.fr/search/univ-rennes/?fq=producedDateY_i:['.$anneedeb.'%20TO%20'.$anneefin.']&fq=collCode_s:'.$LAB_SECT[$ils]["code_collection"].'&fq=structId_i:'.$team.'&fq=-status_i=111<br>';
			$url = 'https://api.archives-ouvertes.fr/search/univ-rennes/?wt=xml&fq=producedDateY_i:['.$anneedeb.'%20TO%20'.$anneefin.']&fq=collCode_s:'.$LAB_SECT[$ils]["code_collection"].'&fq=structId_i:'.$team.'&fq=-status_i=111<br>';
			$qte = askCurlNF($url, $cstCA);
			echo '<th scope="row">'.$qte.'</th>';
			$chaine .= $qte.';';
			$tot += $qte;
		}
		echo '<th scope="row">'.$tot.'</th>';
		$chaine .= $tot.';';
		echo '</tr>';
		$chaine .= chr(13).chr(10);
		fwrite($inF,$chaine);
		$chaine = '';
	}
	$ils++;
}

echo '</tr>';
echo '</tbody>';
echo '</table>';

/*
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
	echo '<th scope="col" style="text-align:center">Taux de<br>texte<br>intégral<br>librement<br>accessible<br>hors HAL</th>';
	$chaine .= "Taux de texte intégral librement accessible hors HAL;";
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
				$tabPro[$year][$sect[$is]]["tauxnoTIavOA"] = round($resHAL[$year][$team][$cstNoTIAvOA]*100/$resHAL[$year][$team][$cstNfD]);
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
					$tabPro[$year][$sect[$is]]["tauxnoTIavOA"] = round($resHAL[$year][$team][$cstNoTIAvOA]*100/$resHAL[$year][$team][$cstNfD]);
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
*/

echo '<a class="btn btn-secondary mt-2" href="./csv/req26.csv">Exporter le tableau au format CSV</a><br><br>';
?>
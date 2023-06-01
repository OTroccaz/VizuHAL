<?php
/*
 * VizuHAL - Générez des stats HAL - Generate HAL stats
 *
 * Copyright (C) 2023 Olivier Troccaz (olivier.troccaz@cnrs.fr) and Laurent Jonchère (laurent.jonchere@univ-rennes.fr)
 * Released under the terms and conditions of the GNU General Public License (https://www.gnu.org/licenses/gpl-3.0.txt)
 *
 * Requête 8 - Request 8
 */
 
//Intitulé
echo '<span class="btn btn-secondary mt-2"><strong>8. Portail : Pourcentage par secteur ou pôle des articles de tel éditeur</strong></span><br><br>';

//Descriptif
echo '<div class="alert alert-secondary">Requête masquée : abandon car on dépasse les limites d’exécution du script.</div><br>';

//Export CSV
$Fnm = "./csv/req8.csv";
$inF = fopen($Fnm,"w+");
fseek($inF, 0);
$chaine = "\xEF\xBB\xBF";
fwrite($inF,$chaine);

$year = $annee8;

$chaine = "";
echo '<table class="table table-hover table-bordered">';
echo '<thead class="thead-dark">';
echo '<tr>';
echo '<th scope="col">Articles '.$year.' '.$LAB_SECT[0]['code_secteur'].' par regroupement éditorial</th>';
$chaine .= 'Articles '.$year.' '.$LAB_SECT[0]['code_secteur'].' par regroupement éditorial;';
$ils = 1;
$sect = array();
$is = 0;

if (isset($port) && $port != "choix") {
	$sectI = $LAB_SECT[1]["secteur"];
	$sectF = $LAB_SECT[1]["secteur"];
}

//Recherche des différents secteurs
while (isset($LAB_SECT[$ils]["secteur"])) {
$sectF = $LAB_SECT[$ils]["secteur"];
if ($sectI != $sectF && isset($port) && $port != "choix") {//Secteur à afficher
	echo '<th scope="col" colspan="2" style="text-align:center">'.$sectI.'</th>';
	$chaine .= $sectI.";;";
	$sect[$is] = $sectI;
	$sectI = $sectF;
	$is++;
}
$ils++;
}

//Dernier secteur à afficher
if (isset($port) && $port != "choix") {
	echo '<th scope="col" colspan="2" style="text-align:center">'.$sectF.'</th>';
	$chaine .= $sectF.";;";
	$sect[$is] = $sectF;
	$is++;
}

//Code portail à ajouter au tableau sect
$is++;
$sect[$is] = $LAB_SECT[0]["secteur"];    

//Code portail à afficher
if (isset($port) && $port != "choix") {
	echo '<th scope="col" colspan="2" style="text-align:center">'.$LAB_SECT[0]['code_secteur'].'</th>';
	$chaine .= $LAB_SECT[0]['code_secteur'].";;";
}

echo '</tr>';
$chaine .= chr(13).chr(10);
fwrite($inF,$chaine);

//var_dump($sect);

$resHAL = array();
$ils = 0;

//Parcourir les collections
while (isset($LAB_SECT[$ils]["code_secteur"])) {
	$team = $LAB_SECT[$ils]["code_collection"];

	$urlHAL = $cstAPI.$team."/?q=*%3A*&fq=producedDateY_i:".$year."&indent=true&facet=true&facet.pivot=journalPublisher_s,journalValid_s,producedDateY_i&fq=docType_s:ART&fq=-status_i=111&rows=0";
	//echo $urlHAL.'<br>';
	$url = str_replace(" ", "%20", $urlHAL);
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_HEADER, 0);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_USERAGENT, 'SCD (https://halur1.univ-rennes1.fr)');
	curl_setopt($ch, CURLOPT_USERAGENT, 'PROXY (http://siproxy.univ-rennes1.fr)');
	if (isset ($_SERVER[$cstHTS]) && $_SERVER[$cstHTS] == "on")	{
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, TRUE);
		curl_setopt($ch, CURLOPT_CAINFO, $cstCA);
	}else{
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	}
	$json = curl_exec($ch);
	curl_close($ch);

	if (!empty($json)) {
		$parsed_json = json_decode($json, true);
		$arrayCurl = objectToArray($parsed_json);
		$cTab = $arrayCurl['facet_counts']['facet_pivot']['journalPublisher_s,journalValid_s,producedDateY_i'];
		$i = 0;
		while (isset($cTab[$i])) {
			if ($cTab[$i]['pivot'][0]['value'] == "VALID") {
				//echo $LAB_SECT[$ils]["secteur"].'-'.$team.' - '.$cTab[$i]['value'].' - '.$cTab[$i]['pivot'][0]['count'].'<br>';
				if (isset($resHAL[$cTab[$i]['value']][$LAB_SECT[$ils]["secteur"]])) {
					$resHAL[$cTab[$i]['value']][$LAB_SECT[$ils]["secteur"]] += $cTab[$i]['pivot'][0]['count'];
				}else{
					$resHAL[$cTab[$i]['value']][$LAB_SECT[$ils]["secteur"]] = $cTab[$i]['pivot'][0]['count'];
				}
			}
			$i++;
		}
	}
	$ils++;
}

//Si total pour un éditeur pour le portail n'est pas défini, assigner 0 > nécessaire pour le tri du tableau
foreach ($resHAL as $key => $val) {
	if (!isset($resHAL[$key][$LAB_SECT[0]['secteur']])) {$resHAL[$key][$LAB_SECT[0]['secteur']] = 0;}
}

//Calcul des totaux par secteur tout éditeur confondu = "regroupement éditorial"
$totSect = array();
foreach ($resHAL as $key1 => $val1) {
	foreach ($sect as $key2 => $val2) {
		if (!isset($val1[$val2])) {
			(!isset($totSect[$val2])) ? $totSect[$val2] = 0 : $totSect[$val2] += 0;
		}else{
			(!isset($totSect[$val2])) ? $totSect[$val2] = $val1[$val2] : $totSect[$val2] += $val1[$val2];
		}
	}
}

//Calcul initial temporaire des "Hors regroupement éditorial"
$ils = 0;
while (isset($LAB_SECT[$ils]["secteur"])) {
$code_collection = strtoupper($LAB_SECT[$ils]["code_collection"]);
$urlHAL = $cstAPI.$code_collection."/?wt=xml&fq=producedDateY_i:".$year."&fq=submitType_s:(notice%20OR%20file)&fq=docType_s:ART&fq=-status_i=111";
$qteArt = askCurlNF($urlHAL, $cstCA);
if (isset($resHAL["Hors regroupement éditorial"][$LAB_SECT[$ils]["secteur"]])) {
	$resHAL["Hors regroupement éditorial"][$LAB_SECT[$ils]["secteur"]] += intval($qteArt);
}else{
	$resHAL["Hors regroupement éditorial"][$LAB_SECT[$ils]["secteur"]] = intval($qteArt);
}
$ils++;
}

//Calcul final des totaux et "Hors regroupement éditorial" par secteur
foreach ($sect as $key => $val) {
	$vartemp = $totSect[$val];
	$totSect[$val] = $resHAL["Hors regroupement éditorial"][$val];
	$resHAL["Hors regroupement éditorial"][$val] -= $vartemp;
}

//Tri du tableau selon les totaux obtenus
$totPort = array();
foreach ($resHAL as $key => $val) {
	$totPort[$key] = $val[$LAB_SECT[0]['secteur']];
}
$totPort = array_column($resHAL, $LAB_SECT[0]['secteur']);
array_multisort($totPort, SORT_DESC, $resHAL);

//Construction du tableau
//Totaux par secteur tout éditeur confondu
$chaine = "";
echo '<tr>';
echo '<th scope="col">TOTAL</th>';
$chaine .= "TOTAL;";
foreach ($totSect as $key => $val) {
	echo '<th scope="col">'.$val.'</th>';
	$pcent = 100;
	echo '<th scope="col">'.number_format($pcent, 1).'%</th>';
	$chaine .= $val.";".number_format($pcent, 1).";";
}
echo '</th>';
echo '</tr>';
$chaine .= chr(13).chr(10);
fwrite($inF,$chaine);

//Totaux par secteur et par éditeur
foreach ($resHAL as $key1 => $val1) {
	$chaine = "";
	echo '<tr>';
	echo '<td scope="row">'.$key1.'</td>';
	$chaine .= str_replace(";", "-", $key1).";";
	foreach ($sect as $key2 => $val2) {
		if (isset($val1[$val2]) && $val1[$LAB_SECT[0]['secteur']] != 0) {
			echo '<td scope="row">'.$val1[$val2].'</td>';
			$chaine .= $val1[$val2].";";
			$pcent = ($val1[$val2] * 100) / $totSect[$val2];
		}else{
			echo '<td scope="row">0</td>';
			$chaine .= "0;";
			$pcent = 0;
		}
		echo '<td scope="row">'.number_format($pcent, 1).'%</td>';
		$chaine .= number_format($pcent, 1)."%;";
	}
	echo '</tr>';
	$chaine .= chr(13).chr(10);
	fwrite($inF,$chaine);
}

echo '</table>';

echo '<a class="btn btn-secondary mt-2" href="./csv/'.$cstR08.'.csv">Exporter le tableau au format CSV</a><br><br>';
?>
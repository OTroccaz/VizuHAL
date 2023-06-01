<?php
/*
 * VizuHAL - Générez des stats HAL - Generate HAL stats
 *
 * Copyright (C) 2023 Olivier Troccaz (olivier.troccaz@cnrs.fr) and Laurent Jonchère (laurent.jonchere@univ-rennes.fr)
 * Released under the terms and conditions of the GNU General Public License (https://www.gnu.org/licenses/gpl-3.0.txt)
 *
 * Requête 1A - Request 1A
 */
 
//Intitulé
echo '<span class="btn btn-secondary mt-2"><strong>1A. Portail : production scientifique par secteur ou pôle et par unité (Articles de revue)</strong></span><br><br>';

//Descriptif
echo '<div class="alert alert-secondary">Cette requête présente, pour une année donnée, le nombre de publications (Articles de revue) référencées dans le portail HAL institutionnel, avec ou sans texte intégral, avec ou sans lien vers un PDF librement disponible hors de HAL (via <a target="_blank" href="https://unpaywall.org/">Unpaywall</a>). Les résultats sont déclinés par secteurs ou pôles (le cas échéant), et par unités ou structures de recherche. <a href="#DT">Voir détails techniques en bas de page</a>.</div><br>';

//Export CSV
$Fnm = "./csv/req24.csv";
$inF = fopen($Fnm,"w+");
fseek($inF, 0);
$chaine = "\xEF\xBB\xBF";
fwrite($inF,$chaine);

for($year = $anneedeb; $year <= $anneefin; $year++) {
	//Export CSV
	//Colonnes
	if ($year < 2020) {$chaine = "Unité;Secteur;Productions ".$year.";;";}else{$chaine = "Unité;Pôle;Productions ".$year.";;";}
	$chaine .= "Productions ".$year." sans texte intégral déposé dans HAL;";
	$chaine .= "Productions ".$year." avec texte intégral déposé dans HAL;";
	$chaine .= "Productions ".$year." sans texte intégral déposé dans HAL mais avec texte intégral déposé dans HAL librement accessible hors HAL;;";
	$chaine .= "Productions ".$year." avec texte intégral déposé dans HAL ou librement accessible hors HAL;;";
	$chaine .= chr(13).chr(10);
	fwrite($inF,$chaine);
	
	$ils = 0;
	$chaine = "";
	echo '<table id="basic-datatable" class="table table-hover table-bordered table-responsive">';
	echo '<thead class="thead-dark">';
	echo '<tr>';
	echo '<th scope="col">Unité</th>';
	if ($year < 2020) {echo '<th scope="col">Secteur</th>';}else{echo '<th scope="col">Pôle</th>';}
	echo '<th scope="col">Productions '.$year.'</th>';
	echo '<th scope="col"></th>';
	echo '<th scope="col">Productions '.$year.' sans texte intégral déposé dans HAL</th>';
	echo '<th scope="col"></th>';
	echo '<th scope="col">Productions '.$year.' avec texte intégral déposé dans HAL</th>';
	echo '<th scope="col"></th>';
	echo '<th scope="col">Productions '.$year.' sans texte intégral déposé dans HAL mais avec texte intégral déposé dans HAL librement accessible hors HAL</th>';
	echo '<th scope="col"></th>';
	echo '<th scope="col">Productions '.$year.' avec texte intégral déposé dans HAL ou librement accessible hors HAL</th>';
	echo '<th scope="col"></th>';
	echo '</tr>';
	echo '</thead><tbody>';
	
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
	$sect = array();
	$is = 1;

	while (isset($LAB_SECT[$ils]["code_collection"])) {
		$team = $LAB_SECT[$ils]["code_collection"];
		if ($ils != 0) {
			$sectF = $LAB_SECT[$ils]["secteur"];
			$codeSF = $LAB_SECT[$ils]["code_secteur"];
			if ($sectI != $sectF && isset($port) && $port != "choix") {//Total secteur à inclure
				extractHAL(strtoupper($codeSI), $year, $reqt, $resHAL, $cstCA);
				$chaine = "";
				echo '<tr class="table-info">';
				if ($year < 2020) {echo '<th scope="row"><em>Secteur '.$sectI.$cstETH;}else{echo '<th scope="row"><em>Pôle '.$sectI.$cstETH;}
				if ($year < 2020) {$chaine .= "Secteur ".$sectI.";";}else{$chaine .= "Pôle ".$sectI.";";}
				echo '<th scope="row"><em>'.$sectI.$cstETH;
				$chaine .= $sectI.";";
				
				$sect[$is] = $sectI;
				$is++;
				$tabPro[$year][$sectI][$cstNfD] = $resHAL[$year][$codeSI][$cstNfD];
				echo $cstTEM.$resHAL[$year][$codeSI][$cstNfD].$cstETH;
				$chaine .= $resHAL[$year][$codeSI][$cstNfD].";";
				$pcent = 0;
				if ($resHAL[$year][$codeSI][$cstNfD] != 0) {$pcent = round($resHAL[$year][$codeSI][$cstNfD]*100/$resHAL[$year][$codeSI][$cstNfD]);}
				echo $cstTEM.$pcent.$cstPTH;
				$chaine .= $pcent."%;";
				
				$tabPro[$year][$sectI][$cstNoTI] = $resHAL[$year][$codeSI][$cstNoTI];
				echo $cstTEM.$resHAL[$year][$codeSI][$cstNoTI].$cstETH;
				$chaine .= $resHAL[$year][$codeSI][$cstNoTI].";";
				$pcent = 0;
				if ($resHAL[$year][$codeSI][$cstNoTI]) {$pcent = round($resHAL[$year][$codeSI][$cstNoTI]*100/$resHAL[$year][$codeSI][$cstNfD]);}
				echo $cstTEM.$pcent.$cstPTH;
				$chaine .= $pcent."%;";
				
				$tabPro[$year][$sectI][$cstAvTI] = $resHAL[$year][$codeSI][$cstAvTI];
				echo $cstTEM.$resHAL[$year][$codeSI][$cstAvTI].$cstETH;
				$chaine .= $resHAL[$year][$codeSI][$cstAvTI].";";
				$pcent = 0;
				if ($resHAL[$year][$codeSI][$cstAvTI] != 0) {$pcent = round($resHAL[$year][$codeSI][$cstAvTI]*100/$resHAL[$year][$codeSI][$cstNfD]);}
				echo $cstTEM.$pcent.$cstPTH;
				$chaine .= $pcent."%;";
				
				$tabPro[$year][$sectI][$cstNoTIAvOA] = $resHAL[$year][$codeSI][$cstNoTIAvOA];
				echo $cstTEM.$resHAL[$year][$codeSI][$cstNoTIAvOA].$cstETH;
				$chaine .= $resHAL[$year][$codeSI][$cstNoTIAvOA].";";
				$pcent = 0;
				if ($resHAL[$year][$codeSI][$cstNoTIAvOA] != 0) {$pcent = round($resHAL[$year][$codeSI][$cstNoTIAvOA]*100/$resHAL[$year][$codeSI][$cstNfD]);}
				echo $cstTEM.$pcent.$cstPTH;
				$chaine .= $pcent."%;";
				
				$tabPro[$year][$sectI][$cstAvTIAvOA] = $resHAL[$year][$codeSI][$cstAvTIAvOA];
				echo $cstTEM.$resHAL[$year][$codeSI][$cstAvTIAvOA].$cstETH;
				$chaine .= $resHAL[$year][$codeSI][$cstAvTIAvOA].";";
				$pcent = 0;
				if ($resHAL[$year][$codeSI][$cstAvTIAvOA] != 0) {$pcent = round($resHAL[$year][$codeSI][$cstAvTIAvOA]*100/$resHAL[$year][$codeSI][$cstNfD]);}
				echo $cstTEM.$pcent.$cstPTH;
				$chaine .= $pcent."%;";
				
				echo '</tr>';
				$chaine .= chr(13).chr(10);
				fwrite($inF,$chaine);
				
				$sectI = $sectF;
				$codeSI = $codeSF;
			}
		}
		$chaine = "";
		extractHAL($team, $year, $reqt, $resHAL, $cstCA);
		if ($ils == 0) {
			echo '<tr class="table-warning">';
			if (isset($port) && $port != "choix") {
				$sect[0] = $LAB_SECT[$ils]["secteur"];
				$tabPro[$year][$sect[0]][$cstNfD] = intval($resHAL[$year][$team][$cstNfD]);
				$tabPro[$year][$sect[0]][$cstNoTI] = intval($resHAL[$year][$team][$cstNoTI]);
				$tabPro[$year][$sect[0]][$cstAvTI] = intval($resHAL[$year][$team][$cstAvTI]);
				$tabPro[$year][$sect[0]][$cstNoTIAvOA] = intval($resHAL[$year][$team][$cstNoTIAvOA]);
				$tabPro[$year][$sect[0]][$cstAvTIAvOA] = intval($resHAL[$year][$team][$cstAvTIAvOA]);
				echo '<th scope="row">Tout '.$LAB_SECT[$ils]["code_collection"].'</th>';
				$chaine .= "Tout ".$LAB_SECT[$ils]["code_collection"].";";
			}else{
				echo '<th scope="row">'.$LAB_SECT[$ils]["code_collection"].'</th>';
				$chaine .= $LAB_SECT[$ils]["code_collection"].";";
			}
		}else{
			echo '<tr class="table-light">';
			echo '<th scope="row">'.$LAB_SECT[$ils]["unite"].'</th>';
			$chaine .= $LAB_SECT[$ils]["unite"].";";
		}
		if ($ils == 0) {
			if (isset($port) && $port != "choix") {
				echo '<th scope="row">A_Tous</th>';
				$chaine .= "A_Tous;";
			}else{
				echo '<th scope="row"></th>';
				$chaine .= ";";
			}
		}else{
			echo '<th scope="row">'.$LAB_SECT[$ils]["secteur"].'</th>';
			$chaine .= $LAB_SECT[$ils]["secteur"].";";
		}
		
		echo '<th scope="row" style="text-align:center">'.$resHAL[$year][$team][$cstNfD].'</th>';
		if ($ils != 0) {$totDep = $resHAL[$year][$team][$cstNfD];}
		$chaine .= $resHAL[$year][$team][$cstNfD].";";
		$pcent = 0;
		if ($resHAL[$year][$team][$cstNfD] != 0) {$pcent = round($resHAL[$year][$team][$cstNfD]*100/$resHAL[$year][$team][$cstNfD]);}
		echo '<th scope="row" style="text-align:center">'.$pcent.'%</th>';
		$chaine .= $pcent."%;";
		
		echo '<th scope="row" style="text-align:center">'.$resHAL[$year][$team][$cstNoTI].'</th>';
		if ($ils != 0) {$totPronoTI = $resHAL[$year][$team][$cstNoTI];}
		$chaine .= $resHAL[$year][$team][$cstNoTI].";";
		$pcent = 0;
		if ($resHAL[$year][$team][$cstNoTI] != 0) {$pcent = round($resHAL[$year][$team][$cstNoTI]*100/$resHAL[$year][$team][$cstNfD]);}
		echo '<th scope="row" style="text-align:center">'.$pcent.'%</th>';
		$chaine .= $pcent."%;";
		
		echo '<th scope="row" style="text-align:center">'.$resHAL[$year][$team][$cstAvTI].'</th>';
		if ($ils != 0) {$totProavTI = $resHAL[$year][$team][$cstAvTI];}
		$chaine .= $resHAL[$year][$team][$cstAvTI].";";
		$pcent = 0;
		if ($resHAL[$year][$team][$cstAvTI] != 0) {$pcent = round($resHAL[$year][$team][$cstAvTI]*100/$resHAL[$year][$team][$cstNfD]);}
		echo '<th scope="row" style="text-align:center">'.$pcent.'%</th>';
		$chaine .= $pcent."%;";
		
		echo '<th scope="row" style="text-align:center">'.$resHAL[$year][$team][$cstNoTIAvOA].'</th>';
		if ($ils != 0) {$totPronoTIavOA = $resHAL[$year][$team][$cstNoTIAvOA];}
		$chaine .= $resHAL[$year][$team][$cstNoTIAvOA].";";
		$pcent = 0;
		if ($resHAL[$year][$team][$cstNoTIAvOA] != 0) {$pcent = round($resHAL[$year][$team][$cstNoTIAvOA]*100/$resHAL[$year][$team][$cstNfD]);}
		echo '<th scope="row" style="text-align:center">'.$pcent.'%</th>';
		$chaine .= $pcent."%;";
		
		echo '<th scope="row" style="text-align:center">'.$resHAL[$year][$team][$cstAvTIAvOA].'</th>';
		if ($ils != 0) {$totProavTIavOA = $resHAL[$year][$team][$cstAvTIAvOA];}
		$chaine .= $resHAL[$year][$team][$cstAvTIAvOA].";";
		$pcent = 0;
		if ($resHAL[$year][$team][$cstAvTIAvOA] != 0) {$pcent = round($resHAL[$year][$team][$cstAvTIAvOA]*100/$resHAL[$year][$team][$cstNfD]);}
		echo '<th scope="row" style="text-align:center">'.$pcent.'%</th>';
		$chaine .= $pcent."%;";
		
		echo '</tr>';
		$chaine .= chr(13).chr(10);
		fwrite($inF,$chaine);
		$atester = $LAB_SECT[$ils]["code_collection"];
		$ils++;
	}
	//Total dernier secteur à inclure
	if (isset($port) && $port != "choix") {
		$chaine = "";
		extractHAL(strtoupper($codeSF), $year, $reqt, $resHAL, $cstCA);
		echo '<tr class="table-info">';
		if ($year < 2020) {echo '<th scope="row"><em>Secteur '.$sectF.$cstETH;}else{echo '<th scope="row"><em>Pôle '.$sectF.$cstETH;}
		if ($year < 2020) {$chaine .= "Secteur ".$sectF.";";}else{$chaine .= "Pôle ".$sectF.";";}
		echo '<th scope="row"><em>'.$sectF.$cstETH;
		$chaine .= $sectF.";";
		
		$sect[$is] = $sectF;
		$is++;
		$tabPro[$year][$sectF][$cstNfD] = $resHAL[$year][$codeSF][$cstNfD];
		$chaine .= $resHAL[$year][$codeSF][$cstNfD].";";
		echo $cstTEM.$resHAL[$year][$codeSF][$cstNfD].$cstETH;
		$pcent = 0;
		if ($resHAL[$year][$codeSF][$cstNfD] != 0) {$pcent = round($resHAL[$year][$codeSF][$cstNfD]*100/$resHAL[$year][$codeSF][$cstNfD]);}
		echo $cstTEM.$pcent.$cstPTH;
		$chaine .= $pcent."%;";
		
		$tabPro[$year][$sectF][$cstNoTI] = $resHAL[$year][$codeSF][$cstNoTI];
		echo $cstTEM.$resHAL[$year][$codeSF][$cstNoTI].$cstETH;
		$chaine .= $resHAL[$year][$codeSF][$cstNoTI].";";
		$pcent = 0;
		if ($resHAL[$year][$codeSF][$cstNoTI]) {$pcent = round($resHAL[$year][$codeSF][$cstNoTI]*100/$resHAL[$year][$codeSF][$cstNfD]);}
		echo $cstTEM.$pcent.$cstPTH;
		$chaine .= $pcent."%;";
		
		$tabPro[$year][$sectF][$cstAvTI] = $resHAL[$year][$codeSF][$cstAvTI];
		echo $cstTEM.$resHAL[$year][$codeSF][$cstAvTI].$cstETH;
		$chaine .= $resHAL[$year][$codeSF][$cstAvTI].";";
		$pcent = 0;
		if ($resHAL[$year][$codeSF][$cstAvTI] != 0) {$pcent = round($resHAL[$year][$codeSF][$cstAvTI]*100/$resHAL[$year][$codeSF][$cstNfD]);}
		echo $cstTEM.$pcent.$cstPTH;
		$chaine .= $pcent."%;";
		
		$tabPro[$year][$sectF][$cstNoTIAvOA] = $resHAL[$year][$codeSF][$cstNoTIAvOA];
		echo $cstTEM.$resHAL[$year][$codeSF][$cstNoTIAvOA].$cstETH;
		$chaine .= $resHAL[$year][$codeSF][$cstNoTIAvOA].";";
		$pcent = 0;
		if ($resHAL[$year][$codeSF][$cstNoTIAvOA] != 0) {$pcent = round($resHAL[$year][$codeSF][$cstNoTIAvOA]*100/$resHAL[$year][$codeSF][$cstNfD]);}
		echo $cstTEM.$pcent.$cstPTH;
		$chaine .= $pcent."%;";
		
		$tabPro[$year][$sectF][$cstAvTIAvOA] = $resHAL[$year][$codeSF][$cstAvTIAvOA];
		echo $cstTEM.$resHAL[$year][$codeSF][$cstAvTIAvOA].$cstETH;
		$chaine .= $resHAL[$year][$codeSF][$cstAvTIAvOA].";";
		$pcent = 0;
		if ($resHAL[$year][$codeSF][$cstAvTIAvOA] != 0) {$pcent = round($resHAL[$year][$codeSF][$cstAvTIAvOA]*100/$resHAL[$year][$codeSF][$cstNfD]);}
		echo $cstTEM.$pcent.$cstPTH;
		$chaine .= $pcent."%;";
		
		echo '</tr>';
		echo '</tbody>';
		$chaine .= chr(13).chr(10);
		fwrite($inF,$chaine);
	}
	echo '</table>';
	
	echo '<a class="btn btn-secondary mt-2" href="./csv/req24.csv">Exporter le tableau au format CSV</a><br><br>';
}
?>
<?php
//Intitulé
echo '<span class="btn btn-secondary mt-2"><strong>3. Portail : Comparaison portails</strong></span><br><br>';

//Descriptif
echo '<div class="alert alert-secondary">Cette requête permet de situer les données d’un portail institutionnel par rapport aux données d’autres portails (d’universités). Il indique, pour une année donnée, le nombre de publications (articles de revue) référencées dans le portail, avec ou sans texte intégral, incluant ou non un lien vers un PDF librement disponible hors de HAL (via <a target="_blank" href="https://unpaywall.org/">Unpaywall</a>). <a href="#DT">Voir détails techniques en bas de page</a>.</div><br>';

/*
//Tri par défaut
$prtTri = "SORT_ASC";
$artTri = "";
$AnoTiTri = "";
$PnoTiTri = "";
$AavTiTri = "";
$PavTiTri = "";
$AavTiavOaTri = "";
$PavTiavOaTri = "";
$AnoTiavOaTri = "";
$PnoTiavOaTri = "";

$prtUrl = "prtAsc";
$artUrl = "artAsc";
$AnoTiUrl = "AnoTi1Asc";
$PnoTiUrl = "PnoTi1Asc";
$AavTiUrl = "AavTi1Asc";
$PavTiUrl = "PavTi1Asc";
$AavTiavOaUrl = "AavTi2avOaAsc";
$PavTiavOaUrl = "PavTi2avOaAsc";
$AnoTiavOaUrl = "AnoTi2avOaAsc";
$PnoTiavOaUrl = "PnoTi2avOaAsc";

//Recherche des éventuelles demandes de tri
$ordr = (isset($_GET["ordr"])) ? $_GET["ordr"] : "";//Tri demandé
if ($ordr != "") {
	$prtTri = "";
	$artTri = "";
	$AnoTiTri = "";
	$PnoTiTri = "";
	$AavTiTri = "";
	$PavTiTri = "";
	$AavTiavOaTri = "";
	$PavTiavOaTri = "";
	$AnoTiavOaTri = "";
	$PnoTiavOaTri = "";
	
	if (strpos($ordr, "prt") !== false) {//Sur le nom du portail
		if ($ordr == "prtAsc") {$prtTri = "SORT_ASC"; $prtUrl = "prtDes";}else{$prtTri = "SORT_DESC";	$prtUrl = "prtAsc";}
	}
	if (strpos($ordr, "art") !== false) {//Sur le nombre total d'articles du portail
		if ($ordr == "artAsc") {$artTri = "SORT_ASC"; $artUrl = "artDes";}else{$artTri = "SORT_DESC";	$artUrl = "artAsc";}
	}
	if (strpos($ordr, "AnoTi1") !== false) {//Sur le nombre d'articles sans texte intégral
		if ($ordr == "AnoTi1Asc") {$AnoTiTri = "SORT_ASC"; $AnoTiUrl = "AnoTi1Des";}else{$AnoTiTri = "SORT_DESC";	$AnoTiUrl = "AnoTi1Asc";}
	}
	if (strpos($ordr, "PnoTi1") !== false) {//Sur le pourcentage d'articles sans texte intégral
		if ($ordr == "PnoTi1Asc") {$PnoTiTri = "SORT_ASC"; $PnoTiUrl = "PnoTi1Des";}else{$PnoTiTri = "SORT_DESC";	$PnoTiUrl = "PnoTi1Asc";}
	}
	if (strpos($ordr, "AavTi1") !== false) {//Sur le nombre d'articles avec texte intégral
		if ($ordr == "AavTi1Asc") {$AavTiTri = "SORT_ASC"; $AavTiUrl = "AavTi1Des";}else{$AavTiTri = "SORT_DESC";	$AavTiUrl = "AavTi1Asc";}
	}
	if (strpos($ordr, "PavTi1") !== false) {//Sur le pourcentage d'articles avec texte intégral
		if ($ordr == "PavTi1Asc") {$PavTiTri = "SORT_ASC"; $PavTiUrl = "PavTi1Des";}else{$PavTiTri = "SORT_DESC";	$PavTiUrl = "PavTi1Asc";}
	}
	if (strpos($ordr, "AnoTi2avOa") !== false) {//Sur le nombre d'articles sans texte intégral mais avec open access
		if ($ordr == "AnoTi2avOaAsc") {$AnoTiavOaTri = "SORT_ASC"; $AnoTiavOaUrl = "AnoTi2avOaDes";}else{$AnoTiavOaTri = "SORT_DESC";	$AnoTiavOaUrl = "AnoTi2avOaAsc";}
	}
	if (strpos($ordr, "PnoTi2avOa") !== false) {//Sur le pourcentage d'articles sans texte intégral mais avec open access
		if ($ordr == "PnoTi2avOaAsc") {$PnoTiavOaTri = "SORT_ASC"; $PnoTiavOaUrl = "PnoTi2avOaDes";}else{$PnoTiavOaTri = "SORT_DESC";	$PnoTiavOaUrl = "PnoTi2avOaAsc";}
	}
	if (strpos($ordr, "AavTi2avOa") !== false) {//Sur le nombre d'articles avec texte intégral et open access
		if ($ordr == "AavTi2avOaAsc") {$AavTiavOaTri = "SORT_ASC"; $AavTiavOaUrl = "AavTi2avOaDes";}else{$AavTiavOaTri = "SORT_DESC";	$AavTiavOaUrl = "AavTi2avOaAsc";}
	}
	if (strpos($ordr, "PavTi2avOa") !== false) {//Sur le pourcentage d'articles avec texte intégral et open access
		if ($ordr == "PavTi2avOaAsc") {$PavTiavOaTri = "SORT_ASC"; $PavTiavOaUrl = "PavTi2avOaDes";}else{$PavTiavOaTri = "SORT_DESC";	$PavTiavOaUrl = "PavTi2avOaAsc";}
	}
}
*/	

//Export CSV
$Fnm = "./csv/req3.csv";
$inF = fopen($Fnm,"w+");
fseek($inF, 0);
$chaine = "\xEF\xBB\xBF";
fwrite($inF,$chaine);

$sect = array();
$is = 0;

//Portail demandé
$team = $LAB_SECT[0]["code_collection"];
	
//Résultats
if (!isset($_SESSION['datPro'])) {
	$year = $annee3;
	$sect[$is] = $team;
	extractHAL(strtolower($team), $year, $reqt, $resHAL, $cstCA);
	$tabPro[$team][$cstNfD] = intval($resHAL[$year][$team][$cstNfD]);
	$tabPro[$team][$cstNoTI] = intval($resHAL[$year][$team][$cstNoTI]);
	$tabPro[$team]["pCentnoTI"] = 0;
	$tabPro[$team][$cstAvTI] = intval($resHAL[$year][$team][$cstAvTI]);
	$tabPro[$team]["pCentavTI"] = 0;
	$tabPro[$team][$cstAvTIAvOA] = intval($resHAL[$year][$team][$cstAvTIAvOA]);
	$tabPro[$team]["pCentavTIavOA"] = 0;
	$tabPro[$team][$cstNoTIAvOA] = intval($resHAL[$year][$team][$cstNoTIAvOA]);
	$tabPro[$team]["pCentnoTIavOA"] = 0;
	if ($tabPro[$team][$cstNfD] != 0) {
		$tabPro[$team]["pCentnoTI"] = round($tabPro[$team][$cstNoTI]*100/$tabPro[$team][$cstNfD]);
		$tabPro[$team]["pCentavTI"] = round($tabPro[$team][$cstAvTI]*100/$tabPro[$team][$cstNfD]);
		$tabPro[$team]["pCentavTIavOA"] = round($tabPro[$team][$cstAvTIAvOA]*100/$tabPro[$team][$cstNfD]);
		$tabPro[$team]["pCentnoTIavOA"] = round($tabPro[$team][$cstNoTIAvOA]*100/$tabPro[$team][$cstNfD]);
	}
	$is++;
	
	//Autres portails
	include("./VizuHAL_Portails-HAL.php");
	$urlHAL = "https://api.archives-ouvertes.fr/ref/instance/";
	askCurl($urlHAL, $arrayHAL, $cstCA);
	//var_dump($arrayHAL);
	$iHAL = 0;
	while (isset($arrayHAL["response"]["docs"][$iHAL]["code"])) {
	//while ($iHAL < 30) {
		$code = $arrayHAL["response"]["docs"][$iHAL]["code"];
		$name = $arrayHAL["response"]["docs"][$iHAL]["name"];
		if (strtoupper($code) != $team && stripos($name, "université") !== false && strtoupper($code) != "UDL" && strtoupper($code) != "USJ" && strtoupper($code) != "UNIV-LILLE3" && strtoupper($code) != "DESCARTES" && strtoupper($code) != "UNIV-DIDEROT" && strtoupper($code) != "UNIV-NANTES") {//portail univ à intégrer + ignorer UDL, USJ, UNIV-LILLE3, DESCARTES, UNIV-DIDEROT et UNIV-NANTES
			$code = strtoupper($code);
			//if (isset($LAB_SECT[$code])) {$code = $LAB_SECT[$code];}//Equivalence trouvée
			$urlHALDep = $cstAPI.strtolower($code)."/?wt=xml&fq=producedDateY_i:".$year."&fq=submitType_s:(notice OR file)&fq=docType_s:ART&fq=-status_i=111&rows=0";
			//echo $name.' - '.$code.' : '.askCurlNF($urlHALDep, $cstCA).'<br>';
			//if (askCurlNF($urlHALDep) == 0) {echo $urlHALDep.'<br>';}
			if (askCurlNF($urlHALDep, $cstCA) != 0 && $code != "") {//Y-a-t-il des résultats pour l'extraction avec ce code et cette année ?
				//Si limite demandée, ne pas prendre en compte les résultats dont le nombre est inféreur à la limite
				if (isset($limReq3) && $limReq3 == "oui") {
					if (askCurlNF($urlHALDep, $cstCA) > 2000) {
						$sect[$is] = $code;
						extractHAL(strtolower($code), $year, $reqt, $resHAL, $cstCA);
						$tabPro[$code][$cstNfD] = intval($resHAL[$year][$code][$cstNfD]);
						$tabPro[$code][$cstNoTI] = intval($resHAL[$year][$code][$cstNoTI]);
						$tabPro[$code]["pCentnoTI"] = 0;
						$tabPro[$code][$cstAvTI] = intval($resHAL[$year][$code][$cstAvTI]);
						$tabPro[$code]["pCentavTI"] = 0;
						$tabPro[$code][$cstAvTIAvOA] = intval($resHAL[$year][$code][$cstAvTIAvOA]);
						$tabPro[$code]["pCentavTIavOA"] = 0;
						$tabPro[$code][$cstNoTIAvOA] = intval($resHAL[$year][$code][$cstNoTIAvOA]);
						$tabPro[$code]["pCentnoTIavOA"] = 0;
						if ($tabPro[$code][$cstNfD] != 0) {
							$tabPro[$code]["pCentnoTI"] = round($tabPro[$code][$cstNoTI]*100/$tabPro[$code][$cstNfD]);
							$tabPro[$code]["pCentavTI"] = round($tabPro[$code][$cstAvTI]*100/$tabPro[$code][$cstNfD]);
							$tabPro[$code]["pCentavTIavOA"] = round($tabPro[$code][$cstAvTIAvOA]*100/$tabPro[$code][$cstNfD]);
							$tabPro[$code]["pCentnoTIavOA"] = round($tabPro[$code][$cstNoTIAvOA]*100/$tabPro[$code][$cstNfD]);
						}
						$is++;
						//if ($is == 3) {break;}
					}
				}else{
					$sect[$is] = $code;
					extractHAL(strtolower($code), $year, $reqt, $resHAL, $cstCA);
					$tabPro[$code][$cstNfD] = intval($resHAL[$year][$code][$cstNfD]);
					$tabPro[$code][$cstNoTI] = intval($resHAL[$year][$code][$cstNoTI]);
					$tabPro[$code]["pCentnoTI"] = 0;
					$tabPro[$code][$cstAvTI] = intval($resHAL[$year][$code][$cstAvTI]);
					$tabPro[$code]["pCentavTI"] = 0;
					$tabPro[$code][$cstAvTIAvOA] = intval($resHAL[$year][$code][$cstAvTIAvOA]);
					$tabPro[$code]["pCentavTIavOA"] = 0;
					$tabPro[$code][$cstNoTIAvOA] = intval($resHAL[$year][$code][$cstNoTIAvOA]);
					$tabPro[$code]["pCentnoTIavOA"] = 0;
					if ($tabPro[$code][$cstNfD] != 0) {
						$tabPro[$code]["pCentnoTI"] = round($tabPro[$code][$cstNoTI]*100/$tabPro[$code][$cstNfD]);
						$tabPro[$code]["pCentavTI"] = round($tabPro[$code][$cstAvTI]*100/$tabPro[$code][$cstNfD]);
						$tabPro[$code]["pCentavTIavOA"] = round($tabPro[$code][$cstAvTIAvOA]*100/$tabPro[$code][$cstNfD]);
						$tabPro[$code]["pCentnoTIavOA"] = round($tabPro[$code][$cstNoTIAvOA]*100/$tabPro[$code][$cstNfD]);
					}
					$is++;
					//if ($is == 3) {break;}
				}
			}
		}
		$iHAL++;
	}
	//var_dump($tabPro);
	
	//Calcul des rangs > ne doit plus être affiché ni servir au classement

	//noTIavOA
	$tabPro = array_orderby($tabPro, 'nfPronoTIavOA', SORT_DESC);
	$is = 1;
	foreach ($tabPro as $code => $t) {
		$tabPro[$code]["rgPronoTIavOA"] = $is;
		$is++;
	}
	
	//avTIavOA
	$tabPro = array_orderby($tabPro, 'nfProavTIavOA', SORT_DESC);
	$is = 1;
	foreach ($tabPro as $code => $t) {
		$tabPro[$code]["rgProavTIavOA"] = $is;
		$is++;
	}
	
	//avTI
	$tabPro = array_orderby($tabPro, 'nfProavTI', SORT_DESC);
	$is = 1;
	foreach ($tabPro as $code => $t) {
		$tabPro[$code]["rgProavTI"] = $is;
		$is++;
	}
	
	//noTI
	$tabPro = array_orderby($tabPro, 'nfPronoTI', SORT_DESC);
	$is = 1;
	foreach ($tabPro as $code => $t) {
		$tabPro[$code]["rgPronoTI"] = $is;
		$is++;
	}
			
	//nfDep
	$tabPro = array_orderby($tabPro, 'nfDep', SORT_DESC);
	$is = 1;
	foreach ($tabPro as $code => $t) {
		$tabPro[$code]["rgDep"] = $is;
		$is++;
	}
	
	//Stockage du tableau dans la session
	$_SESSION['datPro'] = $tabPro;
}else{
	$tabPro = $_SESSION['datPro'];
}

/*
//Initialement, classement du tableau par le nom du portail ordre alphabétique puis affichage
if ($prtTri == "SORT_ASC") {ksort($tabPro);}
if ($prtTri == "SORT_DESC") {krsort($tabPro);}
if ($artTri == "SORT_ASC") {$tabPro = array_orderby($tabPro, 'nfDep', SORT_ASC);}
if ($artTri == "SORT_DESC") {$tabPro = array_orderby($tabPro, 'nfDep', SORT_DESC);}
if ($AnoTiTri == "SORT_ASC") {$tabPro = array_orderby($tabPro, 'nfPronoTI', SORT_ASC);}
if ($AnoTiTri == "SORT_DESC") {$tabPro = array_orderby($tabPro, 'nfPronoTI', SORT_DESC);}
if ($PnoTiTri == "SORT_ASC") {$tabPro = array_orderby($tabPro, 'pCentnoTI', SORT_ASC);}
if ($PnoTiTri == "SORT_DESC") {$tabPro = array_orderby($tabPro, 'pCentnoTI', SORT_DESC);}
if ($AavTiTri == "SORT_ASC") {$tabPro = array_orderby($tabPro, 'nfProavTI', SORT_ASC);}
if ($AavTiTri == "SORT_DESC") {$tabPro = array_orderby($tabPro, 'nfProavTI', SORT_DESC);}
if ($PavTiTri == "SORT_ASC") {$tabPro = array_orderby($tabPro, 'pCentavTI', SORT_ASC);}
if ($PavTiTri == "SORT_DESC") {$tabPro = array_orderby($tabPro, 'pCentavTI', SORT_DESC);}
if ($AnoTiavOaTri == "SORT_ASC") {$tabPro = array_orderby($tabPro, 'nfPronoTIavOA', SORT_ASC);}
if ($AnoTiavOaTri == "SORT_DESC") {$tabPro = array_orderby($tabPro, 'nfPronoTIavOA', SORT_DESC);}
if ($PnoTiavOaTri == "SORT_ASC") {$tabPro = array_orderby($tabPro, 'pCentnoTIavOA', SORT_ASC);}
if ($PnoTiavOaTri == "SORT_DESC") {$tabPro = array_orderby($tabPro, 'pCentnoTIavOA', SORT_DESC);}
if ($AavTiavOaTri == "SORT_ASC") {$tabPro = array_orderby($tabPro, 'nfProavTIavOA', SORT_ASC);}
if ($AavTiavOaTri == "SORT_DESC") {$tabPro = array_orderby($tabPro, 'nfProavTIavOA', SORT_DESC);}
if ($PavTiavOaTri == "SORT_ASC") {$tabPro = array_orderby($tabPro, 'pCentavTIavOA', SORT_ASC);}
if ($PavTiavOaTri == "SORT_DESC") {$tabPro = array_orderby($tabPro, 'pCentavTIavOA', SORT_DESC);}
*/

//Affichage
//$speTri = '<a href="?reqt=req3&port='.$port.'&annee3='.$annee3;

echo '<span id="reqt3">';
echo '<table id="basic-datatable" class="table table-hover table-bordered table-responsive">';
echo '<thead class="thead-dark">';
echo '<tr>';
$chaine = "";
//echo '<th scope="col" style="text-align:center">'.$speTri.'&ordr='.$prtUrl.'">Articles dans une revue publiés en '.$annee3.' et référencés dans le portail HAL</a></th>';
echo '<th scope="col" style="text-align:center">Articles dans une revue publiés en '.$annee3.' et référencés dans le portail HAL</th>';
//echo '<th scope="col" style="text-align:center"><a style="cursor:pointer;" onclick="$.post(\'VizuHAL_liste_actions.php\', {reqt : \''.$cstR03.'\', port : \''.$port.'\', annee: \''.$annee3.'\', ordr : \''.$prtUrl.'\'});">Articles dans une revue publiés en '.$annee3.' et référencés dans le portail HAL</a></th>';
$chaine .= "Articles dans une revue publiés en ".$annee3." et référencés dans le portail HAL;";
//echo '<th scope="col" style="text-align:center;background-color:#F2F2F2;">'.$speTri.'&ordr='.$artUrl.'">Articles</a></th>';
echo '<th scope="col">Articles</th>';
$chaine .= "Articles;";
//echo '<th scope="col" style="text-align:center;background-color:#F2F2F2;">Rang</th>';
//$chaine .= "Rang;";
//echo '<th scope="col" style="text-align:center;background-color:#DDEBF7;">'.$speTri.'&ordr='.$AnoTiUrl.'">Articles '.$annee3.' sans texte intégral déposé dans HAL</a></th>';
echo '<th scope="col">Articles '.$annee3.' sans texte intégral déposé dans HAL</th>';
$chaine .= "Articles ".$annee3." sans texte intégral déposé dans HAL;";
//echo '<th scope="col" style="text-align:center;background-color:#DDEBF7;">'.$speTri.'&ordr='.$PnoTiUrl.'">%</a></th>';
echo '<th scope="col">%</th>';
$chaine .= "%;";
//echo '<th scope="col" style="text-align:center;background-color:#DDEBF7;">Rang</th>';
//$chaine .= "Rang;";
//echo '<th scope="col" style="text-align:center;background-color:#E2EFDA;">'.$speTri.'&ordr='.$AavTiUrl.'">Articles '.$annee3.' avec texte intégral déposé dans HAL</a></th>';
echo '<th scope="col">Articles '.$annee3.' avec texte intégral déposé dans HAL</th>';
$chaine .= "Articles ".$annee3." avec texte intégral déposé dans HAL;";
//echo '<th scope="col" style="text-align:center;background-color:#E2EFDA;">'.$speTri.'&ordr='.$PavTiUrl.'">%</a></th>';
echo '<th scope="col">%</th>';
$chaine .= "%;";
//echo '<th scope="col" style="text-align:center;background-color:#E2EFDA;">Rang</th>';
//$chaine .= "Rang;";
//echo '<th scope="col" style="text-align:center;background-color:#FFF2CC;">'.$speTri.'&ordr='.$AavTiavOaUrl.'">Articles '.$annee3.' avec texte intégral déposé dans HAL ou librement accessible hors HAL</a></th>';
echo '<th scope="col">Articles '.$annee3.' avec texte intégral déposé dans HAL ou librement accessible hors HAL</th>';
$chaine .= "Articles ".$annee3." avec texte intégral déposé dans HAL ou librement accessible hors HAL;";
//echo '<th scope="col" style="text-align:center;background-color:#FFF2CC;">'.$speTri.'&ordr='.$PavTiavOaUrl.'">%</a></th>';
echo '<th scope="col">%</th>';
$chaine .= "%;";
//echo '<th scope="col" style="text-align:center;background-color:#FFF2CC;">Rang</th>';
//$chaine .= "Rang;";
//echo '<th scope="col" style="text-align:center;background-color:#F4D9C7;">'.$speTri.'&ordr='.$AnoTiavOaUrl.'">Articles '.$annee3.' sans texte intégral déposé dans HAL mais avec texte intégral déposé dans HAL librement accessible hors HAL</a></th>';
echo '<th scope="col">Articles '.$annee3.' sans texte intégral déposé dans HAL mais avec texte intégral déposé dans HAL librement accessible hors HAL</th>';
$chaine .= "Articles ".$annee3." sans texte intégral déposé dans HAL mais avec texte intégral déposé dans HAL librement accessible hors HAL;";
//echo '<th scope="col" style="text-align:center;background-color:#F4D9C7;">'.$speTri.'&ordr='.$PnoTiavOaUrl.'">%</a></th>';
echo '<th scope="col">%</th>';
$chaine .= "%;";
//echo '<th scope="col" style="text-align:center;background-color:#F4D9C7;">Rang</th>';
//$chaine .= "Rang;";
echo '</tr>';
echo '</thead>';
$chaine .= chr(13).chr(10);
fwrite($inF,$chaine);

echo '<tbody>';

foreach ($tabPro as $code => $t) {
	if ($code == $team) {
		$evd = " class=\"table-warning\"";
		$evd1 = "";
		$evd2 = "";
		$evd3 = "";
		$evd4 = "";
		$evd5 = "";
	}else{
		$evd = "";
		$evd1 = "background-color:#F2F2F2;";
		$evd2 = "background-color:#DDEBF7;";
		$evd3 = "background-color:#E2EFDA;";
		$evd4 = "background-color:#FFF2CC;";
		$evd5 = "background-color:#F4D9C7;";
	}
	echo '<tr'.$evd.'>'; 
	$chaine = "";
	echo '<td scope="row" style="text-align:center">'.$code.'</td>';
	$chaine .= $code.";";
	echo '<td scope="row" style="text-align:center;'.$evd1.'">'.$tabPro[$code][$cstNfD].'</td>';
	$chaine .= $tabPro[$code][$cstNfD].";";
	//echo '<td scope="row" style="text-align:center;'.$evd1.'">'.$tabPro[$code]["rgDep"].'</td>';
	//$chaine .= $tabPro[$code]["rgDep"].";";
	echo '<td scope="row" style="text-align:center;'.$evd2.'">'.$tabPro[$code][$cstNoTI].'</td>';
	$chaine .= $tabPro[$code][$cstNoTI].";";
	echo '<td scope="row" style="text-align:center;'.$evd2.'">'.$tabPro[$code]["pCentnoTI"].'</td>';
	$chaine .= $tabPro[$code]["pCentnoTI"].";";
	//echo '<td scope="row" style="text-align:center;'.$evd2.'">'.$tabPro[$code]["rgPronoTI"].'</td>';
	//$chaine .= $tabPro[$code]["rgPronoTI"].";";
	echo '<td scope="row" style="text-align:center;'.$evd3.'">'.$tabPro[$code][$cstAvTI].'</td>';
	$chaine .= $tabPro[$code][$cstAvTI].";";
	echo '<td scope="row" style="text-align:center;'.$evd3.'">'.$tabPro[$code]["pCentavTI"].'</td>';
	$chaine .= $tabPro[$code]["pCentavTI"].";";
	//echo '<td scope="row" style="text-align:center;'.$evd3.'">'.$tabPro[$code]["rgProavTI"].'</td>';
	//$chaine .= $tabPro[$code]["rgProavTI"].";";
	echo '<td scope="row" style="text-align:center;'.$evd4.'">'.$tabPro[$code][$cstAvTIAvOA].'</td>';
	$chaine .= $tabPro[$code][$cstAvTIAvOA].";";
	echo '<td scope="row" style="text-align:center;'.$evd4.'">'.$tabPro[$code]["pCentavTIavOA"].'</td>';
	$chaine .= $tabPro[$code]["pCentavTIavOA"].";";
	//echo '<td scope="row" style="text-align:center;'.$evd4.'">'.$tabPro[$code]["rgProavTIavOA"].'</td>';
	//$chaine .= $tabPro[$code]["rgProavTIavOA"].";";
	echo '<td scope="row" style="text-align:center;'.$evd5.'">'.$tabPro[$code][$cstNoTIAvOA].'</td>';
	$chaine .= $tabPro[$code][$cstNoTIAvOA].";";
	echo '<td scope="row" style="text-align:center;'.$evd5.'">'.$tabPro[$code]["pCentnoTIavOA"].'</td>';
	$chaine .= $tabPro[$code]["pCentnoTIavOA"].";";
	//echo '<td scope="row" style="text-align:center;'.$evd5.'">'.$tabPro[$code]["rgPronoTIavOA"].'</td>';  
	//$chaine .= $tabPro[$code]["rgPronoTIavOA"].";";
	echo '</tr>';
	$chaine .= chr(13).chr(10);
	fwrite($inF,$chaine);
}
echo '</tbody>';
echo '</table></span>';

echo '<a class="btn btn-secondary mt-2" href="./csv/req3.csv">Exporter le tableau au format CSV</a><br><br>';
?>
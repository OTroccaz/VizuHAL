<?php
/*
 * VizuHAL - Générez des stats HAL - Generate HAL stats
 *
 * Copyright (C) 2023 Olivier Troccaz (olivier.troccaz@cnrs.fr) and Laurent Jonchère (laurent.jonchere@univ-rennes.fr)
 * Released under the terms and conditions of the GNU General Public License (https://www.gnu.org/licenses/gpl-3.0.txt)
 *
 * Requête 17 - Request 17
 */
 
//Intitulé
echo '<span class="btn btn-secondary mt-2"><strong>17. Collection : Collaborations nationales</strong></span><br><br>';

//Descriptif
echo '<div class="alert alert-secondary">Cette requête affiche, pour une collection, la liste des structures françaises auxquelles sont affiliés des co-auteurs. Cette liste mêle les 3 niveaux (laboratoires, établissements, autres) mais il est possible de les distinguer (voir les 3 requêtes suivantes). La requête est basée sur les tampons de collections (collCode_s). <a href="#DT">Voir détails techniques en bas de page</a>.</div><br>';

/*
//Tri par défaut
$nomTri = "";
$typTri = "";
$codTri = "";
$nbrTri = "SORT_DESC";
$nomUrl = "nomDes";
$typUrl = "typAsc";
$codUrl = "codAsc";
$nbrUrl = "nbrAsc";

//Recherche des éventuelles demandes de tri
$ordr = (isset($_GET["ordr"])) ? $_GET["ordr"] : "";//Tri demandé
if ($ordr != "") {
	if (strpos($ordr, "nom") !== false) {//Sur le nom de la collection
		if ($ordr == "nomAsc") {$nomTri = "SORT_ASC"; $nbrTri = ""; $nomUrl = "nomDes";}else{$nomTri = "SORT_DESC"; $nbrTri = ""; $nomUrl = "nomAsc";}
	}
	if (strpos($ordr, "typ") !== false) {//Sur le type de la collection
		if ($ordr == "typAsc") {$typTri = "SORT_ASC"; $nbrTri = ""; $typUrl = "typDes";}else{$typTri = "SORT_DESC"; $nbrTri = ""; $typUrl = "typAsc";}
	}
	if (strpos($ordr, "cod") !== false) {//Sur le code la collection
		if ($ordr == "codAsc") {$codTri = "SORT_ASC"; $nbrTri = ""; $codUrl = "codDes";}else{$codTri = "SORT_DESC"; $nbrTri = ""; $codUrl = "codAsc";}
	}
	if (strpos($ordr, "nbr") !== false) {//Sur le nombre de publications
		if ($ordr == "nbrAsc") {$nbrTri = "SORT_ASC"; $nbrUrl = "nbrDes";}else{$nbrTri = "SORT_DESC"; $nbrUrl = "nbrAsc";}
	}
}
*/

//Export CSV
$Fnm = "./csv/req17.csv";
$inF = fopen($Fnm,"w+");
fseek($inF, 0);
$chaine = "\xEF\xBB\xBF";
fwrite($inF,$chaine);

$resColl = array();
$resColl["code"] = array();
$year = $annee17;
$url = $cstAPI.$team."/?fq=producedDateY_i:".$year."&fl=collName_s,collCategory_s,collCode_s,halId_s&rows=10000";
//echo $url;
$totColl = askCurlNF($cstAPI.$team."/?wt=xml&fq=producedDateY_i:".$year."&fl=collName_s,collCategory_s,collCode_s,halId_s", $cstCA);
askCurl($url, $arrayCurl, $cstCA);
//var_dump($arrayCurl);

$i = 0;
$k = 0;
while (isset($arrayCurl["response"]["docs"][$i]["collCode_s"])) {
	for ($j=0; $j<count($arrayCurl["response"]["docs"][$i]["collCode_s"]); $j++) {
		if ($arrayCurl["response"]["docs"][$i]["collCategory_s"][$j] != "AUTRE" && strpos($arrayCurl["response"]["docs"][$i]["collCode_s"][$j], "-TEST") === false && strpos($arrayCurl["response"]["docs"][$i]["collCode_s"][$j], "TEST-") === false && strpos($arrayCurl["response"]["docs"][$i]["collCode_s"][$j], "_TEST") === false && strpos($arrayCurl["response"]["docs"][$i]["collCode_s"][$j], "TEST_") === false) {
			if (array_search($arrayCurl["response"]["docs"][$i]["collCode_s"][$j], $resColl["code"]) === false) {
				$resColl["code"][$k] = strtoupper(trim($arrayCurl["response"]["docs"][$i]["collCode_s"][$j]));
				$resColl["nombre"][$k] = 1;
				$resColl["nom"][$k] = ucfirst(trim($arrayCurl["response"]["docs"][$i]["collName_s"][$j]));
				$resColl["type"][$k] = strtoupper(trim($arrayCurl["response"]["docs"][$i]["collCategory_s"][$j]));
				$resColl["idhal"][$k] = $arrayCurl["response"]["docs"][$i]["halId_s"];
				$k++;
			}else{
				$key = array_search($arrayCurl["response"]["docs"][$i]["collCode_s"][$j], $resColl["code"]);
				if (strpos($resColl["idhal"][$key], $arrayCurl["response"]["docs"][$i]["halId_s"]) === false) {
					$resColl["nombre"][$key] += 1;
					$resColl["idhal"][$key] .= "~".$arrayCurl["response"]["docs"][$i]["halId_s"];
				}
			}
		}
	}
	$i++;
}

if ($totColl != 0) {//Au moins 1 résultat
	//Tableau final avec %
	for ($i=0; $i<count($resColl["nombre"]); $i++) {
		$resColl["pcent"][$i] = ($totColl != 0) ? number_format($resColl["nombre"][$i]*100/$totColl, 1) : 0;
	}
	
	/*
	//Initialement, classement du tableau par le nombre de publications ordre décroissant puis affichage
	if ($nomTri == "SORT_ASC") {array_multisort($resColl["nom"], SORT_ASC, SORT_STRING, $resColl["type"], $resColl["code"], $resColl["nombre"], $resColl["pcent"], $resColl["idhal"]);}
	if ($nomTri == "SORT_DESC") {array_multisort($resColl["nom"], SORT_DESC, SORT_STRING, $resColl["type"], $resColl["code"], $resColl["nombre"], $resColl["pcent"], $resColl["idhal"]);}
	if ($typTri == "SORT_ASC") {array_multisort($resColl["type"], SORT_ASC, SORT_STRING, $resColl["nom"], $resColl["code"], $resColl["nombre"], $resColl["pcent"], $resColl["idhal"]);}
	if ($typTri == "SORT_DESC") {array_multisort($resColl["type"], SORT_DESC, SORT_STRING, $resColl["nom"], $resColl["code"], $resColl["nombre"], $resColl["pcent"], $resColl["idhal"]);}
	if ($codTri == "SORT_ASC") {array_multisort($resColl["code"], SORT_ASC, SORT_STRING, $resColl["nom"], $resColl["type"], $resColl["nombre"], $resColl["pcent"], $resColl["idhal"]);}
	if ($codTri == "SORT_DESC") {array_multisort($resColl["code"], SORT_DESC, SORT_STRING, $resColl["nom"], $resColl["type"], $resColl["nombre"], $resColl["pcent"], $resColl["idhal"]);}
	if ($nbrTri == "SORT_ASC") {array_multisort($resColl["nombre"], SORT_ASC, SORT_NUMERIC, $resColl["nom"], $resColl["type"], $resColl["code"], $resColl["pcent"], $resColl["idhal"]);}
	if ($nbrTri == "SORT_DESC") {array_multisort($resColl["nombre"], SORT_DESC, SORT_NUMERIC, $resColl["nom"], $resColl["type"], $resColl["code"], $resColl["pcent"], $resColl["idhal"]);}
	*/
	
	//echo $totColl;
	//var_dump($resColl);
	
	//Affichage
	//$speTri = '<a href="?reqt=req17&team='.$team.'&annee17='.$annee17;
	echo '<br>';
	echo '<table id="basic-datatable" class="table table-hover table-striped table-bordered col-12">';
	echo '<thead class="thead-dark">';
	echo '<tr>';
	//echo $cstTS1.$speTri.'&ordr='.$nomUrl.'">'.$cstNom;
	echo $cstTS1.$cstNom;
	//echo $cstTS1.$speTri.'&ordr='.$typUrl.'">'.$cstTyp;
	echo $cstTS1.$cstTyp;
	//echo $cstTS1.$speTri.'&ordr='.$codUrl.'">'.$cstCod;
	echo $cstTS1.$cstCod;
	//echo $cstTS1.$speTri.'&ordr='.$nbrUrl.'">'.$cstNbP;
	echo $cstTS1.$cstNbP;
	echo $cstTS2;
	echo $cstTS3;
	$chaine = "Nom;Type;Code HAL;Nombre de publications;%;Références HAL;";
	echo '</tr>';
	$chaine .= chr(13).chr(10);
	fwrite($inF,$chaine);
	echo '</thead>';
	echo '<tbody>';
	
	for ($i=0; $i<count($resColl["nom"]); $i++) {
		echo '<tr>';
		echo '<td>';
		echo $resColl["nom"][$i];
		echo '</td>';
		echo '<td>';
		echo $resColl["type"][$i];
		echo '</td>';
		echo '<td>';
		echo $resColl["code"][$i];
		echo '</td>';
		echo '<td>';
		echo $resColl["nombre"][$i];
		echo '</td>';
		echo '<td>';
		echo $resColl["pcent"][$i];
		echo '%</td>';
		echo '<td>';
		$idhal = $resColl["idhal"][$i];
		$idhal = "(".str_replace("~", "%20OR%20", $idhal).")";
		$liens = '<a target="_blank" href="https://api.archives-ouvertes.fr/search/'.$team.'/?fq=producedDateY_i:'.$year.'%20AND%20halId_s:'.$idhal.'&rows=10000&wt=xml">XML</a>';
		$liens .= ' - ';
		$liens .= '<a target="_blank" href="https://api.archives-ouvertes.fr/search/'.$team.'/?fq=producedDateY_i:'.$year.'%20AND%20halId_s:'.$idhal.'&rows=10000">JSON</a>';
		$liens .= ' - ';
		$liens .= '<a target="_blank" href="https://api.archives-ouvertes.fr/search/'.$team.'/?fq=producedDateY_i:'.$year.'%20AND%20halId_s:'.$idhal.'&rows=10000&wt=csv">CSV</a>';
		echo $liens;
		echo '</td>';
		$chaine = $resColl["nom"][$i].";".$resColl["type"][$i].";".$resColl["code"][$i].";".$resColl["nombre"][$i].";".$resColl["pcent"][$i].";".$liens.";";
		echo '</tr>';
		$chaine .= chr(13).chr(10);
		fwrite($inF,$chaine);
	}
	
	echo '</tbody>';
	echo '</table>';
	
	echo '<a class="btn btn-secondary mt-2" href="./csv/req17.csv">Exporter le tableau au format CSV</a><br><br>';
}else{
	echo $cstNR;
}
?>
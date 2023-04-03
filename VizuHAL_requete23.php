<?php
//Intitulé
echo '<span class="btn btn-secondary mt-2"><strong>23. Collection : Collaborations internationales (structures)</strong></span><br><br>';

//Descriptif
echo '<div class="alert alert-secondary">Cette requête affiche, pour une collection, la liste des institutions étrangères auxquelles sont affiliés des co-auteurs. La requête est basée sur le pays de l’affiliation (structCountry_s). Cliquez sur le lien XML / JSON pour afficher les références concernées. Les institutions dont le pays n’est pas renseigné dans le <a target="_blank" href="https://aurehal.archives-ouvertes.fr/structure/index">référentiel AuréHAL</a> (<a target="_blank" href="https://aurehal.archives-ouvertes.fr/structure/browse?critere=-country_s%3A%5B%22%22+TO+*%5D&category=*">elles sont nombreuses</a>) sont classés sous la rubriques « Structure(s) sans pays défini(s) dans HAL » en fin de tableau. <a href="#DT">Voir détails techniques en bas de page</a>.</div><br>';

include('./VizuHAL_codes_pays.php');

$typTab = array(
'regroupinstitution' => 'Regroupement d\'institutions',
'institution' => 'Institution',
'regrouplaboratory' => 'Regroupement de laboratoires, département',
);

/*
//Tri par défaut
$nomTri = "";
$payTri = "";
$typTri = "";
$nbrTri = "SORT_DESC";
$nomUrl = "nomDes";
$payUrl = "payDes";
$typUrl = "typAsc";
$nbrUrl = "nbrAsc";

//Recherche des éventuelles demandes de tri
$ordr = (isset($_GET["ordr"])) ? $_GET["ordr"] : "";//Tri demandé
if ($ordr != "") {
	if (strpos($ordr, "nom") !== false) {//Sur le nom de la structure
		if ($ordr == "nomAsc") {$nomTri = "SORT_ASC"; $nbrTri = ""; $nomUrl = "nomDes";}else{$nomTri = "SORT_DESC"; $nbrTri = ""; $nomUrl = "nomAsc";}
	}
	if (strpos($ordr, "pay") !== false) {//Sur le pays de la structure
		if ($ordr == "payAsc") {$payTri = "SORT_ASC"; $nbrTri = ""; $payUrl = "payDes";}else{$payTri = "SORT_DESC"; $nbrTri = ""; $payUrl = "payAsc";}
	}
	if (strpos($ordr, "typ") !== false) {//Sur le type de la structure
		if ($ordr == "typAsc") {$typTri = "SORT_ASC"; $nbrTri = ""; $typUrl = "typDes";}else{$typTri = "SORT_DESC"; $nbrTri = ""; $typUrl = "typAsc";}
	}
	if (strpos($ordr, "nbr") !== false) {//Sur le nombre de publications
		if ($ordr == "nbrAsc") {$nbrTri = "SORT_ASC"; $nbrUrl = "nbrDes";}else{$nbrTri = "SORT_DESC"; $nbrUrl = "nbrAsc";}
	}
}
*/

//Export CSV
$Fnm = "./csv/req23.csv";
$inF = fopen($Fnm,"w+");
fseek($inF, 0);
$chaine = "\xEF\xBB\xBF";
fwrite($inF,$chaine);

$resColl = array();
$resColl["nom"] = array();
$k = 0;
$totColl = 0;
$tabPaysFR = array('fr','FR','mq','MQ','gp','GP','gf','GF','yt','YT','nc','NC','pf','PF','pm','PM','tf','TF','re','RE');//Territoires français à ne pas considérer dans l'international

for ($year = $anneedeb; $year <= $anneefin; $year++) {
	$url = $cstAPI.$team."/?fq=producedDateY_i:".$year."&fl=structName_s,structType_s,halId_s,structCountry_s&rows=10000";
	//echo $url;
	//$totColl += askCurlNF($cstAPI.$team."/?wt=xml&fq=producedDateY_i:".$year."&fl=structName_s,structType_s,halId_s,structCountry_s", $cstCA);
	askCurl($url, $arrayCurl, $cstCA);
	//var_dump($arrayCurl);
	$totColl += $arrayCurl["response"][$cstNuF];
	$i = 0;
	
	while (isset($arrayCurl["response"]["docs"][$i]["structName_s"])) {
		if (count($arrayCurl["response"]["docs"][$i]["structCountry_s"]) != count($arrayCurl["response"]["docs"][$i]["structName_s"])) {//Pays non défini pour une structure
			if (array_search("Structure(s) sans pays défini(s) dans HAL", $resColl["nom"]) === false) {
				$resColl["nom"][$k] = "Structure(s) sans pays défini(s) dans HAL";
				$resColl["nombre"][$k] = 1;
				$resColl["type"][$k] = "-";
				$resColl["pays"][$k] = "-";
				$resColl["idhal"][$k] = $arrayCurl["response"]["docs"][$i]["halId_s"];
				$k++;
			}else{
				$key = array_search("Structure(s) sans pays défini(s) dans HAL", $resColl["nom"]);
				$resColl["nombre"][$key] += 1;
				$resColl["idhal"][$key] .= "~".$arrayCurl["response"]["docs"][$i]["halId_s"];
			}
		}else{
			for ($j=0; $j<count($arrayCurl["response"]["docs"][$i]["structName_s"]); $j++) {
				if (isset($arrayCurl["response"]["docs"][$i]["structCountry_s"][$j]) && array_search($arrayCurl["response"]["docs"][$i]["structCountry_s"][$j], $tabPaysFR) === false) {
					if (array_search(ucfirst(trim($arrayCurl["response"]["docs"][$i]["structName_s"][$j])), $resColl["nom"]) === false) {//Nouvelle structure
						if (array_key_exists(strtoupper($arrayCurl["response"]["docs"][$i]["structCountry_s"][$j]), $countries)) {
							if (array_key_exists(strtolower(trim($arrayCurl["response"]["docs"][$i]["structType_s"][$j])), $typTab)) {//Le type de structure est bien parmi ceux recherchés
								$resColl["nom"][$k] = ucfirst(trim($arrayCurl["response"]["docs"][$i]["structName_s"][$j]));
								$resColl["nombre"][$k] = 1;
								$resColl["type"][$k] = $typTab[strtolower(trim($arrayCurl["response"]["docs"][$i]["structType_s"][$j]))];
								$resColl["pays"][$k] = $countries[strtoupper($arrayCurl["response"]["docs"][$i]["structCountry_s"][$j])];
								$resColl["idhal"][$k] = $arrayCurl["response"]["docs"][$i]["halId_s"];
								$k++;
							}								
						}else{//Code pays inconnu dans la liste ISO des pays
							if (array_search("Structure(s) sans pays défini(s) dans HAL", $resColl["nom"]) === false) {
								$resColl["nom"][$k] = "Structure(s) sans pays défini(s) dans HAL";
								$resColl["nombre"][$k] = 1;
								$resColl["type"][$k] = "-";
								$resColl["pays"][$k] = "-";
								$resColl["idhal"][$k] = $arrayCurl["response"]["docs"][$i]["halId_s"];
								$k++;
							}else{
								$key = array_search("Structure(s) sans pays défini(s) dans HAL", $resColl["nom"]);
								$resColl["nombre"][$key] += 1;
								$resColl["idhal"][$key] .= "~".$arrayCurl["response"]["docs"][$i]["halId_s"];
							}
						}
					}else{
						$key = array_search(ucfirst(trim($arrayCurl["response"]["docs"][$i]["structName_s"][$j])), $resColl["nom"]);
						$resColl["nombre"][$key] += 1;
						$resColl["idhal"][$key] .= "~".$arrayCurl["response"]["docs"][$i]["halId_s"];
					}
				}
			}
		}
		$i++;
	}
}

if ($k != 0) {//Au moins 1 résultat
	/*
	//Nombre total de publications
	for ($i=0; $i<count($resColl["nombre"]); $i++) {
		if ($resColl["nom"][$i] != "Structure(s) sans pays défini(s) dans HAL") {
			$totColl += $resColl["nombre"][$i];
		}
	}
	*/

	//Tableau final avec %
	for ($i=0; $i<count($resColl["nombre"]); $i++) {
		if ($resColl["nom"][$i] != "Structure(s) sans pays défini(s) dans HAL") {
			$resColl["pcent"][$i] = ($totColl != 0) ? number_format($resColl["nombre"][$i]*100/$totColl, 2) : 0;
		}else{
			$resColl["pcent"][$i] = "-";
		}
	}

	/*
	//Initialement, classement du tableau par le nombre de publications ordre décroissant puis affichage
	if ($nomTri == "SORT_ASC") {array_multisort($resColl["nom"], SORT_ASC, SORT_STRING, $resColl["type"], $resColl["nombre"], $resColl["pcent"], $resColl["idhal"], $resColl["pays"]);}
	if ($nomTri == "SORT_DESC") {array_multisort($resColl["nom"], SORT_DESC, SORT_STRING, $resColl["type"], $resColl["nombre"], $resColl["pcent"], $resColl["idhal"], $resColl["pays"]);}
	if ($payTri == "SORT_ASC") {array_multisort($resColl["pays"], SORT_ASC, SORT_STRING, $resColl["nom"], $resColl["nombre"], $resColl["pcent"], $resColl["idhal"], $resColl["type"]);}
	if ($payTri == "SORT_DESC") {array_multisort($resColl["pays"], SORT_DESC, SORT_STRING, $resColl["nom"], $resColl["nombre"], $resColl["pcent"], $resColl["idhal"], $resColl["type"]);}
	if ($typTri == "SORT_ASC") {array_multisort($resColl["type"], SORT_ASC, SORT_STRING, $resColl["nom"], $resColl["nombre"], $resColl["pcent"], $resColl["idhal"], $resColl["pays"]);}
	if ($typTri == "SORT_DESC") {array_multisort($resColl["type"], SORT_DESC, SORT_STRING, $resColl["nom"], $resColl["nombre"], $resColl["pcent"], $resColl["idhal"], $resColl["pays"]);}
	if ($nbrTri == "SORT_ASC") {array_multisort($resColl["nombre"], SORT_ASC, SORT_NUMERIC, $resColl["nom"], $resColl["type"], $resColl["pcent"], $resColl["idhal"], $resColl["pays"]);}
	if ($nbrTri == "SORT_DESC") {array_multisort($resColl["nombre"], SORT_DESC, SORT_NUMERIC, $resColl["nom"], $resColl["type"], $resColl["pcent"], $resColl["idhal"], $resColl["pays"]);}
	*/
	
	//echo $totColl;
	//var_dump($resColl);
	
	//Affichage
	//$speTri = '<a href="?reqt=req23&team='.$team.'&anneedeb='.$anneedeb.'&anneefin='.$anneefin;
	echo '<br>Poucentages calculés sur le nombre total de publications de la collection sur la période concernée';
	echo '<br><table id="basic-datatable" class="table table-hover table-striped table-bordered col-12">';
	echo '<thead class="thead-dark">';
	echo '<tr>';
	//echo $cstTS1.$speTri.'&ordr='.$nomUrl.'">'.$cstNom;
	echo $cstTS1.$cstNom;
	//echo $cstTS1.$speTri.'&ordr='.$typUrl.'">'.$cstPay;
	echo $cstTS1.$cstPay;
	//echo $cstTS1.$speTri.'&ordr='.$codUrl.'">'.$cstTyp;
	echo $cstTS1.$cstTyp;
	//echo $cstTS1.$speTri.'&ordr='.$nbrUrl.'">'.$cstNbP;
	echo $cstTS1.$cstNbP;
	echo $cstTS2;
	echo $cstTS3;
	$chaine = "Nom;Pays;Type;Nombre de publications;%;Références HAL;";
	echo '</tr>';
	$chaine .= chr(13).chr(10);
	fwrite($inF,$chaine);
	echo '</thead>';
	echo '<tbody>';
	
	//Affichage du nombre total de publications de la collection sur la période concernée
	echo '<tr>';
	echo '<td>Publications de la collection sur la période concernée</td>';
	echo '<td>-</td>';
	echo '<td>-</td>';
	echo '<td>'.$totColl.'</td>';
	echo '<td>100%</td>';
	echo '<td>-</td>';
	$chaine = "Publications de la collection sur la période concernée".";-;-;".$totColl.";100%;-;";
	echo '</tr>';
	$chaine .= chr(13).chr(10);
	fwrite($inF,$chaine);
	
	$key = -1;
	for ($i=0; $i<count($resColl["nom"]); $i++) {
		if ($resColl["nom"][$i] != "Structure(s) sans pays défini(s) dans HAL") {
			echo '<tr>';
			echo '<td>'.$resColl["nom"][$i].'</td>';
			echo '<td>'.$resColl["pays"][$i].'</td>';
			echo '<td>'.$resColl["type"][$i].'</td>';
			echo '<td>'.$resColl["nombre"][$i].'</td>';
			echo '<td>'.$resColl["pcent"][$i].'%</td>';
			echo '<td>';
			$idhal = $resColl["idhal"][$i];
			$idhal = "(".str_replace("~", "%20OR%20", $idhal).")";
			$liens = '<a target="_blank" href="https://api.archives-ouvertes.fr/search/'.$team.'/?fq=producedDateY_i:['.$anneedeb.' TO '.$anneefin.']%20AND%20halId_s:'.$idhal.'&rows=10000&wt=xml">XML</a>';
			$liens .= ' - ';
			$liens .= '<a target="_blank" href="https://api.archives-ouvertes.fr/search/'.$team.'/?fq=producedDateY_i:['.$anneedeb.' TO '.$anneefin.']%20AND%20halId_s:'.$idhal.'&rows=10000">JSON</a>';
			$liens .= ' - ';
			$liens .= '<a target="_blank" href="https://api.archives-ouvertes.fr/search/'.$team.'/?fq=producedDateY_i:['.$anneedeb.' TO '.$anneefin.']%20AND%20halId_s:'.$idhal.'&rows=10000&wt=csv">CSV</a>';
			echo $liens;
			echo '</td>';
			$chaine = str_replace(';', '-', $resColl["nom"][$i]).";".$resColl["pays"][$i].";".$resColl["type"][$i].";".$resColl["nombre"][$i].";".$resColl["pcent"][$i].";".$liens.";";
			echo '</tr>';
			$chaine .= chr(13).chr(10);
			fwrite($inF,$chaine);
		}else{
			$key = $i;//Clé structure(s) sans pays défini(s) dans HAL
		}
	}
	//Affichage en fin de tableau de la ligne des structure(s) sans pays défini(s) dans HAL
	if ($key != -1) {
		echo '<tr>';
		echo '<td>'.$resColl["nom"][$key].'</td>';
		echo '<td>'.$resColl["pays"][$key].'</td>';
		echo '<td>'.$resColl["type"][$key].'</td>';
		echo '<td>'.$resColl["nombre"][$key].'</td>';
		echo '<td>'.$resColl["pcent"][$key].'</td>';
		echo '<td>';
		$idhal = $resColl["idhal"][$key];
		$idhal = "(".str_replace("~", "%20OR%20", $idhal).")";
		$liens = '<a target="_blank" href="https://api.archives-ouvertes.fr/search/'.$team.'/?fq=producedDateY_i:['.$anneedeb.' TO '.$anneefin.']%20AND%20halId_s:'.$idhal.'&rows=10000&wt=xml">XML</a>';
		$liens .= ' - ';
		$liens .= '<a target="_blank" href="https://api.archives-ouvertes.fr/search/'.$team.'/?fq=producedDateY_i:['.$anneedeb.' TO '.$anneefin.']%20AND%20halId_s:'.$idhal.'&rows=10000">JSON</a>';
		echo $liens;
		echo '</td>';
		$chaine = str_replace(';', '-', $resColl["nom"][$key]).";".$resColl["pays"][$key].";".$resColl["type"][$key].";".$resColl["nombre"][$key].";".$resColl["pcent"][$key].";".$liens.";";
		echo '</tr>';
		$chaine .= chr(13).chr(10);
		fwrite($inF,$chaine);
	}
	
	echo '</tbody>';
	echo '</table>';
	
	echo '<a class="btn btn-secondary mt-2" href="./csv/req23.csv">Exporter le tableau au format CSV</a><br><br>';
}else{
	echo $cstNR;
}
?>
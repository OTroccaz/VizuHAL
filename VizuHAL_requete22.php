<?php
//Intitulé
echo '<br><strong>22. Collection : Collaborations internationales (institutions)</strong><br><br>';

//Descriptif
echo '<div style="background-color:#f5f5f5">Cette requête affiche, pour une collection, la liste des institutions étrangères auxquelles sont affiliés des co-auteurs. La requête est basée sur le pays de l’affiliation (structCountry_s). Cliquez sur le lien XML / JSON pour afficher les références concernées. Les institutions dont le pays n’est pas renseigné dans le <a target="_blank" href="https://aurehal.archives-ouvertes.fr/structure/index">référentiel AuréHAL</a> (<a target="_blank" href="https://aurehal.archives-ouvertes.fr/structure/browse?critere=-country_s%3A%5B%22%22+TO+*%5D&category=*">elles sont nombreuses</a>) sont classés sous la rubriques « Structure(s) sans pays défini(s) dans HAL » en fin de tableau. <a href="#DT">Voir détails techniques en bas de page</a>.</div><br>';

include('./VizuHAL_codes_pays.php');

//Tri par défaut
$payTri = "";
$nbrTri = "SORT_DESC";
$payUrl = "payDes";
$nbrUrl = "nbrAsc";

//Recherche des éventuelles demandes de tri
$ordr = (isset($_GET["ordr"])) ? $_GET["ordr"] : "";//Tri demandé
if ($ordr != "") {
	if (strpos($ordr, "pay") !== false) {//Sur le pays
		if ($ordr == "payAsc") {$payTri = "SORT_ASC"; $nbrTri = ""; $payUrl = "payDes";}else{$payTri = "SORT_DESC"; $nbrTri = ""; $payUrl = "payAsc";}
	}
	if (strpos($ordr, "nbr") !== false) {//Sur le nombre de publications
		if ($ordr == "nbrAsc") {$nbrTri = "SORT_ASC"; $nbrUrl = "nbrDes";}else{$nbrTri = "SORT_DESC"; $nbrUrl = "nbrAsc";}
	}
}

//Export CSV
$Fnm = "./csv/req22.csv";
$inF = fopen($Fnm,"w+");
fseek($inF, 0);
$chaine = "\xEF\xBB\xBF";
fwrite($inF,$chaine);

$resColl = array();
$resColl["pays"] = array();
$docType = array("ART", "COMM", "POSTER", "COUV", "OUV", "DOUV");
$typColl = array();
$typCollStr = array();//Nombre de types de publications impliquant au moins un pays étranger
$k = 0;
$totColl = 0;//Nombre de publications
$totCollStr = 0;//Nombre de publications impliquant au moins un pays étranger
$tabPaysFR = array('fr','FR','mq','MQ','gp','GP','gf','GF','yt','YT','nc','NC','pf','PF','pm','PM','tf','TF','re','RE');//Territoires français à ne pas considérer dans l'international

for ($year = $anneedeb; $year <= $anneefin; $year++) {
	$url = $cstAPI.$team."/?fq=producedDateY_i:".$year."&fl=docType_s,structName_s,structType_s,halId_s,structCountry_s&rows=10000";
	//echo $url;
	askCurl($url, $arrayCurl, $cstCA);
	//var_dump($arrayCurl);
	$totColl += $arrayCurl["response"][$cstNuF];
	$i = 0;
	
	while (isset($arrayCurl["response"]["docs"][$i]["structName_s"])) {
		$cptStr = 0;
		//docType
		if (isset($typColl[$arrayCurl["response"]["docs"][$i]["docType_s"]])) {
			$typColl[$arrayCurl["response"]["docs"][$i]["docType_s"]] += 1;
		}else{
			$typColl[$arrayCurl["response"]["docs"][$i]["docType_s"]] = 1;
		}
		if (count($arrayCurl["response"]["docs"][$i]["structCountry_s"]) != count($arrayCurl["response"]["docs"][$i]["structName_s"])) {//Pays non défini pour une structure
			if (array_search("Structure(s) sans pays défini(s) dans HAL", $resColl["pays"]) === false) {
				$resColl["nombre"][$k] = 1;
				foreach($docType as $type) {
					if ($arrayCurl["response"]["docs"][$i]["docType_s"] == $type) {
						$resColl[$type][$k] = 1;
					}else{
						$resColl[$type][$k] = 0;
					}
				}
				$resColl["pays"][$k] = "Structure(s) sans pays défini(s) dans HAL";
				$resColl["idhal"][$k] = $arrayCurl["response"]["docs"][$i]["halId_s"];
				$k++;
			}else{
				$key = array_search("Structure(s) sans pays défini(s) dans HAL", $resColl["pays"]);
				if (strpos($resColl["idhal"][$key], $arrayCurl["response"]["docs"][$i]["halId_s"]) === false) {
					$resColl["nombre"][$key] += 1;
					foreach($docType as $type) {
						if ($arrayCurl["response"]["docs"][$i]["docType_s"] == $type) {
							if (isset($resColl[$type][$key])) {
								$resColl[$type][$key] += 1;
							}else{
								$resColl[$type][$key] = 1;
							}
						}else{
							$resColl[$type][$key] = 0;
						}
					}
					$resColl["idhal"][$key] .= "~".$arrayCurl["response"]["docs"][$i]["halId_s"];
				}
			}
		}else{
			for ($j=0; $j<count($arrayCurl["response"]["docs"][$i]["structName_s"]); $j++) {
				if (isset($arrayCurl["response"]["docs"][$i]["structCountry_s"][$j]) && array_search($arrayCurl["response"]["docs"][$i]["structCountry_s"][$j], $tabPaysFR) === false) {
					if (array_key_exists(strtoupper($arrayCurl["response"]["docs"][$i]["structCountry_s"][$j]), $countries)) {
						$pays = $countries[strtoupper($arrayCurl["response"]["docs"][$i]["structCountry_s"][$j])];
						if ($cptStr == 0) {
							$totCollStr += 1;
							$cptStr = 1;
							if (isset($typCollStr[$arrayCurl["response"]["docs"][$i]["docType_s"]])) {
								$typCollStr[$arrayCurl["response"]["docs"][$i]["docType_s"]] += 1;
							}else{
								$typCollStr[$arrayCurl["response"]["docs"][$i]["docType_s"]] = 1;
							}
						}
						if (array_search($pays, $resColl["pays"]) === false) {//Nouveau pays
							$resColl["pays"][$k] = $pays;
							$resColl["nombre"][$k] = 1;
							foreach($docType as $type) {
								if ($arrayCurl["response"]["docs"][$i]["docType_s"] == $type) {
									$resColl[$type][$k] = 1;
								}else{
									$resColl[$type][$k] = 0;
								}
							}
							$resColl["idhal"][$k] = $arrayCurl["response"]["docs"][$i]["halId_s"];
							$k++;
						}else{
							$key = array_search($pays, $resColl["pays"]);
							if (strpos($resColl["idhal"][$key], $arrayCurl["response"]["docs"][$i]["halId_s"]) === false) {
								$resColl["nombre"][$key] += 1;
								foreach($docType as $type) {
									if ($arrayCurl["response"]["docs"][$i]["docType_s"] == $type) {
										$resColl[$type][$key] += 1;
									}
								}
								$resColl["idhal"][$key] .= "~".$arrayCurl["response"]["docs"][$i]["halId_s"];
							}
						}
					}else{//Code pays inconnu dans la liste ISO des pays
						$key = array_search("Structure(s) sans pays défini(s) dans HAL", $resColl["pays"]);
						if (strpos($resColl["idhal"][$key], $arrayCurl["response"]["docs"][$i]["halId_s"]) === false) {
							$resColl["nombre"][$key] += 1;
							if (isset($resColl[$arrayCurl["response"]["docs"][$i]["docType_s"]][$key])) {
								$resColl[$arrayCurl["response"]["docs"][$i]["docType_s"]][$key] += 1;
							}else{
								$resColl[$arrayCurl["response"]["docs"][$i]["docType_s"]][$key] = 1;
							}
							$resColl["idhal"][$key] .= "~".$arrayCurl["response"]["docs"][$i]["halId_s"];
						}
					}
				}
			}
		}
		$i++;
	}
}
//var_dump($typCollStr);
//var_dump($typColl);
//var_dump($resColl);
if ($k != 0) {//Au moins 1 résultat
	/*
	//Nombre total de publications
	for ($i=0; $i<count($resColl["nombre"]); $i++) {
		if ($resColl["pays"][$i] != "Structure(s) sans pays défini(s) dans HAL") {
			$totColl += $resColl["nombre"][$i];
		}
	}
	*/

	//Tableau final avec %
	for ($i=0; $i<count($resColl["nombre"]); $i++) {
		if ($resColl["pays"][$i] != "Structure(s) sans pays défini(s) dans HAL") {
			$resColl["pcent"][$i] = ($totColl != 0) ? number_format($resColl["nombre"][$i]*100/$totColl, 2) : 0;
		}else{
			$resColl["pcent"][$i] = "-";
		}
	}
	
	/*
	//Remplir les tableaux de types de documents avec des valeurs nulles si cellule vide de manière à pouvoir trier
	foreach($docType as $type) {
		for ($i=0; $i<count($resColl["nombre"]); $i++) {
			if (!isset($resColl[$type][$i])) {
				$resColl[$type][$i] = 0;
			}
		}
	}
	*/
	
	//Initialement, classement du tableau par le nombre de publications ordre décroissant puis affichage
	if ($payTri == "SORT_ASC") {array_multisort($resColl["pays"], SORT_ASC, SORT_STRING, $resColl["nombre"], $resColl["pcent"], $resColl["idhal"], $resColl["ART"], $resColl["COMM"], $resColl["POSTER"], $resColl["COUV"], $resColl["OUV"], $resColl["DOUV"]);}
	if ($payTri == "SORT_DESC") {array_multisort($resColl["pays"], SORT_DESC, SORT_STRING, $resColl["nombre"], $resColl["pcent"], $resColl["idhal"], $resColl["ART"], $resColl["COMM"], $resColl["POSTER"], $resColl["COUV"], $resColl["OUV"], $resColl["DOUV"]);}
	if ($nbrTri == "SORT_ASC") {array_multisort($resColl["nombre"], SORT_ASC, SORT_NUMERIC, $resColl["pcent"], $resColl["idhal"], $resColl["pays"], $resColl["ART"], $resColl["COMM"], $resColl["POSTER"], $resColl["COUV"], $resColl["OUV"], $resColl["DOUV"]);}
	if ($nbrTri == "SORT_DESC") {array_multisort($resColl["nombre"], SORT_DESC, SORT_NUMERIC, $resColl["pcent"], $resColl["idhal"], $resColl["pays"], $resColl["ART"], $resColl["COMM"], $resColl["POSTER"], $resColl["COUV"], $resColl["OUV"], $resColl["DOUV"]);}
	
	//echo $totColl;
	//var_dump($resColl);
	
	//Carte mondiale
	echo '<link href="./lib/JQVmaps/jqvmap.css" media="screen" rel="stylesheet" type="text/css">';
	echo '<script type="text/javascript" src="./lib/JQVmaps/jquery.vmap.js"></script>';
	echo '<script type="text/javascript" src="./lib/JQVmaps/maps/jquery.vmap.world.js" charset="utf-8"></script>';
	//Ajout des données
	echo '<script>';
	echo '    var gdpData = {';
	for ($i=0; $i<count($resColl["pays"]); $i++) {
		if ($resColl["pays"][$i] != "Structure(s) sans pays défini(s) dans HAL") {
			$key = strtolower(array_search($resColl["pays"][$i], $countries));
			echo '"'.$key.'":'.$resColl["nombre"][$i].', ';
		}
	}
	//echo '"fr":'.$totCollStr);
	echo '	};';
	echo '</script>';
	echo '<script>';
	echo '  var max = 0,';
	echo '        min = Number.MAX_VALUE,';
	echo '        cc,';
	echo '        startColor = [200, 238, 255],';
	echo '        endColor = [0, 100, 145],';
	echo '        colors = {},';
	echo '        hex;';
	//find maximum and minimum values
	echo '    for (cc in gdpData)';
	echo '    {';
	echo '        if (parseFloat(gdpData[cc]) > max)';
	echo '        {';
	echo '            max = parseFloat(gdpData[cc]);';
	echo '        }';
	echo '        if (parseFloat(gdpData[cc]) < min)';
	echo '        {';
	echo '            min = parseFloat(gdpData[cc]);';
	echo '        }';
	echo '    }';
	//set colors according to values of GDP
	echo '    for (cc in gdpData)';
	echo '    {';
	echo '        if (gdpData[cc] > 0)';
	echo '        {';
	echo '            colors[cc] = \'#\';';
	echo '            for (var i = 0; i<3; i++)';
	echo '            {';
	echo '                hex = Math.round(startColor[i]';
	echo '                    + (endColor[i]';
	echo '                    - startColor[i])';
	echo '                    * (gdpData[cc] / (max - min))).toString(16);';
	echo '                if (hex.length == 1)';
	echo '                {';
	echo '                    hex = \'0\'+hex;';
	echo '                }';
	echo '                colors[cc] += (hex.length == 1 ? \'0\' : \'\') + hex;';
	echo '            }';
	echo '        }';
	echo '    }';
	echo '</script>';

	//Appel de la carte
	echo '<script type="text/javascript">';
	echo 'jQuery(document).ready(function() {';
	echo 'jQuery(\'#vmap\').vectorMap({ ';
	echo '	onLabelShow: function (event, label, code) {';
	echo '	if(gdpData[code] > 0)';
	echo '  	label.append(\': \'+gdpData[code]);';
	echo '	},';
	echo '	map: \'world_en\',';
	echo '	colors: colors,';
	echo '	hoverOpacity: 0.7,';
	echo '	hoverColor: false });';
	echo '});';
	echo '</script>';
	if ($anneedeb != $anneefin) {
		$per = "sur la période ".$anneedeb." - ".$anneefin;
	}else{
		$per = "en ".$anneedeb;
	}
	echo '<center><h3>Carte interactive du nombre de publications par pays pour la collection '.$team.' '.$per.'</h3><br><div id="vmap" style="width: 800px; height: 530px;"></div><br><br></center>';
	
	//Affichage
	$speTri = '<a href="?reqt=req22&team='.$team.'&anneedeb='.$anneedeb.'&anneefin='.$anneefin;
	echo '<br>Poucentages calculés sur le nombre total de publications de la collection sur la période concernée';
	echo '<br><table class="table table-striped table-hover table-responsive table-bordered" style="width:100%;">';
	echo '<thead>';
	echo '<tr>';
	echo $cstTS1.$speTri.'&ordr='.$payUrl.'">'.$cstPay;
	echo $cstTS1.$speTri.'&ordr='.$nbrUrl.'">'.$cstNbP;
	echo $cstTS2;
	echo '<th scope="col" style="text-align:left"><strong>ART</strong></th>';
	echo '<th scope="col" style="text-align:left"><strong>COMM</strong></th>';
	echo '<th scope="col" style="text-align:left"><strong>POSTER</strong></th>';
	echo '<th scope="col" style="text-align:left"><strong>COUV</strong></th>';
	echo '<th scope="col" style="text-align:left"><strong>OUV</strong></th>';
	echo '<th scope="col" style="text-align:left"><strong>DOUV</strong></th>';
	echo $cstTS3;
	$chaine = "Pays;Code pays ISO;Nombre de publications;%;ART;COMM;POSTER;COUV;OUV;DOUV;Références HAL;";
	echo '</tr>';
	$chaine .= chr(13).chr(10);
	fwrite($inF,$chaine);
	echo '</thead>';
	echo '<tbody>';
	
	//Affichage du nombre total de publications de la collection sur la période concernée
	$chaine = "Publications de la collection sur la période concernée".";;".$totColl.";100%;";
	echo '<tr>';
	echo '<td>Publications de la collection sur la période concernée</td>';
	echo '<td>'.$totColl.'</td>';
	echo '<td>100%</td>';
	foreach($docType as $type) {
		$totType = 0;
		if (isset($typColl[$type])) {
			$totType = $typColl[$type];
		}
		echo '<td>'.number_format($totType*100/$totColl, 2).'%</td>';
		$chaine .= number_format($totType*100/$totColl, 2).";";
	}
	echo '<td>-</td>';
	$chaine .= "-;";
	echo '</tr>';
	$chaine .= chr(13).chr(10);
	fwrite($inF,$chaine);
	
	//Affichage du nombre de publications impliquant au moins un pays étranger
	$pcentStr = ($totColl != 0) ? number_format($totCollStr*100/$totColl, 2) : 0;
	$chaine = "Publications impliquant au moins un pays étranger".";;".$totCollStr.";".$pcentStr.";";
	echo '<tr>';
	echo '<td>Publications impliquant au moins un pays étranger</td>';
	echo '<td>'.$totCollStr.'</td>';
	echo '<td>'.$pcentStr.'%</td>';
	foreach($docType as $type) {
		$totType = 0;
		if (isset($typCollStr[$type])) {
			$totType = $typCollStr[$type];
		}
		echo '<td>'.number_format($totType*100/$totColl, 2).'%</td>';
		$chaine .= number_format($totType*100/$totColl, 2).";";
	}
	echo '<td>-</td>';
	$chaine .= "-;";
	echo '</tr>';
	$chaine .= chr(13).chr(10);
	fwrite($inF,$chaine);
	
	$key = -1;
	for ($i=0; $i<count($resColl["pays"]); $i++) {
		if ($resColl["pays"][$i] != "Structure(s) sans pays défini(s) dans HAL") {
			$chaine = $resColl["pays"][$i].";".array_search($resColl["pays"][$i], $countries).";".$resColl["nombre"][$i].";".$resColl["pcent"][$i].";";
			echo '<tr>';
			echo '<td>'.$resColl["pays"][$i].'</td>';
			echo '<td>'.$resColl["nombre"][$i].'</td>';
			echo '<td>'.$resColl["pcent"][$i].'%</td>';
			foreach($docType as $type) {
				$totType = 0;
				if (isset($resColl[$type][$i])) {
					$totType = $resColl[$type][$i];
				}
				echo '<td>'.number_format($totType*100/$totColl, 2).'%</td>';
				$chaine .= number_format($totType*100/$totColl, 2).";";
			}
			echo '<td>';
			$idhal = $resColl["idhal"][$i];
			$idhal = "(".str_replace("~", "%20OR%20", $idhal).")";
			$liens = '<a target="_blank" href="https://api.archives-ouvertes.fr/search/'.$team.'/?fq=producedDateY_i:['.$anneedeb.' TO '.$anneefin.']%20AND%20halId_s:'.$idhal.'&rows=10000&wt=xml">XML</a>';
			$liens .= ' - ';
			$liens .= '<a target="_blank" href="https://api.archives-ouvertes.fr/search/'.$team.'/?fq=producedDateY_i:['.$anneedeb.' TO '.$anneefin.']%20AND%20halId_s:'.$idhal.'&rows=10000">JSON</a>';
			echo $liens;
			echo '</td>';
			$chaine .= $liens.";";
			echo '</tr>';
			$chaine .= chr(13).chr(10);
			fwrite($inF,$chaine);
		}else{
			$key = $i;//Clé structure(s) sans pays défini(s) dans HAL
		}
	}
	
	//Affichage en fin de tableau de la ligne des structure(s) sans pays défini(s) dans HAL
	if ($key != -1) {
		$chaine = $resColl["pays"][$key].";;".$resColl["nombre"][$key].";".$resColl["pcent"][$key].";";
		echo '<tr>';
		echo '<td>'.$resColl["pays"][$key].'</td>';
		echo '<td>'.$resColl["nombre"][$key].'</td>';
		echo '<td>'.$resColl["pcent"][$key].'</td>';
		foreach($docType as $type) {
			echo '<td>-</td>';
			$chaine .= "-;";
		}
		echo '<td>';
		$idhal = $resColl["idhal"][$key];
		$idhal = "(".str_replace("~", "%20OR%20", $idhal).")";
		$liens = '<a target="_blank" href="https://api.archives-ouvertes.fr/search/'.$team.'/?fq=producedDateY_i:['.$anneedeb.' TO '.$anneefin.']%20AND%20halId_s:'.$idhal.'&rows=10000&wt=xml">XML</a>';
		$liens .= ' - ';
		$liens .= '<a target="_blank" href="https://api.archives-ouvertes.fr/search/'.$team.'/?fq=producedDateY_i:['.$anneedeb.' TO '.$anneefin.']%20AND%20halId_s:'.$idhal.'&rows=10000">JSON</a>';
		echo $liens;
		echo '</td>';
		$chaine .= $liens.";";
		echo '</tr>';
		$chaine .= chr(13).chr(10);
		fwrite($inF,$chaine);
	}
	
	echo '</tbody>';
	echo '</table>';
	echo '<a href=\'./csv/req22.csv\'>Exporter le tableau au format CSV</a><br><br>';
}else{
	echo $cstNR;
}
?>
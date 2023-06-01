<?php
/*
 * VizuHAL - Générez des stats HAL - Generate HAL stats
 *
 * Copyright (C) 2023 Olivier Troccaz (olivier.troccaz@cnrs.fr) and Laurent Jonchère (laurent.jonchere@univ-rennes.fr)
 * Released under the terms and conditions of the GNU General Public License (https://www.gnu.org/licenses/gpl-3.0.txt)
 *
 * Requête 15 - Request 15
 */
 
//Intitulé
echo '<strong>15. Collection : Nombre de projets européens</strong><br><br>';

//Descriptif
echo '<div class="alert alert-secondary">Cette requête présente la liste des projets européens d’une collection, avec pour chaque projet le nombre et la liste des publications HAL. En fin de tableau figurent sous la mention « à compléter » les projets mentionnés dans le champ « financement » des dépôts HAL mais pour lesquels il manque la forme validée du référentiel*. Cette requête ne prend en effet en compte que les projets référencés dans le champ projet européen des dépôts HAL. <a href="#DT">Voir détails techniques en bas de page</a>.<br><br><em>(*) : Vous pouvez ainsi rechercher dans la collection HAL les notices concernées (recherche avancée dans le champ « financement »), et compléter les projets manquants dans le champ ANR.</em></div><br>';

//Export CSV
$Fnm = "./csv/req15.csv";
$inF = fopen($Fnm,"w+");
fseek($inF, 0);
$chaine = "\xEF\xBB\xBF";
fwrite($inF,$chaine);

$nbEUR = 1;
$resEUR = array();
$listEURProId = "~";

for ($year = $anneedeb; $year <= $anneefin; $year++) {
	$urlEUR = $cstAPI.$team."/?fq=producedDateY_i:".$year."&fl=europeanProjectId_i,europeanProjectAcronym_s,funding_s,europeanProjectId_i,europeanProjectReference_s&rows=10000";
	askCurl($urlEUR, $arrayCurl, $cstCA);
	$nbTotEUR = $arrayCurl["response"][$cstNuF];
	//echo '<br>Total potentiel de '.$nbTotEUR.' projets EUR pour '.$team.' en '.$year.'.');
	
	$i = 0;
	while (isset($arrayCurl["response"]["docs"][$i])) {
		if (isset($arrayCurl["response"]["docs"][$i]["europeanProjectId_i"][0])){
			$k = 0;
			while (isset($arrayCurl["response"]["docs"][$i]["europeanProjectId_i"][$k])) {//Il y a parfois plusieurs Id
				if (strpos($listEURProId, strval($arrayCurl["response"]["docs"][$i]["europeanProjectId_i"][$k]."-".$year)) === false) {//On vérifie que ce projet n'a pas déjà été affiché
					$listEURProId .= strval($arrayCurl["response"]["docs"][$i]["europeanProjectId_i"][$k]."-".$year)."~";
					//Référence du projet
					if(isset($arrayCurl["response"]["docs"][$i]["europeanProjectReference_s"][$k])) {
						$resEUR["Reference"][$nbEUR] = ucfirst($arrayCurl["response"]["docs"][$i]["europeanProjectReference_s"][$k]);
					}else{
						$resEUR["Reference"][$nbEUR] = "-";
					}
					//Acronyme du projet
					if(isset($arrayCurl["response"]["docs"][$i]["europeanProjectAcronym_s"][$k])) {
						$resEUR["Acronyme"][$nbEUR] = ucfirst($arrayCurl["response"]["docs"][$i]["europeanProjectAcronym_s"][$k]);
					}else{
						$resEUR["Acronyme"][$nbEUR] = "-";
					}
					//Nombre total de publications pour ce projet et cette année
					if (isset($arrayCurl["response"]["docs"][$i]["europeanProjectId_i"][$k])) {
						$urlPub = $cstAPI.$team."/?fq=producedDateY_i:".$year."&fq=europeanProjectId_i:".$arrayCurl["response"]["docs"][$i]["europeanProjectId_i"][$k]."&rows=10000";
						askCurl($urlPub, $arrayPub, $cstCA);
						$nbTotPub = $arrayPub["response"][$cstNuF];
						$resEUR["Nombre"][$nbEUR] = $nbTotPub;
						//Liste des publications
						$j = 0;
						$resEUR["Liste"][$nbEUR] = "";
						$resEUR["ListeCSV"][$nbEUR] = "";
						while (isset($arrayPub["response"]["docs"][$j])) {
							$uri_s = $arrayPub["response"]["docs"][$j]["uri_s"];
							//Ne mettre un lien que sur l'identifiant HAL
							$tabId = explode("/", $uri_s);
							$idHAL = $tabId[count($tabId)-1];
							$label = str_replace($idHAL, '<a target="_blank" href="'.$uri_s.'">'.$idHAL.'</a>', $arrayPub["response"]["docs"][$j]["label_s"]);
							$resEUR["Liste"][$nbEUR] .= $label.'<br><br>';
							$resEUR["ListeCSV"][$nbEUR] .= $arrayPub["response"]["docs"][$j]["label_s"].'   -   ';
							$j++;
						}
						$nbEUR++;
					}
				}
				$k++;
			}
		}
		$i++;
	}
}
echo '<tbody>';
//var_dump($resEUR);
if (count($resEUR) > 0) {//Au moins 1 résultat
	//Classement du tableau par ordre alphabétique des acronymes puis affichage
	array_multisort($resEUR["Acronyme"], SORT_ASC, SORT_FLAG_CASE, $resEUR["Reference"], $resEUR["Nombre"], $resEUR["Liste"], $resEUR["ListeCSV"]);
	
	//Début de l'affichage
	echo '<table id="basic-datatable" class="table table-hover table-striped table-bordered">';
	echo '<thead class="thead-dark">';
	echo '<tr>';
	echo '<th scope="col" style="text-align:left"></th>';
	echo '<th scope="col" style="text-align:left"><strong>Acronyme</strong></th>';
	echo '<th scope="col" style="text-align:left"><strong>Référence du projet européen</strong></th>';
	echo '<th scope="col" style="text-align:left"><strong>Nombre de dépôts HAL contenant cette référence</strong></th>';
	echo '<th scope="col" style="text-align:left"><strong>Liste des publications</strong></th>';
	$chaine = "Acronyme;Référence du projet;Nombre de dépôts HAL contenant cette référence;Liste des publications;";
	echo '</tr>';
	$chaine .= chr(13).chr(10);
	fwrite($inF,$chaine);
	echo '</thead>';
	
	//Regroupement des lignes de projets identiques mais d'années différentes
	$resEURfin = array();
	$nbEUR = 0;
	$nbEURfin = 0;
	while (isset($resEUR["Reference"][$nbEUR])) {
		if ($nbEUR == 0) {$acro = $resEUR["Acronyme"][0];}
		if ($acro == $resEUR["Acronyme"][$nbEUR] && $acro != "-" && $nbEUR != 0) {//2 lignes successives avec le même acronyme > regroupement
			$resEURfin["Nombre"][$nbEURfin-1] += $resEUR["Nombre"][$nbEUR];
			$resEURfin["Liste"][$nbEURfin-1] .= $resEUR["Liste"][$nbEUR];
			$resEURfin["ListeCSV"][$nbEURfin-1] .= $resEUR["ListeCSV"][$nbEUR];
		}else{//Nouvel enregistrement dans le tableau final
			$resEURfin["Acronyme"][$nbEURfin] = $resEUR["Acronyme"][$nbEUR];
			$resEURfin["Reference"][$nbEURfin] = $resEUR["Reference"][$nbEUR];
			$resEURfin["Nombre"][$nbEURfin] = $resEUR["Nombre"][$nbEUR];
			$resEURfin["Liste"][$nbEURfin] = $resEUR["Liste"][$nbEUR];
			$resEURfin["ListeCSV"][$nbEURfin] = $resEUR["ListeCSV"][$nbEUR];
			$nbEURfin++;
			$acro = $resEUR["Acronyme"][$nbEUR];
		}
		$nbEUR++;
	}

	//Affichage du tableau final
	$nbEURfin = 0;
	while (isset($resEURfin["Reference"][$nbEURfin])) {
		$idPro = $nbEURfin + 1;
		echo '<tr><td>'.$idPro.'</td>';
		echo '<td>'.$resEURfin["Acronyme"][$nbEURfin].'</td>';
		$chaine = $resEURfin["Acronyme"][$nbEURfin].";";
		echo '<td>'.$resEURfin["Reference"][$nbEURfin].'</td>';
		$chaine .= $resEURfin["Reference"][$nbEURfin].";";
		echo '<td>'.$resEURfin["Nombre"][$nbEURfin].'</td>';
		$chaine .= $resEURfin["Nombre"][$nbEURfin].";";
		echo '<td>'.$resEURfin["Liste"][$nbEURfin].'</td></tr>';
		$listeCSV = substr($resEURfin["ListeCSV"][$nbEURfin], 0, (strlen($resEURfin["ListeCSV"][$nbEURfin]) - 7));
		$chaine .= str_replace(array('&#x27E8;','&#x27E9;'),array('(',')'), $listeCSV).";";
		$chaine .= chr(13).chr(10);
		fwrite($inF,$chaine);
		$nbEURfin++;
	}
	echo '</tbody>';
	echo '</table><br>';
	
	echo '<a href=\'./csv/req15.csv\'>Exporter le tableau au format CSV</a><br><br>';
}else{
	echo $cstNR;
}
?>
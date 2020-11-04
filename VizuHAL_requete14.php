<?php
//Intitulé
echo '<span class="btn btn-secondary mt-2"><strong>14. Collection : Nombre de projets ANR</strong></span><br><br>';

//Descriptif
echo '<div class="alert alert-secondary">Cette requête présente la liste des projets ANR d’une collection, avec pour chaque projet le nombre et la liste des publications HAL. En fin de tableau figurent sous la mention « à compléter » les projets mentionnés dans le champ « financement » des dépôts HAL mais pour lesquels il manque la forme validée du référentiel*. Cette requête ne prend en effet en compte que les projets référencés dans le champ ANR des dépôts HAL. <a href="#DT">Voir détails techniques en bas de page</a>.<br><br><em>(*) : Vous pouvez ainsi rechercher dans la collection HAL les notices concernées (recherche avancée dans le champ « financement »), et compléter les projets manquants dans le champ ANR.</em></div><br>';

//Export CSV
$Fnm = "./csv/req14.csv";
$inF = fopen($Fnm,"w+");
fseek($inF, 0);
$chaine = "\xEF\xBB\xBF";
fwrite($inF,$chaine);

$nbANR = 1;
$resANR = array();
$listANRProId = "~";

for ($year = $anneedeb; $year <= $anneefin; $year++) {
	$urlANR = $cstAPI.$team."/?fq=producedDateY_i:".$year."&fl=anrProjectId_i,anrProjectAcronym_s,funding_s,anrProjectId_i,anrProjectReference_s&rows=10000";
	askCurl($urlANR, $arrayCurl, $cstCA);
	$nbTotANR = $arrayCurl["response"][$cstNuF];
	//echo '<br>Total potentiel de '.$nbTotANR.' projets ANR pour '.$team.' en '.$year.'.');
	
	$i = 0;
	while (isset($arrayCurl["response"]["docs"][$i])) {
		if (isset($arrayCurl["response"]["docs"][$i]["anrProjectReference_s"][0])){
			$k = 0;
			while (isset($arrayCurl["response"]["docs"][$i]["anrProjectReference_s"][$k])) {//Il y a parfois plusieurs références
				if (strpos($listANRProId, strval($arrayCurl["response"]["docs"][$i]["anrProjectId_i"][$k]."-".$year)) === false) {//On vérifie que ce projet n'a pas déjà été affiché
					$listANRProId .= strval($arrayCurl["response"]["docs"][$i]["anrProjectId_i"][$k]."-".$year)."~";
					//Référence du projet ANR-00-xxx-0000
					$resANR["Reference"][$nbANR] = $arrayCurl["response"]["docs"][$i]["anrProjectReference_s"][$k];
					//Acronyme du projet
					if(isset($arrayCurl["response"]["docs"][$i]["anrProjectAcronym_s"][$k])) {
						$resANR["Acronyme"][$nbANR] = ucfirst($arrayCurl["response"]["docs"][$i]["anrProjectAcronym_s"][$k]);
					}else{
						$resANR["Acronyme"][$nbANR] = "-";
					}
					//Nombre total de publications pour ce projet et cette année
					if (isset($arrayCurl["response"]["docs"][$i]["anrProjectId_i"][$k])) {
						$urlPub = $cstAPI.$team."/?fq=producedDateY_i:".$year."&fq=anrProjectId_i:".$arrayCurl["response"]["docs"][$i]["anrProjectId_i"][$k]."&rows=10000";
						askCurl($urlPub, $arrayPub, $cstCA);
						$nbTotPub = $arrayPub["response"][$cstNuF];
						$resANR["Nombre"][$nbANR] = $nbTotPub;
						//Liste des publications
						$j = 0;
						$resANR["Liste"][$nbANR] = "";
						$resANR["ListeCSV"][$nbANR] = "";
						while (isset($arrayPub["response"]["docs"][$j])) {
							$uri_s = $arrayPub["response"]["docs"][$j]["uri_s"];
							//Ne mettre un lien que sur l'identifiant HAL
							$tabId = explode("/", $uri_s);
							$idHAL = $tabId[count($tabId)-1];
							$label = str_replace($idHAL, '<a target="_blank" href="'.$uri_s.'">'.$idHAL.'</a>', $arrayPub["response"]["docs"][$j]["label_s"]);
							$resANR["Liste"][$nbANR] .= $label.'<br><br>';
							$resANR["ListeCSV"][$nbANR] .= $arrayPub["response"]["docs"][$j]["label_s"].'   -   ';
							$j++;
						}
						$nbANR++;
					}
				}
				$k++;
			}
		}else{//Pas de référence > on va essayer de la trouver avec funding_s
			if (isset($arrayCurl["response"]["docs"][$i]["funding_s"][0])){
				$k = 0;
				while (isset($arrayCurl["response"]["docs"][$i]["funding_s"][$k])) {//Il y a parfois plusieurs funding_s
					if (strpos($arrayCurl["response"]["docs"][$i]["funding_s"][$k], "ANR-") !== false) {
						$ANRTab = explode(",", $arrayCurl["response"]["docs"][$i]["funding_s"][$k]);
						$j = 0;
						while (isset($ANRTab[$j])) {
							if (strpos($ANRTab[$j], "ANR-") !== false) {//Affichage de la référence
								//echo '<tr><td>'.$nbANR.'</td><td>'.$ANRTab[$j].'</td><td>-</td><td>-</td><td>-</td></tr>';
								$resANR["Reference"][$nbANR] = $ANRTab[$j];
								$resANR["Acronyme"][$nbANR] = "Zzz: à compléter";
								$resANR["Nombre"][$nbANR] = "-";
								$resANR["Liste"][$nbANR] = "-";
								$resANR["ListeCSV"][$nbANR] = "-";
								$nbANR++;
								break;
							}
							$j++;
						}
					}
					$k++;
				}
			}
		}
		$i++;
	}
}
echo '<tbody>';
//var_dump($resANR);
if (count($resANR) > 0) {//Au moins 1 résultat
	//Début de l'affichage
	echo '<table id="basic-datatable" class="table table-hover table-striped table-bordered">';
	echo '<thead class="thead-dark">';
	echo '<tr>';
	echo '<th scope="col" style="text-align:left"></th>';
	echo '<th scope="col" style="text-align:left"><strong>Acronyme</strong></th>';
	echo '<th scope="col" style="text-align:left"><strong>Référence du projet ANR</strong></th>';
	echo '<th scope="col" style="text-align:left"><strong>Nombre de dépôts HAL contenant cette référence</strong></th>';
	echo '<th scope="col" style="text-align:left"><strong>Liste des publications</strong></th>';
	$chaine = "Acronyme;Référence du projet;Nombre de dépôts HAL contenant cette référence;Liste des publications;";
	echo '</tr>';
	$chaine .= chr(13).chr(10);
	fwrite($inF,$chaine);
	echo '</thead>';

	//Classement du tableau par ordre alphabétique des acronymes puis affichage
	array_multisort($resANR["Acronyme"], SORT_ASC, SORT_FLAG_CASE, $resANR["Reference"], $resANR["Nombre"], $resANR["Liste"], $resANR["ListeCSV"]);
	
	//Regroupement des lignes de projets identiques mais d'années différentes
	$resANRfin = array();
	$nbANR = 0;
	$nbANRfin = 0;
	while (isset($resANR["Reference"][$nbANR])) {
		if ($nbANR == 0) {$acro = $resANR["Acronyme"][0];}
		if ($acro == $resANR["Acronyme"][$nbANR] && $acro != "Zzz: à compléter" && $nbANR != 0) {//2 lignes successives avec le même acronyme > regroupement
			$resANRfin["Nombre"][$nbANRfin-1] += $resANR["Nombre"][$nbANR];
			$resANRfin["Liste"][$nbANRfin-1] .= $resANR["Liste"][$nbANR];
			$resANRfin["ListeCSV"][$nbANRfin-1] .= $resANR["ListeCSV"][$nbANR];
		}else{//Nouvel enregistrement dans le tableau final
			$resANRfin["Acronyme"][$nbANRfin] = $resANR["Acronyme"][$nbANR];
			$resANRfin["Reference"][$nbANRfin] = $resANR["Reference"][$nbANR];
			$resANRfin["Nombre"][$nbANRfin] = $resANR["Nombre"][$nbANR];
			$resANRfin["Liste"][$nbANRfin] = $resANR["Liste"][$nbANR];
			$resANRfin["ListeCSV"][$nbANRfin] = $resANR["ListeCSV"][$nbANR];
			$nbANRfin++;
			$acro = $resANR["Acronyme"][$nbANR];
		}
		$nbANR++;
	}
	
	//Affichage du tableau final
	$nbANRfin = 0;
	while (isset($resANRfin["Reference"][$nbANRfin])) {
		$idPro = $nbANRfin + 1;
		echo '<tr><td>'.$idPro.'</td>';
		echo '<td>'.$resANRfin["Acronyme"][$nbANRfin].'</td>';
		$chaine = $resANRfin["Acronyme"][$nbANRfin].";";
		echo '<td>'.$resANRfin["Reference"][$nbANRfin].'</td>';
		$chaine .= $resANRfin["Reference"][$nbANRfin].";";
		echo '<td>'.$resANRfin["Nombre"][$nbANRfin].'</td>';
		$chaine .= $resANRfin["Nombre"][$nbANRfin].";";
		echo '<td>'.$resANRfin["Liste"][$nbANRfin].'</td></tr>';
		$listeCSV = substr($resANRfin["ListeCSV"][$nbANRfin], 0, (strlen($resANRfin["ListeCSV"][$nbANRfin]) - 7));
		$chaine .= str_replace(array('&#x27E8;','&#x27E9;'),array('(',')'), $listeCSV).";";
		$chaine .= chr(13).chr(10);
		fwrite($inF,$chaine);
		$nbANRfin++;
	}
	echo '</tbody>';
	echo '</table><br>';
	
	echo '<a class="btn btn-secondary mt-2" href="./csv/req14.csv">Exporter le tableau au format CSV</a><br><br>';
}else{
	echo $cstNR;
}
?>
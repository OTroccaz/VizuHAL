<?php
//Intitulé
echo '<span class="btn btn-secondary mt-2"><strong>7. Portail ou Collection : Nombre de publications (articles de revue) par revue</strong></span><br><br>';

//Descriptif
echo '<div class="alert alert-secondary">Cette requête présente le nombre d’articles présents dans le portail ou la collection, avec ou sans texte intégral, par revue. <a href="#DT">Voir détails techniques en bas de page</a>.</div><br>';

//Export CSV
$Fnm = "./csv/req7.csv";
$inF = fopen($Fnm,"w+");
fseek($inF, 0);
$chaine = "\xEF\xBB\xBF";
fwrite($inF,$chaine);

$year = $annee7;
$somme = 0;
if (isset($port) && $port != "choix") {
	$team = strtolower($LAB_SECT[0]["secteur"]);
}

$urlHAL = $cstAPI.$team."/?q=*%3A*&rows=0&indent=true&facet=true&facet.pivot=journalTitle_s,journalPublisher_s,journalValid_s&fq=-status_i=111&fq=docType_s:ART&fq=producedDateY_i:".$year;
askCurl($urlHAL, $arrayCurl, $cstCA);
$nbTotArt = $arrayCurl["response"][$cstNuF];
$pivot = "journalTitle_s,journalPublisher_s,journalValid_s";

//Affichage
echo '<div id="cpt"></div>';
echo '<strong>'.$nbTotArt.' publications :</strong>';
echo '<br>';
echo '<table id="basic-datatable" class="table table-hover table-striped table-bordered">';
echo '<thead class="thead-dark">';
echo '<tr>';
echo '<th scope="col" style="text-align:left"><strong>Revues</strong></th>';
echo $cstPUB;
echo $cstART;
echo '<th scope="col" style="text-align:left"><strong>Editeurs</strong></th>';
echo '<th scope="col" style="text-align:left"><strong># texte intégral déposé dans HAL</strong></th>';
echo '<th scope="col" style="text-align:left"><strong>% texte intégral déposé dans HAL</strong></th>';
$chaine = "Revues;Publications;% articles;Editeur;# texte intégral déposé dans HAL;% texte intégral déposé dans HAL;";
echo '</tr>';
$chaine .= chr(13).chr(10);
fwrite($inF,$chaine);
echo '</thead>';
echo '<tbody>';
$rows = count($arrayCurl["facet_counts"]["facet_pivot"][$pivot]);
for ($i=0; $i<count($arrayCurl["facet_counts"]["facet_pivot"][$pivot]); $i++) {
//$rows = 10;//Pour limiter les résultats de la requête
//for ($i=0; $i<$rows; $i++) {
	progression($i, $rows);
	$jTitle = $arrayCurl["facet_counts"]["facet_pivot"][$pivot][$i]["value"];
	$valid = "non";
	if (isset($arrayCurl["facet_counts"]["facet_pivot"][$pivot][$i]["pivot"][0]["pivot"][0]["value"]) && $arrayCurl["facet_counts"]["facet_pivot"][$pivot][$i]["pivot"][0]["pivot"][0]["value"] == "VALID") {$valid = "oui";}
	if ($valid == "oui") {
		$nbTotArtTI = 0;
		$urlTitle = $cstAPI.$team."/?q=*%3A*&rows=0&indent=true&wt=xml&facet=true&facet.pivot=journalTitle_s,journalPublisher_s,journalValid_s&fq=-status_i=111&fq=submitType_s:file&fq=docType_s:ART&fq=journalTitle_s:%22".$jTitle."%22&fq=producedDateY_i:".$year;
		$nbTotArtTI = askCurlNF($urlTitle, $cstCA);
		echo '<tr>';
		$nbTotArti = $arrayCurl["facet_counts"]["facet_pivot"][$pivot][$i]["count"];
		$somme += $nbTotArti;
		echo '<td>'. $arrayCurl["facet_counts"]["facet_pivot"][$pivot][$i]["value"].'</td>';
		echo '<td>'. $nbTotArti.'</td>';
		$pcentArt = ($nbTotArt != 0) ? number_format($nbTotArti*100/$nbTotArt, 2) : 0;
		echo '<td>'.$pcentArt.'%</td>';
		$editeur = "-";
		if (isset($arrayCurl["facet_counts"]["facet_pivot"][$pivot][$i]["pivot"][0]["value"])) {$editeur = $arrayCurl["facet_counts"]["facet_pivot"][$pivot][$i]["pivot"][0]["value"];}
		echo '<td>'. $editeur.'</td>';
		echo '<td>'.$nbTotArtTI.'</td>';
		$pcentArtTI = ($nbTotArti != 0) ? number_format($nbTotArtTI*100/$nbTotArti, 1) : 0;
		echo '<td>'.$pcentArtTI.'%</td>';
		$chaine = $arrayCurl["facet_counts"]["facet_pivot"][$pivot][$i]["value"].";";
		$chaine .= $nbTotArti.";";
		$chaine .= $pcentArt.";";
		$chaine .= $editeur.";";
		$chaine .= $nbTotArtTI.";";
		$chaine .= $pcentArtTI.";";
		echo '</tr>';
		$chaine .= chr(13).chr(10);
		fwrite($inF,$chaine);
	}
}
echo '</tbody>';
echo '</table>';
echo '<script>';
echo '  document.getElementById("cpt").style.display = "none";';
echo '</script>';
//echo $somme.'<br>';

echo '<a class="btn btn-secondary mt-2" href="./csv/req7.csv">Exporter le tableau au format CSV</a><br><br>';
?>
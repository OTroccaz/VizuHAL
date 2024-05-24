<?php
/*
 * VizuHAL - Générez des stats HAL - Generate HAL stats
 *
 * Copyright (C) 2023 Olivier Troccaz (olivier.troccaz@cnrs.fr) and Laurent Jonchère (laurent.jonchere@univ-rennes.fr)
 * Released under the terms and conditions of the GNU General Public License (https://www.gnu.org/licenses/gpl-3.0.txt)
 *
 * Requête 5 - Request 5
 */
 
//Intitulé
echo '<span class="btn btn-secondary mt-2"><strong>5. Portail ou Collection : Nombre de publications de type articles par éditeur</strong></span><br><br>';

//Descriptif
echo '<div class="alert alert-secondary">Cette requête présente le nombre d’articles de revues par éditeur pour une année donnée. Ne sont représentés que les principaux éditeurs et les articles HAL ayant un DOI. Les autres éditeurs sont rassemblés sous l’appellation « Hors regroupement éditorial ». <a href="#DT">Voir détails techniques en bas de page</a>.</div><br>';

//Export CSV
$Fnm = "./csv/req5.csv";
$inF = fopen($Fnm,"w+");
fseek($inF, 0);
$chaine = "\xEF\xBB\xBF";
fwrite($inF,$chaine);

$year = $annee5;
if (isset($port) && $port != "choix") {
	$team = strtolower($LAB_SECT[0]["secteur"]);
}
$spefq = "&fq=-submitType_s:annex";
extractHALnbPubEd_nv($team, $year, "ART", $spefq, $nbTotArt, $nbPubEdRE, $cstCA);
//var_dump($nbPubEdRE);
//Affichage
echo '<br>';
echo '<table id="basic-datatable" class="table table-hover table-striped table-bordered col-9">';
echo '<thead class="thead-dark">';
echo '<tr>';
echo $cstRED;
echo $cstPUB;
echo $cstART;
$chaine = "Regroupement éditorial;Publications;% articles;";
echo '</tr>';
$chaine .= chr(13).chr(10);
fwrite($inF,$chaine);
echo '</thead>';
echo '<tbody>';
for ($i=0; $i<count($nbPubEdRE); $i++) {
	echo '<tr>';
	if ($nbPubEdRE[$i]["editeur_ng"] == "Publications sans indication d'éditeur") {
		$deb = "<em>";
		$fin = "</em>";
	}else{
		$deb = "";
		$fin = "";
	}
	echo '<td>';
	echo $deb.$nbPubEdRE[$i]["editeur_ng"].$fin;
	echo '</td>';
	echo '<td>';
	echo $nbPubEdRE[$i]["nbArt"];
	echo '</td>';
	echo '<td>';
	$pcentArt = ($nbTotArt != 0) ? number_format($nbPubEdRE[$i]["nbArt"]*100/$nbTotArt, 1) : 0;
	echo $pcentArt;
	echo '%</td>';
	$chaine = $nbPubEdRE[$i]["editeur_ng"].";".$nbPubEdRE[$i]["nbArt"].";".$pcentArt.";";
	echo '</tr>';
	$chaine .= chr(13).chr(10);
	fwrite($inF,$chaine);
}
echo '</tbody>';
echo '</table>';

echo '<a class="btn btn-secondary mt-2" href="./csv/req5.csv">Exporter le tableau au format CSV</a><br><br>';
?>
<?php
//Intitulé
echo '<span class="btn btn-secondary mt-2"><strong>6. Portail ou Collection : Nombre de publications de type communications par éditeur</strong></span><br><br>';

//Descriptif
echo '<div class="alert alert-secondary">Cette requête présente le nombre de communications par éditeur pour une année donnée. Ne sont représentés que les principaux éditeurs et les dépôts HAL ayant un DOI. Les autres éditeurs sont rassemblés sous l’appellation « Hors regroupement éditorial ». <a href="#DT">Voir détails techniques en bas de page</a>.</div><br>';

//Export CSV
$Fnm = "./csv/req6.csv";
$inF = fopen($Fnm,"w+");
fseek($inF, 0);
$chaine = "\xEF\xBB\xBF";
fwrite($inF,$chaine);

$year = $annee6;
if (isset($port) && $port != "choix") {
	$team = strtolower($LAB_SECT[0]["secteur"]);
}
$spefq = "&fq=-submitType_s:annex";
extractHALnbPubEd($team, $year, "COMM", $spefq, $nbTotArt, $nbPubEdRE, $cstCA);
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
	if ($nbPubEdRE[$i]["editeur_ng"] == "Hors regroupement éditorial") {
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
	echo '</tr>';
	$chaine = $nbPubEdRE[$i]["editeur_ng"].";".$nbPubEdRE[$i]["nbArt"].";".$pcentArt.";";
	echo '</tr>';
	$chaine .= chr(13).chr(10);
	fwrite($inF,$chaine);
}
echo '</tbody>';
echo '</table>';

echo '<a class="btn btn-secondary mt-2" href="./csv/req6.csv">Exporter le tableau au format CSV</a><br><br>';
?>
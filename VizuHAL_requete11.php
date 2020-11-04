<?php
//Intitulé
echo '<span class="btn btn-secondary mt-2"><strong>11. Collection : Nombre d\'articles avec texte intégral déposé dans HAL par éditeur</strong></span><br><br>';

//Descriptif
echo '<div class="alert alert-secondary">Cette requête présente le nombre d’articles de revue, avec texte intégral, par éditeur et pour une année donnée. Ne sont représentés que les principaux éditeurs et les articles HAL ayant un DOI (à l’exception des éditeurs Dalloz et Lextenso). Les autres éditeurs sont rassemblés sous l’appellation « Hors regroupement éditorial ».  <a href="#DT">Voir détails techniques en bas de page</a>.</div><br>';

//Export CSV
$Fnm = "./csv/req11.csv";
$inF = fopen($Fnm,"w+");
fseek($inF, 0);
$chaine = "\xEF\xBB\xBF";
fwrite($inF,$chaine);

$year = $annee11;

$spefq = "&fq=submitType_s:file";
extractHALnbPubEd($team, $year, "ART", $spefq, $nbTotArt, $nbPubEdRE, $cstCA);
//var_dump($nbPubEdRE);
//Affichage
echo '<br>';
echo '<table id="basic-datatable" class="table table-hover table-striped table-bordered col-9">';
echo '<thead class="thead-dark">';
echo '<tr>';
echo $cstRED;
echo '<th scope="col" style="text-align:left"><strong>Nombre d\'articles avec texte intégral déposé dans HAL</strong></th>';
$chaine = "Regroupement éditorial;Nombre d'articles avec texte intégral déposé dans HAL;";
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
	$chaine = $nbPubEdRE[$i]["editeur_ng"].";".$nbPubEdRE[$i]["nbArt"].";";
	echo '</tr>';
	$chaine .= chr(13).chr(10);
	fwrite($inF,$chaine);
}
echo '</tbody>';
echo '</table>';

echo '<a class="btn btn-secondary mt-2" href="./csv/req11.csv">Exporter le tableau au format CSV</a><br><br>';
?>
<?php
//Intitulé
echo '<br><strong>5. Portail ou Collection : Nombre de publications de type articles par éditeur</strong><br><br>';

//Descriptif
echo '<div style="background-color:#f5f5f5">Cette requête présente le nombre d’articles de revues par éditeur pour une année donnée. Ne sont représentés que les principaux éditeurs et les articles HAL ayant un DOI (à l’exception des éditeurs Dalloz et Lextenso). Les autres éditeurs sont rassemblés sous l’appellation « Hors regroupement éditorial ». <a href="#DT">Voir détails techniques en bas de page</a>.</div><br>';

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
extractHALnbPubEd($team, $year, "ART", $spefq, $nbTotArt, $nbPubEdRE, $cstCA);
//var_dump($nbPubEdRE);
//Affichage
echo '<br><table class="table table-striped table-hover table-responsive table-bordered" style="width:70%;">';
echo '<thead>';
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
	$chaine = $nbPubEdRE[$i]["editeur_ng"].";".$nbPubEdRE[$i]["nbArt"].";".$pcentArt.";";
	echo '</tr>';
	$chaine .= chr(13).chr(10);
	fwrite($inF,$chaine);
}
echo '</tbody>';
echo '</table>';
echo '<a href=\'./csv/req5.csv\'>Exporter le tableau au format CSV</a><br><br>';
?>
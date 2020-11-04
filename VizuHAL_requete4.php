<?php
//Intitulé
echo '<span class="btn btn-secondary mt-2"><strong>4. Portail : ESGBU (stocks et flux)</strong></span><br><br>';

//Descriptif
echo '<div class="alert alert-secondary">Cette requête fournit les 4 premiers indicateurs (stocks et flux) demandés dans l’enquête annuelle ESGBU pour l’archive ouverte. <a href="#DT">Voir détails techniques en bas de page</a>.</div><br>';

//Export CSV
$Fnm = "./csv/req4.csv";
$inF = fopen($Fnm,"w+");
fseek($inF, 0);
$chaine = "\xEF\xBB\xBF";
fwrite($inF,$chaine);

$year = $annee4;
if (isset($port) && $port != "choix") {
	$team = $LAB_SECT[0]["secteur"];
}
//Calculs
$A01 = 0;
$A02 = 0;
$A03 = 0;
$A04 = 0;

$urlHALDep = $cstAPI.strtolower($team)."/?wt=xml&fq=submitType_s:notice&fq=-status_i=111&fq=submittedDate_s:[1600-01-01-%20TO%20".$year."-12-31]&rows=0";
$A01 = askCurlNF($urlHALDep, $cstCA);

$urlHALDep = $cstAPI.strtolower($team)."/?wt=xml&fq=submitType_s:file&fq=-status_i=111&fq=submittedDate_s:[1600-01-01-%20TO%20".$year."-12-31]&rows=0";
$A02 = askCurlNF($urlHALDep, $cstCA);

$urlHALDep = $cstAPI.strtolower($team)."/?wt=xml&fq=submitType_s:notice&fq=-status_i=111&fq=submittedDate_s:[".$year."-01-01-%20TO%20".$year."-12-31]&rows=0";
$A03 = askCurlNF($urlHALDep, $cstCA);

$urlHALDep = $cstAPI.strtolower($team)."/?wt=xml&fq=submitType_s:file&fq=-status_i=111&fq=submittedDate_s:[".$year."-01-01-%20TO%20".$year."-12-31]&rows=0";
$A04 = askCurlNF($urlHALDep, $cstCA);

//Affichage
echo '<br>';
echo '<table class="table table-striped table-hover table-responsive table-bordered" style="width:70%;">';
echo '<thead>';
echo '<tr>';
echo '<th scope="col" colspan="2" style="text-align:left"><strong>STOCKS '.$team.' au 31.12.'.$year.'</strong></th>';
$chaine = "STOCKS ".$team." au 31.12.".$year.";;";
echo '</tr>';
$chaine .= chr(13).chr(10);
fwrite($inF,$chaine);
echo '</thead>';
echo '<tbody>';
echo '<tr>';
echo '<td scope="row" style="text-align:left;background-color:#C6D9F1;">A01 - Nombre d\'unités documentaires référencées dans le système de collecte sous forme de notices uniquement</td>';
$chaine = "A01 - Nombre d'unités documentaires référencées dans le système de collecte sous forme de notices uniquement;";
echo '<td scope="row" style="text-align:left;background-color:#C6D9F1;">'.$A01.'</td>';
$chaine .= $A01.";";
echo '</tr>';
$chaine .= chr(13).chr(10);
fwrite($inF,$chaine);
echo '<tr>';
echo '<td scope="row" style="text-align:left;background-color:#DCE6F2;">A02 - Nombre d\'unités documentaires référencées dans le système de collecte et déposées en texte intégral</td>';
$chaine = "A02 - Nombre d\'unités documentaires référencées dans le système de collecte et déposées en texte intégral;";
echo '<td scope="row" style="text-align:left;background-color:#DCE6F2;">'.$A02.'</td>';
$chaine .= $A02.";";
echo '</tr>';
$chaine .= chr(13).chr(10);
fwrite($inF,$chaine);
echo '<tr><td colspan="2">&nbsp;</td></tr>';
echo '</tbody>';

echo '<thead>';
echo '<tr>';
echo '<th scope="col" colspan="2" style="text-align:left"><strong>FLUX sur l\'année civile '.$year.'</strong></th>';
$chaine = "FLUX sur l'année civile ".$year.";;";
echo '</tr>';
$chaine .= chr(13).chr(10);
fwrite($inF,$chaine);
echo '</thead>';
echo '<tbody>';
echo '<tr>';
echo '<td scope="row" style="text-align:left;background-color:#C6D9F1;">A03 - Accroissement annuel des unités documentaires référencées dans le système de collecte sous forme de notices uniquement</td>';
$chaine = "A03 - Accroissement annuel des unités documentaires référencées dans le système de collecte sous forme de notices uniquement;";
echo '<td scope="row" style="text-align:left;background-color:#C6D9F1;">'.$A03.'</td>';
$chaine .= $A03.";";
echo '</tr>';
$chaine .= chr(13).chr(10);
fwrite($inF,$chaine);
echo '<tr>';
echo '<td scope="row" style="text-align:left;background-color:#DCE6F2;">A04 - Accroissement annuel des unités documentaires référencées dans le système de collecte et déposées en texte intégral</td>';
$chaine = "A04 - Accroissement annuel des unités documentaires référencées dans le système de collecte et déposées en texte intégral;";
echo '<td scope="row" style="text-align:left;background-color:#DCE6F2;">'.$A04.'</td>';
$chaine .= $A04.";";
echo '</tr>';
$chaine .= chr(13).chr(10);
fwrite($inF,$chaine);
echo '</tbody>';

echo '</table>';
echo '<br>';
echo 'Pour les consultations de notices et les téléchargements de fichiers, qu\'on ne peut pas interroger directement via une API, utilisez votre dashboard <a target="_blank" rel="noopener noreferrer" href="https://halstats.archives-ouvertes.fr/app/kibana#/home">Kibana</a> ou le dashboard générique CCSD en recherchant votre portail ("ESGBU 2020 sur les chiffres de l\'année 2019 : Consultations ("Usages"))"';
echo '<br><br>';
echo '<a class="btn btn-secondary mt-2" href="./csv/req4.csv">Exporter le tableau au format CSV</a><br><br>';
?>
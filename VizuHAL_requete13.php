<?php
//Intitulé
echo '<br><strong>13. Portail ou collection : évolution sur une et trois années</strong><br><br>';

//Descriptif
echo '<div style="background-color:#f5f5f5">Cette requête mesure la progression du nombre de dépôts, avec ou sans texte intégral ou avec un lien vers un PDF librement disponible hors de HAL (via <a target="_blank" href="https://unpaywall.org/">Unpaywall</a>), sur 1 et 3 années, à partir de l’année de référence saisie par l’utilisateur. La comparaison 1 / 3 ans permet le cas échéant de relativiser une baisse ou une augmentation sur 1 an, afin de vérifier s’il s’agit d’une tendance de fond, ou au contraire d’un changement circonstanciel. <a href="#DT">Voir détails techniques en bas de page</a>.</div><br>';

function signe($int)
{
	 if( $int > 0 )
			$int = '+' . $int;
	 return $int;
}

//Pourcentages

//Export CSV
$Fnm = "./csv/req13a.csv";
$inF = fopen($Fnm,"w+");
fseek($inF, 0);
$chaine = "\xEF\xBB\xBF";
fwrite($inF,$chaine);


$anneedeb = $annee13;
$anneefin = $annee13 - 3;

for($year = $anneefin; $year <= $anneedeb; $year++) {
	if ($year != $annee13 - 2) {
		extractHAL($team, $year, $reqt, $resHAL, $cstCA);
	}
}

if (isset($resHAL[$annee13-1][$team][$cstNoTI]) && isset($resHAL[$annee13-1][$team][$cstAvTI]) && ($resHAL[$annee13-1][$team][$cstNoTI] + $resHAL[$annee13-1][$team][$cstAvTI]) != 0) {
	$pct1noavTI = round((($resHAL[$annee13][$team][$cstNoTI] + $resHAL[$annee13][$team][$cstAvTI]) - ($resHAL[$annee13-1][$team][$cstNoTI] + $resHAL[$annee13-1][$team][$cstAvTI]))*100/($resHAL[$annee13-1][$team][$cstNoTI] + $resHAL[$annee13-1][$team][$cstAvTI]), 1);
}else{
	$pct1noavTI = 0;
}
if (isset($resHAL[$annee13-1][$team][$cstAvTI]) && $resHAL[$annee13-1][$team][$cstAvTI] != 0) {
	$pct1avTI = round(($resHAL[$annee13][$team][$cstAvTI] - $resHAL[$annee13-1][$team][$cstAvTI])*100/$resHAL[$annee13-1][$team][$cstAvTI], 1);
}else{
	$pct1avTI = 0;
}
if (isset($resHAL[$annee13-1][$team][$cstAvTIAvOA]) && $resHAL[$annee13-1][$team][$cstAvTIAvOA] != 0) {
	$pct1avTIavOA = round(($resHAL[$annee13][$team][$cstAvTIAvOA] - $resHAL[$annee13-1][$team][$cstAvTIAvOA])*100/$resHAL[$annee13-1][$team][$cstAvTIAvOA], 1);
}else{
	$pct1avTIavOA = 0;
}
if (isset($resHAL[$annee13-1][$team][$cstNoTIAvOA]) && $resHAL[$annee13-1][$team][$cstNoTIAvOA] != 0) {
	$pct1noTIavOA = round(($resHAL[$annee13][$team][$cstNoTIAvOA] - $resHAL[$annee13-1][$team][$cstNoTIAvOA])*100/$resHAL[$annee13-1][$team][$cstNoTIAvOA], 1);
}else{
	$pct1noTIavOA = 0;
}

if (isset($resHAL[$annee13-3][$team][$cstNoTI]) && isset($resHAL[$annee13-3][$team][$cstAvTI]) && ($resHAL[$annee13-3][$team][$cstNoTI] + $resHAL[$annee13-3][$team][$cstAvTI]) != 0) {
	$pct3noavTI = round((($resHAL[$annee13][$team][$cstNoTI] + $resHAL[$annee13][$team][$cstAvTI]) - ($resHAL[$annee13-3][$team][$cstNoTI] + $resHAL[$annee13-3][$team][$cstAvTI]))*100/($resHAL[$annee13-3][$team][$cstNoTI] + $resHAL[$annee13-3][$team][$cstAvTI]), 1);
}else{
	$pct3noavTI = 0;
}
if (isset($resHAL[$annee13-3][$team][$cstAvTI]) && $resHAL[$annee13-3][$team][$cstAvTI] != 0) {
	$pct3avTI = round(($resHAL[$annee13][$team][$cstAvTI] - $resHAL[$annee13-3][$team][$cstAvTI])*100/$resHAL[$annee13-3][$team][$cstAvTI], 1);
}else{
	$pct3avTI = 0;
}
if (isset($resHAL[$annee13-3][$team][$cstAvTIAvOA]) && $resHAL[$annee13-3][$team][$cstAvTIAvOA] != 0) {
	$pct3avTIavOA = round(($resHAL[$annee13][$team][$cstAvTIAvOA] - $resHAL[$annee13-3][$team][$cstAvTIAvOA])*100/$resHAL[$annee13-3][$team][$cstAvTIAvOA], 1);
}else{
	$pct3avTIavOA = 0;
}
if (isset($resHAL[$annee13-3][$team][$cstNoTIAvOA]) && $resHAL[$annee13-3][$team][$cstNoTIAvOA] != 0) {
	$pct3noTIavOA = round(($resHAL[$annee13][$team][$cstNoTIAvOA] - $resHAL[$annee13-3][$team][$cstNoTIAvOA])*100/$resHAL[$annee13-3][$team][$cstNoTIAvOA], 1);
}else{
	$pct3noTIavOA = 0;
}

//Export CSV
//Colonnes
$chaine = $team." - ".$annee13.";Sur 1 an;Sur 3 ans;";
$chaine .= chr(13).chr(10);
fwrite($inF,$chaine);

echo '<table class="table table-striped table-hover table-responsive table-bordered">';
echo '<thead>';
echo '<tr>';
echo '<th scope="col"><font color="red">'.$team.' - '.$annee13.'</font></th>';
echo '<th scope="col" colspan="2" style="text-align:center">Sur 1 an</th>';
echo '<th scope="col" colspan="2" style="text-align:center">Sur 3 ans</th>';
echo '</tr>';
echo '</thead>';

echo '<tbody>';

$chaine = "Publications avec ou sans texte intégral déposé dans HAL;";
echo '<tr>';
echo '<th scope="row">Publications avec ou sans texte intégral déposé dans HAL <a class=info onclick=\'return false\' href="#"><img src="./img/pdi.jpg"><span>Nombre total de publications référencées dans HAL. Une baisse peut signaler soit une baisse de la production, soit une baisse du référencement (dépôt par les auteurs et/ou des intermédiaires), soit le cas échéant un problème de <strong>visibilité</strong> de la production dans les bases bibliographiques (WoS, Pubmed, Scopus…), qui peut aussi être lié à un problème de <strong>signature</strong> (affiliation insuffisante ou erronée).</span></a></th>';
($pct1noavTI > 0) ? $img = './img/hausse.png' : (($pct1noavTI < 0) ? $img = './img/baisse.png' : $img = './img/zero.png');
echo '<th scope="row" style="text-align:center"><img src='.$img.'></th>';
echo '<th scope="row" style="text-align:center">'.signe($pct1noavTI).' %</th>';
$chaine .= signe($pct1noavTI)."%;";
($pct3noavTI > 0) ? $img = './img/hausse.png' : (($pct3noavTI < 0) ? $img = './img/baisse.png' : $img = './img/zero.png');
echo '<th scope="row" style="text-align:center"><img src='.$img.'></th>';
echo '<th scope="row" style="text-align:center">'.signe($pct3noavTI).' %</th>';
$chaine .= signe($pct3noavTI)."%;";
echo '</tr>';
$chaine .= chr(13).chr(10);
fwrite($inF,$chaine);

$chaine = "Publications avec texte intégral déposé dans HAL;";
echo '<tr>';
echo '<th scope="row">Publications avec texte intégral déposé dans HAL</th>';
($pct1avTI > 0) ? $img = './img/hausse.png' : (($pct1avTI < 0) ? $img = './img/baisse.png' : $img = './img/zero.png');
echo '<th scope="row" style="text-align:center"><img src='.$img.'></th>';
echo '<th scope="row" style="text-align:center">'.signe($pct1avTI).' %</th>';
$chaine .= signe($pct1avTI)."%;";
($pct3avTI > 0) ? $img = './img/hausse.png' : (($pct3avTI < 0) ? $img = './img/baisse.png' : $img = './img/zero.png');
echo '<th scope="row" style="text-align:center"><img src='.$img.'></th>';
echo '<th scope="row" style="text-align:center">'.signe($pct3avTI).' %</th>';
$chaine .= signe($pct3avTI)."%;";
echo '</tr>';
$chaine .= chr(13).chr(10);
fwrite($inF,$chaine);

$chaine = "Publications avec texte intégral déposé dans HAL + lien externe vers PDF en open access;";
echo '<tr>';
echo '<th scope="row">Publications avec texte intégral déposé dans HAL + lien externe vers PDF en open access <a class=info onclick=\'return false\' href="#"><img src="./img/pdi.jpg"><span>Taux global d’open access : texte intégral déposé dans HAL ou référence HAL avec un lien vers un PDF librement disponible hors de HAL (via Unpaywall > https://unpaywall.org/). </span></a></th>';
($pct1avTIavOA > 0) ? $img = './img/hausse.png' : (($pct1avTIavOA < 0) ? $img = './img/baisse.png' : $img = './img/zero.png');
echo '<th scope="row" style="text-align:center"><img src='.$img.'></th>';
echo '<th scope="row" style="text-align:center">'.signe($pct1avTIavOA).' %</th>';
$chaine .= signe($pct1avTIavOA)."%;";
($pct3avTIavOA > 0) ? $img = './img/hausse.png' : (($pct3avTIavOA < 0) ? $img = './img/baisse.png' : $img = './img/zero.png');
echo '<th scope="row" style="text-align:center"><img src='.$img.'></th>';
echo '<th scope="row" style="text-align:center">'.signe($pct3avTIavOA).' %</th>';
$chaine .= signe($pct3avTIavOA)."%;";
echo '</tr>';
$chaine .= chr(13).chr(10);
fwrite($inF,$chaine);

$chaine = "Publications sans texte intégral déposé dans HAL + lien externe vers PDF en open access;";
echo '<tr>';
echo '<th scope="row">Publications sans texte intégral déposé dans HAL + lien externe vers PDF en open access <a class=info onclick=\'return false\' href="#"><img src="./img/pdi.jpg"><span>Références HAL sans texte intégral, mais avec un lien vers l’article en open access sur le site de la revue. Une baisse peut simplement signifier que les auteurs ont ajouté massivement dans HAL le PDF de ces articles. Une hausse peut également signifier un recours accru à la publication dans des revues en open access, et/ou au paiement de frais de mise en open access des articles.</span></a></th>';
($pct1noTIavOA > 0) ? $img = './img/hausse.png' : (($pct1noTIavOA < 0) ? $img = './img/baisse.png' : $img = './img/zero.png');
echo '<th scope="row" style="text-align:center"><img src='.$img.'></th>';
echo '<th scope="row" style="text-align:center">'.signe($pct1noTIavOA).' %</th>';
$chaine .= signe($pct1noTIavOA)."%;";
($pct3noTIavOA > 0) ? $img = './img/hausse.png' : (($pct3noTIavOA < 0) ? $img = './img/baisse.png' : $img = './img/zero.png');
echo '<th scope="row" style="text-align:center"><img src='.$img.'></th>';
echo '<th scope="row" style="text-align:center">'.signe($pct3noTIavOA).' %</th>';
$chaine .= signe($pct3noTIavOA)."%;";
echo '</tr>';
$chaine .= chr(13).chr(10);
fwrite($inF,$chaine);

echo '</tbody>';
echo '</table>';

echo '<a href=\'./csv/req13a.csv\'>Exporter le tableau au format CSV</a><br><br>';


//Valeurs

//Export CSV
$Fnm = "./csv/req13b.csv";
$inF = fopen($Fnm,"w+");
fseek($inF, 0);
$chaine = "\xEF\xBB\xBF";
fwrite($inF,$chaine);


$anneedeb = $annee13;
$anneefin = $annee13 - 3;

for($year = $anneefin; $year <= $anneedeb; $year++) {
	if ($year != $annee13 - 2) {
		extractHAL($team, $year, $reqt, $resHAL, $cstCA);
	}
}

//Export CSV
//Colonnes
$chaine = $team." - ".$annee13.";Sur 1 an;Sur 3 ans;";
$chaine .= chr(13).chr(10);
fwrite($inF,$chaine);

echo '<table class="table table-striped table-hover table-responsive table-bordered">';
echo '<thead>';
echo '<tr>';
echo '<th scope="col"><font color="red">'.$team.' - '.$annee13.'</font></th>';
echo '<th scope="col" style="text-align:center">'.($annee13 - 3).'</th>';
echo '<th scope="col" style="text-align:center">'.($annee13 - 1).'</th>';
echo '<th scope="col" style="text-align:center">'.$annee13.'</th>';
echo '</tr>';
echo '</thead>';

echo '<tbody>';

$chaine = "Publications avec ou sans texte intégral déposé dans HAL;";
echo '<tr>';
echo '<th scope="row">Publications avec ou sans texte intégral déposé dans HAL</th>';
echo '<th scope="row" style="text-align:center">'.($resHAL[$annee13-3][$team][$cstNoTI] + $resHAL[$annee13-3][$team][$cstAvTI]).'</th>';
$chaine .= ($resHAL[$annee13-3][$team][$cstNoTI] + $resHAL[$annee13-3][$team][$cstAvTI]).";";
echo '<th scope="row" style="text-align:center">'.($resHAL[$annee13-1][$team][$cstNoTI] + $resHAL[$annee13-1][$team][$cstAvTI]).'</th>';
$chaine .= ($resHAL[$annee13-1][$team][$cstNoTI] + $resHAL[$annee13-1][$team][$cstAvTI]).";";
echo '<th scope="row" style="text-align:center">'.($resHAL[$annee13][$team][$cstNoTI] + $resHAL[$annee13][$team][$cstAvTI]).'</th>';
$chaine .= ($resHAL[$annee13][$team][$cstNoTI] + $resHAL[$annee13][$team][$cstAvTI]).";";
echo '</tr>';
$chaine .= chr(13).chr(10);
fwrite($inF,$chaine);

$chaine = "Publications avec texte intégral déposé dans HAL;";
echo '<tr>';
echo '<th scope="row">Publications avec texte intégral déposé dans HAL</th>';		
echo '<th scope="row" style="text-align:center">'.$resHAL[$annee13-3][$team][$cstAvTI].'</th>';
$chaine .= $resHAL[$annee13-3][$team][$cstAvTI].";";
echo '<th scope="row" style="text-align:center">'.$resHAL[$annee13-1][$team][$cstAvTI].'</th>';
$chaine .= $resHAL[$annee13-1][$team][$cstAvTI].";";
echo '<th scope="row" style="text-align:center">'.$resHAL[$annee13][$team][$cstAvTI].'</th>';
$chaine .= $resHAL[$annee13][$team][$cstAvTI].";";
echo '</tr>';
$chaine .= chr(13).chr(10);
fwrite($inF,$chaine);

$chaine = "Publications avec texte intégral déposé dans HAL + lien externe vers PDF en open access;";
echo '<tr>';
echo '<th scope="row">Publications avec texte intégral déposé dans HAL + lien externe vers PDF en open access</th>';
echo '<th scope="row" style="text-align:center">'.$resHAL[$annee13-3][$team][$cstAvTIAvOA].'</th>';
$chaine .= $resHAL[$annee13-3][$team][$cstAvTIAvOA].";";
echo '<th scope="row" style="text-align:center">'.$resHAL[$annee13-1][$team][$cstAvTIAvOA].'</th>';
$chaine .= $resHAL[$annee13-1][$team][$cstAvTIAvOA].";";
echo '<th scope="row" style="text-align:center">'.$resHAL[$annee13][$team][$cstAvTIAvOA].'</th>';
$chaine .= $resHAL[$annee13][$team][$cstAvTIAvOA].";";
echo '</tr>';
$chaine .= chr(13).chr(10);
fwrite($inF,$chaine);

$chaine = "Publications sans texte intégral déposé dans HAL + lien externe vers PDF en open access;";
echo '<tr>';
echo '<th scope="row">Publications sans texte intégral déposé dans HAL + lien externe vers PDF en open access</th>';
echo '<th scope="row" style="text-align:center">'.$resHAL[$annee13-3][$team][$cstNoTIAvOA].'</th>';
$chaine .= $resHAL[$annee13-3][$team][$cstNoTIAvOA].";";
echo '<th scope="row" style="text-align:center">'.$resHAL[$annee13-1][$team][$cstNoTIAvOA].'</th>';
$chaine .= $resHAL[$annee13-1][$team][$cstNoTIAvOA].";";
echo '<th scope="row" style="text-align:center">'.$resHAL[$annee13][$team][$cstNoTIAvOA].'</th>';
$chaine .= $resHAL[$annee13][$team][$cstNoTIAvOA].";";
echo '</tr>';
$chaine .= chr(13).chr(10);
fwrite($inF,$chaine);

echo '</tbody>';
echo '</table>';

echo '<a href=\'./csv/req13b.csv\'>Exporter le tableau au format CSV</a><br><br>';
?>
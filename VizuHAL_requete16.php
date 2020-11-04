<?php
//Intitulé
echo '<span class="btn btn-secondary mt-2"><strong>16. Collection : Profil des contributeurs HAL</strong></span><br><br>';

//Descriptif
echo '<div class="alert alert-secondary">Cette requête affiche, pour une collection et une période donnée (date de dépôt), la liste des contributeurs classée par nombre de dépôts (références, texte intégral, données de recherche), ainsi que le portail de dépôt. A noter que les contributions secondaires (ajout d’un fichier) ne sont pas créditées par HAL : c’est toujours le nom du premier contributeur qui est remonté. <a href="#DT">Voir détails techniques en bas de page</a>.</div><br>';

include("./VizuHAL_Portails-SID.php");

/*
//Tri par défaut
$ntdTri = "SORT_DESC";
$nomTri = "";
$ndrTri = "";
$ndtTri = "";
$nddTri = "";
$ntdUrl = "ntdAsc";
$nomUrl = "nomAsc";
$ndrUrl = "ndrAsc";
$ndtUrl = "ndtAsc";
$nddUrl = "nddAsc";

//Recherche des éventuelles demandes de tri
$ordr = (isset($_GET["ordr"])) ? $_GET["ordr"] : "";//Tri demandé
if ($ordr != "") {
	if (strpos($ordr, "ntd") !== false) {//Sur nombre total de dépôts
		if ($ordr == "ntdAsc") {$ntdTri = "SORT_ASC"; $ntdUrl = "ntdDes";}else{$ntdTri = "SORT_DESC"; $ntdUrl = "ntdAsc";}
	}
	if (strpos($ordr, "nom") !== false) {//Sur le nom du contributeur
		if ($ordr == "nomAsc") {$nomTri = "SORT_ASC"; $ntdTri = ""; $nomUrl = "nomDes";}else{$nomTri = "SORT_DESC"; $ntdTri = ""; $nomUrl = "nomAsc";}
	}
	if (strpos($ordr, "ndr") !== false) {//Sur le nombre de dépôts (références)
		if ($ordr == "ndrAsc") {$ndrTri = "SORT_ASC"; $ntdTri = ""; $ndrUrl = "ndrDes";}else{$ndrTri = "SORT_DESC"; $ntdTri = ""; $ndrUrl = "ndrAsc";}
	}
	if (strpos($ordr, "ndt") !== false) {//Sur le nombre de dépôts (texte intégral)
		if ($ordr == "ndtAsc") {$ndtTri = "SORT_ASC"; $ntdTri = ""; $ndtUrl = "ndtDes";}else{$ndtTri = "SORT_DESC"; $ntdTri = ""; $ndtUrl = "ndtAsc";}
	}
	if (strpos($ordr, "ndd") !== false) {//Sur le nombre de dépôts (données de recherche)
		if ($ordr == "nddAsc") {$nddTri = "SORT_ASC"; $ntdTri = ""; $nddUrl = "nddDes";}else{$nddTri = "SORT_DESC"; $ntdTri = ""; $nddUrl = "nddAsc";}
	}
}
*/

//Export CSV
$Fnm = "./csv/req16.csv";
$inF = fopen($Fnm,"w+");
fseek($inF, 0);
$chaine = "\xEF\xBB\xBF";
fwrite($inF,$chaine);

$LAB_SECT = array();

if (isset($port) && $port != "choix") {
	include('./Port'.$port.'.php');
}else{
	$LAB_SECT[0]["code_collection"] = $team;
}

//Création d'un tableau regroupant les différentes années et différentes collections
$ctbTot = array();
$nbTotCtb = 0;
$ctb = 0;
$col = 0;

while (isset($LAB_SECT[$col]["code_collection"])) {
	for ($year = $anneedeb; $year <= $anneefin; $year++) {
		$urlHAL = $cstAPI.$LAB_SECT[$col]["code_collection"]."/?fq=submittedDateY_i:".$year."&fl=contributorFullName_s,submittedDate_s,submitType_s,halId_s,sid_i&rows=10000&sort=contributorFullName_s%20desc";
		askCurl($urlHAL, $arrayCtb, $cstCA);
		$nbTotCtb += $arrayCtb["response"][$cstNuF];
		for ($i=0; $i<$arrayCtb["response"][$cstNuF]; $i++) {
			if (isset($arrayCtb["response"]["docs"][$i]["contributorFullName_s"])) {//Nom du contributeur parfois non renseigné
				$ctbTot["nom"][$ctb] = $arrayCtb["response"]["docs"][$i]["contributorFullName_s"];
				$ctbTot["typ"][$ctb] = $arrayCtb["response"]["docs"][$i]["submitType_s"];
				$ctbTot["sid"][$ctb] = strval($arrayCtb["response"]["docs"][$i]["sid_i"]);
				$ctb++;
			}else{
				$nbTotCtb -= 1;
			}
		}
	}
	$col++;
}

if ($nbTotCtb != 0) {//Au moins 1 résultat
	//Classement du tableau par contributeur par ordre croissant
	array_multisort($ctbTot["nom"], SORT_ASC, $ctbTot["typ"], $ctbTot["sid"]);
}

if ($nbTotCtb != 0) {//Au moins 1 résultat
	//Affichage
	//$speCode = '<a href="?reqt=req16&port='.$port.'&team='.$team.'&anneedeb='.$anneedeb.'&anneefin='.$anneefin;
	echo '<br>';
	echo '<table id="basic-datatable" class="table table-hover table-striped table-bordered col-12">';
	echo '<thead class="thead-dark">';
	echo '<tr>';
	//echo $cstTS1.$speCode.'&ordr='.$nomUrl.'">Nom du contributeur</a></strong></th>';
	echo $cstTS1.'Nom du contributeur</strong></th>';
	//echo $cstTS1.$speCode.'&ordr='.$ntdUrl.'">Nombre total de dépôts</a></strong></th>';
	echo $cstTS1.'Nombre total de dépôts</strong></th>';
	//echo $cstTS1.$speCode.'&ordr='.$ndrUrl.'">Nombre de dépôts (références)</a></strong></th>';
	echo $cstTS1.'Nombre total de dépôts (références)</strong></th>';
	//echo $cstTS1.$speCode.'&ordr='.$ndtUrl.'">Nombre de dépôts (texte intégral)</a></strong></th>';
	echo $cstTS1.'Nombre total de dépôts (texte intégral)</strong></th>';
	//echo $cstTS1.$speCode.'&ordr='.$nddUrl.'">Nombre de dépôts (données de recherche)</a></strong></th>';
	echo $cstTS1.'Nombre total de dépôts (données de recherche)</strong></th>';
	echo '<th scope="col" style="text-align:left"><strong>Portail(s) de dépôt</strong></th>';
	$chaine = "Nom du contributeur;Nombre total de dépôts;Nombre de dépôts (références);Nombre de dépôts (texte intégral);Nombre de dépôts (données de recherche);Portail(s) de dépôt;";
	echo '</tr>';
	$chaine .= chr(13).chr(10);
	fwrite($inF,$chaine);
	echo '</thead>';
	echo '<tbody>';

	//Création d'un tableau regroupant les contributeurs et le nombre de dépôts
	$ctbDep = array();
	$ctb = 0;
	for ($i=0; $i<$nbTotCtb; $i++) {
		//Regroupement des lignes de contributeurs identiques mais d'années différentes
		if ($ctb == 0) {$nom = $ctbTot["nom"][$i]; $ctbDep["txt"][$ctb] = 0; $ctbDep["ref"][$ctb] = 0; $ctbDep["anx"][$ctb] = 0; $ctbDep["tot"][$ctb] = 0;}
		if ($nom == $ctbTot["nom"][$i] && $ctb != 0) {//2 lignes successives avec le même contributeur > regroupement
			($ctbTot["typ"][$i] == "file") ? $ctbDep["txt"][$ctb-1] += 1 : (($ctbTot["typ"][$i] == "notice") ? $ctbDep["ref"][$ctb-1] += 1 : $ctbDep["anx"][$ctb-1] += 1);
			$ctbDep["tot"][$ctb-1] += 1;
			if (strpos($ctbDep["ptl"][$ctb-1], strval($ctbTot["sid"][$i])) === false) {$ctbDep["ptl"][$ctb-1] .= "~n°".strval($ctbTot["sid"][$i]);}
		}else{//Nouvel enregistrement dans le tableau final
			$ctbDep["nom"][$ctb] = $ctbTot["nom"][$i];
			if ($ctbTot["typ"][$i] == "file") {
				$ctbDep["txt"][$ctb] = 1;
				$ctbDep["ref"][$ctb] = 0;
				$ctbDep["anx"][$ctb] = 0;
			}else{
				if ($ctbTot["typ"][$i] == "notice") {
					$ctbDep["txt"][$ctb] = 0;
					$ctbDep["ref"][$ctb] = 1;
					$ctbDep["anx"][$ctb] = 0;
				}else{
					$ctbDep["txt"][$ctb] = 0;
					$ctbDep["ref"][$ctb] = 0;
					$ctbDep["anx"][$ctb] = 1;
				}
			}
			$ctbDep["tot"][$ctb] = 1;
			$ctbDep["ptl"][$ctb] = "n°".strval($ctbTot["sid"][$i]);
			$ctb++;
			$nom = $ctbTot["nom"][$i];
		}
	}
	
	for ($i=0; $i<count($ctbDep["ptl"]); $i++) {//Remplacement des SID portails par leur véritable intitulé
		$tabPtl = explode("~", $ctbDep["ptl"][$i]);
		for ($j=0; $j<count($tabPtl); $j++) {
			if (array_key_exists(strval($tabPtl[$j]), $SID_i)) {
				$ctbDep["ptl"][$i] = str_replace($tabPtl[$j], $SID_i[$tabPtl[$j]], $ctbDep["ptl"][$i]);
			}
		}
		$ctbDep["ptl"][$i] = str_replace(array("~", "n°"), array("<br>", ""), $ctbDep["ptl"][$i]);
	}

	/*
	//Initialement, classement du tableau par nombre total de dépôts ordre décroissant puis affichage
	if ($ntdTri == "SORT_ASC") {array_multisort($ctbDep["tot"], SORT_ASC, SORT_NUMERIC, $ctbDep["nom"], $ctbDep["txt"], $ctbDep["ref"], $ctbDep["anx"], $ctbDep["ptl"]);}
	if ($ntdTri == "SORT_DESC") {array_multisort($ctbDep["tot"], SORT_DESC, SORT_NUMERIC, $ctbDep["nom"], $ctbDep["txt"], $ctbDep["ref"], $ctbDep["anx"], $ctbDep["ptl"]);}
	if ($nomTri == "SORT_ASC") {array_multisort($ctbDep["nom"], SORT_ASC, SORT_STRING, $ctbDep["tot"], $ctbDep["txt"], $ctbDep["ref"], $ctbDep["anx"], $ctbDep["ptl"]);}
	if ($nomTri == "SORT_DESC") {array_multisort($ctbDep["nom"], SORT_DESC, SORT_STRING, $ctbDep["tot"], $ctbDep["txt"], $ctbDep["ref"], $ctbDep["anx"], $ctbDep["ptl"]);}
	if ($ndrTri == "SORT_ASC") {array_multisort($ctbDep["ref"], SORT_ASC, SORT_NUMERIC, $ctbDep["tot"], $ctbDep["nom"], $ctbDep["txt"], $ctbDep["anx"], $ctbDep["ptl"]);}
	if ($ndrTri == "SORT_DESC") {array_multisort($ctbDep["ref"], SORT_DESC, SORT_NUMERIC, $ctbDep["tot"], $ctbDep["nom"], $ctbDep["txt"], $ctbDep["anx"], $ctbDep["ptl"]);}
	if ($ndtTri == "SORT_ASC") {array_multisort($ctbDep["txt"], SORT_ASC, SORT_NUMERIC, $ctbDep["tot"], $ctbDep["nom"], $ctbDep["ref"], $ctbDep["anx"], $ctbDep["ptl"]);}
	if ($ndtTri == "SORT_DESC") {array_multisort($ctbDep["txt"], SORT_DESC, SORT_NUMERIC, $ctbDep["tot"], $ctbDep["nom"], $ctbDep["ref"], $ctbDep["anx"], $ctbDep["ptl"]);}
	if ($nddTri == "SORT_ASC") {array_multisort($ctbDep["anx"], SORT_ASC, SORT_NUMERIC, $ctbDep["tot"], $ctbDep["nom"], $ctbDep["txt"], $ctbDep["ref"], $ctbDep["ptl"]);}
	if ($nddTri == "SORT_DESC") {array_multisort($ctbDep["anx"], SORT_DESC, SORT_NUMERIC, $ctbDep["tot"], $ctbDep["nom"], $ctbDep["txt"], $ctbDep["ref"], $ctbDep["ptl"]);}
	//array_multisort($ctbDep["anx"], SORT_ASC, SORT_NUMERIC, $ctbDep["tot"], $ctbDep["nom"], $ctbDep["ref"], $ctbDep["txt"], $ctbDep["ptl"]);
	*/

	for ($i=0; $i<count($ctbDep["nom"]); $i++) {
		echo '<tr>';
		echo '<td>'. $ctbDep["nom"][$i].'</td>';
		$chaine = $ctbDep["nom"][$i].";";
		echo '<td>'. $ctbDep["tot"][$i].'</td>';
		$chaine .= $ctbDep["tot"][$i].";";
		echo '<td>'. $ctbDep["ref"][$i].'</td>';
		$chaine .= $ctbDep["ref"][$i].";";
		echo '<td>'. $ctbDep["txt"][$i].'</td>';
		$chaine .= $ctbDep["txt"][$i].";";
		echo '<td>'. $ctbDep["anx"][$i].'</td>';
		$chaine .= $ctbDep["anx"][$i].";";
		echo '<td>'. $ctbDep["ptl"][$i].'</td>';
		$chaine .= $ctbDep["ptl"][$i].";";
		echo '</tr>';
		$chaine .= chr(13).chr(10);
		fwrite($inF,$chaine);
	}
	
	echo '</tbody>';
	echo '</table>';
	
	echo '<a class="btn btn-secondary mt-2" href="./csv/req16.csv">Exporter le tableau au format CSV</a><br><br>';
}else{
	echo $cstNR;
}
?>
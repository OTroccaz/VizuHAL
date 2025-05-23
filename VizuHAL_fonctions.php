<?php
/*
 * VizuHAL - Générez des stats HAL - Generate HAL stats
 *
 * Copyright (C) 2023 Olivier Troccaz (olivier.troccaz@cnrs.fr) and Laurent Jonchère (laurent.jonchere@univ-rennes.fr)
 * Released under the terms and conditions of the GNU General Public License (https://www.gnu.org/licenses/gpl-3.0.txt)
 *
 * Fonctions utilisées - Functions used
 */
 
register_shutdown_function(function() {
    $error = error_get_last();

    if (isset($error['type']) && isset($error['message'])) {
			if ($error['type'] === E_ERROR && strpos($error['message'], 'Maximum execution time of') === 0) {
					echo "<br><strong><font color='red'>Le script a été arrêté car son temps d'exécution dépasse la limite maximale autorisée.</font></strong><br>";
			}
		}
});

if (!function_exists("array_column")) {
	function array_column($array,$column_name) {
		return array_map(function($element) use($column_name){return $element[$column_name];}, $array);
  }
}

function progression($indice, $iMax) {	
	echo "<script>";
  echo "var txt = 'Traitement revue $indice sur $iMax<br>';";
	echo "document.getElementById('cpt').innerHTML = txt";
	echo "</script>";
	ob_flush();
	flush();
	ob_flush();
	flush();
}
function array_orderby() {
  $args = func_get_args();
  $data = array_shift($args);
  foreach ($args as $n => $field) {
		if (is_string($field)) {
			$tmp = array();
			foreach ($data as $key => $row) {
				$tmp[$key] = $row[$field];
				$args[$n] = $tmp;
			}
		}
  }
  $args[] = &$data;
  call_user_func_array('array_multisort', $args);
  return array_pop($args);
}

function objectToArray($object) {
  if(!is_object( $object) && !is_array($object)) {
    return $object;
  }
  if(is_object($object)) {
    $object = get_object_vars($object);
  }
  return array_map('objectToArray', $object);
}

function askCurl($url, &$arrayCurl, $cstCA) {
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, $url);
  curl_setopt($ch, CURLOPT_HEADER, 0);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($ch, CURLOPT_USERAGENT, 'SCD (https://halur.univ-rennes.fr)');
  if (isset ($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] == "on")	{
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
		curl_setopt($ch, CURLOPT_CAINFO, "cacert.pem");
	}else{
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	}
  $json = curl_exec($ch);
  curl_close($ch);
  
  $memory = intval(ini_get('memory_limit')) * 1024 * 1024;
  $limite = strlen($json)*10;
  if ($limite > $memory) {
    die ('<strong><font color="red">Désolé ! La collection et/ou la période choisie génère(nt) trop de résultats pour être traités correctement.</font></strong>');
  }else{
    $parsed_json = json_decode($json, true);
    $arrayCurl = objectToArray($parsed_json);
  }
}

function askCurlNF($url, $cstCA) {
  $url = str_replace(" ", "%20", $url);
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, $url);
  curl_setopt($ch, CURLOPT_HEADER, 0);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($ch, CURLOPT_USERAGENT, 'SCD (https://halur.univ-rennes.fr)');
	if (isset ($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] == "on")	{
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, TRUE);
		curl_setopt($ch, CURLOPT_CAINFO, $cstCA);
	}else{
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	}
  $json = curl_exec($ch);
  curl_close($ch);

  $memory = intval(ini_get('memory_limit')) * 1024 * 1024;
  $limite = strlen($json)*10;
  if ($limite > $memory) {
    die ('<strong><font color="red">Désolé ! La collection et/ou la période choisie génère(nt) trop de résultats pour être traités correctement.</font></strong>');
  }else{
    if (!empty($json)) {
      $dom = new DOMDocument();
      $dom->loadXML($json);
			if ($dom->getElementsByTagName('result')->item(0) && $dom->getElementsByTagName('result')->item(0)->hasAttribute('numFound')) {
				$qte = $dom->getElementsByTagName('result')->item(0)->getAttribute('numFound');
			}else{
				$qte = 0;
			}
    }else{
      $qte = 0;
    }
  }
  
  return $qte;
}

function extractHAL($team, $year, $reqt, &$resHAL, $cstCA) {
	$cstAPI = "https://api.archives-ouvertes.fr/search/";
	$cstNfD = "nfDep";
	$cstNoTI = "nfPronoTI";
	$cstAvTI = "nfProavTI";
	$cstNoTIAvOA = "nfPronoTIavOA";
	$cstAvTIAvOA = "nfProavTIavOA";
  if ($reqt == "req3" || $reqt == "req24" || $reqt == "req25") {
    $dT = "&fq=docType_s:ART";
  }else{
    $dT = "";
  }
  
  //Dépôts par année de publication
  $urlHALDep = $cstAPI.$team."/?wt=xml&fq=producedDateY_i:".$year.$dT."&facet=true&facet.pivot=producedDateY_i,submitType_s&rows=0";
  $qte = askCurlNF($urlHALDep, $cstCA);
  $resHAL[$year][strtoupper($team)][$cstNfD] = $qte;
  
  //notices sans TI
  $urlHALPronoTI = $cstAPI.$team."/?wt=xml&fq=producedDateY_i:".$year."&fq=submitType_s:notice".$dT."&fq=-status_i=111&rows=0";
  $qte = askCurlNF($urlHALPronoTI, $cstCA);
  $resHAL[$year][strtoupper($team)][$cstNoTI] = $qte;
  
  //Manuscrits plein texte avec TI
  $urlHALProavTI = $cstAPI.$team."/?wt=xml&fq=producedDateY_i:".$year."&fq=submitType_s:file".$dT."&fq=-status_i=111&rows=0";
  $qte = askCurlNF($urlHALProavTI, $cstCA);
  $resHAL[$year][strtoupper($team)][$cstAvTI] = $qte;
  
  //notices avec lien open access, sans TI déposé dans HAL mais avec TI librement accessible hors HAL
  $urlHALPronoTIavOA = $cstAPI.$team."/?wt=xml&fq=producedDateY_i:".$year."&fq=linkExtId_s:*&fq=-linkExtId_s:istex".$dT."&fq=-status_i=111&fq=-submitType_s:file&rows=0";
	$qte = askCurlNF($urlHALPronoTIavOA, $cstCA);
  $resHAL[$year][strtoupper($team)][$cstNoTIAvOA] = $qte;
  
  //Manuscrits et lien open access avec TI déposé dans HAL ou librement accessible hors HAL
  $urlHALProavTIavOA = $cstAPI.$team."/?wt=xml&fq=producedDateY_i:".$year."&fq=(submitType_s:file OR linkExtId_s:*)&fq=-linkExtId_s:istex".$dT."&fq=-status_i=111&rows=0";
	$qte = askCurlNF($urlHALProavTIavOA, $cstCA);
  $resHAL[$year][strtoupper($team)][$cstAvTIAvOA] = $qte;
}

function extractHAL1($team, $year, $reqt, &$resHAL, $cstCA) {
	$cstAPI = "https://api.archives-ouvertes.fr/search/";
	$cstNfD = "nfDep";
	$cstNoTI = "nfPronoTI";
	$cstAvTI = "nfProavTI";
	$cstNoTIAvOA = "nfPronoTIavOA";
	$cstAvTIAvOA = "nfProavTIavOA";
  if ($reqt == "req3" || $reqt == "req24" || $reqt == "req25") {
    $dT = "&fq=docType_s:ART";
  }else{
    $dT = "";
  }
  
  //Dépôts par année de publication
  $urlHALDep = $cstAPI.$team."/?wt=xml&fq=producedDateY_i:".$year."&fq=submitType_s:(notice OR file)".$dT."&fq=-status_i=111&rows=0";
  $qte = askCurlNF($urlHALDep, $cstCA);
  $resHAL[$year][strtoupper($team)][$cstNfD] = $qte;
  
  //notices sans TI
  $urlHALPronoTI = $cstAPI.$team."/?wt=xml&fq=producedDateY_i:".$year."&fq=submitType_s:notice".$dT."&fq=-status_i=111&rows=0";
  $qte = askCurlNF($urlHALPronoTI, $cstCA);
  $resHAL[$year][strtoupper($team)][$cstNoTI] = $qte;
  
  //Manuscrits plein texte avec TI
  $urlHALProavTI = $cstAPI.$team."/?wt=xml&fq=producedDateY_i:".$year."&fq=submitType_s:file".$dT."&fq=-status_i=111&rows=0";
  $qte = askCurlNF($urlHALProavTI, $cstCA);
  $resHAL[$year][strtoupper($team)][$cstAvTI] = $qte;
  
  //notices avec lien open access, sans TI déposé dans HAL mais avec TI librement accessible hors HAL
  $urlHALPronoTIavOA = $cstAPI.$team."/?wt=xml&fq=producedDateY_i:".$year."&fq=linkExtId_s:*&fq=-linkExtId_s:istex".$dT."&fq=-status_i=111&fq=-submitType_s:file&rows=0";
	$qte = askCurlNF($urlHALPronoTIavOA, $cstCA);
  $resHAL[$year][strtoupper($team)][$cstNoTIAvOA] = $qte;
  
  //Manuscrits et lien open access avec TI déposé dans HAL ou librement accessible hors HAL
  $urlHALProavTIavOA = $cstAPI.$team."/?wt=xml&fq=producedDateY_i:".$year."&fq=(submitType_s:file OR linkExtId_s:*)&fq=-linkExtId_s:istex".$dT."&fq=-status_i=111&rows=0";
	$qte = askCurlNF($urlHALProavTIavOA, $cstCA);
  $resHAL[$year][strtoupper($team)][$cstAvTIAvOA] = $qte;
}

function var_dump_pre($mixed = null) {
  echo '<pre>';
  var_dump($mixed);
  echo '</pre>';
  return null;
}

function extractHALnbPubEd_nv($team, $year, $type, $spefq, &$nbTotArt, &$nbPubEdRE, $cstCA) {
	$nbPubEdRE = array();//Regroupement éditorial
	$cstAPI = "https://api.archives-ouvertes.fr/search/";
	
	$urlHAL = $cstAPI.$team."/?fq=producedDateY_i:".$year.$spefq."&fq=-status_i=111&fq=docType_s:".$type."&fl=label_s,doiId_s,journalPublisher_s&rows=100000";
	askCurl($urlHAL, $arrayCurl, $cstCA);
	
	$nbTotArt = $arrayCurl["response"]["numFound"];
	$i = 0;
	$j = 0;
	while (isset($arrayCurl["response"]["docs"][$i])) {
		if (isset($arrayCurl["response"]["docs"][$i]["journalPublisher_s"])) {
			$eds = array_column($nbPubEdRE, "editeur_ng");
			$found_key = array_search($arrayCurl["response"]["docs"][$i]["journalPublisher_s"], $eds);
			//L'éditeur est-il déjà présent dans le tableau ?
			if ($found_key != '') {
				$nbPubEdRE[$found_key]["nbArt"] += 1;
			}else{
				$nbPubEdRE[$j]["editeur_ng"] = $arrayCurl["response"]["docs"][$i]["journalPublisher_s"];
				$nbPubEdRE[$j]["nbArt"] = 1;
				$j++;
			}
		}else{
			$eds = array_column($nbPubEdRE, "editeur_ng");
			$found_key = array_search("Publications sans indication d'éditeur", $eds);
			if ($found_key != '') {
				$nbPubEdRE[$found_key]["nbArt"] += 1;
			}else{
				$nbPubEdRE[$j]["editeur_ng"] = "Publications sans indication d'éditeur";
				$nbPubEdRE[$j]["nbArt"] = 1;
				$j++;
			}
		}
		$i++;
	}
	//var_dump_pre($nbPubEdRE);
	$nbPubEdRE = array_orderby($nbPubEdRE, 'nbArt', SORT_DESC);
}
	
function extractHALnbPubEd($team, $year, $type, $spefq, &$nbTotArt, &$nbPubEdRE, $cstCA) {
	$nbPubEd = array();
	$nbPubEdRE = array();//Regroupement éditorial
	$cstAPI = "https://api.archives-ouvertes.fr/search/";
	include("./VizuHAL_Prefixe_DOI.php");
	$i = 0;
	//for ($i=0; $i<=10; $i++) {
	for ($i=0; $i<count($Prefixe_DOI); $i++) {
		$pDOI = $Prefixe_DOI[$i]["prefixe"];
		$editeur_ng = $Prefixe_DOI[$i]["editeur_ng"];
		if ($pDOI != "") {
			$urlHAL = $cstAPI.$team."/?wt=xml&fq=producedDateY_i:".$year.$spefq."&fq=-status_i=111&fq=doiId_s:".$pDOI."*&fq=docType_s:".$type;
		}else{
			if($type != "COMM") {
				$urlHAL = $cstAPI.$team."/?wt=xml&fq=producedDateY_i:".$year.$spefq."&fq=-status_i=111&fq=journalPublisher_t:".$editeur_ng."&fq=docType_s:".$type;
			}else{
				$urlHAL = "Passer_tour";
			}
		}
		$qteArt = 0;
		$qteTotArt = 0;
		if ($urlHAL != "") {
			if ($urlHAL == "Passer_tour") {
				$qteArt = 0;
			}else{
				$qteArt = askCurlNF($urlHAL, $cstCA);
			}
		}
		$nbPubEd[$i]["editeur_ng"] = $editeur_ng;
		$nbPubEd[$i]["nbArt"] = $qteArt;
	}
	//Regroupement éditorial
	$j = 0;
	$cpt = 0;
	for ($i=0; $i<count($nbPubEd); $i++) {
		$cpt += $nbPubEd[$i]["nbArt"];
		if ($i != count($nbPubEd) - 1) {
			if ($nbPubEd[$i]["editeur_ng"] != $nbPubEd[$i+1]["editeur_ng"]) {
				$nbPubEdRE[$j]["editeur_ng"] = $nbPubEd[$i]["editeur_ng"];
				$nbPubEdRE[$j]["nbArt"] = $cpt;
				$cpt = 0;
				$j++;
			}
		}else{//Dernière ligne
			$nbPubEdRE[$j]["editeur_ng"] = $nbPubEd[$i]["editeur_ng"];
			$nbPubEdRE[$j]["nbArt"] = $cpt;
		}
	}
	for ($i=0; $i<count($nbPubEdRE); $i++) {
		$qteTotArt += $nbPubEdRE[$i]["nbArt"];
	}
	$urlHALTotArt = $cstAPI.$team."/?wt=xml&fq=producedDateY_i:".$year.$spefq."&fq=-status_i=111*&fq=docType_s:".$type;
	$nbTotArt = askCurlNF($urlHALTotArt, $cstCA);
	$hre = $nbTotArt - $qteTotArt;//Hors regroupement éditorial
	$i = count($nbPubEdRE);
	$nbPubEdRE[$i]["editeur_ng"] = "Hors regroupement éditorial";
	$nbPubEdRE[$i]["nbArt"] = $hre;
	$nbPubEdRE = array_orderby($nbPubEdRE, 'nbArt', SORT_DESC);
}

//Nettoyage des dossiers de création de fichiers
function suppression($dossier, $age) {
  $repertoire = opendir($dossier);
    while (false !== ($fichier = readdir($repertoire)))
    {
      $chemin = $dossier."/".$fichier;
      $age_fichier = time() - filemtime($chemin);
      if($fichier != "." && $fichier != ".." && !is_dir($fichier) && $age_fichier > $age)
      {
      unlink($chemin);
      //echo $chemin." - ".date ("F d Y H:i:s.", filemtime($chemin))."<br>";
      }
    }
  closedir($repertoire);
}

//Recherche par valeur dans un tableau multidimensionnel
function searchForId($id, $array, $uid) {
	foreach ($array as $key => $val) {
		if ($val[$uid] === $id) {
			return $key;
		}
	}
	return null;
}

?>
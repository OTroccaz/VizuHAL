<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<?php
// récupération de l'adresse IP du client (on cherche d'abord à savoir s'il est derrière un proxy)
if(isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
  $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
}elseif(isset($_SERVER['HTTP_CLIENT_IP'])) {
  $ip = $_SERVER['HTTP_CLIENT_IP'];
}else {
  $ip = $_SERVER['REMOTE_ADDR'];
}

//Restriction IP
/*
include("./IP_list.php");
if (!in_array($ip, $IP_aut)) {
if (!in_array($ip, $IP_aut)) {
  echo "<br><br><center><font face='Corbel'><b>";
  echo "Votre poste n'est pas autorisé à accéder à cette application.";
  echo "</b></font></center>";
  die;
}
*/

//Paramètres envoyés par l'URL
if (isset($_GET["reqt"])) {
	if ($_GET["reqt"] == "req16") {$reqt = "req16";$irq16 = " selected";}
	if ($_GET["reqt"] == "req17") {$reqt = "req17";$irq17 = " selected";}
	if ($_GET["reqt"] == "req18") {$reqt = "req18";$irq18 = " selected";}
	if ($_GET["reqt"] == "req19") {$reqt = "req19";$irq19 = " selected";}
	if ($_GET["reqt"] == "req20") {$reqt = "req20";$irq20 = " selected";}
	if ($_GET["reqt"] == "req21") {$reqt = "req21";$irq21 = " selected";}
	if ($_GET["reqt"] == "req22") {$reqt = "req22";$irq22 = " selected";}
	if ($_GET["reqt"] == "req23") {$reqt = "req23";$irq23 = " selected";}
	$team = $_GET["team"];
	if (isset($_GET["port"])) {$port = $_GET["port"];}
	$ordr = $_GET["ordr"];
	if (isset($_GET["anneedeb"])) {$anneedeb = $_GET["anneedeb"];}
	if (isset($_GET["anneefin"])) {$anneefin = $_GET["anneefin"];}
	if (isset($_GET["annee17"])) {$annee17 = $_GET["annee17"];}
	if (isset($_GET["annee18"])) {$annee18 = $_GET["annee18"];}
	if (isset($_GET["annee19"])) {$annee19 = $_GET["annee19"];}
	if (isset($_GET["annee20"])) {$annee20 = $_GET["annee20"];}
}

header('Content-type: text/html; charset=UTF-8');

register_shutdown_function(function() {
    $error = error_get_last();

    if ($error['type'] === E_ERROR && strpos($error['message'], 'Maximum execution time of') === 0) {
        echo "<br><b><font color='red'>Le script a été arrêté car son temps d'exécution dépasse la limite maximale autorisée.</font></b><br>";
    }
});

if (isset($_GET['css']) && ($_GET['css'] != ""))
{
  $css = $_GET['css'];
}else{
  $css = "https://ecobio.univ-rennes1.fr/HAL_SCD.css";
}

$root = 'http';
if (isset ($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] == "on")	{
  $root.= "s";
}

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
          foreach ($data as $key => $row)
              $tmp[$key] = $row[$field];
          $args[$n] = $tmp;
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

function askCurl($url, &$arrayCurl) {
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, $url);
  curl_setopt($ch, CURLOPT_HEADER, 0);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($ch, CURLOPT_USERAGENT, 'SCD (https://halur1.univ-rennes1.fr)');
  curl_setopt($ch, CURLOPT_USERAGENT, 'PROXY (http://siproxy.univ-rennes1.fr)');
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
  $json = curl_exec($ch);
  curl_close($ch);
  
  $memory = intval(ini_get('memory_limit')) * 1024 * 1024;
  $limite = strlen($json)*10;
  if ($limite > $memory) {
    die ('<b><font color="red">Désolé ! La collection et/ou la période choisie génère(nt) trop de résultats pour être traités correctement.</font></b>');
  }else{
    $parsed_json = json_decode($json, true);
    $arrayCurl = objectToArray($parsed_json);
  }
}

function askCurlNF($url) {
  $url = str_replace(" ", "%20", $url);
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, $url);
  curl_setopt($ch, CURLOPT_HEADER, 0);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($ch, CURLOPT_USERAGENT, 'SCD (https://halur1.univ-rennes1.fr)');
  curl_setopt($ch, CURLOPT_USERAGENT, 'PROXY (http://siproxy.univ-rennes1.fr)');
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
  $json = curl_exec($ch);
  curl_close($ch);

  $memory = intval(ini_get('memory_limit')) * 1024 * 1024;
  $limite = strlen($json)*10;
  if ($limite > $memory) {
    die ('<b><font color="red">Désolé ! La collection et/ou la période choisie génère(nt) trop de résultats pour être traités correctement.</font></b>');
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

function extractHAL($team, $year, $reqt, &$resHAL) {
  if ($reqt == "req3") {
    $dT = "&fq=docType_s:ART";
  }else{
    $dT = "";
  }
  
  //Dépôts par année de publication
  $urlHALDep = "https://api.archives-ouvertes.fr/search/".$team."/?wt=xml&fq=producedDateY_i:".$year."&fq=submitType_s:(notice OR file)".$dT."&fq=-status_i=111&rows=0";
  $qte = askCurlNF($urlHALDep);
  $resHAL[$year][strtoupper($team)]["nfDep"] = $qte;
  
  //notices sans TI
  $urlHALPronoTI = "https://api.archives-ouvertes.fr/search/".$team."/?wt=xml&fq=producedDateY_i:".$year."&fq=submitType_s:notice".$dT."&fq=-status_i=111&rows=0";
  $qte = askCurlNF($urlHALPronoTI);
  $resHAL[$year][strtoupper($team)]["nfPronoTI"] = $qte;
  
  //Manuscrits plein texte avec TI
  $urlHALProavTI = "https://api.archives-ouvertes.fr/search/".$team."/?wt=xml&fq=producedDateY_i:".$year."&fq=submitType_s:file".$dT."&fq=-status_i=111&rows=0";
  $qte = askCurlNF($urlHALProavTI);
  $resHAL[$year][strtoupper($team)]["nfProavTI"] = $qte;
  
  //notices avec lien open access, sans TI déposé dans HAL mais avec TI librement accessible hors HAL
  $urlHALPronoTIavOA = "https://api.archives-ouvertes.fr/search/".$team."/?wt=xml&fq=producedDateY_i:".$year."&fq=linkExtId_s:*&fq=-linkExtId_s:istex".$dT."&fq=-status_i=111&rows=0";
  $qte = askCurlNF($urlHALPronoTIavOA);
  $resHAL[$year][strtoupper($team)]["nfPronoTIavOA"] = $qte;
  
  //Manuscrits et lien open access avec TI déposé dans HAL ou librement accessible hors HAL
  $urlHALProavTIavOA = "https://api.archives-ouvertes.fr/search/".$team."/?wt=xml&fq=producedDateY_i:".$year."&fq=(submitType_s:file OR linkExtId_s:*)&fq=-linkExtId_s:istex".$dT."&fq=-status_i=111&rows=0";
  $qte = askCurlNF($urlHALProavTIavOA);
  $resHAL[$year][strtoupper($team)]["nfProavTIavOA"] = $qte;
}

function extractHALnbPubEd($team, $year, $type, $spefq, &$nbTotArt, &$nbPubEdRE) {
	$nbPubEd = array();
	$nbPubEdRE = array();//Regroupement éditorial
	include("./Prefixe_DOI.php");
	$i = 0;
	//for ($i=0; $i<=10; $i++) {
	for ($i=0; $i<count($Prefixe_DOI); $i++) {
		$pDOI = $Prefixe_DOI[$i]["prefixe"];
		$editeur_ng = $Prefixe_DOI[$i]["editeur_ng"];
		if ($pDOI != "") {
			$urlHAL = "https://api.archives-ouvertes.fr/search/".$team."/?wt=xml&fq=producedDateY_i:".$year.$spefq."&fq=-status_i=111&fq=doiId_s:".$pDOI."*&fq=docType_s:".$type;
		}else{
			if($type != "COMM") {
				$urlHAL = "https://api.archives-ouvertes.fr/search/".$team."/?wt=xml&fq=producedDateY_i:".$year.$spefq."&fq=-status_i=111&fq=journalPublisher_t:".$editeur_ng."&fq=docType_s:".$type;
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
				$qteArt = askCurlNF($urlHAL);
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
	$urlHALTotArt = "https://api.archives-ouvertes.fr/search/".$team."/?wt=xml&fq=producedDateY_i:".$year.$spefq."&fq=-status_i=111*&fq=docType_s:".$type;
	$nbTotArt = askCurlNF($urlHALTotArt);
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
      $infos = pathinfo($chemin);
      $age_fichier = time() - filemtime($chemin);
      if($fichier != "." && $fichier != ".." && !is_dir($fichier) && $age_fichier > $age)
      {
      unlink($chemin);
      //echo $chemin." - ".date ("F d Y H:i:s.", filemtime($chemin))."<br>";
      }
    }
  closedir($repertoire);
}
suppression("./grf", 3600);//Suppression des graphes du dossier grf créés il y a plus d'une heure
suppression("./csv", 3600);//Suppression des exports du dossier csv créés il y a plus d'une heure

?>
<html lang="fr">
<head>
  <title>VizuHAL</title>
  <meta name="Description" content="VizuHAL">
  <link href="bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="<?php echo $css;?>" type="text/css">
  <link rel="shortcut icon" type="image/x-icon" href="favicon.ico">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <script src="//code.jquery.com/jquery-1.11.3.min.js"></script>
  <link rel="icon" type="type/ico" href="favicon.ico">
  <link rel="stylesheet" href="./VizuHAL.css">
</head>
<body onload="freqt();">

<noscript>
<div align='center' id='noscript'><font color='red'><b>ATTENTION !!! JavaScript est désactivé ou non pris en charge par votre navigateur : cette procédure ne fonctionnera pas correctement.</b></font><br>
<b>Pour modifier cette option, voir <a target='_blank' href='http://www.libellules.ch/browser_javascript_activ.php'>ce lien</a>.</b></div><br>
</noscript>

<table width="100%">
<tr>
<td style="text-align: left;"><img alt="VizuHAL" title="VizuHAL" width="250px" src="./img/logo_Vizuhal.png"></td>
<td style="text-align: right;"><img alt="Université de Rennes 1" title="Université de Rennes 1" width="150px" src="./img/logo_UR1_gris_petit.jpg"></td>
</tr>
</table>
<hr style="color: #467666; height: 1px; border-width: 1px; border-top-color: #467666; border-style: inset;">

<p>VizuHAL permet de générer des tableaux et graphes statistiques à partir de HAL (collection ou portail).<br>
<br>
Entrez un code collection OU sélectionnez un portail dans la liste déroulante, puis sélectionnez votre requête.<br>
<u>Attention :</u> certaines requêtes ne sont valides que pour une collection ou un portail.<br>
</p>

<form name="troli" action="VizuHAL.php" method="post"  onsubmit="freqt();">
<p class="form-inline"><label for="team">Code collection HAL</label> <a class='info' onclick='return false' href="#">(qu'est-ce que c’est ?)<span>Code visible dans l’URL d’une collection.
Exemple : IPR-MOL est le code de la collection http://hal.archives-ouvertes.fr/<b>IPR-PMOL</b> de l’équipe Physique moléculaire
de l’unité IPR UMR CNRS 6251</span></a> :

<?php
if (isset($_POST["valider"])) {
  $team = htmlspecialchars(strtoupper($_POST["team"]));
  $port = htmlspecialchars($_POST["port"]);
  $reqt = htmlspecialchars($_POST["reqt"]);
  if ($reqt == "req2") {
    $anneedeb = htmlspecialchars($_POST["anneedeb2"]);
    $anneefin = htmlspecialchars($_POST["anneefin2"]);
    if ($anneefin < $anneedeb) {$anneetemp = $anneedeb; $anneedeb = $anneefin; $anneefin = $anneetemp;}
  }else{
    if ($reqt == "req1") {
      $annee1 = htmlspecialchars($_POST["annee1"]);
    }else{
      if ($reqt == "req3") {
        $annee3 = htmlspecialchars($_POST["annee3"]);
      }else{
        if ($reqt == "req4") {
					$annee4 = htmlspecialchars($_POST["annee4"]);
				}else{
					if ($reqt == "req5") {
						$annee5 = htmlspecialchars($_POST["annee5"]);
					}else{
						if ($reqt == "req6") {
							$annee6 = htmlspecialchars($_POST["annee6"]);
						}else{
							if ($reqt == "req7") {
								$annee7 = htmlspecialchars($_POST["annee7"]);
							}else{
								if ($reqt == "req8") {
									$annee8 = htmlspecialchars($_POST["annee8"]);
								}else{
									if ($reqt == "req9") {
										$annee9 = htmlspecialchars($_POST["annee9"]);
									}else{
										if ($reqt == "req10") {
											$annee10 = htmlspecialchars($_POST["annee10"]);
										}else{
											if ($reqt == "req11") {
												$annee11 = htmlspecialchars($_POST["annee11"]);
											}else{
												if ($reqt == "req12") {
													$annee12 = htmlspecialchars($_POST["annee12"]);
												}else{
													if ($reqt == "req13") {
														$annee13 = htmlspecialchars($_POST["annee13"]);
													}else{
														if ($reqt == "req14") {
															$anneedeb = htmlspecialchars($_POST["anneedeb14"]);
															$anneefin = htmlspecialchars($_POST["anneefin14"]);
															if ($anneefin < $anneedeb) {$anneetemp = $anneedeb; $anneedeb = $anneefin; $anneefin = $anneetemp;}
														}else{
															if ($reqt == "req15") {
																$anneedeb = htmlspecialchars($_POST["anneedeb15"]);
																$anneefin = htmlspecialchars($_POST["anneefin15"]);
																if ($anneefin < $anneedeb) {$anneetemp = $anneedeb; $anneedeb = $anneefin; $anneefin = $anneetemp;}
															}else{
																if ($reqt == "req16") {
																	$anneedeb = htmlspecialchars($_POST["anneedeb16"]);
																	$anneefin = htmlspecialchars($_POST["anneefin16"]);
																	if ($anneefin < $anneedeb) {$anneetemp = $anneedeb; $anneedeb = $anneefin; $anneefin = $anneetemp;}
																}else{
																	if ($reqt == "req17") {
																		$annee17 = htmlspecialchars($_POST["annee17"]);
																	}else{
																		if ($reqt == "req18") {
																			$annee18 = htmlspecialchars($_POST["annee18"]);
																		}else{
																			if ($reqt == "req19") {
																				$annee19 = htmlspecialchars($_POST["annee19"]);
																			}else{
																				if ($reqt == "req20") {
																					$annee20 = htmlspecialchars($_POST["annee20"]);
																				}else{
																					if ($reqt == "req21") {
																						$anneedeb = htmlspecialchars($_POST["anneedeb21"]);
																						$anneefin = htmlspecialchars($_POST["anneefin21"]);
																						if ($anneefin < $anneedeb) {$anneetemp = $anneedeb; $anneedeb = $anneefin; $anneefin = $anneetemp;}
																					}else{
																						if ($reqt == "req22") {
																							$anneedeb = htmlspecialchars($_POST["anneedeb22"]);
																							$anneefin = htmlspecialchars($_POST["anneefin22"]);
																							if ($anneefin < $anneedeb) {$anneetemp = $anneedeb; $anneedeb = $anneefin; $anneefin = $anneetemp;}
																						}else{
																							$anneedeb = htmlspecialchars($_POST["anneedeb23"]);
																							$anneefin = htmlspecialchars($_POST["anneefin23"]);
																							if ($anneefin < $anneedeb) {$anneetemp = $anneedeb; $anneedeb = $anneefin; $anneefin = $anneetemp;}
																						}
																					}
																				}
																			}
																		}
																	}
																}
															}
														}
													}
												}
											}
										}
									}
								}
							}
						}
					}
				}
      }
    }
  }
}
if (isset($team) && $team != "") {$team1 = $team; $team2 = $team;}else{$team1 = "Entrez le code de votre collection"; $team2 = "";}
if (isset($port) && $port != "choix") {$team1 = "";}
?>
<!--Code collection HAL-->
<input type="text" id="team" class="form-control" style="height: 25px; width: 300px;" name="team" value="<?php echo $team1;?>" onClick="this.value='<?php echo $team2;?>'; document.getElementById('port').value = 'choix';">&nbsp;<a target="_blank" href="https://hal-univ-rennes1.archives-ouvertes.fr/page/codes-collections">Trouver le code de mon équipe / labo</a>
<h2><b><u>ou</u></b></h2>
<br>
<!--Portail HAL-->
<p class="form-inline"><label for="port">Portail HAL :&nbsp;</label></td>
<select id="port" class="form-control" style="margin:0px; width:300px" size="1" name="port" onChange="document.getElementById('team').value = '';">
<option value="choix">Veuillez choisir parmi la liste</option>
<?php
$sel = array();
if (isset($port) && $port != "choix") {$sel[$port] = "selected";}else{$sel[$port] = "";}

$dossier = opendir('./');
while (false !== ($fichier = readdir($dossier))) {
  if($fichier != '.' && $fichier != '..' && strpos($fichier, 'PortHAL')!== false) {
    $qui = str_replace(array('Port', '.php'), '', $fichier);
		if(isset($sel[$qui])) {
			echo ('<option value='.$qui.' '.$sel[$qui].'>'.$qui.'</option>');
		}else{
			echo ('<option value='.$qui.'>'.$qui.'</option>');
		}
  }
}
?>
</select>
<br><br>
<?php
if (isset($reqt) && $reqt == "tabg") {$itab = " selected";}else{$itab = "";}
if (isset($reqt) && $reqt == "req1") {$irq1 = " selected";}else{$irq1 = "";}
if (isset($reqt) && $reqt == "req2") {$irq2 = " selected";}else{$irq2 = "";}
if (isset($reqt) && $reqt == "req3") {$irq3 = " selected";}else{$irq3 = "";}
if (isset($reqt) && $reqt == "req4") {$irq4 = " selected";}else{$irq4 = "";}
if (isset($reqt) && $reqt == "req5") {$irq5 = " selected";}else{$irq5 = "";}
if (isset($reqt) && $reqt == "req6") {$irq6 = " selected";}else{$irq6 = "";}
if (isset($reqt) && $reqt == "req7") {$irq7 = " selected";}else{$irq7 = "";}
if (isset($reqt) && $reqt == "req8") {$irq8 = " selected";}else{$irq8 = "";}
if (isset($reqt) && $reqt == "req9") {$irq9 = " selected";}else{$irq9 = "";}
if (isset($reqt) && $reqt == "req10") {$irq10 = " selected";}else{$irq10 = "";}
if (isset($reqt) && $reqt == "req11") {$irq11 = " selected";}else{$irq11 = "";}
if (isset($reqt) && $reqt == "req12") {$irq12 = " selected";}else{$irq12 = "";}
if (isset($reqt) && $reqt == "req13") {$irq13 = " selected";}else{$irq13 = "";}
if (isset($reqt) && $reqt == "req14") {$irq14 = " selected";}else{$irq14 = "";}
if (isset($reqt) && $reqt == "req15") {$irq15 = " selected";}else{$irq15 = "";}
if (isset($reqt) && $reqt == "req16") {$irq16 = " selected";}else{$irq16 = "";}
if (isset($reqt) && $reqt == "req17") {$irq17 = " selected";}else{$irq17 = "";}
if (isset($reqt) && $reqt == "req18") {$irq18 = " selected";}else{$irq18 = "";}
if (isset($reqt) && $reqt == "req19") {$irq19 = " selected";}else{$irq19 = "";}
if (isset($reqt) && $reqt == "req20") {$irq20 = " selected";}else{$irq20 = "";}
if (isset($reqt) && $reqt == "req21") {$irq21 = " selected";}else{$irq21 = "";}
if (isset($reqt) && $reqt == "req22") {$irq22 = " selected";}else{$irq22 = "";}
if (isset($reqt) && $reqt == "req23") {$irq23 = " selected";}else{$irq23 = "";}
?>
<!--Extraction-->
<p class="form-inline"><label for="reqt">Extraction souhaitée :&nbsp;</label>
<select id="reqt" class="form-control" style="margin:0px;" size="1" name="reqt" onChange="freqt();">
<!--<option value="tabg"<?php echo($itab);?>>Tableau de bord général</option>-->
<option value="req1"<?php echo($irq1);?>>1. Portail : production scientifique par secteur et par unité</option>
<option value="req2"<?php echo($irq2);?>>2. Portail ou collection : évolution sur une période</option>
<option value="req3"<?php echo($irq3);?>>3. Portail : Comparaison portails</option>
<option value="req4"<?php echo($irq4);?>>4. Portail : ESGBU (stocks et flux)</option>
<option value="req5"<?php echo($irq5);?>>5. Portail ou Collection : Nombre de publications de type articles par éditeur</option>
<option value="req6"<?php echo($irq6);?>>6. Portail ou Collection : Nombre de publications de type communications par éditeur</option>
<option value="req7"<?php echo($irq7);?>>7. Portail ou Collection : Nombre de publications (articles de revue) par revue</option>
<!--
<option value="req8"<?php echo($irq8);?>>8. Portail : Pourcentage par secteur des articles de tel éditeur</option>
<option value="req9"<?php echo($irq9);?>>9. Portail : Pourcentage par éditeur des articles de tel secteur</option>
-->
<option value="req10"<?php echo($irq10);?>>10. Collection : Nombre d'articles sans texte intégral déposé dans HAL par éditeur</option>
<option value="req11"<?php echo($irq11);?>>11. Collection : Nombre d'articles avec texte intégral déposé dans HAL par éditeur</option>
<option value="req12"<?php echo($irq12);?>>12. Collection : Nombre d'articles avec texte intégral déposé dans HAL OU lien externe vers PDF en open access par éditeur</option>
<option value="req13"<?php echo($irq13);?>>13. Portail ou collection : évolution sur une et trois années</option>
<option value="req14"<?php echo($irq14);?>>14. Collection : Nombre de projets ANR</option>
<option value="req15"<?php echo($irq15);?>>15. Collection : Nombre de projets européens</option>
<option value="req16"<?php echo($irq16);?>>16. Collection : Profil des contributeurs HAL</option>
<option value="req17"<?php echo($irq17);?>>17. Collection : Collaborations nationales</option>
<option value="req18"<?php echo($irq18);?>>18. Collection : Collaborations nationales (laboratoires)</option>
<option value="req19"<?php echo($irq19);?>>19. Collection : Collaborations nationales (établissements)</option>
<option value="req20"<?php echo($irq20);?>>20. Collection : Collaborations nationales (autres)</option>
<option value="req21"<?php echo($irq21);?>>21. Collection : Collaborations internationales (toutes structures)</option>
<option value="req22"<?php echo($irq22);?>>22. Collection : Collaborations internationales (institutions)</option>
<option value="req23"<?php echo($irq23);?>>23. Collection : Collaborations internationales (pays)</option>
</select>

<!--Tableau général-->
<div id="tabg">
<!--Paramètres :-->
</div>

<!--Requête 1-->
<div id="req1">
<!--Paramètres :-->
<label for="annee1">Année</label>
<select id="annee1" class="form-control" style="height: 25px; width: 60px; padding: 0px;" name="annee1">
<?php
$moisactuel = date('n', time());
if ($moisactuel >= 10) {$i = date('Y', time())+1;}else{$i = date('Y', time());}
while ($i >= date('Y', time()) - 30) {
  if(isset($annee1) && $annee1 == $i) {$txt = "selected";}else{$txt = "";}
  echo '<option value='.$i.' '.$txt.'>'.$i.'</option>' ;
  $i--;
}
?>
</select>
<br>
<p class="form-inline">
<input type="submit" class="btn btn-md btn-primary" value="Valider" name="valider">
</p>
</div>

<!--Requête 2-->
<div id="req2">
<!--Paramètres :-->
<table>
<tr><td valign="top">Période :&nbsp;</td>
<td>
<p class="form-inline">
<label for="anneedeb2">Depuis</label>
<select id="anneedeb2" class="form-control" style="height: 25px; width: 60px; padding: 0px;" name="anneedeb2">
<?php
$moisactuel = date('n', time());
if ($moisactuel >= 10) {$i = date('Y', time())+1;}else{$i = date('Y', time());}
while ($i >= date('Y', time()) - 30) {
  if(isset($anneedeb) && $anneedeb == $i) {$txt = "selected";}else{$txt = "";}
  echo '<option value='.$i.' '.$txt.'>'.$i.'</option>' ;
  $i--;
}
?>
</select>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<label for="anneefin2">Jusqu'à</label>
<select id="anneefin2" class="form-control" style="height: 25px; width: 60px; padding: 0px;" name="anneefin2">
<?php
$moisactuel = date('n', time());
if ($moisactuel >= 10) {$i = date('Y', time())+1;}else{$i = date('Y', time());}
while ($i >= date('Y', time()) - 30) {
  if(isset($anneefin) && $anneefin == $i) {$txt = "selected";}else{$txt = "";}
  echo '<option value='.$i.' '.$txt.'>'.$i.'</option>';
  $i--;
}
?>
</select>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i><u>Attention :</u> l'extraction via un portail demande beaucoup de temps et il est préférable de se limiter à une période annuelle.</i>
<br>
</td></tr></table>
<p class="form-inline">
<input type="submit" class="btn btn-md btn-primary" value="Valider" name="valider">
</p>
</div>

<!--Requête 3-->
<div id="req3">
<!--Paramètres :-->
<label for="annee3">Année</label>
<select id="annee3" class="form-control" style="height: 25px; width: 60px; padding: 0px;" name="annee3">
<?php
$moisactuel = date('n', time());
if ($moisactuel >= 10) {$i = date('Y', time())+1;}else{$i = date('Y', time());}
while ($i >= date('Y', time()) - 30) {
  if(isset($annee3) && $annee3 == $i) {$txt = "selected";}else{$txt = "";}
  echo '<option value='.$i.' '.$txt.'>'.$i.'</option>' ;
  $i--;
}
?>
</select>
<br>
<p class="form-inline">
<input type="submit" class="btn btn-md btn-primary" value="Valider" name="valider">
</p>
</div>

<!--Requête 4-->
<div id="req4">
<!--Paramètres :-->
<label for="annee4">Année</label>
<select id="annee4" class="form-control" style="height: 25px; width: 60px; padding: 0px;" name="annee4">
<?php
$moisactuel = date('n', time());
if ($moisactuel >= 10) {$i = date('Y', time())+1;}else{$i = date('Y', time());}
while ($i >= date('Y', time()) - 30) {
  if(isset($annee4) && $annee4 == $i) {$txt = "selected";}else{$txt = "";}
  echo '<option value='.$i.' '.$txt.'>'.$i.'</option>' ;
  $i--;
}
?>
</select>
<br>
<p class="form-inline">
<input type="submit" class="btn btn-md btn-primary" value="Valider" name="valider">
</p>
</div>

<!--Requête 5-->
<div id="req5">
<!--Paramètres :-->
<label for="annee5">Année</label>
<select id="annee5" class="form-control" style="height: 25px; width: 60px; padding: 0px;" name="annee5">
<?php
$moisactuel = date('n', time());
if ($moisactuel >= 10) {$i = date('Y', time())+1;}else{$i = date('Y', time());}
while ($i >= date('Y', time()) - 30) {
  if(isset($annee5) && $annee5 == $i) {$txt = "selected";}else{$txt = "";}
  echo '<option value='.$i.' '.$txt.'>'.$i.'</option>' ;
  $i--;
}
?>
</select>
<br>
<p class="form-inline">
<input type="submit" class="btn btn-md btn-primary" value="Valider" name="valider">
</p>
</div>

<!--Requête 6-->
<div id="req6">
<!--Paramètres :-->
<label for="annee6">Année</label>
<select id="annee6" class="form-control" style="height: 25px; width: 60px; padding: 0px;" name="annee6">
<?php
$moisactuel = date('n', time());
if ($moisactuel >= 10) {$i = date('Y', time())+1;}else{$i = date('Y', time());}
while ($i >= date('Y', time()) - 30) {
  if(isset($annee6) && $annee6 == $i) {$txt = "selected";}else{$txt = "";}
  echo '<option value='.$i.' '.$txt.'>'.$i.'</option>' ;
  $i--;
}
?>
</select>
<br>
<p class="form-inline">
<input type="submit" class="btn btn-md btn-primary" value="Valider" name="valider">
</p>
</div>

<!--Requête 7-->
<div id="req7">
<!--Paramètres :-->
<label for="annee7">Année</label>
<select id="annee7" class="form-control" style="height: 25px; width: 60px; padding: 0px;" name="annee7">
<?php
$moisactuel = date('n', time());
if ($moisactuel >= 10) {$i = date('Y', time())+1;}else{$i = date('Y', time());}
while ($i >= date('Y', time()) - 30) {
  if(isset($annee7) && $annee7 == $i) {$txt = "selected";}else{$txt = "";}
  echo '<option value='.$i.' '.$txt.'>'.$i.'</option>' ;
  $i--;
}
?>
</select>
<br>
<p class="form-inline">
<input type="submit" class="btn btn-md btn-primary" value="Valider" name="valider">
</p>
</div>

<!--Requête 8-->
<div id="req8">
<!--Paramètres :-->
<label for="annee8">Année</label>
<select id="annee8" class="form-control" style="height: 25px; width: 60px; padding: 0px;" name="annee8">
<?php
$moisactuel = date('n', time());
if ($moisactuel >= 10) {$i = date('Y', time())+1;}else{$i = date('Y', time());}
while ($i >= date('Y', time()) - 30) {
  if(isset($annee8) && $annee8 == $i) {$txt = "selected";}else{$txt = "";}
  echo '<option value='.$i.' '.$txt.'>'.$i.'</option>' ;
  $i--;
}
?>
</select>
<br>
<p class="form-inline">
<input type="submit" class="btn btn-md btn-primary" value="Valider" name="valider">
</p>
</div>

<!--Requête 9-->
<div id="req9">
<!--Paramètres :-->
<label for="annee9">Année</label>
<select id="annee9" class="form-control" style="height: 25px; width: 60px; padding: 0px;" name="annee9">
<?php
$moisactuel = date('n', time());
if ($moisactuel >= 10) {$i = date('Y', time())+1;}else{$i = date('Y', time());}
while ($i >= date('Y', time()) - 30) {
  if(isset($annee9) && $annee9 == $i) {$txt = "selected";}else{$txt = "";}
  echo '<option value='.$i.' '.$txt.'>'.$i.'</option>' ;
  $i--;
}
?>
</select>
<br>
<p class="form-inline">
<input type="submit" class="btn btn-md btn-primary" value="Valider" name="valider">
</p>
</div>

<!--Requête 10-->
<div id="req10">
<!--Paramètres :-->
<label for="annee10">Année</label>
<select id="annee10" class="form-control" style="height: 25px; width: 60px; padding: 0px;" name="annee10">
<?php
$moisactuel = date('n', time());
if ($moisactuel >= 10) {$i = date('Y', time())+1;}else{$i = date('Y', time());}
while ($i >= date('Y', time()) - 30) {
  if(isset($annee10) && $annee10 == $i) {$txt = "selected";}else{$txt = "";}
  echo '<option value='.$i.' '.$txt.'>'.$i.'</option>' ;
  $i--;
}
?>
</select>
<br>
<p class="form-inline">
<input type="submit" class="btn btn-md btn-primary" value="Valider" name="valider">
</p>
</div>

<!--Requête 11-->
<div id="req11">
<!--Paramètres :-->
<label for="annee11">Année</label>
<select id="annee11" class="form-control" style="height: 25px; width: 60px; padding: 0px;" name="annee11">
<?php
$moisactuel = date('n', time());
if ($moisactuel >= 10) {$i = date('Y', time())+1;}else{$i = date('Y', time());}
while ($i >= date('Y', time()) - 30) {
  if(isset($annee11) && $annee11 == $i) {$txt = "selected";}else{$txt = "";}
  echo '<option value='.$i.' '.$txt.'>'.$i.'</option>' ;
  $i--;
}
?>
</select>
<br>
<p class="form-inline">
<input type="submit" class="btn btn-md btn-primary" value="Valider" name="valider">
</p>
</div>

<!--Requête 12-->
<div id="req12">
<!--Paramètres :-->
<label for="annee12">Année</label>
<select id="annee12" class="form-control" style="height: 25px; width: 60px; padding: 0px;" name="annee12">
<?php
$moisactuel = date('n', time());
if ($moisactuel >= 10) {$i = date('Y', time())+1;}else{$i = date('Y', time());}
while ($i >= date('Y', time()) - 30) {
  if(isset($annee12) && $annee12 == $i) {$txt = "selected";}else{$txt = "";}
  echo '<option value='.$i.' '.$txt.'>'.$i.'</option>' ;
  $i--;
}
?>
</select>
<br>
<p class="form-inline">
<input type="submit" class="btn btn-md btn-primary" value="Valider" name="valider">
</p>
</div>

<!--Requête 13-->
<div id="req13">
<!--Paramètres :-->
<label for="annee13">Année</label>
<select id="annee13" class="form-control" style="height: 25px; width: 60px; padding: 0px;" name="annee13">
<?php
$moisactuel = date('n', time());
if ($moisactuel >= 10) {$i = date('Y', time())+1;}else{$i = date('Y', time());}
while ($i >= date('Y', time()) - 30) {
  if(isset($annee13) && $annee13 == $i) {$txt = "selected";}else{$txt = "";}
  echo '<option value='.$i.' '.$txt.'>'.$i.'</option>' ;
  $i--;
}
?>
</select>
<br>
<p class="form-inline">
<input type="submit" class="btn btn-md btn-primary" value="Valider" name="valider">
</p>
</div>

<!--Requête 14-->
<div id="req14">
<!--Paramètres :-->
<table>
<tr><td valign="top">Période :&nbsp;</td>
<td>
<p class="form-inline">
<label for="anneedeb14">Depuis</label>
<select id="anneedeb14" class="form-control" style="height: 25px; width: 60px; padding: 0px;" name="anneedeb14">
<?php
$moisactuel = date('n', time());
if ($moisactuel >= 10) {$i = date('Y', time())+1;}else{$i = date('Y', time());}
while ($i >= date('Y', time()) - 30) {
  if(isset($anneedeb) && $anneedeb == $i) {$txt = "selected";}else{$txt = "";}
  echo '<option value='.$i.' '.$txt.'>'.$i.'</option>' ;
  $i--;
}
?>
</select>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<label for="anneefin14">Jusqu'à</label>
<select id="anneefin14" class="form-control" style="height: 25px; width: 60px; padding: 0px;" name="anneefin14">
<?php
$moisactuel = date('n', time());
if ($moisactuel >= 10) {$i = date('Y', time())+1;}else{$i = date('Y', time());}
while ($i >= date('Y', time()) - 30) {
  if(isset($anneefin) && $anneefin == $i) {$txt = "selected";}else{$txt = "";}
  echo '<option value='.$i.' '.$txt.'>'.$i.'</option>';
  $i--;
}
?>
</select>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i><u>Attention :</u> l'extraction sur plusieurs années peut demander beaucoup de temps et il est préférable de se limiter à une période raisonnable.</i>
<br>
</td></tr></table>
<br>
<p class="form-inline">
<input type="submit" class="btn btn-md btn-primary" value="Valider" name="valider">
</p>
</div>

<!--Requête 15-->
<div id="req15">
<!--Paramètres :-->
<table>
<tr><td valign="top">Période :&nbsp;</td>
<td>
<p class="form-inline">
<label for="anneedeb15">Depuis</label>
<select id="anneedeb15" class="form-control" style="height: 25px; width: 60px; padding: 0px;" name="anneedeb15">
<?php
$moisactuel = date('n', time());
if ($moisactuel >= 10) {$i = date('Y', time())+1;}else{$i = date('Y', time());}
while ($i >= date('Y', time()) - 30) {
  if(isset($anneedeb) && $anneedeb == $i) {$txt = "selected";}else{$txt = "";}
  echo '<option value='.$i.' '.$txt.'>'.$i.'</option>' ;
  $i--;
}
?>
</select>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<label for="anneefin15">Jusqu'à</label>
<select id="anneefin15" class="form-control" style="height: 25px; width: 60px; padding: 0px;" name="anneefin15">
<?php
$moisactuel = date('n', time());
if ($moisactuel >= 10) {$i = date('Y', time())+1;}else{$i = date('Y', time());}
while ($i >= date('Y', time()) - 30) {
  if(isset($anneefin) && $anneefin == $i) {$txt = "selected";}else{$txt = "";}
  echo '<option value='.$i.' '.$txt.'>'.$i.'</option>';
  $i--;
}
?>
</select>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i><u>Attention :</u> l'extraction sur plusieurs années peut demander beaucoup de temps et il est préférable de se limiter à une période raisonnable.</i>
<br>
</td></tr></table>
<br>
<p class="form-inline">
<input type="submit" class="btn btn-md btn-primary" value="Valider" name="valider">
</p>
</div>

<!--Requête 16-->
<div id="req16">
<!--Paramètres :-->
<table>
<tr><td valign="top">Période :&nbsp;</td>
<td>
<p class="form-inline">
<label for="anneedeb16">Depuis</label>
<select id="anneedeb16" class="form-control" style="height: 25px; width: 60px; padding: 0px;" name="anneedeb16">
<?php
$moisactuel = date('n', time());
if ($moisactuel >= 10) {$i = date('Y', time())+1;}else{$i = date('Y', time());}
while ($i >= date('Y', time()) - 30) {
  if(isset($anneedeb) && $anneedeb == $i) {$txt = "selected";}else{$txt = "";}
  echo '<option value='.$i.' '.$txt.'>'.$i.'</option>' ;
  $i--;
}
?>
</select>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<label for="anneefin16">Jusqu'à</label>
<select id="anneefin16" class="form-control" style="height: 25px; width: 60px; padding: 0px;" name="anneefin16">
<?php
$moisactuel = date('n', time());
if ($moisactuel >= 10) {$i = date('Y', time())+1;}else{$i = date('Y', time());}
while ($i >= date('Y', time()) - 30) {
  if(isset($anneefin) && $anneefin == $i) {$txt = "selected";}else{$txt = "";}
  echo '<option value='.$i.' '.$txt.'>'.$i.'</option>';
  $i--;
}
?>
</select>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i><u>Attention :</u> l'extraction sur plusieurs années peut demander beaucoup de temps et il est préférable de se limiter à une période raisonnable.</i>
<br>
</td></tr></table>
<br>
<p class="form-inline">
<input type="submit" class="btn btn-md btn-primary" value="Valider" name="valider">
</p>
</div>

<!--Requête 17-->
<div id="req17">
<!--Paramètres :-->
<label for="annee17">Année</label>
<select id="annee17" class="form-control" style="height: 25px; width: 60px; padding: 0px;" name="annee17">
<?php
$moisactuel = date('n', time());
if ($moisactuel >= 10) {$i = date('Y', time())+1;}else{$i = date('Y', time());}
while ($i >= date('Y', time()) - 30) {
  if(isset($annee17) && $annee17 == $i) {$txt = "selected";}else{$txt = "";}
  echo '<option value='.$i.' '.$txt.'>'.$i.'</option>' ;
  $i--;
}
?>
</select>
<br>
<p class="form-inline">
<input type="submit" class="btn btn-md btn-primary" value="Valider" name="valider">
</p>
</div>

<!--Requête 18-->
<div id="req18">
<!--Paramètres :-->
<label for="annee18">Année</label>
<select id="annee18" class="form-control" style="height: 25px; width: 60px; padding: 0px;" name="annee18">
<?php
$moisactuel = date('n', time());
if ($moisactuel >= 10) {$i = date('Y', time())+1;}else{$i = date('Y', time());}
while ($i >= date('Y', time()) - 30) {
  if(isset($annee18) && $annee18 == $i) {$txt = "selected";}else{$txt = "";}
  echo '<option value='.$i.' '.$txt.'>'.$i.'</option>' ;
  $i--;
}
?>
</select>
<br>
<p class="form-inline">
<input type="submit" class="btn btn-md btn-primary" value="Valider" name="valider">
</p>
</div>

<!--Requête 19-->
<div id="req19">
<!--Paramètres :-->
<label for="annee19">Année</label>
<select id="annee19" class="form-control" style="height: 25px; width: 60px; padding: 0px;" name="annee19">
<?php
$moisactuel = date('n', time());
if ($moisactuel >= 10) {$i = date('Y', time())+1;}else{$i = date('Y', time());}
while ($i >= date('Y', time()) - 30) {
  if(isset($annee19) && $annee19 == $i) {$txt = "selected";}else{$txt = "";}
  echo '<option value='.$i.' '.$txt.'>'.$i.'</option>' ;
  $i--;
}
?>
</select>
<br>
<p class="form-inline">
<input type="submit" class="btn btn-md btn-primary" value="Valider" name="valider">
</p>
</div>

<!--Requête 20-->
<div id="req20">
<!--Paramètres :-->
<label for="annee20">Année</label>
<select id="annee20" class="form-control" style="height: 25px; width: 60px; padding: 0px;" name="annee20">
<?php
$moisactuel = date('n', time());
if ($moisactuel >= 10) {$i = date('Y', time())+1;}else{$i = date('Y', time());}
while ($i >= date('Y', time()) - 30) {
  if(isset($annee20) && $annee20 == $i) {$txt = "selected";}else{$txt = "";}
  echo '<option value='.$i.' '.$txt.'>'.$i.'</option>' ;
  $i--;
}
?>
</select>
<br>
<p class="form-inline">
<input type="submit" class="btn btn-md btn-primary" value="Valider" name="valider">
</p>
</div>

<!--Requête 21-->
<div id="req21">
<table>
<tr><td valign="top">Période :&nbsp;</td>
<td>
<p class="form-inline">
<label for="anneedeb21">Depuis</label>
<select id="anneedeb21" class="form-control" style="height: 25px; width: 60px; padding: 0px;" name="anneedeb21">
<?php
$moisactuel = date('n', time());
if ($moisactuel >= 10) {$i = date('Y', time())+1;}else{$i = date('Y', time());}
while ($i >= date('Y', time()) - 30) {
  if(isset($anneedeb) && $anneedeb == $i) {$txt = "selected";}else{$txt = "";}
  echo '<option value='.$i.' '.$txt.'>'.$i.'</option>' ;
  $i--;
}
?>
</select>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<label for="anneefin21">Jusqu'à</label>
<select id="anneefin21" class="form-control" style="height: 25px; width: 60px; padding: 0px;" name="anneefin21">
<?php
$moisactuel = date('n', time());
if ($moisactuel >= 10) {$i = date('Y', time())+1;}else{$i = date('Y', time());}
while ($i >= date('Y', time()) - 30) {
  if(isset($anneefin) && $anneefin == $i) {$txt = "selected";}else{$txt = "";}
  echo '<option value='.$i.' '.$txt.'>'.$i.'</option>';
  $i--;
}
?>
</select>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i><u>Attention :</u> l'extraction sur plusieurs années peut demander beaucoup de temps et il est préférable de se limiter à une période raisonnable.</i>
<br>
</td></tr></table>
<br>
<p class="form-inline">
<input type="submit" class="btn btn-md btn-primary" value="Valider" name="valider">
</p>
</div>

<!--Requête 22-->
<div id="req22">
<table>
<tr><td valign="top">Période :&nbsp;</td>
<td>
<p class="form-inline">
<label for="anneedeb22">Depuis</label>
<select id="anneedeb22" class="form-control" style="height: 25px; width: 60px; padding: 0px;" name="anneedeb22">
<?php
$moisactuel = date('n', time());
if ($moisactuel >= 10) {$i = date('Y', time())+1;}else{$i = date('Y', time());}
while ($i >= date('Y', time()) - 30) {
  if(isset($anneedeb) && $anneedeb == $i) {$txt = "selected";}else{$txt = "";}
  echo '<option value='.$i.' '.$txt.'>'.$i.'</option>' ;
  $i--;
}
?>
</select>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<label for="anneefin22">Jusqu'à</label>
<select id="anneefin22" class="form-control" style="height: 25px; width: 60px; padding: 0px;" name="anneefin22">
<?php
$moisactuel = date('n', time());
if ($moisactuel >= 10) {$i = date('Y', time())+1;}else{$i = date('Y', time());}
while ($i >= date('Y', time()) - 30) {
  if(isset($anneefin) && $anneefin == $i) {$txt = "selected";}else{$txt = "";}
  echo '<option value='.$i.' '.$txt.'>'.$i.'</option>';
  $i--;
}
?>
</select>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i><u>Attention :</u> l'extraction sur plusieurs années peut demander beaucoup de temps et il est préférable de se limiter à une période raisonnable.</i>
<br>
</td></tr></table>
<br>
<p class="form-inline">
<input type="submit" class="btn btn-md btn-primary" value="Valider" name="valider">
</p>
</div>

<!--Requête 23-->
<div id="req23">
<table>
<tr><td valign="top">Période :&nbsp;</td>
<td>
<p class="form-inline">
<label for="anneedeb23">Depuis</label>
<select id="anneedeb23" class="form-control" style="height: 25px; width: 60px; padding: 0px;" name="anneedeb23">
<?php
$moisactuel = date('n', time());
if ($moisactuel >= 10) {$i = date('Y', time())+1;}else{$i = date('Y', time());}
while ($i >= date('Y', time()) - 30) {
  if(isset($anneedeb) && $anneedeb == $i) {$txt = "selected";}else{$txt = "";}
  echo '<option value='.$i.' '.$txt.'>'.$i.'</option>' ;
  $i--;
}
?>
</select>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<label for="anneefin23">Jusqu'à</label>
<select id="anneefin23" class="form-control" style="height: 25px; width: 60px; padding: 0px;" name="anneefin23">
<?php
$moisactuel = date('n', time());
if ($moisactuel >= 10) {$i = date('Y', time())+1;}else{$i = date('Y', time());}
while ($i >= date('Y', time()) - 30) {
  if(isset($anneefin) && $anneefin == $i) {$txt = "selected";}else{$txt = "";}
  echo '<option value='.$i.' '.$txt.'>'.$i.'</option>';
  $i--;
}
?>
</select>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i><u>Attention :</u> l'extraction sur plusieurs années peut demander beaucoup de temps et il est préférable de se limiter à une période raisonnable.</i>
<br>
</td></tr></table>
<br>
<p class="form-inline">
<input type="submit" class="btn btn-md btn-primary" value="Valider" name="valider">
</p>
</div>


</form>
<script type="text/javascript" language="Javascript" src="./VizuHAL.js"></script>
<?php
if (isset($_POST["valider"]) || isset($_GET["reqt"])) {
  ob_flush();
	flush();
  //Bloquer interrogation code collection labo avec requête 3, 4, 8 ou 9
  if (($reqt == "req3" || $reqt == "req4" || $reqt == "req8" || $reqt == "req9") && isset($port) && $port == "choix") {
    echo "<br><br><center><font face='Corbel'><b>";
    echo "Cette requête n'est pas applicable à un code collection mais uniquement à un portail.";
    echo "</b></font></center>";
    die;
  }
	
	//Bloquer interrogation portail avec requête 10, 11, 12, 13, 14, 15, 17, 18, 19, 20 ou 21
  if (($reqt == "req10" || $reqt == "req11" || $reqt == "req12" || $reqt == "req13" || $reqt == "req14" || $reqt == "req15" || $reqt == "req17" || $reqt == "req18" || $reqt == "req19" || $reqt == "req20" || $reqt == "req21") && isset($port) && $port != "choix") {
    echo "<br><br><center><font face='Corbel'><b>";
    echo "Cette requête n'est pas applicable à portail mais uniquement à un code collection.";
    echo "</b></font></center>";
    die;
  }
  
  $LAB_SECT = array();
  
  if (isset($port) && $port != "choix") {
    include('./Port'.$port.'.php');
  }else{
    $LAB_SECT[0]["code_collection"] = $team;
  }

  $tabPro = array();
  $year = 0;
  if ($reqt == "req1") {
    $anneedeb = $annee1;
    $anneefin = $annee1;
  }
  
  //Tableau de résultats requête 1
  if ($reqt == "req1") {
    //Export CSV
    $Fnm = "./csv/req1.csv";
    $inF = fopen($Fnm,"w+");
    fseek($inF, 0);
    $chaine = "\xEF\xBB\xBF";
    fwrite($inF,$chaine);
		
		//Intitulé
		echo('<br><b>1. Portail : production scientifique par secteur et par unité</b><br><br>');
		
		//Descriptif
		echo('<div style="background-color:#f5f5f5">Cette requête présente, pour une année donnée, le nombre de publications référencées dans le portail HAL institutionnel, avec ou sans texte intégral, avec ou sans lien vers un PDF librement disponible hors de HAL (via <a target="_blank" href="https://unpaywall.org/">Unpaywall</a>). Les résultats sont déclinés par secteurs (le cas échéant), et par unités ou structures de recherche. <a href="#DT">Voir détails techniques en bas de page</a>.</div><br>');
		
    for($year = $anneedeb; $year <= $anneefin; $year++) {
      //Export CSV
      //Colonnes
      $chaine = "Unité;Secteur;Productions ".$year.";;";
      $chaine .= "Productions ".$year." sans texte intégral déposé dans HAL déposé dans HAL;;";
      $chaine .= "Productions ".$year." avec texte intégral déposé dans HAL déposé dans HAL;;";
      $chaine .= "Productions ".$year." sans texte intégral déposé dans HAL déposé dans HAL mais avec texte intégral déposé dans HAL librement accessible hors HAL;;";
      $chaine .= "Productions ".$year." avec texte intégral déposé dans HAL déposé dans HAL ou librement accessible hors HAL;;";
      $chaine .= chr(13).chr(10);
      fwrite($inF,$chaine);
      
      $ils = 0;
      $chaine = "";
      echo ('<table class="table table-striped table-hover table-responsive table-bordered">');
      echo ('<thead>');
      echo ('<tr>');
      echo ('<th scope="col">Unité</th>');
      echo ('<th scope="col">Secteur</th>');
      echo ('<th scope="col">Productions '.$year.'</th>');
      echo ('<th scope="col"></th>');
      echo ('<th scope="col">Productions '.$year.' sans texte intégral déposé dans HAL déposé dans HAL</th>');
      echo ('<th scope="col"></th>');
      echo ('<th scope="col">Productions '.$year.' avec texte intégral déposé dans HAL déposé dans HAL</th>');
      echo ('<th scope="col"></th>');
      echo ('<th scope="col">Productions '.$year.' sans texte intégral déposé dans HAL déposé dans HAL mais avec texte intégral déposé dans HAL librement accessible hors HAL</th>');
      echo ('<th scope="col"></th>');
      echo ('<th scope="col">Productions '.$year.' avec texte intégral déposé dans HAL déposé dans HAL ou librement accessible hors HAL</th>');
      echo ('<th scope="col"></th>');
      echo ('</tr>');
      echo ('</thead>');
      
      if (isset($port) && $port != "choix") {
        $sectI = $LAB_SECT[1]["secteur"];
        $sectF = $LAB_SECT[1]["secteur"];
        $codeSI = $LAB_SECT[1]["code_secteur"];
        $codeSF = $LAB_SECT[1]["code_secteur"];
      }else{
        $sectI = $team;
        $sectF = $team;
        $codeSI = $team;
        $codeSF = $team;
      }
      $sect = array();
      $is = 1;

      while (isset($LAB_SECT[$ils]["code_collection"])) {
        $team = $LAB_SECT[$ils]["code_collection"];
        if ($ils != 0) {
          $sectF = $LAB_SECT[$ils]["secteur"];
          $codeSF = $LAB_SECT[$ils]["code_secteur"];
          if ($sectI != $sectF && isset($port) && $port != "choix") {//Total secteur à inclure
            extractHAL(strtoupper($codeSI), $year, $reqt, $resHAL);
            $chaine = "";
            echo ('<tr class="info">');
            echo ('<th scope="row"><i>Secteur '.$sectI.'</i></th>');
            $chaine .= "Secteur ".$sectI.";";
            echo ('<th scope="row"><i>'.$sectI.'</i></th>');
            $chaine .= $sectI.";";
            
            $sect[$is] = $sectI;
            $is++;
            $tabPro[$year][$sectI]["nfDep"] = $resHAL[$year][$codeSI]["nfDep"];
            echo ('<th scope="row" style="text-align:center"><i>'.$resHAL[$year][$codeSI]["nfDep"].'</i></th>');
            $chaine .= $resHAL[$year][$codeSI]["nfDep"].";";
            $pcent = 0;
            if ($resHAL[$year][$codeSI]["nfDep"] != 0) {$pcent = round($resHAL[$year][$codeSI]["nfDep"]*100/$resHAL[$year][$codeSI]["nfDep"]);}
            echo ('<th scope="row" style="text-align:center"><i>'.$pcent.'%</i></th>');
            $chaine .= $pcent."%;";
            
            $tabPro[$year][$sectI]["nfPronoTI"] = $resHAL[$year][$codeSI]["nfPronoTI"];
            echo ('<th scope="row" style="text-align:center"><i>'.$resHAL[$year][$codeSI]["nfPronoTI"].'</i></th>');
            $chaine .= $resHAL[$year][$codeSI]["nfPronoTI"].";";
            $pcent = 0;
            if ($resHAL[$year][$codeSI]["nfPronoTI"]) {$pcent = round($resHAL[$year][$codeSI]["nfPronoTI"]*100/$resHAL[$year][$codeSI]["nfDep"]);}
            echo ('<th scope="row" style="text-align:center"><i>'.$pcent.'%</i></th>');
            $chaine .= $pcent."%;";
            
            $tabPro[$year][$sectI]["nfProavTI"] = $resHAL[$year][$codeSI]["nfProavTI"];
            echo ('<th scope="row" style="text-align:center"><i>'.$resHAL[$year][$codeSI]["nfProavTI"].'</i></th>');
            $chaine .= $resHAL[$year][$codeSI]["nfProavTI"].";";
            $pcent = 0;
            if ($resHAL[$year][$codeSI]["nfProavTI"] != 0) {$pcent = round($resHAL[$year][$codeSI]["nfProavTI"]*100/$resHAL[$year][$codeSI]["nfDep"]);}
            echo ('<th scope="row" style="text-align:center"><i>'.$pcent.'%</i></th>');
            $chaine .= $pcent."%;";
            
            $tabPro[$year][$sectI]["nfPronoTIavOA"] = $resHAL[$year][$codeSI]["nfPronoTIavOA"];
            echo ('<th scope="row" style="text-align:center"><i>'.$resHAL[$year][$codeSI]["nfPronoTIavOA"].'</i></th>');
            $chaine .= $resHAL[$year][$codeSI]["nfPronoTIavOA"].";";
            $pcent = 0;
            if ($resHAL[$year][$codeSI]["nfPronoTIavOA"] != 0) {$pcent = round($resHAL[$year][$codeSI]["nfPronoTIavOA"]*100/$resHAL[$year][$codeSI]["nfDep"]);}
            echo ('<th scope="row" style="text-align:center"><i>'.$pcent.'%</i></th>');
            $chaine .= $pcent."%;";
            
            $tabPro[$year][$sectI]["nfProavTIavOA"] = $resHAL[$year][$codeSI]["nfProavTIavOA"];
            echo ('<th scope="row" style="text-align:center"><i>'.$resHAL[$year][$codeSI]["nfProavTIavOA"].'</i></th>');
            $chaine .= $resHAL[$year][$codeSI]["nfProavTIavOA"].";";
            $pcent = 0;
            if ($resHAL[$year][$codeSI]["nfProavTIavOA"] != 0) {$pcent = round($resHAL[$year][$codeSI]["nfProavTIavOA"]*100/$resHAL[$year][$codeSI]["nfDep"]);}
            echo ('<th scope="row" style="text-align:center"><i>'.$pcent.'%</i></th>');
            $chaine .= $pcent."%;";
            
            echo ('</tr>');
            echo ('</tbody>');
            $chaine .= chr(13).chr(10);
            fwrite($inF,$chaine);
            
            $sectI = $sectF;
            $codeSI = $codeSF;
          }
        }
        $chaine = "";
        extractHAL($team, $year, $reqt, $resHAL);
        echo ('<tbody>');    
        if ($ils == 0) {
          echo ('<tr class="warning">');
          if (isset($port) && $port != "choix") {
            $sect[0] = $LAB_SECT[$ils]["secteur"];
            $tabPro[$year][$sect[0]]["nfDep"] = intval($resHAL[$year][$team]["nfDep"]);
            $tabPro[$year][$sect[0]]["nfPronoTI"] = intval($resHAL[$year][$team]["nfPronoTI"]);
            $tabPro[$year][$sect[0]]["nfProavTI"] = intval($resHAL[$year][$team]["nfProavTI"]);
            $tabPro[$year][$sect[0]]["nfPronoTIavOA"] = intval($resHAL[$year][$team]["nfPronoTIavOA"]);
            $tabPro[$year][$sect[0]]["nfProavTIavOA"] = intval($resHAL[$year][$team]["nfProavTIavOA"]);
            echo ('<th scope="row">Tout '.$LAB_SECT[$ils]["code_collection"].'</th>');
            $chaine .= "Tout ".$LAB_SECT[$ils]["code_collection"].";";
          }else{
            echo ('<th scope="row">'.$LAB_SECT[$ils]["code_collection"].'</th>');
            $chaine .= $LAB_SECT[$ils]["code_collection"].";";
          }
        }else{
          echo ('<tr class="active">');
          echo ('<th scope="row">'.$LAB_SECT[$ils]["unite"].'</th>');
          $chaine .= $LAB_SECT[$ils]["unite"].";";
        }
        if ($ils == 0) {
          if (isset($port) && $port != "choix") {
            echo ('<th scope="row">A_Tous</th>');
            $chaine .= "A_Tous;";
          }else{
            echo ('<th scope="row"></th>');
            $chaine .= ";";
          }
        }else{
          echo ('<th scope="row">'.$LAB_SECT[$ils]["secteur"].'</th>');
          $chaine .= $LAB_SECT[$ils]["secteur"].";";
        }
        
        echo ('<th scope="row" style="text-align:center">'.$resHAL[$year][$team]["nfDep"].'</th>');
        if ($ils != 0) {$totDep = $resHAL[$year][$team]["nfDep"];}
        $chaine .= $resHAL[$year][$team]["nfDep"].";";
        $pcent = 0;
        if ($resHAL[$year][$team]["nfDep"] != 0) {$pcent = round($resHAL[$year][$team]["nfDep"]*100/$resHAL[$year][$team]["nfDep"]);}
        echo ('<th scope="row" style="text-align:center">'.$pcent.'%</th>');
        $chaine .= $pcent."%;";
        
        echo ('<th scope="row" style="text-align:center">'.$resHAL[$year][$team]["nfPronoTI"].'</th>');
        if ($ils != 0) {$totPronoTI = $resHAL[$year][$team]["nfPronoTI"];}
        $chaine .= $resHAL[$year][$team]["nfPronoTI"].";";
        $pcent = 0;
        if ($resHAL[$year][$team]["nfPronoTI"] != 0) {$pcent = round($resHAL[$year][$team]["nfPronoTI"]*100/$resHAL[$year][$team]["nfDep"]);}
        echo ('<th scope="row" style="text-align:center">'.$pcent.'%</th>');
        $chaine .= $pcent."%;";
        
        echo ('<th scope="row" style="text-align:center">'.$resHAL[$year][$team]["nfProavTI"].'</th>');
        if ($ils != 0) {$totProavTI = $resHAL[$year][$team]["nfProavTI"];}
        $chaine .= $resHAL[$year][$team]["nfProavTI"].";";
        $pcent = 0;
        if ($resHAL[$year][$team]["nfProavTI"] != 0) {$pcent = round($resHAL[$year][$team]["nfProavTI"]*100/$resHAL[$year][$team]["nfDep"]);}
        echo ('<th scope="row" style="text-align:center">'.$pcent.'%</th>');
        $chaine .= $pcent."%;";
        
        echo ('<th scope="row" style="text-align:center">'.$resHAL[$year][$team]["nfPronoTIavOA"].'</th>');
        if ($ils != 0) {$totPronoTIavOA = $resHAL[$year][$team]["nfPronoTIavOA"];}
        $chaine .= $resHAL[$year][$team]["nfPronoTIavOA"].";";
        $pcent = 0;
        if ($resHAL[$year][$team]["nfPronoTIavOA"] != 0) {$pcent = round($resHAL[$year][$team]["nfPronoTIavOA"]*100/$resHAL[$year][$team]["nfDep"]);}
        echo ('<th scope="row" style="text-align:center">'.$pcent.'%</th>');
        $chaine .= $pcent."%;";
        
        echo ('<th scope="row" style="text-align:center">'.$resHAL[$year][$team]["nfProavTIavOA"].'</th>');
        if ($ils != 0) {$totProavTIavOA = $resHAL[$year][$team]["nfProavTIavOA"];}
        $chaine .= $resHAL[$year][$team]["nfProavTIavOA"].";";
        $pcent = 0;
        if ($resHAL[$year][$team]["nfProavTIavOA"] != 0) {$pcent = round($resHAL[$year][$team]["nfProavTIavOA"]*100/$resHAL[$year][$team]["nfDep"]);}
        echo ('<th scope="row" style="text-align:center">'.$pcent.'%</th>');
        $chaine .= $pcent."%;";
        
        echo ('</tr>');
        echo ('</tbody>');
        $chaine .= chr(13).chr(10);
        fwrite($inF,$chaine);
        $atester = $LAB_SECT[$ils]["code_collection"];
        $ils++;
      }
      //Total dernier secteur à inclure
      if (isset($port) && $port != "choix") {
        $chaine = "";
        extractHAL(strtoupper($codeSF), $year, $reqt, $resHAL);
        echo ('<tr class="info">');
        echo ('<th scope="row"><i>Secteur '.$sectF.'</i></th>');
        $chaine .= "Secteur ".$sectF.";";
        echo ('<th scope="row"><i>'.$sectF.'</i></th>');
        $chaine .= $sectF.";";
        
        $sect[$is] = $sectF;
        $is++;
        $tabPro[$year][$sectF]["nfDep"] = $resHAL[$year][$codeSF]["nfDep"];
        $chaine .= $resHAL[$year][$codeSF]["nfDep"].";";
        echo ('<th scope="row" style="text-align:center"><i>'.$resHAL[$year][$codeSF]["nfDep"].'</i></th>');
        $pcent = 0;
        if ($resHAL[$year][$codeSF]["nfDep"] != 0) {$pcent = round($resHAL[$year][$codeSF]["nfDep"]*100/$resHAL[$year][$codeSF]["nfDep"]);}
        echo ('<th scope="row" style="text-align:center"><i>'.$pcent.'%</i></th>');
        $chaine .= $pcent."%;";
        
        $tabPro[$year][$sectF]["nfPronoTI"] = $resHAL[$year][$codeSF]["nfPronoTI"];
        echo ('<th scope="row" style="text-align:center"><i>'.$resHAL[$year][$codeSF]["nfPronoTI"].'</i></th>');
        $chaine .= $resHAL[$year][$codeSF]["nfPronoTI"].";";
        $pcent = 0;
        if ($resHAL[$year][$codeSF]["nfPronoTI"]) {$pcent = round($resHAL[$year][$codeSF]["nfPronoTI"]*100/$resHAL[$year][$codeSF]["nfDep"]);}
        echo ('<th scope="row" style="text-align:center"><i>'.$pcent.'%</i></th>');
        $chaine .= $pcent."%;";
        
        $tabPro[$year][$sectF]["nfProavTI"] = $resHAL[$year][$codeSF]["nfProavTI"];
        echo ('<th scope="row" style="text-align:center"><i>'.$resHAL[$year][$codeSF]["nfProavTI"].'</i></th>');
        $chaine .= $resHAL[$year][$codeSF]["nfProavTI"].";";
        $pcent = 0;
        if ($resHAL[$year][$codeSF]["nfProavTI"] != 0) {$pcent = round($resHAL[$year][$codeSF]["nfProavTI"]*100/$resHAL[$year][$codeSF]["nfDep"]);}
        echo ('<th scope="row" style="text-align:center"><i>'.$pcent.'%</i></th>');
        $chaine .= $pcent."%;";
        
        $tabPro[$year][$sectF]["nfPronoTIavOA"] = $resHAL[$year][$codeSF]["nfPronoTIavOA"];
        echo ('<th scope="row" style="text-align:center"><i>'.$resHAL[$year][$codeSF]["nfPronoTIavOA"].'</i></th>');
        $chaine .= $resHAL[$year][$codeSF]["nfPronoTIavOA"].";";
        $pcent = 0;
        if ($resHAL[$year][$codeSF]["nfPronoTIavOA"] != 0) {$pcent = round($resHAL[$year][$codeSF]["nfPronoTIavOA"]*100/$resHAL[$year][$codeSF]["nfDep"]);}
        echo ('<th scope="row" style="text-align:center"><i>'.$pcent.'%</i></th>');
        $chaine .= $pcent."%;";
        
        $tabPro[$year][$sectF]["nfProavTIavOA"] = $resHAL[$year][$codeSF]["nfProavTIavOA"];
        echo ('<th scope="row" style="text-align:center"><i>'.$resHAL[$year][$codeSF]["nfProavTIavOA"].'</i></th>');
        $chaine .= $resHAL[$year][$codeSF]["nfProavTIavOA"].";";
        $pcent = 0;
        if ($resHAL[$year][$codeSF]["nfProavTIavOA"] != 0) {$pcent = round($resHAL[$year][$codeSF]["nfProavTIavOA"]*100/$resHAL[$year][$codeSF]["nfDep"]);}
        echo ('<th scope="row" style="text-align:center"><i>'.$pcent.'%</i></th>');
        $chaine .= $pcent."%;";
        
        echo ('</tr>');
        echo ('</tbody>');
        $chaine .= chr(13).chr(10);
        fwrite($inF,$chaine);
      }
      echo ('</table>');
      echo ('<a href=\'./csv/req1.csv\'>Exporter le tableau au format CSV</a><br><br>');
    }
  }
  //var_dump($resHAL);
  
  //Tableau de résultats requête 2
  if ($reqt == "req2") {
		//Intitulé
		echo('<br><b>2. Portail ou collection : évolution sur une période</b><br><br>');
		
		//Descriptif
		echo('<div style="background-color:#f5f5f5">Cette requête présente, sur une période donnée, le nombre de publications référencées dans le portail HAL institutionnel (secteurs disciplinaires, le cas échéant) ou une collection, avec ou sans texte intégral, avec ou sans lien vers un PDF librement disponible hors de HAL (via <a target="_blank" href="https://unpaywall.org/">Unpaywall</a>). Pour le portail, les résultats sont déclinés par secteurs (le cas échéant). <a href="#DT">Voir détails techniques en bas de page</a>.</div><br>');
		
    //Export CSV
    $Fnm = "./csv/req2.csv";
    $inF = fopen($Fnm,"w+");
    fseek($inF, 0);
    $chaine = "\xEF\xBB\xBF";
    fwrite($inF,$chaine);
    
    echo ('<table class="table table-striped table-hover table-responsive table-bordered">');
    echo ('<thead>');
    echo ('<tr>');
    echo ('<th scope="col">&nbsp;</th>');
    $chaine = ";";
    $ils = 0;
    $sect = array();
    $is = 0;

    if (isset($port) && $port != "choix") {
      $sectI = $LAB_SECT[1]["secteur"];
      $sectF = $LAB_SECT[1]["secteur"];
      $codeSI = $LAB_SECT[1]["code_secteur"];
      $codeSF = $LAB_SECT[1]["code_secteur"];
    }else{
      $sectI = $team;
      $sectF = $team;
      $codeSI = $team;
      $codeSF = $team;
    }
    //Recherche des différents secteurs
    while (isset($LAB_SECT[$ils]["code_collection"])) {
      if ($ils == 0) {
        $sect[$is] = $LAB_SECT[$ils]["code_collection"];
        $is++;
        echo ('<th scope="col" colspan="6" style="text-align:center">'.$LAB_SECT[$ils]["code_collection"].'</th>');
        $chaine .= $LAB_SECT[$ils]["code_collection"].";;;;;;";
      }else{
        $sectF = $LAB_SECT[$ils]["secteur"];
        if ($sectI != $sectF && isset($port) && $port != "choix") {//Total secteur à inclure
          echo ('<th scope="col" colspan="6" style="text-align:center">'.$sectI.'</th>');
          $chaine .= $sectI.";;;;;;";
          $sect[$is] = $sectI;
          $sectI = $sectF;
          $codeSI = $codeSF;
          $is++;
        }
      }
      $ils++;
    }
    //Total dernier secteur à inclure
    if (isset($port) && $port != "choix") {
      echo ('<th scope="col" colspan="6" style="text-align:center">'.$sectF.'</th>');
      $chaine .= $sectF.";;;;;;";
      $sect[$is] = $sectF;
      $is++;
    }
    echo ('</tr>');
    $chaine .= chr(13).chr(10);
    fwrite($inF,$chaine);

    echo ('<tr>');
    echo ('<th scope="col">Année</th>');
    $chaine = "Année;";
    for($ils=0; $ils<$is; $ils++) {
      echo ('<th scope="col" style="text-align:center">Productions</th>');
      $chaine .= "Productions;";
      echo ('<th scope="col" style="text-align:center">Productions avec texte intégral déposé dans HAL</th>');
      $chaine .= "Productions avec texte intégral déposé dans HAL;";
      echo ('<th scope="col" style="text-align:center">Taux de texte intégral déposé dans HAL</th>');
      $chaine .= "Taux de texte intégral déposé dans HAL;";
      echo ('<th scope="col" style="text-align:center">Productions sans texte intégral déposé dans HAL</th>');
      $chaine .= "Productions sans texte intégral déposé dans HAL;";
      echo ('<th scope="col" style="text-align:center">Productions sans texte intégral déposé dans HAL mais avec texte intégral librement accessible hors HAL</th>');
      $chaine .= "Productions sans texte intégral déposé dans HAL mais avec texte intégral déposé dans HAL librement accessible hors HAL;";
      echo ('<th scope="col" style="text-align:center">Taux de productions sans texte intégral déposé dans HAL mais avec texte intégral déposé dans HAL librement accessible hors HAL</th>');
      $chaine .= "Taux de productions sans texte intégral déposé dans HAL mais avec texte intégral déposé dans HAL librement accessible hors HAL;";
    }   
    echo ('</tr>');
    echo ('</thead>');
    $chaine .= chr(13).chr(10);
    fwrite($inF,$chaine);
    
    //Calculs
    if (isset($port) && $port != "choix") {
      $sectI = $LAB_SECT[0]["secteur"];
      $sectF = $LAB_SECT[0]["secteur"];
      $codeSI = $LAB_SECT[0]["code_secteur"];
      $codeSF = $LAB_SECT[0]["code_secteur"];
    }else{
      $sectI = $team;
      $sectF = $team;
    }
  
    for($year = $anneedeb; $year <= $anneefin; $year++) {
      $ils = 0;
      $is = 0;
      while (isset($LAB_SECT[$ils]["code_collection"])) {
        if ($ils == 0) {
          $team = $LAB_SECT[$ils]["code_collection"];
          extractHAL($team, $year, $reqt, $resHAL);
          $tabPro[$year][$sect[$is]]["nfDep"] = intval($resHAL[$year][$team]["nfDep"]);
          $tabPro[$year][$sect[$is]]["nfProavTI"] = intval($resHAL[$year][$team]["nfProavTI"]);
          $tabPro[$year][$sect[$is]]["taux"] = 0;
          if ($resHAL[$year][$team]["nfDep"] != 0) {
            $tabPro[$year][$sect[$is]]["taux"] = round($resHAL[$year][$team]["nfProavTI"]*100/$resHAL[$year][$team]["nfDep"]);
          }
          $tabPro[$year][$sect[$is]]["nfPronoTI"] = intval($resHAL[$year][$team]["nfPronoTI"]);
          $tabPro[$year][$sect[$is]]["nfPronoTIavOA"] = intval($resHAL[$year][$team]["nfPronoTIavOA"]);
          $tabPro[$year][$sect[$is]]["tauxnoTIavOA"] = 0;
          if ($resHAL[$year][$team]["nfPronoTI"] != 0) {
            $tabPro[$year][$sect[$is]]["tauxnoTIavOA"] = round($resHAL[$year][$team]["nfPronoTIavOA"]*100/$resHAL[$year][$team]["nfPronoTI"]);
          }
          $is++;
        }else{
          $sectF = $LAB_SECT[$ils]["secteur"];
          if ($sectI != $sectF && isset($port) && $port != "choix") {//Secteur suivant
            $team = $LAB_SECT[$ils]["code_secteur"];
            extractHAL(strtoupper($team), $year, $reqt, $resHAL);
            $tabPro[$year][$sect[$is]]["nfDep"] = intval($resHAL[$year][$team]["nfDep"]);
            $tabPro[$year][$sect[$is]]["nfProavTI"] = intval($resHAL[$year][$team]["nfProavTI"]);
						$tabPro[$year][$sect[$is]]["taux"] = 0;
            if ($resHAL[$year][$team]["nfDep"] != 0) {
              $tabPro[$year][$sect[$is]]["taux"] = round($resHAL[$year][$team]["nfProavTI"]*100/$resHAL[$year][$team]["nfDep"]);
            }
            $tabPro[$year][$sect[$is]]["nfPronoTI"] = intval($resHAL[$year][$team]["nfPronoTI"]);
            $tabPro[$year][$sect[$is]]["nfPronoTIavOA"] = intval($resHAL[$year][$team]["nfPronoTIavOA"]);
            $tabPro[$year][$sect[$is]]["tauxnoTIavOA"] = 0;
            if ($resHAL[$year][$team]["nfPronoTI"] != 0) {
              $tabPro[$year][$sect[$is]]["tauxnoTIavOA"] = round($resHAL[$year][$team]["nfPronoTIavOA"]*100/$resHAL[$year][$team]["nfPronoTI"]);
            }
            $sectI = $sectF;
            $codeSI = $codeSF;
            $is++;
          }
        }
        $ils++;
      }
    }
    //var_dump($resHAL);
    //var_dump($tabPro);

    //Affichage
    echo ('<tbody>');
    for($year = $anneedeb; $year <= $anneefin; $year++) {
      echo ('<tr class="active">');
      echo ('<th scope="row">'.$year.'</th>');
      $chaine = $year.";";
      $is = 0;
      while (isset($sect[$is])) {
        echo ('<th scope="row" style="text-align:center">'.$tabPro[$year][$sect[$is]]["nfDep"].'</th>');
        $chaine .= $tabPro[$year][$sect[$is]]["nfDep"].";";
        echo ('<th scope="row" style="text-align:center">'.$tabPro[$year][$sect[$is]]["nfProavTI"].'</th>');
        $chaine .= $tabPro[$year][$sect[$is]]["nfProavTI"].";";
        echo ('<th scope="row" style="text-align:center">'.$tabPro[$year][$sect[$is]]["taux"].'%</th>');
        $chaine .= $tabPro[$year][$sect[$is]]["taux"]."%;";
        echo ('<th scope="row" style="text-align:center">'.$tabPro[$year][$sect[$is]]["nfPronoTI"].'</th>');
        $chaine .= $tabPro[$year][$sect[$is]]["nfPronoTI"].";";
        echo ('<th scope="row" style="text-align:center">'.$tabPro[$year][$sect[$is]]["nfPronoTIavOA"].'</th>');
        $chaine .= $tabPro[$year][$sect[$is]]["nfPronoTIavOA"].";";
        echo ('<th scope="row" style="text-align:center">'.$tabPro[$year][$sect[$is]]["tauxnoTIavOA"].'%</th>');
        $chaine .= $tabPro[$year][$sect[$is]]["tauxnoTIavOA"]."%;";
        $is++;
      }      
      echo ('</tr>');
      $chaine .= chr(13).chr(10);
      fwrite($inF,$chaine);
    }
    echo ('</tbody>');
    echo('</table>');
    echo ('<a href=\'./csv/req2.csv\'>Exporter le tableau au format CSV</a><br><br>');
  }
  
  //Tableau de résultats requête 3
  if ($reqt == "req3") {
		//Intitulé
		echo('<br><b>3. Portail : comparaison portailsComparaison portails</b><br><br>');
		
		//Descriptif
		echo('<div style="background-color:#f5f5f5">Cette requête permet de situer les données d’un portail institutionnel par rapport aux données d’autres portails (d’universités). Il indique, pour une année donnée, le nombre de publications (articles de revue) référencées dans le portail, avec ou sans texte intégral, incluant ou non un lien vers un PDF librement disponible hors de HAL (via <a target="_blank" href="https://unpaywall.org/">Unpaywall</a>). <a href="#DT">Voir détails techniques en bas de page</a>.</div><br>');
  
    //Export CSV
    $Fnm = "./csv/req3.csv";
    $inF = fopen($Fnm,"w+");
    fseek($inF, 0);
    $chaine = "\xEF\xBB\xBF";
    fwrite($inF,$chaine);
    
    $sect = array();
    $is = 0;

    echo ('<table class="table table-striped table-hover table-responsive table-bordered">');
    echo ('<thead>');
    echo ('<tr>');
    $chaine = "";
    echo ('<th scope="col" style="text-align:center">Articles dans une revue publiés en '.$annee3.' et référencés dans le portail HAL</th>');
    $chaine .= "Articles dans une revue publiés en ".$annee3." et référencés dans le portail HAL;";
    echo ('<th scope="col" style="text-align:center;background-color:#F2F2F2;">Articles</th>');
    $chaine .= "Articles;";
    //echo ('<th scope="col" style="text-align:center;background-color:#F2F2F2;">Rang</th>');
    //$chaine .= "Rang;";
    echo ('<th scope="col" style="text-align:center;background-color:#DDEBF7;">Articles '.$annee3.' sans texte intégral déposé dans HAL</th>');
    $chaine .= "Articles ".$annee3." sans texte intégral déposé dans HAL;";
    echo ('<th scope="col" style="text-align:center;background-color:#DDEBF7;">%</th>');
    $chaine .= "%;";
    //echo ('<th scope="col" style="text-align:center;background-color:#DDEBF7;">Rang</th>');
    //$chaine .= "Rang;";
    echo ('<th scope="col" style="text-align:center;background-color:#E2EFDA;">Articles '.$annee3.' avec texte intégral déposé dans HAL</th>');
    $chaine .= "Articles ".$annee3." avec texte intégral déposé dans HAL;";
    echo ('<th scope="col" style="text-align:center;background-color:#E2EFDA;">%</th>');
    $chaine .= "%;";
    //echo ('<th scope="col" style="text-align:center;background-color:#E2EFDA;">Rang</th>');
    //$chaine .= "Rang;";
    echo ('<th scope="col" style="text-align:center;background-color:#FFF2CC;">Articles '.$annee3.' avec texte intégral déposé dans HAL ou librement accessible hors HAL</th>');
    $chaine .= "Articles ".$annee3." avec texte intégral déposé dans HAL ou librement accessible hors HAL;";
    echo ('<th scope="col" style="text-align:center;background-color:#FFF2CC;">%</th>');
    $chaine .= "%;";
    //echo ('<th scope="col" style="text-align:center;background-color:#FFF2CC;">Rang</th>');
    //$chaine .= "Rang;";
    echo ('<th scope="col" style="text-align:center;background-color:#F4D9C7;">Articles '.$annee3.' sans texte intégral déposé dans HAL mais avec texte intégral déposé dans HAL librement accessible hors HAL</th>');
    $chaine .= "Articles ".$annee3." sans texte intégral déposé dans HAL mais avec texte intégral déposé dans HAL librement accessible hors HAL;";
    echo ('<th scope="col" style="text-align:center;background-color:#F4D9C7;">%</th>');
    $chaine .= "%;";
    //echo ('<th scope="col" style="text-align:center;background-color:#F4D9C7;">Rang</th>');
    //$chaine .= "Rang;";
    echo ('</tr>');
    echo ('</thead>');
    $chaine .= chr(13).chr(10);
    fwrite($inF,$chaine);
    
    //Résultats
    
    //Portail demandé
    $team = $LAB_SECT[0]["code_collection"];
    $year = $annee3;
    $sect[$is] = $team;
    extractHAL(strtolower($team), $year, $reqt, $resHAL);
    $tabPro[$team]["nfDep"] = intval($resHAL[$year][$team]["nfDep"]);
    $tabPro[$team]["nfPronoTI"] = intval($resHAL[$year][$team]["nfPronoTI"]);
    $tabPro[$team]["pCentnoTI"] = 0;
    $tabPro[$team]["nfProavTI"] = intval($resHAL[$year][$team]["nfProavTI"]);
    $tabPro[$team]["pCentavTI"] = 0;
    $tabPro[$team]["nfProavTIavOA"] = intval($resHAL[$year][$team]["nfProavTIavOA"]);
    $tabPro[$team]["pCentavTIavOA"] = 0;
    $tabPro[$team]["nfPronoTIavOA"] = intval($resHAL[$year][$team]["nfPronoTIavOA"]);
    $tabPro[$team]["pCentnoTIavOA"] = 0;
    if ($tabPro[$team]["nfDep"] != 0) {
      $tabPro[$team]["pCentnoTI"] = round($tabPro[$team]["nfPronoTI"]*100/$tabPro[$team]["nfDep"]);
      $tabPro[$team]["pCentavTI"] = round($tabPro[$team]["nfProavTI"]*100/$tabPro[$team]["nfDep"]);
      $tabPro[$team]["pCentavTIavOA"] = round($tabPro[$team]["nfProavTIavOA"]*100/$tabPro[$team]["nfDep"]);
      $tabPro[$team]["pCentnoTIavOA"] = round($tabPro[$team]["nfPronoTIavOA"]*100/$tabPro[$team]["nfDep"]);
    }
    $is++;
    
    //Autres portails
    include("./Portails-HAL.php");
    $urlHAL = "https://api.archives-ouvertes.fr/ref/instance/";
    askCurl($urlHAL, $arrayHAL);
    //var_dump($arrayHAL);
    $iHAL = 0;
    while (isset($arrayHAL["response"]["docs"][$iHAL]["code"])) {
    //while ($iHAL < 5) {
      $code = $arrayHAL["response"]["docs"][$iHAL]["code"];
      $name = $arrayHAL["response"]["docs"][$iHAL]["name"];
      if (strtoupper($code) != $team && stripos($name, "université") !== false && strtoupper($code) != "UDL") {//portail univ à intégrer + ignorer UDL
        $code = strtoupper($code);
        //if (isset($LAB_SECT[$code])) {$code = $LAB_SECT[$code];}//Equivalence trouvée
        $urlHALDep = "https://api.archives-ouvertes.fr/search/".strtolower($code)."/?wt=xml&fq=producedDateY_i:".$year."&fq=submitType_s:(notice OR file)&fq=docType_s:ART&fq=-status_i=111&rows=0";
        //echo $name.' - '.$code.' : '.askCurlNF($urlHALDep).'<br>';
        //if (askCurlNF($urlHALDep) == 0) {echo $urlHALDep.'<br>';}
        if (askCurlNF($urlHALDep) != 0 && $code != "") {//Y-a-t-il des résultats pour l'extraction avec ce code et cette année ?
          $sect[$is] = $code;
          extractHAL(strtolower($code), $year, $reqt, $resHAL);
          $tabPro[$code]["nfDep"] = intval($resHAL[$year][$code]["nfDep"]);
          $tabPro[$code]["nfPronoTI"] = intval($resHAL[$year][$code]["nfPronoTI"]);
          $tabPro[$code]["pCentnoTI"] = 0;
          $tabPro[$code]["nfProavTI"] = intval($resHAL[$year][$code]["nfProavTI"]);
          $tabPro[$code]["pCentavTI"] = 0;
          $tabPro[$code]["nfProavTIavOA"] = intval($resHAL[$year][$code]["nfProavTIavOA"]);
          $tabPro[$code]["pCentavTIavOA"] = 0;
          $tabPro[$code]["nfPronoTIavOA"] = intval($resHAL[$year][$code]["nfPronoTIavOA"]);
          $tabPro[$code]["pCentnoTIavOA"] = 0;
          if ($tabPro[$code]["nfDep"] != 0) {
            $tabPro[$code]["pCentnoTI"] = round($tabPro[$code]["nfPronoTI"]*100/$tabPro[$code]["nfDep"]);
            $tabPro[$code]["pCentavTI"] = round($tabPro[$code]["nfProavTI"]*100/$tabPro[$code]["nfDep"]);
            $tabPro[$code]["pCentavTIavOA"] = round($tabPro[$code]["nfProavTIavOA"]*100/$tabPro[$code]["nfDep"]);
            $tabPro[$code]["pCentnoTIavOA"] = round($tabPro[$code]["nfPronoTIavOA"]*100/$tabPro[$code]["nfDep"]);
          }
          $is++;
          //if ($is == 3) {break;}
        }
      }
      $iHAL++;
    }
    //var_dump($tabPro);
    
    //Calcul des rangs > ne doit plus être affiché ni servir au classement

    //noTIavOA
    $tabPro = array_orderby($tabPro, 'nfPronoTIavOA', SORT_DESC);
    $is = 1;
    foreach ($tabPro as $code => $t) {
      $tabPro[$code]["rgPronoTIavOA"] = $is;
      $is++;
    }
    
    //avTIavOA
    $tabPro = array_orderby($tabPro, 'nfProavTIavOA', SORT_DESC);
    $is = 1;
    foreach ($tabPro as $code => $t) {
      $tabPro[$code]["rgProavTIavOA"] = $is;
      $is++;
    }
    
    //avTI
    $tabPro = array_orderby($tabPro, 'nfProavTI', SORT_DESC);
    $is = 1;
    foreach ($tabPro as $code => $t) {
      $tabPro[$code]["rgProavTI"] = $is;
      $is++;
    }
    
    //noTI
    $tabPro = array_orderby($tabPro, 'nfPronoTI', SORT_DESC);
    $is = 1;
    foreach ($tabPro as $code => $t) {
      $tabPro[$code]["rgPronoTI"] = $is;
      $is++;
    }
        
    //nfDep
    $tabPro = array_orderby($tabPro, 'nfDep', SORT_DESC);
    $is = 1;
    foreach ($tabPro as $code => $t) {
      $tabPro[$code]["rgDep"] = $is;
      $is++;
    }
		
		ksort($tabPro);//Classement par ordre alphabétique
    
    //Affichage
    echo ('<tbody>');
    
    foreach ($tabPro as $code => $t) {
      if ($code == $team) {
        $evd = " class=\"warning\"";
        $evd1 = "";
        $evd2 = "";
        $evd3 = "";
        $evd4 = "";
        $evd5 = "";
      }else{
        $evd = "";
        $evd1 = "background-color:#F2F2F2;";
        $evd2 = "background-color:#DDEBF7;";
        $evd3 = "background-color:#E2EFDA;";
        $evd4 = "background-color:#FFF2CC;";
        $evd5 = "background-color:#F4D9C7;";
      }
      echo ('<tr'.$evd.'>'); 
      $chaine = "";
      echo ('<td scope="row" style="text-align:center">'.$code.'</td>');
      $chaine .= $code.";";
      echo ('<td scope="row" style="text-align:center;'.$evd1.'">'.$tabPro[$code]["nfDep"].'</td>');
      $chaine .= $tabPro[$code]["nfDep"].";";
      //echo ('<td scope="row" style="text-align:center;'.$evd1.'">'.$tabPro[$code]["rgDep"].'</td>');
      //$chaine .= $tabPro[$code]["rgDep"].";";
      echo ('<td scope="row" style="text-align:center;'.$evd2.'">'.$tabPro[$code]["nfPronoTI"].'</td>');
      $chaine .= $tabPro[$code]["nfPronoTI"].";";
      echo ('<td scope="row" style="text-align:center;'.$evd2.'">'.$tabPro[$code]["pCentnoTI"].'</td>');
      $chaine .= $tabPro[$code]["pCentnoTI"].";";
      //echo ('<td scope="row" style="text-align:center;'.$evd2.'">'.$tabPro[$code]["rgPronoTI"].'</td>');
      //$chaine .= $tabPro[$code]["rgPronoTI"].";";
      echo ('<td scope="row" style="text-align:center;'.$evd3.'">'.$tabPro[$code]["nfProavTI"].'</td>');
      $chaine .= $tabPro[$code]["nfProavTI"].";";
      echo ('<td scope="row" style="text-align:center;'.$evd3.'">'.$tabPro[$code]["pCentavTI"].'</td>');
      $chaine .= $tabPro[$code]["pCentavTI"].";";
      //echo ('<td scope="row" style="text-align:center;'.$evd3.'">'.$tabPro[$code]["rgProavTI"].'</td>');
      //$chaine .= $tabPro[$code]["rgProavTI"].";";
      echo ('<td scope="row" style="text-align:center;'.$evd4.'">'.$tabPro[$code]["nfProavTIavOA"].'</td>');
      $chaine .= $tabPro[$code]["nfProavTIavOA"].";";
      echo ('<td scope="row" style="text-align:center;'.$evd4.'">'.$tabPro[$code]["pCentavTIavOA"].'</td>');
      $chaine .= $tabPro[$code]["pCentavTIavOA"].";";
      //echo ('<td scope="row" style="text-align:center;'.$evd4.'">'.$tabPro[$code]["rgProavTIavOA"].'</td>');
      //$chaine .= $tabPro[$code]["rgProavTIavOA"].";";
      echo ('<td scope="row" style="text-align:center;'.$evd5.'">'.$tabPro[$code]["nfPronoTIavOA"].'</td>');
      $chaine .= $tabPro[$code]["nfPronoTIavOA"].";";
      echo ('<td scope="row" style="text-align:center;'.$evd5.'">'.$tabPro[$code]["pCentnoTIavOA"].'</td>');
      $chaine .= $tabPro[$code]["pCentnoTIavOA"].";";
      //echo ('<td scope="row" style="text-align:center;'.$evd5.'">'.$tabPro[$code]["rgPronoTIavOA"].'</td>');  
      //$chaine .= $tabPro[$code]["rgPronoTIavOA"].";";
      echo ('</tr>');
      $chaine .= chr(13).chr(10);
      fwrite($inF,$chaine);
    }
    echo ('</tbody>');
    echo ('</table>');
    echo ('<a href=\'./csv/req3.csv\'>Exporter le tableau au format CSV</a><br><br>');
  }
  
  //Tableau de résultats requête 4
  if ($reqt == "req4") {
		//Intitulé
		echo('<br><b>4. Portail : ESGBU (stocks et flux)</b><br><br>');
		
		//Descriptif
		echo('<div style="background-color:#f5f5f5">Cette requête fournit les 4 premiers indicateurs (stocks et flux) demandés dans l’enquête annuelle ESGBU pour l’archive ouverte. <a href="#DT">Voir détails techniques en bas de page</a>.</div><br>');
		
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
    
    $urlHALDep = "https://api.archives-ouvertes.fr/search/".strtolower($team)."/?wt=xml&fq=submitType_s:notice&fq=-status_i=111&fq=submittedDate_s:[1600-01-01-%20TO%20".$year."-12-31]&rows=0";
    $A01 = askCurlNF($urlHALDep);
    
    $urlHALDep = "https://api.archives-ouvertes.fr/search/".strtolower($team)."/?wt=xml&fq=submitType_s:file&fq=-status_i=111&fq=submittedDate_s:[1600-01-01-%20TO%20".$year."-12-31]&rows=0";
    $A02 = askCurlNF($urlHALDep);
    
    $urlHALDep = "https://api.archives-ouvertes.fr/search/".strtolower($team)."/?wt=xml&fq=submitType_s:notice&fq=-status_i=111&fq=submittedDate_s:[".$year."-01-01-%20TO%20".$year."-12-31]&rows=0";
    $A03 = askCurlNF($urlHALDep);
    
    $urlHALDep = "https://api.archives-ouvertes.fr/search/".strtolower($team)."/?wt=xml&fq=submitType_s:file&fq=-status_i=111&fq=submittedDate_s:[".$year."-01-01-%20TO%20".$year."-12-31]&rows=0";
    $A04 = askCurlNF($urlHALDep);
    
    //Affichage
    echo ('<br><table class="table table-striped table-hover table-responsive table-bordered" style="width:70%;">');
    echo ('<thead>');
    echo ('<tr>');
    echo ('<th scope="col" colspan="2" style="text-align:left"><b>STOCKS '.$team.' au 31.12.'.$year.'</b></th>');
    $chaine = "STOCKS ".$team." au 31.12.".$year.";;";
    echo ('</tr>');
    $chaine .= chr(13).chr(10);
    fwrite($inF,$chaine);
    echo ('</thead>');
    echo ('<tbody>');
    echo ('<tr>');
    echo ('<td scope="row" style="text-align:left;background-color:#C6D9F1;">A01 - Nombre d\'unités documentaires référencées dans le système de collecte sous forme de notices uniquement</td>');
    $chaine = "A01 - Nombre d'unités documentaires référencées dans le système de collecte sous forme de notices uniquement;";
    echo ('<td scope="row" style="text-align:left;background-color:#C6D9F1;">'.$A01.'</td>');
    $chaine .= $A01.";";
    echo ('</tr>');
    $chaine .= chr(13).chr(10);
    fwrite($inF,$chaine);
    echo ('<tr>');
    echo ('<td scope="row" style="text-align:left;background-color:#DCE6F2;">A02 - Nombre d\'unités documentaires référencées dans le système de collecte et déposées en texte intégral</td>');
    $chaine = "A02 - Nombre d\'unités documentaires référencées dans le système de collecte et déposées en texte intégral;";
    echo ('<td scope="row" style="text-align:left;background-color:#DCE6F2;">'.$A02.'</td>');
    $chaine .= $A02.";";
    echo ('</tr>');
    $chaine .= chr(13).chr(10);
    fwrite($inF,$chaine);
    echo ('<tr><td colspan="2">&nbsp;</td></tr>');
    echo ('</tbody>');
    
    echo ('<thead>');
    echo ('<tr>');
    echo ('<th scope="col" colspan="2" style="text-align:left"><b>FLUX sur l\'année civile '.$year.'</b></th>');
    $chaine = "FLUX sur l'année civile ".$year.";;";
    echo ('</tr>');
    $chaine .= chr(13).chr(10);
    fwrite($inF,$chaine);
    echo ('</thead>');
    echo ('<tbody>');
    echo ('<tr>');
    echo ('<td scope="row" style="text-align:left;background-color:#C6D9F1;">A03 - Accroissement annuel des unités documentaires référencées dans le système de collecte sous forme de notices uniquement</td>');
    $chaine = "A03 - Accroissement annuel des unités documentaires référencées dans le système de collecte sous forme de notices uniquement;";
    echo ('<td scope="row" style="text-align:left;background-color:#C6D9F1;">'.$A03.'</td>');
    $chaine .= $A03.";";
    echo ('</tr>');
    $chaine .= chr(13).chr(10);
    fwrite($inF,$chaine);
    echo ('<tr>');
    echo ('<td scope="row" style="text-align:left;background-color:#DCE6F2;">A04 - Accroissement annuel des unités documentaires référencées dans le système de collecte et déposées en texte intégral</td>');
    $chaine = "A04 - Accroissement annuel des unités documentaires référencées dans le système de collecte et déposées en texte intégral;";
    echo ('<td scope="row" style="text-align:left;background-color:#DCE6F2;">'.$A04.'</td>');
    $chaine .= $A04.";";
    echo ('</tr>');
    $chaine .= chr(13).chr(10);
    fwrite($inF,$chaine);
    echo ('</tbody>');
    
    
    echo ('</table>');
    echo ('<a href=\'./csv/req4.csv\'>Exporter le tableau au format CSV</a><br><br>');
  }
  
  //Tableau de résultats requête 5
  if ($reqt == "req5") {
		//Intitulé
		echo('<br><b>5. Portail ou Collection : Nombre de publications de type articles par éditeur</b><br><br>');
		
		//Descriptif
		echo('<div style="background-color:#f5f5f5">Cette requête présente le nombre d’articles de revues par éditeur pour une année donnée. Ne sont représentés que les principaux éditeurs et les articles HAL ayant un DOI (à l’exception des éditeurs Dalloz et Lextenso). Les autres éditeurs sont rassemblés sous l’appellation « Hors regroupement éditorial ». <a href="#DT">Voir détails techniques en bas de page</a>.</div><br>');
		
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
		extractHALnbPubEd($team, $year, "ART", $spefq, $nbTotArt, $nbPubEdRE);
		//var_dump($nbPubEdRE);
		//Affichage
    echo ('<br><table class="table table-striped table-hover table-responsive table-bordered" style="width:70%;">');
    echo ('<thead>');
    echo ('<tr>');
   	echo ('<th scope="col" style="text-align:left"><b>Regroupement éditorial</b></th>');
		echo ('<th scope="col" style="text-align:left"><b>Publications</b></th>');
		echo ('<th scope="col" style="text-align:left"><b>% articles</b></th>');
		$chaine = "Regroupement éditorial;Publications;% articles;";
    echo ('</tr>');
    $chaine .= chr(13).chr(10);
    fwrite($inF,$chaine);
		echo ('</thead>');
		echo ('<tbody>');
    for ($i=0; $i<count($nbPubEdRE); $i++) {
			echo ('<tr>');
			if ($nbPubEdRE[$i]["editeur_ng"] == "Hors regroupement éditorial") {
				$deb = "<i>";
				$fin = "</i>";
			}else{
				$deb = "";
				$fin = "";
			}
			echo ('<td>');
			echo ($deb.$nbPubEdRE[$i]["editeur_ng"].$fin);
			echo ('</td>');
			echo ('<td>');
			echo ($nbPubEdRE[$i]["nbArt"]);
			echo ('</td>');
			echo ('<td>');
			$pcentArt = ($nbTotArt != 0) ? number_format($nbPubEdRE[$i]["nbArt"]*100/$nbTotArt, 1) : 0;
			echo $pcentArt;
			echo ('%</td>');
			$chaine = $nbPubEdRE[$i]["editeur_ng"].";".$nbPubEdRE[$i]["nbArt"].";".$pcentArt.";";
			echo ('</tr>');
			$chaine .= chr(13).chr(10);
			fwrite($inF,$chaine);
		}
		echo ('</tbody>');
		echo ('</table>');
		echo ('<a href=\'./csv/req5.csv\'>Exporter le tableau au format CSV</a><br><br>');
  }
	
	//Tableau de résultats requête 6
  if ($reqt == "req6") {
		//Intitulé
		echo('<br><b>6. Portail ou Collection : Nombre de publications de type communications par éditeur</b><br><br>');
		
		//Descriptif
		echo('<div style="background-color:#f5f5f5">Cette requête présente le nombre de communications par éditeur pour une année donnée. Ne sont représentés que les principaux éditeurs et les dépôts HAL ayant un DOI. Les autres éditeurs sont rassemblés sous l’appellation « Hors regroupement éditorial ». <a href="#DT">Voir détails techniques en bas de page</a>.</div><br>');
		
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
		extractHALnbPubEd($team, $year, "COMM", $spefq, $nbTotArt, $nbPubEdRE);
		//var_dump($nbPubEdRE);
		//Affichage
    echo ('<br><table class="table table-striped table-hover table-responsive table-bordered" style="width:70%;">');
    echo ('<thead>');
    echo ('<tr>');
   	echo ('<th scope="col" style="text-align:left"><b>Regroupement éditorial</b></th>');
		echo ('<th scope="col" style="text-align:left"><b>Publications</b></th>');
		echo ('<th scope="col" style="text-align:left"><b>% articles</b></th>');
    $chaine = "Regroupement éditorial;Publications;% articles;";
    echo ('</tr>');
    $chaine .= chr(13).chr(10);
    fwrite($inF,$chaine);
		echo ('</thead>');
		echo ('<tbody>');
    for ($i=0; $i<count($nbPubEdRE); $i++) {
			echo ('<tr>');
			if ($nbPubEdRE[$i]["editeur_ng"] == "Hors regroupement éditorial") {
				$deb = "<i>";
				$fin = "</i>";
			}else{
				$deb = "";
				$fin = "";
			}
			echo ('<td>');
			echo ($deb.$nbPubEdRE[$i]["editeur_ng"].$fin);
			echo ('</td>');
			echo ('<td>');
			echo ($nbPubEdRE[$i]["nbArt"]);
			echo ('</td>');
			echo ('<td>');
			$pcentArt = ($nbTotArt != 0) ? number_format($nbPubEdRE[$i]["nbArt"]*100/$nbTotArt, 1) : 0;
			echo $pcentArt;
			echo ('%</td>');
			echo ('</tr>');
			$chaine = $nbPubEdRE[$i]["editeur_ng"].";".$nbPubEdRE[$i]["nbArt"].";".$pcentArt.";";
			echo ('</tr>');
			$chaine .= chr(13).chr(10);
			fwrite($inF,$chaine);
		}
		echo ('</tbody>');
		echo ('</table>');
		echo ('<a href=\'./csv/req6.csv\'>Exporter le tableau au format CSV</a><br><br>');
  }
	
	//Tableau de résultats requête 7
  if ($reqt == "req7") {
		//Intitulé
		echo('<br><b>7. Portail ou Collection : Nombre de publications (articles de revue) par revue</b><br><br>');
		
		//Descriptif
		echo('<div style="background-color:#f5f5f5">Cette requête présente le nombre d’articles présents dans le portail ou la collection, avec ou sans texte intégral, par revue. <a href="#DT">Voir détails techniques en bas de page</a>.</div><br>');
		
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
		
		$urlHAL = "https://api.archives-ouvertes.fr/search/".$team."/?q=*%3A*&rows=0&indent=true&facet=true&facet.pivot=journalTitle_s,journalPublisher_s,journalValid_s&fq=-status_i=111&fq=docType_s:ART&fq=producedDateY_i:".$year;
		askCurl($urlHAL, $arrayCurl);
		$nbTotArt = $arrayCurl["response"]["numFound"];
		$pivot = "journalTitle_s,journalPublisher_s,journalValid_s";
		
		//Affichage
		echo ('<div id="cpt"></div>');
		echo ('<b>'.$nbTotArt.' publications :</b>');
    echo ('<br><table class="table table-striped table-hover table-responsive table-bordered" style="width:100%;">');
    echo ('<thead>');
    echo ('<tr>');
   	echo ('<th scope="col" style="text-align:left"><b>Revues</b></th>');
		echo ('<th scope="col" style="text-align:left"><b>Publications</b></th>');
		echo ('<th scope="col" style="text-align:left"><b>% articles</b></th>');
		echo ('<th scope="col" style="text-align:left"><b>Editeurs</b></th>');
		echo ('<th scope="col" style="text-align:left"><b># texte intégral déposé dans HAL</b></th>');
		echo ('<th scope="col" style="text-align:left"><b>% texte intégral déposé dans HAL</b></th>');
		$chaine = "Revues;Publications;% articles;Editeur;# texte intégral déposé dans HAL;% texte intégral déposé dans HAL;";
    echo ('</tr>');
    $chaine .= chr(13).chr(10);
    fwrite($inF,$chaine);
		echo ('</thead>');
		echo ('<tbody>');
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
				$urlTitle = "https://api.archives-ouvertes.fr/search/".$team."/?q=*%3A*&rows=0&indent=true&wt=xml&facet=true&facet.pivot=journalTitle_s,journalPublisher_s,journalValid_s&fq=-status_i=111&fq=submitType_s:file&fq=docType_s:ART&fq=journalTitle_s:%22".$jTitle."%22&fq=producedDateY_i:".$year;
				$nbTotArtTI = askCurlNF($urlTitle);
				echo ('<tr>');
				$nbTotArti = $arrayCurl["facet_counts"]["facet_pivot"][$pivot][$i]["count"];
				$somme += $nbTotArti;
				echo ('<td>'. $arrayCurl["facet_counts"]["facet_pivot"][$pivot][$i]["value"].'</td>');
				echo ('<td>'. $nbTotArti.'</td>');
				$pcentArt = ($nbTotArt != 0) ? number_format($nbTotArti*100/$nbTotArt, 2) : 0;
				echo ('<td>'.$pcentArt.'%</td>');
				$editeur = "-";
				if (isset($arrayCurl["facet_counts"]["facet_pivot"][$pivot][$i]["pivot"][0]["value"])) {$editeur = $arrayCurl["facet_counts"]["facet_pivot"][$pivot][$i]["pivot"][0]["value"];}
				echo ('<td>'. $editeur.'</td>');
				echo ('<td>'.$nbTotArtTI.'</td>');
				$pcentArtTI = ($nbTotArti != 0) ? number_format($nbTotArtTI*100/$nbTotArti, 1) : 0;
				echo ('<td>'.$pcentArtTI.'%</td>');
				$chaine = $arrayCurl["facet_counts"]["facet_pivot"][$pivot][$i]["value"].";";
				$chaine .= $nbTotArti.";";
				$chaine .= $pcentArt.";";
				$chaine .= $editeur.";";
				$chaine .= $nbTotArtTI.";";
				$chaine .= $pcentArtTI.";";
				echo ('</tr>');
				$chaine .= chr(13).chr(10);
				fwrite($inF,$chaine);
			}
		}
		echo ('</tbody>');
		echo ('</table>');
		echo ('<script>');
		echo ('  document.getElementById("cpt").style.display = "none";');
		echo ('</script>');
		//echo ($somme.'<br>');
		echo ('<a href=\'./csv/req7.csv\'>Exporter le tableau au format CSV</a><br><br>');
	}

	//Tableau de résultats requêtes 8 et 9 > seuls les pourcentages finaux représentent des indices différents
  if ($reqt == "req8" || $reqt == "req9") {
		if ($reqt == "req8") {
			//Intitulé
			echo('<br><b>8. Portail : Pourcentage par secteur des articles de tel éditeur</b><br><br>');
			
			//Descriptif
			echo('<div style="background-color:#f5f5f5">Requête masquée : abandon car on dépasse les limites d’exécution du script.</div><br>');
		}else{
			//Intitulé
			echo('<br><b>9. Portail : Pourcentage par éditeur des articles de tel secteur</b><br><br>');
			
			//Descriptif
			echo('<div style="background-color:#f5f5f5">Requête masquée : abandon car on dépasse les limites d’exécution du script.</div><br>');
		}
		
    //Export CSV
    ($reqt == "req8") ? $Fnm = "./csv/req8.csv" : $Fnm = "./csv/req9.csv";
    $inF = fopen($Fnm,"w+");
    fseek($inF, 0);
    $chaine = "\xEF\xBB\xBF";
    fwrite($inF,$chaine);
    
		($reqt == "req8") ? $year = $annee8 : $year = $annee9;
		
		$chaine = "";
		echo ('<table class="table table-striped table-hover table-responsive table-bordered">');
    echo ('<thead>');
    echo ('<tr>');
    echo ('<th scope="col">Articles '.$year.' '.$LAB_SECT[0]['code_secteur'].' par regroupement éditorial</th>');
		$chaine .= 'Articles '.$year.' '.$LAB_SECT[0]['code_secteur'].' par regroupement éditorial;';
		$ils = 1;
    $sect = array();
    $is = 0;
		
		if (isset($port) && $port != "choix") {
      $sectI = $LAB_SECT[1]["secteur"];
      $sectF = $LAB_SECT[1]["secteur"];
    }
		
		//Recherche des différents secteurs
    while (isset($LAB_SECT[$ils]["secteur"])) {
			$sectF = $LAB_SECT[$ils]["secteur"];
			if ($sectI != $sectF && isset($port) && $port != "choix") {//Secteur à afficher
				echo ('<th scope="col" colspan="2" style="text-align:center">'.$sectI.'</th>');
				$chaine .= $sectI.";;";
				$sect[$is] = $sectI;
				$sectI = $sectF;
				$is++;
			}
      $ils++;
    }
		
		//Dernier secteur à afficher
    if (isset($port) && $port != "choix") {
      echo ('<th scope="col" colspan="2" style="text-align:center">'.$sectF.'</th>');
      $chaine .= $sectF.";;";
      $sect[$is] = $sectF;
      $is++;
    }
		
		//Code portail à ajouter au tableau sect
		$is++;
    $sect[$is] = $LAB_SECT[0]["secteur"];    
		
		//Code portail à afficher
		if (isset($port) && $port != "choix") {
      echo ('<th scope="col" colspan="2" style="text-align:center">'.$LAB_SECT[0]['code_secteur'].'</th>');
			$chaine .= $LAB_SECT[0]['code_secteur'].";;";
		}
		
		echo ('</tr>');
    $chaine .= chr(13).chr(10);
    fwrite($inF,$chaine);
		
		//var_dump($sect);
		
		$resHAL = array();
		$ils = 0;

		//Parcourir les collections
		while (isset($LAB_SECT[$ils]["code_secteur"])) {
			$team = $LAB_SECT[$ils]["code_collection"];
			
			$urlHAL = "https://api.archives-ouvertes.fr/search/".$team."/?q=*%3A*&fq=producedDateY_i:".$year."&indent=true&facet=true&facet.pivot=journalPublisher_s,journalValid_s,producedDateY_i&fq=docType_s:ART&fq=-status_i=111&rows=0";
			//echo $urlHAL.'<br>';
			$url = str_replace(" ", "%20", $urlHAL);
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_HEADER, 0);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_USERAGENT, 'SCD (https://halur1.univ-rennes1.fr)');
			curl_setopt($ch, CURLOPT_USERAGENT, 'PROXY (http://siproxy.univ-rennes1.fr)');
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			$json = curl_exec($ch);
			curl_close($ch);
			
			if (!empty($json)) {
				$parsed_json = json_decode($json, true);
				$arrayCurl = objectToArray($parsed_json);
				$cTab = $arrayCurl['facet_counts']['facet_pivot']['journalPublisher_s,journalValid_s,producedDateY_i'];
				$i = 0;
				while (isset($cTab[$i])) {
					if ($cTab[$i]['pivot'][0]['value'] == "VALID") {
						//echo $LAB_SECT[$ils]["secteur"].'-'.$team.' - '.$cTab[$i]['value'].' - '.$cTab[$i]['pivot'][0]['count'].'<br>';
						if (isset($resHAL[$cTab[$i]['value']][$LAB_SECT[$ils]["secteur"]])) {
							$resHAL[$cTab[$i]['value']][$LAB_SECT[$ils]["secteur"]] += $cTab[$i]['pivot'][0]['count'];
						}else{
							$resHAL[$cTab[$i]['value']][$LAB_SECT[$ils]["secteur"]] = $cTab[$i]['pivot'][0]['count'];
						}
					}
					$i++;
				}
			}
			$ils++;
		}
		
		//Si total pour un éditeur pour le portail n'est pas défini, assigner 0 > nécessaire pour le tri du tableau
		foreach ($resHAL as $key => $val) {
			if (!isset($resHAL[$key][$LAB_SECT[0]['secteur']])) {$resHAL[$key][$LAB_SECT[0]['secteur']] = 0;}
		}
		
		//Calcul des totaux par secteur tout éditeur confondu = "regroupement éditorial"
		$totSect = array();
		foreach ($resHAL as $key1 => $val1) {
			foreach ($sect as $key2 => $val2) {
				if (!isset($val1[$val2])) {
					(!isset($totSect[$val2])) ? $totSect[$val2] = 0 : $totSect[$val2] += 0;
				}else{
					(!isset($totSect[$val2])) ? $totSect[$val2] = $val1[$val2] : $totSect[$val2] += $val1[$val2];
				}
			}
		}

		//Calcul initial temporaire des "Hors regroupement éditorial"
		$ils = 0;
		while (isset($LAB_SECT[$ils]["secteur"])) {
			$code_collection = strtoupper($LAB_SECT[$ils]["code_collection"]);
			$urlHAL = "https://api.archives-ouvertes.fr/search/".$code_collection."/?wt=xml&fq=producedDateY_i:".$year."&fq=submitType_s:(notice%20OR%20file)&fq=docType_s:ART&fq=-status_i=111";
			$qteArt = askCurlNF($urlHAL);
			if (isset($resHAL["Hors regroupement éditorial"][$LAB_SECT[$ils]["secteur"]])) {
				$resHAL["Hors regroupement éditorial"][$LAB_SECT[$ils]["secteur"]] += intval($qteArt);
			}else{
				$resHAL["Hors regroupement éditorial"][$LAB_SECT[$ils]["secteur"]] = intval($qteArt);
			}
			$ils++;
		}
		
		//Calcul final des totaux et "Hors regroupement éditorial" par secteur
		foreach ($sect as $key => $val) {
			$vartemp = $totSect[$val];
			$totSect[$val] = $resHAL["Hors regroupement éditorial"][$val];
			$resHAL["Hors regroupement éditorial"][$val] -= $vartemp;
		}

		//Tri du tableau selon les totaux obtenus
		$totPort = array();
		foreach ($resHAL as $key => $val) {
			$totPort[$key] = $val[$LAB_SECT[0]['secteur']];
		}
		$totPort = array_column($resHAL, $LAB_SECT[0]['secteur']);
		array_multisort($totPort, SORT_DESC, $resHAL);

		//Construction du tableau
		//Totaux par secteur tout éditeur confondu
		$chaine = "";
		echo ('<tr>');
    echo ('<th scope="col">TOTAL</th>');
		$chaine .= "TOTAL;";
		foreach ($totSect as $key => $val) {
			echo ('<th scope="col">'.$val.'</th>');
			($reqt == "req8") ? $pcent = 100 : $pcent = ($val * 100) / $totSect[$LAB_SECT[0]['secteur']];
			echo ('<th scope="col">'.number_format($pcent, 1).'%</th>');
			($reqt == "req8") ? $chaine .= $val.";".number_format($pcent, 1).";" : $chaine .= $val.";".number_format($pcent, 1)."%;";
		}
		echo ('</th>');
		echo ('</tr>');
		$chaine .= chr(13).chr(10);
    fwrite($inF,$chaine);
		
		//Totaux par secteur et par éditeur
		foreach ($resHAL as $key1 => $val1) {
			$chaine = "";
			echo ('<tr>');
			echo ('<td scope="row">'.$key1.'</td>');
			$chaine .= str_replace(";", "-", $key1).";";
			foreach ($sect as $key2 => $val2) {
				if (isset($val1[$val2]) && $val1[$LAB_SECT[0]['secteur']] != 0) {
					echo ('<td scope="row">'.$val1[$val2].'</td>');
					$chaine .= $val1[$val2].";";
					($reqt == "req8") ? $pcent = ($val1[$val2] * 100) / $totSect[$val2] : $pcent = ($val1[$val2] * 100) / $val1[$LAB_SECT[0]['secteur']];
				}else{
					echo ('<td scope="row">0</td>');
					$chaine .= "0;";
					$pcent = 0;
				}
				echo ('<td scope="row">'.number_format($pcent, 1).'%</td>');
				$chaine .= number_format($pcent, 1)."%;";
			}
			echo ('</tr>');
			$chaine .= chr(13).chr(10);
			fwrite($inF,$chaine);
		}
		
		echo ('</table>');
    ($reqt == "req8") ? $nf = "req8" : $nf = "req9";
		echo ('<a href=\'./csv/'.$nf.'.csv\'>Exporter le tableau au format CSV</a><br><br>');
		//var_dump($resHAL);	
	}
	
	//Tableau de résultats requête 10
  if ($reqt == "req10") {
		//Intitulé
		echo('<br><b>10. Collection : Nombre d\'articles sans texte intégral déposé dans HAL par éditeur</b><br><br>');
		
		//Descriptif
		echo('<div style="background-color:#f5f5f5">Cette requête présente le nombre d’articles de revue, sans texte intégral, par éditeur et pour une année donnée. Ne sont représentés que les principaux éditeurs et les articles HAL ayant un DOI (à l’exception des éditeurs Dalloz et Lextenso). Les autres éditeurs sont rassemblés sous l’appellation « Hors regroupement éditorial ».  <a href="#DT">Voir détails techniques en bas de page</a>.</div><br>');
		
		//Export CSV
    $Fnm = "./csv/req10.csv";
    $inF = fopen($Fnm,"w+");
    fseek($inF, 0);
    $chaine = "\xEF\xBB\xBF";
    fwrite($inF,$chaine);
		
		$year = $annee10;
		
		$spefq = "&fq=submitType_s:notice";
		extractHALnbPubEd($team, $year, "ART", $spefq, $nbTotArt, $nbPubEdRE);
		//var_dump($nbPubEdRE);
		//Affichage
    echo ('<br><table class="table table-striped table-hover table-responsive table-bordered" style="width:70%;">');
    echo ('<thead>');
    echo ('<tr>');
   	echo ('<th scope="col" style="text-align:left"><b>Regroupement éditorial</b></th>');
		echo ('<th scope="col" style="text-align:left"><b>Nombre d\'articles sans texte intégral déposé dans HAL</b></th>');
		$chaine = "Regroupement éditorial;Nombre d'articles sans texte intégral déposé dans HAL;";
    echo ('</tr>');
    $chaine .= chr(13).chr(10);
    fwrite($inF,$chaine);
		echo ('</thead>');
		echo ('<tbody>');
    for ($i=0; $i<count($nbPubEdRE); $i++) {
			echo ('<tr>');
			if ($nbPubEdRE[$i]["editeur_ng"] == "Hors regroupement éditorial") {
				$deb = "<i>";
				$fin = "</i>";
			}else{
				$deb = "";
				$fin = "";
			}
			echo ('<td>');
			echo ($deb.$nbPubEdRE[$i]["editeur_ng"].$fin);
			echo ('</td>');
			echo ('<td>');
			echo ($nbPubEdRE[$i]["nbArt"]);
			echo ('</td>');
			$chaine = $nbPubEdRE[$i]["editeur_ng"].";".$nbPubEdRE[$i]["nbArt"].";";
			echo ('</tr>');
			$chaine .= chr(13).chr(10);
			fwrite($inF,$chaine);
		}
		echo ('</tbody>');
		echo ('</table>');
		echo ('<a href=\'./csv/req10.csv\'>Exporter le tableau au format CSV</a><br><br>');
  }
	
	//Tableau de résultats requête 11
  if ($reqt == "req11") {
		//Intitulé
		echo('<br><b>11. Collection : Nombre d\'articles avec texte intégral déposé dans HAL par éditeur</b><br><br>');
		
		//Descriptif
		echo('<div style="background-color:#f5f5f5">Cette requête présente le nombre d’articles de revue, avec texte intégral, par éditeur et pour une année donnée. Ne sont représentés que les principaux éditeurs et les articles HAL ayant un DOI (à l’exception des éditeurs Dalloz et Lextenso). Les autres éditeurs sont rassemblés sous l’appellation « Hors regroupement éditorial ».  <a href="#DT">Voir détails techniques en bas de page</a>.</div><br>');
		
		//Export CSV
    $Fnm = "./csv/req11.csv";
    $inF = fopen($Fnm,"w+");
    fseek($inF, 0);
    $chaine = "\xEF\xBB\xBF";
    fwrite($inF,$chaine);
		
		$year = $annee11;
		
		$spefq = "&fq=submitType_s:file";
		extractHALnbPubEd($team, $year, "ART", $spefq, $nbTotArt, $nbPubEdRE);
		//var_dump($nbPubEdRE);
		//Affichage
    echo ('<br><table class="table table-striped table-hover table-responsive table-bordered" style="width:70%;">');
    echo ('<thead>');
    echo ('<tr>');
   	echo ('<th scope="col" style="text-align:left"><b>Regroupement éditorial</b></th>');
		echo ('<th scope="col" style="text-align:left"><b>Nombre d\'articles avec texte intégral déposé dans HAL</b></th>');
		$chaine = "Regroupement éditorial;Nombre d'articles avec texte intégral déposé dans HAL;";
    echo ('</tr>');
    $chaine .= chr(13).chr(10);
    fwrite($inF,$chaine);
		echo ('</thead>');
		echo ('<tbody>');
    for ($i=0; $i<count($nbPubEdRE); $i++) {
			echo ('<tr>');
			if ($nbPubEdRE[$i]["editeur_ng"] == "Hors regroupement éditorial") {
				$deb = "<i>";
				$fin = "</i>";
			}else{
				$deb = "";
				$fin = "";
			}
			echo ('<td>');
			echo ($deb.$nbPubEdRE[$i]["editeur_ng"].$fin);
			echo ('</td>');
			echo ('<td>');
			echo ($nbPubEdRE[$i]["nbArt"]);
			echo ('</td>');
			$chaine = $nbPubEdRE[$i]["editeur_ng"].";".$nbPubEdRE[$i]["nbArt"].";";
			echo ('</tr>');
			$chaine .= chr(13).chr(10);
			fwrite($inF,$chaine);
		}
		echo ('</tbody>');
		echo ('</table>');
		echo ('<a href=\'./csv/req11.csv\'>Exporter le tableau au format CSV</a><br><br>');
  }
	
	//Tableau de résultats requête 12
  if ($reqt == "req12") {
		//Intitulé
		echo('<br><b>12. Collection : Nombre d\'articles avec texte intégral déposé dans HAL OU lien externe vers PDF en open access par éditeur</b><br><br>');
		
		//Descriptif
		echo('<div style="background-color:#f5f5f5">Cette requête présente le nombre d’articles de revue, avec texte intégral ou avec un lien vers un PDF librement disponible hors de HAL (via <a target="_blank" href="https://unpaywall.org/">Unpaywall</a>), par éditeur et pour une année donnée. Ne sont représentés que les principaux éditeurs et les articles HAL ayant un DOI (à l’exception des éditeurs Dalloz et Lextenso). Les autres éditeurs sont rassemblés sous l’appellation « Hors regroupement éditorial ».  <a href="#DT">Voir détails techniques en bas de page</a>.</div><br>');
		
		//Export CSV
    $Fnm = "./csv/req12.csv";
    $inF = fopen($Fnm,"w+");
    fseek($inF, 0);
    $chaine = "\xEF\xBB\xBF";
    fwrite($inF,$chaine);
		
		$year = $annee12;
		
		$spefq = "&fq=(submitType_s:file%20OR%20linkExtId_s:*)";
		extractHALnbPubEd($team, $year, "ART", $spefq, $nbTotArt, $nbPubEdRE);
		//var_dump($nbPubEdRE);
		//Affichage
    echo ('<br><table class="table table-striped table-hover table-responsive table-bordered" style="width:70%;">');
    echo ('<thead>');
    echo ('<tr>');
   	echo ('<th scope="col" style="text-align:left"><b>Regroupement éditorial</b></th>');
		echo ('<th scope="col" style="text-align:left"><b>Nombre d\'articles avec texte intégral déposé dans HAL OU lien externe vers PDF en open access</b></th>');
		$chaine = "Regroupement éditorial;Nombre d'articles avec texte intégral déposé dans HAL OU lien externe vers PDF en open access;";
    echo ('</tr>');
    $chaine .= chr(13).chr(10);
    fwrite($inF,$chaine);
		echo ('</thead>');
		echo ('<tbody>');
    for ($i=0; $i<count($nbPubEdRE); $i++) {
			echo ('<tr>');
			if ($nbPubEdRE[$i]["editeur_ng"] == "Hors regroupement éditorial") {
				$deb = "<i>";
				$fin = "</i>";
			}else{
				$deb = "";
				$fin = "";
			}
			echo ('<td>');
			echo ($deb.$nbPubEdRE[$i]["editeur_ng"].$fin);
			echo ('</td>');
			echo ('<td>');
			echo ($nbPubEdRE[$i]["nbArt"]);
			echo ('</td>');
			$chaine = $nbPubEdRE[$i]["editeur_ng"].";".$nbPubEdRE[$i]["nbArt"].";";
			echo ('</tr>');
			$chaine .= chr(13).chr(10);
			fwrite($inF,$chaine);
		}
		echo ('</tbody>');
		echo ('</table>');
		echo ('<a href=\'./csv/req12.csv\'>Exporter le tableau au format CSV</a><br><br>');
  }
	
	//Tableau de résultats requête 13
  if ($reqt == "req13") {
		//Intitulé
		echo('<br><b>13. Portail ou collection : évolution sur une et trois années</b><br><br>');
		
		//Descriptif
		echo('<div style="background-color:#f5f5f5">Cette requête mesure la progression du nombre de dépôts, avec ou sans texte intégral ou avec un lien vers un PDF librement disponible hors de HAL (via <a target="_blank" href="https://unpaywall.org/">Unpaywall</a>), sur 1 et 3 années, à partir de l’année de référence saisie par l’utilisateur. La comparaison 1 / 3 ans permet le cas échéant de relativiser une baisse ou une augmentation sur 1 an, afin de vérifier s’il s’agit d’une tendance de fond, ou au contraire d’un changement circonstanciel. <a href="#DT">Voir détails techniques en bas de page</a>.</div><br>');
		
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
				extractHAL($team, $year, $reqt, $resHAL);
			}
		}
		
		if (isset($resHAL[$annee13-1][$team]["nfPronoTI"]) && isset($resHAL[$annee13-1][$team]["nfProavTI"]) && ($resHAL[$annee13-1][$team]["nfPronoTI"] + $resHAL[$annee13-1][$team]["nfProavTI"]) != 0) {
			$pct1noavTI = round((($resHAL[$annee13][$team]["nfPronoTI"] + $resHAL[$annee13][$team]["nfProavTI"]) - ($resHAL[$annee13-1][$team]["nfPronoTI"] + $resHAL[$annee13-1][$team]["nfProavTI"]))*100/($resHAL[$annee13-1][$team]["nfPronoTI"] + $resHAL[$annee13-1][$team]["nfProavTI"]), 1);
		}else{
			$pct1noavTI = 0;
		}
		if (isset($resHAL[$annee13-1][$team]["nfProavTI"]) && $resHAL[$annee13-1][$team]["nfProavTI"] != 0) {
			$pct1avTI = round(($resHAL[$annee13][$team]["nfProavTI"] - $resHAL[$annee13-1][$team]["nfProavTI"])*100/$resHAL[$annee13-1][$team]["nfProavTI"], 1);
		}else{
			$pct1avTI = 0;
		}
		if (isset($resHAL[$annee13-1][$team]["nfProavTIavOA"]) && $resHAL[$annee13-1][$team]["nfProavTIavOA"] != 0) {
			$pct1avTIavOA = round(($resHAL[$annee13][$team]["nfProavTIavOA"] - $resHAL[$annee13-1][$team]["nfProavTIavOA"])*100/$resHAL[$annee13-1][$team]["nfProavTIavOA"], 1);
		}else{
			$pct1avTIavOA = 0;
		}
		if (isset($resHAL[$annee13-1][$team]["nfPronoTIavOA"]) && $resHAL[$annee13-1][$team]["nfPronoTIavOA"] != 0) {
			$pct1noTIavOA = round(($resHAL[$annee13][$team]["nfPronoTIavOA"] - $resHAL[$annee13-1][$team]["nfPronoTIavOA"])*100/$resHAL[$annee13-1][$team]["nfPronoTIavOA"], 1);
		}else{
			$pct1noTIavOA = 0;
		}
		
		if (isset($resHAL[$annee13-3][$team]["nfPronoTI"]) && isset($resHAL[$annee13-3][$team]["nfProavTI"]) && ($resHAL[$annee13-3][$team]["nfPronoTI"] + $resHAL[$annee13-3][$team]["nfProavTI"]) != 0) {
			$pct3noavTI = round((($resHAL[$annee13][$team]["nfPronoTI"] + $resHAL[$annee13][$team]["nfProavTI"]) - ($resHAL[$annee13-3][$team]["nfPronoTI"] + $resHAL[$annee13-3][$team]["nfProavTI"]))*100/($resHAL[$annee13-3][$team]["nfPronoTI"] + $resHAL[$annee13-3][$team]["nfProavTI"]), 1);
		}else{
			$pct3noavTI = 0;
		}
		if (isset($resHAL[$annee13-3][$team]["nfProavTI"]) && $resHAL[$annee13-3][$team]["nfProavTI"] != 0) {
			$pct3avTI = round(($resHAL[$annee13][$team]["nfProavTI"] - $resHAL[$annee13-3][$team]["nfProavTI"])*100/$resHAL[$annee13-3][$team]["nfProavTI"], 1);
		}else{
			$pct3avTI = 0;
		}
		if (isset($resHAL[$annee13-3][$team]["nfProavTIavOA"]) && $resHAL[$annee13-3][$team]["nfProavTIavOA"] != 0) {
			$pct3avTIavOA = round(($resHAL[$annee13][$team]["nfProavTIavOA"] - $resHAL[$annee13-3][$team]["nfProavTIavOA"])*100/$resHAL[$annee13-3][$team]["nfProavTIavOA"], 1);
		}else{
			$pct3avTIavOA = 0;
		}
		if (isset($resHAL[$annee13-3][$team]["nfPronoTIavOA"]) && $resHAL[$annee13-3][$team]["nfPronoTIavOA"] != 0) {
			$pct3noTIavOA = round(($resHAL[$annee13][$team]["nfPronoTIavOA"] - $resHAL[$annee13-3][$team]["nfPronoTIavOA"])*100/$resHAL[$annee13-3][$team]["nfPronoTIavOA"], 1);
		}else{
			$pct3noTIavOA = 0;
		}
		
		//Export CSV
		//Colonnes
		$chaine = $team." - ".$annee13.";Sur 1 an;Sur 3 ans;";
		$chaine .= chr(13).chr(10);
		fwrite($inF,$chaine);
		
		echo ('<table class="table table-striped table-hover table-responsive table-bordered">');
		echo ('<thead>');
		echo ('<tr>');
		echo ('<th scope="col"><font color="red">'.$team.' - '.$annee13.'</font></th>');
		echo ('<th scope="col" colspan="2" style="text-align:center">Sur 1 an</th>');
		echo ('<th scope="col" colspan="2" style="text-align:center">Sur 3 ans</th>');
		echo ('</tr>');
    echo ('</thead>');
		
		echo ('<tbody>');
		
		$chaine = "Publications avec ou sans texte intégral déposé dans HAL;";
		echo ('<tr>');
    echo ('<th scope="row">Publications avec ou sans texte intégral déposé dans HAL <a class=info onclick=\'return false\' href="#"><img src="./img/pdi.jpg"><span>Nombre total de publications référencées dans HAL. Une baisse peut signaler soit une baisse de la production, soit une baisse du référencement (dépôt par les auteurs et/ou des intermédiaires), soit le cas échéant un problème de <b>visibilité</b> de la production dans les bases bibliographiques (WoS, Pubmed, Scopus…), qui peut aussi être lié à un problème de <b>signature</b> (affiliation insuffisante ou erronée).</span></a></th>');
		($pct1noavTI > 0) ? $img = './img/hausse.png' : (($pct1noavTI < 0) ? $img = './img/baisse.png' : $img = './img/zero.png');
		echo ('<th scope="row" style="text-align:center"><img src='.$img.'></th>');
		echo ('<th scope="row" style="text-align:center">'.signe($pct1noavTI).' %</th>');
		$chaine .= signe($pct1noavTI)."%;";
		($pct3noavTI > 0) ? $img = './img/hausse.png' : (($pct3noavTI < 0) ? $img = './img/baisse.png' : $img = './img/zero.png');
		echo ('<th scope="row" style="text-align:center"><img src='.$img.'></th>');
		echo ('<th scope="row" style="text-align:center">'.signe($pct3noavTI).' %</th>');
		$chaine .= signe($pct3noavTI)."%;";
		echo ('</tr>');
		$chaine .= chr(13).chr(10);
		fwrite($inF,$chaine);
		
		$chaine = "Publications avec texte intégral déposé dans HAL;";
		echo ('<tr>');
    echo ('<th scope="row">Publications avec texte intégral déposé dans HAL</th>');
		($pct1avTI > 0) ? $img = './img/hausse.png' : (($pct1avTI < 0) ? $img = './img/baisse.png' : $img = './img/zero.png');
		echo ('<th scope="row" style="text-align:center"><img src='.$img.'></th>');
		echo ('<th scope="row" style="text-align:center">'.signe($pct1avTI).' %</th>');
		$chaine .= signe($pct1avTI)."%;";
		($pct3avTI > 0) ? $img = './img/hausse.png' : (($pct3avTI < 0) ? $img = './img/baisse.png' : $img = './img/zero.png');
		echo ('<th scope="row" style="text-align:center"><img src='.$img.'></th>');
		echo ('<th scope="row" style="text-align:center">'.signe($pct3avTI).' %</th>');
		$chaine .= signe($pct3avTI)."%;";
		echo ('</tr>');
		$chaine .= chr(13).chr(10);
		fwrite($inF,$chaine);
		
		$chaine = "Publications avec texte intégral déposé dans HAL + lien externe vers PDF en open access;";
		echo ('<tr>');
    echo ('<th scope="row">Publications avec texte intégral déposé dans HAL + lien externe vers PDF en open access <a class=info onclick=\'return false\' href="#"><img src="./img/pdi.jpg"><span>Taux global d’open access : texte intégral déposé dans HAL ou référence HAL avec un lien vers un PDF librement disponible hors de HAL (via Unpaywall > https://unpaywall.org/). </span></a></th>');
		($pct1avTIavOA > 0) ? $img = './img/hausse.png' : (($pct1avTIavOA < 0) ? $img = './img/baisse.png' : $img = './img/zero.png');
		echo ('<th scope="row" style="text-align:center"><img src='.$img.'></th>');
		echo ('<th scope="row" style="text-align:center">'.signe($pct1avTIavOA).' %</th>');
		$chaine .= signe($pct1avTIavOA)."%;";
		($pct3avTIavOA > 0) ? $img = './img/hausse.png' : (($pct3avTIavOA < 0) ? $img = './img/baisse.png' : $img = './img/zero.png');
		echo ('<th scope="row" style="text-align:center"><img src='.$img.'></th>');
		echo ('<th scope="row" style="text-align:center">'.signe($pct3avTIavOA).' %</th>');
		$chaine .= signe($pct3avTIavOA)."%;";
		echo ('</tr>');
		$chaine .= chr(13).chr(10);
		fwrite($inF,$chaine);
		
		$chaine = "Publications sans texte intégral déposé dans HAL + lien externe vers PDF en open access;";
		echo ('<tr>');
    echo ('<th scope="row">Publications sans texte intégral déposé dans HAL + lien externe vers PDF en open access <a class=info onclick=\'return false\' href="#"><img src="./img/pdi.jpg"><span>Références HAL sans texte intégral, mais avec un lien vers l’article en open access sur le site de la revue. Une baisse peut simplement signifier que les auteurs ont ajouté massivement dans HAL le PDF de ces articles. Une hausse peut également signifier un recours accru à la publication dans des revues en open access, et/ou au paiement de frais de mise en open access des articles.</span></a></th>');
		($pct1noTIavOA > 0) ? $img = './img/hausse.png' : (($pct1noTIavOA < 0) ? $img = './img/baisse.png' : $img = './img/zero.png');
		echo ('<th scope="row" style="text-align:center"><img src='.$img.'></th>');
		echo ('<th scope="row" style="text-align:center">'.signe($pct1noTIavOA).' %</th>');
		$chaine .= signe($pct1noTIavOA)."%;";
		($pct3noTIavOA > 0) ? $img = './img/hausse.png' : (($pct3noTIavOA < 0) ? $img = './img/baisse.png' : $img = './img/zero.png');
		echo ('<th scope="row" style="text-align:center"><img src='.$img.'></th>');
		echo ('<th scope="row" style="text-align:center">'.signe($pct3noTIavOA).' %</th>');
		$chaine .= signe($pct3noTIavOA)."%;";
		echo ('</tr>');
		$chaine .= chr(13).chr(10);
		fwrite($inF,$chaine);
		
		echo ('</tbody>');
		echo ('</table>');
		
    echo ('<a href=\'./csv/req13a.csv\'>Exporter le tableau au format CSV</a><br><br>');
		
		
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
				extractHAL($team, $year, $reqt, $resHAL);
			}
		}
		
		//Export CSV
		//Colonnes
		$chaine = $team." - ".$annee13.";Sur 1 an;Sur 3 ans;";
		$chaine .= chr(13).chr(10);
		fwrite($inF,$chaine);
		
		echo ('<table class="table table-striped table-hover table-responsive table-bordered">');
		echo ('<thead>');
		echo ('<tr>');
		echo ('<th scope="col"><font color="red">'.$team.' - '.$annee13.'</font></th>');
		echo ('<th scope="col" style="text-align:center">'.($annee13 - 3).'</th>');
		echo ('<th scope="col" style="text-align:center">'.($annee13 - 1).'</th>');
		echo ('<th scope="col" style="text-align:center">'.$annee13.'</th>');
		echo ('</tr>');
    echo ('</thead>');
		
		echo ('<tbody>');
		
		$chaine = "Publications avec ou sans texte intégral déposé dans HAL;";
		echo ('<tr>');
    echo ('<th scope="row">Publications avec ou sans texte intégral déposé dans HAL</th>');
		echo ('<th scope="row" style="text-align:center">'.($resHAL[$annee13-3][$team]["nfPronoTI"] + $resHAL[$annee13-3][$team]["nfProavTI"]).'</th>');
		$chaine .= ($resHAL[$annee13-3][$team]["nfPronoTI"] + $resHAL[$annee13-3][$team]["nfProavTI"]).";";
		echo ('<th scope="row" style="text-align:center">'.($resHAL[$annee13-1][$team]["nfPronoTI"] + $resHAL[$annee13-1][$team]["nfProavTI"]).'</th>');
		$chaine .= ($resHAL[$annee13-1][$team]["nfPronoTI"] + $resHAL[$annee13-1][$team]["nfProavTI"]).";";
		echo ('<th scope="row" style="text-align:center">'.($resHAL[$annee13][$team]["nfPronoTI"] + $resHAL[$annee13][$team]["nfProavTI"]).'</th>');
		$chaine .= ($resHAL[$annee13][$team]["nfPronoTI"] + $resHAL[$annee13][$team]["nfProavTI"]).";";
		echo ('</tr>');
		$chaine .= chr(13).chr(10);
		fwrite($inF,$chaine);
		
		$chaine = "Publications avec texte intégral déposé dans HAL;";
		echo ('<tr>');
    echo ('<th scope="row">Publications avec texte intégral déposé dans HAL</th>');		
		echo ('<th scope="row" style="text-align:center">'.$resHAL[$annee13-3][$team]["nfProavTI"].'</th>');
		$chaine .= $resHAL[$annee13-3][$team]["nfProavTI"].";";
		echo ('<th scope="row" style="text-align:center">'.$resHAL[$annee13-1][$team]["nfProavTI"].'</th>');
		$chaine .= $resHAL[$annee13-1][$team]["nfProavTI"].";";
		echo ('<th scope="row" style="text-align:center">'.$resHAL[$annee13][$team]["nfProavTI"].'</th>');
		$chaine .= $resHAL[$annee13][$team]["nfProavTI"].";";
		echo ('</tr>');
		$chaine .= chr(13).chr(10);
		fwrite($inF,$chaine);
		
		$chaine = "Publications avec texte intégral déposé dans HAL + lien externe vers PDF en open access;";
		echo ('<tr>');
    echo ('<th scope="row">Publications avec texte intégral déposé dans HAL + lien externe vers PDF en open access</th>');
		echo ('<th scope="row" style="text-align:center">'.$resHAL[$annee13-3][$team]["nfProavTIavOA"].'</th>');
		$chaine .= $resHAL[$annee13-3][$team]["nfProavTIavOA"].";";
		echo ('<th scope="row" style="text-align:center">'.$resHAL[$annee13-1][$team]["nfProavTIavOA"].'</th>');
		$chaine .= $resHAL[$annee13-1][$team]["nfProavTIavOA"].";";
		echo ('<th scope="row" style="text-align:center">'.$resHAL[$annee13][$team]["nfProavTIavOA"].'</th>');
		$chaine .= $resHAL[$annee13][$team]["nfProavTIavOA"].";";
		echo ('</tr>');
		$chaine .= chr(13).chr(10);
		fwrite($inF,$chaine);
		
		$chaine = "Publications sans texte intégral déposé dans HAL + lien externe vers PDF en open access;";
		echo ('<tr>');
    echo ('<th scope="row">Publications sans texte intégral déposé dans HAL + lien externe vers PDF en open access</th>');
		echo ('<th scope="row" style="text-align:center">'.$resHAL[$annee13-3][$team]["nfPronoTIavOA"].'</th>');
		$chaine .= $resHAL[$annee13-3][$team]["nfPronoTIavOA"].";";
		echo ('<th scope="row" style="text-align:center">'.$resHAL[$annee13-1][$team]["nfPronoTIavOA"].'</th>');
		$chaine .= $resHAL[$annee13-1][$team]["nfPronoTIavOA"].";";
		echo ('<th scope="row" style="text-align:center">'.$resHAL[$annee13][$team]["nfPronoTIavOA"].'</th>');
		$chaine .= $resHAL[$annee13][$team]["nfPronoTIavOA"].";";
		echo ('</tr>');
		$chaine .= chr(13).chr(10);
		fwrite($inF,$chaine);
		
		echo ('</tbody>');
		echo ('</table>');
		
    echo ('<a href=\'./csv/req13b.csv\'>Exporter le tableau au format CSV</a><br><br>');
  }
  //var_dump($resHAL);
	
	//Tableau de résultats requête 14
  if ($reqt == "req14") {
		//Intitulé
		echo('<br><b>14. Collection : Nombre de projets ANR</b><br><br>');
		
		//Descriptif
		echo('<div style="background-color:#f5f5f5">Cette requête présente la liste des projets ANR d’une collection, avec pour chaque projet le nombre et la liste des publications HAL. En fin de tableau figurent sous la mention « à compléter » les projets mentionnés dans le champ « financement » des dépôts HAL mais pour lesquels il manque la forme validée du référentiel*. Cette requête ne prend en effet en compte que les projets référencés dans le champ ANR des dépôts HAL. <a href="#DT">Voir détails techniques en bas de page</a>.<br><br><i>(*) : Vous pouvez ainsi rechercher dans la collection HAL les notices concernées (recherche avancée dans le champ « financement »), et compléter les projets manquants dans le champ ANR.</i></div><br>');
		
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
			$urlANR = "https://api.archives-ouvertes.fr/search/".$team."/?fq=producedDateY_i:".$year."&fl=anrProjectId_i,anrProjectAcronym_s,funding_s,anrProjectId_i,anrProjectReference_s&rows=10000";
			askCurl($urlANR, $arrayCurl);
			$nbTotANR = $arrayCurl["response"]["numFound"];
			//echo ('<br>Total potentiel de '.$nbTotANR.' projets ANR pour '.$team.' en '.$year.'.');
			
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
								$urlPub = "https://api.archives-ouvertes.fr/search/".$team."/?fq=producedDateY_i:".$year."&fq=anrProjectId_i:".$arrayCurl["response"]["docs"][$i]["anrProjectId_i"][$k]."&rows=10000";
								askCurl($urlPub, $arrayPub);
								$nbTotPub = $arrayPub["response"]["numFound"];
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
										//echo ('<tr><td>'.$nbANR.'</td><td>'.$ANRTab[$j].'</td><td>-</td><td>-</td><td>-</td></tr>');
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
		echo ('<tbody>');
		//var_dump($resANR);
		if (count($resANR) > 0) {//Au moins 1 résultat
			//Début de l'affichage
			echo ('<br><table class="table table-striped table-hover table-responsive table-bordered">');
			echo ('<thead>');
			echo ('<tr>');
			echo ('<th scope="col" style="text-align:left"></th>');
			echo ('<th scope="col" style="text-align:left"><b>Acronyme</b></th>');
			echo ('<th scope="col" style="text-align:left"><b>Référence du projet ANR</b></th>');
			echo ('<th scope="col" style="text-align:left"><b>Nombre de dépôts HAL contenant cette référence</b></th>');
			echo ('<th scope="col" style="text-align:left"><b>Liste des publications</b></th>');
			$chaine = "Acronyme;Référence du projet;Nombre de dépôts HAL contenant cette référence;Liste des publications;";
			echo ('</tr>');
			$chaine .= chr(13).chr(10);
			fwrite($inF,$chaine);
			echo ('</thead>');
		
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
				echo('<tr><td>'.$idPro.'</td>');
				echo('<td>'.$resANRfin["Acronyme"][$nbANRfin].'</td>');
				$chaine = $resANRfin["Acronyme"][$nbANRfin].";";
				echo('<td>'.$resANRfin["Reference"][$nbANRfin].'</td>');
				$chaine .= $resANRfin["Reference"][$nbANRfin].";";
				echo('<td>'.$resANRfin["Nombre"][$nbANRfin].'</td>');
				$chaine .= $resANRfin["Nombre"][$nbANRfin].";";
				echo('<td>'.$resANRfin["Liste"][$nbANRfin].'</td></tr>');
				$listeCSV = substr($resANRfin["ListeCSV"][$nbANRfin], 0, (strlen($resANRfin["ListeCSV"][$nbANRfin]) - 7));
				$chaine .= str_replace(array('&#x27E8;','&#x27E9;'),array('(',')'), $listeCSV).";";
				$chaine .= chr(13).chr(10);
				fwrite($inF,$chaine);
				$nbANRfin++;
			}
			echo ('</tbody>');
			echo ('</table><br>');
			
			echo ('<a href=\'./csv/req14.csv\'>Exporter le tableau au format CSV</a><br><br>');
		}else{
			echo ('<b>Aucun résultat</b><br><br>');
		}
  }
	
	//Tableau de résultats requête 15
  if ($reqt == "req15") {
		//Intitulé
		echo('<br><b>15. Collection : Nombre de projets européens</b><br><br>');
		
		//Descriptif
		echo('<div style="background-color:#f5f5f5">Cette requête présente la liste des projets européens d’une collection, avec pour chaque projet le nombre et la liste des publications HAL. En fin de tableau figurent sous la mention « à compléter » les projets mentionnés dans le champ « financement » des dépôts HAL mais pour lesquels il manque la forme validée du référentiel*. Cette requête ne prend en effet en compte que les projets référencés dans le champ projet européen des dépôts HAL. <a href="#DT">Voir détails techniques en bas de page</a>.<br><br><i>(*) : Vous pouvez ainsi rechercher dans la collection HAL les notices concernées (recherche avancée dans le champ « financement »), et compléter les projets manquants dans le champ ANR.</i></div><br>');
		
		//Export CSV
    $Fnm = "./csv/req15.csv";
    $inF = fopen($Fnm,"w+");
    fseek($inF, 0);
    $chaine = "\xEF\xBB\xBF";
    fwrite($inF,$chaine);
		
		$nbEUR = 1;
		$resEUR = array();
		$listEURProId = "~";
		
		for ($year = $anneedeb; $year <= $anneefin; $year++) {
			$urlEUR = "https://api.archives-ouvertes.fr/search/".$team."/?fq=producedDateY_i:".$year."&fl=europeanProjectId_i,europeanProjectAcronym_s,funding_s,europeanProjectId_i,europeanProjectReference_s&rows=10000";
			askCurl($urlEUR, $arrayCurl);
			$nbTotEUR = $arrayCurl["response"]["numFound"];
			//echo ('<br>Total potentiel de '.$nbTotEUR.' projets EUR pour '.$team.' en '.$year.'.');
			
			$i = 0;
			while (isset($arrayCurl["response"]["docs"][$i])) {
				if (isset($arrayCurl["response"]["docs"][$i]["europeanProjectId_i"][0])){
					$k = 0;
					while (isset($arrayCurl["response"]["docs"][$i]["europeanProjectId_i"][$k])) {//Il y a parfois plusieurs Id
						if (strpos($listEURProId, strval($arrayCurl["response"]["docs"][$i]["europeanProjectId_i"][$k]."-".$year)) === false) {//On vérifie que ce projet n'a pas déjà été affiché
							$listEURProId .= strval($arrayCurl["response"]["docs"][$i]["europeanProjectId_i"][$k]."-".$year)."~";
							//Référence du projet
							if(isset($arrayCurl["response"]["docs"][$i]["europeanProjectReference_s"][$k])) {
								$resEUR["Reference"][$nbEUR] = ucfirst($arrayCurl["response"]["docs"][$i]["europeanProjectReference_s"][$k]);
							}else{
								$resEUR["Reference"][$nbEUR] = "-";
							}
							//Acronyme du projet
							if(isset($arrayCurl["response"]["docs"][$i]["europeanProjectAcronym_s"][$k])) {
								$resEUR["Acronyme"][$nbEUR] = ucfirst($arrayCurl["response"]["docs"][$i]["europeanProjectAcronym_s"][$k]);
							}else{
								$resEUR["Acronyme"][$nbEUR] = "-";
							}
							//Nombre total de publications pour ce projet et cette année
							if (isset($arrayCurl["response"]["docs"][$i]["europeanProjectId_i"][$k])) {
								$urlPub = "https://api.archives-ouvertes.fr/search/".$team."/?fq=producedDateY_i:".$year."&fq=europeanProjectId_i:".$arrayCurl["response"]["docs"][$i]["europeanProjectId_i"][$k]."&rows=10000";
								askCurl($urlPub, $arrayPub);
								$nbTotPub = $arrayPub["response"]["numFound"];
								$resEUR["Nombre"][$nbEUR] = $nbTotPub;
								//Liste des publications
								$j = 0;
								$resEUR["Liste"][$nbEUR] = "";
								$resEUR["ListeCSV"][$nbEUR] = "";
								while (isset($arrayPub["response"]["docs"][$j])) {
									$uri_s = $arrayPub["response"]["docs"][$j]["uri_s"];
									//Ne mettre un lien que sur l'identifiant HAL
									$tabId = explode("/", $uri_s);
									$idHAL = $tabId[count($tabId)-1];
									$label = str_replace($idHAL, '<a target="_blank" href="'.$uri_s.'">'.$idHAL.'</a>', $arrayPub["response"]["docs"][$j]["label_s"]);
									$resEUR["Liste"][$nbEUR] .= $label.'<br><br>';
									$resEUR["ListeCSV"][$nbEUR] .= $arrayPub["response"]["docs"][$j]["label_s"].'   -   ';
									$j++;
								}
								$nbEUR++;
							}
						}
						$k++;
					}
				}
				$i++;
			}
		}
		echo ('<tbody>');
		//var_dump($resEUR);
		if (count($resEUR) > 0) {//Au moins 1 résultat
			//Classement du tableau par ordre alphabétique des acronymes puis affichage
			array_multisort($resEUR["Acronyme"], SORT_ASC, SORT_FLAG_CASE, $resEUR["Reference"], $resEUR["Nombre"], $resEUR["Liste"], $resEUR["ListeCSV"]);
			
			//Début de l'affichage
			echo ('<br><table class="table table-striped table-hover table-responsive table-bordered">');
			echo ('<thead>');
			echo ('<tr>');
			echo ('<th scope="col" style="text-align:left"></th>');
			echo ('<th scope="col" style="text-align:left"><b>Acronyme</b></th>');
			echo ('<th scope="col" style="text-align:left"><b>Référence du projet européen</b></th>');
			echo ('<th scope="col" style="text-align:left"><b>Nombre de dépôts HAL contenant cette référence</b></th>');
			echo ('<th scope="col" style="text-align:left"><b>Liste des publications</b></th>');
			$chaine = "Acronyme;Référence du projet;Nombre de dépôts HAL contenant cette référence;Liste des publications;";
			echo ('</tr>');
			$chaine .= chr(13).chr(10);
			fwrite($inF,$chaine);
			echo ('</thead>');
			
			//Regroupement des lignes de projets identiques mais d'années différentes
			$resEURfin = array();
			$nbEUR = 0;
			$nbEURfin = 0;
			while (isset($resEUR["Reference"][$nbEUR])) {
				if ($nbEUR == 0) {$acro = $resEUR["Acronyme"][0];}
				if ($acro == $resEUR["Acronyme"][$nbEUR] && $acro != "-" && $nbEUR != 0) {//2 lignes successives avec le même acronyme > regroupement
					$resEURfin["Nombre"][$nbEURfin-1] += $resEUR["Nombre"][$nbEUR];
					$resEURfin["Liste"][$nbEURfin-1] .= $resEUR["Liste"][$nbEUR];
					$resEURfin["ListeCSV"][$nbEURfin-1] .= $resEUR["ListeCSV"][$nbEUR];
				}else{//Nouvel enregistrement dans le tableau final
					$resEURfin["Acronyme"][$nbEURfin] = $resEUR["Acronyme"][$nbEUR];
					$resEURfin["Reference"][$nbEURfin] = $resEUR["Reference"][$nbEUR];
					$resEURfin["Nombre"][$nbEURfin] = $resEUR["Nombre"][$nbEUR];
					$resEURfin["Liste"][$nbEURfin] = $resEUR["Liste"][$nbEUR];
					$resEURfin["ListeCSV"][$nbEURfin] = $resEUR["ListeCSV"][$nbEUR];
					$nbEURfin++;
					$acro = $resEUR["Acronyme"][$nbEUR];
				}
				$nbEUR++;
			}

			//Affichage du tableau final
			$nbEURfin = 0;
			while (isset($resEURfin["Reference"][$nbEURfin])) {
				$idPro = $nbEURfin + 1;
				echo('<tr><td>'.$idPro.'</td>');
				echo('<td>'.$resEURfin["Acronyme"][$nbEURfin].'</td>');
				$chaine = $resEURfin["Acronyme"][$nbEURfin].";";
				echo('<td>'.$resEURfin["Reference"][$nbEURfin].'</td>');
				$chaine .= $resEURfin["Reference"][$nbEURfin].";";
				echo('<td>'.$resEURfin["Nombre"][$nbEURfin].'</td>');
				$chaine .= $resEURfin["Nombre"][$nbEURfin].";";
				echo('<td>'.$resEURfin["Liste"][$nbEURfin].'</td></tr>');
				$listeCSV = substr($resEURfin["ListeCSV"][$nbEURfin], 0, (strlen($resEURfin["ListeCSV"][$nbEURfin]) - 7));
				$chaine .= str_replace(array('&#x27E8;','&#x27E9;'),array('(',')'), $listeCSV).";";
				$chaine .= chr(13).chr(10);
				fwrite($inF,$chaine);
				$nbEURfin++;
			}
			echo ('</tbody>');
			echo ('</table><br>');
			
			echo ('<a href=\'./csv/req15.csv\'>Exporter le tableau au format CSV</a><br><br>');
		}else{
			echo ('<b>Aucun résultat</b><br><br>');
		}
  }
	
	//Tableau de résultats requête 16
  if ($reqt == "req16") {
		//Intitulé
		echo('<br><b>16. Collection : Profil des contributeurs HAL</b><br><br>');
		
		//Descriptif
		echo('<div style="background-color:#f5f5f5">Cette requête affiche, pour une collection, la liste des contributeurs classée par nombre de dépôts (références, texte intégral, données de recherche), ainsi que le portail de dépôt. A noter que les contributions secondaires (ajout d’un fichier) ne sont pas créditées par HAL : c’est toujours le nom du premier contributeur qui est remonté. <a href="#DT">Voir détails techniques en bas de page</a>.</div><br>');
		
		include("./Portails-SID.php");
		
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
				$urlHAL = "https://api.archives-ouvertes.fr/search/".$LAB_SECT[$col]["code_collection"]."/?fq=producedDateY_i:".$year."&fl=contributorFullName_s,submittedDate_s,submitType_s,halId_s,sid_i&rows=10000&sort=contributorFullName_s%20desc";
				askCurl($urlHAL, $arrayCtb);
				$nbTotCtb += $arrayCtb["response"]["numFound"];
				for ($i=0; $i<$arrayCtb["response"]["numFound"]; $i++) {
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
		//Classement du tableau par contributeur par ordre croissant
		array_multisort($ctbTot["nom"], SORT_ASC, $ctbTot["typ"], $ctbTot["sid"]);
		
		if ($nbTotCtb != 0) {//Au moins 1 résultat
			//Affichage
			$speCode = '<a href="?reqt=req16&port='.$port.'&team='.$team.'&anneedeb='.$anneedeb.'&anneefin='.$anneefin;
			echo ('<br><table class="table table-striped table-hover table-responsive table-bordered" style="width:100%;">');
			echo ('<thead>');
			echo ('<tr>');
			echo ('<th scope="col" style="text-align:left"><b>'.$speCode.'&ordr='.$nomUrl.'">Nom du contributeur</a></b></th>');
			echo ('<th scope="col" style="text-align:left"><b>'.$speCode.'&ordr='.$ntdUrl.'">Nombre total de dépôts</a></b></th>');
			echo ('<th scope="col" style="text-align:left"><b>'.$speCode.'&ordr='.$ndrUrl.'">Nombre de dépôts (références)</a></b></th>');
			echo ('<th scope="col" style="text-align:left"><b>'.$speCode.'&ordr='.$ndtUrl.'">Nombre de dépôts (texte intégral)</a></b></th>');
			echo ('<th scope="col" style="text-align:left"><b>'.$speCode.'&ordr='.$nddUrl.'">Nombre de dépôts (données de recherche)</a></b></th>');
			echo ('<th scope="col" style="text-align:left"><b>Portail(s) de dépôt</b></th>');
			$chaine = "Nom du contributeur;Nombre total de dépôts;Nombre de dépôts (références);Nombre de dépôts (texte intégral);Nombre de dépôts (données de recherche);Portail(s) de dépôt;";
			echo ('</tr>');
			$chaine .= chr(13).chr(10);
			fwrite($inF,$chaine);
			echo ('</thead>');
			echo ('<tbody>');

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

			for ($i=0; $i<count($ctbDep["nom"]); $i++) {
				echo ('<tr>');
				echo ('<td>'. $ctbDep["nom"][$i].'</td>');
				$chaine = $ctbDep["nom"][$i].";";
				echo ('<td>'. $ctbDep["tot"][$i].'</td>');
				$chaine .= $ctbDep["tot"][$i].";";
				echo ('<td>'. $ctbDep["ref"][$i].'</td>');
				$chaine .= $ctbDep["ref"][$i].";";
				echo ('<td>'. $ctbDep["txt"][$i].'</td>');
				$chaine .= $ctbDep["txt"][$i].";";
				echo ('<td>'. $ctbDep["anx"][$i].'</td>');
				$chaine .= $ctbDep["anx"][$i].";";
				echo ('<td>'. $ctbDep["ptl"][$i].'</td>');
				$chaine .= $ctbDep["ptl"][$i].";";
				echo ('</tr>');
				$chaine .= chr(13).chr(10);
				fwrite($inF,$chaine);
			}
			
			echo ('</tbody>');
			echo ('</table>');
			echo ('<a href=\'./csv/req16.csv\'>Exporter le tableau au format CSV</a><br><br>');
		}else{
			echo('<b>Aucun résultat</b><br><br>');
		}
	}
	
	//Tableau de résultats requête 17
  if ($reqt == "req17") {
		//Intitulé
		echo('<br><b>17. Collection : Collaborations nationales</b><br><br>');
		
		//Descriptif
		echo('<div style="background-color:#f5f5f5">Cette requête affiche, pour une collection, la liste des structures françaises auxquelles sont affiliés des co-auteurs. Cette liste mêle les 3 niveaux (laboratoires, établissements, autres) mais il est possible de les distinguer (voir les 3 requêtes suivantes). La requête est basée sur les tampons de collections (collCode_s). <a href="#DT">Voir détails techniques en bas de page</a>.</div><br>');
		
		//Tri par défaut
		$nomTri = "";
		$typTri = "";
		$codTri = "";
		$nbrTri = "SORT_DESC";
		$nomUrl = "nomDes";
		$typUrl = "typAsc";
		$codUrl = "codAsc";
		$nbrUrl = "nbrAsc";
		
		//Recherche des éventuelles demandes de tri
		$ordr = (isset($_GET["ordr"])) ? $_GET["ordr"] : "";//Tri demandé
		if ($ordr != "") {
			if (strpos($ordr, "nom") !== false) {//Sur le nom de la collection
				if ($ordr == "nomAsc") {$nomTri = "SORT_ASC"; $nbrTri = ""; $nomUrl = "nomDes";}else{$nomTri = "SORT_DESC"; $nbrTri = ""; $nomUrl = "nomAsc";}
			}
			if (strpos($ordr, "typ") !== false) {//Sur le type de la collection
				if ($ordr == "typAsc") {$typTri = "SORT_ASC"; $nbrTri = ""; $typUrl = "typDes";}else{$typTri = "SORT_DESC"; $nbrTri = ""; $typUrl = "typAsc";}
			}
			if (strpos($ordr, "cod") !== false) {//Sur le code la collection
				if ($ordr == "codAsc") {$codTri = "SORT_ASC"; $nbrTri = ""; $codUrl = "codDes";}else{$codTri = "SORT_DESC"; $nbrTri = ""; $codUrl = "codAsc";}
			}
			if (strpos($ordr, "nbr") !== false) {//Sur le nombre de publications
				if ($ordr == "nbrAsc") {$nbrTri = "SORT_ASC"; $nbrUrl = "nbrDes";}else{$nbrTri = "SORT_DESC"; $nbrUrl = "nbrAsc";}
			}
		}
		
		//Export CSV
    $Fnm = "./csv/req17.csv";
    $inF = fopen($Fnm,"w+");
    fseek($inF, 0);
    $chaine = "\xEF\xBB\xBF";
    fwrite($inF,$chaine);
		
		$resColl = array();
		$resColl["code"] = array();
		$year = $annee17;
		$url = "https://api.archives-ouvertes.fr/search/".$team."/?fq=producedDateY_i:".$year."&fl=collName_s,collCategory_s,collCode_s,halId_s&rows=10000";
		//echo $url;
		$totColl = askCurlNF("https://api.archives-ouvertes.fr/search/".$team."/?wt=xml&fq=producedDateY_i:".$year."&fl=collName_s,collCategory_s,collCode_s,halId_s");
		askCurl($url, $arrayCurl);
		//var_dump($arrayCurl);
		
		$i = 0;
		$k = 0;
		while (isset($arrayCurl["response"]["docs"][$i]["collCode_s"])) {
			for ($j=0; $j<count($arrayCurl["response"]["docs"][$i]["collCode_s"]); $j++) {
				if ($arrayCurl["response"]["docs"][$i]["collCategory_s"][$j] != "AUTRE" && strpos($arrayCurl["response"]["docs"][$i]["collCode_s"][$j], "-TEST") === false && strpos($arrayCurl["response"]["docs"][$i]["collCode_s"][$j], "TEST-") === false && strpos($arrayCurl["response"]["docs"][$i]["collCode_s"][$j], "_TEST") === false && strpos($arrayCurl["response"]["docs"][$i]["collCode_s"][$j], "TEST_") === false) {
					if (array_search($arrayCurl["response"]["docs"][$i]["collCode_s"][$j], $resColl["code"]) === false) {
						$resColl["code"][$k] = strtoupper(trim($arrayCurl["response"]["docs"][$i]["collCode_s"][$j]));
						$resColl["nombre"][$k] = 1;
						$resColl["nom"][$k] = ucfirst(trim($arrayCurl["response"]["docs"][$i]["collName_s"][$j]));
						$resColl["type"][$k] = strtoupper(trim($arrayCurl["response"]["docs"][$i]["collCategory_s"][$j]));
						$resColl["idhal"][$k] = $arrayCurl["response"]["docs"][$i]["halId_s"];
						$k++;
					}else{
						$key = array_search($arrayCurl["response"]["docs"][$i]["collCode_s"][$j], $resColl["code"]);
						if (strpos($resColl["idhal"][$key], $arrayCurl["response"]["docs"][$i]["halId_s"]) === false) {
							$resColl["nombre"][$key] += 1;
							$resColl["idhal"][$key] .= "~".$arrayCurl["response"]["docs"][$i]["halId_s"];
						}
					}
				}
			}
			$i++;
		}

		if ($totColl != 0) {//Au moins 1 résultat
			//Tableau final avec %
			for ($i=0; $i<count($resColl["nombre"]); $i++) {
				$resColl["pcent"][$i] = ($totColl != 0) ? number_format($resColl["nombre"][$i]*100/$totColl, 1) : 0;
			}
			
			//Initialement, classement du tableau par le nombre de publications ordre décroissant puis affichage
			if ($nomTri == "SORT_ASC") {array_multisort($resColl["nom"], SORT_ASC, SORT_STRING, $resColl["type"], $resColl["code"], $resColl["nombre"], $resColl["pcent"], $resColl["idhal"]);}
			if ($nomTri == "SORT_DESC") {array_multisort($resColl["nom"], SORT_DESC, SORT_STRING, $resColl["type"], $resColl["code"], $resColl["nombre"], $resColl["pcent"], $resColl["idhal"]);}
			if ($typTri == "SORT_ASC") {array_multisort($resColl["type"], SORT_ASC, SORT_STRING, $resColl["nom"], $resColl["code"], $resColl["nombre"], $resColl["pcent"], $resColl["idhal"]);}
			if ($typTri == "SORT_DESC") {array_multisort($resColl["type"], SORT_DESC, SORT_STRING, $resColl["nom"], $resColl["code"], $resColl["nombre"], $resColl["pcent"], $resColl["idhal"]);}
			if ($codTri == "SORT_ASC") {array_multisort($resColl["code"], SORT_ASC, SORT_STRING, $resColl["nom"], $resColl["type"], $resColl["nombre"], $resColl["pcent"], $resColl["idhal"]);}
			if ($codTri == "SORT_DESC") {array_multisort($resColl["code"], SORT_DESC, SORT_STRING, $resColl["nom"], $resColl["type"], $resColl["nombre"], $resColl["pcent"], $resColl["idhal"]);}
			if ($nbrTri == "SORT_ASC") {array_multisort($resColl["nombre"], SORT_ASC, SORT_NUMERIC, $resColl["nom"], $resColl["type"], $resColl["code"], $resColl["pcent"], $resColl["idhal"]);}
			if ($nbrTri == "SORT_DESC") {array_multisort($resColl["nombre"], SORT_DESC, SORT_NUMERIC, $resColl["nom"], $resColl["type"], $resColl["code"], $resColl["pcent"], $resColl["idhal"]);}
			
			//echo $totColl;
			//var_dump($resColl);
			
			//Affichage
			$speTri = '<a href="?reqt=req17&team='.$team.'&annee17='.$annee17;
			echo ('<br><table class="table table-striped table-hover table-responsive table-bordered" style="width:100%;">');
			echo ('<thead>');
			echo ('<tr>');
			echo ('<th scope="col" style="text-align:left"><b>'.$speTri.'&ordr='.$nomUrl.'">Nom</a></b></th>');
			echo ('<th scope="col" style="text-align:left"><b>'.$speTri.'&ordr='.$typUrl.'">Type</a></b></th>');
			echo ('<th scope="col" style="text-align:left"><b>'.$speTri.'&ordr='.$codUrl.'">Code HAL</a></b></th>');
			echo ('<th scope="col" style="text-align:left"><b>'.$speTri.'&ordr='.$nbrUrl.'">Nombre de publications</a></b></th>');
			echo ('<th scope="col" style="text-align:left"><b>%</b></th>');
			echo ('<th scope="col" style="text-align:left"><b>Références HAL</b></th>');
			$chaine = "Nom;Type;Code HAL;Nombre de publications;%;Références HAL;";
			echo ('</tr>');
			$chaine .= chr(13).chr(10);
			fwrite($inF,$chaine);
			echo ('</thead>');
			echo ('<tbody>');
			
			for ($i=0; $i<count($resColl["nom"]); $i++) {
				echo ('<tr>');
				echo ('<td>');
				echo ($resColl["nom"][$i]);
				echo ('</td>');
				echo ('<td>');
				echo ($resColl["type"][$i]);
				echo ('</td>');
				echo ('<td>');
				echo ($resColl["code"][$i]);
				echo ('</td>');
				echo ('<td>');
				echo ($resColl["nombre"][$i]);
				echo ('</td>');
				echo ('<td>');
				echo ($resColl["pcent"][$i]);
				echo ('%</td>');
				echo ('<td>');
				$idhal = $resColl["idhal"][$i];
				$idhal = "(".str_replace("~", "%20OR%20", $idhal).")";
				$liens = '<a target="_blank" href="https://api.archives-ouvertes.fr/search/'.$team.'/?fq=producedDateY_i:'.$year.'%20AND%20halId_s:'.$idhal.'&rows=10000&wt=xml">XML</a>';
				$liens .= ' - ';
				$liens .= '<a target="_blank" href="https://api.archives-ouvertes.fr/search/'.$team.'/?fq=producedDateY_i:'.$year.'%20AND%20halId_s:'.$idhal.'&rows=10000">JSON</a>';
				echo ($liens);
				echo ('</td>');
				$chaine = $resColl["nom"][$i].";".$resColl["type"][$i].";".$resColl["code"][$i].";".$resColl["nombre"][$i].";".$resColl["pcent"][$i].";".$liens.";";
				echo ('</tr>');
				$chaine .= chr(13).chr(10);
				fwrite($inF,$chaine);
			}
			
			echo ('</tbody>');
			echo ('</table>');
			echo ('<a href=\'./csv/req17.csv\'>Exporter le tableau au format CSV</a><br><br>');
		}else{
			echo('<b>Aucun résultat</b><br><br>');
		}
  }
	
	//Tableau de résultats requête 18
  if ($reqt == "req18") {
		//Intitulé
		echo('<br><b>18. Collection : Collaborations nationales (laboratoires)</b><br><br>');
		
		//Descriptif
		echo('<div style="background-color:#f5f5f5">Cette requête affiche, pour une collection, la liste des unités de recherche françaises auxquelles sont affiliés des co-auteurs. La requête est basée sur les tampons de collections (collCode_s). <a href="#DT">Voir détails techniques en bas de page</a>.</div><br>');
		
		//Tri par défaut
		$nomTri = "";
		$typTri = "";
		$codTri = "";
		$nbrTri = "SORT_DESC";
		$nomUrl = "nomDes";
		$typUrl = "typAsc";
		$codUrl = "codAsc";
		$nbrUrl = "nbrAsc";
		
		//Recherche des éventuelles demandes de tri
		$ordr = (isset($_GET["ordr"])) ? $_GET["ordr"] : "";//Tri demandé
		if ($ordr != "") {
			if (strpos($ordr, "nom") !== false) {//Sur le nom de la collection
				if ($ordr == "nomAsc") {$nomTri = "SORT_ASC"; $nbrTri = ""; $nomUrl = "nomDes";}else{$nomTri = "SORT_DESC"; $nbrTri = ""; $nomUrl = "nomAsc";}
			}
			if (strpos($ordr, "typ") !== false) {//Sur le type de la collection
				if ($ordr == "typAsc") {$typTri = "SORT_ASC"; $nbrTri = ""; $typUrl = "typDes";}else{$typTri = "SORT_DESC"; $nbrTri = ""; $typUrl = "typAsc";}
			}
			if (strpos($ordr, "cod") !== false) {//Sur le code la collection
				if ($ordr == "codAsc") {$codTri = "SORT_ASC"; $nbrTri = ""; $codUrl = "codDes";}else{$codTri = "SORT_DESC"; $nbrTri = ""; $codUrl = "codAsc";}
			}
			if (strpos($ordr, "nbr") !== false) {//Sur le nombre de publications
				if ($ordr == "nbrAsc") {$nbrTri = "SORT_ASC"; $nbrUrl = "nbrDes";}else{$nbrTri = "SORT_DESC"; $nbrUrl = "nbrAsc";}
			}
		}
		
		//Export CSV
    $Fnm = "./csv/req18.csv";
    $inF = fopen($Fnm,"w+");
    fseek($inF, 0);
    $chaine = "\xEF\xBB\xBF";
    fwrite($inF,$chaine);
		
		$resColl = array();
		$resColl["code"] = array();
		$year = $annee18;
		$url = "https://api.archives-ouvertes.fr/search/".$team."/?fq=producedDateY_i:".$year."&fl=collName_s,collCategory_s,collCode_s,halId_s&rows=10000";
		//echo $url;
		$totColl = askCurlNF("https://api.archives-ouvertes.fr/search/".$team."/?wt=xml&fq=producedDateY_i:".$year."&fl=collName_s,collCategory_s,collCode_s,halId_s");
		askCurl($url, $arrayCurl);
		//var_dump($arrayCurl);
		
		$i = 0;
		$k = 0;
		while (isset($arrayCurl["response"]["docs"][$i]["collCode_s"])) {
			for ($j=0; $j<count($arrayCurl["response"]["docs"][$i]["collCode_s"]); $j++) {
				if (($arrayCurl["response"]["docs"][$i]["collCategory_s"][$j] == "LABO" || $arrayCurl["response"]["docs"][$i]["collCategory_s"][$j] == "THEME") && strpos($arrayCurl["response"]["docs"][$i]["collCode_s"][$j], "-TEST") === false && strpos($arrayCurl["response"]["docs"][$i]["collCode_s"][$j], "TEST-") === false && strpos($arrayCurl["response"]["docs"][$i]["collCode_s"][$j], "_TEST") === false && strpos($arrayCurl["response"]["docs"][$i]["collCode_s"][$j], "TEST_") === false) {
					if (array_search($arrayCurl["response"]["docs"][$i]["collCode_s"][$j], $resColl["code"]) === false) {
						$resColl["code"][$k] = strtoupper(trim($arrayCurl["response"]["docs"][$i]["collCode_s"][$j]));
						$resColl["nombre"][$k] = 1;
						$resColl["nom"][$k] = ucfirst(trim($arrayCurl["response"]["docs"][$i]["collName_s"][$j]));
						$resColl["type"][$k] = strtoupper(trim($arrayCurl["response"]["docs"][$i]["collCategory_s"][$j]));
						$resColl["idhal"][$k] = $arrayCurl["response"]["docs"][$i]["halId_s"];
						$k++;
					}else{
						$key = array_search($arrayCurl["response"]["docs"][$i]["collCode_s"][$j], $resColl["code"]);
						if (strpos($resColl["idhal"][$key], $arrayCurl["response"]["docs"][$i]["halId_s"]) === false) {
							$resColl["nombre"][$key] += 1;
							$resColl["idhal"][$key] .= "~".$arrayCurl["response"]["docs"][$i]["halId_s"];
						}
					}
				}
			}
			$i++;
		}

		if ($totColl != 0) {//Au moins 1 résultat
			//Tableau final avec %
			for ($i=0; $i<count($resColl["nombre"]); $i++) {
				$resColl["pcent"][$i] = ($totColl != 0) ? number_format($resColl["nombre"][$i]*100/$totColl, 1) : 0;
			}
			
			//Initialement, classement du tableau par le nombre de publications ordre décroissant puis affichage
			if ($nomTri == "SORT_ASC") {array_multisort($resColl["nom"], SORT_ASC, SORT_STRING, $resColl["type"], $resColl["code"], $resColl["nombre"], $resColl["pcent"], $resColl["idhal"]);}
			if ($nomTri == "SORT_DESC") {array_multisort($resColl["nom"], SORT_DESC, SORT_STRING, $resColl["type"], $resColl["code"], $resColl["nombre"], $resColl["pcent"], $resColl["idhal"]);}
			if ($typTri == "SORT_ASC") {array_multisort($resColl["type"], SORT_ASC, SORT_STRING, $resColl["nom"], $resColl["code"], $resColl["nombre"], $resColl["pcent"], $resColl["idhal"]);}
			if ($typTri == "SORT_DESC") {array_multisort($resColl["type"], SORT_DESC, SORT_STRING, $resColl["nom"], $resColl["code"], $resColl["nombre"], $resColl["pcent"], $resColl["idhal"]);}
			if ($codTri == "SORT_ASC") {array_multisort($resColl["code"], SORT_ASC, SORT_STRING, $resColl["nom"], $resColl["type"], $resColl["nombre"], $resColl["pcent"], $resColl["idhal"]);}
			if ($codTri == "SORT_DESC") {array_multisort($resColl["code"], SORT_DESC, SORT_STRING, $resColl["nom"], $resColl["type"], $resColl["nombre"], $resColl["pcent"], $resColl["idhal"]);}
			if ($nbrTri == "SORT_ASC") {array_multisort($resColl["nombre"], SORT_ASC, SORT_NUMERIC, $resColl["nom"], $resColl["type"], $resColl["code"], $resColl["pcent"], $resColl["idhal"]);}
			if ($nbrTri == "SORT_DESC") {array_multisort($resColl["nombre"], SORT_DESC, SORT_NUMERIC, $resColl["nom"], $resColl["type"], $resColl["code"], $resColl["pcent"], $resColl["idhal"]);}
			
			//echo $totColl;
			//var_dump($resColl);
			
			//Affichage
			$speTri = '<a href="?reqt=req18&team='.$team.'&annee18='.$annee18;
			echo ('<br><table class="table table-striped table-hover table-responsive table-bordered" style="width:100%;">');
			echo ('<thead>');
			echo ('<tr>');
			echo ('<th scope="col" style="text-align:left"><b>'.$speTri.'&ordr='.$nomUrl.'">Nom</a></b></th>');
			echo ('<th scope="col" style="text-align:left"><b>'.$speTri.'&ordr='.$typUrl.'">Type</a></b></th>');
			echo ('<th scope="col" style="text-align:left"><b>'.$speTri.'&ordr='.$codUrl.'">Code HAL</a></b></th>');
			echo ('<th scope="col" style="text-align:left"><b>'.$speTri.'&ordr='.$nbrUrl.'">Nombre de publications</a></b></th>');
			echo ('<th scope="col" style="text-align:left"><b>%</b></th>');
			echo ('<th scope="col" style="text-align:left"><b>Références HAL</b></th>');
			$chaine = "Nom;Type;Code HAL;Nombre de publications;%;Références HAL;";
			echo ('</tr>');
			$chaine .= chr(13).chr(10);
			fwrite($inF,$chaine);
			echo ('</thead>');
			echo ('<tbody>');
			
			for ($i=0; $i<count($resColl["nom"]); $i++) {
				echo ('<tr>');
				echo ('<td>');
				echo ($resColl["nom"][$i]);
				echo ('</td>');
				echo ('<td>');
				echo ($resColl["type"][$i]);
				echo ('</td>');
				echo ('<td>');
				echo ($resColl["code"][$i]);
				echo ('</td>');
				echo ('<td>');
				echo ($resColl["nombre"][$i]);
				echo ('</td>');
				echo ('<td>');
				echo ($resColl["pcent"][$i]);
				echo ('%</td>');
				echo ('<td>');
				$idhal = $resColl["idhal"][$i];
				$idhal = "(".str_replace("~", "%20OR%20", $idhal).")";
				$liens = '<a target="_blank" href="https://api.archives-ouvertes.fr/search/'.$team.'/?fq=producedDateY_i:'.$year.'%20AND%20halId_s:'.$idhal.'&rows=10000&wt=xml">XML</a>';
				$liens .= ' - ';
				$liens .= '<a target="_blank" href="https://api.archives-ouvertes.fr/search/'.$team.'/?fq=producedDateY_i:'.$year.'%20AND%20halId_s:'.$idhal.'&rows=10000">JSON</a>';
				echo ($liens);
				echo ('</td>');
				$chaine = $resColl["nom"][$i].";".$resColl["type"][$i].";".$resColl["code"][$i].";".$resColl["nombre"][$i].";".$resColl["pcent"][$i].";".$liens.";";
				echo ('</tr>');
				$chaine .= chr(13).chr(10);
				fwrite($inF,$chaine);
			}
			
			echo ('</tbody>');
			echo ('</table>');
			echo ('<a href=\'./csv/req18.csv\'>Exporter le tableau au format CSV</a><br><br>');
		}else{
			echo('<b>Aucun résultat</b><br><br>');
		}
  }
	
	//Tableau de résultats requête 19
  if ($reqt == "req19") {
		//Intitulé
		echo('<br><b>19. Collection : Collaborations nationales (établissements)</b><br><br>');
		
		//Descriptif
		echo('<div style="background-color:#f5f5f5">Cette requête affiche, pour une collection, la liste des institutions françaises auxquelles sont affiliés des co-auteurs. La requête est basée sur les tampons de collections (collCode_s). <a href="#DT">Voir détails techniques en bas de page</a>.</div><br>');
		
		//Tri par défaut
		$nomTri = "";
		$typTri = "";
		$codTri = "";
		$nbrTri = "SORT_DESC";
		$nomUrl = "nomDes";
		$typUrl = "typAsc";
		$codUrl = "codAsc";
		$nbrUrl = "nbrAsc";
		
		//Recherche des éventuelles demandes de tri
		$ordr = (isset($_GET["ordr"])) ? $_GET["ordr"] : "";//Tri demandé
		if ($ordr != "") {
			if (strpos($ordr, "nom") !== false) {//Sur le nom de la collection
				if ($ordr == "nomAsc") {$nomTri = "SORT_ASC"; $nbrTri = ""; $nomUrl = "nomDes";}else{$nomTri = "SORT_DESC"; $nbrTri = ""; $nomUrl = "nomAsc";}
			}
			if (strpos($ordr, "typ") !== false) {//Sur le type de la collection
				if ($ordr == "typAsc") {$typTri = "SORT_ASC"; $nbrTri = ""; $typUrl = "typDes";}else{$typTri = "SORT_DESC"; $nbrTri = ""; $typUrl = "typAsc";}
			}
			if (strpos($ordr, "cod") !== false) {//Sur le code la collection
				if ($ordr == "codAsc") {$codTri = "SORT_ASC"; $nbrTri = ""; $codUrl = "codDes";}else{$codTri = "SORT_DESC"; $nbrTri = ""; $codUrl = "codAsc";}
			}
			if (strpos($ordr, "nbr") !== false) {//Sur le nombre de publications
				if ($ordr == "nbrAsc") {$nbrTri = "SORT_ASC"; $nbrUrl = "nbrDes";}else{$nbrTri = "SORT_DESC"; $nbrUrl = "nbrAsc";}
			}
		}
		
		//Export CSV
    $Fnm = "./csv/req19.csv";
    $inF = fopen($Fnm,"w+");
    fseek($inF, 0);
    $chaine = "\xEF\xBB\xBF";
    fwrite($inF,$chaine);
		
		$resColl = array();
		$resColl["code"] = array();
		$year = $annee19;
		$url = "https://api.archives-ouvertes.fr/search/".$team."/?fq=producedDateY_i:".$year."&fl=collName_s,collCategory_s,collCode_s,halId_s&rows=10000";
		//echo $url;
		$totColl = askCurlNF("https://api.archives-ouvertes.fr/search/".$team."/?wt=xml&fq=producedDateY_i:".$year."&fl=collName_s,collCategory_s,collCode_s,halId_s");
		askCurl($url, $arrayCurl);
		//var_dump($arrayCurl);

		$i = 0;
		$k = 0;
		while (isset($arrayCurl["response"]["docs"][$i]["collCode_s"])) {
			for ($j=0; $j<count($arrayCurl["response"]["docs"][$i]["collCode_s"]); $j++) {
				if (($arrayCurl["response"]["docs"][$i]["collCategory_s"][$j] == "INSTITUTION" || $arrayCurl["response"]["docs"][$i]["collCategory_s"][$j] == "UNIV" || $arrayCurl["response"]["docs"][$i]["collCategory_s"][$j] == "ECOLE") && strpos($arrayCurl["response"]["docs"][$i]["collCode_s"][$j], "-TEST") === false && strpos($arrayCurl["response"]["docs"][$i]["collCode_s"][$j], "TEST-") === false && strpos($arrayCurl["response"]["docs"][$i]["collCode_s"][$j], "_TEST") === false && strpos($arrayCurl["response"]["docs"][$i]["collCode_s"][$j], "TEST_") === false) {
					if (array_search($arrayCurl["response"]["docs"][$i]["collCode_s"][$j], $resColl["code"]) === false) {
						$resColl["code"][$k] = strtoupper(trim($arrayCurl["response"]["docs"][$i]["collCode_s"][$j]));
						$resColl["nombre"][$k] = 1;
						$resColl["nom"][$k] = ucfirst(trim($arrayCurl["response"]["docs"][$i]["collName_s"][$j]));
						$resColl["type"][$k] = strtoupper(trim($arrayCurl["response"]["docs"][$i]["collCategory_s"][$j]));
						$resColl["idhal"][$k] = $arrayCurl["response"]["docs"][$i]["halId_s"];
						$k++;
					}else{
						$key = array_search($arrayCurl["response"]["docs"][$i]["collCode_s"][$j], $resColl["code"]);
						if (strpos($resColl["idhal"][$key], $arrayCurl["response"]["docs"][$i]["halId_s"]) === false) {
							$resColl["nombre"][$key] += 1;
							$resColl["idhal"][$key] .= "~".$arrayCurl["response"]["docs"][$i]["halId_s"];
						}
					}
				}
			}
			$i++;
		}

		if ($totColl != 0) {//Au moins 1 résultat
			//Tableau final avec %
			for ($i=0; $i<count($resColl["nombre"]); $i++) {
				$resColl["pcent"][$i] = ($totColl != 0) ? number_format($resColl["nombre"][$i]*100/$totColl, 1) : 0;
			}
			
			//Initialement, classement du tableau par le nombre de publications ordre décroissant puis affichage
			if ($nomTri == "SORT_ASC") {array_multisort($resColl["nom"], SORT_ASC, SORT_STRING, $resColl["type"], $resColl["code"], $resColl["nombre"], $resColl["pcent"], $resColl["idhal"]);}
			if ($nomTri == "SORT_DESC") {array_multisort($resColl["nom"], SORT_DESC, SORT_STRING, $resColl["type"], $resColl["code"], $resColl["nombre"], $resColl["pcent"], $resColl["idhal"]);}
			if ($typTri == "SORT_ASC") {array_multisort($resColl["type"], SORT_ASC, SORT_STRING, $resColl["nom"], $resColl["code"], $resColl["nombre"], $resColl["pcent"], $resColl["idhal"]);}
			if ($typTri == "SORT_DESC") {array_multisort($resColl["type"], SORT_DESC, SORT_STRING, $resColl["nom"], $resColl["code"], $resColl["nombre"], $resColl["pcent"], $resColl["idhal"]);}
			if ($codTri == "SORT_ASC") {array_multisort($resColl["code"], SORT_ASC, SORT_STRING, $resColl["nom"], $resColl["type"], $resColl["nombre"], $resColl["pcent"], $resColl["idhal"]);}
			if ($codTri == "SORT_DESC") {array_multisort($resColl["code"], SORT_DESC, SORT_STRING, $resColl["nom"], $resColl["type"], $resColl["nombre"], $resColl["pcent"], $resColl["idhal"]);}
			if ($nbrTri == "SORT_ASC") {array_multisort($resColl["nombre"], SORT_ASC, SORT_NUMERIC, $resColl["nom"], $resColl["type"], $resColl["code"], $resColl["pcent"], $resColl["idhal"]);}
			if ($nbrTri == "SORT_DESC") {array_multisort($resColl["nombre"], SORT_DESC, SORT_NUMERIC, $resColl["nom"], $resColl["type"], $resColl["code"], $resColl["pcent"], $resColl["idhal"]);}
			
			//echo $totColl;
			//var_dump($resColl);
			
			//Affichage
			$speTri = '<a href="?reqt=req19&team='.$team.'&annee19='.$annee19;
			echo ('<br><table class="table table-striped table-hover table-responsive table-bordered" style="width:100%;">');
			echo ('<thead>');
			echo ('<tr>');
			echo ('<th scope="col" style="text-align:left"><b>'.$speTri.'&ordr='.$nomUrl.'">Nom</a></b></th>');
			echo ('<th scope="col" style="text-align:left"><b>'.$speTri.'&ordr='.$typUrl.'">Type</a></b></th>');
			echo ('<th scope="col" style="text-align:left"><b>'.$speTri.'&ordr='.$codUrl.'">Code HAL</a></b></th>');
			echo ('<th scope="col" style="text-align:left"><b>'.$speTri.'&ordr='.$nbrUrl.'">Nombre de publications</a></b></th>');
			echo ('<th scope="col" style="text-align:left"><b>%</b></th>');
			echo ('<th scope="col" style="text-align:left"><b>Références HAL</b></th>');
			$chaine = "Nom;Type;Code HAL;Nombre de publications;%;Références HAL;";
			echo ('</tr>');
			$chaine .= chr(13).chr(10);
			fwrite($inF,$chaine);
			echo ('</thead>');
			echo ('<tbody>');
			
			for ($i=0; $i<count($resColl["nom"]); $i++) {
				echo ('<tr>');
				echo ('<td>');
				echo ($resColl["nom"][$i]);
				echo ('</td>');
				echo ('<td>');
				echo ($resColl["type"][$i]);
				echo ('</td>');
				echo ('<td>');
				echo ($resColl["code"][$i]);
				echo ('</td>');
				echo ('<td>');
				echo ($resColl["nombre"][$i]);
				echo ('</td>');
				echo ('<td>');
				echo ($resColl["pcent"][$i]);
				echo ('%</td>');
				echo ('<td>');
				$idhal = $resColl["idhal"][$i];
				$idhal = "(".str_replace("~", "%20OR%20", $idhal).")";
				$liens = '<a target="_blank" href="https://api.archives-ouvertes.fr/search/'.$team.'/?fq=producedDateY_i:'.$year.'%20AND%20halId_s:'.$idhal.'&rows=10000&wt=xml">XML</a>';
				$liens .= ' - ';
				$liens .= '<a target="_blank" href="https://api.archives-ouvertes.fr/search/'.$team.'/?fq=producedDateY_i:'.$year.'%20AND%20halId_s:'.$idhal.'&rows=10000">JSON</a>';
				echo ($liens);
				echo ('</td>');
				$chaine = $resColl["nom"][$i].";".$resColl["type"][$i].";".$resColl["code"][$i].";".$resColl["nombre"][$i].";".$resColl["pcent"][$i].";".$liens.";";
				echo ('</tr>');
				$chaine .= chr(13).chr(10);
				fwrite($inF,$chaine);
			}
			
			echo ('</tbody>');
			echo ('</table>');
			echo ('<a href=\'./csv/req19.csv\'>Exporter le tableau au format CSV</a><br><br>');
		}else{
			echo('<b>Aucun résultat</b><br><br>');
		}
  }
	
	//Tableau de résultats requête 20
  if ($reqt == "req20") {
		//Intitulé
		echo('<br><b>20. Collection : Collaborations nationales (autres)</b><br><br>');
		
		//Descriptif
		echo('<div style="background-color:#f5f5f5">Cette requête affiche, pour une collection, la liste des structures françaises (autres que laboratoires et institutions) auxquelles sont affiliés des co-auteurs. La requête est basée sur les tampons de collections (collCode_s). <a href="#DT">Voir détails techniques en bas de page</a>.</div><br>');
		
		//Tri par défaut
		$nomTri = "";
		$typTri = "";
		$codTri = "";
		$nbrTri = "SORT_DESC";
		$nomUrl = "nomDes";
		$typUrl = "typAsc";
		$codUrl = "codAsc";
		$nbrUrl = "nbrAsc";
		
		//Recherche des éventuelles demandes de tri
		$ordr = (isset($_GET["ordr"])) ? $_GET["ordr"] : "";//Tri demandé
		if ($ordr != "") {
			if (strpos($ordr, "nom") !== false) {//Sur le nom de la collection
				if ($ordr == "nomAsc") {$nomTri = "SORT_ASC"; $nbrTri = ""; $nomUrl = "nomDes";}else{$nomTri = "SORT_DESC"; $nbrTri = ""; $nomUrl = "nomAsc";}
			}
			if (strpos($ordr, "typ") !== false) {//Sur le type de la collection
				if ($ordr == "typAsc") {$typTri = "SORT_ASC"; $nbrTri = ""; $typUrl = "typDes";}else{$typTri = "SORT_DESC"; $nbrTri = ""; $typUrl = "typAsc";}
			}
			if (strpos($ordr, "cod") !== false) {//Sur le code la collection
				if ($ordr == "codAsc") {$codTri = "SORT_ASC"; $nbrTri = ""; $codUrl = "codDes";}else{$codTri = "SORT_DESC"; $nbrTri = ""; $codUrl = "codAsc";}
			}
			if (strpos($ordr, "nbr") !== false) {//Sur le nombre de publications
				if ($ordr == "nbrAsc") {$nbrTri = "SORT_ASC"; $nbrUrl = "nbrDes";}else{$nbrTri = "SORT_DESC"; $nbrUrl = "nbrAsc";}
			}
		}
		
		//Export CSV
    $Fnm = "./csv/req20.csv";
    $inF = fopen($Fnm,"w+");
    fseek($inF, 0);
    $chaine = "\xEF\xBB\xBF";
    fwrite($inF,$chaine);
		
		$resColl = array();
		$resColl["code"] = array();
		$year = $annee20;
		$url = "https://api.archives-ouvertes.fr/search/".$team."/?fq=producedDateY_i:".$year."&fl=collName_s,collCategory_s,collCode_s,halId_s&rows=10000";
		//echo $url;
		$totColl = askCurlNF("https://api.archives-ouvertes.fr/search/".$team."/?wt=xml&fq=producedDateY_i:".$year."&fl=collName_s,collCategory_s,collCode_s,halId_s");
		askCurl($url, $arrayCurl);
		//var_dump($arrayCurl);
		
		$i = 0;
		$k = 0;
		while (isset($arrayCurl["response"]["docs"][$i]["collCode_s"])) {
			for ($j=0; $j<count($arrayCurl["response"]["docs"][$i]["collCode_s"]); $j++) {
				if (($arrayCurl["response"]["docs"][$i]["collCategory_s"][$j] == "AUTRE") && strpos($arrayCurl["response"]["docs"][$i]["collCode_s"][$j], "-TEST") === false && strpos($arrayCurl["response"]["docs"][$i]["collCode_s"][$j], "TEST-") === false && strpos($arrayCurl["response"]["docs"][$i]["collCode_s"][$j], "_TEST") === false && strpos($arrayCurl["response"]["docs"][$i]["collCode_s"][$j], "TEST_") === false) {
					if (array_search($arrayCurl["response"]["docs"][$i]["collCode_s"][$j], $resColl["code"]) === false) {
						$resColl["code"][$k] = strtoupper(trim($arrayCurl["response"]["docs"][$i]["collCode_s"][$j]));
						$resColl["nombre"][$k] = 1;
						$resColl["nom"][$k] = ucfirst(trim($arrayCurl["response"]["docs"][$i]["collName_s"][$j]));
						$resColl["type"][$k] = strtoupper(trim($arrayCurl["response"]["docs"][$i]["collCategory_s"][$j]));
						$resColl["idhal"][$k] = $arrayCurl["response"]["docs"][$i]["halId_s"];
						$k++;
					}else{
						$key = array_search($arrayCurl["response"]["docs"][$i]["collCode_s"][$j], $resColl["code"]);
						if (strpos($resColl["idhal"][$key], $arrayCurl["response"]["docs"][$i]["halId_s"]) === false) {
							$resColl["nombre"][$key] += 1;
							$resColl["idhal"][$key] .= "~".$arrayCurl["response"]["docs"][$i]["halId_s"];
						}
					}
				}
			}
			$i++;
		}

		if ($totColl != 0) {//Au moins 1 résultat
			//Tableau final avec %
			for ($i=0; $i<count($resColl["nombre"]); $i++) {
				$resColl["pcent"][$i] = ($totColl != 0) ? number_format($resColl["nombre"][$i]*100/$totColl, 1) : 0;
			}
			
			//Initialement, classement du tableau par le nombre de publications ordre décroissant puis affichage
			if ($nomTri == "SORT_ASC") {array_multisort($resColl["nom"], SORT_ASC, SORT_STRING, $resColl["type"], $resColl["code"], $resColl["nombre"], $resColl["pcent"], $resColl["idhal"]);}
			if ($nomTri == "SORT_DESC") {array_multisort($resColl["nom"], SORT_DESC, SORT_STRING, $resColl["type"], $resColl["code"], $resColl["nombre"], $resColl["pcent"], $resColl["idhal"]);}
			if ($typTri == "SORT_ASC") {array_multisort($resColl["type"], SORT_ASC, SORT_STRING, $resColl["nom"], $resColl["code"], $resColl["nombre"], $resColl["pcent"], $resColl["idhal"]);}
			if ($typTri == "SORT_DESC") {array_multisort($resColl["type"], SORT_DESC, SORT_STRING, $resColl["nom"], $resColl["code"], $resColl["nombre"], $resColl["pcent"], $resColl["idhal"]);}
			if ($codTri == "SORT_ASC") {array_multisort($resColl["code"], SORT_ASC, SORT_STRING, $resColl["nom"], $resColl["type"], $resColl["nombre"], $resColl["pcent"], $resColl["idhal"]);}
			if ($codTri == "SORT_DESC") {array_multisort($resColl["code"], SORT_DESC, SORT_STRING, $resColl["nom"], $resColl["type"], $resColl["nombre"], $resColl["pcent"], $resColl["idhal"]);}
			if ($nbrTri == "SORT_ASC") {array_multisort($resColl["nombre"], SORT_ASC, SORT_NUMERIC, $resColl["nom"], $resColl["type"], $resColl["code"], $resColl["pcent"], $resColl["idhal"]);}
			if ($nbrTri == "SORT_DESC") {array_multisort($resColl["nombre"], SORT_DESC, SORT_NUMERIC, $resColl["nom"], $resColl["type"], $resColl["code"], $resColl["pcent"], $resColl["idhal"]);}
			
			//echo $totColl;
			//var_dump($resColl);
			
			//Affichage
			$speTri = '<a href="?reqt=req20&team='.$team.'&annee20='.$annee20;
			echo ('<br><table class="table table-striped table-hover table-responsive table-bordered" style="width:100%;">');
			echo ('<thead>');
			echo ('<tr>');
			echo ('<th scope="col" style="text-align:left"><b>'.$speTri.'&ordr='.$nomUrl.'">Nom</a></b></th>');
			echo ('<th scope="col" style="text-align:left"><b>'.$speTri.'&ordr='.$typUrl.'">Type</a></b></th>');
			echo ('<th scope="col" style="text-align:left"><b>'.$speTri.'&ordr='.$codUrl.'">Code HAL</a></b></th>');
			echo ('<th scope="col" style="text-align:left"><b>'.$speTri.'&ordr='.$nbrUrl.'">Nombre de publications</a></b></th>');
			echo ('<th scope="col" style="text-align:left"><b>%</b></th>');
			echo ('<th scope="col" style="text-align:left"><b>Références HAL</b></th>');
			$chaine = "Nom;Type;Code HAL;Nombre de publications;%;Références HAL;";
			echo ('</tr>');
			$chaine .= chr(13).chr(10);
			fwrite($inF,$chaine);
			echo ('</thead>');
			echo ('<tbody>');
			
			for ($i=0; $i<count($resColl["nom"]); $i++) {
				echo ('<tr>');
				echo ('<td>');
				echo ($resColl["nom"][$i]);
				echo ('</td>');
				echo ('<td>');
				echo ($resColl["type"][$i]);
				echo ('</td>');
				echo ('<td>');
				echo ($resColl["code"][$i]);
				echo ('</td>');
				echo ('<td>');
				echo ($resColl["nombre"][$i]);
				echo ('</td>');
				echo ('<td>');
				echo ($resColl["pcent"][$i]);
				echo ('%</td>');
				echo ('<td>');
				$idhal = $resColl["idhal"][$i];
				$idhal = "(".str_replace("~", "%20OR%20", $idhal).")";
				$liens = '<a target="_blank" href="https://api.archives-ouvertes.fr/search/'.$team.'/?fq=producedDateY_i:'.$year.'%20AND%20halId_s:'.$idhal.'&rows=10000&wt=xml">XML</a>';
				$liens .= ' - ';
				$liens .= '<a target="_blank" href="https://api.archives-ouvertes.fr/search/'.$team.'/?fq=producedDateY_i:'.$year.'%20AND%20halId_s:'.$idhal.'&rows=10000">JSON</a>';
				echo ($liens);
				echo ('</td>');
				$chaine = $resColl["nom"][$i].";".$resColl["type"][$i].";".$resColl["code"][$i].";".$resColl["nombre"][$i].";".$resColl["pcent"][$i].";".$liens.";";
				echo ('</tr>');
				$chaine .= chr(13).chr(10);
				fwrite($inF,$chaine);
			}
			
			echo ('</tbody>');
			echo ('</table>');
			echo ('<a href=\'./csv/req20.csv\'>Exporter le tableau au format CSV</a><br><br>');
		}else{
			echo('<b>Aucun résultat</b><br><br>');
		}
  }
	
	//Tableau de résultats requête 21
  if ($reqt == "req21") {
		//Intitulé
		echo('<br><b>21. Collection : Collaborations internationales (toutes structures)</b><br><br>');
		
		//Descriptif
		echo('<div style="background-color:#f5f5f5">Cette requête affiche, pour une collection, la liste des structures étrangères auxquelles sont affiliés des co-auteurs. La requête est basée sur le pays de l’affiliation (structCountry_s). Cliquez sur le lien XML / JSON pour afficher les références concernées.  Les structures dont le pays n’est pas renseigné dans le <a target="_blank" href="https://aurehal.archives-ouvertes.fr/structure/index">référentiel AuréHAL</a> sont classés sous la rubriques « Structure(s) sans pays défini(s) dans HAL » en fin de tableau. <a href="#DT">Voir détails techniques en bas de page</a>.</div><br>');
		
		include('./VizuHAL_codes_pays.php');
		$typTab = array(
		'researchteam' => 'Équipe de recherche',
		'laboratory' => 'Laboratoire',
		'regrouplaboratory' => 'Regroupement de laboratoires, département',
		'department' => 'Département',
		'regroupinstitution' => 'Regroupement d\'institutions',
		'institution' => 'Institution'
		);
		
		//Tri par défaut
		$nomTri = "";
		$payTri = "";
		$typTri = "";
		$nbrTri = "SORT_DESC";
		$nomUrl = "nomDes";
		$payUrl = "payDes";
		$typUrl = "typAsc";
		$nbrUrl = "nbrAsc";
		
		//Recherche des éventuelles demandes de tri
		$ordr = (isset($_GET["ordr"])) ? $_GET["ordr"] : "";//Tri demandé
		if ($ordr != "") {
			if (strpos($ordr, "nom") !== false) {//Sur le nom de la structure
				if ($ordr == "nomAsc") {$nomTri = "SORT_ASC"; $nbrTri = ""; $nomUrl = "nomDes";}else{$nomTri = "SORT_DESC"; $nbrTri = ""; $nomUrl = "nomAsc";}
			}
			if (strpos($ordr, "pay") !== false) {//Sur le pays de la structure
				if ($ordr == "payAsc") {$payTri = "SORT_ASC"; $nbrTri = ""; $payUrl = "payDes";}else{$payTri = "SORT_DESC"; $nbrTri = ""; $payUrl = "payAsc";}
			}
			if (strpos($ordr, "typ") !== false) {//Sur le type de la structure
				if ($ordr == "typAsc") {$typTri = "SORT_ASC"; $nbrTri = ""; $typUrl = "typDes";}else{$typTri = "SORT_DESC"; $nbrTri = ""; $typUrl = "typAsc";}
			}
			if (strpos($ordr, "nbr") !== false) {//Sur le nombre de publications
				if ($ordr == "nbrAsc") {$nbrTri = "SORT_ASC"; $nbrUrl = "nbrDes";}else{$nbrTri = "SORT_DESC"; $nbrUrl = "nbrAsc";}
			}
		}
		
		//Export CSV
    $Fnm = "./csv/req21.csv";
    $inF = fopen($Fnm,"w+");
    fseek($inF, 0);
    $chaine = "\xEF\xBB\xBF";
    fwrite($inF,$chaine);
		
		$resColl = array();
		$resColl["nom"] = array();
		$k = 0;
		$totColl = 0;
		$tabPaysFR = array('fr','FR','mq','MQ','gp','GP','gf','GF','yt','YT','nc','NC','pf','PF','pm','PM','tf','TF','re','RE');//Territoires français à ne pas considérer dans l'international
		
		for ($year = $anneedeb; $year <= $anneefin; $year++) {
			$url = "https://api.archives-ouvertes.fr/search/".$team."/?fq=producedDateY_i:".$year."&fl=structName_s,structType_s,halId_s,structCountry_s&rows=10000";
			//echo $url;
			//$totColl += askCurlNF("https://api.archives-ouvertes.fr/search/".$team."/?wt=xml&fq=producedDateY_i:".$year."&fl=structName_s,structType_s,halId_s,structCountry_s");
			askCurl($url, $arrayCurl);
			//var_dump($arrayCurl);
			$totColl += $arrayCurl["response"]["numFound"];
			$i = 0;
			
			while (isset($arrayCurl["response"]["docs"][$i]["structName_s"])) {
				if (count($arrayCurl["response"]["docs"][$i]["structCountry_s"]) != count($arrayCurl["response"]["docs"][$i]["structName_s"])) {//Pays non défini pour une structure
					if (array_search("Structure(s) sans pays défini(s) dans HAL", $resColl["nom"]) === false) {
						$resColl["nom"][$k] = "Structure(s) sans pays défini(s) dans HAL";
						$resColl["nombre"][$k] = 1;
						$resColl["type"][$k] = "-";
						$resColl["pays"][$k] = "-";
						$resColl["idhal"][$k] = $arrayCurl["response"]["docs"][$i]["halId_s"];
						$k++;
					}else{
						$key = array_search("Structure(s) sans pays défini(s) dans HAL", $resColl["nom"]);
						$resColl["nombre"][$key] += 1;
						$resColl["idhal"][$key] .= "~".$arrayCurl["response"]["docs"][$i]["halId_s"];
					}
				}else{
					for ($j=0; $j<count($arrayCurl["response"]["docs"][$i]["structName_s"]); $j++) {
						if (isset($arrayCurl["response"]["docs"][$i]["structCountry_s"][$j]) && array_search($arrayCurl["response"]["docs"][$i]["structCountry_s"][$j], $tabPaysFR) === false) {
							if (array_search(ucfirst(trim($arrayCurl["response"]["docs"][$i]["structName_s"][$j])), $resColl["nom"]) === false) {//Nouvelle structure
								if (array_key_exists(strtoupper($arrayCurl["response"]["docs"][$i]["structCountry_s"][$j]), $countries)) {
									$resColl["nom"][$k] = ucfirst(trim($arrayCurl["response"]["docs"][$i]["structName_s"][$j]));
									$resColl["nombre"][$k] = 1;
									if (array_key_exists(strtolower(trim($arrayCurl["response"]["docs"][$i]["structType_s"][$j])), $typTab)) {
										$resColl["type"][$k] = $typTab[strtolower(trim($arrayCurl["response"]["docs"][$i]["structType_s"][$j]))];
									}else{
										$resColl["type"][$k] = strtoupper(trim($arrayCurl["response"]["docs"][$i]["structType_s"][$j]));
									}								
									$resColl["pays"][$k] = $countries[strtoupper($arrayCurl["response"]["docs"][$i]["structCountry_s"][$j])];
									$resColl["idhal"][$k] = $arrayCurl["response"]["docs"][$i]["halId_s"];
									$k++;
								}else{//Code pays inconnu dans la liste ISO des pays
									if (array_search("Structure(s) sans pays défini(s) dans HAL", $resColl["nom"]) === false) {
										$resColl["nom"][$k] = "Structure(s) sans pays défini(s) dans HAL";
										$resColl["nombre"][$k] = 1;
										$resColl["type"][$k] = "-";
										$resColl["pays"][$k] = "-";
										$resColl["idhal"][$k] = $arrayCurl["response"]["docs"][$i]["halId_s"];
										$k++;
									}else{
										$key = array_search("Structure(s) sans pays défini(s) dans HAL", $resColl["nom"]);
										$resColl["nombre"][$key] += 1;
										$resColl["idhal"][$key] .= "~".$arrayCurl["response"]["docs"][$i]["halId_s"];
									}
								}
							}else{
								$key = array_search(ucfirst(trim($arrayCurl["response"]["docs"][$i]["structName_s"][$j])), $resColl["nom"]);
								$resColl["nombre"][$key] += 1;
								$resColl["idhal"][$key] .= "~".$arrayCurl["response"]["docs"][$i]["halId_s"];
							}
						}
					}
				}
				$i++;
			}
		}

		if ($k != 0) {//Au moins 1 résultat
			/*
			//Nombre total de publications
			for ($i=0; $i<count($resColl["nombre"]); $i++) {
				if ($resColl["nom"][$i] != "Structure(s) sans pays défini(s) dans HAL") {
					$totColl += $resColl["nombre"][$i];
				}
			}
			*/

			//Tableau final avec %
			for ($i=0; $i<count($resColl["nombre"]); $i++) {
				if ($resColl["nom"][$i] != "Structure(s) sans pays défini(s) dans HAL") {
					$resColl["pcent"][$i] = ($totColl != 0) ? number_format($resColl["nombre"][$i]*100/$totColl, 2) : 0;
				}else{
					$resColl["pcent"][$i] = "-";
				}
			}

			//Initialement, classement du tableau par le nombre de publications ordre décroissant puis affichage
			if ($nomTri == "SORT_ASC") {array_multisort($resColl["nom"], SORT_ASC, SORT_STRING, $resColl["type"], $resColl["nombre"], $resColl["pcent"], $resColl["idhal"], $resColl["pays"]);}
			if ($nomTri == "SORT_DESC") {array_multisort($resColl["nom"], SORT_DESC, SORT_STRING, $resColl["type"], $resColl["nombre"], $resColl["pcent"], $resColl["idhal"], $resColl["pays"]);}
			if ($payTri == "SORT_ASC") {array_multisort($resColl["pays"], SORT_ASC, SORT_STRING, $resColl["nom"], $resColl["nombre"], $resColl["pcent"], $resColl["idhal"], $resColl["type"]);}
			if ($payTri == "SORT_DESC") {array_multisort($resColl["pays"], SORT_DESC, SORT_STRING, $resColl["nom"], $resColl["nombre"], $resColl["pcent"], $resColl["idhal"], $resColl["type"]);}
			if ($typTri == "SORT_ASC") {array_multisort($resColl["type"], SORT_ASC, SORT_STRING, $resColl["nom"], $resColl["nombre"], $resColl["pcent"], $resColl["idhal"], $resColl["pays"]);}
			if ($typTri == "SORT_DESC") {array_multisort($resColl["type"], SORT_DESC, SORT_STRING, $resColl["nom"], $resColl["nombre"], $resColl["pcent"], $resColl["idhal"], $resColl["pays"]);}
			if ($nbrTri == "SORT_ASC") {array_multisort($resColl["nombre"], SORT_ASC, SORT_NUMERIC, $resColl["nom"], $resColl["type"], $resColl["pcent"], $resColl["idhal"], $resColl["pays"]);}
			if ($nbrTri == "SORT_DESC") {array_multisort($resColl["nombre"], SORT_DESC, SORT_NUMERIC, $resColl["nom"], $resColl["type"], $resColl["pcent"], $resColl["idhal"], $resColl["pays"]);}
			
			//echo $totColl;
			//var_dump($resColl);
			
			//Affichage
			$speTri = '<a href="?reqt=req21&team='.$team.'&anneedeb='.$anneedeb.'&anneefin='.$anneefin;
			echo ('<br>Poucentages calculés sur le nombre total de publications de la collection sur la période concernée');
			echo ('<br><table class="table table-striped table-hover table-responsive table-bordered" style="width:100%;">');
			echo ('<thead>');
			echo ('<tr>');
			echo ('<th scope="col" style="text-align:left"><b>'.$speTri.'&ordr='.$nomUrl.'">Nom</a></b></th>');
			echo ('<th scope="col" style="text-align:left"><b>'.$speTri.'&ordr='.$payUrl.'">Pays</a></b></th>');
			echo ('<th scope="col" style="text-align:left"><b>'.$speTri.'&ordr='.$typUrl.'">Type</a></b></th>');
			echo ('<th scope="col" style="text-align:left"><b>'.$speTri.'&ordr='.$nbrUrl.'">Nombre de publications</a></b></th>');
			echo ('<th scope="col" style="text-align:left"><b>%</b></th>');
			echo ('<th scope="col" style="text-align:left"><b>Références HAL</b></th>');
			$chaine = "Nom;Pays;Type;Nombre de publications;%;Références HAL;";
			echo ('</tr>');
			$chaine .= chr(13).chr(10);
			fwrite($inF,$chaine);
			echo ('</thead>');
			echo ('<tbody>');
			
			//Affichage du nombre total de publications de la collection sur la période concernée
			echo ('<tr>');
			echo ('<td>');
			echo ("Publications de la collection sur la période concernée");
			echo ('</td>');
			echo ('<td>');
			echo ('-');
			echo ('</td>');
			echo ('<td>');
			echo ('-');
			echo ('</td>');
			echo ('<td>');
			echo ($totColl);
			echo ('</td>');
			echo ('<td>');
			echo ('100%');
			echo ('</td>');
			echo ('<td>');
			echo ('-');
			echo ('</td>');
			$chaine = "Publications de la collection sur la période concernée".";-;-;".$totColl.";100%;-;";
			echo ('</tr>');
			$chaine .= chr(13).chr(10);
			fwrite($inF,$chaine);
			
			$key = -1;
			for ($i=0; $i<count($resColl["nom"]); $i++) {
				if ($resColl["nom"][$i] != "Structure(s) sans pays défini(s) dans HAL") {
					echo ('<tr>');
					echo ('<td>');
					echo ($resColl["nom"][$i]);
					echo ('</td>');
					echo ('<td>');
					echo ($resColl["pays"][$i]);
					echo ('</td>');
					echo ('<td>');
					echo ($resColl["type"][$i]);
					echo ('</td>');
					echo ('<td>');
					echo ($resColl["nombre"][$i]);
					echo ('</td>');
					echo ('<td>');
					echo ($resColl["pcent"][$i]);
					echo ('%</td>');
					echo ('<td>');
					$idhal = $resColl["idhal"][$i];
					$idhal = "(".str_replace("~", "%20OR%20", $idhal).")";
					$liens = '<a target="_blank" href="https://api.archives-ouvertes.fr/search/'.$team.'/?fq=producedDateY_i:['.$anneedeb.' TO '.$anneefin.']%20AND%20halId_s:'.$idhal.'&rows=10000&wt=xml">XML</a>';
					$liens .= ' - ';
					$liens .= '<a target="_blank" href="https://api.archives-ouvertes.fr/search/'.$team.'/?fq=producedDateY_i:['.$anneedeb.' TO '.$anneefin.']%20AND%20halId_s:'.$idhal.'&rows=10000">JSON</a>';
					echo ($liens);
					echo ('</td>');
					$chaine = str_replace(';', '-', $resColl["nom"][$i]).";".$resColl["pays"][$i].";".$resColl["type"][$i].";".$resColl["nombre"][$i].";".$resColl["pcent"][$i].";".$liens.";";
					echo ('</tr>');
					$chaine .= chr(13).chr(10);
					fwrite($inF,$chaine);
				}else{
					$key = $i;//Clé structure(s) sans pays défini(s) dans HAL
				}
			}
			//Affichage en fin de tableau de la ligne des structure(s) sans pays défini(s) dans HAL
			if ($key != -1) {
				echo ('<tr>');
				echo ('<td>');
				echo ($resColl["nom"][$key]);
				echo ('</td>');
				echo ('<td>');
				echo ($resColl["pays"][$key]);
				echo ('</td>');
				echo ('<td>');
				echo ($resColl["type"][$key]);
				echo ('</td>');
				echo ('<td>');
				echo ($resColl["nombre"][$key]);
				echo ('</td>');
				echo ('<td>');
				echo ($resColl["pcent"][$key]);
				echo ('</td>');
				echo ('<td>');
				$idhal = $resColl["idhal"][$key];
				$idhal = "(".str_replace("~", "%20OR%20", $idhal).")";
				$liens = '<a target="_blank" href="https://api.archives-ouvertes.fr/search/'.$team.'/?fq=producedDateY_i:['.$anneedeb.' TO '.$anneefin.']%20AND%20halId_s:'.$idhal.'&rows=10000&wt=xml">XML</a>';
				$liens .= ' - ';
				$liens .= '<a target="_blank" href="https://api.archives-ouvertes.fr/search/'.$team.'/?fq=producedDateY_i:['.$anneedeb.' TO '.$anneefin.']%20AND%20halId_s:'.$idhal.'&rows=10000">JSON</a>';
				echo ($liens);
				echo ('</td>');
				$chaine = str_replace(';', '-', $resColl["nom"][$key]).";".$resColl["pays"][$key].";".$resColl["type"][$key].";".$resColl["nombre"][$key].";".$resColl["pcent"][$key].";".$liens.";";
				echo ('</tr>');
				$chaine .= chr(13).chr(10);
				fwrite($inF,$chaine);
			}
			
			echo ('</tbody>');
			echo ('</table>');
			echo ('<a href=\'./csv/req21.csv\'>Exporter le tableau au format CSV</a><br><br>');
		}else{
			echo('<b>Aucun résultat</b><br><br>');
		}
  }
	
	//Tableau de résultats requête 22
  if ($reqt == "req22") {
		//Intitulé
		echo('<br><b>22. Collection : Collaborations internationales (institutions)</b><br><br>');
		
		//Descriptif
		echo('<div style="background-color:#f5f5f5">Cette requête affiche, pour une collection, la liste des institutions étrangères auxquelles sont affiliés des co-auteurs. La requête est basée sur le pays de l’affiliation (structCountry_s). Cliquez sur le lien XML / JSON pour afficher les références concernées. Les institutions dont le pays n’est pas renseigné dans le <a target="_blank" href="https://aurehal.archives-ouvertes.fr/structure/index">référentiel AuréHAL</a> sont classés sous la rubriques « Structure(s) sans pays défini(s) dans HAL » en fin de tableau. <a href="#DT">Voir détails techniques en bas de page</a>.</div><br>');
		
		include('./VizuHAL_codes_pays.php');
		
		//Tri par défaut
		$payTri = "";
		$nbrTri = "SORT_DESC";
		$payUrl = "payDes";
		$nbrUrl = "nbrAsc";
		
		//Recherche des éventuelles demandes de tri
		$ordr = (isset($_GET["ordr"])) ? $_GET["ordr"] : "";//Tri demandé
		if ($ordr != "") {
			if (strpos($ordr, "pay") !== false) {//Sur le pays
				if ($ordr == "payAsc") {$payTri = "SORT_ASC"; $nbrTri = ""; $payUrl = "payDes";}else{$payTri = "SORT_DESC"; $nbrTri = ""; $payUrl = "payAsc";}
			}
			if (strpos($ordr, "nbr") !== false) {//Sur le nombre de publications
				if ($ordr == "nbrAsc") {$nbrTri = "SORT_ASC"; $nbrUrl = "nbrDes";}else{$nbrTri = "SORT_DESC"; $nbrUrl = "nbrAsc";}
			}
		}
		
		//Export CSV
    $Fnm = "./csv/req22.csv";
    $inF = fopen($Fnm,"w+");
    fseek($inF, 0);
    $chaine = "\xEF\xBB\xBF";
    fwrite($inF,$chaine);
		
		$resColl = array();
		$resColl["pays"] = array();
		$docType = array("ART", "COMM", "POSTER", "COUV", "OUV", "DOUV");
		$typColl = array();
		$typCollStr = array();//Nombre de types de publications impliquant au moins un pays étranger
		$k = 0;
		$totColl = 0;//Nombre de publications
		$totCollStr = 0;//Nombre de publications impliquant au moins un pays étranger
		$tabPaysFR = array('fr','FR','mq','MQ','gp','GP','gf','GF','yt','YT','nc','NC','pf','PF','pm','PM','tf','TF','re','RE');//Territoires français à ne pas considérer dans l'international
		
		for ($year = $anneedeb; $year <= $anneefin; $year++) {
			$url = "https://api.archives-ouvertes.fr/search/".$team."/?fq=producedDateY_i:".$year."&fl=docType_s,structName_s,structType_s,halId_s,structCountry_s&rows=10000";
			//echo $url;
			askCurl($url, $arrayCurl);
			//var_dump($arrayCurl);
			$totColl += $arrayCurl["response"]["numFound"];
			$i = 0;
			
			while (isset($arrayCurl["response"]["docs"][$i]["structName_s"])) {
				$cptStr = 0;
				//docType
				if (isset($typColl[$arrayCurl["response"]["docs"][$i]["docType_s"]])) {
					$typColl[$arrayCurl["response"]["docs"][$i]["docType_s"]] += 1;
				}else{
					$typColl[$arrayCurl["response"]["docs"][$i]["docType_s"]] = 1;
				}
				if (count($arrayCurl["response"]["docs"][$i]["structCountry_s"]) != count($arrayCurl["response"]["docs"][$i]["structName_s"])) {//Pays non défini pour une structure
					if (array_search("Structure(s) sans pays défini(s) dans HAL", $resColl["pays"]) === false) {
						$resColl["nombre"][$k] = 1;
						foreach($docType as $type) {
							if ($arrayCurl["response"]["docs"][$i]["docType_s"] == $type) {
								$resColl[$type][$k] = 1;
							}else{
								$resColl[$type][$k] = 0;
							}
						}
						$resColl["pays"][$k] = "Structure(s) sans pays défini(s) dans HAL";
						$resColl["idhal"][$k] = $arrayCurl["response"]["docs"][$i]["halId_s"];
						$k++;
					}else{
						$key = array_search("Structure(s) sans pays défini(s) dans HAL", $resColl["pays"]);
						if (strpos($resColl["idhal"][$key], $arrayCurl["response"]["docs"][$i]["halId_s"]) === false) {
							$resColl["nombre"][$key] += 1;
							foreach($docType as $type) {
								if ($arrayCurl["response"]["docs"][$i]["docType_s"] == $type) {
									if (isset($resColl[$type][$key])) {
										$resColl[$type][$key] += 1;
									}else{
										$resColl[$type][$key] = 1;
									}
								}else{
									$resColl[$type][$key] = 0;
								}
							}
							$resColl["idhal"][$key] .= "~".$arrayCurl["response"]["docs"][$i]["halId_s"];
						}
					}
				}else{
					for ($j=0; $j<count($arrayCurl["response"]["docs"][$i]["structName_s"]); $j++) {
						if (isset($arrayCurl["response"]["docs"][$i]["structCountry_s"][$j]) && array_search($arrayCurl["response"]["docs"][$i]["structCountry_s"][$j], $tabPaysFR) === false) {
							if (array_key_exists(strtoupper($arrayCurl["response"]["docs"][$i]["structCountry_s"][$j]), $countries)) {
								$pays = $countries[strtoupper($arrayCurl["response"]["docs"][$i]["structCountry_s"][$j])];
								if ($cptStr == 0) {
									$totCollStr += 1;
									$cptStr = 1;
									if (isset($typCollStr[$arrayCurl["response"]["docs"][$i]["docType_s"]])) {
										$typCollStr[$arrayCurl["response"]["docs"][$i]["docType_s"]] += 1;
									}else{
										$typCollStr[$arrayCurl["response"]["docs"][$i]["docType_s"]] = 1;
									}
								}
								if (array_search($pays, $resColl["pays"]) === false) {//Nouveau pays
									$resColl["pays"][$k] = $pays;
									$resColl["nombre"][$k] = 1;
									foreach($docType as $type) {
										if ($arrayCurl["response"]["docs"][$i]["docType_s"] == $type) {
											$resColl[$type][$k] = 1;
										}else{
											$resColl[$type][$k] = 0;
										}
									}
									$resColl["idhal"][$k] = $arrayCurl["response"]["docs"][$i]["halId_s"];
									$k++;
								}else{
									$key = array_search($pays, $resColl["pays"]);
									if (strpos($resColl["idhal"][$key], $arrayCurl["response"]["docs"][$i]["halId_s"]) === false) {
										$resColl["nombre"][$key] += 1;
										foreach($docType as $type) {
											if ($arrayCurl["response"]["docs"][$i]["docType_s"] == $type) {
												$resColl[$type][$key] += 1;
											}
										}
										$resColl["idhal"][$key] .= "~".$arrayCurl["response"]["docs"][$i]["halId_s"];
									}
								}
							}else{//Code pays inconnu dans la liste ISO des pays
								$key = array_search("Structure(s) sans pays défini(s) dans HAL", $resColl["pays"]);
								if (strpos($resColl["idhal"][$key], $arrayCurl["response"]["docs"][$i]["halId_s"]) === false) {
									$resColl["nombre"][$key] += 1;
									if (isset($resColl[$arrayCurl["response"]["docs"][$i]["docType_s"]][$key])) {
										$resColl[$arrayCurl["response"]["docs"][$i]["docType_s"]][$key] += 1;
									}else{
										$resColl[$arrayCurl["response"]["docs"][$i]["docType_s"]][$key] = 1;
									}
									$resColl["idhal"][$key] .= "~".$arrayCurl["response"]["docs"][$i]["halId_s"];
								}
							}
						}
					}
				}
				$i++;
			}
		}
		//var_dump($typCollStr);
		//var_dump($typColl);
		//var_dump($resColl);
		if ($k != 0) {//Au moins 1 résultat
			/*
			//Nombre total de publications
			for ($i=0; $i<count($resColl["nombre"]); $i++) {
				if ($resColl["pays"][$i] != "Structure(s) sans pays défini(s) dans HAL") {
					$totColl += $resColl["nombre"][$i];
				}
			}
			*/

			//Tableau final avec %
			for ($i=0; $i<count($resColl["nombre"]); $i++) {
				if ($resColl["pays"][$i] != "Structure(s) sans pays défini(s) dans HAL") {
					$resColl["pcent"][$i] = ($totColl != 0) ? number_format($resColl["nombre"][$i]*100/$totColl, 2) : 0;
				}else{
					$resColl["pcent"][$i] = "-";
				}
			}
			
			/*
			//Remplir les tableaux de types de documents avec des valeurs nulles si cellule vide de manière à pouvoir trier
			foreach($docType as $type) {
				for ($i=0; $i<count($resColl["nombre"]); $i++) {
					if (!isset($resColl[$type][$i])) {
						$resColl[$type][$i] = 0;
					}
				}
			}
			*/
			
			//Initialement, classement du tableau par le nombre de publications ordre décroissant puis affichage
			if ($payTri == "SORT_ASC") {array_multisort($resColl["pays"], SORT_ASC, SORT_STRING, $resColl["nombre"], $resColl["pcent"], $resColl["idhal"], $resColl["ART"], $resColl["COMM"], $resColl["POSTER"], $resColl["COUV"], $resColl["OUV"], $resColl["DOUV"]);}
			if ($payTri == "SORT_DESC") {array_multisort($resColl["pays"], SORT_DESC, SORT_STRING, $resColl["nombre"], $resColl["pcent"], $resColl["idhal"], $resColl["ART"], $resColl["COMM"], $resColl["POSTER"], $resColl["COUV"], $resColl["OUV"], $resColl["DOUV"]);}
			if ($nbrTri == "SORT_ASC") {array_multisort($resColl["nombre"], SORT_ASC, SORT_NUMERIC, $resColl["pcent"], $resColl["idhal"], $resColl["pays"], $resColl["ART"], $resColl["COMM"], $resColl["POSTER"], $resColl["COUV"], $resColl["OUV"], $resColl["DOUV"]);}
			if ($nbrTri == "SORT_DESC") {array_multisort($resColl["nombre"], SORT_DESC, SORT_NUMERIC, $resColl["pcent"], $resColl["idhal"], $resColl["pays"], $resColl["ART"], $resColl["COMM"], $resColl["POSTER"], $resColl["COUV"], $resColl["OUV"], $resColl["DOUV"]);}
			
			//echo $totColl;
			//var_dump($resColl);
			
			//Carte mondiale
			echo('<link href="./lib/JQVmaps/jqvmap.css" media="screen" rel="stylesheet" type="text/css">');
			echo('<script type="text/javascript" src="./lib/JQVmaps/jquery.vmap.js"></script>');
			echo('<script type="text/javascript" src="./lib/JQVmaps/maps/jquery.vmap.world.js" charset="utf-8"></script>');
			//Ajout des données
			echo('<script>');
			echo('    var gdpData = {');
			for ($i=0; $i<count($resColl["pays"]); $i++) {
				if ($resColl["pays"][$i] != "Structure(s) sans pays défini(s) dans HAL") {
					$key = strtolower(array_search($resColl["pays"][$i], $countries));
					echo ('"'.$key.'":'.$resColl["nombre"][$i].', ');
				}
			}
			//echo('"fr":'.$totCollStr);
			echo('	};');
			echo('</script>');
			echo('<script>');
			echo('  var max = 0,');
			echo('        min = Number.MAX_VALUE,');
			echo('        cc,');
			echo('        startColor = [200, 238, 255],');
			echo('        endColor = [0, 100, 145],');
			echo('        colors = {},');
			echo('        hex;');
			//find maximum and minimum values
			echo('    for (cc in gdpData)');
			echo('    {');
			echo('        if (parseFloat(gdpData[cc]) > max)');
			echo('        {');
			echo('            max = parseFloat(gdpData[cc]);');
			echo('        }');
			echo('        if (parseFloat(gdpData[cc]) < min)');
			echo('        {');
			echo('            min = parseFloat(gdpData[cc]);');
			echo('        }');
			echo('    }');
			//set colors according to values of GDP
			echo('    for (cc in gdpData)');
			echo('    {');
			echo('        if (gdpData[cc] > 0)');
			echo('        {');
			echo('            colors[cc] = \'#\';');
			echo('            for (var i = 0; i<3; i++)');
			echo('            {');
			echo('                hex = Math.round(startColor[i]');
			echo('                    + (endColor[i]');
			echo('                    - startColor[i])');
			echo('                    * (gdpData[cc] / (max - min))).toString(16);');
			echo('                if (hex.length == 1)');
			echo('                {');
			echo('                    hex = \'0\'+hex;');
			echo('                }');
			echo('                colors[cc] += (hex.length == 1 ? \'0\' : \'\') + hex;');
			echo('            }');
			echo('        }');
			echo('    }');
			echo('</script>');

			//Appel de la carte
			echo('<script type="text/javascript">');
			echo('jQuery(document).ready(function() {');
			echo('jQuery(\'#vmap\').vectorMap({ ');
			echo('	onLabelShow: function (event, label, code) {');
			echo('	if(gdpData[code] > 0)');
			echo('  	label.append(\': \'+gdpData[code]);');
			echo('	},');
			echo('	map: \'world_en\',');
			echo('	colors: colors,');
			echo('	hoverOpacity: 0.7,');
			echo('	hoverColor: false });');
			echo('});');
			echo('</script>');
			if ($anneedeb != $anneefin) {
				$per = "sur la période ".$anneedeb." - ".$anneefin;
			}else{
				$per = "en ".$anneedeb;
			}
			echo('<center><h3>Carte interactive du nombre de publications par pays pour la collection '.$team.' '.$per.'</h3><br><div id="vmap" style="width: 800px; height: 530px;"></div><br><br></center>');
			
			//Affichage
			$speTri = '<a href="?reqt=req22&team='.$team.'&anneedeb='.$anneedeb.'&anneefin='.$anneefin;
			echo ('<br>Poucentages calculés sur le nombre total de publications de la collection sur la période concernée');
			echo ('<br><table class="table table-striped table-hover table-responsive table-bordered" style="width:100%;">');
			echo ('<thead>');
			echo ('<tr>');
			echo ('<th scope="col" style="text-align:left"><b>'.$speTri.'&ordr='.$payUrl.'">Pays</a></b></th>');
			echo ('<th scope="col" style="text-align:left"><b>'.$speTri.'&ordr='.$nbrUrl.'">Nombre de publications</a></b></th>');
			echo ('<th scope="col" style="text-align:left"><b>%</b></th>');
			echo ('<th scope="col" style="text-align:left"><b>ART</b></th>');
			echo ('<th scope="col" style="text-align:left"><b>COMM</b></th>');
			echo ('<th scope="col" style="text-align:left"><b>POSTER</b></th>');
			echo ('<th scope="col" style="text-align:left"><b>COUV</b></th>');
			echo ('<th scope="col" style="text-align:left"><b>OUV</b></th>');
			echo ('<th scope="col" style="text-align:left"><b>DOUV</b></th>');
			echo ('<th scope="col" style="text-align:left"><b>Références HAL</b></th>');
			$chaine = "Pays;Code pays ISO;Nombre de publications;%;ART;COMM;POSTER;COUV;OUV;DOUV;Références HAL;";
			echo ('</tr>');
			$chaine .= chr(13).chr(10);
			fwrite($inF,$chaine);
			echo ('</thead>');
			echo ('<tbody>');
			
			//Affichage du nombre total de publications de la collection sur la période concernée
			$chaine = "Publications de la collection sur la période concernée".";;".$totColl.";100%;";
			echo ('<tr>');
			echo ('<td>');
			echo ("Publications de la collection sur la période concernée");
			echo ('</td>');
			echo ('<td>');
			echo ($totColl);
			echo ('</td>');
			echo ('<td>');
			echo ('100%');
			echo ('</td>');
			foreach($docType as $type) {
				$totType = 0;
				if (isset($typColl[$type])) {
					$totType = $typColl[$type];
				}
				echo ('<td>'.number_format($totType*100/$totColl, 2).'%</td>');
				$chaine .= number_format($totType*100/$totColl, 2).";";
			}
			echo ('<td>');
			echo ('-');
			echo ('</td>');
			$chaine .= "-;";
			echo ('</tr>');
			$chaine .= chr(13).chr(10);
			fwrite($inF,$chaine);
			
			//Affichage du nombre de publications impliquant au moins un pays étranger
			$pcentStr = ($totColl != 0) ? number_format($totCollStr*100/$totColl, 2) : 0;
			$chaine = "Publications impliquant au moins un pays étranger".";;".$totCollStr.";".$pcentStr.";";
			echo ('<tr>');
			echo ('<td>');
			echo ("Publications impliquant au moins un pays étranger");
			echo ('</td>');
			echo ('<td>');
			echo ($totCollStr);
			echo ('</td>');
			echo ('<td>');
			echo ($pcentStr.'%');
			echo ('</td>');
			foreach($docType as $type) {
				$totType = 0;
				if (isset($typCollStr[$type])) {
					$totType = $typCollStr[$type];
				}
				echo ('<td>'.number_format($totType*100/$totColl, 2).'%</td>');
				$chaine .= number_format($totType*100/$totColl, 2).";";
			}
			echo ('<td>');
			echo ('-');
			echo ('</td>');
			$chaine .= "-;";
			echo ('</tr>');
			$chaine .= chr(13).chr(10);
			fwrite($inF,$chaine);
			
			$key = -1;
			for ($i=0; $i<count($resColl["pays"]); $i++) {
				if ($resColl["pays"][$i] != "Structure(s) sans pays défini(s) dans HAL") {
					$chaine = $resColl["pays"][$i].";".array_search($resColl["pays"][$i], $countries).";".$resColl["nombre"][$i].";".$resColl["pcent"][$i].";";
					echo ('<tr>');
					echo ('<td>');
					echo ($resColl["pays"][$i]);
					echo ('</td>');
					echo ('<td>');
					echo ($resColl["nombre"][$i]);
					echo ('</td>');
					echo ('<td>');
					echo ($resColl["pcent"][$i]);
					echo ('%</td>');
					foreach($docType as $type) {
						$totType = 0;
						if (isset($resColl[$type][$i])) {
							$totType = $resColl[$type][$i];
						}
						echo ('<td>'.number_format($totType*100/$totColl, 2).'%</td>');
						$chaine .= number_format($totType*100/$totColl, 2).";";
					}
					echo ('<td>');
					$idhal = $resColl["idhal"][$i];
					$idhal = "(".str_replace("~", "%20OR%20", $idhal).")";
					$liens = '<a target="_blank" href="https://api.archives-ouvertes.fr/search/'.$team.'/?fq=producedDateY_i:['.$anneedeb.' TO '.$anneefin.']%20AND%20halId_s:'.$idhal.'&rows=10000&wt=xml">XML</a>';
					$liens .= ' - ';
					$liens .= '<a target="_blank" href="https://api.archives-ouvertes.fr/search/'.$team.'/?fq=producedDateY_i:['.$anneedeb.' TO '.$anneefin.']%20AND%20halId_s:'.$idhal.'&rows=10000">JSON</a>';
					echo ($liens);
					echo ('</td>');
					$chaine .= $liens.";";
					echo ('</tr>');
					$chaine .= chr(13).chr(10);
					fwrite($inF,$chaine);
				}else{
					$key = $i;//Clé structure(s) sans pays défini(s) dans HAL
				}
			}
			
			//Affichage en fin de tableau de la ligne des structure(s) sans pays défini(s) dans HAL
			if ($key != -1) {
				$chaine = $resColl["pays"][$key].";;".$resColl["nombre"][$key].";".$resColl["pcent"][$key].";";
				echo ('<tr>');
				echo ('<td>');
				echo ($resColl["pays"][$key]);
				echo ('</td>');
				echo ('<td>');
				echo ($resColl["nombre"][$key]);
				echo ('</td>');
				echo ('<td>');
				echo ($resColl["pcent"][$key]);
				echo ('</td>');
				foreach($docType as $type) {
					echo ('<td>-</td>');
					$chaine .= "-;";
				}
				echo ('<td>');
				$idhal = $resColl["idhal"][$key];
				$idhal = "(".str_replace("~", "%20OR%20", $idhal).")";
				$liens = '<a target="_blank" href="https://api.archives-ouvertes.fr/search/'.$team.'/?fq=producedDateY_i:['.$anneedeb.' TO '.$anneefin.']%20AND%20halId_s:'.$idhal.'&rows=10000&wt=xml">XML</a>';
				$liens .= ' - ';
				$liens .= '<a target="_blank" href="https://api.archives-ouvertes.fr/search/'.$team.'/?fq=producedDateY_i:['.$anneedeb.' TO '.$anneefin.']%20AND%20halId_s:'.$idhal.'&rows=10000">JSON</a>';
				echo ($liens);
				echo ('</td>');
				$chaine .= $liens.";";
				echo ('</tr>');
				$chaine .= chr(13).chr(10);
				fwrite($inF,$chaine);
			}
			
			echo ('</tbody>');
			echo ('</table>');
			echo ('<a href=\'./csv/req22.csv\'>Exporter le tableau au format CSV</a><br><br>');
		}else{
			echo('<b>Aucun résultat</b><br><br>');
		}
  }
	
	//Tableau de résultats requête 23
  if ($reqt == "req23") {
		//Intitulé
		echo('<br><b>23. Collection : Collaborations internationales (pays)</b><br><br>');
		
		//Descriptif
		echo('<div style="background-color:#f5f5f5">Cette requête affiche, pour une collection, la liste des pays (ie. affiliation des co-auteurs) représentée sous forme de carte interactive. La requête est basée sur le pays de l’affiliation (structCountry_s). Cliquez sur le lien XML / JSON pour afficher les références concernées.  Les structures dont le pays n’est pas renseigné dans le <a target="_blank" href="https://aurehal.archives-ouvertes.fr/structure/index">référentiel AuréHAL</a>L (<a target="_blank" href="https://aurehal.archives-ouvertes.fr/structure/browse?critere=-country_s%3A%5B%22%22+TO+*%5D&category=*">elles sont nombreuses</a>) sont classées sous la rubriques « Structure(s) sans pays défini(s) dans HAL » en fin de tableau. <a href="#DT">Voir détails techniques en bas de page</a>.</div><br>');
		
		include('./VizuHAL_codes_pays.php');
		$typTab = array(
		'regroupinstitution' => 'Regroupement d\'institutions',
		'institution' => 'Institution',
		'regrouplaboratory' => 'Regroupement de laboratoires, département',
		);
		
		//Tri par défaut
		$nomTri = "";
		$payTri = "";
		$typTri = "";
		$nbrTri = "SORT_DESC";
		$nomUrl = "nomDes";
		$payUrl = "payDes";
		$typUrl = "typAsc";
		$nbrUrl = "nbrAsc";
		
		//Recherche des éventuelles demandes de tri
		$ordr = (isset($_GET["ordr"])) ? $_GET["ordr"] : "";//Tri demandé
		if ($ordr != "") {
			if (strpos($ordr, "nom") !== false) {//Sur le nom de la structure
				if ($ordr == "nomAsc") {$nomTri = "SORT_ASC"; $nbrTri = ""; $nomUrl = "nomDes";}else{$nomTri = "SORT_DESC"; $nbrTri = ""; $nomUrl = "nomAsc";}
			}
			if (strpos($ordr, "pay") !== false) {//Sur le pays de la structure
				if ($ordr == "payAsc") {$payTri = "SORT_ASC"; $nbrTri = ""; $payUrl = "payDes";}else{$payTri = "SORT_DESC"; $nbrTri = ""; $payUrl = "payAsc";}
			}
			if (strpos($ordr, "typ") !== false) {//Sur le type de la structure
				if ($ordr == "typAsc") {$typTri = "SORT_ASC"; $nbrTri = ""; $typUrl = "typDes";}else{$typTri = "SORT_DESC"; $nbrTri = ""; $typUrl = "typAsc";}
			}
			if (strpos($ordr, "nbr") !== false) {//Sur le nombre de publications
				if ($ordr == "nbrAsc") {$nbrTri = "SORT_ASC"; $nbrUrl = "nbrDes";}else{$nbrTri = "SORT_DESC"; $nbrUrl = "nbrAsc";}
			}
		}
		
		//Export CSV
    $Fnm = "./csv/req23.csv";
    $inF = fopen($Fnm,"w+");
    fseek($inF, 0);
    $chaine = "\xEF\xBB\xBF";
    fwrite($inF,$chaine);
		
		$resColl = array();
		$resColl["nom"] = array();
		$k = 0;
		$totColl = 0;
		$tabPaysFR = array('fr','FR','mq','MQ','gp','GP','gf','GF','yt','YT','nc','NC','pf','PF','pm','PM','tf','TF','re','RE');//Territoires français à ne pas considérer dans l'international
		
		for ($year = $anneedeb; $year <= $anneefin; $year++) {
			$url = "https://api.archives-ouvertes.fr/search/".$team."/?fq=producedDateY_i:".$year."&fl=structName_s,structType_s,halId_s,structCountry_s&rows=10000";
			//echo $url;
			//$totColl += askCurlNF("https://api.archives-ouvertes.fr/search/".$team."/?wt=xml&fq=producedDateY_i:".$year."&fl=structName_s,structType_s,halId_s,structCountry_s");
			askCurl($url, $arrayCurl);
			//var_dump($arrayCurl);
			$totColl += $arrayCurl["response"]["numFound"];
			$i = 0;
			
			while (isset($arrayCurl["response"]["docs"][$i]["structName_s"])) {
				if (count($arrayCurl["response"]["docs"][$i]["structCountry_s"]) != count($arrayCurl["response"]["docs"][$i]["structName_s"])) {//Pays non défini pour une structure
					if (array_search("Structure(s) sans pays défini(s) dans HAL", $resColl["nom"]) === false) {
						$resColl["nom"][$k] = "Structure(s) sans pays défini(s) dans HAL";
						$resColl["nombre"][$k] = 1;
						$resColl["type"][$k] = "-";
						$resColl["pays"][$k] = "-";
						$resColl["idhal"][$k] = $arrayCurl["response"]["docs"][$i]["halId_s"];
						$k++;
					}else{
						$key = array_search("Structure(s) sans pays défini(s) dans HAL", $resColl["nom"]);
						$resColl["nombre"][$key] += 1;
						$resColl["idhal"][$key] .= "~".$arrayCurl["response"]["docs"][$i]["halId_s"];
					}
				}else{
					for ($j=0; $j<count($arrayCurl["response"]["docs"][$i]["structName_s"]); $j++) {
						if (isset($arrayCurl["response"]["docs"][$i]["structCountry_s"][$j]) && array_search($arrayCurl["response"]["docs"][$i]["structCountry_s"][$j], $tabPaysFR) === false) {
							if (array_search(ucfirst(trim($arrayCurl["response"]["docs"][$i]["structName_s"][$j])), $resColl["nom"]) === false) {//Nouvelle structure
								if (array_key_exists(strtoupper($arrayCurl["response"]["docs"][$i]["structCountry_s"][$j]), $countries)) {
									if (array_key_exists(strtolower(trim($arrayCurl["response"]["docs"][$i]["structType_s"][$j])), $typTab)) {//Le type de structure est bien parmi ceux recherchés
										$resColl["nom"][$k] = ucfirst(trim($arrayCurl["response"]["docs"][$i]["structName_s"][$j]));
										$resColl["nombre"][$k] = 1;
										$resColl["type"][$k] = $typTab[strtolower(trim($arrayCurl["response"]["docs"][$i]["structType_s"][$j]))];
										$resColl["pays"][$k] = $countries[strtoupper($arrayCurl["response"]["docs"][$i]["structCountry_s"][$j])];
										$resColl["idhal"][$k] = $arrayCurl["response"]["docs"][$i]["halId_s"];
										$k++;
									}								
								}else{//Code pays inconnu dans la liste ISO des pays
									if (array_search("Structure(s) sans pays défini(s) dans HAL", $resColl["nom"]) === false) {
										$resColl["nom"][$k] = "Structure(s) sans pays défini(s) dans HAL";
										$resColl["nombre"][$k] = 1;
										$resColl["type"][$k] = "-";
										$resColl["pays"][$k] = "-";
										$resColl["idhal"][$k] = $arrayCurl["response"]["docs"][$i]["halId_s"];
										$k++;
									}else{
										$key = array_search("Structure(s) sans pays défini(s) dans HAL", $resColl["nom"]);
										$resColl["nombre"][$key] += 1;
										$resColl["idhal"][$key] .= "~".$arrayCurl["response"]["docs"][$i]["halId_s"];
									}
								}
							}else{
								$key = array_search(ucfirst(trim($arrayCurl["response"]["docs"][$i]["structName_s"][$j])), $resColl["nom"]);
								$resColl["nombre"][$key] += 1;
								$resColl["idhal"][$key] .= "~".$arrayCurl["response"]["docs"][$i]["halId_s"];
							}
						}
					}
				}
				$i++;
			}
		}

		if ($k != 0) {//Au moins 1 résultat
			/*
			//Nombre total de publications
			for ($i=0; $i<count($resColl["nombre"]); $i++) {
				if ($resColl["nom"][$i] != "Structure(s) sans pays défini(s) dans HAL") {
					$totColl += $resColl["nombre"][$i];
				}
			}
			*/

			//Tableau final avec %
			for ($i=0; $i<count($resColl["nombre"]); $i++) {
				if ($resColl["nom"][$i] != "Structure(s) sans pays défini(s) dans HAL") {
					$resColl["pcent"][$i] = ($totColl != 0) ? number_format($resColl["nombre"][$i]*100/$totColl, 2) : 0;
				}else{
					$resColl["pcent"][$i] = "-";
				}
			}

			//Initialement, classement du tableau par le nombre de publications ordre décroissant puis affichage
			if ($nomTri == "SORT_ASC") {array_multisort($resColl["nom"], SORT_ASC, SORT_STRING, $resColl["type"], $resColl["nombre"], $resColl["pcent"], $resColl["idhal"], $resColl["pays"]);}
			if ($nomTri == "SORT_DESC") {array_multisort($resColl["nom"], SORT_DESC, SORT_STRING, $resColl["type"], $resColl["nombre"], $resColl["pcent"], $resColl["idhal"], $resColl["pays"]);}
			if ($payTri == "SORT_ASC") {array_multisort($resColl["pays"], SORT_ASC, SORT_STRING, $resColl["nom"], $resColl["nombre"], $resColl["pcent"], $resColl["idhal"], $resColl["type"]);}
			if ($payTri == "SORT_DESC") {array_multisort($resColl["pays"], SORT_DESC, SORT_STRING, $resColl["nom"], $resColl["nombre"], $resColl["pcent"], $resColl["idhal"], $resColl["type"]);}
			if ($typTri == "SORT_ASC") {array_multisort($resColl["type"], SORT_ASC, SORT_STRING, $resColl["nom"], $resColl["nombre"], $resColl["pcent"], $resColl["idhal"], $resColl["pays"]);}
			if ($typTri == "SORT_DESC") {array_multisort($resColl["type"], SORT_DESC, SORT_STRING, $resColl["nom"], $resColl["nombre"], $resColl["pcent"], $resColl["idhal"], $resColl["pays"]);}
			if ($nbrTri == "SORT_ASC") {array_multisort($resColl["nombre"], SORT_ASC, SORT_NUMERIC, $resColl["nom"], $resColl["type"], $resColl["pcent"], $resColl["idhal"], $resColl["pays"]);}
			if ($nbrTri == "SORT_DESC") {array_multisort($resColl["nombre"], SORT_DESC, SORT_NUMERIC, $resColl["nom"], $resColl["type"], $resColl["pcent"], $resColl["idhal"], $resColl["pays"]);}
			
			//echo $totColl;
			//var_dump($resColl);
			
			//Affichage
			$speTri = '<a href="?reqt=req23&team='.$team.'&anneedeb='.$anneedeb.'&anneefin='.$anneefin;
			echo ('<br>Poucentages calculés sur le nombre total de publications de la collection sur la période concernée');
			echo ('<br><table class="table table-striped table-hover table-responsive table-bordered" style="width:100%;">');
			echo ('<thead>');
			echo ('<tr>');
			echo ('<th scope="col" style="text-align:left"><b>'.$speTri.'&ordr='.$nomUrl.'">Nom</a></b></th>');
			echo ('<th scope="col" style="text-align:left"><b>'.$speTri.'&ordr='.$payUrl.'">Pays</a></b></th>');
			echo ('<th scope="col" style="text-align:left"><b>'.$speTri.'&ordr='.$typUrl.'">Type</a></b></th>');
			echo ('<th scope="col" style="text-align:left"><b>'.$speTri.'&ordr='.$nbrUrl.'">Nombre de publications</a></b></th>');
			echo ('<th scope="col" style="text-align:left"><b>%</b></th>');
			echo ('<th scope="col" style="text-align:left"><b>Références HAL</b></th>');
			$chaine = "Nom;Pays;Type;Nombre de publications;%;Références HAL;";
			echo ('</tr>');
			$chaine .= chr(13).chr(10);
			fwrite($inF,$chaine);
			echo ('</thead>');
			echo ('<tbody>');
			
			//Affichage du nombre total de publications de la collection sur la période concernée
			echo ('<tr>');
			echo ('<td>');
			echo ("Publications de la collection sur la période concernée");
			echo ('</td>');
			echo ('<td>');
			echo ('-');
			echo ('</td>');
			echo ('<td>');
			echo ('-');
			echo ('</td>');
			echo ('<td>');
			echo ($totColl);
			echo ('</td>');
			echo ('<td>');
			echo ('100%');
			echo ('</td>');
			echo ('<td>');
			echo ('-');
			echo ('</td>');
			$chaine = "Publications de la collection sur la période concernée".";-;-;".$totColl.";100%;-;";
			echo ('</tr>');
			$chaine .= chr(13).chr(10);
			fwrite($inF,$chaine);
			
			$key = -1;
			for ($i=0; $i<count($resColl["nom"]); $i++) {
				if ($resColl["nom"][$i] != "Structure(s) sans pays défini(s) dans HAL") {
					echo ('<tr>');
					echo ('<td>');
					echo ($resColl["nom"][$i]);
					echo ('</td>');
					echo ('<td>');
					echo ($resColl["pays"][$i]);
					echo ('</td>');
					echo ('<td>');
					echo ($resColl["type"][$i]);
					echo ('</td>');
					echo ('<td>');
					echo ($resColl["nombre"][$i]);
					echo ('</td>');
					echo ('<td>');
					echo ($resColl["pcent"][$i]);
					echo ('%</td>');
					echo ('<td>');
					$idhal = $resColl["idhal"][$i];
					$idhal = "(".str_replace("~", "%20OR%20", $idhal).")";
					$liens = '<a target="_blank" href="https://api.archives-ouvertes.fr/search/'.$team.'/?fq=producedDateY_i:['.$anneedeb.' TO '.$anneefin.']%20AND%20halId_s:'.$idhal.'&rows=10000&wt=xml">XML</a>';
					$liens .= ' - ';
					$liens .= '<a target="_blank" href="https://api.archives-ouvertes.fr/search/'.$team.'/?fq=producedDateY_i:['.$anneedeb.' TO '.$anneefin.']%20AND%20halId_s:'.$idhal.'&rows=10000">JSON</a>';
					echo ($liens);
					echo ('</td>');
					$chaine = str_replace(';', '-', $resColl["nom"][$i]).";".$resColl["pays"][$i].";".$resColl["type"][$i].";".$resColl["nombre"][$i].";".$resColl["pcent"][$i].";".$liens.";";
					echo ('</tr>');
					$chaine .= chr(13).chr(10);
					fwrite($inF,$chaine);
				}else{
					$key = $i;//Clé structure(s) sans pays défini(s) dans HAL
				}
			}
			//Affichage en fin de tableau de la ligne des structure(s) sans pays défini(s) dans HAL
			if ($key != -1) {
				echo ('<tr>');
				echo ('<td>');
				echo ($resColl["nom"][$key]);
				echo ('</td>');
				echo ('<td>');
				echo ($resColl["pays"][$key]);
				echo ('</td>');
				echo ('<td>');
				echo ($resColl["type"][$key]);
				echo ('</td>');
				echo ('<td>');
				echo ($resColl["nombre"][$key]);
				echo ('</td>');
				echo ('<td>');
				echo ($resColl["pcent"][$key]);
				echo ('</td>');
				echo ('<td>');
				$idhal = $resColl["idhal"][$key];
				$idhal = "(".str_replace("~", "%20OR%20", $idhal).")";
				$liens = '<a target="_blank" href="https://api.archives-ouvertes.fr/search/'.$team.'/?fq=producedDateY_i:['.$anneedeb.' TO '.$anneefin.']%20AND%20halId_s:'.$idhal.'&rows=10000&wt=xml">XML</a>';
				$liens .= ' - ';
				$liens .= '<a target="_blank" href="https://api.archives-ouvertes.fr/search/'.$team.'/?fq=producedDateY_i:['.$anneedeb.' TO '.$anneefin.']%20AND%20halId_s:'.$idhal.'&rows=10000">JSON</a>';
				echo ($liens);
				echo ('</td>');
				$chaine = str_replace(';', '-', $resColl["nom"][$key]).";".$resColl["pays"][$key].";".$resColl["type"][$key].";".$resColl["nombre"][$key].";".$resColl["pcent"][$key].";".$liens.";";
				echo ('</tr>');
				$chaine .= chr(13).chr(10);
				fwrite($inF,$chaine);
			}
			
			echo ('</tbody>');
			echo ('</table>');
			echo ('<a href=\'./csv/req23.csv\'>Exporter le tableau au format CSV</a><br><br>');
		}else{
			echo('<b>Aucun résultat</b><br><br>');
		}
  }
	

  //Création de graphes
  //Librairies pChart
	if (strpos(phpversion(), "7") !== false) {//PHP7 > pChart2
		//Librairies pChart
		include_once("./lib/pChart2/pChart/pDraw.php");
		include_once("./lib/pChart2/pChart/pException.php");
		include_once("./lib/pChart2/pChart/pColor.php");
		include_once("./lib/pChart2/pChart/pColorGradient.php");
		include_once("./lib/pChart2/pChart/pData.php");
		include_once("./lib/pChart2/pChart/pCharts.php");
		include_once("./lib/pChart2/pChart/pPie.php");
	}else{//PHP 5 > pChart
		//Librairies pChart
		include("./lib/pChart/class/pData.class.php");
		include("./lib/pChart/class/pDraw.class.php");
		include("./lib/pChart/class/pImage.class.php");
		include("./lib/pChart/class/pPie.class.php");
	}

  if (isset($reqt) && $reqt == "req1") {
    include("./VizuHAL_grf_histo_req1.php");
    include("./VizuHAL_grf_cbert_req1.php");
  }
  
  if (isset($reqt) && $reqt == "req2") {
    include("./VizuHAL_grf_histo_req2.php");
    include("./VizuHAL_grf_cbert_req2.php");
  }

  if (isset($reqt) && ($reqt == "req1" || $reqt == "req2")) {
    if (isset($port) && $port != "choix") {
      $is = 0;
      while (isset($sect[$is]) && $sect[$is] != "") {
        //histogramme
        $ficgraf = "./grf/grf_".$sect[$is]."_".time().".png";
        grf_histo($anneedeb, $anneefin, $tabPro, $sect[$is], $ficgraf, "port");
        echo('<center><img alt="Productions HAL "'.$sect[$is].' src="'.$ficgraf.'"></center><br>');
        
        //Camemberts
        if ($reqt == "req1") {
          for($year = $anneedeb; $year <= $anneefin; $year++) {
            $ficgraf = "./grf/grf_".$year."_".$sect[$is]."_".time().".png";
            grf_cbert($year, $tabPro, $sect[$is], $ficgraf, "coll");
            echo('<center><img alt="Productions HAL "'.$year.' '.$team.' src="'.$ficgraf.'"></center><br>');
          }
        }

        $is++;
      }
    }else{
      //histogramme
      $ficgraf = "./grf/grf_".time().".png";
      grf_histo($anneedeb, $anneefin, $resHAL, $team, $ficgraf, "coll");
      echo('<center><img alt="Productions HAL "'.$team.' src="'.$ficgraf.'"></center><br>');

      //Camemberts
      for($year = $anneedeb; $year <= $anneefin; $year++) {
        $ficgraf = "./grf/grf_".$year."_".time().".png";
        grf_cbert($year, $resHAL, $team, $ficgraf, "coll");
        echo('<center><img alt="Productions HAL "'.$year.' '.$team.' src="'.$ficgraf.'"></center><br>');
      }
    }
  }
}

//Détails techniques
echo('<a name="DT"></a>');

//Requête 1
echo('<div id="DTreq1" style="width:100%;float: left;background-color:#f5f5f5;border:1px solid #dddddd;padding: 3px;border-radius: 3px;margin-bottom: 10px;">');
echo('<span style="color:#333333;" class="accordeon"><b>Consultez la documentation technique</b>&nbsp;<font color="#aaaaaa"><i>(Cliquez)</i></font></span>');
echo('<div class="panel" style="margin-bottom: 0px; border: 0px;"><br>');
echo('
<b>Pour les utilisateurs hors Rennes 1</b> : pour exploiter cette requête, il faut au préalable compléter la liste des codes collections des secteurs et unités dans un tableau PortHAL-UNIV-XXXXX.php, sur le modèle du fichier PortHAL-RENNES1.php. En l’absence de secteurs, il suffit de reporter le code collection (ex : UNIV-RENNES1) comme valeur des champs « secteurs » du tableau PHP.<br>
<br>
# dépôts HAL-UR1 par année de publication (= colonne « <b>Productions 2017</b> ») :<br>
<a target="_blank" href="https://api.archives-ouvertes.fr/search/univ-rennes1/?fq=producedDateY_i:2017&fq=-submitType_s:annex&fq=-status_i=111">https://api.archives-ouvertes.fr/search/univ-rennes1/?fq=producedDateY_i:2017&fq=-submitType_s:annex&fq=-status_i=111</a><br>
<br>
# notices HAL-UR1 par année de publication (= colonne « <b>Productions 2017 sans texte intégral déposé dans HAL</b> ») :<br>
<a target="_blank" href="https://api.archives-ouvertes.fr/search/univ-rennes1/?fq=producedDateY_i:2017&fq=submitType_s:notice&fq=-status_i=111">https://api.archives-ouvertes.fr/search/univ-rennes1/?fq=producedDateY_i:2017&fq=submitType_s:notice&fq=-status_i=111</a><br>
<br>
# manuscrits HAL-UR1 par année de publication (= colonne « <b>Productions 2017 avec texte intégral déposé dans HAL</b> ») :<br>
<a target="_blank" href="https://api.archives-ouvertes.fr/search/univ-rennes1/?fq=producedDateY_i:2017&fq=submitType_s:file&fq=-status_i=111">https://api.archives-ouvertes.fr/search/univ-rennes1/?fq=producedDateY_i:2017&fq=submitType_s:file&fq=-status_i=111</a><br>
<br>
# notices HAL-UR1 avec lien open access par année de publication (= colonne « <b>Productions 2017 sans texte intégral déposé dans HAL mais avec texte intégral librement accessible hors HAL</b> ») :<br>
<a target="_blank" href="https://api.archives-ouvertes.fr/search/univ-rennes1/?fq=producedDateY_i:2017&fq=linkExtId_s:*&fq=-linkExtId_s:istex&fq=-status_i=111">https://api.archives-ouvertes.fr/search/univ-rennes1/?fq=producedDateY_i:2017&fq=linkExtId_s:*&fq=-linkExtId_s:istex&fq=-status_i=111</a><br>
<br>
# manuscrits et lien open access HAL-UR1 par année de publication (= colonne « <b>Productions 2017 avec texte intégral déposé dans HAL ou librement accessible hors HAL</b> ») :<br>
<a target="_blank" href="https://api.archives-ouvertes.fr/search/univ-rennes1/?fq=producedDateY_i:2017&fq=(submitType_s:file%20OR%20linkExtId_s:*)&fq=-linkExtId_s:istex&fq=-status_i=111">https://api.archives-ouvertes.fr/search/univ-rennes1/?fq=producedDateY_i:2017&fq=(submitType_s:file%20OR%20linkExtId_s:*)&fq=-linkExtId_s:istex&fq=-status_i=111</a><br>
<br>
<b>Notes :</b><br>
<ul>
<li>Les données obtenues pour les secteurs ne sont pas la somme des données collections : certains dépôts sont en effet des co-publications et peuvent apparaître dans plusieurs collections à la fois au sein d’un même secteur. En les additionnant, on fausserait les résultats.</li>
<li>Dans les requêtes API, il faut éliminer les dépôts ayant le statut 111, c’est-à-dire portant la mention d’un numéro de version (versions 2, 3 etc.). Voir ticket HAL #60428. Dans la requête API, cela peut s’écrire fq=-status_i=111 (avec signe - devant le champ « status_i »).</li>
<li>Dans les requêtes API portant sur le lien vers un PDF librement disponible hors de HAL (via <a target="_blank" href="https://unpaywall.org/">Unpaywall</a>), il faut exclure les liens ISTEX (uniquement accessibles aux membres ESR) : fq=-linkExtId_s:istex</li>
</ul>
');
echo('<br></div></div>');

//Requête 2
echo('<div id="DTreq2" style="width:100%;float: left;background-color:#f5f5f5;border:1px solid #dddddd;padding: 3px;border-radius: 3px;margin-bottom: 10px;">');
echo('<span style="color:#333333;" class="accordeon"><b>Consultez la documentation technique</b>&nbsp;<font color="#aaaaaa"><i>(Cliquez)</i></font></span>');
echo('<div class="panel" style="margin-bottom: 0px; border: 0px;"><br>');
echo('
<b>Pour les utilisateurs hors Rennes 1</b> : pour exploiter la requête portail, il faut au préalable compléter la liste des codes collections des secteurs et unités dans un tableau PortHAL-UNIV-XXXXX.php, sur le modèle du fichier PortHAL-RENNES1.php. En l’absence de secteurs, il suffit de reporter le code collection (ex : UNIV-RENNES1) comme valeur des champs « secteurs «  du tableau PHP.<br>
<br>
# notices et texte intégral HAL-UR1 (toutes les années de publication) :<br>
<a target="_blank" href="https://api.archives-ouvertes.fr/search/univ-rennes1/?q=*:*&wt=xml&rows=0&facet=true&facet.pivot=producedDateY_i,submitType_s">https://api.archives-ouvertes.fr/search/univ-rennes1/?q=*:*&wt=xml&rows=0&facet=true&facet.pivot=producedDateY_i,submitType_s</a><br>
<br>
# manuscrits HAL-UR1 par année de publication (= colonne « <b>Productions avec texte intégral déposé dans HAL</b> ») :<br>
<a target="_blank" href="https://api.archives-ouvertes.fr/search/univ-rennes1/?fq=producedDateY_i:2017&fq=submitType_s:file&fq=-status_i=111">https://api.archives-ouvertes.fr/search/univ-rennes1/?fq=producedDateY_i:2017&fq=submitType_s:file&fq=-status_i=111</a><br> 
<br>
# notices HAL-UR1 (= colonne « <b>Productions sans texte intégral déposé dans HAL</b> ») :<br>
<a target="_blank" href="https://api.archives-ouvertes.fr/search/univ-rennes1/?fq=producedDateY_i:2017&fq=submitType_s:notice&fq=-status_i=111">https://api.archives-ouvertes.fr/search/univ-rennes1/?fq=producedDateY_i:2017&fq=submitType_s:notice&fq=-status_i=111</a><br>
<br>
# notices HAL-UR1 avec lien open access par année de publication  (= colonne « <b>Productions sans texte intégral déposé dans HAL mais avec texte intégral librement accessible hors HAL</b> ») :<br>
<a target="_blank" href="https://api.archives-ouvertes.fr/search/univ-rennes1/?fq=producedDateY_i:2017&fq=linkExtId_s:*&fq=-linkExtId_s:istex&fq=-status_i=111">https://api.archives-ouvertes.fr/search/univ-rennes1/?fq=producedDateY_i:2017&fq=linkExtId_s:*&fq=-linkExtId_s:istex&fq=-status_i=111</a><br>
<br>
<b>Notes :</b><br>
<ul>
<li>Dans les requêtes API, il faut éliminer les dépôts ayant le statut 111, c’est-à-dire portant la mention d’un numéro de version (versions 2, 3 etc.). Voir ticket HAL #60428. Dans la requête API, cela peut s’écrire fq=-status_i=111 (avec signe - devant le champ « status_i »).</li>
<li>Dans les requêtes API portant sur le lien vers un PDF librement disponible hors de HAL (via Unpaywall), il faut exclure les liens ISTEX (uniquement accessibles aux membres ESR) : fq=-linkExtId_s:istex</li>
</ul>
');
echo('<br></div></div>');

//Requête 3
echo('<div id="DTreq3" style="width:100%;float: left;background-color:#f5f5f5;border:1px solid #dddddd;padding: 3px;border-radius: 3px;margin-bottom: 10px;">');
echo('<span style="color:#333333;" class="accordeon"><b>Consultez la documentation technique</b>&nbsp;<font color="#aaaaaa"><i>(Cliquez)</i></font></span>');
echo('<div class="panel" style="margin-bottom: 0px; border: 0px;"><br>');
echo('
Liste des portails : <a target="_blank" href="https://api.archives-ouvertes.fr/ref/instance/?wt=xml">https://api.archives-ouvertes.fr/ref/instance/?wt=xml</a><br> (un filtre interne au programme est appliqué pour n’extraire que les portails université : « université » doit figurer dans le champ « name »).<br>
<br>
# articles HAL-UR1 par année de publication (= colonne « <b>Articles</b> ») :<br>
<a target="_blank" href="https://api.archives-ouvertes.fr/search/univ-rennes1/?fq=producedDateY_i:2017&fq=submitType_s:(notice OR file)&fq=docType_s:ART&fq=-status_i=111">https://api.archives-ouvertes.fr/search/univ-rennes1/?fq=producedDateY_i:2017&fq=submitType_s:(notice OR file)&fq=docType_s:ART&fq=-status_i=111</a><br>
<br>
# articles HAL-UR1 sans texte intégral par année de publication (= colonne « <b>Articles 2017 sans texte intégral déposé dans HAL</b> ») :<br>
<a target="_blank" href="https://api.archives-ouvertes.fr/search/univ-rennes1/?fq=producedDateY_i:2017&fq=docType_s:ART&fq=submitType_s:notice&fq=-status_i=111">https://api.archives-ouvertes.fr/search/univ-rennes1/?fq=producedDateY_i:2017&fq=docType_s:ART&fq=submitType_s:notice&fq=-status_i=111</a><br>
<br>
# articles HAL-UR1 avec texte intégral par année de publication (= colonne « <b>Articles 2017 avec texte intégral déposé dans HAL</b> ») :<br>
<a target="_blank" href="https://api.archives-ouvertes.fr/search/univ-rennes1/?fq=producedDateY_i:2017&fq=docType_s:ART&fq=submitType_s:file&fq=-status_i=111">https://api.archives-ouvertes.fr/search/univ-rennes1/?fq=producedDateY_i:2017&fq=docType_s:ART&fq=submitType_s:file&fq=-status_i=111</a><br>
<br>
# articles HAL-UR1 sans texte intégral déposé dans HAL mais avec texte intégral librement accessible hors HAL :<br>
<a target="_blank" href="https://api.archives-ouvertes.fr/search/univ-rennes1/?fq=producedDateY_i:2017&fq=docType_s:ART&fq=linkExtId_s:*&fq=-linkExtId_s:istex&fq=-status_i=111">https://api.archives-ouvertes.fr/search/univ-rennes1/?fq=producedDateY_i:2017&fq=docType_s:ART&fq=linkExtId_s:*&fq=-linkExtId_s:istex&fq=-status_i=111</a><br>
<br>
# articles HAL-UR1 avec texte intégral ou texte intégral accessible hors HAL par année de publication (= colonne « <b>Articles 2017 avec texte intégral déposé dans HAL ou librement accessible hors HAL</b> ») :<br>
<a target="_blank" href="https://api.archives-ouvertes.fr/search/univ-rennes1/?fq=producedDateY_i:2017&fq=docType_s:ART&fq=(submitType_s:file%20OR%20linkExtId_s:*)&fq=-linkExtId_s:istex&fq=-status_i=111">https://api.archives-ouvertes.fr/search/univ-rennes1/?fq=producedDateY_i:2017&fq=docType_s:ART&fq=(submitType_s:file%20OR%20linkExtId_s:*)&fq=-linkExtId_s:istex&fq=-status_i=111</a><br>
<br>
<b>Notes :</b><br>
<ul>
<li>Dans les requêtes API, il faut éliminer les dépôts ayant le statut 111, c’est-à-dire portant la mention d’un numéro de version (versions 2, 3 etc.). Voir ticket HAL #60428. Dans la requête API, cela peut s’écrire fq=-status_i=111 (avec signe - devant le champ « status_i »).</li>
<li>Dans les requêtes API portant sur le lien vers un PDF librement disponible hors de HAL (via Unpaywall), il faut exclure les liens ISTEX (uniquement accessibles aux membres ESR) : fq=-linkExtId_s:istex</li>
</ul>
');
echo('<br></div></div>');

//Requête 4
echo('<div id="DTreq4" style="width:100%;float: left;background-color:#f5f5f5;border:1px solid #dddddd;padding: 3px;border-radius: 3px;margin-bottom: 10px;">');
echo('<span style="color:#333333;" class="accordeon"><b>Consultez la documentation technique</b>&nbsp;<font color="#aaaaaa"><i>(Cliquez)</i></font></span>');
echo('<div class="panel" style="margin-bottom: 0px; border: 0px;"><br>');
echo('
<b>Stocks :</b><br>
AO1 = nombre de notices au 31/12/XXXX (remplacer par année renseignée par l’utilisateur)<br>
<a target="_blank" href="https://api.archives-ouvertes.fr/search/univ-rennes1/?fq=submitType_s:notice&fq=-status_i=111&fq=submittedDate_s:[1600-01-01-%20TO%202017-12-31/HOUR]">https://api.archives-ouvertes.fr/search/univ-rennes1/?fq=submitType_s:notice&fq=-status_i=111&fq=submittedDate_s:[1600-01-01-%20TO%202017-12-31/HOUR]</a><br>
AO2 = nombre de fichiers au 31/12/XXXX (remplacer par année renseignée par l’utilisateur)<br>
<a target="_blank" href="https://api.archives-ouvertes.fr/search/univ-rennes1/?fq=submitType_s:file&fq=-status_i=111&fq=submittedDate_s:[1600-01-01-%20TO%202017-12-31/HOUR]">https://api.archives-ouvertes.fr/search/univ-rennes1/?fq=submitType_s:file&fq=-status_i=111&fq=submittedDate_s:[1600-01-01-%20TO%202017-12-31/HOUR]</a><br>
<br>
<b>Flux :</b><br>
AO3 = nombre de notices ajoutées en XXXX (remplacer par année renseignée par l’utilisateur)<br>
<a target="_blank" href="https://api.archives-ouvertes.fr/search/univ-rennes1/?fq=submitType_s:notice&fq=-status_i=111&fq=submittedDate_s:[2017-01-01-%20TO%202017-12-31/HOUR]">https://api.archives-ouvertes.fr/search/univ-rennes1/?fq=submitType_s:notice&fq=-status_i=111&fq=submittedDate_s:[2017-01-01-%20TO%202017-12-31/HOUR]</a><br>
AO4 = nombre de fichiers ajoutés en XXXX (remplacer par année renseignée par l’utilisateur)<br>
<a target="_blank" href="https://api.archives-ouvertes.fr/search/univ-rennes1/?fq=submitType_s:file&fq=-status_i=111&fq=submittedDate_s:[2017-01-01-%20TO%202017-12-31/HOUR]">https://api.archives-ouvertes.fr/search/univ-rennes1/?fq=submitType_s:file&fq=-status_i=111&fq=submittedDate_s:[2017-01-01-%20TO%202017-12-31/HOUR]</a><br>
<br>
<b>Note :</b> Dans les requêtes API, il faut éliminer les dépôts ayant le statut 111, c’est-à-dire portant la mention d’un numéro de version (versions 2, 3 etc.). Voir ticket HAL #60428. Dans la requête API, cela peut s’écrire fq=-status_i=111 (avec signe - devant le champ « status_i »).<br>
');
echo('<br></div></div>');

//Requête 5
echo('<div id="DTreq5" style="width:100%;float: left;background-color:#f5f5f5;border:1px solid #dddddd;padding: 3px;border-radius: 3px;margin-bottom: 10px;">');
echo('<span style="color:#333333;" class="accordeon"><b>Consultez la documentation technique</b>&nbsp;<font color="#aaaaaa"><i>(Cliquez)</i></font></span>');
echo('<div class="panel" style="margin-bottom: 0px; border: 0px;"><br>');
echo('
Ce chiffre n’est pas calculé à partir de la métadonnée « éditeur » (journalPublisher_s) car elle n’est pas présente dans tous les dépôts HAL. La requête est basée sur le préfixe du DOI des principaux éditeurs, extrait d’une version interne abrégée de la <a target="_blank" href="https://www.crossref.org/06members/50go-live.html">liste à jour des préfixes DOI de CrossRef</a>. Les éditeurs non répertoriées dans la liste interne sont rassemblés sous l’appellation « Hors regroupement éditorial ». Une exception est faite pour les éditeurs Dalloz et Lextenso qui n’ont pas de DOI (interrogation du champ « journalPublisher_s »).<br>
<br>
Liste restreinte des préfixes de DOI : <a target="_blank" href="https://github.com/OTroccaz/VizuHAL/blob/master/Prefixe_DOI.php">Prefixe_DOI.php</a><br>
<br>
Requêtes API :<br>
Articles 2017 (exemple pour préfixe 10.1016) : <a target="_blank" href="https://api.archives-ouvertes.fr/search/univ-rennes1/?fq=producedDateY_i:2017&fq=-submitType_s:annex&fq=-status_i=111&fq=doiId_s:10.1016*&fq=docType_s:ART">https://api.archives-ouvertes.fr/search/univ-rennes1/?fq=producedDateY_i:2017&fq=-submitType_s:annex&fq=-status_i=111&fq=doiId_s:10.1016*&fq=docType_s:ART</a><br>
La ligne "Hors regroupement éditorial" est calculée en retranchant le nombre total d\'articles recensés chez les éditeurs principaux (liste abrégée) du nombre total d\'articles du portail pour 2017 : <a target="_blank" href="https://api.archives-ouvertes.fr/search/univ-rennes1/?fq=producedDateY_i:2017&fq=submitType_s:(notice%20OR%20file)&fq=docType_s:ART&fq=-status_i=111">https://api.archives-ouvertes.fr/search/univ-rennes1/?fq=producedDateY_i:2017&fq=submitType_s:(notice%20OR%20file)&fq=docType_s:ART&fq=-status_i=111</a><br>
Lextenso : <a target="_blank" href="https://api.archives-ouvertes.fr/search/univ-rennes1/?fq=producedDateY_i:2017&fq=-submitType_s:annex&fq=-status_i=111&fq=journalPublisher_t:lextenso&fq=docType_s:ART">https://api.archives-ouvertes.fr/search/univ-rennes1/?fq=producedDateY_i:2017&fq=-submitType_s:annex&fq=-status_i=111&fq=journalPublisher_t:lextenso&fq=docType_s:ART</a><br>
Dalloz : <a target="_blank" href="https://api.archives-ouvertes.fr/search/univ-rennes1/?fq=producedDateY_i:2017&fq=-submitType_s:annex&fq=-status_i=111&fq=journalPublisher_t:dalloz&fq=docType_s:ART">https://api.archives-ouvertes.fr/search/univ-rennes1/?fq=producedDateY_i:2017&fq=-submitType_s:annex&fq=-status_i=111&fq=journalPublisher_t:dalloz&fq=docType_s:ART</a><br>
<br>
<b>Note :</b> Dans les requêtes API, il faut éliminer les dépôts ayant le statut 111, c’est-à-dire portant la mention d’un numéro de version (versions 2, 3 etc.). Voir ticket HAL #60428. Dans la requête API, cela peut s’écrire fq=-status_i=111 (avec signe - devant le champ « status_i »).<br>
');
echo('<br></div></div>');

//Requête 6
echo('<div id="DTreq6" style="width:100%;float: left;background-color:#f5f5f5;border:1px solid #dddddd;padding: 3px;border-radius: 3px;margin-bottom: 10px;">');
echo('<span style="color:#333333;" class="accordeon"><b>Consultez la documentation technique</b>&nbsp;<font color="#aaaaaa"><i>(Cliquez)</i></font></span>');
echo('<div class="panel" style="margin-bottom: 0px; border: 0px;"><br>');
echo('
Ce chiffre n’est pas calculé à partir de la métadonnée « éditeur » (journalPublisher_s) car elle n’est pas présente dans tous les dépôts HAL. La requête est basée sur le préfixe du DOI des principaux éditeurs, extrait d’une version interne abrégée de la <a target="_blank" href="https://www.crossref.org/06members/50go-live.html">liste à jour des préfixes DOI de CrossRef</a>. Les éditeurs non répertoriées dans la liste interne sont rassemblés sous l’appellation « Hors regroupement éditorial ».<br>
<br>
Requêtes API :<br>
Communications 2017 (exemple pour préfixe 10.1016) : <a target="_blank" href="https://api.archives-ouvertes.fr/search/univ-rennes1/?fq=producedDateY_i:2017&fq=-submitType_s:annex&fq=-status_i=111&fq=doiId_s:10.1016*&fq=docType_s:COMM">https://api.archives-ouvertes.fr/search/univ-rennes1/?fq=producedDateY_i:2017&fq=-submitType_s:annex&fq=-status_i=111&fq=doiId_s:10.1016*&fq=docType_s:COMM</a><br>
La ligne "Hors regroupement éditorial" est calculée en retranchant le nombre total d\'articles recensés chez les éditeurs principaux (liste abrégée) du nombre total d\'articles du portail pour 2017 : <a target="_blank" href="https://api.archives-ouvertes.fr/search/univ-rennes1/?fq=producedDateY_i:2017&fq=submitType_s:(notice%20OR%20file)&fq=docType_s:COMM&fq=-status_i=111">https://api.archives-ouvertes.fr/search/univ-rennes1/?fq=producedDateY_i:2017&fq=submitType_s:(notice%20OR%20file)&fq=docType_s:COMM&fq=-status_i=111</a><br>
<br>
<b>Note :</b> Dans les requêtes API, il faut éliminer les dépôts ayant le statut 111, c’est-à-dire portant la mention d’un numéro de version (versions 2, 3 etc.). Voir ticket HAL #60428. Dans la requête API, cela peut s’écrire fq=-status_i=111 (avec signe - devant le champ « status_i »).<br>
');
echo('<br></div></div>');

//Requête 7
echo('<div id="DTreq7" style="width:100%;float: left;background-color:#f5f5f5;border:1px solid #dddddd;padding: 3px;border-radius: 3px;margin-bottom: 10px;">');
echo('<span style="color:#333333;" class="accordeon"><b>Consultez la documentation technique</b>&nbsp;<font color="#aaaaaa"><i>(Cliquez)</i></font></span>');
echo('<div class="panel" style="margin-bottom: 0px; border: 0px;"><br>');
echo('
Requête API (on additionne les valeurs des balises « count » du 1er niveau) :<br>
<a target="_blank" href="https://api.archives-ouvertes.fr/search/univ-rennes1/?q=*%3A*&rows=0&wt=xml&indent=true&facet=true&facet.pivot=journalTitle_s,journalPublisher_s,journalValid_s&fq=-status_i=111&fq=docType_s:ART&fq=producedDateY_i:2017&facet.limit=10000">https://api.archives-ouvertes.fr/search/univ-rennes1/?q=*%3A*&rows=0&wt=xml&indent=true&facet=true&facet.pivot=journalTitle_s,journalPublisher_s,journalValid_s&fq=-status_i=111&fq=docType_s:ART&fq=producedDateY_i:2017&facet.limit=10000</a><br>
La requête n’est pas basée sur l’ISSN car certaines revues du référentiel AuréHAL n’ont pas d’ISSN. C’est donc le titre de la revue (journalTitle_s) qui est pris en compte.<br>
<br>
<b>Note :</b> Dans les requêtes API, il faut éliminer les dépôts ayant le statut 111, c’est-à-dire portant la mention d’un numéro de version (versions 2, 3 etc.). Voir ticket HAL #60428. Dans la requête API, cela peut s’écrire fq=-status_i=111 (avec signe - devant le champ « status_i »).<br>
');
echo('<br></div></div>');

//Requête 8
echo('<div id="DTreq8" style="width:100%;float: left;background-color:#f5f5f5;border:1px solid #dddddd;padding: 3px;border-radius: 3px;margin-bottom: 10px;">');
echo('<span style="color:#333333;" class="accordeon"><b>Consultez la documentation technique</b>&nbsp;<font color="#aaaaaa"><i>(Cliquez)</i></font></span>');
echo('<div class="panel" style="margin-bottom: 0px; border: 0px;"><br>');
echo('
');
echo('<br></div></div>');

//Requête 9
echo('<div id="DTreq9" style="width:100%;float: left;background-color:#f5f5f5;border:1px solid #dddddd;padding: 3px;border-radius: 3px;margin-bottom: 10px;">');
echo('<span style="color:#333333;" class="accordeon"><b>Consultez la documentation technique</b>&nbsp;<font color="#aaaaaa"><i>(Cliquez)</i></font></span>');
echo('<div class="panel" style="margin-bottom: 0px; border: 0px;"><br>');
echo('
');
echo('<br></div></div>');

//Requête 10
echo('<div id="DTreq10" style="width:100%;float: left;background-color:#f5f5f5;border:1px solid #dddddd;padding: 3px;border-radius: 3px;margin-bottom: 10px;">');
echo('<span style="color:#333333;" class="accordeon"><b>Consultez la documentation technique</b>&nbsp;<font color="#aaaaaa"><i>(Cliquez)</i></font></span>');
echo('<div class="panel" style="margin-bottom: 0px; border: 0px;"><br>');
echo('
Ce chiffre n’est pas calculé à partir de la métadonnée « éditeur » (journalPublisher_s) car elle n’est pas présente dans tous les dépôts HAL. La requête est basée sur le préfixe du DOI des principaux éditeurs, extrait d’une version interne abrégée de la <a target="_blank" href="https://www.crossref.org/06members/50go-live.html">liste à jour des préfixes DOI de CrossRef</a>. Les éditeurs non répertoriées dans la liste interne sont rassemblés sous l’appellation « Hors regroupement éditorial ». Une exception est faite pour les éditeurs Dalloz et Lextenso qui n’ont pas de DOI (interrogation du champ « journalPublisher_s »).<br>
<br>
Liste restreinte des préfixes de DOI : <a target="_blank" href="https://github.com/OTroccaz/VizuHAL/blob/master/Prefixe_DOI.php">Prefixe_DOI.php</a><br>
<br>
Requête API :<br>
Nombre de notices sans texte intégral :<br>
 <a target="_blank" href="https://api.archives-ouvertes.fr/search/LTSI/?fq=producedDateY_i:2019&fq=submitType_s:notice&fq=-status_i=111">https://api.archives-ouvertes.fr/search/LTSI/?fq=producedDateY_i:2019&fq=submitType_s:notice&fq=-status_i=111</a><br>
<br>
<b>Note :</b> Dans les requêtes API, il faut éliminer les dépôts ayant le statut 111, c’est-à-dire portant la mention d’un numéro de version (versions 2, 3 etc.). Voir ticket HAL #60428. Dans la requête API, cela peut s’écrire fq=-status_i=111 (avec signe - devant le champ « status_i »).<br>
');
echo('<br></div></div>');

//Requête 11
echo('<div id="DTreq11" style="width:100%;float: left;background-color:#f5f5f5;border:1px solid #dddddd;padding: 3px;border-radius: 3px;margin-bottom: 10px;">');
echo('<span style="color:#333333;" class="accordeon"><b>Consultez la documentation technique</b>&nbsp;<font color="#aaaaaa"><i>(Cliquez)</i></font></span>');
echo('<div class="panel" style="margin-bottom: 0px; border: 0px;"><br>');
echo('
Ce chiffre n’est pas calculé à partir de la métadonnée « éditeur » (journalPublisher_s) car elle n’est pas présente dans tous les dépôts HAL. La requête est basée sur le préfixe du DOI des principaux éditeurs, extrait d’une version interne abrégée de la <a target="_blank" href="https://www.crossref.org/06members/50go-live.html">liste à jour des préfixes DOI de CrossRef</a>. Les éditeurs non répertoriées dans la liste interne sont rassemblés sous l’appellation « Hors regroupement éditorial ». Une exception est faite pour les éditeurs Dalloz et Lextenso qui n’ont pas de DOI (interrogation du champ « journalPublisher_s »).<br>
Liste restreinte des préfixes de DOI : <a target="_blank" href="https://github.com/OTroccaz/VizuHAL/blob/master/Prefixe_DOI.php">Prefixe_DOI.php</a><br>
<br>
Requête API :<br>
Nombre de notices avec texte intégral : <br>
<a target="_blank" href="https://api.archives-ouvertes.fr/search/LTSI/?fq=producedDateY_i:2019&fq=submitType_s:file&fq=-status_i=111">https://api.archives-ouvertes.fr/search/LTSI/?fq=producedDateY_i:2019&fq=submitType_s:file&fq=-status_i=111</a><br>
<br>
<b>Note :</b> Dans les requêtes API, il faut éliminer les dépôts ayant le statut 111, c’est-à-dire portant la mention d’un numéro de version (versions 2, 3 etc.). Voir ticket HAL #60428. Dans la requête API, cela peut s’écrire fq=-status_i=111 (avec signe - devant le champ « status_i »).<br>
');
echo('<br></div></div>');

//Requête 12
echo('<div id="DTreq12" style="width:100%;float: left;background-color:#f5f5f5;border:1px solid #dddddd;padding: 3px;border-radius: 3px;margin-bottom: 10px;">');
echo('<span style="color:#333333;" class="accordeon"><b>Consultez la documentation technique</b>&nbsp;<font color="#aaaaaa"><i>(Cliquez)</i></font></span>');
echo('<div class="panel" style="margin-bottom: 0px; border: 0px;"><br>');
echo('
Ce chiffre n’est pas calculé à partir de la métadonnée « éditeur » (journalPublisher_s) car elle n’est pas présente dans tous les dépôts HAL. La requête est basée sur le préfixe du DOI des principaux éditeurs, extrait d’une version interne abrégée de la <a target="_blank" href="https://www.crossref.org/06members/50go-live.html">liste à jour des préfixes DOI de CrossRef</a>. Les éditeurs non répertoriées dans la liste interne sont rassemblés sous l’appellation « Hors regroupement éditorial ». Une exception est faite pour les éditeurs Dalloz et Lextenso qui n’ont pas de DOI (interrogation du champ « journalPublisher_s »).<br>
Liste restreinte des préfixes de DOI : <a target="_blank" href="https://github.com/OTroccaz/VizuHAL/blob/master/Prefixe_DOI.php">Prefixe_DOI.php</a><br>
<br>
Requête API :<br>
Nombre de notices avec texte intégral OU lien externe : <br>
<a target="_blank" href="https://api.archives-ouvertes.fr/search/LTSI/?fq=producedDateY_i:2019&fq=(submitType_s:file%20OR%20linkExtId_s:*)&fq=-linkExtId_s:istex&fq=-status_i=111">https://api.archives-ouvertes.fr/search/LTSI/?fq=producedDateY_i:2019&fq=(submitType_s:file%20OR%20linkExtId_s:*)&fq=-linkExtId_s:istex&fq=-status_i=111</a><br>
<br>
<b>Notes :</b><br>
<ul>
<li>Dans les requêtes API, il faut éliminer les dépôts ayant le statut 111, c’est-à-dire portant la mention d’un numéro de version (versions 2, 3 etc.). Voir ticket HAL #60428. Dans la requête API, cela peut s’écrire fq=-status_i=111 (avec signe - devant le champ « status_i »).</li>
<li>Dans les requêtes API portant sur le lien vers un PDF librement disponible hors de HAL (via Unpaywall), il faut exclure les liens ISTEX (uniquement accessibles aux membres ESR) : fq=-linkExtId_s:istex</li>
</ul>
');
echo('<br></div></div>');

//Requête 13
echo('<div id="DTreq13" style="width:100%;float: left;background-color:#f5f5f5;border:1px solid #dddddd;padding: 3px;border-radius: 3px;margin-bottom: 10px;">');
echo('<span style="color:#333333;" class="accordeon"><b>Consultez la documentation technique</b>&nbsp;<font color="#aaaaaa"><i>(Cliquez)</i></font></span>');
echo('<div class="panel" style="margin-bottom: 0px; border: 0px;"><br>');
echo('
Requêtes API :<br>
Nombre de notices sans texte intégral :<br>
<a target="_blank" href="https://api.archives-ouvertes.fr/search/LTSI/?fq=producedDateY_i:2019&fq=submitType_s:notice&fq=-status_i=111">https://api.archives-ouvertes.fr/search/LTSI/?fq=producedDateY_i:2019&fq=submitType_s:notice&fq=-status_i=111</a><br>
Nombre de notices avec texte intégral :<br>
<a target="_blank" href="https://api.archives-ouvertes.fr/search/LTSI/?fq=producedDateY_i:2019&fq=submitType_s:file&fq=-status_i=111">https://api.archives-ouvertes.fr/search/LTSI/?fq=producedDateY_i:2019&fq=submitType_s:file&fq=-status_i=111</a><br>
Nombre de notices avec texte intégral OU lien externe :<br>
<a target="_blank" href="https://api.archives-ouvertes.fr/search/LTSI/?fq=producedDateY_i:2019&fq=(submitType_s:file%20OR%20linkExtId_s:*)&fq=-linkExtId_s:istex&fq=-status_i=111">https://api.archives-ouvertes.fr/search/LTSI/?fq=producedDateY_i:2019&fq=(submitType_s:file%20OR%20linkExtId_s:*)&fq=-linkExtId_s:istex&fq=-status_i=111</a><br>
<br>
<b>Notes :</b><br>
<ul>
<li>Dans les requêtes API, il faut éliminer les dépôts ayant le statut 111, c’est-à-dire portant la mention d’un numéro de version (versions 2, 3 etc.). Voir ticket HAL #60428. Dans la requête API, cela peut s’écrire fq=-status_i=111 (avec signe - devant le champ « status_i »).</li>
<li>Dans les requêtes API portant sur le lien vers un PDF librement disponible hors de HAL (via Unpaywall), il faut exclure les liens ISTEX (uniquement accessibles aux membres ESR) : fq=-linkExtId_s:istex</li>
</ul>
');
echo('<br></div></div>');

//Requête 14
echo('<div id="DTreq14" style="width:100%;float: left;background-color:#f5f5f5;border:1px solid #dddddd;padding: 3px;border-radius: 3px;margin-bottom: 10px;">');
echo('<span style="color:#333333;" class="accordeon"><b>Consultez la documentation technique</b>&nbsp;<font color="#aaaaaa"><i>(Cliquez)</i></font></span>');
echo('<div class="panel" style="margin-bottom: 0px; border: 0px;"><br>');
echo('
Nombre de références HAL dans la collection LTSI pour 2019 ayant un projet ANR (incluant le champ « financement ») :<br>
<a target="_blank" href="https://api.archives-ouvertes.fr/search/LTSI/?fq=producedDateY_i:2019&fl=anrProjectId_i,anrProjectAcronym_s,funding_s,anrProjectId_i,anrProjectReference_s&rows=10000">https://api.archives-ouvertes.fr/search/LTSI/?fq=producedDateY_i:2019&fl=anrProjectId_i,anrProjectAcronym_s,funding_s,anrProjectId_i,anrProjectReference_s&rows=10000</a><br>
');
echo('<br></div></div>');

//Requête 15
echo('<div id="DTreq15" style="width:100%;float: left;background-color:#f5f5f5;border:1px solid #dddddd;padding: 3px;border-radius: 3px;margin-bottom: 10px;">');
echo('<span style="color:#333333;" class="accordeon"><b>Consultez la documentation technique</b>&nbsp;<font color="#aaaaaa"><i>(Cliquez)</i></font></span>');
echo('<div class="panel" style="margin-bottom: 0px; border: 0px;"><br>');
echo('
Nombre de références HAL dans la collection LTSI pour 2019 ayant un projet européen (incluant le champ « financement ») :<br>
<a target="_blank" href="https://api.archives-ouvertes.fr/search/LTSI/?fq=producedDateY_i:2019&fl= europeanProjectId_i,europeanProjectAcronym_s,funding_s,europeanProjectId_i,europeanProjectReference_s &rows=10000">https://api.archives-ouvertes.fr/search/LTSI/?fq=producedDateY_i:2019&fl= europeanProjectId_i,europeanProjectAcronym_s,funding_s,europeanProjectId_i,europeanProjectReference_s &rows=10000</a><br>
');
echo('<br></div></div>');

//Requête 16
echo('<div id="DTreq16" style="width:100%;float: left;background-color:#f5f5f5;border:1px solid #dddddd;padding: 3px;border-radius: 3px;margin-bottom: 10px;">');
echo('<span style="color:#333333;" class="accordeon"><b>Consultez la documentation technique</b>&nbsp;<font color="#aaaaaa"><i>(Cliquez)</i></font></span>');
echo('<div class="panel" style="margin-bottom: 0px; border: 0px;"><br>');
echo('
<a target="_blank" href="https://api.archives-ouvertes.fr/search/UNIV-RENNES1/?fq=producedDateY_i:2019&fl=contributorFullName_s,submittedDate_s,submitType_s,halId_s&rows=10000&sort=contributorFullName_s%20desc">https://api.archives-ouvertes.fr/search/UNIV-RENNES1/?fq=producedDateY_i:2019&fl=contributorFullName_s,submittedDate_s,submitType_s,halId_s&rows=10000&sort=contributorFullName_s%20desc</a><br>
<br>
Champs exploités :<br>
<ul>
<li>contributorFullName_s</li>
<li>submittedDate_s pour la date de dépôt (année)</li>
<li>submitType_s pour le type de dépôt (notice, file)</li>
<li>sid_i : identifiant du portail de dépôt (avec <a target="_blank" href="https://api.archives-ouvertes.fr/search/?q=*%3A*&rows=0&wt=xml&indent=true&facet=true&facet.field=sid_i">une liste</a>, mais non documentée selon ticket <a target="_blank" href="https://support.ccsd.cnrs.fr/SelfService/Display.html?id=87256">HAL#87256</a> : on n’en a traduit que quelques-uns)</li>
</ul>
');
echo('<br></div></div>');

//Requête 17
echo('<div id="DTreq17" style="width:100%;float: left;background-color:#f5f5f5;border:1px solid #dddddd;padding: 3px;border-radius: 3px;margin-bottom: 10px;">');
echo('<span style="color:#333333;" class="accordeon"><b>Consultez la documentation technique</b>&nbsp;<font color="#aaaaaa"><i>(Cliquez)</i></font></span>');
echo('<div class="panel" style="margin-bottom: 0px; border: 0px;"><br>');
echo('
<a target="_blank" href="https://api.archives-ouvertes.fr/search/ECOBIO/?fq=producedDateY_i:2019&fl=collName_s,collCategory_s,collCode_s,halId_s">https://api.archives-ouvertes.fr/search/ECOBIO/?fq=producedDateY_i:2019&fl=collName_s,collCategory_s,collCode_s,halId_s</a><br>
Les 3 niveaux (collCategory_s):<br>
Laboratoires = uniquement les tampons LABO et THEME<br>
Etablissements = uniquement les tampons INSTITUTION, UNIV et ECOLE<br>
Autres = uniquement les tampons AUTRE<br>
');
echo('<br></div></div>');

//Requête 18
echo('<div id="DTreq18" style="width:100%;float: left;background-color:#f5f5f5;border:1px solid #dddddd;padding: 3px;border-radius: 3px;margin-bottom: 10px;">');
echo('<span style="color:#333333;" class="accordeon"><b>Consultez la documentation technique</b>&nbsp;<font color="#aaaaaa"><i>(Cliquez)</i></font></span>');
echo('<div class="panel" style="margin-bottom: 0px; border: 0px;"><br>');
echo('
<a target="_blank" href="https://api.archives-ouvertes.fr/search/ECOBIO/?fq=producedDateY_i:2019&fl=collName_s,collCategory_s,collCode_s,halId_s">https://api.archives-ouvertes.fr/search/ECOBIO/?fq=producedDateY_i:2019&fl=collName_s,collCategory_s,collCode_s,halId_s</a><br>
collCategory_s / Laboratoires = uniquement les tampons LABO et THEME<br>
');
echo('<br></div></div>');

//Requête 19
echo('<div id="DTreq19" style="width:100%;float: left;background-color:#f5f5f5;border:1px solid #dddddd;padding: 3px;border-radius: 3px;margin-bottom: 10px;">');
echo('<span style="color:#333333;" class="accordeon"><b>Consultez la documentation technique</b>&nbsp;<font color="#aaaaaa"><i>(Cliquez)</i></font></span>');
echo('<div class="panel" style="margin-bottom: 0px; border: 0px;"><br>');
echo('
<a target="_blank" href="https://api.archives-ouvertes.fr/search/ECOBIO/?fq=producedDateY_i:2019&fl=collName_s,collCategory_s,collCode_s,halId_s">https://api.archives-ouvertes.fr/search/ECOBIO/?fq=producedDateY_i:2019&fl=collName_s,collCategory_s,collCode_s,halId_s</a><br>
collCategory_s / Etablissements = uniquement les tampons INSTITUTION, UNIV et ECOLE<br>
');
echo('<br></div></div>');

//Requête 20
echo('<div id="DTreq20" style="width:100%;float: left;background-color:#f5f5f5;border:1px solid #dddddd;padding: 3px;border-radius: 3px;margin-bottom: 10px;">');
echo('<span style="color:#333333;" class="accordeon"><b>Consultez la documentation technique</b>&nbsp;<font color="#aaaaaa"><i>(Cliquez)</i></font></span>');
echo('<div class="panel" style="margin-bottom: 0px; border: 0px;"><br>');
echo('
<a target="_blank" href="https://api.archives-ouvertes.fr/search/ECOBIO/?fq=producedDateY_i:2019&fl=collName_s,collCategory_s,collCode_s,halId_s">https://api.archives-ouvertes.fr/search/ECOBIO/?fq=producedDateY_i:2019&fl=collName_s,collCategory_s,collCode_s,halId_s</a><br>
collCategory_s / Autres = uniquement les tampons AUTRE<br>
');
echo('<br></div></div>');

//Requête 21
echo('<div id="DTreq21" style="width:100%;float: left;background-color:#f5f5f5;border:1px solid #dddddd;padding: 3px;border-radius: 3px;margin-bottom: 10px;">');
echo('<span style="color:#333333;" class="accordeon"><b>Consultez la documentation technique</b>&nbsp;<font color="#aaaaaa"><i>(Cliquez)</i></font></span>');
echo('<div class="panel" style="margin-bottom: 0px; border: 0px;"><br>');
echo('
<a target="_blank" href="https://api.archives-ouvertes.fr/search/LTSI/?fq=producedDateY_i:2018&fl=docType_s,structName_s,structType_s,halId_s,structCountry_s&rows=10000">https://api.archives-ouvertes.fr/search/LTSI/?fq=producedDateY_i:2018&fl=docType_s,structName_s,structType_s,halId_s,structCountry_s&rows=10000</a><br> 
Liens XML/JSON : l’export des références en csv n’est malheureusement pas possible (même si théoriquement proposé par le CCSD).<br>
Sont exclus des résultats les territoires français d’outre-mer de la <a target="_blank" href="http://documentation.abes.fr/sudoc/formats/CodesPays.htm">liste ISO 3166</a> : "Martinique" MQ,"Guadeloupe" GP, etc.<br>
<br>
<b>Note :</b> ces résultats sont à relativiser car beaucoup de structures étrangères non valides du référentiel AuréHAL ont un code pays = France. Par ailleurs, les co-auteurs étrangers ne sont pas systématiquement affiliés dans HAL, voire ont une affiliation erronée (attribuée automatiquement par HAL).<br>
');
echo('<br></div></div>');

//Requête 22
echo('<div id="DTreq22" style="width:100%;float: left;background-color:#f5f5f5;border:1px solid #dddddd;padding: 3px;border-radius: 3px;margin-bottom: 10px;">');
echo('<span style="color:#333333;" class="accordeon"><b>Consultez la documentation technique</b>&nbsp;<font color="#aaaaaa"><i>(Cliquez)</i></font></span>');
echo('<div class="panel" style="margin-bottom: 0px; border: 0px;"><br>');
echo('
<a target="_blank" href="https://api.archives-ouvertes.fr/search/LTSI/?fq=producedDateY_i:2018&fl=docType_s,structName_s,structType_s,halId_s,structCountry_s&rows=10000">https://api.archives-ouvertes.fr/search/LTSI/?fq=producedDateY_i:2018&fl=docType_s,structName_s,structType_s,halId_s,structCountry_s&rows=10000</a><br> 
Liens XML/JSON : l’export des références en csv n’est malheureusement pas possible (même si théoriquement proposé par le CCSD).<br>
Données utilisées pour le label « institution » :<br>
structType_s = "institution", "regroupinstitution", "regrouplaboratory", "department"<br>
Sont exclus des résultats les territoires français d’outre-mer de la <a target="_blank" href="http://documentation.abes.fr/sudoc/formats/CodesPays.htm">liste ISO 3166</a> : "Martinique" MQ,"Guadeloupe" GP, etc.<br>
<br>
<b>Note :</b> ces résultats sont à relativiser car beaucoup de structures étrangères non valides du référentiel AuréHAL ont un code pays = France. Par ailleurs, les co-auteurs étrangers ne sont pas systématiquement affiliés dans HAL, voire ont une affiliation erronée (attribuée automatiquement par HAL).<br>
');
echo('<br></div></div>');
echo('Vous pouvez générer différents types de cartes en exportant ces données dans l\'outil open source <a target="_blank" href="https://www.sciencespo.fr/cartographie/khartis/">Khartis</a> (voir <a target="_blank" href="https://www.sciencespo.fr/cartographie/khartis/docs/premiers-pas-avec-Khartis-(1)/">documentation</a>)');

//Requête 23
echo('<div id="DTreq23" style="width:100%;float: left;background-color:#f5f5f5;border:1px solid #dddddd;padding: 3px;border-radius: 3px;margin-bottom: 10px;">');
echo('<span style="color:#333333;" class="accordeon"><b>Consultez la documentation technique</b>&nbsp;<font color="#aaaaaa"><i>(Cliquez)</i></font></span>');
echo('<div class="panel" style="margin-bottom: 0px; border: 0px;"><br>');
echo('
<a target="_blank" href="https://api.archives-ouvertes.fr/search/LTSI/?fq=producedDateY_i:2018&fl=docType_s,structName_s,structType_s,halId_s,structCountry_s&rows=10000">https://api.archives-ouvertes.fr/search/LTSI/?fq=producedDateY_i:2018&fl=docType_s,structName_s,structType_s,halId_s,structCountry_s&rows=10000</a><br> 
Liens XML/JSON : l’export des références en csv n’est malheureusement pas possible (même si théoriquement proposé par le CCSD).<br>
Sont exclus des résultats les territoires français d’outre-mer de la <a target="_blank" href="http://documentation.abes.fr/sudoc/formats/CodesPays.htm">liste ISO 3166</a> : "Martinique" MQ,"Guadeloupe" GP, etc.<br>
<br>
<b>Note :</b> ces résultats sont à relativiser car beaucoup de structures étrangères non valides du référentiel AuréHAL ont un code pays = France. Par ailleurs, les co-auteurs étrangers ne sont pas systématiquement affiliés dans HAL, voire ont une affiliation erronée (attribuée automatiquement par HAL).<br>
');
echo('<br></div></div>');

echo('<script type="text/javascript" language="Javascript">');
echo('var acc = document.getElementsByClassName("accordeon");');
echo('var i;');
echo('for (i = 0; i < acc.length; i++) {');
echo('  acc[i].onclick = function() {');
echo('    this.classList.toggle("active");');
echo('    var panel = this.nextElementSibling;');
echo('    if (panel.style.maxHeight){');
echo('      panel.style.maxHeight = null;');
echo('    } else {');
echo('      panel.style.maxHeight = panel.scrollHeight + "px";');
echo('    }');
echo('  }');
echo('}');
echo('</script>');

if (!isset($_POST["valider"]) && !isset($_GET["reqt"])) {
	echo('<script type="text/javascript" language="Javascript">
		for(let i=1; i<=imax; i++) {
			document.getElementById("DTreq"+i).style.display = "none";
		}
	</script>');
}else{
	for ($i=1; $i<=23; $i++) { 
		if ($reqt == "req".$i) {
			echo('<script type="text/javascript" language="Javascript">document.getElementById("DTreq'.$i.'").style.display = "block";</script>');
		}else{
			echo('<script type="text/javascript" language="Javascript">document.getElementById("DTreq'.$i.'").style.display = "none";</script>');
		}
	}
}
echo('<br>');
?>
<?php
include('./bas.php');
?>
</body>
</html>
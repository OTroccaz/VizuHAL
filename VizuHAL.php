<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<?php
include "./VizuHAL_constantes.php";
include "./VizuHAL_fonctions.php";

//Paramètres envoyés par l'URL
if (isset($_GET["reqt"])) {
  if ($_GET["reqt"] == $cstR03) {$reqt = $cstR03;$irq03 = $cstSel;}
	if ($_GET["reqt"] == $cstR16) {$reqt = $cstR16;$irq16 = $cstSel;}
	if ($_GET["reqt"] == $cstR17) {$reqt = $cstR17;$irq17 = $cstSel;}
	if ($_GET["reqt"] == $cstR18) {$reqt = $cstR18;$irq18 = $cstSel;}
	if ($_GET["reqt"] == $cstR19) {$reqt = $cstR19;$irq19 = $cstSel;}
	if ($_GET["reqt"] == $cstR20) {$reqt = $cstR20;$irq20 = $cstSel;}
	if ($_GET["reqt"] == $cstR21) {$reqt = $cstR21;$irq21 = $cstSel;}
	if ($_GET["reqt"] == $cstR22) {$reqt = $cstR22;$irq22 = $cstSel;}
	if ($_GET["reqt"] == $cstR23) {$reqt = $cstR23;$irq23 = $cstSel;}
	if (isset($_GET["team"])) {$team = $_GET["team"];}
	if (isset($_GET["port"])) {$port = $_GET["port"];}
	if (isset($_GET["ordr"])) {$ordr = $_GET["ordr"];}
	if (isset($_GET["anneedeb"])) {$anneedeb = $_GET["anneedeb"];}
	if (isset($_GET["anneefin"])) {$anneefin = $_GET["anneefin"];}
	if (isset($_GET["annee3"])) {$annee3 = $_GET["annee3"];}
	if (isset($_GET[$cstA17])) {$annee17 = $_GET[$cstA17];}
	if (isset($_GET[$cstA18])) {$annee18 = $_GET[$cstA18];}
	if (isset($_GET[$cstA19])) {$annee19 = $_GET[$cstA19];}
	if (isset($_GET[$cstA20])) {$annee20 = $_GET[$cstA20];}
}

header('Content-type: text/html; charset=UTF-8');

if (isset($_GET['css']) && ($_GET['css'] != ""))
{
  $css = $_GET['css'];
}else{
  $css = "https://ecobio.univ-rennes1.fr/HAL_SCD.css";
}

$root = 'http';
if (isset ($_SERVER[$cstHTS]) && $_SERVER[$cstHTS] == "on")	{
  $root.= "s";
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
<body style="font-family: Corbel;" onload="freqt();">

<noscript>
<div class='center, red' id='noscript'><strong>ATTENTION !!! JavaScript est désactivé ou non pris en charge par votre navigateur : cette procédure ne fonctionnera pas correctement.</strong><br>
<strong>Pour modifier cette option, voir <a target='_blank' rel='noopener noreferrer' href='http://www.libellules.ch/browser_javascript_activ.php'>ce lien</a>.</strong></div><br>
</noscript>

<table class="table100" aria-describedby="Entêtes">
<tr>
<th scope="col" style="text-align: left;"><img alt="VizuHAL" title="VizuHAL" width="250px" src="./img/logo_Vizuhal.png"><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Générez des stats HAL</th>
<th scope="col" style="text-align: right;"><img alt="Université de Rennes 1" title="Université de Rennes 1" width="150px" src="./img/logo_UR1_gris_petit.jpg"></th>
</tr>
</table>
<hr style="color: #467666; height: 1px; border-width: 1px; border-top-color: #467666; border-style: inset;">

<p>VizuHAL permet de générer des tableaux et graphes statistiques à partir de HAL (collection ou portail).<br>
<br>
Entrez un code collection OU sélectionnez un portail dans la liste déroulante, puis sélectionnez votre requête.<br>
<u>Attention :</u> certaines requêtes ne sont valides que pour une collection ou un portail.<br>
</p>

<?php
include "./VizuHAL_formulaire.php";

echo '<script type="text/javascript" language="Javascript" src="./VizuHAL.js"></script>';

if (isset($_POST["valider"]) || isset($_GET["reqt"])) {
  ob_flush();
	flush();
  //Bloquer interrogation code collection labo avec requête 3, 4, 8 ou 9
  if (($reqt == $cstR03 || $reqt == $cstR04 || $reqt == $cstR08 || $reqt == $cstR09) && isset($port) && $port == "choix") {
    echo "<br><br><center><font face='Corbel'><strong>";
    echo "Cette requête n'est pas applicable à un code collection mais uniquement à un portail.";
    echo "</strong></font></center>";
    die;
  }
	
	//Bloquer interrogation portail avec requête 10, 11, 12, 14, 15, 17, 18, 19, 20 ou 21
  if (($reqt == $cstR10 || $reqt == $cstR11 || $reqt == $cstR12 || $reqt == $cstR14 || $reqt == $cstR15 || $reqt == $cstR17 || $reqt == $cstR18 || $reqt == $cstR19 || $reqt == $cstR20 || $reqt == $cstR21) && isset($port) && $port != "choix") {
    echo "<br><br><center><font face='Corbel'><strong>";
    echo "Cette requête n'est pas applicable à portail mais uniquement à un code collection.";
    echo "</strong></font></center>";
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
	
  if ($reqt == $cstR01) {
    $anneedeb = $annee1;
    $anneefin = $annee1;
  }
	if ($reqt == $cstR24) {
    $anneedeb = $annee24;
    $anneefin = $annee24;
  }
  
	 //Tableau de résultats de la requête
	 include "./VizuHAL_requete".str_replace("req", "", $reqt).".php";
	
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

  if (isset($reqt) && $reqt == $cstR01) {
    include("./VizuHAL_grf_histo_req1.php");
    include("./VizuHAL_grf_cbert_req1.php");
  }
  
  if (isset($reqt) && $reqt == "req2") {
    include("./VizuHAL_grf_histo_req2.php");
    include("./VizuHAL_grf_cbert_req2.php");
  }

  if (isset($reqt) && ($reqt == $cstR01 || $reqt == "req2")) {
    if (isset($port) && $port != "choix") {
      $is = 0;
      while (isset($sect[$is]) && $sect[$is] != "") {
        //histogramme
        $ficgraf = "./grf/grf_".$sect[$is]."_".time().".png";
        grf_histo($anneedeb, $anneefin, $tabPro, $sect[$is], $ficgraf, "port");
        echo '<center><img alt="Productions HAL "'.$sect[$is].' src="'.$ficgraf.'"></center><br>';
        
        //Camemberts
        if ($reqt == $cstR01) {
          for($year = $anneedeb; $year <= $anneefin; $year++) {
            $ficgraf = "./grf/grf_".$year."_".$sect[$is]."_".time().".png";
            grf_cbert($year, $tabPro, $sect[$is], $ficgraf, "coll");
            echo '<center><img alt="Productions HAL "'.$year.' '.$team.' src="'.$ficgraf.'"></center><br>';
          }
        }

        $is++;
      }
    }else{
      //histogramme
      $ficgraf = "./grf/grf_".time().".png";
      grf_histo($anneedeb, $anneefin, $resHAL, $team, $ficgraf, "coll");
      echo '<center><img alt="Productions HAL "'.$team.' src="'.$ficgraf.'"></center><br>';

      //Camemberts
      for($year = $anneedeb; $year <= $anneefin; $year++) {
        $ficgraf = "./grf/grf_".$year."_".time().".png";
        grf_cbert($year, $resHAL, $team, $ficgraf, "coll");
        echo '<center><img alt="Productions HAL "'.$year.' '.$team.' src="'.$ficgraf.'"></center><br>';
      }
    }
  }
}
include "./VizuHAL_details_techniques.php";
?>
<?php
include "./bas.php";
?>
</body>
</html>
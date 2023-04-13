<!DOCTYPE html>
<?php
session_start();
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

$root = 'http';
if (isset ($_SERVER[$cstHTS]) && $_SERVER[$cstHTS] == "on")	{
  $root.= "s";
}

suppression("./csv", 3600);//Suppression des exports du dossier csv créés il y a plus d'une heure

?>
<html lang="fr">
<head>
	<meta charset="utf-8" />
	<title>VizuHAL - HAL - UR1</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta content="VizuHAL permet de générer des tableaux et graphes statistiques à partir de HAL (collection ou portail)" name="description" />
	<meta content="Coderthemes + Lizuka + OTroccaz + LJonchere + TFournier" name="author" />
	<!-- App favicon -->
	<link rel="shortcut icon" href="favicon.ico">

	<!-- third party css -->
	<!-- <link href="./assets/css/vendor/jquery-jvectormap-1.2.2.css" rel="stylesheet" type="text/css" /> -->
	<!-- third party css end -->

	<!-- App css -->
	<link href="./assets/css/icons.min.css" rel="stylesheet" type="text/css" />
	<link href="./assets/css/app-hal-ur1.min.css" rel="stylesheet" type="text/css" id="light-style" />
	<!-- <link href="./assets/css/app-creative-dark.min.css" rel="stylesheet" type="text/css" id="dark-style" /> -->
	
	<!-- third party js -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>
	<!-- third party js end -->
	
	<!-- bundle -->
	<script src="./assets/js/vendor.min.js"></script>
	<script src="./assets/js/app.min.js"></script>

	<!-- third party js -->
	<!-- <script src="./assets/js/vendor/Chart.bundle.min.js"></script> -->
	<!-- third party js ends -->
	<script src="./assets/js/pages/hal-ur1.chartjs.js"></script>
	
	<!-- Datatables css -->
	<link href="./assets/css/vendor/dataTables.bootstrap4.css" rel="stylesheet" type="text/css" />
	<link href="./assets/css/vendor/responsive.bootstrap4.css" rel="stylesheet" type="text/css" />
                                                
					
</head>

<body class="loading" data-layout="topnav" onload="freqt();">

<noscript>
<div class='text-primary' id='noscript'><strong>ATTENTION !!! JavaScript est désactivé ou non pris en charge par votre navigateur : cette procédure ne fonctionnera pas correctement.</strong><br>
<strong>Pour modifier cette option, voir <a target='_blank' rel='noopener noreferrer' href='http://www.libellules.ch/browser_javascript_activ.php'>ce lien</a>.</strong></div><br>
</noscript>

        <!-- Begin page -->
        <div class="wrapper">

            <!-- ============================================================== -->
            <!-- Start Page Content here -->
            <!-- ============================================================== -->

            <div class="content-page">
                <div class="content">
								
								<?php
								include "./Glob_haut.php";
								?>
								
								<!-- Start Content-->
                    <div class="container-fluid">

                        <!-- start page title -->
                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box">
                                    <div class="page-title-right">
                                        <nav aria-label="breadcrumb">
                                            <ol class="breadcrumb bg-light-lighten p-2">
                                                <li class="breadcrumb-item"><a href="index.php"><i class="uil-home-alt"></i> Accueil HALUR</a></li>
                                                <li class="breadcrumb-item active" aria-current="page">Vizu<span class="font-weight-bold">HAL</span></li>
                                            </ol>
                                        </nav>
                                    </div>
                                    <h4 class="page-title">Générez des stats HAL</h4>
                                </div>
                            </div>
                        </div>
                        <!-- end page title -->

                        <div class="row">
                            <div class="col-xl-8 col-lg-6 d-flex">
                                <!-- project card -->
                                <div class="card d-block w-100 shadow-lg">
                                    <div class="card-body">
                                        
                                        <!-- project title-->
                                        <h2 class="h1 mt-0">
                                            <i class="mdi mdi-chart-bar-stacked text-primary"></i>
                                            <span class="font-weight-light">Vizu</span><span class="text-primary">HAL</span>
                                        </h2>
                                        <h5 class="badge badge-primary badge-pill">Présentation</h5>
																				
																				<img src="./img/anders-ipsen-9XhgZmrvCEU-unsplash.jpg" alt="Accueil VizuHAL" class="img-fluid"><br>
																				<p class="font-italic">Photo : Anders Ipsen on Unsplash (détail)</p>

                                        <p class=" mb-2 text-justify">
                                           VizuHAL permet de générer des tableaux et graphes statistiques à partir de HAL (collection ou portail). Il a été créé par Olivier Troccaz (conception-développement), Laurent Jonchère (conception) et Thierry Fournier (conception). Son code est disponible <a target='_blank' rel='noopener noreferrer' href="https://github.com/OTroccaz/VizuHAL">sur GitHub</a> sous licence <a target='_blank' rel='noopener noreferrer' href="https://www.gnu.org/licenses/gpl-3.0.fr.html">GPLv3</a>.
                                       </p>
																			 
																			 <p class="mb-4">
                                            Contacts : <a target='_blank' rel='noopener noreferrer' href="https://openaccess.univ-rennes1.fr/interlocuteurs/laurent-jonchere">Laurent Jonchère</a> (Université de Rennes 1) / <a target='_blank' rel='noopener noreferrer' href="https://openaccess.univ-rennes1.fr/interlocuteurs/olivier-troccaz">Olivier Troccaz</a> (CNRS CReAAH/OSUR).
                                        </p>
																				
                                       <p class=" mb-2">
                                        Entrez un code collection OU sélectionnez un portail dans la liste déroulante, puis sélectionnez votre requête.<br>
                                                            Attention : certaines requêtes ne sont valides que pour une collection ou un portail.
                                        </p>


                                    </div> <!-- end card-body-->
                                    
                                </div> <!-- end card-->

                            </div> <!-- end col -->
                            <div class="col-lg-6 col-xl-4 d-flex">
                                <div class="card shadow-lg w-100">
                                    <div class="card-body">
                                        <h5 class="badge badge-primary badge-pill">Mode d'emploi</h5>
																				<div class=" mb-2">
                                            <ul class="list-group">
                                                <li class="list-group-item">
                                                    En préparation
                                                </li>
                                            </ul> 
                                        </div>
                                    </div>
                                </div>
                                <!-- end card-->
                            </div>
                        </div>
                        <!-- end row -->

                        <div class="row">
                            <div class="col-12 d-flex">
                                <!-- project card -->
                                <div class="card w-100 d-block shadow-lg">
                                    <div class="card-body">
                                        
                                        <h5 class="badge badge-primary badge-pill">Paramétrage</h5>
																				
																				<?php
																				include "./VizuHAL_formulaire.php";
																				?>
																				
																		</div> <!-- end card-body-->
                                    
                                </div> <!-- end card-->

                            </div> <!-- end col -->
                        
												</div> <!-- end row -->

																				<?php
																				echo '<script src="./VizuHAL.js"></script>';
																				
																				if (isset($_POST["valider"]) || isset($_GET["reqt"])) {
																					echo '<div class="row">';
																					echo '		<div class="col-12 d-flex">';
																					echo '				<div class="card shadow-lg w-100">';
																					echo '						<div class="card-body">';
																		
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
																						if ($reqt == $cstR01 && $annee1 < 2020) {
																							include('./VizuHAL_Port'.$port.'_av2020.php');
																						}else{
																							if ($reqt == "req24" && $annee24 < 2020) {
																								include('./VizuHAL_Port'.$port.'_av2020.php');
																							}else{
																								include('./VizuHAL_Port'.$port.'.php');
																							}
																						}
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
																				  if (isset($reqt) && $reqt == $cstR01) {
																					  include("./VizuHAL_grf_histo_req1.php");
																					  include("./VizuHAL_grf_cbert_req1.php");
																					}
																					
																					if (isset($reqt) && ($reqt == $cstR02 || $reqt == $cstR25)) {
																						include("./VizuHAL_grf_histo_req2.php");
																						include("./VizuHAL_grf_cbert_req2.php");
																					}
																					
																					if (isset($reqt) && ($reqt == $cstR01 || $reqt == $cstR02 || $reqt == $cstR25)) {
																						if (isset($port) && $port != "choix") {
																							$is = 0;
																							while (isset($sect[$is]) && $sect[$is] != "") {
																								//histogramme
																								grf_histo($anneedeb, $anneefin, $tabPro, $sect[$is], "port");
																								echo '<div class="form-group row mb-1">&nbsp;</div>';
																								//Camemberts
																								if ($reqt == $cstR01) {
																									for($year = $anneedeb; $year <= $anneefin; $year++) {
																										grf_cbert($year, $tabPro, $sect[$is], "coll");
																										echo '<div class="form-group row mb-1">&nbsp;</div>';
																									}
																								}
																								$is++;
																							}
																						}else{
																							//histogramme
																							grf_histo($anneedeb, $anneefin, $resHAL, $team, "coll");
																							echo '<div class="form-group row mb-1">&nbsp;</div>';
																							//Camemberts
																							for($year = $anneedeb; $year <= $anneefin; $year++) {
																								grf_cbert($year, $resHAL, $team, "coll");
																								echo '<div class="form-group row mb-1">&nbsp;</div>';
																							}
																						}
																					}
																					include "./VizuHAL_details_techniques.php";
																				
																					echo '								</div> <!-- end card-body-->';
																					echo '				</div> <!-- end card-->';
																					echo '		</div> <!-- end col -->';
																					echo '</div> <!-- end row -->';
																				}
																				?>

                    </div> <!-- container -->

                </div> <!-- content -->
								
								<?php
								include "./Glob_bas.php";
								?>
								
								</div>

            <!-- ============================================================== -->
            <!-- End Page content -->
            <!-- ============================================================== -->


        </div>
				
				<button id="scrollBackToTop" class="btn btn-primary"><i class="mdi mdi-24px text-white mdi-chevron-double-up"></i></button>
        <!-- END wrapper -->

        <!-- bundle -->
        <!-- <script src="./assets/js/vendor.min.js"></script> -->
        <script src="./assets/js/app.min.js"></script>

        <!-- third party js -->
        <!-- <script src="./assets/js/vendor/Chart.bundle.min.js"></script> -->
        <!-- third party js ends -->
        <script src="./assets/js/pages/hal-ur1.chartjs.js"></script>
				
				<script>
            (function($) {
                'use strict';
                $('#warning-alert-modal').modal(
                    {'show': true, 'backdrop': 'static'}    
                    
                        );
                $(document).scroll(function() {
                  var y = $(this).scrollTop();
                  if (y > 200) {
                    $('#scrollBackToTop').fadeIn();
                  } else {
                    $('#scrollBackToTop').fadeOut();
                  }
                });
                $('#scrollBackToTop').each(function(){
                    $(this).click(function(){ 
                        $('html,body').animate({ scrollTop: 0 }, 'slow');
                        return false; 
                    });
                });
            })(window.jQuery)
        </script>
        
    </body>
		
		<!-- Datatables js -->
		<script src="assets/js/vendor/jquery.dataTables.min.js"></script>
		<script src="assets/js/vendor/dataTables.bootstrap4.js"></script>
		<script src="assets/js/vendor/dataTables.responsive.min.js"></script>
		<script src="assets/js/vendor/responsive.bootstrap4.min.js"></script>
		<script src="assets/js/vendor/dataTables.buttons.min.js"></script>

		<!-- Datatable Init js -->
		<script src="assets/js/pages/demo.datatable-init.js"></script>
                                                
</html>
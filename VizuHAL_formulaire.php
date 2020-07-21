<form name="troli" action="VizuHAL.php" method="post"  onsubmit="freqt();">
<p class="form-inline"><label for="team">Code collection HAL</label> <a class='info' onclick='return false' href="#">(qu'est-ce que c’est ?)<span>Code visible dans l’URL d’une collection.
Exemple : IPR-MOL est le code de la collection http://hal.archives-ouvertes.fr/<strong>IPR-PMOL</strong> de l’équipe Physique moléculaire
de l’unité IPR UMR CNRS 6251</span></a> :

<?php
session_start();
if (isset($_POST["valider"])) {
	if (isset($_SESSION['datPro'])) {unset($_SESSION['datPro']);}
  $team = htmlspecialchars(strtoupper($_POST["team"]));
  $port = htmlspecialchars($_POST["port"]);
  $reqt = htmlspecialchars($_POST["reqt"]);
  if ($reqt == $cstR02) {
    $anneedeb = htmlspecialchars($_POST["anneedeb2"]);
    $anneefin = htmlspecialchars($_POST["anneefin2"]);
    if ($anneefin < $anneedeb) {$anneetemp = $anneedeb; $anneedeb = $anneefin; $anneefin = $anneetemp;}
  }else{
    if ($reqt == $cstR01) {
      $annee1 = htmlspecialchars($_POST["annee1"]);
    }else{
      if ($reqt == $cstR03) {
        $annee3 = htmlspecialchars($_POST["annee3"]);
      }else{
        if ($reqt == $cstR04) {
					$annee4 = htmlspecialchars($_POST["annee4"]);
				}else{
					if ($reqt == $cstR05) {
						$annee5 = htmlspecialchars($_POST["annee5"]);
					}else{
						if ($reqt == $cstR06) {
							$annee6 = htmlspecialchars($_POST["annee6"]);
						}else{
							if ($reqt == $cstR07) {
								$annee7 = htmlspecialchars($_POST["annee7"]);
							}else{
								if ($reqt == $cstR08) {
									$annee8 = htmlspecialchars($_POST["annee8"]);
								}else{
									if ($reqt == $cstR09) {
										$annee9 = htmlspecialchars($_POST["annee9"]);
									}else{
										if ($reqt == $cstR10) {
											$annee10 = htmlspecialchars($_POST["annee10"]);
										}else{
											if ($reqt == $cstR11) {
												$annee11 = htmlspecialchars($_POST["annee11"]);
											}else{
												if ($reqt == $cstR12) {
													$annee12 = htmlspecialchars($_POST["annee12"]);
												}else{
													if ($reqt == $cstR13) {
														$annee13 = htmlspecialchars($_POST["annee13"]);
													}else{
														if ($reqt == $cstR14) {
															$anneedeb = htmlspecialchars($_POST["anneedeb14"]);
															$anneefin = htmlspecialchars($_POST["anneefin14"]);
															if ($anneefin < $anneedeb) {$anneetemp = $anneedeb; $anneedeb = $anneefin; $anneefin = $anneetemp;}
														}else{
															if ($reqt == $cstR15) {
																$anneedeb = htmlspecialchars($_POST["anneedeb15"]);
																$anneefin = htmlspecialchars($_POST["anneefin15"]);
																if ($anneefin < $anneedeb) {$anneetemp = $anneedeb; $anneedeb = $anneefin; $anneefin = $anneetemp;}
															}else{
																if ($reqt == $cstR16) {
																	$anneedeb = htmlspecialchars($_POST["anneedeb16"]);
																	$anneefin = htmlspecialchars($_POST["anneefin16"]);
																	if ($anneefin < $anneedeb) {$anneetemp = $anneedeb; $anneedeb = $anneefin; $anneefin = $anneetemp;}
																}else{
																	if ($reqt == $cstR17) {
																		$annee17 = htmlspecialchars($_POST[$cstA17]);
																	}else{
																		if ($reqt == $cstR18) {
																			$annee18 = htmlspecialchars($_POST[$cstA18]);
																		}else{
																			if ($reqt == $cstR19) {
																				$annee19 = htmlspecialchars($_POST[$cstA19]);
																			}else{
																				if ($reqt == $cstR20) {
																					$annee20 = htmlspecialchars($_POST[$cstA20]);
																				}else{
																					if ($reqt == $cstR21) {
																						$anneedeb = htmlspecialchars($_POST["anneedeb21"]);
																						$anneefin = htmlspecialchars($_POST["anneefin21"]);
																						if ($anneefin < $anneedeb) {$anneetemp = $anneedeb; $anneedeb = $anneefin; $anneefin = $anneetemp;}
																					}else{
																						if ($reqt == $cstR22) {
																							$anneedeb = htmlspecialchars($_POST["anneedeb22"]);
																							$anneefin = htmlspecialchars($_POST["anneefin22"]);
																							if ($anneefin < $anneedeb) {$anneetemp = $anneedeb; $anneedeb = $anneefin; $anneefin = $anneetemp;}
																						}else{
																							if ($reqt == $cstR24) {
																								$annee24 = htmlspecialchars($_POST["annee24"]);
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
}
if (isset($team) && $team != "") {$team1 = $team; $team2 = $team;}else{$team1 = "Entrez le code de votre collection"; $team2 = "";}
if (isset($port) && $port != "choix") {$team1 = "";}
?>
<!--Code collection HAL-->
<input type="text" id="team" class="form-control" style="height: 25px; width: 300px;" name="team" value="<?php echo $team1;?>" onClick="this.value='<?php echo $team2;?>'; document.getElementById('port').value = 'choix';">&nbsp;<a target="_blank" rel="noopener noreferrer" href="https://hal-univ-rennes1.archives-ouvertes.fr/page/codes-collections">Trouver le code de mon équipe / labo</a>
<h2><strong><u>ou</u></strong></h2>
<br>
<!--Portail HAL-->
<p class="form-inline"><label for="port">Portail HAL :&nbsp;</label></td>
<select id="port" class="form-control" style="margin:0px; width:300px" size="1" name="port" onChange="document.getElementById('team').value = '';">
<option value="choix">Veuillez choisir parmi la liste</option>
<?php
$sel = array();
if (isset($port) && $port != "choix") {$sel[$port] = "selected";}

$dossier = opendir('./');
while (false !== ($fichier = readdir($dossier))) {
  if($fichier != '.' && $fichier != '..' && strpos($fichier, 'PortHAL')!== false) {
    $qui = str_replace(array('Port', '.php'), '', $fichier);
		if(isset($sel[$qui])) {
			echo '<option value='.$qui.' '.$sel[$qui].'>'.$qui.'</option>';
		}else{
			echo '<option value='.$qui.'>'.$qui.'</option>';
		}
  }
}
?>
</select>
<br><br>
<?php
if (isset($reqt) && $reqt == "tabg") {$itab = $cstSel;}else{$itab = "";}
if (isset($reqt) && $reqt == $cstR01) {$irq1 = $cstSel;}else{$irq1 = "";}
if (isset($reqt) && $reqt == $cstR24) {$irq24 = $cstSel;}else{$irq24 = "";}
if (isset($reqt) && $reqt == $cstR02) {$irq2 = $cstSel;}else{$irq2 = "";}
if (isset($reqt) && $reqt == $cstR03) {$irq3 = $cstSel;}else{$irq3 = "";}
if (isset($reqt) && $reqt == $cstR04) {$irq4 = $cstSel;}else{$irq4 = "";}
if (isset($reqt) && $reqt == $cstR05) {$irq5 = $cstSel;}else{$irq5 = "";}
if (isset($reqt) && $reqt == $cstR06) {$irq6 = $cstSel;}else{$irq6 = "";}
if (isset($reqt) && $reqt == $cstR07) {$irq7 = $cstSel;}else{$irq7 = "";}
if (isset($reqt) && $reqt == $cstR08) {$irq8 = $cstSel;}else{$irq8 = "";}
if (isset($reqt) && $reqt == $cstR09) {$irq9 = $cstSel;}else{$irq9 = "";}
if (isset($reqt) && $reqt == $cstR10) {$irq10 = $cstSel;}else{$irq10 = "";}
if (isset($reqt) && $reqt == $cstR11) {$irq11 = $cstSel;}else{$irq11 = "";}
if (isset($reqt) && $reqt == $cstR12) {$irq12 = $cstSel;}else{$irq12 = "";}
if (isset($reqt) && $reqt == $cstR13) {$irq13 = $cstSel;}else{$irq13 = "";}
if (isset($reqt) && $reqt == $cstR14) {$irq14 = $cstSel;}else{$irq14 = "";}
if (isset($reqt) && $reqt == $cstR15) {$irq15 = $cstSel;}else{$irq15 = "";}
if (isset($reqt) && $reqt == $cstR16) {$irq16 = $cstSel;}else{$irq16 = "";}
if (isset($reqt) && $reqt == $cstR17) {$irq17 = $cstSel;}else{$irq17 = "";}
if (isset($reqt) && $reqt == $cstR18) {$irq18 = $cstSel;}else{$irq18 = "";}
if (isset($reqt) && $reqt == $cstR19) {$irq19 = $cstSel;}else{$irq19 = "";}
if (isset($reqt) && $reqt == $cstR20) {$irq20 = $cstSel;}else{$irq20 = "";}
if (isset($reqt) && $reqt == $cstR21) {$irq21 = $cstSel;}else{$irq21 = "";}
if (isset($reqt) && $reqt == $cstR22) {$irq22 = $cstSel;}else{$irq22 = "";}
if (isset($reqt) && $reqt == $cstR23) {$irq23 = $cstSel;}else{$irq23 = "";}
?>
<!--Extraction-->
<p class="form-inline"><label for="reqt">Extraction souhaitée :&nbsp;</label>
<select id="reqt" class="form-control" style="margin:0px;" size="1" name="reqt" onChange="freqt();">
<!--<option value="tabg"<?php echo $itab;?>>Tableau de bord général</option>-->
<option value="<?php echo $cstR01;?>"<?php echo $irq1;?>>1. Portail : production scientifique par secteur et par unité</option>
<option value="<?php echo $cstR24;?>"<?php echo $irq24;?>>1A. Portail : production scientifique par secteur et par unité (Articles de revue)</option>
<option value="<?php echo $cstR02;?>"<?php echo $irq2;?>>2. Portail ou collection : évolution sur une période</option>
<option value="<?php echo $cstR03;?>"<?php echo $irq3;?>>3. Portail : Comparaison portails</option>
<option value="<?php echo $cstR04;?>"<?php echo $irq4;?>>4. Portail : ESGBU (stocks et flux)</option>
<option value="<?php echo $cstR05;?>"<?php echo $irq5;?>>5. Portail ou Collection : Nombre de publications de type articles par éditeur</option>
<option value="<?php echo $cstR06;?>"<?php echo $irq6;?>>6. Portail ou Collection : Nombre de publications de type communications par éditeur</option>
<option value="<?php echo $cstR07;?>"<?php echo $irq7;?>>7. Portail ou Collection : Nombre de publications (articles de revue) par revue</option>
<!--
<option value="<?php echo $cstR08;?>"<?php echo $irq8;?>>8. Portail : Pourcentage par secteur des articles de tel éditeur</option>
<option value="<?php echo $cstR09;?>"<?php echo $irq9;?>>9. Portail : Pourcentage par éditeur des articles de tel secteur</option>
-->
<option value="<?php echo $cstR10;?>"<?php echo $irq10;?>>10. Collection : Nombre d'articles sans texte intégral déposé dans HAL par éditeur</option>
<option value="<?php echo $cstR11;?>"<?php echo $irq11;?>>11. Collection : Nombre d'articles avec texte intégral déposé dans HAL par éditeur</option>
<option value="<?php echo $cstR12;?>"<?php echo $irq12;?>>12. Collection : Nombre d'articles avec texte intégral déposé dans HAL OU lien externe vers PDF en open access par éditeur</option>
<option value="<?php echo $cstR13;?>"<?php echo $irq13;?>>13. Portail ou collection : évolution sur une et trois années</option>
<option value="<?php echo $cstR14;?>"<?php echo $irq14;?>>14. Collection : Nombre de projets ANR</option>
<option value="<?php echo $cstR15;?>"<?php echo $irq15;?>>15. Collection : Nombre de projets européens</option>
<option value="<?php echo $cstR16;?>"<?php echo $irq16;?>>16. Collection : Profil des contributeurs HAL</option>
<option value="<?php echo $cstR17;?>"<?php echo $irq17;?>>17. Collection : Collaborations nationales</option>
<option value="<?php echo $cstR18;?>"<?php echo $irq18;?>>18. Collection : Collaborations nationales (laboratoires)</option>
<option value="<?php echo $cstR19;?>"<?php echo $irq19;?>>19. Collection : Collaborations nationales (établissements)</option>
<option value="<?php echo $cstR20;?>"<?php echo $irq20;?>>20. Collection : Collaborations nationales (autres)</option>
<option value="<?php echo $cstR21;?>"<?php echo $irq21;?>>21. Collection : Collaborations internationales (toutes structures)</option>
<option value="<?php echo $cstR22;?>"<?php echo $irq22;?>>22. Collection : Collaborations internationales (institutions)</option>
<option value="<?php echo $cstR23;?>"<?php echo $irq23;?>>23. Collection : Collaborations internationales (pays)</option>
</select>

<!--Tableau général-->
<div id="tabg">
<!--Paramètres :-->
</div>

<!--Requête 1-->
<div id="<?php echo $cstR01;?>">
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

<!--Requête 24 (>1A)-->
<div id="<?php echo $cstR24;?>">
<!--Paramètres :-->
<label for="annee24">Année</label>
<select id="annee24" class="form-control" style="height: 25px; width: 60px; padding: 0px;" name="annee24">
<?php
$moisactuel = date('n', time());
if ($moisactuel >= 10) {$i = date('Y', time())+1;}else{$i = date('Y', time());}
while ($i >= date('Y', time()) - 30) {
  if(isset($annee24) && $annee24 == $i) {$txt = "selected";}else{$txt = "";}
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
<div id="<?php echo $cstR02;?>">
<!--Paramètres :-->
<table aria-describedby="Période">
<tr><th scope="col" class="valign">Période :&nbsp;</th>
<th scope="col">
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
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<em><u>Attention :</u> l'extraction via un portail demande beaucoup de temps et il est préférable de se limiter à une période annuelle.</em>
<br>
</th></tr></table>
<p class="form-inline">
<input type="submit" class="btn btn-md btn-primary" value="Valider" name="valider">
</p>
</div>

<!--Requête 3-->
<div id="<?php echo $cstR03;?>">
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
<div id="<?php echo $cstR04;?>">
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
<div id="<?php echo $cstR05;?>">
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
<div id="<?php echo $cstR06;?>">
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
<div id="<?php echo $cstR07;?>">
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
<div id="<?php echo $cstR08;?>">
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
<div id="<?php echo $cstR09;?>">
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
<div id="<?php echo $cstR10;?>">
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
<div id="<?php echo $cstR11;?>">
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
<div id="<?php echo $cstR12;?>">
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
<div id="<?php echo $cstR13;?>">
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
<div id="<?php echo $cstR14;?>">
<!--Paramètres :-->
<table aria-describedby="Période">
<tr><th scope="col" class="valign">Période :&nbsp;</th>
<th scope="col">
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
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<em><u>Attention :</u> l'extraction sur plusieurs années peut demander beaucoup de temps et il est préférable de se limiter à une période raisonnable.</em>
<br>
</th></tr></table>
<br>
<p class="form-inline">
<input type="submit" class="btn btn-md btn-primary" value="Valider" name="valider">
</p>
</div>

<!--Requête 15-->
<div id="<?php echo $cstR15;?>">
<!--Paramètres :-->
<table aria-describedby="Période">
<tr><th scope="col" class="valign">Période :&nbsp;</th>
<th scope="col">
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
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<em><u>Attention :</u> l'extraction sur plusieurs années peut demander beaucoup de temps et il est préférable de se limiter à une période raisonnable.</em>
<br>
</th></tr></table>
<br>
<p class="form-inline">
<input type="submit" class="btn btn-md btn-primary" value="Valider" name="valider">
</p>
</div>

<!--Requête 16-->
<div id="<?php echo $cstR16;?>">
<!--Paramètres :-->
<table aria-describedby="Période">
<tr><th scope="col" class="valign">Période :&nbsp;</th>
<th scope="col">
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
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<em><u>Attention :</u> l'extraction sur plusieurs années peut demander beaucoup de temps et il est préférable de se limiter à une période raisonnable.</em>
<br>
</th></tr></table>
<br>
<p class="form-inline">
<input type="submit" class="btn btn-md btn-primary" value="Valider" name="valider">
</p>
</div>

<!--Requête 17-->
<div id="<?php echo $cstR17;?>">
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
<div id="<?php echo $cstR18;?>">
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
<div id="<?php echo $cstR19;?>">
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
<div id="<?php echo $cstR20;?>">
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
<div id="<?php echo $cstR21;?>">
<table aria-describedby="Période">
<tr><th scope="col" class="valign">Période :&nbsp;</th>
<th scope="col">
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
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<em><u>Attention :</u> l'extraction sur plusieurs années peut demander beaucoup de temps et il est préférable de se limiter à une période raisonnable.</em>
<br>
</th></tr></table>
<br>
<p class="form-inline">
<input type="submit" class="btn btn-md btn-primary" value="Valider" name="valider">
</p>
</div>

<!--Requête 22-->
<div id="<?php echo $cstR22;?>">
<table aria-describedby="Période">
<tr><th scope="col" class="valign">Période :&nbsp;</th>
<th scope="col">
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
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<em><u>Attention :</u> l'extraction sur plusieurs années peut demander beaucoup de temps et il est préférable de se limiter à une période raisonnable.</em>
<br>
</th></tr></table>
<br>
<p class="form-inline">
<input type="submit" class="btn btn-md btn-primary" value="Valider" name="valider">
</p>
</div>

<!--Requête 23-->
<div id="<?php echo $cstR23;?>">
<table aria-describedby="Période">
<tr><th scope="col" class="valign">Période :&nbsp;</th>
<th scope="col">
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
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<em><u>Attention :</u> l'extraction sur plusieurs années peut demander beaucoup de temps et il est préférable de se limiter à une période raisonnable.</em>
<br>
</th></tr></table>
<br>
<p class="form-inline">
<input type="submit" class="btn btn-md btn-primary" value="Valider" name="valider">
</p>
</div>

</form>
<?php
function grf_histo($anneedeb, $anneefin, $arrRes, $team, $ficgraf, $orig) {
  //Recherche de la valeur maximale que doit prendre l'axe des ordonnées
  $maxY = 0;
  for($year = $anneedeb; $year <= $anneefin; $year++) {
    $nbavTI = $arrRes[$year][$team]["nfProavTI"];
    $nbnoTI = $arrRes[$year][$team]["nfPronoTI"];
    if (($nbavTI + $nbnoTI) > $maxY) {
      $maxY = $nbavTI + $nbnoTI;
    }
  }
	
	if (strpos(phpversion(), "7") !== false) {//PHP7 > pChart2
		$myPicture = new pDraw(700,280);
		$rYearArr = array();
		
		for($year = $anneedeb; $year <= $anneefin; $year++) {
			$nbavTI = $arrRes[$year][$team]["nfProavTI"];
			$nbnoTI = $arrRes[$year][$team]["nfPronoTI"];
			$nbnoTIavOA = $arrRes[$year][$team]["nfPronoTIavOA"];
			$nbnoTInoOA = $nbnoTI - $nbnoTIavOA;
			array_push($rYearArr, $year);
			$rTypeArr = array();
			if($nbnoTInoOA != 0){
				array_push($rTypeArr, $nbnoTInoOA);
			} else {
				array_push($rTypeArr, VOID);
			}
			$myPicture->myData->addPoints($rTypeArr, "Sans TI");
			$rTypeArr = array();
			if($nbavTI != 0){
				array_push($rTypeArr, $nbavTI);
			} else {
				array_push($rTypeArr, VOID);
			}
			$myPicture->myData->addPoints($rTypeArr, "Avec TI");
			$rTypeArr = array();
			if($nbnoTIavOA != 0){
				array_push($rTypeArr, $nbnoTIavOA);
			} else {
				array_push($rTypeArr, VOID);
			}
			$myPicture->myData->addPoints($rTypeArr, "Avec lien externe vers PDF en OA");
		}
		$myPicture->myData->addPoints($rYearArr,"Labels");
		$myPicture->myData->setAxisName(0,"Nombre");
		$myPicture->myData->setSerieDescription("Labels","Année");
		$myPicture->myData->setAbscissa("Labels");
		$myPicture->myData->setAbscissaName("Année");

		/* Create the pChart object */
		$myPicture->drawGradientArea(0,0,700,280,DIRECTION_VERTICAL, ["StartColor"=>new pColor(240,240,240,100),"EndColor"=>new pColor(180,180,180,100)]);
		$myPicture->drawGradientArea(0,0,700,280,DIRECTION_HORIZONTAL, ["StartColor"=>new pColor(240,240,240,20),"EndColor"=>new pColor(180,180,180,20)]);
		$myPicture->drawRectangle(0,0,699,279,array("R"=>0,"G"=>0,"B"=>0));
		$myPicture->setFontProperties(array("FontName"=>"./lib/pChart/fonts/corbel.ttf","FontSize"=>10));

		/* Turn of Antialiasing */
		$myPicture->Antialias = FALSE;

		/* Draw the scale  */
		$AxisBoundaries = [0=>array("Min"=>0,"Max"=>$maxY)];
		$myPicture->setGraphArea(50,50,680,220);
		$myPicture->drawText(350,40,"Productions HAL ".$team,array("FontSize"=>20,"Align"=>TEXT_ALIGN_BOTTOMMIDDLE));
		$myPicture->drawScale(array("CycleBackground"=>TRUE,"DrawSubTicks"=>TRUE,"GridR"=>0,"GridG"=>0,"GridB"=>0,"GridAlpha"=>10,"Mode"=>SCALE_MODE_MANUAL,"ManualScale"=>$AxisBoundaries));

		/* Turn on shadow computing */
		$myPicture->setShadow(TRUE,array("X"=>1,"Y"=>1,"R"=>0,"G"=>0,"B"=>0,"Alpha"=>10));
		
		/* Colors of the series */
		$myPicture->myData->setPalette("Sans TI", new pColor(46, 151, 224, 100));
		$myPicture->myData->setPalette("Avec TI", new pColor(188, 224, 46, 100));
		$myPicture->myData->setPalette("Avec lien externe vers PDF en OA", new pColor(244, 120, 66, 100));

		/* Draw the chart */
		$settings = array("Gradient"=>TRUE,"DisplayPos"=>LABEL_POS_INSIDE,"DisplayValues"=>TRUE,"DisplayR"=>255,"DisplayG"=>255,"DisplayB"=>255,"DisplayShadow"=>TRUE,"Surrounding"=>-30,"InnerSurrounding"=>30);
		(new pCharts($myPicture))->drawStackedBarChart($settings);

		/* Write the chart legend */
		$myPicture->drawLegend(30,260,array("Style"=>LEGEND_NOBORDER,"Mode"=>LEGEND_HORIZONTAL));

		/* Do the mirror effect */
		$myPicture->drawAreaMirror(0,220,700,15);
	}else{//PHP5 > pChart
		$MyData = new pData();
		
		for($year = $anneedeb; $year <= $anneefin; $year++) {
			$nbavTI = $arrRes[$year][$team]["nfProavTI"];
			$nbnoTI = $arrRes[$year][$team]["nfPronoTI"];
			$nbnoTIavOA = $arrRes[$year][$team]["nfPronoTIavOA"];
			$nbnoTInoOA = $nbnoTI - $nbnoTIavOA;
			$MyData->addPoints($year, "Labels");
			if($nbnoTInoOA != 0){
				 $MyData->addPoints($nbnoTInoOA, "Sans TI");
			} else {
				 $MyData->addPoints(VOID, "Sans TI");
			}
			if($nbavTI != 0){
				 $MyData->addPoints($nbavTI, "Avec TI");
			} else {
				 $MyData->addPoints(VOID, "Avec TI");
			}
			if($nbnoTIavOA != 0){
				 $MyData->addPoints($nbnoTIavOA, "Avec lien externe vers PDF en OA");
			} else {
				 $MyData->addPoints(VOID, "Avec lien externe vers PDF en OA");
			}
		}
		
		$MyData->setAxisName(0,"Nombre");
		$MyData->setSerieDescription("Labels","Année");
		$MyData->setAbscissa("Labels");
		$MyData->setAbscissaName("Année");
		
		/* Create the pChart object */
		$myPicture = new pImage(700,280,$MyData);
		$myPicture->drawGradientArea(0,0,700,280,DIRECTION_VERTICAL,array("StartR"=>240,"StartG"=>240,"StartB"=>240,"EndR"=>180,"EndG"=>180,"EndB"=>180,"Alpha"=>100));
		$myPicture->drawGradientArea(0,0,700,280,DIRECTION_HORIZONTAL,array("StartR"=>240,"StartG"=>240,"StartB"=>240,"EndR"=>180,"EndG"=>180,"EndB"=>180,"Alpha"=>20));
		$myPicture->drawRectangle(0,0,699,279,array("R"=>0,"G"=>0,"B"=>0));
		$myPicture->setFontProperties(array("FontName"=>"./lib/pChart/fonts/corbel.ttf","FontSize"=>10));

		/* Turn of Antialiasing */
		$myPicture->Antialias = FALSE;

		/* Draw the scale  */
		$AxisBoundaries = array(0=>array("Min"=>0,"Max"=>$maxY));
		$myPicture->setGraphArea(50,50,680,220);
		$myPicture->drawText(350,40,"Productions HAL ".$team,array("FontSize"=>20,"Align"=>TEXT_ALIGN_BOTTOMMIDDLE));
		$myPicture->drawScale(array("CycleBackground"=>TRUE,"DrawSubTicks"=>TRUE,"GridR"=>0,"GridG"=>0,"GridB"=>0,"GridAlpha"=>10,"Mode"=>SCALE_MODE_MANUAL,"ManualScale"=>$AxisBoundaries));

		/* Turn on shadow computing */
		$myPicture->setShadow(TRUE,array("X"=>1,"Y"=>1,"R"=>0,"G"=>0,"B"=>0,"Alpha"=>10));

		/* Colors of the series */
		$sansTI = array("R"=>46,"G"=>151,"B"=>224,"Alpha"=>100);
		$MyData->setPalette("Sans TI",$sansTI);
		$avecTI = array("R"=>188,"G"=>224,"B"=>46,"Alpha"=>100);
		$MyData->setPalette("Avec TI",$avecTI);
		$noTIavOA = array("R"=>244,"G"=>120,"B"=>66,"Alpha"=>100);
		$MyData->setPalette("Avec lien externe vers PDF en OA",$noTIavOA);

		/* Draw the chart */
		$settings = array("DisplayPos"=>LABEL_POS_INSIDE,"DisplayValues"=>TRUE,"DisplayR"=>0,"DisplayG"=>0,"DisplayB"=>0,"DisplayShadow"=>TRUE,"Surrounding"=>-30,"InnerSurrounding"=>30);
		$myPicture->drawStackedBarChart($settings);

		/* Write the chart legend */
		$myPicture->drawLegend(30,260,array("Style"=>LEGEND_NOBORDER,"Mode"=>LEGEND_HORIZONTAL));

		/* Do the mirror effect */
		$myPicture->drawAreaMirror(0,220,700,15);
	}
	
  /* Render the picture (choose the best way) */
  $myPicture->render($ficgraf);
  
}
?>
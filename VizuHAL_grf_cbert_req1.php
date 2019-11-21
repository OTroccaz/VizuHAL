<?php
function grf_cbert($year, $resHAL, $team, $ficgraf, $orig) {
	$nbnoTI = $resHAL[$year][$team]["nfPronoTI"] - $resHAL[$year][$team]["nfPronoTIavOA"];
	$nbavTI = $resHAL[$year][$team]["nfProavTI"];
	$nbavOA = $resHAL[$year][$team]["nfPronoTIavOA"];
	
	if (strpos(phpversion(), "7") !== false) {//PHP7 > pChart2
		$myPicture = new pDraw(500,230);
					
		$myPicture->myData->addPoints([$nbnoTI, $nbavTI, $nbavOA],"Detail");
		$myPicture->myData->setSerieDescription("Detail","Application A");

		/* Define the absissa serie */
		$myPicture->myData->addPoints(["Sans TI","Avec TI","Avec lien externe vers PDF en OA"],"Labels");
		$myPicture->myData->setAbscissa("Labels");

		/* Draw a solid background */
		$Settings = ["Color"=>new pColor(173,152,217), "Dash"=>TRUE, "DashColor"=>new pColor(193,172,237)];
		$myPicture->drawFilledRectangle(0,0,500,230,$Settings);

		/* Draw a gradient overlay */
		$myPicture->drawGradientArea(0,0,500,280,DIRECTION_VERTICAL, ["StartColor"=>new pColor(240,240,240,100),"EndColor"=>new pColor(180,180,180,100)]);
		$myPicture->drawGradientArea(0,0,500,280,DIRECTION_HORIZONTAL, ["StartColor"=>new pColor(240,240,240,20),"EndColor"=>new pColor(180,180,180,20)]);


		/* Add a border to the picture */
		$myPicture->drawRectangle(0,0,499,229,array("R"=>0,"G"=>0,"B"=>0));

		/* Write the picture title */
		$myPicture->setFontProperties(array("FontName"=>"./lib/pChart/fonts/corbel.ttf","FontSize"=>10));
		$myPicture->drawText(250,40,"Productions HAL ".$team." ".$year,array("FontSize"=>20,"Align"=>TEXT_ALIGN_BOTTOMMIDDLE));

		/* Set the default font properties */
		$myPicture->setFontProperties(array("FontName"=>"./lib/pChart/fonts/corbel.ttf","FontSize"=>10,"R"=>80,"G"=>80,"B"=>80));

		/* Create the pPie object */
		$PieChart = new pPie($myPicture);
		
		/* Define the slice colors */
		$myPicture->myData->savePalette([
			0 => new pColor(46,151,224),
			1 => new pColor(188,224,46),
			2 => new pColor(244,120,66)
		]);

		/* Enable shadow computing */
		$myPicture->setShadow(TRUE,array("X"=>3,"Y"=>3,"Color"=>new pColor(0,0,0,10)));

		/* Draw a splitted pie chart */
		$PieChart->draw3DPie(250,125,["WriteValues"=>TRUE,"ValuePosition"=>PIE_VALUE_OUTSIDE,"ValueColor"=>new pColor(0,0,0,100),"DataGapAngle"=>10,"DataGapRadius"=>6,"Border"=>TRUE]);

		/* Write the legend */
		$myPicture->setFontProperties(array("FontName"=>"./lib/pChart/fonts/corbel.ttf","FontSize"=>10));
		$myPicture->setShadow(TRUE,array("X"=>1,"Y"=>1,"Color"=>new pColor(0,0,0,20)));

		/* Write the legend box */
		$myPicture->setFontProperties(array("FontName"=>"./lib/pChart/fonts/corbel.ttf","FontSize"=>10,"R"=>0,"G"=>0,"B"=>0));
		$PieChart->drawPieLegend(30,200,array("Style"=>LEGEND_NOBORDER,"Mode"=>LEGEND_HORIZONTAL));
	}else{//PHP5 > pChart
		$MyData = new pData();

		$MyData->addPoints(array($nbnoTI, $nbavTI, $nbavOA),"Detail");
		$MyData->setSerieDescription("Detail","Application A");//?

		/* Define the absissa serie */
		$MyData->addPoints(array("Sans TI","Avec TI","Avec lien externe vers PDF en OA"),"Labels");
		$MyData->setAbscissa("Labels");

		/* Create the pChart object */
		$myPicture = new pImage(500,230,$MyData,TRUE);

		/* Draw a solid background */
		$Settings = array("R"=>173, "G"=>152, "B"=>217, "Dash"=>1, "DashR"=>193, "DashG"=>172, "DashB"=>237);
		$myPicture->drawFilledRectangle(0,0,500,230,$Settings);

		/* Draw a gradient overlay */
		$myPicture->drawGradientArea(0,0,500,280,DIRECTION_VERTICAL,array("StartR"=>240,"StartG"=>240,"StartB"=>240,"EndR"=>180,"EndG"=>180,"EndB"=>180,"Alpha"=>100));
		$myPicture->drawGradientArea(0,0,500,280,DIRECTION_HORIZONTAL,array("StartR"=>240,"StartG"=>240,"StartB"=>240,"EndR"=>180,"EndG"=>180,"EndB"=>180,"Alpha"=>20));

		/* Add a border to the picture */
		$myPicture->drawRectangle(0,0,499,229,array("R"=>0,"G"=>0,"B"=>0));

		/* Write the picture title */
		$myPicture->setFontProperties(array("FontName"=>"./lib/pChart/fonts/corbel.ttf","FontSize"=>10));
		$myPicture->drawText(250,40,"Productions HAL ".$team." ".$year,array("FontSize"=>20,"Align"=>TEXT_ALIGN_BOTTOMMIDDLE));

		/* Set the default font properties */
		$myPicture->setFontProperties(array("FontName"=>"./lib/pChart/fonts/corbel.ttf","FontSize"=>10,"R"=>80,"G"=>80,"B"=>80));

		/* Create the pPie object */
		$PieChart = new pPie($myPicture,$MyData);

		/* Define the slice color */
		$PieChart->setSliceColor(0,array("R"=>46,"G"=>151,"B"=>224));
		$PieChart->setSliceColor(1,array("R"=>188,"G"=>224,"B"=>46));
		$PieChart->setSliceColor(2,array("R"=>244,"G"=>120,"B"=>66));

		/* Enable shadow computing */
		$myPicture->setShadow(TRUE,array("X"=>3,"Y"=>3,"R"=>0,"G"=>0,"B"=>0,"Alpha"=>10));

		/* Draw a splitted pie chart */
		$PieChart->draw3DPie(250,125,array("WriteValues"=>TRUE,"ValuePosition"=>PIE_VALUE_OUTSIDE,"ValueR"=>0,"ValueG"=>0,"ValueB"=>0,"DataGapAngle"=>10,"DataGapRadius"=>6,"Border"=>TRUE));

		/* Write the legend */
		$myPicture->setFontProperties(array("FontName"=>"./lib/pChart/fonts/corbel.ttf","FontSize"=>10));
		$myPicture->setShadow(TRUE,array("X"=>1,"Y"=>1,"R"=>0,"G"=>0,"B"=>0,"Alpha"=>20));

		/* Write the legend box */
		$myPicture->setFontProperties(array("FontName"=>"./lib/pChart/fonts/corbel.ttf","FontSize"=>10,"R"=>0,"G"=>0,"B"=>0));
		$PieChart->drawPieLegend(30,200,array("Style"=>LEGEND_NOBORDER,"Mode"=>LEGEND_HORIZONTAL));
	}
  $myPicture->render($ficgraf);
}
?>
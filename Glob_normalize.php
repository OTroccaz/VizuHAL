<?php
/*
 * VizuHAL - Générez des stats HAL - Generate HAL stats
 *
 * Copyright (C) 2023 Olivier Troccaz (olivier.troccaz@cnrs.fr) and Laurent Jonchère (laurent.jonchere@univ-rennes.fr)
 * Released under the terms and conditions of the GNU General Public License (https://www.gnu.org/licenses/gpl-3.0.txt)
 *
 * Normalisation - Standardisation
 */
 ?>
 
<!-- <meta http-equiv="Content-Type" content="text/html; charset=utf-8"> -->
<?php
function normalize($st) {
    //return preg_replace('/\W+/', '', $st);
    $st = strtr($st,' ()"-!?[]{}:,;./*+$^=\'\\','                       ');
    $st = preg_replace('/\s+/', '', $st);
		$utf8 = array(
			/* à répéter pour chaque caractère accentué possible */
			'/[æǽ]/u' => 'ae',
			'/[ÆǼ]/u' => 'AE',
			'/[œ]/u' => 'oe',
			'/[Œ]/u' => 'OE',
			'/[áàâãäåāăąǻά]/u' => 'a',
			'/[ÁÀÂÃÄÅĀĂĄǺΆ]/u' => 'A',
			'/[ḃб]/u' => 'b',
			'/[ḂБ]/u' => 'B',
			'/[çćĉċčц]/u' => 'c',
			'/[ÇĆĈĊČЦ]/u' => 'C',
			'/[ďḋđдð]/u' => 'd',
			'/[ĎḊĐД]/u' => 'D',
			'/[éèêëēĕėęěэ]/u' => 'e',
			'/[ÉÈÊËĒĔĖĘĚΈЭ]/u' => 'E',
			'/[ḟƒфФ]/u' => 'f',
			'/[Ḟ₣]/u' => 'F',
			'/[ĝğġģг]/u' => 'g',
			'/[ĜĞĠĢГ]/u' => 'G',
			'/[ĥħ]/u' => 'h',
			'/[ĤĦΉ]/u' => 'H',
			'/[íìîïĩīĭįίи]/u' => 'i',
			'/[ÍÌÎÏĨĪĬĮİΊИ]/u' => 'I',
			'/[ĵй]/u' => 'j',
			'/[ĴЙĲ]/u' => 'J',
			'/[ķк]/u' => 'k',
			'/[Ķ]/u' => 'K',
			'/[ĺľļŀłл]/u' => 'l',
			'/[ĹĽĻĿŁЛ]/u' => 'L',
			'/[ṁм]/u' => 'm',
			'/[Ṁ]/u' => 'M',
			'/[ñńňņнŉŋ]/u' => 'n',
			'/[ÑŃŇŅŊ]/u' => 'N',
			'/[óòôõöőøōŏơǿό]/u' => 'o',
			'/[ÓÒÔÕÖŐØŌŎƠǾΌ]/u' => 'O',
			'/[ṗп]/u' => 'p',
			'/[ṖП]/u' => 'P',
			'/[ŕřŗ]/u' => 'r',
			'/[ŔŘŖ]/u' => 'R',
			'/[šśŝṡşș]/u' => 's',
			'/[ŠŚŜṠŞȘ]/u' => 'S',
			'/[ťṫţțŧтþ]/u' => 't',
			'/[ŤṪŢȚŦ]/u' => 'T',
			'/[ùúûüũŭūůűųư]/u' => 'u',
			'/[ÚÙÛÜŨŬŪŮŰŲƯ]/u' => 'U',
			'/[в]/u' => 'v',
			'/[ẃẁŵẅ]/u' => 'w',
			'/[ẂẀŴẄ]/u' => 'W',
			'/[ýÿŷỳ]/u' => 'y',
			'/[ÝŸŶỲ]/u' => 'Y',
			'/[žźżз]/u' => 'z',
			'/[ŽŹŻЗ]/u' => 'Z'
		);
		return preg_replace(array_keys($utf8), array_values($utf8), $st);
		//return str_replace(array('à','á','â','ã','ä','ç','è','é','ê','ë','ì','í','î','ï','ñ','ò','ó','ô','õ','ö','ù','ú','û','ü','ý','ÿ','À','Á','Â','Ã','Ä','Ç','È','É','Ê','Ë','Ì','Í','Î','Ï','Ñ','Ò','Ó','Ô','Õ','Ö','Ù','Ú','Û','Ü','Ý'), array('a','a','a','a','a','c','e','e','e','e','i','i','i','i','n','o','o','o','o','o','u','u','u','u','y','y','A','A','A','A','A','C','E','E','E','E','I','I','I','I','N','O','O','O','O','O','U','U','U','U','Y'), $st);
    //return strtr($st,'àáâãäçèéêëìíîïñòóôõöùúûüýÿÀÁÂÃÄÇÈÉÊËÌÍÎÏÑÒÓÔÕÖÙÚÛÜÝ','aaaaaceeeeiiiinooooouuuuyyAAAAACEEEEIIIINOOOOOUUUUY');
}
	?>
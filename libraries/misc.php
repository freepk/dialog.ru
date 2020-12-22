<?php
	function getMicroTime()
	{
		list($usec, $sec) = explode(' ', microtime());
		return ((float) $usec + (float) $sec);
	}
	function u2w($string)
	{
		return iconv('UTF-8', 'CP1251', $string);
	}
	function w2u($string)
	{
		return iconv('CP1251', 'UTF-8', $string);
	}
	function r2t($string)
	{
		$translit = array('à'=>'a','á'=>'b','â'=>'v','ã'=>'g','ä'=>'d','å'=>'e','¸'=>'jo','æ'=>'zh','ç'=>'z','è'=>'i','é'=>'j','ê'=>'k','ë'=>'l','ì'=>'m','í'=>'n','î'=>'o','ï'=>'p','ð'=>'r','ñ'=>'s','ò'=>'t','ó'=>'u','ô'=>'f','õ'=>'h','ö'=>'ts','÷'=>'ch','ø'=>'sh','ù'=>'shch','ú'=>'','û'=>'y','ü'=>'','ý'=>'e','þ'=>'yu','ÿ'=>'ya');
		$search = array_keys($translit);
		$replace = array_values($translit);
		return str_replace($search, $replace, lowercase($string));
	}
	
	$chars_lo = 'abcdefghijklmnopqrstuvwxyzàáâãäåæçèéêëìíîïðñòóôõö÷øùúûüýþÿ¸ƒº¾³¿¼šœž¢Ÿ´';
	$chars_hi = 'ABCDEFGHIJKLMNOPQRSTUVWXYZÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖ×ØÙÚÛÜÝÞß¨€ª½²¯£ŠŒŽ¡¥';
	
	function uppercase($s) { 
		global $chars_hi, $chars_lo; 
		return strtr($s, $chars_lo, $chars_hi); 
	} 

	function lowercase($s) { 
		global $chars_hi, $chars_lo; 
		return strtr($s, $chars_hi, $chars_lo); 
	}
	
	function url_title($string)
	{
		return urlencode(
			str_replace(' ', '_',
				trim(
					preg_replace('/(\W+)/', ' ', r2t($string))
				)
			)
		);
	}
?>

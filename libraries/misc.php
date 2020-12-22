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
		$translit = array('�'=>'a','�'=>'b','�'=>'v','�'=>'g','�'=>'d','�'=>'e','�'=>'jo','�'=>'zh','�'=>'z','�'=>'i','�'=>'j','�'=>'k','�'=>'l','�'=>'m','�'=>'n','�'=>'o','�'=>'p','�'=>'r','�'=>'s','�'=>'t','�'=>'u','�'=>'f','�'=>'h','�'=>'ts','�'=>'ch','�'=>'sh','�'=>'shch','�'=>'','�'=>'y','�'=>'','�'=>'e','�'=>'yu','�'=>'ya');
		$search = array_keys($translit);
		$replace = array_values($translit);
		return str_replace($search, $replace, lowercase($string));
	}
	
	$chars_lo = 'abcdefghijklmnopqrstuvwxyz�����������������������������������������������';
	$chars_hi = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ�������������������������������ߨ��������������';
	
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

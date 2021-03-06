<?php
/**
 * @package Smarty
 * @subpackage plugins
 */

/**
 * Smarty nice time format modifier plugin
 *
 * Type:     modifier<br>
 * Name:     nicetime<br>
 * Purpose:  Formats minutes into a nice humanly readable string
 * @link http://www.php.net/date
 * @param integer $minutes Minutes to convert to string
 * @param string $lang Language strings, defaults to English
 * @return string
 */
function smarty_modifier_nicetime($minutes, $lang=array("minute", "minutes", "hour", "hours", "and", "day", "days")) {
	if($minutes==1) {
		return "1 ".$lang[0];
	} elseif($minutes<60) {
		return $minutes." ".$lang[1];
	} elseif($minutes==60) {
		return "1 ".$lang[2];
	} elseif($minutes<1440) {
		$d = floor($minutes / 1440);
		$h = floor(($minutes - $d * 1440) / 60);
		$m = $minutes - ($d * 1440) - ($h * 60);
		if($h==1)
			$string = $h." ".$lang[2]." ";
		else
			$string = $h." ".$lang[3]." ";
		if($m==0)
			return $string;
		elseif($m==1)
			$string .= $lang[4]." ".$m." ".$lang[0];
		else
			$string .= $lang[4]." ".$m." ".$lang[1];
		return $string;
	} else {
		$d = floor($minutes / 1440);
		$h = floor(($minutes - $d * 1440) / 60);
		$m = $minutes - ($d * 1440) - ($h * 60);
		if($d==1)
			$string = $d." ".$lang[5];
		else
			$string = $d." ".$lang[6];
		if($h>0 && $m==0)
			$string .= " ".$lang[4]." ";
		elseif($h>0)
			$string .= ", ";
		if($h==0)
			$string .= "";
		elseif($h==1)
			$string .= $h." ".$lang[2];
		else
			$string .= $h." ".$lang[3];
		if($m==0)
			return $string;
		elseif($m==1)
			$string .= " ".$lang[4]." ".$m." ".$lang[0];
		else
			$string .= " ".$lang[4]." ".$m." ".$lang[1];
		return $string;
	}
}
?>

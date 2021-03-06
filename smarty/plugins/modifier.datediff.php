<?php
/**
 * @package Smarty
 * @subpackage plugins
 */

/**
 * Smarty date diff modifier plugin
 *
 * Type:     modifier<br>
 * Name:     datediff<br>
 * Purpose:  Returns the difference between two dates
 * @link http://gr.php.net/manual/en/datetime.diff.php
 * @param string $from From date/time
 * @param string $to To date/time
 * @param string $lang Language strings, defaults to English
 * @param boolean $minutes Return minutes instead of a string
 * @return string
 */
function smarty_modifier_datediff($from, $to, $lang=array("minute", "minutes", "hour", "hours", "and", "day", "days"), $minutes=false) {

	// From date object
	$from = new DateTime($from);
	if($from===false)
		return "";

	// To date object
	$to = new DateTime($to);
	if($to===false)
		return "";

	// Calculate the difference
	$interval = $from->diff($to);
	if($interval===false)
		return "";

	// Return minutes instead of a string
	if($minutes===true)
		return (($interval->days * 24 * 60) + ($interval->h * 60) + ($interval->i));

	// Return formatted string
	if($interval->d==0) {
		if($interval->h==1)
			$string = $interval->h." ".$lang[2]." ";
		else
			$string = $interval->h." ".$lang[3]." ";
		if($interval->i==0)
			return $string;
		elseif($interval->i==1)
			$string .= $lang[4]." ".$interval->i." ".$lang[0];
		else
			$string .= $lang[4]." ".$interval->i." ".$lang[1];
		return $string;

	} else {

		if($interval->d==1)
			$string = $interval->d." ".$lang[5];
		else
			$string = $interval->d." ".$lang[6];
		if($interval->h>0 && $interval->i==0)
			$string .= " ".$lang[4]." ";
		elseif($interval->h>0)
			$string .= " ,";
		if($interval->h==0)
			$string .= "";
		elseif($interval->h==1)
			$string .= $interval->h." ".$lang[2];
		else
			$string .= $interval->h." ".$lang[3];
		if($interval->i==0)
			return $string;
		elseif($interval->i==1)
			$string .= " ".$lang[4]." ".$interval->i." ".$lang[0];
		else
			$string .= " ".$lang[4]." ".$interval->i." ".$lang[1];
		return $string;

	}

}
?>

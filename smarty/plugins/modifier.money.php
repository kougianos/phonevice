<?php
/**
 * @package Smarty
 * @subpackage plugins
 */

/**
 * Smarty money format modifier plugin
 *
 * Type:     modifier<br>
 * Name:     money<br>
 * Purpose:  Formats a number as a currency string
 * @link http://www.php.net/money_format
 * @param float $number Number to format
 * @param string $format (default %n)
 * @return string
 */
function smarty_modifier_money($number, $format='%!.2n') {
	return money_format($format, $number);
}
?>

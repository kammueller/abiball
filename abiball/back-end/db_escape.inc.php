<?php
/**
 * DB ESCAPE
 * escapes \ ( ) ;
 * + entities ' " < >
 */
 header ('Content-type: text/html; charset=utf-8');
function esc($input) {
		$escape  = array("\r\n", "(",     ")",     "\\"   , "\"",     "'",      "<",    ">");
		$escaped = array("%nZ%", "&#40;", "&#41;", "&#92;", "&quot;", "&#039;", "&lt;", "&gt;");
	$out = str_replace($escape, $escaped, $input);
	
	return $out;
}

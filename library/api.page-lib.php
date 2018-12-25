<?php
//【需要用 include】
$indexStartWith = 0;
$index = \com\mousechsh\GlobalStatic::$var[ 'data' ][ 'index' ] * 1;
$size = \com\mousechsh\GlobalStatic::$var[ 'data' ][ 'size'  ] * 1;
if( isset( \com\mousechsh\GlobalStatic::$var[ 'query' ][ 'indexStartWith' ] ) ){
	if( \com\mousechsh\GlobalStatic::$var[ 'query' ][ 'indexStartWith' ] == 1 ){
		$indexStartWith = 1;
	}
}
$index = intval( $index );
$size = intval( $size );
if( $size < 1 ){
	$size = 1;
}
if( $size > 100 ){
	$size = 100;
}
if( $index < $indexStartWith ){
	$index = $indexStartWith;
}
$start = ( $index - $indexStartWith ) * $size;

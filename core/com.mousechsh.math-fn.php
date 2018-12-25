<?php
/***************************************************************
Math Function
======================
Canbe use for Big-Number Process
***************************************************************/
//
function MouseChsh_Math_BigIntegerNumberRadixTrans(
	$value = '',
	$sr = 10, $si = 0,
	$tr = 10, $ti = 0
){
	//
	$digits = array(
		0 => 0, 1 => 1, 2 => 2, 3 => 3, 4 => 4, 5 => 5, 6 => 6, 7 => 7, 8 => 8, 9 => 9,
		10 => 'A', 11 => 'B', 12 => 'C', 13 => 'D', 14 => 'E', 15 => 'F', 16 => 'G',
		17 => 'H', 18 => 'I', 19 => 'J', 20 => 'K', 21 => 'L', 22 => 'M', 23 => 'N',
		24 => 'O', 25 => 'P', 26 => 'Q', 27 => 'R', 28 => 'S', 29 => 'T',
		30 => 'U', 31 => 'V', 32 => 'W', 33 => 'X', 34 => 'Y', 35 => 'Z',
		36 => 'a', 37 => 'b', 38 => 'c', 39 => 'd', 40 => 'e', 41 => 'f', 42 => 'g',
		43 => 'h', 44 => 'i', 45 => 'j', 46 => 'k', 47 => 'l', 48 => 'm', 49 => 'n',
		50 => 'o', 51 => 'p', 52 => 'q', 53 => 'r', 54 => 's', 55 => 't',
		56 => 'u', 57 => 'v', 58 => 'w', 59 => 'x', 60 => 'y', 61 => 'z',
		62 => '+', 63 => '~',
		'A' => 10, 'B' => 11, 'C' => 12, 'D' => 13, 'E' => 14, 'F' => 15, 'G' => 16,
		'H' => 17, 'I' => 18, 'J' => 19, 'K' => 20, 'L' => 21, 'M' => 22, 'N' => 23,
		'O' => 24, 'P' => 25, 'Q' => 26, 'R' => 27, 'S' => 28, 'T' => 29,
		'U' => 30, 'V' => 31, 'W' => 32, 'X' => 33, 'Y' => 34, 'Z' => 35,
		'a' => 36, 'b' => 37, 'c' => 38, 'd' => 39, 'e' => 40, 'f' => 41, 'g' => 42,
		'h' => 43, 'i' => 44, 'j' => 45, 'k' => 46, 'l' => 47, 'm' => 48, 'n' => 49,
		'o' => 50, 'p' => 51, 'q' => 52, 'r' => 53, 's' => 54, 't' => 55,
		'u' => 56, 'v' => 57, 'w' => 58, 'x' => 59, 'y' => 60, 'z' => 61,
		'+' => 62, '~' => 63
	);
	//
	$minRadix = 2;
	$maxRadix = 64;
	$defRadix = 10;
	$defIndex = 0;
//	/* DEBUG POINT */ echo var_dump( $value ); echo var_dump( $sr ); echo var_dump( $si ); echo var_dump( $tr ); echo var_dump( $ti ); exit();
	// value check
	$value = strval( $value );
	if( !$value ) return '0';
	// radix & index check
	$sr = intval( $sr );
//	/* DEBUG POINT */ echo var_dump( $sr ); exit();
	if( !$sr ) $sr = $defRadix;
//	/* DEBUG POINT */ echo var_dump( $sr ); exit();
	$si = intval( $si );
	if( !$si ) $si = $defIndex;
//	/* DEBUG POINT */ echo var_dump( $minRadix ); exit();
//	/* DEBUG POINT */ echo var_dump( $sr < $minRadix || $sr > $maxRadix ); exit();
	if( $sr < $minRadix || $sr > $maxRadix ){
		$sr = $defRadix;
	}
//	/* DEBUG POINT */ echo var_dump( $sr ); exit();
	if( $si < $defIndex || $si > $maxRadix - $sr ){
		$si = $defIndex;
	}
	$tr = intval( $tr );
	if( !$tr ) $tr = $defRadix;
	$ti = intval( $ti );
	if( !$ti ) $ti = $defIndex;
	if( $tr < $minRadix || $tr > $maxRadix ){
		$tr = $defRadix;
	}
	if( $ti < $defIndex || $ti > $maxRadix - $tr ){
		$ti = $defIndex;
	}
//	/* DEBUG POINT */ echo var_dump( $value ); echo var_dump( $sr ); echo var_dump( $si ); echo var_dump( $tr ); echo var_dump( $ti ); exit();
	// trans
	$output = array();
	$nextvalue = $value;
	while( strlen( $nextvalue ) > 0 ){
	//	/* DEBUG POINT */ echo var_dump( '================' ); // exit();
		$curvalue = $nextvalue;
		$nextvalue = '';
		$nextnum = 0;
		while( strlen( $curvalue ) > 0 ){
			$letter = substr( $curvalue, 0, 1 );
			$curvalue = substr( $curvalue, 1 );
			$num = $digits[ $letter ] - $si;
			$nextnum = $nextnum * $sr + $num;
			$nextvalue .= $digits[ intval( $nextnum / $tr ) + $si ];
			$nextnum = $nextnum % $tr;
		//	/* DEBUG POINT */ echo var_dump( $letter ); echo var_dump( $curvalue ); echo var_dump( $num ); echo var_dump( $nextnum ); echo var_dump( $nextvalue ); // exit();
		//	/* DEBUG POINT */ echo var_dump( '----------------' ); // exit();
		}
		array_push( $output, $digits[ $nextnum + $ti ] );
	//	/* DEBUG POINT */ echo var_dump( "/^" . $digits[ $si ] . "+/" );
		$nextvalue = preg_replace( "/^" . $digits[ $si ] . "+/", '', $nextvalue );
	//	/* DEBUG POINT */ echo var_dump( $output ); echo var_dump( $nextvalue ); // exit();
	}
	$out = '';
	$len = sizeof( $output );
	for( $idx = $len - 1; $idx >= 0; $idx-- ){
		$out .= $output[ $idx ];
	}
	return $out;
}

<?php
/***************************************************************
UUID Generate Class
===================
Use for generate a uuid
Format 1 can be 1x 2x 4x length and add split
***************************************************************/
// namespace
namespace com\mousechsh;
// load function
require_once( 'com.mousechsh.uuid-fn.php' );
// class
class uuid{

	public static function get( $times = 1, $split = '' ){

		return MouseChsh_UUID( 0, $times, $split );

	}

	public static function getWithSplit(){

		return MouseChsh_UUID( 1 );

	}

	public static function getBase64( $times = 1, $base64ext = '_-', $trim = true ){

		return MouseChsh_UUID( 2, $times, '', $base64ext, $trim );

	}

	public static function getObjectBase64(){

		return MouseChsh_UUID( 3 );

	}

}

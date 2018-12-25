<?php
//
namespace com\mousechsh;
// load function
require_once( 'com.mousechsh.cors-fn.php' );
// class
class cors{

	public static function run( $domain = null, $header = null ){
		
		$result = MouseChsh_CORS_Do( null, $domain, $header );
		if( isset( $result ) && isset( $result[ '' ] ) && $result[ '' ] == 'OK' && isset( $result[ '@' ] ) && $result[ '@' ] ){
			return true;
		}

		return false;

	}

}

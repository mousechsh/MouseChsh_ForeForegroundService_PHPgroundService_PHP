<?php
// namespace
namespace com\mousechsh;
// load function
require_once( 'com.mousechsh.url-fn.php' );
// class
class url{

	public static function ParseString2UrlArray( $string ){

		$result = MouseChsh_Url_ParseString2UrlArray( null, $string );
		if( isset( $result ) && isset( $result[ '' ] ) && $result[ '' ] == 'OK' && isset( $result[ '@' ] ) && isset( $result[ '@' ][ 'url' ] ) ){
			return $result[ '@' ][ 'url' ];
		}

		return null;

	}
	
}

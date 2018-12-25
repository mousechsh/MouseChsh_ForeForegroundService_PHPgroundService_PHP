<?php
//
namespace com\mousechsh;
// load function
require_once( 'com.mousechsh.browser-fn.php' );
// class
class browser{

	public static function check(){

		$result = MouseChsh_Browser_Check();
		if( isset( $result ) && isset( $result[ '' ] ) && $result[ '' ] == 'OK' && isset( $result[ '@' ] ) && $result[ '@' ] ){
			return $result[ '@' ];
		}

		return null;

	}

}

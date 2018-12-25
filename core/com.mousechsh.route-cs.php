<?php
// namespace
namespace com\mousechsh;
// load function
require_once( 'com.mousechsh.route-fn.php' );
// class
class route{

	public static function check( $url, $method, $cookie ){
		
		$result = MouseChsh_Route_Check( null, $url, $method, $cookie );
		if( isset( $result ) && isset( $result[ '' ] ) && $result[ '' ] == 'OK' && isset( $result[ '@' ] ) ){
			return $result[ '@' ];
		}

		return null;

	}

}

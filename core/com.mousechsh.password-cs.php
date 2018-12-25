<?php
/***************************************************************
Password Util Class
===================
can create password and salt from a string
can check password with string, password and salt
***************************************************************/
// namespace
namespace com\mousechsh;
// load function
require_once( 'com.mousechsh.password-fn.php' );
// class
class password{

	public static function create_password( $origin, $type = 'Java-Simple' ){

		return MouseChsh_Password_Make( $origin, $type );

	}

	public static function check_password( $origin, $code, $salt, $type = 'Java-Simple' ){

		return MouseChsh_Password_Check( $origin, $code, $salt, $type );

	}

	public static function password_type(){

		return json_decode( json_encode( MouseChsh_Password_GetType() ), true );

	}

}

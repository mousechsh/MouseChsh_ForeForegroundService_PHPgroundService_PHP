<?php
//
namespace com\mousechsh;
// load function
require_once( 'com.mousechsh.loader-fn.php' );
// class
class loader{

	public static function component( $key ){

		return MouseChsh_Loader( 'component', $key, 'PHP' );

	}

	public static function config( $key ){

		return MouseChsh_Loader( 'config', $key, 'JSON' );

	}

	public static function fn( $key ){

		return MouseChsh_Loader( 'function', $key, 'PHP' );

	}

	public static function map( $key ){

		return MouseChsh_Loader( 'map', $key, 'JSON' );

	}

	public static function page( $key ){

		return MouseChsh_Loader( 'page', $key, 'PHP' );

	}

	public static function part( $key ){

		return MouseChsh_Loader( 'part', $key, 'PHP' );

	}

	public static function plugin( $key ){

		return MouseChsh_Loader( 'plugin', $key, 'PHP' );

	}

	public static function scriptp( $key ){

		return MouseChsh_Loader( 'script', $key, 'PHP' );

	}

	public static function sql( $key ){

		return MouseChsh_Loader( 'sql', $key, 'String' );

	}

	public static function stylep( $key ){

		return MouseChsh_Loader( 'style', $key, 'PHP' );

	}

	public static function view( $key ){

		return MouseChsh_Loader( 'view', $key, 'PHP' );

	}

}

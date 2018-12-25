<?php
//
namespace com\mousechsh;
// load function
require_once( 'com.mousechsh.file-fn.php' );
// class
class file{

	public static function listdir( $path ){

		$result = MouseChsh_File_ListFolder( null, $path );
		if( isset( $result ) && isset( $result[ '' ] ) && $result[ '' ] == 'OK' && isset( $result[ '@' ] ) && isset( $result[ '@' ][ 'list' ] ) ){
			return $result[ '@' ][ 'list' ];
		}

		return array();

	}

	public static function exists( $path ){

		$result = MouseChsh_File_FileExists( null, $path );
		if( isset( $result ) && isset( $result[ '' ] ) && $result[ '' ] == 'OK' && $result[ '@' ] ){
			return true;
		}

		return false;

	}

	public static function delfile( $path ){

		$result = MouseChsh_File_RemoveFile( null, $path );
		if( isset( $result ) && isset( $result[ '' ] ) && $result[ '' ] == 'OK' && $result[ '@' ] ){
			return true;
		}

		return false;

	}

	public static function rmdir( $path ){

		$result = MouseChsh_File_RemoveFolder( null, $path );
		if( isset( $result ) && isset( $result[ '' ] ) && $result[ '' ] == 'OK' && $result[ '@' ] ){
			return true;
		}

		return false;

	}

}

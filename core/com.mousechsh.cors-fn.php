<?php

function MouseChsh_CORS_Do( $obj, $domain = null, $header = null ){

	if( isset( $obj ) && isset( $obj[ '@' ] ) && isset( $obj[ '@' ][ 'domain' ] ) ){
		$domain = $obj[ '@' ][ 'domain' ];
	}
	if( isset( $obj ) && isset( $obj[ '@' ] ) && isset( $obj[ '@' ][ 'header' ] ) ){
		$header = $obj[ '@' ][ 'header' ];
	}
	if( !isset( $domain ) ){
		return array(
			''       => 'Fault',
			'type'   => 'CORS',
			'action' => 'Do'
		);
	}
	header( "Access-Control-Allow-Origin: {$domain}" );
	header( 'Access-Control-Allow-Credentials: true' );
	header( 'Access-Control-Max-Age: 86400' );
	if( $_SERVER[ 'REQUEST_METHOD' ] == 'OPTIONS' ){
		if( isset( $_SERVER[ 'HTTP_ACCESS_CONTROL_REQUEST_METHOD' ] ) )
			header( "Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS" );
		if( isset( $_SERVER[ 'HTTP_ACCESS_CONTROL_REQUEST_HEADERS' ] ) )
			header( "Access-Control-Allow-Headers: {$header}" );
		return array(
			''       => 'OK',
			'type'   => 'CORS',
			'action' => 'Do',
			'@'      => true
		);
	}

	return array(
		''       => 'OK',
		'type'   => 'CORS',
		'action' => 'Do',
		'@'      => false
	);

}

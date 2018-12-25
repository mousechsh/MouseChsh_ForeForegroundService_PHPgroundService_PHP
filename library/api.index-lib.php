<?php
//【需要用 include】
\com\mousechsh\GlobalConfig::$UseCache = false;
if( isset( $json ) ){
	if( isset( $json[ 'CorsDomain' ] ) ){
		\com\mousechsh\GlobalStatic::$cors[ 'domain' ] = $json[ 'CorsDomain' ];
	}
	if( isset( $json[ 'CorsHeader' ] ) ){
		\com\mousechsh\GlobalStatic::$cors[ 'header' ] = $json[ 'CorsHeader' ];
	}
}
$url = array(
	'url' => false,
	'query' => array()
);
foreach( $_GET as $key => $value ){
	if( $key == '_' ){
		$url[ 'url' ] = $value;
		$url[ 'url' ] = preg_replace( '/^\//', '', $url[ 'url' ] );
	}else{
		$url[ 'query' ][ $key ] = $value;
	}
}
\com\mousechsh\GlobalStatic::$var[ 'url' ] = $url;
// /* DEBUG POINT */ echo var_dump( $url ); exit();
if( isset( $url[ 'url' ] ) && $url[ 'url' ] ){
	$urlstring = '/' . $url[ 'url' ];
	$data = \com\mousechsh\route::check( $urlstring, $_SERVER[ 'REQUEST_METHOD' ], $_COOKIE );
//	/* DEBUG POINT */ echo var_dump( $data ); exit();
	if( isset( $data ) && isset( $data[ 'route' ] ) && isset( $data[ 'data' ] ) && isset( $data[ 'cookie' ] ) ){
		\com\mousechsh\GlobalStatic::$var[ 'data'   ] = $data[ 'data'   ];
		\com\mousechsh\GlobalStatic::$var[ 'cookie' ] = $data[ 'cookie' ];
		\com\mousechsh\GlobalStatic::$var[ 'query'  ] = $url [ 'query'  ];
		require_once( \com\mousechsh\GlobalStatic::$apppath_action . DIRECTORY_SEPARATOR . $data[ 'route' ] );
	}else{
		header( 'HTTP/1.0 404 Not Found' );
		header( 'Content-Type: application/json; charset=UTF-8' );
		echo json_encode( array(
			'Error' => 'HTTP404'
		) );
	}
}else{
	header( 'HTTP/1.0 404 Not Found' );
	header( 'Content-Type: application/json; charset=UTF-8' );
	echo json_encode( array(
		'Error' => 'HTTP404'
	) );
}

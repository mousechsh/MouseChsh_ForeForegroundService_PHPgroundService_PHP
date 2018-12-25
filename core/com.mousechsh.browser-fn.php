<?php

function MouseChsh_Browser_Check(){

	$res = array(
		'type'    => 'unknown',
		'os'      => '',
		'browser' => '',
		'kernel'  => '',
		'device'  => '',
		'version' => ''
	);
	if( empty( $_SERVER[ 'HTTP_USER_AGENT' ] ) ){
		return $res;
	}
	if( false === stripos( $_SERVER[ 'HTTP_USER_AGENT' ], 'Mobile' ) ){
		$res[ 'type' ] = 'desktop';
	}else{
		$res[ 'type' ] = 'mobile';
	}
	if( false !== stripos( $_SERVER[ 'HTTP_USER_AGENT' ], 'MSIE 9.0' ) ){
		$res[ 'browser' ] = 'Internet Explorer';
		$res[ 'version' ] = '9.0';
	}else if( false !== stripos( $_SERVER[ 'HTTP_USER_AGENT' ], 'MSIE 8.0' ) ){
		$res[ 'browser' ] = 'Internet Explorer';
		$res[ 'version' ] = '8.0';
	}else if( false !== stripos( $_SERVER[ 'HTTP_USER_AGENT' ], 'MSIE 7.0' ) ){
		$res[ 'browser' ] = 'Internet Explorer';
		$res[ 'version' ] = '7.0';
	}else if( false !== stripos( $_SERVER[ 'HTTP_USER_AGENT' ], 'MSIE 6.0' ) ){
		$res[ 'browser' ] = 'Internet Explorer';
		$res[ 'version' ] = '6.0';
	}else if( false !== stripos( $_SERVER[ 'HTTP_USER_AGENT' ], 'Firefox' ) ){
		$res[ 'browser' ] = 'Mozilla Firefox';
	}else if( false !== stripos( $_SERVER[ 'HTTP_USER_AGENT' ], 'Chrome' ) ){
		$res[ 'browser' ] = 'Google Chrome';
	}else if( false !== stripos( $_SERVER[ 'HTTP_USER_AGENT' ], 'Safari' ) ){
		$res[ 'browser' ] = 'Safari';
	}else if( false !== stripos( $_SERVER[ 'HTTP_USER_AGENT' ], 'Opera' ) ){
		$res[ 'browser' ] = 'Opera';
	}else if( false !== stripos( $_SERVER[ 'HTTP_USER_AGENT' ], '360SE' ) ){
		$res[ 'browser' ] = '360SE';
	}
	if( false !== stripos( $_SERVER[ 'HTTP_USER_AGENT' ], 'Trident' ) ){
		$res[ 'kernel' ] = 'Trident';
	}else if( false !== stripos( $_SERVER[ 'HTTP_USER_AGENT' ], 'Presto' ) ){
		$res[ 'kernel' ] = 'Presto';
	}else if( false !== stripos( $_SERVER[ 'HTTP_USER_AGENT' ], 'AppleWebKit' ) ){
		$res[ 'kernel' ] = 'WebKit';
	}else if( false !== stripos( $_SERVER[ 'HTTP_USER_AGENT' ], 'Gecko' ) ){
		$res[ 'kernel' ] = 'Gecko';
	}

	return array(
		'' =>  'OK',
		'@' => $res
	);

}

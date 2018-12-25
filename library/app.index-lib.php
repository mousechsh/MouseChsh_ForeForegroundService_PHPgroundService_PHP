<?php
//【需要用 include】
\com\mousechsh\GlobalConfig::$UseCors             = false;
\com\mousechsh\GlobalConfig::$UseCache            = true;
\com\mousechsh\GlobalConfig::$HeaderCache         = 'public';
\com\mousechsh\GlobalConfig::$HeaderETag          = true;
\com\mousechsh\GlobalConfig::$HeaderLastModified  = true;
\com\mousechsh\GlobalStatic::$cache_cachelongtime = 86400;

$url = array();
foreach( $_GET as $key => $value ){
	if( $key == '_' ){
		$url[ 'url' ] = $value;
		$url[ 'url' ] = preg_replace( '/^\//', '', $url[ 'url' ] );
	}else{
		$url[ 'query' ][ $key ] = $value;
	}
}
if( !isset( $url[ 'url' ] ) || $url[ 'url' ] == '' ){
	$url[ 'url' ] = 'index';
}
$url[ 'url' ] = preg_replace( '/\.[A-Za-z0-9]*[?]?$/', '', $url[ 'url' ] );
$cahce_key = 'app:' . sha1( json_encode( $url ) . json_encode( $_COOKIE ) );
//
$browser = \com\mousechsh\browser::check();
if( $browser == null ){
	if( isset( $cache ) ){
		$cache_content = $cache -> get( $cahce_key );
		if( $cache_content ){
			echo $cache_content;
			return;
		}
	}
	$pagecontent = \com\mousechsh\loader::page( 'default' );
	$ctt = \com\mousechsh\loader::view( $url[ 'url' ] );
	if( !$ctt ){
		$tmp_url = explode( '/', $url[ 'url' ] );
		$ctt = \com\mousechsh\loader::view( $tmp_url[ 0 ] );
		if( $ctt ){
			$url[ 'url' ] = $tmp_url[ 0 ];
			array_shift( $tmp_url );
			$url[ 'query' ][ '_' ] = $tmp_url;
		}else{
			$ctt = \com\mousechsh\loader::view( 'index' );
		}
	}
	$pagecontent = str_replace( '{{view|Content}}', $ctt, $pagecontent );
}else if( $browser[ 'type' ] == 'mobile' ){
	if( isset( $cache ) ){
		$cache_content = $cache -> get( $cahce_key . '@mobile' );
		if( $cache_content ){
			echo $cache_content;
			return;
		}
	}
	$pagecontent = \com\mousechsh\loader::page( 'mobile' );
	if( !$pagecontent ){
		$pagecontent = \com\mousechsh\loader::page( 'default' );
	}
	$ctt = \com\mousechsh\loader::view( $url[ 'url' ] . '.mobile' );
	if( !$ctt ){
		$tmp_url = explode( '/', $url[ 'url' ] );
		$ctt = \com\mousechsh\loader::view( $tmp_url[ 0 ] . '.mobile' );
		if( $ctt ){
			$url[ 'url' ] = $tmp_url[ 0 ];
			array_shift( $tmp_url );
			$url[ 'query' ][ '_' ] = $tmp_url;
		}else{
			$ctt = \com\mousechsh\loader::view( 'index.mobile' );
			if( !$ctt ){
				$ctt = \com\mousechsh\loader::view( $url[ 'url' ] );
				if( !$ctt ){
					$tmp_url = explode( '/', $url[ 'url' ] );
					$ctt = \com\mousechsh\loader::view( $tmp_url[ 0 ] );
					if( $ctt ){
						$url[ 'url' ] = $tmp_url[ 0 ];
						array_shift( $tmp_url );
						$url[ 'query' ][ '_' ] = $tmp_url;
					}else{
						$ctt = \com\mousechsh\loader::view( 'index' );
					}
				}
			}
		}
	}
	$pagecontent = str_replace( '{{view|Content}}', $ctt, $pagecontent );
}else{
	if( isset( $cache ) ){
		$cache_content = $cache -> get( $cahce_key . '@desktop' );
		if( $cache_content ){
			echo $cache_content;
			return;
		}
	}
	$pagecontent = \com\mousechsh\loader::page( 'desktop' );
	if( !$pagecontent ){
		$pagecontent = \com\mousechsh\loader::page( 'default' );
	}
	$ctt = \com\mousechsh\loader::view( $url[ 'url' ] . '.desktop' );
	if( !$ctt ){
		$tmp_url = explode( '/', $url[ 'url' ] );
		$ctt = \com\mousechsh\loader::view( $tmp_url[ 0 ] . '.desktop' );
		if( $ctt ){
			$url[ 'url' ] = $tmp_url[ 0 ];
			array_shift( $tmp_url );
			$url[ 'query' ][ '_' ] = $tmp_url;
		}else{
			$ctt = \com\mousechsh\loader::view( 'index.desktop' );
			if( !$ctt ){
				$ctt = \com\mousechsh\loader::view( $url[ 'url' ] );
				if( !$ctt ){
					$tmp_url = explode( '/', $url[ 'url' ] );
					$ctt = \com\mousechsh\loader::view( $tmp_url[ 0 ] );
					if( $ctt ){
						$url[ 'url' ] = $tmp_url[ 0 ];
						array_shift( $tmp_url );
						$url[ 'query' ][ '_' ] = $tmp_url;
					}else{
						$ctt = \com\mousechsh\loader::view( 'index' );
					}
				}
			}
		}
	}
	$pagecontent = str_replace( '{{view|Content}}', $ctt, $pagecontent );
}
//
while( preg_match( '/\{\{part\|([_0-9A-Z-]+)\}\}/i', $pagecontent ) ){
	$pagecontent = preg_replace_callback( '/\{\{part\|([_0-9A-Z-]+)\}\}/i', function( $matches ){

		if( isset( $matches[ 1 ] ) ){
			return \com\mousechsh\loader::part( $matches[ 1 ] );
		}

		return '';

	}, $pagecontent );
}
//
$g_style = '';
foreach( \com\mousechsh\GlobalStatic::$style as $value ){
	$g_style .= $value . "\r\n";
}
$pagecontent = str_replace( '{{style|List}}', $g_style, $pagecontent );
//
$g_script = '';
foreach( \com\mousechsh\GlobalStatic::$script as $value ){
	$g_script .= $value . "\r\n";
}
$pagecontent = str_replace( '{{script|List}}', $g_script, $pagecontent );
//
\com\mousechsh\GlobalStatic::$var[ 'url' ] = $url;
//
$fn = null;
if( $browser == null ){
	$fn = \com\mousechsh\loader::component( $url[ 'url' ] );
}else if( $browser[ 'type' ] == 'mobile' ){
	$fn = \com\mousechsh\loader::component( $url[ 'url' ] . '.mobile' );
}else{
	$fn = \com\mousechsh\loader::component( $url[ 'url' ] . '.desktop' );
}
if( $fn ){
	$pagecontent = $fn( $pagecontent );
}else{
	$fn = \com\mousechsh\loader::component( 'index' );
	if( $fn ){
		$pagecontent = $fn( $pagecontent );
	}
}
$pagecontent = '<!-- { Date: ' . date( 'Y-m-d D H:i:sO' ) . ' } -->' . "\r\n" . $pagecontent;
echo $pagecontent;
if( $browser == null ){
	if( isset( $cache ) ){
		$cache -> set( $cahce_key, $pagecontent );
		$cache -> expire( $cahce_key, $cache_ttl );
	}
}else if( $browser[ 'type' ] == 'mobile' ){
	if( isset( $cache ) ){
		$cache -> set( $cahce_key . '@mobile', $pagecontent );
		$cache -> expire( $cahce_key . '@mobile', $cache_ttl );
	}
}else{
	if( isset( $cache ) ){
		$cache -> set( $cahce_key . '@desktop', $pagecontent );
		$cache -> expire( $cahce_key . '@desktop', $cache_ttl );
	}
}

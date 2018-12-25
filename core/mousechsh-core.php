<?php
/***************************************************************
Core Enter
================
To load core code, init to common environment
***************************************************************/
// Global
global $entry;
// Set Default TimeZone
date_default_timezone_set( 'UTC' );
// Load core: Global
require_once( 'com.mousechsh.global-conf.php'    );
// Do check
require_once( 'com.mousechsh.check-cd.php'       );
// Enable log
require_once( 'com.mousechsh.log-cs.php'         );
// Load core: ErrorProcess
require_once( 'com.mousechsh.error-conf.php'     );
// Load core: Browser
require_once( 'com.mousechsh.browser-cs.php'     );
// Load core: CORS
require_once( 'com.mousechsh.cors-cs.php'        );
// Load core: File
require_once( 'com.mousechsh.file-cs.php'        );
// Load core: Math
require_once( 'com.mousechsh.math-cs.php'        );
// Load core: UUID
require_once( 'com.mousechsh.uuid-cs.php'        );
// Load core: Database
require_once( 'com.mousechsh.database_rw-cs.php' );
// Load core: SMTP Mail
require_once( 'com.mousechsh.smtp-cs.php'        );
// Load core: Loader
require_once( 'com.mousechsh.loader-cs.php'      );
// Load core: Password
require_once( 'com.mousechsh.password-cs.php'    );
// Load core: Url
require_once( 'com.mousechsh.url-cs.php'         );
// Load core: Route
require_once( 'com.mousechsh.route-cs.php'       );
// start output
ob_start();
// output version
$versionfilepath = dirname( __FILE__ ) . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'version.txt';
if( file_exists( $versionfilepath ) ){
	$versioncontent = file_get_contents( $versionfilepath );
	$versioncontent = trim( $versioncontent );
	header( 'X-Version: ' . $versioncontent );
}
// start
if( file_exists( \com\mousechsh\GlobalStatic::$apppath ) ){
	require_once( \com\mousechsh\GlobalStatic::$apppath );
}else{
	require_once( 'com.mousechsh.404-pg.php' );
}
// end output
$output = ob_get_contents();
if( \com\mousechsh\GlobalConfig::$HeaderContentLength === true ){
	header( 'Content-Length: ' . strlen( $output ) );
}else if( \com\mousechsh\GlobalConfig::$HeaderContentLength === false ){
	;
}else{
	header( 'Content-Length: ' . strlen( $output ) );
}
// 主开关 \com\mousechsh\GlobalConfig::$UseCache
// 下面的子开关 \com\mousechsh\GlobalConfig::$HeaderCache
// 下面的子开关的参数变量 \com\mousechsh\GlobalStatic::$cache_cachelongtime
// 下面的子开关 \com\mousechsh\GlobalConfig::$HeaderETag
// 下面的子开关 \com\mousechsh\GlobalConfig::$HeaderLastModified
if( \com\mousechsh\GlobalConfig::$UseCache === true ){
	if( \com\mousechsh\GlobalConfig::$HeaderCache === 'public' ){
		if( \com\mousechsh\GlobalStatic::$cache_cachelongtime ){
			header( 'Cache-Control: public, max-age=' . \com\mousechsh\GlobalStatic::$cache_cachelongtime );
		}else{
			header( 'Cache-Control: public' );
		}
	}else if( \com\mousechsh\GlobalConfig::$HeaderCache === 'private' ){
		if( \com\mousechsh\GlobalStatic::$cache_cachelongtime ){
			header( 'Cache-Control: private, max-age=' . \com\mousechsh\GlobalStatic::$cache_cachelongtime );
		}else{
			header( 'Cache-Control: private' );
		}
	}else if( \com\mousechsh\GlobalConfig::$HeaderCache === 'no-cache' ){
		header( 'Cache-Control: no-cache' );
	}else{
		header( 'Cache-Control: no-cache' );
	}
	if( \com\mousechsh\GlobalConfig::$HeaderETag === true ){
		$sha1 = sha1( $output );
		if( isset( $_SERVER[ 'HTTP_IF_NONE_MATCH' ] ) &&  $_SERVER[ 'HTTP_IF_NONE_MATCH' ] == $sha1 ){
			ob_clean();
			header( 'HTTP/1.1 304 Not Modified' );
			header( 'Content-Length: 0' );
		}else{
			header( 'ETag: ' . $sha1 );
		}
	}else if( \com\mousechsh\GlobalConfig::$HeaderETag === false ){
		;
	}else{
		;
	}
	if( \com\mousechsh\GlobalConfig::$HeaderLastModified === true ){
		if( \com\mousechsh\GlobalStatic::$cache_lastmodified ){
			header( 'Last-Modified: ' . \com\mousechsh\GlobalStatic::$cache_lastmodified );
		}
	}else if( \com\mousechsh\GlobalConfig::$HeaderLastModified === false ){
		;
	}else{
		;
	}
}else if( \com\mousechsh\GlobalConfig::$UseCache === false ){
	;
}else{
	;
}
// 主开关 \com\mousechsh\GlobalConfig::$UseCors
// 主开关的参数变量 \com\mousechsh\GlobalStatic::$cors[ 'domain' ]
if( \com\mousechsh\GlobalConfig::$UseCors === true ){
	if( \com\mousechsh\cors::run(
		( isset( \com\mousechsh\GlobalStatic::$cors[ 'domain' ] )
			? \com\mousechsh\GlobalStatic::$cors[ 'domain' ]
			: \com\mousechsh\GlobalStatic::$domain ),
		( isset( \com\mousechsh\GlobalStatic::$cors[ 'header' ] )
			? \com\mousechsh\GlobalStatic::$cors[ 'header' ]
			: null )
	) ){
		ob_clean();
		header( 'Content-Length: 0' );
	}
}else if( \com\mousechsh\GlobalConfig::$UseCors === false ){
	;
}else{
	;
}
// 主开关 \com\mousechsh\GlobalConfig::$UseLog
if( \com\mousechsh\GlobalConfig::$UseLog === true ){

}else if( \com\mousechsh\GlobalConfig::$UseLog === false ){
	;
}else{
	;
}

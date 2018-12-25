<?php
/***************************************************************
Global Static Variable and Default Global Config
================================================
Instead for global variable
The global variable is just only $entry
Other gobal variable is here as a Class Static Property
------------------------------------------------
Default \com\mousechsh\GlobalConfig
***************************************************************/
//
namespace com\mousechsh;
// 入口
global $entry;
// 全是变量，不能使用全局变量，需要全局使用的变量都在这里
class GlobalStatic{
	// Current APP Name
	public static $appname                  = '';
	// Common Path
	public static $commonpath_action        = '';
	public static $commonpath_component     = '';
	public static $commonpath_config        = '';
	public static $commonpath_file          = '';
	public static $commonpath_function      = '';
	public static $commonpath_map           = '';
	public static $commonpath_page          = '';
	public static $commonpath_part          = '';
	public static $commonpath_plugin        = '';
	public static $commonpath_sql           = '';
	public static $commonpath_view          = '';
	// Current APP Path
	public static $apppath                  = '';
	public static $apppath_action           = '';
	public static $apppath_code             = '';
	public static $apppath_component        = '';
	public static $apppath_config           = '';
	public static $apppath_file             = '';
	public static $apppath_function         = '';
	public static $apppath_map              = '';
	public static $apppath_page             = '';
	public static $apppath_part             = '';
	public static $apppath_plugin           = '';
	public static $apppath_sql              = '';
	public static $apppath_view             = '';
	// 3rt Path
	public static $path_3rt                 = '';
	// Admin Path
	public static $path_admin               = '';
	// Cache Path
	public static $path_cache               = '';
	// Core Path
	public static $path_core                = '';
	// Data Path
	public static $path_data                = '';
	// Export Path
	public static $path_export              = '';
	// Font Path
	public static $path_font                = '';
	// Image Path
	public static $path_image               = '';
	// Import Path
	public static $path_import              = '';
	// Library Path
	public static $path_library             = '';
	// Log Path
	public static $path_log                 = '';
	// Mail Path
	public static $path_mail                = '';
	// Media Path
	public static $path_media               = '';
	// Script Path
	public static $path_script              = '';
	// Search Path
	public static $path_search              = '';
	// Style Path
	public static $path_style               = '';
	// Temporary Path
	public static $path_tmp                 = '';
	// Core files
	public static $rootfiles                = array();
	// Global Action Variables
	public static $action                   = array();
	// Global Cache Variables
	public static $cache                    = array();
	// Global Cache Last Modified
	public static $cache_lastmodified       = '';
	// Global Cache how long seconds
	public static $cache_cachelongtime      = 0;
	// Global Component Variables
	public static $component                = array();
	// Global Config Variables
	public static $config                   = array();
	// Global CORS Variables
	public static $cors                     = array();
	// Global Data Variables
	public static $data                     = array();
	// Global Domain
	public static $domain                   = 'mousechsh.com';
	// Global Entity Variables
	public static $entity                   = array();
	// Global Function Variables
	public static $fn                       = array();
	// Global Library Variables
	public static $library                  = array();
	// Global Language Variables
	public static $lng                      = array();
	// Global Language Code
	public static $lngcode                  = '_';
	// Global Map Variables
	public static $map                      = array();
	// Global Model Variables
	public static $model                    = array();
	// Global Page Variables
	public static $page                     = array();
	// Global Part Variables
	public static $part                     = array();
	// Global Plugin Variables
	public static $plugin                   = array();
	// Global Website TrueRoot Path
	public static $rootpath                 = '';
	// Global Website Current Route
	public static $route                    = '';
	// Global Script Variables
	public static $script                   = array();
	// Global SQL Text Variables
	public static $sql                      = array();
	// Global Style Variables
	public static $style                    = array();
	// Global Other Variables
	public static $var                      = array();
	// Global View Variables
	public static $view                     = array();
}
// 全是配置，配置只能使用固定的值，这里的值都是默认值
class GlobalConfig{
	// Runtime := 'debug' | 'release' | 'testing' | '';
	// debug - 本地调试
	// testing - 本地运行
	// release - 正式运行
	public static $Runtime                  = 'debug';

	// DetailErrorMessage := true | false;
	public static $DetailErrorMessage       = true;

	// Header Content-Length := true | false
	public static $HeaderContentLength      = true;

	// UseCache := true | false;
	public static $UseCache                 = false;
		// Header Cache := no-cache | private | public
		public static $HeaderCache          = 'no-cache';
		// Header E-Tag := true | false
		public static $HeaderETag           = false;
		// Header Last-Modified
		public static $HeaderLastModified   = false;

	// UseCors := true | false;
	public static $UseCors                  = false;

	// UseLog := true | false;
	public static $UseLog                   = false;
}
\com\mousechsh\GlobalStatic::$appname              = $entry;
\com\mousechsh\GlobalStatic::$rootpath             = dirname( __FILE__ )                    . DIRECTORY_SEPARATOR . '..';
\com\mousechsh\GlobalStatic::$commonpath_action    = \com\mousechsh\GlobalStatic::$rootpath . DIRECTORY_SEPARATOR . 'common' . DIRECTORY_SEPARATOR . 'action';
\com\mousechsh\GlobalStatic::$commonpath_component = \com\mousechsh\GlobalStatic::$rootpath . DIRECTORY_SEPARATOR . 'common' . DIRECTORY_SEPARATOR . 'component';
\com\mousechsh\GlobalStatic::$commonpath_config    = \com\mousechsh\GlobalStatic::$rootpath . DIRECTORY_SEPARATOR . 'common' . DIRECTORY_SEPARATOR . 'config';
\com\mousechsh\GlobalStatic::$commonpath_file      = \com\mousechsh\GlobalStatic::$rootpath . DIRECTORY_SEPARATOR . 'common' . DIRECTORY_SEPARATOR . 'file';
\com\mousechsh\GlobalStatic::$commonpath_function  = \com\mousechsh\GlobalStatic::$rootpath . DIRECTORY_SEPARATOR . 'common' . DIRECTORY_SEPARATOR . 'function';
\com\mousechsh\GlobalStatic::$commonpath_map       = \com\mousechsh\GlobalStatic::$rootpath . DIRECTORY_SEPARATOR . 'common' . DIRECTORY_SEPARATOR . 'map';
\com\mousechsh\GlobalStatic::$commonpath_page      = \com\mousechsh\GlobalStatic::$rootpath . DIRECTORY_SEPARATOR . 'common' . DIRECTORY_SEPARATOR . 'page';
\com\mousechsh\GlobalStatic::$commonpath_part      = \com\mousechsh\GlobalStatic::$rootpath . DIRECTORY_SEPARATOR . 'common' . DIRECTORY_SEPARATOR . 'part';
\com\mousechsh\GlobalStatic::$commonpath_plugin    = \com\mousechsh\GlobalStatic::$rootpath . DIRECTORY_SEPARATOR . 'common' . DIRECTORY_SEPARATOR . 'plugin';
\com\mousechsh\GlobalStatic::$commonpath_sql       = \com\mousechsh\GlobalStatic::$rootpath . DIRECTORY_SEPARATOR . 'common' . DIRECTORY_SEPARATOR . 'sql';
\com\mousechsh\GlobalStatic::$commonpath_view      = \com\mousechsh\GlobalStatic::$rootpath . DIRECTORY_SEPARATOR . 'common' . DIRECTORY_SEPARATOR . 'view';
\com\mousechsh\GlobalStatic::$apppath              = \com\mousechsh\GlobalStatic::$rootpath . DIRECTORY_SEPARATOR . $entry   . DIRECTORY_SEPARATOR . 'index-idx.php';
\com\mousechsh\GlobalStatic::$apppath_action       = \com\mousechsh\GlobalStatic::$rootpath . DIRECTORY_SEPARATOR . $entry   . DIRECTORY_SEPARATOR . 'action';
\com\mousechsh\GlobalStatic::$apppath_code         = \com\mousechsh\GlobalStatic::$rootpath . DIRECTORY_SEPARATOR . $entry   . DIRECTORY_SEPARATOR . 'code';
\com\mousechsh\GlobalStatic::$apppath_component    = \com\mousechsh\GlobalStatic::$rootpath . DIRECTORY_SEPARATOR . $entry   . DIRECTORY_SEPARATOR . 'component';
\com\mousechsh\GlobalStatic::$apppath_config       = \com\mousechsh\GlobalStatic::$rootpath . DIRECTORY_SEPARATOR . $entry   . DIRECTORY_SEPARATOR . 'config';
\com\mousechsh\GlobalStatic::$apppath_file         = \com\mousechsh\GlobalStatic::$rootpath . DIRECTORY_SEPARATOR . $entry   . DIRECTORY_SEPARATOR . 'file';
\com\mousechsh\GlobalStatic::$apppath_function     = \com\mousechsh\GlobalStatic::$rootpath . DIRECTORY_SEPARATOR . $entry   . DIRECTORY_SEPARATOR . 'function';
\com\mousechsh\GlobalStatic::$apppath_map          = \com\mousechsh\GlobalStatic::$rootpath . DIRECTORY_SEPARATOR . $entry   . DIRECTORY_SEPARATOR . 'map';
\com\mousechsh\GlobalStatic::$apppath_page         = \com\mousechsh\GlobalStatic::$rootpath . DIRECTORY_SEPARATOR . $entry   . DIRECTORY_SEPARATOR . 'page';
\com\mousechsh\GlobalStatic::$apppath_part         = \com\mousechsh\GlobalStatic::$rootpath . DIRECTORY_SEPARATOR . $entry   . DIRECTORY_SEPARATOR . 'part';
\com\mousechsh\GlobalStatic::$apppath_plugin       = \com\mousechsh\GlobalStatic::$rootpath . DIRECTORY_SEPARATOR . $entry   . DIRECTORY_SEPARATOR . 'plugin';
\com\mousechsh\GlobalStatic::$apppath_sql          = \com\mousechsh\GlobalStatic::$rootpath . DIRECTORY_SEPARATOR . $entry   . DIRECTORY_SEPARATOR . 'sql';
\com\mousechsh\GlobalStatic::$apppath_view         = \com\mousechsh\GlobalStatic::$rootpath . DIRECTORY_SEPARATOR . $entry   . DIRECTORY_SEPARATOR . 'view';
\com\mousechsh\GlobalStatic::$path_3rt             = \com\mousechsh\GlobalStatic::$rootpath . DIRECTORY_SEPARATOR . '3rt';
\com\mousechsh\GlobalStatic::$path_admin           = \com\mousechsh\GlobalStatic::$rootpath . DIRECTORY_SEPARATOR . 'admin';
\com\mousechsh\GlobalStatic::$path_cache           = \com\mousechsh\GlobalStatic::$rootpath . DIRECTORY_SEPARATOR . 'cache';
\com\mousechsh\GlobalStatic::$path_core            = \com\mousechsh\GlobalStatic::$rootpath . DIRECTORY_SEPARATOR . 'core';
\com\mousechsh\GlobalStatic::$path_data            = \com\mousechsh\GlobalStatic::$rootpath . DIRECTORY_SEPARATOR . 'data';
\com\mousechsh\GlobalStatic::$path_export          = \com\mousechsh\GlobalStatic::$rootpath . DIRECTORY_SEPARATOR . 'export';
\com\mousechsh\GlobalStatic::$path_font            = \com\mousechsh\GlobalStatic::$rootpath . DIRECTORY_SEPARATOR . 'font';
\com\mousechsh\GlobalStatic::$path_image           = \com\mousechsh\GlobalStatic::$rootpath . DIRECTORY_SEPARATOR . 'image';
\com\mousechsh\GlobalStatic::$path_import          = \com\mousechsh\GlobalStatic::$rootpath . DIRECTORY_SEPARATOR . 'import';
\com\mousechsh\GlobalStatic::$path_library         = \com\mousechsh\GlobalStatic::$rootpath . DIRECTORY_SEPARATOR . 'library';
\com\mousechsh\GlobalStatic::$path_log             = \com\mousechsh\GlobalStatic::$rootpath . DIRECTORY_SEPARATOR . 'log';
\com\mousechsh\GlobalStatic::$path_mail            = \com\mousechsh\GlobalStatic::$rootpath . DIRECTORY_SEPARATOR . 'mail';
\com\mousechsh\GlobalStatic::$path_media           = \com\mousechsh\GlobalStatic::$rootpath . DIRECTORY_SEPARATOR . 'media';
\com\mousechsh\GlobalStatic::$path_script          = \com\mousechsh\GlobalStatic::$rootpath . DIRECTORY_SEPARATOR . 'script';
\com\mousechsh\GlobalStatic::$path_search          = \com\mousechsh\GlobalStatic::$rootpath . DIRECTORY_SEPARATOR . 'search';
\com\mousechsh\GlobalStatic::$path_style           = \com\mousechsh\GlobalStatic::$rootpath . DIRECTORY_SEPARATOR . 'style';
\com\mousechsh\GlobalStatic::$path_tmp             = \com\mousechsh\GlobalStatic::$rootpath . DIRECTORY_SEPARATOR . 'temp';
array_push( \com\mousechsh\GlobalStatic::$rootfiles, 'mousechsh-core.php' );
array_push( \com\mousechsh\GlobalStatic::$rootfiles, 'com.mousechsh.404-pg.php' );
array_push( \com\mousechsh\GlobalStatic::$rootfiles, 'com.mousechsh.500-pg.php' );
array_push( \com\mousechsh\GlobalStatic::$rootfiles, 'com.mousechsh.browser-cs.php' );
array_push( \com\mousechsh\GlobalStatic::$rootfiles, 'com.mousechsh.browser-fn.php' );
array_push( \com\mousechsh\GlobalStatic::$rootfiles, 'com.mousechsh.buffer-cs.php' );
array_push( \com\mousechsh\GlobalStatic::$rootfiles, 'com.mousechsh.buffer-fn.php' );
array_push( \com\mousechsh\GlobalStatic::$rootfiles, 'com.mousechsh.cache-cs.php' );
array_push( \com\mousechsh\GlobalStatic::$rootfiles, 'com.mousechsh.cache-fn.php' );
array_push( \com\mousechsh\GlobalStatic::$rootfiles, 'com.mousechsh.check-cd.php' );
array_push( \com\mousechsh\GlobalStatic::$rootfiles, 'com.mousechsh.cors-cs.php' );
array_push( \com\mousechsh\GlobalStatic::$rootfiles, 'com.mousechsh.cors-fn.php' );
array_push( \com\mousechsh\GlobalStatic::$rootfiles, 'com.mousechsh.database_rw-cs.php' );
array_push( \com\mousechsh\GlobalStatic::$rootfiles, 'com.mousechsh.database-cs.php' );
array_push( \com\mousechsh\GlobalStatic::$rootfiles, 'com.mousechsh.database-fn.php' );
array_push( \com\mousechsh\GlobalStatic::$rootfiles, 'com.mousechsh.error-conf.php' );
array_push( \com\mousechsh\GlobalStatic::$rootfiles, 'com.mousechsh.file-cs.php' );
array_push( \com\mousechsh\GlobalStatic::$rootfiles, 'com.mousechsh.file-fn.php' );
array_push( \com\mousechsh\GlobalStatic::$rootfiles, 'com.mousechsh.global-conf.php' );
array_push( \com\mousechsh\GlobalStatic::$rootfiles, 'com.mousechsh.loader-cs.php' );
array_push( \com\mousechsh\GlobalStatic::$rootfiles, 'com.mousechsh.loader-fn.php' );
array_push( \com\mousechsh\GlobalStatic::$rootfiles, 'com.mousechsh.log-cs.php' );
array_push( \com\mousechsh\GlobalStatic::$rootfiles, 'com.mousechsh.math-cs.php' );
array_push( \com\mousechsh\GlobalStatic::$rootfiles, 'com.mousechsh.math-fn.php' );
array_push( \com\mousechsh\GlobalStatic::$rootfiles, 'com.mousechsh.password-cs.php' );
array_push( \com\mousechsh\GlobalStatic::$rootfiles, 'com.mousechsh.password-fn.php' );
array_push( \com\mousechsh\GlobalStatic::$rootfiles, 'com.mousechsh.route-cs.php' );
array_push( \com\mousechsh\GlobalStatic::$rootfiles, 'com.mousechsh.route-fn.php' );
array_push( \com\mousechsh\GlobalStatic::$rootfiles, 'com.mousechsh.smtp-cs.php' );
array_push( \com\mousechsh\GlobalStatic::$rootfiles, 'com.mousechsh.smtp-fn.php' );
array_push( \com\mousechsh\GlobalStatic::$rootfiles, 'com.mousechsh.url-cs.php' );
array_push( \com\mousechsh\GlobalStatic::$rootfiles, 'com.mousechsh.url-fn.php' );
array_push( \com\mousechsh\GlobalStatic::$rootfiles, 'com.mousechsh.uuid-cs.php' );
array_push( \com\mousechsh\GlobalStatic::$rootfiles, 'com.mousechsh.uuid-fn.php' );

<?php
/***************************************************************
Site Integrity Checker
======================
Check the site folder is OK
Add missing folder
----------------------
Spacial app name can be use for build phar
***************************************************************/
$fn = function(){

	// Schema check
	$path = dirname( __FILE__ ) . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'index.html';
	if( !file_exists( $path ) ){
		file_put_contents( $path, '' );
	}
	function _MouseChsh_CheckRootSchema( $folder, $ext = '' ){

		if( $folder == 'core' ){
			if( file_exists( dirname( __FILE__ ) . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'core_delete' ) ){
				return;
			}
		}
		$path = dirname( __FILE__ ) . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . $folder;
		if( !file_exists( $path ) ){
			mkdir( $path );
		}
		$path = dirname( __FILE__ ) . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . $folder . DIRECTORY_SEPARATOR . 'index.html';
		if( !file_exists( $path ) ){
			file_put_contents( $path, '' );
		}
		if( $ext ){
			$path = dirname( __FILE__ ) . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . $folder . DIRECTORY_SEPARATOR . $ext;
			if( !file_exists( $path ) ){
				file_put_contents( $path, '' );
			}
		}else{
			$path = dirname( __FILE__ ) . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . $folder . DIRECTORY_SEPARATOR . '.empty';
			if( !file_exists( $path ) ){
				file_put_contents( $path, '' );
			}
		}

	}
	_MouseChsh_CheckRootSchema( '3rt'     ); // The Third-Part Library
	_MouseChsh_CheckRootSchema( 'admin'   ); // System Admin Console
	_MouseChsh_CheckRootSchema( 'api'     ); // APIs
	_MouseChsh_CheckRootSchema( 'app'     ); // Apps
	_MouseChsh_CheckRootSchema( 'cache'   ); // Runtime Cache ( auto delete when expire )
	_MouseChsh_CheckRootSchema( 'common'  ); // Common Files and Common Config ( business code )
	_MouseChsh_CheckRootSchema( 'core'    ); // Core Files
	_MouseChsh_CheckRootSchema( 'data'    ); // Data Files ( Permanent )
	_MouseChsh_CheckRootSchema( 'export'  ); // Export Files
	_MouseChsh_CheckRootSchema( 'font'    ); // Font Files
	_MouseChsh_CheckRootSchema( 'image'   ); // Images Files
	_MouseChsh_CheckRootSchema( 'import'  ); // Import Files
	_MouseChsh_CheckRootSchema( 'mail'    ); // Mail Box
	_MouseChsh_CheckRootSchema( 'media'   ); // Media Engine
	_MouseChsh_CheckRootSchema( 'log'     ); // Log Files
	_MouseChsh_CheckRootSchema( 'library' ); // PHP Library ( un-business code )
	_MouseChsh_CheckRootSchema( 'search'  ); // Search Engine
	_MouseChsh_CheckRootSchema( 'script'  ); // Script or JavaScript
	_MouseChsh_CheckRootSchema( 'style'   ); // Style or CSS
	_MouseChsh_CheckRootSchema( 'temp'    ); // Temp Files ( Temp, no auto delete but can be override )
	_MouseChsh_CheckRootSchema( 'www'     ); // End Point
	// Check Static Only HTML
	function _MouseChsh_CheckStaticOnlyHtmlSchema( $folder ){

		$path = dirname( __FILE__ ) . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'www' . DIRECTORY_SEPARATOR . $folder;
		if( !file_exists( $path ) ){
			mkdir( $path );
		}
		$path = dirname( __FILE__ ) . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'www' . DIRECTORY_SEPARATOR . $folder . DIRECTORY_SEPARATOR . 'index.html';
		if( !file_exists( $path ) ){
			file_put_contents( $path, '' );
		}

	}
	_MouseChsh_CheckStaticOnlyHtmlSchema( 'font'     ); // Static Only Font File <=> www/../font
	_MouseChsh_CheckStaticOnlyHtmlSchema( 'image'    ); // Static Only HTML Image <=> www/../image
	_MouseChsh_CheckStaticOnlyHtmlSchema( 'media'    ); // Static Only HTML Video, Audio <=> www/../media
	_MouseChsh_CheckStaticOnlyHtmlSchema( 'resource' ); // Static Only HTML Resource, packed JavaScript Library <=> www/../data
	_MouseChsh_CheckStaticOnlyHtmlSchema( 'script'   ); // Static Only HTML JavaScript <=> www/../script
	_MouseChsh_CheckStaticOnlyHtmlSchema( 'style'    ); // Static Only HTML CSS <=> www/../style
	// Check Core
	/*
	$path = dirname( __FILE__ ) . DIRECTORY_SEPARATOR . 'mousechsh.php';
	echo var_dump( hash_file( 'sha512', $path ) );
	//*/
	// Get SP App
	function _MouseChsh_GetSpApp(){

		return array(
			'/^api-[0-9a-z_.]+$/i' => 'api',
			'/^app-[0-9a-z_.]+$/i' => 'app',
			'/^admin$/i'         => false,
			'/^common$/i'        => false,
			'/^cache$/i'         => false,
			'/^data$/i'          => false,
			'/^font$/i'          => false,
			'/^export$/i'        => false,
			'/^image$/i'         => false,
			'/^import$/i'        => false,
			'/^log$/i'           => false,
			'/^mail$/i'          => false,
			'/^media$/i'         => false,
			'/^search$/i'        => false,
			'/^script$/i'        => false,
			'/^style$/i'         => false
		);

	}
	// Check App
	function _MouseChsh_SubCheckApp( $path, $class ){

		$checkpath = $path . DIRECTORY_SEPARATOR . $class;
		$checkpath = str_replace( array( '/', '\\' ), DIRECTORY_SEPARATOR, $checkpath );
		if( !file_exists( $checkpath ) ){
			mkdir( $checkpath );
		}
		$checkpath = $path . DIRECTORY_SEPARATOR . $class . DIRECTORY_SEPARATOR . 'index.html';
		if( !file_exists( $checkpath ) ){
			file_put_contents( $checkpath, '' );
		}

	}
	function _MouseChsh_GetBasePath( $entry ){

		$flag  = true;
		$spApp = _MouseChsh_GetSpApp();
		foreach( $spApp as $app => $doit ){
			if( preg_match( $app, $entry ) ){
				$flag = false;
				if( $doit ){
					$path = dirname( __FILE__ ) . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . $doit . DIRECTORY_SEPARATOR . substr( $entry, 4 );
				}else{
					$path = dirname( __FILE__ ) . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . $entry;
				}
			}
		}
		if( $flag ){
			$path =  dirname( __FILE__ ) . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR . $entry;
		}

		return $path;

	}
	function _MouseChsh_CheckApp( $entry, $classes ){

		if( !isset( $entry ) || $entry == '' ){
			require_once( 'com.mousechsh.500-pg.php' );
			exit();
		}
		$entry = str_replace( array( '/', '\\' ), '', $entry );
		$path = _MouseChsh_GetBasePath( $entry );
		if( !file_exists( $path ) ){
			mkdir ( $path );
		}
		$checkpath = $path . DIRECTORY_SEPARATOR . 'index.html';
		if( !file_exists( $checkpath ) ){
			file_put_contents( $checkpath, '' );
		}
		$checkpath = $path . DIRECTORY_SEPARATOR . 'index-idx.php';
		if( !file_exists( $checkpath ) ){
			file_put_contents( $checkpath, "<?php\r\necho 'Hello, MouseChsh!';\r\nexit();" );
		}
		foreach( $classes as $class ){
			_MouseChsh_SubCheckApp( $path, $class );
		}
		if( $entry == 'common' ){
			\com\mousechsh\GlobalStatic::$commonpath_action    = $path . DIRECTORY_SEPARATOR . 'action';
			\com\mousechsh\GlobalStatic::$commonpath_component = $path . DIRECTORY_SEPARATOR . 'component';
			\com\mousechsh\GlobalStatic::$commonpath_config    = $path . DIRECTORY_SEPARATOR . 'config';
			\com\mousechsh\GlobalStatic::$commonpath_function  = $path . DIRECTORY_SEPARATOR . 'function';
			\com\mousechsh\GlobalStatic::$commonpath_map       = $path . DIRECTORY_SEPARATOR . 'map';
			\com\mousechsh\GlobalStatic::$commonpath_page      = $path . DIRECTORY_SEPARATOR . 'page';
			\com\mousechsh\GlobalStatic::$commonpath_part      = $path . DIRECTORY_SEPARATOR . 'part';
			\com\mousechsh\GlobalStatic::$commonpath_plugin    = $path . DIRECTORY_SEPARATOR . 'plugin';
			\com\mousechsh\GlobalStatic::$commonpath_sql       = $path . DIRECTORY_SEPARATOR . 'sql';
			\com\mousechsh\GlobalStatic::$commonpath_view      = $path . DIRECTORY_SEPARATOR . 'view';
		}else{
			\com\mousechsh\GlobalStatic::$apppath              = $path . DIRECTORY_SEPARATOR . 'index-idx.php';
			\com\mousechsh\GlobalStatic::$apppath_action       = $path . DIRECTORY_SEPARATOR . 'action';
			\com\mousechsh\GlobalStatic::$apppath_component    = $path . DIRECTORY_SEPARATOR . 'component';
			\com\mousechsh\GlobalStatic::$apppath_config       = $path . DIRECTORY_SEPARATOR . 'config';
			\com\mousechsh\GlobalStatic::$apppath_function     = $path . DIRECTORY_SEPARATOR . 'function';
			\com\mousechsh\GlobalStatic::$apppath_map          = $path . DIRECTORY_SEPARATOR . 'map';
			\com\mousechsh\GlobalStatic::$apppath_page         = $path . DIRECTORY_SEPARATOR . 'page';
			\com\mousechsh\GlobalStatic::$apppath_part         = $path . DIRECTORY_SEPARATOR . 'part';
			\com\mousechsh\GlobalStatic::$apppath_plugin       = $path . DIRECTORY_SEPARATOR . 'plugin';
			\com\mousechsh\GlobalStatic::$apppath_sql          = $path . DIRECTORY_SEPARATOR . 'sql';
			\com\mousechsh\GlobalStatic::$apppath_view         = $path . DIRECTORY_SEPARATOR . 'view';
		}

	}
	_MouseChsh_CheckApp( 'common', array(
		             // 这里只包含 PHP 部分可以运行的配置，不包含全项目的配置，全项目的配置在 shell&config 文件夹中
		             // +=====+=====+=====+================+=============+=====================================================
		             // | App | API | SPs | File           | DebugFolder | Display
		             // +-----+-----+-----+----------------+-------------+-----------------------------------------------------
		'action',    // | no  | YES | no  |     x-act.php  | Not Have    | Action Files
		'cmdshell',  // | no  | no  | YES |     x-sh       | Can Have    | CMD/DOS/Shell/BASH Files
		'code',      // | no  | no  | YES |     x-cd.php   | Not Have    | Code Files
		'component', // | YES | no  | no  |     x-cpt.php  | Not Have    | Component Files, Component for View, Function Result
		'config',    // | YES | YES | YES |     x-cfg.json | Can Have    | Config Files, e.g. DB Connect String
		'entity',    // | YES | YES | YES |     x-ett.php  | Can Have    | Entity Files, Data Access Layout
		'error',     // | no  | YES | YES |     x-err.php  | Can Have    | Error Files, When error show
		'etc',       // | no  | YES | YES |     x.conf     | Not Have    | Config Files, for runtime software
		'extension', // | YES | no  | no  |     x-ext.php  | Not Have    | The Code-Version View
		'file',      // | no  | no  | YES |     x-file     | Not Have    | Files, just files
		'filter',    // | YES | YES | YES |     x-fltr.php | Not Have    | Filter Files, e.g. Auth Check
		'function',  // | YES | YES | no  |     x-fn.php   | Not Have    | Functiuon Files, Single Function
		'language',  // | YES | YES | YES |     x-lng.php  | Not Have    | Language Files, I18N
		'map',       // | YES | no  | no  |     x-mp.php   | Can Have    | Map Files, e.g. Database to View
		'model',     // | YES | YES | YES |     x-md.php   | Can Have    | Model Files, Presentation layer
		'module',    // | no  | YES | no  |     x-mdl.php  | Not Have    | Module Files, Function Combination
		'page',      // | YES | no  | no  |     x-pg.php   | Not Have    | Page Files, The View's Page
		'part',      // | YES | no  | no  |     x-pt.php   | Not Have    | Part Files, The Part of View, Just Code Include
		'plugin',    // | YES | no  | no  |     x-plg.php  | Not Have    | Plugin Files
		'show',      // | YES | no  | no  |     x-shw.php  | Not Have    | Show Files, When View Failt to Show
		'sql',       // | YES | YES | YES |     x.sql      | Can Have    | SQL Files, Database Execute
		'view'       // | YES | no  | no  |     x-vw.php   | Not Have    | View Files
					 // | YES | YES | YES | index-idx.php  | No feature  | App/API enter point
	) );
	function _MouseChsh_CheckOther( $entry ){

		if( preg_match( '/^api-[0-9a-z_.]+$/i', $entry ) ){
			return array(
				'action',
				'config',
				'entity',
				'error',
				'filter',
				'function',
				'language',
				'map',
				'model',
				'module',
				'sql'
			);
		}
		if( $entry == 'cache' || $entry == 'data' || $entry == 'font' || $entry == 'log' || $entry == 'image' || $entry == 'mail' || $entry == 'media' || $entry == 'script' || $entry == 'style' ){
			return array(
				'code',
				'config',
				'entity',
				'error',
				'file',
				'filter',
				'language',
				'map',
				'model',
				'sql',
				'../www/font',
				'../www/image',
				'../www/media',
				'../www/resource',
				'../www/script',
				'../www/style'
			);
		}
		if( $entry == 'export' || $entry == 'import' || $entry == 'library' ){
			return array(
				'code',
				'config',
				'error',
				'language',
				'sql'
			);
		}
		if( $entry == 'search' || $entry == 'admin' ){
			return array(
				'action',
				'component',
				'config',
				'entity',
				'extension',
				'filter',
				'function',
				'language',
				'map',
				'model',
				'module',
				'page',
				'part',
				'plugin',
				'show',
				'sql',
				'view',
				'../www/font/' . $entry,
				'../www/image/' . $entry,
				'../www/media/' . $entry,
				'../www/resource/' . $entry,
				'../www/script/' . $entry,
				'../www/style/' . $entry
			);
		}
		if( preg_match( '/^app-[0-9a-z_.]+$/i', $entry ) ){
			return array(
				'component',
				'config',
				'entity',
				'extension',
				'filter',
				'function',
				'language',
				'map',
				'model',
				'page',
				'part',
				'plugin',
				'show',
				'sql',
				'view',
				'../../www/font/' . substr( $entry, 4 ),
				'../../www/image/' . substr( $entry, 4 ),
				'../../www/media/' . substr( $entry, 4 ),
				'../../www/resource/' . substr( $entry, 4 ),
				'../../www/script/' . substr( $entry, 4 ),
				'../../www/style/' . substr( $entry, 4 )
			);
		}

		return array(
			'component',
			'config',
			'entity',
			'extension',
			'filter',
			'function',
			'language',
			'map',
			'model',
			'page',
			'part',
			'plugin',
			'show',
			'sql',
			'view',
			'../../www/font/' . $entry,
			'../../www/image/' . $entry,
			'../../www/media/' . $entry,
			'../../www/resource/' . $entry,
			'../../www/script/' . $entry,
			'../../www/style/' . $entry
		);

	}
	_MouseChsh_CheckApp( \com\mousechsh\GlobalStatic::$appname, _MouseChsh_CheckOther( \com\mousechsh\GlobalStatic::$appname ) );

};
$fn();

<?php
/***************************************************************
UUID Generate Function
***************************************************************/
function _MouseChsh_Loader_JSON( $key, $ext, $commonpath_, $apppath_, &$var ){

	if( isset( $commonpath_ ) ){
		$path = $commonpath_ . DIRECTORY_SEPARATOR . $key . '-' . $ext;
		if( file_exists( $path ) ){
			$content = file_get_contents( $path );
			if( isset( $content ) && $content != '' ){
				$var[ $key ] = json_decode( $content, true );
			}
		}
	}
	if( isset( $apppath_ ) ){
		$path = $apppath_ . DIRECTORY_SEPARATOR . $key . '-' . $ext;
		if( file_exists( $path ) ){
			$content = file_get_contents( $path );
			if( isset( $content ) && $content != '' ){
				$var[ $key ] = json_decode( $content, true );
			}
		}
	}
	if( \com\mousechsh\GlobalConfig::$Runtime == 'debug' ){
		if( isset( $commonpath_ ) ){
			$path = $commonpath_ . DIRECTORY_SEPARATOR . 'debug' . DIRECTORY_SEPARATOR . $key . '-' . $ext;
			if( file_exists( $path ) ){
				$content = file_get_contents( $path );
				if( isset( $content ) && $content != '' ){
					$var[ $key ] = json_decode( $content, true );
				}
			}
		}
		if( isset( $apppath_ ) ){
			$path = $apppath_ . DIRECTORY_SEPARATOR . 'debug' . DIRECTORY_SEPARATOR . $key . '-' . $ext;
			if( file_exists( $path ) ){
				$content = file_get_contents( $path );
				if( isset( $content ) && $content != '' ){
					$var[ $key ] = json_decode( $content, true );
				}
			}
		}
	}else if( \com\mousechsh\GlobalConfig::$Runtime == 'release' ){
		if( isset( $commonpath_ ) ){
			$path = $commonpath_ . DIRECTORY_SEPARATOR . 'release' . DIRECTORY_SEPARATOR . $key . '-' . $ext;
			if( file_exists( $path ) ){
				$content = file_get_contents( $path );
				if( isset( $content ) && $content != '' ){
					$var[ $key ] = json_decode( $content, true );
				}
			}
		}
		if( isset( $apppath_ ) ){
			$path = $apppath_ . DIRECTORY_SEPARATOR . 'release' . DIRECTORY_SEPARATOR . $key . '-' . $ext;
			if( file_exists( $path ) ){
				$content = file_get_contents( $path );
				if( isset( $content ) && $content != '' ){
					$var[ $key ] = json_decode( $content, true );
				}
			}
		}
	}else if( \com\mousechsh\GlobalConfig::$Runtime == 'testing' ){
		if( isset( $commonpath_ ) ){
			$path = $commonpath_ . DIRECTORY_SEPARATOR . 'testing' . DIRECTORY_SEPARATOR . $key . '-' . $ext;
			if( file_exists( $path ) ){
				$content = file_get_contents( $path );
				if( isset( $content ) && $content != '' ){
					$var[ $key ] = json_decode( $content, true );
				}
			}
		}
		if( isset( $apppath_ ) ){
			$path = $apppath_ . DIRECTORY_SEPARATOR . 'testing' . DIRECTORY_SEPARATOR . $key . '-' . $ext;
			if( file_exists( $path ) ){
				$content = file_get_contents( $path );
				if( isset( $content ) && $content != '' ){
					$var[ $key ] = json_decode( $content, true );
				}
			}
		}
	}

}

function _MouseChsh_Loader_PHP( $key, $ext, $commonpath_, $apppath_, &$var ){

//	/* DEBUG POINT */ echo var_dump( $key );
//	/* DEBUG POINT */ echo var_dump( $ext );
//	/* DEBUG POINT */ echo var_dump( $commonpath_ );
//	/* DEBUG POINT */ echo var_dump( $apppath_ );
//	/* DEBUG POINT */ echo var_dump( $var );
	if( isset( $commonpath_ ) ){
		$path = $commonpath_ . DIRECTORY_SEPARATOR . $key . '-' . $ext;
		if( file_exists( $path ) ){
			require( $path );
		}
	}
	if( isset( $apppath_ ) ){
		$path = $apppath_ . DIRECTORY_SEPARATOR . $key . '-' . $ext;
	//	/* DEBUG POINT */ echo var_dump( $path );
	//	/* DEBUG POINT */ echo var_dump( file_exists( $path ) );
		if( file_exists( $path ) ){
			require( $path );
		}
	}
	if( \com\mousechsh\GlobalConfig::$Runtime == 'debug' ){
		if( isset( $commonpath_ ) ){
			$path = $commonpath_ . DIRECTORY_SEPARATOR . 'debug' . DIRECTORY_SEPARATOR . $key . '-' . $ext;
			if( file_exists( $path ) ){
				require( $path );
			}
		}
		if( isset( $apppath_ ) ){
			$path = $apppath_ . DIRECTORY_SEPARATOR . 'debug' . DIRECTORY_SEPARATOR . $key . '-' . $ext;
			if( file_exists( $path ) ){
				require( $path );
			}
		}
	}else if( \com\mousechsh\GlobalConfig::$Runtime == 'release' ){
		if( isset( $commonpath_ ) ){
			$path = $commonpath_ . DIRECTORY_SEPARATOR . 'release' . DIRECTORY_SEPARATOR . $key . '-' . $ext;
			if( file_exists( $path ) ){
				require( $path );
			}
		}
		if( isset( $apppath_ ) ){
			$path = $apppath_ . DIRECTORY_SEPARATOR . 'release' . DIRECTORY_SEPARATOR . $key . '-' . $ext;
			if( file_exists( $path ) ){
				require( $path );
			}
		}
	}else if( \com\mousechsh\GlobalConfig::$Runtime == 'testing' ){
		if( isset( $commonpath_ ) ){
			$path = $commonpath_ . DIRECTORY_SEPARATOR . 'testing' . DIRECTORY_SEPARATOR . $key . '-' . $ext;
			if( file_exists( $path ) ){
				require( $path );
			}
		}
		if( isset( $apppath_ ) ){
			$path = $apppath_ . DIRECTORY_SEPARATOR . 'testing' . DIRECTORY_SEPARATOR . $key . '-' . $ext;
			if( file_exists( $path ) ){
				require( $path );
			}
		}
	}

}

function _MouseChsh_Loader_String( $key, $ext, $commonpath_, $apppath_, &$var ){

//	/* DEBUG POINT */ echo var_dump( $key );
//	/* DEBUG POINT */ echo var_dump( $ext );
//	/* DEBUG POINT */ echo var_dump( $commonpath_ );
//	/* DEBUG POINT */ echo var_dump( $apppath_ );
//	/* DEBUG POINT */ echo var_dump( $var );
	if( isset( $commonpath_ ) ){
		$path = $commonpath_ . DIRECTORY_SEPARATOR . $key . '.' . $ext;
		if( file_exists( $path ) ){
			$var[ $key ] = file_get_contents( $path );
		}
	}
	if( isset( $apppath_ ) ){
		$path = $apppath_ . DIRECTORY_SEPARATOR . $key . '.' . $ext;
		if( file_exists( $path ) ){
			$var[ $key ] = file_get_contents( $path );
		}
	}
	if( \com\mousechsh\GlobalConfig::$Runtime == 'debug' ){
		if( isset( $commonpath_ ) ){
			$path = $commonpath_ . DIRECTORY_SEPARATOR . 'debug' . DIRECTORY_SEPARATOR . $key . '.' . $ext;
			if( file_exists( $path ) ){
				$var[ $key ] = file_get_contents( $path );
			}
		}
		if( isset( $apppath_ ) ){
			$path = $apppath_ . DIRECTORY_SEPARATOR . 'debug' . DIRECTORY_SEPARATOR . $key . '.' . $ext;
			if( file_exists( $path ) ){
				$var[ $key ] = file_get_contents( $path );
			}
		}
	}else if( \com\mousechsh\GlobalConfig::$Runtime == 'release' ){
		if( isset( $commonpath_ ) ){
			$path = $commonpath_ . DIRECTORY_SEPARATOR . 'release' . DIRECTORY_SEPARATOR . $key . '.' . $ext;
			if( file_exists( $path ) ){
				$var[ $key ] = file_get_contents( $path );
			}
		}
		if( isset( $apppath_ ) ){
			$path = $apppath_ . DIRECTORY_SEPARATOR . 'release' . DIRECTORY_SEPARATOR . $key . '.' . $ext;
			if( file_exists( $path ) ){
				$var[ $key ] = file_get_contents( $path );
			}
		}
	}else if( \com\mousechsh\GlobalConfig::$Runtime == 'testing' ){
		if( isset( $commonpath_ ) ){
			$path = $commonpath_ . DIRECTORY_SEPARATOR . 'testing' . DIRECTORY_SEPARATOR . $key . '.' . $ext;
			if( file_exists( $path ) ){
				$var[ $key ] = file_get_contents( $path );
			}
		}
		if( isset( $apppath_ ) ){
			$path = $apppath_ . DIRECTORY_SEPARATOR . 'testing' . DIRECTORY_SEPARATOR . $key . '.' . $ext;
			if( file_exists( $path ) ){
				$var[ $key ] = file_get_contents( $path );
			}
		}
	}

}

function MouseChsh_Loader( $type, $key, $format = null ){

	if( $type == 'component' ){
		if( isset( \com\mousechsh\GlobalStatic::$component[ $key ] ) ){
			return \com\mousechsh\GlobalStatic::$component[ $key ];
		}
		if( $format == 'PHP' ){
			_MouseChsh_Loader_PHP( $key, 'cpt.php',
				\com\mousechsh\GlobalStatic::$commonpath_component,
				\com\mousechsh\GlobalStatic::$apppath_component,
				\com\mousechsh\GlobalStatic::$component
			);
		}
		if( isset( \com\mousechsh\GlobalStatic::$component[ $key ] ) ){
			return \com\mousechsh\GlobalStatic::$component[ $key ];
		}
	}
	if( $type == 'config' ){
		if( isset( \com\mousechsh\GlobalStatic::$config[ $key ] ) ){
			return \com\mousechsh\GlobalStatic::$config[ $key ];
		}
		if( $format == 'JSON' ){
			_MouseChsh_Loader_JSON( $key, 'cfg.json',
				\com\mousechsh\GlobalStatic::$commonpath_config,
				\com\mousechsh\GlobalStatic::$apppath_config,
				\com\mousechsh\GlobalStatic::$config
			);
		}
		if( isset( \com\mousechsh\GlobalStatic::$config[ $key ] ) ){
			return \com\mousechsh\GlobalStatic::$config[ $key ];
		}
	}
	if( $type == 'function' ){
		if( isset( \com\mousechsh\GlobalStatic::$fn[ $key ] ) ){
			return \com\mousechsh\GlobalStatic::$fn[ $key ];
		}
		if( $format == 'PHP' ){
			_MouseChsh_Loader_PHP( $key, 'fn.php',
				\com\mousechsh\GlobalStatic::$commonpath_function,
				\com\mousechsh\GlobalStatic::$apppath_function,
				\com\mousechsh\GlobalStatic::$fn
			);
		}
		if( isset( \com\mousechsh\GlobalStatic::$fn[ $key ] ) ){
			return \com\mousechsh\GlobalStatic::$fn[ $key ];
		}
	}
	if( $type == 'map' ){
		if( isset( \com\mousechsh\GlobalStatic::$map[ $key ] ) ){
			return \com\mousechsh\GlobalStatic::$map[ $key ];
		}
		if( $format == 'JSON' ){
			_MouseChsh_Loader_JSON( $key, 'map.json',
				\com\mousechsh\GlobalStatic::$commonpath_map,
				\com\mousechsh\GlobalStatic::$apppath_map,
				\com\mousechsh\GlobalStatic::$map
			);
		}
		if( isset( \com\mousechsh\GlobalStatic::$map[ $key ] ) ){
			return \com\mousechsh\GlobalStatic::$map[ $key ];
		}
	}
	if( $type == 'page' ){
		if( isset( \com\mousechsh\GlobalStatic::$page[ $key ] ) ){
			return \com\mousechsh\GlobalStatic::$page[ $key ];
		}
		if( $format == 'PHP' ){
			_MouseChsh_Loader_PHP( $key, 'pg.php',
				\com\mousechsh\GlobalStatic::$commonpath_page,
				\com\mousechsh\GlobalStatic::$apppath_page,
				\com\mousechsh\GlobalStatic::$page
			);
		}
		if( isset( \com\mousechsh\GlobalStatic::$page[ $key ] ) ){
			return \com\mousechsh\GlobalStatic::$page[ $key ];
		}
	}
	if( $type == 'part' ){
		if( isset( \com\mousechsh\GlobalStatic::$part[ $key ] ) ){
			return \com\mousechsh\GlobalStatic::$part[ $key ];
		}
		if( $format == 'PHP' ){
			_MouseChsh_Loader_PHP( $key, 'pt.php',
				\com\mousechsh\GlobalStatic::$commonpath_part,
				\com\mousechsh\GlobalStatic::$apppath_part,
				\com\mousechsh\GlobalStatic::$part
			);
		}
		if( isset( \com\mousechsh\GlobalStatic::$part[ $key ] ) ){
			return \com\mousechsh\GlobalStatic::$part[ $key ];
		}
	}
	if( $type == 'plugin' ){
		if( isset( \com\mousechsh\GlobalStatic::$plugin[ $key ] ) ){
			return \com\mousechsh\GlobalStatic::$plugin[ $key ];
		}
		if( $format == 'PHP' ){
			_MouseChsh_Loader_PHP( $key, 'pgi.php',
				\com\mousechsh\GlobalStatic::$commonpath_plugin,
				\com\mousechsh\GlobalStatic::$apppath_plugin,
				\com\mousechsh\GlobalStatic::$plugin
			);
		}
		if( isset( \com\mousechsh\GlobalStatic::$plugin[ $key ] ) ){
			return \com\mousechsh\GlobalStatic::$plugin[ $key ];
		}
	}
	if( $type == 'script' ){
		if( isset( \com\mousechsh\GlobalStatic::$script[ $key ] ) ){
			return \com\mousechsh\GlobalStatic::$script[ $key ];
		}
		if( $format == 'PHP' ){
			_MouseChsh_Loader_PHP( $key, 'script.php',
				\com\mousechsh\GlobalStatic::$commonpath_file,
				\com\mousechsh\GlobalStatic::$apppath_file,
				\com\mousechsh\GlobalStatic::$script
			);
		}
		if( isset( \com\mousechsh\GlobalStatic::$script[ $key ] ) ){
			return \com\mousechsh\GlobalStatic::$script[ $key ];
		}
	}
	if( $type == 'sql' ){
		if( isset( \com\mousechsh\GlobalStatic::$sql[ $key ] ) ){
			return \com\mousechsh\GlobalStatic::$sql[ $key ];
		}
		if( $format == 'String' ){
			_MouseChsh_Loader_String( $key, 'sql',
				\com\mousechsh\GlobalStatic::$commonpath_sql,
				\com\mousechsh\GlobalStatic::$apppath_sql,
				\com\mousechsh\GlobalStatic::$sql
			);
		}
		if( isset( \com\mousechsh\GlobalStatic::$sql[ $key ] ) ){
			return \com\mousechsh\GlobalStatic::$sql[ $key ];
		}
	}
	if( $type == 'style' ){
		if( isset( \com\mousechsh\GlobalStatic::$style[ $key ] ) ){
			return \com\mousechsh\GlobalStatic::$style[ $key ];
		}
		if( $format == 'PHP' ){
			_MouseChsh_Loader_PHP( $key, 'style.php',
				\com\mousechsh\GlobalStatic::$commonpath_file,
				\com\mousechsh\GlobalStatic::$apppath_file,
				\com\mousechsh\GlobalStatic::$style
			);
		}
		if( isset( \com\mousechsh\GlobalStatic::$style[ $key ] ) ){
			return \com\mousechsh\GlobalStatic::$style[ $key ];
		}
	}
	if( $type == 'view' ){
		if( isset( \com\mousechsh\GlobalStatic::$view[ $key ] ) ){
			return \com\mousechsh\GlobalStatic::$view[ $key ];
		}
		if( $format == 'PHP' ){
			_MouseChsh_Loader_PHP( $key, 'vw.php',
				\com\mousechsh\GlobalStatic::$commonpath_view,
				\com\mousechsh\GlobalStatic::$apppath_view,
				\com\mousechsh\GlobalStatic::$view
			);
		}
		if( isset( \com\mousechsh\GlobalStatic::$view[ $key ] ) ){
			return \com\mousechsh\GlobalStatic::$view[ $key ];
		}
	}

	return null;

}

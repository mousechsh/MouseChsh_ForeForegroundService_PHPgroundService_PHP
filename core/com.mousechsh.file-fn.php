<?php

function MouseChsh_File_OpenFile( $obj, $path = null ){

	if( isset( $obj ) && isset( $obj[ '@' ] ) && isset( $obj[ '@' ][ 'path' ] ) ){
		$path = $obj[ '@' ][ 'path' ];
	}
	if( !isset( $path ) ){
		return array(
			''       => 'Fault',
			'type'   => 'File',
			'action' => 'OpenFile'
		);
	}
	$file = fopen( $path, 'r+' );
	if( isset( $file ) ){
		return array(
			''         => 'OK',
			'type'     => 'File',
			'action'   => 'OpenFile',
			'@'        => array(
				'file' => $file
			)
		);
	}else{
		return array(
			''       => 'Fault',
			'type'   => 'File',
			'action' => 'OpenFile'
		);
	}

}

function MouseChsh_File_CreateFile( $obj, $path = null ){

	if( isset( $obj ) && isset( $obj[ '@' ] ) && isset( $obj[ '@' ][ 'path' ] ) ){
		$path = $obj[ '@' ][ 'path' ];
	}
	if( !isset( $path ) ){
		return array(
			''       => 'Fault',
			'type'   => 'File',
			'action' => 'CreateFile'
		);
	}
	$file = fopen( $path, 'w+' );
	if( isset( $file ) ){
		return array(
			''         => 'OK',
			'type'     => 'File',
			'action'   => 'CreateFile',
			'@'        => array(
				'file' => $file
			)
		);
	}else{
		return array(
			''       => 'Fault',
			'type'   => 'File',
			'action' => 'CreateFile'
		);
	}

}

function MouseChsh_File_FileExists( $obj, $path = null ){

	if( isset( $obj ) && isset( $obj[ '@' ] ) && isset( $obj[ '@' ][ 'path' ] ) ){
		$path = $obj[ '@' ][ 'path' ];
	}
	if( !isset( $path ) ){
		return array(
			''       => 'Fault',
			'type'   => 'File',
			'action' => 'FileExists'
		);
	}
	if( file_exists( $path ) ){
		return array(
			''       => 'OK',
			'type'   => 'File',
			'action' => 'FileExists',
			'@'      => true
		);
	}else{
		return array(
			''       => 'OK',
			'type'   => 'File',
			'action' => 'FileExists',
			'@'      => false
		);
	}

}

function MouseChsh_File_OpenCreateFile( $obj, $path = null ){

	if( isset( $obj ) && isset( $obj[ '@' ] ) && isset( $obj[ '@' ][ 'path' ] ) ){
		$path = $obj[ '@' ][ 'path' ];
	}
	if( !isset( $path ) ){
		return array(
			''       => 'Fault',
			'type'   => 'File',
			'action' => 'OpenCreateFile'
		);
	}
	$result = MouseChsh_File_FileExists( $obj, $path );
	if( isset( $res ) && isset( $res[ '' ] ) && $res[ '' ] == 'OK' && isset( $res[ '@' ] ) && $res[ '@' ] ){
		return MouseChsh_File_OpenFile( $obj, $path );
	}

	return MouseChsh_File_CreateFile( $obj, $path );

}

function MouseChsh_File_CloseFile( $obj, $file = null ){

	if( isset( $obj ) && isset( $obj[ '@' ] ) && isset( $obj[ '@' ][ 'file' ] ) ){
		$file = $obj[ '@' ][ 'file' ];
	}
	if( $file ){
		if( fclose( $file ) ){
			return array(
				''       => 'OK',
				'type'   => 'File',
				'action' => 'CloseFile',
				'@'      => true
			);
		}else{
			return array(
				''       => 'OK',
				'type'   => 'File',
				'action' => 'CloseFile',
				'@'      => false
			);
		}
	}else{
		return array(
			''       => 'Fault',
			'type'   => 'File',
			'action' => 'CloseFile'
		);
	}

}

function MouseChsh_File_GetContentAllText( $obj, $path = null ){

	if( isset( $obj ) && isset( $obj[ '@' ] ) && isset( $obj[ '@' ][ 'path' ] ) ){
		$path = $obj[ '@' ][ 'path' ];
	}
	$res = MouseChsh_File_FileExists( $obj, $path );
	if( isset( $res ) && isset( $res[ '' ] ) && $res[ '' ] == 'OK' && isset( $res[ '@' ] ) && $res[ '@' ] ){
		$content = file_get_contents( $path );
		return array(
			''            => 'OK',
			'type'        => 'File',
			'action'      => 'GetContentAllText',
			'@'           => array(
				'content' => $content
			)
		);
	}

	return array(
		''       => 'Fault',
		'type'   => 'File',
		'action' => 'GetContentAllText'
	);

}

function MouseChsh_File_SaveContentAllText( $obj, $path = null, $content = null ){

	if( isset( $obj ) && isset( $obj[ '@' ] ) ){
		if( isset( $obj[ '@' ][ 'path' ] ) ){
			$path = $obj[ '@' ][ 'path' ];
		}
		if( isset( $obj[ '@' ][ 'content' ] ) ){
			$content = $obj[ '@' ][ 'content' ];
		}
	}
	if( !isset( $path ) ){
		return array(
			''       => 'Fault',
			'type'   => 'File',
			'action' => 'SaveContentAllText',
			'data'   => 'Empty_Path'
		);
	}
	$res = MouseChsh_File_FileExists( $obj, $path );
	if( isset( $res ) && isset( $res[ '' ] ) && $res[ '' ] == 'OK' && isset( $res[ '@' ] ) ){
		if( $res[ '@' ] ){
			$res = MouseChsh_File_IsFile( $obj, $path );
			if( isset( $res ) && isset( $res[ '' ] ) && $res[ '' ] == 'OK' && isset( $res[ '@' ] ) && $res[ '@' ] ){
				if( file_put_contents( $path, $content ) !== false ){
					return array(
						''       => 'OK',
						'type'   => 'File',
						'action' => 'SaveContentAllText',
						'@'      => true
					);
				}else{
					return array(
						''       => 'Fault',
						'type'   => 'File',
						'action' => 'SaveContentAllText',
						'@'      => false
					);
				}
			}
		}else{
			$res = MouseChsh_File_MakeFolder( null, dirname( $path ) );
			if( isset( $res ) && isset( $res[ '' ] ) && $res[ '' ] == 'OK' && isset( $res[ '@' ] ) && $res[ '@' ] ){
				if( file_put_contents( $path, $content ) !== false ){
					return array(
						''       => 'OK',
						'type'   => 'File',
						'action' => 'SaveContentAllText',
						'@'      => true
					);
				}else{
					return array(
						''       => 'Fault',
						'type'   => 'File',
						'action' => 'SaveContentAllText',
						'@'      => false
					);
				}
			}
		}
	}

	return array(
		''       => 'Fault',
		'type'   => 'File',
		'action' => 'SaveContentAllText'
	);

}

function MouseChsh_File_IsFile( $obj, $path = null ){

	if( isset( $obj ) && isset( $obj[ '@' ] ) && isset( $obj[ '@' ][ 'path' ] ) ){
		$path = $obj[ '@' ][ 'path' ];
	}
	if( is_file( $path ) ){
		return array(
			''       => 'OK',
			'type'   => 'File',
			'action' => 'IsFile',
			'@'      => true
		);
	}else{
		return array(
			''       => 'OK',
			'type'   => 'File',
			'action' => 'IsFile',
			'@'      => false
		);
	}

}

function MouseChsh_File_IsFolder( $obj, $path = null ){

	if( isset( $obj ) && isset( $obj[ '@' ] ) && isset( $obj[ '@' ][ 'path' ] ) ){
		$path = $obj[ '@' ][ 'path' ];
	}
	if( is_dir( $path ) ){
		return array(
			''       => 'OK',
			'type'   => 'File',
			'action' => 'IsFolder',
			'@'      => true
		);
	}else{
		return array(
			''       => 'OK',
			'type'   => 'File',
			'action' => 'IsFolder',
			'@'      => false
		);
	}

}

function MouseChsh_File_MakeFolder( $obj, $path = null ){

	if( isset( $obj ) && isset( $obj[ '@' ] ) && isset( $obj[ '@' ][ 'path' ] ) ){
		$path = $obj[ '@' ][ 'path' ];
	}
	if( !isset( $path ) ){
		return array(
			''       => 'Fault',
			'type'   => 'File',
			'action' => 'MakeFolder'
		);
	}
	$res = MouseChsh_File_FileExists( $obj, $path );
	if( isset( $res ) && isset( $res[ '' ] ) && $res[ '' ] == 'OK' && isset( $res[ '@' ] ) && $res[ '@' ] ){
		return array(
			''       => 'OK',
			'type'   => 'File',
			'action' => 'MakeFolder',
			'data'   => 'Existed',
			'@'      => true
		);
	}else{
		if( mkdir( $path, 0777, true ) ){
			return array(
				''       => 'OK',
				'type'   => 'File',
				'action' => 'MakeFolder',
				'@'      => true
			);
		}else{
			return array(
				''       => 'OK',
				'type'   => 'File',
				'action' => 'MakeFolder',
				'@'      => false
			);
		}
	}

}

function MouseChsh_File_ListFolder( $obj, $path = null ){

	if( isset( $obj ) && isset( $obj[ '@' ] ) && isset( $obj[ '@' ][ 'path' ] ) ){
		$path = $obj[ '@' ][ 'path' ];
	}
	$res = MouseChsh_File_FileExists( $obj, $path );
	if( isset( $res ) && isset( $res[ '' ] ) && $res[ '' ] == 'OK' && isset( $res[ '@' ] ) && $res[ '@' ] ){
		$res = MouseChsh_File_IsFolder( $obj, $path );
		if( isset( $res ) && isset( $res[ '' ] ) && $res[ '' ] == 'OK' && isset( $res[ '@' ] ) && $res[ '@' ] ){
			$folder = opendir( $path );
			$arr = array();
			while( false !== ( $file = readdir( $folder ) ) ){
				if( $file != "." && $file != ".." ){
					array_push( $arr, $file );
				}
			}
			closedir( $folder );
			return array(
				''         => 'OK',
				'type'     => 'File',
				'action'   => 'ListFolder',
				'@'        => array(
					'list' => $arr
				)
			);
		}else{
			return array(
				''       => 'Fault',
				'type'   => 'File',
				'action' => 'ListFolder'
			);
		}
	}else{
		return array(
			''       => 'Fault',
			'type'   => 'File',
			'action' => 'ListFolder'
		);
	}

}

function MouseChsh_File_ListFilesAllSubFolder( $obj, $path = null ){

	if( isset( $obj ) && isset( $obj[ '@' ] ) && isset( $obj[ '@' ][ 'path' ] ) ){
		$path = $obj[ '@' ][ 'path' ];
	}
	$result = array();
	$list = array( DIRECTORY_SEPARATOR );
	$flag = 0;
	while( $item = array_shift( $list ) ){
		$npath = rtrim( $path . DIRECTORY_SEPARATOR . $item, DIRECTORY_SEPARATOR );
		$res   = MouseChsh_File_ListFolder( null, $npath );
	//	/* DEBUG POINT */ echo var_dump( $res );
		if( isset( $res ) && isset( $res[ '' ] ) && $res[ '' ] == 'OK' && isset( $res[ '@' ] ) && isset( $res[ '@' ][ 'list' ] ) ){
			foreach( $res[ '@' ][ 'list' ] as $v ){
				if( preg_match( "/^\^/", $v ) ){
					continue;
				}
				$ppp = trim( $item . DIRECTORY_SEPARATOR . $v, DIRECTORY_SEPARATOR );
				$rrr = MouseChsh_File_IsFile( null, $path . DIRECTORY_SEPARATOR . $ppp );
				if( isset( $rrr ) && isset( $rrr[ '' ] ) && $rrr[ '' ] == 'OK' && isset( $rrr[ '@' ] ) ){
					if( $rrr[ '@' ] ){
						array_push( $result, array(
							'path' => $ppp
						) );
					}else{
					//	/* DEBUG POINT */ echo var_dump( $ppp );
						array_push( $list, $ppp );
					}
				}
			}
		}
		$flag++;
		if( $flag > 10000 ){
			return array(
				''       => 'Fault',
				'type'   => 'File',
				'action' => 'ListFolderAllSubFolder'
			);
		}
	}

	return array(
		''       => 'OK',
		'type'   => 'File',
		'action' => 'ListFolderAllSubFolder',
		'@'      => array(
			'list' => $result
		)
	);

}

function MouseChsh_File_RemoveFile( $obj, $path = null ){

	if( isset( $obj ) && isset( $obj[ '@' ] ) && isset( $obj[ '@' ][ 'path' ] ) ){
		$path = $obj[ '@' ][ 'path' ];
	}
	if( !isset( $path ) ){
		return array(
			''       => 'Fault',
			'type'   => 'File',
			'action' => 'RemoveFile'
		);
	}
	$res = MouseChsh_File_FileExists( $obj, $path );
	if( isset( $res ) && isset( $res[ '' ] ) && $res[ '' ] == 'OK' && isset( $res[ '@' ] ) && $res[ '@' ] ){
		$res = MouseChsh_File_IsFile( $obj, $path );
		if( isset( $res ) && isset( $res[ '' ] ) && $res[ '' ] == 'OK' && isset( $res[ '@' ] ) && $res[ '@' ] ){
			if( unlink( $path ) ){
				return array(
					''       => 'OK',
					'type'   => 'File',
					'action' => 'RemoveFile',
					'@'      => true
				);
			}else{
				return array(
					''       => 'OK',
					'type'   => 'File',
					'action' => 'RemoveFile',
					'@'      => false
				);
			}
		}
	}else{
		return array(
			''       => 'OK',
			'type'   => 'File',
			'action' => 'RemoveFile',
			'data'   => 'NotExisted',
			'@'      => true
		);
	}

}

function MouseChsh_File_RemoveFolder( $obj, $path = null ){

	if( isset( $obj ) && isset( $obj[ '@' ] ) && isset( $obj[ '@' ][ 'path' ] ) ){
		$path = $obj[ '@' ][ 'path' ];
	}
	if( !isset( $path ) ){
		return array(
			''       => 'Fault',
			'type'   => 'File',
			'action' => 'RemoveFolder'
		);
	}
	$res = MouseChsh_File_FileExists( $obj, $path );
	if( isset( $res ) && isset( $res[ '' ] ) && $res[ '' ] == 'OK' && isset( $res[ '@' ] ) && $res[ '@' ] ){
		$res = MouseChsh_File_IsFolder( $obj, $path );
		if( isset( $res ) && isset( $res[ '' ] ) && $res[ '' ] == 'OK' && isset( $res[ '@' ] ) && $res[ '@' ] ){
			$dir = opendir( $path );
			while( $file = readdir( $dir ) ){
				if( $file != '.' && $file != '..' ){
					$fullpath = $path . DIRECTORY_SEPARATOR . $file;
					$res = MouseChsh_File_RemoveFile( null, $fullpath );
					$res = MouseChsh_File_RemoveFolder( null, $fullpath );
				}
			}
			closedir( $dir );
			if( rmdir( $path ) ){
				return array(
					''       => 'OK',
					'type'   => 'File',
					'action' => 'RemoveFolder',
					'@'      => true
				);
			}else{
				return array(
					''       => 'OK',
					'type'   => 'File',
					'action' => 'RemoveFolder',
					'@'      => false
				);
			}
		}
	}else{
		return array(
			''       => 'OK',
			'type'   => 'File',
			'action' => 'RemoveFolder',
			'data'   => 'NotExisted',
			'@'      => true
		);
	}
	
}

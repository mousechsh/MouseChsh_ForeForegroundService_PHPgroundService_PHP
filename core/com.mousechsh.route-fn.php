<?php
function _MouseChsh_Route_ActionListPath(){

	return \com\mousechsh\GlobalStatic::$apppath_action . DIRECTORY_SEPARATOR . 'action-list.json';

}

function _MouseChsh_Route_Check_GetApiList( $ttl = 0, $digest = '' ){

//	/* DEBUG POINT */ echo var_dump( '_MouseChsh_Route_Check_GetApiList' );
	$res = MouseChsh_File_ListFilesAllSubFolder( null, \com\mousechsh\GlobalStatic::$apppath_action );
//	/* DEBUG POINT */ echo var_dump( $res ); exit();
	if( isset( $res ) && isset( $res[ '' ] ) && $res[ '' ] == 'OK' && isset( $res[ '@' ] ) && isset( $res[ '@' ][ 'list' ] ) ){
		$actlist = array();
		foreach( $res[ '@' ][ 'list' ] as $m => $v ){
			$item = $v[ 'path' ];
			if( preg_match( "/_-act\.php$/", $item ) ){
				$s    = explode( DIRECTORY_SEPARATOR, $item );
				$vrank = 0;
				for( $i = 0; $i < sizeof( $s ); $i++ ){
					$x  = 0;
					$si = $s[ $i ];
					if( $si == '_-act.php' ){
						$x = 0;
					}else if( preg_match( "/^[_]/", $si ) ){
						$x = 1;
					}else if( preg_match( "/^[Mm]=/", $si ) ){
						$x = 2;
					}else if( preg_match( "/^[Cc]=/", $si ) ){
						$x = 3;
					}else{
						$x = 4;
					}
					$vrank += $x * pow( 10, $i );
				}
				$v[ 'rank' ] = $vrank;
				array_push( $actlist, $v );
			}
		}
		usort( $actlist, function( $a, $b ){

			if( $a[ 'rank' ] > $b[ 'rank' ] ){
				return -1;
			}else if( $a[ 'rank' ] < $b[ 'rank' ] ){
				return 1;
			}else{
				strcmp( $a[ 'path' ], $b[ 'path' ] );
			}

		} );
		$sha1 = sha1( 'SHA1:' . json_encode( $actlist ) );
		if( $digest != $sha1 ){
			$ttl = 0;
		}
		if( $ttl < 10 ){
			$ttl = 10;
		}else{
			$ttl += 10;
		}
		if( $ttl > 31536000 ){
			$ttl = 31536000;
		}
		MouseChsh_File_SaveContentAllText( null, _MouseChsh_Route_ActionListPath(), json_encode( array(
			'list'   => $actlist,
			'expire' => time() + $ttl,
			'ttl'    => $ttl,
			'sence'  => date( 'Y-m-d\TH:i:sO' ),
			'digest' => $sha1
		) ) );
		return $actlist;
	}

	return array();

}

function MouseChsh_Route_Check( $obj, $url = null, $method = null, $cookie = null ){

	if( isset( $obj ) && isset( $obj[ '@' ] ) ){
		if( isset( $obj[ '@' ][ 'url' ] ) ){
			$url = $obj[ '@' ][ 'url' ];
		}
		if( isset( $obj[ '@' ][ 'method' ] ) ){
			$method = $obj[ '@' ][ 'method' ];
		}
		if( isset( $obj[ '@' ][ 'cookie' ] ) ){
			$cookie = $obj[ '@' ][ 'cookie' ];
		}
	}
	if( isset( $url ) ){
		$res = MouseChsh_Url_ParseString2UrlArray( $obj, $url );
	//	/* DEBUG POINT */ echo var_dump( $res ); exit();
		if( isset( $res ) && isset( $res[ '' ] ) && $res[ '' ] == 'OK' && isset( $res[ '@' ] ) && isset( $res[ '@' ][ 'url' ] ) && isset( $res[ '@' ][ 'url' ][ 'pathlist' ] ) ){
			$pathlist = $res[ '@' ][ 'url' ][ 'pathlist' ];
			$apilist = array();
			$res = MouseChsh_File_GetContentAllText( null, _MouseChsh_Route_ActionListPath() );
		//	/* DEBUG POINT */ echo var_dump( $res ); exit();
			if( isset( $res ) && isset( $res[ '' ] ) && $res[ '' ] == 'OK' && isset( $res[ '@' ] ) && isset( $res[ '@' ][ 'content' ] ) ){
				$ooo = json_decode( $res[ '@' ][ 'content' ], true );
				if( isset( $ooo[ 'expire' ] ) && isset( $ooo[ 'ttl' ] ) && isset( $ooo[ 'digest' ] ) ){
					if( time() > $ooo[ 'expire' ] ){
						$apilist = _MouseChsh_Route_Check_GetApiList( $ooo[ 'ttl' ], $ooo[ 'digest' ] );
					}else{
						$apilist = $ooo[ 'list' ];
					}
				}else{
					$apilist = _MouseChsh_Route_Check_GetApiList();
				}
			}else{
				$apilist = _MouseChsh_Route_Check_GetApiList();
			}
		//	/* DEBUG POINT */ echo var_dump( $apilist ); exit();
			$data = false;
			for( $m = 0; $m < sizeof( $apilist ); $m++ ){
				$item = $apilist[ $m ];
				$idx = 0;
				$data = array(
					'route'  => $item[ 'path' ],
					'data'   => array(),
					'cookie' => array(),
					'method' => ''
				);
				$sss = explode( DIRECTORY_SEPARATOR, $item[ 'path' ] );
			//	/* DEBUG POINT */ echo var_dump( $sss );
			//	/* DEBUG POINT */ echo var_dump( $data ); exit();
				for( $n = 0; $n < sizeof( $sss ); $n++ ){
					$si = $sss[ $n ];
				//	/* DEBUG POINT */ echo var_dump( $si );
					if( $si == '_-act.php' ){
					//	/* DEBUG POINT */ echo var_dump( 'OK' );
						break 2;
					}else if( preg_match( "/^[_]/", $si ) ){
						if( isset( $pathlist[ $idx ] ) ){
						//	/* DEBUG POINT */ echo var_dump( 'OK' );
							$data[ 'data' ][ substr( $si, 1 ) ] = $pathlist[ $idx ];
							$idx ++;
						}else{
						//	/* DEBUG POINT */ echo var_dump( 'False' );
							$data = false;
							break;
						}
					}else if( preg_match( "/^[Mm]=/", $si ) ){
						if( isset( $method ) && strtolower( $method ) == strtolower( substr( $si, 2 ) ) ){
						//	/* DEBUG POINT */ echo var_dump( 'OK' );
							$data[ 'method' ] = strtolower( $method );
						}else{
						//	/* DEBUG POINT */ echo var_dump( 'False' );
							$data = false;
							break;
						}
					}else if( preg_match( "/^[Cc]=/", $si ) ){
						if( isset( $cookie ) && isset( $cookie[ substr( $si, 2 ) ] ) ){
						//	/* DEBUG POINT */ echo var_dump( 'OK' );
							$data[ 'cookie' ][ substr( $si, 1 ) ] = $cookie[ substr( $si, 1 ) ];
						}else{
						//	/* DEBUG POINT */ echo var_dump( 'False' );
							$data = false;
							break;
						}
					}else{
						if( isset( $pathlist[ $idx ] ) && $pathlist[ $idx ] == $si ){
						//	/* DEBUG POINT */ echo var_dump( 'OK' );
							$idx ++;
						}else{
						//	/* DEBUG POINT */ echo var_dump( 'False' );
							$data = false;
							break;
						}
					}
				}
			}
			\com\mousechsh\GlobalStatic::$route = $item[ 'path' ];
			return array(
				''       => 'OK',
				'type'   => 'Route',
				'action' => 'Check',
				'@'      => $data
			);
		}else{
			\com\mousechsh\GlobalStatic::$route = '';
			return array(
				''       => 'Fault',
				'type'   => 'Route',
				'action' => 'Check'
			);
		}
	}
	\com\mousechsh\GlobalStatic::$route = '';

	return array(
		''       => 'Fault',
		'type'   => 'Route',
		'action' => 'Check'
	);

}

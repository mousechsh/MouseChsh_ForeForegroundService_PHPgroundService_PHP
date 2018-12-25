<?php

function MouseChsh_Url_ParseString2UrlArray( $obj, $url = null ){

	if( isset( $obj ) && isset( $obj[ '@' ] ) && isset( $obj[ '@' ][ 'url' ] ) ){
		$url = $obj[ '@' ][ 'url' ];
	}
	if( !isset( $url ) || $url == '' ){
		return array(
			''       => 'Fault',
			'type'   => 'Url',
			'action' => 'ParseString2UrlArray',
			'@'      => null
		);
	}
	$data = array();
	if( $url ){
		$s1 = strval( $url );
		$s2 = null;
		$s3 = null;
		preg_match( '/^((.*):\/\/)?(.*)$/', $s1, $m1 );
		if( $m1 ){
			$data[ 'protocol' ] = $m1[ 2 ];
			$s2 = $m1[ 3 ];
		}else{
			$s2 = $s1;
		}
		if( !$s2 ){
			return array(
				''        => 'OK',
				'type'    => 'Url',
				'action'  => 'ParseString2UrlArray',
				'@'       => array(
				'url'     => $data
				)
			);
		}
		preg_match( '/^([^\/]*)(.*)$/', $s2, $m2 );
		if( $m2 ){
			$data[ 'host' ] = $m2[ 1 ];
			$s3 = $m2[ 2 ];
		}else{
			$s3 = $s2;
		}
		if( $data[ 'host' ] ){
			preg_match( '/^([^:]*):(.*)$/', $data[ 'host' ], $m2_1 );
			if( $m2_1 ){
				if( isset( $m2_1[ 1 ] ) ){
					if( preg_match( '/^\d+(\.\d+)+$/', $m2_1[ 1 ], $t001 ) ){
						$data[ 'ip' ] = $m2_1[ 1 ];
					}else{
						$data[ 'hostname' ] = $m2_1[ 1 ];
					}
				}
				if( isset( $m2_1[ 2 ] ) ){
					$data[ 'port' ] = $m2_1[ 2 ];
				}
			}
		}
		if( !$s3 ){
			return array(
				''        => 'OK',
				'type'    => 'Url',
				'action'  => 'ParseString2UrlArray',
				'@'       => array(
				'url'     => $data
				)
			);
		}
		preg_match( '/^([^?#]*)(\?([^#]*))?(#(.*))?$/', $s3, $m3 );
		if( $m3 ){
			if( isset( $m3[ 1 ] ) ){
				$data[ 'path' ] = $m3[ 1 ];
				$data[ 'pathlist' ] = explode( '/', preg_replace( '/^\//', '', $data[ 'path' ] ) );
			}
			if( isset( $m3[ 2 ] ) ){
				$data[ 'search' ] = $m3[ 2 ];
			}
			if( isset( $m3[ 3 ] ) ){
				$data[ 'query' ] = $m3[ 3 ];
				$split = explode( '&', $data[ 'query' ] );
				if( $split ){
					$data[ 'querykeyvalue' ] = array();
					$data[ 'querylist' ] = array();
					for( $i = 0; $i < sizeof( $split ); $i++ ){
						$item = $split[ $i ];
						preg_match( '/^([^=&]+)(=([^&]*))?$/', $item, $match );
						if( $match ){
							$key = $match[ 1 ];
							if( $key ){
								$value = $match[ 3 ];
								if( $value ){
									if( isset( $data[ 'querykeyvalue' ][ $key ] ) ){
										if( is_array( $data[ 'querykeyvalue' ][ $key ] ) ){
											array_push( $data[ 'querykeyvalue' ][ $key ], urldecode( $value ) );
										}else{
											$data[ 'querykeyvalue' ][ $key ] = array(
												$data[ 'querykeyvalue' ][ $key ],
												urldecode( $value )
											);
										}
									}else{
										$data[ 'querykeyvalue' ][ $key ] = urldecode( $value );
									}
								}else{
									array_push( $data[ 'querylist' ], urldecode( $key ) );
								}
							}
						}
					}
				}
			}
			if( isset( $m3[ 4 ] ) ){
				$data[ 'hash' ] = $m3[ 4 ];
			}
			if( isset( $m3[ 5 ] ) ){
				$data[ 'hashstr' ] = $m3[ 5 ];
			}
		}
	}

	return array(
		''        => 'OK',
		'type'    => 'Url',
		'action'  => 'ParseString2UrlArray',
		'@'       => array(
		'url'     => $data
		)
	);

}

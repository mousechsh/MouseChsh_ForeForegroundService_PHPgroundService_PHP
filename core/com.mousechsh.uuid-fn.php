<?php
/***************************************************************
UUID Generate Function
======================
Use for generate a uuid
4 format
-	Format 1 is /^[0-9A-F]{32}$/
-	Format 2 is /^\{[0-9A-F]{8}-[0-9A-F]{4}-[0-9A-F]{4}-[0-9A-F]{4}-[0-9A-F]{12}\}$/
-	Format 3 is /^[0-9A-Za-z+~]{22}={2}$/
-	Format 4 is /^\{[0-9A-Za-z+~]{22}\}$/
***************************************************************/
// UUID 生成函数
// 返回值：UUID 无分隔符字符串
function _MouseChsh_UUID( $flag = 0 ){

	// 根据时间设置随机种子值
	mt_srand( ( double )microtime() * 10000 );
	// 创建 UUID
	$uuid = strtoupper( md5( uniqid( rand(), true ), ( $flag ? true: false ) ) );
	if( $flag ){
		$str = implode( unpack( 'H*', $uuid ) );
		if( preg_match( '/^4D6F757365436873685A524C00000000/', $str ) ){
			return _MouseChsh_UUID( $flag );
		}
	}else{
		if( preg_match( '/^4D6F757365436873685A524C00000000/', $uuid ) ){
			return _MouseChsh_UUID( $flag );
		}
	}

	return $uuid;

}

function MouseChsh_UUID( $flag = 0, $length = 1, $split = '', $base64ext = '+~', $trim = false ){

	/* Format: FFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFF (32) */
	/* Format: FFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFF (64) */
	/* Format: FFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFF (128) */
	if( $flag == 0 ){
		if( $length != 1 && $length != 2 && $length != 4 ){
			$length = 1;
		}
		if( $split != '' && $split != ' ' && $split != '-' && $split != '=' ){
			$split = '';
		}
		if( $length == 1 ){
			return _MouseChsh_UUID();
		}else if( $length == 2 ){
			return _MouseChsh_UUID() . $split . _MouseChsh_UUID();
		}else if( $length == 4 ){
			return _MouseChsh_UUID() . $split . _MouseChsh_UUID() . $split . _MouseChsh_UUID() . $split . _MouseChsh_UUID();
		}
	}
	/* Format: {FFFFFFFF-FFFF-FFFF-FFFF-FFFFFFFFFFFF} */
	if( $flag == 1 ){
		// 创建 UUID
		$uuid = _MouseChsh_UUID();
		// 添加分隔符
		$hyphen = chr(45); // "-"
		$uuid = chr( 123 ) // "{"
			. substr( $uuid, 0, 8 ) . $hyphen
			. substr( $uuid, 8, 4 ) . $hyphen
			. substr( $uuid, 12, 4 ) . $hyphen
			. substr( $uuid, 16, 4 ) . $hyphen
			. substr( $uuid, 20, 12 )
			. chr( 125 ); // "}"
		return $uuid;
	}
	/* Format: /////////////////////w== (22+2) */
	/* Format: //////////////////////////////////////////8= (43+1) */
	/* Format: /////////////////////////////////////////////////////////////////////////////////////w== (86+2) */
	if( $flag == 2 ){
		if( $length != 1 && $length != 2 && $length != 4 ){
			$length = 1;
		}
		if( $base64ext != '+~' && $base64ext != '+-' && $base64ext != '+/' && $base64ext != '_-' && $base64ext != '()' ){
			$base64ext = '+~';
		}
		if( $length == 1 ){
			$uuid = _MouseChsh_UUID( 1 );
		}else if( $length == 2 ){
			$uuid = _MouseChsh_UUID( 1 ) . _MouseChsh_UUID( 1 );
		}else if( $length == 4 ){
			$uuid = _MouseChsh_UUID( 1 ) . _MouseChsh_UUID( 1 ) . _MouseChsh_UUID( 1 ) . _MouseChsh_UUID( 1 );
		}
		// 创建 BASE64 UUID
		$uuid = strtr( base64_encode( $uuid ), '+/', $base64ext );
		if( $trim ){
			$uuid = rtrim( $uuid, '=' );
		}
		return $uuid;
	}
	/* Format: {XXXXXXXXXXXXXXXXXXXXXX} */
	if( $flag == 3 ){
		// 创建 UUID
		$uuid = _MouseChsh_UUID( 1 );
		// 创建 BASE64 UUID
		$uuid = chr( 123 )
			. rtrim( strtr( base64_encode( $uuid ), '+/', '+~' ), '=')
			. chr( 125 );
		return $uuid;
	}

}

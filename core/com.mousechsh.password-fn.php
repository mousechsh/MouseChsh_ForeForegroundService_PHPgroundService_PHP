<?php
/***************************************************************
Password Util Function
======================
can create password and salt from a string
can check password with string, password and salt
***************************************************************/
// 创建密码
// 参数：原始密码
// 返回值：加密后的密码和加密盐
function MouseChsh_Password_Make( $origin, $type = 'PHP-Simple' ){

	$_PasswordType = MouseChsh_Password_GetType();
	switch( $type ){
		case $_PasswordType[ 0 ]:
			return _MouseChsh_Password_Make_Simple( $origin );
		case $_PasswordType[ 1 ]:
			return _MouseChsh_Password_Make_Simple_Java( $origin );
	}

}

function _MouseChsh_Password_Make_Simple( $origin ){

	// 创建一个 UUID 作为第一次的盐
	$uuid = MouseChsh_UUID();
	// 使用原始密码和第一次的盐进行加密
	$crypt = crypt( $origin, '$1$' . $uuid );
	// 截取第一次加密的内容作为第二次的盐，也就是返回的盐
	$salt = substr( $crypt, 12 );
	// 使用原始密码和第二次的盐加密
	$crypt1 = crypt( $origin, '$2a$09$' . $salt );
	// 去除加密方法标识和第二次加密的盐
	$code = substr( $crypt1, -32 );

	// 返回结果
	return array(
		'salt' => $salt,
		'code' => $code
	);

}

function _MouseChsh_Password_Make_Simple_Java( $origin ){

	$salt = strtolower( MouseChsh_UUID( 0, 2 ) );
	$code = hash_pbkdf2( 'sha1', $origin, pack( 'H*', $salt ), 1000, 64, false );

	return array(
		'salt' => $salt,
		'code' => $code
	);

}

// 验证密码是否正确
// 参数：原始密码，加密后的密码，加密盐
// 返回值：true 为密码正确，false 为密码错误
function MouseChsh_Password_Check( $origin, $code, $salt, $type = 'PHP-Simple' ){

	$_PasswordType = MouseChsh_Password_GetType();
	switch( $type ){
		case $_PasswordType[ 0 ]:
			return _MouseChsh_Password_Check_Simple( $origin, $code, $salt );
		case $_PasswordType[ 1 ]:
			return _MouseChsh_Password_Check_Simple_Java( $origin, $code, $salt );
	}

}

function _MouseChsh_Password_Check_Simple( $origin, $code, $salt ){

	// 使用原始密码和密码盐进行加密
	$crypt = crypt( $origin, '$2a$09$' . $salt );
	$salt1 = substr( $salt, 0, -1 );

	// 使用加密结果和拼接后的加密结果进行判断
	return $crypt == '$2a$09$' . $salt1 . $code;

}

function _MouseChsh_Password_Check_Simple_Java( $origin, $code, $salt ){

	$crypt = hash_pbkdf2( 'sha1', $origin, pack( 'H*', strtolower( $salt ) ), 1000, 64, false );

	return $code == $crypt;

}

function MouseChsh_Password_GetType(){

	return array(
		'PHP-Simple'
	,	'Java-Simple'
	);

}

/**********************************************************************************
 * PBKDF2WithHmacSHA1                                                             *
 * 原始密码为：123456                                                               *
 * 加密后的密码1为：5607e8b5822d6f0c4e48ef04300872c4e98dc3e1524a581ddcffa04def9eadb8 *
 * 加密后的密码2为：3cce7c2a7d84c6ea2fec23e644b5ed39ea31dff02bd116be795fd69c1f30f2af *
 * 验证结果为：true                                                                 *
 **********************************************************************************/

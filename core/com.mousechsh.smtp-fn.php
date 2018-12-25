<?php

function MouseChsh_SMTP_CreateSocket( $server, $port ){

	$socket = socket_create( AF_INET, SOCK_STREAM, getprotobyname( 'tcp' ) );
	if( !$socket ){
		return array(
			''    => 'err',
			'msg' => socket_strerror( socket_last_error() )
		);
	}
	socket_set_block( $socket );
	if( !socket_connect( $socket, $server, $port ) ){
		return array(
			''    => 'err',
			'msg' => socket_strerror( socket_last_error() )
		);
	}
	$str = socket_read( $socket, 1024 );
	if( !preg_match( "/220+?/", $str ) ){
		return array(
			''    => 'err',
			'msg' => $str
		);
	}

	return array(
		''       => 'OK',
		'socket' => $socket,
		'msg'    => $str
	);

}

function MouseChsh_SMTP_CreateSocketWithSSL( $server, $port ){

	$addr   = 'tcp://' . $server . ':' . $port;
	$socket = stream_socket_client( $addr, $errNo, $errStr, 30 );
	if( !$socket ){
		return array(
			''    => 'err',
			'msg' => $errStr
		);
	}
	stream_socket_enable_crypto( $socket, true, STREAM_CRYPTO_METHOD_SSLv23_CLIENT );
	stream_set_blocking(         $socket, 1 );
	$str = fread( $socket, 1024 );
	if( !preg_match( "/220+?/", $str ) ){
		return array(
			''    => 'err',
			'msg' => $str
		);
	}

	return array(
		''       => 'OK',
		'socket' => $socket,
		'msg'    => $str
	);

}

function MouseChsh_SMTP_CloseSocket( $socket ){

	if( isset( $socket ) && is_object( $socket ) ){
		$socket.close();
		return array(
			'' => 'OK'
		);
	}

	return array(
		''    => 'err',
		'msg' => 'No resource can to be close'
	);

}

function MouseChsh_SMTP_CloseSocketWithSSL( $socket ){

	if( isset( $socket ) && is_object( $socket ) ){
		stream_socket_shutdown( $socket, STREAM_SHUT_WR );
		return array(
			'' => 'OK'
		);
	}

	return array(
		''    => 'err',
		'msg' => 'No resource can to be close'
	);

}

function MouseChsh_SMTP_BuildSendCommandList(
    $username
,   $password
,   $from
,   $to
,   $cc
,   $bcc
,   $subject
,   $body
,   $attachment
){

	$separator = "----=_Part_" . md5( $from . time() ) . uniqid();
	$command = array(
		                       array( "HELO sendmail\r\n",                 250 )
	);
	if( !empty( $username ) ){
		$command[]           = array( "AUTH LOGIN\r\n",                    334 );
		$command[]           = array( base64_encode( $username ) . "\r\n", 334 );
		$command[]           = array( base64_encode( $password ) . "\r\n", 235 );
	}
	$command[]               = array( "MAIL FROM:<" . $from . ">\r\n",     250 );
	$header                  = "FROM: <" . $from . ">\r\n";
	if( !empty( $to ) ){
		$count = count( $to );
		if( $count == 1 ){
			$command[]       = array( "RCPT TO: <" . $to[ 0 ] . ">\r\n",   250 );
			$header         .= "TO: <" . $to[ 0 ] . ">\r\n";
		}else{
			for( $i = 0; $i < $count; $i++ ){
				$command[]   = array( "RCPT TO: <" . $to[ $i ] . ">\r\n",  250 );
				if( $i == 0 ){
					$header .= "TO: <" . $to[ $i ] . ">";
				}else if( $i + 1 == $count ){
					$header .= ",<" . $to[ $i ] . ">\r\n";
				}else{
					$header .= ",<" . $to[ $i ] . ">";
				}
			}
		}
	}
	if( !empty( $cc ) ){
		$count = count( $cc );
		if( $count == 1 ){
			$command[]       = array( "RCPT TO: <" . $cc[ 0 ] . ">\r\n",   250 );
			$header         .= "CC: <" . $cc[ 0 ] . ">\r\n";
		}else{
			for( $i = 0; $i < $count; $i++ ){
				$command[]   = array( "RCPT TO: <" . $cc[ $i ] . ">\r\n",  250 );
				if( $i == 0 ){
					$header .= "CC: <" . $cc[ $i ] . ">\r\n";
				}else if( $i + 1 == $count ){
					$header .= ",<" . $cc[ $i ] . ">\r\n";
				}else{
					$header .= ",<" . $cc[ $i ] . ">";
				}
			}
		}
	}
	if( !empty( $bcc ) ){
		$count = count( $bcc );
		if( $count == 1 ){
			$command[]       = array( "RCPT TO: <" . $bcc[ 0 ] . ">\r\n",  250 );
			$header         .= "BCC: <" . $bcc[ 0 ] . ">\r\n";
		}else{
			for( $i = 0; $i < $count; $i++ ){
				$command[]   = array( "RCPT TO: <" . $bcc[ $i ] . ">\r\n", 250 );
				if( $i == 0 ){
					$header .= "BCC: <" . $bcc[ $i ] . ">\r\n";
				}else if( $i + 1 == $count ){
					$header .= ",<" . $bcc[ $i ] . ">\r\n";
				}else{
					$header .= ",<" . $bcc[ $i ] . ">";
				}
			}
		}
	}
	$header                 .= "Subject: =?UTF-8?B?" . base64_encode( $subject ) ."?=\r\n";
	if( isset( $attachment ) ){
		$header             .= "Content-Type: multipart/mixed;\r\n";
	}else if( false ){
		$header             .= "Content-Type: multipart/related;\r\n";
	}else{
		$header             .= "Content-Type: multipart/alternative;\r\n";
	}
	$header                 .= "\t" . 'boundary="' . $separator . '"';
	$header                 .= "\r\nMIME-Version: 1.0\r\n";
	$header                 .= "\r\n--" . $separator . "\r\n";
	$header                 .= "Content-Type:text/html; charset=utf-8\r\n";
	$header                 .= "Content-Transfer-Encoding: base64\r\n\r\n";
	$header                 .= base64_encode( $body ) . "\r\n";
	$header                 .= "--" . $separator . "\r\n";
	if( !empty( $attachment ) ){
		$count = count( $attachment );
		for( $i = 0; $i < $count; $i++ ){
			$header         .= "\r\n--" . $separator . "\r\n";
			$header         .= "Content-Type: " . MouseChsh_SMTP_GetMIMEType( $attachment[ $i ] ) . '; name="=?UTF-8?B?' . base64_encode( basename( $attachment[ $i ] ) ) . '?="' . "\r\n";
			$header         .= "Content-Transfer-Encoding: base64\r\n";
			$header         .= 'Content-Disposition: attachment; filename="=?UTF-8?B?' . base64_encode( basename( $attachment[ $i ] ) ) . '?="' . "\r\n";
			$header         .= "\r\n";
			$header         .= MouseChsh_SMTP_ReadFile( $attachment[ $i ] );
			$header         .= "\r\n--" . $separator . "\r\n";
		}
	}
	$header                 .= "\r\n.\r\n";
	$command[]               = array( "DATA\r\n",                          354 );
	$command[]               = array( $header,                             250 );
	$command[]               = array( "QUIT\r\n",                          221 );

	return $command;

}

function MouseChsh_SMTP_GetMIMEType( $file ){

	if( file_exists( $file ) ){
		$mime = mime_content_type( $file );
		return $mime;
	}else {
		return false;
	}

}

function MouseChsh_SMTP_ReadFile( $file ){

	if( file_exists( $file ) ){
		$file_obj = file_get_contents( $file );
		return base64_encode( $file_obj );
	}else{
		return '';
	}

}

function MouseChsh_SMTP_SendCommand( $socket, $command, $code ){

	try{
		if( socket_write( $socket, $command, strlen( $command ) ) ){
			if( empty( $code ) ){
				return array(
					'' => 'Continue'
				);
			}
			$data = trim( socket_read( $socket, 1024 ) );
			if( $data ){
				$pattern = "/^" . $code . "+?/";
				if( preg_match( $pattern, $data ) ){
					return array(
						'' => 'OK'
					);
				}else {
					return array(
						''    => 'Fault',
						'msg' => "Error: " . $data . " | command: [" . $code . '] ' . $command
					);
				}
			}else{
				return array(
					''    => 'Fault',
					'msg' => "Error:" . socket_strerror( socket_last_error() )
				);
			}
		}else{
			return array(
				''    => 'Fault',
				'msg' => "Error:" . socket_strerror( socket_last_error() )
			);
		}
	}
	catch( \Exception $e ){
		return array(
			''    => 'Fault',
			'msg' => "Error:" . $e -> getMessage()
		);
	}

};

function MouseChsh_SMTP_SendCommandWithSSL( $socket, $command, $code ){

	try{
		if( fwrite( $socket, $command ) ){
			if( empty( $code ) ){
				return array(
					'' => 'Continue'
				);
			}
			$data = trim( fread( $socket, 1024 ) );
			if( $data ){
				$pattern = "/^" . $code . "+?/";
				if( preg_match( $pattern, $data ) ){
					return array(
						'' => 'OK'
					);
				}else {
					return array(
						''    => 'Fault',
						'msg' => "Error: " . $data . " | command: [" . $code . '] ' . $command
					);
				}
			}else{
				return array(
					''    => 'Fault'
				);
			}
		}else{
			return array(
				''    => 'Fault',
				'msg' => "Error: " . $command . " send failed"
			);
		}
	}
	catch( \Exception $e ){
		return array(
			''    => 'Fault',
			'msg' => "Error:" . $e -> getMessage()
		);
	}
	
}

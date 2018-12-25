<?php
// namespace
namespace com\mousechsh;
// load function
require_once( 'com.mousechsh.smtp-fn.php' );
// class
class smtp{

	private $socket = null;
	private $isSecurity = false;
	private $authUserName = '';
	private $authPassword = '';
	private $command = null;

	public function open( $server, $port, $isSecurity = false ){

		if( $isSecurity ){
			$this -> isSecurity = true;
			$sk = MouseChsh_SMTP_CreateSocketWithSSL( $server, $port );
		}else{
			$this -> isSecurity = false;
			$sk = MouseChsh_SMTP_CreateSocket       ( $server, $port );
		}
	//	/* DEBUG POINT */ echo var_dump( $sk ); exit();
		if( $sk[ '' ] == 'OK' ){
			$this -> socket = $sk[ 'socket' ];
			return true;
		}else{
			throw new \Exception( $sk[ 'msg' ] );
			return false;
		}

	}

	public function setAuth( $username, $password ){

		$this -> authUserName = $username;
		$this -> authPassword = $password;

		return true;

	}

	public function makeMail(
	    $from
	,   $to
	,   $cc
	,   $bcc
	,   $subject
	,   $body
	,   $attachment
	){

		$this -> command = MouseChsh_SMTP_BuildSendCommandList(
		    $this -> authUserName
		,   $this -> authPassword
		,   $from
		,   $to
		,   $cc
		,   $bcc
		,   $subject
		,   $body
		,   $attachment
		);
	//	/* DEBUG POINT */ echo var_dump( $this -> command ); exit();
		if( isset( $this -> command ) && count( $this -> command ) > 0 ){
			return true;
		}

		return false;

	}

	public function send(){

		foreach( $this -> command as $value ){
			$result = $this -> isSecurity ? MouseChsh_SMTP_SendCommandWithSSL( $this -> socket, $value[ 0 ], $value[ 1 ] ) : MouseChsh_SMTP_SendCommand( $this -> socket, $value[ 0 ], $value[ 1 ] );
		//	/* DEBUG POINT */ echo var_dump( $result ); // exit();
			if( $result[ '' ] == 'Continue' || $result[ '' ] == 'OK' ){
				continue;
			}
		//	/* DEBUG POINT */ exit();
			return $result[ 'msg' ];
		}

	//	/* DEBUG POINT */ exit();
		return true;

	}

	public function close(){

		if( $this -> isSecurity ){
			MouseChsh_SMTP_CloseSocketWithSSL( $this -> socket );
		}else{
			MouseChsh_SMTP_CloseSocket       ( $this -> socket );
		}

	}

}

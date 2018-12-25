<?php
//
namespace com\mousechsh;
// load function
require_once( 'com.mousechsh.database-cs.php' );
// class
class database_rw{

	private $reader = null;
	private $writer = null;
	private $type = 'MySQL';

	function __construct( $config_r = null, $config_w = null, $type = null ){

		$this -> reader = new \com\mousechsh\database( $config_r, $type );
		$this -> writer = new \com\mousechsh\database( $config_w, $type );
		$this -> type   = $type;

	}

	public function connect(){

		if( isset( $this -> reader ) ){
			$this -> reader -> connect();
		}
		if( isset( $this -> writer ) ){
			$this -> writer -> connect();
		}

		return true;

	}

	public function execute( $sql, $para = null, $is_obj = false ){

		if( isset( $this -> reader ) ){
			return $this -> reader -> execute( $sql, $para, $is_obj );
		}

		return array(
			'result'  => false,
			'prepare' => null
		);

	}

	public function doexecute( $sql, $para = null, $is_obj = false ){

		if( isset( $this -> writer ) ){
			return $this -> writer -> execute( $sql, $para, $is_obj );
		}

		return array(
			'result'  => false,
			'prepare' => null
		);

	}

	public function expire( $key, $value ){

		return $this -> writer -> expire( $key, $value );

	}

	public function ttl( $key ){

		return $this -> reader -> ttl( $key );

	}

	public function set( $key, $value ){

		return $this -> writer -> set( $key, $value );

	}

	public function get( $key ){

		return $this -> reader -> get( $key );

	}

	public function del( $key ){

		return $this -> writer -> del( $key );

	}

	public function exists( $key ){

		return $this -> reader -> exists( $key );

	}

	public function setHash( $key, $hashKey, $value ){

		return $this -> writer -> setHash( $key, $hashKey, $value );

	}

	public function getHash( $key, $hashKey ){

		return $this -> reader -> getHash( $key, $hashKey );

	}

	public function getAllHash( $key ){

		return $this -> reader -> getAllHash( $key );

	}

	public function getAllHashKey( $key ){

		return $this -> reader -> getAllHashKey( $key );

	}

	public function getAllHashValue( $key ){

		return $this -> reader -> getAllHashValue( $key );

	}

	public function getHashLength( $key ){

		return $this -> reader -> getHashLength( $key );

	}

	public function existsHash( $key, $hashKey ){

		return $this -> reader -> existsHash( $key, $hashKey );

	}

	public function delHash( $key, $hashKey ){

		return $this -> writer -> delHash( $key, $hashKey );

	}

	public function setList( $key, $listKey, $value ){

		return $this -> writer -> setList( $key, $listKey, $value );

	}

	public function getList( $key, $listKey ){

		return $this -> reader -> getList( $key, $listKey );

	}

	public function getListBetween( $key, $listStartIndex, $listEndIndex ){

		return $this -> reader -> getListBetween( $key, $listStartIndex, $listEndIndex );

	}

	public function pushListAtStart( $key, $value ){

		return $this -> writer -> pushListAtStart( $key, $value );

	}

	public function popListAtStart( $key ){

		return $this -> writer -> popListAtStart( $key );

	}

	public function pushListAtEnd( $key, $value ){

		return $this -> writer -> pushListAtEnd( $key, $value );

	}

	public function popListAtEnd( $key ){

		return $this -> writer -> popListAtEnd( $key );

	}

	public function switchToList( $fromKey, $toKey ){

		return $this -> writer -> switchToList( $fromKey, $toKey );

	}

	public function insertBeforeList( $key, $index, $value ){

		return $this -> writer -> insertBeforeList( $key, $index, $value );

	}

	public function insertAfterList( $key, $index, $value ){

		return $this -> writer -> insertAfterList( $key, $index, $value );

	}

	public function getListLength( $key ){

		return $this -> reader -> getListLength( $key );

	}

	public function delList( $key, $listkey, $countMatch ){

		return $this -> writer -> delList( $key, $listkey, $countMatch );

	}

	public function beginTransaction(){

		return $this -> writer -> beginTransaction();

	}

	public function commitTransaction(){

		return $this -> writer -> commitTransaction();

	}

	public function rollBackTransaction(){

		return $this -> writer -> rollBackTransaction();

	}

}

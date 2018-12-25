<?php
//
namespace com\mousechsh;
// load function
require_once( 'com.mousechsh.database-fn.php' );
// class
class database{

	private $pdo = null;
	private $cfg = null;
	private $type = 'MySQL';

	function __construct( $config = null, $type = null ){

		if( !isset( $type ) && isset( $config ) && isset( $config[ 'type' ] ) ){
			$type = $config[ 'type' ];
		}
		if( $type == 'MySQL' ){
			$result = MouseChsh_Database_MySQL_CheckPDOConfig( null, $config );
			if( isset( $result ) && isset( $result[ '' ] ) && $result[ '' ] == 'OK' && isset( $result[ '@' ] ) ){
				$this -> cfg = $result[ '@' ];
			}
			$this -> type = $type;
		}else if( $type == 'PostgreSQL' ){
			$result = MouseChsh_Database_PostgreSQL_CheckPDOConfig( null, $config );
			if( isset( $result ) && isset( $result[ '' ] ) && $result[ '' ] == 'OK' && isset( $result[ '@' ] ) ){
				$this -> cfg = $result[ '@' ];
			}
			$this -> type = $type;
		}else if( $type == 'Redis' ){
			$this -> type = $type;
			$this -> cfg = $config;
		}

	}

	public function connect(){

		if( isset( $this -> pdo ) ){
			return;
		}
		if( $this -> type == 'MySQL' ){
			$result = MouseChsh_Database_MySQL_ConnectPDO( null, $this -> cfg );
		//	/* DEBUG POINT */ echo var_dump( $result );
			if( isset( $result ) && isset( $result[ '' ] ) &&  $result[ '' ] == 'OK' &&  isset( $result[ '@' ] ) ){
				$this -> pdo = $result[ '@' ];
				return true;
			}
			return false;
		}else if( $this -> type == 'PostgreSQL' ){
			$result = MouseChsh_Database_PostgreSQL_ConnectPDO( null, $this -> cfg );
		//	/* DEBUG POINT */ echo var_dump( $result );
			if( isset( $result ) && isset( $result[ '' ] ) &&  $result[ '' ] == 'OK' &&  isset( $result[ '@' ] ) ){
				$this -> pdo = $result[ '@' ];
				return true;
			}
			return false;
		}else if( $this -> type == 'Redis' ){
			$result = MouseChsh_Database_Redis_ConnectDatabase( null, $this -> cfg );
		//	/* DEBUG POINT */ echo var_dump( $result );
			if( isset( $result ) && isset( $result[ '' ] ) &&  $result[ '' ] == 'OK' &&  isset( $result[ '@' ] ) ){
				$this -> pdo = $result[ '@' ];
				return true;
			}
			return false;
		}

	}

	/*

	DEMO:

	$result = $db -> execute( $sql, array(
		':C_A' => 'A_VALUE',
		':C_B' => 'B_VALUE'
	) );
	if( $result[ 'status' ] == 'OK' && $result[ 'result' ] ){
		if( $row = $result[ 'prepare' ] -> fetch() ){
			 $c = $row[ 'C_C' ];
		}
	}

	*/

	public function execute( $sql, $para = null, $is_obj = false ){

		if( $this -> type == 'MySQL' || $this -> type == 'PostgreSQL' ){
			if( $is_obj ){
				$result = MouseChsh_Database_MySQL_Execute( null, $this -> pdo, $sql, null, $para );
			}else{
				$result = MouseChsh_Database_MySQL_Execute( null, $this -> pdo, $sql, $para );
			}
		//	/* DEBUG POINT */ echo var_dump( $result ); // exit();
			if( isset( $result ) && isset( $result[ '' ] ) &&  $result[ '' ] == 'OK' &&  isset( $result[ '@' ] ) ){
				return array(
					'result'  => $result[ 'result' ],
					'prepare' => $result[ 'prepare' ]
				);
			}
			return array(
				'result'   => false,
				'prepare'  => null,
				'err_data' => ( isset( $result[ 'data' ] ) ? $result[ 'data' ] : null )
			);
		}

	}

	public function expire( $key, $value ){

		if( $this -> type == 'Redis' ){
			$result = MouseChsh_Database_Redis_Execute( null, $this -> pdo, 'expire', $key, $value );
		//	/* DEBUG POINT */ echo var_dump( $result );
			if( isset( $result ) && isset( $result[ '' ] ) &&  $result[ '' ] == 'OK' &&  isset( $result[ '@' ] ) ){
				return true;
			}
			return false;
		}

	}

	public function ttl( $key ){

		if( $this -> type == 'Redis' ){
			$result = MouseChsh_Database_Redis_Execute( null, $this -> pdo, 'ttl', $key );
			if( isset( $result ) && isset( $result[ '' ] ) &&  $result[ '' ] == 'OK' ){
				return $result[ '@' ];
			}
			return null;
		}

	}

	public function set( $key, $value ){

		if( $this -> type == 'Redis' ){
			$result = MouseChsh_Database_Redis_Execute( null, $this -> pdo, 'set', $key, $value );
		//	/* DEBUG POINT */ echo var_dump( $result );
			if( isset( $result ) && isset( $result[ '' ] ) &&  $result[ '' ] == 'OK' &&  isset( $result[ '@' ] ) ){
				return true;
			}
			return false;
		}

	}

	public function get( $key ){

		if( $this -> type == 'Redis' ){
			$result = MouseChsh_Database_Redis_Execute( null, $this -> pdo, 'get', $key );
			if( isset( $result ) && isset( $result[ '' ] ) &&  $result[ '' ] == 'OK' ){
				return $result[ '@' ];
			}
			return null;
		}

	}

	public function del( $key ){

		if( $this -> type == 'Redis' ){
			$result = MouseChsh_Database_Redis_Execute( null, $this -> pdo, 'del', $key );
			if( isset( $result ) && isset( $result[ '' ] ) &&  $result[ '' ] == 'OK' ){
				return $result[ '@' ];
			}
			return null;
		}

	}

	public function exists( $key ){

		if( $this -> type == 'Redis' ){
			$result = MouseChsh_Database_Redis_Execute( null, $this -> pdo, 'exists', $key );
			if( isset( $result ) && isset( $result[ '' ] ) &&  $result[ '' ] == 'OK' ){
				return $result[ '@' ];
			}
			return null;
		}

	}

	public function setHash( $key, $hashKey, $value ){

		if( $this -> type == 'Redis' ){
			$result = MouseChsh_Database_Redis_Execute( null, $this -> pdo, 'set-hash', $key, $value, $hashKey );
			if( isset( $result ) && isset( $result[ '' ] ) &&  $result[ '' ] == 'OK' &&  isset( $result[ '@' ] ) ){
				return true;
			}
			return false;
		}

	}

	public function getHash( $key, $hashKey ){

		if( $this -> type == 'Redis' ){
			$result = MouseChsh_Database_Redis_Execute( null, $this -> pdo, 'get-hash', $key, null, $hashKey );
			if( isset( $result ) && isset( $result[ '' ] ) &&  $result[ '' ] == 'OK' ){
				return $result[ '@' ];
			}
			return null;
		}

	}

	public function getAllHash( $key ){

		if( $this -> type == 'Redis' ){
			$result = MouseChsh_Database_Redis_Execute( null, $this -> pdo, 'get-hash-all', $key );
			if( isset( $result ) && isset( $result[ '' ] ) &&  $result[ '' ] == 'OK' ){
				return $result[ '@' ];
			}
			return null;
		}

	}

	public function getAllHashKey( $key ){

		if( $this -> type == 'Redis' ){
			$result = MouseChsh_Database_Redis_Execute( null, $this -> pdo, 'get-hash-all_key', $key );
			if( isset( $result ) && isset( $result[ '' ] ) &&  $result[ '' ] == 'OK' ){
				return $result[ '@' ];
			}
			return null;
		}

	}

	public function getAllHashValue( $key ){

		if( $this -> type == 'Redis' ){
			$result = MouseChsh_Database_Redis_Execute( null, $this -> pdo, 'get-hash-all_value', $key );
			if( isset( $result ) && isset( $result[ '' ] ) &&  $result[ '' ] == 'OK' ){
				return $result[ '@' ];
			}
			return null;
		}

	}

	public function getHashLength( $key ){

		if( $this -> type == 'Redis' ){
			$result = MouseChsh_Database_Redis_Execute( null, $this -> pdo, 'get-hash-length', $key );
			if( isset( $result ) && isset( $result[ '' ] ) &&  $result[ '' ] == 'OK' ){
				return $result[ '@' ];
			}
			return null;
		}

	}

	public function existsHash( $key, $hashKey ){

		if( $this -> type == 'Redis' ){
			$result = MouseChsh_Database_Redis_Execute( null, $this -> pdo, 'exists-hash', $key, null, $hashKey );
			if( isset( $result ) && isset( $result[ '' ] ) &&  $result[ '' ] == 'OK' ){
				return $result[ '@' ];
			}
			return null;
		}

	}

	public function delHash( $key, $hashKey ){

		if( $this -> type == 'Redis' ){
			$result = MouseChsh_Database_Redis_Execute( null, $this -> pdo, 'del-hash', $key, null, $hashKey );
			if( isset( $result ) && isset( $result[ '' ] ) &&  $result[ '' ] == 'OK' ){
				return $result[ '@' ];
			}
			return null;
		}

	}

	public function setList( $key, $listKey, $value ){

		if( $this -> type == 'Redis' ){
			$result = MouseChsh_Database_Redis_Execute( null, $this -> pdo, 'set-list', $key, $value, $listKey );
			if( isset( $result ) && isset( $result[ '' ] ) &&  $result[ '' ] == 'OK' ){
				return $result[ '@' ];
			}
			return null;
		}

	}

	public function getList( $key, $listKey ){

		if( $this -> type == 'Redis' ){
			$result = MouseChsh_Database_Redis_Execute( null, $this -> pdo, 'get-list', $key, null, $listKey );
			if( isset( $result ) && isset( $result[ '' ] ) &&  $result[ '' ] == 'OK' ){
				return $result[ '@' ];
			}
			return null;
		}

	}

	public function getListBetween( $key, $listStartIndex, $listEndIndex ){

		if( $this -> type == 'Redis' ){
			$result = MouseChsh_Database_Redis_Execute( null, $this -> pdo, 'get_range-list', $key, null, $listStartIndex, $listEndIndex );
			if( isset( $result ) && isset( $result[ '' ] ) &&  $result[ '' ] == 'OK' ){
				return $result[ '@' ];
			}
			return null;
		}

	}

	public function pushListAtStart( $key, $value ){

		if( $this -> type == 'Redis' ){
			$result = MouseChsh_Database_Redis_Execute( null, $this -> pdo, 'push_start-list', $key, $value );
			if( isset( $result ) && isset( $result[ '' ] ) &&  $result[ '' ] == 'OK' ){
				return $result[ '@' ];
			}
			return null;
		}

	}

	public function popListAtStart( $key ){

		if( $this -> type == 'Redis' ){
			$result = MouseChsh_Database_Redis_Execute( null, $this -> pdo, 'pop_start-list', $key );
			if( isset( $result ) && isset( $result[ '' ] ) &&  $result[ '' ] == 'OK' ){
				return $result[ '@' ];
			}
			return null;
		}

	}

	public function pushListAtEnd( $key, $value ){

		if( $this -> type == 'Redis' ){
			$result = MouseChsh_Database_Redis_Execute( null, $this -> pdo, 'push_end-list', $key, $value );
			if( isset( $result ) && isset( $result[ '' ] ) &&  $result[ '' ] == 'OK' ){
				return $result[ '@' ];
			}
			return null;
		}

	}

	public function popListAtEnd( $key ){

		if( $this -> type == 'Redis' ){
			$result = MouseChsh_Database_Redis_Execute( null, $this -> pdo, 'pop_end-list', $key );
			if( isset( $result ) && isset( $result[ '' ] ) &&  $result[ '' ] == 'OK' ){
				return $result[ '@' ];
			}
			return null;
		}

	}

	public function switchToList( $fromKey, $toKey ){

		if( $this -> type == 'Redis' ){
			$result = MouseChsh_Database_Redis_Execute( null, $this -> pdo, 'pop_end-push_start-list', $fromKey, null, $toKey );
			if( isset( $result ) && isset( $result[ '' ] ) &&  $result[ '' ] == 'OK' ){
				return $result[ '@' ];
			}
			return null;
		}

	}

	public function insertBeforeList( $key, $index, $value ){

		if( $this -> type == 'Redis' ){
			$result = MouseChsh_Database_Redis_Execute( null, $this -> pdo, 'insert_before-list', $key, $value, $index );
			if( isset( $result ) && isset( $result[ '' ] ) &&  $result[ '' ] == 'OK' ){
				return $result[ '@' ];
			}
			return null;
		}

	}

	public function insertAfterList( $key, $index, $value ){

		if( $this -> type == 'Redis' ){
			$result = MouseChsh_Database_Redis_Execute( null, $this -> pdo, 'insert_after-list', $key, $value, $index );
			if( isset( $result ) && isset( $result[ '' ] ) &&  $result[ '' ] == 'OK' ){
				return $result[ '@' ];
			}
			return null;
		}

	}

	public function getListLength( $key ){

		if( $this -> type == 'Redis' ){
			$result = MouseChsh_Database_Redis_Execute( null, $this -> pdo, 'get-list-length', $key );
			if( isset( $result ) && isset( $result[ '' ] ) &&  $result[ '' ] == 'OK' ){
				return $result[ '@' ];
			}
			return null;
		}

	}

	public function delList( $key, $listkey, $countMatch ){

		if( $this -> type == 'Redis' ){
			$result = MouseChsh_Database_Redis_Execute( null, $this -> pdo, 'del-list', $key, null, $listkey, $countMatch );
			if( isset( $result ) && isset( $result[ '' ] ) &&  $result[ '' ] == 'OK' ){
				return $result[ '@' ];
			}
			return null;
		}

	}

	public function beginTransaction(){

		if( $this -> type == 'MySQL' || $this -> type == 'PostgreSQL' ){
			$result = MouseChsh_Database_MySQL_BeginTransaction( null, $this -> pdo );
			if( isset( $result ) && isset( $result[ '' ] ) &&  $result[ '' ] == 'OK' &&  isset( $result[ '@' ] ) ){
				return true;
			}
			return false;
		}

	}

	public function commitTransaction(){

		if( $this -> type == 'MySQL' || $this -> type == 'PostgreSQL' ){
			$result = MouseChsh_Database_MySQL_CommitTransaction( null, $this -> pdo );
			if( isset( $result ) && isset( $result[ '' ] ) &&  $result[ '' ] == 'OK' &&  isset( $result[ '@' ] ) ){
				return true;
			}
			return false;
		}

	}

	public function rollBackTransaction(){

		if( $this -> type == 'MySQL' || $this -> type == 'PostgreSQL' ){
			$result = MouseChsh_Database_MySQL_RollBackTransaction( null, $this -> pdo );
			if( isset( $result ) && isset( $result[ '' ] ) &&  $result[ '' ] == 'OK' &&  isset( $result[ '@' ] ) ){
				return true;
			}
			return false;
		}

	}

}

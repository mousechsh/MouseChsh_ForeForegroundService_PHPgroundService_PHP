<?php
// Connect Database for MySQL only
function MouseChsh_Database_MySQL_ConnectDatabase( $obj, $config = null ){

	if( isset( $obj ) && isset( $obj[ '@' ] ) && isset( $obj[ '@' ][ 'config' ] ) ){
		$config = $obj[ '@' ][ 'config' ];
	}
	// Connecting
	$conn = @mysql_connect( $config[ 'host' ], $config[ 'user' ], $config[ 'password' ] );
	// Check if connected
	if( $conn ){
		// change connect to use UTF-8
		mysql_query( 'SET NAMES UTF8' );
		// select db
		@mysql_select_db( $config[ 'db' ] );
		// all green
		return array(
			''         => 'OK',
			'type'     => 'Database',
			'action'   => 'ConnectDatabase',
			'database' => 'MySQL',
			'@'        => true
		);
	}

	// connect fault
	return array(
		''         => 'Fault',
		'type'     => 'Database',
		'action'   => 'ConnectDatabase',
		'database' => 'MySQL',
		'@'        => false
	);

}

//
function MouseChsh_Database_MySQL_CheckPDOConfig( $obj, $config = null ){

	if( isset( $obj ) && isset( $obj[ '@' ] ) && isset( $obj[ '@' ][ 'config' ] ) ){
		$config = $obj[ '@' ][ 'config' ];
	}
	if( !isset( $config ) ){
		throw new Exception();
	}
	if( !isset( $config[ 'dbms' ] ) || $config[ 'dbms' ] == '' ){
		$config[ 'dbms' ] = 'mysql';
	}
	$config[ 'dsn' ] = "{$config['dbms']}:";
	if( !isset( $config[ 'host' ] ) || $config[ 'host' ] == '' ){
		$config[ 'host' ] = '127.0.0.1';
	}
	$config[ 'dsn' ] .= "host={$config['host']};";
	if( !isset( $config[ 'port' ] ) || $config[ 'port' ] == '' ){
		$config[ 'port' ] = 3306;
	}
	$config[ 'dsn' ] .= "port={$config['port']};";
	if( isset( $config[ 'database' ] ) && $config[ 'database' ] != '' ){
		$config[ 'dsn' ] .= "dbname={$config['database']}";
	}
	if( isset( $config[ 'path' ] ) && $config[ 'path' ] != '' ){
		$config[ 'dsn' ] .= "{$config['path']}";
	}
	if( !isset( $config[ 'user' ] ) ){
		$config[ 'user' ] = '';
	}
	if( !isset( $config[ 'password' ] ) ){
		$config[ 'password' ] = '';
	}
	if( !isset( $config[ 'dsn' ] ) || $config[ 'dsn' ] == '' ){
		throw new Exception();
	}

	return array(
		''         => 'OK',
		'type'     => 'Database',
		'action'   => 'CheckPDOConfig',
		'database' => 'MySQL',
		'@'        => $config
	);

}

// Connect Database by PDO
function MouseChsh_Database_MySQL_ConnectPDO( $obj, $config = null ){

	if( isset( $obj ) && isset( $obj[ '@' ] ) && isset( $obj[ '@' ][ 'config' ] ) ){
		$config = $obj[ '@' ][ 'config' ];
	}
	try{
	//	/* DEBUG POINT */ echo var_dump( $config ); // exit();
		// PDO Params
		$opts = array( PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION );
		// get connect object
		$pdo = new PDO( $config[ 'dsn' ], $config[ 'user' ], $config[ 'password' ], $opts );
		// MySQL Only
		if( $config[ 'dbms' ] == 'mysql' ){
			// set attributes
			$pdo -> setAttribute( PDO::CASE_NATURAL, PDO::ERRMODE_EXCEPTION );
			// change connect to use UTF-8
			$pdo -> exec( 'SET NAMES UTF8' );
		// SQLite Only
		}else if( $config[ 'dbms' ] == 'sqlite' ){
			// 关闭写同步，可选值：0 | OFF | 1 | NORMAL | 2 | FULL | 3 | EXTRA
			$pdo -> exec( 'PRAGMA synchronous = FULL' );
			// 设置编码，可选值："UTF-8"、"UTF-16"、"UTF-16le"、"UTF-16be";
			$pdo -> exec( 'PRAGMA encoding = "UTF-8"' );
		}
	//	/* DEBUG POINT */ echo var_dump( $pdo );
	//	/* DEBUG POINT */ echo var_dump( $pre -> errorCode() ); exit();
	//	/* DEBUG POINT */ echo var_dump( $pdo -> errorInfo() ); exit();
		// Check if connected
		if( $pdo -> errorCode() != '00000' && $pdo -> errorCode() != null ){
			return array(
				''         => 'Fault',
				'type'     => 'Database',
				'action'   => 'ConnectPDO',
				'database' => 'MySQL',
				'status'   => 'Error',
				'message'  => '', // $ErrMessage -> message = getLanguage( 0, array( 'Set charset error!', '设置字符集错误！' ) );
				'code'     => $pdo -> errorCode(),
				'data'     => $pdo -> errorInfo()
			);
		}
		// OK
		return array(
			''         => 'OK',
			'type'     => 'Database',
			'action'   => 'ConnectPDO',
			'database' => 'MySQL',
			'status'   => 'Connected',
			'@'        => $pdo
		);
	}
	catch( Exception $e ){
	//	/* DEBUG POINT */echo var_dump( $e ); exit();
		return array(
			''         => 'Fault',
			'type'     => 'Database',
			'action'   => 'ConnectPDO',
			'database' => 'MySQL',
			'status'   => 'Error',
			'message'  => '', // $ErrMessage -> message = getLanguage( 0, array( 'Connect Database error!', '连接数据库错误！' ) );
			'data'     => $e
		);
	}

}

// DataString to PDO Data
function _MouseChsh_Database_GetParaType( $type ){

	$type = strtolower( $type );
	switch( $type ){
		case 'int':
			return PDO::PARAM_INT;
		case 'string':
			return PDO::PARAM_STR;
		default:
			return null;
	}

}

// Run SQL
// param: pdo, sql text, para list, para object, prev execute
// 注意：在这里是支持两种格式的参数同时传递的，但是为了简化类的设计，在类的参数中改为只能二选一了。
function MouseChsh_Database_MySQL_Execute( $obj, $pdo = null, $sql = null, $para = null, $bindpara = null, $oldpre = null ){

	if( isset( $obj ) && isset( $obj[ '@' ] ) ){
		if( isset( $obj[ '@' ][ 'pdo' ] ) ){
			$pdo = $obj[ '@' ][ 'pdo' ];
		}
		if( isset( $obj[ '@' ][ 'sql' ] ) ){
			$sql = $obj[ '@' ][ 'sql' ];
		}
		if( isset( $obj[ '@' ][ 'para' ] ) ){
			$para = $obj[ '@' ][ 'para' ];
		}
		if( isset( $obj[ '@' ][ 'bindpara' ] ) ){
			$bindpara = $obj[ '@' ][ 'bindpara' ];
		}
		if( isset( $obj[ '@' ][ 'oldpre' ] ) ){
			$oldpre = $obj[ '@' ][ 'oldpre' ];
		}
	}
	if( !isset( $pdo ) || !isset( $sql ) ){
		return array(
			''         => 'Fault',
			'type'     => 'Database',
			'action'   => 'Execute',
			'database' => 'MySQL'
		);
	}
	try{
		// process pre execute and set sql text
		if( $oldpre && isset( $oldpre[ 'queryString' ] ) && $oldpre[ 'queryString' ] == $sql ){
			$pre = $oldpre;
		}else{
			$pre = $pdo -> prepare( $sql );
		}
		// bind param
		if( $bindpara && gettype( $bindpara ) == 'array' ){
			foreach( $bindpara as $key => $value ){
				$ty = _MouseChsh_Database_GetParaType( $value[ 1 ] );
				if( $ty != null ){
					$pre -> bindParam( $key, $value[ 0 ], $ty );
				}else{
					$pre -> bindParam( $key, $value[ 0 ] );
				}
			}
		}
		// process sql
		if( $para ){
			$rs = $pre -> execute( $para );
		}else{
			$rs = $pre -> execute();
		}
	//	/* DEBUG POINT */ echo var_dump( $pre -> errorCode() ); exit();
	//	/* DEBUG POINT */ echo var_dump( $pdo -> errorInfo() ); exit();
		// check if ok
		if( $pre -> errorCode() != '00000' ){
			return array(
				''         => 'Fault',
				'type'     => 'Database',
				'action'   => 'Execute',
				'database' => 'MySQL',
				'status'   => 'Error',
				'message'  => '', // $ErrMessage -> message = getLanguage( 0, array( 'Database execute error!', '操作数据库失败！' ) );
				'data'     => $pdo -> errorInfo()
			);
		}
		return array(
			''         => 'OK',
			'type'     => 'Database',
			'action'   => 'Execute',
			'database' => 'MySQL',
			'status'   => 'CanFetchData',
			'result'   => $rs,
			'prepare'  => $pre,
			'@'        => $pdo
		);
	}
	catch( Exception $e ){
		return array(
			''         => 'Fault',
			'type'     => 'Database',
			'action'   => 'Execute',
			'database' => 'MySQL',
			'status'   => 'Error',
			'message'  => '', // $ErrMessage -> message = getLanguage( 0, array( 'Database execute exception!', '操作数据库出现异常！' ) );
			'data'     => $e
		);
	}

}

// Begin Transaction
function MouseChsh_Database_MySQL_BeginTransaction( $obj, $pdo = null ){

	if( isset( $obj ) && isset( $obj[ '@' ] ) && isset( $obj[ '@' ][ 'pdo' ] ) ){
		$pdo = $obj[ '@' ][ 'pdo' ];
	}
	try{
		// Begin Transaction
		$pdo -> beginTransaction();
		//
		return array(
			''         => 'OK',
			'type'     => 'Database',
			'action'   => 'BeginTransaction',
			'database' => 'MySQL',
			'status'   => 'BeginTransaction',
			'@'        => $pdo
		);
	}
	catch( Exception $e ){
		return array(
			''         => 'Fault',
			'type'     => 'Database',
			'action'   => 'BeginTransaction',
			'database' => 'MySQL',
			'status'   => 'Error',
			'message'  => '', // $ErrMessage -> message = getLanguage( 0, array( 'Database begin transaction error!', '开启数据库事务出现异常！' ) );
			'data'     => $e
		);
	}

}

// Commit Transaction
function MouseChsh_Database_MySQL_CommitTransaction( $obj, $pdo = null ){

	if( isset( $obj ) && isset( $obj[ '@' ] ) && isset( $obj[ '@' ][ 'pdo' ] ) ){
		$pdo = $obj[ '@' ][ 'pdo' ];
	}
	try{
		// Commit Transaction
		$pdo -> commit();
		//
		return array(
			''         => 'OK',
			'type'     => 'Database',
			'action'   => 'CommitTransaction',
			'database' => 'MySQL',
			'status'   => 'CommitTransaction',
			'@'        => $pdo
		);
	}
	catch( Exception $e ){
		// Rollback Transaction
		$pdo -> rollBack();
		// Error message
		return array(
			''         => 'Fault',
			'type'     => 'Database',
			'action'   => 'CommitTransaction',
			'database' => 'MySQL',
			'status'   => 'Error',
			'message'  => '', // $ErrMessage -> message = getLanguage( 0, array( 'Database commit transaction error!', '提交数据库事务出现异常！' ) );
			'data'     => $e
		);
	}

}

// Rollback Transaction
function MouseChsh_Database_MySQL_RollBackTransaction( $obj, $pdo = null ){

	if( isset( $obj ) && isset( $obj[ '@' ] ) && isset( $obj[ '@' ][ 'pdo' ] ) ){
		$pdo = $obj[ '@' ][ 'pdo' ];
	}
	try{
		// Rollback Transaction
		$pdo -> rollBack();
		//
		return array(
			''         => 'OK',
			'type'     => 'Database',
			'action'   => 'RollBackTransaction',
			'database' => 'MySQL',
			'status'   => 'RollBackTransaction',
			'@'        => $pdo
		);
	}
	catch( Exception $e ){
		return array(
			''         => 'OK',
			'type'     => 'Database',
			'action'   => 'RollBackTransaction',
			'database' => 'MySQL',
			'status'   => 'Error',
			'message'  => '', // $ErrMessage -> message = getLanguage( 0, array( 'Database rollback transaction error!', '回滚数据库事务出现异常！' ) );
			'data'     => $e
		);
	}

}

function MouseChsh_Database_PostgreSQL_CheckPDOConfig( $obj, $config = null ){

	if( isset( $obj ) && isset( $obj[ '@' ] ) && isset( $obj[ '@' ][ 'config' ] ) ){
		$config = $obj[ '@' ][ 'config' ];
	}
	if( !isset( $config ) ){
		throw new Exception();
	}
	if( !isset( $config[ 'dbms' ] ) || $config[ 'dbms' ] == '' ){
		$config[ 'dbms' ] = 'pgsql';
	}
	$config[ 'dsn' ] = "{$config['dbms']}:";
	if( !isset( $config[ 'host' ] ) || $config[ 'host' ] == '' ){
		$config[ 'host' ] = '127.0.0.1';
	}
	$config[ 'dsn' ] .= "host={$config['host']};";
	if( !isset( $config[ 'port' ] ) || $config[ 'port' ] == '' ){
		$config[ 'port' ] = 5432;
	}
	$config[ 'dsn' ] .= "port={$config['port']};";
	if( isset( $config[ 'database' ] ) && $config[ 'database' ] != '' ){
		$config[ 'dsn' ] .= "dbname={$config['database']}";
	}
	if( isset( $config[ 'path' ] ) && $config[ 'path' ] != '' ){
		$config[ 'dsn' ] .= "{$config['path']}";
	}
	if( !isset( $config[ 'user' ] ) ){
		$config[ 'user' ] = '';
	}
	if( !isset( $config[ 'password' ] ) ){
		$config[ 'password' ] = '';
	}
	if( !isset( $config[ 'dsn' ] ) || $config[ 'dsn' ] == '' ){
		throw new Exception();
	}

	return array(
		''         => 'OK',
		'type'     => 'Database',
		'action'   => 'CheckPDOConfig',
		'database' => 'PostgreSQL',
		'@'        => $config
	);

}


function MouseChsh_Database_PostgreSQL_ConnectPDO( $obj, $config = null ){

	if( isset( $obj ) && isset( $obj[ '@' ] ) && isset( $obj[ '@' ][ 'config' ] ) ){
		$config = $obj[ '@' ][ 'config' ];
	}
	try{
	//	/* DEBUG POINT */ echo var_dump( $config ); // exit();
		// PDO Params
		$opts = array( PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION );
		// get connect object
		$pdo = new PDO( $config[ 'dsn' ], $config[ 'user' ], $config[ 'password' ], $opts );
		// OK
		return array(
			''         => 'OK',
			'type'     => 'Database',
			'action'   => 'ConnectPDO',
			'database' => 'PostgreSQL',
			'status'   => 'Connected',
			'@'        => $pdo
		);
	}
	catch( Exception $e ){
	//	/* DEBUG POINT */echo var_dump( $e ); exit();
		return array(
			''         => 'Fault',
			'type'     => 'Database',
			'action'   => 'ConnectPDO',
			'database' => 'PostgreSQL',
			'status'   => 'Error',
			'message'  => '', // $ErrMessage -> message = getLanguage( 0, array( 'Connect Database error!', '连接数据库错误！' ) );
			'data'     => $e
		);
	}

}

function MouseChsh_Database_Redis_ConnectDatabase( $obj, $config = null ){

	if( isset( $obj ) && isset( $obj[ '@' ] ) && isset( $obj[ '@' ][ 'config' ] ) ){
		$config = $obj[ '@' ][ 'config' ];
	}
	if( !isset( $config[ 'host' ] ) ){
		$config[ 'host' ] = '127.0.0.1';
	}
	if( !isset( $config[ 'port' ] ) ){
		$config[ 'port' ] = 6379;
	}
	if( !isset( $config[ 'password' ] ) ){
		$config[ 'password' ] = '';
	}
	try{
	//	/* DEBUG POINT */ echo var_dump( $config );
		$dbobj = new Redis();
		$dbobj -> pconnect( $config[ 'host' ], $config[ 'port' ] );
		if( $config[ 'password' ] != '' ){
			$dbobj -> auth( $config[ 'password' ] );
		}
		$dbobj -> ping();
		return array(
			''         => 'OK',
			'type'     => 'Database',
			'action'   => 'ConnectDatabase',
			'database' => 'Redis',
			'status'   => 'Connected',
			'@'        => $dbobj
		);
	}
	catch( Exception $e ){
		return array(
			''         => 'Fault',
			'type'     => 'Database',
			'action'   => 'ConnectDatabase',
			'database' => 'Redis',
			'status'   => 'Error',
			'message'  => '',
			'data'     => $e
		);
	}

}

function MouseChsh_Database_Redis_Execute( $obj, $dbobj = null, $act = null, $key = null, $value = null, $key1 = null, $key2 = null ){

	if( isset( $obj ) && isset( $obj[ '@' ] ) ){
		if( isset( $obj[ '@' ][ 'pdo' ] ) ){
			$dbobj = $obj[ '@' ][ 'pdo' ];
		}
		if( isset( $obj[ '@' ][ 'action' ] ) ){
			$act = $obj[ '@' ][ 'action' ];
		}
		if( isset( $obj[ '@' ][ 'key' ] ) ){
			$key = $obj[ '@' ][ 'key' ];
		}
		if( isset( $obj[ '@' ][ 'key1' ] ) ){
			$key1 = $obj[ '@' ][ 'key1' ];
		}
		if( isset( $obj[ '@' ][ 'value' ] ) ){
			$value = $obj[ '@' ][ 'value' ];
		}
	}
	if( !$dbobj ){
		return array(
			''         => 'Fault',
			'type'     => 'Database',
			'action'   => 'Execute',
			'database' => 'Redis'
		);
	}
	try{
		switch( strtolower( $act ) ){
			case 'expire':
				$dbobj -> expire( $key, $value );
				return array(
					''         => 'OK',
					'type'     => 'Database',
					'action'   => 'Execute',
					'database' => 'Redis',
					'status'   => 'Complete',
					'doing'    => 'expire',
					'@'        => true
				);
				break;
			case 'ttl':
				$result = $dbobj -> ttl( $key );
				return array(
					''         => 'OK',
					'type'     => 'Database',
					'action'   => 'Execute',
					'database' => 'Redis',
					'status'   => 'Complete',
					'doing'    => 'ttl',
					'@'        => $result
				);
				break;
			case 'set':
				$dbobj -> set( $key, $value );
				return array(
					''         => 'OK',
					'type'     => 'Database',
					'action'   => 'Execute',
					'database' => 'Redis',
					'status'   => 'Complete',
					'doing'    => 'set',
					'@'        => true
				);
				break;
			case 'get':
				$result = $dbobj -> get( $key );
				return array(
					''         => 'OK',
					'type'     => 'Database',
					'action'   => 'Execute',
					'database' => 'Redis',
					'status'   => 'DataAtHere',
					'doing'    => 'get',
					'@'        => $result
				);
				break;
			case 'del':
				$result = $dbobj -> delete( $key );
				return array(
					''         => 'OK',
					'type'     => 'Database',
					'action'   => 'Execute',
					'database' => 'Redis',
					'status'   => 'CountResult',
					'doing'    => 'del',
					'@'        => $result
				);
				break;
			case 'exists':
				$result = $dbobj -> exists( $key );
				return array(
					''         => 'OK',
					'type'     => 'Database',
					'action'   => 'Execute',
					'database' => 'Redis',
					'status'   => 'ProcessResult',
					'doing'    => 'exists',
					'@'        => $result
				);
				break;
			case 'set-hash':
				$dbobj -> hSet( $key, $key1, $value );
				return array(
					''         => 'OK',
					'type'     => 'Database',
					'action'   => 'Execute',
					'database' => 'Redis',
					'status'   => 'Complete',
					'doing'    => 'set-hash',
					'@'        => true
				);
				break;
			case 'get-hash':
				$result = $dbobj -> hGet( $key, $key1 );
				return array(
					''         => 'OK',
					'type'     => 'Database',
					'action'   => 'Execute',
					'database' => 'Redis',
					'status'   => 'DataAtHere',
					'doing'    => 'get-hash',
					'@'        => $result
				);
				break;
			case 'get-hash-all':
				$result = $dbobj -> hGetAll( $key );
				return array(
					''         => 'OK',
					'type'     => 'Database',
					'action'   => 'Execute',
					'database' => 'Redis',
					'status'   => 'AllData',
					'doing'    => 'get-hash-all',
					'@'        => $result
				);
				break;
			case 'get-hash-all_key':
				$result = $dbobj -> hKeys( $key );
				return array(
					''         => 'OK',
					'type'     => 'Database',
					'action'   => 'Execute',
					'database' => 'Redis',
					'status'   => 'AllDataOfKey',
					'doing'    => 'get-hash-all_key',
					'@'        => $result
				);
				break;
			case 'get-hash-all_value':
				$result = $dbobj -> hVals( $key );
				return array(
					''         => 'OK',
					'type'     => 'Database',
					'action'   => 'Execute',
					'database' => 'Redis',
					'status'   => 'AllDataOfValue',
					'doing'    => 'get-hash-all_value',
					'@'        => $result
				);
				break;
			case 'get-hash-length':
				$result = $dbobj -> hLen( $key );
				return array(
					''         => 'OK',
					'type'     => 'Database',
					'action'   => 'Execute',
					'database' => 'Redis',
					'status'   => 'CountData',
					'doing'    => 'get-hash-length',
					'@'        => $result
				);
				break;
			case 'del-hash':
				$result = $dbobj -> hDel( $key, $key1 );
				return array(
					''         => 'OK',
					'type'     => 'Database',
					'action'   => 'Execute',
					'database' => 'Redis',
					'status'   => 'CountResult',
					'doing'    => 'del-hash',
					'@'        => $result
				);
				break;
			case 'exists-hash':
				$result = $dbobj -> hExists( $key, $key1 );
				return array(
					''         => 'OK',
					'type'     => 'Database',
					'action'   => 'Execute',
					'database' => 'Redis',
					'status'   => 'ProcessResult',
					'doing'    => 'exists-hash',
					'@'        => $result
				);
				break;
			case 'get-list':
				$result = $dbobj -> lGet( $key, $key1 );
				return array(
					''         => 'OK',
					'type'     => 'Database',
					'action'   => 'Execute',
					'database' => 'Redis',
					'status'   => 'DataAtHere',
					'doing'    => 'get-list',
					'@'        => $result
				);
				break;
			case 'get_range-list':
				$result = $dbobj -> lGet( $key, $key1, $key2 );
				return array(
					''         => 'OK',
					'type'     => 'Database',
					'action'   => 'Execute',
					'database' => 'Redis',
					'status'   => 'DataBetween',
					'doing'    => 'get_range-list',
					'@'        => $result
				);
				break;
			case 'set-list':
				$dbobj -> lSet( $key, $key1, $value );
				return array(
					''         => 'OK',
					'type'     => 'Database',
					'action'   => 'Execute',
					'database' => 'Redis',
					'status'   => 'Complete',
					'doing'    => 'set-list',
					'@'        => true
				);
				break;
			case 'push_start-list':
				$dbobj -> lPush( $key, $value );
				return array(
					''         => 'OK',
					'type'     => 'Database',
					'action'   => 'Execute',
					'database' => 'Redis',
					'status'   => 'Complete',
					'doing'    => 'push_start-list',
					'@'        => true
				);
				break;
			case 'pop_start-list':
				$result = $dbobj -> lPop( $key );
				return array(
					''         => 'OK',
					'type'     => 'Database',
					'action'   => 'Execute',
					'database' => 'Redis',
					'status'   => 'DataAtHere',
					'doing'    => 'pop_start-list',
					'@'        => $result
				);
				break;
			case 'push_end-list':
				$dbobj -> rPush( $key, $value );
				return array(
					''         => 'OK',
					'type'     => 'Database',
					'action'   => 'Execute',
					'database' => 'Redis',
					'status'   => 'Complete',
					'doing'    => 'push_end-list',
					'@'        => true
				);
				break;
			case 'pop_end-list':
				$result = $dbobj -> rPop( $key );
				return array(
					''         => 'OK',
					'type'     => 'Database',
					'action'   => 'Execute',
					'database' => 'Redis',
					'status'   => 'DataAtHere',
					'doing'    => 'pop_end-list',
					'@'        => $result
				);
				break;
			case 'pop_end-push_start-list':
				$result = $dbobj -> rPopLPush( $key, $key1 );
				return array(
					''         => 'OK',
					'type'     => 'Database',
					'action'   => 'Execute',
					'database' => 'Redis',
					'status'   => 'DataAtHere',
					'doing'    => 'pop_end-push_start-list',
					'@'        => $result
				);
				break;
			case 'insert_before-list':
				$result = $dbobj -> lInsert( $key, Redis::BEFORE, $key1, $value );
				return array(
					''         => 'OK',
					'type'     => 'Database',
					'action'   => 'Execute',
					'database' => 'Redis',
					'status'   => 'PositionAtHere',
					'doing'    => 'insert_before-list',
					'@'        => $result
				);
				break;
			case 'insert_after-list':
				$result = $dbobj -> lInsert( $key, Redis::AFTER, $key1, $value );
				return array(
					''         => 'OK',
					'type'     => 'Database',
					'action'   => 'Execute',
					'database' => 'Redis',
					'status'   => 'PositionAtHere',
					'doing'    => 'insert_after-list',
					'@'        => $result
				);
				break;
			case 'get-list-length':
				$result = $dbobj -> lSize( $key );
				return array(
					''         => 'OK',
					'type'     => 'Database',
					'action'   => 'Execute',
					'database' => 'Redis',
					'status'   => 'CountData',
					'doing'    => 'get-list-length',
					'@'        => $result
				);
				break;
			case 'del-list':
				$result = $dbobj -> lRem( $key, $key1, $key2 );
				return array(
					''         => 'OK',
					'type'     => 'Database',
					'action'   => 'Execute',
					'database' => 'Redis',
					'status'   => 'CountResult',
					'doing'    => 'del-list',
					'@'        => $result
				);
				break;
		}
	}
	catch( RedisException $e ){
		return array(
			''         => 'Fault',
			'type'     => 'Database',
			'action'   => 'Execute',
			'database' => 'Redis',
			'status'   => 'Error',
			'message'  => '',
			'data'     => $e
		);
	}
	catch( Exception $e ){
		return array(
			''         => 'Fault',
			'type'     => 'Database',
			'action'   => 'Execute',
			'database' => 'Redis',
			'status'   => 'Error',
			'message'  => '',
			'data'     => $e
		);
	}

}

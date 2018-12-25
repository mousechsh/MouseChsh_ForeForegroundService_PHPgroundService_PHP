<?php
/***************************************************************
Global Error Handler
====================
Use for handle all error and warning
***************************************************************/
$fn = function(){

	// 全局错误处理
	function _MouseChsh_GlobalError( $error_level, $error_message, $error_file, $error_line, $error_context ){

		// 再次判断
		if( \com\mousechsh\GlobalConfig::$Runtime == 'debug' ){
			// 保护隐私
			unset( $error_context[ 'mousechsh' ] );
			// 清空输出
			ob_clean();
			// 显示错误消息
			$result = null;
			if( \com\mousechsh\GlobalConfig::$DetailErrorMessage ){
				$result = json_encode( array(
					'errcode' => 'GRR00',
					'message' => 'GLOBAL ERROR',
				//	/*
					'data' => array(
						'' => 'GLOBAL_ERROR',
						'level' => $error_level,
						'message' => $error_message,
						'file' => $error_file,
						'line' => $error_line,
						'context' => json_encode( $error_context )
					)
					//*/
				) );
			}else{
				$result = json_encode( array(
					'errcode' => 'GRR00',
					'message' => 'GLOBAL ERROR'
				) );
			}
			\com\mousechsh\log::Add( 'SYSTEM', 'FINAL', '/core/com.mousechsh.error-conf.php::_MouseChsh_GlobalError-fn.php', 'GLOBAL ERROR CATCHED', json_encode( $result ) );
			echo $result;
			// 结束脚本运行
			exit();
		}

	}
	// 全局异常处理
	function _MouseChsh_GlobalException( $exception ){

		// 再次判断
		if( \com\mousechsh\GlobalConfig::$Runtime == 'debug' ){
			// 清空输出
			ob_clean();
			// 显示错误消息
			$result = null;
			if( \com\mousechsh\GlobalConfig::$DetailErrorMessage ){
				$result = json_encode( array(
					'errcode' => 'GEX00',
					'message' => 'GLOBAL EXCEPTION',
				//	/*
					'data' => array(
						'' => 'GLOBAL_EXCEPTION',
						'Exception' => json_encode( $exception )
					)
					//*/
				) );
			}else{
				$result = json_encode( array(
					'errcode' => 'GEX00',
					'message' => 'GLOBAL EXCEPTION',
				) );
			}
			\com\mousechsh\log::Add( 'SYSTEM', 'FINAL', '/core/com.mousechsh.error-conf.php::_MouseChsh_GlobalException-fn.php', 'GLOBAL EXCEPTION CATCHED', json_encode( $result ) );
			echo $result;
		}

	}
	// 全局停止
	function _MouseChsh_GlobalShutdown(){

		// 再次判断
		if( \com\mousechsh\GlobalConfig::$Runtime == 'debug' ){
			// 如果有错误要处理，则显示错误
			if( $err = error_get_last()){
				// 清空输出
				ob_clean();
				// 显示错误消息
				$result = null;
				if( \com\mousechsh\GlobalConfig::$DetailErrorMessage ){
					$result = json_encode( array(
						'errcode' => 'GSD00',
						'message' => 'GLOBAL ERRO IN SHUTDOWN',
					//	/*
						'data' => array(
							'' => 'GLOBA_SHUTDOWN',
							'Error' => json_encode( $err )
						)
						//*/
					) );
				}else{
					$result = json_encode( array(
						'errcode' => 'GSD00',
						'message' => 'GLOBAL ERRO IN SHUTDOWN',
					) );
				}
				\com\mousechsh\log::Add( 'SYSTEM', 'FINAL', '/core/com.mousechsh.error-conf.php::_MouseChsh_GlobalShutdown-fn.php', 'GLOBAL ERRO IN SHUTDOWN CATCHED', json_encode( $result ) );
				echo $result;
			}
		}

	}
	
//	/*
	// Public Config
	if( \com\mousechsh\GlobalConfig::$Runtime == 'debug' ){
		// 注册全局错误监视
		set_error_handler( '_MouseChsh_GlobalError' );
		// 注册全局异常监视
		set_exception_handler( '_MouseChsh_GlobalException' );
		// 注册全局停止监视
		register_shutdown_function( '_MouseChsh_GlobalShutdown' );
	}
	//*/

};
$fn();

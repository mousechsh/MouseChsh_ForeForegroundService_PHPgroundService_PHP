<?php
if( file_exists( dirname( __FILE__ ) . DIRECTORY_SEPARATOR . 'core_delete' . DIRECTORY_SEPARATOR . 'mousechsh-core.php' ) ){
	require_once( dirname( __FILE__ ) . DIRECTORY_SEPARATOR . 'core_delete' . DIRECTORY_SEPARATOR . 'mousechsh-core.php' );
}else{
	require_once( dirname( __FILE__ ) . DIRECTORY_SEPARATOR . 'core' . DIRECTORY_SEPARATOR . 'mousechsh-core.php' );
}

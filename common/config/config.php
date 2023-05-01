<?php

$_prefijo = 'ser_';

$_config = array ();

$_config ['ext_allowed'] = array (
		'gif', 'png', 'jpg', 'pdf', 'doc', 'docx', 'xls', 'xlsx' 
);



	$_config ['db_user'] = 'portalcliente_dev';
	$_config ['db_password'] = '@7z042eVs';
	$_config ['db_name'] = 'portalcliente_dev';
	$_config ['db_host'] = 'localhost';




if ( $_SESSION['ser_admin_user']['cus_id'] ) $filter_user_docs = " AND cus_doh_fk = '".$_SESSION['ser_admin_user']['cus_id']."' ";

function get_config ($key = false) {

	global $_config;
	
	if ($key)
		return $_config [$key];
	
	else
		return $_config;
}




?>
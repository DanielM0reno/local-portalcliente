<?php

function encriptar ($cadena) {

	$content = bin2hex (openssl_encrypt ($cadena, 'AES-256-CBC', '6eLpo%(2RgzH_H5fkd-G7hKC', OPENSSL_RAW_DATA, 'gB82S!cpL05&4c2A'));
	$checksum = md5 ('S3fuqPYef#JPsOh-vwv.xSb' . $content);
	
	return $checksum . $content;
}

function desencriptarraw ($cadena) {

	$checksum = substr ($cadena, 0, 32);
	$content = substr ($cadena, 32);
	
	if ($checksum == md5 ('S3fuqPYef#JPsOh-vwv.xSb' . $content)) {
		
		//return openssl_decrypt (hex2bin ($content), 'AES-256-CBC', '6eLpo%(2RgzH_H5fkd-G7hKC', OPENSSL_RAW_DATA, 'gB82S!cpL05&4c2A');
		return openssl_decrypt (pack ('H*', $content), 'AES-256-CBC', '6eLpo%(2RgzH_H5fkd-G7hKC', OPENSSL_RAW_DATA, 'gB82S!cpL05&4c2A');
	}
	
	return '';
}

function desencriptar ($cadena) {

	$_GET = array ();
	
	if (! $cadena)
		return;
	
	$result = desencriptarraw ($cadena);
	
	parse_str ($result, $_GET);
}

/**
 * Ejemplo de llamadas:
 *
 * action ( 'op=5' ); // Devuelve index.php?funny=cadena_encriptada
 * action ( 'http://google.com/index.php', 'op=5' ); // Devuelve http://google.com/index.php?funny=cadena_encriptada
 * action ( '', 'op=5' ); // Devuelve index.php?funny=cadena_encriptada
 *
 * @return string Action encriptada
 */
function action () {

	$nargs = func_num_args ();
	$args = func_get_args ();
	
	$opciones = '';
	
	if ($nargs == 1) {
		
		$url = 'index.php';
		$opciones = $args [0];
	} elseif ($nargs == 2) {
		
		$url = $args [0] ? $args [0] : 'index.php';
		$opciones = $args [1];
	}
	
	$opciones = $opciones . '&uid=' . uniqid (mt_rand (0, 10000));
	
	return $url . '?f=' . encriptar ($opciones);
}
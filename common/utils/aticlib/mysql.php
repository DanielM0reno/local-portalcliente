<?php

/**
 * Si la conexión contra la base de datos no existe la crea y la devuelve.
 * Si ya existe simplemente la devuelve.
 * Esta función se ocupa de crear automáticamente la conexión con la base de datos siempre
 * que haga falta, si en el script no se accede a base de datos no se crea la conexión
 *
 * @global mysqli $_mysqli
 * @return mysqli
 */
function get_mysql () {

	global $_mysqli;
	
	$_config = get_config ();
	
	if (! isset ($_mysqli)) {
		
		$_mysqli = new mysqli ($_config ['db_host'], $_config ['db_user'], $_config ['db_password'], $_config ['db_name']);
		
		if ($_mysqli->connect_error) {
			
			exit ('DB Connect Error');
		}
		$_mysqli->set_charset ('utf8mb4');
	}
	
	return $_mysqli;
}

/**
 * Maneja el inicio de una transacción
 */
function start_transaction () {

	ejecuta ('SET TRANSACTION ISOLATION LEVEL SERIALIZABLE');
	ejecuta ('START TRANSACTION');
}

/**
 * Finaliza una transacción iniciada por start_transaction
 */
function commit () {

	ejecuta ('COMMIT');
}

/**
 * Escapa el string dado para ser utilizado en sql
 *
 * @param string $string
 * @return string
 */
function escape ($string) {

	return get_mysql ()->real_escape_string ($string);
}

/**
 * Ejecuta la query en base de datos.
 * Ojo: los parámetros hay que escaparlos a mano,
 * esta función no los escapa automáticamente
 *
 * @param string $query
 * @return mysqli_result
 */
function ejecuta ($query) {

	return get_mysql ()->query ($query);
}

/**
 * Devuelve el último id insertado en la base de datos
 *
 * @return int/string
 */
function insert_id () {

	return get_mysql ()->insert_id;
}

/**
 * Devuelve las filas afectadas en la última query ejecutada
 *
 * @return int/string
 */
function affected_rows () {

	return get_mysql ()->affected_rows;
}

/**
 * Escapa los elementos de un array para utilizarlos con seguridad en una sentencia
 * de mysql.
 * Está definida para ser utilizada con array_walk
 *
 * @param array_item $item
 */
function sanitize_array (&$item) {

	$item = escape ($item);
}

/**
 * Las keys se escapan con una lista blanca, permitiendo solo determinados caracteres
 * Esta función nos servirá para controlar el nombre de los campos que se están actualizando en la base de datos
 *
 * @param array_item $item
 */
function sanitize_array_keys (&$item) {

	$item = preg_replace ('/[^A-Za-z0-9_]/', '', $item);
}

/**
 * Automatiza la accion de insert/update en la base de datos.
 * El id del elemento
 * a actualizar (si se trata de un update) se pasa en el array de datos. La funcion
 * determina con un insert update de mysql si es un insert (el id no está definido)
 * o es un update (el id está definido y coincide con alguno de la base de datos)
 *
 * @param string $table
 * @param array $data
 * @return int/string
 */
function save ($table, $data) {

	return multi_save ($table, array (
			$data 
	));
}

/**
 * Automatiza la accion de insert/update en la base de datos.
 * A diferencia de save, permite varios insert/updates a la vez en una sola query SQL
 * El id del elemento
 * a actualizar (si se trata de un update) se pasa en el array de datos. La funcion
 * determina con un insert update de mysql si es un insert (el id no está definido)
 * o es un update (el id está definido y coincide con alguno de la base de datos)
 * Nota: Los ids devueltos sólo funcionan todo lo que se ejecutan son operaciones INSERT,
 * si existe algún UPDATE mysql ya no devuelve el mismo resultado
 *
 * @param string $table
 * @param array $datas
 * @return array ids
 */
function multi_save ($table, $datas) {

	global $_prefijo;
	
	if (is_array ($datas)) {
		
		$user = escape ($_SESSION [$_prefijo.'admin_user'] ['email']);
		$table = preg_replace ('/[^A-Za-z0-9_]/', '', $table);
		
		$keys = array_keys ($datas [0]);
		array_walk ($keys, 'sanitize_array_keys');
		
		$sql = "INSERT INTO `$table` ";
		$sql .= "(`" . implode ('`,`', $keys) . "`,`status`,`fechaalta`,`useralta`) ";
		$sql .= "VALUES ";
		
		$all_values = array ();
		
		foreach ($datas as $data) {
			
			if (is_array ($data)) {
				
				$values = array_values ($data);
				array_walk ($values, 'sanitize_array');
				
				$all_values [] = "('" . implode ("','", $values) . "','A',NOW(),'$user') ";
			} else {
				return false;
			}
		}
		
		$sql .= implode (',', $all_values);
		$sql .= " ON DUPLICATE KEY UPDATE ";
		
		$aux = array ();
		
		for ($i = 0; $i < count ($keys); $i ++) {
			
			$aux [] = "`" . $keys [$i] . "`=VALUES(`" . $keys [$i] . "`)";
		}
		
		$aux [] = "`status`='M'";
		$aux [] = "`fechamod`=NOW()";
		$aux [] = "`usermod`='$user'";
		
		$sql .= implode (',', $aux);
		
		ejecuta ($sql);
		
		/*
		 * if (count ( $datas ) == 1) {
		 *
		 * return insert_id ();
		 * } else {
		 */
		
		$ids = array ();
		$insert_id = insert_id ();
		$affected_rows = affected_rows ();
		
		for ($i = 0; $i < $affected_rows; $i ++) {
			
			$ids [] = $i + $insert_id;
		}
		
		return $ids;
		// }
	} else {
		
		return false;
	}
}

/**
 * Elimina un elemento de una tabla cuyos valores para su id o sus N ids coincide
 * con las claves/valores del array pasado como parámetro
 *
 * @param string $table
 * @param array $ids
 */
function delete ($table, $ids) {

	global $_prefijo;
	
	if (is_array ($ids)) {
		
		$user = escape ($_SESSION [$_prefijo.'admin_user'] ['email']);
		
		$table = preg_replace ('/[^A-Za-z0-9_]/', '', $table);
		
		$keys = array_keys ($ids);
		$values = array_values ($ids);
		
		array_walk ($keys, 'sanitize_array_keys');
		array_walk ($values, 'sanitize_array');
		
		$sql = "UPDATE `$table` ";
		$sql .= "SET `status`='D',`fechabaja`=NOW(),`userbaja`='$user' ";
		
		$aux = array ();
		
		for ($i = 0; $i < count ($keys); $i ++) {
			
			$aux [] = "`" . $keys [$i] . "`='" . $values [$i] . "'";
		}
		
		$sql .= "WHERE " . implode (" AND ", $aux);
		
		ejecuta ($sql);
	} else {
		
		return false;
	}
}
<?php
_leveloper_ === true ? '' : exit (); // Por seguridad

session_start ();

date_default_timezone_set ('Europe/Madrid');

if (is_dir ('common'))
	$_install_path = '';
elseif (is_dir ('../common'))
	$_install_path = '../';
elseif (is_dir ('../../common'))
	$_install_path = '../../';
elseif (is_dir ('../../../common'))
	$_install_path = '../../../';

	
require_once ($_install_path . 'common/config/config.php');

/**
 * ATICLIB
 */
require_once ($_install_path . 'common/utils/aticlib/mysql.php');
require_once ($_install_path . 'common/utils/aticlib/class.lib.php');
require_once ($_install_path . 'common/utils/aticlib/access.php');

/**
 * Desencriptar la URL si es necesario
 */

if (_url_crypt_ === true) {
	
	desencriptar ($_GET ['f']);
}

/**
 * Clases propias de la aplicación
 */

spl_autoload_register (
		function ($class) {
			
			global $_install_path;
			
			$class = 'class.' . preg_replace ('/[^A-Za-z0-9_]/', '', $class) . '.php'; // El preg replace es por seguridad
			include ($_install_path . 'model/' . $class);
		});

foreach ($_GET as $var => $val) {
	$w = 'w' . $var;
	$$w = $val;
}

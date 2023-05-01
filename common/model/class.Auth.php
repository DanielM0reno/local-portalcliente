<?php

class Auth {
	
	function login() {
	
		global $_prefijo;
				
		if ($_POST['email'] and $_POST['password']) {
				
				$query = "SELECT * FROM USERS WHERE email = '".escape($_POST['email'])."' AND password = '".md5(escape($_POST['password']))."' AND status != 'D';";	
				
				$result = ejecuta($query);	
				
				if ($row = mysqli_fetch_assoc($result)) {
							
					$_SESSION[$_prefijo.'admin_auth'] = true;
					$_SESSION[$_prefijo.'admin_user'] = $row;							
					
				} else {
					$_SESSION[$_prefijo.'admin_auth'] = false;
				}
		
		}
	}
	
	static function is_logged() {
		
		global $_prefijo;
		
		return $_SESSION[$_prefijo.'admin_auth'];
	}
}

?>
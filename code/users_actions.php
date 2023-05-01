<?php

	if ($wact == 'save'){
	
	
		foreach ($_POST as $key => $value){
			$_POST[$key] = escape($value);
		}
		
				
		if ( isset( $_POST['id'] ) && $_POST['id'] == "" ){
		
			if ( isset( $_POST['password_1'] ) && $_POST['password_1'] != '' ){
				
				
				if ( $_POST['password_1'] == $_POST['password_2'] ){
				
					// Comprobar que no exista un usuario activo con ese email
				
					$query = "SELECT * FROM USERS WHERE email = '".$_POST['email']."' AND status != 'D'";
					$res = ejecuta( $query );													
					$row = $res->fetch_assoc();																
													
					if ( !$row['email'] ){										
																
						$query = "INSERT INTO USERS (cus_id, email, password, nombre, role, status, fechaalta, useralta)
									VALUES('".$_POST['cus_id']."', '".$_POST['email']."', '".md5($_POST['password_1'])."', '".$_POST['nombre']."', '".$_POST['role']."', 'A', NOW(), '".$_SESSION[$_prefijo.'admin_user']['id']."')";
					
						ejecuta( $query );
						
						// Mensaje de ok
						
						echo '<div class="alert alert-success">El usuario se ha dado de alta correctamente.</div>';
						
										
					}else{
						
						echo '<div class="alert alert-danger">¡Error! Ya existe un usuario con ese email.</div>';
					
					}
				
				}else{
				
					// Mandar alert de error!
					
				}
				
			}
			
		}else if ( isset( $_POST['id'] ) && $_POST['id'] != "" ){
			
		
			$query = "UPDATE USERS SET cus_id = '".$_POST['cus_id']."', nombre = '".$_POST['nombre']."', role = '".$_POST['role']."', status = 'M', fechamod = NOW(), usermod = '".$_SESSION[$_prefijo.'admin_user']['id']."' WHERE id = '".$_POST['id']."'";			
			ejecuta( $query );
			
			echo '<div class="alert alert-success">El usuario se ha modificado correctamente.</div>';
		}	
	
	}else if ($wact == 'del'){
			
		$query = "UPDATE USERS SET status = 'D', fechabaja = NOW(), userbaja = '".$_SESSION[$_prefijo.'admin_user']['id']."' WHERE id = '".$_GET['id']."'";			
		ejecuta( $query );
		
		echo '<div class="alert alert-success">El usuario ha sido eliminado.</div>';
		
	}

?>
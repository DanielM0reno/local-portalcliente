<?php

ini_set("error_reporting",E_ERROR);
ini_set("display_errors","on");



define ('_leveloper_', true); // Por seguridad
define ('_url_crypt_', true);

require_once ("common/includes.php");


$auth = new Auth ();
$auth->login ();

if (!$auth->is_logged() or $_GET['act'] == 'logout') {
	
	session_destroy ();
	require_once ("code/login.php");
	exit ();
}

	$dbconn = pg_connect("host=serigrafiasergar.no-ip.org port=5432 dbname=i.SERIGRAFIA_SERGAR_SL.2019.0 user=inforgesconnectiqs password=ncxz@L934_PO234&xz23gh")
    or die('No se ha podido conectar: ' . pg_last_error());

if ( $_POST['op'] == 'detalle_pedido' )
{
	

												$query = 'SELECT ite_dli_fk, dli_description, dli_quantity, dli_price, dli_totalamount  FROM public."DOCLINE_DLI" WHERE doh_dli_fk = '.$_POST['idpedido'].'';
												
												echo $query;
												
												$result = pg_query($query) or die('La consulta fallo: ' . pg_last_error());
												
												
												
												while ($line = pg_fetch_array($result, null, PGSQL_ASSOC)) {
													
													echo '<tr>
												    <td>'.$line['ite_dli_fk'].'</td>
													<td>'.utf8_encode($line['dli_description']).'</td>
                                                    <td>'.$line['dli_price'].'</td>
													<td>'.$line['dli_quantity'].'</td>
                                                    <td>'.$line['dli_totalamount'].'</td> 
												</tr>';
												
												}
													

													
	
}
// NEW CODE
else{

	// Muestra los subtipos de incidencias
	if( $_POST['op'] == 'subtype_incident' ){
			
			$query = 'SELECT ID, NAME FROM portalcliente_dev.INCIDENT_SUBTYPE WHERE FK_TYPE = '.$_POST['id_incident'].'; ';									
			$result = ejecuta($query) or die('La consulta fallo: ' . pg_last_error());
			echo '<option disabled selected>Selecciona una opción</option>';
			while ( $row = $result->fetch_assoc())
			{  
				echo '<option value ="'.$row['ID'].'">'.$row['NAME'].'</option>';
			}
	}

	//Muestra los documentos para cada incidencias
	if( $_POST['op'] == 'document_incident' ){
			
		$query = 'SELECT ID, DOC,DOCITEM_TYPE,DOCITEM_TITLE, DOCITEM_DESCRIPTION FROM DOC_TYPE WHERE FK_SUBTYPE = '.$_POST['id_subincident'].'; ';									
		$result = ejecuta($query) or die('La consulta fallo: ' . pg_last_error());
		
		while ( $row = $result->fetch_assoc())
		{
			echo "<label for='".$row['DOCITEM_TYPE']."'>".$row['DOCITEM_TITLE']."</label>";
			
			//Tipo de input a mostrar
			switch ($row['DOC']) {
				case '1':
					echo "<textarea id ='".$row['ID']."' class='form-control' name='doc1' rows='4' style='resize: none'></textarea>";
					echo "<input id ='".$row['ID']."' name='doc1_doctype' type='hidden' value='".$row['ID']."' >";

					// echo "<input name='doc1' id ='".$row['ID']."' type='file' class='dropify form_input' data-height='90' data-allowed-file-extensions='pdf' />";
					break;
				case '2':
					echo "<input name='doc2' id ='".$row['ID']."' type='file' class='dropify form_input' data-height='90' data-allowed-file-extensions='png jpeg jpg'/>";
					break;
				case '3':
					echo "<input name='doc3' id ='".$row['ID']."' type='file' class='dropify form_input' data-height='90' />";
					break;
				default:
					break;
			}
			echo "<p><small>* ".$row['DOCITEM_DESCRIPTION']."</small></p>";
		}
	}

	// Inserta incidencias, donde se guarda los ficheros y se inserta en la bbdd
	if( $_POST['op'] == "new_incident" ) {

		//Array de identificadores de los documentos subidos
		$id_documents = array();
		
		$valid_extensions = array('jpeg', 'jpg', 'png', 'pdf' , 'doc' ); // valid extensions
		$uploaddir = 'uploads/'; 
		$file_upload = 0;

		$incident_type = $_POST['incident_type'];
		$id_doctype = $_POST['id_forminputs'];

		// Insercion de textarea
		if (!empty($_POST["doc1"])) {
			$id = $_POST['doc1_doctype'];
			$content = $_POST['doc1'];

			//QUERY DATABASE
			$query = "INSERT INTO DOCUMENTS_RMA 
			(SECURE_TITLE, TITLE, EXTENSION, DOC_TYPE)
			VALUES(substr(sha(UUID()) from 1 for 10), '".$content."', 'TEXT',".$id.");";
			$result = ejecuta($query) or die('La insercion fallo: ' . pg_last_error()); 

			array_push($id_documents,intval(insert_id())); //Guardo el id para luego
		}
		
		// Insercion de documentos
		if(count($_FILES) > 0)
		{

			// foreach($_FILES as $file){
			foreach(array_combine($id_doctype, $_FILES) as $id => $file){
				//UPLOAD FILE
				// -Get uploaded file's extension
				$ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

				//QUERY DATABASE
				$query = "INSERT INTO DOCUMENTS_RMA 
				(SECURE_TITLE, TITLE, EXTENSION, DOC_TYPE)
				VALUES(substr(sha(UUID()) from 1 for 10), '".basename($file['name'])."', '".$ext."',".$id.");";
				$result = ejecuta($query) or die('La insercion fallo: ' . pg_last_error());
				
				// -Obtengo el nombre del documento seguro
				$last_id = intval(insert_id());
				array_push($id_documents,$last_id); //Guardo el id para luego

				$query = "SELECT SECURE_TITLE FROM DOCUMENTS_RMA WHERE ID=" .$last_id.";";
				$result = ejecuta($query) or die('La consulta fallo: ' . pg_last_error());
				$secure_title = "";

				while ( $row = $result->fetch_assoc())
				{
					$secure_title = $row['SECURE_TITLE'];
				}
				
				// -Subo el fichero al servidor con el nombre seguro
				$uploadfile_secure = $uploaddir.$secure_title;

				if(in_array($ext, $valid_extensions)) 
				{ 
					if(move_uploaded_file($file['tmp_name'], $uploadfile_secure)) 
					{
						$file_upload +=1;
					}
				} 
				else {
					echo 'INVALID FILE';
				}
			}

			// -Comprueba que todos los ficheros se han subido correctamente
			if( count($_FILES) == $file_upload ){

				// -Si se suben los ficheros correctamente inserto la incidencia
				$query = "INSERT INTO INCIDENT
				(FECHA_INCIDENTE, PRODUCTO, TIPOLOGIA, STATUS, CLIENTE)
				VALUES('".date("d/m/y")."', '1', '".$incident_type."', 'ABIERTO', '1');";
				$result = ejecuta($query) or die('La insercion INCIDENT fallo: ' . pg_last_error());
				$id_incidencia = intval(insert_id());

				// -Asocio la documentacion con la incidencia insertada
				$values = "";
				foreach ($id_documents as $id) {
					$values .= "(".$id_incidencia.",".$id."),";
				}
				$values = rtrim($values, ",");

				$query = "INSERT INTO INCIDENT_DOC
				(FK_INCIDENT, FK_DOC) VALUES".$values .";";
				$result = ejecuta($query) or die('La insercion INC_DOC fallo: ' . pg_last_error());

				echo "OK";
			}else{
				echo 'ERROR';
			}
		}else{
			echo 'ERROR';
		}

	}
	
	if( $_POST['op'] == "detalle_rma" ){

		$query = "SELECT TITLE, SECURE_TITLE, DOC_TYPE.DOCITEM_TITLE, EXTENSION
		FROM DOC_TYPE,DOCUMENTS_RMA
		INNER JOIN INCIDENT_DOC 
		ON `DOCUMENTS_RMA`.`ID` = `INCIDENT_DOC`.`FK_DOC`
		WHERE `DOCUMENTS_RMA`.`DOC_TYPE` = `DOC_TYPE`.`ID` AND `INCIDENT_DOC`.`FK_INCIDENT` = ".$_POST['id_incidencia'].";";

		$result = ejecuta($query) or die('La consulta fallo: ' . pg_last_error());

		echo "<div class='row'>
				<div class='col-lg-6'>
					<h5>Información</h5>

				</div>

				<div class='col-lg-6'>
				<h5>Documentación</h5>";
		while ( $row = $result->fetch_assoc())
		{  
			if($row['EXTENSION'] == "TEXT"){
				echo "<span><b>".$row['DOCITEM_TITLE']."</b></span><br>";
				echo "<span>".$row['TITLE']."</span><br>";
			}else{
				echo "<span><b>".$row['DOCITEM_TITLE']."</b></span><br>";
				echo "<a class='btn btn-primary btn-lg mb-1' href='uploads/".$row['SECURE_TITLE']."' download=".$row['TITLE'].">".$row['TITLE']."</a><br>";		
			}
			echo "<hr>";
			
		}

		echo "</div></div>";
	}

	if( $_POST['op'] == 'subincident_table' ){
		$query = 'SELECT ID, NAME FROM portalcliente_dev.INCIDENT_SUBTYPE WHERE FK_TYPE = '.$_POST['id_incident'].' AND STATUS = "A"; ';									
			$result = ejecuta($query) or die('La consulta fallo: ' . pg_last_error());
			while ( $row = $result->fetch_assoc())
			{  
				echo '<tr>
					<td>'.$row['NAME'].'</td>
					<td>
						<a href="'.action('','op=admin_subtipologia&act=edit&id='.$row['ID']).'">
							<button type="button" class="btn btn-danger"><i class="fa fa-edit"></i></button>
						</a>																	
						<a href="javascript:void(0)" onclick="if ( confirm(\''.htmlentities('¿').'Seguro que desea eliminar la tipologia?\') ) window.open(\''.action('','op=admin_subtipologia&act=del&id='.$row['ID']).'\', \'_self\');">
							<button type="button" class="btn btn-danger"><i class="fa fa-trash"></i></button>
						</a>																	
					</td>
				</tr>';
			}
	}
}
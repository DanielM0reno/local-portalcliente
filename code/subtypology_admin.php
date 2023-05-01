<div class="container-fluid">

                  
                            <!-- end page title end breadcrumb -->
                            
                            
                            <div class="page-content-wrapper ">

                        <div class="container-fluid">

                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="page-title-box">
                                        <div class="btn-group float-right">
                                            <ol class="breadcrumb hide-phone p-0 m-0">
                                                <li class="breadcrumb-item"><a href="#">AC</a></li>
                                               
                                                <li class="breadcrumb-item active">Subtipologías</li>
                                            </ol>
                                        </div>
                                        <h4 class="page-title">Gestión de Subtipologías <i class="fas fa-question-circle"></i></h4>
                                    </div>
                                </div>
                            </div>
                            <!-- end page title end breadcrumb -->
							
					<?php 
                        
                        if($wact == 'save'){        // SAVE operation 
                            if ( isset( $_POST['id'] ) && $_POST['id'] == "" ){
                                $name = $_POST['nombre'];
                                $tipologia = $_POST['tipologia'];

                                $query = "INSERT INTO `INCIDENT_SUBTYPE` (`NAME`,`FK_TYPE`,`STATUS`)  VALUES ('".$name."','".$tipologia."','A');";
                                ejecuta( $query );    

                                $id_subtype = insert_id();
                                
                                $doc1_input = $_POST['doc1-input'];
                                $doc1_textarea = $_POST['doc1-textarea'];

                                $query = "INSERT INTO `portalcliente_dev`.`doc_type` 
                                (`DOC`,`FK_SUBTYPE`, `DOCITEM_TYPE`, `DOCITEM_TITLE`, `DOCITEM_DESCRIPTION`)
                                VALUES ( '1', '".  $id_subtype."', 'TEXT', '".$doc1_input."', '".$doc1_textarea."');";
                                ejecuta( $query );  

                                // DOCUMENTACION para Imagenes (DOC-2)
                                if (!empty($_POST["doc2-input"])) {
                                    $doc2_input = $_POST['doc2-input'];
                                    $doc2_textarea = $_POST['doc2-textarea'];

                                    $query = "INSERT INTO `portalcliente_dev`.`doc_type` 
                                    (`DOC`,`FK_SUBTYPE`, `DOCITEM_TYPE`, `DOCITEM_TITLE`, `DOCITEM_DESCRIPTION`)
                                    VALUES ( '2', '".  $id_subtype."', 'IMAGE', '".$doc2_input."', '".$doc2_textarea."');";
                                    ejecuta( $query );  

                                } 

                                // DOCUMENTACION para DOCUMENTOS (DOC-3)
                                if(!empty($_POST["doc3-input"])) {   
                                    $doc3_input = $_POST['doc3-input'];
                                    $doc3_textarea = $_POST['doc3-textarea'];

                                    $query = "INSERT INTO `portalcliente_dev`.`doc_type` 
                                    (`DOC`,`FK_SUBTYPE`, `DOCITEM_TYPE`, `DOCITEM_TITLE`, `DOCITEM_DESCRIPTION`)
                                    VALUES ( '3', '".  $id_subtype."', 'DOCUMENT', '".$doc3_input."', '".$doc3_textarea."');";
                                    ejecuta( $query );  
                                }
                                
                                echo '<div class="alert alert-success">La subtipología se ha dado de alta correctamente.</div>';
                            
                        }else{
                                $id = $_POST['id'];
                                $name = $_POST['nombre'];
                                $tipologia = $_POST['tipologia'];
                                
                                $query = "UPDATE INCIDENT_SUBTYPE SET `NAME` = '".$name."', `FK_TYPE` = '".$tipologia."'  WHERE `ID` = '".$id."' ;";
                                $res = ejecuta( $query );	

                                // Se comprueba que DOC-TYPE se actualiza y cuales se insertan
                                $query2 = "SELECT `DOC` FROM `doc_type` WHERE FK_SUBTYPE = ".$id.";";
                                $res2 = ejecuta( $query2 );

                                $listado_update = array();

                                while ( $row = $res2->fetch_assoc())
                                {
                                    if($row['DOC'] == '1'){
                                        $query = "UPDATE `portalcliente_dev`.`doc_type` SET `DOCITEM_TITLE` = '".$_POST['doc1-input']."',
                                        `DOCITEM_DESCRIPTION` = '".$_POST['doc1-textarea']."' WHERE `FK_SUBTYPE` = '".$id."' AND `DOC` = 1;";
                                        ejecuta( $query );  

                                    }elseif ($row['DOC'] == '2'){
                                        $query = "UPDATE `portalcliente_dev`.`doc_type` SET `DOCITEM_TITLE` = '".$_POST['doc2-input']."',
                                        `DOCITEM_DESCRIPTION` = '".$_POST['doc2-textarea']."' WHERE `FK_SUBTYPE` = '".$id."' AND `DOC` = 2;";
                                        ejecuta( $query );  
                                        array_push($listado_update, "2");
                                        
                                    }elseif ($row['DOC'] == '3'){
                                        $query = "UPDATE `portalcliente_dev`.`doc_type` SET `DOCITEM_TITLE` = '".$_POST['doc3-input']."',
                                        `DOCITEM_DESCRIPTION` = '".$_POST['doc3-textarea']."' WHERE `FK_SUBTYPE` = '".$id."' AND `DOC` = 3;";
                                        ejecuta( $query );  
                                        array_push($listado_update, "3");
                                    }
                                }

                                // Compruebo cuales tengo que insertar
                                if(!in_array("2", $listado_update)){
                                    if (!empty($_POST["doc2-input"])) {
                                        $doc2_input = $_POST['doc2-input'];
                                        $doc2_textarea = $_POST['doc2-textarea'];
    
                                        $query = "INSERT INTO `portalcliente_dev`.`doc_type` 
                                        (`DOC`,`FK_SUBTYPE`, `DOCITEM_TYPE`, `DOCITEM_TITLE`, `DOCITEM_DESCRIPTION`)
                                        VALUES ( '2', '".  $id."', 'IMAGE', '".$doc2_input."', '".$doc2_textarea."');";
                                        ejecuta( $query );  
                                    } 
                                }

                                if(!in_array("3", $listado_update)){
                                    if(!empty($_POST["doc3-input"])) {   
                                        $doc3_input = $_POST['doc3-input'];
                                        $doc3_textarea = $_POST['doc3-textarea'];

                                        $query = "INSERT INTO `portalcliente_dev`.`doc_type` 
                                        (`DOC`,`FK_SUBTYPE`, `DOCITEM_TYPE`, `DOCITEM_TITLE`, `DOCITEM_DESCRIPTION`)
                                        VALUES ( '3', '".  $id."', 'DOCUMENT', '".$doc3_input."', '".$doc3_textarea."');";
                                        ejecuta( $query );  
                                    }
                                }

                                echo '<div class="alert alert-success">La subtipología se ha modificado correctamente.</div>';
                            }
                            

                        }elseif($wact == 'del'){    //DELETE operation
                            $id = $_GET['id'];
                           
                            $query = "UPDATE INCIDENT_SUBTYPE SET `STATUS` = 'D' WHERE `ID` = '".$id."' ;";		
                            ejecuta( $query );
                            
                            echo '<div class="alert alert-success">La subtipología ha sido eliminada correctamente.</div>';
                        }elseif($wact == 'del_doctype'){
                            $doc = $_GET['doc'];
                            $id = $_GET['id'];

                            $query = "DELETE FROM `doc_type` WHERE `FK_SUBTYPE` = '".$id."' AND `DOC` = '".$doc."' ;";
                            ejecuta( $query );

                            echo '<div class="alert alert-success">El requisito de documentacion ha sido eliminada correctamente.</div>';
                        }
								
                        // VARIABLES para DOC_TYPE
                        $doc1 = [
                            "title" => "",
                            "description" => ""
                        ];
                        $doc2 = [
                            "title" => "",
                            "description" => ""
                        ];
                        $doc3 = [
                            "title" => "",
                            "description" => ""
                        ];

                        // Mostramos formulario
						if ( $wact == 'add' || $wact == 'edit' ){
                            
							if ( $wact == 'edit' ){
							
								$query = "SELECT * FROM INCIDENT_SUBTYPE WHERE ID = '".$wid."' AND STATUS = 'A'";
								$res = ejecuta( $query );														
								$row_user = $res->fetch_assoc();

                                $query2 = "SELECT 	`DOC`, 	`DOCITEM_TITLE`, `DOCITEM_DESCRIPTION` FROM `doc_type` 
                                WHERE FK_SUBTYPE = ".$wid.";";
								$res2 = ejecuta( $query2 );			

                                while ( $row = $res2->fetch_assoc())
                                {
                                    if($row['DOC'] == 1){
                                        $doc1['title'] = $row['DOCITEM_TITLE'];
                                        $doc1['description'] = $row['DOCITEM_DESCRIPTION'];
                                    }elseif ($row['DOC'] == 2){
                                        $doc2['title'] = $row['DOCITEM_TITLE'];
                                        $doc2['description'] = $row['DOCITEM_DESCRIPTION'];
                                    }elseif ($row['DOC'] == 3){
                                        $doc3['title'] = $row['DOCITEM_TITLE'];
                                        $doc3['description'] = $row['DOCITEM_DESCRIPTION'];
                                    }
                                }
							}
							
					?>
                            <form class="" action="<?php echo action('','op=admin_subtipologia&act=save'); ?>" method="POST">
							<div class="row">

                                <div class="col-lg-6">
                                    <div class="card">
                                        <div class="card-body">
            
                                            <h4 class="mt-0 header-title">Edición de subtipología</h4>
                                            
                                            <input type="hidden" name="id" value="<?php echo $row_user['ID']; ?>">
                                                
                                                <div class="form-group">
                                                <label for="">Seleccione tipología: </label>

                                                    <!-- Selector de tipologia -->
                                                    <select class="form-control w-50 " name="tipologia" id="sel_tipologia" required>
                                                        <option value="" disabled selected>Selecciona una opción</option>
                                                    <?php
                                                            $value = 0;
                                                            if(!empty($wid)){
                                                                $q2 = "SELECT `incident_type`.ID,`incident_type`.`NAME` FROM `incident_type` INNER JOIN `incident_subtype`
                                                                ON `incident_type`.`ID` = `incident_subtype`.`FK_TYPE`
                                                                WHERE `incident_type`.`STATUS` = 'A' AND `incident_subtype`.`ID` = ".$wid.";";
                                                                $res2 = ejecuta( $q2 );
                                                                $select_tipologia = $res2->fetch_assoc();
                                                                $value = $select_tipologia['ID'];
                                                            }
                                                            
                                                            $q = "SELECT * FROM INCIDENT_TYPE WHERE `STATUS` = 'A';";
                                                            $res = ejecuta( $q );

                                                            while ( $row = $res->fetch_assoc())
                                                            {
                                                                if ( $value == $row['ID']) {
                                                                    echo '<option selected="selected" value="'.$row['ID'].'">'.$row['NAME'].'</option>';
                                                                }
                                                                else{
                                                                    echo '<option value="'.$row['ID'].'">'.$row['NAME'].'</option>';
                                                                } 
                                                    }?>

                                                    </select>
                                                    <!-- Input nombre subtipología -->
                                                    <label>Nombre</label>
                                                    <div>
                                                        <input data-parsley-type="alphanum" type="text"
                                                                class="form-control" required
                                                                placeholder="" name="nombre" value="<?php echo $row_user['NAME']; ?>"/>
                                                    </div>
                                                </div>
                                                                                                                                    
                                                
                                                <div class="form-group mb-0">
                                                    <div>
                                                        <button type="submit" class="btn btn-primary waves-effect waves-light">
                                                            Guardar
                                                        </button>
                                                        <a href="<?php echo action('','op=admin_subtipologia'); ?>">
                                                            <button type="button" class="btn btn-secondary waves-effect m-l-5">
                                                            Cancelar
                                                            </button>
                                                        </a>
                                                    </div>
                                                </div>
            
                                        </div>
                                    </div>
                                </div> <!-- end col -->
                                                    
                                <!-- Elementos a adjuntar / DocType  -->
                                <div class="col-lg-6">
                                    <div class="card" id="doc1-form">
                                        <div class="card-body">
                                            <label for="doc1-textarea">TÍtulo para observaciones</label>
                                            <input type="text" class="form-control" id="doc1-input" name="doc1-input" value="<?php echo $doc1['title'];?>" required>
                                            <small id="help" class="form-text text-muted">Debes de introducir un titulo para identificar el caso.</small>
                                            <label for="doc1-textarea">Descripción a aportar en incidencia</label>
                                            <textarea class="form-control"  name="doc1-textarea" id="doc1-textarea" cols="20" required><?php echo $doc1['description'];?></textarea>
                                        </div>
                                    </div>
                                    <hr>
                                    <!-- Otra documentacion -->
                                    <p class="text-center">
                                        <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#doc2" aria-expanded="false" aria-controls="doc2">
                                            Aportar imagen
                                        </button>
                                        <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#doc3" aria-expanded="false" aria-controls="doc3">
                                            Aportar documento
                                        </button>
                                    </p>
                                    <div class="collapse" id="doc2">
                                        <div class="card card-body">
                                            <label for="doc2-input">TÍtulo para imagenes</label>
                                            <input type="text" class="form-control" id="doc2-input" name="doc2-input" value="<?php echo $doc2['title'];?>">
                                            <small id="help" class="form-text text-muted">Debes de introducir un titulo para identificar la imagen.</small>
                                            <label for="doc2-textarea">Descripción a aportar en incidencia para imagen</label>
                                            <textarea class="form-control"  name="doc2-textarea" id="doc2-textarea" cols="20"><?php echo $doc2['description'];?></textarea>
                                            <?php 
                                                if($wact == "edit" && $doc2['title'] != ""){
                                                    echo "<hr><label>Otras opciones:</label>";
                                                    echo '<a href="javascript:void(0)" onclick="if ( confirm(\''.htmlentities('¿').'Seguro que desea eliminar el aporte de imagen?\') ) window.open(\''.action('','op=admin_subtipologia&act=del_doctype&doc=2&id='.$row_user['ID']).'\', \'_self\');">
                                                    <button type="button" class="btn btn-danger"><i class="fa fa-trash"></i> Eliminar imagen</button>
                                                    </a>';
                                                }
                                            ?>
                                        </div>
                                    </div>
                                    <div class="collapse" id="doc3">
                                        <div class="card card-body">
                                            <label for="doc3-input">TÍtulo para documento</label>
                                            <input type="text" class="form-control" id="doc3-input" name="doc3-input" value="<?php echo $doc3['title'];?>">
                                            <small id="help" class="form-text text-muted">Debes de introducir un titulo para identificar el documento.</small>
                                            <label for="doc3-textarea">Descripción a aportar en incidencia para documento</label>
                                            <textarea class="form-control"  name="doc3-textarea" id="doc3-textarea" cols="20"><?php echo $doc3['description'];?></textarea>
                                            <?php 
                                                if($wact == "edit" && $doc3['title'] != ""){
                                                    echo "<hr><label>Otras opciones:</label>";
                                                    echo '<a href="javascript:void(0)" onclick="if ( confirm(\''.htmlentities('¿').'Seguro que desea eliminar el aporte de documento?\') ) window.open(\''.action('','op=admin_subtipologia&act=del_doctype&doc=3&id='.$row_user['ID']).'\', \'_self\');">
                                                    <button type="button" class="btn btn-danger"><i class="fa fa-trash"></i> Eliminar documento</button>
                                                    </a>';
                                                }
                                            ?>
                                        </div>
                                    </div>
                                </div>
                                
                            </div> <!-- end row -->
                            </form>
					
					<?php
							
							
						}else{
					
					?>
							
                            <div class="row">
							 <div class="col-12">
                                    <div class="card">
                                        <div class="card-body">
                                                   																						
											<div style="margin-bottom: 30px; padding-left: 15px">
												<a href="<?php echo action('','op=admin_subtipologia&act=add'); ?>">
													<button type="button" class="btn btn-danger"><i class="fa fa-plus"></i> Añadir subtipología</button>
												</a>
                                                <hr>
                                                <label for="">Seleccione tipología: </label>
                                                <select class="form-control w-50 " name="tipologia" id="sel_tipologia">
                                                    <option disabled selected>Selecciona una opción</option>
                                                <?php
														$q = "SELECT * FROM INCIDENT_TYPE WHERE `STATUS` = 'A';";
														$res = ejecuta( $q );
														
														while ( $row = $res->fetch_assoc())
														{
                                                            echo '<option value="'.$row['ID'].'">'.$row['NAME'].'</option>';
                                                 }?>

                                                </select>
											</div>
                               
                                           <table id="datatable_subtipologia" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                                <thead>
                                                <tr>
													<th>Nombre</th>
													<th width="10%">Acciones</th>
                                                </tr>
                                                </thead>
            
            
                                                <tbody>
                                                 
                                                            <!-- AJAX -->
                                                </tbody>
                                            </table>
            
                                        </div>
                                    </div>
                                </div> <!-- end col -->
                            </div> <!-- end row -->

                        <?php } ?>    
                            

                        </div><!-- container -->

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
                                
                                echo '<div class="alert alert-success">La subtipología se ha dado de alta correctamente.</div>';
                                
                                $id = insert_id();
                                $_GET['ID'] = $id;
                            
                        }else{
                                $id = $_POST['id'];
                                $name = $_POST['nombre'];
                                $tipologia = $_POST['tipologia'];
                                
                                $query = "UPDATE INCIDENT_SUBTYPE SET `NAME` = '".$name."', `FK_TYPE` = '".$tipologia."'  WHERE `ID` = '".$id."' ;";
                                $res = ejecuta( $query );	

                                // Se comprueba que DOC-TYPE se actualiza y cuales se insertan
                                $query2 = "SELECT `ID`,`DOC` FROM `DOC_TYPE` WHERE FK_SUBTYPE = ".$id.";";
                                $res2 = ejecuta( $query2 );

                                while ( $row = $res2->fetch_assoc())
                                {
                                    $html_elem = "doc".$row['DOC']."-";
                                    $query = "UPDATE `DOC_TYPE` SET `DOCITEM_TITLE` = '".$_POST[$html_elem.'input-'.$row['ID']]."',
                                    `DOCITEM_DESCRIPTION` = '".$_POST[$html_elem.'textarea-'.$row['ID']]."' WHERE `FK_SUBTYPE` = '".$id."' AND `DOC` = '".$row['DOC']."';";
                                    ejecuta( $query );  
                                }

                                echo '<div class="alert alert-success">La subtipología se ha modificado correctamente.</div>';
                                $_GET['id'] = $id; 
                            }

                            $wid = $id;
                            $wact = 'edit';

                        }elseif($wact == 'del'){    //DELETE operation
                            $id = $_GET['id'];
                           
                            $query = "UPDATE INCIDENT_SUBTYPE SET `STATUS` = 'D' WHERE `ID` = '".$id."' ;";		
                            ejecuta( $query );
                            
                            echo '<div class="alert alert-success">La subtipología ha sido eliminada correctamente.</div>';
                        }elseif($wact == 'del_doctype'){
                            $doc = $_GET['id_req'];
                            $id = $_GET['id'];

                            $query = "DELETE FROM `DOC_TYPE` WHERE `ID` = '".$doc."';";
                            ejecuta( $query );

                            echo '<div class="alert alert-success">El requisito de documentacion ha sido eliminada correctamente.</div>';
                            $_GET['ID'] = $id;
                            $wact = 'edit';

                        }elseif($wact == 'new_requisito'){

                            $doctype = $_POST['select_doctype'];
                            $title = $_POST['doc-input'];
                            $description = $_POST['doc-textarea'];
                            $id = $_POST['id'];
                            $DOCITEM_TYPE = "TEXT";

                            if($doctype == 2){$DOCITEM_TYPE = "IMAGE";}
                            elseif($doctype == 3){$DOCITEM_TYPE = "DOCUMENT";}

                            $query = "INSERT INTO `DOC_TYPE`  (`DOC`,`FK_SUBTYPE`,`DOCITEM_TYPE`,`DOCITEM_TITLE`,`DOCITEM_DESCRIPTION`)
                            VALUES(".$doctype.",".$id.",'".$DOCITEM_TYPE."','".$title."','".$description."');";
                            ejecuta( $query );

                            echo '<div class="alert alert-success">Se ha insertado el requisito de documentacion correctamente.</div>';

                            $_GET['id'] = $id;
                            $wid = $id;
                            $wact = 'edit';
                        }
								
                        // VARIABLES para DOC_TYPE
                        $docs = array();

                        // Mostramos formulario
						if ( $wact == 'add' || $wact == 'edit' || $wact == 'new_requisito'){
                            
							if ( $wact == 'edit' ){
							
								$query = "SELECT * FROM INCIDENT_SUBTYPE WHERE ID = '".$wid."' AND STATUS = 'A'";
								$res = ejecuta( $query );														
								$row_user = $res->fetch_assoc();

                                $query2 = "SELECT 	`ID`,`DOC`,`FK_SUBTYPE`,`DOCITEM_TITLE`,`DOCITEM_DESCRIPTION` FROM `DOC_TYPE` 
                                WHERE FK_SUBTYPE = ".$wid.";";
								$res2 = ejecuta( $query2 );			

                                while ( $row = $res2->fetch_assoc())
                                {
                                    
                                    $element = '<div class="card" id="doc">
                                        <div class="card-body">
                                            <label for="doc-input">Título del requisito</label>
                                            <input type="text" class="form-control" id="doc-input" name="doc'.$row['DOC'].'-input-'.$row['ID'].'" value="'. $row['DOCITEM_TITLE'].'">
                                            <small id="help" class="form-text text-muted">Debes de introducir un titulo para identificar el requisito.</small>
                                            
                                            <label for="doc-textarea">Descripción a aportar en la incidencia</label>
                                            <textarea class="form-control"  name="doc'.$row['DOC'].'-textarea-'.$row['ID'].'" id="doc-textarea" cols="20">'.$row['DOCITEM_DESCRIPTION'].'</textarea>
                                            
                                            <hr>
                                            <label>Otras opciones:</label>
                                            <a href="javascript:void(0)" onclick="if ( confirm(\''.htmlentities('¿').'Seguro que desea eliminar el requisito?\') ) window.open(\''.action('','op=admin_subtipologia&act=del_doctype&id='.$row['FK_SUBTYPE'].'&id_req='.$row['ID']).'\', \'_self\');">
                                            <button type="button" class="btn btn-danger"><i class="fa fa-trash"></i> Eliminar requisito</button>
                                            </a>
                                        </div>
                                    </div>';

                                    array_push($docs, $element);
                                }
							}
							
					?>
                        <form class="" action="<?php echo action('','op=admin_subtipologia&act=save'); ?>" method="POST">
							<div class="row">

                                <div class="col-lg-3">
                                    <div class="card">
                                        <div class="card-body">
            
                                            <h4 class="mt-0 header-title">Edición de subtipología</h4>
                                            
                                            <input type="hidden" name="id" value="<?php echo $row_user['ID']; ?>">
                                                
                                                <div class="form-group">
                                                <label for="">Seleccione tipología: </label>

                                                    <!-- Selector de tipologia -->
                                                    <select class="form-control" name="tipologia" id="sel_tipologia" required>
                                                        <option value="" disabled selected>Selecciona una opción</option>
                                                    <?php
                                                            $value = 0;
                                                            if(!empty($wid)){
                                                                $q2 = "SELECT `INCIDENT_TYPE`.ID,`INCIDENT_TYPE`.`NAME` FROM `INCIDENT_TYPE` INNER JOIN `INCIDENT_SUBTYPE`
                                                                ON `INCIDENT_TYPE`.`ID` = `INCIDENT_SUBTYPE`.`FK_TYPE`
                                                                WHERE `INCIDENT_TYPE`.`STATUS` = 'A' AND `INCIDENT_SUBTYPE`.`ID` = ".$wid.";";
                                                                $res2 = ejecuta( $q2 );
                                                                $select_tipologia = $res2->fetch_assoc();
                                                                $value = $select_tipologia['ID'];
                                                            }
                                                            
                                                            // Se muestra los tipos de incidentes actuales
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
                                                            }
                                                    ?>

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
                                                            Volver
                                                            </button>
                                                        </a>
                                                        <?php if($wact !='add'){?>
                                                            <button type="button" class="btn btn-warning float-right" data-toggle="modal" data-target="#modal-newitem">Añadir requisito</button>
                                                        <?php } ?>
                                                        </div>
                                                </div>
            
                                        </div>
                                    </div>
                                </div> <!-- end col -->

                                
                                                    
                                <!-- Elementos a adjuntar / DocType  -->
                                <div class="col-lg-9 elementos-doctype">
                                    <?php foreach ( $docs as $e) { echo $e; } ?>
                                </div>
                                
                            </div> <!-- end row -->
                        </form>

                        <!-- MODAL NEW ITEM -->
                        <form class="" action="<?php echo action('','op=admin_subtipologia&act=new_requisito'); ?>" method="POST">
                            <input type="hidden" name="id" value="<?php echo $row_user['ID']; ?>">
                            <div class="modal fade" id="modal-newitem" tabindex="-1" role="dialog" aria-labelledby="modal-newitem" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLongTitle">Añadir nuevo requisito</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <!-- MODAL content -->
                                        <div class="modal-body">

                                            <label for="select_doctype">Seleccione tipo de requisito: </label>
                                            <select class="custom-select" id="select_doctype" name="select_doctype" required>
                                                <option value="" selected disabled>Seleccione una opción</option>
                                                <option value="1">Texto</option>
                                                <option value="2">Imagen</option>
                                                <option value="3">Documento</option>
                                            </select>
                                            <hr>

                                            <label for="doc-input">Título</label>
                                            <input type="text" class="form-control" id="doc-input" name="doc-input" value="">
                                            <br>

                                            <small id="help" class="form-text text-muted">Debes de introducir un titulo identificativo.</small>
                                            <label for="doc-textarea">Descripción a aportar en incidencia</label>
                                            <textarea class="form-control"  name="doc-textarea" id="doc-textarea" cols="20"></textarea>
                                            <hr>
                                            <button type="submit" class="btn btn-success float-right">Añadir requisito</button>

                                        </div>       
                                    </div>
                                </div>
                            </div>
                        </form>
                        <!-- ./MODAL NEW ITEM -->
					
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

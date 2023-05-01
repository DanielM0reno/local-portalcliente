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
                            
                        }else{
                                $id = $_POST['id'];
                                $name = $_POST['nombre'];
                                $tipologia = $_POST['tipologia'];

                                $query = "UPDATE INCIDENT_SUBTYPE SET `NAME` = '".$name."', `FK_TYPE` = '".$tipologia."'  WHERE `ID` = '".$id."' ;";
                                $res = ejecuta( $query );	
                                echo '<div class="alert alert-success">La subtipología se ha modificado correctamente.</div>';
                            }
                            

                        }elseif($wact == 'del'){    //DELETE operation
                            $id = $_GET['id'];
                           
                            $query = "UPDATE INCIDENT_SUBTYPE SET `STATUS` = 'D' WHERE `ID` = '".$id."' ;";		
                            ejecuta( $query );
                            
                            echo '<div class="alert alert-success">La subtipología ha sido eliminada correctamente.</div>';
                        }
									
                        // Mostramos formulario
						if ( $wact == 'add' || $wact == 'edit' ){
							
							if ( $wact == 'edit' ){
							
								$query = "SELECT * FROM INCIDENT_SUBTYPE WHERE ID = '".$wid."' AND STATUS = 'A'";
								$res = ejecuta( $query );														
								$row_user = $res->fetch_assoc();
								
							}
							
					?>

							<div class="row">
                                <div class="col-lg-6">
                                    <div class="card">
                                        <div class="card-body">
            
                                            <h4 class="mt-0 header-title">Edición de subtipología</h4>
                                            
            
                                            <form class="" action="<?php echo action('','op=admin_subtipologia&act=save'); ?>" method="POST">
                                            <input type="hidden" name="id" value="<?php echo $row_user['ID']; ?>">
                                                
												 <div class="form-group">
                                                 <label for="">Seleccione tipología: </label>

                                                    <!-- Selector de tipologia -->
                                                    <select class="form-control w-50 " name="tipologia" id="sel_tipologia">
                                                        <option disabled selected>Selecciona una opción</option>
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
                                            </form>
            
                                        </div>
                                    </div>
                                </div> <!-- end col -->
            
                                
                            </div> <!-- end row -->

					
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

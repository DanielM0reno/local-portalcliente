 <?php require_once "users_actions.php"; ?>
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
                                               
                                                <li class="breadcrumb-item active">Usuarios</li>
                                            </ol>
                                        </div>
                                        <h4 class="page-title">Gestión de usuarios <i class="fas fa-question-circle"></i></h4>
                                    </div>
                                </div>
                            </div>
                            <!-- end page title end breadcrumb -->
							
					<?php 
																				
						if ( $wact == 'add' || $wact == 'edit' ){
							
							if ( $wact == 'edit' ){
							
								$query = "SELECT * FROM USERS WHERE id = '".$wid."' AND status != 'D'";
								$res = ejecuta( $query );														
								$row_user = $res->fetch_assoc();
								
							}
							
					?>

							<div class="row">
                                <div class="col-lg-6">
                                    <div class="card">
                                        <div class="card-body">
            
                                            <h4 class="mt-0 header-title">Edición del usuario</h4>
                                            
            
                                            <form class="" action="<?php echo action('','op=usuarios&act=save'); ?>" method="POST">
                                            <input type="hidden" name="id" value="<?php echo $row_user['id']; ?>">
												
                                                <div class="form-group">
                                                    <label>E-Mail</label>
                                                    <div>
                                                        <input type="email" class="form-control" required
                                                                parsley-type="email" placeholder="" name="email" value="<?php echo $row_user['email']; ?>" <?php echo ( $row_user['email'] != '' ? 'disabled': ''); ?>/>
                                                    </div>
                                                </div>
                                                
												 <div class="form-group">
                                                    <label>Nombre</label>
                                                    <div>
                                                        <input data-parsley-type="alphanum" type="text"
                                                                class="form-control" required
                                                                placeholder="" name="nombre" value="<?php echo $row_user['nombre']; ?>"/>
                                                    </div>
                                                </div>
												
												 <div class="form-group">
                                                    <label>Cliente</label>
                                                    <div>														
                                                        <select name="cus_id" class="select2 form-control mb-3 custom-select" style="width: 100%; height:36px;" required>
															<option value="">Seleccionar Cliente</option>
														<?php 
														
															$q = "SELECT * FROM CUSTOMER_CUS WHERE status != 'D'";
															$res = ejecuta( $q );
														
															while ( $row = $res->fetch_assoc()){																
																
																$selected = '';
																if ( $row_user['cus_id'] == $row['cus_id'] ) $selected = 'selected';
																
																echo '<option value="'.$row['cus_id'].'" '.$selected.'>'.$row['cus_corporatename'].'</option>';																																
															}
														
														?>															
														</select>
                                                    </div>
                                                </div>
												
												 <div class="form-group">
                                                    <label>Rol</label>
                                                    <div>
                                                        <select name="role" class="select2 form-control mb-3 custom-select" style="width: 100%; height:36px;" required>
															<option value="">Seleccionar Rol</option>
															<option value="admin" <?php echo ( $row_user['role'] == 'admin' ? 'selected' : '' ); ?>>Admin</option>
															<option value="cliente" <?php echo ( $row_user['role'] == 'cliente' ? 'selected' : '' ); ?>>Cliente</option>															
														</select>
                                                    </div>
                                                </div>
												
												 <div class="form-group">
                                                    <label>Contraseña</label>
                                                    <div>
                                                        <input data-parsley-type="alphanum" type="password"
                                                                class="form-control" required
                                                                placeholder="" name="password_1" value="<?php echo $row_user['password']; ?>" <?php echo ( $row_user['password'] != '' ? 'disabled': ''); ?>/>
                                                    </div>
                                                </div>		

												 <div class="form-group">
                                                    <label>Confirmar Contraseña</label>
                                                    <div>
                                                        <input data-parsley-type="alphanum" type="password"
                                                                class="form-control" required
                                                                placeholder="" name="password_2" value="<?php echo $row_user['password']; ?>" <?php echo ( $row_user['password'] != '' ? 'disabled': ''); ?>/>
                                                    </div>
                                                </div>													
												
                                                <div class="form-group mb-0">
                                                    <div>
                                                        <button type="submit" class="btn btn-primary waves-effect waves-light">
                                                            Guardar
                                                        </button>
                                                        <a href="<?php echo action('','op=usuarios'); ?>">
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
												<a href="<?php echo action('','op=usuarios&act=add'); ?>">
													<button type="button" class="btn btn-danger"><i class="fa fa-plus"></i> Añadir Usuario</button>
												</a>
											</div>
                               
                                           <table id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                                <thead>
                                                <tr>
                                                    <th>Usuario</th>
													<th>Nombre</th>
													<th>Cliente asociado</th>
													<th>Rol</th>
													
													<th width="10%">Acciones</th>
                                                </tr>
                                                </thead>
            
            
                                                <tbody>
													<?php
													
													
														$q = "SELECT * FROM USERS WHERE status != 'D'";
														$res = ejecuta( $q );
														
														while ( $row = $res->fetch_assoc())
														{
															
															$q2 = "SELECT cus_corporatename FROM CUSTOMER_CUS WHERE cus_id = '".$row['cus_id']."'";															
															$res2 = ejecuta( $q2 );
															$row2 = $res2->fetch_assoc();
															
															echo '<tr>
															<td>'.$row['email'].'</td>
															<td>'.$row['nombre'].'</td>
															<td>'.$row2['cus_corporatename'].'</td>
															<td>'.$row['role'].'</td>
																<td>
																	<a href="'.action('','op=usuarios&act=edit&id='.$row['id']).'">
																		<button type="button" class="btn btn-danger"><i class="fa fa-edit"></i></button>
																	</a>																	
																	<a href="javascript:void(0)" onclick="if ( confirm(\''.htmlentities('¿').'Seguro que desea eliminar el usuario?\') ) window.open(\''.action('','op=usuarios&act=del&id='.$row['id']).'\', \'_self\');">
																		<button type="button" class="btn btn-danger"><i class="fa fa-trash"></i></button>
																	</a>																	
																</td>
															</tr>';
														}
													
													?>
                                                 
                                                </tbody>
                                            </table>
            
                                        </div>
                                    </div>
                                </div> <!-- end col -->
                            </div> <!-- end row -->

                        <?php } ?>    
                            

                        </div><!-- container -->

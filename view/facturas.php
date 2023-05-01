 <div class="container-fluid">

						<div class="row">
                                <div class="col-sm-12">
                                    <div class="page-title-box">
                                        <div class="btn-group float-right">
                                            <ol class="breadcrumb hide-phone p-0 m-0">
                                                <li class="breadcrumb-item"><a href="#">Portal cliente</a></li>
                                                <li class="breadcrumb-item active">Facturas</li>
                                            </ol>
                                        </div>
                                        <h4 class="page-title">Resumen</h4>
                                    </div>
                                </div>
                            </div>
                            
							 <div class="row">
                                <div class="col-lg-6">
                                    <div class="row">
                                        <div class="col-lg-4">
                                            <div class="card">
                                                <div class="card-body">
                                                    <div class="icon-contain">
                                                        <div class="row">
                                                            <div class="col-2 align-self-center">
                                                                <i class="fas fa-tasks text-gradient-success"></i>
                                                            </div>
                                                            <div class="col-10 text-right">
                                                                <h5 class="mt-0 mb-1">	<?php
																
																$q = "SELECT count(*) num FROM DOCHEADER_DOH WHERE doh_type = '4' $filter_user_docs order by doh_id DESC;";
																$res = ejecuta( $q );
																
																if ( $row = $res->fetch_assoc())
																{
																	echo $row['num'];
																}
																
																?></h5>
                                                                <p class="mb-0 font-12 text-muted">Facturas recibidas</p>   
                                                            </div>
                                                        </div>                                                        
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="card">
                                                <div class="card-body justify-content-center">
                                                    <div class="icon-contain">
                                                        <div class="row">
                                                            <div class="col-2 align-self-center">
                                                                <i class="fas fa-tasks text-gradient-warning"></i>
                                                            </div>
                                                            <div class="col-10 text-right">
                                                                <h5 class="mt-0 mb-1">	<?php
																
																$q = "SELECT count(*) num FROM DOCHEADER_DOH WHERE doh_type = '4' and doh_payCompleted = 'f' $filter_user_docs order by doh_id DESC;";
																$res = ejecuta( $q );
																
																if ( $row = $res->fetch_assoc())
																{
																	echo $row['num'];
																}
																
																?></h5>
                                                                <p class="mb-0 font-12 text-muted">Pendientes de pago</p>
                                                            </div>
                                                        </div>                                                        
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
										
										  <div class="col-lg-4">
                                            <div class="card">
                                                <div class="card-body justify-content-center">
                                                    <div class="icon-contain">
                                                        <div class="row">
                                                            <div class="col-2 align-self-center">
                                                                <i class="fas fa-tasks text-gradient-danger"></i>
                                                            </div>
                                                            <div class="col-10 text-right">
                                                                <h5 class="mt-0 mb-1">0</h5>
                                                                <p class="mb-0 font-12 text-muted">Vencidas</p>
                                                            </div>
                                                        </div>                                                        
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                                                                   
                                    </div> 
                                                                    
                                </div>
                                                               
                            </div>
							
                            <div class="page-content-wrapper ">

                        <div class="container-fluid">

                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="page-title-box">
                                        <div class="btn-group float-right">
                                            <ol class="breadcrumb hide-phone p-0 m-0">
                                               
                                            </ol>
                                        </div>
                                        <h4 class="page-title">Histórico de facturas <i class="fas fa-question-circle"></i></h4>
                                    </div>
                                </div>
                            </div>
                            <!-- end page title end breadcrumb -->
                            <div class="row">
							 <div class="col-12">
                                  
						
							   
                                             <table id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                                <thead>
                                                <tr>
                                                    <th>Fecha factura</th>
													<th>Nº factura</th>
													<th>Importe</th>
													<th>Vencimiento</th>
													<th>Estado</th>
													<th width="10%">Acciones</th>
                                                </tr>
                                                </thead>
            
            
                                                <tbody>
													<?php
													
													
														$q = "SELECT * FROM DOCHEADER_DOH WHERE doh_type = '4' $filter_user_docs order by doh_id DESC;";
														$res = ejecuta( $q );
														
														while ( $row = $res->fetch_assoc())
														{
															
															$estado = '<span class="badge badge-warning">Pendiente pago</span>';
															
															switch( $row['doh_payCompleted'] )
															{
															
																case 't':
																
																	$estado = '<span class="badge badge-success">Cobrado</span>';
																break;
																
																case 'f':
																
																	$estado = '<span class="badge badge-warning">Pendiente cobro</span>';
																break;
																
																default;
															}
															
															
															echo '<tr>
															<td>'.lib::date_convert($row['doh_date']).'</td>
															<td>'.$row['doh_seqNumber'].'</td>
															<td style="text-align:right;">'.number_format($row['doh_netAmount'],2,",",".").'€</td>
															
															<td></td>
															
															<td style="text-align:center;">'.$estado.'</td>
															<td><button type="button" class="btn btn-default"><i class="fa fa-eye ver_detalle" data-id="'.$row['doh_id'].'"></i></button>
															<button type="button" class="btn btn-danger"><i class="fa fa-download"></i> Descargar factura</button></td>
															</tr>';
														}
													
													?>
                                                 
                                                </tbody>
                                            </table>
											
											
											  <div class="modal fade modal_detalle" id="modal_detalle" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog modal-lg">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title mt-0" id="myLargeModalLabel">Detalle de factura</h5>
                                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
																	
																	
                                                                </div>
                                                                <div class="modal-body">
                                                                   <table id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                                <thead>
                                                <tr>
                                                
                                                    <th>Id Producto</th>
													<th>Descripción</th>
													<th>Precio</th>
                                                    <th>Cantidad</th>
													<th>Subtotal</th>
                                                </tr>
                                                </thead>
            
            
                                                <tbody id="detalle_pedido">
												
									
												
												
                                                </tbody>
                                            </table>
                                                                </div>
														<div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                                          
															
                                                        </div>
                                                            </div><!-- /.modal-content -->
                                                        </div><!-- /.modal-dialog -->
                                                    </div><!-- /.modal -->
            
                                        </div>
                                    </div>
                                </div> <!-- end col -->
                            </div> <!-- end row -->

                            
                            

                        </div><!-- container -->

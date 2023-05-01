 <div class="container-fluid">

						
							
                            <div class="page-content-wrapper ">

                        <div class="container-fluid">

                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="page-title-box">
                                        <div class="btn-group float-right">
                                            <ol class="breadcrumb hide-phone p-0 m-0">
                                                <li class="breadcrumb-item"><a href="#">Portal Cliente</a></li>
                                                <li class="breadcrumb-item active"><a href="#">Albaranes</a></li>
                                            </ol>
                                        </div>
                                        <h4 class="page-title">Albaranes de entrega <i class="fas fa-question-circle"></i></h4>
                                    </div>
                                </div>
                            </div>
                            <!-- end page title end breadcrumb -->
                            <div class="row">
							 <div class="col-12">
                                   
							   
                                            <table id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                                <thead>
                                                <tr>
                                                    <th>Fecha albarán</th>
													<th>Nº albarán</th>
													<th>Envío</th>
													<th>Situación</th>
													<th width="10%">Acciones</th>
                                                </tr>
                                                </thead>
            
            
                                                <tbody>
													<?php
													
													
														$q = "SELECT * FROM DOCHEADER_DOH WHERE doh_type = '3' $filter_user_docs order by doh_id DESC;";
														$res = ejecuta( $q );
														
														while ( $row = $res->fetch_assoc())
														{
															
															switch( $row['doh_invoiced'] )
															{
																case '1':
																
																	$estado = '<span class="badge badge-warning">Pendiente facturar</span>';
																break;
																
																case '2':
																
																	$estado = '<span class="badge badge-primary">Parcialmente facturado</span>';
																break;
																
																case '3':
																
																	$estado = '<span class="badge badge-success">Facturado</span>';
																break;
																
																case '4':
																
																	$estado = '<span class="badge badge-success">Facturado</span>';
																break;
																
																default;
															}
															
															$envio = '';
															
															switch( $row['tco_doh_fk'] )
															{
																case '1':
																
																	$envio = '<span class="badge badge-default">FEDEX EXPRESS</span>';
																break;
																
																case '2':
																
																	$envio = '<span class="badge badge-default">TIPSA</span>';
																break;
																
																case '3':
																
																	$envio = '<span class="badge badge-default">TRANSPORTES NATURIL</span>';
																break;
																
																case '4':
																
																	$envio = '<span class="badge badge-default">DHL PARCEL IBERIA</span>';
																break;
																
																case '5':
																
																	$envio = '<span class="badge badge-default">AGENCIA CLIENTE</span>';
																break;
																
																default;
															}
															
															
															echo '<tr>
															<td>'.lib::date_convert($row['doh_date']).'</td>
															<td>'.$row['doh_seqNumber'].'</td>
															<td>'.$envio.'</td>
															<td style="text-align:center;">'.$estado.'</td>
																<td><button type="button" class="btn btn-default"><i class="fa fa-eye ver_detalle" data-id="'.$row['doh_id'].'"></i></button>
																<button type="button" class="btn btn-danger"><i class="fa fa-download"></i> Descargar albarán</button></td>
															</tr>';
														}
													
													?>
                                                 
                                                </tbody>
                                            </table>
											
											  <div class="modal fade modal_detalle" id="modal_detalle" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog modal-lg">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title mt-0" id="myLargeModalLabel">Detalle de pedido</h5>
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

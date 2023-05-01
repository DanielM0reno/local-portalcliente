 <div class="container-fluid">

						<div class="row">
                                <div class="col-sm-12">
                                    <div class="page-title-box">
                                        <div class="btn-group float-right">
                                            <ol class="breadcrumb hide-phone p-0 m-0">
                                                <li class="breadcrumb-item"><a href="#">Portal cliente</a></li>
                                                <li class="breadcrumb-item active">Dashboard</li>
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
                                                                <h5 class="mt-0 mb-1">
																<?php
																
																
																$q = "SELECT count(*) num FROM DOCHEADER_DOH WHERE doh_type = '2' and doh_serve in (1,2) $filter_user_docs order by doh_id DESC;";
																$res = ejecuta( $q );
																
																if ( $row = $res->fetch_assoc())
																{
																	echo $row['num'];
																}
																
																?>
																
																</h5>
                                                                <p class="mb-0 font-12 text-muted">Pedidos en curso</p>   
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
                                        <h4 class="page-title">Pedidos en curso<i class="fas fa-question-circle"></i></h4>
                                    </div>
                                </div>
                            </div>
                            <!-- end page title end breadcrumb -->
                            <div class="row">
							 <div class="col-12">
                                    <div class="card">
                                        <div class="card-body">
            
                                         <div class="col-lg-12"><div class="card-body"><div class="row">
				
						
							   
                                             <table id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                                <thead>
                                                <tr>
                                                    <th>Fecha pedido</th>
													<th>Nº pedido</th>
													<th>Nº pedido cliente</th>
													<th>Fecha entrega</th>
													<th>Importe</th>
													<th>Estado</th>
													<th width="10%">Acciones</th>
                                                </tr>
                                                </thead>
            
            
                                                <tbody>
													<?php
													
													
														$q = "SELECT * FROM DOCHEADER_DOH WHERE doh_type = '2' and doh_serve in (1,2) $filter_user_docs order by doh_id DESC;";
														$res = ejecuta( $q );
														
														while ( $row = $res->fetch_assoc())
														{
															
															switch( $row['doh_serve'] )
															{
																case '1':
																
																	$estado = '<span class="badge badge-warning">Pendiente servir</span>';
																break;
																
																case '2':
																
																	$estado = '<span class="badge badge-primary">Parcialmente servido</span>';
																break;
																
																case '3':
																
																	$estado = '<span class="badge badge-success">Servido</span>';
																break;
																
																case '4':
																
																	$estado = '<span class="badge badge-success">Servido</span>';
																break;
																
																default;
															}
															
															
															echo '<tr>
															<td>'.lib::date_convert($row['doh_date']).'</td>
															<td>'.$row['doh_seqNumber'].'</td>
															<td>'.$row['doh_n_customerDocID'].'</td>
															<td>'.lib::date_convert($row['doh_deliveryDateDoc']).'</td>
															<td style="text-align:right;">'.number_format($row['doh_netAmount'],2,",",".").'€</td>
															<td style="text-align:center;">'.$estado.'</td>
																<td><button type="button" class="btn btn-danger"><i class="fa fa-download"></i> Descargar pedido</button></td>
															</tr>';
														}
													
													?>
                                                 
                                                </tbody>
                                            </table>
											
											
											
            
                                        </div>
                                    </div>
                                </div> <!-- end col -->
                            </div> <!-- end row -->
							
							
							
							
							

                            
                            

                        </div><!-- container -->

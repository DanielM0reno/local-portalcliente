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
                                                                <h5 class="mt-0 mb-1">	<?php
																
																$q = "SELECT * FROM DOCHEADER_DOH WHERE doh_type = '1' $filter_user_docs order by doh_id DESC;";
																$res = ejecuta( $q );
																
																while ( $row = $res->fetch_assoc())
																{
																	$menosunmes = date("Y-m-d",strtotime(date("Y-m-d")."- 1 month")); 

																	if ( $row['doh_date'] >= $menosunmes ) $vigentes++;
																
																}
																
																echo $vigentes;
																
																?></h5>
                                                                <p class="mb-0 font-12 text-muted">Presupuestos vigentes</p>   
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
                                                <li class="breadcrumb-item"><a href="#">Portal Cliente</a></li>
                                                <li class="breadcrumb-item active"><a href="#">Presupuestos</a></li>
                                            </ol>
                                        </div>
                                        <h4 class="page-title">Histórico de presupuestos <i class="fas fa-question-circle"></i></h4>
                                    </div>
                                </div>
                            </div>
                            <!-- end page title end breadcrumb -->
                            <div class="row">
							 <div class="col-12">
                                   
							   
                                            <table id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                                <thead>
                                                <tr>
                                                    <th>Fecha presupuesto</th>
													<th>Nº presupuesto</th>
													<th>Estado</th>
													<th width="10%">Acciones</th>
                                                </tr>
                                                </thead>
            
            
                                                <tbody>
													<?php
													
													
														$q = "SELECT * FROM DOCHEADER_DOH WHERE doh_type = '1' $filter_user_docs order by doh_id DESC;";
														$res = ejecuta( $q );
														
														while ( $row = $res->fetch_assoc())
														{
															$menosunmes = date("Y-m-d",strtotime(date("Y-m-d")."- 1 month")); 
															
														
															
															if ( $row['doh_date'] >= $menosunmes ) $estado = '<span class="badge badge-success">Vigente</span>';
															else $estado = '<span class="badge badge-default">Vencido</span>';
															
															
															echo '<tr>
															<td>'.lib::date_convert($row['doh_date']).'</td>
															<td>'.$row['doh_seqNumber'].'</td>														
															<td style="text-align:center;">'.$estado.'</td>
															<td><button type="button" class="btn btn-danger"><i class="fa fa-download"></i> Descargar presupuesto</button></td>
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

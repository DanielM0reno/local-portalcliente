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
																	$incidencias = 1;
																
																?></h5>
                                                                <p class="mb-0 font-12 text-muted">Incidencias abiertas</p>   
                                                            </div>
                                                        </div>                                                        
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- NEW CODE -->
                                        <div class="col-lg-4">
                                            <div style="margin-bottom: 30px; padding-left: 15px">
                                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#new-incident">
                                                    <i class="fa fa-plus"></i> Añadir incidencia
                                                </button>
                                            </div>
                                        </div>

                                        <!-- Modal -->
                                        <div class="modal fade" id="new-incident" tabindex="-1" role="dialog" aria-labelledby="Nueva incidencia" aria-hidden="true">
                                            <form action="" id="new_incident">   <!-- FORM -->
                                                
                                                <input type="hidden" name="op" value="new_incident">
                                                <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                                                    <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLongTitle">Nueva incidencia</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                    <!-- Contenido modal -->
                                                        <div class="row">
                                                            <div class="col-lg-4">
                                                                <span><strong> Seleccione el tipo de indicencia</strong></span>
                                                                <br>    
                                                                <span>Tipo de incidencia:</span>
                                                                <select class="form-control form-control-sm select-incident" id="incident_type">
                                                                <!-- SELECT -->
                                                                <option disabled selected>Selecciona una opción</option>
                                                                <?php
                                                                    $q = "SELECT * FROM INCIDENT_TYPE WHERE `STATUS` = 'A';";
                                                                    $res = ejecuta( $q );
                                                                    
                                                                    while ( $row = $res->fetch_assoc())
                                                                    {  
                                                                        echo "<option value='".$row['ID'] ."' data-id='".$row['ID']."''>". $row['NAME']."</option>"; 
                                                                    }
                                                                    
                                                                ?>
                                                                </select>
                                                                <br>
                                                                <span>Subtipo de indicencia:</span>
                                                                <select class="form-control form-control-sm select-subincident" id="subincident_type">
                                                                    <option disabled selected>Selecciona una opción</option>
                                                                </select>
                                                            </div>
                                                            <div class="col-lg-8" class="container">
                                                                <span><strong> Subida documental</strong></span>
                                                                <div id="input_document">
                                                                
                                                                    <!-- INPUTS -->
                                                                
                                                                
                                                                </div>
                                                            </div>
                                                        </div>
                                                    <!-- #Contenido modal -->
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                                        <button type="submit" class="btn btn-primary">Guardar incidencia</button>
                                                    </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                        <!-- #Modal -->
                                        <!-- Modal NOTIFICACION-->
                                        <div class="modal fade" id="modalNotifCorrecto" tabindex="-1" role="dialog"  aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                                <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLongTitle">Notificacion</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <h2>Se ha insertado correctamente</h2>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-success" onClick="window.location.reload();">Continuar</button>
                                                </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="modal fade" id="modalNotifError" tabindex="-1" role="dialog"  aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                                <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLongTitle">Notificacion</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <h2>Se ha producido un problema</h2>
                                                    <p>Revisa si la informacion es correcta, y si el problema persiste contacte con un agente.</p>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                                                </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- ./Modal NOTIFICACION-->
                                        <!-- Modal VER DETALLER-->

                                        <div class="modal fade" id="modalVerDetalle" tabindex="-1" role="dialog" aria-labelledby="modalVerDetalle" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
                                                <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLongTitle">Incidencia</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body" id="detalle_rma">
                                                    ...
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- ./Modal VER DETALLER-->
                                        <!-- #NEW CODE -->
                                        
                                        
                                                                                   
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
                                                <li class="breadcrumb-item active"><a href="#">Incidencias</a></li>
                                            </ol>
                                        </div>
                                        <h4 class="page-title">Incidencias <i class="fas fa-question-circle"></i></h4>
                                    </div>
                                </div>
                            </div>
                            <!-- end page title end breadcrumb -->
                            <div class="row">
							 <div class="col-12">
                                   
							   
                                            <table id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                                <thead>
                                                <tr>
                                                    <th>Fecha incidencia</th>
													<th>Código incidencia</th>
													<th>Producto</th>
													<th>Tipología</th>
													<th>Estado</th>
													<th width="10%">Acciones</th>
                                                </tr>
                                                </thead>
            
            
                                                <tbody>
											<!-- Temporal -->
                                            <?php
													
													
														$q = "SELECT 	`INCIDENT`.`ID`,`FECHA_INCIDENTE`,`PRODUCTO`,`INCIDENT_TYPE`.`NAME` AS TIPOLOGIA, `INCIDENT`.`STATUS`, `CLIENTE`
                                                        FROM `INCIDENT`,`INCIDENT_TYPE`
                                                        WHERE `TIPOLOGIA` = `INCIDENT_TYPE`.`ID`;";
														$res = ejecuta( $q );
														
														while ( $row = $res->fetch_assoc())
														{
                                                            echo "<tr>";
                                                            echo "<td>".$row['FECHA_INCIDENTE']."</td>";
                                                            echo "<td>".$row['ID']."</td>";
                                                            echo "<td>".$row['PRODUCTO']."</td>";
                                                            echo "<td>".$row['TIPOLOGIA']."</td>";

                                                            if ($row['STATUS'] == 'ABIERTO'){
                                                                echo "<td class='text-center'><span class='badge badge-success'>".$row['STATUS']."</span></td>";
                                                            }
                                                            elseif ($row['STATUS'] == 'CERRADO'){
                                                                echo "<td class='text-center'><span class='badge badge-danger'>".$row['STATUS']."</span></td>";
                                                            }
                                                            
                                                            echo "<td>
                                                            <button type='button' class='btn btn-default ver_incidente' data-toggle='modal' data-target='#modalVerDetalle' data-id='".$row['ID']."'><i class='fa fa-eye ver_detalle'></i></button>
                                                            
                                                            <a href='".action('','op=trace_incident&id='.$row['ID'])."' class='btn btn-danger'>
                                                            <i class='fa fa-download'></i> Seguimiento incidencia
                                                            </a>
                                                            </td>";
                                                            echo "</tr>";
                                                        }
                                            ?>
                                                 
                                                </tbody>
                                            </table>
											
											
											 
            
                                        </div>
                                    </div>
                                </div> <!-- end col -->
                            </div> <!-- end row -->

                            
                            

                        </div><!-- container -->
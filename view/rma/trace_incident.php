<div class="container-fluid">

						

                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="page-title-box">
                                        <div class="btn-group float-right">
                                            <ol class="breadcrumb hide-phone p-0 m-0">
                                                <li class="breadcrumb-item"><a href="#">Portal Cliente</a></li>
                                                <li class="breadcrumb-item active"><a href="#">Seguimiento incidencia</a></li>
                                            </ol>
                                        </div>
                                        <h4 class="page-title">Seguimiento incidencia <i class="fas fa-question-circle"></i></h4>
                                    </div>
                                </div>
                            </div>
                            <!-- end page title end breadcrumb -->
                            <?php
                                
                                if($wact == 'change_status'){  
                                    
                                    $id = $_POST['id'];
                                    $status = $_POST['select-status'];

                                    $query = "UPDATE INCIDENT SET STATUS='".$status."' WHERE ID=".$id.";";
                                    ejecuta( $query );                    
                                    echo '<div class="alert alert-success">El estado ha sido actualizado.</div>';
                                    
                                }
                                if($wact == 'send_message'){
                                    $id = $_POST['id'];
                                    $message = $_POST['input_message'];

                                    //Obtengo el id del chat a partir del id del incidente
                                    $query_idchat = "SELECT ID FROM CHAT_INCIDENT ci WHERE FK_INCIDENT = ".$id.";";
                                    $res = ejecuta( $query_idchat ); 
                                    $id_chat = $res->fetch_assoc();

                                    //Inserto el mensaje
                                    $query = "INSERT INTO CHAT_MESSAGE
                                    (FK_CHAT, ID_USER, MESSAGE, FECHA, HORA)
                                    VALUES(".$id_chat['ID'].", ".$_SESSION[$_prefijo.'admin_user']['id'].", '".$message."', '".date("d/m/y")."', '".date('H:m')."');";
                                    ejecuta( $query ); 

                                }
                            ?>


                            <div class="row">
							 <div class="col-12">
                                   
							   <?php 
                                    $id =  $_GET['id'];
                                    $query = "SELECT inc.ID, FECHA_INCIDENTE, PRODUCTO, it.NAME as TIPOLOGIA, inc.STATUS, cc.cus_corporatename as CLIENTE
                                    FROM INCIDENT inc 
                                    INNER JOIN INCIDENT_TYPE it ON it.ID = inc.TIPOLOGIA 
                                    INNER JOIN CUSTOMER_CUS cc ON cc.cus_id = inc.CLIENTE 
                                    WHERE inc.ID = ".$id.";";
								    $res = ejecuta( $query );														
								    $incident_info = $res->fetch_assoc();


                               
                               ?>	
								<div class="row">

                                    <!-- LEFT CONTAINER -->
                                    <div class="col-5">
                                        <div class="card">
                                            <div class="card-body">
                                                <h4>Incidencia nº <?php echo $incident_info['ID']; ?></h4>
                                                <hr>
                                                <span><strong>Fecha: </strong><?php echo $incident_info['FECHA_INCIDENTE']; ?></span>
                                                <br>
                                                <span><strong>Tipologia: </strong><?php echo $incident_info['TIPOLOGIA']; ?></span>
                                                <br>
                                                <span><strong>Cliente: </strong><?php echo $incident_info['CLIENTE']; ?></span>
                                                <br>
                                                <span><strong>Estado actual: </strong></span>
                                                <?php 
                                                if ($incident_info['STATUS'] == 'ABIERTO'){
                                                    echo "<span class='badge badge-success'>". $incident_info['STATUS'] ."</span>"; 
                                                }
                                                elseif ($incident_info['STATUS'] == 'CERRADO'){
                                                    echo "<span class='badge badge-danger'>". $incident_info['STATUS'] ."</span>"; 
                                                }
                                                
                                                
                                                ?>
                                                <hr>
                                                <label for="select-status" class="w-100"><strong>Cambiar estado incidencia: </strong></label>
                                                <form class="" action="<?php echo action('','op=trace_incident&act=change_status&id='.$incident_info['ID']); ?>" method="POST">
                                                    <input type="hidden" name="id" value="<?php echo $incident_info['ID']; ?>">
                                                    <select name="select-status" id="select-status" class="form-control w-50 float-left">
                                                        <?php 
                                                            if($incident_info['STATUS'] == 'ABIERTO'){
                                                                echo "<option value='ABIERTO' selected='selected'>Abierto</option>";
                                                                echo "<option value='CERRADO'>Cerrado</option>";
                                                            }elseif($incident_info['STATUS'] == 'CERRADO'){
                                                                echo "<option value='ABIERTO'>Abierto</option>";
                                                                echo "<option value='CERRADO' selected='selected'>Cerrado</option>";
                                                            }
                                                        ?>
                                                    </select>
                                                    <button type="submit" class="btn btn-warning float-right w-25">Actualizar</button>
                                                </form>

                                            </div>
                                        </div>
                                    </div>
                                    <!-- ./LEFT CONTAINER -->

                                    <!-- RIGHT CONTAINER -->
                                    <div class="col-7">
                                        <div class="card">
                                            <div class="card-body">
                                                
                                                <div class="panel panel-primary">

                                                    <div class="panel-body mb-3 p-3 border rounded" style="overflow-y: scroll;height: 300px;">

                                                            <!-- MESSAGE -->
                                                            <?php
                                                                $query = "SELECT u.nombre, cm.MESSAGE, cm.FECHA, cm.HORA 
                                                                FROM CHAT_MESSAGE cm 
                                                                INNER JOIN CHAT_INCIDENT ci 
                                                                ON ci.ID = cm.FK_CHAT 
                                                                INNER JOIN USERS u
                                                                ON u.id = cm.ID_USER
                                                                WHERE ci.FK_INCIDENT ='".$id."';";

                                                                $res_message = ejecuta( $query );	


                                                                while ( $row = $res_message->fetch_assoc())
                                                                {
                                                                    echo '<div class="clearfix">
                                                                            <div class="header">
                                                                                <strong class="primary-font">'.$row['nombre'].'</strong> <small class="pull-right text-muted">
                                                                                <i class="fa fa-clock-o" aria-hidden="true"></i>'.$row['HORA'].' - '.$row['FECHA'].'</small>
                                                                            </div>
                                                                            <p>'.$row['MESSAGE'].'</p>
                                                                        </div>
                                                                        <hr class="w-75">';
                                                                }
                                                                
                                                                //echo "<h3 class='mt-2'>Todavia no hay mensajes...</h3>";
                                                                
                                                            ?>

                                                            <!-- ./MESSAGE -->
 
                                                    </div>

                                                    <!-- Panel de ENVIAR TEXTO -->
                                                    <form class="" action="<?php echo action('','op=trace_incident&act=send_message&id='.$incident_info['ID']); ?>" method="POST">

                                                    <div class="panel-footer">
                                                        <div class="input-group">
                                                                <input type="hidden" name="id" value="<?php echo $incident_info['ID']; ?>">
                                                                <input id="btn-input" type="text" name="input_message" class="form-control input-sm mr-2" placeholder="Escribe tu mensaje aquí..."  maxlength="100" required/>
                                                                <span class="input-group-btn">
                                                                    <button class="btn btn-info btn-sm" id="btn-chat" type="submit">Enviar mensaje</button>
                                                                </span>

                                                        </div>
                                                    </div>

                                                    </form>

                                                    <!-- ./Panel de ENVIAR TEXTO -->

                                                </div>
                                                        

                                            </div>
                                        </div>
                                    </div>
                                    <!-- ./RIGHT CONTAINER -->

                                </div>				
                            </div> <!-- end row -->

                            
                            

                        </div><!-- container -->
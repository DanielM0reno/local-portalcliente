<?php

ini_set("error_reporting",E_ERROR);
ini_set("display_errors","on");



define ('_leveloper_', true); // Por seguridad
define ('_url_crypt_', true);

require_once ("common/includes.php");


$auth = new Auth ();
$auth->login ();

if (!$auth->is_logged() or $_GET['act'] == 'logout') {
	
	session_destroy ();
	require_once ("code/login.php");
	exit ();
}


?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
        <title>Portal de cliente</title>
        <meta content="Admin Dashboard" name="description" />
        <meta content="Mannatthemes" name="author" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />

        <link rel="shortcut icon" href="assets/images/favicon.ico">

        <link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css">
        <link href="assets/css/icons.css" rel="stylesheet" type="text/css">
        <link href="assets/css/style.css" rel="stylesheet" type="text/css">
		
		   <!-- DataTables -->
        <link href="assets/plugins/datatables/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
        <link href="assets/plugins/datatables/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css" />
        <!-- Responsive datatable examples -->
        <link href="assets/plugins/datatables/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css" />

        <link href="assets/plugins/dropify/css/dropify.min.css" rel="stylesheet" type="text/css"/>

    </head>


    <body class="fixed-left">

        <!-- Loader -->
        <div id="preloader"><div id="status"><div class="spinner"></div></div></div>

        <!-- Begin page -->
        <div id="wrapper">

            <!-- ========== Left Sidebar Start ========== -->
            <div class="left side-menu">
                <button type="button" class="button-menu-mobile button-menu-mobile-topbar open-left waves-effect">
                    <i class="ion-close"></i>
                </button>

                <!-- LOGO -->
                <div class="topbar-left" style="background:#afc3cacc !important;">
                    <div class="text-center bg-logo" style="background-color:#fff !important;">
                       
                        <a href="index.php" class="logo"><img src="./assets/images/logo-inforges-principal.png" height="60" alt="logo"></a>
                    </div>
                </div>
                <div class="sidebar-user">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/9/99/Sample_User_Icon.png" alt="user" class="rounded-circle img-thumbnail mb-1">
                    <h4 class=""><?php echo $_SESSION['ser_admin_user']['nombre']; ?></h4> 
					
					
					<?php
						$q = "SELECT * FROM CUSTOMER_CUS WHERE cus_id = '".$_SESSION['ser_admin_user']['cus_id']."';";
						$res = ejecuta( $q );
						
						if ( $row = $res->fetch_assoc())
						{
							$cliente = $row['cus_corporatename'];
						}
					?>
					
					
                    <h6 class=""><?php echo $cliente; ?></h6>                 
                    <ul class="list-unstyled list-inline mb-0 mt-2">
                        <li class="list-inline-item">
                            <a href="#" class="" data-toggle="tooltip" data-placement="top" title="Profile"><i class="dripicons-user text-purple"></i></a>
                        </li>
                       
                        <li class="list-inline-item">
                            <a href="#" class="" data-toggle="tooltip" data-placement="top" title="Log out"><i class="dripicons-power text-danger"></i></a>
                        </li>
                    </ul>           
                </div>

                <div class="sidebar-inner slimscrollleft">

                    <div id="sidebar-menu">
                        <ul>
                            <li class="menu-title">Principal</li>

                            <li>
                                <a href="index.php?op=dashboard" class="waves-effect">
                                    <i class="dripicons-device-desktop"></i>
                                    <span> Dashboard </span>
                                </a>
                            </li>
                          

                            <li class="menu-title">Documentos</li>


							<li>
                                <a href="<?php echo action('','op=presupuestos'); ?>" class="waves-effect"><i class="fas fa-tasks"></i> <span> Presupuestos </span> </a>
                                
                            </li>
							
							<li>
                                <a href="<?php echo action('','op=pedidos'); ?>" class="waves-effect"><i class="fas fa-tasks"></i> <span> Pedidos </span> </a>
                                
                            </li>
							<li>
                                <a href="<?php echo action('','op=albaranes'); ?>" class="waves-effect"><i class="fas fa-truck"></i> <span> Albaranes </span> </a>
                                
                            </li>
							<li>
                                <a href="<?php echo action('','op=facturas'); ?>" class="waves-effect"><i class="fas fa-tasks"></i> <span> Facturas </span> </a>
                                
                            </li>
							<li>
                                <a href="<?php echo action('','op=rma'); ?>" class="waves-effect"><i class="fas fa-tasks"></i> <span> RMA </span> </a>
                                
                            </li>
							
							
							<?php if ( $_SESSION['ser_admin_user']['role'] == 'admin'): ?>
							
							
							   <li class="menu-title">Administración</li>

							<li style="display:none;">
                                <a href="/index.php?op=cuenta" class="waves-effect"><i class="dripicons-user"></i><span> Mi cuenta </span> </a>
                               
                            </li>
							
                            <li>
                                <a href="<?php echo action('','op=usuarios'); ?>" class="waves-effect"><i class="dripicons-user"></i><span> Gestión de usuarios </span> </a>
                               
                            </li>

                            <li>
                                <a href="<?php echo action('','op=admin_tipologia'); ?>" class="waves-effect"><i class="dripicons-document"></i><span> Gestión de tipologias </span> </a>
                               
                            </li>
							
							<?php endif; ?>
						


                           

                        </ul>
                    </div>
                    <div class="clearfix"></div>
                </div> <!-- end sidebarinner -->
            </div>
            <!-- Left Sidebar End -->

            <!-- Start right Content here -->

            <div class="content-page">
                <!-- Start content -->
                <div class="content">

                    <!-- Top Bar Start -->
                    <div class="topbar">

                        <nav class="navbar-custom"  style="background:#afc3cacc  !important;">

                            <ul class="list-inline float-right mb-0">
                                <!-- language-->
                  
                                <li class="list-inline-item dropdown notification-list" style="display:none;">
                                    <a class="nav-link dropdown-toggle arrow-none waves-effect" data-toggle="dropdown" href="#" role="button"
                                       aria-haspopup="false" aria-expanded="false">
                                        <i class="fa fa-tasks noti-icon"></i>
                                        <span class="badge badge-danger noti-icon-badge">1</span>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right dropdown-arrow dropdown-menu-lg" style="display:none;">
                                        <!-- item-->
                                        <div class="dropdown-item noti-title">
                                            <h5><span class="badge badge-danger float-right">1</span>Facturas vencidas</h5>
                                        </div>

                                       

                                        <!-- All-->
                                        <a href="javascript:void(0);" class="dropdown-item notify-item border-top">
                                            Ver todas
                                        </a>

                                    </div>
                                </li>

                               

                                <li class="list-inline-item dropdown notification-list">
                                    <a class="nav-link dropdown-toggle arrow-none waves-effect nav-user" data-toggle="dropdown" href="#" role="button"
                                       aria-haspopup="false" aria-expanded="false">
                                        <img style="background:#fff;" src="https://upload.wikimedia.org/wikipedia/commons/9/99/Sample_User_Icon.png" alt="user" class="rounded-circle">
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right profile-dropdown ">
                                        <!-- item-->
                                        <div class="dropdown-item noti-title">
                                            <h5>Bienvenido</h5>
                                        </div>
                                        <a  style="display:none;" class="dropdown-item" href="#"><i class="mdi mdi-account-circle m-r-5 text-muted"></i> Mi cuenta</a>
                                    
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item" href="<?php echo action('','act=logout'); ?>"><i class="mdi mdi-logout m-r-5 text-muted"></i> Logout</a>
                                    </div>
                                </li>
                            </ul>

                            <ul class="list-inline menu-left mb-0">
                                <li class="float-left">
                                    <button class="button-menu-mobile open-left waves-light waves-effect">
                                        <i class="mdi mdi-menu"></i>
                                    </button>
                                </li>
                            
                            </ul>

                            <div class="clearfix"></div>
                        </nav>
                    </div>
                    <!-- Top Bar End -->

                    <div class="page-content-wrapper ">
					
					<?php
					
					switch( $_GET['op'] )
					{
							case 'usuarios':
								require_once("code/users.php");
							break;
							case 'albaranes':
							    require_once("view/albaranes.php");
							break;
							case 'facturas':
							    require_once("view/facturas.php");
							break;
							case 'pedidos':
							    require_once("view/pedidos.php");
							break;
							case 'presupuestos':
							    require_once("view/presupuestos.php");
							break;
							case 'existencias':
							    require_once("view/existencias.php");
							break;
							case 'rma':
							    require_once("view/rma/index.php");
							break;
                            case 'admin_tipologia':
							    require_once("code/typology_admin.php");
							break;
                            case 'admin_subtipologia':
							    require_once("code/subtypology_admin.php");
							break;

                            case 'trace_incident':
							    require_once("view/rma/trace_incident.php");
							break;

							default:
								require_once("code/dashboard.php");
					}
					
					

                    ?>
                    </div> <!-- Page content Wrapper -->
                            
                        </div><!-- container -->

                    </div> <!-- Page content Wrapper -->

                </div> <!-- content -->

                <footer class="footer">
                    © 2022 Portal Cliente.
                </footer>

            </div>
            <!-- End Right content here -->

        </div>
        <!-- END wrapper -->


        <!-- jQuery  -->
        <script src="assets/js/jquery.min.js"></script>
        <script src="assets/js/popper.min.js"></script>
        <script src="assets/js/bootstrap.min.js"></script>
        <script src="assets/js/modernizr.min.js"></script>
        <script src="assets/js/detect.js"></script>
        <script src="assets/js/fastclick.js"></script>
        <script src="assets/js/jquery.slimscroll.js"></script>
        <script src="assets/js/jquery.blockUI.js"></script>
        <script src="assets/js/waves.js"></script>
        <script src="assets/js/jquery.nicescroll.js"></script>
        <script src="assets/js/jquery.scrollTo.min.js"></script>

        <script src="assets/plugins/dropify/js/dropify.min.js"></script>

		
		<!-- Required datatable js -->
        <script src="assets/plugins/datatables/jquery.dataTables.min.js"></script>
        <script src="assets/plugins/datatables/dataTables.bootstrap4.min.js"></script>

        <script src="assets/plugins/chart.js/chart.min.js"></script>
        <script src="assets/pages/dashboard.js"></script>

        <!-- App js -->
        <script src="assets/js/app.js"></script>
		
		   <!-- Datatable init js -->
        <script src="assets/pages/datatables.init.js"></script>
		
		
		<script>
		jQuery(document).ready(function () {
            
				jQuery(".ver_detalle").click( function () {
					var id = jQuery(this).attr("data-id");
					$.post( "ajax.php", { op: "detalle_pedido", idpedido: id })
					  .done(function( data ) {
						
						jQuery("#detalle_pedido").html( data );
						$('#modal_detalle').modal('show');
					  });
					
					
					
				} );

                // NEW CODE
                // Ver detalle RMA
                jQuery(".ver_incidente").click( function () {
					var id = jQuery(this).attr("data-id");
					$.post( "ajax.php", { op: "detalle_rma", id_incidencia: id })
					  .done(function( data ) {
						
						jQuery("#detalle_rma").html( data );
						$('#modalVerDetalle').modal('show');
					  });
					
					
					
				} );
                // Selectores de incidencias
                jQuery(".select-incident").change( function () {
                    var id = $('#incident_type').find(":selected").val();
                    $.post( "ajax.php", { op: "subtype_incident", id_incident: id })
					  .done(function( data ) {
						jQuery("#subincident_type").html( data );
                        jQuery("#input_document").html( "" );
					  });

				} );

                jQuery(".select-subincident").change( function () {
                    var id = $('#subincident_type').find(":selected").val();
                    $.post( "ajax.php", { op: "document_incident", id_subincident: id })
					  .done(function( data ) {
						jQuery("#input_document").html( data );
                        $('.dropify').dropify({
                            messages: {
                                'default': 'Arrastre y suelte un fichero aqui o haga click',
                                'replace': 'Arrastre y suelte un fichero aqui o haga click para reemplazar',
                                'remove':  'Eliminar',
                                'error':   'Ooops, algo ha salido mal.'
                            }
                        });

					  });

				} );
                // #Selectores de incidencias

                // Nueva INCIDENCIA
                $("#new_incident").submit(function(e) {
                    e.preventDefault(); // avoid to execute the actual submit of the form.
                    var form = $(this);
                    var formData = new FormData(document.getElementById("new_incident"));
                    formData.append('op', 'new_incident');

                    // -------------------- Temporal
                    formData.append('incident_type', $( "#incident_type" ).val());

                    // Obtener los DOC_TYPE para insertarlos en la BBDD junto con los ficheros enviados
                    var id_forminputs = [];
                    $('.form_input').each(function () {
                        id_forminputs.push(this.id);
                    });

                    for (var i = 0; i < id_forminputs.length; i++) {
                        formData.append('id_forminputs[]', id_forminputs[i]);
                    }

                    $.ajax({
                        url : "ajax.php",
                        type : "POST",
                        data : formData,
                        contentType : false,
                        processData : false
                    }).done(function(response){
                        console.log(response)
                        if(response == "OK"){
                            $('#new-incident').modal('toggle');
                            $('#modalNotifCorrecto').modal('show');
                        }
                        if(response == "ERROR"){
                            $('#modalNotifError').modal('show');                        
                        }
                    }).fail(function(){
                        // Here you should treat the http errors (e.g., 403, 404)
                    }).always(function(){
                        console.log("AJAX request finished!");
                    });
                });

                // Selectores de incidencias PARA TABLA en GESTION subincidencias
                jQuery("#sel_tipologia").change( function () {
                    var id = $('#sel_tipologia').find(":selected").val();
                    $.post( "ajax.php", { op: "subincident_table", id_incident: id })
					  .done(function( data ) {
						jQuery("#datatable_subtipologia tbody").html( data );
					  });

				} );
			    // #NEW CODE
		});
		
		</script>
        

    </body>
</html>
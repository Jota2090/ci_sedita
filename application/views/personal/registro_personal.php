<!DOCTYPE html>
<html>
    <head>
    	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
        <title>Sedita Registro Personal</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta name="description" content="" />
        <meta name="Sedita" content="" />
        <base href="<?=site_url()?>" />
        
        <link href="assets/css/bootstrap.css" rel="stylesheet" />
        <link href="assets/css/bootstrap.min.css" rel="stylesheet"/>
        <link rel="shortcut icon" href="assets/ico/favicon.ico"/>
        <link rel="apple-touch-icon-precomposed" sizes="144x144" href="assets/ico/apple-touch-icon-144-precomposed.png" />
        <link rel="apple-touch-icon-precomposed" sizes="114x114" href="assets/ico/apple-touch-icon-114-precomposed.png" />
        <link rel="apple-touch-icon-precomposed" sizes="72x72" href="assets/ico/apple-touch-icon-72-precomposed.png" />
        <link rel="apple-touch-icon-precomposed" href="assets/ico/apple-touch-icon-57-precomposed.png" />
        
        <script src="assets/js/jquery-bootstrap.js"></script>
        <script src="assets/js/bootstrap-alert.js"></script>
        <script src="assets/js/bootstrap-modal.js"></script>
        <script src="assets/js/bootstrap-dropdown.js"></script> 
        
        <style type="text/css">
            body {
                width: 1320px;
                padding-top: 60px;
                padding-bottom: 40px;
                margin: 0 auto;
                font-family: Arial;
            	font-size: 14px;        
            }
            .sidebar-nav {
                padding: 9px 0;
            }
        </style>
        
        <script>
            function guardar(){
                var nombre = $("#txtNombres").val();
                var apellido = $("#txtApellidos").val();
                var domicilio = $("#txtDomicilio").val();
                var telefono = $("#txtTelefono").val();
                var cell = $("#txtCell").val();
                var cedula = $("#txtCedula").val();
                
                if(nombre==""){
                    alert("nombre");
                }
                else{
                    if(apellido==""){
                        alert("apellido");
                    }
                    else{
                        if(domicilio==""){
                            alert("domicilio");
                        }
                        else{
                            if((telefono==""||telefono==null)&&(cell==""||cell==null)){
                                alert("telefono");
                            }
                            else{
                                if(cedula==""||cedula==null){
                                    alert("cedula");
                                }
                                else{
                                    document.forma.submit();
                                }
                            }
                        }       
                    }
                }
            };
        </script>
    </head>

    <body data-spy="scroll" data-target=".bs-docs-sidebar">
        <div class="navbar navbar-inverse navbar-fixed-top">
          <div class="navbar-inner">
            <div class="container-fluid">
              <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
              </a>
              <a class="brand" href="<?=site_url("main")?>">Sistema Sedita</a>
              <div class="nav-collapse collapse">
                <p class="navbar-text pull-right">
                    <a href="<?=site_url("login/cerrar")?>" class="navbar-link">Cerrar Sesion</a>
                </p>
                <ul class="nav nav-pills">
                    <li class="dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="">
                            Ingresos
                            <b class="caret"></b>
                        </a>
                        <ul class="dropdown-menu">
                            <li class="dropdown-submenu">
                                <a tabindex="-1" href="<?=site_url("alumno")?>">Alumnos</a>
                                <ul class="dropdown-menu">
                                    <li><a tabindex="-1" href="<?=site_url("alumno")?>">Matriculaci&oacute;n</a></li>
                                    <li><a tabindex="-1" href="<?=site_url("alumno/consultar")?>">Consultar o Actualizar</a></li>
                                </ul>
                            </li>
                            <li class="dropdown-submenu">
                                <a tabindex="-1" href="<?=site_url("personal")?>">Personal</a>
                                <ul class="dropdown-menu">
                                    <li><a tabindex="-1" href="<?=site_url("personal")?>">Registro</a></li>
                                    <li><a tabindex="-1" href="<?=site_url("personal/consultar")?>">Consultar o Actualizar</a></li>
                                    <li><a tabindex="-1" href="<?=site_url("personal/asignacion_cursos")?>">Asignar Curso o Dirigente</a></li>
                                </ul>
                            </li>
                            <li class="dropdown-submenu">
                                <a tabindex="-1" href="<?=site_url("listados/nomina_alumnos")?>">Listados</a>
                                <ul class="dropdown-menu">
                                    <li><a tabindex="-1" href="<?=site_url("listados/nomina_alumnos")?>">N&oacute;mina o Actas de Alumnos</a></li>
        
                                </ul>
                            </li>
                        </ul>
                    </li>
                    <li class="dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="">
                            Calificaciones
                            <b class="caret"></b>
                        </a>
                        <ul class="dropdown-menu">
                            <!--<li><a tabindex="-1" href="=site_url("acta_calificaciones")?>">Actas de Calificaciones</a></li>-->
                            <li class="dropdown-submenu">
                                <a tabindex="-1" href="<?=site_url("libreta")?>">Libretas</a>
                                <ul class="dropdown-menu">
                                    <li><a tabindex="-1" href="<?=site_url("libreta")?>">Consultar o Imprimir</a></li>
                                    <li><a tabindex="-1" href="<?=site_url("listados/cuadro_honor")?>">Cuadro de Honor</a></li>
                                    <li><a tabindex="-1" href="<?=site_url("listados/cuadro_promocion")?>">Cuadro de Promoci&oacute;n</a></li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                    <li class="dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="<?=site_url("mantenimiento/usuarios") ?>">
                            Mantenimiento
                            <b class="caret"></b>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a tabindex="-1" href="<?=site_url("mantenimiento/usuarios") ?>">Usuarios</a></li>
                            <li><a tabindex="-1" href="<?=site_url("mantenimiento/cursos") ?>">Cursos</a></li>
                            <li class="dropdown-submenu">
                                <a tabindex="-1" href="#">Materias</a>
                                <ul class="dropdown-menu">
                                    <li><a tabindex="-1" href="<?=site_url("mantenimiento/nom_mat")?>">Nombres</a></li>
                                    <li><a tabindex="-1" href="<?=site_url("mantenimiento/mat_curso")?>">Materias por Curso</a></li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                    <li><a href="#contact">Ayuda</a></li>
                </ul>
              </div><!--/.nav-collapse -->
            </div>
          </div>
        </div>
        <div class="container-fluid">
          <div class="row-fluid">
            <div class="span3">
                <div class="well sidebar-nav" style="width:300px;">
                    <ul class="nav nav-list">
                      <li class="nav-header">Personal</li>
                      <li class="active"><a href="<?=site_url("personal")?>">Registro</a></li>
                      <br />
                      <li class="nav-header">Profesor</li>
                      <li><a href="<?=site_url("personal/asignacion_cursos")?>">Asignaci&oacute;n de Cursos y Dirigentes</em></a></li>
                      <br />
                    </ul>
                </div><!--/.well -->
                <div class="well sidebar-nav" style="float:left;width:200px;margin:30px 0 0 50px">
                    <ul class="nav nav-list">
                      <li class="nav-header">Ayuda<i class="icon-question-sign" style="float: right;"></i></li>
                      <li><a>En esta secci&oacute;n podr&aacute; <b>registrar al personal del plantel</b> en el per&iacute;odo actual.</a></li>
                    </ul>
                </div><!--/.well -->
            </div>
            <div class="span9">
                <div class="panel" style="width: 800px;">
                    <form style="padding-right: 100px;" id="forma" name="forma" class="form-horizontal" action="<?=site_url("personal/guardar")?>" method="post" >
                       <input type="hidden" id="indicador" name="indicador" />
                       <fieldset>
                           <legend>Registro de Personal</legend>
                            <div class="span9">
                                <div class="span7">
                                    <label class="control-label"><b>Cargo</b></label>
                                    <div class="controls">
                                        <select id="cmbCargo" name="cmbCargo" style="width: 130px;">
                                            <?=$cargos?>
                                        </select>
                                    </div>
                                </div>
                                
                                <div class="span2">
                                    <label class="control-label"><b>A&ntilde;o Lectivo</b></label>
                                    <div class="controls">
                                        <?php 
                                            $js = "id='cmbAnioLectivo' style='width:130px' ";
                                            echo form_dropdown("cmbAnioLectivo",$anio_lectivo, $anl, $js);
                                        ?>
                                    </div>
                                </div>
                                
                                <div class="span9" style="margin-top: 10px;">
                                    <label class="control-label"><b>Nombres*</b></label>
                                    <div class="controls">
                                        <input style="height:30px;width:375px;" type="text" name="txtNombres" id="txtNombres" />
                                    </div>
                                </div>
                                
                                <div class="span9" style="margin-top: 10px;">
                                    <label class="control-label"><b>Apellidos*</b></label>
                                    <div class="controls">
                                        <input style="height:30px;width:375px;" type="text" name="txtApellidos" id="txtApellidos" />
                                    </div>
                                </div>
                                
                                <div class="span9" style="margin-top: 10px;">
                                    <label class="control-label"><b>Domicilio*</b></label>
                                    <div class="controls">
                                        <input style="height:30px;width: 375px;" type="text" name="txtDomicilio" id="txtDomicilio" />
                                    </div>
                                </div>
                                
                                <div class="span5" style="margin-top: 10px;">
                                    <label class="control-label"><b>Tel&eacute;fono*</b></label>
                                    <div class="controls">
                                        <input style="height:30px;width: 120px;" type="text" name="txtTelefono" id="txtTelefono" />
                                    </div>
                                </div>
                                
                                <div class="span4" style="margin-top: 10px;">
                                    <div class="controls">
                                         <input style="height:30px;width: 120px;" type="text" name="txtCell" id="txtCell" />
                                    </div>
                                </div>
                                
                                <div class="span9" style="margin-top: 10px;">
                                    <label class="control-label"><b>C&eacute;dula*</b></label>
                                    <div class="controls">
                                        <input style="height:30px;width: 120px;" type="text" name="txtCedula" id="txtCedula" />
                                    </div>
                                </div>
                                <div class="span9">
                                    <label class="control-label" style="margin-top: 10px;"><b>Comentarios</b></label><br /><br />
                                     <textarea style="height:30px;width: 375px; height: 100px; margin-left: 180px;" name="txtComentarios" id="txtComentarios" > </textarea>
                                 </div>
                            </div>
                            <div class="span9" style="margin:30px 0 20px 250px;">
                                <input class="btn" type="button" name="btnCancelar" id="btnCancelar" value="Cancelar" />
                                <a class="btn btn-primary" style="margin-left:80px;" href="javascript:guardar()">Guardar</a>
                            </div>
                        </fieldset> 
                    </form>
                </div>
            </div><!--/span-->
            <div class="span2"></div>
          </div><!--/row-->
    
          <hr>
    
          <footer>
            <h6>Realizado por Sedita &nbsp;&nbsp; - &nbsp;&nbsp; &copy; Company 2012</h6>
          </footer>
    
        </div><!--/.fluid-container-->
    </body>
</html>
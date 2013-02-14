<!DOCTYPE html>
<html>
    <head>
    	<meta charset="utf-8" />
        <title>Sedita Nombres/Materias</title>
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
        
        <script>
            function fncCmbMateria(){
                var nombre= $("#txtMat").val();
                
                if(nombre==""){
                    alert("Debe escribir un nombre");
                    //$('#warning').modal();
                }
                else{
                    $("#resultadosConsulta").innerHTML="";
                    $.ajax({
                        type:"post",
                        url: "<?=site_url("mantenimiento/nom_mat")?>",
                        data:"nom="+nombre+"&ind=1",
                        success:function(info){
                            $("#resultadosConsulta").html(info);
                        }
                    });
                }
            };
        </script>
        
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
        <form class="form-horizontal">
            <fieldset>
                <legend>Materias del Plantel</legend>
                <div class="panel span8" style="width:750px; margin-left:130px; padding:20px 0 20px 0;">
                    <div class="control-group span5">
                        <label class="control-label"><b>Nombre*</b></label>
                        <div class="controls">
                            <input style="height: 30px;" type="text" id="txtMat" name="txtMat" />
                        </div>
                    </div>
                    <div class="control-group span4">
                        <a href="javascript:fncCmbMateria()" id="btnConsultar" class="btn btn-primary" style="width:120px;margin-left:100px;" ><i class="icon-search"></i>Buscar</a>
                   </div>
                </div>
                <div class="span4" style="margin-left:120px;">
                    <div class="well sidebar-nav" style="width: 200px;">
                        <ul class="nav nav-list">
                          <li class="nav-header">Ayuda<i class="icon-question-sign" style="float: right;"></i></li>
                          <li><a>En esta secci&oacute;n podr&aacute; <b>agregar, buscar, y editar</b> materias del plantel.</a></li>
                        </ul>
                    </div><!--/.well -->
                </div><!--/span-->
            </fieldset>
        </form> 
        
        <div id="resultadosConsulta" style="width: 1100px; margin: 0 auto;">
            <?php foreach($css_files as $file): ?>
            	<link type="text/css" rel="stylesheet" href="<?php echo $file; ?>" />
                <base href="<?=site_url()?>" />
            <?php endforeach; ?>

            <?php foreach($js_files as $file): ?>
            	<script src="<?php echo $file; ?>"></script>
            <?php endforeach; ?>
            
            <?php echo $output ?>
            
            <script>
                $(document).ready(function(){
                   $("div#groceryCrudTable_filter").remove();
                });
            </script>
        </div>
        
        <hr>

        <footer>
            <h6>Realizado por Sedita &nbsp;&nbsp; - &nbsp;&nbsp; &copy; Company 2012</h6>
        </footer>
    </body>
    
</html>
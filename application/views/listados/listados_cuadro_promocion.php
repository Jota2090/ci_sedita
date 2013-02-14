<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <title>Sedita Listados</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description" content="" />
    <meta name="Sedita" content="" />
	<base href="<?=site_url()?>" />
    
    <!-- Le styles -->
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
    <script src="js/jquery-1.8.3.min.js"></script>
    <script src="js/jquery-ui.js"></script>
    <script src="js/jquery.validate.js"></script>
        
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
        $(document).ready(function(){
            $("#cmbJornada").change(function(){
                var jornada = $("#cmbJornada").find(":selected").val();
                
                if(jornada == 2){
                    $("#cmbCurso").attr('disabled', 'disabled');
                    $("#cmbEspecializacion").attr('disabled', 'disabled');
                    $("#cmbParalelo").attr('disabled', 'disabled');
                    $("#cmbTrimestre").attr('disabled', 'disabled');
                }
                else{
                    var curso = $("#cmbCurso").find(":selected").val();
                    var especializacion = $("#cmbEspecializacion").find(":selected").val();
                    var paralelo = $("#cmbParalelo").find(":selected").val();
                    
                    $("#cmbCurso").removeAttr('disabled');
                    $("#cmbTrimestre").removeAttr('disabled');
                    
                    if(curso>0){
                        if(curso > 11 && curso < 14){
                            $("#cmbEspecializacion").removeAttr('disabled');
                            
                            if(especializacion>0)
                                $("#cmbParalelo").removeAttr('disabled');
                        }
                        else{
                            $("#cmbEspecializacion").empty();
                            $("#cmbEspecializacion").attr('disabled', 'disabled');
                            $("#cmbParalelo").removeAttr('disabled');
                        }
                    }
                }
            });
        });
        
        
        $(document).ready(function(){
            $("#cmbCurso").change(function(){
               var curso = $("#cmbCurso").find(":selected").val();
               var jornada = $("#cmbJornada").find(":selected").val();
                
                if(curso == 0){
                    $("#cmbEspecializacion").empty();
                    $("#cmbEspecializacion").attr('disabled', 'disabled');
                    $("#cmbParalelo").empty();
                    $("#cmbParalelo").attr('disabled', 'disabled');
                }
                else{
                    if(curso > 11 && curso < 14){
                        var especializacion = $("#cmbEspecializacion").find(":selected").val();
                        
                        $.ajax({
                            type:"post",
                            url: "<?=site_url("alumno/cargar_especializaciones")?>",
                            data:"curso="+curso+"&jornada="+jornada,
                            success:function(info){
                                $("#cmbEspecializacion").removeAttr('disabled');
                                $("#cmbEspecializacion").html(info);
                                $("#cmbParalelo").empty();
                                $("#cmbParalelo").attr('disabled', 'disabled');
                            }
                       });   
                    }
                    else{
                        $.ajax({
                            type:"post",
                            url: "<?=site_url("alumno/cargar_paralelos")?>",
                            data:"jornada="+jornada+"&curso="+curso,
                            success:function(info){
                                $("#cmbEspecializacion").empty();
                                $("#cmbEspecializacion").attr('disabled', 'disabled');
                                $("#cmbParalelo").removeAttr('disabled');
                                $("#cmbParalelo").html(info);
                            }
                       });
                    }   
                }
            });
        });
        
        $(document).ready(function(){
            $("#cmbEspecializacion").change(function(){
                var cur = $("#cmbCurso").find(":selected").val();
                var jor = $("#cmbJornada").find(":selected").val();
                var esp = $("#cmbEspecializacion").find(":selected").val();
                
                if(esp==0 || esp==null){
                    $("#cmbParalelo").empty();
                    $("#cmbParalelo").attr('disabled', 'disabled');
                    $("#cmbMateria").empty();
                    $("#cmbMateria").attr('disabled', 'disabled');
                }
                else{
                    $.ajax({
                        type:"post",
                        url: "<?=site_url("alumno/cargar_paralBachill")?>",
                         data:"jornada="+jor+"&curso="+cur+"&espec="+esp,
                        success:function(info){
                            $("#cmbParalelo").removeAttr('disabled');
                            $("#cmbParalelo").html(info);
                        }
                   });
                }
            });
        });
        
        function imprimir(){
            var curso = $("#cmbCurso").find(":selected").val();
            var especializacion = $("#cmbEspecializacion").find(":selected").val();
            var paralelo = $("#cmbParalelo").find(":selected").val();
            
            if(curso == 0){
                alert("Debe elegir un curso");
            }
            else{
                if((curso >11 && curso < 14) && especializacion==0){
                    alert("Debe elegir una especializacion");
                }
                else{
                    if(paralelo==0){
                        alert("Debe elegir un paralelo");
                    }
                    else{
                        var frm = document.getElementById("forma");
                        frm.indicador.value = 1;
                        document.forma.submit();
                    }       
                }
            }
        }
        
        function ver_promocion(){
            var cur = $("#cmbCurso").find(":selected").val();
            var esp = $("#cmbEspecializacion").find(":selected").val();
            var par = $("#cmbParalelo").find(":selected").val();
            var jor = $("#cmbJornada").find(":selected").val();
            var anl = $("#cmbAnioLectivo").find(":selected").val();  
            
            if(cur == 0){
                alert("Debe elegir un curso");
            }
            else{
                if((cur >11 && cur < 14) && esp==0){
                    alert("Debe elegir una especializacion");
                }
                else{
                    if(par==0){
                        alert("Debe elegir un paralelo");
                    }
                    else{
                        $("#cmbJornada").attr('disabled', 'disabled');
                        $("#cmbCurso").attr('disabled', 'disabled');
                        $("#cmbEspecializacion").attr('disabled', 'disabled');
                        $("#cmbParalelo").attr('disabled', 'disabled');
                        $("#cmbAnioLectivo").attr('disabled', 'disabled');
                        $("#btnImprimir").attr('href', 'javascript:disable');
                        $("#btnImprimir").attr('disabled', 'disabled');
                        $("#btnVer").attr('href', 'javascript:disable');
                        $("#btnVer").attr('disabled', 'disabled');
                        
                        $.ajax({
                            type:"post",
                            url: "<?=site_url("listados/cargar_alumnos")?>",
                            data:"cur="+cur+"&jor="+jor+"&esp="+esp+"&anl="+anl+"&par="+par,
                            success:function(info){
                                $("#alumnos").html(info);
                            }
                        });
                    }          
                }
            }
        }
        
        function cancelar(){
            var curso = $("#cmbCurso").find(":selected").val();
            
            if(curso > 11 && curso <14){
                $("#cmbEspecializacion").removeAttr('disabled');
            }
            
            $("#cmbJornada").removeAttr('disabled');
            $("#cmbCurso").removeAttr('disabled');
            $("#cmbParalelo").removeAttr('disabled');
            $("#cmbAnioLectivo").removeAttr('disabled');
            $("#btnImprimir").attr('href', 'javascript:imprimir()');
            $("#btnImprimir").removeAttr('disabled', 'disabled');
            $("#btnVer").attr('href', 'javascript:ver_promocion()');
            $("#btnVer").removeAttr('disabled', 'disabled');
                    
            $("#alumnos").html(""); 
            $("#promocion").html("");
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
                  <li class="nav-header">Alumnos</li>
                  <li><a href="<?=site_url("listados/nomina_alumnos")?>">N&oacute;minas o Actas</a></li>
                  <br />
                  <li class="nav-header">Libretas</li>
                  <li><a href="<?=site_url("listados/cuadro_honor")?>">Cuadro de Honor</a></li>
                  <li class="active"><a href="<?=site_url("listados/cuadro_promocion")?>">Cuadro de Promoci&oacute;n</a></li>
                </ul>
            </div><!--/.well -->
            <div class="well sidebar-nav" style="float:left;width:200px;margin:30px 0 0 50px">
                <ul class="nav nav-list">
                  <li class="nav-header">Ayuda<i class="icon-question-sign" style="float: right;"></i></li>
                  <li><a>En esta secci&oacute;n podr&aacute; <b>visualizar e imprimir</b> las libretas con el promedio final de la suma de todos los per&iacute;odos escolares de un curso correspondiente.</a></li>
                </ul>
            </div><!--/.well -->
        </div>
        
        <div class="span9">
            <div class="panel">
                <form target="_blank" style="padding-right: 100px;" id="forma" name="forma" class="form-horizontal" action="<?=site_url("listados/generar_promocion")?>" method="post" >
                   <input type="hidden" id="indicador" name="indicador" />
                   <fieldset>
                        <legend>Cuadro de Promoci&oacute;n</legend>
                        <div class="control-group" style="width:390px;float:left;">
                            <label class="control-label"><b>Jornada</b></label>
                            <div class="controls">
                                <?php 
                                    $js = "id='cmbJornada'";
                                    echo form_dropdown("cmbJornada",$jornada, null, $js);
                                ?>
                            </div>
                            
                            <label class="control-label" style="margin-top: 5px;"><b>Curso *</b></label>
                            <div class="controls" style="margin-top: 5px;">
                                <select id="cmbCurso" name="cmbCurso"><?=$curso?></select>
                            </div>
                            
                            <label class="control-label" style="margin-top: 5px;"><b>Especializaci&oacute;n *</b></label>
                            <div class="controls" style="margin-top: 5px;">
                                <select disabled="disabled" id="cmbEspecializacion" name="cmbEspecializacion"></select>
                            </div>
                            
                            <label class="control-label" style="margin-top: 5px;"><b>Paralelo *</b></label>
                            <div class="controls" style="margin-top: 5px;">
                                <select disabled="disabled" id="cmbParalelo" name="cmbParalelo"></select>
                            </div>
                            
                            <label class="control-label" style="margin-top: 10px;"><b>A&ntilde;o Lect&iacute;vo</b></label>
                            <div class="controls" style="margin-top: 10px;">
                                <?php 
                                    $js = "id='cmbAnioLectivo'";
                                    echo form_dropdown("cmbAnioLectivo",$per_lectivos, $anio_lectivo, $js);
                                ?>
                            </div>
                        </div>
                        
                        <div class="control-group" style="width:300px;float:left; margin: 25px 0 0 0;" >
                            <a href="javascript:imprimir()" id="btnImprimir" class="btn btn-primary" style="width: 130px; float:left;margin:35px 0 0 100px" ><i class="icon-print"></i>Imprimir</a>
                            <a href="javascript:ver_promocion()" id="btnVer" class="btn" style="width: 130px;float:left;margin:30px 0 0 100px" ><i class="icon-search"></i>Ver Cuadros</a>
                            
                        </div>
                   </fieldset> 
                </form>
            </div>
            
            <div style="padding-left: 330px;" id="alumnos"></div>
            <div id="promocion" style="padding-left: 50px;"></div>
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
<!DOCTYPE html>
<html>
    <head>
    	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
        <title>Sedita Asignaci&oacute;n Curso y Dirigente</title>
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
            $(document).ready(function(){
                $("#cmbProf").change(function(){
                    var jor= $("#cmbJornada").find(":selected").val();
                    var per= $("#cmbProf").find(":selected").val();
                    var anl= $("#cmbAnioLectivo").find(":selected").val();
                    if(jor==1){
                        $("#cmbJornada").removeAttr('disabled');
                        $("#cmbNivel").removeAttr('disabled');
                        $("#cmbCurso").removeAttr('disabled');
                    }
                    
                    $.ajax({
                        type:"post",
                        url: "<?=site_url("personal/cargar_cur_dir")?>",
                        data:"per="+per+"&anl="+anl,
                        success:function(info){
                            $("#resultadoConsulta").html(info);
                        }
                    });
                })                
            })
            
            $(document).ready(function(){
                $("#cmbAnioLectivo").change(function(){
                    var jor= $("#cmbJornada").find(":selected").val();
                    var per= $("#cmbProf").find(":selected").val();
                    var anl= $("#cmbAnioLectivo").find(":selected").val();
                    
                    if(jor==1){
                        $("#cmbJornada").removeAttr('disabled');
                        $("#cmbNivel").removeAttr('disabled');
                        $("#cmbCurso").removeAttr('disabled');
                    }
                    
                    $.ajax({
                        type:"post",
                        url: "<?=site_url("personal/cargar_cur_dir")?>",
                        data:"per="+per+"&anl="+anl,
                        success:function(info){
                            $("#resultadoConsulta").html(info);
                        }
                    });
                })                
            })
            
            function fmcCmbNivel(){
                var id= $("#cmbNivel").find(":selected").val();
                
                if( id == 1){
                    var curso = -1;
                }else{
                    if(id == 2){
                        var curso = -2;
                        var especializacion = $("#cmbEspecializacion").find(":selected").val();
                    }
                }
                
                var jornada = $("#cmbJornada").find(":selected").val();
                
                $.ajax({
                    type:"post",
                    url: "<?=site_url("alumno/cargar_curso")?>",
                    data:"nivel="+id,
                    success:function(info){
                        $("#cmbCurso").html(info);
                        $("#cmbEspecializacion").empty();
                        $("#cmbEspecializacion").attr('disabled', 'disabled');
                        $("#cmbParalelo").empty();
                        $("#cmbParalelo").attr('disabled', 'disabled');
                        $("#cmbMat").empty();
                        $("#cmbMat").attr('disabled', 'disabled');
                    }
                });
            }
            
            function fmcCmbCurso(){
                var curso = $("#cmbCurso").find(":selected").val();
                var jornada = $("#cmbJornada").find(":selected").val();
                
                if(curso > 11 && curso < 14){
                    $.ajax({
                        type:"post",
                        url: "<?=site_url("alumno/cargar_especializaciones")?>",
                        data:"curso="+curso+"&jornada="+jornada,
                        success:function(info){
                            $("#cmbEspecializacion").removeAttr('disabled');
                            $("#cmbEspecializacion").html(info);
                            $("#cmbParalelo").empty();
                            $("#cmbParalelo").attr('disabled', 'disabled');
                            $("#cmbMat").empty();
                            $("#cmbMat").attr('disabled', 'disabled');
                        }
                   });   
                }
                else{
                    $("#cmbEspecializacion").empty();
                    $("#cmbEspecializacion").attr('disabled', 'disabled');
                    
                    if(curso==-1||curso==-2||curso==0){
                        $("#cmbParalelo").empty();
                        $("#cmbParalelo").attr('disabled', 'disabled');
                        $("#cmbMat").empty();
                        $("#cmbMat").attr('disabled', 'disabled');
                    }
                    else{
                        var esp = $("#cmbEspecializacion").find(":selected").val();
                        
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
                       
                       $.ajax({
                            type:"post",
                            url: "<?=site_url("personal/cargar_materias")?>",
                            data:"cur="+curso+"&esp="+esp,
                            success:function(info){
                                $("#cmbMat").removeAttr('disabled');
                                $("#cmbMat").html(info);
                            }
                       });
                    }
                }
            }                      
                                    
            function fmcCmbJornada(){
                var jornada = $("#cmbJornada").find(":selected").val();
                    
                if(jornada == 2){
                    $("#cmbNivel").attr('disabled','disabled');
                    $("#cmbCurso").attr('disabled','disabled');
                    $("#cmbParalelo").attr('disabled', 'disabled');
                    $("#cmbEspecializacion").attr('disabled','disabled');
                    $("#cmbMat").attr('disabled', 'disabled');
                    $("#btnAgregar").attr('href', 'javascript:disable');
                    $("#btnAgregar").attr('disabled', 'disabled');
                }
                else{
                    var curso = $("#cmbCurso").find(":selected").val();
                    var paralelo = $("#cmbParalelo").find(":selected").val();
                    var especializacion = $("#cmbEspecializacion").find(":selected").val();
                    
                    $("#cmbNivel").removeAttr('disabled');
                    $("#cmbCurso").removeAttr('disabled');
                    $("#btnAgregar").attr('href', 'javascript:agregar()');
                    $("#btnAgregar").removeAttr('disabled');
                    
                    if(curso > 11 && curso < 14){
                        $("#cmbEspecializacion").removeAttr('disabled');
                        if(especializacion>0){
                            $("#cmbParalelo").removeAttr('disabled');
                            $("#cmbMat").removeAttr('disabled');
                        }
                    }
                    else{
                        if(curso==-1||curso==0){
                            $("#cmbParalelo").attr('disabled', 'disabled');
                            $("#cmbParalelo").attr('disabled', 'disabled');
                        }
                        else{
                            $("#cmbParalelo").removeAttr('disabled');
                            $("#cmbMat").removeAttr('disabled');
                        }
                    }
                } 
            }
            
            $(document).ready(function(){
                $("#cmbEspecializacion").change(function(){
                    var idJornada= $("#cmbJornada").find(":selected").val();
                    var idCurso= $("#cmbCurso").find(":selected").val();
                    var idEspec= $("#cmbEspecializacion").find(":selected").val();
                    
                    if(idEspec>0){
                        $.ajax({
                            type:"post",
                            url: "<?=site_url("alumno/cargar_paralBachill")?>",
                             data:"jornada="+idJornada+"&curso="+idCurso+"&espec="+idEspec,
                            success:function(info){
                                $("#cmbParalelo").removeAttr('disabled');
                                $("#cmbParalelo").html(info);
                            }
                       });
                       
                       $.ajax({
                            type:"post",
                            url: "<?=site_url("personal/cargar_materias")?>",
                            data:"cur="+idCurso+"&esp="+idEspec,
                            success:function(info){
                                $("#cmbMat").removeAttr('disabled');
                                $("#cmbMat").html(info);
                            }
                       });
                    }
                    else{
                        $("#cmbParalelo").attr('disabled','disabled');
                        $("#cmbParalelo").empty();
                        $("#cmbMat").attr('disabled','disabled');
                        $("#cmbMat").empty();
                    }
                        
                });
            });
            
            function agregar(){
                var per = $("#cmbProf").find(":selected").val();
                var cur = $("#cmbCurso").find(":selected").val();
                var esp = $("#cmbEspecializacion").find(":selected").val();
                var par = $("#cmbParalelo").find(":selected").val();
                var jor = $("#cmbJornada").find(":selected").val();
                var mat = $("#cmbMat").find(":selected").val();
                var anl = $("#cmbAnioLectivo").find(":selected").val();
                var dir = $("#chkDir:checked").val();
                
                if(cur==""||cur==0||cur==-1||cur==-2){
                    alert("curso");
                }
                else{
                    if(cur>11&&cur<14&&esp==0){
                        alert("espec");
                    }
                    else{
                        if(par==0){
                            alert("paralelo");
                        }
                        else{
                            $.ajax({
                                type:"post",
                                url: "<?=site_url("personal/cd_guardar")?>",
                                data:"cur="+cur+"&esp="+esp+"&par="+par+"&jor="+jor
                                        +"&mat="+mat+"&dir="+dir+"&per="+per+"&anl="+anl,
                                success:function(info){
                                    $("#resultadoConsulta").html(info);
                                }
                           });
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
                      <li><a href="<?=site_url("personal")?>">Registro</a></li>
                      <br />
                      <li class="nav-header">Profesor</li>
                      <li class="active"><a href="<?=site_url("personal/asignacion_cursos")?>">Asignaci&oacute;n de Cursos y Dirigentes</em></a></li>
                      <br />
                    </ul>
                </div><!--/.well -->
                <div class="well sidebar-nav" style="float:left;width:200px;margin:30px 0 0 50px">
                    <ul class="nav nav-list">
                      <li class="nav-header">Ayuda<i class="icon-question-sign" style="float: right;"></i></li>
                      <li><a>En esta secci&oacute;n podr&aacute; <b>asignar los cursos a los que impartir&aacute; la materia y a los que dirige</b> el personal docente en el per&iacute;odo actual.</a></li>
                    </ul>
                </div><!--/.well -->
            </div>
            <div class="span9">
                <div class="panel" style="width: 900px;">
                    <form style="padding-right:50px" class="form-horizontal">
                       <input type="hidden" id="indicador" name="indicador" />
                       <fieldset>
                           <legend>Asignaci&oacute;n de Cursos</legend>
                        </fieldset> 
                    </form>
                          
                    <div class="span8">
                        <label class="control-label" style="margin-left:250px"><b>A&ntilde;o Lectivo</b></label>
                        <div class="controls" style="margin-left:250px">
                            <?php 
                                $js = "id='cmbAnioLectivo' style='width:130px' ";
                                echo form_dropdown("cmbAnioLectivo",$anio_lectivo, $anl, $js);
                            ?>
                        </div>
                        
                        <label class="control-label"><b>Profesores</b></label>
                        <div class="controls">
                            <select id="cmbProf" name="cmbProf" style="width: 400px;" size="10">
                                <?=$profesor?>
                            </select>
                        </div>
                    </div>
                    
                    <div class="span5" style="margin-left: 60px;">
                        <div class="control-group span6">
                            <label class="control-label"><b>Nivel</b></label>
                            <div class="controls">
                                <?php 
                                    $js = " style='width:130px' id='cmbNivel' disabled='disabled' onChange='fmcCmbNivel()'";
                                    echo form_dropdown("cmbNivel",$nivel, null, $js);
                                ?>
                            </div>
                        </div>
                        
                        <div class="control-group span3">
                            <label class="control-label"><b>Jornada</b></label>
                            <div class="controls">
                                <?php 
                                    $js = 'style="width:130px" id="cmbJornada" disabled="disabled" onChange="fmcCmbJornada()"';
                                    echo form_dropdown("cmbJornada",$jornada, null, $js);
                                ?>
                            </div>
                        </div>
                        
                        <div class="control-group span6">
                            <label class="control-label"><b>Curso*</b></label>
                            <div class="controls">
                                <select style="width:165px" disabled="disabled" id="cmbCurso" name="cmbCurso" onChange="fmcCmbCurso()">
                                    <?php echo $curso ?>
                                </select>
                            </div>
                        </div>
                        
                        <div class="control-group span3">
                            <label class="control-label"><b>Especializaci&oacute;n*</b></label>
                            <div class="controls">
                                <select style="width:165px" id="cmbEspecializacion" name="cmbEspecializacion" disabled="disabled"></select>
                            </div>
                        </div>
                        
                        <div class="control-group span12">
                            <label class="control-label"><b>Materia*</b></label>
                            <div class="controls">
                                <select style="width: 300px;" id="cmbMat" name="cmbMat" disabled="disabled"></select>
                            </div>
                        </div>
                        
                        <div class="control-group span3">
                            <label class="control-label"><b>Par.*</b></label>
                            <div class="controls">
                                <select style="width:60px" id="cmbParalelo" name="cmbParalelo" disabled="disabled"></select>
                            </div>
                        </div>   
                        
                        <div class="control-group span4">
                            <label class="checkbox inline" style="margin-top: 5px;">
                            <input style="margin-top: 5px;" type="checkbox" id="chkDir" value="SI" /> <b>Dirigente</b>
                        </div>  
                        
                        <div class="control-group span4">
                            <a id="btnAgregar" style="margin: 20px 0 0 15px;" class="btn btn-primary" style="" href="javascript:agregar()"><i class="icon-plus-sign"></i>Agregar</a>
                        </div> 
                        
                    </div><!--/span-->
                    
                    <div class="span12" id="resultadoConsulta" style="width:850px;margin-top:20px;">
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
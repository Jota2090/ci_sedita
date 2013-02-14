<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <title>Sedita Actualizacion de Datos</title>
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
    
    <script src="js/jquery-1.8.3.min.js"></script>
    
    <script>
        $(document).ready(function(){
            $("#cmbNivel").html("<option>Seleccione un nivel</option>");
            $("#cmbCurso").html("<option>Seleccione un curso</option>");
            $("#cmbEspec").html("<option>Seleccione una especializaci&oacute;n</option>");
            $("#cmbParalelo").html("<option>Seleccione un paralelo</option>")
            $("#cmbCategoria").attr('disabled', 'disabled');
                        
        });
    </script>
    
    
    <script>
        $(document).ready(function(){
            $("#cmbJornada").change(function(){
            $("#cmbNivel").html("<option>Cargando..</option>");
               var idJornada= $("#cmbJornada").find(":selected").val();
               var cmbNivel=document.getElementById("cmbNivel");
               var cmbCurso=document.getElementById("cmbCurso");
               var cmbEspec=document.getElementById("cmbEspec");
               var cmbParal=document.getElementById("cmbParalelo");
               cmbNivel.disabled=false;
               cmbCurso.disabled=true;
               cmbEspec.disabled=true;
               cmbParal.disabled=true;                         
               $.ajax({
                    type:"post",
                    url: "<?=site_url("alumno/cargar_niveles")?>",
                    data:"jornada="+idJornada,
                    success:function(info){
                        
                        $("#cmbNivel").html(info);
                    }
               });
            });
        });
    </script>
    
    
    <script>
        $(document).ready(function(){
            $("#cmbNivel").change(function(){
            $("#cmbCurso").html("<option>Cargando..</option>");
               var idJornada= $("#cmbJornada").find(":selected").val();
               var idNivel= $("#cmbNivel").find(":selected").val();
               var cmbCurso=document.getElementById("cmbCurso");
               var cmbEspec=document.getElementById("cmbEspec");
               var cmbParal=document.getElementById("cmbParalelo");
              
               cmbCurso.disabled=false;
               cmbParal.disabled=true;
               //nivel básico
               if(idNivel==1)
               {
                    cmbEspec.disabled=true;
                    
               }
               $.ajax({
                    type:"post",
                    url: "<?=site_url("alumno/cargar_cursos")?>",
                    data:"jornada="+idJornada+"&nivel="+idNivel,
                    success:function(info){
                        $("#cmbCurso").html(info);
                    }
               });
            });
        });
    </script>
    

    <script>
        $(document).ready(function(){
            $("#cmbCurso").change(function(){
                
                var idJornada= $("#cmbJornada").find(":selected").val();
                var idCurso= $("#cmbCurso").find(":selected").val();
                var cmbParal=document.getElementById("cmbParalelo");
            
          //idCurso==12 o 13, 5to y 6to bachillerato
               if((idCurso==12)||(idCurso==13))
               {
                    cmbEspec.disabled=false;
                    cmbParal.disabled=true;
                    $("#cmbEspec").html("<option>Cargando..</option>");
                    $.ajax({
                        type:"post",
                        url: "<?=site_url("alumno/cargar_especializaciones")?>",
                        data:"jornada="+idJornada+"&curso="+idCurso,
                        success:function(info){
                            $("#cmbEspec").html(info);
                        }
                   });
               }
               else
               {
                    cmbEspec.disabled=true;
                    cmbParal.disabled=false;
                    $("#cmbParalelo").html("<option>Cargando..</option>");
                    $.ajax({
                        type:"post",
                        url: "<?=site_url("alumno/cargar_paralelos")?>",
                        data:"jornada="+idJornada+"&curso="+idCurso,
                        success:function(info){
                            //alert ("cargado");
                            $("#cmbParalelo").html(info);
                        }
                   });
               }
            });
        });
    </script>
    
    
    <script>
        $(document).ready(function(){
            $("#cmbEspec").change(function(){
                $("#cmbParalelo").html("<option>Cargando..</option>");
                 var idJornada= $("#cmbJornada").find(":selected").val();
                 var idCurso= $("#cmbCurso").find(":selected").val();
                 var cmbParal=document.getElementById("cmbParalelo");
                 var idEspec= $("#cmbEspec").find(":selected").val();
   
                cmbParal.disabled=false;
        
               $.ajax({
                    type:"post",
                    url: "<?=site_url("alumno/cargar_paralBachill")?>",
                     data:"jornada="+idJornada+"&curso="+idCurso+"&espec="+idEspec,
                    success:function(info){
                        //alert ("cargado");
                        $("#cmbParalelo").html(info);
                    }
               });
            });
        });
    </script>
    
    
    <script>
        $(document).ready(function(){
            $("#cmbParalelo").change(function(){
                //$("#cmbParalelo").html("<option>Cargando..</option>");
                 var idJornada= $("#cmbJornada").find(":selected").val();
                 var idCurso= $("#cmbCurso").find(":selected").val();
                 //var cmbParal=document.getElementById("cmbParalelo");
                 
                 var idParal= $("#cmbParalelo").find(":selected").val();
                 
                   var idEspec= $("#cmbEspec").find(":selected").val();
                 //idCurso==12 o 13, 5to y 6to bachillerato
               if((idCurso==12)||(idCurso==13))
               {
                 
                   $.ajax({
                        type:"post",
                        url: "<?=site_url("alumno/num_AlumnosBach")?>",
                         data:"jornada="+idJornada+"&curso="+idCurso+"&espec="+idEspec+"&paral="+idParal,
                        success:function(info){
                            //alert ("cargado");
                            document.getElementById('txtNumAlumn').value =info;
                               
                        }
                   });
                   
                   $.ajax({
                        type:"post",
                        url: "<?=site_url("alumno/consulta_alumnos")?>",
                        data:"jornada="+idJornada+"&curso="+idCurso+"&espec="+idEspec+"&paral="+idParal+"&indBachill=1",
                        success:function(info){
                            $("#consultaAlumnos").html(info);
                        }
                  });            
                }
                else
                {   
                     $.ajax({
                        type:"post",
                        url: "<?=site_url("alumno/num_Alumnos")?>",
                         data:"jornada="+idJornada+"&curso="+idCurso+"&paral="+idParal,
                        success:function(info){
                            //alert ("cargado");
                            document.getElementById('txtNumAlumn').value =info;
                            
                        }
                    });
                    
                    
                      $.ajax({
                        type:"post",
                        url: "<?=site_url("alumno/consulta_alumnos")?>",
                         data:"jornada="+idJornada+"&curso="+idCurso+"&paral="+idParal+"&indBachill=0",
                         success:function(info){
                            $("#consultaAlumnos").html(info);
                        }
                    }); 
                }
            });
        });
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
            <div class="well sidebar-nav">
                <ul class="nav nav-list">
                  <li class="nav-header">Alumnos</li>
                  <li class="active"><a href="<?=site_url("alumno/consultar_alumnos")?>">Consulta de Alumnos</a></li>
                  <br />
                  <li class="nav-header">Personal del Plantel</li>
                  <li><a href="<?=site_url("listados/cuadro_honor")?>">Consulta del Personal</a></li>
                </ul>
            </div><!--/.well -->
        </div><!--/span-->
        
        <div class="span9">
            <div class="panel">
                    <b>Jornada </b>
                <?php  
                    $js = "id='cmbJornada'";
                    echo form_dropdown("cmbJornada",$jornada, null, $js);
                ?> 
            <br /><br />
            
            <b>Nivel </b>
                <select id="cmbNivel" name="cmbNivel" disabled="disabled" ></select> <br />
            <br /><br />
            
            <b>Curso </b>
                <select id="cmbCurso" name="cmbCurso" disabled="disabled" ></select> <br /> 
            <br /><br />
            
             <b>Especialización </b>
                <select id="cmbEspec" name="cmbEspec" disabled="disabled" ></select> <br /> 
            <br /><br />
            
            <b>Paralelo </b>
                <select id="cmbParalelo" name="cmbParalelo" disabled="disabled" ></select> <br /> 
            <br /><br />
            <br /><br />
            <b>N&uacute;mero de alumnos</b>
                <input type="text" name="txtNumAlumn" id="txtNumAlumn" disabled="disabled"/> <br />
                
            <b>Año Lectivo</b>
                <input type="text" name="txtAnoLectivo" id="txtAnoLectivo" disabled="disabled"/> <br />
                  
        
                <div id="consultaAlumnos"></div>
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
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <title>Sedita Personal</title>
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

    <script src="js/jquery-1.8.3.min.js"></script>
    
    <script>
        $(document).ready(function(){
            $("#cmbAnoLectivo").attr('disabled', 'disabled');
        });
        
        function funcCmbJornada(){
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
         };
         
        function funcCmbNivel(){
            
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
                    url: "<?=site_url("controlador_General/cargar_cursos")?>",
                    data:"jornada="+idJornada+"&nivel="+idNivel+"&edit=0",
                    success:function(info){
                        $("#cmbCurso").html(info);
                    }
               });
            
        };
        
        function funcCmbCurso(){
            
                var idJornada= $("#cmbJornada").find(":selected").val();
                var idCurso= $("#cmbCurso").find(":selected").val();
                var cmbParal=document.getElementById("cmbParalelo");
                var cmbEspec=document.getElementById("cmbEspec");
            
          //idCurso==12 o 13, 5to y 6to bachillerato
               if((idCurso==12)||(idCurso==13))
               {
                    cmbEspec.disabled=false;
                    cmbParal.disabled=true;
                    $("#cmbEspec").html("<option>Cargando..</option>");
                    $.ajax({
                        type:"post",
                        url: "<?=site_url("controlador_General/cargar_especializaciones")?>",
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
                        url: "<?=site_url("controlador_General/cargar_paralelos")?>",
                        data:"jornada="+idJornada+"&curso="+idCurso,
                        success:function(info){
                            //alert ("cargado");
                            $("#cmbParalelo").html(info);
                        }
                   });
               }
       };
       
       function funcCmbEspec(){
            
            $("#cmbParalelo").html("<option>Cargando..</option>");
             var idJornada= $("#cmbJornada").find(":selected").val();
             var idCurso= $("#cmbCurso").find(":selected").val();
             var cmbParal=document.getElementById("cmbParalelo");
             var idEspec= $("#cmbEspec").find(":selected").val();

            cmbParal.disabled=false;
    
           $.ajax({
                type:"post",
                url: "<?=site_url("controlador_General/cargar_paralBachill")?>",
                 data:"jornada="+idJornada+"&curso="+idCurso+"&espec="+idEspec,
                success:function(info){
                    //alert ("cargado");
                    $("#cmbParalelo").html(info);
                }
           });
        };
        
        function funcCmbParalelo(){
           
            //$("#cmbParalelo").html("<option>Cargando..</option>");
             var idJornada= $("#cmbJornada").find(":selected").val();
             var idCurso= $("#cmbCurso").find(":selected").val();
             //var cmbParal=document.getElementById("cmbParalelo");
             
             var idParal= $("#cmbParalelo").find(":selected").val();
             
             var idEspec= $("#cmbEspec").find(":selected").val();
             
             var cmbPeriodoLectivo=document.getElementById("cmbAnoLectivo");
             cmbPeriodoLectivo.disabled=false;
               
             var periodoLectivo= $("#cmbAnoLectivo").find(":selected").val();
             var strAnioLect=periodoLectivo.split("-");
             
               $("#resultadosConsulta").innerHTML="";
               
             //idCurso==12 o 13, 5to y 6to bachillerato
           if((idCurso==12)||(idCurso==13))
           {
             
               $.ajax({
                    type:"post",
                    url: "<?=site_url("alumno/num_Alumnos")?>",
                     data:"jornada="+idJornada+"&curso="+idCurso+"&espec="+idEspec+"&paral="+idParal+"&strAnioLect="+strAnioLect[0],
                    success:function(info){
                        //alert ("cargado");
                        document.getElementById('txtNumAlumn').value =info;          
                    }
               });

               
            }
            
            else
            {   
                 $.ajax({
                    type:"post",
                    url: "<?=site_url("alumno/num_Alumnos")?>",
                     data:"jornada="+idJornada+"&curso="+idCurso+"&espec=-1"+"&paral="+idParal+"&strAnioLect="+strAnioLect[0],
                    success:function(info){
                        //alert ("cargado");
                        document.getElementById('txtNumAlumn').value =info;
                        
                    }
                });
                

            }   
        }

        function funcCmbAnoLectivo(){
        
            //$("#cmbParalelo").html("<option>Cargando..</option>");
             var idJornada= $("#cmbJornada").find(":selected").val();
             var idCurso= $("#cmbCurso").find(":selected").val();
             //var cmbParal=document.getElementById("cmbParalelo");
             
             var idParal= $("#cmbParalelo").find(":selected").val();
             
             var idEspec= $("#cmbEspec").find(":selected").val();
               
             var periodoLectivo= $("#cmbAnoLectivo").find(":selected").val();
             var strAnioLect=periodoLectivo.split("-");
               
              
               
             //idCurso==12 o 13, 5to y 6to bachillerato
           if((idCurso==12)||(idCurso==13))
           {
             
               $.ajax({
                    type:"post",
                    url: "<?=site_url("alumno/num_Alumnos")?>",
                     data:"jornada="+idJornada+"&curso="+idCurso+"&espec="+idEspec+"&paral="+idParal+"&strAnioLect="+strAnioLect[0],
                    success:function(info){
                        //alert ("cargado");
                        document.getElementById('txtNumAlumn').value =info;          
                    }
               });
              
            }
            
            else
            {   
                 $.ajax({
                    type:"post",
                    url: "<?=site_url("alumno/num_Alumnos")?>",
                     data:"jornada="+idJornada+"&curso="+idCurso+"&espec=-1"+"&paral="+idParal+"&strAnioLect="+strAnioLect[0],
                    success:function(info){
                        //alert ("cargado");
                        document.getElementById('txtNumAlumn').value =info;
                        
                    }
                });
                
            }
        }
        
        
        function consultar()
        {
            //$("#cmbParalelo").html("<option>Cargando..</option>");
             var idJornada= $("#cmbJornada").find(":selected").val();
             var idCurso= $("#cmbCurso").find(":selected").val();
             //var cmbParal=document.getElementById("cmbParalelo");
             
             var idParal= $("#cmbParalelo").find(":selected").val();
             
             var idEspec= $("#cmbEspec").find(":selected").val();
               
             var periodoLectivo= $("#cmbAnoLectivo").find(":selected").val();
             var strAnioLect=periodoLectivo.split("-");
             
             if((idCurso==12)||(idCurso==13))
            {
                $.ajax({
                    type:"post",
                    url: "<?=site_url("alumno/consultar")?>",
                    data:"jornada="+idJornada+"&curso="+idCurso+"&espec="+idEspec+"&paral="+idParal+"&strAnioLect="+strAnioLect[0]+"&indBachill=1"+"&indInicio=1",
                    success:function(info){
                        $("#resultadosConsulta").innerHTML="";
                        $("#resultadosConsulta").html(info);
                    }
                });
                
            }
            else
            {
                
                $.ajax({
                    type:"post",
                    url: "<?=site_url("alumno/consultar")?>",
                     data:"jornada="+idJornada+"&curso="+idCurso+"&espec=-1"+"&paral="+idParal+"&strAnioLect="+strAnioLect[0]+"&indBachill=0"+"&indInicio=1",
                     success:function(info){
                        $("#resultadosConsulta").innerHTML="";
                        $("#resultadosConsulta").html(info);
                    }
                });
                
                
            }
             
      
            
            
        }
        
    	$(document).ready(function(){
    	   
           var divRepresM = document.getElementById("rbRepresentM");
           var divRepresP = document.getElementById("rbRepresentP");
           var divRepresO = document.getElementById("rbRepresentO");
           
           if((divRepresM != null) && (divRepresP != null) && (divRepresO != null) ) 
           {
                if((divRepresM.checked== true)||(divRepresP.checked== true))
                {
                    document.getElementById("alu_representante_id_field_box").style.display = "none";
                    
                }       
                else
                {
                    document.getElementById("alu_representante_id_field_box").style.display = "block";
                }
           }
        });
        
        function toggle_otra_persona(elemento) {
            if((elemento.value=="m") || (elemento.value=="p")) {
                document.getElementById("alu_representante_id_field_box").style.display = "none";
               
            } 
            else {
                document.getElementById("alu_representante_id_field_box").style.display = "block";
            }
        };
        
        //Combos para editar jornada, curso, especializacion,paralelo y año lectivo
        function funcCmbJornadaEdit(){
            $("#cmbCursoEdit").html("<option>Cargando..</option>");
               var idJornadaEdit= $("#cmbJornadaEdit").find(":selected").val();
               var cmbCursoEdit=document.getElementById("cmbCursoEdit");
               var cmbEspecEdit=document.getElementById("cmbEspecEdit");
               var cmbParalEdit=document.getElementById("cmbParalEdit");
           
              
               cmbCursoEdit.disabled=false;
               cmbParalEdit.disabled=true;
               cmbEspecEdit.disabled=true;
               $("#cmbCursoEdit").empty();
               $("#cmbEspecEdit").empty();
               $("#cmbParalEdit").empty();
              
               $.ajax({
                    type:"post",
                    url: "<?=site_url("controlador_General//cargar_cursos")?>",
                    data:"jornada="+idJornadaEdit+"&nivel=0&edit=1",
                    success:function(info){
                        //alert ("cargado"+idJornadaEdit+info);
                        $("#cmbCursoEdit").html(info);
                        
                    }
               });
        };
        
        function funcCmbCursoEdit(){
                var idJornadaEdit= $("#cmbJornadaEdit").find(":selected").val();
                var idCursoEdit= $("#cmbCursoEdit").find(":selected").val();
                var cmbParalEdit=document.getElementById("cmbParalEdit");
                var cmbEspecEdit=document.getElementById("cmbEspecEdit");
            
          //idCurso==12 o 13, 5to y 6to bachillerato
               if((idCursoEdit==12)||(idCursoEdit==13))
               {
                    cmbEspecEdit.disabled=false;
                    cmbParalEdit.disabled=true;
                    $("#cmbParalEdit").empty();
                    $("#cmbEspecEdit").html("<option>Cargando..</option>");
                    $.ajax({
                        type:"post",
                        url: "<?=site_url("controlador_General/cargar_especializaciones")?>",
                        data:"jornada="+idJornadaEdit+"&curso="+idCursoEdit,
                        success:function(info){
                            $("#cmbEspecEdit").html(info);
                        }
                   });
               }
               else
               {
                    cmbEspecEdit.disabled=true;
                    cmbParalEdit.disabled=false;
                    $("#cmbEspecEdit").empty();
                    $("#cmbParalEdit").html("<option>Cargando..</option>");
                    $.ajax({
                        type:"post",
                        url: "<?=site_url("controlador_General/cargar_paralelos")?>",
                        data:"jornada="+idJornadaEdit+"&curso="+idCursoEdit,
                        success:function(info){
                            //alert ("cargado");
                            $("#cmbParalEdit").html(info);
                        }
                   });
               }
        };
    
        function funcCmbEspecEdit(){
            
                $("#cmbParalEdit").html("<option>Cargando..</option>");
                 var idJornadaEdit= $("#cmbJornadaEdit").find(":selected").val();
                 var idCursoEdit= $("#cmbCursoEdit").find(":selected").val();
                 var cmbParalEdit=document.getElementById("cmbParalEdit");
                 var idEspecEdit= $("#cmbEspecEdit").find(":selected").val();
   
                cmbParalEdit.disabled=false;
        
               $.ajax({
                    type:"post",
                    url: "<?=site_url("controlador_General/cargar_paralBachill")?>",
                     data:"jornada="+idJornadaEdit+"&curso="+idCursoEdit+"&espec="+idEspecEdit,
                    success:function(info){
                        //alert ("cargado");
                        $("#cmbParalEdit").html(info);
                    }
               });
        };
        
        //Fin Combos para editar jornada, curso, especializacion,paralelo y año lectivo
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
    <div class="modal alert" id="warning" style="display: none;">
        <div class="modal-header">
            <a class="close" data-dismiss="modal">x</a>
            <h3><img src="images/alerta-warning.jpg" style="margin-right: 10px;" width="30px" height="30px"/>Atenci&oacute;n!</h3>
        </div>
        <div class="modal-body">
            <p>Debe llenar al menos un campo!</p>
        </div>
    </div>
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
                  <li class="active"><a href="<?=site_url("alumno/consultar")?>">Alumnos</a></li>
                  <li><a href="<?=site_url("personal/consultar")?>">Personal Docente</a></li>
                  <li><a href="<?=site_url("banda_guerra/consultar_instrumentos")?>">Banda de Guerra</a></li>
                  <li><a href="<?=site_url("equipo_laboratorio/consultar_equipos")?>">Equipos de Laboratorio</a></li>
                  <li><a href="<?=site_url("uniforme/consultar_uniformes")?>">Uniformes</a></li>
                </ul>
            </div><!--/.well -->
            <div class="well sidebar-nav" style="float:left;width:200px;margin:30px 0 0 50px">
                <ul class="nav nav-list">
                  <li class="nav-header">Ayuda<i class="icon-question-sign" style="float: right;"></i></li>
                  <li><a>En esta secci&oacute;n podr&aacute; <b>consultar y modificar </b> informaci&oacute;n de un alumno y de su respectivo representante.</a></li>
                </ul>
            </div><!--/.well -->
        </div>
        <div class="span9">
            <div class="panel" style="padding-bottom: 0px;">
                <form target="_blank" style="padding-right: 100px;" id="forma" name="forma" class="form-horizontal" action="<?=site_url("listados/exportar")?>" method="post" >
                   <input type="hidden" id="indicador" name="indicador" />
                   <fieldset>
                       <legend>Alumnos</legend>
                        <div class="control-group span5" style="margin:5px 0px 0 0; float:left;">
                            <div class="control-group">
                                <label class="control-label"><b>Jornada</b></label>
                                <div class="controls">
                                    <?php  
                                        $js = 'id="cmbJornada"  onChange="funcCmbJornada();"';
                                        echo form_dropdown("cmbJornada",$jornada, null, $js);
                                    ?> 
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label"><b>Nivel</b></label>
                                <div class="controls">
                                    <select id="cmbNivel" name="cmbNivel" disabled="disabled"  onchange="funcCmbNivel()"></select> <br />
                                </div>
                            </div>
                            
                            <div class="control-group">
                                <label class="control-label"><b>A&ntilde;o Lectivo</b></label>
                                <div class="controls">
                                        <?php  
                                        
                                        $mesActual = date("m");
                                        if($mesActual<3)
                                        {
                                           
                                            $aniosgt=date("Y");
                                            $anioActual= $aniosgt-1;
                                        }
                                        else
                                        {
                                            $anioActual= date("Y");
                                            $aniosgt=$anioActual+1;
                                        }
                                            
                                        $js = 'id="cmbAnoLectivo"  onChange="funcCmbAnoLectivo();"';
                                        echo form_dropdown("cmbAnoLectivo",$anio_lectivo, $anioActual, $js);
                                    ?> 
                                    
                                </div>
                            </div>
                            
                                <div class="control-group">
                                    <label class="control-label"><b>N&uacute;mero de alumnos</b></label>
                                    <div class="controls">
                                        <input type="text" name="txtNumAlumn" id="txtNumAlumn" disabled="disabled" style="width: 60px;height: 34px;" /> <br />
                                    </div>
                                </div>

                          </div>
                          
                          <div class="control-group span4" style="margin:5px 110px 0 0; float:right;">
                                <div class="control-group" >
                                    <label class="control-label"><b>Curso</b></label>
                                    <div class="controls">
                                        <select id="cmbCurso" name="cmbCurso" disabled="disabled" onchange="funcCmbCurso()"></select> <br /> 
                                    </div>
                                    
                                </div>
                                
                                <div class="control-group">
                                    <label class="control-label"><b>Especializaci&oacute;n</b></label>
                                    <div class="controls">
                                        <select id="cmbEspec" name="cmbEspec" disabled="disabled" onchange="funcCmbEspec()"></select> <br />   
                                    </div>
                                
                                </div>
                                
                                <div class="control-group">
                                    <label class="control-label"><b>Paralelo</b></label>
                                    <div class="controls">
                                        <select id="cmbParalelo" name="cmbParalelo" disabled="disabled" onchange="funcCmbParalelo()"></select> <br />
                                    </div>
                                </div>
                          
                          </div>
                            
                            
                        
                        <div class="control-group span4">
                            <br />
                            <a href="javascript:consultar()" id="btnConsultar" class="btn btn-primary" style="width:120px;margin:20px 0 0 100px;" ><i class="icon-search"></i>Buscar</a>
                       </div>
                   </fieldset> 
                </form>
            </div>
            <div id="resultadosConsulta" class="span9" style="width: 1000px; margin: 0 auto;">          
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
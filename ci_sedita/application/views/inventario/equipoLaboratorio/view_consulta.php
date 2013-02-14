<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <title>Sedita Equipos de Laboratorio</title>
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
            function funcCmbBusquedaCateg(){
                   var valueCategoria= $("#cmbBusquedaCateg").find(":selected").val();
                   var cmbOpciones=document.getElementById("cmbOpciones");
                   var txtCodInv=document.getElementById("txtCodInv");
                   
                   if(valueCategoria=="Todos") 
                   {
                        cmbOpciones.disabled=true;
                        txtCodInv.value="";
                        txtCodInv.disabled=true;
                        $("#cmbOpciones").empty();
                   }
                   
                   
                   else if ((valueCategoria=="Tipo")||(valueCategoria=="Estado"))
                   {
                        cmbOpciones.disabled=false;
                        txtCodInv.value="";
                        txtCodInv.disabled=true;
                        $.ajax({
                        type:"post",
                        url: "<?=site_url("activos/cargar_opcionesCombos")?>",
                        data:"valueCategoria="+valueCategoria+"&tipo_id_objeto=1",
                        success:function(info){
                            $("#cmbOpciones").html(info);
                            }
                        });
                   }
                   
                   else if (valueCategoria=="Codigo")
                   {
                        cmbOpciones.disabled=true;
                        txtCodInv.disabled=false;
                   }
                   

               }   
               
               
               function funcCmbOpciones(){
                
                var valueCategoria= $("#cmbBusquedaCateg").find(":selected").val();
                var strCod=$("#txtCodInv").val()
                
                
                //alert(idOpcion);     
                        
                        if(valueCategoria=="Codigo") 
                        {
                            var idOpcion=0;
                        }
                        else
                        {
                            var idOpcion= $("#cmbOpciones").find(":selected").val();
                        
                        }
                        
                        $.ajax({
                                        type:'post',
                                        url: '<?=site_url("equipo_laboratorio/consultar_equipos")?>',
                                        data:'categoria='+valueCategoria+'&idOpcion='+idOpcion+'&strCod='+strCod+'&indInicio=1',
                                        success:function(info){
                                            $("#resultadosConsulta").innerHTML="";                                            
                                            $('#resultadosConsulta').html(info);
                                            
                                            }
                               });	
                
                }
        
        </script>
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
                  <li><a href="<?=site_url("alumno/consultar")?>">Alumnos</a></li>
                  <li><a href="<?=site_url("personal/consultar")?>">Personal Docente</a></li>
                  <li><a href="<?=site_url("banda_guerra/consultar_instrumentos")?>">Banda de Guerra</a></li>
                  <li class="active"><a href="<?=site_url("equipo_laboratorio/consultar_equipos")?>">Equipos de Laboratorio</a></li>
                  <li><a href="<?=site_url("uniforme/consultar_uniformes")?>">Uniformes</a></li>
                </ul>
            </div><!--/.well -->
            <div class="well sidebar-nav" style="width: 240px;">
                <ul class="nav nav-list">
                  <li class="nav-header">Ayuda<i class="icon-question-sign" style="float: right;"></i></li>
                  <li><a>En esta secci&oacute;n podr&aacute; <b>consultar y editar los equipos del laboratorio</b> que pertenecen a la instituci&oacute;n.</a></li>
                </ul>
            </div><!--/.well -->
        </div>
        <div class="span9">
            <div class="panel" style="padding-bottom: 0px;">
                <form target="_blank" style="padding-right: 100px;" id="forma" name="forma" class="form-horizontal" action="<?=site_url("listados/exportar")?>" method="post" >
                   <input type="hidden" id="indicador" name="indicador" />
                   <fieldset>
                        <legend>Equipos de Laboratorio</legend>
                        <div class="control-group span5">
                            
                            <label class="control-label"><b>Buscar por:</b></label>
                            <div class="controls">
                                 <?php  
                                    $js = 'id="cmbBusquedaCateg" onChange="funcCmbBusquedaCateg()"';
                                    echo form_dropdown("cmbBusquedaCateg",$options, null, $js);
                                ?> 
                            </div>
                            
                            
                            <label class="control-label" style="margin-top: 10px;"><b>Opciones</b></label>
                            <div class="controls" style="margin-top: 10px;">
                                <select id="cmbOpciones" name="cmbOpciones" disabled="disabled">
                                </select>               
                            </div>
                            
                            <label class="control-label" style="margin-top: 10px;"><b>C&oacute;digo</b></label>
                            <div class="controls" style="margin-top: 10px;" >
                                <input type="text" id="txtCodInv" name="txtCodInv" disabled="disabled" />
                            </div>
                                    
                        </div>
                        <div class="control-group span4">
                            <a href="javascript:funcCmbOpciones()" id="btnConsultar" class="btn btn-primary" style="width:120px;margin:20px 0 0 100px;" ><i class="icon-search"></i>Buscar</a>
                        </div>
                   </fieldset> 
                </form>
            </div>
            <div id="resultadosConsulta" style="width: 1000px; margin: 0 auto;">
              
                 <?php foreach($css_files as $file): ?>
                	<link type="text/css" rel="stylesheet" href="<?php echo $file; ?>" />
                    <base href="<?=site_url()?>" />
                <?php endforeach; ?>
                
                <?php foreach($js_files as $file): ?>
                	<script src="<?php echo $file; ?>"></script>
                <?php endforeach; ?>
                
                <div style="padding-top: 5px;">
                                <?php echo $output ?>
                </div>
                
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
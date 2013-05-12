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
        function buscar(){
            var matricula = $("#txtMatricula").val();
            var nombres = $("#txtNombres").val();
            var apellidos = $("#txtApellidos").val();
            var anl = $("#cmbAnioLec").find(":selected").val();
            
            $.ajax({
                type:"post",
                url: "<?=site_url("listados/buscar_alumnos/alumno")?>",
                data:"matricula="+matricula+"&nombres="+nombres+"&apellidos="+apellidos+"&anl="+anl,
                success:function(info){
                    $("#alumnos").html(info);
                }
            });
        };
    </script>
        
        
    <style type="text/css">
        body {
            width: 1320px;
            padding-top: 10px;
            padding-bottom: 10px;
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
            <div class="panel" style="padding-bottom: 0px; padding-top: 20px; margin-bottom: 0px;">
                <form target="_blank" style="padding-right: 100px;" id="forma" name="forma" class="form-horizontal" action="<?=site_url("listados/exportar")?>" method="post" >
                   <input type="hidden" id="indicador" name="indicador" />
                   <fieldset>
                       <legend>Alumnos</legend>
                       <!--<div class="control-group span5" style="margin:5px 0px 0 0; float:left;">-->
                        <div class="control-group" style="width:350px;float:left;">
                            <label id="lbMatricula" class="control-label"><b>Matr&iacute;cula</b></label>
                            <div class="controls">
                                <input maxlength="9" style="width:90px;" type="text" name="txtMatricula" id="txtMatricula"  onkeypress="return validarSoloNumeros(event)" >
                            </div>
                        </div>

                        <div class="control-group" style="width:300px;float:left;" >
                            <label class="control-label"  ><b>A&ntilde;o Lect&iacute;vo</b></label>
                            <div class="controls">
                                <?php 
                                    $js = 'id="cmbAnioLec" style="width:130px"';
                                    echo form_dropdown("cmbAnioLec",$anioLect, $anlId, $js);
                                ?>
                            </div>
                        </div>

                        <div class="control-group" style="width:800px; clear: both">
                             <label id="lbMatricula" class="control-label" style="margin-top: 5px;"><b>Alumno</b></label>
                             <div class="controls" style="margin-top: 5px;">
                                 <input style="float:left; width:220px;" placeholder="Nombres" type="text" name="txtNombres" id="txtNombres"  onkeypress="return validarSoloLetras(event)" >
                                 <input style="float:left; margin-left: 10px; width:220px;" placeholder="Apellidos" type="text" name="txtApellidos" id="txtApellidos"  onkeypress="return validarSoloLetras(event)" >
                             </div>
                         </div>

                        <div class="control-group" style="width:650px; clear: both">
                            <a style="float:right; width: 125px;" href="javascript:buscar()" id="btnBuscar" class="btn btn-primary" ><i class="icon-search"></i>Buscar</a>
                        </div>
                         
                   </fieldset> 
                </form>
            </div>
            <div id="alumnos" class="span9" style="width: 950px; margin: 0 auto;"></div>
        </div><!--/span-->
        <div class="span2"></div>
      </div><!--/row-->
    </div><!--/.fluid-container-->
  </body>
</html>
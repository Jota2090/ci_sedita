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
        <script src="js/misfunciones.js"></script> 
        
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
        
        <script>
            function guardar(){
                var cont=0;
                cont=require_personal();
                
                if(cont>0){ alert("LLene los campos requeridos"); return}
                else{ document.forma.submit();}
            };
        </script>
    </head>

    <body data-spy="scroll" data-target=".bs-docs-sidebar">
        <div class="container-fluid">
          <div class="row-fluid">
            <div class="span3">
                <div class="well sidebar-nav" style="width:300px;">
                <ul class="nav nav-list">
                  <li><a href="<?=site_url("alumno/consultar")?>">Alumnos</a></li>
                  <li class="active"><a href="<?=site_url("personal/consultar")?>">Personal Docente</a></li>
                  <!--<li><a href="<?=site_url("banda_guerra/consultar_instrumentos")?>">Banda de Guerra</a></li>
                  <li><a href="<?=site_url("equipo_laboratorio/consultar_equipos")?>">Equipos de Laboratorio</a></li>
                  <li><a href="<?=site_url("uniforme/consultar_uniformes")?>">Uniformes</a></li>-->
                </ul>
            </div><!--/.well -->
            <div class="well sidebar-nav" style="float:left;width:200px;margin:30px 0 0 50px">
                <ul class="nav nav-list">
                  <li class="nav-header">Ayuda<i class="icon-question-sign" style="float: right;"></i></li>
                  <li><a>En esta secci&oacute;n podr&aacute; <b>consultar, modificar o eliminar</b> informaci&oacute;n del personal docente.</a></li>
                </ul>
            </div><!--/.well -->
            </div>
            <div class="span9">
                <div class="panel" style="width: 800px;">
                    <form style="padding-right: 100px;" id="forma" name="forma" class="form-horizontal" action="<?=site_url("personal/guardar")?>" method="post" >
                       <input type="hidden" id="idPer" name="idPer" value="<?echo $query->per_id?>" />
                       <fieldset>
                           <legend>Actualizaci&oacute;n de Datos del Personal</legend>
                            <div class="span9">
                                <div class="span7">
                                    <label class="control-label"><b>Cargo</b></label>
                                    <div class="controls">
                                        <select id="cmbCargo" name="cmbCargo" style="width: 130px;">
                                            <?echo $cargos;?>
                                        </select>
                                    </div>
                                </div>
                                
                                <div class="span2">
                                    <label class="control-label"><b>A&ntilde;o Lectivo</b></label>
                                    <div class="controls">
                                        <?php 
                                            $js = "id='cmbAnioLectivo' style='width:130px' ";
                                            echo form_dropdown("cmbAnioLectivo",$anioLect, $query->per_anio_lectivo_id, $js);
                                        ?>
                                    </div>
                                </div>
                                
                                <div class="span9" style="margin-top: 10px;">
                                    <label id="lbNombres" class="control-label"><b>Nombres*</b></label>
                                    <div class="controls">
                                        <input style="width:375px;" onkeyup="changeCSSRequire('Nombres','375px','160px')" onkeypress="return validarSoloLetras(event)" type="text" name="txtNombres" id="txtNombres" value="<?echo $query->per_nombres;?>" />
                                    </div>
                                </div>
                                
                                <div class="span9" style="margin-top: 10px;">
                                    <label id="lbApellidos" class="control-label"><b>Apellidos*</b></label>
                                    <div class="controls">
                                        <input style="width:375px;" onkeyup="changeCSSRequire('Apellidos','375px','160px')" onkeypress="return validarSoloLetras(event)" type="text" name="txtApellidos" id="txtApellidos" value="<?echo $query->per_apellidos;?>" />
                                    </div>
                                </div>
                                
                                <div class="span9" style="margin-top: 10px;">
                                    <label id="lbDomicilio" class="control-label"><b>Domicilio*</b></label>
                                    <div class="controls">
                                        <input style="width: 375px;" onkeyup="changeCSSRequire('Domicilio','375px','160px')" type="text" name="txtDomicilio" id="txtDomicilio" value="<?echo $query->per_domicilio;?>" />
                                    </div>
                                </div>
                                
                                <div class="span9" style="width:800px;margin-top: 10px;">
                                    <label id="lbTelefono" class="control-label"><b>Tel&eacute;fono*</b></label>
                                    <div class="controls">
                                        <div style="float:left;"><input style="width: 120px;" onkeyup="changeCSSRequire('Telefono','120px','160px')" maxlength="10" onkeypress="return validarSoloNumeros(event)" type="text" name="txtTelefono" id="txtTelefono" value="<?echo $query->per_telefono;?>" /></div>
                                        <input style="margin-left: 30px;width: 120px;float:left;" maxlength="10" onkeypress="return validarSoloNumeros(event)" type="text" name="txtCell" id="txtCell" value="<?echo $query->per_celular;?>" />
                                    </div>
                                </div>
                                
                                <div class="span9" style="margin-top: 10px;">
                                    <label id="lbCedula" class="control-label"><b>C&eacute;dula*</b></label>
                                    <div class="controls">
                                        <input style="width: 120px;" onkeyup="changeCSSRequire('Cedula','120px','160px')" maxlength="10" onkeypress="return validarSoloNumeros(event)" type="text" name="txtCedula" id="txtCedula" value="<?echo $query->per_cedula;?>" />
                                    </div>
                                </div>
                                <div class="span9">
                                    <label class="control-label" style="margin-top: 10px;"><b>Comentarios</b></label><br /><br />
                                    <textarea style="width: 375px; height: 100px; margin-left: 180px;" name="txtComentarios" id="txtComentarios" ><?echo $query->per_comentarios;?>" </textarea>
                                 </div>
                            </div>
                            <div class="span9" style="margin:30px 0 20px 250px;">
                                <a class="btn btn-primary" style="margin-left:80px;" href="javascript:guardar()">Guardar</a>
                            </div>
                        </fieldset> 
                    </form>
                </div>
            </div><!--/span-->
            <div class="span2"></div>
          </div><!--/row-->
        </div><!--/.fluid-container-->
        
    </body>
</html>
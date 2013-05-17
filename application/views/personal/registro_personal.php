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
                      <li class="nav-header">Personal</li>
                      <li class="active"><a href="<?=site_url("personal/registro")?>">Registro</a></li>
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
                                            echo form_dropdown("cmbAnioLectivo",$anioLect, $anlId, $js);
                                        ?>
                                    </div>
                                </div>
                                
                                <div class="span9" style="margin-top: 10px;">
                                    <label id="lbNombres" class="control-label"><b>Nombres*</b></label>
                                    <div class="controls">
                                        <input style="width:375px;" onkeyup="changeCSSRequire('Nombres','375px','160px')" onkeypress="return validarSoloLetras(event)" type="text" name="txtNombres" id="txtNombres" />
                                    </div>
                                </div>
                                
                                <div class="span9" style="margin-top: 10px;">
                                    <label id="lbApellidos" class="control-label"><b>Apellidos*</b></label>
                                    <div class="controls">
                                        <input style="width:375px;" onkeyup="changeCSSRequire('Apellidos','375px','160px')" onkeypress="return validarSoloLetras(event)" type="text" name="txtApellidos" id="txtApellidos" />
                                    </div>
                                </div>
                                
                                <div class="span9" style="margin-top: 10px;">
                                    <label id="lbDomicilio" class="control-label"><b>Domicilio*</b></label>
                                    <div class="controls">
                                        <input style="width: 375px;" onkeyup="changeCSSRequire('Domicilio','375px','160px')" type="text" name="txtDomicilio" id="txtDomicilio" />
                                    </div>
                                </div>
                                
                                <div class="span9" style="width:800px;margin-top: 10px;">
                                    <label id="lbTelefono" class="control-label"><b>Tel&eacute;fono*</b></label>
                                    <div class="controls">
                                        <div style="float:left;"><input style="width: 120px;" onkeyup="changeCSSRequire('Telefono','120px','160px')" maxlength="10" onkeypress="return validarSoloNumeros(event)" type="text" name="txtTelefono" id="txtTelefono" /></div>
                                        <input style="margin-left: 30px;width: 120px;float:left;" maxlength="10" onkeypress="return validarSoloNumeros(event)" type="text" name="txtCell" id="txtCell" />
                                    </div>
                                </div>
                                
                                <div class="span9" style="margin-top: 10px;">
                                    <label id="lbCedula" class="control-label"><b>C&eacute;dula*</b></label>
                                    <div class="controls">
                                        <input style="width: 120px;" onkeyup="changeCSSRequire('Cedula','120px','160px')" maxlength="10" onkeypress="return validarSoloNumeros(event)" type="text" name="txtCedula" id="txtCedula" />
                                    </div>
                                </div>
                                <div class="span9">
                                    <label class="control-label" style="margin-top: 10px;"><b>Comentarios</b></label><br /><br />
                                     <textarea style="width: 375px; height: 100px; margin-left: 180px;" name="txtComentarios" id="txtComentarios" > </textarea>
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
        </div><!--/.fluid-container-->
        
    </body>
</html>
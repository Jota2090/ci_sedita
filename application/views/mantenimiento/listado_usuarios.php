<!DOCTYPE html>
<html>
    <head>
    	<meta charset="utf-8" />
        <title>Sedita Usuarios</title>
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
            function fncCmbUsuario(){
                var id= $("#cmbUsuario").find(":selected").val();
                var nombre= $("#txtNombre").val();
                $("#resultadosConsulta").innerHTML="";
                $.ajax({
                    type:"post",
                    url: "<?=site_url("mantenimiento/usuarios")?>",
                    data:"usuario="+id+"&nombre="+nombre+"&indicador=1",
                    success:function(info){
                        $("#resultadosConsulta").html(info);
                    }
                });
            };
        </script>
        
        <style type="text/css">
            body {
                width: 1200px;
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
        <form class="form-horizontal">
            <fieldset>
                <legend>Usuarios del Sistema</legend>
                <div class="panel span8" style="width:750px; margin-left:50px; padding:20px 0 20px 0;">
                    <div class="control-group span5">
                        <label class="control-label"><b>Nombre</b></label>
                        <div class="controls">
                            <input type="text" id="txtNombre" name="txtNombre" />
                        </div>
                        
                        <label class="control-label" style="margin-top: 10px;"><b>Tipo de Usuario</b></label>
                        <div class="controls" style="margin-top: 10px;">
                            <?
                                $js = 'id="cmbUsuario"';
                                echo form_dropdown("cmbUsuario",$usuario, null, $js);
                            ?>
                        </div>
                    </div>
                    <div class="control-group span4">
                        <a href="javascript:fncCmbUsuario()" id="btnConsultar" class="btn btn-primary" style="width:120px;margin:20px 0 0 100px;" ><i class="icon-search"></i>Buscar</a>
                   </div>
                </div>
                <div class="span4" style="margin-left:80px;">
                    <div class="well sidebar-nav" style="width: 200px;">
                        <ul class="nav nav-list">
                          <li class="nav-header">Ayuda<i class="icon-question-sign" style="float: right;"></i></li>
                          <li><a>En esta secci&oacute;n podr&aacute; <b>agregar, buscar, editar y eliminar</b> usuarios del sistema.</a></li>
                        </ul>
                    </div><!--/.well -->
                </div><!--/span-->
            </fieldset>
        </form> 
        
        <div id="resultadosConsulta" style="width: 1100px; margin: 0 auto;">
            <!--<form class="span2" style="float: right;" action="<?=site_url("mantenimiento/expListUsuarios")?>" method="post">
                <button class="btn" type="submit" id="exportar" style="width: 120px;"><i class="icon-download-alt"></i>Excel</button>
                <input type="hidden" id="tipoUsuario" name="tipoUsuario" value="<? echo $u?>" />
                <input type="hidden" id="nombre" name="nombre" value="<? echo $name?>" />
                <input type="hidden" id="indicador" name="indicador" value="1" />
            </form>
            
            <form class="span2" style="float: right;" action="<?=site_url("mantenimiento/expListUsuarios")?>" method="post" target="_blank">
                <button class="btn" type="submit" id="exportar" style="width: 120px;"><i class="icon-print"></i>Imprimir</button>
                <input type="hidden" id="tipoUsuario" name="tipoUsuario" value="<? echo $u?>" />
                <input type="hidden" id="nombre" name="nombre" value="<? echo $name?>" />
                <input type="hidden" id="indicador" name="indicador" value="0" />
            </form>-->
            
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
    </body>
</html>
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
            function fncCmbCurso(){
                var nombre= $("#txtCurso").val();
                
                $("#resultadosConsulta").innerHTML="";
                $.ajax({
                    type:"post",
                    url: "<?=site_url("mantenimiento/nom_cursos")?>",
                    data:"nom="+nombre+"&ind=1",
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
                <legend>Cursos del Plantel</legend>
                <div class="panel span8" style="width:750px; margin-left:50px; padding:10px 0 10px 0;">
                    <div class="control-group span5">
                        <label class="control-label"><b>Nombre*</b></label>
                        <div class="controls">
                            <input type="text" id="txtCurso" name="txtCurso" />
                        </div>
                    </div>
                    <div class="control-group span4">
                        <a href="javascript:fncCmbCurso()" id="btnConsultar" class="btn btn-primary" style="width:120px;margin-left:100px;" ><i class="icon-search"></i>Buscar</a>
                   </div>
                </div>
                <div class="span4" style="margin-left:90px;">
                    <div class="well sidebar-nav" style="width: 200px;">
                        <ul class="nav nav-list">
                          <li class="nav-header">Ayuda<i class="icon-question-sign" style="float: right;"></i></li>
                          <li><a>En esta secci&oacute;n podr&aacute; <b>agregar, buscar, y editar</b> cursos del plantel.</a></li>
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
    </body>
</html>
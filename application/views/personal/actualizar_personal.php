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
    <script src="js/jquery.validate.js"></script>
        
        
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
        function fncCmbPer(){
            var nom= $("#txtNom").val(); var estado = $("#estado").find(":selected").val();
            var ape= $("#txtApe").val();
            
            $.ajax({
                type:"post",
                url: "<?=site_url("personal/consultar")?>",
                data:"nom="+nom+"&ape="+ape+"&ind=1"+"&estado="+estado,
                success:function(info){
                    $("#resultadosConsulta").innerHTML="";
                    $("#resultadosConsulta").html(info);
                }
            });
        };
        
        function filtros(){
            var idBtn=document.getElementById("btnFiltros").value;
            if(idBtn==="-"){
                document.getElementById("filtros").style.display="none";
                document.getElementById("btnFiltros").value="+";
                document.getElementById("btnFiltros").title="Mostrar Filtros";
            }else{
                document.getElementById("filtros").style.display="";
                document.getElementById("btnFiltros").value="-";
                document.getElementById("btnFiltros").title="Ocultar Filtros";
            }
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
            <div class="panel" style="padding-bottom: 0px;">
                <form target="_blank" style="padding-right: 100px;" id="forma" name="forma" class="form-horizontal" action="<?=site_url("listados/exportar")?>" method="post" >
                   <input type="hidden" id="indicador" name="indicador" />
                   <fieldset>
                       <legend>
                            <div style="float:left;">Personal Docente</div>
                            <div style="float:right;"><input title="Ocultar Filtros" id="btnFiltros" type="button" onclick="filtros();" value="-"></div>
                        </legend>
                       <div id="filtros">
                            <div class="control-group">
                                <label class="control-label"><b>Personal</b></label>
                                <div class="controls">
                                    <input type="text" id="txtNom" name="txtNom" placeholder="Nombres" />
                                    <input style="margin-left:20px;" type="text" id="txtApe" name="txtApe" placeholder="Apellidos" />
                                </div>
                            </div>
                            <div class="control-group">
                                <label id="lbEstado" class="control-label" style="float:left;"><b>Estado</b></label>
                                <select id="estado" name="estado" style="width:110px; float:left;  margin-left:20px ">
                                    <option value="a">Activos</option>
                                    <option value="i">Inactivos</option>
                                </select>
                                <a href="javascript:fncCmbPer()" id="btnConsultar" class="btn btn-primary" style="width:100px;margin-left:220px;" ><i class="icon-search"></i>Buscar</a>
                           </div>
                       </div>
                   </fieldset> 
                </form>
            </div>
            <div id="resultadosConsulta" class="span9" style="width: 980px; margin: 0 auto;">          
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
    </div><!--/.fluid-container-->
    
  </body>
</html>
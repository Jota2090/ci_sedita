<!DOCTYPE html>
<html>
    <head>
    	<meta charset="utf-8" />
        <title>Sedita Materias/Cursos</title>
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
            $(document).ready(function(){
                $("#cmbJornada").change(function(){
                    var idJornada= $("#cmbJornada").find(":selected").val();
                    var cmbNivel=document.getElementById("cmbNivel");
                    var cmbCurso=document.getElementById("cmbCurso");
                    var cmbEspec=document.getElementById("cmbEspec");
                    
                    cmbCurso.disabled=true;
                    cmbEspec.disabled=true;
                    $("#cmbCurso").empty();
                    $("#cmbEspec").empty();
                    
                    if(idJornada==0){
                        cmbNivel.disabled=true;
                        $("#cmbNivel").empty();
                    }
                    else{
                        cmbNivel.disabled=false;
                        $.ajax({
                            type:"post",
                            url: "<?=site_url("general/cargar_niveles")?>",
                            data:"jornada="+idJornada,
                            success:function(info){
                                $("#cmbNivel").html(info);
                            }
                        }); 
                    }
                });
             });
             
            $(document).ready(function(){
                $("#cmbNivel").change(function(){
                    var idJornada= $("#cmbJornada").find(":selected").val();
                    var idNivel= $("#cmbNivel").find(":selected").val();
                    var cmbCurso=document.getElementById("cmbCurso");
                    var cmbEspec=document.getElementById("cmbEspec");
                    
                    cmbEspec.disabled=true;
                    $("#cmbEspec").empty();
                    
                    if(idNivel==0){
                        $("#cmbCurso").empty();
                        cmbCurso.disabled=true;                    
                    }
                    else{
                        cmbCurso.disabled=false;
                        
                        $.ajax({
                            type:"post",
                            url: "<?=site_url("general/cargar_cursos")?>",
                            data:"jornada="+idJornada+"&nivel="+idNivel,
                            success:function(info){
                                $("#cmbCurso").html(info);
                            }
                        });
                    } 
                });
            });
            
            $(document).ready(function(){
                $("#cmbCurso").change(function(){
                    var idJornada= $("#cmbJornada").find(":selected").val();
                    var idCurso= $("#cmbCurso").find(":selected").val();
                    var cmbEspec=document.getElementById("cmbEspec");
                    
                    if(idCurso==0){
                        $("#cmbEspec").empty();
                        cmbEspec.disabled=true;
                    }
                    else{
                        //idCurso==12 o 13, 5to y 6to bachillerato
                        if((idCurso==12)||(idCurso==13))
                        {
                            cmbEspec.disabled=false;
                            
                            $.ajax({
                                type:"post",
                                url: "<?=site_url("general/cargar_especializaciones")?>",
                                data:"jornada="+idJornada+"&curso="+idCurso,
                                success:function(info){
                                    $("#cmbEspec").html(info);
                                }
                            });
                        }
                        else{
                            cmbEspec.disabled=true;
                            $("#cmbEspec").empty();
                        }
                    }
                });
            });
            
            function fncCmbMateria(){
                var nom= $("#txtMat").val();
                var cur = $("#cmbCurso").find(":selected").val();
                var esp = $("#cmbEspec").find(":selected").val();
                
                if(cur>11&&cur<14&&esp==0){
                    alert("Debe elegir una especializacion");
                }
                else{
                    $("#resultadosConsulta").innerHTML="";
                    $.ajax({
                        type:"post",
                        url: "<?=site_url("mantenimiento/mat_curso")?>",
                        data:"nom="+nom+"&cur="+cur+"&esp="+esp+"&ind=1",
                        success:function(info){
                            $("#resultadosConsulta").html(info);
                        }
                    });
                }
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
                <legend>Materias del Plantel</legend>
                <div class="panel span8" style="width:750px; margin-left:50px; padding:10px 0 10px 0;">
                    <div class="control-group" style="clear:both">
                        <label class="control-label"><b>Nombre</b></label>
                        <div class="controls">
                            <input type="text" id="txtMat" name="txtMat" />
                        </div>
                    </div>
                    <div class="span4">
                        <label style="width:70px; margin-top: 10px;" class="control-label"><b>Jornada</b></label>
                        <div style="margin-top: 10px; padding-left: 80px" >
                            <?php 
                                $js = 'id="cmbJornada"';
                                echo form_dropdown("cmbJornada",$jornada, null, $js);
                            ?>
                        </div>
                        <label style="width:70px; margin-top: 10px;" class="control-label"><b>Nivel</b></label>
                        <div style="margin-top: 10px; padding-left: 80px;">
                            <select id="cmbNivel" name="cmbNivel" disabled="disabled" ></select>
                        </div>
                    </div>
                    <div style="margin-left:50px;" class="span5">
                        <label class="control-label" style="width:110px; margin-top: 10px;"><b>Curso </b></label>
                        <div  style="margin-top: 10px; padding-left: 120px;">
                            <select id="cmbCurso" name="cmbCurso" disabled="disabled" ></select>
                        </div>
                        
                        <label class="control-label" style="width:110px; margin-top: 10px;"><b>Especializaci&oacute;n</b></label>
                        <div  style="margin-top: 10px; padding-left: 120px;">
                            <select id="cmbEspec" name="cmbEspec" disabled="disabled" ></select>
                        </div>
                        
                        <a href="javascript:fncCmbMateria()" id="btnConsultar" class="btn btn-primary" style="width:120px;margin:15px 0 0 180px;" ><i class="icon-search"></i>Buscar</a>
                   </div>
                </div>
                <div class="span4" style="margin-left:80px;">
                    <div class="well sidebar-nav" style="width: 200px;">
                        <ul class="nav nav-list">
                          <li class="nav-header">Ayuda<i class="icon-question-sign" style="float: right;"></i></li>
                          <li><a>En esta secci&oacute;n podr&aacute; <b>agregar, buscar, y editar</b> materias del plantel.</a></li>
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
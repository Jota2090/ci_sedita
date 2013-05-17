<!DOCTYPE html>
<html>
    <head>
    	<meta charset="utf-8" />
        <title>Sedita Cursos</title>
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
        <script src="js/jquery-ui.js"></script>
        
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
            
            function fncConsultar(){
                var jornada = $("#cmbJornada").find(":selected").val();
                var especializacion = $("#cmbEspec").find(":selected").val();
                var curso = $("#cmbCurso").find(":selected").val();
                
                if(curso>11&&curso<14 &&especializacion===0){
                    alert("Debe elegir especializacion");
                }
                else{
                    $.ajax({
                        type:"post",
                        url: "<?=site_url("mantenimiento/cursos")?>",
                        data:"curso="+curso+"&jornada="+jornada+"&especializacion="+especializacion
                                +"&indicador=1",
                        success:function(info){
                            $("#resultadosConsulta").html(info);
                        }
                    }); 
                }  
            }
            

            $(document).ready(function() {
                $( "#paralelo" ).dialog({
                    autoOpen: false,
                    height: 200,
                    width: 300,
                    modal: true,
                    buttons: {
                        Guardar: function(){
                            var paralelo = $('input[name=paralelo]').val();
                            
                            if(paralelo == "" || paralelo == null){
                                $( this ).dialog( "close" );
                            }
                            else{
                                $.ajax({
                                    type:"post",
                                    url: "<?=site_url("mantenimiento/paralelo")?>",
                                    data:"paralelo="+paralelo,
                                    success:function(info){
                                    }
                                });
                                
                                $( this ).dialog( "close" );
                            }
                        },
                        Salir: function() {
                            $( this ).dialog( "close" );
                        }
                    },
                    close: function() {
                    }
                });
                
                $( "#add-paralelo" ).button().click(function() {
                    $.ajax({
                        type: 'post',
                        dataType: 'html',
                        url:"<?=site_url("mantenimiento/agregar_paralelo")?>",
                        success: function(data){
                            $("#paralelo").empty();
                            $("#paralelo").append(data);
                            $("#paralelo").dialog( "open" );
                        }                        
                     })            
                });
            });
        </script>
    </head>
    
    <body data-spy="scroll" data-target=".bs-docs-sidebar">
        <div id="paralelo" title="Agregar Paralelo"></div>
        <form class="form-horizontal">
            <fieldset>
                <legend>Cursos Disponibles</legend>
                <div class="panel span7" style="width:850px; margin-left:50px; padding:10px 0 10px 0;">
                    <div class="control-group span5">
                        <label class="control-label"><b>Nivel</b></label>
                        <div class="controls">
                            <select id="cmbNivel" name="cmbNivel" disabled="disabled" ></select>
                        </div>
                        
                        <label class="control-label" style="margin-top: 10px;"><b>Curso </b></label>
                        <div class="controls" style="margin-top: 10px;">
                            <select id="cmbCurso" name="cmbCurso" disabled="disabled" ></select>
                        </div>
                        
                        <label class="control-label" style="margin-top: 10px;"><b>Especializaci&oacute;n</b></label>
                        <div class="controls" style="margin-top: 10px;">
                            <select id="cmbEspec" name="cmbEspec" disabled="disabled" ></select>
                        </div>
                    </div>
                    <div class="control-group span3">
                        <label class="control-label"><b>Jornada</b></label>
                        <div class="controls">
                            <?php 
                                $js = 'id="cmbJornada"';
                                echo form_dropdown("cmbJornada",$jornada, null, $js);
                            ?>
                        </div>
                        
                        <a href="javascript:fncConsultar()" id="btnConsultar" class="btn btn-primary" style="width:120px;margin:45px 0 0 160px;" ><i class="icon-search"></i>Buscar</a>
                   </div>
                </div>
                <div class="span2" style="margin-left: 45px;">
                    <div class="well sidebar-nav" style="width: 200px;">
                        <ul class="nav nav-list">
                          <li class="nav-header">Ayuda<i class="icon-question-sign" style="float: right;"></i></li>
                          <li><a>En esta secci&oacute;n podr&aacute; <b>agregar, buscar, editar y eliminar</b> usuarios del sistema.</a></li>
                        </ul>
                    </div><!--/.well -->
                </div><!--/span-->
            </fieldset>
        </form>
        
        <button style="margin-left: 450px;" type="btn" id="add-paralelo"><i class="icon-plus-sign"></i>Agregar Paralelo</button> 
        <div id="resultadosConsulta" style="width: 1100px; margin: 0 auto;">
            <!--<form class="span2" style="float: right;" action="<?=site_url("mantenimiento/expListCursos")?>" method="post">
                <button class="btn" type="submit" id="exportar" style="width: 120px;"><i class="icon-download-alt"></i>Excel</button>
                <input type="hidden" id="jornada" name="jornada" value="<? echo $j?>" />
                <input type="hidden" id="curso" name="curso" value="<? echo $c?>" />
                <input type="hidden" id="especializacion" name="especializacion" value="<? echo $e?>" />
                <input type="hidden" id="indicador" name="indicador" value="1" />
            </form>
            
            <form class="span2" style="float: right;" action="<?=site_url("mantenimiento/expListCursos")?>" method="post" target="_blank">
                <button class="btn" type="submit" id="exportar" style="width: 120px;"><i class="icon-print"></i>Imprimir</button>
                <input type="hidden" id="jornada" name="jornada" value="<? echo $j?>" />
                <input type="hidden" id="curso" name="curso" value="<? echo $c?>" />
                <input type="hidden" id="especializacion" name="especializacion" value="<? echo $e?>" />
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
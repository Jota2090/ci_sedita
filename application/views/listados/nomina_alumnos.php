<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <title>Sedita Listados</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description" content="" />
    <meta name="Sedita" content="" />
	<base href="<?=site_url()?>" />
    
    <!-- Le styles -->
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
        $(document).ready(function(){
            $("#cmbJornada").change(function(){
                var idJornada= $("#cmbJornada").find(":selected").val();
                var cmbNivel=document.getElementById("cmbNivel");
                var cmbCurso=document.getElementById("cmbCurso");
                var cmbEspec=document.getElementById("cmbEspec");
                var cmbParal=document.getElementById("cmbParalelo");

                cmbCurso.disabled=true;
                cmbEspec.disabled=true;
                cmbParal.disabled=true; 
                $("#cmbCurso").empty();
                $("#cmbEspec").empty();
                $("#cmbParalelo").empty();

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
                var cmbParal=document.getElementById("cmbParalelo");

                cmbEspec.disabled=true;
                cmbParal.disabled=true;
                $("#cmbEspec").empty();
                $("#cmbParalelo").empty();

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
                var cmbParal=document.getElementById("cmbParalelo");
                var cmbEspec=document.getElementById("cmbEspec");

                if(idCurso==0){
                    $("#cmbEspec").empty();
                    $("#cmbParalelo").empty();
                    cmbEspec.disabled=true;
                    cmbParal.disabled=true;
                }
                else{
                    //idCurso==12 o 13, 5to y 6to bachillerato
                    if((idCurso==12)||(idCurso==13))
                    {
                        cmbEspec.disabled=false;
                        cmbParal.disabled=true;
                        $("#cmbParalelo").empty();

                        $.ajax({
                            type:"post",
                            url: "<?=site_url("general/cargar_especializaciones")?>",
                            data:"jornada="+idJornada+"&curso="+idCurso,
                            success:function(info){
                                $("#cmbEspec").html(info);
                            }
                        });
                    }
                    else
                    {
                        cmbEspec.disabled=true;
                        $("#cmbEspec").empty();
                        cmbParal.disabled=false;

                        $.ajax({
                            type:"post",
                            url: "<?=site_url("general/cargar_paralelos")?>",
                            data:"jornada="+idJornada+"&curso="+idCurso,
                            success:function(info){
                                $("#cmbParalelo").html(info);
                            }
                        });
                    }
                }
            });
        });

        $(document).ready(function(){
            $("#cmbEspec").change(function(){
                var idJornada= $("#cmbJornada").find(":selected").val();
                var idCurso= $("#cmbCurso").find(":selected").val();
                var cmbParal=document.getElementById("cmbParalelo");
                var idEspec= $("#cmbEspec").find(":selected").val();

                if(idEspec==0){
                    cmbParal.disabled=true;
                    $("#cmbParalelo").empty();
                }
                else{
                    cmbParal.disabled=false;

                    $.ajax({
                        type:"post",
                        url: "<?=site_url("general/cargar_paralBachill")?>",
                        data:"jornada="+idJornada+"&curso="+idCurso+"&espec="+idEspec,
                        success:function(info){
                            $("#cmbParalelo").html(info);
                        }
                    });
                } 
            });
        });
        
        $(document).ready(function(){
            $("#cmbModulo").change(function(){
                var mod = $("#cmbModulo").find(":selected").val();

                if(mod==2){
                    $("#quimestre").hide();
                    $("#trimestre").show();
                }
                else{
                    $("#quimestre").show();
                    $("#trimestre").hide();
                }
            });
        });
        
        function imprimir(){
            var jor = $("#cmbJornada").find(":selected").val();
            var cur = $("#cmbCurso").find(":selected").val();
            var esp = $("#cmbEspec").find(":selected").val();
            var par = $("#cmbParalelo").find(":selected").val();
            var radio = $("input[name=radio]:checked").val();
            var parcial = $("input[name=parcial]:checked").val();
            
            if(jor==0){
                alert("Debe elegir una jornada");
            }
            else{
                if(cur==0||cur==null){
                    alert("Debe elegir un curso");
                }
                else{
                    if((cur >11 && cur < 14) && esp==0){
                        alert("Debe elegir una especializacion");
                    }
                    else{
                        if(par==0||par==null){
                            alert("Debe elegir un paralelo");
                        }
                        else{
                            if(radio==""||radio==null){
                                alert("Debe seleccionar el tipo de reporte a generar");
                            }
                            else{
                                if(radio=="acta"&&(parcial==null||parcial=="")){
                                    alert("Debe elegir un parcial");
                                }
                                else{
                                    var frm = document.getElementById("forma");
                                    frm.indicador.value = 1;
                                    document.forma.submit();
                                }
                            }
                        }       
                    }
                }
            }
        };
        
        function exportar(){
            var curso = $("#cmbCurso").find(":selected").val();
            var especializacion = $("#cmbEspecializacion").find(":selected").val();
            var paralelo = $("#cmbParalelo").find(":selected").val();
            var radio = $("input[name=radio]:checked").val();
            var parcial = $("input[name=parcial]:checked").val(); 
            
            if(curso == 0){
                alert("Debe elegir un curso");
            }
            else{
                if((curso >11 && curso < 14) && especializacion==0){
                    alert("Debe elegir una especializacion");
                }
                else{
                    if(paralelo==0){
                        alert("Debe elegir un paralelo");
                    }
                    else{
                        if(radio==""||radio==null){
                            alert("Debe seleccionar el tipo de reporte a generar");
                        }
                        else{
                            if(radio=="acta"&&(parcial==null||parcial=="")){
                                alert("Debe elegir un parcial");
                            }
                            else{
                                var frm = document.getElementById("forma");
                                frm.indicador.value = 2;
                                document.forma.submit();
                            }
                        }
                    }        
                }
            }
        };
    </script>
  </head>

  <body data-spy="scroll" data-target=".bs-docs-sidebar">
      <?=$menu?>
    <div class="container-fluid">
      <div class="row-fluid">
        <div class="span3">
            <div class="well sidebar-nav" style="width:300px;">
                <ul class="nav nav-list">
                  <li class="nav-header">Alumnos</li>
                  <li class="active"><a href="<?=site_url("listados/nomina_alumnos")?>">N&oacute;minas o Actas</a></li>
                  <li><a href="<?=site_url("listados/hoja_matricula")?>">Hoja de Matr&iacute;cula</a></li>
                  <br />
                  <li class="nav-header">Libretas</li>
                  <li><a href="<?=site_url("listados/cuadro_honor")?>">Cuadro de Honor</a></li>
                  <li><a href="<?=site_url("listados/cuadro_promocion")?>">Cuadro de Promoci&oacute;n</a></li>
                </ul>
            </div><!--/.well -->
            <div class="well sidebar-nav" style="float:left;width:200px;margin:30px 0 0 50px">
                <ul class="nav nav-list">
                  <li class="nav-header">Ayuda<i class="icon-question-sign" style="float: right;"></i></li>
                  <li><a>En esta secci&oacute;n podr&aacute; <b>imprimir o exportar a excel</b> las n&oacute;minas y actas de calificaciones de un per&iacute;odo correspodiente.</a></li>
                </ul>
            </div><!--/.well -->
        </div>
        <div class="span9">
            <div class="panel">
                <form target="_blank" style="padding-right: 100px;" id="forma" name="forma" class="form-horizontal" action="<?=site_url("listados/exportar")?>" method="post" >
                   <input type="hidden" id="indicador" name="indicador" />
                   <fieldset>
                       <legend>Listados de Alumnos</legend>
                        <div class="control-group" style="width:390px;float:left;">
                            <label class="control-label"><b>Jornada *</b></label>
                            <div class="controls">
                                <?php 
                                    $js = "id='cmbJornada'";
                                    echo form_dropdown("cmbJornada",$jornada, null, $js);
                                ?>
                            </div>
                            
                            <label class="control-label" style="margin-top: 5px;"><b>Nivel *</b></label>
                            <div class="controls" style="margin-top: 5px;">
                                <select disabled="disabled" id="cmbNivel" name="cmbNivel"></select>
                            </div>
                            
                            <label class="control-label" style="margin-top: 5px;"><b>Curso *</b></label>
                            <div class="controls" style="margin-top: 5px;">
                                <select disabled="disabled" id="cmbCurso" name="cmbCurso"></select>
                            </div>
                            
                            <label class="control-label" style="margin-top: 5px;"><b>Especializaci&oacute;n *</b></label>
                            <div class="controls" style="margin-top: 5px;">
                                <select disabled="disabled" id="cmbEspec" name="cmbEspec"></select>
                            </div>
                            
                            <label class="control-label" style="margin-top: 5px;"><b>Paralelo *</b></label>
                            <div class="controls" style="margin-top: 5px;">
                                <select disabled="disabled" id="cmbParalelo" name="cmbParalelo"></select>
                            </div>
                            
                            <label class="radio" style="margin: 40px 0 0 180px;">
                                <input type="radio" name="radio" id="radio" value="nomina" />
                                <b>N&oacute;mina</b>
                            </label>
                            <label class="radio" style="margin: 10px 0 0 180px;">
                                <input type="radio" name="radio" id="radio" value="acta" />
                                <b>Acta de Calificaciones</b> 
                            </label>
                        </div>
                        
                        <div class="control-group" style="width:300px;float:left; margin-top: 0px;" >
                            <label class="control-label" ><b>A&ntilde;o Lect&iacute;vo</b></label>
                            <div class="controls">
                                <?php 
                                    $js = 'id="cmbAnioLec" style="width:130px"';
                                    echo form_dropdown("cmbAnioLec",$anioLect, $anlId, $js);
                                ?>
                            </div>
                            <label class="control-label" style="margin-top:30px"><b>M&oacute;dulo Escolar</b></label>
                            <div class="controls" style="margin-top:30px">
                               <select id="cmbModulo" name="cmbModulo" >
                                    <option value="1">Quinquemestre</option>
                                    <option value="2">Trimestre</option>
                                </select>
                            </div>
                            
                            <div id="parciales"  style="height: 50px">
                                <div id="quimestre"  style="margin: 20px 0 0 35px;">
                                    <label class="checkbox inline">
                                        <input type="radio" name="parcial" id="parcial" value="1"> 1er Parcial
                                    </label>
                                    <label class="checkbox inline">
                                        <input type="radio" name="parcial" id="parcial" value="2"> 2do Parcial
                                    </label>
                                </div>
                                <div id="trimestre"  style="margin: 20px 0 0 35px; display: none">
                                    <label class="checkbox inline">
                                        <input type="radio" name="parcial" id="parcial" value="3"> 1er Trimestre
                                    </label>
                                    <label class="checkbox inline">
                                        <input type="radio" name="parcial" id="parcial" value="4"> 2do Trimestre
                                    </label>
                                    <label class="checkbox inline">
                                        <input type="radio" name="parcial" id="parcial" value="5"> 3er Trimestre
                                    </label>
                                </div>
                            </div>
                            <div  style="margin: 60px 0 0 60px; float:left; width:350px;">
                                <a style="float:left; width: 125px;" href="javascript:imprimir()" id="btnImprimir" class="btn btn-primary" ><i class="icon-print"></i>Generar</a>
                                <a style="float:right; width: 125px;" href="javascript:exportar()" id="btnExportar" class="btn" ><i class="icon-download-alt"></i>Exportar Excel</a>
                            </div>
                        </div>
                   </fieldset>
                </form>
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
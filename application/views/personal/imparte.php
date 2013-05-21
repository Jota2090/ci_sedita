<!DOCTYPE html>
<html>
    <head>
    	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
        <title>Sedita Asignaci&oacute;n Curso y Dirigente</title>
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
            $(document).ready(function(){
                $("#cmbProf").change(function(){
                    var jor= $("#cmbJornada").find(":selected").val();
                    var per= $("#cmbProf").find(":selected").val();
                    var anl= $("#cmbAnioLectivo").find(":selected").val();
                    if(jor==1){
                        $("#cmbJornada").removeAttr('disabled');
                        $("#cmbNivel").removeAttr('disabled');
                        $("#cmbCurso").removeAttr('disabled');
                    }
                    
                    $.ajax({
                        type:"post",
                        url: "<?=site_url("personal/cargar_cur_dir")?>",
                        data:"per="+per+"&anl="+anl,
                        success:function(info){
                            $("#resultadoConsulta").html(info);
                        }
                    });
                })                
            })
            
            $(document).ready(function(){
                $("#cmbAnioLectivo").change(function(){
                    var per= $("#cmbProf").find(":selected").val();
                    var anl= $("#cmbAnioLectivo").find(":selected").val();
                    
                    $.ajax({
                        type:"post",
                        url: "<?=site_url("personal/cargar_cur_dir")?>",
                        data:"per="+per+"&anl="+anl,
                        success:function(info){
                            $("#resultadoConsulta").html(info);
                        }
                    });
                })                
            });
            
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
                    $("#cmbMat").empty();
                    $("#cmbMat").attr('disabled', 'disabled');
                    
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
                                    $("#cmbMat").empty();
                                    $("#cmbMat").attr('disabled', 'disabled');
                                }
                            });
                        }
                        else
                        {
                            cmbEspec.disabled=true;
                            $("#cmbEspec").empty();
                            cmbParal.disabled=false;
                            var esp = $("#cmbEspecializacion").find(":selected").val();
                            if(idCurso>0&&idCurso<12) esp=-1;
                            
                            $.ajax({
                                type:"post",
                                url: "<?=site_url("general/cargar_paralelos")?>",
                                data:"jornada="+idJornada+"&curso="+idCurso,
                                success:function(info){
                                    $("#cmbParalelo").html(info);
                                }
                            });
                            
                            $.ajax({
                                type:"post",
                                url: "<?=site_url("personal/cargar_materias")?>",
                                data:"cur="+idCurso+"&esp="+esp,
                                success:function(info){
                                    $("#cmbMat").removeAttr('disabled');
                                    $("#cmbMat").html(info);
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
                        $("#cmbMat").empty();
                        $("#cmbMat").attr('disabled', 'disabled');
                    }
                    else{
                        cmbParal.disabled=false;
                        
                        if(idCurso>0&&idCurso<12) idEspec=-1;
                        
                        $.ajax({
                            type:"post",
                            url: "<?=site_url("general/cargar_paralBachill")?>",
                            data:"jornada="+idJornada+"&curso="+idCurso+"&espec="+idEspec,
                            success:function(info){
                                $("#cmbParalelo").html(info);
                            }
                        });
                        
                        $.ajax({
                            type:"post",
                            url: "<?=site_url("personal/cargar_materias")?>",
                            data:"cur="+idCurso+"&esp="+idEspec,
                            success:function(info){
                                $("#cmbMat").removeAttr('disabled');
                                $("#cmbMat").html(info);
                            }
                       });
                    } 
                });
            });
            
            function agregar(){
                var per = $("#cmbProf").find(":selected").val();
                var cur = $("#cmbCurso").find(":selected").val();
                var esp = $("#cmbEspec").find(":selected").val();
                var par = $("#cmbParalelo").find(":selected").val();
                var jor = $("#cmbJornada").find(":selected").val();
                var mat = $("#cmbMat").find(":selected").val();
                var anl = $("#cmbAnioLectivo").find(":selected").val();
                var dir = $("#chkDir:checked").val();
                
                if(per===""||per==null){
                    alert("Debe seleccionar un PROFESOR");
                }
                else{
                    if(mat===""||mat==null){
                        alert("Debe seleccionar una MATERIA");
                    }
                    else{
                        if(par==0||par==null){
                            alert("Debe seleccionar un PARALELO");
                        }
                        else{
                            $.ajax({
                                type:"post",
                                url: "<?=site_url("personal/cargar_cur_dir")?>",
                                data: "cur="+cur+"&esp="+esp+"&par="+par+"&jor="+jor+"&mat="+mat
                                        +"&dir="+dir+"&per="+per+"&anl="+anl+"&ind=1",
                                success:function(info){
                                    $("#resultadoConsulta").html(info);
                                }
                           });
                        } 
                    }
                }
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
                      <li class="nav-header">Personal</li>
                      <li><a href="<?=site_url("personal/registro")?>">Registro</a></li>
                      <br />
                      <li class="nav-header">Profesor</li>
                      <li class="active"><a href="<?=site_url("personal/asignacion_cursos")?>">Asignaci&oacute;n de Cursos y Dirigentes</a></li>
                      <br />
                    </ul>
                </div><!--/.well -->
                <div class="well sidebar-nav" style="float:left;width:200px;margin:30px 0 0 50px">
                    <ul class="nav nav-list">
                      <li class="nav-header">Ayuda<i class="icon-question-sign" style="float: right;"></i></li>
                      <li><a>En esta secci&oacute;n podr&aacute; <b>asignar los cursos a los que impartir&aacute; la materia y a los que dirige</b> el personal docente en el per&iacute;odo actual.</a></li>
                    </ul>
                </div><!--/.well -->
            </div>
            <div class="span9">
                <div class="panel" style="width: 900px; padding-bottom: 10px; padding-top: 20px; margin-bottom: 10px;">
                    <form style="padding-right:50px" class="form-horizontal">
                       <input type="hidden" id="indicador" name="indicador" />
                       <fieldset>
                           <legend>
                                <div style="float:left;">Asignaci&oacute;n de Cursos</div>
                                <div style="float:right;"><input title="Ocultar Filtros" id="btnFiltros" type="button" onclick="filtros();" value="-"></div>
                            </legend>
                        </fieldset> 
                    </form>
                    
                    <div id="filtros">
                        <div class="span8">
                            <label class="control-label" style="margin-left:250px"><b>A&ntilde;o Lectivo</b></label>
                            <div class="controls" style="margin-left:250px">
                                <?php 
                                    $js = "id='cmbAnioLectivo' style='width:130px' ";
                                    echo form_dropdown("cmbAnioLectivo",$anio_lectivo, $anl, $js);
                                ?>
                            </div>

                            <label class="control-label"><b>Profesores</b></label>
                            <div class="controls">
                                <select id="cmbProf" name="cmbProf" style="width: 400px;" size="10">
                                    <?=$profesor?>
                                </select>
                            </div>
                        </div>

                        <div class=" control-group span5" style="margin-left: 60px;">
                            <div style="float:left;">
                                <label class="control-label"><b>Jornada</b></label>
                                <div class="controls">
                                    <?php 
                                        $js = 'style="width:130px" id="cmbJornada"';
                                        echo form_dropdown("cmbJornada",$jornada, null, $js);
                                    ?>
                                </div>
                            </div>

                            <div style="margin-left:60px; float:left;">
                                <label class="control-label"><b>Nivel</b></label>
                                <div class="controls">
                                    <select style="width:130px" id="cmbNivel" name="cmbNivel" disabled="disabled" ></select>
                                </div>
                            </div>
                        </div>

                        <div class=" control-group span6" style="margin-left: 60px;">
                            <div style="float:left;">
                                <label class="control-label"><b>Curso*</b></label>
                                <div class="controls">
                                    <select style="width:130px" id="cmbCurso" name="cmbCurso" disabled="disabled" ></select>
                                </div>
                            </div>

                            <div style="margin-left:60px; float:left;">
                                <label class="control-label"><b>Especializaci&oacute;n*</b></label>
                                <div class="controls">
                                    <select style="width:180px" id="cmbEspec" name="cmbEspec" disabled="disabled" ></select>
                                </div>
                            </div>
                        </div>

                        <div class="control-group span6" style="margin-left: 60px;">
                            <div class="control-group span12">
                                <label class="control-label"><b>Materia*</b></label>
                                <div class="controls">
                                    <select style="width: 300px;" id="cmbMat" name="cmbMat" disabled="disabled"></select>
                                </div>
                            </div>
                        </div>

                        <div class=" control-group span6" style="margin-left: 60px;"> 
                            <div style="float:left;">
                                <label class="control-label"><b>Par.*</b></label>
                                <div class="controls">
                                    <select style="width:130px" id="cmbParalelo" name="cmbParalelo" disabled="disabled" ></select>
                                </div>
                            </div>

                            <div style="margin-left:20px; float:left;">
                                <label class="checkbox inline" style="margin-top: 5px;"></label>
                                <input style="margin-top: 5px;" type="checkbox" id="chkDir" value="SI" /> <b>Dirigente</b>
                                <a id="btnAgregar" style="margin: 20px 0 0 40px;" class="btn btn-primary" style="" href="javascript:agregar()"><i class="icon-plus-sign"></i>Agregar</a>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="span12" id="resultadoConsulta" style="width:850px;margin-top:20px;"></div>
            </div><!--/span-->
            <div class="span2"></div>
          </div><!--/row-->
        </div><!--/.fluid-container-->
    </body>
</html>
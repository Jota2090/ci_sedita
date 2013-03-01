<!DOCTYPE html>
<html lang="es">
    <head>
    	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
        <title>Sedita Acta Calificaciones</title>
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
        <script src="js/jquery.validate.bootstrap.js"></script> 
        
        <!--Combos-->
        <script>
            $(document).ready(function(){
                $("#cmbJornada").change(function(){
                    var idJornada= $("#cmbJornada").find(":selected").val();
                    var cmbNivel=document.getElementById("cmbNivel");
                    var cmbCurso=document.getElementById("cmbCurso");
                    var cmbEspec=document.getElementById("cmbEspec");
                    var cmbParal=document.getElementById("cmbParalelo");
                    var cmbMat=document.getElementById("cmbMateria");
                    
                    cmbCurso.disabled=true;
                    cmbEspec.disabled=true;
                    cmbParal.disabled=true;
                    cmbMat.disabled=true;
                    $("#cmbCurso").empty();
                    $("#cmbEspec").empty();
                    $("#cmbParalelo").empty();
                    $("#cmbMateria").empty();
                    
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
                    var cmbMat=document.getElementById("cmbMateria");
                    
                    cmbEspec.disabled=true;
                    cmbParal.disabled=true;
                    cmbMat.disabled=true;
                    $("#cmbEspec").empty();
                    $("#cmbParalelo").empty();
                    $("#cmbMateria").empty();
                    
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
                    var cmbMat=document.getElementById("cmbMateria");
                    
                    if(idCurso==0){
                        $("#cmbEspec").empty();
                        $("#cmbParalelo").empty();
                        $("#cmbMateria").empty();
                        cmbEspec.disabled=true;
                        cmbParal.disabled=true;
                        cmbMat.disabled=true;
                    }
                    else{
                        //idCurso==12 o 13, 5to y 6to bachillerato
                        if((idCurso==12)||(idCurso==13))
                        {
                            cmbEspec.disabled=false;
                            cmbParal.disabled=true;
                            cmbMat.disabled=true;
                            $("#cmbParalelo").empty();
                            $("#cmbMateria").empty();
                            
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
                            
                            cmbMat.disabled=false;
                            var esp = -1;
                            $.ajax({
                                type:"post",
                                url: "<?=site_url("personal/cargar_materias")?>",
                                data:"cur="+idCurso+"&esp="+esp,
                                success:function(info){
                                    $("#cmbMateria").html(info);
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
                    var cmbMat=document.getElementById("cmbMateria");
                    
                    if(idEspec==0){
                        cmbParal.disabled=true;
                        $("#cmbParalelo").empty();
                        cmbMat.disabled=true;
                        $("#cmbMateria").empty();
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
                        
                        cmbMat.disabled=false;
                        $.ajax({
                            type:"post",
                            url: "<?=site_url("personal/cargar_materias")?>",
                            data:"cur="+idCurso+"&esp="+idEspec,
                            success:function(info){
                                $("#cmbMateria").html(info)
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
        </script>
        
        <script>
            function generar_acta(){
                var jor = $("#cmbJornada").find(":selected").val();
                var cur = $("#cmbCurso").find(":selected").val();
                var esp = $("#cmbEspec").find(":selected").val();
                var par = $("#cmbParalelo").find(":selected").val();
                var mat = $("#cmbMateria").find(":selected").val();
                var anl = $("#cmbAnioLec").find(":selected").val();
                var mod = $("input[name=radio]:checked").val();
                
                if(esp==null || esp=="")
                    esp=0;
                
                if(jor==0){
                    alert("Debe elegir una jornada");
                }
                else{
                    if(cur==0){
                        alert("Debe elegir un curso");
                    }
                    else{
                        if(cur>11 && cur<14 && esp==0){
                            alert("Debe elegir una especialización");
                        }
                        else{
                            if(par==0){
                                alert("Debe elegir un paralelo");
                            }
                            else{
                                if(mod==0||mod==null||mod==""){
                                    alert("Debe elegir parcial del periodo escolar");
                                }
                                else{
                                    $.ajax({
                                        type:"post",
                                        url: "<?=site_url("acta_calificaciones/generar_acta")?>",
                                        data:"cur="+cur+"&jor="+jor+"&esp="+esp+"&par="+par
                                                +"&mod="+mod+"&anl="+anl+"&mat="+mat,
                                        success:function(info){
                                            disabled($("#formActa"));
                                            $("#btnGenerar").attr('href', 'javascript:disable');
                                            $("#btnGenerar").attr('disabled', 'disabled');
                                            $("#listadoAlumnos").html(info);
                                        }
                                    });
                                } 
                            }
                        }
                    } 
                }
            }; 
            
            function cancelar(){
                nondisabled($("#formActa"));
                
                var cur = $("#cmbCurso").find(":selected").val();
                
                if(cur<12||cur>13)
                    $("#cmbEspec").attr('disabled','disabled');
                
                $("#btnGenerar").attr('href', 'javascript:generar_acta()');
                $("#btnGenerar").removeAttr('disabled');
                        
                $("#listadoAlumnos").html(""); 
            };
        </script>
        
        <script>
            function disabled(miForm) {
                $(':input', miForm).each(function() {
                var type = this.type;
                var tag = this.tagName.toLowerCase();
                    //limpiamos los valores de los campos�
                    if (type == 'checkbox' || type == 'radio'){
                        this.disabled = true;
                    }
                    else if (tag == 'select'){
                        this.disabled=true;
                    }
                });
            }
            
            function nondisabled(miForm) {
                $(':input', miForm).each(function() {
                var type = this.type;
                var tag = this.tagName.toLowerCase();
                    //limpiamos los valores de los campos�
                    if (type == 'checkbox' || type == 'radio'){
                        this.disabled = false;
                    }
                    else if (tag == 'select'){
                        this.disabled = false;
                    }
                });
            }
        </script>

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
    </head>

    <body data-spy="scroll" data-target=".bs-docs-sidebar">
        <div class="modal alert" id="warning" style="display: none;">
            <div class="modal-header">
                <a class="close" data-dismiss="modal">x</a>
                <h3><img src="images/alerta-warning.jpg" style="margin-right: 10px;" width="30px" height="30px"/>Atenci&oacute;n!</h3>
            </div>
            <div class="modal-body">
                <p>Esta Acta de Calificaciones <strong>ya fue creada</strong>!</p>
            </div>
        </div>
        <div class="modal alert-error" id="error" style="display: none;">
            <div class="modal-header">
                <a class="close" data-dismiss="modal">x</a>
                <h3><img src="images/alerta-error.jpg" style="margin-right: 10px;" width="30px" height="30px"/>Atenci&oacute;n!</h3>
            </div>
            <div class="modal-body">
                <p>Esta materia <strong>no pertenece</strong> al curso seleccionado!</p>
            </div>
        </div>
        <div class="modal alert" id="warning2" style="display: none;">
            <div class="modal-header">
                <a class="close" data-dismiss="modal">x</a>
                <h3><img src="images/alerta-warning.jpg" style="margin-right: 10px;" width="30px" height="30px"/>Atenci&oacute;n!</h3>
            </div>
            <div class="modal-body">
                <p>Esta Acta de Calificaciones <strong>no ha sido creada</strong>!</p>
            </div>
        </div>
        <?=$menu?>
        <div class="container-fluid">
            <form class="form-horizontal" id="formActa" name="formActa" action="<?=site_url("alumno/guardar") ?>" method="post" >
                <fieldset>
                    <legend>Acta de Calificaciones</legend>
                    <div class="span3" style="margin-right: 50px;">
                        <div class="span3 panel" style="width:230px;margin-left:15px;padding:10px 10px 0 20px;">
                            <ul class="nav">
                                <li><b>Jornada*</b></li>
                                <li><?php 
                                        $js = 'id="cmbJornada"';
                                        echo form_dropdown("cmbJornada",$jornada, null, $js);
                                    ?>
                                </li>
                                <br />
                                <li><b>Nivel*</b></li>
                                <li><select id="cmbNivel" name="cmbNivel" disabled="disabled" ></select></li>
                                <br />
                                <li><b>Curso*</b></li>
                                <li><select id="cmbCurso" name="cmbCurso" disabled="disabled" ></select></li>
                                <br />
                                <li><b>Especializaci&oacute;n*</b></li>
                                <li><select id="cmbEspec" name="cmbEspec" disabled="disabled" ></select></li>
                                <br />
                                <li><b>Paralelo*</b></li>
                                <li><select id="cmbParalelo" name="cmbParalelo" disabled="disabled" ></select></li>
                                <br />
                            </ul>
                        </div><!--/span-->
                        <div class="span3" style="margin-left:50px;">
                            <div class="well sidebar-nav">
                                <ul class="nav nav-list">
                                  <li class="nav-header">Ayuda<i class="icon-question-sign" style="float: right;"></i></li>
                                  <li><a>En esta secci&oacute;n podr&aacute; <b>ingresar, consultar y modificar</b> las actas de calificaciones del per&iacute;odo actual.</a></li>
                                </ul>
                            </div><!--/.well -->
                        </div><!--/span-->  
                    </div> 
                    <div class="span9 panel" style="width:930px;padding:10px 20px 10px 0;">
                        <div class="control-group span9">
                            <label class="control-label"><b>Materia</b></label>
                            <div class="controls">
                                <select id="cmbMateria" name="cmbMateria" style="width:320px" disabled="disabled"></select>
                            </div>
                        </div>
                        <div class="control-group span6">
                            <label class="control-label"><b>M&oacute;dulo Escolar</b></label>
                            <div class="controls">
                               <select id="cmbModulo" name="cmbModulo" >
                                    <option value="1">Quinquemestre</option>
                                    <option value="2">Trimestre</option>
                                </select>
                            </div>

                            <div id="quimestre"  style="margin: 20px 0 0 35px">
                                <label class="checkbox inline">
                                    <input type="radio" name="radio" id="radio" value="1"> 1er Parcial
                                </label>
                                <label class="checkbox inline">
                                    <input type="radio" name="radio" id="radio" value="2"> 2do Parcial
                                </label>
                            </div>
                            <div id="trimestre"  style="margin: 20px 0 0 35px; display: none">
                                <label class="checkbox inline">
                                    <input type="radio" name="radio" id="radio" value="3"> 1er Trimestre
                                </label>
                                <label class="checkbox inline">
                                    <input type="radio" name="radio" id="radio" value="4"> 2do Trimestre
                                </label>
                                <label class="checkbox inline">
                                    <input type="radio" name="radio" id="radio" value="5"> 3er Trimestre
                                </label>
                            </div>
                        </div>
                        <div class="span3">
                            <div class="control-group">
                                <label class="control-label"><b>A&ntilde;o Lect&iacute;vo</b></label>
                                <div class="controls">
                                    <?php 
                                        $js = 'id="cmbAnioLec" style="width:130px"';
                                        echo form_dropdown("cmbAnioLec",$anioLect, $anlId, $js);
                                    ?>
                                </div>
                            </div>
                            <a href="javascript:generar_acta()" id="btnGenerar" class="btn btn-primary" style="width: 100px; margin-left: 60px" ><i class="icon-calendar"></i>Visualizar</a>
                        </div>

                        <div class="span9" id="listadoAlumnos" style="width: 910px; margin:10px 0 0 15px;"></div>
                    </div>    
                </fieldset> 
            </form>
            <hr>
            <footer>
                <h6>Realizado por Sedita &nbsp;&nbsp; - &nbsp;&nbsp; &copy; Company 2012</h6>
            </footer> 
        </div>
    </body>
</html>

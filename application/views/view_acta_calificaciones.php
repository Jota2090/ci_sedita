<!DOCTYPE html>
<html>
    <head>
    	<meta charset="utf-8" />
        <title>Sedita Actas</title>
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
                $("#cmbMateria").change(function(){
                    var mat = $("#cmbMateria").find(":selected").val();
                    
                    if(mat == 0){
                        $("#cmbCurso").empty();
                        $("#cmbCurso").attr('disabled', 'disabled');
                    }
                    else{
                        $.ajax({
                            type:"post",
                            url: "<?=site_url("acta_calificaciones/cargar_curso")?>",
                            data:"mat="+mat,
                            success:function(info){
                                $("#cmbCurso").removeAttr('disabled');
                                $("#cmbCurso").html(info);
                            }
                        });
                    }
                });
            });
            
            function generar_acta(){
                var cur = $("#cmbCurso").find(":selected").val();
                var mat = $("#cmbMateria").find(":selected").val();
                var tri = $("#cmbTrimestre").find(":selected").val();
                var anl = $("#cmbAnioLectivo").find(":selected").val();
                
                if(mat==0){
                    alert("Debe elegir una materia");
                }
                else{
                    if(cur==0){
                        alert("Debe elegir un curso");
                    }
                    else{
                        $.ajax({
                            type:"post",
                            url: "<?=site_url("acta_calificaciones/generar_acta")?>",
                            data:"cur="+cur+"&mat="+mat+"&tri="+tri+"&anl="+anl,
                            success:function(info){
                                if(info=="1"){
                                    $('#error').modal();
                                }else{
                                    if(info=="2"){
                                    $('#warning').modal();
                                    }else{
                                        $("#cmbMateria").attr('disabled', 'disabled');
                                        $("#cmbCurso").attr('disabled', 'disabled');
                                        $("#cmbTrimestre").attr('disabled', 'disabled');
                                        $("#btnGenerar").attr('href', 'javascript:disable');
                                        $("#btnGenerar").attr('disabled', 'disabled');
                                        $("#btnConsultar").attr('href', 'javascript:disable');
                                        $("#btnConsultar").attr('disabled', 'disabled');
                                        $("#listadoAlumnos").html(info);
                                    }
                                }
                            }
                        })     
                    }
                }
            }; 
            
            function consultar_acta(){
                var cur = $("#cmbCurso").find(":selected").val();
                var mat = $("#cmbMateria").find(":selected").val();
                var tri = $("#cmbTrimestre").find(":selected").val();
                var anl = $("#cmbAnioLectivo").find(":selected").val();
                
                if(mat==0){
                    alert("Debe elegir una materia");
                }
                else{
                    if(cur==0){
                        alert("Debe elegir un curso");
                    }
                    else{
                        $.ajax({
                            type:"post",
                            url: "<?=site_url("acta_calificaciones/consultar_acta")?>",
                            data:"cur="+cur+"&mat="+mat+"&tri="+tri+"&anl="+anl,
                            success:function(info){
                                if(info=="1"){
                                    $('#error').modal();
                                }else{
                                    if(info=="2"){
                                        $('#warning2').modal();
                                    }else{
                                        $("#cmbMateria").attr('disabled', 'disabled');
                                        $("#cmbAnioLectivo").attr('disabled','disabled');
                                        $("#cmbCurso").attr('disabled', 'disabled');
                                        $("#cmbTrimestre").attr('disabled', 'disabled');
                                        $("#btnGenerar").attr('href', 'javascript:disable');
                                        $("#btnGenerar").attr('disabled', 'disabled');
                                        $("#btnConsultar").attr('href', 'javascript:disable');
                                        $("#btnConsultar").attr('disabled', 'disabled');
                                        $("#listadoAlumnos").html(info);
                                    }
                                }
                            }
                        })       
                    }
                }
            };              
        
            function cancelar(){
                $("#cmbMateria").removeAttr('disabled');
                $("#cmbCurso").removeAttr('disabled');
                $("#cmbTrimestre").removeAttr('disabled');
                $("#cmbAnioLectivo").removeAttr('disabled');
                $("#btnGenerar").attr('href', 'javascript:generar_acta()');
                $("#btnGenerar").removeAttr('disabled', 'disabled');
                $("#btnConsultar").attr('href', 'javascript:consultar_acta()');
                $("#btnConsultar").removeAttr('disabled', 'disabled');
                        
                $("#listadoAlumnos").html(""); 
            };
        </script>
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
        <form class="form-horizontal">
            <fieldset>
                <legend>Acta de Calificaciones</legend>
                <div class="panel span9" style="width:900px; margin-left:100px; padding:20px 0 20px 0;">
                    <div class="control-group span6">
                        <label class="control-label"><b>Materia*</b></label>
                        <div class="controls">
                            <?php 
                                $js = "id='cmbMateria' style='width:300px'";
                                echo form_dropdown("cmbMateria",$materia, null, $js);
                            ?>
                        </div>
                        
                        <label class="control-label" style="margin-top: 10px;"><b>Curso *</b></label>
                        <div class="controls" style="margin-top: 10px;">
                            <select style="width:300px" id="cmbCurso" name="cmbCurso" disabled="disabled"></select>
                        </div>
                    </div>
                    
                    <div class="control-group span2">
                        <label class="control-label"><b>A&ntilde;o Lect&iacute;vo</b></label>
                        <div class="controls">
                            <?php 
                                $js = "id='cmbAnioLectivo' style='width:130px;'";
                                echo form_dropdown("cmbAnioLectivo",$per_lectivos, $anio_lectivo, $js);
                            ?>
                        </div>
                        
                        <label class="control-label" style="margin-top: 5px;"><b>Trimestre</b></label>
                        <div class="controls" style="margin-top: 5px;">
                            <?php 
                                $js = "id='cmbTrimestre' style='width:130px'";
                                echo form_dropdown("cmbTrimestre",$trimestre, null, $js);
                            ?>
                        </div>
                    </div>
                    <div class="control-group" style="clear:both;margin-left:250px;" >
                        <a href="javascript:consultar_acta()" id="btnConsultar" class="btn" style="width:120px;margin-top:10px;" ><i class="icon-search"></i>Consultar</a>
                        <a href="javascript:generar_acta()" id="btnGenerar" class="btn btn-primary" style="width: 120px; margin:10px 0 0 80px;" ><i class="icon-calendar"></i>Generar Acta</a>
                   </div>
                </div>
                <div class="span3" style="margin-left:50px;">
                    <div class="well sidebar-nav">
                        <ul class="nav nav-list">
                          <li class="nav-header">Ayuda<i class="icon-question-sign" style="float: right;"></i></li>
                          <li><a>En esta secci&oacute;n podr&aacute; <b>ingresar, consultar y modificar</b> las actas de calificaciones del per&iacute;odo actual.</a></li>
                        </ul>
                    </div><!--/.well -->
                </div><!--/span-->                         
            </fieldset>
        </form>
        <div id="listadoAlumnos" style="width: 1100px; margin: 0 auto;"><?=$mensaje?></div>
        
        <hr>

        <footer>
            <h6>Realizado por Sedita &nbsp;&nbsp; - &nbsp;&nbsp; &copy; Company 2012</h6>
        </footer>
    </body>
    
</html>
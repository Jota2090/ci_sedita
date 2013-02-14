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
            function visualizar_libretas(){
                var cur = $("#cmbCurso").find(":selected").val();
                var tri = $("#cmbTrimestre").find(":selected").val();
                var anl = $("#cmbAnioLectivo").find(":selected").val();
                
                if(cur == 0){
                    alert("Debe elegir un curso");
                }
                else{
                    $("#cmbCurso").attr('disabled', 'disabled');
                    $("#cmbTrimestre").attr('disabled', 'disabled');
                    $("#cmbAnioLectivo").attr('disabled', 'disabled');
                    $("#btnVisualizar").attr('href', 'javascript:disable');
                    $("#btnVisualizar").attr('disabled', 'disabled');
                    
                    $.ajax({
                        type:"post",
                        url: "<?=site_url("alumno_profesor/alu_list")?>",
                        data:"cur="+cur+"&tri="+tri+"&anl="+anl,
                        success:function(info){
                            $("#alumnos").html(info);
                        }
                    });
                }
            };            
        
            function cancelar(){
                $("#alumnos").html(""); 
                $("#libretas").html("");
                
                $("#cmbCurso").removeAttr('disabled');
                $("#cmbTrimestre").removeAttr('disabled');
                $("#cmbAnioLectivo").removeAttr('disabled');
                $("#btnVisualizar").attr('href', 'javascript:visualizar_libretas()');
                $("#btnVisualizar").removeAttr('disabled');
            };
        </script>
    </head>
    
    <body data-spy="scroll" data-target=".bs-docs-sidebar">
        <?=$menu?>
        <form class="form-horizontal">
            <fieldset>
                <legend>Libretas</legend>
                <div class="panel span9" style="width:900px; margin-left:100px; padding:20px 0 20px 0;">
                    <div class="control-group span7">
                        <label class="control-label"><b>Curso *</b></label>
                        <div class="controls">
                            <?php 
                                $js = "id='cmbCurso' style='width:310px;'";
                                echo form_dropdown("cmbCurso",$curso, null, $js);
                            ?>
                        </div>
                        
                        <label class="control-label" style="margin-top: 5px;"><b>A&ntilde;o Lect&iacute;vo</b></label>
                        <div class="controls" style="margin-top: 5px;">
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
                    
                    <div class="control-group span2">
                        <a href="javascript:visualizar_libretas()" id="btnVisualizar" class="btn btn-primary" style="width: 130px;margin-top:35px;" ><i class="icon-search"></i>Ver Libretas</a>
                    </div>
                </div>
                <div class="span3" style="margin-left:50px;">
                    <div class="well sidebar-nav">
                        <ul class="nav nav-list">
                          <li class="nav-header">Ayuda<i class="icon-question-sign" style="float: right;"></i></li>
                          <li><a>En esta secci&oacute;n podr&aacute; <b>consultar las libretas de un respectivo curso y agregar faltas u observaciones</b> correspondiente a cada estudiante.<br />
                                Adem&aacute;s podr&aacute; mandar a <b>imprimir las libretas.</b></a></li>
                        </ul>
                    </div><!--/.well -->
                </div><!--/span-->                       
            </fieldset>
        </form>
        <div id="mensaje"></div>
        <div id="alumnos"  style="width: 1100px; margin: 0 auto;"></div>
        <div id="libretas" style="width: 1100px; margin: 0 auto;">
            <?=$mensaje?>
        </div>
        <div id="faltas" title="Agregar Faltas"></div>
        <div id="observaciones" title="Agregar Observacion"></div>
        <hr>

        <footer>
            <h6>Realizado por Sedita &nbsp;&nbsp; - &nbsp;&nbsp; &copy; Company 2012</h6>
        </footer>
    </body>
    
</html>
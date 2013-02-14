<!DOCTYPE html>
<html>
    <head>
    	<meta charset="utf-8" />
        <title>Sedita Alumnos</title>
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
        <link rel="stylesheet" href="http://code.jquery.com/ui/1.10.0/themes/base/jquery-ui.css" />

        <script src="assets/js/jquery-bootstrap.js"></script>
        <script src="assets/js/bootstrap-alert.js"></script>
        <script src="assets/js/bootstrap-modal.js"></script>
        <script src="assets/js/bootstrap-dropdown.js"></script>
        <script src="js/jquery-1.8.3.min.js"></script>
        <script src="js/jquery-ui.js"></script>
        
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
                        $("#cmbAlumno").empty();
                        $("#cmbAlumno").attr('disabled', 'disabled');
                    }
                    else{
                        $.ajax({
                            type:"post",
                            url: "<?=site_url("acta_calificaciones/cargar_curso")?>",
                            data:"mat="+mat,
                            success:function(info){
                                $("#cmbCurso").removeAttr('disabled');
                                $("#cmbCurso").html(info);
                                $("#cmbAlumno").empty();
                                $("#cmbAlumno").attr('disabled', 'disabled');
                            }
                        });
                    }
                });
            });
            
            
            $(document).ready(function(){
                $("#cmbCurso").change(function(){
                    var cur = $("#cmbCurso").find(":selected").val();
                    var anl = $("#cmbAnioLectivo").find(":selected").val();
                    
                    if(cur == 0){
                        $("#cmbAlumno").empty();
                        $("#cmbAlumno").attr('disabled', 'disabled');
                    }
                    else{
                        $.ajax({
                            type:"post",
                            url: "<?=site_url("alumno_profesor/listar_alumnos")?>",
                            data:"cur="+cur+"&anl="+anl,
                            success:function(info){
                                $("#cmbAlumno").removeAttr('disabled');
                                $("#cmbAlumno").html(info);
                            }
                        });
                    }
                });
            });
            
            $(document).ready(function(){
                $("#cmbAnioLectivo").change(function(){
                    var mat = $("#cmbMateria").find(":selected").val();
                    var cur = $("#cmbCurso").find(":selected").val();
                    var anl = $("#cmbAnioLectivo").find(":selected").val();
                    
                    if(mat>0){
                        if(cur>0){
                            $.ajax({
                                type:"post",
                                url: "<?=site_url("alumno_profesor/listar_alumnos")?>",
                                data:"cur="+cur+"&anl="+anl,
                                success:function(info){
                                    $("#cmbAlumno").removeAttr('disabled');
                                    $("#cmbAlumno").html(info);
                                }
                            });
                                                    
                        }
                    }
                })
            });
            
            
            function imprimir(){
                var chk = $("input[name=chkRep]:checked").val(); 
                var curso = $("#cmbCurso").find(":selected").text();
                var c = $("#cmbCurso").find(":selected").val();
                var anl = $("#cmbAnioLectivo").find(":selected").val();
                
                if(chk>0){
                    if(c>0){
                        var frm = document.getElementById("forma");
                        frm.cur.value = c;
                        frm.curtxt.value = curso;
                        frm.anio.value = anl;
                        document.forma.submit();
                    }else{
                        alert("No ha elegido un curso");
                    }
                }else{
                    alert("No ha escojigo ninguna opci&oacute;n");
                }
            };
            
            
            $(document).ready(function() {
                $( "#detalle" ).dialog({
                    autoOpen: false,
                    height: 480,
                    width: 500,
                    modal: true,
                    buttons: {
                        Salir: function() {
                            $( this ).dialog( "close" );
                        }
                    },
                    close: function() {
                    }
                });
                
                $( "#add-detalle" ).button().click(function() {
                    var alu = $("#cmbAlumno").find(":selected").val();
                    var mat = $("#cmbMateria").find(":selected").val();
                    var cur = $("#cmbCurso").find(":selected").val();
                    
                    if(mat==0){
                        alert("Debe elegir una materia");
                    }
                    else{
                        if(cur==0){
                            alert("Debe elegir un curso");
                        }
                        else{
                            $.ajax({
                                type: 'post',
                                url:"<?=site_url("alumno_profesor/detalle_alumno")?>",
                                data: "alu="+alu,
                                success: function(data){
                                    $("#detalle").empty();
                                    $("#detalle").html(data);
                                    $("#detalle").dialog( "open" );
                                }                        
                             })
                        }
                    }            
                });
            });
        </script>
    </head>
    
    <body data-spy="scroll" data-target=".bs-docs-sidebar">
        <?=$menu?>
        <form target="_blank" id="forma" name="forma" action="<?=site_url("alumno_profesor/imp_rep")?>" method="post" >
            <input type="hidden" id="cur" name="cur" />
            <input type="hidden" id="curtxt" name="curtxt" />
            <input type="hidden" id="anio" name="anio" />
        </form>
        <div class="form-horizontal">
            <fieldset>
                <legend>Alumnos</legend>
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
                        
                        <label class="control-label" style="margin-top: 10px;"><b>Alumnos *</b></label>
                        <div class="controls" style="margin-top: 10px;">
                            <select style="width:300px" id="cmbAlumno" name="cmbAlumno" disabled="disabled"></select>
                        </div>
                    </div>
                    <div class="control-group span2">
                        <label class="control-label"><b>A&ntilde;o Lect&iacute;vo</b></label>
                        <div class="controls">
                            <?php 
                                $js = "id='cmbAnioLectivo' style='width:130px'";
                                echo form_dropdown("cmbAnioLectivo",$per_lectivos, $anio_lectivo, $js);
                            ?>
                        </div>
                        <div id="detalle" title="Detalle Alumno"></div>
                        <button style="margin:45px 0 0 100px;height:35px;width:150px;font-size:12px;" type="btn" id="add-detalle"><i class="icon-search"></i>Ver Detalle</button>
            
                    </div>
                    <div class="control-group" style="clear:both;margin-left:250px;" >
                        <label class="checkbox" style="margin-top: 40px;float:left;">
                            <input id="chkRep"  name="chkRep" type="checkbox" value="1" /> <b>Listar Representante</b>
                        </label>
                        
                        <a href="javascript:imprimir()" class="btn btn-primary" style="float:left;width: 120px; margin:30px 0 0 100px;" ><i class="icon-calendar"></i>Imprimir</a>
                   </div>
                </div>
                <div class="span3" style="margin-left:50px;">
                    <div class="well sidebar-nav">
                        <ul class="nav nav-list">
                          <li class="nav-header">Ayuda<i class="icon-question-sign" style="float: right;"></i></li>
                          <li><a>En esta secci&oacute;n podr&aacute; <b>consultar los datos personales de los alumnos y listar los nombres de los representantes</b>.</a></li>
                        </ul>
                    </div><!--/.well -->
                </div>
            </fieldset>
        </div>
        
        <hr>

        <footer>
            <h6>Realizado por Sedita &nbsp;&nbsp; - &nbsp;&nbsp; &copy; Company 2012</h6>
        </footer>
        
    </body>
</html>
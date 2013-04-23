<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <title>Sedita Cobros</title>
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
                var cmbAlu=document.getElementById("cmbAlumnos");

                cmbAlu.disabled=true;
                cmbCurso.disabled=true;
                cmbEspec.disabled=true;
                cmbParal.disabled=true; 
                $("#cat").attr('value','');
                $("#cmbCurso").empty();
                $("#cmbEspec").empty();
                $("#cmbParalelo").empty();
                $("#cobros").empty();
                $("#pagos").empty();
                $("#cmbAlumnos").empty();

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
                var cmbAlu=document.getElementById("cmbAlumnos");

                cmbAlu.disabled=true;
                cmbEspec.disabled=true;
                cmbParal.disabled=true;
                $("#cat").attr('value','');
                $("#cmbEspec").empty();
                $("#cmbParalelo").empty();
                $("#cobros").empty();
                $("#pagos").empty();
                $("#cmbAlumnos").empty();

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
                var cmbAlu=document.getElementById("cmbAlumnos");

                cmbAlu.disabled=true;
                $("#cat").attr('value','');
                $("#cobros").empty();
                $("#pagos").empty();
                $("#cmbAlumnos").empty();
                
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
                var cmbAlu=document.getElementById("cmbAlumnos");
                
                cmbAlu.disabled=true;
                $("#cat").attr('value','');
                $("#cobros").empty();
                $("#pagos").empty();
                $("#cmbAlumnos").empty();
                
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
            $("#cmbParalelo").change(function(){
                var jor = $("#cmbJornada").find(":selected").val();
                var cur = $("#cmbCurso").find(":selected").val();
                var esp = $("#cmbEspec").find(":selected").val();
                var par = $("#cmbParalelo").find(":selected").val();
                var anl = $("#cmbAnioLec").find(":selected").val();
                
                $("#cobros").empty();
                $("#pagos").empty();
                $("#cat").attr('value','');
                
                if(par==0){
                    $("#cmbAlumnos").removeAttr('disabled');
                    $("#cmbAlumnos").empty();
                    $("#cmbAlumnos").html("<option>No hay datos para mostrar</option>");
                }
                else{
                    $.ajax({
                        type:"post",
                        url: "<?=site_url("general/listar_alumnos")?>",
                        data:"jor="+jor+"&cur="+cur+"&esp="+esp+"&par="+par+"&anl="+anl,
                        success:function(info){
                            $("#cmbAlumnos").empty();
                            $("#cmbAlumnos").removeAttr('disabled');
                            $("#cmbAlumnos").html(info);
                        }
                    });
                }
            });
        });
        
        
        $(document).ready(function(){
            $("#cmbAlumnos").change(function(){
                var alu = $("#cmbAlumnos").find(":selected").val();
                
                if(alu>0 && alu!=null){
                    $.ajax({
                        type:"post",
                        url: "<?=site_url("facturacion/cat_alumno")?>",
                        data:"alu="+alu,
                        success:function(info){
                            $("#cat").empty();
                            $("#cat").attr('value',info);
                        }
                    });
                    
                    $.ajax({
                        type:"post",
                        url: "<?=site_url("facturacion/cobros_pagos")?>",
                        data:"alu="+alu+"&ind=1",
                        success:function(info){
                            $("#cobros").empty();
                            $("#cobros").html(info);
                        }
                    });

                    $.ajax({
                        type:"post",
                        url: "<?=site_url("facturacion/cobros_pagos")?>",
                        data:"alu="+alu+"&ind=0",
                        success:function(info){
                            $("#pagos").empty();
                            $("#pagos").html(info);
                        }
                    });
                }
            });
        });
        
        
        $(document).ready(function(){
            $("#cmbAnioLec").change(function(){
                var jor = $("#cmbJornada").find(":selected").val();
                var cur = $("#cmbCurso").find(":selected").val();
                var esp = $("#cmbEspec").find(":selected").val();
                var par = $("#cmbParalelo").find(":selected").val();
                var anl = $("#cmbAnioLec").find(":selected").val();
                var cmbAlu=document.getElementById("cmbAlumnos");

                cmbAlu.disabled=true;
                $("#cmbAlumnos").empty();
                $("#cobros").empty();
                $("#pagos").empty();
                $("#cat").attr('value','');
                
                if(par>0&&par!=null){
                    $.ajax({
                        type:"post",
                        url: "<?=site_url("general/listar_alumnos")?>",
                        data:"jor="+jor+"&cur="+cur+"&esp="+esp+"&par="+par+"&anl="+anl,
                        success:function(info){
                            $("#cmbAlumnos").empty();
                            $("#cmbAlumnos").removeAttr('disabled');
                            $("#cmbAlumnos").html(info);
                        }
                    });
                }
            });
        });
        
        
        $(function(){
            $("#selectall").click(function () {
                  $('.case').attr('checked', this.checked);
            });

            $(".case").click(function(){
                if($(".case").length == $(".case:checked").length) {
                    $("#selectall").attr("checked", "checked");
                } else {
                    $("#selectall").removeAttr("checked");
                }

            });
        });
    </script>
  </head>

  <body data-spy="scroll" data-target=".bs-docs-sidebar">
    <?=$menu?>
    <div class="container-fluid">
      <div class="row-fluid">
        <div class="span3">
            <div class="well sidebar-nav" style="width:300px;">
                <ul class="nav nav-list">
                  <li class="nav-header">Mensualidades</li>
                  <li class="active"><a href="<?=site_url("facturacion/cobros")?>">Cobros Y Estados de Cuenta</a></li>
                  <br />
                  <li class="nav-header">Reportes</li>
                  <li><a href="<?=site_url("facturacion/pagos_detalles")?>">Pagos en Detalle</a></li>
                  <li><a href="<?=site_url("facturacion/pagos_descripcion")?>">Pagos por Descripci&oacute;n</a></li>
                  <li><a href="<?=site_url("facturacion/pagos_curso")?>">Pagos por Curso</a></li>
                  <li><a href="<?=site_url("facturacion/pagos_general")?>">Pagos General</a></li>
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
                <form target="_blank" style="padding-right: 100px;" id="forma" name="forma" class="form-horizontal" action="<?=site_url("listados/imp_hoja_matricula")?>" method="post" >
                   <input type="hidden" id="indicador" name="indicador" />
                   <fieldset>
                       <legend>Cobro de Mensualidades</legend>
                        <div class="control-group span5" style="width:420px;float:left;">
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
                            
                            <label class="control-label" style="margin-top: 5px;" ><b>A&ntilde;o Lect&iacute;vo</b></label>
                            <div class="controls" style="margin-top: 5px;">
                                <?php 
                                    $js = 'id="cmbAnioLec" style="width:130px"';
                                    echo form_dropdown("cmbAnioLec",$anioLect, $anlId, $js);
                                ?>
                            </div>
                            
                            <label class="control-label" style="margin-top: 30px;" ><b>Categor&iacute;a:</b></label>
                            <div class="controls" style="margin-top: 30px;">
                                <input style="height:30px" disabled="disabled" id="cat" name="cat" type="text" />
                            </div>
                            <div class="panel span5" style="width:420px; padding:15px; margin-top: 10px;">
                                <div>
                                    <b>Por Cobrar</b>
                                </div>
                                <div id="cobros" style="margin-top:10px">
                                    <table class="table-bordered">
                                        <tr>
                                            <th>CONCEPTOS</th>
                                        </tr>
                                        <tr>
                                            <td>No hay Datos que Presentar</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                        
                        <div class="control-group" style="width:350px;float:left; padding: 10px" >
                            <div>
                                <b>Alumnos *</b>
                                 <!--<input style="margin-left:50px" type="checkbox"> Todos-->
                            </div>
                            <div>
                                <select disabled="disabled" size="9" style="width:350px"  id="cmbAlumnos" name="cmbAlumnos"></select>
                            </div>
                        </div>
                       
                       <div class="control-group panel span4" style="margin-top:55px;width:350px;float:left; padding: 15px" >
                            <div><b>Pagado</b></div>
                            <div id="pagos" style="margin-top:10px">
                                <table class="table-bordered">
                                    <tr>
                                        <th>CONCEPTOS</th>
                                    </tr>
                                    <tr>
                                        <td>No hay Datos para Presentar</td>
                                    </tr>
                                </table>
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

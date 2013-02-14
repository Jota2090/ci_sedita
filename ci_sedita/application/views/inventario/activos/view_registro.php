<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es" lang="es">
<html>
    <head>
    
    	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
        <title>Sedita Registro Uniforme</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta name="description" content="" />
        <meta name="Sedita" content="" />
        
        <base href="<?=site_url()?>" />
        <!--Errores en input--!>
           <link rel="stylesheet" type="text/css" href="css/jquery-easyui-1.3/validation.css"/>
	       <script type="text/javascript" src="js/jquery-easyui-1.3/jquery-1.7.2.min.js"></script>
	       <script type="text/javascript" src="js/jquery-easyui-1.3/jquery.easyui.min.js"></script>
        <!--Fin Alertas--!>
        
        <link href="assets/css/bootstrap.css" rel="stylesheet" />
        <link href="assets/css/bootstrap.min.css" rel="stylesheet"/>
        
        <link href="assets/grocery_crud/themes/datatables/css/ui/simple/jquery-ui-1.8.10.custom.css" rel="stylesheet" />

        <link rel="shortcut icon" href="assets/ico/favicon.ico"/>
        <link rel="apple-touch-icon-precomposed" sizes="144x144" href="assets/ico/apple-touch-icon-144-precomposed.png" />
        <link rel="apple-touch-icon-precomposed" sizes="114x114" href="assets/ico/apple-touch-icon-114-precomposed.png" />
        <link rel="apple-touch-icon-precomposed" sizes="72x72" href="assets/ico/apple-touch-icon-72-precomposed.png" />
        <link rel="apple-touch-icon-precomposed" href="assets/ico/apple-touch-icon-57-precomposed.png" />
        
        <script src="assets/js/jquery-bootstrap.js"></script>
        <script src="assets/js/bootstrap-alert.js"></script>
        <script src="assets/js/bootstrap-modal.js"></script>
        <script src="assets/js/bootstrap-dropdown.js"></script>              
      
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
            function validarSoloLetras(e) 
            { // 1
                tecla = (document.all) ? e.keyCode : e.which; // 2
                if (tecla==8) return true; // 3
                patron =/[A-Za-z\s\xf1\xd1\xe1\xe9\xed\xf3\xfa\xc1\xc9\xcd\xd3\xda\xfc\xdc]/; // 4
                te = String.fromCharCode(tecla); // 5
                return patron.test(te); // 6
            } 
            
            function validarSoloLetrasNumeros(e) 
            { // 1
                tecla = (document.all) ? e.keyCode : e.which; // 2
                if (tecla==8) return true; // 3
                patron =/[A-Za-z\0-9\-\s\xf1\xd1\xe1\xe9\xed\xf3\xfa\xc1\xc9\xcd\xd3\xda\xfc\xdc]/; // 4
                te = String.fromCharCode(tecla); // 5
                return patron.test(te); // 6
            } 
        
        </script>
        
        <script>
        $(document).ready(function() {
                
                //Tipo
                $( "#nuevoTipoUniforme" ).dialog({
                    autoOpen: false,
                    height: 150,
                    width: 300,
                    modal: true,
                    buttons: {
                        Guardar: function(){
                            var tipo = $('input[name=nuevoTipo]').val();
                            
                            if(tipo == "" || tipo == null){
                                $( this ).dialog( "close" );
                            }
                            else{
                                $.ajax({
                                    type:"post",
                                    url: "<?=site_url("activos/insertar_nuevo_tipo")?>",
                                    data:"tipo="+tipo+"&tipo_id_objeto=3",
                                    success:function(info){ 
                                        window.location.href = '<?=site_url("uniforme/")?>'; 
                                      
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
                
                $( "#add-tipoUniforme" ).button().click(function() {
                    $.ajax({
                        type: 'post',
                        dataType: 'html',
                        url:"<?=site_url("activos/agregar_tipo")?>",
                        success: function(data){
                            $("#nuevoTipoUniforme").empty();
                            $("#nuevoTipoUniforme").append(data);
                            $("#nuevoTipoUniforme").dialog( "open" );
                        }                        
                     })            
                });
                //Fin de Tipo
       
                //Estado
                $( "#nuevoEstadoUniforme" ).dialog({
                    autoOpen: false,
                    height: 150,
                    width: 300,
                    modal: true,
                    buttons: {
                        Guardar: function(){
                            var estado = $('input[name=nuevoEstado]').val();
                            
                            if(estado == "" || estado == null){
                                $( this ).dialog( "close" );
                            }
                            else{
                                $.ajax({
                                    type:"post",
                                    url: "<?=site_url("activos/insertar_nuevo_estado")?>",
                                    data:"estado="+estado+"&tipo_id_objeto=3",
                                    success:function(info){
                                         window.location.href = '<?=site_url("uniforme/")?>'; 
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
                
                 $( "#add-estadoUniforme" ).button().click(function() {
                    $.ajax({
                        type: 'post',
                        dataType: 'html',
                        url:"<?=site_url("activos/agregar_estado")?>",
                        success: function(data){
                            $("#nuevoEstadoUniforme").empty();
                            $("#nuevoEstadoUniforme").append(data);
                            $("#nuevoEstadoUniforme").dialog( "open" );
                        }                        
                     })            
                });       
                 //Fin de Estado
       
                
                //Talla
                $( "#nuevaTallaUniforme" ).dialog({
                    autoOpen: false,
                    height: 150,
                    width: 300,
                    modal: true,
                    buttons: {
                        Guardar: function(){
                            var talla = $('input[name=nuevaTalla]').val();
                            
                            if(talla == "" || talla == null){
                                $( this ).dialog( "close" );
                            }
                            else{
                                $.ajax({
                                    type:"post",
                                    url: "<?=site_url("uniforme/insertar_nueva_talla")?>",
                                    data:"talla="+talla,
                                    success:function(info){ 
                                         window.location.href = '<?=site_url("uniforme/")?>'; 
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
                
                $( "#add-tallaUniforme" ).button().click(function() {
                    $.ajax({
                        type: 'post',
                        dataType: 'html',
                        url:"<?=site_url("uniforme/agregar_talla")?>",
                        success: function(data){
                            $("#nuevaTallaUniforme").empty();
                            $("#nuevaTallaUniforme").append(data);
                            $("#nuevaTallaUniforme").dialog( "open" );
                        }                        
                     })            
                });
                //Fin Talla
 
            });
        </script>
        
         <script>
        function limpiarForm()
        {
             document.getElementById('txtCodInv').value="";
             document.getElementById('txtComentariosUniforme').value=""; 
             document.getElementById("txtCodInv").focus();          
        }
        
        </script>

    <script language="javascript" src="js/getElementsByClassName-1.0.1.js"></script>
     <script language="javascript">
        $(document).ready(function() {
            document.getElementById("txtCodInv").focus();
            $('#formUniforme').submit(function() {
                elementosClassInvalid=getElementsByClassName("validatebox-invalid");
                numElemenInvalid=elementosClassInvalid.length;
                
                
                            //alert(numElemenInvalid);
                            
                if(numElemenInvalid==0)
                {
                
                        $.ajax({
                            type: 'POST',
                            url: $(this).attr('action'),
                            data: $(this).serialize(),
                            success: function(data) {
                                if(data==1)
                                {
                                   
                                    $('#uniformeGuardado').modal();
                                    $('#uniformeGuardado').on('hidden', function () {
                                            $.ajax({
                                                    type: 'post',
                                                    url:"<?=site_url("uniforme/actualizar_UltimoCod")?>",
                                                    success: function(info){
                                                        
                                                        document.getElementById("txtUltCodInv").value=info;
                                                                                                       
                                                        
                                                    }                        
                                            })    
                                        
                                        
                                            limpiarForm(); 
                                    })
                                    
                                                             
                                      
                                    
                                    
                                }
                                else
                                {
                                        $('#errorUniformeRepet').modal();
                                        $('#errorUniformeRepet').on('hidden', function () {    
                                            limpiarForm(); 
                                        })
                                                             
                                    
                                }
                                
                
                            }
                        })
                }
                 else
                 {
                    $('#errorDatosUniforme').modal();  
                 }
                return false;
            }); 
        })  
</script>
    
        
        
    </head>

    <body data-spy="scroll" data-target=".bs-docs-sidebar">
        <div class="modal alert-error" id="errorDatosUniforme" style="display: none;">
            <div class="modal-header">
                <a class="close" data-dismiss="modal">x</a>
                <h3><img src="images/alerta-error.jpg" style="margin-right: 10px;" width="30px" height="30px"/>Atenci&oacute;n!</h3>
            </div>
            <div class="modal-body">
                <p>Los datos ingresados <strong>tienen alg&uacute;n error.</strong> Por favor revise sus datos!</p>
            </div>
        </div>
        
        <div class="modal alert-error" id="errorUniformeRepet" style="display: none;">
            <div class="modal-header">
                <a class="close" data-dismiss="modal">x</a>
                <h3><img src="images/alerta-error.jpg" style="margin-right: 10px;" width="30px" height="30px"/>Atenci&oacute;n!</h3>
            </div>
            <div class="modal-body">
                <p>Este uniforme <strong>ya est&aacute; registrado</strong></p>
            </div>
        </div>
        
        
        <div class="modal alert-success" id="uniformeGuardado" style="display: none;">
            <div class="modal-header">
                <a class="close" data-dismiss="modal">x</a>
                <h3><img src="images/ok.jpg" style="margin-right: 10px;" width="30px" height="30px"/>Atenci&oacute;n!</h3>
            </div>
            <div class="modal-body">
                <p>Los datos del uniforme fueron registrados <strong>exitosamente!</strong></p>
            </div>
        </div>

        <div class="navbar navbar-inverse navbar-fixed-top">
          <div class="navbar-inner">
            <div class="container-fluid">
              <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
              </a>
              <a class="brand" href="<?=site_url("main")?>">Sistema Sedita</a>
              <div class="nav-collapse collapse">
                <p class="navbar-text pull-right">
                    <a href="<?=site_url("login/cerrar")?>" class="navbar-link">Cerrar Sesion</a>
                </p>
                <ul class="nav nav-pills">
                    <li class="dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="">
                            Ingresos
                            <b class="caret"></b>
                        </a>
                        <ul class="dropdown-menu">
                            <li class="dropdown-submenu">
                                <a tabindex="-1" href="<?=site_url("alumno")?>">Alumnos</a>
                                <ul class="dropdown-menu">
                                    <li><a tabindex="-1" href="<?=site_url("alumno")?>">Matriculaci&oacute;n</a></li>
                                    <li><a tabindex="-1" href="<?=site_url("alumno/consultar")?>">Consultar o Actualizar</a></li>
                                </ul>
                            </li>
                            <li class="dropdown-submenu">
                                <a tabindex="-1" href="<?=site_url("personal")?>">Personal</a>
                                <ul class="dropdown-menu">
                                    <li><a tabindex="-1" href="<?=site_url("personal")?>">Registro</a></li>
                                    <li><a tabindex="-1" href="<?=site_url("personal/consultar")?>">Consultar o Actualizar</a></li>
                                    <li><a tabindex="-1" href="<?=site_url("personal/asignacion_cursos")?>">Asignar Curso o Dirigente</a></li>
                                </ul>
                            </li>
                            <li class="dropdown-submenu">
                                <a tabindex="-1" href="<?=site_url("listados/nomina_alumnos")?>">Listados</a>
                                <ul class="dropdown-menu">
                                    <li><a tabindex="-1" href="<?=site_url("listados/nomina_alumnos")?>">N&oacute;mina o Actas de Alumnos</a></li>
        
                                </ul>
                            </li>
                        </ul>
                    </li>
                    <li class="dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="">
                            Calificaciones
                            <b class="caret"></b>
                        </a>
                        <ul class="dropdown-menu">
                            <!--<li><a tabindex="-1" href="=site_url("acta_calificaciones")?>">Actas de Calificaciones</a></li>-->
                            <li class="dropdown-submenu">
                                <a tabindex="-1" href="<?=site_url("libreta")?>">Libretas</a>
                                <ul class="dropdown-menu">
                                    <li><a tabindex="-1" href="<?=site_url("libreta")?>">Consultar o Imprimir</a></li>
                                    <li><a tabindex="-1" href="<?=site_url("listados/cuadro_honor")?>">Cuadro de Honor</a></li>
                                    <li><a tabindex="-1" href="<?=site_url("listados/cuadro_promocion")?>">Cuadro de Promoci&oacute;n</a></li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                    <li class="dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="<?=site_url("mantenimiento/usuarios") ?>">
                            Mantenimiento
                            <b class="caret"></b>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a tabindex="-1" href="<?=site_url("mantenimiento/usuarios") ?>">Usuarios</a></li>
                            <li><a tabindex="-1" href="<?=site_url("mantenimiento/cursos") ?>">Cursos</a></li>
                            <li class="dropdown-submenu">
                                <a tabindex="-1" href="#">Materias</a>
                                <ul class="dropdown-menu">
                                    <li><a tabindex="-1" href="<?=site_url("mantenimiento/nom_mat")?>">Nombres</a></li>
                                    <li><a tabindex="-1" href="<?=site_url("mantenimiento/mat_curso")?>">Materias por Curso</a></li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                    <li><a href="#contact">Ayuda</a></li>
                </ul>
              </div><!--/.nav-collapse -->
            </div>
          </div>
        </div>

         <input style="float: right;" type="button" id="add-tallaUniforme" value="Agregar Talla"/>
        <div id="nuevaTallaUniforme" title="Agregar una nueva talla"></div>
        
        <input style="float: right;" type="button" id="add-estadoUniforme" value="Agregar Estado"/>
        <div id="nuevoEstadoUniforme" title="Agregar un nuevo estado"></div>
        
        <input style="float: right;" type="button" id="add-tipoUniforme" value="Agregar Tipo"/>
        <div id="nuevoTipoUniforme" title="Agregar un nuevo tipo"></div>

        
        <form class="form-horizontal" action="<?=site_url("uniforme/guardar") ?>" method="post" id="formUniforme" name="formUniforme">
            <fieldset>
                <legend>Registrar uniforme</legend>
                <div class="panel span9" style="width:900px; margin-left:100px; padding:20px 0 20px 0;">
                    <div class="control-group span5">
                        <label class="control-label" style="margin-top: 5px;" ><b>Fecha de ingreso</b></label>
                        <div class="controls" style="margin-top: 10px;">
                            <input style="width:120px;" type="text" name="txtFechaIngr" id="txtFechaIngr" disabled="disabled" value="<?php echo date("d/m/Y"); ?>" />
                
                        </div>
                        
                        <label class="control-label" style="margin-top: 10px;"><b>&uacute;ltimo c&oacute;digo de Inventario</b></label>
                        <div class="controls" style="margin-top: 10px;">
                            <?php 
                           
                                    $data = array(
                                                    'name'        => 'txtUltCodInv',
                                                    'id'          => 'txtUltCodInv',
                                                    'value'       =>  $ultimoCodigo,
                                                    'disabled'   => 'disabled',
                                                    'size'        => '50',
                                                    'style'       => 'width:50%; margin-top:10px;',
                                    );
                                    echo form_input($data);
                            ?>                     
                    
                        </div>
                        <br />
                        
                        <label class="control-label" ><b>C&oacute;digo de Inventario</b></label>
                        <div class="controls"  >
                            <input style="width:120px; " type="text" name="txtCodInv" id="txtCodInv" class="easyui-validatebox" data-options="required:true,validType:'length[1,10]'" onkeypress="return validarSoloLetrasNumeros(event)" />
                        </div>
                        
                        <label class="control-label" style="margin-top: 20px;"><b>Comentarios</b></label>
                        <div class="controls" style="margin-top: 20px;" >
                            <textarea style="width: 440px; height: 100px;" name="txtComentariosUniforme" id="txtComentariosUniforme" name="comments" id="comments" > </textarea>
                        </div>
                        
                    </div>
                    
                    <div class="control-group span4">
                        <label class="control-label" style="margin-top: 10px;"><b>Tipo</b></label>
                        <div class="controls" style="margin-top: 10px;">
                             <?php 
                            $js = 'id="cmbTipo" class="validate[required]"';
                            echo form_dropdown("cmbTipo",$tipo_activos, null, $js);
                            ?>
                        </div>
                        
                        <label class="control-label" style="margin-top: 20px;"><b>Estado</b></label>
                        <div class="controls" style="margin-top: 20px;">
                             <?php 
                            $js = 'id="cmbEstado" class="validate[required]"';
                            echo form_dropdown("cmbEstado",$estado_activos, 1, $js);
                            ?>
                        </div>
                        
                        <label class="control-label" style="margin-top: 10px;"><b>Talla</b></label>
                        <div class="controls" style="margin-top: 20px;">
                             <?php 
                            $js = 'id="cmbTalla" class="validate[required]"';
                            echo form_dropdown("cmbTalla",$talla_uniforme, null, $js);
                            ?>
                        </div>
                    </div>
                    
                    <div class="span9" style="margin:30px 0 20px 380px;">
                        <input class="btn btn-primary"  type="submit" name="btnEnviar" id="btnEnviar" value="Enviar" />
                        <input class="btn" type="button" name="btnCancelar" id="btnCancelar" value="Cancelar"  onclick="javascript:limpiarForm()"/>
                    </div> 
                                        
                </div>
                
                <div class="span4" style="width:0px; float:right; margin-left:0px;">
                    <div class="well sidebar-nav" style="width: 240px; margin-left:38px;">
                        <ul class="nav nav-list">
                          <li class="nav-header">Ayuda<i class="icon-question-sign" style="float: right;"></i></li>
                          <li><a>En esta secci&oacute;n podr&aacute; <b>ingresar los datos de los uniformes </b>  que pertenecen a la instituci&oacute;n</a></li>
                          <li><a>Tambi&eacute;n podr&aacute; <b>ingresar un nuevo tipo o estado de un uniforme</b></a></li>
                        
                        
                        </ul>
                    </div><!--/.well -->
                </div><!--/span--> 
          
                
                   
            </fieldset> 
        </form>
        
        <hr>

        <footer>
            <h6>Realizado por Sedita &nbsp;&nbsp; - &nbsp;&nbsp; &copy; Company 2012</h6>
        </footer> 
    
    </body>
</html>
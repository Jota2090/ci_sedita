<!DOCTYPE html>
<html lang="es">
    <head>
    	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
        <title>Sedita Registro Alumno</title>
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
        
        <!--Autocompletar-->
        <link type="text/css" href="assets/grocery_crud/themes/datatables/css/ui/simple/jquery-ui-1.8.10.custom.css" rel="stylesheet" />	
    	<script type="text/javascript" src="<?php echo base_url(); ?>js/jquery-ui-1.8.10.custom.min.js"></script>
    	
        <script type="text/javascript">
    		$(document).ready(function(){
    			$('#txtNombres, #txtApellidos').autocomplete({
    				source:'<?php echo site_url('autocomplete/nombApellidAlumnos'); ?>',
    				select: function(event, ui) {
                         $.ajax({
                            type:"post",
                            url: "<?=site_url("alumno/autocompletar_alumno")?>",
                            data:"alu_matricula="+ui.item.alu_matricula,
                            success:function(info){
                                array=info.split("_");
                                
                                document.getElementById('chkDocument').value = array[0];
                                if(document.getElementById('chkDocument').value == 0)
                                {
                                    document.getElementById("chkDocument").checked=false;
                                }
                                else
                                {
                                    document.getElementById("chkDocument").checked=true;
                                }
                                
                                document.getElementById('groupMatricula').setAttribute("style","margin-top: 10px;visible:inherit;height:30px");                                
                                document.getElementById('txtMatricula').setAttribute("disabled","disabled"); 
                                document.getElementById('txtMatricula').value = array[27];
                                document.getElementById('txtNombres').value = array[1];
                                document.getElementById('txtApellidos').value = array[2];
                                document.getElementById('cmbCategoria').value = array[3];
                                document.getElementById('txtDomicilio').value = array[4];
                                document.getElementById('txtTelef').value = array[5];
                                document.getElementById('cmbPais').value = array[6];
                                document.getElementById('txtLugarNac').value = array[7];
                                
                                $strFechaBase=array[8];
                                arrayFecha= $strFechaBase.split("-");
                                $strFechaAlu=arrayFecha[2]+"/"+arrayFecha[1]+"/"+arrayFecha[0];
                                
                                document.getElementById('dateArrival').value = $strFechaAlu;
                                document.getElementById('txtEdad').value = array[9];
                                
                                if(array[10]== "M")
                                {
                                    document.getElementById("rbSexoM").checked=true;
                                    document.getElementById("rbSexoF").checked=false;
                                }
                                else
                                {
                                    document.getElementById("rbSexoM").checked=false;
                                    document.getElementById("rbSexoF").checked=true;
                                }
                                document.getElementById('txtNombMadre').value = array[11];
                                document.getElementById('txtCedMadre').value = array[28];
                                document.getElementById('txtOcupMadre').value = array[12];
                                document.getElementById('cmbPaisMadre').value = array[13];
                                
                                document.getElementById('txtNombPadre').value = array[14];
                                document.getElementById('txtCedPadre').value = array[29];
                                document.getElementById('txtOcupPadre').value = array[15];
                                document.getElementById('cmbPaisPadre').value = array[16];
                             
                                if(array[17]== "m")
                                {
                                    document.getElementById("rbRepresentM").checked=true;
                                    document.getElementById("rbRepresentP").checked=false;
                                    document.getElementById("rbRepresentO").checked=false;
                                    
                                    document.getElementById("div_otra_persona").style.display = "none";
                                }
                                else if(array[17]== "p")
                                {
                                    document.getElementById("rbRepresentM").checked=false;
                                    document.getElementById("rbRepresentP").checked=true;
                                    document.getElementById("rbRepresentO").checked=false;
                                    document.getElementById("div_otra_persona").style.display = "none";
                                }
                            
                                else{
                                    document.getElementById("rbRepresentM").checked=false;
                                    document.getElementById("rbRepresentP").checked=false;
                                    document.getElementById("rbRepresentO").checked=true;
                                    
                                    document.getElementById("div_otra_persona").style.display = "block";
                                    
                                    document.getElementById('txtNombPerson').value = array[21];
                                    document.getElementById('txtCedPerson').value = array[30];
                                    document.getElementById('txtOcupPerson').value = array[22];
                                    document.getElementById('txtTelefPerson').value = array[23];
                                    document.getElementById('txtDomicilioPerson').value = array[24];
                                    document.getElementById('cmbPaisPerson').value = array[25];
                                }
                            
                            document.getElementById('txtComentarios').value = array[18];
                        }
                   });
                   
    				}
    			});
    		});
    	</script>   
         <!--Fin de Autocompletar-->
        
        <!--Calendario-->
        <link type="text/css" rel="stylesheet" href="css/calendar/dhtmlgoodies_calendar.css?random=20051112" media="screen"/>
	    <script type="text/javascript" src="js/calendar/dhtmlgoodies_calendar.js?random=20060118"></script>
        <!--Fin de calendario-->

        <script type="text/javascript">
            function validarSoloLetras(e) 
            {
                tecla = (document.all) ? e.keyCode : e.which;
                if (tecla==8) return true;
                else if (tecla==0||tecla==9)  return true;
                patron =/[A-Za-z\s\xf1\xd1\xe1\xe9\xed\xf3\xfa\xc1\xc9\xcd\xd3\xda\xfc\xdc]/;
                te = String.fromCharCode(tecla);
                return patron.test(te);
            } 
            
            function validarSoloNumeros(e) 
            {
                                
                tecla = (document.all) ? e.keyCode : e.which;
                if (tecla==8) return true;
                else if (tecla==0||tecla==9)  return true;
                patron =/[0-9\\]/;
                te = String.fromCharCode(tecla);
                return patron.test(te);
            } 
        </script>
        
        <!--Combos-->
        <script>
            $(document).ready(function(){
                $("#cmbCategoria").attr('disabled', 'disabled');
                $("#cmbPais").attr('disabled', 'disabled');
                $("#cmbPaisMadre").attr('disabled', 'disabled');
                $("#cmbPaisPadre").attr('disabled', 'disabled');
                $("#cmbPaisPerson").attr('disabled', 'disabled');
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
                $("#cmbParalelo").change(function(){
                    var idJornada= $("#cmbJornada").find(":selected").val();
                    var idCurso= $("#cmbCurso").find(":selected").val();
                    var idParal= $("#cmbParalelo").find(":selected").val();
                    var idEspec= $("#cmbEspec").find(":selected").val();
                    var anl = $("#cmbAnioLectivo").find(":selected").val();
                    
                    //idCurso==12 o 13, 5to y 6to bachillerato
                    if((idCurso==12)||(idCurso==13))
                    {
                        $.ajax({
                            type:"post",
                            url: "<?=site_url("alumno/num_Alumnos")?>",
                            data:"jornada="+idJornada+"&curso="+idCurso+"&espec="+idEspec+"&paral="+idParal+"&anl="+anl,
                            success:function(info){
                                document.getElementById('txtNumAlumn').value =info;
                            
                                if(info>30)
                                {
                                  $('#errorCursoLleno').modal();
                                  window.location.href = "<?php echo site_url('alumno/'); ?>";
                                }
                                else
                                {   
                                    quitarDisable($("#formAlumno"));
                                    $("#btnEnviar").removeAttr('disabled');
                                    $("#btnCancelar").removeAttr('disabled');
                                    document.getElementById("txtNombres").focus();
                                }
                            }
                        });
                    }
                    else
                    {   
                        $.ajax({
                            type:"post",
                            url: "<?=site_url("alumno/num_Alumnos")?>",
                            data:"jornada="+idJornada+"&curso="+idCurso+"&espec=-1"+"&paral="+idParal+"&anl="+anl,
                            success:function(info){
                                document.getElementById('txtNumAlumn').value =info;
                                
                                if(info>30)
                                {
                                    $('#errorCursoLleno').modal(); 
                                    window.location.href = "<?php echo site_url('alumno/'); ?>";
                                }
                                else
                                {
                                    quitarDisable($("#formAlumno"));
                                    $("#btnEnviar").removeAttr('disabled');
                                    $("#btnCancelar").removeAttr('disabled');
                                    document.getElementById("txtNombres").focus();
                                }
                            }
                        });
                    }
                });
            });
        </script>

              
        <!--Quitar atributo disabled de los campos del formulario alumno-->
        <script>
            function quitarDisable(miForm) {
                // recorremos todos los campos que tiene el formulario
                $(':input', miForm).each(function() {
                    var type = this.type;
                    var tag = this.tagName.toLowerCase();
                    
                    //limpiamos los valores de los campos�
                    if (type == 'text' || type == 'password' || tag == 'textarea')
                    {
                        if(this.disabled)
                        {
                            this.disabled=false;
                        }
                        else{
                            this.value = "";
                        }
                    }
                    else if (type == 'checkbox' || type == 'radio')
                    {
                        this.disabled = false;
                    }
                    else if (tag == 'select')
                    {
                       this.disabled = false;
                    }
                });
                
                //$("#txtMatricula").attr('disabled', 'disabled');
                $("#cmbJornada").attr('disabled', 'disabled');
                $("#cmbNivel").attr('disabled', 'disabled');
                $("#cmbCurso").attr('disabled', 'disabled');
                $("#cmbEspec").attr('disabled', 'disabled');
                $("#cmbParalelo").attr('disabled', 'disabled');
                $("#txtNumAlumn").attr('disabled', 'disabled');
                $("#txtEdad").attr('disabled', 'disabled');
                $.ajax({
                    type:"post",
                    url: "<?=site_url("alumno/num_matricula")?>",
                    success:function(info){
                        $("#matricula").html(info);
                    }
                });
            }
        </script>   
        <!--Quitar atributo disabled-->
      
        
        <script>
        function limpiaForm(miForm) {
            // recorremos todos los campos que tiene el formulario
            $(':input', miForm).each(function() {
            var type = this.type;
            var tag = this.tagName.toLowerCase();
                //limpiamos los valores de los campos�
                if (type == 'text' || type == 'password' || tag == 'textarea')
                {
                    if(this.disabled==false)
                    {  
                        this.disabled=true;
                        this.value = "";
                    } 
                }
                
                // excepto de los checkboxes y radios, le quitamos el checked
                // pero su valor no debe ser cambiado
                else if (type == 'checkbox' || type == 'radio')
                {
                    this.checked = false;
                    this.disabled=true;
                }
                
                // los selects le ponesmos el indice a -
                else if (tag == 'select')
                {
                    this.disabled=true;
                }
            });
        }
        </script>
        <!--Fin Setear campos del formulario alumno-->
            
        <script>
            function toggle_otra_persona(elemento) {
                if((elemento.value=="m") || (elemento.value=="p")) {
                    document.getElementById("div_otra_persona").style.display = "none";
                } 
                if(elemento.value=="o") {
                    document.getElementById("div_otra_persona").style.display = "block";
                }
            }
        </script>
        
         <!--Submit-->
        <script language="javascript">
            
                    
            function changeCSSRequire( identificador ){
                if(document.getElementById("txt"+identificador).value==""){
                    document.getElementById("txt"+identificador).setAttribute("required","true");                                
                    document.getElementById("txt"+identificador).setAttribute("style","border-color: #B94A48; float left; width: 200px; box-shadow: 0 1px 1px rgba(0, 0, 0, 0.075) inset;");
                    document.getElementById("lb"+identificador).setAttribute("style","color: #B94A48; float: left; width: 100px; margin-left: 20px;");    
                }
                else changeCSSNoRequire( identificador );
            }
            
            function changeCSSNoRequire( identificador ){
                document.getElementById("txt"+identificador).removeAttribute("required");                
                document.getElementById("txt"+identificador).setAttribute("style","float left; width: 200px;");
                document.getElementById("lb"+identificador).setAttribute("style","float: left; width: 100px; margin-left: 20px;");
            }
            
            
            function requerirRepresentante(){
                changeCSSRequire("Nombres");
                changeCSSRequire("Apellidos");
                changeCSSRequire("Domicilio");
                changeCSSRequire("Telef");
                changeCSSRequire("CedMadre");
                changeCSSRequire("LugarNac");
                                
                if(document.getElementById('rbRepresentM').checked){
                    changeCSSRequire("NombMadre");
                    changeCSSRequire("CedMadre");
                    changeCSSRequire("OcupMadre");
                }
                else{
                    changeCSSNoRequire("NombMadre");
                    changeCSSNoRequire("CedMadre");
                    changeCSSNoRequire("OcupMadre");
                }
                    
                if(document.getElementById('rbRepresentP').checked){
                    changeCSSRequire("NombPadre");
                    changeCSSRequire("CedPadre");
                    changeCSSRequire("OcupPadre");
                }
                else{
                    changeCSSNoRequire("NombPadre");
                    changeCSSNoRequire("CedPadre");
                    changeCSSNoRequire("OcupPadre");
                }    
                if(document.getElementById('rbRepresentO').checked){
                    changeCSSRequire("NombPerson");
                    changeCSSRequire("CedPerson");
                    changeCSSRequire("OcupPerson");
                    changeCSSRequire("DomicilioPerson");
                    changeCSSRequire("TelefPerson");
                }
                else{
                    changeCSSNoRequire("NombPerson");
                    changeCSSNoRequire("CedPerson");
                    changeCSSNoRequire("OcupPerson");
                    changeCSSNoRequire("DomicilioPerson");
                    changeCSSNoRequire("TelefPerson");
                }
            }
            
            $(document).ready(function() {
                                                
                var va = $("#formAlumno").validate({
                    rules:{
                    	txtNombres:{required: true},
                        txtApellidos:{required: true},
                        txtDomicilio:{required: true},
                        txtTelef:{required: true, minlength: 7, maxlength: 10},
                        txtLugarNac:{required: true},
                        txtEdad:{required: true, maxlength: 2},
                        dateArrival:{required: true,date: true},
                        
                        txtCedMadre:{minlength:10,maxlength:10},
                        txtCedPadre:{minlength:10,maxlength:10},
                        txtCedPerson:{minlength:10,maxlength:10},
                        
                    },
                    messages:{
                        txtNombres:{required: ""},
                        txtApellidos:{required: ""},
                        txtDomicilio:{required: ""},
                        txtTelef:{required: "", minlength:"Minimo 7 n&uacute;meros", maxlength:"Maximo 10 n&uacute;meros"},
                        txtLugarNac:{required: ""},
                        txtEdad:{required: "", maxlength:"Maximo 2 n&uacute;meros"},
                        dateArrival:{required: "", date:"<label style='color:#B94A48; margin: -10px -30px;font-size: 16px;'>Fecha no V&aacute;lida</label>"},
                        
                        txtCedMadre:{required:"",minlength:"La c&eacute;dula debe tener m&iacute;nimo 10 n&uacute;meros",maxlength:"La c&eacute;dula debe tener m&aacute;ximo 10 n&uacute;meros"},
                        txtCedPadre:{minlength:"La c&eacute;dula debe tener m&iacute;nimo 10 n&uacute;meros",maxlength:"La c&eacute;dula debe tener m&aacute;ximo 10 n&uacute;meros"},
                        txtCedPerson:{minlength:"La c&eacute;dula debe tener m&iacute;nimo 10 n&uacute;meros",maxlength:"La c&eacute;dula debe tener m&aacute;ximo 10 n&uacute;meros"},
                    },
                    submitHandler: function(){
                        // Interceptamos el evento submit
                        $('#formAlumno').submit(function() {
                            $.ajax({
                                type: 'POST',
                                url: $(this).attr('action'),
                                data: $(this).serialize(),
                                // Mostramos un mensaje con la respuesta de PHP
                                success: function(data) {
                                    if(data==0)
                                    {         
                                        $('#errorAlumnRepCurso').modal(); 
                                        cancelar();
                                    }
                                     else if(data==1)
                                    {
                                        $('#errorAlumnRepOtroCurso').modal();
                                        cancelar();
                                    }                                  
                                    else if(data==2)
                                    {
                                        document.getElementById("divAlumnoGuardado").innerHTML="<strong>Alumno:</strong>"+" "+
                                                                                               document.getElementById("txtNombres").value+
                                                                                               document.getElementById("txtApellidos").value+
                                                                                               "<br/><strong>Matricula:</strong>"+" "+
                                                                                               document.getElementById("txtMatricula").value;
                                                                                               
                                        $('#alumnoGuardado').modal();
                                        cancelar();
                                    }
                                    else if(data==3)
                                    {
                                        $('#errorDatosRepres').modal();
                                    }
                                    else{}
                                }
                            })
                            
                            return false;
                        }); //submit
                    }
                });
            })//del ready
        </script>
        <!--Fin submit-->
      
         <script>
            function formNuevoAlumno()
            {
                var idJornada= $("#cmbJornada").find(":selected").val();
                var idNivel= $("#cmbNivel").find(":selected").val();
                var idCurso= $("#cmbCurso").find(":selected").val();
                var idEspec= $("#cmbEspec").find(":selected").val();
                var idParal= $("#cmbParalelo").find(":selected").val();   
                
                limpiaForm($("#formAlumno"));
                
                document.getElementById("groupMatricula").setAttribute("style","height:0px;visibility:hidden");
                document.getElementById("txtMatricula").value= '000000000';
                document.getElementById('cmbPais').value = 'Ecuador';
                document.getElementById('cmbPaisMadre').value = 'Ecuador';
                document.getElementById('cmbPaisPadre').value = 'Ecuador';
                document.getElementById('cmbPaisPerson').value = 'Ecuador';
                document.getElementById('cmbCategoria').value = '1';
                document.getElementById('rbSexoM').checked=true;
                document.getElementById('rbRepresentM').checked=true;
                document.getElementById("div_otra_persona").style.display = "none";
                
                if(idCurso!=12 && idCurso!=13){
                    $("#cmbEspec").attr('disabled','disabled');
                }
            }
             
             
            function cancelar()
            {   
                var idCurso= $("#cmbCurso").find(":selected").val();
                limpiaForm($("#formAlumno"));
                
                if(idCurso>11 && idCurso<14){
                    $("#cmbEspec").removeAttr('disabled');
                }
                document.getElementById("groupMatricula").setAttribute("style","height:0px;visibility:hidden");
                document.getElementById("txtMatricula").value= '000000000';
                $("#cmbJornada").removeAttr('disabled');
                $("#cmbNivel").removeAttr('disabled');
                $("#cmbCurso").removeAttr('disabled');
                $("#cmbParalelo").removeAttr('disabled');
                $("#btnEnviar").attr('disabled','disabled');
                $("#btnCancelar").attr('disabled','disabled');
                
                document.getElementById('cmbParalelo').selectedIndex=0;
                document.getElementById('rbSexoM').checked=true;
                document.getElementById('rbRepresentM').checked=true;
                document.getElementById("div_otra_persona").style.display = "none";
            }
            function setearEdad()
            {   
                var fecha= document.getElementById('dateArrival').value;
                var edad=2013-fecha.substring(6);
                
                document.getElementById('txtEdad').value= edad;
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
        <div class="modal alert-error" id="errorDatos" style="display: none;">
            <div class="modal-header">
                <a class="close" data-dismiss="modal">x</a>
                <h3><img src="images/alerta-error.jpg" style="margin-right: 10px;" width="30px" height="30px"/>Atenci&oacute;n!</h3>
            </div>
            <div class="modal-body">
                <p>Los datos ingresados <strong>tienen alg&uacute;n error.</strong> Por favor revise sus datos!</p>
            </div>
        </div>
        
        <div class="modal alert-error" id="errorAlumnRepCurso" style="display: none;">
            <div class="modal-header">
                <a class="close" data-dismiss="modal">x</a>
                <h3><img src="images/alerta-error.jpg" style="margin-right: 10px;" width="30px" height="30px"/>Atenci&oacute;n!</h3>
            </div>
            <div class="modal-body">
                <p>Esta alumno <strong>ya est&aacute; registrado</strong> en el curso seleccionado!</p>
            </div>
        </div>
        
        <div class="modal alert-error" id="errorAlumnRepOtroCurso" style="display: none;">
            <div class="modal-header">
                <a class="close" data-dismiss="modal">x</a>
                <h3><img src="images/alerta-error.jpg" style="margin-right: 10px;" width="30px" height="30px"/>Atenci&oacute;n!</h3>
            </div>
            <div class="modal-body">
                <p>Este alumno <strong>ya est&aacute; registrado</strong> en otro curso de la instituci&oacute;n</p>
            </div>
        </div>
        
        <div class="modal alert-error" id="errorCursoLleno" style="display: none;">
            <div class="modal-header">
                <a class="close" data-dismiss="modal">x</a>
                <h3><img src="images/alerta-warning.jpg" style="margin-right: 10px;" width="30px" height="30px"/>Atenci&oacute;n!</h3>
            </div>
            <div class="modal-body">
                <p>No podr&aacute; registrar m&aacute;s alumnos en este curso, debido a que <strong>el curso est&aacute; lleno!</strong></p>
            </div>
        </div>
        
        <div class="modal alert-error" id="errorDatosRepres" style="display: none;">
            <div class="modal-header">
                <a class="close" data-dismiss="modal">x</a>
                <h3><img src="images/alerta-error.jpg" style="margin-right: 10px;" width="30px" height="30px"/>Atenci&oacute;n!</h3>
            </div>
            <div class="modal-body">
                <p>Los datos ingresados del <strong>representante son incorrectos</strong> Por favor revise corr�jalos!</p>
            </div>
        </div>
        
        <div class="modal alert-success" id="alumnoGuardado" style="display: none;">
            <div class="modal-header">
                <a class="close" data-dismiss="modal">x</a>
                <h3><img src="images/ok.jpg" style="margin-right: 10px;" width="30px" height="30px"/>Atenci&oacute;n!</h3>
            </div>
            <div class="modal-body">
                <p>Los datos del alumno fueron registrados <strong>exitosamente!</strong></p>
                
                <div id="divAlumnoGuardado" style="padding: 0px 20px;">                </div>     
                           
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
        
        <form class="form-horizontal" id="formAlumno" name="formAlumno" action="<?=site_url("alumno/guardar") ?>" method="post" >
            <fieldset>
                <legend>Matricular Alumno</legend>
                <div class="span3" style="margin-right: 50px;">
                    <div class="span3 panel" style="width:230px;margin-left:15px;padding:10px 10px 0 20px;">
                        <ul class="nav">
                            <li><b>Jornada</b></li>
                            <li><?php 
                                    $js = 'id="cmbJornada"';
                                    echo form_dropdown("cmbJornada",$jornada, null, $js);
                                ?>
                            </li>
                            <br />
                            <li><b>Nivel</b></li>
                            <li><select id="cmbNivel" name="cmbNivel" disabled="disabled" ></select></li>
                            <br />
                            <li><b>Curso </b></li>
                            <li><select id="cmbCurso" name="cmbCurso" disabled="disabled" ></select></li>
                            <br />
                            <li><b>Especializaci&oacute;n </b></li>
                            <li><select id="cmbEspec" name="cmbEspec" disabled="disabled" ></select></li>
                            <br />
                            <li><b>Paralelo </b></li>
                            <li><select id="cmbParalelo" name="cmbParalelo" disabled="disabled" ></select></li>
                            <br />
                            <li><b>A&ntilde;o Lectivo</b></li>
                            <li>
                                <?php 
                                    $js = "id='cmbAnioLectivo' disabled='disabled' style='width:130px;'";
                                    echo form_dropdown("cmbAnioLectivo",$anLects,null, $js);
                                ?>
                            </li>
                            <br />
                            <li><b>No. de Matriculados</b></li>
                            <li><input type="text" name="txtNumAlumn" id="txtNumAlumn" disabled="disabled" /></li>
                        </ul>
                    </div><!--/span-->
                    <div class="span3" style="margin-left:50px;">
                        <div class="well sidebar-nav">
                            <ul class="nav nav-list">
                              <li class="nav-header">Ayuda<i class="icon-question-sign" style="float: right;"></i></li>
                              <li><a>En esta secci&oacute;n podr&aacute; <b>matricular a un alumno</b> en el plantel, llenando sus datos personales.</a></li>
                            </ul>
                        </div><!--/.well -->
                    </div><!--/span-->
                </div> 
                <div class="span9 panel" style="width:980px;padding:10px 20px 0 0;">
                    <div class="span4" style="padding-right:280px;border-right: 1px solid #000000">
                        
                        <!--<div class="span4" style="margin-top: 10px;">
                            <label class="control-label"><b>No. de Matriculados</b></label>
                            <div class="controls">
                                <input style="width: 60px;" type="text" name="txtNumAlumn" id="txtNumAlumn" disabled="disabled" />
                            </div>
                        </div>--!>
                        <div class="span2" id="groupMatricula" style="display:none">
                            <label class="control-label"><b>Matr&iacute;cula</b></label>
                            <div class="controls" id="divmatricula">
                                <input style="width: 80px;" type="text" name="txtMatricula" id="txtMatricula" disabled="disabled" value="<?=$matricula?>" />
                            </div>
                        </div>
                        <!--<div class="span1" style="margin: 10px 0 0 80px;">
                            <label class="control-label"><b>A&ntilde;o Lectivo</b></label>
                            <div class="controls">
                                <?php 
                                    $js = "id='cmbAnioLectivo' disabled='disabled' style='width:130px;'";
                                    echo form_dropdown("cmbAnioLectivo",$anLects,null, $js);
                                ?>--!>
                                <!--<input style="width: 120px;" type="text" name="txtAnoLectivo" id="txtAnoLectivo" disabled="disabled" />-->
                        <!--    </div>
                        </div>
                        --!>
                        <div class="span2" style="margin-top: 10px;">
                            <label class="control-label" ><b>Con documentaci&oacute;n</b></label>
                            <div class="controls">
                                <input type="checkbox" name="chkDocument" id="chkDocument" value="1" disabled="disabled" />
                            </div>
                        </div>
                        
                        <div class="span1" style="margin: 10px 0 0 80px;">
                            <label class="control-label"><b>Categor&iacute;a</b></label>
                            <div class="controls">
                                <?php 
                                    $js = "id='cmbCategoria' style='width:135px;'";
                                    echo form_dropdown("cmbCategoria",$categoria_alumno, null, $js);
                                ?>
                            </div>
                        </div>
                        
                        <div class="control-group span4" style="margin-top: 15px;">
                            <label class="control-label"><b>Nombres*</b></label>
                            <div class="controls">
                                <input onkeyup="changeCSSRequire('Nombres')" style="width:342px;" type="text" name="txtNombres" id="txtNombres" disabled="disabled" onkeypress="return validarSoloLetras(event)"   />
                            </div>
                        </div>
                        
                        <div class="control-group span4">
                            <label class="control-label"><b>Apellidos*</b></label>
                            <div class="controls">
                                <input onkeyup="changeCSSRequire('Apellidos')" style="width:342px;"  disabled="disabled" type="text" name="txtApellidos" id="txtApellidos"  onkeypress="return validarSoloLetras(event)"  />
                            </div>
                        </div>
                        
                        <div class="control-group span4">
                            <label class="control-label"><b>Direcci&oacute;n*</b></label>
                            <div class="controls">
                                <input onkeyup="changeCSSRequire('Domicilio')" style="width: 342px;" type="text" name="txtDomicilio" id="txtDomicilio" disabled="disabled" />
                            </div>
                        </div>
                        
                        <div class="control-group span2">
                            <label class="control-label"><b>Tel&eacute;fono*</b></label>
                            <div class="controls">
                                <input onkeyup="changeCSSRequire('Telef')" style="width: 120px;" type="text" name="txtTelef" id="txtTelef" disabled="disabled" onkeypress="return validarSoloNumeros(event)"  />
                            </div>
                        </div>
                                                
                        <div class="control-group span1" style="margin-left:80px;">
                            <label class="control-label" ><b>Pa&iacute;s</b></label>
                            <div class="controls">
                                 <?php echo country_dropdown('cmbPais','cmbPais',
                                        array('US','CA','GB','DE','BR','IT','ES','AU','NZ','HK'));?>
                            </div>
                        </div>
                        
                        
                        <div class="control-group span2">
                            <label class="control-label"><b>Lugar de nacimiento*</b></label>
                            <div class="controls">
                                <input onkeyup="changeCSSRequire('LugarNac')" style="width: 120px;" type="text" name="txtLugarNac" id="txtLugarNac" disabled="disabled"  type="text" onkeypress="return validarSoloLetras(event)"  />
                            </div>
                        </div>
                        
                        <div class="control-group span1" style="margin-left:80px;">
                            <label class="control-label" ><b>Edad*</b></label>
                            <div class="controls">
                                <input style="width:50px" type="text" name="txtEdad" id="txtEdad"  disabled="disabled" onkeypress="return validarSoloNumeros(event)"  />
                            </div>
                        </div>
                        
                        <div class="control-group span4" style="margin-bottom: -5px;" >
                            <label class="control-label"><b>Fecha de Nacimiento*</b></label>
                            <div class="controls" style="width:165px;">
                                <a id="linkCalendar" onclick="displayCalendar(document.forms[0].dateArrival,'dd/mm/yyyy',this);" style="float: right;padding: 0 0 10px 165px;">
                                    <i class="icon-calendar" style="float:right;position: relative;" id="calendar"></i>
                                    <input onchange="setearEdad();" placeholder="dd/mm/yyyy" name="dateArrival" id="dateArrival" type="text" disabled="disabled" size="10" style="width: 120px;right: 30px;bottom: 25px;position: relative;" class="easyui-validatebox" data-options="required:true"  />                                                                        
                                </a>
                                
                            </div>
                        </div>
                        
                        <div class="control-group span6">
                            <label class="control-label"><b>Sexo</b></label>
                            <label class="checkbox inline">
                                <input type="radio" name="rbSexo" value="M" id="rbSexoM" disabled="disabled" checked="checked" />Masculino
                            </label>
                            <label class="checkbox inline">
                                <input type="radio" name="rbSexo" value="F"  id="rbSexoF" disabled="disabled" />Femenino
                            </label>
                        </div>
                        <div class="control-group span6">                        
                            <label class="control-label"><b>Representante*</b></label>
                            <label class="checkbox inline">
                                <input onchange="requerirRepresentante();" type="radio"  class="rbRepresent" name="rbRepresent" value="m" onclick="toggle_otra_persona(this)" id="rbRepresentM" checked="checked" disabled="disabled" />Madre
                            </label>
                            <label class="checkbox inline">
                                <input onchange="requerirRepresentante();" type="radio" class="rbRepresent" name="rbRepresent" value="p" onclick="toggle_otra_persona(this)" id="rbRepresentP"  disabled="disabled"/>Padre
                            </label>
                            <label class="checkbox inline">
                                <input onchange="requerirRepresentante();" type="radio" class="rbRepresent" name="rbRepresent" value="o" onclick="toggle_otra_persona(this)" id="rbRepresentO"  disabled="disabled"/>Otra persona
                            </label>                            
                        </div>
                        
                        <div class="span4 panel" style="display:none; width:470px;padding:10px 20px 30px 20px;margin-top:20px" id="div_otra_persona" >
                            <fieldset>
                                <legend>Representante</legend>
                                <div class="control-group">
                                    <label id="lbNombPerson" class="control-label"><b>Nombres*</b></label>
                                    <div class="controls">
                                        <input onkeyup="changeCSSRequire('NombPerson')" type="text" name="txtNombPerson" id="txtNombPerson" disabled="disabled" onkeypress="return validarSoloLetras(event)" />
                                    </div>
                                </div>
                                
                                <div class="control-group">
                                    <label id="lbCedPerson" class="control-label" style="margin-top: 10px;"><b>N. C&eacute;dula</b></label>
                                    <div class="controls" style="margin-top: 10px;">
                                        <input onkeyup="changeCSSRequire('CedPerson')" type="text" name="txtCedPerson" id="txtCedPerson" disabled="disabled" onkeypress="return validarSoloNumeros(event)"  />
                                    </div>
                                </div>
                                
                                <div class="control-group">
                                    <label id="lbOcupPerson" class="control-label" style="margin-top: 10px;"><b>Ocupaci&oacute;n</b></label>
                                    <div class="controls" style="margin-top: 10px;">
                                        <input onkeyup="changeCSSRequire('OcupPerson')" type="text" name="txtOcupPerson" id="txtOcupPerson" disabled="disabled" onkeypress="return validarSoloLetras(event)"  />
                                    </div>
                                </div>
                                
                                <div class="control-group">
                                    <label id="lbDomicilioPerson" class="control-label"><b>Direcci&oacute;n*</b></label>
                                    <div class="controls">
                                        <input onkeyup="changeCSSRequire('DomicilioPerson')" type="text" name="txtDomicilioPerson" id="txtDomicilioPerson" disabled="disabled" />
                                    </div>
                                </div>
                                
                                <div class="control-group">
                                    <label id="lbTelefPerson" class="control-label"><b>Tel&eacute;fono*</b></label>
                                    <div class="controls">
                                        <input onkeyup="changeCSSRequire('TelefPerson')" type="text" name="txtTelefPerson" id="txtTelefPerson"  disabled="disabled" onkeypress="return validarSoloNumeros(event)" />
                                    </div>
                                </div>
                                
                                <label class="control-label" style="margin-top: 20px;"><b>Pa&iacute;s</b></label>
                                <div class="controls" style="margin-top: 20px;">
    
                                    <?php echo country_dropdown('cmbPaisPerson','cmbPaisPerson',
                                array('US','CA','GB','DE','BR','IT','ES','AU','NZ','HK'));?>
                                </div>
                            </fieldset>
                        </div>
                        
                        <div class="span4">
                            <label class="control-label" style="margin-top: 10px;"><b>Comentarios</b></label><br /><br />
                             <textarea style="width: 345px; height: 100px; margin-left: 180px;" name="txtComentarios" id="txtComentarios" disabled="disabled"  name="comments" id="comments"  > </textarea>
                         </div>
                    </div> 
                    <div class="span5" style="padding-bottom:30px; width:340px; margin-left: 30px; border-bottom: 1px solid black;">
                        <fieldset>
                            <legend style="width: 340px;">Madre</legend>
                            <div class="control-group">
                                <label  id="lbNombMadre" style="float:left;width:100px;margin-left:20px;"><b>Nombres*</b></label>
                                <div style="margin-left:10px;">
                                    <input onkeyup="changeCSSRequire('NombMadre')" style="width:200px;" type="text" name="txtNombMadre" id="txtNombMadre" disabled="disabled" checked="checked" onkeypress="return validarSoloLetras(event)"  />
                                </div>
                            </div>
                            
                            <div class="control-group">
                                <label id="lbCedMadre" style="float:left;width:100px;margin-left:20px;"><b>N. C&eacute;dula</b></label>
                                <div style="margin:5px 0 0 10px;">
                                    <input onkeyup="changeCSSRequire('CedMadre')" style="width:200px;" type="text" name="txtCedMadre" id="txtCedMadre" disabled="disabled" onkeypress="return validarSoloNumeros(event)"  />
                                </div>
                            </div>
                            
                            <div class="control-group">
                                <label id="lbOcupMadre" style="float:left;width:100px;margin-left:20px;"><b>Ocupaci&oacute;n</b></label>
                                <div style="margin:5px 0 0 10px;">
                                    <input onkeyup="changeCSSRequire('OcupMadre')" style="width:200px;" type="text" name="txtOcupMadre" id="txtOcupMadre" disabled="disabled" onkeypress="return validarSoloLetras(event)"  />
                                </div>
                            </div>
                            
                            <label style="width:50px;margin:20px 30px 0 30px;float:left;"><b>Pa&iacute;s</b></label>
                            <div style="margin:15px 0 0 10px;float: left;">
                                <?php echo country_dropdown('cmbPaisMadre','cmbPaisMadre',
                                array('US','CA','GB','DE','BR','IT','ES','AU','NZ','HK'));?>
                            </div>
                        </fieldset>
                    </div>
                    
                    <div class="span5" style="width:300px;margin: 20px 0 0 30px;">
                        <fieldset>
                            <legend style="width: 340px;">Padre</legend>
                            <div class="control-group">
                                <label id="lbNombPadre" style="float:left;width:100px;margin-left:20px;"><b>Nombres*</b></label>
                                <div style="margin-left:10px;">
                                    <input onkeyup="changeCSSRequire('NombPadre')" style="width:200px;" type="text" name="txtNombPadre" id="txtNombPadre" disabled="disabled" onkeypress="return validarSoloLetras(event)"  />
                                </div>
                            </div>
                            
                            <div class="control-group">
                                <label id="lbCedPadre" style="float:left;width:100px;margin-left:20px;"><b>N. C&eacute;dula</b></label>
                                <div style="margin:5px 0 0 10px;">
                                    <input onkeyup="changeCSSRequire('CedPadre')" style="width:200px;" type="text" name="txtCedPadre" id="txtCedPadre" disabled="disabled" onkeypress="return validarSoloNumeros(event)"  />
                                </div>
                            </div>
                            
                            <div class="control-group">
                                <label id="lbOcupPadre" style="float:left;width:100px;margin-left:20px;"><b>Ocupaci&oacute;n</b></label>
                                <div style="margin:5px 0 0 10px;">
                                    <input onkeyup="changeCSSRequire('OcupPadre')" style="width:200px;" type="text" name="txtOcupPadre" id="txtOcupPadre" disabled="disabled" onkeypress="return validarSoloLetras(event)"  />
                                </div>
                            </div>
                            <label style="width:50px;margin:20px 30px 0 30px;float:left;"><b>Pa&iacute;s</b></label>
                            <div style="margin:15px 0 0 10px;float: left;">
                             <?php echo country_dropdown('cmbPaisPadre','cmbPaisPadre',
                                array('US','CA','GB','DE','BR','IT','ES','AU','NZ','HK'));?>
    
                            </div>
                        </fieldset>
                    </div>
                    <div class="span9" style="margin:30px 0 20px 380px;">
                        <input class="btn btn-primary"  type="submit" name="btnEnviar" id="btnEnviar" value="Enviar" disabled="disabled" onclick="requerirRepresentante();" />
                        <input class="btn" style="margin-left: 100px;" type="button" name="btnCancelar" id="btnCancelar" value="Cancelar" disabled="disabled" onclick="javascript:cancelar()"/>
                    </div> 
                </div>    
            </fieldset> 
        </form>
        
        <hr>

        <footer>
            <h6>Realizado por Sedita &nbsp;&nbsp; - &nbsp;&nbsp; &copy; Company 2012</h6>
        </footer> 
    
    </body>
</html>
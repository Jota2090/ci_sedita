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
        <script src="js/misfunciones.js"></script> 
        
        <!--Autocompletar-->
        <link type="text/css" href="assets/grocery_crud/themes/datatables/css/ui/simple/jquery-ui-1.8.10.custom.css" rel="stylesheet" />	
    	<script type="text/javascript" src="<?php echo base_url(); ?>js/jquery-ui-1.8.10.custom.min.js"></script>
    	
        <script type="text/javascript">
            $(document).ready(function(){
                $('#txtNombres').autocomplete({
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
                                   document.getElementById("chkDocument").checked=false;
                               else
                                   document.getElementById("chkDocument").checked=true;

                               document.getElementById('txtMatricula').value = array[27];
                               document.getElementById('txtNombres').value = array[1];
                               document.getElementById('txtApellidos').value = array[2];
                               document.getElementById('cmbCategoria').value = array[3];
                               document.getElementById('txtDomicilio').value = array[4];
                               document.getElementById('txtTelef').value = array[5];
                               document.getElementById('cmbPais').value = array[6];
                               document.getElementById('txtLugarNac').value = array[7];

                               strFechaBase=array[8];
                               arrayFecha= strFechaBase.split("-");
                               strFechaAlu=arrayFecha[2]+"/"+arrayFecha[1]+"/"+arrayFecha[0];

                               document.getElementById('txtdateArrival').value = strFechaAlu;
                               document.getElementById('txtEdad').disabled=false;
                               document.getElementById('txtEdad').value = array[9];
                               document.getElementById('txtEdad').disabled=true;

                               if(array[10]=="M"){
                                   document.getElementById("rbSexoM").checked=true;
                                   document.getElementById("rbSexoF").checked=false;
                               }
                               else{
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

                               if(array[17]== "m"){
                                   var elements = document.getElementsByName('rbRepresent');
                                   for (i=0;i<elements.length;i++) {
                                       if(elements[i].value =="m")
                                           elements[i].checked = true;
                                   }
                                   document.getElementById("div_otra_persona").style.display = "none";
                               }
                               else if(array[17]== "p"){
                                   var elements = document.getElementsByName('rbRepresent');
                                   for (i=0;i<elements.length;i++) {
                                     if(elements[i].value ==="p") {
                                       elements[i].checked = true;
                                     }
                                   }
                                   document.getElementById("div_otra_persona").style.display = "none";
                               }

                               else{
                                   var elements = document.getElementsByName('rbRepresent');
                                   for (i=0;i<elements.length;i++) {
                                     if(elements[i].value ==="o") {
                                       elements[i].checked = true;
                                     }
                                   }
                                   document.getElementById("div_otra_persona").style.display = "block";
                                   document.getElementById('txtNombPerson').value = array[21];
                                   document.getElementById('txtCedPerson').value = array[30];
                                   document.getElementById('txtOcupPerson').value = array[22];
                                   document.getElementById('txtTelefPerson').value = array[23];
                                   document.getElementById('txtDomicilioPerson').value = array[24];
                                   document.getElementById('cmbPaisPerson').value = array[25];
                               }

                                document.getElementById('txtComentarios').value = array[18];
                                require();
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
        
         <!--Submit-->
        <script language="javascript">        
            function requerirRepresentante(){
                var r = $("input[name='rbRepresent']:checked").val();
                
                if(r==="m"){
                    changeCSSRequire('NombMadre','200px','100px');
                    changeCSSRequire('CedMadre','200px','100px');
                    changeCSSRequire('OcupMadre','200px','100px');
                }
                else{
                    if(r==="p"){
                        changeCSSRequire('NombPadre','200px','100px');
                        changeCSSRequire('CedPadre','200px','100px');
                        changeCSSRequire('OcupPadre','200px','100px');
                    }
                    else{
                        changeCSSRequire('NombPerson','','100px');
                        changeCSSRequire('CedPerson','','100px');
                        changeCSSRequire('OcupPerson','','100px');
                        changeCSSRequire('DomicilioPerson','','100px');
                        changeCSSRequire('TelefPerson','','100px');
                    }
                }
            }
            
            function registrar(){
                var cont=0;
                cont=require();
                
                if(cont>0){ alert("LLene los campos requeridos"+cont); return}
                else{
                    var matricula=$("#txtMatricula").val();
                    if(matricula==""){
                        var fecha=$("#txtdateArrival").val(), nombres=$("#txtNombres").val(),
                            apellidos=$("#txtApellidos").val();
                        var pais=$("#cmbPais").find(":selected").val();
                        
                        $.ajax({
                            type:"post",
                            data:"nombres="+nombres+"&apellidos="+apellidos+"&pais="+pais+"&fecha="+fecha,
                            url: "<?=site_url("alumno/datosRepetidos/")?>",
                            success:function(info){
                                alert(info);
                                if(info==0){
                                    document.getElementById("cmbJornada").disabled=false;
                                    document.getElementById("cmbCurso").disabled=false;
                                    document.getElementById("cmbEspec").disabled=false;
                                    document.getElementById("cmbParalelo").disabled=false;
                                    document.getElementById("txtEdad").disabled=false;
                                    document.formAlumno.submit();
                                }
                                else{
                                   alert("El alumno ya se encuentra matriculado");
                                   return;
                                }
                            }
                        });
                    }
                    else{
                        document.getElementById("cmbJornada").disabled=false;
                        document.getElementById("cmbCurso").disabled=false;
                        document.getElementById("cmbEspec").disabled=false;
                        document.getElementById("cmbParalelo").disabled=false;
                        var idJornada= $("#cmbJornada").find(":selected").val(), idCurso= $("#cmbCurso").find(":selected").val(),
                            idParal= $("#cmbParalelo").find(":selected").val(), idEspec= $("#cmbEspec").find(":selected").val(),
                            anl = $("#cmbAnioLectivo").find(":selected").val();
                        $.ajax({
                            type:"post",
                            url: "<?=site_url("alumno/alumnoRepetidoCurso/")?>"+idJornada+"/"+idCurso+"/"+idParal+"/"+idEspec+"/"+anl+"/"+matricula,
                            success:function(info){
                                if(info==0){
                                    document.getElementById("txtEdad").disabled=false;
                                    document.formAlumno.submit();
                                }
                                else{
                                    if(info==1){
                                        alert("El alumno ya se encuentra matriculado en el curso");
                                    }
                                    else{
                                        alert("El alumno ya se encuentra matriculado en otro curso");
                                    }
                                    
                                    document.getElementById("cmbJornada").disabled=true;
                                    document.getElementById("cmbCurso").disabled=true;
                                    document.getElementById("cmbEspec").disabled=true;
                                    document.getElementById("cmbParalelo").disabled=true;
                                    return;
                                }
                            }
                        });
                    }
                }
            }
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
        
        <form class="form-horizontal" id="formAlumno" name="formAlumno" action="<?=site_url("alumno/guardar") ?>" method="post" target="_blank" >
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
                            <li><select id="cmbEspec" name="cmbEspec" disabled="disabled" >
                                    <option value="">Especializaciones</option>
                                </select></li>
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
                        <input type="hidden" name="txtMatricula" id="txtMatricula" value="" />
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
                            <label id="lbNombres" class="control-label"><b>Nombres*</b></label>
                            <div class="controls">
                                <input class="span2" onkeyup="changeCSSRequire('Nombres','342px','155px')" style="width:342px;" type="text" name="txtNombres" id="txtNombres" disabled="disabled" onkeypress="return validarSoloLetras(event)">
                                <!--<div class="input-append">
                                    <input class="span2" onkeyup="changeCSSRequire('Nombres','288px','155px')" style="width:288px;" type="text" name="txtNombres" id="txtNombres" disabled="disabled" onkeypress="return validarSoloLetras(event)">
                                    <button class="btn" type="button"><i class="icon-search"></i></button>
                                </div>-->
                            </div>
                        </div>
                        
                        <div class="control-group span4">
                            <label id="lbApellidos" class="control-label"><b>Apellidos*</b></label>
                            <div class="controls">
                                <input onkeyup="changeCSSRequire('Apellidos','342px','155px')" style="width:342px;"  disabled="disabled" type="text" name="txtApellidos" id="txtApellidos"  onkeypress="return validarSoloLetras(event)"  />
                            </div>
                        </div>
                        
                        <div class="control-group span4">
                            <label id="lbDomicilio" class="control-label"><b>Direcci&oacute;n*</b></label>
                            <div class="controls">
                                <input onkeyup="changeCSSRequire('Domicilio','342px','155px')" style="width: 342px;" type="text" name="txtDomicilio" id="txtDomicilio" disabled="disabled" />
                            </div>
                        </div>
                        
                        <div class="control-group span2">
                            <label id="lbTelef" class="control-label"><b>Tel&eacute;fono*</b></label>
                            <div class="controls">
                                <input onkeyup="changeCSSRequire('Telef','120px','155px')" style="width: 120px;" type="text" name="txtTelef" id="txtTelef" disabled="disabled" maxlength="10" onkeypress="return validarSoloNumeros(event)" />
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
                            <label id="lbLugarNac" class="control-label"><b>Lugar de nacimiento*</b></label>
                            <div class="controls">
                                <input onkeyup="changeCSSRequire('LugarNac','120px','')" style="width: 120px;" type="text" name="txtLugarNac" id="txtLugarNac" disabled="disabled"  type="text" onkeypress="return validarSoloLetras(event)"  />
                            </div>
                        </div>
                        
                        <div class="control-group span1" style="margin-left:80px;">
                            <label class="control-label" ><b>Edad*</b></label>
                            <div class="controls">
                                <input style="width:50px" type="text" name="txtEdad" id="txtEdad"  disabled="disabled" onkeypress="return validarSoloNumeros(event)"  />
                            </div>
                        </div>
                        
                        <div class="control-group span4" style="margin-bottom: -5px;" >
                            <label id="lbdateArrival" class="control-label"><b>Fecha de Nacimiento*</b></label>
                            <div class="controls" style="width:165px;">
                                <a id="linkCalendar" onclick="displayCalendar(document.forms[0].txtdateArrival,'dd/mm/yyyy',this);" style="float: right;padding: 0 0 10px 165px;">
                                    <i class="icon-calendar" style="float:right;position: relative;" id="calendar"></i>
                                    <input onkeydown="displayCalendar(document.forms[0].txtdateArrival,'dd/mm/yyyy',this);" onchange="setearEdad();changeCSSRequire('dateArrival','120px','');" placeholder="dd/mm/yyyy" name="txtdateArrival" id="txtdateArrival" type="text" disabled="disabled" size="10" style="width: 120px;right: 30px;bottom: 25px;position: relative;" />                                                                        
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
                                <input type="radio"  id="rbRepresent" name="rbRepresent" value="m" onclick="toggle_otra_persona(this)" checked="checked" disabled="disabled" />Madre
                            </label>
                            <label class="checkbox inline">
                                <input type="radio" id="rbRepresent" name="rbRepresent" value="p" onclick="toggle_otra_persona(this)"  disabled="disabled"/>Padre
                            </label>
                            <label class="checkbox inline">
                                <input type="radio" id="rbRepresent" name="rbRepresent" value="o" onclick="toggle_otra_persona(this)" disabled="disabled"/>Otra persona
                            </label>                            
                        </div>
                        
                        <div class="span4 panel" style="display:none; width:470px;padding:10px 20px 30px 20px;margin-top:20px" id="div_otra_persona" >
                            <fieldset>
                                <legend>Representante</legend>
                                <div class="control-group">
                                    <label id="lbNombPerson" class="control-label"><b>Nombres*</b></label>
                                    <div class="controls">
                                        <input onkeyup="requerirRepresentante()" type="text" name="txtNombPerson" id="txtNombPerson" disabled="disabled" onkeypress="return validarSoloLetras(event)" />
                                    </div>
                                </div>
                                
                                <div class="control-group">
                                    <label id="lbCedPerson" class="control-label" style="margin-top: 10px;"><b>N. C&eacute;dula</b></label>
                                    <div class="controls" style="margin-top: 10px;">
                                        <input onkeyup="requerirRepresentante()" maxlength="10" type="text" name="txtCedPerson" id="txtCedPerson" disabled="disabled" onkeypress="return validarSoloNumeros(event)"  />
                                    </div>
                                </div>
                                
                                <div class="control-group">
                                    <label id="lbOcupPerson" class="control-label" style="margin-top: 10px;"><b>Ocupaci&oacute;n</b></label>
                                    <div class="controls" style="margin-top: 10px;">
                                        <input onkeyup="requerirRepresentante()" type="text" name="txtOcupPerson" id="txtOcupPerson" disabled="disabled" onkeypress="return validarSoloLetras(event)"  />
                                    </div>
                                </div>
                                
                                <div class="control-group">
                                    <label id="lbDomicilioPerson" class="control-label"><b>Direcci&oacute;n*</b></label>
                                    <div class="controls">
                                        <input onkeyup="requerirRepresentante()" type="text" name="txtDomicilioPerson" id="txtDomicilioPerson" disabled="disabled" />
                                    </div>
                                </div>
                                
                                <div class="control-group">
                                    <label id="lbTelefPerson" class="control-label"><b>Tel&eacute;fono*</b></label>
                                    <div class="controls">
                                        <input onkeyup="requerirRepresentante()" maxlength="10" type="text" name="txtTelefPerson" id="txtTelefPerson"  disabled="disabled" onkeypress="return validarSoloNumeros(event)" />
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
                                    <input onkeyup="requerirRepresentante()" style="width:200px;" type="text" name="txtNombMadre" id="txtNombMadre" disabled="disabled" checked="checked" onkeypress="return validarSoloLetras(event)"  />
                                </div>
                            </div>
                            
                            <div class="control-group">
                                <label id="lbCedMadre" style="float:left;width:100px;margin-left:20px;"><b>N. C&eacute;dula</b></label>
                                <div style="margin:5px 0 0 10px;">
                                    <input onkeyup="requerirRepresentante()" maxlength="10" style="width:200px;" type="text" name="txtCedMadre" id="txtCedMadre" disabled="disabled" onkeypress="return validarSoloNumeros(event)"  />
                                </div>
                            </div>
                            
                            <div class="control-group">
                                <label id="lbOcupMadre" style="float:left;width:100px;margin-left:20px;"><b>Ocupaci&oacute;n</b></label>
                                <div style="margin:5px 0 0 10px;">
                                    <input onkeyup="requerirRepresentante()" style="width:200px;" type="text" name="txtOcupMadre" id="txtOcupMadre" disabled="disabled" onkeypress="return validarSoloLetras(event)"  />
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
                                    <input onkeyup="requerirRepresentante()" style="width:200px;" type="text" name="txtNombPadre" id="txtNombPadre" disabled="disabled" onkeypress="return validarSoloLetras(event)"  />
                                </div>
                            </div>
                            
                            <div class="control-group">
                                <label id="lbCedPadre" style="float:left;width:100px;margin-left:20px;"><b>N. C&eacute;dula</b></label>
                                <div style="margin:5px 0 0 10px;">
                                    <input onkeyup="requerirRepresentante()" maxlength="10" style="width:200px;" type="text" name="txtCedPadre" id="txtCedPadre" disabled="disabled" onkeypress="return validarSoloNumeros(event)"  />
                                </div>
                            </div>
                            
                            <div class="control-group">
                                <label id="lbOcupPadre" style="float:left;width:100px;margin-left:20px;"><b>Ocupaci&oacute;n</b></label>
                                <div style="margin:5px 0 0 10px;">
                                    <input onkeyup="requerirRepresentante()" style="width:200px;" type="text" name="txtOcupPadre" id="txtOcupPadre" disabled="disabled" onkeypress="return validarSoloLetras(event)"  />
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
                        <input class="btn btn-primary"  type="button" name="btnEnviar" id="btnEnviar" value="Enviar" disabled="disabled" onclick="registrar();" />
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
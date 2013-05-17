<?php
    if(isset($editar)){
        $general = new General();
        $jor=$query->jor_id; 
        $niv=$this->general->cargar_niveles($jor,$query->niv_id); 
        $cur=$general->cargar_cursos($jor,$query->niv_id,$query->cur_id);
        if($query->esp_id>0){
            $esp=$general->cargar_especializaciones($jor,$query->cur_id,$query->esp_id); 
            $par=$general->cargar_paralBachill($jor,$query->cur_id,$query->esp_id,$query->par_id); 
        }else{
            $esp=$general->cargar_especializaciones($jor,$query->cur_id,$query->esp_id); 
            $par=$general->cargar_paralelos($jor,$query->cur_id,$query->par_id);}
        $anl=$query->alu_ano_lectivo_id; $categoria=$query->alu_categoria_alumno_id; $nombres=$query->alu_nombres; 
        $apellidos=$query->alu_apellidos; $domicilio=$query->alu_domicilio; $telefono=$query->alu_telefono; 
        $pais=$query->alu_pais; $lugar=$query->alu_lugar_nacimiento; 
        list($ano,$mes,$dia)= explode("-",$query->alu_fecha_nacimiento);
        $f_nacimiento=$dia."/".$mes."/".$ano; 
        $comentarios=$query->alu_comentarios; $nom_madre=$query->alu_madre_nombres; 
        $ced_madre=$query->alu_madre_cedula; $ocu_madre=$query->alu_madre_ocupacion; 
        $pais_madre=$query->alu_madre_pais; $nom_padre=$query->alu_padre_nombres; 
        $ced_padre=$query->alu_padre_cedula; $ocu_padre=$query->alu_padre_ocupacion; 
        $pais_padre=$query->alu_padre_pais; 
        if($query->alu_principal_representante==="o"){
            $nom_repre=$query->rep_nombres; $ced_repre=$query->rep_cedula; $ocu_repre=$query->rep_ocupacion;
            $pais_repre=$query->rep_pais; $dom_repre=$query->rep_domicilio; $tel_repre=$query->rep_telefono;
        }else{
            $nom_repre=""; $ced_repre=""; $ocu_repre=""; $pais_repre="Ecuador"; $dom_repre=""; $tel_repre="";
        }
        $documentacion=$query->alu_documentacion; $sexo=$query->alu_sexo; 
        $representante=$query->alu_principal_representante; $edad=$query->alu_edad; 
        $matricula=$query->alu_matricula; $id=$query->alu_id; $idRepre=$query->rep_id;
    }else{
        $jor=0; $niv=""; $cur=""; $esp="<option value='0'>Especializaciones</option>"; $par=""; $anl=""; 
        $categoria=1; $nombres=""; $apellidos=""; $domicilio=""; $telefono=""; $pais="Ecuador"; $lugar=""; 
        $f_nacimiento=""; $comentarios=""; $nom_madre=""; $ced_madre=""; $ocu_madre=""; $pais_madre="Ecuador"; 
        $nom_padre=""; $ced_padre=""; $ocu_padre=""; $pais_padre="Ecuador"; $nom_repre=""; $ced_repre=""; 
        $ocu_repre=""; $pais_repre="Ecuador"; $dom_repre=""; $tel_repre=""; $documentacion=0; $sexo="M"; 
        $representante="m"; $edad=""; $matricula=""; $id="";$idRepre="";}
?>
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
    	
        <?if(!isset($editar)):?>   
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
        <?endif;?>
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
            
            <?if(!isset($editar)):?>
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
            <?endif;?>
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
                        if(this.disabled){
                            this.disabled=false;
                        }
                        else{
                            this.value = "";
                        }
                    }
                    else if (type == 'checkbox' || type == 'radio'){
                        this.disabled = false;
                    }
                    else if (type == 'button'){
                        this.disabled = false;
                    }
                    else if (tag == 'select'){
                       this.disabled = false;
                    }
                });
                <?if(!isset($editar)):?>
                $("#cmbJornada").attr('disabled', 'disabled');
                $("#cmbNivel").attr('disabled', 'disabled');
                $("#cmbCurso").attr('disabled', 'disabled');
                $("#cmbEspec").attr('disabled', 'disabled');
                $("#cmbParalelo").attr('disabled', 'disabled');
                $("#txtNumAlumn").attr('disabled', 'disabled');
                
                $.ajax({
                    type:"post",
                    url: "<?=site_url("alumno/num_matricula")?>",
                    success:function(info){
                        $("#matricula").html(info);
                    }
                });
                <?endif;?>
                $("#txtEdad").attr('disabled', 'disabled');
            }
        </script>   
        <!--Quitar atributo disabled-->
      
        <?if(!isset($editar)):?>
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
        <?endif;?>
        
        <?if(isset($editar)):?>
        <script language="javascript"> 
            function regresar(){
                location.href="<?echo base_url()?>"+"/alumno/consultar";
            }
        </script>
        <?endif;?>
        
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
                cont=require_alumno();
                
                if(cont>0){ alert("LLene los campos requeridos"); return}
                else{
                    var matricula=$("#txtMatricula").val();
                    var id=$("#txtId").val();
                    if(id==""){
                        if(matricula==""){
                            var fecha=$("#txtdateArrival").val(), nombres=$("#txtNombres").val(),
                                apellidos=$("#txtApellidos").val();
                            var pais=$("#cmbPais").find(":selected").val();

                            $.ajax({
                                type:"post",
                                data:"nombres="+nombres+"&apellidos="+apellidos+"&pais="+pais+"&fecha="+fecha,
                                url: "<?=site_url("alumno/datosRepetidos/")?>",
                                success:function(info){
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
                                data:"jornada="+idJornada+"&curso="+idCurso+"&paralelo="+idParal+"&especializacion="+idEspec
                                        +"&anl="+anl+"&matricula="+matricula,
                                url: "<?=site_url("alumno/alumnoRepetidoCurso/")?>",
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
                    }else{
                        document.getElementById("txtEdad").disabled=false;
                        document.formAlumno.submit();
                    }   
                }
            }
        </script>
        <!--Fin submit-->
      
        <?if(!isset($editar)):?>
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
        <?endif;?>

        <style type="text/css">
            body {
                width: 1280px;
                padding-top: 10px;
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

    <body>
        <form class="form-horizontal" id="formAlumno" name="formAlumno" action="<?=site_url("alumno/guardar") ?>" method="post" >
            <fieldset>
                <?if(!isset($editar)):?><legend>Matricular Alumno</legend>
                <?else:?><legend>
                            <div style="float:left;">Modificar Alumno</div>
                            <div style="float:right; font-size: 16px;"><a href="javascript:;" onclick="regresar();">Regresar a la Lista</a></div>
                        </legend>
                <?endif;?>
                <div style="margin-right:15px; float: left">
                    <div class="panel" style="clear:left; width:230px;padding:10px 10px 0 20px;">
                        <ul class="nav">
                            <li><b>Jornada</b></li>
                            <li><?php 
                                    $js = 'id="cmbJornada"';
                                    echo form_dropdown("cmbJornada",$jornada, $jor, $js);
                                ?>
                            </li>
                            <br />
                            <li><b>Nivel</b></li>
                            <li><select id="cmbNivel" name="cmbNivel" disabled="disabled" ><?echo $niv;?></select></li>
                            <br />
                            <li><b>Curso </b></li>
                            <li><select id="cmbCurso" name="cmbCurso" disabled="disabled" ><?echo $cur;?></select></li>
                            <br />
                            <li><b>Especializaci&oacute;n </b></li>
                            <li><select id="cmbEspec" name="cmbEspec" disabled="disabled" ><?echo $esp;?></select></li>
                            <br />
                            <li><b>Paralelo </b></li>
                            <li><select id="cmbParalelo" name="cmbParalelo" disabled="disabled" ><?echo $par;?></select></li>
                            <br />
                            <li><b>A&ntilde;o Lectivo</b></li>
                            <li>
                                <? $js = "id='cmbAnioLectivo' disabled='disabled' style='width:130px;'";
                                    echo form_dropdown("cmbAnioLectivo",$anLects,$anl, $js);
                                ?>
                            </li>
                            <?if(!isset($editar)):?>
                            <br />
                            <li><b>No. de Matriculados</b></li>
                            <li><input type="text" name="txtNumAlumn" id="txtNumAlumn" disabled="disabled" /></li>
                            <?endif;?>
                        </ul>
                    </div><!--/span-->
                    <?if(!isset($editar)):?>
                    <div class="span3" style="clear: left; margin-left:30px;">
                        <div class="well sidebar-nav">
                            <ul class="nav nav-list">
                              <li class="nav-header">Ayuda<i class="icon-question-sign" style="float: right;"></i></li>
                              <li><a>En esta secci&oacute;n podr&aacute; <b>matricular a un alumno</b> en el plantel, llenando sus datos personales.</a></li>
                            </ul>
                        </div><!--/.well -->
                    </div><!--/span-->
                    <?else:?>
                    <div class="span3" style="clear: left; margin-left:30px;">
                        <div class="well sidebar-nav">
                            <ul class="nav nav-list">
                              <li class="nav-header">Ayuda<i class="icon-question-sign" style="float: right;"></i></li>
                              <li><a>En esta secci&oacute;n podr&aacute; <b>editar a un alumno</b> en el plantel, llenando sus datos personales.</a></li>
                            </ul>
                        </div><!--/.well -->
                    </div><!--/span-->
                    <?endif;?>
                </div> 
                <div class="panel" style="float: left; width:980px;padding:10px 20px 0 0;">
                    <div class="span4" style="padding-right:280px;border-right: 1px solid #000000">
                        <input type="hidden" name="txtMatricula" id="txtMatricula" value="<?echo $matricula;?>" />
                        <input type="hidden" name="txtId" id="txtId" value="<?echo $id;?>" />
                        <input type="hidden" name="txtIdRepre" id="txtIdRepre" value="<?echo $idRepre;?>" />
                        <div class="span2" style="margin-top: 10px;">
                            <label class="control-label" ><b>Con documentaci&oacute;n</b></label>
                            <div class="controls">
                                <input type="checkbox" name="chkDocument" id="chkDocument" value="1" disabled="disabled" <?if($documentacion!=0):?>checked="checked"<?endif;?> />
                            </div>
                        </div>

                        <div class="span1" style="margin: 10px 0 0 80px;">
                            <label class="control-label"><b>Categor&iacute;a</b></label>
                            <div class="controls">
                                <?  if(!isset($editar)): $disabled="disabled='disabled'"; else: $disabled=""; endif;
                                    $js = "id='cmbCategoria' ".$disabled."' style='width:135px;'";
                                    echo form_dropdown("cmbCategoria",$categoria_alumno, $categoria, $js);
                                ?>
                            </div>
                        </div>
                        <div class="control-group span4" style="margin-top: 15px;">
                            <label id="lbNombres" class="control-label"><b>Nombres*</b></label>
                            <div class="controls">
                                <!--<div class="input-append">
                                    <input onkeyup="changeCSSRequire('Nombres','292px','155px')" style="width:292px;" type="text" name="txtNombres" id="txtNombres" disabled="disabled" onkeypress="return validarSoloLetras(event)" value="<?echo $nombres;?>" />
                                    <button class="btn" onclick="" style="height:30px"><i class="icon-search"></i></button>
                                </div>-->
                                <input onkeyup="changeCSSRequire('Nombres','342px','155px')" style="width:342px;" type="text" name="txtNombres" id="txtNombres" disabled="disabled" onkeypress="return validarSoloLetras(event)" value="<?echo $nombres;?>" />
                            </div>
                        </div>

                        <div class="control-group span4">
                            <label id="lbApellidos" class="control-label"><b>Apellidos*</b></label>
                            <div class="controls">
                                <!--<div class="input-append">
                                    <input onkeyup="changeCSSRequire('Apellidos','292px','155px')" style="width:292px;" type="text" name="txtApellidos" id="txtApellidos" disabled="disabled" onkeypress="return validarSoloLetras(event)" value="<?echo $apellidos;?>" />
                                    <button class="btn" onclick="" style="height:30px"><i class="icon-search"></i></button>
                                </div>-->
                                <input onkeyup="changeCSSRequire('Apellidos','342px','155px')" style="width:342px;" type="text" name="txtApellidos" id="txtApellidos" disabled="disabled" onkeypress="return validarSoloLetras(event)" value="<?echo $apellidos;?>" />
                            </div>
                        </div>

                        <div class="control-group span4">
                            <label id="lbDomicilio" class="control-label"><b>Direcci&oacute;n*</b></label>
                            <div class="controls">
                                <input onkeyup="changeCSSRequire('Domicilio','342px','155px')" style="width: 342px;" type="text" name="txtDomicilio" id="txtDomicilio" disabled="disabled" value="<?echo $domicilio;?>" />
                            </div>
                        </div>

                        <div class="control-group span2">
                            <label id="lbTelef" class="control-label"><b>Tel&eacute;fono*</b></label>
                            <div class="controls">
                                <input onkeyup="changeCSSRequire('Telef','120px','155px')" style="width: 120px;" type="text" name="txtTelef" id="txtTelef" disabled="disabled" maxlength="10" onkeypress="return validarSoloNumeros(event)" value="<?echo $telefono;?>" />
                            </div>
                        </div>

                        <div class="control-group span1" style="margin-left:80px;">
                            <label class="control-label" ><b>Pa&iacute;s</b></label>
                            <div class="controls">
                                <?php if(!isset($editar)): $disabled="disabled"; else: $disabled=""; endif;
                                echo country_dropdown('cmbPais','cmbPais',array(),$pais,$disabled);?>
                            </div>
                        </div>


                        <div class="control-group span2">
                            <label id="lbLugarNac" class="control-label"><b>Lugar de nacimiento*</b></label>
                            <div class="controls">
                                <input onkeyup="changeCSSRequire('LugarNac','120px','')" style="width: 120px;" type="text" name="txtLugarNac" id="txtLugarNac" disabled="disabled"  type="text" onkeypress="return validarSoloLetras(event)" value="<?echo $lugar;?>" />
                            </div>
                        </div>

                        <div class="control-group span1" style="margin-left:80px;">
                            <label class="control-label" ><b>Edad*</b></label>
                            <div class="controls">
                                <input style="width:50px" type="text" name="txtEdad" id="txtEdad"  disabled="disabled" onkeypress="return validarSoloNumeros(event)" value="<?echo $edad;?>" />
                            </div>
                        </div>

                        <div class="control-group span4" style="margin-bottom: -5px;" >
                            <label id="lbdateArrival" class="control-label"><b>Fecha de Nacimiento*</b></label>
                            <div class="controls" style="width:165px;">
                                <a id="linkCalendar" onclick="displayCalendar(document.forms[0].txtdateArrival,'dd/mm/yyyy',this);" style="float: right;padding: 0 0 10px 165px;">
                                    <i class="icon-calendar" style="float:right;position: relative;" id="calendar"></i>
                                    <input autocomplete="off" onkeydown="displayCalendar(document.forms[0].txtdateArrival,'dd/mm/yyyy',this);" onchange="setearEdad();changeCSSRequire('dateArrival','120px','');" placeholder="dd/mm/yyyy" name="txtdateArrival" id="txtdateArrival" type="text" disabled="disabled" size="10" style="width: 120px;right: 30px;bottom: 25px;position: relative;" value="<?echo $f_nacimiento;?>" />                                                                        
                                </a>

                            </div>
                        </div>

                        <div class="control-group span6">
                            <label class="control-label"><b>Sexo</b></label>
                            <label class="checkbox inline">
                                <input type="radio" name="rbSexo" value="M" id="rbSexoM" disabled="disabled" <?if($sexo=="M"):?>checked="checked"<?endif;?> />Masculino
                            </label>
                            <label class="checkbox inline">
                                <input type="radio" name="rbSexo" value="F"  id="rbSexoF" disabled="disabled" <?if($sexo=="F"):?>checked="checked"<?endif;?> />Femenino
                            </label>
                        </div>
                        <div class="control-group span6">                        
                            <label class="control-label"><b>Representante*</b></label>
                            <label class="checkbox inline">
                                <input type="radio"  id="rbRepresent" name="rbRepresent" value="m" onclick="toggle_otra_persona(this)" <?if($representante=="m"):?>checked="checked"<?endif;?> disabled="disabled" />Madre
                            </label>
                            <label class="checkbox inline">
                                <input type="radio" id="rbRepresent" name="rbRepresent" value="p" onclick="toggle_otra_persona(this)" <?if($representante=="p"):?>checked="checked"<?endif;?> disabled="disabled"/>Padre
                            </label>
                            <label class="checkbox inline">
                                <input type="radio" id="rbRepresent" name="rbRepresent" value="o" onclick="toggle_otra_persona(this)" <?if($representante=="o"):?>checked="checked"<?endif;?> disabled="disabled"/>Otra persona
                            </label>                            
                        </div>

                        <div class="span4 panel" style="display:none; width:470px;padding:10px 20px 30px 20px;margin-top:20px" id="div_otra_persona" >
                            <fieldset>
                                <legend>Representante</legend>
                                <div class="control-group">
                                    <label id="lbNombPerson" class="control-label"><b>Nombres*</b></label>
                                    <div class="controls">
                                        <input onkeyup="requerirRepresentante()" type="text" name="txtNombPerson" id="txtNombPerson" disabled="disabled" onkeypress="return validarSoloLetras(event)" value="<?echo $nom_repre;?>" />
                                    </div>
                                </div>

                                <div class="control-group">
                                    <label id="lbCedPerson" class="control-label" style="margin-top: 10px;"><b>N. C&eacute;dula</b></label>
                                    <div class="controls" style="margin-top: 10px;">
                                        <input onkeyup="requerirRepresentante()" maxlength="10" type="text" name="txtCedPerson" id="txtCedPerson" disabled="disabled" onkeypress="return validarSoloNumeros(event)" value="<?echo $ced_repre;?>" />
                                    </div>
                                </div>

                                <div class="control-group">
                                    <label id="lbOcupPerson" class="control-label" style="margin-top: 10px;"><b>Ocupaci&oacute;n</b></label>
                                    <div class="controls" style="margin-top: 10px;">
                                        <input onkeyup="requerirRepresentante()" type="text" name="txtOcupPerson" id="txtOcupPerson" disabled="disabled" onkeypress="return validarSoloLetras(event)" value="<?echo $ocu_repre;?>" />
                                    </div>
                                </div>

                                <div class="control-group">
                                    <label id="lbDomicilioPerson" class="control-label"><b>Direcci&oacute;n*</b></label>
                                    <div class="controls">
                                        <input onkeyup="requerirRepresentante()" type="text" name="txtDomicilioPerson" id="txtDomicilioPerson" disabled="disabled" value="<?echo $dom_repre;?>" />
                                    </div>
                                </div>

                                <div class="control-group">
                                    <label id="lbTelefPerson" class="control-label"><b>Tel&eacute;fono*</b></label>
                                    <div class="controls">
                                        <input onkeyup="requerirRepresentante()" maxlength="10" type="text" name="txtTelefPerson" id="txtTelefPerson"  disabled="disabled" onkeypress="return validarSoloNumeros(event)" value="<?echo $tel_repre;?>" />
                                    </div>
                                </div>

                                <label class="control-label" style="margin-top: 20px;"><b>Pa&iacute;s</b></label>
                                <div class="controls" style="margin-top: 20px;">
                                    <?php if(!isset($editar)): $disabled="disabled"; else: $disabled=""; endif;
                                    echo country_dropdown('cmbPaisPerson','cmbPaisPerson',array(),$pais_repre,$disabled);?>
                                </div>
                            </fieldset>
                        </div>

                        <div class="span4">
                            <label class="control-label" style="margin-top: 10px;"><b>Comentarios</b></label><br /><br />
                             <textarea style="width: 345px; height: 100px; margin-left: 180px;" name="txtComentarios" id="txtComentarios" disabled="disabled"  name="comments" id="comments" value="<?echo $comentarios;?>" > </textarea>
                         </div>
                    </div> 
                    <div class="span5" style="padding-bottom:30px; width:340px; margin-left: 30px; border-bottom: 1px solid black;">
                        <fieldset>
                            <legend style="width: 340px;">Madre</legend>
                            <div class="control-group">
                                <label  id="lbNombMadre" style="float:left;width:100px;margin-left:20px;"><b>Nombres*</b></label>
                                <div style="margin-left:10px;">
                                    <input onkeyup="requerirRepresentante()" style="width:200px;" type="text" name="txtNombMadre" id="txtNombMadre" disabled="disabled" checked="checked" onkeypress="return validarSoloLetras(event)" value="<?echo $nom_madre;?>" />
                                </div>
                            </div>

                            <div class="control-group">
                                <label id="lbCedMadre" style="float:left;width:100px;margin-left:20px;"><b>N. C&eacute;dula</b></label>
                                <div style="margin:5px 0 0 10px;">
                                    <input onkeyup="requerirRepresentante()" maxlength="10" style="width:200px;" type="text" name="txtCedMadre" id="txtCedMadre" disabled="disabled" onkeypress="return validarSoloNumeros(event)" value="<?echo $ced_madre;?>" />
                                </div>
                            </div>

                            <div class="control-group">
                                <label id="lbOcupMadre" style="float:left;width:100px;margin-left:20px;"><b>Ocupaci&oacute;n</b></label>
                                <div style="margin:5px 0 0 10px;">
                                    <input onkeyup="requerirRepresentante()" style="width:200px;" type="text" name="txtOcupMadre" id="txtOcupMadre" disabled="disabled" onkeypress="return validarSoloLetras(event)" value="<?echo $ocu_madre;?>" />
                                </div>
                            </div>

                            <label style="width:50px;margin:20px 30px 0 30px;float:left;"><b>Pa&iacute;s</b></label>
                            <div style="margin:15px 0 0 10px;float: left;">
                                <?php if(!isset($editar)): $disabled="disabled"; else: $disabled=""; endif;
                                echo country_dropdown('cmbPaisMadre','cmbPaisMadre',array(),$pais_madre,$disabled);?>
                            </div>
                        </fieldset>
                    </div>

                    <div class="span5" style="width:300px;margin: 20px 0 0 30px;">
                        <fieldset>
                            <legend style="width: 340px;">Padre</legend>
                            <div class="control-group">
                                <label id="lbNombPadre" style="float:left;width:100px;margin-left:20px;"><b>Nombres*</b></label>
                                <div style="margin-left:10px;">
                                    <input onkeyup="requerirRepresentante()" style="width:200px;" type="text" name="txtNombPadre" id="txtNombPadre" disabled="disabled" onkeypress="return validarSoloLetras(event)" value="<?echo $nom_padre;?>" />
                                </div>
                            </div>

                            <div class="control-group">
                                <label id="lbCedPadre" style="float:left;width:100px;margin-left:20px;"><b>N. C&eacute;dula</b></label>
                                <div style="margin:5px 0 0 10px;">
                                    <input onkeyup="requerirRepresentante()" maxlength="10" style="width:200px;" type="text" name="txtCedPadre" id="txtCedPadre" disabled="disabled" onkeypress="return validarSoloNumeros(event)" value="<?echo $ced_padre;?>" />
                                </div>
                            </div>

                            <div class="control-group">
                                <label id="lbOcupPadre" style="float:left;width:100px;margin-left:20px;"><b>Ocupaci&oacute;n</b></label>
                                <div style="margin:5px 0 0 10px;">
                                    <input onkeyup="requerirRepresentante()" style="width:200px;" type="text" name="txtOcupPadre" id="txtOcupPadre" disabled="disabled" onkeypress="return validarSoloLetras(event)" value="<?echo $ocu_padre;?>" />
                                </div>
                            </div>
                            <label style="width:50px;margin:20px 30px 0 30px;float:left;"><b>Pa&iacute;s</b></label>
                            <div style="margin:15px 0 0 10px;float: left;">
                             <?php if(!isset($editar)): $disabled="disabled"; else: $disabled=""; endif;
                             echo country_dropdown('cmbPaisPadre','cmbPaisPadre',array(),$pais_padre,$disabled);?>
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
    </body>
</html>
<?if(isset($editar)):
    echo "<script> var id=document.getElementById('formAlumno'); $(document).ready(function(){quitarDisable(id);}); </script>";
  endif;?>
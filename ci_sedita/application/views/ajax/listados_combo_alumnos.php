<script>
    $(document).ready(function(){
        ver_libretas();
    });
    
    $(document).ready(function(){
        $("#cmbAlumno").change(function(){
            ver_libretas();
        })
    });
                
    function ver_libretas(){
        var cur = $("#cmbCurso").find(":selected").val();
        var esp = $("#cmbEspecializacion").find(":selected").val();
        var par = $("#cmbParalelo").find(":selected").val();
        var jor = $("#cmbJornada").find(":selected").val();
        var anl = $("#cmbAnioLectivo").find(":selected").val();  
        var alu = $("#cmbAlumno").find(":selected").val(); 
        
        $.ajax({
            type:"post",
            url: "<?=site_url("listados/ver_promocion")?>",
            data:"cur="+cur+"&jor="+jor+"&esp="+esp+"&anl="+anl+"&par="+par+"&alu="+alu,
            success:function(info){
                $("#promocion").html(info);
            }
        });
    }
</script>
<div class="control-group">
    <label class="control-label"><b>Alumnos</b></label>
    <div class="controls">
        <?php 
            $js = "id='cmbAlumno' style='width:300px'";
            echo form_dropdown("cmbAlumno",$alumnos, null, $js);
        ?>
    </div>
</div>
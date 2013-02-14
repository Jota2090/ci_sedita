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
        var tri = $("#cmbTrimestre").find(":selected").val();
        var alu = $("#cmbAlumno").find(":selected").val();
        var anl = $("#cmbAnioLectivo").find(":selected").val();
        
        $.ajax({
            type:"post",
            url: "<?=site_url("alumno_profesor/visualizar_libretas")?>",
            data:"cur="+cur+"&tri="+tri+"&alu="+alu+"&anl="+anl,
            success:function(info){
                $("#libretas").html(info);
            }
        });
    }; 
</script>
<label class="control-label"><b>Alumnos</b></label>
<div class="controls">
    <?php 
        $js = "id='cmbAlumno'";
        echo form_dropdown("cmbAlumno",$alumnos, null, $js);
    ?>
</div>
<button style="margin-left: 450px;" type="btn" id="add-paralelo"><i class="icon-plus-sign"></i>Agregar Paralelo</button>
<form class="span2" style="float: right;" action="<?=site_url("mantenimiento/expListCursos")?>" method="post">
    <button class="btn" type="submit" id="exportar" style="width: 120px;"><i class="icon-download-alt"></i>Excel</button>
    <input type="hidden" id="jornada" name="jornada" value="<? echo $j?>" />
    <input type="hidden" id="curso" name="curso" value="<? echo $c?>" />
    <input type="hidden" id="especializacion" name="especializacion" value="<? echo $e?>" />
    <input type="hidden" id="indicador" name="indicador" value="1" />
</form>

<form class="span2" style="float: right;" action="<?=site_url("mantenimiento/expListCursos")?>" method="post" target="_blank">
    <button class="btn" type="submit" id="exportar" style="width: 120px;"><i class="icon-print"></i>Imprimir</button>
    <input type="hidden" id="jornada" name="jornada" value="<? echo $j?>" />
    <input type="hidden" id="curso" name="curso" value="<? echo $c?>" />
    <input type="hidden" id="especializacion" name="especializacion" value="<? echo $e?>" />
    <input type="hidden" id="indicador" name="indicador" value="0" />
</form>

<?php foreach($css_files as $file): ?>
	<link type="text/css" rel="stylesheet" href="<?php echo $file; ?>" />
    <base href="<?=site_url()?>" />
<?php endforeach; ?>

<?php foreach($js_files as $file): ?>
	<script src="<?php echo $file; ?>"></script>
<?php endforeach; ?>

<div style="padding-top: 5px;">
    <?php echo $output ?>
</div>

<script>
    $(document).ready(function(){
       $("div#groceryCrudTable_filter").remove();
    });
    
    $(document).ready(function() {
        $( "#paralelo" ).dialog({
            autoOpen: false,
            height: 200,
            width: 300,
            title: "Agregar Paralelo",
            modal: true,
            buttons: {
                Guardar: function(){
                    var paralelo = $('input[name=paralelo]').val();
                    
                    if(paralelo == "" || paralelo == null){
                        $( this ).dialog( "close" );
                    }
                    else{
                        $.ajax({
                            type:"post",
                            url: "<?=site_url("mantenimiento/paralelo")?>",
                            data:"paralelo="+paralelo,
                            success:function(info){
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
        
        $( "#add-paralelo" ).button().click(function() {
            $.ajax({
                type: 'post',
                dataType: 'html',
                url:"<?=site_url("mantenimiento/agregar_paralelo")?>",
                success: function(data){
                    $("#paralelo").empty();
                    $("#paralelo").append(data);
                    $("#paralelo").dialog( "open" );
                }                        
             })            
        });
    });
</script>


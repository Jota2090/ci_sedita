<button style="margin-left: 450px;clear:both;" type="btn" id="add-paralelo"><i class="icon-plus-sign"></i>Agregar Paralelo</button>

<?php foreach($css_files as $file): ?>
    <link type="text/css" rel="stylesheet" href="<?php echo $file; ?>" />
    <base href="<?=site_url()?>" />
<?php endforeach; ?>

<?php foreach($js_files as $file): ?>
    <script src="<?php echo $file; ?>"></script>
<?php endforeach; ?>

<?php echo $output ?>
    
<script>
    $(document).ready(function(){
       $("div#groceryCrudTable_filter").remove(); 
    });
    
    $(document).ready(function() {
        $( "#paralelo" ).dialog({
            autoOpen: false,
            height: 200,
            width: 300,
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
                    document.getElementById("paralelo").title="Agregar Paralelo";
                    $("#paralelo").dialog( "open" );
                }                        
             })            
        });
    });
</script>
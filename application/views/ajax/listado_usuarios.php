<form class="span2" style="float: right;" action="<?=site_url("mantenimiento/expListUsuarios")?>" method="post">
    <button class="btn" type="submit" id="exportar" style="width: 120px;"><i class="icon-download-alt"></i>Excel</button>
    <input type="hidden" id="tipoUsuario" name="tipoUsuario" value="<? echo $u?>" />
    <input type="hidden" id="nombre" name="nombre" value="<? echo $name?>" />
    <input type="hidden" id="indicador" name="indicador" value="1" />
</form>

<form class="span2" style="float: right;" action="<?=site_url("mantenimiento/expListUsuarios")?>" method="post" target="_blank">
    <button class="btn" type="submit" id="exportar" style="width: 120px;"><i class="icon-print"></i>Imprimir</button>
    <input type="hidden" id="tipoUsuario" name="tipoUsuario" value="<? echo $u?>" />
    <input type="hidden" id="nombre" name="nombre" value="<? echo $name?>" />
    <input type="hidden" id="indicador" name="indicador" value="0" />
</form>

<?php foreach($css_files as $file): ?>
	<link type="text/css" rel="stylesheet" href="<?php echo $file; ?>" />
    <base href="<?=site_url()?>" />
<?php endforeach; ?>

<?php foreach($js_files as $file): ?>
	<script src="<?php echo $file; ?>"></script>
<?php endforeach; ?>

<div style="padding-top: 40px;">
    <?php echo $output ?>
</div>

<script>
    $(document).ready(function(){
       $("div#groceryCrudTable_filter").remove();
    });
</script>
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
</script>
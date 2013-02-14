<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
		<title>jQuery UI Autocomplete Ejemplo</title>
		<link type="text/css" href="<?php echo base_url(); ?>css/dark-hive/jquery-ui-1.8.10.custom.css" rel="stylesheet" />	
		<script type="text/javascript" src="<?php echo base_url(); ?>js/jquery-1.4.4.min.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>js/jquery-ui-1.8.10.custom.min.js"></script>
		<script type="text/javascript">
		$(document).ready(function(){
			$('#autocomplete').autocomplete({
				source:'<?php echo site_url('autocomplete/ajax'); ?>',
				select: function(event, ui) {
					alert(ui.item ? "Selected: " + ui.item.id : "Nothing selected, input was " + this.value );
				}
			});
		});
		</script>
	</head>
	<body>
	<p><label for='autocomplete'>Nombre de Usuario: </label><input type='text' id='autocomplete'></p>
	</body>
</html>
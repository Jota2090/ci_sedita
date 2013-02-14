<?php
    $config = array(
		'login/validar'=>array(
            array(
                'field'=>'txtUser',
                'label'=>"Usuario",
                'rules'=>'required'
            ),
            
            array(
                'field'=>'txtClave',
                'label'=>"Clave",
                'rules'=>'required'
            )
        )
    );
?>
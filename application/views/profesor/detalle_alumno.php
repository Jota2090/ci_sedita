<?foreach($rs->result() as $fila):?>
<div class="control-group span4">
    <div class="span4" style="margin-top: 10px;">
        <label class="control-label"><b>Alumno</b></label>
        <div class="controls">
            <input style="width:370px;height: 30px;" type="text" disabled="disabled" value="<?=$fila->alu_apellidos." ".$fila->alu_nombres?>" />
        </div>
    </div>
    
    <div class="span4">
        <label class="control-label" style="margin-top: 10px;"><b>Representante</b></label>
        <div class="controls" style="margin-top: 10px; width:165px;">
            <input style="width:370px;height: 30px;" type="text" disabled="disabled" value="<?=$fila->rep_nombres?>" />
        </div>
    </div>        
    
    <div class="span4" style="margin-top: 10px;">
        <label class="control-label"><b>Direcci&oacute;n</b></label>
        <div class="controls">
            <input style="width: 370px;height: 30px;" type="text" disabled="disabled" value="<?=$fila->alu_domicilio?>"/>
        </div>
    </div>
    
    <div class="span2" style="margin-top: 10px;">
        <label class="control-label"><b>Tel&eacute;fono</b></label>
        <div class="controls">
            <? if($fila->alu_principal_representante=="o"){?>
                <input style="width: 130px;height: 30px;" type="text" disabled="disabled" value="<?=$fila->rep_telefono?>" />
            <? }else{?>
                <input style="width: 130px;height: 30px;" type="text" disabled="disabled" value="<?=$fila->alu_telefono?>" />
            <?}?>
        </div>
    </div>
    
    <div class="span1" style="margin: 10px 0 0 80px;">
        <label class="control-label" ><b>Pa&iacute;s</b></label>
        <div class="controls">
             <input style="width: 150px;height: 30px;" type="text" disabled="disabled" value="<?=$fila->alu_pais?>" />
        </div>
    </div>
    
    
    <div class="span2" style="margin-top: 10px;">
        <label class="control-label"><b>Lugar de nacimiento</b></label>
        <div class="controls">
            <input style="width: 120px;height: 30px;" type="text" disabled="disabled" value="<?=$fila->alu_lugar_nacimiento?>" />
        </div>
    </div>
    
    <div class="span1" style="margin:  10px 0 0 80px;">
        <label class="control-label"><b>Edad</b></label>
        <div class="controls">
            <input style="width:50px;height: 30px;" type="text" disabled="disabled" value="<?=$fila->alu_edad?>" />
        </div>
    </div>
    
    <div class="span4">
        <label class="control-label" style="margin-top: 10px;"><b>Fecha de Nacimiento</b></label>
        <div class="controls" style="margin-top: 10px; width:165px;">
            <input style="width:150px;height: 30px;" type="text" disabled="disabled" value="<?=$fila->alu_fecha_nacimiento?>" />
        </div>
    </div>
</div>    
<?endforeach;?>
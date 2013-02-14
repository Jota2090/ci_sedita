<?if($fob->num_rows>0){
    foreach($fob->result() as $fila){?>
       <div style="margin-top: 10px;">
            <label class="control-label"><b>Observaci&oacute;n :</b></label>
            <div class="controls">
                <textarea id="observacion" name="observacion" style="width: 300px; height: 200px;"><?=html_entity_decode($fila->fob_observacion)?></textarea>
            </div>
        </div> 
    <?}
}
else{?>
    <div style="margin-top: 10px;">
        <label class="control-label"><b>Observaci&oacute;n :</b></label>
        <div class="controls">
            <textarea id="observacion" name="observacion" style="width: 300px; height: 200px;"></textarea>
        </div>
    </div>
<?}?>
<div style="margin-top: 10px;">
    <?if($tri==1){
        if($fob->num_rows>0){
            foreach($fob->result() as $fila){?>
                <label class="control-label"><b>Abril :</b></label>
                <div class="controls">
                    <input type="text" id="nota1" name="nota1" value="<?=$fila->fob_nota1?>" />
                </div>
                
                <label class="control-label" style="margin-top: 5px;"><b>Mayo :</b></label>
                <div class="controls" style="margin-top: 5px;">
                    <input type="text" id="nota2" name="nota2" value="<?=$fila->fob_nota2?>" />
                </div>
                
                <label class="control-label" style="margin-top: 5px;"><b>Junio :</b></label>
                <div class="controls" style="margin-top: 5px;">
                    <input type="text" id="nota3" name="nota3" value="<?=$fila->fob_nota3?>" />
                </div>
                
                <label class="control-label" style="margin-top: 5px;"><b>Examen :</b></label>
                <div class="controls" style="margin-top: 5px;">
                    <input type="text" id="examen" name="examen" value="<?=$fila->fob_examen?>" />
                </div>
            <?}
        }
        else{?>
            <label class="control-label"><b>Abril :</b></label>
                <div class="controls">
                    <input type="text" id="nota1" name="nota1" />
                </div>
                
                <label class="control-label" style="margin-top: 5px;"><b>Mayo :</b></label>
                <div class="controls" style="margin-top: 5px;">
                    <input type="text" id="nota2" name="nota2" />
                </div>
                
                <label class="control-label" style="margin-top: 5px;"><b>Junio :</b></label>
                <div class="controls" style="margin-top: 5px;">
                    <input type="text" id="nota3" name="nota3" />
                </div>
                
                <label class="control-label" style="margin-top: 5px;"><b>Examen :</b></label>
                <div class="controls" style="margin-top: 5px;">
                    <input type="text" id="examen" name="examen" />
                </div>
        <?}
    }
    elseif($tri==2){
        if($fob->num_rows>0){
            foreach($fob->result() as $fila){?>
                <label class="control-label"><b>Julio :</b></label>
                <div class="controls">
                    <input type="text" id="nota1" name="nota1" value="<?=$fila->fob_nota1?>" />
                </div>
                
                <label class="control-label" style="margin-top: 5px;"><b>Agosto :</b></label>
                <div class="controls" style="margin-top: 5px;">
                    <input type="text" id="nota2" name="nota2" value="<?=$fila->fob_nota2?>" />
                </div>
                
                <label class="control-label" style="margin-top: 5px;"><b>Septiembre :</b></label>
                <div class="controls" style="margin-top: 5px;">
                    <input type="text" id="nota3" name="nota3" value="<?=$fila->fob_nota3?>" />
                </div>
                
                <label class="control-label" style="margin-top: 5px;"><b>Examen :</b></label>
                <div class="controls" style="margin-top: 5px;">
                    <input type="text" id="examen" name="examen" value="<?=$fila->fob_examen?>" />
                </div>
            <?}
        }
        else{?>
            <label class="control-label"><b>Julio :</b></label>
                <div class="controls">
                    <input type="text" id="nota1" name="nota1" />
                </div>
                
                <label class="control-label" style="margin-top: 5px;"><b>Agosto :</b></label>
                <div class="controls" style="margin-top: 5px;">
                    <input type="text" id="nota2" name="nota2" />
                </div>
                
                <label class="control-label" style="margin-top: 5px;"><b>Septiembre :</b></label>
                <div class="controls" style="margin-top: 5px;">
                    <input type="text" id="nota3" name="nota3" />
                </div>
                
                <label class="control-label" style="margin-top: 5px;"><b>Examen :</b></label>
                <div class="controls" style="margin-top: 5px;">
                    <input type="text" id="examen" name="examen" />
                </div>
        <?}
    }
    elseif($tri==3){
        if($fob->num_rows>0){
            foreach($fob->result() as $fila){?>
                <label class="control-label"><b>Octubre :</b></label>
                <div class="controls">
                    <input type="text" id="nota1" name="nota1" value="<?=$fila->fob_nota1?>" />
                </div>
                
                <label class="control-label" style="margin-top: 5px;"><b>Noviembre :</b></label>
                <div class="controls" style="margin-top: 5px;">
                    <input type="text" id="nota2" name="nota2" value="<?=$fila->fob_nota2?>" />
                </div>
                
                <label class="control-label" style="margin-top: 5px;"><b>Diciembre :</b></label>
                <div class="controls" style="margin-top: 5px;">
                    <input type="text" id="nota3" name="nota3" value="<?=$fila->fob_nota3?>" />
                </div>
                
                <label class="control-label" style="margin-top: 5px;"><b>Examen :</b></label>
                <div class="controls" style="margin-top: 5px;">
                    <input type="text" id="examen" name="examen" value="<?=$fila->fob_examen?>" />
                </div>
            <?}
        }
        else{?>
            <label class="control-label"><b>Octubre :</b></label>
                <div class="controls">
                    <input type="text" id="nota1" name="nota1" />
                </div>
                
                <label class="control-label" style="margin-top: 5px;"><b>Noviembre :</b></label>
                <div class="controls" style="margin-top: 5px;">
                    <input type="text" id="nota2" name="nota2" />
                </div>
                
                <label class="control-label" style="margin-top: 5px;"><b>Diciembre :</b></label>
                <div class="controls" style="margin-top: 5px;">
                    <input type="text" id="nota3" name="nota3" />
                </div>
                
                <label class="control-label" style="margin-top: 5px;"><b>Examen :</b></label>
                <div class="controls" style="margin-top: 5px;">
                    <input type="text" id="examen" name="examen" />
                </div>
        <?}
    }?>
</div>
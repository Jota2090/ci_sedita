<form  style="margin-bottom: 50px" id="forma" class="form-horizontal" method="post" action="<?=site_url("acta_calificaciones/guardar")?>">
    <input type="hidden" id="mod" name="mod" value="<?=$mod?>" />
    <input type="hidden" id="cur_par" name="cur_par" value="<?=$cur_par?>" />
    <input type="hidden" id="mat_cur" name="mat_cur" value="<?=$mat_cur?>" />
    <input type="hidden" id="anl" name="anl" value="<?=$anl?>" />
    <div style="margin-bottom: 10px;">
        <input type="submit" class="btn btn-primary" style="float: right; margin: 10px 40px 10px 0;" value="Guardar"/>
        <a href="javascript:cancelar()" class="btn" style="float: right; margin: 10px 10px 10px 0;">Cancelar</a>
    </div>
    <table class="table table-bordered" style="clear:both; margin-top: 10px;">
        <thead>
            <tr>
                <th class="span1" style="text-align: center;">No.</th>
                <th class="span6" style="text-align: center;">Nombres y Apellidos</th>
                <th class="span1" style="text-align: center;">Nota1</th>
                <th class="span1" style="text-align: center;">Nota2</th>
                <th class="span1" style="text-align: center;">Nota3</th>
                <th class="span1" style="text-align: center;">Examen</th>
                <th class="span1" style="text-align: center;">Total</th>
                <th class="span1" style="text-align: center;">Promedio</th>
                <th class="span1" style="text-align: center;">Conducta</th>
            </tr>
        </thead>
        <tbody>
        <?php
            $i = 0;
            foreach($resultado->result() as $alumno):
                $i++; ?>
            <tr>
                <td class="span1" style="text-align: center;"><? echo $i; ?></td>
                <td class="span6"><? echo $alumno->alu_apellidos ." " .$alumno->alu_nombres;?></td>
                <td class="span1" style="text-align: center;"><input onkeypress="return validarSoloNumeros(event)" onkeyup="sumar<?echo "".$alumno->alu_id?>()" min="0" max="20" step="1" name="<?php echo "nt1" .$alumno->alu_id ?>" id="<?php echo "nt1" .$alumno->alu_id ?>" class="span1" type="number" placeholder="0"/></td>
                <td class="span1" style="text-align: center;"><input onkeypress="return validarSoloNumeros(event)" onkeyup="sumar<?echo "".$alumno->alu_id?>()" min="0" max="20" step="1" name="<?php echo "nt2" .$alumno->alu_id ?>" id="<?php echo "nt2" .$alumno->alu_id ?>" class="span1" type="number" placeholder="0"/></td>
                <td class="span1" style="text-align: center;"><input onkeypress="return validarSoloNumeros(event)" onkeyup="sumar<?echo "".$alumno->alu_id?>()" min="0" max="20" step="1" name="<?php echo "nt3" .$alumno->alu_id ?>" id="<?php echo "nt3" .$alumno->alu_id ?>" class="span1" type="number" placeholder="0"/></td>
                <td class="span1" style="text-align: center;"><input onkeypress="return validarSoloNumeros(event)" onkeyup="sumar<?echo "".$alumno->alu_id?>()" min="0" max="20" step="1" name="<?php echo "exa" .$alumno->alu_id ?>" id="<?php echo "exa" .$alumno->alu_id ?>" class="span1" type="number" placeholder="0"/></td>
                <td class="span1" style="text-align: center;"><input type="text" disabled="disabled" name="<?php echo "tot1" .$alumno->alu_id ?>" id="<?php echo "tot1" .$alumno->alu_id ?>" class="span1" /></td>
                <td class="span1" style="text-align: center;"><input type="text" disabled="disabled" name="<?php echo "pro1" .$alumno->alu_id ?>" id="<?php echo "pro1" .$alumno->alu_id ?>" class="span1" /></td>
                <input type="hidden" name="<?php echo "tot" .$alumno->alu_id ?>" id="<?php echo "tot" .$alumno->alu_id ?>" class="span1" />
                <input type="hidden" name="<?php echo "pro" .$alumno->alu_id ?>" id="<?php echo "pro" .$alumno->alu_id ?>" class="span1" />
                <td class="span1" style="text-align: center;"><input onkeypress="return validarSoloNumeros(event)"  min="0" max="20" step="1" name="<?php echo "cond" .$alumno->alu_id ?>" id="<?php echo "cond" .$alumno->alu_id ?>" class="span1" type="number" placeholder="0"/></td>
            </tr>  
         <?endforeach; ?>
        </tbody>
    </table>
    <div style="margin-bottom: 10px;">
        <input type="submit" class="btn btn-primary" style="float: right; margin: 10px 40px 10px 0;" value="Guardar"/>
        <a href="javascript:cancelar()" class="btn" style="float: right; margin: 10px 10px 10px 0;">Cancelar</a>
    </div>
</form>
<script language="javascript"> 
    function validarSoloNumeros(e) 
    {
        tecla = (document.all) ? e.keyCode : e.which;
        if (tecla==8) return true;
        else if (tecla==0||tecla==9)  return true;
        patron =/[0-9\\]/;
        te = String.fromCharCode(tecla);
        return patron.test(te);
    }
            
    $(document).ready(function(){
        var va = $("#forma").validate({
            rules:{
    		<?php 
                    $i = 0;
                    foreach($resultado->result() as $alumno):
                        $s = $i - $resultado->num_rows;
                        
                        if($s == 1 ){
                            echo "nt1" .$alumno->alu_id ?>:{
                                maxlength: 5
                            },
                            
                            <? echo "nt2" .$alumno->alu_id ?>:{
                                maxlength: 5
                            },
                            
                            <? echo "nt3" .$alumno->alu_id ?>:{
                                maxlength: 5
                            },
                            
                            <? echo "tot" .$alumno->alu_id ?>:{
                                maxlength: 5
                            },
                            
                            <? echo "pro" .$alumno->alu_id ?>:{
                                maxlength: 5
                            }
                       <?}else{
                            echo "nt1" .$alumno->alu_id ?>:{
                                maxlength: 5
                            },
                            
                            <? echo "nt2" .$alumno->alu_id ?>:{
                                maxlength: 5
                            },
                            
                            <? echo "nt3" .$alumno->alu_id ?>:{
                                maxlength: 5
                            },
                            
                            <? echo "tot" .$alumno->alu_id ?>:{
                                maxlength: 5
                            },
                            
                            <? echo "pro" .$alumno->alu_id ?>:{
                                maxlength: 5
                            },
                        <?}
                        
                        $i++;
                    endforeach; ?>
            }
        });
    });              
    
    <? foreach($resultado->result() as $alumno):?>
    function sumar<?echo "".$alumno->alu_id?>()  { 
        $("<?echo "#tot" .$alumno->alu_id?>").empty();
        $("<?echo "#pro" .$alumno->alu_id?>").empty();
        
        var nota1 = $("<?echo "#nt1".$alumno->alu_id?>").val();  
        var nota2 = $("<?echo "#nt2".$alumno->alu_id?>").val();
        var nota3 = $("<?echo "#nt3".$alumno->alu_id?>").val();
        var examen = $("<?echo "#exa".$alumno->alu_id?>").val();
        var total=0, promedio=0; 
        
        if(nota1==""){
            nota1="0";
        }
        if(nota2==""){
            nota2="0";
        }
        if(nota3==""){
            nota3="0";
        }
        if(examen==""){
            examen="0";
        }
        
        total=parseInt(nota1)+parseInt(nota2)+parseInt(nota3)+parseInt(examen);
        $("<?echo "#tot1" .$alumno->alu_id?>").attr('value', total);
        $("<?echo "#tot" .$alumno->alu_id?>").attr('value', total);
        
        promedio=total/4;
        $("<?echo "#pro1" .$alumno->alu_id?>").attr('value', Math.round(promedio));
        $("<?echo "#pro" .$alumno->alu_id?>").attr('value', Math.round(promedio));
    }  
    <? endforeach ?>
</script>
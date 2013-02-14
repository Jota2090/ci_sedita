<script>
    $(document).ready(function(){
        var va = $("#forma").validate({
            rules:{
    			<?php 
                    $i = 0;
                    foreach($resultado->result() as $alumno):
                        $s = $i - $resultado->num_rows;
                        
                        if($s == 1 ){
                            echo "nt1" .$alumno->alu_id ?>:{
                                number: true,
                                maxlength: 5
                            },
                            
                            <? echo "nt2" .$alumno->alu_id ?>:{
                                number: true,
                                maxlength: 5
                            },
                            
                            <? echo "nt3" .$alumno->alu_id ?>:{
                                number: true,
                                maxlength: 5
                            },
                            
                            <? echo "tot" .$alumno->alu_id ?>:{
                                number: true,
                                maxlength: 5
                            },
                            
                            <? echo "pro" .$alumno->alu_id ?>:{
                                number: true,
                                maxlength: 5
                            }
                       <?}else{
                            echo "nt1" .$alumno->alu_id ?>:{
                                number: true,
                                maxlength: 5
                            },
                            
                            <? echo "nt2" .$alumno->alu_id ?>:{
                                number: true,
                                maxlength: 5
                            },
                            
                            <? echo "nt3" .$alumno->alu_id ?>:{
                                number: true,
                                maxlength: 5
                            },
                            
                            <? echo "tot" .$alumno->alu_id ?>:{
                                number: true,
                                maxlength: 5
                            },
                            
                            <? echo "pro" .$alumno->alu_id ?>:{
                                number: true,
                                maxlength: 5
                            },
                        <?}
                        
                        $i++;
                    endforeach; ?>
            },
            
            messages:{
                <?php 
                    $i = 0;
                    foreach($resultado->result() as $alumno):
                        $s = $i - $resultado->num_rows;
                        
                        if($s == 1 ){
                            echo "nt1" .$alumno->alu_id ?>:{
                                number: "No es un n&uacute;mero"
                            },
                            
                            <? echo "nt2" .$alumno->alu_id ?>:{
                                number: "No es un n&uacute;mero"
                            },
                            
                            <? echo "nt3" .$alumno->alu_id ?>:{
                                number: "No es un n&uacute;mero"
                            },
                            
                            <? echo "tot" .$alumno->alu_id ?>:{
                                number: "No es un n&uacute;mero"
                            },
                            
                            <? echo "pro" .$alumno->alu_id ?>:{
                                number: "No es un n&uacute;mero"
                            }
                       <?}else{
                            echo "nt1" .$alumno->alu_id ?>:{
                                number: "No es un n&uacute;mero"
                            },
                            <? echo "nt2" .$alumno->alu_id ?>:{
                                number: "No es un n&uacute;mero"
                            },
                            
                            <? echo "nt3" .$alumno->alu_id ?>:{
                                number: "No es un n&uacute;mero"
                            },
                            
                            <? echo "tot" .$alumno->alu_id ?>:{
                                number: "No es un n&uacute;mero"
                            },
                            
                            <? echo "pro" .$alumno->alu_id ?>:{
                                number: "No es un n&uacute;mero"
                            }, 
                        <?}
                        
                        $i++;
                    endforeach; ?>
            }
        });
    });              
</script>
<div style="margin-bottom: 90px;">
    <form id="forma" class="form-horizontal" method="post" action="<?=site_url("acta_calificaciones/guardar")?>">
        <input type="hidden" id="tri" name="tri" value="<?=$tri?>" />
        <input type="hidden" id="curso_paralelo" name="curso_paralelo" value="<?=$curso_paralelo?>" />
        <input type="hidden" id="materia_curso" name="materia_curso" value="<?=$materia_curso?>" />
        <input type="hidden" id="anio_lectivo" name="anio_lectivo" value="<?=$anio_lectivo?>" />
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
                    <td class="span1" style="text-align: center;"><input onkeyup="sumar<?echo "".$alumno->alu_id?>()" min="0" max="20" step="1" name="<?php echo "nt1" .$alumno->alu_id ?>" id="<?php echo "nt1" .$alumno->alu_id ?>" class="span1" type="number" placeholder="0"/></td>
                    <td class="span1" style="text-align: center;"><input onkeyup="sumar<?echo "".$alumno->alu_id?>()" min="0" max="20" step="1" name="<?php echo "nt2" .$alumno->alu_id ?>" id="<?php echo "nt2" .$alumno->alu_id ?>" class="span1" type="number" placeholder="0"/></td>
                    <td class="span1" style="text-align: center;"><input onkeyup="sumar<?echo "".$alumno->alu_id?>()" min="0" max="20" step="1" name="<?php echo "nt3" .$alumno->alu_id ?>" id="<?php echo "nt3" .$alumno->alu_id ?>" class="span1" type="number" placeholder="0"/></td>
                    <td class="span1" style="text-align: center;"><input onkeyup="sumar<?echo "".$alumno->alu_id?>()" min="0" max="20" step="1" name="<?php echo "exa" .$alumno->alu_id ?>" id="<?php echo "exa" .$alumno->alu_id ?>" class="span1" type="number" placeholder="0"/></td>
                    <td class="span1" style="text-align: center;"><input type="text" name="<?php echo "tot" .$alumno->alu_id ?>" id="<?php echo "tot" .$alumno->alu_id ?>" class="span1" /></td>
                    <td class="span1" style="text-align: center;"><input type="text" name="<?php echo "pro" .$alumno->alu_id ?>" id="<?php echo "pro" .$alumno->alu_id ?>" class="span1" /></td>
                    <td class="span1" style="text-align: center;"><input min="0" max="20" step="1" name="<?php echo "cond" .$alumno->alu_id ?>" id="<?php echo "cond" .$alumno->alu_id ?>" class="span1" type="number" placeholder="0"/></td>
                </tr>  
             <?endforeach; ?>
            </tbody>
        </table>
        <div style="margin-bottom: 10px;">
            <input type="submit" class="btn btn-primary" style="float: right; margin: 10px 40px 10px 0;" value="Guardar"/>
            <a href="javascript:cancelar()" class="btn" style="float: right; margin: 10px 10px 10px 0;">Cancelar</a>
        </div>
    </form>
</div>
<script language="javascript"> 
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
        $("<?echo "#tot" .$alumno->alu_id?>").attr('value', total);
        
        promedio=total/4;
        $("<?echo "#pro" .$alumno->alu_id?>").attr('value', Math.round(promedio));
    }  
    <? endforeach ?>
</script>
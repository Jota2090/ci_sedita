<form id="forma" class="form-horizontal" method="post" target="_blank" action="<?=site_url("listados/impPromo")?>">
    <input type="hidden" id="alu" name="alu" value="<?=$alumno?>" />
    <input type="hidden" id="esp" name="esp" value="<?=$esp?>" />
    <input type="hidden" id="cur" name="cur" value="<?=$curso?>" />
    <input type="hidden" id="dir" name="dir" value="<?=$dirigente?>" />
    <input type="hidden" id="cp" name="cp" value="<?=$curso_paralelo?>" />
    <input type="hidden" id="anl" name="anl" value="<?=$anio_lectivo?>" />
    <input type="hidden" id="jor" name="jor" value="<?=$jornada?>" />
    <input type="hidden" id="cond1" name="cond1" value="<?=$cond1?>" />
    <input type="hidden" id="cond2" name="cond2" value="<?=$cond2?>" />
    <input type="hidden" id="cond3" name="cond3" value="<?=$cond3?>" />
    <button type="submit" class="btn" style="float: left; margin: 10px 10px 10px 10px;"><i class="icon-print"></i>Imprimir</button>
    
</form>
<div style="margin-bottom: 10px;">
    <a href="javascript:cancelar()" class="btn" style="float: right; margin: 10px 10px 10px 0;">Regresar</a>
</div>
<table class="table table-bordered" style="clear:both; margin-top: 10px;">
    <thead>
        <tr>
            <th class="span1" style="text-align: center;" rowspan="2">No.</th>
            <th class="span9" style="text-align: center;" rowspan="2">A S I G N A T U R A S</th>
            <th class="span1" style="text-align: center;">TRIMESTRE</th>
            <th class="span1" style="text-align: center;">TRIMESTRE</th>
            <th class="span1" style="text-align: center;">TRIMESTRE</th>
            <th class="span1" style="text-align: center;" rowspan="2">TOTAL</th>
            <th class="span1" style="text-align: center;" rowspan="2">PRO T.</th>
            <th class="span1" style="text-align: center;" rowspan="2">SUP.</th>
            <th class="span1" style="text-align: center;" rowspan="2">PRO F.</th>
        </tr>
        <tr>
            <th class="span1" style="text-align: center;">I</th>
            <th class="span1" style="text-align: center;">II</th>
            <th class="span1" style="text-align: center;">III</th>
        </tr>
    </thead>
    <tbody>
    <?php
        $i = 0;
        foreach($materias->result() as $mat):
            $i++;?>
            <?foreach($calificaciones->result() as $cal):
                if($mat->mc_id == $cal->cal_materia_curso_id &&$cal->cal_periodo_escolar_id==1){?>
        <tr>
            <td class="span1" style="text-align: center;"><? echo $i; ?></td>
            <td class="span9"><? echo $mat->mat_nombre;?></td>
            <td class="span1" style="text-align: center;"><input disabled="disabled" id="<? echo "nm1" .$mat->mc_id?>" name="<? echo "nm1" .$mat->mc_id?>" class="span1" type="number" value="<?=$cal->cal_promedio?>"/></td>
                <?}
                elseif($mat->mc_id == $cal->cal_materia_curso_id &&$cal->cal_periodo_escolar_id==2){?>
            <td class="span1" style="text-align: center;"><input disabled="disabled" id="<? echo "nm2" .$mat->mc_id?>" name="<? echo "nm2" .$mat->mc_id?>" class="span1" type="number" value="<?=$cal->cal_promedio?>"/></td>
                <?}
                elseif($mat->mc_id == $cal->cal_materia_curso_id &&$cal->cal_periodo_escolar_id==3){?>
            <td class="span1" style="text-align: center;"><input disabled="disabled" id="<? echo "nm3" .$mat->mc_id?>" name="<? echo "nm3" .$mat->mc_id?>" class="span1" type="number" value="<?=$cal->cal_promedio?>"/></td>
            <td class="span1" style="text-align: center;"><input disabled="disabled" id="<? echo "nmt" .$mat->mc_id?>" name="<? echo "nmt" .$mat->mc_id?>" class="span1" type="number" /></td>
            <td class="span1" style="text-align: center;"><input disabled="disabled" id="<? echo "nmpt" .$mat->mc_id?>" name="<? echo "nmpt" .$mat->mc_id?>" class="span1" type="number" /></td>
            <td class="span1" style="text-align: center;"><input disabled="disabled" id="<? echo "nmsp" .$mat->mc_id?>" name="<? echo "nmsp" .$mat->mc_id?>" class="span1" type="number" value="0" /></td>
            <td class="span1" style="text-align: center;"><input disabled="disabled" id="<? echo "nmpf" .$mat->mc_id?>" name="<? echo "nmpf" .$mat->mc_id?>" class="span1" type="number" /></td>
                <?}
            endforeach;?>
        </tr>
        <?if($i==$materias->num_rows)
            break;
        endforeach;?>
        
        <tr>
            <td class="span1" style="text-align: center;"><?$i++; echo $i; ?></td>
            <td class="span9"><? echo "Promedio";?></td>
            <td class="span1" style="text-align: center;"><input disabled="disabled" id="p1" name="p1" class="span1" type="number" /></td>
            <td class="span1" style="text-align: center;"><input disabled="disabled" id="p2" name="p2" class="span1" type="number" /></td>
            <td class="span1" style="text-align: center;"><input disabled="disabled" id="p3" name="p3" class="span1" type="number" /></td>
            <td class="span1" style="text-align: center;"><input disabled="disabled" id="pt" name="pt" class="span1" type="number" /></td>
            <td class="span1" style="text-align: center;"><input disabled="disabled" id="ppt" name="ppt" class="span1" type="number" /></td>
            <td class="span1" style="text-align: center;"><input disabled="disabled" id="psp" name="psp" class="span1" type="number" value="" /></td>
            <td class="span1" style="text-align: center;"><input disabled="disabled" id="ppf" name="ppf" class="span1" type="number" /></td>
        </tr>
        
        <tr>
            <td class="span1" style="text-align: center;"><?$i++; echo $i; ?></td>
            <td class="span9"><? echo "Conducta";?></td>
            <td class="span1" style="text-align: center;"><input disabled="disabled" id="n1" name="n1" class="span1" type="number" value="<?=$cond1?>"/></td>
            <td class="span1" style="text-align: center;"><input disabled="disabled" id="n2" name="n2" class="span1" type="number" value="<?=$cond2?>"/></td>
            <td class="span1" style="text-align: center;"><input disabled="disabled" id="n3" name="n3" class="span1" type="number" value="<?=$cond3?>"/></td>
            <td class="span1" style="text-align: center;"><input disabled="disabled" id="nt" name="nt" class="span1" type="number" /></td>
            <td class="span1" style="text-align: center;"><input disabled="disabled" id="npt" name="npt" class="span1" type="number" /></td>
            <td class="span1" style="text-align: center;"><input disabled="disabled" id="nsp" name="nsp" class="span1" type="number" value="" /></td>
            <td class="span1" style="text-align: center;"><input disabled="disabled" id="npf" name="npf" class="span1" type="number" /></td>
        </tr>
    </tbody>
</table>
<div style="margin-bottom: 10px;">
    <a href="javascript:cancelar()" class="btn" style="float: right; margin: 10px 10px 10px 0;">Regresar</a>
</div>

<script language="javascript"> 
    $(document).ready(function sumar(){
        var pro=0,cont=0,prom1=0,cond=0,prom2=0,prom3=0,promt=0,promf=0;
        <?foreach($materias->result() as $mat):?>
            var nota1 = $("<? echo "#nm1" .$mat->mc_id?>").val();  
            var nota2 = $("<? echo "#nm2" .$mat->mc_id?>").val();
            var nota3 = $("<? echo "#nm3" .$mat->mc_id?>").val();
            var suple = $("<? echo "#nmsp" .$mat->mc_id?>").val();
            
            prom1=prom1+parseInt(nota1);
            prom2=prom2+parseInt(nota2);
            prom3=prom3+parseInt(nota3);
            
            pro = parseInt(nota1)+parseInt(nota2)+parseInt(nota3);
            $("<? echo "#nmt" .$mat->mc_id?>").attr('value',pro);
            pro = Math.round(pro/3);
            $("<? echo "#nmpt" .$mat->mc_id?>").attr('value',pro);
            
            if(suple!=0&&suple!=null)
                pro = Math.round((pro+parseInt(suple))/2);
            
            $("<? echo "#nmpf" .$mat->mc_id?>").attr('value',pro);
            
            promf=promf+pro;
            cont=cont+1;
        <? endforeach; ?>
        
        prom1=Math.round(prom1/cont);
        prom2=Math.round(prom2/cont);
        prom3=Math.round(prom3/cont);
        $("#p1").attr('value',prom1);
        $("#p2").attr('value',prom2);
        $("#p3").attr('value',prom3);
        
        promt=prom1+prom2+prom3;
        $("#pt").attr('value',promt);
        promt=Math.round(promt/3);
        $("#ppt").attr('value',promt);
        promf=Math.round(promf/cont);
        $("#ppf").attr('value',promf);
        
        cond=parseInt($("#n1").val())+parseInt($("#n2").val())+parseInt($("#n3").val());
        $("#nt").attr('value',cond);
        cond=Math.round(cond/3);
        $("#npt").attr('value',cond);
        $("#npf").attr('value',cond);
    });
</script>
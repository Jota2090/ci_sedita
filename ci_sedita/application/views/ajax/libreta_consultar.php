<form id="forma" class="form-horizontal" method="post" action="<?=site_url("libreta/visualizar_libretas")?>" target="_blank">
    <input type="hidden" id="conducta" name="conducta" value="<?=$conducta?>" />
    <input type="hidden" id="cur" name="cur" value="<?=$curso?>" />
    <input type="hidden" id="esp" name="esp" value="<?=$especializacion?>" />
    <input type="hidden" id="alumno" name="alumno" value="<?=$alumno?>" />
    <input type="hidden" id="tri" name="tri" value="<?=$periodo?>" />
    <input type="hidden" id="par" name="par" value="<?=$paralelo?>" />
    <input type="hidden" id="anio_lectivo" name="anio_lectivo" value="<?=$anio_lectivo?>" />
    <input type="hidden" id="curso_paralelo" name="curso_paralelo" value="<?=$curso_paralelo?>" />
    <input type="hidden" id="jor" name="jor" value="<?=$jornada?>" />
    <input type="hidden" id="indicador" name="indicador" value="1" />
    <div style="margin-bottom: 10px;">
        <button type="submit" class="btn" style="float: left; margin: 10px 10px 10px 40px;"><i class="icon-print"></i>Imprimir</button>
        <button id="add-faltas" type="button" class="btn" style="height:30px; float: left; margin: 10px 10px 10px 300px;"><i class="icon-plus"></i>Faltas</button>
        <button id="add-observaciones" type="button" class="btn" style="height:30px; float: left; margin: 10px 10px 10px 10px;"><i class="icon-plus"></i>Observaciones</button>
        <a href="javascript:cancelar()" class="btn" style="float: right; margin: 10px 40px 10px 0;">Regresar</a>
    </div>
    <table class="table table-bordered" style="clear:both; margin-top: 10px;">
        <thead>
            <tr>
                <th class="span1" style="text-align: center;">No.</th>
                <th class="span7" style="text-align: center;">Asignaturas</th>
                <th class="span1" style="text-align: center;">Nota1</th>
                <th class="span1" style="text-align: center;">Nota2</th>
                <th class="span1" style="text-align: center;">Nota3</th>
                <th class="span1" style="text-align: center;">Examen</th>
                <th class="span1" style="text-align: center;">Total</th>
                <th class="span1" style="text-align: center;">Promedio</th>
            </tr>
        </thead>
        <tbody>
        <?php
            $i = 0;
            foreach($materias->result() as $mat): 
                foreach($calificaciones->result() as $cal):
                    if($mat->mc_id == $cal->cal_materia_curso_id){
                    $i++;?>
            <tr>
                <td class="span1" style="text-align: center;"><? echo $i; ?></td>
                <td class="span7"><? echo $mat->mat_nombre;?></td>
                <td class="span1" style="text-align: center;"><input disabled="disabled" id="<? echo "nm1" .$mat->mc_id?>" name="<? echo "nm1" .$mat->mc_id?>" class="span1" type="number" value="<?=$cal->cal_nota1?>"/></td>
                <td class="span1" style="text-align: center;"><input disabled="disabled" id="<? echo "nm2" .$mat->mc_id?>" name="<? echo "nm2" .$mat->mc_id?>" class="span1" type="number" value="<?=$cal->cal_nota2?>"/></td>
                <td class="span1" style="text-align: center;"><input disabled="disabled" id="<? echo "nm3" .$mat->mc_id?>" name="<? echo "nm3" .$mat->mc_id?>" class="span1" type="number" value="<?=$cal->cal_nota3?>"/></td>
                <td class="span1" style="text-align: center;"><input disabled="disabled" id="<? echo "nm4" .$mat->mc_id?>" name="<? echo "nm4" .$mat->mc_id?>" class="span1" type="number" value="<?=$cal->cal_examen?>"/></td>
                <td class="span1" style="text-align: center;"><input disabled="disabled" id="<? echo "nm5" .$mat->mc_id?>" name="<? echo "nm5" .$mat->mc_id?>" class="span1" type="number" value="<?=$cal->cal_total?>"/></td>
                <td class="span1" style="text-align: center;"><input disabled="disabled" id="<? echo "nm6" .$mat->mc_id?>" name="<? echo "nm6" .$mat->mc_id?>" class="span1" type="number" value="<?=$cal->cal_promedio?>"/></td>
            </tr>
                    <?}
                endforeach;
            endforeach;
            $i++;?>
            <tr>
                <td class="span1" style="text-align: center;"><? echo $i; ?></td>
                <td class="span7">Promedio</td>
                <td class="span1" style="text-align: center;"><input disabled="disabled" id="np1" class="span1" type="number" /></td>
                <td class="span1" style="text-align: center;"><input disabled="disabled" id="np2" class="span1" type="number" /></td>
                <td class="span1" style="text-align: center;"><input disabled="disabled" id="np3" class="span1" type="number" /></td>
                <td class="span1" style="text-align: center;"><input disabled="disabled" id="npe" class="span1" type="number" /></td>
                <td class="span1" style="text-align: center;"><input disabled="disabled" id="npt" class="span1" type="number" /></td>
                <td class="span1" style="text-align: center;"><input disabled="disabled" id="npp" class="span1" type="number" /></td>
            </tr>
            <?$i++;?>
            <tr>
                <td class="span1" style="text-align: center;"><? echo $i ?></td>
                <td class="span7">Conducta</td>
                <td class="span1" style="text-align: center;"><input disabled="disabled" id="cp1" class="span1" type="number" value="<?=$conducta?>"/></td>
                <td class="span1" style="text-align: center;"><input disabled="disabled" id="cp2" class="span1" type="number" value="<?=$conducta?>"/></td>
                <td class="span1" style="text-align: center;"><input disabled="disabled" id="cp3" class="span1" type="number" value="<?=$conducta?>"/></td>
                <td class="span1" style="text-align: center;"><input disabled="disabled" id="cpe" class="span1" type="number" value="<?=$conducta?>"/></td>
                <td class="span1" style="text-align: center;"><input disabled="disabled" id="cpt" class="span1" type="number" /></td>
                <td class="span1" style="text-align: center;"><input disabled="disabled" id="cpp" class="span1" type="number" /></td>
            </tr>
        </tbody>
    </table>
</form>
<script language="javascript"> 
    $(document).ready(function sumar(){
        var pro1=0,pro2=0,pro3=0,pro4=0,prot=0,prop=0,cont=0;
        <?foreach($calificaciones->result() as $cal):?>
            var nota1 = $("<? echo "#nm1" .$cal->cal_materia_curso_id?>").val();  
            var nota2 = $("<? echo "#nm2" .$cal->cal_materia_curso_id?>").val();
            var nota3 = $("<? echo "#nm3" .$cal->cal_materia_curso_id?>").val();
            var examen = $("<? echo "#nm4" .$cal->cal_materia_curso_id?>").val();
            
            pro1 = parseInt(pro1)+parseInt(nota1);
            pro2 = parseInt(pro2)+parseInt(nota2);
            pro3 = parseInt(pro3)+parseInt(nota3);
            pro4 = parseInt(pro4)+parseInt(examen);
            cont = parseInt(cont)+1;
        <? endforeach; ?>
        
        pro1 = Math.round(pro1/cont);
        pro2 = Math.round(pro2/cont);
        pro3 = Math.round(pro3/cont);
        pro4 = Math.round(pro4/cont);
        
        $("#np1").attr('value', pro1);
        $("#np2").attr('value', pro2);
        $("#np3").attr('value', pro3);
        $("#npe").attr('value', pro4);
        
        prot=parseInt(pro1)+parseInt(pro2)+parseInt(pro3)+parseInt(pro4);
        prop=Math.round(prot/4);
        
        $("#npt").attr('value', prot);
        $("#npp").attr('value', prop);
        
        var cond1 = $("#cp1").val();  
        var cond2 = $("#cp2").val();
        var cond3 = $("#cp3").val();
        var cond4 = $("#cpe").val();
        
        prot=parseInt(cond1)+parseInt(cond2)+parseInt(cond3)+parseInt(cond4);
        prop=Math.round(prot/4);
        
        $("#cpt").attr('value', prot);
        $("#cpp").attr('value', prop);
    });
    
    $(document).ready(function() {
        $( "#faltas" ).dialog({
            autoOpen: false,
            height: 410,
            width: 320,
            modal: true,
            buttons: {
                Guardar: function(){
                    var nota1 = $('input[name=nota1]').val();
                    var nota2 = $('input[name=nota2]').val();
                    var nota3 = $('input[name=nota3]').val();
                    var examen = $('input[name=examen]').val();
                    var alu = $('input[name=alumno]').val();
                    var tri = $('input[name=tri]').val();
                    var anl = $('input[name=anio_lectivo]').val();
                    
                    if((nota1=="" || nota1==null)&&(nota2=="" || nota2==null)
                        &&(nota3=="" || nota3==null)&&(examen=="" || examen==null)){
                        $( this ).dialog( "close" );
                    }
                    else{
                        $.ajax({
                            type:"post",
                            url: "<?=site_url("libreta/guardar_faltas")?>",
                            data:"nt1="+nota1+"&nt2="+nota2+"&nt3="+nota3+"&exa="+examen+"&alu="+alu
                                    +"&tri="+tri+"&anl="+anl,
                            success:function(info){
                                $("#mensaje").empty();
                                $("#mensaje").html(info);
                            }
                        });
                        
                        $( this ).dialog( "close" );
                    }
                },
                Salir: function() {
                    $( this ).dialog( "close" );
                }
            },
            close: function() {
            }
        });
        
        $( "#add-faltas" ).button().click(function() {
            var alu = $('input[name=alumno]').val();
            var tri = $('input[name=tri]').val();
            var anl = $('input[name=anio_lectivo]').val();
            
            $.ajax({
                type: 'post',
                url:"<?=site_url("libreta/agregar_faltas")?>",
                data:"alu="+alu+"&tri="+tri+"&anl="+anl,
                success: function(data){
                    $("#faltas").empty();
                    $("#faltas").append(data);
                    $("#faltas").dialog( "open" );
                }                        
             })            
        });
        
        $( "#observaciones" ).dialog({
            autoOpen: false,
            height: 400,
            width: 350,
            modal: true,
            buttons: {
                Guardar: function(){
                    var obs = $('#observacion').val();
                    var alu = $('input[name=alumno]').val();
                    var tri = $('input[name=tri]').val();
                    var anl = $('input[name=anio_lectivo]').val();
                    
                    if(obs=="" || obs==null){
                        $( this ).dialog( "close" );
                    }
                    else{
                        $.ajax({
                            type:"post",
                            url: "<?=site_url("libreta/guardar_observaciones")?>",
                            data:"obs="+obs+"&alu="+alu+"&tri="+tri+"&anl="+anl,
                            success:function(info){
                                $("#mensaje").empty();
                                $("#mensaje").html(info);
                            }
                        });
                        
                        $( this ).dialog( "close" );
                    }
                },
                Salir: function() {
                    $( this ).dialog( "close" );
                }
            },
            close: function() {
            }
        });
        
        $( "#add-observaciones" ).button().click(function() {
            var alu = $('input[name=alumno]').val();
            var tri = $('input[name=tri]').val();
            var anl = $('input[name=anio_lectivo]').val();
            
            $.ajax({
                type: 'post',
                url:"<?=site_url("libreta/agregar_observaciones")?>",
                data:"alu="+alu+"&tri="+tri+"&anl="+anl,
                success: function(data){
                    $("#observaciones").empty();
                    $("#observaciones").append(data);
                    $("#observaciones").dialog( "open" );
                }                        
             })          
        });
    });
</script>
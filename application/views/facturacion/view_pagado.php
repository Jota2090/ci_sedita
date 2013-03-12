<script>
    function eliminar(chk) {
        var alu = $("#cmbAlumnos").find(":selected").val();

        $.ajax({
            type: "post",
            url: "<?= site_url("facturacion/eliminar_concepto") ?>",
            data: "alu=" + alu + "&chk=" + chk ,
            success: function(info) {
                $("#cobros").empty();
                $("#pagos").empty();
                
                $.ajax({
                    type: "post",
                    url: "<?= site_url("facturacion/cobros_pagos") ?>",
                    data: "alu=" + alu + "&ind=1",
                    success: function(info) {
                        $("#cobros").html(info);
                        
                        $.ajax({
                            type: "post",
                            url: "<?= site_url("facturacion/cobros_pagos") ?>",
                            data: "alu=" + alu + "&ind=0",
                            success: function(info) {
                                $("#pagos").html(info);
                            }
                        });
                    }
                });
            }
        });
    };
</script>
<? if ($t1==1||$t2==1||$t3==1||$t4==1||$t5==1||$t6==1||$t7==1||$t8==1
        ||$t9==1||$t10==1||$t11==1||$t12==1||$t13==1){
    
    $cont=0; ?>
   <table class="table-bordered">
        <tr>
            <th>CONCEPTOS</th>
            <th>CANT.</th>
            <th></th>
        </tr>
        <?if($t1==1){?>
            <tr>
                <td>Matr&iacute;cula</td>
                <? $cont=$cont+$val1; ?>
                <td align="center"><?="$  ".$val1?></td>
                <td align="center"><a title="cancelar" href="javascript:eliminar(1)"><i class="icon-remove-sign"></i></a></td>
            </tr>
            <?}
        ?>
        <?if($t12==1){?>
            <tr>
                <td>Derecho de Examen 1</td>
                <? $cont=$cont+$val2; ?>
                <td align="center"><?="$  ".$val2?></td>
                <td align="center"><a title="cancelar" href="javascript:eliminar(12)"><i class="icon-remove-sign"></i></a></td>
            </tr>
            <?}
        ?>
        <?if($t13==1){?>
            <tr>
                <td>Derecho de Examen 2</td>
                <? $cont=$cont+$val2; ?>
                <td align="center"><?="$  ".$val2?></td>
                <td align="center"><a title="cancelar" href="javascript:eliminar(13)"><i class="icon-remove-sign"></i></a></td>
            </tr>
            <?}
        ?>
        <?if($t2==1){?>
            <tr>
                <td>Mensualidad MAYO</td>
                <? $cont=$cont+$val3; ?>
                <td align="center"><?="$  ".$val3?></td>
                <td align="center"><a title="cancelar" href="javascript:eliminar(2)"><i class="icon-remove-sign"></i></a></td>
            </tr>
            <?}
        ?>
        <?if($t3==1){?>
            <tr>
                <td>Mensualidad JUNIO</td>
                <? $cont=$cont+$val3; ?>
                <td align="center"><?="$  ".$val3?></td>
                <td align="center"><a title="cancelar" href="javascript:eliminar(3)"><i class="icon-remove-sign"></i></a></td>
            </tr>
            <?}
        ?>
        <?if($t4==1){?>
            <tr>
                <td>Mensualidad JULIO</td>
                <? $cont=$cont+$val3; ?>
                <td align="center"><?="$  ".$val3?></td>
                <td align="center"><a title="cancelar" href="javascript:eliminar(4)"><i class="icon-remove-sign"></i></a></td>
            </tr>
            <?}
        ?>
        <?if($t5==1){?>
            <tr>
                <td>Mensualidad AGOSTO</td>
                <? $cont=$cont+$val3; ?>
                <td align="center"><?="$  ".$val3?></td>
                <td align="center"><a title="cancelar" href="javascript:eliminar(5)"><i class="icon-remove-sign"></i></a></td>
            <?}
        ?>
        <?if($t6==1){?>
            <tr>
                <td>Mensualidad SEPTIEMBRE</td>
                <? $cont=$cont+$val3; ?>
                <td align="center"><?="$  ".$val3?></td>
                <td align="center"><a title="cancelar" href="javascript:eliminar(6)"><i class="icon-remove-sign"></i></a></td>
            </tr>
            <?}
        ?>
        <?if($t7==1){?>
            <tr>
                <td>Mensualidad OCTUBRE</td>
                <? $cont=$cont+$val3; ?>
                <td align="center"><?="$  ".$val3?></td>
                <td align="center"><a title="cancelar" href="javascript:eliminar(7)"><i class="icon-remove-sign"></i></a></td>
            </tr>
            <?}
        ?>
        <?if($t8==1){?>
            <tr>
                <td>Mensualidad NOVIEMBRE</td>
                <? $cont=$cont+$val3; ?>
                <td align="center"><?="$  ".$val3?></td>
                <td align="center"><a title="cancelar" href="javascript:eliminar(8)"><i class="icon-remove-sign"></i></a></td>
            </tr>
            <?}
        ?>
        <?if($t9==1){?>
            <tr>
                <td>Mensualidad DICIEMBRE</td>
                <? $cont=$cont+$val3; ?>
                <td align="center"><?="$  ".$val3?></td>
                <td align="center"><a title="cancelar" href="javascript:eliminar(9)"><i class="icon-remove-sign"></i></a></td>
            </tr>
            <?}
        ?>
        <?if($t10==1){?>
            <tr>
                <td>Mensualidad ENERO</td>
                <? $cont=$cont+$val3; ?>
                <td align="center"><?="$  ".$val3?></td>
                <td align="center"><a title="cancelar" href="javascript:eliminar(10)"><i class="icon-remove-sign"></i></a></td>
            </tr>
            <?}
        ?>
        <?if($t11==1){?>
            <tr>
                <td>Mensualidad FEBRERO</td>
                <? $cont=$cont+$val3; ?>
                <td align="center"><?="$  ".$val3?></td>
                <td align="center"><a title="cancelar" href="javascript:eliminar(11)"><i class="icon-remove-sign"></i></a></td>
            </tr>
            <?}
        ?>
            <tr>
                <td><b>TOTAL PAGADO</b></td>
                <td text-align="right" colspan="2"><b><?="$  ".$cont?></b></td>
            </tr>
    </table>
<form id="forma" name="forma" method="post" action="<?=  site_url("facturacion/est_cuenta")?>" target="_blank">
    <input type="hidden" id="alu" name="alu" value="<?=$alu?>" />
    <div style="float:left; width:300px; margin-top: 10px">
        <input style="float:right;" type="submit" id="btnImprimir" class="btn btn-primary" value="Generar Estado de Cuenta" />
    </div>
</form>
<?}
else{?>
    <table class="table-bordered">
        <tr>
            <th>CONCEPTOS</th>
            <th colspan="2">CANT.</th>
        </tr>
        <tr>
            <td align="center" colspan="3">No hay Datos para mostrar</td>
        </tr>
    </table>
<?}?>
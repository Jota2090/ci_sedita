<script>
    $(function() {
        $("#selectall").click(function() {
            $('.case').attr('checked', this.checked);
        });

        $(".case").click(function() {
            if ($(".case").length == $(".case:checked").length) {
                $("#selectall").attr("checked", "checked");
            } else {
                $("#selectall").removeAttr("checked");
            }
        });
    });

    function cobrar() {
        var alu = $("#cmbAlumnos").find(":selected").val();
        var chk1 = $("input[name=case1]:checked").val();
        var chk2 = $("input[name=case2]:checked").val();
        var chk3 = $("input[name=case3]:checked").val();
        var chk4 = $("input[name=case4]:checked").val();
        var chk5 = $("input[name=case5]:checked").val();
        var chk6 = $("input[name=case6]:checked").val();
        var chk7 = $("input[name=case7]:checked").val();
        var chk8 = $("input[name=case8]:checked").val();
        var chk9 = $("input[name=case9]:checked").val();
        var chk10 = $("input[name=case10]:checked").val();
        var chk11 = $("input[name=case11]:checked").val();
        var chk12 = $("input[name=case12]:checked").val();
        var chk13 = $("input[name=case13]:checked").val();
        
        $("#cobros").empty();
        $("#pagos").empty();
        
        $.ajax({
            type: "post",
            url: "<?= site_url("facturacion/cobrar_conceptos") ?>",
            data: "alu=" + alu + "&chk1=" + chk1 + "&chk2=" + chk2 + "&chk3=" + chk3 + "&chk4=" + chk4 + "&chk5=" + chk5
                    + "&chk6=" + chk6 + "&chk7=" + chk7 + "&chk8=" + chk8 + "&chk9=" + chk9 + "&chk10=" + chk10
                    + "&chk11=" + chk11 + "&chk12=" + chk12 + "&chk13=" + chk13,
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

<?
if ($t1 == 0 || $t2 == 0 || $t3 == 0 || $t4 == 0 || $t5 == 0 || $t6 == 0 || $t7 == 0 || $t8 == 0 || $t9 == 0 || $t10 == 0 || $t11 == 0 || $t12 == 0 || $t13 == 0) {

    $cont = 0;
    ?>
    <form id="forma" name="forma" action="<?= site_url("facturacion/cobrar") ?>" target="_blank">
        <table class="table-bordered">
            <tr>
                <th>CONCEPTOS</th>
                <th>CANT.</th>
                <th><input type="checkbox" id="selectall"/></th>
            </tr>
    <? if ($t1 == 0) { ?>
                <tr>
                    <td>Matr&iacute;cula</td>
        <? $cont = $cont + $val1; ?>
                    <td align="center"><?= "$  " . $val1 ?></td>
                    <td align="center"><input type="checkbox" class="case" name="case1" value="1"/></td>
                </tr>
            <? }
            ?>
    <? if ($t12 == 0) { ?>
                <tr>
                    <td>Derecho de Examen 1</td>
        <? $cont = $cont + $val2; ?>
                    <td align="center"><?= "$  " . $val2 ?></td>
                    <td align="center"><input type="checkbox" class="case" name="case12" value="12"/></td>
                </tr>
            <? }
            ?>
    <? if ($t13 == 0) { ?>
                <tr>
                    <td>Derecho de Examen 2</td>
        <? $cont = $cont + $val2; ?>
                    <td align="center"><?= "$  " . $val2 ?></td>
                    <td align="center"><input type="checkbox" class="case" name="case13" value="13"/></td>
                </tr>
            <? }
            ?>
    <? if ($t2 == 0) { ?>
                <tr>
                    <td>Mensualidad MAYO</td>
        <? $cont = $cont + $val3; ?>
                    <td align="center"><?= "$  " . $val3 ?></td>
                    <td align="center"><input type="checkbox" class="case" name="case2" value="2"/></td>
                </tr>
            <? }
            ?>
    <? if ($t3 == 0) { ?>
                <tr>
                    <td>Mensualidad JUNIO</td>
        <? $cont = $cont + $val3; ?>
                    <td align="center"><?= "$  " . $val3 ?></td>
                    <td align="center"><input type="checkbox" class="case" name="case3" value="3"/></td>
                </tr>
            <? }
            ?>
    <? if ($t4 == 0) { ?>
                <tr>
                    <td>Mensualidad JULIO</td>
        <? $cont = $cont + $val3; ?>
                    <td align="center"><?= "$  " . $val3 ?></td>
                    <td align="center"><input type="checkbox" class="case" name="case4" value="4"/></td>
                </tr>
            <? }
            ?>
    <? if ($t5 == 0) { ?>
                <tr>
                    <td>Mensualidad AGOSTO</td>
        <? $cont = $cont + $val3; ?>
                    <td align="center"><?= "$  " . $val3 ?></td>
                    <td align="center"><input type="checkbox" class="case" name="case5" value="5"/></td>
                </tr>
            <? }
            ?>
    <? if ($t6 == 0) { ?>
                <tr>
                    <td>Mensualidad SEPTIEMBRE</td>
        <? $cont = $cont + $val3; ?>
                    <td align="center"><?= "$  " . $val3 ?></td>
                    <td align="center"><input type="checkbox" class="case" name="case6" value="6"/></td>
                </tr>
            <? }
            ?>
    <? if ($t7 == 0) { ?>
                <tr>
                    <td>Mensualidad OCTUBRE</td>
        <? $cont = $cont + $val3; ?>
                    <td align="center"><?= "$  " . $val3 ?></td>
                    <td align="center"><input type="checkbox" class="case" name="case7" value="7"/></td>
                </tr>
            <? }
            ?>
    <? if ($t8 == 0) { ?>
                <tr>
                    <td>Mensualidad NOVIEMBRE</td>
        <? $cont = $cont + $val3; ?>
                    <td align="center"><?= "$  " . $val3 ?></td>
                    <td align="center"><input type="checkbox" class="case" name="case8" value="8"/></td>
                </tr>
            <? }
            ?>
    <? if ($t9 == 0) { ?>
                <tr>
                    <td>Mensualidad DICIEMBRE</td>
        <? $cont = $cont + $val3; ?>
                    <td align="center"><?= "$  " . $val3 ?></td>
                    <td align="center"><input type="checkbox" class="case" name="case9" value="9"/></td>
                </tr>
            <? }
            ?>
    <? if ($t10 == 0) { ?>
                <tr>
                    <td>Mensualidad ENERO</td>
        <? $cont = $cont + $val3; ?>
                    <td align="center"><?= "$  " . $val3 ?></td>
                    <td align="center"><input type="checkbox" class="case" name="case10" value="10"/></td>
                </tr>
            <? }
            ?>
    <? if ($t11 == 0) { ?>
                <tr>
                    <td>Mensualidad FEBRERO</td>
        <? $cont = $cont + $val3; ?>
                    <td align="center"><?= "$  " . $val3 ?></td>
                    <td align="center"><input type="checkbox" class="case" name="case11" value="11"/></td>
                </tr>
    <? } ?>
            <tr>
                <td><b>TOTAL POR COBRAR</b></td>
                <td text-align="right" colspan="2"><b><?= "$  " . $cont ?></b></td>
            </tr>
        </table>
        <div style="float:left; width:300px; margin-top: 10px">
            <a style="float:right; width: 100px;" href="javascript:cobrar()" id="btnCobrar" class="btn btn-primary" >Cobrar</a>
        </div>
    </form>
<? } else {
    ?>
    <table class="table-bordered">
        <tr>
            <th>CONCEPTOS</th>
            <th>CANT.</th>
            <th><input type="checkbox" id="selectall"/></th>
        </tr>
        <tr>
            <td align="center" colspan="3">No hay Datos para mostrar</td>
        </tr>
    </table>
<?
}?>
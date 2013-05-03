<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <title>Sedita Cobros</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description" content="" />
    <meta name="Sedita" content="" />
    <base href="<?=site_url()?>" />
    
    <!-- Le styles -->
    <link href="assets/css/bootstrap.css" rel="stylesheet" />
    <link href="assets/css/bootstrap.min.css" rel="stylesheet"/>
    <link rel="shortcut icon" href="assets/ico/favicon.ico"/>
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="assets/ico/apple-touch-icon-144-precomposed.png" />
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="assets/ico/apple-touch-icon-114-precomposed.png" />
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="assets/ico/apple-touch-icon-72-precomposed.png" />
    <link rel="apple-touch-icon-precomposed" href="assets/ico/apple-touch-icon-57-precomposed.png" />
    
    <script src="assets/js/jquery-bootstrap.js"></script>
    <script src="assets/js/bootstrap-alert.js"></script>
    <script src="assets/js/bootstrap-modal.js"></script>
    <script src="assets/js/bootstrap-dropdown.js"></script>
    <script src="js/jquery-1.8.3.min.js"></script>
    <script src="js/jquery-ui.js"></script>
    <script src="js/jquery.validate.js"></script>
        
    <style type="text/css">
        body {
            width: 1320px;
            padding-top: 10px;
            padding-bottom: 10px;
            margin: 0 auto;
            font-family: Arial;
            font-size: 14px;        
        }
        .sidebar-nav {
            padding: 9px 0;
        }
    </style>
    
    <script>
        $(function(){
            $("#selectall").click(function () {
                  $('.case').attr('checked', this.checked);
            });

            $(".case").click(function(){
                if($(".case").length == $(".case:checked").length) {
                    $("#selectall").attr("checked", "checked");
                } else {
                    $("#selectall").removeAttr("checked");
                }

            });
        });
        
        function eliminar(valor){
             var forma = document.getElementById("pagos");
             forma.pago.value = valor;
             
             document.pagos.submit();
        }
    </script>
  </head>

  <body data-spy="scroll" data-target=".bs-docs-sidebar">
    <div class="container-fluid">
      <div class="row-fluid">
        <div class="panel" style="padding:10px 0px;margin:0px;">
            <form id="forma" name="forma" class="form-horizontal" method="post" >
                <div class="control-group">
                    <div>
                        <label class="control-label"><b>Alumno:</b></label>
                        <div class="controls">
                             <input readonly="true" style="width:500px;border:none; background: transparent;" id="cat" name="cat" type="text" value="<?echo $alumno;?>" />
                        </div>
                    </div>
                        
                    <div style="clear:both;">
                        <label class="control-label"><b>Categor&iacute;a:</b></label>
                        <div class="controls">
                             <input readonly="true" style="width:75px;border:none; background: transparent;" id="cat" name="cat" type="text" value="<?echo $categoria;?>" />
                        </div>
                    </div>
                </div>
             </form>
            
            <div class="panel span5" style="width:420px; padding:15px;">
                 <? if ($t1 == 0 || $t2 == 0 || $t3 == 0 || $t4 == 0 || $t5 == 0 || $t6 == 0 || $t7 == 0 || $t8 == 0 || $t9 == 0 || $t10 == 0 || $t11 == 0 || $t12 == 0 || $t13 == 0) {
                     $cont = 0;?>
                <form id="cobros" action="<?=site_url("facturacion/cobrar_conceptos")?>" name="cobros" method="post">
                    <input type="hidden" name="alumno" id="alumno" value="<?echo $alu;?>" />
                    <div align="right"><button type="submit" style="margin-bottom: 10px; width: 100px;" id="btnCobrar" class="btn btn-primary" >Cobrar</button></div>
                    <table class="table-bordered">
                             <tr>
                                 <th>CONCEPTOS POR COBRAR</th>
                                 <th>CANT.</th>
                                 <th><input type="checkbox" id="selectall"/></th>
                             </tr>
                     <? if ($t1 == 0) { ?>
                                 <tr>
                                     <td>Matr&iacute;cula</td>
                         <? $cont = $cont + $val1; ?>
                                     <td align="center"><?= "$  " . $val1 ?></td>
                                     <td align="center"><input type="checkbox" class="case" name="case[]" value="1"/></td>
                                 </tr>
                             <? }
                             ?>
                     <? if ($t12 == 0) { ?>
                                 <tr>
                                     <td>Derecho de Examen 1</td>
                         <? $cont = $cont + $val2; ?>
                                     <td align="center"><?= "$  " . $val2 ?></td>
                                     <td align="center"><input type="checkbox" class="case" name="case[]" value="12"/></td>
                                 </tr>
                             <? }
                             ?>
                     <? if ($t13 == 0) { ?>
                                 <tr>
                                     <td>Derecho de Examen 2</td>
                         <? $cont = $cont + $val2; ?>
                                     <td align="center"><?= "$  " . $val2 ?></td>
                                     <td align="center"><input type="checkbox" class="case" name="case[]" value="13"/></td>
                                 </tr>
                             <? }
                             ?>
                     <? if ($t2 == 0) { ?>
                                 <tr>
                                     <td>Mensualidad MAYO</td>
                         <? $cont = $cont + $val3; ?>
                                     <td align="center"><?= "$  " . $val3 ?></td>
                                     <td align="center"><input type="checkbox" class="case" name="case[]" value="2"/></td>
                                 </tr>
                             <? }
                             ?>
                     <? if ($t3 == 0) { ?>
                                 <tr>
                                     <td>Mensualidad JUNIO</td>
                         <? $cont = $cont + $val3; ?>
                                     <td align="center"><?= "$  " . $val3 ?></td>
                                     <td align="center"><input type="checkbox" class="case" name="case[]" value="3"/></td>
                                 </tr>
                             <? }
                             ?>
                     <? if ($t4 == 0) { ?>
                                 <tr>
                                     <td>Mensualidad JULIO</td>
                         <? $cont = $cont + $val3; ?>
                                     <td align="center"><?= "$  " . $val3 ?></td>
                                     <td align="center"><input type="checkbox" class="case" name="case[]" value="4"/></td>
                                 </tr>
                             <? }
                             ?>
                     <? if ($t5 == 0) { ?>
                                 <tr>
                                     <td>Mensualidad AGOSTO</td>
                         <? $cont = $cont + $val3; ?>
                                     <td align="center"><?= "$  " . $val3 ?></td>
                                     <td align="center"><input type="checkbox" class="case" name="case[]" value="5"/></td>
                                 </tr>
                             <? }
                             ?>
                     <? if ($t6 == 0) { ?>
                                 <tr>
                                     <td>Mensualidad SEPTIEMBRE</td>
                         <? $cont = $cont + $val3; ?>
                                     <td align="center"><?= "$  " . $val3 ?></td>
                                     <td align="center"><input type="checkbox" class="case" name="case[]" value="6"/></td>
                                 </tr>
                             <? }
                             ?>
                     <? if ($t7 == 0) { ?>
                                 <tr>
                                     <td>Mensualidad OCTUBRE</td>
                         <? $cont = $cont + $val3; ?>
                                     <td align="center"><?= "$  " . $val3 ?></td>
                                     <td align="center"><input type="checkbox" class="case" name="case[]" value="7"/></td>
                                 </tr>
                             <? }
                             ?>
                     <? if ($t8 == 0) { ?>
                                 <tr>
                                     <td>Mensualidad NOVIEMBRE</td>
                         <? $cont = $cont + $val3; ?>
                                     <td align="center"><?= "$  " . $val3 ?></td>
                                     <td align="center"><input type="checkbox" class="case" name="case[]" value="8"/></td>
                                 </tr>
                             <? }
                             ?>
                     <? if ($t9 == 0) { ?>
                                 <tr>
                                     <td>Mensualidad DICIEMBRE</td>
                         <? $cont = $cont + $val3; ?>
                                     <td align="center"><?= "$  " . $val3 ?></td>
                                     <td align="center"><input type="checkbox" class="case" name="case[]" value="9"/></td>
                                 </tr>
                             <? }
                             ?>
                     <? if ($t10 == 0) { ?>
                                 <tr>
                                     <td>Mensualidad ENERO</td>
                         <? $cont = $cont + $val3; ?>
                                     <td align="center"><?= "$  " . $val3 ?></td>
                                     <td align="center"><input type="checkbox" class="case" name="case[]" value="10"/></td>
                                 </tr>
                             <? }
                             ?>
                     <? if ($t11 == 0) { ?>
                                 <tr>
                                     <td>Mensualidad FEBRERO</td>
                         <? $cont = $cont + $val3; ?>
                                     <td align="center"><?= "$  " . $val3 ?></td>
                                     <td align="center"><input type="checkbox" class="case" name="case[]" value="11"/></td>
                                 </tr>
                     <? } ?>
                             <tr>
                                 <td><b>TOTAL POR COBRAR</b></td>
                                 <td text-align="right" colspan="2"><b><?= "$  " . $cont ?></b></td>
                             </tr>
                    </table>
                </form>
                 <? } else { ?>
                     <table class="table-bordered">
                         <tr>
                             <th>CONCEPTOS POR COBRAR</th>
                             <th>CANT.</th>
                             <th><input type="checkbox" id="selectall"/></th>
                         </tr>
                         <tr>
                             <td align="center" colspan="3">No hay Datos para mostrar</td>
                         </tr>
                     </table>
                 <?}?>
             </div>
            <div class="control-group panel span4" style="width:350px;float:left; padding: 15px" >
                <? if ($t1==1||$t2==1||$t3==1||$t4==1||$t5==1||$t6==1||$t7==1||$t8==1||$t9==1||$t10==1||$t11==1||$t12==1||$t13==1){
                    $cont=0; ?>
                <form id="pagos" action="<?=site_url("facturacion/eliminar_concepto")?>" name="pagos" method="post">
                   <input type="hidden" name="alumno" id="alumno" value="<?echo $alu;?>" />
                   <input type="hidden" name="pago" id="pago" value="" />
                   <table class="table-bordered">
                        <tr>
                            <th>CONCEPTOS PAGADOS</th>
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
                </form>
                <form id="forma" name="forma" method="post" action="<?=  site_url("facturacion/estado_cuenta")?>" target="_blank">
                    <input type="hidden" id="alu" name="alu" value="<?=$alu?>" />
                    <div style="float:left; width:300px; margin-top: 10px">
                        <input style="float:right;" type="submit" id="btnImprimir" class="btn btn-primary" value="Generar Estado de Cuenta" />
                    </div>
                </form>
                <?}
                else{?>
                    <table class="table-bordered">
                        <tr>
                            <th>CONCEPTOS PAGADOS</th>
                            <th colspan="2">CANT.</th>
                        </tr>
                        <tr>
                            <td align="center" colspan="3">No hay Datos para mostrar</td>
                        </tr>
                    </table>
                <?}?>
             </div>
          </div>
      </div><!--/row-->
    </div><!--/.fluid-container-->
    
  </body>
</html>
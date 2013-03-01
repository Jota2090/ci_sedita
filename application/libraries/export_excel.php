<?php
    if (!defined('BASEPATH'))
        exit('No tiene Permiso para acceder directamente al Script');
    
    class export_excel
    {
        function setHeader($excel_file_name)  
        {   
            header("Content-type: application/vnd.ms-excel");  
            header("Content-Disposition: attachment; filename=$excel_file_name");  
            header("Pragma: no-cache");  
            header("Expires: 0");    
        }    
        
        function exportToExcel($resultado,$excel_file_name,$num_columnas,$nom_columnas, $nom_tabla)  
        {  
            $header="<center><table border=1px><tr>";  
                for($i=0;$i<$num_columnas;$i++){     
                    $header.="<th>".$nom_columnas[$i]."</th>";
                }
            $header.="</tr>";
            
            $body="";  
            
            foreach ($resultado->result() as $fila){
                $body.="<center><tr>";
                for($i=0;$i<$num_columnas;$i++){     
                    $body.="<td>".$fila->$nom_tabla[$i]."</td>";
                }
                $body.="</tr>";
            }
            
            $this->setHeader($excel_file_name);  
            
            echo $header.$body."</table>";  
        }
        
        function exportToExcel_CuadroHonor($promedios,$excel_file_name,$periodo,$ano_lectivo,$curso,$esp,$jornada)  
        {  
            $header="<center><table border=1px><tr>";  
            $header.="<th colspan='9' style='align:center;'>Acta de Calificaciones de ".$curso."</th>";
            $header.="</tr>";
            
            $header.="<tr>";  
            $header.="<th>Curso</th>";
            $header.="<th colspan='4'>".$curso." ".$esp."</th>";
            $header.="<th colspan='2'>Jornada</th>";
            $header.="<th colspan='2'>".$jornada ."</th>";
            $header.="</tr>";
            
            $header.="<tr>";  
            $header.="<th>Trimestre</th>";
            $header.="<th colspan='3'>".$periodo ."</th>";
            $header.="<th colspan='2'>A�o Lect�vo</th>";
            $header.="<th colspan='3'>".$ano_lectivo ."</th>";
            $header.="</tr>";
            
            $header.="<tr>";
            $header.="<th>No.</th>";
            $header.="<th colspan='6'>Nombres y Apellidos</th>";
            $header.="<th colspan='2'>Promedio</th>";
            $header.="</tr>";
            
            $body="";  
            
            $i=0;
            foreach($promedios as $fila){
                $i++;
                $body.="<center><tr>";
                $body.="<td>".$i."</td>";
                $body.="<td colspan='6'>".$fila["alumno"]."</td>";
                $body.="<td colspan='2'>".$fila["promedio"]."</td>";
                $body.="</tr>";
            }  
            
            $this->setHeader($excel_file_name);  
            
            echo $header.$body."</table>";  
        }
        
        function exportToExcel_Acta($alumnos,$calificaciones,$excel_file_name,$periodo,$ano_lectivo,$curso,$jornada)  
        {  
            $header="<center><table border=1px><tr>";  
            $header.="<th colspan='9' style='align:center;'>Acta de Calificaciones de ".utf8_decode($curso)."</th>";
            $header.="</tr>";
            
            $header.="<tr>";  
            $header.="<th>Materia</th>";
            $header.="<th colspan='4'></th>";
            $header.="<th colspan='2'>Jornada</th>";
            $header.="<th colspan='2'>".$jornada ."</th>";
            $header.="</tr>";
            
            $header.="<tr>";  
            $header.="<th>Trimestre</th>";
            $header.="<th colspan='3'>".$periodo ."</th>";
            $header.="<th colspan='2'>".utf8_decode("Año Lectívo")."</th>";
            $header.="<th colspan='3'>".$ano_lectivo ."</th>";
            $header.="</tr>";
            
            $header.="<tr>";
            $header.="<th>No.</th>";
            $header.="<th>Nombres y Apellidos</th>";
            $header.="<th>Nota1</th>";
            $header.="<th>Nota2</th>";
            $header.="<th>Nota3</th>";
            $header.="<th>Examen</th>";
            $header.="<th>Total</th>";
            $header.="<th>Promedio</th>";
            $header.="<th>Conducta</th>";
            $header.="</tr>";
            
            $body="";  
            
            $i=0;
            foreach($alumnos->result() as $fila){
                $i++;
                if($calificaciones->num_rows>0){
                    foreach($calificaciones->result() as $cal){
                        if($fila->alu_id == $cal->cal_alumno_id){
                            $body.="<center><tr>";
                            $body.="<td>".$i."</td>";
                            $body.="<td>".utf8_decode($fila->alu_apellidos ." " .$fila->alu_nombres)."</td>";
                            $body.="<td>".$cal->cal_nota1."</td>";
                            $body.="<td>".$cal->cal_nota2."</td>";
                            $body.="<td>".$cal->cal_nota3."</td>";
                            $body.="<td>".$cal->cal_examen."</td>";
                            $body.="<td>".$cal->cal_total."</td>";
                            $body.="<td>".$cal->cal_promedio."</td>";
                            $body.="<td>".$cal->cal_conducta."</td>";
                            $body.="</tr>";
                        }
                    } 
                }else{
                    $body.="<center><tr>";
                    $body.="<td>".$i."</td>";
                    $body.="<td>".$fila->alu_apellidos ." " .$fila->alu_nombres."</td>";
                    $body.="<td></td>";
                    $body.="<td></td>";
                    $body.="<td></td>";
                    $body.="<td></td>";
                    $body.="<td></td>";
                    $body.="<td></td>";
                    $body.="<td></td>";
                    $body.="</tr>";
                }
            }  
            
            $this->setHeader($excel_file_name);  
            
            echo $header.$body."</table>";  
        }
        
        function exportToExcel_Nomina($alumnos,$excel_file_name,$ano_lectivo,$curso,$jornada)  
        {  
            $header="<center><table border=1px><tr>";  
            $header.="<th colspan='7' style='align:center;'>N�mina de Alumnos de ".$curso."</th>";
            $header.="</tr>";
            
            $header.="<tr>";  
            $header.="<th>Profesor</th>";
            $header.="<th colspan='3'></th>";
            $header.="<th>Mes</th>";
            $header.="<th colspan='2'></th>";
            $header.="</tr>";
            
            $header.="<tr>";  
            $header.="<th>Jornada</th>";
            $header.="<th colspan='2'>".$jornada."</th>";
            $header.="<th colspan='2'>Año Lectívo</th>";
            $header.="<th colspan='2'>".$ano_lectivo."</th>";
            $header.="</tr>";
            
            $header.="<tr>";
            $header.="<th>No.</th>";
            $header.="<th>Nombres y Apellidos</th>";
            $header.="<th></th>";$header.="<th></th>";$header.="<th></th>";$header.="<th></th>";$header.="<th></th>";
            $header.="</tr>";
            
            $body="";  
            
            $i=0;
            foreach($alumnos->result() as $fila){
                $i++;
                $body.="<center><tr>";
                $body.="<td>".$i."</td>";
                $body.="<td>".$fila->alu_apellidos ." " .$fila->alu_nombres."</td>";
                $body.="<td></td>";$body.="<td></td>";$body.="<td></td>";$body.="<td></td>";$body.="<td></td>";
                $body.="</tr>";
            }  
            
            $this->setHeader($excel_file_name);  
            
            echo $header.$body."</table>";  
        }
    }
?>

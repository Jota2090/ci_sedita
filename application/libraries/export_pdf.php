<?php
    if (!defined('BASEPATH'))
        exit('No tiene Permiso para acceder directamente al Script');
    
    class export_pdf
    {
        function exportToPDF_Cursos($resultado, $ano_lectivo){
            $CI = & get_instance();
            
            $CI->load->library("cezpdf");
            $CI->load->helper('pdf');
            
            header_pdf();
            footer_pdf();
            $CI->cezpdf->selectFont('fonts/Helvetica.afm');
            $CI->cezpdf->ezSetMargins(105,80,50,50);
            $CI->cezpdf->ezText("LISTADO  DE  CURSOS",10, array('justification'=>'center'));
            $CI->cezpdf->ezText("\n\n\n",10);
            $CI->cezpdf->setStrokeColor(0,0,0);            
            $CI->cezpdf->rectangle(405,680,67,20);
            $CI->cezpdf->setStrokeColor(0,0,0);
            $CI->cezpdf->rectangle(472,680,61,20);
            $CI->cezpdf->addText(408,685,10,"<b>Año Lectivo:</b>   ".$ano_lectivo);
            
            $columnas = array("num"=>"<b>No.</b>",
                                "c"=>"<b>Curso</b>",
                                "e"=>"<b>Especializaci�n</b>",
                                "p"=>"<b>Paralelo</b>",
                                "j"=>"<b>Jornada</b>");
                                
            $data = array();
            $i=0;
            foreach($resultado->result() as $fila){
                $i++;
                $data[] = array("num"=>$i,
                                "c"=>htmlentities($fila->cur_nombre),
                                "e"=>$fila->esp_nombre,
                                "p"=>$fila->par_nombre,
                                "j"=>$fila->jor_nombre);
            }                    
                            
            $CI->cezpdf->ezTable($data, $columnas, '', array('width'=>480,
                                                             'shaded'=>0,
                                                             'showLines'=>2,
                                                             'cols'=>array('num'=>array('width'=>30),
                                                                           'c'=>array('justification'=>'center'),
                                                                           'e'=>array('justification'=>'center'),
                                                                           'p'=>array('justification'=>'center'),
                                                                           'j'=>array('justification'=>'center'))
                                                            )
                                );
            
            $CI->cezpdf->ezStream();
        }
        
        function exportToPDF_Repre($rs, $curso){
            $CI = & get_instance();
            
            $CI->load->library("cezpdf");
            $CI->load->helper('pdf');
            
            header_pdf();
            footer_pdf();
            $CI->cezpdf->selectFont('fonts/Helvetica.afm');
            $CI->cezpdf->ezSetMargins(105,80,50,50);
            $CI->cezpdf->ezText("LISTADO  DE  REPRESENTANTES DE ".strtoupper($curso),10, array('justification'=>'center'));
            $CI->cezpdf->ezText("\n\n",10);
            
            $columnas = array("num"=>"<b>No.</b>",
                                "r"=>"<b>                REPRESENTANTE          </b>",
                                "f"=>"<b>                             FIRMA          </b>");
            
            $data = array();
            $CI->cezpdf->ezTable($data, $columnas, '', array('width'=>480,
                                                             'shaded'=>0,
                                                             'showLines'=>2,
                                                             'fontsize'=>8,
                                                             'cols'=>array('num'=>array('width'=>30),
                                                                           'r'=>array('width'=>200),
                                                                           'f'=>array('width'=>200))
                                                            )
                                );
                             
            $i=0;
            foreach($rs->result() as $fila){
                $i++;
                $data[] = array("num"=>$i,
                                "r"=>$fila->rep_nombres,
                                "f"=>"");
            }                    
                            
            $CI->cezpdf->ezTable($data, $columnas, '', array('width'=>480,
                                                             'shaded'=>0,
                                                             'showLines'=>2,
                                                             'fontsize'=>8,
                                                             'showHeadings'=>0,
                                                             'rowGap'=>15,
                                                             'cols'=>array('num'=>array('width'=>30),
                                                                           'r'=>array('width'=>200),
                                                                           'f'=>array('width'=>200))
                                                            )
                                );
            
            $CI->cezpdf->ezStream();
        }
        
        function exportToPDF_Usuarios($resultado, $ano_lectivo){
            $CI = & get_instance();
            
            $CI->load->library("cezpdf");
            $CI->load->helper('pdf');
            
            header_pdf();
            footer_pdf();
            $CI->cezpdf->selectFont('fonts/Helvetica.afm');
            $CI->cezpdf->ezSetMargins(105,80,50,50);
            $CI->cezpdf->ezText("LISTADO  DE  USUARIOS",10, array('justification'=>'center'));
            $CI->cezpdf->ezText("\n\n\n",10);
            $CI->cezpdf->setStrokeColor(0,0,0);            
            $CI->cezpdf->rectangle(405,680,67,20);
            $CI->cezpdf->setStrokeColor(0,0,0);
            $CI->cezpdf->rectangle(472,680,61,20);
            $CI->cezpdf->addText(408,685,10,"<b>Año Lectivo:</b>   ".$ano_lectivo);
            
            $columnas = array("num"=>"<b>No.</b>",
                                "u"=>"<b>Usuario</b>",
                                "c"=>"<b>Contrase�a</b>",
                                "tp"=>"<b>Tipo de Usuario</b>");
                                
            $data = array();
            $i=0;
            foreach($resultado->result() as $fila){
                $i++;
                $data[] = array("num"=>$i,
                                "u"=>$fila->usu_nombre,
                                "c"=>$fila->usu_clave,
                                "tp"=>$fila->tip_nombre);
            }                    
                            
            $CI->cezpdf->ezTable($data, $columnas, '', array('width'=>480,
                                                             'shaded'=>0,
                                                             'showLines'=>2,
                                                             'cols'=>array('num'=>array('width'=>30),
                                                                           'u'=>array('justification'=>'center'),
                                                                           'c'=>array('justification'=>'center'),
                                                                           'tp'=>array('justification'=>'center'))
                                                            )
                                );
            
            $CI->cezpdf->ezStream();
        }
        
        
        function exportToPDF_Actas($alumnos,$calificaciones,$periodo,$ano_lectivo,$curso,$jornada,$t){
            $CI = & get_instance();
            $anl = "Año Lectívo";
            $CI->load->library("cezpdf");
            $CI->load->helper('pdf');
            $CI->cezpdf->selectFont('fonts/Helvetica.afm');
            header_pdf();
            footer_pdf();
            $CI->cezpdf->ezSetMargins(105,80,50,50);
            $CI->cezpdf->ezText("ACTAS DE CALIFICACIONES DEL ".strtoupper($periodo),9, array('justification'=>'center'));
            $CI->cezpdf->line(98,691,290,691);
            $CI->cezpdf->addText(57,694,8,"<b>Profesor:</b>");
            $CI->cezpdf->line(375,691,525,691);
            $CI->cezpdf->addText(325,694,8,"<b>Asignatura:   </b>");
            $CI->cezpdf->ezText("\n\n\n\n",10);
            $CI->cezpdf->setStrokeColor(0,0,0);            
            $CI->cezpdf->rectangle(53,669,25,15);
            $CI->cezpdf->setStrokeColor(0,0,0);            
            $CI->cezpdf->rectangle(78,669,43,15);
            $CI->cezpdf->setStrokeColor(0,0,0);
            $CI->cezpdf->rectangle(121,669,100,15);
            $CI->cezpdf->setStrokeColor(0,0,0);            
            $CI->cezpdf->rectangle(221,669,36,15);
            $CI->cezpdf->setStrokeColor(0,0,0);
            $CI->cezpdf->rectangle(257,669,151,15);
            $CI->cezpdf->setStrokeColor(0,0,0);           
            $CI->cezpdf->rectangle(408,669,60,15);
            $CI->cezpdf->setStrokeColor(0,0,0);
            $CI->cezpdf->rectangle(468,669,64,15);
            $CI->cezpdf->addText(82,674,8,"<b>Jornada:</b>         ".$jornada);
            $CI->cezpdf->addText(225,674,8,"<b>Curso:</b>           ".utf8_decode($curso));
            $CI->cezpdf->addText(412,674,8,"<b>".utf8_decode($anl).":</b>        ".$ano_lectivo);
            
            if($t==1){
                $columnas = array("num"=>"<b>No.</b>",
                                    "a"=>"<b>Nombres y Apellidos</b>",
                                    "n1"=>"<b>Abril</b>","n2"=>"<b>Mayo</b>","n3"=>"<b>Junio</b>",
                                    "ex"=>"<b>Exa.</b>",
                                    "t"=>"<b>Suma</b>",
                                    "p"=>"<b>Prom.</b>",
                                    "co"=>"<b>Cond.</b>");
            }elseif($t==2){
                $columnas = array("num"=>"<b>No.</b>",
                                    "a"=>"<b>Nombres y Apellidos</b>",
                                    "n1"=>"<b>Julio</b>","n2"=>"<b>Agos.</b>","n3"=>"<b>Sept.</b>",
                                    "ex"=>"<b>Exa.</b>",
                                    "t"=>"<b>Suma</b>",
                                    "p"=>"<b>Prom.</b>",
                                    "co"=>"<b>Cond.</b>");
            }elseif($t==3){
                $columnas = array("num"=>"<b>No.</b>",
                                    "a"=>"<b>Nombres y Apellidos</b>",
                                    "n1"=>"<b>Oct.</b>","n2"=>"<b>Nov.</b>","n3"=>"<b>Dic.</b>",
                                    "ex"=>"<b>Exa.</b>",
                                    "t"=>"<b>Suma</b>",
                                    "p"=>"<b>Prom.</b>",
                                    "co"=>"<b>Cond.</b>");
            }
                                
            $data = array();
            $i=0;
            foreach($alumnos->result() as $fila){
                $i++;
                if($calificaciones->num_rows>0){
                    foreach($calificaciones->result() as $cal){
                        if($fila->alu_id == $cal->cal_alumno_id){
                            $data[] = array("num"=>$i,
                                            "a"=>strtoupper(utf8_decode($fila->alu_apellidos ." " .$fila->alu_nombres)),
                                            "n1"=>$cal->cal_nota1,
                                            "n2"=>$cal->cal_nota2,
                                            "n3"=>$cal->cal_nota3,
                                            "ex"=>$cal->cal_examen,
                                            "t"=>$cal->cal_total,
                                            "p"=>$cal->cal_promedio,
                                            "co"=>$cal->cal_conducta,);
                        }
                    } 
                }else{
                    $data[] = array("num"=>$i,
                                    "a"=>strtoupper(utf8_decode($fila->alu_apellidos ." " .$fila->alu_nombres)),
                                    "n1"=>"",
                                    "n2"=>"",
                                    "n3"=>"",
                                    "ex"=>"",
                                    "t"=>"",
                                    "p"=>"",
                                    "co"=>"");   
                }
            }                    
                            
            $CI->cezpdf->ezTable($data, $columnas, '', array('width'=>480,
                                                             'shaded'=>0,
                                                             'showLines'=>2,
                                                             'fontSize'=>8,
                                                             'cols'=>array('num'=>array('width'=>25),
                                                                           'n1'=>array('justification'=>'center',
                                                                                        'width'=>33),
                                                                           'n2'=>array('justification'=>'center',
                                                                                        'width'=>33),
                                                                           'n3'=>array('justification'=>'center',
                                                                                        'width'=>33),
                                                                           'ex'=>array('justification'=>'center',
                                                                                        'width'=>33),
                                                                           't'=>array('justification'=>'center',
                                                                                        'width'=>33),
                                                                           'p'=>array('justification'=>'center',
                                                                                        'width'=>33),
                                                                           'co'=>array('justification'=>'center',
                                                                                        'width'=>33),)
                                                            )
                                );
            
            $CI->cezpdf->ezStream();
        }
        
        function exportToPDF_Nomina($alumnos,$ano_lectivo,$curso,$jornada){
            $CI = & get_instance();
            
            $CI->load->library("cezpdf");
            $CI->load->helper('pdf');
            
            $CI->cezpdf->selectFont('fonts/Helvetica.afm');
            header_pdf();
            footer_pdf();
            $CI->cezpdf->ezSetMargins(105,80,50,50);
            $CI->cezpdf->ezText(utf8_decode("NÓMINA DE ALUMNOS"),9, array('justification'=>'center'));
            $CI->cezpdf->line(98,691,290,691);
            $CI->cezpdf->line(425,691,525,691);
            $CI->cezpdf->addText(57,694,8,"<b>Inspector:</b>");
            $CI->cezpdf->addText(405,694,8,"<b>Mes:</b>");
            $CI->cezpdf->ezText("\n\n\n\n",10);
            $CI->cezpdf->setStrokeColor(0,0,0);            
            $CI->cezpdf->rectangle(53,669,25,15);
            $CI->cezpdf->setStrokeColor(0,0,0);            
            $CI->cezpdf->rectangle(78,669,43,15);
            $CI->cezpdf->setStrokeColor(0,0,0);
            $CI->cezpdf->rectangle(121,669,100,15);
            $CI->cezpdf->setStrokeColor(0,0,0);            
            $CI->cezpdf->rectangle(221,669,36,15);
            $CI->cezpdf->setStrokeColor(0,0,0);
            $CI->cezpdf->rectangle(257,669,151,15);
            $CI->cezpdf->setStrokeColor(0,0,0);           
            $CI->cezpdf->rectangle(408,669,60,15);
            $CI->cezpdf->setStrokeColor(0,0,0);
            $CI->cezpdf->rectangle(468,669,64,15);
            $CI->cezpdf->addText(82,674,8,"<b>Jornada:</b>         ".$jornada);
            $CI->cezpdf->addText(225,674,8,"<b>Curso:</b>           ".utf8_decode($curso));
            $CI->cezpdf->addText(412,674,8,"<b>".utf8_decode("Año Lectívo").":</b>        ".$ano_lectivo);
            
            $columnas = array("num"=>"<b>No.</b>",
                                "a"=>"<b>                    Apellidos  -  Nombres</b>",
                                "n1"=>"","n2"=>"","n3"=>"","n4"=>"","n5"=>"","n6"=>"",
                                "n7"=>"","n8"=>"","n9"=>"","n10"=>"","n11"=>"","n12"=>"",
                                "n13"=>"","n14"=>"","n15"=>"","n16"=>"","n17"=>"","n18"=>"",
                                "n19"=>"","n20"=>"","n21"=>"","n22"=>"","n23"=>"","n24"=>"");
                                
            $data = array();
            $i=0;
            foreach($alumnos->result() as $fila){
                $i++;
                $data[] = array("num"=>$i,"a"=> strtoupper(utf8_decode($fila->alu_apellidos ." " .$fila->alu_nombres)),
                                "n1"=>"","n2"=>"","n3"=>"","n4"=>"","n5"=>"","n6"=>"",
                                "n7"=>"","n8"=>"","n9"=>"","n10"=>"","n11"=>"","n12"=>"",
                                "n13"=>"","n14"=>"","n15"=>"","n16"=>"","n17"=>"","n18"=>"",
                                "n19"=>"","n20"=>"","n21"=>"","n22"=>"","n23"=>"","n24"=>"");
            }                    
                            
            $CI->cezpdf->ezTable($data, $columnas, '', array('width'=>480,
                                                             'shaded'=>0,
                                                             'showLines'=>2,
                                                             'fontSize'=>8,
                                                             'cols'=>array('num'=>array('width'=>25),
                                                                            'a'=>array('width'=>214))
                                                            )
                                );
            
            $CI->cezpdf->ezStream();
        }
        
        
        function exportToPDF_Hoja_Matricula($datos_alu,$ano_lectivo,$curso,$jornada){
            $CI = & get_instance();
            
            $CI->load->library("cezpdf");
            $CI->load->helper('pdf');
            
            $CI->cezpdf->selectFont('fonts/Helvetica.afm');
            header_pdf();
            footer_pdf();
            $CI->cezpdf->ezSetMargins(105,80,50,50);
            $CI->cezpdf->ezText(utf8_decode("HOJA DE MATRÍCULA"),10, array('justification'=>'center'));
            $CI->cezpdf->line(98,691,290,691);
            $CI->cezpdf->ezText(utf8_decode("Nº Matrícula"),8);
            $CI->cezpdf->ezText("\n\n\n\n",10);
            $CI->cezpdf->setStrokeColor(0,0,0);
            $CI->cezpdf->rectangle(430,630,94,100);
            
            $columnas = array("num"=>"<b>No.</b>",
                                "a"=>"<b>                    Apellidos  -  Nombres</b>",
                                "n1"=>"","n2"=>"","n3"=>"","n4"=>"","n5"=>"","n6"=>"",
                                "n7"=>"","n8"=>"","n9"=>"","n10"=>"","n11"=>"","n12"=>"",
                                "n13"=>"","n14"=>"","n15"=>"","n16"=>"","n17"=>"","n18"=>"",
                                "n19"=>"","n20"=>"","n21"=>"","n22"=>"","n23"=>"","n24"=>"");
                                
            $data = array();
            $i=0;
            /*foreach($alumnos->result() as $fila){
                $i++;
                $data[] = array("num"=>$i,"a"=> strtoupper(utf8_decode($fila->alu_apellidos ." " .$fila->alu_nombres)),
                                "n1"=>"","n2"=>"","n3"=>"","n4"=>"","n5"=>"","n6"=>"",
                                "n7"=>"","n8"=>"","n9"=>"","n10"=>"","n11"=>"","n12"=>"",
                                "n13"=>"","n14"=>"","n15"=>"","n16"=>"","n17"=>"","n18"=>"",
                                "n19"=>"","n20"=>"","n21"=>"","n22"=>"","n23"=>"","n24"=>"");
            }                    
                            
            $CI->cezpdf->ezTable($data, $columnas, '', array('width'=>480,
                                                             'shaded'=>0,
                                                             'showLines'=>2,
                                                             'fontSize'=>8,
                                                             'cols'=>array('num'=>array('width'=>25),
                                                                            'a'=>array('width'=>214))
                                                            )
                                );*/
            
            $CI->cezpdf->ezStream();
        }
        
        
        function exportToPDF_Libretas($list_alumnos,$materias,$dirigente,$anio,$anl,$curso,
                                                                $jornada,$t,$mc,$c){
            $CI = & get_instance();
            
            $CI->load->library("cezpdf");
            $CI->load->helper('pdf');
            $CI->load->model("mod_acta_calificaciones","acta");
            $CI->load->model("mod_libreta","libreta");
            $tri=$CI->acta->nombre_trimestre($t);
            
            $cols1 = array("col1"=>"",
                                "col2"=>"",
                                "col3"=>""); 
                            
                                   
            
            foreach($list_alumnos->result() as $alu):
                $faltas=$CI->libreta->verificar_fob($t,$alu->alu_id,$anl);
                $data1 = array(); 
                
                $CI->cezpdf->ezImage(site_url("images/logo-escuela2.jpg"), 10, 130, 5, 'left');
                $CI->cezpdf->addText(248,798,7,"Unidad  Educativa");
                $CI->cezpdf->addText(235,784,10,"<b>&quot;La  Luz  de  Dios&quot;</b>");
                $CI->cezpdf->addText(200,764,7,"REPORTE  DE  CALIFICACIONES  GENERAL   -    ".strtoupper($tri));
                $CI->cezpdf->addText(110,744,7,"NOMBRE  <b>:</b>       ".strtoupper($alu->alu_apellidos." ".$alu->alu_nombres));
                $CI->cezpdf->addText(300,744,7,"A�O  LECTIVO  <b>:</b>         ".$anio);
                $CI->cezpdf->addText(110,734,7,"CURSO  <b>:</b>          ".strtoupper($curso." ".$jornada));
                $CI->cezpdf->addText(300,734,7,"PROFESOR  (A)  <b>:</b>        ".strtoupper($dirigente));
                $CI->cezpdf->ezText("\n",11);                
                $i = 0;
                $cols = array("num"=>"<b>N�</b>",
                                            "mat"=>"<b>                              A  S  I  G  N  A  T  U  R  A  S</b>",
                                            "nt1"=>"<b>ABRIL</b>",
                                            "nt2"=>"<b>MAYO</b>",
                                            "nt3"=>"<b>JUNIO</b>",
                                            "exa"=>"<b>EXAMEN</b>",
                                            "tot"=>"<b>TOTAL</b>",
                                            "pro"=>"<b>PRO. T</b>");
                $data = array();
                $prom1=0;$prom2=0;$prom3=0;$prom4=0;                                                            
                $calificaciones = $CI->libreta->calificaciones_actas($t, $anl, $alu->alu_id);
                foreach($materias->result() as $mat):
                    foreach($calificaciones->result() as $cal):
                        if($mat->mc_id == $cal->cal_materia_curso_id){
                            $i++;
                            $data[] = array("num"=>$i,
                                         "mat"=>strtoupper($mat->mat_nombre),
                                         "nt1"=>$cal->cal_nota1,
                                         "nt2"=>$cal->cal_nota2,
                                         "nt3"=>$cal->cal_nota3,
                                         "exa"=>$cal->cal_examen,
                                         "tot"=>$cal->cal_total,
                                         "pro"=>$cal->cal_promedio);
                            
                            $prom1=$prom1+$cal->cal_nota1;
                            $prom2=$prom2+$cal->cal_nota2;
                            $prom3=$prom3+$cal->cal_nota3;
                            $prom4=$prom4+$cal->cal_examen;
                        }
                    endforeach;
                endforeach;
                
                $conducta = $CI->libreta->calificacion_conducta($t,$mc,$anl,$alu->alu_id);
                
                $prom1=round($prom1/$i);
                $prom2=round($prom2/$i);
                $prom3=round($prom3/$i);
                $prom4=round($prom4/$i);
                $promTotal=$prom1+$prom2+$prom3+$prom4;
                $promProm=round($promTotal/4);
                $condTotal=$conducta*4;
                $condProm=round($condTotal/4);
                
                $i++;
                $data[] = array("num"=>$i,
                             "mat"=>"PROMEDIO",
                             "nt1"=>$prom1,
                             "nt2"=>$prom2,
                             "nt3"=>$prom3,
                             "exa"=>$prom4,
                             "tot"=>$promTotal,
                             "pro"=>$promProm);
                
                $i++;
                $data[] = array("num"=>$i,
                             "mat"=>"CONDUCTA",
                             "nt1"=>$conducta,
                             "nt2"=>$conducta,
                             "nt3"=>$conducta,
                             "exa"=>$conducta,
                             "tot"=>$condTotal,
                             "pro"=>$condProm);
                             
                if($faltas->num_rows>0){
                    foreach($faltas->result() as $fila){
                        $data[] = array("num"=>"",
                                         "mat"=>"FALTAS",
                                         "nt1"=>$fila->fob_nota1,
                                         "nt2"=>$fila->fob_nota2,
                                         "nt3"=>$fila->fob_nota3,
                                         "exa"=>$fila->fob_examen,
                                         "tot"=>"");
                        
                        if($fila->fob_observacion==""||$fila->fob_observacion==null){
                            $data1[] = array("col1"=>"",
                                                "col2"=>"                 OBSERVACI�N  <b>:</b>          ",
                                                "col3"=>"");
                        }else{
                            $data1[] = array("col1"=>"",
                                                "col2"=>"                 OBSERVACI�N  <b>:</b>          ",
                                                "col3"=>$fila->fob_observacion);
                        }
                    }
                }else{
                    $data[] = array("num"=>"",
                                     "mat"=>"FALTAS",
                                     "nt1"=>"",
                                     "nt2"=>"",
                                     "nt3"=>"",
                                     "exa"=>"",
                                     "tot"=>"");
                                     
                    $data1[] = array("col1"=>"",
                                                "col2"=>"                 OBSERVACI�N  <b>:</b>          ",
                                                "col3"=>"");
                }
                 
                $CI->cezpdf->ezTable($data, $cols, '', array('width'=>500,
                                                          'shaded'=>0,
                                                          'showLines'=>2,
                                                          'fontSize'=>7,                                                              
                                                          'cols'=>array('num'=>array('width'=>25),
                                                                        'mat'=>array('width'=>190),
                                                                        'nt1'=>array('justification'=>'center',
                                                                                     'width'=>35),
                                                                        'nt2'=>array('justification'=>'center',
                                                                                     'width'=>35),
                                                                        'nt3'=>array('justification'=>'center',
                                                                                     'width'=>35),
                                                                        'exa'=>array('justification'=>'center',
                                                                                     'width'=>40),
                                                                        'tot'=>array('justification'=>'center',
                                                                                     'width'=>35),
                                                                        'pro'=>array('justification'=>'center',
                                                                                     'width'=>35))
                                                         )
                             );             
                
                $CI->cezpdf->ezTable($data1, $cols1, '', array('width'=>500,
                                                          'shaded'=>0,
                                                          'showLines'=>2,
                                                          'showHeadings'=>0,
                                                          'fontSize'=>7,                                                              
                                                          'cols'=>array('col1'=>array('width'=>25),
                                                                        'col2'=>array('width'=>119),
                                                                        'col3'=>array('width'=>286))
                                                         )
                             );
                             
                $CI->cezpdf->line(110,500,200,500);
                $CI->cezpdf->line(260,500,350,500);
                $CI->cezpdf->line(410,500,500,500); 
                $CI->cezpdf->addText(5,488,7,"                                                                  DIRECTORA                                                       PROFESOR (A)                                                 REPRESENTANTE");
         
                $CI->cezpdf->ezNewPage();
            endforeach;
            
            
            ob_end_clean();                  
            $CI->cezpdf->ezStream();
        }
        
        function exportToPDF_CuadrosPromo($alumnos,$materias,$dirigente,$curso,$jornada,$anio,$mc,$anl){
            $CI = & get_instance();
            
            $CI->load->library("cezpdf");
            $CI->load->helper('pdf');
            $CI->load->model("mod_acta_calificaciones","acta");
            $CI->load->model("mod_libreta","libreta");
            
            $cols1 = array("col1"=>"",
                                "col2"=>"",
                                "col3"=>""); 
                            
                                   
            
            foreach($alumnos->result() as $alu):
                $data1 = array(); 
                
                $CI->cezpdf->ezImage(site_url("images/logo-escuela2.jpg"), 10, 130, 5, 'left');
                $CI->cezpdf->addText(268,798,7,"Unidad  Educativa");
                $CI->cezpdf->addText(255,784,10,"<b>&quot;La  Luz  de  Dios&quot;</b>");
                $CI->cezpdf->addText(250,764,7,"CUADRO  DE  PROMOCI�N");
                $CI->cezpdf->addText(110,744,7,"NOMBRE  <b>:</b>       ".strtoupper($alu->alu_apellidos." ".$alu->alu_nombres));
                $CI->cezpdf->addText(300,744,7,"A�O  LECTIVO  <b>:</b>         ".$anio);
                $CI->cezpdf->addText(110,734,7,"CURSO  <b>:</b>          ".strtoupper($curso." ".$jornada));
                $CI->cezpdf->addText(300,734,7,"PROFESOR  (A)  <b>:</b>        ".strtoupper($dirigente));               
                $CI->cezpdf->ezText("\n\n\n",10);
                $CI->cezpdf->setStrokeColor(0,0,0);            
                $CI->cezpdf->rectangle(52,700,22,20);
                $CI->cezpdf->setStrokeColor(0,0,0);
                $CI->cezpdf->rectangle(74,700,214,20);
                $CI->cezpdf->setStrokeColor(0,0,0);
                $CI->cezpdf->rectangle(288,709,35,11);
                $CI->cezpdf->setStrokeColor(0,0,0);
                $CI->cezpdf->rectangle(288,700,35,9);
                $CI->cezpdf->setStrokeColor(0,0,0);
                $CI->cezpdf->rectangle(323,709,35,11);
                $CI->cezpdf->setStrokeColor(0,0,0);
                $CI->cezpdf->rectangle(323,700,35,9);
                $CI->cezpdf->setStrokeColor(0,0,0);
                $CI->cezpdf->rectangle(358,709,35,11);
                $CI->cezpdf->setStrokeColor(0,0,0);
                $CI->cezpdf->rectangle(358,700,35,9);
                $CI->cezpdf->setStrokeColor(0,0,0);
                $CI->cezpdf->rectangle(393,700,35,20);
                $CI->cezpdf->setStrokeColor(0,0,0);
                $CI->cezpdf->rectangle(428,700,35,20);
                $CI->cezpdf->setStrokeColor(0,0,0);
                $CI->cezpdf->rectangle(463,700,35,20);
                $CI->cezpdf->setStrokeColor(0,0,0);
                $CI->cezpdf->rectangle(498,700,35,20);
                $CI->cezpdf->addText(59,706,8,"<b>N�</b>");
                $CI->cezpdf->addText(78,706,8,"<b>                          A  S  I  G  N  A  T  U  R  A  S     </b>      ");
                $CI->cezpdf->addText(292,712,6,"<b>TRIMEST.</b>");
                $CI->cezpdf->addText(305,702,6,"<b>I</b>");
                $CI->cezpdf->addText(327,712,6,"<b>TRIMEST.</b>");
                $CI->cezpdf->addText(338,702,6,"<b>II</b>");
                $CI->cezpdf->addText(362,712,6,"<b>TRIMEST.</b>");
                $CI->cezpdf->addText(373,702,6,"<b>III</b>");
                $CI->cezpdf->addText(397,706,8,"<b>TOTAL</b>");
                $CI->cezpdf->addText(432,706,8,"<b>PRO. T.</b>");
                $CI->cezpdf->addText(473,706,8,"<b>SUP. </b>");
                $CI->cezpdf->addText(502,706,8,"<b>PRO. F.</b>");
                
                $i = 0;
                $cols = array("num"=>"","mat"=>"","tri1"=>"","tri2"=>"","tri3"=>"","tot"=>"","prot"=>"","sup"=>"","prof"=>"");
                                
                $fila = array();
                $prom1=0;$prom2=0;$prom3=0;$prom4=0;                                                            
                $calificaciones = $CI->libreta->calificaciones_actas(0, $anl, $alu->alu_id);
                foreach($materias->result() as $mat):
                    $data = array();
                    $i++;
                    $data["num"]=$i;
                    $data["mat"]=strtoupper($mat->mat_nombre);
                    foreach($calificaciones->result() as $cal):
                        if($mat->mc_id == $cal->cal_materia_curso_id &&$cal->cal_periodo_escolar_id==1){
                            $data["tri1"]=$cal->cal_promedio;
                            $prom1=$prom1+$cal->cal_promedio;
                        }
                        elseif($mat->mc_id == $cal->cal_materia_curso_id &&$cal->cal_periodo_escolar_id==2){
                            $data["tri2"]=$cal->cal_promedio;
                            $prom2=$prom2+$cal->cal_promedio;
                        }
                        elseif($mat->mc_id == $cal->cal_materia_curso_id &&$cal->cal_periodo_escolar_id==3){
                            $data["tri3"]=$cal->cal_promedio;
                            $prom3=$prom3+$cal->cal_promedio;
                        }
                    endforeach;
                    $data["tot"]=$data["tri1"]+$data["tri2"]+$data["tri3"];
                    $data["prot"]=round($data["tot"]/3);
                    $data["sup"]=0;
                    if($data["sup"]>0)
                        $data["prof"]=round(($data["sup"]+$data["prot"])/2);
                    else
                        $data["prof"]=$data["prot"];
                    $prom4=$prom4+$data["prof"];
                    $fila[] = $data;
                endforeach;
                
                $data=array();
                $data["prof"]=round($prom4/$i);
                $data["tri1"]=round($prom1/$i);
                $data["tri2"]=round($prom2/$i);
                $data["tri3"]=round($prom3/$i);
                $i++; $data["num"]=$i;
                $data["mat"]="PROMEDIO";
                $data["tot"]=$data["tri1"]+$data["tri2"]+$data["tri3"];
                $data["prot"]=round($data["tot"]/3);
                $data["sup"]="";
                $fila[] = $data;
                
                $data=array();
                $data["tri1"]=$CI->libreta->calificacion_conducta(1,$mc,$anl,$alu->alu_id);
                $data["tri2"]=$CI->libreta->calificacion_conducta(2,$mc,$anl,$alu->alu_id);
                $data["tri3"]=$CI->libreta->calificacion_conducta(3,$mc,$anl,$alu->alu_id);
                $i++; $data["num"]=$i;
                $data["mat"]="CONDUCTA";
                $data["tot"]=$data["tri1"]+$data["tri2"]+$data["tri3"];
                $data["prot"]=round($data["tot"]/3);
                $data["sup"]="";
                $data["prof"]=$data["prot"];
                $fila[] = $data;
                
                $CI->cezpdf->ezTable($fila, $cols, '', array('width'=>499,
                                                          'shaded'=>0,
                                                          'showLines'=>2,
                                                          'showHeadings'=>0,
                                                          'fontSize'=>7,                                                              
                                                          'cols'=>array('num'=>array('width'=>22),
                                                                        'mat'=>array('width'=>214),
                                                                        'tri1'=>array('justification'=>'center',
                                                                                     'width'=>35),
                                                                        'tri2'=>array('justification'=>'center',
                                                                                     'width'=>35),
                                                                        'tri3'=>array('justification'=>'center',
                                                                                     'width'=>35),
                                                                        'tot'=>array('justification'=>'center',
                                                                                     'width'=>35),
                                                                        'prot'=>array('justification'=>'center',
                                                                                     'width'=>35),
                                                                        'sup'=>array('justification'=>'center',
                                                                                     'width'=>35),
                                                                        'prof'=>array('justification'=>'center',
                                                                                     'width'=>35))
                                                         )
                             );             
                             
                $CI->cezpdf->line(110,500,200,500);
                $CI->cezpdf->line(260,500,350,500);
                $CI->cezpdf->line(410,500,500,500); 
                $CI->cezpdf->addText(5,488,7,"                                                                  DIRECTORA                                                       PROFESOR (A)                                                 REPRESENTANTE");
         
                $CI->cezpdf->ezNewPage();
            endforeach;
            
            ob_end_clean();                  
            $CI->cezpdf->ezStream();
        }
        
        function exportToPDF_Promo($materias,$calificaciones,$alu,$dirigente,$curso,$jornada,$anio,$cond1,$cond2,$cond3){
            $CI = & get_instance();
            
            $CI->load->library("cezpdf");
            $CI->load->helper('pdf');
            $CI->load->model("mod_acta_calificaciones","acta");
            $CI->load->model("mod_libreta","libreta");
            $alumno=$CI->acta->nombre_alumno($alu);
            
            $cols1 = array("col1"=>"",
                                "col2"=>"",
                                "col3"=>""); 
                            
                                   
            
            $CI->cezpdf->ezImage(site_url("images/logo-escuela2.jpg"), 10, 130, 5, 'left');
            $CI->cezpdf->addText(268,798,7,"Unidad  Educativa");
            $CI->cezpdf->addText(255,784,10,"<b>&quot;La  Luz  de  Dios&quot;</b>");
            $CI->cezpdf->addText(250,764,7,"CUADRO  DE  PROMOCI�N");
            $CI->cezpdf->addText(110,744,7,"NOMBRE  <b>:</b>       ".strtoupper($alumno));
            $CI->cezpdf->addText(300,744,7,"A�O  LECTIVO  <b>:</b>         ".$anio);
            $CI->cezpdf->addText(110,734,7,"CURSO  <b>:</b>          ".strtoupper($curso." ".$jornada));
            $CI->cezpdf->addText(300,734,7,"PROFESOR  (A)  <b>:</b>        ".strtoupper($dirigente));               
            $CI->cezpdf->ezText("\n\n\n",10);
            $CI->cezpdf->setStrokeColor(0,0,0);            
            $CI->cezpdf->rectangle(52,700,22,20);
            $CI->cezpdf->setStrokeColor(0,0,0);
            $CI->cezpdf->rectangle(74,700,214,20);
            $CI->cezpdf->setStrokeColor(0,0,0);
            $CI->cezpdf->rectangle(288,709,35,11);
            $CI->cezpdf->setStrokeColor(0,0,0);
            $CI->cezpdf->rectangle(288,700,35,9);
            $CI->cezpdf->setStrokeColor(0,0,0);
            $CI->cezpdf->rectangle(323,709,35,11);
            $CI->cezpdf->setStrokeColor(0,0,0);
            $CI->cezpdf->rectangle(323,700,35,9);
            $CI->cezpdf->setStrokeColor(0,0,0);
            $CI->cezpdf->rectangle(358,709,35,11);
            $CI->cezpdf->setStrokeColor(0,0,0);
            $CI->cezpdf->rectangle(358,700,35,9);
            $CI->cezpdf->setStrokeColor(0,0,0);
            $CI->cezpdf->rectangle(393,700,35,20);
            $CI->cezpdf->setStrokeColor(0,0,0);
            $CI->cezpdf->rectangle(428,700,35,20);
            $CI->cezpdf->setStrokeColor(0,0,0);
            $CI->cezpdf->rectangle(463,700,35,20);
            $CI->cezpdf->setStrokeColor(0,0,0);
            $CI->cezpdf->rectangle(498,700,35,20);
            $CI->cezpdf->addText(59,706,8,"<b>N�</b>");
            $CI->cezpdf->addText(78,706,8,"<b>                          A  S  I  G  N  A  T  U  R  A  S     </b>      ");
            $CI->cezpdf->addText(292,712,6,"<b>TRIMEST.</b>");
            $CI->cezpdf->addText(305,702,6,"<b>I</b>");
            $CI->cezpdf->addText(327,712,6,"<b>TRIMEST.</b>");
            $CI->cezpdf->addText(338,702,6,"<b>II</b>");
            $CI->cezpdf->addText(362,712,6,"<b>TRIMEST.</b>");
            $CI->cezpdf->addText(373,702,6,"<b>III</b>");
            $CI->cezpdf->addText(397,706,8,"<b>TOTAL</b>");
            $CI->cezpdf->addText(432,706,8,"<b>PRO. T.</b>");
            $CI->cezpdf->addText(473,706,8,"<b>SUP. </b>");
            $CI->cezpdf->addText(502,706,8,"<b>PRO. F.</b>");
            
            $i = 0;
            $cols = array("num"=>"","mat"=>"","tri1"=>"","tri2"=>"","tri3"=>"","tot"=>"","prot"=>"","sup"=>"","prof"=>"");
                            
            $fila = array();
            $prom1=0;$prom2=0;$prom3=0;$prom4=0;
            foreach($materias->result() as $mat):
                $data = array();
                $i++;
                $data["num"]=$i;
                $data["mat"]=strtoupper($mat->mat_nombre);
                foreach($calificaciones->result() as $cal):
                    if($mat->mc_id == $cal->cal_materia_curso_id &&$cal->cal_periodo_escolar_id==1){
                        $data["tri1"]=$cal->cal_promedio;
                        $prom1=$prom1+$cal->cal_promedio;
                    }
                    elseif($mat->mc_id == $cal->cal_materia_curso_id &&$cal->cal_periodo_escolar_id==2){
                        $data["tri2"]=$cal->cal_promedio;
                        $prom2=$prom2+$cal->cal_promedio;
                    }
                    elseif($mat->mc_id == $cal->cal_materia_curso_id &&$cal->cal_periodo_escolar_id==3){
                        $data["tri3"]=$cal->cal_promedio;
                        $prom3=$prom3+$cal->cal_promedio;
                    }
                endforeach;
                $data["tot"]=$data["tri1"]+$data["tri2"]+$data["tri3"];
                $data["prot"]=round($data["tot"]/3);
                $data["sup"]=0;
                if($data["sup"]>0)
                    $data["prof"]=round(($data["sup"]+$data["prot"])/2);
                else
                    $data["prof"]=$data["prot"];
                $prom4=$prom4+$data["prof"];
                $fila[] = $data;
            endforeach;
            
            $data=array();
            $data["prof"]=round($prom4/$i);
            $data["tri1"]=round($prom1/$i);
            $data["tri2"]=round($prom2/$i);
            $data["tri3"]=round($prom3/$i);
            $i++; $data["num"]=$i;
            $data["mat"]="PROMEDIO";
            $data["tot"]=$data["tri1"]+$data["tri2"]+$data["tri3"];
            $data["prot"]=round($data["tot"]/3);
            $data["sup"]="";
            $fila[] = $data;
            
            $data=array();
            $data["tri1"]=$cond1;
            $data["tri2"]=$cond2;
            $data["tri3"]=$cond3;
            $i++; $data["num"]=$i;
            $data["mat"]="CONDUCTA";
            $data["tot"]=$data["tri1"]+$data["tri2"]+$data["tri3"];
            $data["prot"]=round($data["tot"]/3);
            $data["sup"]="";
            $data["prof"]=$data["prot"];
            $fila[] = $data;
            
            $CI->cezpdf->ezTable($fila, $cols, '', array('width'=>499,
                                                      'shaded'=>0,
                                                      'showLines'=>2,
                                                      'showHeadings'=>0,
                                                      'fontSize'=>7,                                                              
                                                      'cols'=>array('num'=>array('width'=>22),
                                                                    'mat'=>array('width'=>214),
                                                                    'tri1'=>array('justification'=>'center',
                                                                                 'width'=>35),
                                                                    'tri2'=>array('justification'=>'center',
                                                                                 'width'=>35),
                                                                    'tri3'=>array('justification'=>'center',
                                                                                 'width'=>35),
                                                                    'tot'=>array('justification'=>'center',
                                                                                 'width'=>35),
                                                                    'prot'=>array('justification'=>'center',
                                                                                 'width'=>35),
                                                                    'sup'=>array('justification'=>'center',
                                                                                 'width'=>35),
                                                                    'prof'=>array('justification'=>'center',
                                                                                 'width'=>35))
                                                     )
                         );             
                         
            $CI->cezpdf->line(110,500,200,500);
            $CI->cezpdf->line(260,500,350,500);
            $CI->cezpdf->line(410,500,500,500); 
            $CI->cezpdf->addText(5,488,7,"                                                                  DIRECTORA                                                       PROFESOR (A)                                                 REPRESENTANTE");
            
            ob_end_clean();                  
            $CI->cezpdf->ezStream();
        }
        
        function exportToPDF_LibretaAlumno($calificaciones,$materias,$dirigente,$anio,$anl,$curso,
                                                                        $jornada,$t,$conducta,$alu){
            $CI = & get_instance();
            
            $CI->load->library("cezpdf");
            $CI->load->helper('pdf');
            $CI->load->model("mod_acta_calificaciones","acta");
            $CI->load->model("mod_libreta","libreta");
            $tri=$CI->acta->nombre_trimestre($t);
            $alumno=$CI->acta->nombre_alumno($alu);
            $faltas=$CI->libreta->verificar_fob($t,$alu,$anl);
            
            $CI->cezpdf->ezImage(site_url("images/logo-escuela2.jpg"), 10, 130, 5, 'left');
            $CI->cezpdf->addText(248,798,7,"Unidad  Educativa");
            $CI->cezpdf->addText(236,784,10,"<b>&quot;La  Luz  de  Dios&quot;</b>");
            $CI->cezpdf->addText(200,764,7,"REPORTE  DE  CALIFICACIONES  GENERAL   -    ".strtoupper($tri));
            $CI->cezpdf->addText(82,744,7,"NOMBRE  <b>:</b>       ".strtoupper("Almeida Jimenez Naomi Damaris"));
            $CI->cezpdf->addText(282,744,7,"A�O  LECTIVO  <b>:</b>         ".$anio);
            $CI->cezpdf->addText(82,734,7,"CURSO  <b>:</b>          ".strtoupper($curso." ".$jornada));
            $CI->cezpdf->addText(282,734,7,"PROFESOR  (A)  <b>:</b>        ".strtoupper($dirigente));
            $CI->cezpdf->ezText("\n",11);                
            $i = 0;
            $cols = array("num"=>"<b>N�</b>",
                                        "mat"=>"<b>                              A  S  I  G  N  A  T  U  R  A  S</b>",
                                        "nt1"=>"<b>ABRIL</b>",
                                        "nt2"=>"<b>MAYO</b>",
                                        "nt3"=>"<b>JUNIO</b>",
                                        "exa"=>"<b>EXAMEN</b>",
                                        "tot"=>"<b>TOTAL</b>",
                                        "pro"=>"<b>PRO. T</b>");
            $data = array();
            $prom1=0;$prom2=0;$prom3=0;$prom4=0;
            foreach($materias->result() as $mat):
                foreach($calificaciones->result() as $cal):
                    if($mat->mc_id == $cal->cal_materia_curso_id){
                        $i++;
                        $data[] = array("num"=>$i,
                                     "mat"=>strtoupper($mat->mat_nombre),
                                     "nt1"=>$cal->cal_nota1,
                                     "nt2"=>$cal->cal_nota2,
                                     "nt3"=>$cal->cal_nota3,
                                     "exa"=>$cal->cal_examen,
                                     "tot"=>$cal->cal_total,
                                     "pro"=>$cal->cal_promedio);
                        
                        $prom1=$prom1+$cal->cal_nota1;
                        $prom2=$prom2+$cal->cal_nota2;
                        $prom3=$prom3+$cal->cal_nota3;
                        $prom4=$prom4+$cal->cal_examen;
                    }
                endforeach;
            endforeach;
            
            $prom1=round($prom1/$i);
            $prom2=round($prom2/$i);
            $prom3=round($prom3/$i);
            $prom4=round($prom4/$i);
            $promTotal=$prom1+$prom2+$prom3+$prom4;
            $promProm=round($promTotal/4);
            $condTotal=$conducta*4;
            $condProm=round($condTotal/4);
            
            $i++;
            $data[] = array("num"=>$i,
                         "mat"=>"PROMEDIO",
                         "nt1"=>$prom1,
                         "nt2"=>$prom2,
                         "nt3"=>$prom3,
                         "exa"=>$prom4,
                         "tot"=>$promTotal,
                         "pro"=>$promProm);
            
            $i++;
            $data[] = array("num"=>$i,
                         "mat"=>"CONDUCTA",
                         "nt1"=>$conducta,
                         "nt2"=>$conducta,
                         "nt3"=>$conducta,
                         "exa"=>$conducta,
                         "tot"=>$condTotal,
                         "pro"=>$condProm);
              
            if($faltas->num_rows>0){
                foreach($faltas->result() as $fila){
                    $data[] = array("num"=>"",
                                     "mat"=>"FALTAS",
                                     "nt1"=>$fila->fob_nota1,
                                     "nt2"=>$fila->fob_nota2,
                                     "nt3"=>$fila->fob_nota3,
                                     "exa"=>$fila->fob_examen,
                                     "tot"=>"");
                    
                    if($fila->fob_observacion==""||$fila->fob_observacion==null){
                        $data1[] = array("col1"=>"",
                                            "col2"=>"                 OBSERVACI�N  <b>:</b>          ",
                                            "col3"=>"");
                    }else{
                        $data1[] = array("col1"=>"",
                                            "col2"=>"                 OBSERVACI�N  <b>:</b>          ",
                                            "col3"=>$fila->fob_observacion);
                    }
                }
            }else{
                $data1[] = array("col1"=>"",
                                                "col2"=>"                 OBSERVACI�N  <b>:</b>          ",
                                                "col3"=>"");
                                                
                $data[] = array("num"=>"",
                                 "mat"=>"FALTAS",
                                 "nt1"=>"",
                                 "nt2"=>"",
                                 "nt3"=>"",
                                 "exa"=>"",
                                 "tot"=>"");
            }        
            
            $CI->cezpdf->ezTable($data, $cols, '', array('width'=>500,
                                                          'shaded'=>0,
                                                          'showLines'=>2,
                                                          'fontSize'=>7,                                                              
                                                          'cols'=>array('num'=>array('width'=>25),
                                                                        'mat'=>array('width'=>190),
                                                                        'nt1'=>array('justification'=>'center',
                                                                                     'width'=>35),
                                                                        'nt2'=>array('justification'=>'center',
                                                                                     'width'=>35),
                                                                        'nt3'=>array('justification'=>'center',
                                                                                     'width'=>35),
                                                                        'exa'=>array('justification'=>'center',
                                                                                     'width'=>40),
                                                                        'tot'=>array('justification'=>'center',
                                                                                     'width'=>35),
                                                                        'pro'=>array('justification'=>'center',
                                                                                     'width'=>35))
                                                         )
                             );
                             
            $cols1 = array("col1"=>"",
                            "col2"=>"",
                            "col3"=>"");               
            
            $CI->cezpdf->ezTable($data1, $cols1, '', array('width'=>500,
                                                          'shaded'=>0,
                                                          'showLines'=>2,
                                                          'showHeadings'=>0,
                                                          'fontSize'=>7,                                                              
                                                          'cols'=>array('col1'=>array('width'=>25),
                                                                        'col2'=>array('width'=>119),
                                                                        'col3'=>array('width'=>286))
                                                         )
                             );
            $CI->cezpdf->line(110,500,200,500);
            $CI->cezpdf->line(260,500,350,500);
            $CI->cezpdf->line(410,500,500,500); 
            $CI->cezpdf->addText(5,488,7,"                                                                  DIRECTORA                                                       PROFESOR (A)                                                 REPRESENTANTE");
     
            ob_end_clean();                  
            $CI->cezpdf->ezStream();
        }
        
        function exportToPDF_CuadroHonor($promedios,$periodo,$ano_lectivo,$curso,$esp,$jornada){
            $CI = & get_instance();
            
            $CI->load->library("cezpdf");
            $CI->load->helper('pdf');
            
            $CI->cezpdf->selectFont('fonts/Helvetica.afm');
            header_pdf();
            footer_pdf();
            $CI->cezpdf->ezSetMargins(105,80,50,50);
            $CI->cezpdf->ezText("CUADRO DE HONOR DEL ".strtoupper($periodo),9, array('justification'=>'center'));
            $CI->cezpdf->ezText("\n\n\n",10);
            $CI->cezpdf->setStrokeColor(0,0,0);            
            $CI->cezpdf->rectangle(53,680,42,15);
            $CI->cezpdf->setStrokeColor(0,0,0);
            $CI->cezpdf->rectangle(95,680,58,15);
            $CI->cezpdf->setStrokeColor(0,0,0);            
            $CI->cezpdf->rectangle(153,680,36,15);
            $CI->cezpdf->setStrokeColor(0,0,0);
            $CI->cezpdf->rectangle(189,680,100,15);
            $CI->cezpdf->setStrokeColor(0,0,0);
            $CI->cezpdf->rectangle(289,680,35,15);
            $CI->cezpdf->setStrokeColor(0,0,0);
            $CI->cezpdf->rectangle(324,680,100,15);
            $CI->cezpdf->setStrokeColor(0,0,0);            
            $CI->cezpdf->rectangle(424,680,48,15);
            $CI->cezpdf->setStrokeColor(0,0,0);
            $CI->cezpdf->rectangle(472,680,60,15);
            $CI->cezpdf->addText(57,686,8,"<b>Jornada:</b>    ".$jornada);
            $CI->cezpdf->addText(157,686,8,"<b>Curso:</b>      ".$curso);
            $CI->cezpdf->addText(293,686,8,"<b>Esp. :</b>       ".$esp);
            $CI->cezpdf->addText(428,686,8,"<b>Año / Lec:</b>     ".$ano_lectivo);
            
            $columnas = array("num"=>"<b>No.</b>",
                                "a"=>"<b>                    Apellidos  -  Nombres</b>",
                                "pro"=>"<b>Promedio</b>");
                                
            $data = array();
            $i=0;
            foreach($promedios as $fila){
                $i++;
                $data[] = array("num"=>$i,"a"=>$fila["alumno"],
                                "pro"=>$fila["promedio"]);
            }                    
                            
            $CI->cezpdf->ezTable($data, $columnas, '', array('width'=>480,
                                                             'shaded'=>0,
                                                             'showLines'=>2,
                                                             'fontSize'=>8,
                                                             'cols'=>array('num'=>array('width'=>25),
                                                                            'a'=>array('width'=>355),
                                                                            'pro'=>array('width'=>100,
                                                                                         'justification'=>'center'))
                                                            )
                                );
            
            $CI->cezpdf->ezStream();
        }
    }
?>
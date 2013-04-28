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
            
            $meses = array("01"=>"Enero","02"=>"Febrero","03"=>"Marzo","04"=>"Abril","05"=>"Mayo","06"=>"Junio",
                            "07"=>"Julio","08"=>"Agosto","09"=>"Septiembre","10"=>"Octubre","11"=>"Noviembre",
                            "12"=>"Diciembre");
            
            $array=explode("_", $datos_alu);
            $strFechaBase=$array[8];
            $arrayFecha= explode("-",$strFechaBase);
            $strFechaAlu=$meses[$arrayFecha[1]]." ".$arrayFecha[2].", ".$arrayFecha[0];
            
            if($array[10]=="M")
                $sexo="Masculino";
            else
                $sexo="Fememino";
            
            $CI->load->library("cezpdf");
            $CI->load->helper('pdf');
            
            $CI->cezpdf->selectFont('fonts/Helvetica.afm');
            header_pdf();
            footer_hoja_pdf();
            $CI->cezpdf->ezSetMargins(105,80,60,60);
            $CI->cezpdf->ezText(utf8_decode("<b>HOJA DE MATRÍCULA</b>"),10, array('justification'=>'center'));
            $CI->cezpdf->setStrokeColor(0,0,0);
            $CI->cezpdf->rectangle(430,630,94,100);
            $CI->cezpdf->ezText("\n\n",10);
            $CI->cezpdf->ezText(utf8_decode("<b>Nº Matrícula :</b>    ").$array[27],9);
            $CI->cezpdf->line(122,677,180,677);
            $CI->cezpdf->ezText("\n",8);
            $CI->cezpdf->ezText("<b>     Nombres :</b>    ".strtoupper(utf8_decode($array[1])),9);
            $CI->cezpdf->line(122,648,350,648);
            $CI->cezpdf->ezText("\n",8);
            $CI->cezpdf->ezText("<b>     Apellidos :</b>    ".strtoupper(utf8_decode($array[2])),9);
            $CI->cezpdf->line(122,619,350,619);
            $CI->cezpdf->ezText("\n",8);
            $CI->cezpdf->ezText(utf8_decode("<b>     Dirección :</b>    ").strtoupper(utf8_decode($array[4])),9);
            $CI->cezpdf->line(122,590,350,590);
            $CI->cezpdf->ezText("\n",8);
            $CI->cezpdf->ezText(utf8_decode("<b>      Teléfono :</b>    ").strtoupper(utf8_decode($array[5])),9);
            $CI->cezpdf->addText(235,563,9,"<b>Lugar / Nac. :</b>   ".strtoupper(utf8_decode($array[7])));
            $CI->cezpdf->addText(405,563,9,utf8_decode("<b>País :</b>     ".strtoupper(utf8_decode($array[6]))));
            $CI->cezpdf->line(122,560,215,560);
            $CI->cezpdf->line(295,560,390,560);
            $CI->cezpdf->line(435,560,530,560);
            $CI->cezpdf->ezText("\n",8);
            $CI->cezpdf->ezText("<b> Fecha / Nac.:</b>    ".$strFechaAlu,9);
            $CI->cezpdf->addText(265,535,9,"<b>Edad :</b>   ".$array[9].utf8_decode(" Años"));
            $CI->cezpdf->addText(401,535,9,"<b> Sexo :</b>   ".$sexo);
            $CI->cezpdf->line(122,532,215,532);
            $CI->cezpdf->line(295,532,390,532);
            $CI->cezpdf->line(435,532,530,532);
            $CI->cezpdf->ezText("\n",10);
            
            $columnas = array("num"=>"",
                                "nombres"=>"<b>Nombres</b>",
                                "ocup"=>utf8_decode("<b>Oupación</b>"),
                                "pais"=>utf8_decode("<b>País</b>"));
                                
            $data = array();
            $data[] = array("num"=>"    <b>Padre :</b>",
                            "nombres"=>"   ".strtoupper(utf8_decode($array[14])),
                            "ocup"=>"   ".strtoupper(utf8_decode($array[15])),
                            "pais"=>"   ".strtoupper(utf8_decode($array[16])));

            $data[] = array("num"=>"    <b>Madre :</b>",
                            "nombres"=>"   ".strtoupper(utf8_decode($array[11])),
                            "ocup"=>"   ".strtoupper(utf8_decode($array[12])),
                            "pais"=>"   ".strtoupper(utf8_decode($array[13])));
            if($array[17]=="m"){
                $data[] = array("num"=>"    <b>Represent. :</b>",
                            "nombres"=>"   Madre",
                            "ocup"=>utf8_decode(""),
                            "pais"=>utf8_decode(""));
                
                $data[] = array("num"=>"    <b>Dat - Rep. :</b>",
                                "nombres"=>"     ---     ",
                                "ocup"=>"     ---     ",
                                "pais"=>"     ---     ");  
            }
            elseif($array[17]=="p"){
                $data[] = array("num"=>"    <b>Represent. :</b>",
                            "nombres"=>"   Padre",
                            "ocup"=>utf8_decode(""),
                            "pais"=>utf8_decode(""));
                
                $data[] = array("num"=>"    <b>Dat - Rep. :</b>",
                                "nombres"=>"     ---     ",
                                "ocup"=>"     ---     ",
                                "pais"=>"     ---     ");  
            }
            else{
                $data[] = array("num"=>"    <b>Represent. :</b>",
                            "nombres"=>"    Otro",
                            "ocup"=>utf8_decode(""),
                            "pais"=>utf8_decode(""));
                
                $data[] = array("num"=>"    <b>Dat - Rep. :</b>",
                                "nombres"=>"   ".strtoupper(utf8_decode($array[21])),
                                "ocup"=>"   ".strtoupper(utf8_decode($array[23])),
                                "pais"=>"   ".strtoupper(utf8_decode($array[26])));  
            }                
                            
            $CI->cezpdf->ezTable($data, $columnas, '', array('width'=>480,
                                                             'shaded'=>0,
                                                             'showLines'=>2,
                                                             'fontSize'=>9,
                                                             'rowGap'=>10,
                                                             'cols'=>array('num'=>array('width'=>75),
                                                                            'nombres'=>array('width'=>205,
                                                                                             'justification'=>'center'),
                                                                            'ocup'=>array('width'=>100,
                                                                                             'justification'=>'center'),
                                                                            'pais'=>array('width'=>100,
                                                                                             'justification'=>'center'))
                                                            )
                                );
            $CI->cezpdf->ezText("\n",10);
            $columnas = array("anio"=>utf8_decode("<b>Año Lectívo</b>"),
                                "jornada"=>"<b>Jornada</b>",
                                "curso"=>"<b>Curso</b>");
                                
            $data = array();
            $data[] = array("anio"=>$ano_lectivo,
                            "jornada"=>$jornada,
                            "curso"=>utf8_decode($curso));             
                            
            $CI->cezpdf->ezTable($data, $columnas, '', array('width'=>480,
                                                             'shaded'=>0,
                                                             'showLines'=>2,
                                                             'fontSize'=>9,
                                                             'rowGap'=>10,
                                                             'cols'=>array('anio'=>array('justification'=>'center',
                                                                                          'width'=>100),
                                                                            'jornada'=>array('justification'=>'center',
                                                                                          'width'=>120),
                                                                            'curso'=>array('justification'=>'center',
                                                                                          'width'=>260))
                                                            )
                                );
            
            $CI->cezpdf->ezText("\n",10);
            $CI->cezpdf->ezText("Notas Adicionales :",9);
            $columnas = array("notas"=>"");
            $data = array();
            $data[] = array("notas"=>utf8_decode($array[19]));             
                            
            $CI->cezpdf->ezTable($data, $columnas, '', array('width'=>480,
                                                             'shaded'=>0,
                                                             'showLines'=>2,
                                                             'showHeadings'=>0,
                                                             'fontSize'=>9,
                                                             'rowGap'=>30,
                                                             'cols'=>array('notas'=>array('width'=>480))
                                                            )
                                );
            
            $CI->cezpdf->ezStream();
        }
        
        
        function exportToPDF_EstadoCuenta($alumno,$matricula,$ano_lectivo,$curso,$jornada,$valores,$pagos){
            $CI = & get_instance();
            
            $CI->load->library("cezpdf");
            $CI->load->helper('pdf');
            $CI->cezpdf->cezpdf('estado');
            $CI->cezpdf->selectFont('fonts/Helvetica.afm');
            footer_estado_cuenta();
            $CI->cezpdf->ezImage(site_url("images/logo-escuela2.jpg"), 0, 60, 5, 'left');
            $CI->cezpdf->addText(135,393,6,"Unidad  Educativa");
            $CI->cezpdf->addText(120,380,9,"<b>&quot;La  Luz  de  Dios&quot;</b>");
            $CI->cezpdf->addText(128,359,6,"ESTADO  DE  CUENTA");
            $CI->cezpdf->addText(30,340,5,utf8_decode("<b>Matrícula  :</b>      ").$matricula);
            $CI->cezpdf->addText(30,330,5,"<b>Alumno  :</b>         ".strtoupper(utf8_decode($alumno)));              
            $CI->cezpdf->addText(30,320,5,"<b>Curso  :</b>            ".utf8_decode($curso));
            $CI->cezpdf->addText(190,330,5,utf8_decode("<b>Año Lectívo  :</b>         ").$ano_lectivo);              
            $CI->cezpdf->addText(190,320,5,"<b>Jornada  :</b>                ".$jornada);
            $CI->cezpdf->setStrokeColor(0,0,0);
            $CI->cezpdf->rectangle(25,298,30,8);
            $CI->cezpdf->addText(30,300,6,"<b># Rec.</b>");
            $CI->cezpdf->setStrokeColor(0,0,0);
            $CI->cezpdf->rectangle(55,298,180,8);
            $CI->cezpdf->addText(130,300,6,utf8_decode("<b>Descripción</b>"));
            $CI->cezpdf->setStrokeColor(0,0,0);
            $CI->cezpdf->rectangle(235,298,30,8);
            $CI->cezpdf->addText(242,300,6,"<b>Valor</b>");
            $CI->cezpdf->ezText("\n\n\n\n",12); 
            
            $columnas = array("rec"=>"", "desc"=>"", "valor"=>"");
                                
            $data = array();$cont=0;$i=1;
            if($pagos["t1"]==1){
                $cont=$cont+$valores["val1"];
                $data[] = array("rec"=>$i,
                            "desc"=>utf8_decode("Matrícula"),
                            "valor"=>number_format($valores["val1"], 2, ".",""));
                $i++;
            }
            if($pagos["t12"]==1){
                $cont=$cont+$valores["val2"];
                $data[] = array("rec"=>$i,
                            "desc"=>utf8_decode("Derecho de Examen 1"),
                            "valor"=>number_format($valores["val2"], 2, ".",""));
                $i++;
            }
            if($pagos["t13"]==1){
                $cont=$cont+$valores["val2"];
                $data[] = array("rec"=>$i,
                            "desc"=>utf8_decode("Derecho de Examen 2"),
                            "valor"=>number_format($valores["val2"], 2, ".",""));
                $i++;
            }
            if($pagos["t2"]==1){
                $cont=$cont+$valores["val3"];
                $data[] = array("rec"=>$i,
                            "desc"=>utf8_decode("Mensualidad MAYO"),
                            "valor"=>number_format($valores["val3"], 2, ".",""));
                $i++;
            }
            if($pagos["t3"]==1){
                $cont=$cont+$valores["val3"];
                $data[] = array("rec"=>$i,
                            "desc"=>utf8_decode("Mensualidad JUNIO"),
                            "valor"=>number_format($valores["val3"], 2, ".",""));
                $i++;
            }
            if($pagos["t4"]==1){
                $cont=$cont+$valores["val3"];
                $data[] = array("rec"=>$i,
                            "desc"=>utf8_decode("Mensualidad JULIO"),
                            "valor"=>number_format($valores["val3"], 2, ".",""));
                $i++;
            }
            if($pagos["t5"]==1){
                $cont=$cont+$valores["val3"];
                $data[] = array("rec"=>$i,
                            "desc"=>utf8_decode("Mensualidad AGOSTO"),
                            "valor"=>number_format($valores["val3"], 2, ".",""));
                $i++;
            }
            if($pagos["t6"]==1){
                $cont=$cont+$valores["val3"];
                $data[] = array("rec"=>$i,
                            "desc"=>utf8_decode("Mensualidad SEPTIEMBRE"),
                            "valor"=>number_format($valores["val3"], 2, ".",""));
                $i++;
            }
            if($pagos["t7"]==1){
                $cont=$cont+$valores["val3"];
                $data[] = array("rec"=>$i,
                            "desc"=>utf8_decode("Mensualidad OCTUBRE"),
                            "valor"=>number_format($valores["val3"], 2, ".",""));
                $i++;
            }
            if($pagos["t8"]==1){
                $cont=$cont+$valores["val3"];
                $data[] = array("rec"=>$i,
                            "desc"=>utf8_decode("Mensualidad NOVIEMBRE"),
                            "valor"=>number_format($valores["val3"], 2, ".",""));
                $i++;
            }
            if($pagos["t9"]==1){
                $cont=$cont+$valores["val3"];
                $data[] = array("rec"=>$i,
                            "desc"=>utf8_decode("Mensualidad DICIEMBRE"),
                            "valor"=>number_format($valores["val3"], 2, ".",""));
                $i++;
            }
            if($pagos["t10"]==1){
                $cont=$cont+$valores["val3"];
                $data[] = array("rec"=>$i,
                            "desc"=>utf8_decode("Mensualidad ENERO"),
                            "valor"=>number_format($valores["val3"], 2, ".",""));
                $i++;
            }
            if($pagos["t11"]==1){
                $cont=$cont+$valores["val3"];
                $data[] = array("rec"=>$i,
                            "desc"=>utf8_decode("Mensualidad FEBRERO"),
                            "valor"=>number_format($valores["val3"], 2, ".",""));
                $i++;
            }
            $CI->cezpdf->ezTable($data, $columnas, '', array('width'=>480,
                                                             'shaded'=>0,
                                                             'showLines'=>0,
                                                             'fontSize'=>6,
                                                             'showHeadings'=>0,
                                                             'cols'=>array('rec'=>array('justification'=>'center',
                                                                                          'width'=>30),
                                                                           'desc'=>array('width'=>180),
                                                                           'valor'=>array('justification'=>'right',
                                                                                          'width'=>30))
                                                            )
                                );
            
            
            $CI->cezpdf->ezSetMargins(10,10,20,70);
            $CI->cezpdf->ezText("\n",8); 
            $colmns = array("tot"=>"", "val"=>"");
            $datos=array();
            $datos[] = array("tot"=>"<b>Total Pagado</b>",
                            "val"=>"$   ".number_format($cont, 2, ".",""));
            
            $CI->cezpdf->ezTable($datos, $colmns, '', array('width'=>450,
                                                            'shaded'=>0,
                                                             'fontSize'=>6,
                                                             'xPos'=>'right',
                                                             'showHeadings'=>0,
                                                             'cols'=>array('tot'=>array('justification'=>'center',
                                                                                          'width'=>48),
                                                                           'val'=>array('justification'=>'right',
                                                                                          'width'=>40))
                                                            )
                                );
            
            ob_end_clean();                  
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
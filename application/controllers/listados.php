<?php
    if (! defined('BASEPATH'))
    exit ('No se puede ejecutar directamente este SCRIPT');

    class Listados extends alumno {
        
        function __construct(){
            parent::__construct();
            $this->load->library('grocery_CRUD');
            $this->load->model("mod_acta_calificaciones","acta");
            $this->load->model("mod_libreta","libreta");
        }
        
        function _remap($metodo){
            if(!$this->clslogin->check()){
                redirect(site_url("login"));
            }
            elseif($metodo=="hoja_matricula"){
                $this->hoja_matricula();   
            }
            elseif($metodo=="cuadro_honor"){
                $this->cuadro_honor();   
            }
            elseif($metodo=="cuadro_promocion"){
                $this->cuadro_promocion();   
            }
            elseif($metodo=="cargar_alumnos"){
                $this->combo_alumnos();
            }
            elseif($metodo=="listar_alumnos"){
                $this->list_alu();
            }
            elseif($metodo=="exportar"){
                $ind = $this->input->post("indicador");
                $rd = $this->input->post("radio");
                
                if($ind==0||$ind==null)
                    $this->nominas();
                else{
                    if($rd=="nomina"){
                        $this->exportar_nomina($ind);
                    }elseif($rd=="acta"){
                        $this->exportar_acta($ind);
                    }
                }
            }
            elseif($metodo=="imp_hoja_matricula"){
                $c = $this->input->post("cmbCurso");
                
                if($c==0||$c==""||$c==null)
                    $this->hoja_matricula ();
                else
                    $this->imp_hoja($c);
            }
            elseif($metodo=="listar_materias"){
                $c=$this->input->post("curso");
                $e=$this->input->post("especializacion");
                
                if($e==0)
                    $e=-1;
                
                echo $this->acta->listar_materias($c,$e);  
            }
            elseif($metodo=="ver_promocion"){
                $j=$this->input->post("jor");
                
                if($j=="")
                    $this->cuadro_promocion(); 
                else
                    $this->ver_promocion($j); 
            }
            elseif($metodo=="generar_cuadro"){
                $ind = $this->input->post("indicador");
                
                if($ind==0||$ind==null)
                    $this->cuadro_honor();
                else{
                    $this->generar_cuadro($ind);
                }
            }
            elseif($metodo=="generar_promocion"){
                $ind = $this->input->post("indicador");
                
                if($ind==0||$ind==null)
                    $this->cuadro_promocion();
                else{
                    $this->generar_promocion($ind);
                }
            }
            elseif($metodo=="impPromo"){
                $alu = $this->input->post("alu");
                
                if($alu==0||$alu==null)
                    $this->cuadro_promocion();
                else{
                    $this->imp_promo($alu);
                }
            }
            else{
                $this->nominas();
            }
        }
        
        
        function nominas(){
            $data["jornada"] = $this->cargar_jornadas();
            $data["anioLect"]=$this->cargar_aniosLectivos();
            $data["anlId"]=$this->cargar_anlActual();
            $data["menu"]=$this->load->view("view_menu_administrador");
            $this->load->view("listados/nomina_alumnos", $data);   
        }
        
        
        function hoja_matricula(){
            $data["jornada"] = $this->cargar_jornadas();
            $data["anioLect"]=$this->cargar_aniosLectivos();
            $data["anlId"]=$this->cargar_anlActual();
            $data["menu"]=$this->load->view("view_menu_administrador");
            $this->load->view("listados/hoja_matricula", $data);   
        }
        
        
        function cuadro_honor(){
            $data["jornada"] = $this->alumno->cargar_jornadas();
            $data["curso"] = $this->alumno->cargar_curso(0);
            $data["per_lectivos"]=$this->libreta->cargar_anl();
            $data["anio_lectivo"] = $this->libreta->verificar_anl(date('Y'));
            $data["trimestre"] = $this->acta->cargar_trimestre();
            $data["menu"]=$this->load->view("view_menu_administrador");
            $this->load->view("listados/cuadro_honor", $data);   
        }
        
        function cuadro_promocion(){
            $data["jornada"] = $this->alumno->cargar_jornadas();
            $data["curso"] = $this->alumno->cargar_curso(0);
            $data["per_lectivos"]=$this->libreta->cargar_anl();
            $data["anio_lectivo"] = $this->libreta->verificar_anl(date('Y'));
            $data["trimestre"] = $this->acta->cargar_trimestre();
            $data["menu"]=$this->load->view("view_menu_administrador");
            $this->load->view("listados/cuadro_promocion", $data);   
        }
        
        function exportar_nomina($ind){
            $c = $this->input->post("cmbCurso");
            $j = $this->input->post("cmbJornada");
            $e = $this->input->post("cmbEspec");
            $p = $this->input->post("cmbParalelo");
            $anl = $this->input->post("cmbAnioLec");
            
            if($c<11||$c>14)
                $e=-1;
            
            $cp = $this->encontrarIdCursoParalelo($j, $c, $e, $p);
            $curso = $this->get_nom_curso($cp);
            $jornada = $this->get_nom_jornada($j);
            $ano_lectivo = $this->get_anio_lectivo($anl);
            $alumnos = $this->acta->listar_alumnos($cp, $anl);
            
            if($ind==1){
                $this->load->library('export_pdf');                 
                
                $pdf = new export_pdf();
                
                $pdf->exportToPDF_Nomina($alumnos,$ano_lectivo,$curso,$jornada);    
            }
            elseif($ind==2){
                $this->load->library('export_excel');
                
                $excel = new export_excel();
                $excel->exportToExcel_Nomina($alumnos,"NominaAlumnos.xls",$ano_lectivo,$curso,$jornada);
            }
        }
        
        function exportar_acta($ind){
            $c = $this->input->post("cmbCurso");
            $j = $this->input->post("cmbJornada");
            $e = $this->input->post("cmbEspec");
            $p = $this->input->post("cmbParalelo");
            $mod = $this->input->post("parcial");
            $anl = $this->input->post("cmbAnioLec");
            
            if($c<11||$c>14)
                $e=-1;
            
            $cp = $this->encontrarIdCursoParalelo($j, $c, $e, $p);
            $curso = $this->get_nom_curso($cp);
            $jornada = $this->get_nom_jornada($j);
            $periodo = $this->get_nom_periodo($mod);
            $ano_lectivo = $this->get_anio_lectivo($anl);
            $alumnos = $this->acta->listar_alumnos($cp, $anl);
            $calificaciones = $this->acta->obtener_calificaciones(0, 0, 0);
            
            if($ind==1){
                $this->load->library('export_pdf');                 
                
                $pdf = new export_pdf();
                
                $pdf->exportToPDF_Actas($alumnos,$calificaciones,$periodo,$ano_lectivo,$curso,$jornada,$mod);
            }
            else{
                $this->load->library('export_excel');
                
                $excel = new export_excel();
                $excel->exportToExcel_Acta($alumnos,$calificaciones,"ActaAlumnos.xls",
                                            $periodo,$ano_lectivo,$curso,$jornada);
            }
        }
        
        
        function imp_hoja($c){
            $this->load->library('export_pdf'); 
            $this->load->model('mod_alumno','alumno'); 
            
            $j = $this->input->post("cmbJornada");
            $e = $this->input->post("cmbEspec");
            $p = $this->input->post("cmbParalelo");
            $alu = $this->input->post("cmbAlumnos");
            $anl = $this->input->post("cmbAnioLec");
            
            if($c<11||$c>14)
                $e=-1;
            
            $cp = $this->encontrarIdCursoParalelo($j, $c, $e, $p);
            $curso = $this->get_nom_curso($cp);
            $jornada = $this->get_nom_jornada($j);
            $ano_lectivo = $this->get_anio_lectivo($anl);
            $alumno = $this->alumno->obtener_alumno($alu);
            
            foreach($alumno->result() as $alu)
                $datos_alu = $this->autocompletar_alumno($alu->alu_matricula);
            
            $pdf = new export_pdf();
            $pdf->exportToPDF_Hoja_Matricula($datos_alu,$ano_lectivo,$curso,$jornada);
        }
     
        
        function generar_cuadro($ind){
            $c = $this->input->post("cmbCurso");
            $j = $this->input->post("cmbJornada");
            $e = $this->input->post("cmbEspecializacion");
            $p = $this->input->post("cmbParalelo");
            $t = $this->input->post("cmbTrimestre");
            $anl=$this->input->post("cmbAnioLectivo");
            
            if($c<11||$c>14)
                $e=-1;
            
            $cp = $this->acta->verificar_curso($c, $e, $p, $j);
            $alumnos = $this->acta->listar_alumnos($cp,$anl);
            $materias=$this->libreta->listar_materias_curso($c,$e);
            
            $prom=0.0;$alumno=array();$item=array();$y=0;$keys=array();
            foreach($alumnos->result() as $alu){
                $i=0;                
                $calificaciones = $this->libreta->calificaciones_actas($t,$anl,$alu->alu_id);
                foreach($calificaciones->result() as $cal){
                    $i++;
                    $prom=$prom+(($cal->cal_total)/4);
                }
                $prom=$prom/$i;
                $prom=number_format($prom,2);
                $item[$alu->alu_id]=$prom;
                $y++;                                
            }
            
            arsort($item);
            $keys=array_keys($item);
            
            $promedios=array();$z=0;
            for($y=0;$y<sizeof($keys);$y++){           
                foreach($alumnos->result() as $alu){                            
                    if($keys[$y]==$alu->alu_id){
                        $alumno["alumno"]=$alu->alu_apellidos." ".$alu->alu_nombres;
                        $alumno["promedio"]=$item[$alu->alu_id]; 
                        break;                                         
                     }                                           
                }
                $promedios[$z]=$alumno;
                $z++;
            }
                     
            $periodo = $this->acta->nombre_trimestre($t);
            $curso = $this->acta->nom_cur($cp);
            $esp = $this->acta->nom_esp($e);
            $jornada = $this->acta->nombre_jornada($j);
            $ano_lectivo=$this->libreta->nombre_anl($anl);
            
            if($ind==1){
                $this->load->library('export_pdf');                 
                $pdf = new export_pdf();  
                $pdf->exportToPDF_CuadroHonor($promedios,$periodo,$ano_lectivo,$curso,$esp,$jornada);
            }
            else{
                $this->load->library('export_excel');
                
                $excel = new export_excel();
                $excel->exportToExcel_CuadroHonor($promedios,"CuadroHonor.xls",$periodo,$ano_lectivo,$curso,$esp,$jornada);
            }
        }
        
        function generar_promocion($ind){
            $c = $this->input->post("cmbCurso");
            $j = $this->input->post("cmbJornada");
            $e = $this->input->post("cmbEspecializacion");
            $p = $this->input->post("cmbParalelo");
            $anl=$this->input->post("cmbAnioLectivo");
            
            if($c<11||$c>14)
                $e=-1;
            
            $vc = $this->acta->verificar_curso($c, $e, $p, $j);
            $alumnos = $this->acta->listar_alumnos($vc,$anl);
            $materias = $this->libreta->listar_materias_curso($c, $e);
            
            foreach($alumnos->result() as $alu){
                $calificaciones = $this->libreta->calificaciones_actas(0, $anl, $alu->alu_id);
                break;   
            }
            
            if(($materias->num_rows*3)==$calificaciones->num_rows){
                $dir = $this->libreta->dir_curso($c, $e, $p, $j);
                $mc=$this->acta->materia_curso($dir,$vc);//SACAR LA NOTA DE CONDUCTA DEL DIRIGENTE
                
                $dirigente=$this->acta->cargar_personal($c, $e, $p, $j);
                $curso = $this->acta->nombre_curso($vc);
                $jornada = $this->acta->nombre_jornada($j); 
                
                $anio = $this->libreta->nom_anl($anl); 
                
                $this->load->library('export_pdf');                 
                $pdf = new export_pdf();  
                $pdf->exportToPDF_CuadrosPromo($alumnos,$materias,$dirigente,$curso,$jornada,$anio,$mc,$anl);
            }
            else{
                $this->cuadro_promocion();
            }
        }
        
        function imp_promo($alu){
            $cond1 = $this->input->post("cond1");
            $cond2 = $this->input->post("cond2");
            $cond3 = $this->input->post("cond3");
            $c=$this->input->post("cur");
            $e=$this->input->post("esp");
            $vc=$this->input->post("cp");
            $dirigente=$this->input->post("dir");
            $anl=$this->input->post("anl");
            $j=$this->input->post("jor");
            
            $curso = $this->acta->nombre_curso($vc);
            $jornada = $this->acta->nombre_jornada($j);
            $calificaciones = $this->libreta->calificaciones_actas(0, $anl, $alu);
            $materias = $this->libreta->listar_materias_curso($c, $e); 
            
            $anio = $this->libreta->nom_anl($anl); 
            
            $this->load->library('export_pdf');                 
            $pdf = new export_pdf();  
            $pdf->exportToPDF_Promo($materias,$calificaciones,$alu,$dirigente,$curso,$jornada,$anio,$cond1,$cond2,$cond3);
        }
        
        function combo_alumnos(){
            $c = $this->input->post("cur");
            $e = $this->input->post("esp");
            $p = $this->input->post("par");
            $j = $this->input->post("jor");
            $anl = $this->input->post("anl");
            
            if($e==0)
                $e=-1;
            
            $vc = $this->acta->verificar_curso($c, $e, $p, $j);
            $alumnos = $this->acta->listar_alumnos($vc,$anl);
            $info = array();
            
            foreach($alumnos->result() as $alu){
                $info[$alu->alu_id] = $alu->alu_apellidos ." " .$alu->alu_nombres;
            }
            
            $data["alumnos"] = $info;
            
            $this->load->view("ajax/listados_combo_alumnos", $data);
        }
        
        function ver_promocion($j){
            $c = $this->input->post("cur");
            $e = $this->input->post("esp");
            $p = $this->input->post("par");
            $anl=$this->input->post("anl");
            $alu=$this->input->post("alu");
            
            if($c<11||$c>14)
                $e=-1;
            
            $vc = $this->acta->verificar_curso($c, $e, $p, $j);
            $calificaciones = $this->libreta->calificaciones_actas(0, $anl, $alu);
            $materias = $this->libreta->listar_materias_curso($c, $e);
            
            if(($materias->num_rows*3)==$calificaciones->num_rows){
                $dir = $this->libreta->dir_curso($c, $e, $p, $j);
                $mc=$this->acta->materia_curso($dir,$vc);
                
                $data["cond1"] = $this->libreta->calificacion_conducta(1,$mc,$anl,$alu);
                $data["cond2"] = $this->libreta->calificacion_conducta(2,$mc,$anl,$alu);
                $data["cond3"] = $this->libreta->calificacion_conducta(3,$mc,$anl,$alu);
                $data["calificaciones"] = $calificaciones;
                $data["dirigente"]=$this->acta->cargar_personal($c, $e, $p, $j);
                $data["materias"] = $materias;
                $data["alumno"] = $alu;
                $data["anio_lectivo"] = $anl;  
                $data["curso_paralelo"] = $vc;
                $data["jornada"] = $j;
                $data["curso"] = $c;
                $data["esp"] = $e;
                
                $this->load->view("ajax/listados_promocion", $data);   
            }
            else{
                $this->load->view("alertas/actas_vacias");
            }
        }
        
        
        function list_alu(){
            $c = $this->input->post("cur");
            $j = $this->input->post("jor");
            $e = $this->input->post("esp");
            $p = $this->input->post("par");
            $anl=$this->input->post("anl");
            
            if($c<11||$c>14)
                $e=-1;
            
            $cp = $this->encontrarIdCursoParalelo($j, $c, $e, $p);
            $alu = $this->lista_alumnos($cp,$anl);
            
            echo $alu;
        }
    }
?>
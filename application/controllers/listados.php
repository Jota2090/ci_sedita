<?php
    if (! defined('BASEPATH'))
    exit ('No se puede ejecutar directamente este SCRIPT');

    class Listados extends CI_Controller {
        
        function __construct(){
            parent::__construct();
            $this->load->library('grocery_CRUD');
            $this->load->model("mod_acta_calificaciones","acta");
            $this->load->model("mod_libreta","libreta");
            $this->load->model("mod_alumno","alumno");
        }
        
        function nuevo(){
            if(!$this->clslogin->check()) redirect(site_url("login"));
            $funcion = $this->uri->segment(3);
            $data["link"]=base_url()."listados/".$funcion;
            $this->load->view("view_plantilla",$data);
        }
        
        function buscar_alumnos(){
            if(!$this->clslogin->check()) redirect(site_url("login"));
            $cobros=$this->uri->segment(3);
            if($cobros=="cobros"):
                $matricula=$this->uri->segment(4); $nombres=$this->uri->segment(5);
                $apellidos=$this->uri->segment(6); $anl=$this->uri->segment(7);
            else:
                $matricula=$this->input->post("matricula"); $nombres=$this->input->post("nombres");
                $apellidos=$this->input->post("apellidos"); $anl=$this->input->post("anl");
            endif;
            
            $crud = new grocery_CRUD();
            $crud->set_subject('Alumnos');  
            $crud->set_theme('datatables');
            $crud->set_table('alumno');
            $crud->set_relation('alu_curso_paralelo_id','curso_paralelo','cp_id');
            $crud->set_model('cursoParalelo_join');
            $crud->columns('alu_matricula','alu_nombres','alu_apellidos','cur_nombre','esp_nombre','par_nombre','jor_nombre');
            if($matricula!=""&&$matricula!=0){ echo "jajaja-".$matricula."-jajaja"; $crud->where('alu_matricula',$matricula);}
            if($nombres!=""&&$nombres!=0){ $crud->like('alu_nombres',$nombres);}
            if($apellidos!=""&&$apellidos!=0){ $crud->like('alu_apellidos',$apellidos);}
            $crud->where('alu_ano_lectivo_id',$anl);
            $crud->display_as('alu_matricula','Matricula');
            $crud->display_as('alu_nombres','Nombres');
            $crud->display_as('alu_apellidos','Apellidos');
            $crud->display_as('cur_nombre','Curso');
            $crud->display_as('esp_nombre','Especialización');
            $crud->display_as('par_nombre','Paralelo');
            $crud->display_as('jor_nombre','Jornada');
            $crud->unset_add(); $crud->unset_edit(); $crud->unset_delete(); 
            if($cobros=="cobros") $crud->add_action('Ver', '', 'facturacion/cobrar_pagar','ui-icon-printer');
            else $crud->add_action('Imprimir', '', 'listados/imprimir_hm','ui-icon-printer');
            $output = $crud->render();
            $this->load->view('view_cruds',$output);
        }
        
        /*function _remap($metodo){
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
        }*/
        
        
        function nominas(){
            $general = new General();
            $data["jornada"] = $general->cargar_jornadas();
            $data["anioLect"]=$general->cargar_aniosLectivos();
            $data["anlId"]=$general->cargar_anlActual();
            $this->load->view("listados/nomina_alumnos", $data);   
        }
        
        
        function hoja_matricula(){
            $general = new General();
            $data["jornada"] = $general->cargar_jornadas();
            $data["anioLect"]=$general->cargar_aniosLectivos();
            $data["anlId"]=$general->cargar_anlActual();
            $this->load->view("listados/hoja_matricula", $data);   
        }
        
        
        function cuadro_honor(){
            $general = new General();
            $data["jornada"] = $this->alumno->cargar_jornadas();
            $data["curso"] = $this->alumno->cargar_curso(0);
            $data["per_lectivos"]=$this->libreta->cargar_anl();
            $data["anio_lectivo"] = $this->libreta->verificar_anl(date('Y'));
            $data["trimestre"] = $this->acta->cargar_trimestre();
            $data["menu"]=$this->load->view("view_menu_administrador");
            $this->load->view("listados/cuadro_honor", $data);   
        }
        
        function cuadro_promocion(){
            $general = new General();
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
        
        
        function imprimir_hm(){
            $general= new General();
            $alu= new Alumno();
            $this->load->library('export_pdf'); 
            
            $idAlumno=$this->uri->segment(3);
            $alumno = $this->alumno->obtener_alumno($idAlumno)->row();
            $curso = $general->get_nom_curso($alumno->alu_curso_paralelo_id);
            $jornada = $general->get_nom_jornada($alumno->jor_id);
            $ano_lectivo = $general->get_anio_lectivo($alumno->alu_ano_lectivo_id);
            $datos_alu = $alu->autocompletar_alumno($alumno->alu_matricula);
            
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
    }
?>
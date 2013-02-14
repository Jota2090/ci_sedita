<?php
    if (! defined('BASEPATH'))
    exit ('No se puede ejecutar directamente este SCRIPT');

    class Libreta extends CI_Controller {
        
        function __construct(){
            parent::__construct();
            $this->load->library('grocery_CRUD');
            $this->load->model("mod_alumno2","alumno");
            $this->load->model("mod_acta_calificaciones","acta");
            $this->load->model("mod_libreta","libreta");
        }
        
        function _remap($m){
            if(!$this->clslogin->check())
            {
				redirect(site_url("login"));
			}
            elseif($m=="listar_alumnos"){
                $t = $this->input->post("tri");
                
                if($t=="")
                    $this->libreta_vacia();
                else
                    $this->combo_alumnos($t);
            }
            elseif($m=="visualizar_libretas"){
                $t = $this->input->post("tri");
                
                if($t=="")
                    $this->libreta_vacia();
                else
                    $this->ver_libretas($t);
            }
            elseif($m=="imprimir_libretas"){
                $t = $this->input->post("cmbTrimestre");
                
                if($t=="")
                    $this->libreta_vacia();
                else
                    $this->imprimir_libretas($t);
            }
            elseif($m=="agregar_faltas"){
                $t = $this->input->post("tri");
                
                if($t=="")
                    echo "";
                else
                    $this->add_faltas($t);
            }
            elseif($m=="agregar_observaciones"){
                $t = $this->input->post("tri");
                
                if($t=="")
                    echo "";
                else
                    $this->add_observaciones($t);
            }
            elseif($m=="guardar_faltas"){
                $t = $this->input->post("tri");
                
                if($t=="")
                    echo "";
                else
                    $this->faltas($t);
            }
            elseif($m=="guardar_observaciones"){
                $t = $this->input->post("tri");
                
                if($t=="")
                    echo "";
                else
                    $this->observaciones($t);
            }
            else{
                $this->libreta_vacia();
            }
        }
        
        
        function libreta_vacia(){
            $data["menu"]=$this->load->view("view_menu_administrador");
            $data["jornada"] = $this->alumno->cargar_jornadas();
            $data["curso"] = $this->alumno->cargar_curso(0);
            $data["per_lectivos"]=$this->libreta->cargar_anl();
            $data["anio_lectivo"] = $this->libreta->verificar_anl(date('Y'));
            $data["trimestre"] = $this->acta->cargar_trimestre();
            $data["mensaje"] = "";
            
            $this->load->view("view_libreta.php", $data); 
        }
        
        function combo_alumnos($t){
            $c = $this->input->post("cur");
            $e = $this->input->post("esp");
            $p = $this->input->post("par");
            $j = $this->input->post("jor");
            $anl=$this->input->post("anl");
            
            if($e==0)
                $e=-1;
            
            $vc = $this->acta->verificar_curso($c, $e, $p, $j);
            $alumnos = $this->acta->listar_alumnos($vc,$anl);
            $info = array();
            
            foreach($alumnos->result() as $alu){
                $info[$alu->alu_id] = $alu->alu_apellidos ." " .$alu->alu_nombres;
            }
            
            $data["alumnos"] = $info;
            $this->load->view("view_combo_alumno", $data);
        }
        
        function ver_libretas($t){
            $ind = $this->input->post("indicador");
            $j = $this->input->post("jor");
            $c = $this->input->post("cur");
            $e = $this->input->post("esp");
            $p = $this->input->post("par");
            
            if($ind>0 || $ind!=null){
                $this->load->library('export_pdf');     
                
                $vc=$this->input->post("curso_paralelo");
                $anl=$this->input->post("anio_lectivo"); 
                $conducta=$this->input->post("conducta");
                $alu=$this->input->post("alumno");
                
                $dirigente=$this->acta->cargar_personal($c, $e, $p, $j);
                $curso = $this->acta->nombre_curso($vc);
                $jornada = $this->acta->nombre_jornada($j); 
                $calificaciones = $this->libreta->calificaciones_actas($t, $anl, $alu);
                $materias = $this->libreta->listar_materias_curso($c, $e);

                $fecha_actual = date('Y');
                $fecha_despues = date('Y')+1;
                $anio = $fecha_actual ." - " .$fecha_despues ;           
            
                $pdf = new export_pdf();
                $pdf->exportToPDF_LibretaAlumno($calificaciones,$materias,$dirigente,$anio,$anl,$curso,
                                                                            $jornada,$t,$conducta,$alu);
                    
            }else{
                $data["conducta"]="";
                $alu = $this->input->post("alu");
                $anl = $this->input->post("anl");
        
                if($e==0)
                    $e=-1;
                
                $vc = $this->acta->verificar_curso($c, $e, $p, $j);
                $calificaciones = $this->libreta->calificaciones_actas($t, $anl, $alu);
                $materias = $this->libreta->listar_materias_curso($c, $e);
                
                if($materias->num_rows == $calificaciones->num_rows){
                    $dir = $this->libreta->dir_curso($c, $e, $p, $j);
                    $mc=$this->acta->materia_curso($dir,$vc);
                    
                    $data["conducta"] = $this->libreta->calificacion_conducta($t,$mc,$anl,$alu);
                    $data["calificaciones"] = $calificaciones;
                    $data["materias"] = $materias;
                    $data["alumno"] = $alu;
                    $data["periodo"] = $t;
                    $data["anio_lectivo"] = $anl;  
                    $data["curso_paralelo"] = $vc;
                    $data["jornada"] = $j;
                    $data["curso"] = $c;
                    $data["paralelo"] = $p;
                    $data["especializacion"] = $e;  
                    
                    $this->load->view("ajax/libreta_consultar", $data);   
                }
                else{
                    $this->load->view("alertas/actas_vacias");
                }
            }
        }
        
        function imprimir_libretas($t){
            $c = $this->input->post("cmbCurso");
            $e = $this->input->post("cmbEspecializacion");
            $p = $this->input->post("cmbParalelo");
            $j = $this->input->post("cmbJornada");
            $anl = $this->input->post("cmbAnioLectivo");
            $conducta="";
            
            if($e==0)
                $e=-1;
            
            $vc = $this->acta->verificar_curso($c, $e, $p, $j);
            $list_alumnos=$this->acta->listar_alumnos($vc,$anl);
        
            if($list_alumnos->num_rows>0){
                 $listado=array();
                 foreach($list_alumnos->result() as $lstAlu){
                     $listado[0]= $lstAlu->alu_id;
                     break;
                 }
                                  
                 $calificaciones = $this->libreta->calificaciones_actas($t, $anl, $listado[0]);
                 $materias = $this->libreta->listar_materias_curso($c, $e);
                 
                 if($materias->num_rows == $calificaciones->num_rows){
                    $this->load->library('export_pdf');      
                    
                    $dir = $this->libreta->dir_curso($c, $e, $p, $j);
                    $mc=$this->acta->materia_curso($dir,$vc);
                    $conducta = $this->libreta->calificacion_conducta($t,$mc,$anl,$alu);
                    
                    $dirigente=$this->acta->cargar_personal($c, $e, $p, $j);
                    $curso = $this->acta->nombre_curso($vc);
                    $jornada = $this->acta->nombre_jornada($j); 
                    
                    $anio = $this->libreta->nom_anl($anl);           
                
                    $pdf = new export_pdf();
                    $pdf->exportToPDF_Libretas($list_alumnos,$materias,$dirigente,$anio,$anl,$curso,
                                                $jornada,$t,$mc,$c);
                 }
                 else{
                     $this->load->view("alertas/actas_vacias");
                 }
             }
             else{
                 $this->load->view("alertas/actas_vacias");
            }
        }
        
        function add_faltas($t){
            $alu=$this->input->post("alu");
            $anl=$this->input->post("anl");
            $data["fob"]=$this->libreta->verificar_fob($t,$alu,$anl);
            $data["tri"]=$t;
            
            $this->load->view("ajax/libreta_faltas",$data);
        }
        
        function add_observaciones($t){
            $alu=$this->input->post("alu");
            $anl=$this->input->post("anl");
            $data["fob"]=$this->libreta->verificar_fob($t,$alu,$anl);
            
            $this->load->view("ajax/libreta_observacion",$data);
        }
        
        function faltas($t){
            $alu=$this->input->post("alu");
            $anl=$this->input->post("anl");
            $vfob=$this->libreta->verificar_fob($t,$alu,$anl);
            
            $nt1=$this->input->post("nt1");
            $nt2=$this->input->post("nt2");
            $nt3=$this->input->post("nt3");
            $exa=$this->input->post("exa");
            
            if($vfob->num_rows==0)
                $this->libreta->insertar_faltas($nt1,$nt2,$nt3,$exa,$alu,$t,$anl);
            else{
                foreach($vfob->result() as $fila)
                    $this->libreta->actualizar_faltas($fila->fob_id,$nt1,$nt2,$nt3,$exa);
            }
                
                
            $this->load->view("alertas/libreta_exito_faltas");
        }
        
        function observaciones($t){
            $alu=$this->input->post("alu");
            $anl=$this->input->post("anl");
            $vfob=$this->libreta->verificar_fob($t,$alu,$anl);
            
            $obs=$this->input->post("obs");
            
            if($vfob->num_rows==0)
                $this->libreta->insertar_observacion($obs,$alu,$t,$anl);
            else{
                foreach($vfob->result() as $fila)
                    $this->libreta->actualizar_observacion($fila->fob_id,$obs);
            }
                
            $this->load->view("alertas/libreta_exito_faltas");
        }
    }
?>
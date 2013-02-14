<?php
    if (! defined('BASEPATH'))
    exit ('No se puede ejecutar directamente este SCRIPT');

    class Alumno_Profesor extends CI_Controller {
        
        function __construct(){
            parent::__construct();
            $this->load->library('grocery_CRUD');
            $this->load->model("mod_acta_calificaciones","acta");
            $this->load->model("mod_alumno2","alumno");
            $this->load->model("mod_libreta","libreta");
        }
        
        function _remap($m){
            if(!$this->clslogin->check())
            {
				redirect(site_url("login"));
			}
            if($this->clslogin->getTipoUser() == 1){
                $this->load->view("view_administrador");
            }
            elseif($m=="libreta"){
                $this->lib_prof();
            }
            elseif($m=="cargar_curso"){
                $m = $this->input->post("mat");
                echo $this->acta->cargar_personal_curso($m,$this->clslogin->getId());
            }
            elseif($m=="detalle_alumno"){
                $alu = $this->input->post("alu");
                $data["rs"]=$this->alumno->det_alu($alu);
                $this->load->view("profesor/detalle_alumno",$data);
            }
            elseif($m=="imp_rep"){
                $cp = $this->input->post("cur");
                
                if($cp==0||$cp==null)
                    $this->alumnos();
                else
                    $this->listar_rep($cp);
            }
            elseif($m=="alu_list"){
                $t = $this->input->post("tri");
                
                if($t=="")
                    $this->libreta_vacia();
                else
                    $this->combo_alumnos($t);
            }
            elseif($m=="listar_alumnos"){
                $c = $this->input->post("cur");
                $anl = $this->input->post("anl");
                
                $rs=$this->acta->listar_alumnos($c,$anl);
                $info="";
                foreach($rs->result() as $fila)
                    $info.="<option value='".$fila->alu_id."'>".$fila->alu_apellidos." ".$fila->alu_nombres."</option>";
                
                echo $info;
            }
            elseif($m=="visualizar_libretas"){
                $t = $this->input->post("tri");
                
                if($t=="")
                    $this->libreta_vacia();
                else
                    $this->ver_libretas($t);
            }
            else{
                $this->alumnos();
            }
        }
        
        function ver_libretas($t){
            $cp = $this->input->post("cur");
            
            $data["conducta"]="";
            $alu = $this->input->post("alu");
            $anl = $this->input->post("anl");
            $t;
            $calificaciones = $this->libreta->calificaciones_actas($t, $anl, $alu);
            $cur_esp=$this->acta->cur_esp($cp);
            foreach($cur_esp->result() as $fila){
                $c=$fila->cur_id;
                $e=$fila->esp_id;
                $j=$fila->jor_id;
                $p=$fila->par_id;
            }
            $materias = $this->libreta->listar_materias_curso($c, $e);
            
            if($materias->num_rows == $calificaciones->num_rows){
                $mat=$this->acta->materia_personal($this->clslogin->getId(),$c,$e,$p,$j,$anl);
                $mc=$this->acta->materia_curso($mat,$cp);
                
                $data["conducta"] = $this->libreta->calificacion_conducta($t,$mc,$anl,$alu);
                $data["calificaciones"] = $calificaciones;
                $data["materias"] = $materias;
                
                $this->load->view("profesor/libreta_consultar", $data);   
            }
            else{
                $this->load->view("alertas/actas_vacias");
            }
        }
        
        function lib_prof(){
            $id_per = $this->clslogin->getId();
            $data["mensaje"]="";
            $data["curso"] = $this->acta->cursos_personal($id_per);
            $data["trimestre"] = $this->acta->cargar_trimestre();
            $data["per_lectivos"]=$this->libreta->cargar_anl();
            $data["anio_lectivo"] = $this->libreta->verificar_anl(date('Y'));
            $data["menu"]=$this->load->view("view_menu_profesor");
            $this->load->view("profesor/prof_libreta", $data);
        }
        
        function alumnos(){
            $id_per = $this->clslogin->getId();
            $data["materia"] = $this->acta->cargar_materias_personal($id_per);
            $data["menu"]=$this->load->view("view_menu_profesor");
            $data["per_lectivos"]=$this->libreta->cargar_anl();
            $data["anio_lectivo"] = $this->libreta->verificar_anl(date('Y'));
            $this->load->view("profesor/prof_alumno", $data);
        }
        
        function listar_rep($cp){
            $anio = $this->input->post("anio");
            $curso=$this->input->post("curtxt");
            $rs=$this->acta->listar_rep($cp,$anio);
            
            $this->load->library('export_pdf');                 
            $pdf = new export_pdf();
            $pdf->exportToPDF_Repre($rs,$curso);
        }
        
        function combo_alumnos($t){
            $c = $this->input->post("cur");
            $anl=$this->input->post("anl");
            
            $alumnos = $this->acta->listar_alumnos($c,$anl);
            $info = array();
            
            foreach($alumnos->result() as $alu){
                $info[$alu->alu_id] = $alu->alu_apellidos ." " .$alu->alu_nombres;
            }
            
            $data["alumnos"] = $info;
            $this->load->view("profesor/combo_alumno", $data);
        }
    }
?>
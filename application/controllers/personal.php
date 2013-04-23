<?php 
    
    if ( ! defined('BASEPATH')) exit('No direct script access allowed');

    class Personal extends CI_Controller {
        
        function __construct(){
    		parent::__construct();
            $this->load->library('grocery_CRUD');
            $this->load->model("mod_alumno2","alumno");
            $this->load->model("mod_personal","personal");
            $this->load->model("mod_libreta","libreta");
    	}
     
        function _remap($metodo){
            if(!$this->clslogin->check()){
				redirect(site_url("login"));
			}
            elseif($metodo=="guardar"){
                $n=$this->input->post("txtNombres");
                
                if($n==""||$n==null)
                    $this->reg_personal();
                else
                    $this->guardar($n);
            }
            elseif($metodo=="cd_guardar"){
                $c=$this->input->post("cur");
                
                if($c==""||$c==null)
                    $this->imparte();
                else
                    $this->cd_guardar($c);
            }
            elseif($metodo=="cargar_cur_dir"){
                $this->listar_pc();
            }
            elseif($metodo=="asignacion_cursos"){
                $this->imparte();
            }
            elseif($metodo=="consultar"){
                $this->per_consultar();
            }
            else{
                $this->reg_personal();
            }
        }
        
        function reg_personal(){
            $data["cargos"]=$this->personal->cargar_tipo_personal();
            $data["anio_lectivo"]=$this->libreta->cargar_anl();
            $data["anl"] = $this->libreta->verificar_anl(date('Y'));
            $data["menu"]=$this->load->view("view_menu_administrador");
            $this->load->view("personal/registro_personal",$data);   
        }
        
        function per_consultar(){
            $ind=$this->input->post("ind");
            
            $crud = new grocery_CRUD();

			$crud->set_theme('datatables');
			$crud->set_table('personal');
			$crud->set_subject('Personal Docente');
            $crud->display_as('per_cargo_id','Cargo');
            $crud->display_as('per_nombres','Nombres');
            $crud->display_as('per_apellidos','Apellidos');
            $crud->display_as('per_telefono','Telefono');
            $crud->display_as('per_celular','Celular');
            $crud->display_as('per_anio_lectivo_id','Ingres&oacute;');
            $crud->display_as('per_cedula','C&eacute;dula');
            $crud->set_relation('per_cargo_id','cargo_personal','car_nombre');
            $crud->set_relation('per_anio_lectivo_id','anio_lectivo','anl_periodo');
            $crud->callback_before_delete(array($this,'personal_before_delete'));
            $crud->where('per_estado','a');
            $crud->unset_columns('per_id','per_anio_lectivo_id','per_domicilio','per_comentarios','per_estado');
            $crud->unset_add();
            
            if($ind>0){
                $nom=$this->input->post("nom");
                $ape=$this->input->post("ape");
                
                if($nom!=""&&$nom!=null)
                    $crud->like('per_nombres',$nom);
                
                if($ape!=""&&$ape!=null) 
                    $crud->or_like('per_apellidos',$ape);
                    
                $output = $crud->render();
            
                $this->load->view("ajax/personal_curso_dirigente",$output);
            }
            else{
                $output = $crud->render();
                $output->menu=$this->load->view("view_menu_administrador");
                $this->load->view("personal/actualizar_personal",$output);   
            }
        }
        
        function personal_before_delete($primary_key){
            
            $this->db->where('per_id',$primary_key);
            $user = $this->db->get('personal')->row();
         
            if(empty($user))
                return false;
            
            $this->db->where('per_id',$primary_key);
            $this->db->update('personal',array('per_estado'=>'d'));
            
            return true;
        }
        
        function imparte(){
            $crud = new grocery_CRUD();

			$crud->set_theme('datatables');
			$crud->set_table('personal_curso');
			$crud->set_subject('Cursos y Dirigentes');
            $crud->where('pc_personal_id',0);
            $crud->display_as('pc_curso_id','Curso');
            $crud->display_as('pc_especializacion_id','Especializacion');
            $crud->display_as('pc_paralelo_id','Par.');
            $crud->display_as('pc_jornada_id','Jornada');
            $crud->display_as('pc_dirigente','Dirige');
            $crud->display_as('pc_materia_id','Materia');
            $crud->unset_columns('pc_personal_id','pc_anio_lectivo_id');
            $crud->unset_add();$crud->unset_edit();
            $output = $crud->render();
            
            $output->anio_lectivo=$this->libreta->cargar_anl();
            $output->anl = $this->libreta->verificar_anl(date('Y'));
            $output->nivel = $this->alumno->cargar_niveles();
            $output->curso = $this->alumno->cargar_curso(0);
            $output->jornada = $this->alumno->cargar_jornadas();
            $output->profesor = $this->personal->cargar_profesor();
            $output->menu=$this->load->view("view_menu_administrador");
            $this->load->view("personal/imparte",$output);   
        }
        
        function guardar($n){
            $c=$this->input->post("cmbCargo");
            $anl=$this->input->post("cmbAnioLectivo");
            $ap=$this->input->post("txtApellidos");
            $tel=$this->input->post("txtTelefono");
            $cell=$this->input->post("txtCell");
            $ced=$this->input->post("txtCedula");
            $dom=$this->input->post("txtDomicilio");
            $com=$this->input->post("txtComentarios");
            
            $this->personal->guardar_personal($n,$ap,$ced,$dom,$tel,$cell,$anl,$com,$c);
            
            $this->reg_personal();
        }
        
        function cd_guardar($c){
            $e=$this->input->post("esp");
            $par=$this->input->post("par");
            $j=$this->input->post("jor");
            $m=$this->input->post("mat");
            $d=$this->input->post("dir");
            $per=$this->input->post("per");
            $anl=$this->input->post("anl");
            
            if($d!="SI")
                $d="--";
            
            if($c<11||$c>14)
                $e=-1;
                
            $this->personal->cd_guardar($c,$e,$par,$j,$m,$d,$per,$anl);
            
            $this->listar_pc();
        }
        
        function listar_pc(){
            $p=$this->input->post("per");
            $anl=$this->input->post("anl");
            
            $crud = new grocery_CRUD();

			$crud->set_theme('datatables');
			$crud->set_table('personal_curso');
			$crud->set_subject('Cursos y Dirigentes');
            
            $crud->set_relation('pc_curso_id','curso','cur_nombre');
            $crud->set_relation('pc_especializacion_id','especializacion','esp_nombre');
            $crud->set_relation('pc_paralelo_id','paralelo','par_nombre');
            $crud->set_relation('pc_jornada_id','jornada','jor_nombre');
            $crud->set_relation('pc_materia_id','materia','mat_nombre');
            $crud->where('pc_personal_id',$p);
            $crud->where('pc_anio_lectivo_id',$anl);
            
            $crud->display_as('pc_curso_id','Curso');
            $crud->display_as('pc_especializacion_id','Especializacion');
            $crud->display_as('pc_paralelo_id','Par.');
            $crud->display_as('pc_jornada_id','Jornada');
            $crud->display_as('pc_dirigente','Dirige');
            $crud->display_as('pc_materia_id','Materia');
            
            $crud->unset_columns('pc_personal_id','pc_anio_lectivo_id');
            $crud->unset_add();$crud->unset_edit();
            
            $output = $crud->render();
            
            $this->load->view("ajax/personal_curso_dirigente",$output);
        }
        
    }
    
?>
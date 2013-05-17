<?php 
    
    if ( ! defined('BASEPATH')) exit('No direct script access allowed');

    class Personal extends CI_Controller {
        
        function __construct(){
    		parent::__construct();
            $this->load->library('grocery_CRUD');
            $this->load->model("mod_personal","personal");
            $this->load->model("mod_libreta","libreta");
    	}
        
        function nuevo(){
            if(!$this->clslogin->check()) redirect(site_url("login"));
            $funcion = $this->uri->segment(3);
            $data["link"]=base_url()."personal/".$funcion;
            $this->load->view("view_plantilla",$data);
        }
     
        /*function _remap($metodo){
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
        }*/
        
        function registro(){
            if(!$this->clslogin->check()){redirect(site_url("login/login2"));}
            
            $general = new General();
            $data["cargos"]=$this->personal->cargar_tipo_personal();
            $data["anioLect"]=$general->cargar_aniosLectivos();
            $data["anlId"]=$general->cargar_anlActual();
            $this->load->view("personal/registro_personal",$data);   
        }
        
        function guardar(){
            if(!$this->clslogin->check()){redirect(site_url("login/login2"));}
            
            $this->personal->guardar_personal();
            echo "<script>alert('Los datos del personal han sido guardados con exito.');
                    window.location.href='".base_url()."personal/registro/';
                  </script>";
        }
        
        function asignacion_cursos(){
            if(!$this->clslogin->check()){redirect(site_url("login/login2"));}
            
            $general = new General();
            $data["anio_lectivo"]=$general->cargar_aniosLectivos();
            $data["anl"] = $general->cargar_anlActual();
            $data["jornada"]= $general->cargar_jornadas();
            $data["profesor"] = $this->personal->cargar_profesor();
            $this->load->view("personal/imparte",$data);   
        }
        
        function cargar_cur_dir(){
            if(!$this->clslogin->check()){redirect(site_url("login/login2"));}
            
            $p=$this->input->post("per");
            $anl=$this->input->post("anl");
            
            $crud = new grocery_CRUD();
            $crud->set_theme('datatables');
            $crud->set_table('personal_curso');
            $crud->set_subject('Cursos y Dirigentes');
            $crud->set_relation('pc_materia_id','materia','mat_nombre');
            $crud->set_model('cursoParaleloPersonal_join');
            $crud->columns('pc_materia_id','cur_nombre','esp_nombre','par_nombre','jor_nombre','pc_dirigente');
            $crud->where('pc_personal_id',$p);
            $crud->where('pc_anio_lectivo_id',$anl);
            $crud->display_as('cur_nombre','Curso');
            $crud->display_as('esp_nombre','Especialización');
            $crud->display_as('par_nombre','Paralelo');
            $crud->display_as('jor_nombre','Jornada');
            $crud->display_as('pc_dirigente','Dirige');
            $crud->display_as('pc_materia_id','Materia');
            $crud->unset_add();$crud->unset_edit();
            $output = $crud->render();
            
            $this->load->view("view_cruds",$output);
        }
        
        function cd_guardar(){
            if(!$this->clslogin->check()){redirect(site_url("login/login2"));}
            $this->personal->cd_guardar();
            $this->cargar_cur_dir();
        }
        
        function cargar_materias(){
            if(!$this->clslogin->check()){redirect(site_url("login/login2"));}
            $this->personal->cargar_mat_curso();
        }
        
        function consultar(){
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
            $crud->unset_operations();
            $crud->add_action('Editar', '', 'personal/editar','ui-icon-pencil');
            $crud->add_action('Eliminar', '', 'personal/eliminar','ui-icon-circle-minus');
            
            if($ind>0){
                $nom=$this->input->post("nom");
                $ape=$this->input->post("ape");
                
                if($nom!=""&&$nom!=null) $crud->like('per_nombres',$nom);
                if($ape!=""&&$ape!=null) $crud->or_like('per_apellidos',$ape);
                    
                $output = $crud->render();
                $this->load->view("view_cruds",$output);
            }
            else{
                $output = $crud->render();
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

    }
    
?>
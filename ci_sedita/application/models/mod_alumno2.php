<?php
    if (! defined('BASEPATH'))
    exit ('No se puede ejecutar directamente este SCRIPT');

    class mod_alumno2 extends CI_Model {
        
        function __construct(){
            parent::__construct();
        }
        
        function cargar_especializaciones($jornada,$curso){
            $this->db->distinct();
			$this->db->order_by("esp_nombre");
            $this->db->select("esp_id,esp_nombre");
            $this->db->from("curso_paralelo");
            $this->db->where("cp_jornada_id",$jornada);
            $this->db->where("cp_curso_id",$curso);
            $this->db->join("especializacion", "cp_especializacion_id = esp_id");
            $rs= $this->db->get();
            $info="";
            
            $info .="<option value='0'>Seleccione una especializaci&oacute;n</option>";
                        
            foreach($rs->result() as $row){
                $info .="<option value='".$row->esp_id."'>".$row->esp_nombre."</option>";
            }
            return $info;
        }
        
        function cargar_paralelos($jornada,$curso){
            $this->db->where("cp_jornada_id",$jornada);
            $this->db->where("cp_curso_id",$curso);
            $rs1= $this->db->get("curso_paralelo");
            
            $info="";
            $info .="<option value='0'>Seleccione un paralelo</option>";
            foreach($rs1->result() as $row1){
                $this->db->where("par_id",($row1->cp_paralelo_id));
                $rs2= $this->db->get("paralelo");
                foreach($rs2->result() as $row2){
                $info .="<option value='".$row2->par_id."'>".$row2->par_nombre."</option>";
                }
            }
            return $info;
        }
        
        
        function cargar_paralBachill($jornada,$curso,$espec){
            $this->db->where("cp_jornada_id",$jornada);
            $this->db->where("cp_curso_id",$curso);
            $this->db->where("cp_especializacion_id",$espec);
            $rs1= $this->db->get("curso_paralelo");
            
            $info="";
            $info .="<option value=''>Seleccione un paralelo</option>";
            foreach($rs1->result() as $row1){
                $this->db->order_by("par_nombre");
                $this->db->where("par_id",($row1->cp_paralelo_id));
                $rs2= $this->db->get("paralelo");
                foreach($rs2->result() as $row2){
                $info .="<option value='".$row2->par_id."'>".$row2->par_nombre."</option>";
                }
            }
            return $info;
        }
        
        function det_alu($alu){
            $this->db->where("alu_id",$alu);
            $this->db->join("representante","alu_representante_id=rep_id");
            $rs=$this->db->get("alumno");
              
            return $rs;
        }

        function cargar_categorias(){
            $this->db->group_by("cat_nombre");
            $rs=$this->db->get("categoria_alumno");
            $info=array();
            foreach ($rs->result() as $fila){
                $info[$fila->cat_id] = $fila->cat_id ."::" .$fila->cat_nombre;
            }
                
            return $info;
        }
        
        function cargar_jornadas(){
            $this->db->group_by("jor_nombre");
            $rs = $this->db->get("jornada");
            $info = array();
            
            foreach ($rs->result() as $fila){
                $info[$fila->jor_id] = $fila->jor_id ."::" .$fila->jor_nombre;
            }
                
            return $info;
        }
        
        function cargar_niveles(){
            $this->db->group_by("niv_nombre");
            $this->db->order_by("niv_id");
            $rs=$this->db->get("nivel");
            $info=array();
            $info[0] = "<< Todos >>";
            foreach ($rs->result() as $fila){
                $info[$fila->niv_id] = $fila->niv_id ."::" .$fila->niv_nombre;
            }
                
            return $info;
        }
        
        function cargar_curso($nivel){
            $info="";
            
            if($nivel == 0){
                $info .="<option value='0'>Todos los Cursos</option>";
                $this->db->where("cur_nivel_id",1);
                $this->db->or_where("cur_nivel_id",2);                                
            }elseif($nivel == 1){
                $info .="<option value='-1'>Todos los Basicos</option>";
                $this->db->where("cur_nivel_id",$nivel);                
            }else{
                $info .="<option value='-2'>Todos los Bachilleratos</option>";
                $this->db->where("cur_nivel_id",$nivel);                                
            }
            
            $this->db->order_by("cur_id");
            $rs= $this->db->get("curso");            
                        
            foreach($rs->result() as $row){
                $info .="<option value='".$row->cur_id."'>".$row->cur_nombre."</option>";
            }
            return $info;
        }
        
        function cargar_especializacion($curso, $jornada){
            $this->db->select("esp_nombre, esp_id");
            $this->db->from("curso_paralelo");
            $this->db->where("cp_curso_id",$curso);
            $this->db->where("cp_jornada_id",$jornada);
            $this->db->where("cp_paralelo_id",1);
            $this->db->join("especializacion", "cp_especializacion_id = esp_id");
            
            $rs= $this->db->get();
            $info="";
            
            $info .="<option value='0'>Todas las Especializaciones</option>";
                        
            foreach($rs->result() as $row){
                $info .="<option value='".$row->esp_id."'>".$row->esp_nombre."</option>";
            }
            return $info;
        }
    }
?>
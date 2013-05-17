<?php
    if (! defined('BASEPATH'))
    exit ('No se puede ejecutar directamente este SCRIPT');

    class mod_personal extends CI_Model {
        
        function __construct(){
            parent::__construct();
        }
        
        function cargar_tipo_personal(){
            $this->db->order_by("car_id");
            $rs=$this->db->get("cargo_personal");
            $info="";
            
            foreach ($rs->result() as $fila){
                $info .= "<option value='".$fila->car_id."'>".$fila->car_nombre."</option>";
            }
                
            return $info;
        }
        
        function guardar_personal(){
            $data = array(
                   'per_nombres' => utf8_encode(trim($this->input->post("txtNombres"))),
                   'per_apellidos' => utf8_encode(trim($this->input->post("txtApellidos"))),
                   'per_cedula' => trim($this->input->post("txtCedula")),
                   'per_domicilio' => utf8_encode(trim($this->input->post("txtDomicilio"))),
                   'per_telefono' => trim($this->input->post("txtTelefono")),
                   'per_celular' => trim($this->input->post("txtCell")),
                   'per_anio_lectivo_id' => $this->input->post("cmbAnioLectivo"),
                   'per_comentarios' => utf8_encode(trim($this->input->post("txtComentarios"))),
                   'per_cargo_id' => $this->input->post("cmbCargo"),
                   'per_estado' => 'a'
                );
                
            $this->db->insert('personal', $data); 
        }
        
        function cargar_mat_curso(){
            $this->db->order_by("mat_nombre");
            $this->db->join("materia","mat_id=mc_materia_id");
            $this->db->where("mc_curso_id",$this->input->post("cur"));
            $this->db->where("mc_especializacion_id",$this->input->post("esp"));
            $rs=$this->db->get("materia_curso");
            $info="";
            
            foreach ($rs->result() as $fila){
                $info .= "<option value='".$fila->mat_id."'>".$fila->mat_nombre."</option>";
            }
                
            echo $info;
        }
                
        function cd_guardar(){
            $c=$this->input->post("cur");
            $e=$this->input->post("esp");
            $d=$this->input->post("dir");
            
            if($d!="SI") $d="--";
            if($c<11||$c>14) $e=-1;
            
            $data = array(
                   'pc_personal_id' => $this->input->post("per"),
                   'pc_curso_id' => $c ,
                   'pc_especializacion_id' => $e ,
                   'pc_paralelo_id' => $this->input->post("par"),
                   'pc_jornada_id' => $this->input->post("jor") ,
                   'pc_dirigente' => $d ,
                   'pc_anio_lectivo_id' => $this->input->post("anl"),
                   'pc_materia_id' => $this->input->post("mat") 
                );
                
            $this->db->insert('personal_curso', $data);
        }
        
        function cargar_profesor(){
            $this->db->order_by("per_apellidos, per_nombres");
            $this->db->where("per_cargo_id",4);
            $rs=$this->db->get("personal");
            
            $info="";
            foreach ($rs->result() as $fila){
                $info .= "<option value='".$fila->per_id."'>".$fila->per_apellidos." ".$fila->per_nombres."</option>";
            }
                
            return $info;
        }
        
        
        function mat_prof_dirigente($cp, $anl){
            $this->db->from("personal_curso");
            $this->db->where("pc_curso_paralelo_id",$cp);
            $this->db->where("pc_dirigente","SI");
            $this->db->where("pc_anio_lectivo_id",$anl);
            
            $rs= $this->db->get();
            $info="";
            foreach($rs->result() as $fila){
                $info=$fila->pc_materia_id;
            }
            return $info;
        }
        
    }
?>
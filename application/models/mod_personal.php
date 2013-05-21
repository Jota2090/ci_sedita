<?php
    if (! defined('BASEPATH'))
    exit ('No se puede ejecutar directamente este SCRIPT');

    class mod_personal extends CI_Model {
        
        function __construct(){
            parent::__construct();
        }
        
        function obtener_personal($idPersonal){            
            $this->db->from("personal");
            $this->db->where("per_id",$idPersonal);
            $rs = $this->db->get();
            return $rs;
        }
        
        function cargar_tipo_personal($cargo=""){
            $this->db->order_by("car_id");
            $rs=$this->db->get("cargo_personal");
            $info="";
            
            foreach ($rs->result() as $fila){
                if($cargo==="") $info .= "<option value='".$fila->car_id."'>".$fila->car_nombre."</option>";
                else{
                    if($cargo==$fila->car_id) $info .= "<option selected='selected' value='".$fila->car_id."'>".$fila->car_nombre."</option>";
                    else $info .= "<option value='".$fila->car_id."'>".$fila->car_nombre."</option>";
                }
            }
                
            return $info;
        }
        
        function guardar_personal(){
            $data = array(
                   'per_nombres' => trim($this->input->post("txtNombres")),
                   'per_apellidos' => trim($this->input->post("txtApellidos")),
                   'per_cedula' => trim($this->input->post("txtCedula")),
                   'per_domicilio' => trim($this->input->post("txtDomicilio")),
                   'per_telefono' => trim($this->input->post("txtTelefono")),
                   'per_celular' => trim($this->input->post("txtCell")),
                   'per_anio_lectivo_id' => $this->input->post("cmbAnioLectivo"),
                   'per_comentarios' => trim($this->input->post("txtComentarios")),
                   'per_cargo_id' => $this->input->post("cmbCargo"),
                   'per_estado' => 'a'
                );
            $idPer=$this->input->post("idPer");
            if($idPer!=""){
                $this->db->where('per_id', $idPer);
                $this->db->update('personal', $data);
            }
            else $this->db->insert('personal', $data); 
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
                
        function cd_guardar($parametros){
            $keys= array_keys($parametros);
            for($i=0; $i<count($keys); $i++):		$$keys[$i]= trim($parametros[$keys[$i]]);
            endfor;
            
            $general = new General();
            $cpId=$general->encontrarIdCursoParalelo($jor,$cur,$esp,$par);
            
            if($dir!="SI") $dir="--";
            
            $data = array(
                   'pc_personal_id' => $per,
                   'pc_curso_paralelo_id' => $cpId,
                   'pc_dirigente' => $dir ,
                   'pc_anio_lectivo_id' => $anl,
                   'pc_materia_id' => $mat);
                
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
        
        function eliminar_personal($id){
            $data=array("per_estado"=>"i");
            $this->db->where("per_id",$id);
            $this->db->update("personal",$data);
        }
        
        function reactivar_personal($id){
            $data=array("per_estado"=>"a");
            $this->db->where("per_id",$id);
            $this->db->update("personal",$data);
        }
        
    }
?>
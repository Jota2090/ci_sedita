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
        
        function guardar_personal($n,$ap,$ced,$dom,$tel,$cell,$anl,$com,$c){
            $data = array(
                   'per_nombres' => $n ,
                   'per_apellidos' => $ap ,
                   'per_cedula' => $ced ,
                   'per_domicilio' => $dom ,
                   'per_telefono' => $tel ,
                   'per_celular' => $cell ,
                   'per_anio_lectivo_id' => $anl ,
                   'per_comentarios' => $com,
                   'per_cargo_id' => $c,
                   'per_estado' => 'a'
                );
                
            $this->db->insert('personal', $data); 
        }
        
        function cd_guardar($c,$e,$par,$j,$m,$d,$per,$anl){
            $data = array(
                   'pc_personal_id' => $per ,
                   'pc_curso_id' => $c ,
                   'pc_especializacion_id' => $e ,
                   'pc_paralelo_id' => $par ,
                   'pc_jornada_id' => $j ,
                   'pc_dirigente' => $d ,
                   'pc_anio_lectivo_id' => $anl ,
                   'pc_materia_id' => $m 
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
        
        function cargar_materias($c,$e){
            $this->db->order_by("mat_nombre");
            $this->db->where("mc_curso_id",$c);
            $this->db->where("mc_especializacion_id",$e);
            $this->db->join("materia","mc_materia_id=mat_id");
            $rs=$this->db->get("materia_curso");
            
            $info="";
            foreach ($rs->result() as $fila){
                $info .= "<option value='".$fila->mat_id."'>".$fila->mat_nombre."</option>";
            }
            
            return $info;
        }
        
    }
?>
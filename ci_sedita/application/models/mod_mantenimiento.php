<?php
    if (! defined('BASEPATH'))
    exit ('No se puede ejecutar directamente este SCRIPT');

    class mod_mantenimiento extends CI_Model {
        
        function __construct(){
            parent::__construct();
        }
        
        function nombre_jornada($j){
            $this->db->order_by("jor_id");
            $this->db->select("jor_nombre, jor_id");
            $this->db->from("jornada");
            $this->db->where("jor_id", $j);
            
            $rs = $this->db->get();
            $info = array();
            
            foreach ($rs->result() as $fila){
                $info[$fila->jor_id] = $fila->jor_nombre;
            }
                
            return $info;
        }
        
        function nombre_nivel($n){
            $this->db->order_by("niv_id");
            $this->db->select("niv_nombre, niv_id");
            $this->db->from("nivel");
            
            if($n > 0){
                $this->db->where("niv_id", $n);
            }
            
            $rs = $this->db->get();
            $info = array();
            
            foreach ($rs->result() as $fila){
                $info[$fila->niv_id] = $fila->niv_nombre;
            }
                
            return $info;
        }
        
        function nombre_curso($c){
            $info = array();
            
            if($c != -3){
                $this->db->order_by("cur_id");
                $this->db->select("cur_nombre, cur_id");
                $this->db->from("curso");
                
                if($c > 0){
                    $this->db->where("cur_id", $c);
                }elseif($c == "-1"){
                    $this->db->join("nivel", "niv_id=cur_nivel_id");
                    $this->db->where("niv_nombre", "Basico");
                }elseif($c == "-2"){
                    $this->db->join("nivel", "niv_id=cur_nivel_id");
                    $this->db->where("niv_nombre", "Bachillerato");
                }
                
                $rs = $this->db->get();
                
                foreach ($rs->result() as $fila){
                    $info[$fila->cur_id] = $fila->cur_nombre;
                }
            }else{
                $info[1] = null;
            }
                
            return $info;
        }
        
        function nombre_especializacion($e){
            $info="";
            
            if( $e != -3){
                $this->db->order_by("esp_id");
                $this->db->select("esp_nombre, esp_id");
                $this->db->from("especializacion");
                
                if($e > 0){
                    $this->db->where("esp_id", $e);
                }
                
                $rs = $this->db->get();
                
                foreach ($rs->result() as $fila){
                    $info = $fila->esp_nombre;
                }
            }
                
            return $info;
        }
        
        function nombre_tipo_usuario($t){
            $info = array();
            
            $this->db->order_by("tip_id");
            $this->db->select("tip_nombre, tip_id");
            $this->db->from("tipo_usuario");
            
            if($t > 0){
                $this->db->where("tip_id", $t);
            }
            
            $rs = $this->db->get();
            
            foreach ($rs->result() as $fila){
                $info[$fila->tip_id] = $fila->tip_nombre;
            }
                
            return $info;
        }
        
        function cargar_tipo_usuario(){
            $info = array();
            
            $this->db->order_by("tip_id");
            $this->db->select("tip_nombre, tip_id");
            $this->db->from("tipo_usuario");
            
            $rs = $this->db->get();
            
            $info[0] = "<< Todos >>";
            foreach ($rs->result() as $fila){
                $info[$fila->tip_id] = $fila->tip_nombre;
            }
                
            return $info;
        }

    }
?>
<?php
    if (! defined('BASEPATH'))
    exit ('No se puede ejecutar directamente este SCRIPT');

    class mod_activos extends CI_Model {
        
        function __construct(){
            parent::__construct();
        }

        
        function cargar_tipo($tipo_id_objeto){
            $this->db->order_by("tipo_nombre");
            $this->db->where("tipo_id_objeto",$tipo_id_objeto); 
            $rs=$this->db->get("tipo_activos");
            
            return $rs;  
        }
        
        function cargar_estado($estado_id_objeto){
            
            $this->db->order_by("estado_nombre");
            $this->db->where("estado_id_objeto",$estado_id_objeto); 
            $rs=$this->db->get("estado_activos");
            return $rs;
        }
        
        
         function cargar_lugar($lugar_id_objeto){
            //$this->db->group_by("jor_nombre");
            $this->db->order_by("lugar_nombre");
            $this->db->where("lugar_id_objeto",$lugar_id_objeto); 
            $rs=$this->db->get("lugar_activos");
            
            return $rs;
        }
        
        function cargar_tipoConsulta($tipo_id_objeto){
            //$this->db->group_by("jor_nombre");
            $this->db->order_by("tipo_nombre");
            $this->db->where("tipo_id_objeto",$tipo_id_objeto); 
            $rs=$this->db->get("tipo_activos");
            return $rs;
            
        }
        
        
        function cargar_estadoConsulta($estado_id_objeto){
            //$this->db->group_by("jor_nombre");
            $this->db->order_by("estado_nombre");
            $this->db->where("estado_id_objeto",$estado_id_objeto); 
            $rs=$this->db->get("estado_activos");
            return $rs;
            
        }

        
        function insertar_tipo($tipo,$tipo_id_objeto){
            $data = array(
                            "tipo_nombre"=>$tipo,
                            "tipo_id_objeto"=>$tipo_id_objeto
            );
            
            $this->db->insert("tipo_activos",$data);
        }
        
        function insertar_estado($estado,$estado_id_objeto){
            $data = array(
                            "estado_nombre"=>$estado,
                            "estado_id_objeto"=>$estado_id_objeto
            );
            
            $this->db->insert("estado_activos",$data);
        }
        
        function insertar_lugar($lugar,$lugar_id_objeto){
            $data = array(
                            "lugar_nombre"=>$lugar,
                            "lugar_id_objeto"=>$lugar_id_objeto
            );
            
            $this->db->insert("lugar_activos",$data);
        }

        function numBusqTipoRepet($tipo,$tipo_id_objeto)
        {
            $this->db->where("tipo_nombre",$tipo); 
            $this->db->where("tipo_id_objeto",$tipo_id_objeto); 
            $this->db->from("tipo_activos");
            
            $numTipoRepet=$this->db->count_all_results();
            return $numTipoRepet;
        }
        
        function numBusqEstadoRepet($estado,$estado_id_objeto)
        {
            $this->db->where("estado_nombre",$estado); 
            $this->db->where("estado_id_objeto",$estado_id_objeto); 
            $this->db->from("estado_activos");
            
            $numEstadoRepet=$this->db->count_all_results();
            return $numEstadoRepet;
        }
        
        function numBusqLugarRepet($lugar,$lugar_id_objeto)
        {
            $this->db->where("lugar_nombre",$lugar); 
            $this->db->where("lugar_id_objeto",$lugar_id_objeto); 
            $this->db->from("lugar_activos");
            
            $numLugarRepet=$this->db->count_all_results();
            return $numLugarRepet;
        }


     }   
     
     
?>
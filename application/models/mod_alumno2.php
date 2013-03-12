<?php
    if (! defined('BASEPATH'))
    exit ('No se puede ejecutar directamente este SCRIPT');

    class mod_alumno2 extends CI_Model {
        
        function __construct(){
            parent::__construct();
        }
        
        function det_alu($alu){
            $this->db->where("alu_id",$alu);
            $this->db->join("representante","alu_representante_id=rep_id");
            $rs=$this->db->get("alumno");
              
            return $rs;
        }
    }
?>
<?php
    if (! defined('BASEPATH'))
    exit ('No se puede ejecutar directamente este SCRIPT');

    class mod_curso extends CI_Model {
        
        function __construct(){
            parent::__construct();
        }
        
        function insertar_paralelo(){
            $data = array("par_nombre"=>$this->input->post("paralelo"));
            
            $this->db->insert("paralelo",$data);
        }
    }
?>
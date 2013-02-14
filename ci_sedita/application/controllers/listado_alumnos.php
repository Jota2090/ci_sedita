<?php
    if (! defined('BASEPATH'))
    exit ('No se puede ejecutar directamente este SCRIPT');

    class listado_alumnos extends CI_Controller {
        
        function __construct(){
            parent::__construct();
        }
        
        function _remap($metodo){
            if($metodo=="pdf"){ 
                $this->imprimir_pdf();
            }
            else
           $this->_listar();
        }
               
        function _listar(){
            $this->load->model("mod_alumno", "objA");
            $data=$this->objA->listado_alumnos();
            
                             
                $this->load->library('table');
                
                $tmp=array("table_open" => "<table border ='1' class='display' id='ejemplolista'>");
                $this->table->set_template($tmp);
                
                $info["tabla"]= $this->table->generate($data);
                $this->load->view("view_listado_alumnos",$info);

        }
        
        function imprimir_pdf(){
        }
        
    }
?>

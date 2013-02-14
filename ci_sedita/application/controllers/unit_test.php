<?php
    if (! defined('BASEPATH'))
    exit ('No se puede ejecutar directamente este SCRIPT');

    class Unit_Test extends CI_Controller {
        
        function __construct(){
            parent::__construct();
            $this->load->library('unit_test');
            $this->load->model("mod_alumno","alumno");
        }
        
        function _remap($m){
            if(!$this->clslogin->check())
            {
				redirect(site_url("login"));
			}
            elseif($m=="prueba1"){
                $esperado=$this->alumno->cargar_niveles("c");
                echo $this->unit->run($this->alumno->cargar_niveles(1),$esperado, 'Prueba Inicial');
                echo $this->unit->report();
                echo $this->unit->result();                                
            }
        }
   }
?>
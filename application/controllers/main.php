<?php 
    if ( ! defined('BASEPATH')) exit('No direct script access allowed');

    class Main extends CI_Controller {
        
        function __construct(){
    		parent::__construct();
    	}
     
        function menu(){
           if(!$this->clslogin->check()){redirect(site_url("login/login2"));}
	
           $data["link"]=base_url()."main/vista_main";
           $this->load->view("view_plantilla",$data); 
        }
        
        function vista_main(){
            if(!$this->clslogin->check()){redirect(site_url("login/login2"));}
            
            $dias = array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sábado");
            $meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
            $data["fecha"] = htmlentities($dias[date('w')]) .", " .date('d') ." de " .$meses[date('n')-1] ." del " .date('Y');
            $data["usuario"] = "Administrador";

            $this->load->view('view_administrador', $data);
        }
    }
?>
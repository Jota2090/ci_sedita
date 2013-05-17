<?php
    if ( ! defined('BASEPATH')) exit('No direct script access allowed');
    
    class login extends CI_Controller {
    
    	function __construct(){
    		parent::__construct();
            $this->load->library("form_validation");                        
    	}
        
        function vista_login($data){
            $this->load->view("view_login", $data);
        }
        
        function validar(){
            $u = $this->input->post("txtUser");
            $c = $this->input->post("txtClave");

            if($this->clslogin->login($u, $c)){
                redirect(site_url("main/menu"));
            }
            else{
                $data["error"]="<div class='alert alert-error' style='text-align:center; 
                                                                        margin-left:470px;
                                                                        margin-right:130px' >
                                    Usuario o Contrase&ntilde;a incorrectos
                                </div>";
                $this->vista_login($data);
            }
        }
        
        function cerrar(){
            $this->clslogin->logout();
            redirect(site_url("main/menu"));
        }
        
        function login2(){
            $data["error"]="";
            $data["sin_menu"]="sin_menu";
            $this->vista_login($data);
        }
        
     }
?>
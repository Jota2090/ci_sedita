<?php
    if ( ! defined('BASEPATH')) exit('No direct script access allowed');
    
    class login extends CI_Controller {
    
    	function __construct(){
    		parent::__construct();
            $this->load->library("form_validation");                        
    	}
        
        function _remap($metodo){
            if($metodo=="validar"){
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
                    $this->_login($data);
                }
            }
            elseif(!$this->clslogin->check()){
                $data["error"]="";
                $this->_login($data);
            }
            elseif($metodo="cerrar"){
                $this->clslogin->logout();
                redirect(site_url("main/menu"));
            }
            else{
                redirect(site_url("main/menu"));
            }
        }
        
        function _login($data){
            $this->load->view("view_login", $data);
        }
        
     }
?>
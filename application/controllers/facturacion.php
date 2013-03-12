<?php
    if (! defined('BASEPATH'))
    exit ('No se puede ejecutar directamente este SCRIPT');

    /**
    * alumno
    *
    * @package CodeIgniter
    * @subpackage Controllers
    * @author Sedita
    */    
    class facturacion extends Alumno {
        
        function __construct(){
            parent::__construct();
            $this->load->library('grocery_CRUD');
            $this->load->model('mod_facturacion','factura');
            $this->load->helper("country_helper");
            $this->load->helper("form");
        }
        
        function _remap($m){
            if(!$this->clslogin->check()){
		redirect(site_url("login"));
            }
            else{
                if($m=="cobros_pagos"){
                    $this->cobrar_pagar();
                }
                elseif($m=="cat_alumno"){
                    $this->categoria_alumno();
                }
                elseif($m=="cobrar_conceptos"){
                    $this->cobrar_conceptos();
                }
                elseif($m=="eliminar_concepto"){
                    $this->eliminar_concepto();
                }
                elseif($m=="est_cuenta"){
                    $this->estado_cuenta();
                }
                else
                {
                    $this->cobros();
                }
            }
        }
     
        
        function cobros(){    
            $data["jornada"]= $this->cargar_jornadas();
            $data["anioLect"]=$this->cargar_aniosLectivos();
            $data["anlId"]=$this->cargar_anlActual();
            $data["menu"]=$this->load->view("view_menu_administrador");
            $this->load->view("facturacion/view_cobros",$data);       
        }
        
        
        function cobrar_pagar(){
            $data=array("t1"=>0,"t2"=>0,"t3"=>0,"t4"=>0,"t5"=>0,"t6"=>0,"t7"=>0,
                        "t8"=>0,"t9"=>0,"t10"=>0,"t11"=>0,"t12"=>0,"t13"=>0);

            $data["alu"]=$this->input->post('alu');
            $ind=$this->input->post('ind');

            $res=$this->alumno->obtener_alumno($data["alu"]);
            $cat="";
            foreach($res->result() as $catId){
                $cat=$catId->cat_id;
            }

            $i=1;
            $valores=$this->factura->listar_valores($cat);
            foreach($valores->result() as $val){
                $data["val".$i]=$val->val_cantidad;
                $i++;
            }

            $rs=$this->factura->listar_pagos($data["alu"]);
            foreach($rs->result() as $conceptos)
                $data["t".$conceptos->pag_conceptos_id]=1;

            if($ind==1)
                $this->load->view("facturacion/view_por_cobrar", $data);
            else
                $this->load->view("facturacion/view_pagado", $data);
        }
        
        
        function categoria_alumno(){
            $alu=$this->input->post("alu");
            $rs=$this->alumno->obtener_alumno($alu);
            $cat="";
            foreach($rs->result() as $al){
                $cat=$al->cat_nombre;
            }
            echo $cat;
        }
        
        
        function cobrar_conceptos(){
            $alu=$this->input->post("alu");
            $this->factura->cobrar_conceptos($alu);
        }
        
        
        function eliminar_concepto(){
            $alu=$this->input->post("alu");
            $this->factura->eliminar_concepto($alu);
        }
        
        
        function estado_cuenta(){
            $pagos=array("t1"=>0,"t2"=>0,"t3"=>0,"t4"=>0,"t5"=>0,"t6"=>0,"t7"=>0,
                        "t8"=>0,"t9"=>0,"t10"=>0,"t11"=>0,"t12"=>0,"t13"=>0);
            
            $alu=$this->input->post("alu");
            
            $rs=$this->alumno->obtener_alumno($alu);
            foreach($rs->result() as $al){
                $alumno = $al->alu_apellidos." ".$al->alu_nombres;
                $matricula = $al->alu_matricula;
                $ano_lectivo = $this->get_anio_lectivo($al->alu_ano_lectivo_id);
                $curso = $this->get_nom_curso($al->cur_id);
                $jornada = $this->get_nom_jornada($al->jor_id);
                
                $i=1; $valores=array();
                $valor=$this->factura->listar_valores($al->alu_categoria_alumno_id);
                foreach($valor->result() as $val){
                    $valores["val".$i]=$val->val_cantidad;
                    $i++;
                }
                
                $pagos=array();
                $resp=$this->factura->listar_pagos($alu);
                foreach($resp->result() as $conceptos)
                    $pagos["t".$conceptos->pag_conceptos_id]=1;
            }
            
            $this->load->library('export_pdf');                 
            $pdf = new export_pdf();
            $pdf->exportToPDF_EstadoCuenta($alumno,$matricula,$ano_lectivo,$curso,$jornada,$valores,$pagos);
        }
    }
?>
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
    class facturacion extends CI_Controller {
        
        function __construct(){
            parent::__construct();
            $this->load->library('grocery_CRUD');
            $this->load->model('mod_facturacion','factura');
            $this->load->model('mod_alumno','alumno');
            $this->load->helper("country_helper");
            $this->load->helper("form");
        }
        
        /*function _remap($m){
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
        }*/
     
        
        function cobros(){
            $general = new General();
            $data["jornada"]= $general->cargar_jornadas();
            $data["anioLect"]=$general->cargar_aniosLectivos();
            $data["anlId"]=$general->cargar_anlActual();
            $this->load->view("facturacion/view_cobros",$data);       
        }
        
        
        function cobrar_pagar(){
            $data=array("t1"=>0,"t2"=>0,"t3"=>0,"t4"=>0,"t5"=>0,"t6"=>0,"t7"=>0,
                        "t8"=>0,"t9"=>0,"t10"=>0,"t11"=>0,"t12"=>0,"t13"=>0);

            $data["alu"]=$this->uri->segment(3);

            $res=$this->alumno->obtener_alumno($data["alu"])->row();
            $cat=$res->cat_id;
            $data["categoria"]=$res->cat_nombre;
            $data["alumno"]=$res->alu_apellidos." ".$res->alu_nombres;
            $i=1;
            $valores=$this->factura->listar_valores($cat);
            foreach($valores->result() as $val){
                $data["val".$i]=$val->val_cantidad;
                $i++;
            }

            $rs=$this->factura->listar_pagos($data["alu"]);
            foreach($rs->result() as $conceptos)
                $data["t".$conceptos->pag_conceptos_id]=1;
            
            $this->load->view("facturacion/view_resultado_cobros_pagos", $data);
        }
        
        function cobrar_conceptos(){
            $case=$this->input->post("case");
            $alu=$this->input->post("alumno");
            if($case[0]!=""){
                $this->factura->cobrar_conceptos($case,$alu);
                redirect("facturacion/cobrar_pagar/".$alu);
            }
            else
                echo "<script>alert('No ha seleccionado ningun concepto de cobro'); window.history.back();</script>";
        }
        
        
        function eliminar_concepto(){
            $alu=$this->input->post("alumno");
            $valor=$this->input->post("pago");
            $this->factura->eliminar_concepto($alu,$valor);
            redirect("facturacion/cobrar_pagar/".$alu);
        }
        
        
        function estado_cuenta(){
            $general = new General();
            $pagos=array("t1"=>0,"t2"=>0,"t3"=>0,"t4"=>0,"t5"=>0,"t6"=>0,"t7"=>0,
                        "t8"=>0,"t9"=>0,"t10"=>0,"t11"=>0,"t12"=>0,"t13"=>0);
            
            $alu=$this->input->post("alu");
            
            $rs=$this->alumno->obtener_alumno($alu);
            foreach($rs->result() as $al){
                $alumno = $al->alu_apellidos." ".$al->alu_nombres;
                $matricula = $al->alu_matricula;
                $ano_lectivo = $general->get_anio_lectivo($al->alu_ano_lectivo_id);
                $curso = $general->get_nom_curso($al->cur_id);
                $jornada = $general->get_nom_jornada($al->jor_id);
                
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
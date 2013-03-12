<?php
    if (! defined('BASEPATH'))
    exit ('No se puede ejecutar directamente este SCRIPT');

    class mod_facturacion extends CI_Model {
        
        function __construct(){
            parent::__construct();
        }
        
        function listar_pagos($alu){
            $this->db->where("pag_alumno_id",$alu);
            $this->db->order_by("pag_conceptos_id");
            $rs=$this->db->get("pagos");

            return $rs;
        }
        
        function listar_valores($cat){
            $this->db->where("val_categoria_alumno_id",$cat);
            $this->db->order_by("val_tipo_conceptos_id");
            $rs=$this->db->get("valores");
            
            return $rs;
        }
        
        function cobrar_conceptos($alu){
            $data =  array("0"=>$this->input->post("chk1"),"1"=>$this->input->post("chk2"),
                            "2"=>$this->input->post("chk3"),"3"=>$this->input->post("chk4"),
                            "4"=>$this->input->post("chk5"),"5"=>$this->input->post("chk6"),
                            "6"=>$this->input->post("chk7"),"7"=>$this->input->post("chk8"),
                            "8"=>$this->input->post("chk9"),"9"=>$this->input->post("chk10"),
                            "10"=>$this->input->post("chk11"),"11"=>$this->input->post("chk12"),
                            "12"=>$this->input->post("chk13")
                           );
            
            for($i=0;$i<13;$i++){
                if($data[$i]!=null && $data[$i]!="" && $data[$i]>0){
                    $campos = array("pag_conceptos_id"=>$data[$i], "pag_alumno_id"=>$alu);             
                    $this->db->insert("pagos",$campos);
                }
            }
        }
        
        function eliminar_concepto($alu){
            $data = array("pag_conceptos_id"=>$this->input->post("chk"),"pag_alumno_id"=>$alu);
            $this->db->delete('pagos', $data); 
        }
    }
?>

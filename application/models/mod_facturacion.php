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
        
        function cobrar_conceptos($case,$alu){
            for($i=0;$i<count($case);$i++){
                $campos = array("pag_conceptos_id"=>$case[$i], "pag_alumno_id"=>$alu);             
                $this->db->insert("pagos",$campos);
            }
        }
        
        function eliminar_concepto($alu,$pago){
            $data = array("pag_conceptos_id"=>$pago,"pag_alumno_id"=>$alu);
            $this->db->delete('pagos', $data); 
        }
    }
?>

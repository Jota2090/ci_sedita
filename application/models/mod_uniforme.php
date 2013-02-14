<?php
    if (! defined('BASEPATH'))
    exit ('No se puede ejecutar directamente este SCRIPT');


    /**
    * mod_uniforme
    *
    * @package CodeIgniter
    * @subpackage Models
    * @author Sedita
    */
    class mod_uniforme extends CI_Model {
        
        function __construct(){
            parent::__construct();
             $this->load->model("mod_activos","activos");
        }    
        
        
        
        /**
            * Initialize registrarUniforme
            * Esta función registra un uniforme
            * @access public
            * @param string $codInv: código del uniforme
            * @param integer $idTipo: id del tipo del uniforme
            * @param integer $idEstado: id del estado del uniforme
            * @param integer $idTalla: id de la talla del uniforme
            * @param string $comentarios: comentarios realizados de un uniforme
            * @return array
        */
        function registrarUniforme($codInv,$idTipo,$idEstado,$idTalla,$comentarios)
        {
            $fechaIngreso = date("Y-m-d");
            $data = array(
                            "uniforme_codInv"=>$codInv,
                            "uniforme_tipo"=>$idTipo,
                            "uniforme_estado"=>$idEstado,
                            "uniforme_talla"=>$idTalla,
                            "uniforme_comentarios"=>$comentarios,
                            "uniforme_FechaIngreso"=>$fechaIngreso,
                            "uniforme_FechaModificacion"=>$fechaIngreso
                            
                            );
            $this->db->insert("uniforme",$data);
        }
        
        
         /**
            * Initialize ultimoUniforme
            * Esta función obtiene el último registro realizado en la tabla uniforme
            * @access public
            * @return array
        */
        function ultimoUniforme()
        {
            $this->db->select_max("uniforme_id");
            $rs = $this->db->get("uniforme");
            
            return $rs;
        }
        
        
         /**
            * Initialize busqUniformeId
            * Obtiene el uniforme de acuerdo al id del uniforme enviado como parámetro
            * @access public
            * @param integer $idUniforme: id del uniforme
            * @return array
        */
        function busqUniformeId($idUniforme)
        {
             $this->db->where("uniforme_id",$idUniforme);
             $this->db->from("uniforme");
             $rs= $this->db->get();
             
             return $rs;
        }
        
        
        /**
            * Initialize update_before
            * Esta función permite actualizar el tipo, estado, lugar
            * y fecha de modificación de un uniforme
            * @access public
            * @param string $primary_key: id del uniforme
            * @param integer $tipo: id del tipo del uniforme
            * @param integer $estado: id del estado del uniforme
            * @param integer $talla: id de la talla del uniforme
            * @return void
        */
        function update_before($primary_key,$tipo,$estado,$talla){
            
             $fechaModif = date("Y-m-d");
             
             $data = array(
                            "uniforme_tipo"=>$tipo,
                            "uniforme_estado"=>$estado,
                            "uniforme_talla"=>$talla,
                            "uniforme_FechaModificacion"=>$fechaModif
                            );
                            
            $this->db->where('uniforme_id', $primary_key);
            $this->db->update('uniforme', $data);   
        }
        
        
         /**
            * Initialize numBusqUniformeRepet
            * Esta función retorna el número de coincidencias entre el código del uniforme
            * que se quiere ingresar y los códigos de los uniformes
            * qye ya están registrados
            * @access public
            * @param string $codUniforme: código de uniforme
            * @return integer
        */
        function numBusqUniformeRepet($codUniforme)
        {
            $this->db->where("uniforme_codInv",$codUniforme);  
            $this->db->from("uniforme");
            
            $numUniformeRepet=$this->db->count_all_results();
            return $numUniformeRepet;
        }
        
        
        
        /**
            * Initialize cargar_talla
            * Esta función obtiene la consulta de todas las tallas que han sido ingresadas
            * @access public
            * @return array
        */
        function cargar_talla(){
            $this->db->order_by("talla_nombre");
            $rs=$this->db->get("talla_uniforme");
            
            return $rs;  
        }
        
             
        /**
            * Initialize insertar_talla
            * Esta función registra una nueva talla de uniforme
            * @access public
            * @param string $talla: nombre de talla de uniforme
            * @return array
        */
        function insertar_talla($talla){
            $data = array(
                            "talla_nombre"=>$talla,
            );
            
            $this->db->insert("talla_uniforme",$data);
        }
        
            
         /**
            * Initialize numBusqTallaRepet
            * Esta función retorna el número de coincidencias entre la talla del uniforme
            * que se quiere ingresar y las tallas de los uniformes
            * que ya están registrados
            * @access public
            * @param string $talla: código de uniforme
            * @return integer
        */
        function numBusqTallaRepet($talla)
        {
            $this->db->where("talla_nombre",$talla);  
            $this->db->from("talla_uniforme");
            
            $numTallaRepet=$this->db->count_all_results();
            return $numTallaRepet;
        }
        
        
    }
?>
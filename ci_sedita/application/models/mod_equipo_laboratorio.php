<?php
    if (! defined('BASEPATH'))
    exit ('No se puede ejecutar directamente este SCRIPT');

    /**
    * mod_equipo_laboratorio
    *
    * @package CodeIgniter
    * @subpackage Models
    * @author Sedita
    */

    class mod_equipo_laboratorio extends CI_Model {
        
        function __construct(){
            parent::__construct();
             $this->load->model("mod_activos","activos");
        }    
        
        
        
        /**
            * Initialize registrarEquiLab
            * Esta función registra un equipo de laboratorio
            * @access public
            * @param string $codInv: código del equipo de laboratorio
            * @param integer $idTipo: id del tipo del equipo de laboratorio
            * @param integer $idEstado: id del estado del equipo de laboratorio
            * @param integer $idLugar: id del lugar del equipo de laboratorio
            * @param string $comentarios: comentarios realizados de un equipo de laboratorio
            * @return array
        */
        function registrarEquiLab($codInv,$idTipo,$idEstado,$idLugar,$comentarios)
        {
            $fechaIngreso = date("Y-m-d");
            $data = array(
                            "equilab_codInv"=>$codInv,
                            "equilab_tipo"=>$idTipo,
                            "equilab_estado"=>$idEstado,
                            "equilab_lugar"=>$idLugar,
                            "equilab_comentarios"=>$comentarios,
                            "equilab_FechaIngreso"=>$fechaIngreso,
                            "equilab_FechaModificacion"=>$fechaIngreso
                            
                            );
            $this->db->insert("equipo_laboratorio",$data);
        }
        
        
         /**
            * Initialize ultimoEquilab
            * Esta función obtiene el último registro realizado en la tabla equipo_laboratorio
            * @access public
            * @return array
        */
        function ultimoEquilab()
        {
            $this->db->select_max("equilab_id");
            $rs = $this->db->get("equipo_laboratorio");
            
            return $rs;
        }
        
        
         /**
            * Initialize busqEquipoId
            * Obtiene el equipo de laboratorio de acuerdo al id del equipo enviado como parámetro
            * @access public
            * @param integer $idEquiLab: id del equipo de laboratorio
            * @return array
        */
        function busqEquipoId($idEquiLab)
        {
             $this->db->where("equilab_id",$idEquiLab);
             $this->db->from("equipo_laboratorio");
             $rs= $this->db->get();
             
             return $rs;
        }
        
        
         /**
            * Initialize update_before
            * Esta función permite actualizar el tipo, estado, lugar
            * y fecha de modificación de un equipo de laboratorio
            * @access public
            * @param string $primary_key: id del equipo de labratorio
            * @param integer $tipo: id del tipo del equipo de laboratorio
            * @param integer $estado: id del estado del equipo de laboratorio
            * @param integer $lugar: id del lugar del equipo de laboratorio
            * @return void
        */
        function update_before($primary_key,$tipo,$estado,$lugar){
            
             $fechaModif = date("Y-m-d");
             
             $data = array(
                            "equilab_tipo"=>$tipo,
                            "equilab_estado"=>$estado,
                            "equilab_lugar"=>$lugar,
                            "equilab_FechaModificacion"=>$fechaModif
                            );
                            
            $this->db->where('equilab_id', $primary_key);
            $this->db->update('equipo_laboratorio', $data);   
        }
        
        
        
         /**
            * Initialize numBusqEquipoRepet
            * Esta función retorna el número de coincidencias entre el código del equipo
            * de laboratorio que se quiere ingresar y los códigos de los equipos de laboratorios
            * qye ya están registrados
            * @access public
            * @param string $codEquipo: código de equipo d elaboratorio
            * @return integer
        */
        function numBusqEquipoRepet($codEquipo)
        {
            $this->db->where("equilab_codInv",$codEquipo);  
            $this->db->from("equipo_laboratorio");
            
            $numEquipoRepet=$this->db->count_all_results();
            return $numEquipoRepet;
        }
        
    }
?>
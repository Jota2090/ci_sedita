<?php
    if (! defined('BASEPATH'))
    exit ('No se puede ejecutar directamente este SCRIPT');

    /**
    * mod_banda_guerra
    *
    * @package CodeIgniter
    * @subpackage Models
    * @author Sedita
    */
    class mod_banda_guerra extends CI_Model {
        
        function __construct(){
            parent::__construct();
             $this->load->model("mod_activos","activos");
        }
        
        /**
            * Initialize ultimoInstrum
            * Esta funci�n obtiene el �ltimo registro realizado en la tabla banda_guerra
            * @access public
            * @return array
        */
        function ultimoInstrum()
        {
            $this->db->select_max("banda_id");
            $rs = $this->db->get("banda_guerra");
            
            return $rs;
        }
        
         
         /**
            * Initialize busqInstrumId
            * Obtiene el instrumento de la banda de guerra de acuerdo al id del instrumento, enviado como par�metro
            * @access public
            * @param integer $idInstrum: id del instrumento de la banda de guerra
            * @return array
        */
        function busqInstrumId($idInstrum)
        {
             $this->db->where("banda_id",$idInstrum);
             $this->db->from("banda_guerra");
             $rs= $this->db->get();
             
             return $rs;
        }
        
        
        /**
            * Initialize registrarInstrum
            * Esta funci�n registra un instrumento de la banda de guerra
            * @access public
            * @param string $codInv: c�digo del instrumento de la banda de guerra
            * @param integer $idTipo: id del tipo del instrumento de la banda de guerra
            * @param integer $idEstado: id del estado del instrumento de la banda de guerra
            * @param integer $idLugar: id del lugar del instrumento de la banda de guerra
            * @param string $comentarios: comentarios realizados de un instrumento de la banda de guerra
            * @return void
        */
        
        function registrarInstrum($codInv,$idTipo,$idEstado,$idLugar,$comentarios)
        {
      
            $fechaIngreso = date("Y-m-d");
            $data = array(
                            "banda_codInv"=>$codInv,
                            "banda_tipo"=>$idTipo,
                            "banda_estado"=>$idEstado,
                            "banda_lugar"=>$idLugar,
                            "banda_comentarios"=>$comentarios,
                            "banda_FechaIngreso"=>$fechaIngreso,
                            "banda_FechaModificacion"=>$fechaIngreso
                            
                            );
            $this->db->insert("banda_guerra",$data);
        }
        
        
        /**
            * Initialize update_before
            * Esta funci�n permite actualizar el tipo, estado, lugar
            * y fecha de modificaci�n de un instrumento de la banda de guerra
            * @access public
            * @param string $primary_key: id del instrumento de la banda de guerra
            * @param integer $tipo: id del tipo del instrumento de la banda de guerra
            * @param integer $estado: id del estado del instrumento de la banda de guerra
            * @param integer $lugar: id del lugar del instrumento de la banda de guerra
            * @return void
        */
        function update_before($primary_key,$tipo,$estado,$lugar){
            
             $fechaModif = date("Y-m-d");
             
             $data = array(
                            "banda_tipo"=>$tipo,
                            "banda_estado"=>$estado,
                            "banda_lugar"=>$lugar,
                            "banda_FechaModificacion"=>$fechaModif
                            );
                            
            $this->db->where('banda_id', $primary_key);
            $this->db->update('banda_guerra', $data);   
        }
        
        
        
         /**
            * Initialize numBusqInstrumRepet
            * Esta funci�n retorna el n�mero de coincidencias entre el c�digo del instrumento de la banda de guerra
            * que se quiere ingresar y los c�digos de los instrumentos de la banda de guerra
            * que ya est�n registrados
            * @access public
            * @param string $codInstrum: c�digo de instrumento de la banda de guerra
            * @return integer
        */
        function numBusqInstrumRepet($codInstrum)
        {
            $this->db->where("banda_codInv",$codInstrum);  
            $this->db->from("banda_guerra");
            
            $numInstrumRepet=$this->db->count_all_results();
            return $numInstrumRepet;
        }
        
        
    }
?>
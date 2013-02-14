<?php
    if (! defined('BASEPATH'))
    exit ('No se puede ejecutar directamente este SCRIPT');

    /**
    * banda_guerra
    *
    * @package CodeIgniter
    * @subpackage Controllers
    * @author Sedita
    */
    class banda_guerra extends activos {
        
        function __construct(){
            parent::__construct();
            
            $this->load->model("mod_banda_guerra","banda_guerra");
             
            
        }
        
        function _remap($m){
            if(!$this->clslogin->check())
            {
				redirect(site_url("login"));
			}
            else{
                
                    if($m == "guardar"){
                        $this->guardarInstrumento();
                    }
            
                     elseif($m == "consultar_instrumentos"){
                            $categoria = $this->input->post("categoria");
                            $indInicio= $this->input->post("indInicio");
                            $idOpcion = $this->input->post("idOpcion");
                            $strCod = $this->input->post("strCod");
                            $this->consultarInstrumCateg($categoria,$idOpcion,$strCod,$indInicio); 
                     }
                     
                     
                     elseif($m=="actualizar_UltimoCod")
                     {
                        echo $this->ultimoCodInvInstrum(); 
                     }
                     
                     else{
            
                        $this->nuevoInstrum(); 
                    }
                
            }
            
        }
        
            /**
                * Initialize ultimoCodInvInstrum
                * Esta función retorna el código del último instrumento de la banda de guerra que fue ingresado
                * @access public
                * @return string
             */
            function ultimoCodInvInstrum()
            { 
                $strIdCodigo="";
                $rs=$this->banda_guerra->ultimoInstrum();
                 foreach($rs->result() as $row)
                 {
                    $strIdCodigo .="".$row->banda_id."";
                 }
                $idInstrum=(int) $strIdCodigo;
                
                $strUltimoCodigo="";
                $rs1=$this->banda_guerra->busqInstrumId($idInstrum);
                foreach($rs1->result() as $row)
                {
                    $strUltimoCodigo .="".$row->banda_codInv."";
                }
                 return $strUltimoCodigo;
                
            } 
            
            
             /**
            * Initialize nuevoInstrum
            * Esta función permite cargar la vista de registro de un instrumento de la banda de guerra que el usuario podrá observar
            * @access public
            * @return void
            */ 
            function nuevoInstrum(){ 
                $data["ultimoCodigo"]= $this->ultimoCodInvInstrum();    
                $data["tipo_activos"]= $this->obtenerArrayTipo(2);
                $data["estado_activos"]= $this->obtenerArrayEstado(2);  
                $data["lugar_activos"]= $this->obtenerArrayLugar(2);  
                 
                $this->load->view("inventario/bandaGuerra/view_registro",$data); 
            }
            
            
             /**
            * Initialize guardarInstrumento
            * Esta función guarda un instrumento de la banda de guerra, devolviendo 1 si es que el instrumento de la banda de guerra
            * ha sido guardado con éxito, caso contrario devolverá 0 si el instrumento de la banda de guerra
            * ya se encuentra registrado.
            * @access public
            * @return integer
            */ 
            function guardarInstrumento(){
                $codInv=$this->input->post("txtCodInv");
                $numInstrumRepet=$this->banda_guerra->numBusqInstrumRepet($codInv);
                if($numInstrumRepet==0)
                {
                    $idTipo=$this->input->post("cmbTipo");
                    $idEstado=$this->input->post("cmbEstado");
                    $idLugar=$this->input->post("cmbLugar");
                    $comentarios=$this->input->post("txtComentariosInstrum");     
                    $this->banda_guerra->registrarInstrum($codInv,$idTipo,$idEstado,$idLugar,$comentarios);
                    echo 1;
                }
                else
                {
                    echo 0;
                }
 
            }
        
        
            /**
            * Initialize consultarInstrumCateg
            * A través de esta función se podrá obtener los resultados de las respectivas consultas
            * por las distintas categorías: Todos, Tipo, Estado y nombre de un instrumento de la banda de guerra
            * @access public
            * @param string $categoria: nombre de la categoría que ha sido elegida para realizar la búsqueda
            * @param integer $idOpcion: id del estado o tipo del instrumento de la banda de guerra
            * @param string $strCod: cadena para la realizar la búsqueda por nombre(código de inventario) del instrumento de la banda de guerra
            * @param integer $indInicio: entero con dos valores: 0 si la página de consultar instrumento de la banda de guerras ha sido cargada
            *                           y 1 si no se quiere recargar toda la página, sino sólo obtener la tabla con los resultados 
            *                           de la consulta
            * @return void
            */ 
            function consultarInstrumCateg($categoria,$idOpcion,$strCod,$indInicio){
                
        
             $this->load->helper("form");
            
            $crud = new grocery_CRUD();
            $crud->set_subject('Banda de Guerra');  
            $crud->set_theme('datatables');
              
            $crud->set_table('banda_guerra');
            $crud->set_model('mod_banda_guerra_join'); 
                        
            $crud->columns('banda_codInv','tipo_nombre','estado_nombre','lugar_nombre','banda_comentarios','banda_FechaIngreso','banda_FechaModificacion');             
            
            $crud->display_as('banda_codInv','C&oacute;digo de inventario');
            $crud->set_rules('banda_codInv','C&oacute;digo de inventario','required|callback_alpha_numeric_guion');
            
            $crud->display_as('tipo_nombre','Tipo');
            
            $crud->display_as('banda_tipo','Tipo');          
            $crud->callback_edit_field('banda_tipo',array($this,'edit_field_callback_tipos'));
            
            $crud->display_as('estado_nombre','Estado');
            
            $crud->display_as('banda_estado','Estado');
            $crud->callback_edit_field('banda_estado',array($this,'edit_field_callback_estados'));
               
            $crud->display_as('lugar_nombre','Lugar donde se encuentra');
            
            $crud->display_as('banda_lugar','Lugar donde se encuentra');
            $crud->callback_edit_field('banda_lugar',array($this,'edit_field_callback_lugar'));
            
            $crud->display_as('banda_comentarios','Comentario'); 
            $crud->change_field_type('banda_comentarios', 'string');
             
            $crud->display_as('banda_FechaIngreso','Fecha de ingreso');
            
            
            $crud->display_as('banda_FechaModificacion','Fecha de &uacute;ltima modificaci&oacute;n');
            $crud->callback_edit_field('banda_FechaModificacion',array($this,'edit_field_callback_fechaModif'));
            $crud->unset_add();
            $crud->unset_delete();
            $crud->callback_before_update(array($this,'update_before_callback'));
            
                 if($categoria=="Tipo")
                 {
                    $crud->where('banda_tipo',$idOpcion);
                 }
                   elseif($categoria=="Estado")
                 {
                    $crud->where('banda_estado',$idOpcion);
                 }
                 elseif($categoria=="Codigo")
                 {
                    $crud->where('banda_codInv',$strCod);
                 }
                 else
                 {
                    
                 }
            
            $output = $crud->render();    
           
                if($indInicio == 0)
                {
                    $output->options=$this->cargar_opcionesCateg(); 
                
                    $this->load->view('inventario/bandaGuerra/view_consulta',$output);
                  
                }else
                
                {
                    
                    $this->load->view('view_cruds',$output);
                }
  
            }
           
           
             /**
            * Initialize edit_field_callback_tipos
            * Callback que será ejecutado al editar un instrumento de la banda de guerra
            * para modificar el formulario mostrado por grocery crud en la opción 
            * Tipo del instrumento de la banda de guerra
            * @access public
            * @param string $value: nombre del tipo del instrumento de la banda de guerra
            * @return string
            */ 
            function edit_field_callback_tipos($value, $primary_key)
            { 
                $stringTipo = htmlentities($value, ENT_QUOTES,'UTF-8');
                $info="";
                $options = array();
                $options=$this->obtenerArrayTipo(2);
                $js = "id='cmbTiposEdit'";
                $info .="<div id='field-banda_tipo_chzn' class='chzn-container chzn-container-single'>";
                $info .=form_dropdown("cmbTiposEdit",$options,$stringTipo, $js);    
                $info .=  "</div>" ;  
                return $info;
            }
            
            
             /**
            * Initialize edit_field_callback_estados
            * Callback que será ejecutado al editar un instrumento de la banda de guerra
            * para modificar el formulario mostrado por grocery crud en la opción 
            * Estado del instrumento de la banda de guerra
            * @access public
            * @param string $value: nombre del estado del instrumento de la banda de guerra
            * @return string
            */ 
            function edit_field_callback_estados($value, $primary_key)
            {
                $stringEstado = htmlentities($value, ENT_QUOTES,'UTF-8');
                $info="";
                $options = array();
                $options=$this->obtenerArrayEstado(2);
                $js = "id='cmbEstadosEdit'";
                $info .="<div id='field-banda_estado_chzn' class='chzn-container chzn-container-single'>";
                $info .=form_dropdown("cmbEstadosEdit",$options,$stringEstado, $js);    
                $info .=  "</div>" ;  
                return $info;
            }
            
            /**
            * Initialize edit_field_callback_lugar
            * Callback que será ejecutado al editar un instrumento de la banda de guerra
            * para modificar el formulario mostrado por grocery crud en la opción 
            * Talla del instrumento de la banda de guerra
            * @access public
            * @param string $value: nombre del lugar del instrumento de la banda de guerra
            * @return string
            */
            function edit_field_callback_lugar($value, $primary_key)
            {
                $info="";
                $stringLugar = htmlentities($value, ENT_QUOTES,'UTF-8');
                $options = array();
                
                $options=$this->obtenerArrayLugar(2);
                $js = "id='cmbLugaresEdit'";
                $info .="<div id='field-banda_lugar_chzn' class='chzn-container chzn-container-single'>";
                $info .=form_dropdown("cmbLugaresEdit",$options,$stringLugar, $js);  
                $info .=  "</div>" ;  
                return $info;
            }
  
            
            /**
            * Initialize edit_field_callback_fechaModif
            * Callback que será ejecutado al editar un instrumento de la banda de guerra
            * para modificar el formulario mostrado por grocery crud en la opción 
            * Fecha de modificación del instrumento de la banda de guerra, para que se muestre
            * en un input la fecha en la que esta siendo consultada
            * @access public
            * @return string
            */
           function edit_field_callback_fechaModif()
           {
                $fechaMod=date("d/m/Y");
             
                $info="";
                $info .="<input style='width:120px;' type='text' name='txtFechaModifEdit' id='txtFechaModifEdit' disabled='disabled' value='".$fechaMod."' />";
                return $info;  
            }
            
            
            /**
            * Initialize update_before_callback
            * Callback que será ejecutado antes de actualizar un instrumento de la banda de guerra
            * en donde se actualiza el tipo,estado y lugar  
            * @access public
            * @param array $post_array: array de variables pasadas a traves del método HTTP POST
            * @param integer $primary_key: $primary_key del instrumento de la banda de guerra
            * @return array
            */
            function update_before_callback($post_array, $primary_key)
            {
                $tipo=$post_array['cmbTiposEdit'];
                $estado=$post_array['cmbEstadosEdit'];
                $lugar=$post_array['cmbLugaresEdit'];
                $this->banda_guerra->update_before($primary_key,$tipo,$estado,$lugar);
                return $post_array;
            }
    
    
        
    }
        
        
?>
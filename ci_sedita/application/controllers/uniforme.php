<?php
    if (! defined('BASEPATH'))
    exit ('No se puede ejecutar directamente este SCRIPT');

    /**
    * uniforme
    *
    * @package CodeIgniter
    * @subpackage Controllers
    * @author Sedita
    */ 
    class uniforme extends activos {
        
        function __construct(){
            parent::__construct();
            $this->load->model("mod_uniforme","uniforme");
        }
        
        function _remap($m){
            if(!$this->clslogin->check())
            {
				redirect(site_url("login"));
			}
            else{
                
                    if($m == "guardar"){
                        $this->guardarUniforme();
                    }
           
                    elseif($m == "consultar_uniformes"){
                            $categoria = $this->input->post("categoria");
                            $indInicio= $this->input->post("indInicio");
                            $idOpcion = $this->input->post("idOpcion");
                            $strCod = $this->input->post("strCod");
                            $this->consultarUniformeCateg($categoria,$idOpcion,$strCod,$indInicio); 
                    }
                        
                     
                     elseif($m=="agregar_talla"){
                            $this->load->view("inventario/uniforme/view_registro_talla_uniforme");
                     }
                     
                     elseif($m=="insertar_nueva_talla"){
                        $talla = $this->input->post("talla");
                        $ingreso_talla=$this->insertar_talla($talla);
                        
                     }
                     elseif($m=="actualizar_UltimoCod")
                     {
                        echo $this->ultimoCodInvUniforme(); 
                     }
                    
                    else{
            
                        $this->nuevoUniforme(); 
                    }
                
            }
            
        }
        
        
         /**
            * Initialize ultimoCodInvUniforme
            * Esta función retorna el código del último uniforme que fue ingresado
            * @access public
            * @return string
         */
         function ultimoCodInvUniforme()
         { 
                $strIdCodigo="";
                $rs=$this->uniforme->ultimoUniforme();
                 foreach($rs->result() as $row)
                 {
                    $strIdCodigo .="".$row->uniforme_id."";
                 }
                $idUniforme=(int) $strIdCodigo;
                
                $strUltimoCodigo="";
                $rs1=$this->uniforme->busqUniformeId($idUniforme);
                foreach($rs1->result() as $row)
                {
                    $strUltimoCodigo .="".$row->uniforme_codInv."";
                }
                 return $strUltimoCodigo;
                
             }
             
            /**
            * Initialize obtenerArrayTalla
            * Esta función permite obtener el array de la consulta de tallas de los uniformes 
            * @access public
            * @return array
            */       
            function obtenerArrayTalla()
            {
                $info=array();
                $rs=$this->uniforme->cargar_talla();
            
                foreach ($rs->result() as $fila)
                {
                    $info[$fila->talla_id] = $fila->talla_nombre;
                }
                return $info;
            }
            
            
            /**
            * Initialize obtenerArrayTalla
            * Esta función permite obtener el array de la consulta de tallas de los uniformes y si la talla 
            * aún no ha sido ingresada, el ingreso será exitoso devolviendo 1, caso contrario la talla 
            * ya se encuentra registrada devolviendo 0
            * @access public
            * @return integer
            */ 
            function insertar_talla($talla)
            {
                $numTallaRepet=$this->uniforme->numBusqTallaRepet($talla);
                if($numTallaRepet==0)
                {
                    $this->uniforme->insertar_talla($talla);
                    echo 1;
                }
                else
                {
                    echo 0;
                }
                
            }
            
            
            /**
            * Initialize nuevoUniforme
            * Esta función permite cargar la vista de registro de un uniforme que el usuario podrá observar
            * @access public
            * @return void
            */ 
            function nuevoUniforme(){ 
                $data["ultimoCodigo"]= $this->ultimoCodInvUniforme();     
                $data["tipo_activos"]= $this->obtenerArrayTipo(3); 
                $data["estado_activos"]= $this->obtenerArrayEstado(3);  
                $data["talla_uniforme"]= $this->obtenerArrayTalla();   
                $this->load->view("inventario/uniforme/view_registro",$data); 
            }
            
            
            
            /**
            * Initialize guardarUniforme
            * Esta función guarda un uniforme, devolviendo 1 si es que el uniforme
            * ha sido guardado con éxito, caso contrario devolverá 0 si el uniforme
            * ya se encuentra registrado.
            * @access public
            * @return integer
            */ 
            function guardarUniforme(){
                
                $codInv=$this->input->post("txtCodInv");
                $numUniformeRepet=$this->uniforme->numBusqUniformeRepet($codInv);
                if($numUniformeRepet==0)
                {
                   
                    $idTipo=$this->input->post("cmbTipo");
                    $idEstado=$this->input->post("cmbEstado");
                    $idTalla=$this->input->post("cmbTalla");
                    $comentarios=$this->input->post("txtComentariosUniforme");     
                    $this->uniforme->registrarUniforme($codInv,$idTipo,$idEstado,$idTalla,$comentarios);
                    echo 1;
                }
                else
                {
                    echo 0;
                }
                
               
            }
       
            
            
            /**
            * Initialize consultarUniformeCateg
            * A través de esta función se podrá obtener los resultados de las respectivas consultas
            * por las distintas categorías: Todos, Tipo, Estado y nombre de un uniforme
            * @access public
            * @param string $categoria: nombre de la categoría que ha sido elegida para realizar la búsqueda
            * @param integer $idOpcion: id del estado o tipo del uniforme
            * @param string $strCod: cadena para la realizar la búsqueda por nombre(código de inventario) del uniforme
            * @param integer $indInicio: entero con dos valores: 0 si la página de consultar uniformes ha sido cargada
            *                           y 1 si no se quiere recargar toda la página, sino sólo obtener la tabla con los resultados 
            *                           de la consulta
            * @return void
            */ 
            function consultarUniformeCateg($categoria,$idOpcion,$strCod,$indInicio){
        
                $this->load->helper("form");
                
                $crud = new grocery_CRUD();
                $crud->set_subject('Uniformes');  
                $crud->set_theme('datatables');
                  
                $crud->set_table('uniforme');
                $crud->set_model('mod_uniforme_join');             
                
                $crud->columns('uniforme_codInv','tipo_nombre','estado_nombre','talla_nombre','uniforme_comentarios','uniforme_FechaIngreso','uniforme_FechaModificacion');             
                
                $crud->display_as('uniforme_codInv','C&oacute;digo de inventario');
                $crud->set_rules('uniforme_codInv','Pa&iacute;s','required|callback_alpha_numeric_guion');
                
                $crud->display_as('tipo_nombre','Tipo');
                
                $crud->display_as('uniforme_tipo','Tipo');
                $crud->callback_edit_field('uniforme_tipo',array($this,'edit_field_callback_tipos'));
               
                $crud->display_as('uniforme_nombre','Estado');
                
                $crud->display_as('uniforme_estado','Estado');
                $crud->callback_edit_field('uniforme_estado',array($this,'edit_field_callback_estados'));
                   
                $crud->display_as('talla_nombre','talla');
                $crud->display_as('uniforme_talla','Talla');
                $crud->callback_edit_field('uniforme_talla',array($this,'edit_field_callback_talla'));
                
                $crud->display_as('uniforme_comentarios','Comentario');
                $crud->change_field_type('uniforme_comentarios', 'string');
                 
                $crud->display_as('uniforme_FechaIngreso','Fecha de ingreso');                           
                
                $crud->display_as('uniforme_FechaModificacion','Fecha de &uacute;ltima modificaci&oacute;n');
                $crud->callback_edit_field('uniforme_FechaModificacion',array($this,'edit_field_callback_fechaModif'));
                $crud->unset_add();
                $crud->unset_delete();
                $crud->callback_before_update(array($this,'update_before_callback'));
                
                     if($categoria=="Tipo")
                     {
                        $crud->where('uniforme_tipo',$idOpcion);
                     }
                     elseif($categoria=="Estado")
                     {
                        $crud->where('uniforme_estado',$idOpcion);
                     }
                     elseif($categoria=="Codigo")
                     {
                        $crud->where('uniforme_codInv',$strCod);
                     }
                     else
                     {
                        
                     }
                
                $output = $crud->render();    
                
                    if($indInicio == 0)
                    {
                        $output->options=$this->cargar_opcionesCateg(); 
                        $this->load->view('inventario/uniforme/view_consulta',$output);
                    
                    }
                    else
                    {
                        $this->load->view('view_cruds',$output);
                    }
            }
            
             
            /**
            * Initialize edit_field_callback_tipos
            * Callback que será ejecutado al editar un uniforme
            * para modificar el formulario mostrado por grocery crud en la opción 
            * Tipo del uniforme
            * @access public
            * @param string $value: nombre del tipo del uniforme
            * @return string
            */ 
            function edit_field_callback_tipos($value)
            {
                $stringTipo = htmlentities($value, ENT_QUOTES,'UTF-8');
                $info="";
                $options = array();
                $options=$this->obtenerArrayTipo(3);
                $js = "id='cmbTiposEdit'";
                $info .="<div id='field-uniforme_tipo_chzn' class='chzn-container chzn-container-single'>";
                $info .=form_dropdown("cmbTiposEdit",$options,$stringTipo, $js);    
                $info .=  "</div>" ;  
                return $info;
            }
            
  
            
            /**
            * Initialize edit_field_callback_estados
            * Callback que será ejecutado al editar un uniforme
            * para modificar el formulario mostrado por grocery crud en la opción 
            * Estado del uniforme
            * @access public
            * @param string $value: nombre del estado del uniforme
            * @return string
            */ 
            function edit_field_callback_estados($value)
            {
                $stringEstado = htmlentities($value, ENT_QUOTES,'UTF-8');
                $info="";
                $options = array();
                $options=$this->obtenerArrayEstado(3);
                $js = "id='cmbEstadosEdit'";
                $info .="<div id='field-uniforme_estado_chzn' class='chzn-container chzn-container-single'>";
                $info .=form_dropdown("cmbEstadosEdit",$options,$stringEstado, $js);    
                $info .=  "</div>" ;  
                return $info;
             
            }
            
            
            
            /**
            * Initialize edit_field_callback_talla
            * Callback que será ejecutado al editar un uniforme
            * para modificar el formulario mostrado por grocery crud en la opción 
            * Talla del uniforme
            * @access public
            * @param string $value: nombre de la talla del uniforme
            * @return string
            */
            function edit_field_callback_talla($value)
            {
                $info="";
                $stringTalla = htmlentities($value, ENT_QUOTES,'UTF-8');
                $options = array();
                
                $options=$this->obtenerArrayTalla();
                $js = "id='cmbTallasEdit'";
                $info .="<div id='field-uniforme_talla_chzn' class='chzn-container chzn-container-single'>";
                $info .=form_dropdown("cmbTallasEdit",$options,$stringTalla, $js);  
                $info .=  "</div>" ;  
                return $info;
                
            }
            
            
            /**
            * Initialize edit_field_callback_fechaModif
            * Callback que será ejecutado al editar un uniforme
            * para modificar el formulario mostrado por grocery crud en la opción 
            * Fecha de modificación del uniforme, para que se muestre
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
            * Callback que será ejecutado antes de actualizar un uniforme
            * en donde se actualiza el tipo,estado y lugar  
            * @access public
            * @param array $post_array: array de variables pasadas a traves del método HTTP POST
            * @param integer $primary_key: $primary_key del uniforme
            * @return array
            */
            function update_before_callback($post_array, $primary_key)
            {
                $tipo=$post_array['cmbTiposEdit'];
                $estado=$post_array['cmbEstadosEdit'];
                $talla=$post_array['cmbTallasEdit'];
                $this->uniforme->update_before($primary_key,$tipo,$estado,$talla);
                return $post_array;
            }
    
    
        
    }
        
        
?>
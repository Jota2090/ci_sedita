


<?php
    if (! defined('BASEPATH'))
    exit ('No se puede ejecutar directamente este SCRIPT');

    
    /**
    * equipo_laboratorio
    *
    * @package CodeIgniter
    * @subpackage Controllers
    * @author Sedita
    */ 
    class equipo_laboratorio extends activos {
        
        function __construct(){
            parent::__construct(); 
            $this->load->model("mod_equipo_laboratorio","equipo_laboratorio");
        }
        
        function _remap($m){
            if(!$this->clslogin->check())
            {
				redirect(site_url("login"));
			}
            else{
                
                    if($m == "guardar"){
                        $this->guardarEquipo();
                    }
                    elseif($m == "consultar_equipos"){
                            $categoria = $this->input->post("categoria");
                            $indInicio= $this->input->post("indInicio");
                            $idOpcion = $this->input->post("idOpcion");
                            $strCod = $this->input->post("strCod");
                            $this->consultarEquiLabCateg($categoria,$idOpcion,$strCod,$indInicio); 
                    }
                    
                    elseif($m=="actualizar_UltimoCod")
                    {
                        echo $this->ultimoCodInvEquilab(); 
                    }
                    
                    
                    else{
            
                        $this->nuevoEquiLab(); 
                    }
                
                }
            
            }
        
        
        
       
            /**
            * Initialize ultimoCodInvEquilab
            * Esta función retorna el código del último equipo de laboratorio que fue ingresado
            * @access public
            * @return string
            */
            function ultimoCodInvEquilab()
            { 
                $strIdCodigo="";
                $rs=$this->equipo_laboratorio->ultimoEquilab();
                 foreach($rs->result() as $row)
                 {
                    $strIdCodigo .="".$row->equilab_id."";
                 }
                $idEquiLab=(int) $strIdCodigo;
                
                $strUltimoCodigo="";
                $rs1=$this->equipo_laboratorio->busqEquipoId($idEquiLab);
                foreach($rs1->result() as $row)
                {
                    $strUltimoCodigo .="".$row->equilab_codInv."";
                }
                 return $strUltimoCodigo;
                
            }            
            
            
            /**
            * Initialize nuevoEquiLab
            * Esta función permite cargar la vista de registro de un equipo de laboratorio que el usuario podrá observar
            * @access public
            * @return void
            */ 
            function nuevoEquiLab(){ 
                $data["ultimoCodigo"]= $this->ultimoCodInvEquilab();     
                $data["tipo_activos"]= $this->obtenerArrayTipo(1); 
                $data["estado_activos"]= $this->obtenerArrayEstado(1);  
                $data["lugar_activos"]= $this->obtenerArrayLugar(1);   
                $this->load->view("inventario/equipoLaboratorio/view_registro",$data); 
            }
            
            
            /**
            * Initialize guardarEquipo
            * Esta función guarda un equipo de laboratorio, devolviendo 1 si es que el equipo
            * ha sido guardado con éxito, caso contrario devolverá 0 si el equipo de laboratorio
            * ya se encuentra registrado.
            * @access public
            * @return integer
            */ 
            function guardarEquipo(){
                $codInv=$this->input->post("txtCodInv");
                $numEquipoRepet=$this->equipo_laboratorio->numBusqEquipoRepet($codInv);
                if($numEquipoRepet==0)
                {
                    $idTipo=$this->input->post("cmbTipo");
                    $idEstado=$this->input->post("cmbEstado");
                    $idLugar=$this->input->post("cmbLugar");
                    $comentarios=$this->input->post("txtComentariosEquip");     
                    $this->equipo_laboratorio->registrarEquiLab($codInv,$idTipo,$idEstado,$idLugar,$comentarios);
                    echo 1;
                }
                else
                {
                    echo 0;
                }
            }
            
            
            /**
            * Initialize consultarEquiLabCateg
            * A través de esta función se podrá obtener los resultados de las respectivas consultas
            * por las distintas categorías: Todos, Tipo, Estado y nombre de un equipo de laboratorio
            * @access public
            * @param string $categoria: nombre de la categoría que ha sido elegida para realizar la búsqueda
            * @param integer $idOpcion: id del estado o tipo del equipo de laboratorio
            * @param string $strCod: cadena para la realizar la búsqueda por nombre(código de inventario)del equipo de laboratorio
            * @param integer $indInicio: entero con dos valores: 0 si la página de consultar equipo de laboratorio ha sido cargada
            *                           y 1 si no se quiere recargar toda la página, sino sólo obtener la tabla con los resultados 
            *                           de la consulta
            * @return void
            */ 
            function consultarEquiLabCateg($categoria,$idOpcion,$strCod,$indInicio){
        
                $this->load->helper("form");
                
                $crud = new grocery_CRUD();
                $crud->set_subject('Equipos de Laboratorio');  
                $crud->set_theme('datatables');
                  
                $crud->set_table('equipo_laboratorio');
                $crud->set_model('mod_equipo_laboratorio_join');             
                
                $crud->columns('equilab_codInv','tipo_nombre','estado_nombre','lugar_nombre','equilab_comentarios','equilab_FechaIngreso','equilab_FechaModificacion');             
                
                $crud->display_as('equilab_codInv','C&oacute;digo de inventario');
                $crud->set_rules('equilab_codInv','C&oacute;digo de inventario','required|callback_alpha_numeric_guion');
                
                $crud->display_as('tipo_nombre','Tipo');
                
                $crud->display_as('equilab_tipo','Tipo');
                $crud->callback_edit_field('equilab_tipo',array($this,'edit_field_callback_tipos'));
               
                $crud->display_as('estado_nombre','Estado');
                
                $crud->display_as('equilab_estado','Estado');
                $crud->callback_edit_field('equilab_estado',array($this,'edit_field_callback_estados'));
                   
                $crud->display_as('lugar_nombre','Lugar donde se encuentra');
                
                $crud->display_as('equilab_lugar','Lugar donde se encuentra');
                $crud->callback_edit_field('equilab_lugar',array($this,'edit_field_callback_lugar'));
                
                $crud->display_as('equilab_comentarios','Comentario');
                $crud->change_field_type('equilab_comentarios', 'string');
                 
                $crud->display_as('equilab_FechaIngreso','Fecha de ingreso');                           
                
                $crud->display_as('equilab_FechaModificacion','Fecha de &uacute;ltima modificaci&oacute;n');
                $crud->callback_edit_field('equilab_FechaModificacion',array($this,'edit_field_callback_fechaModif'));
                $crud->unset_add();
                $crud->unset_delete();
                $crud->callback_before_update(array($this,'update_before_callback'));
                
                     if($categoria=="Tipo")
                     {
                        $crud->where('equilab_tipo',$idOpcion);
                     }
                     elseif($categoria=="Estado")
                     {
                        $crud->where('equilab_estado',$idOpcion);
                     }
                     elseif($categoria=="Codigo")
                     {
                        $crud->where('equilab_codInv',$strCod);
                     }
                     else
                     {
                        
                     }
                
                $output = $crud->render();    
                
                    if($indInicio == 0)
                    {
                        $output->options=$this->cargar_opcionesCateg(); 
                        $this->load->view('inventario/equipoLaboratorio/view_consulta',$output);
                    
                    }
                    else
                    {
                        $this->load->view('view_cruds',$output);
                    }
            }
            
            
            /**
            * Initialize edit_field_callback_tipos
            * Callback que será ejecutado al editar un equipo de laboratorio
            * para modificar el formulario mostrado por grocery crud en la opción 
            * Tipo del equipo de laboratorio
            * @access public
            * @param string $value: nombre del tipo del equipo de laboratorio
            * @return string
            */ 
            function edit_field_callback_tipos($value)
            { 
                $stringTipo = htmlentities($value, ENT_QUOTES,'UTF-8');
                $info="";
                $options = array();
                $options=$this->obtenerArrayTipo(1);
                $js = "id='cmbTiposEdit'";
                $info .="<div id='field-equilab_tipo_chzn' class='chzn-container chzn-container-single'>";
                $info .=form_dropdown("cmbTiposEdit",$options,$stringTipo, $js);    
                $info .=  "</div>" ;  
                return $info;
            }


            /**
            * Initialize edit_field_callback_estados
            * Callback que será ejecutado al editar un equipo de laboratorio
            * para modificar el formulario mostrado por grocery crud en la opción 
            * Estado del equipo de laboratorio
            * @access public
            * @param string $value: nombre del estado del equipo de laboratorio
            * @return string
            */ 
            function edit_field_callback_estados($value)
            {
                $stringEstado = htmlentities($value, ENT_QUOTES,'UTF-8');
                $info="";
                $options = array();
                $options=$this->obtenerArrayEstado(1);
                $js = "id='cmbEstadosEdit'";
                $info .="<div id='field-equilab_estado_chzn' class='chzn-container chzn-container-single'>";
                $info .=form_dropdown("cmbEstadosEdit",$options,$stringEstado, $js);    
                $info .=  "</div>" ;  
                return $info;
            }
            
            
            
            
            /**
            * Initialize edit_field_callback_lugar
            * Callback que será ejecutado al editar un equipo de laboratorio
            * para modificar el formulario mostrado por grocery crud en la opción 
            * Lugar del equipo de laboratorio
            * @access public
            * @param string $value: nombre del lugar del equipo de laboratorio
            * @return string
            */
            function edit_field_callback_lugar($value)
            {
                $info="";
                $stringLugar = htmlentities($value, ENT_QUOTES,'UTF-8');
                $options = array();
                
                $options=$this->obtenerArrayLugar(1);
                $js = "id='cmbLugaresEdit'";
                $info .="<div id='field-equilab_lugar_chzn' class='chzn-container chzn-container-single'>";
                $info .=form_dropdown("cmbLugaresEdit",$options,$stringLugar, $js);  
                $info .=  "</div>" ;  
                return $info;
            }
            
            
            
            /**
            * Initialize edit_field_callback_fechaModif
            * Callback que será ejecutado al editar un equipo de laboratorio
            * para modificar el formulario mostrado por grocery crud en la opción 
            * Fecha de modificación del equipo de laboratorio, para que se muestre
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
            * Callback que será ejecutado antes de actualizar un equipo de laboratorio
            * en donde se actualiza el tipo,estado y lugar  
            * @access public
            * @param array $post_array: array de variables pasadas a traves del método HTTP POST
            * @param integer $primary_key: $primary_key del equipo de laboratorio
            * @return array
            */
            function update_before_callback($post_array, $primary_key)
            {
                $tipo=$post_array['cmbTiposEdit'];
                $estado=$post_array['cmbEstadosEdit'];
                $lugar=$post_array['cmbLugaresEdit'];
                $this->equipo_laboratorio->update_before($primary_key,$tipo,$estado,$lugar);
                return $post_array;
            }
    
        
    }
        
        
?>
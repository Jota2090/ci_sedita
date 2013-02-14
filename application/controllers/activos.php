<?php
    if (! defined('BASEPATH'))
    exit ('No se puede ejecutar directamente este SCRIPT');

    class activos extends CI_Controller {
         function __construct()
         {
            parent::__construct();
            $this->load->library('grocery_CRUD');
            $this->load->model("mod_activos","activos");
            $this->load->helper("form");
         }
         
         function _remap($m){
                 if(!$this->clslogin->check())
                 {
        				redirect(site_url("login"));
                 }
                 else{
                        if($m == "cargar_opcionesCombos"){
                                $BusqCategoria=$this->input->post("valueCategoria");
                                $tipo_id_objeto=$this->input->post("tipo_id_objeto");
                                
                                    if($BusqCategoria=="Tipo")
                                    {
                                        $r=$this->obtenerInfoTipoConsulta($tipo_id_objeto); 
                                        
                                    }
                                    
                                    if($BusqCategoria=="Estado")
                                    {
                                        $r=$this->obtenerInfoEstadoConsulta($tipo_id_objeto); 
                                    }
                            
                                echo $r;  
                        }
                            
                        elseif($m=="agregar_tipo"){
                            $this->load->view("inventario/activos/view_registro_tipo_activos");
                        }
                     
                        elseif($m=="insertar_nuevo_tipo"){
                            $tipo = $this->input->post("tipo");
                            $tipo_id_objeto=$this->input->post("tipo_id_objeto");                                                                                    
                            $ingreso_tipo=$this->insertar_tipo($tipo,$tipo_id_objeto);
                        }
                     
                        elseif($m=="agregar_estado"){
                            $this->load->view("inventario/activos/view_registro_estado_activos");
                        }
                     
                        elseif($m=="insertar_nuevo_estado"){
                            $estado = $this->input->post("estado");
                            $tipo_id_objeto=$this->input->post("tipo_id_objeto");                                                        
                            $ingreso_estado=$this->insertar_estado($estado,$estado_id_objeto);
                        }
                     
                        elseif($m=="agregar_lugar"){
                            $this->load->view("inventario/activos/view_registro_lugar_activos");
                        }
                     
                        elseif($m=="insertar_nuevo_lugar"){
                            $lugar = $this->input->post("lugar");
                            $tipo_id_objeto=$this->input->post("tipo_id_objeto");                                                        
                            $ingreso_lugar=$this->insertar_lugar($lugar,$lugar_id_objeto);
                        }                                                                                    
                        
                        
                 }
                 
                 
                 
                                                                                                      
         
         
            }

            function cargar_opcionesCateg(){
                
                    $options = array(
                                                'Todos'  => 'Todos',
                                                'Codigo'   => 'C&oacute;digo',
                                                'Tipo'   => 'Tipo',
                                                'Estado' => 'Estado'
                                    );
                return $options;
            }

            function insertar_tipo($tipo,$tipo_id_objeto)
            { 
                $numTipoRepet=$this->activos->numBusqTipoRepet($tipo,$tipo_id_objeto);
                if($numTipoRepet==0)
                {
                    $this->activos->insertar_tipo($tipo,$tipo_id_objeto);
                    echo 1;
                }
                else
                {
                    echo 0;
                }
                
            }
            
            function insertar_estado($estado,$estado_id_objeto)
            {
                $numEstadoRepet=$this->activos->numBusqEstadoRepet($estado,$estado_id_objeto);
                if($numEstadoRepet==0)
                {
                    $this->activos->insertar_estado($estado,$estado_id_objeto);
                    echo 1;
                }
                else
                {
                    echo 0;
                }
                
            }
            
            function insertar_lugar($lugar,$lugar_id_objeto)
            { 
                $numLugarRepet=$this->activos->numBusqLugarRepet($lugar,$lugar_id_objeto);
                if($numLugarRepet==0)
                {
                    $this->activos->insertar_lugar($lugar,$lugar_id_objeto);
                    echo 1;
                }
                else
                {
                    echo 0;
                }
                
            }
         
            function obtenerArrayTipo($tipo_id_objeto)
            {
                $info=array();
                $rs=$this->activos->cargar_tipo($tipo_id_objeto);
            
                foreach ($rs->result() as $fila)
                {
                    $info[$fila->tipo_id] = $fila->tipo_nombre;
                }
                return $info;
            }
            
            function obtenerArrayEstado($estado_id_objeto)
            {
                $info=array();
                $rs=$this->activos->cargar_estado($estado_id_objeto);
            
                foreach ($rs->result() as $fila)
                {
                    $info[$fila->estado_id] = $fila->estado_nombre;
                }
                return $info;
            }
            
            function obtenerArrayLugar($lugar_id_objeto)
            {
                $info=array();
                $rs=$this->activos->cargar_lugar($lugar_id_objeto);
            
                foreach ($rs->result() as $fila)
                {
                    $info[$fila->lugar_id] = $fila->lugar_nombre;
                }
                return $info;
            }
            
            function obtenerInfoTipoConsulta($tipo_id_objeto)
            {
                $info="";
                $info .="<option value=''>Seleccione un tipo</option>";
                $rs=$this->activos->cargar_tipoConsulta($tipo_id_objeto); 
                foreach ($rs->result() as $row)
                {
                    $info .="<option value='".$row->tipo_id."'>".$row->tipo_nombre."</option>";
                }
                    
                return $info;
            }
            
            function obtenerInfoEstadoConsulta($estado_id_objeto)
            {
                $info="";
                $info .="<option value=''>Seleccione un estado</option>";
                $rs=$this->activos->cargar_estadoConsulta($estado_id_objeto); 
                
                foreach ($rs->result() as $row)
                {
                   $info .="<option value='".$row->estado_id."'>".$row->estado_nombre."</option>";
                }
                
                return $info;
            }            


            function alpha_numeric_guion($str)
            {
            
                $str1=utf8_decode(stripcslashes($str)); 
                if (! preg_match("/^[a-zA-Z0-9\ \-]+$/", $str1))
                {
                    $this->form_validation->set_message('alpha_numeric_guion', 'El campo %s solo puede contener letras, n&uacute;meros, gui&oacute;n y espacios');
                    return FALSE;
                }
                else
                {
                    return TRUE;
                }
           
            }
        
        }
        ?>
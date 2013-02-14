<?php
    if (! defined('BASEPATH'))
    exit ('No se puede ejecutar directamente este SCRIPT');

    /**
    * controlador_General
    *
    * @package CodeIgniter
    * @subpackage Controllers
    * @author Sedita
    */
    class controlador_General extends CI_Controller {
        function __construct()
        {
            parent::__construct();
            $this->load->library('grocery_CRUD');
            $this->load->model("mod_general","general");
        }
        
        function _remap($m){
            if(!$this->clslogin->check())
            {
                redirect(site_url("login"));
            }
            else{
                if($m == "cargar_cursos"){      
                    $j= $this->input->post("jornada");
                    $n= $this->input->post("nivel");
                    $r=$this->cargar_cursos($j,$n);
                    echo $r;   
                }
                elseif($m == "cargar_especializaciones"){
                    $j= $this->input->post("jornada");
                    $n= $this->input->post("curso");
                    $r=$this->cargar_especializaciones($j,$n);
                    echo $r;
                }
                elseif($m == "cargar_paralelos"){
                    $j= $this->input->post("jornada");
                    $n= $this->input->post("curso");
                    $r=$this->cargar_paralelos($j,$n);
                    echo $r;
                }
                elseif($m == "cargar_paralBachill"){
                    $j= $this->input->post("jornada");
                    $n= $this->input->post("curso");
                    $o= $this->input->post("espec");
                    $r=$this->cargar_paralBachill($j,$n,$o);
                    echo $r;
                }
            }
            
        }

        /**
            * Initialize cargar_jornadas
            * Esta función permite recorrer el array devuelto de la consulta de jornadas, para obtener un array 
            * con los nombres nombres de las jornadas
            * @access public
            * @return array
        */ 
        function cargar_jornadas()
        {
            $info=array();
            $info['0']="Seleccione una jornada";
            $rs=$this->general->cargar_jornadas();
             foreach ($rs->result() as $fila){
                $info[$fila->jor_id] = $fila->jor_nombre;
            }
            return $info;
        }
        
        
        /**
            * Initialize cargar_anios_registro
            * Esta función permite recorrer el array devuelto de la consulta de años lectivos, para obtener un array 
            * con los períodos lectivos
            * @access public
            * @return array
         */          
        function cargar_anios_registro()
        {
            $info=array();
            $rs=$this->general->cargar_anios_registro();
             foreach ($rs->result() as $fila){
                $info[$fila->anl_id] = $fila->anl_periodo." - " .(($fila->anl_periodo)+1);
            }
            return $info;
        }
        
        
         /**
            * Initialize cargar_aniosLectivos
            * Esta función permite recorrer el array devuelto de la consulta de años lectivos, para obtener un array 
            * con los períodos lectivos
            * @access public
            * @return array
         */          
        function cargar_aniosLectivos()
        {
            $info=array();
            $rs=$this->general->cargar_aniosLectivos();
             foreach ($rs->result() as $fila){
                $info[$fila->anl_id] = $fila->anl_periodo." - " .(($fila->anl_periodo)+1);
            }
            return $info;
        }
        
        
         /**
            * Initialize get_idAnioLect
            * Esta función permite recorrer el array devuelto de la consulta del año lectivo que coincida con el parámetro enviado
            * para obtener el id del año
            * @access public
            * @param string $anioLect
            * @return integer
         */
        function get_idAnioLect($anioLect)
        {   
            if(date('n')<3)
                $anioLect=$anioLect-1;
                
            $rs=$this->general->get_idAnioLect($anioLect);
            $strAnLectId="";
            foreach($rs->result() as $row){
                $strAnLectId=$row->anl_id;
            }
            
            return $strAnLectId;
        }
         
         
          /**
            * Initialize cargar_cursos
            * Esta función permite recorrer el array devuelto de la consulta de cursos de acuerdo a la jornada y nivel
            * devolviendo un string con los option que serán creadas en las vistas
            * @access public
            * @param string $jornada:id de la jornada
            * @param string $nivel: id del nivel
            * @return string
         */
        function cargar_cursos($jornada,$nivel)
        {
            $rs=$this->general->cargar_cursos($jornada,$nivel);
            $info="";
            $info .="<option value='0'>Seleccione un curso</option>";
            foreach($rs->result() as $row){
                $info .="<option value='".$row->cur_id."'>".$row->cur_nombre."</option>";
            }
            return $info;
        }
        
        
         /**
            * Initialize cargar_especializaciones
            * Esta función permite recorrer el array devuelto de la consulta de especializaciones de acuerdo a la jornada y curso
            * enviadas como parámetros, devolviendo un string con los option que serán creadas en las vistas
            * @access public
            * @param string $jornada:id de la jornada
            * @param string $curso: id del curso
            * @return string
         */
        function cargar_especializaciones($jornada,$curso)
        {
            $rs=$this->general->cargar_especializaciones($jornada,$curso);
            $info="";
            
            $info .="<option value='0'>Seleccione una especializaci&oacute;n</option>";
                        
            foreach($rs->result() as $row){
                $info .="<option value='".$row->esp_id."'>".$row->esp_nombre."</option>";
            }
            return $info;
        }
        
        
        /**
            * Initialize cargar_paralelos
            * Esta función permite recorrer el array devuelto de la consulta de paralelos de acuerdo a la jornada y curso
            * enviadas como parámetros, devolviendo un string con los option que serán creadas en las vistas
            * @access public
            * @param string $jornada:id de la jornada
            * @param string $curso: id del curso
            * @return string
         */
        function cargar_paralelos($jornada,$curso)
        {
            $rs=$this->general->cargar_paralelos($jornada,$curso);

            $info="";
            $info .="<option value='0'>Seleccione un paralelo</option>";
                        
            foreach($rs->result() as $row){
                $info .="<option value='".$row->par_id."'>".$row->par_nombre."</option>";
            }
            return $info;
        }
        
        
         /**
            * Initialize cargar_paralBachill
            * Esta función permite recorrer el array devuelto de la consulta de paralelos de 2do. y 3ero. 
            * de Bachillerato de acuerdo a la jornada, curso y espec enviadas como parámetros, devolviendo
            * un string con los option que serán creadas en las vistas
            * @access public
            * @param string $jornada:id de la jornada
            * @param string $curso: id del curso
            * @param string $espec: id de la especialización
            * @return string
         */
        function cargar_paralBachill($jornada,$curso,$espec)
        {
            $rs=$this->general->cargar_paralBachill($jornada,$curso,$espec);
            
            $info="";
            $info .="<option value='0'>Seleccione un paralelo</option>";
                        
            foreach($rs->result() as $row){
                $info .="<option value='".$row->par_id."'>".$row->par_nombre."</option>";
            }
            return $info;
        }
      
    } 
?>
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
    class General extends CI_Controller {
        function __construct()
        {
            parent::__construct();
            $this->load->library('grocery_CRUD');
            $this->load->model("mod_general","general");
            $this->load->model("mod_acta_calificaciones","acta");
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
                elseif($m == "cargar_niveles"){
                    $m= $this->input->post("jornada");
                    $r=$this->general->cargar_niveles($m);
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
        
        
        function cargar_anlActual(){
            $anl_id = $this->general->verificar_anl(date("Y"));
            return $anl_id;
        }

        /**
            * Initialize cargar_jornadas
            * Esta funci�n permite recorrer el array devuelto de la consulta de jornadas, para obtener un array 
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
            * Esta funci�n permite recorrer el array devuelto de la consulta de a�os lectivos, para obtener un array 
            * con los per�odos lectivos
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
            * Esta funci�n permite recorrer el array devuelto de la consulta de a�os lectivos, para obtener un array 
            * con los per�odos lectivos
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
            * Esta funci�n permite recorrer el array devuelto de la consulta del a�o lectivo que coincida con el par�metro enviado
            * para obtener el id del a�o
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
            * Esta funci�n permite recorrer el array devuelto de la consulta de cursos de acuerdo a la jornada y nivel
            * devolviendo un string con los option que ser�n creadas en las vistas
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
            * Esta funci�n permite recorrer el array devuelto de la consulta de especializaciones de acuerdo a la jornada y curso
            * enviadas como par�metros, devolviendo un string con los option que ser�n creadas en las vistas
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
            * Esta funci�n permite recorrer el array devuelto de la consulta de paralelos de acuerdo a la jornada y curso
            * enviadas como par�metros, devolviendo un string con los option que ser�n creadas en las vistas
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
            * Esta funci�n permite recorrer el array devuelto de la consulta de paralelos de 2do. y 3ero. 
            * de Bachillerato de acuerdo a la jornada, curso y espec enviadas como par�metros, devolviendo
            * un string con los option que ser�n creadas en las vistas
            * @access public
            * @param string $jornada:id de la jornada
            * @param string $curso: id del curso
            * @param string $espec: id de la especializaci�n
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
        
        
        /**
            * Initialize encontrarIdCursoParalelo
            * Esta funci�n retorna el id del curso paralelo de acuerdo a los par�metros que sn eniados en la consulta
            * @access public
            * @param integer $jornada: id de la jornada
            * @param integer $curso: id del curso
            * @param integer $espec: id de la especializaci�n
            * @param integer $paral: id del paralelo
            * @return integer
            */
        function encontrarIdCursoParalelo($jornada,$curso,$especializacion,$paralelo)
        {
            if(($curso!=12)&&($curso!=13))
            {
                $especializacion=-1; 
            }

            $rs2=$this->general->curso_Paralelo($jornada,$curso,$especializacion,$paralelo);

            $strCpId="";      
            foreach($rs2->result() as $row){
                $strCpId .="".$row->cp_id."";
            }

            $cpId = (int)$strCpId;

            return $cpId;
        }
        
        
        function get_nom_periodo($mod){
            $info = "";
            $rs=$this->general->nombre_periodo($mod);
            foreach ($rs->result() as $fila){
                $info = $fila->pes_nombre;
            }
            
            return $info;
        }
        
        
        function get_nom_jornada($j){
            $info = "";
            $rs=$this->general->nombre_jornada($j);
            foreach ($rs->result() as $fila){
                $info = $fila->jor_nombre;
            }
            return $info;
        }
        
        
        function get_nom_curso($cp){
            $info = "";
            $rs=$this->general->nombre_curso($cp);
            foreach ($rs->result() as $fila){
                if($fila->esp_id > 0)
                    $info = $fila->cur_nombre ." " .$fila->esp_nombre ." " .$fila->par_nombre;
                else
                    $info = $fila->cur_nombre ." " .$fila->par_nombre;
            }
            return $info;
        }
        
        
        function get_nom_especializacion($e){
            $info="";
            $rs=$this->general->nombre_especializacion($e);
            foreach ($rs->result() as $fila){
                $info = $fila->esp_nombre;
            }
            
            return $info;
        }
        
        
        function get_anio_lectivo($anl){
            $info = "";
            $rs=$this->general->nombre_anio_lectivo($anl);
            foreach ($rs->result() as $fila){
                $info .= $fila->anl_periodo;
                $info .= " - ";
                $info .= $fila->anl_periodo+1;
            }
            return $info;
        }
        
        
        function lista_alumnos($cp, $anl){
            $rs=$this->acta->listar_alumnos($cp,$anl);
            $info="";
            foreach($rs->result() as $row){
                $info .="<option value='".$row->alu_id."'>".$row->alu_apellidos." ".$row->alu_nombres."</option>";
            }
            return $info;
        }
        
    } 
?>
<?php
    if (! defined('BASEPATH'))
    exit ('No se puede ejecutar directamente este SCRIPT');


    /**
    * mod_general
    *
    * @package CodeIgniter
    * @subpackage Models
    * @author Sedita
    */
    class mod_general extends CI_Model {
        
        function __construct(){
            parent::__construct();
            
        }
        
        
        /**
            * Initialize cargar_jornadas
            * Esta función obtiene las jornadas que han sido registradas
            * @access public
            * @return array
        */
        function cargar_jornadas(){
            $this->db->order_by("jor_id");
            $rs=$this->db->get("jornada");
            return $rs;
        }
        
        
        /**
            * Initialize cargar_anios_registro
            * Esta función carga los años lectivos actual y un periodo despues
            * @access public
            * @return array
        */
        function cargar_anios_registro(){
            $fecha=date('Y');
            
            if(date('n')>6){
                $fecha=$fecha+1;
                
                $this->db->order_by("anl_periodo");
                $this->db->where("anl_periodo",$fecha);
                $this->db->from("anio_lectivo");
                $num=$this->db->count_all_results();
                
                if($num>0){
                    $this->db->order_by("anl_periodo");
                    $this->db->where("anl_periodo",$fecha);
                    $this->db->from("anio_lectivo");
                    $this->db->or_where("anl_periodo",date('Y'));
                    $rs=$this->db->get();
                }else{
                    $data = array("anl_periodo"=>$fecha);            
                    $this->db->insert("anio_lectivo",$data);
                    
                    $this->db->where("anl_periodo",date('Y'));
                    $this->db->or_where("anl_periodo",$fecha);
                    $this->db->from("anio_lectivo");
                    $rs=$this->db->get();
                }
            }
            else{
                $this->db->order_by("anl_periodo");
                $this->db->where("anl_periodo",$fecha);
                $this->db->from("anio_lectivo");
                $num=$this->db->count_all_results();
                
                if($num>0){
                    $this->db->order_by("anl_periodo");
                    $this->db->where("anl_periodo",$fecha);
                    $this->db->from("anio_lectivo");
                    $rs=$this->db->get();
                }else{
                    $data = array("anl_periodo"=>$fecha);            
                    $this->db->insert("anio_lectivo",$data);
                    
                    $this->db->where("anl_periodo",$fecha);
                    $this->db->from("anio_lectivo");
                    $rs=$this->db->get();
                }
            }
            
            return $rs;
        }
        
        
        /**
            * Initialize cargar_aniosLectivos
            * Esta función carga todos los años lectivos
            * @access public
            * @return array
        */
        function cargar_aniosLectivos(){
            $this->db->order_by("anl_periodo");
            $rs=$this->db->get("anio_lectivo");
                
            return $rs;
        }
        
        
        /**
            * Initialize get_idAnioLect
            * Esta función obtiene un array con cada uno de los campos de la tabla anio_lectivo de acuerdo al año recibido
            * como parámetro
            * @access public
            * @param integer $Anio: año lectivo
            * @return array
        */
        function get_idAnioLect($Anio){
            $this->db->select("anl_id");
            $this->db->where("anl_periodo",$Anio);
            $rs= $this->db->get("anio_lectivo"); 
            
            return $rs;
        }
        
        
        /**
            * Initialize cargar_cursos
            * Esta función obtiene los cursos que coincidan con los parámetros de jornada y nivel
            * @access public
            * @param integer $jornada: id de la jornada
            * @param integer $nivel: id del nivel
            * @return array
        */
        function cargar_cursos($jornada,$nivel){
            $this->db->distinct();
            $this->db->order_by("cur_id");
            $this->db->select("cur_id,cur_nombre"); 
            $this->db->from("curso_paralelo");
            $this->db->where("cp_jornada_id",$jornada);
            $this->db->where("cur_nivel_id",$nivel);
            $this->db->join("curso", "cp_curso_id = cur_id");
            
            $rs= $this->db->get();
            return $rs;
        }
        
        
         /**
            * Initialize cargar_cursosEdit
            * Esta función ontiene los cursos que coincida con el parámetro jornada para ser mostrada en la vista de edición
            * de alumno
            * @access public
            * @param integer $jornada: id de la jornada
            * @return array
        */
        function cargar_cursosEdit($jornada){
            $this->db->distinct();
            $this->db->order_by("cur_id");
            $this->db->select("cur_id,cur_nombre"); 
            $this->db->from("curso_paralelo");
            $this->db->where("cp_jornada_id",$jornada);
            $this->db->join("curso", "cp_curso_id = cur_id");
            $rs= $this->db->get();
           return $rs;
        }
        
        /**
            * Initialize cargar_especializaciones
            * Esta función obtiene las especializaciones de los cursos de bachillerato 
            * @access public
            * @param integer $jornada: id de la jornada
            * @param integer $curso: id del curso
            * @return array
        */
        function cargar_especializaciones($jornada,$curso){
            $this->db->distinct();
			$this->db->order_by("esp_nombre");
            $this->db->select("esp_id,esp_nombre");
            $this->db->from("curso_paralelo");
            $this->db->where("cp_jornada_id",$jornada);
            $this->db->where("cp_curso_id",$curso);
            $this->db->join("especializacion", "cp_especializacion_id = esp_id");
            $rs= $this->db->get();
            return $rs;
        }
         
         
        /**
            * Initialize cargar_paralelos
            * Esta función obtiene los paralelos de los cursos a excepción de 2do. y 3ero. de Bachillerato
            * @access public
            * @param integer $jornada: id de la jornada
            * @param integer $curso: id del curso
            * @return array
        */
        function cargar_paralelos($jornada,$curso){
            $this->db->from("curso_paralelo");
            $this->db->where("cp_jornada_id",$jornada);
            $this->db->where("cp_curso_id",$curso);
            $this->db->join("paralelo", "cp_paralelo_id = par_id");
            $rs= $this->db->get();
            return $rs;
        }
        
        
        /**
            * Initialize cargar_paralBachill
            * Esta función obtiene los paralelos de 2do. y 3ero. de Bachillerato
            * @access public
            * @param integer $jornada: id de la jornada
            * @param integer $curso: id del curso
            * @param integer $espec: id de la especialización
            * @return array
        */
        function cargar_paralBachill($jornada,$curso,$espec){
            $this->db->from("curso_paralelo");
            $this->db->where("cp_jornada_id",$jornada);
            $this->db->where("cp_curso_id",$curso);
            $this->db->where("cp_especializacion_id",$espec);
            $this->db->join("paralelo", "cp_paralelo_id = par_id");
            $rs= $this->db->get();
            return $rs;
        }
        
        
        
        /**
            * Initialize obtener_CursoParalelo
            * Esta función obtiene la data del curso_paralelo que coincida con el id pasado como parámetro
            * @access public
            * @param integer $id_curso_paralelo
            * @return array
        */
        function obtener_CursoParalelo($id_curso_paralelo){            
                $this->db->from("curso_paralelo");
                $this->db->where("cp_id",$id_curso_paralelo);
                $rs = $this->db->get();
                return $rs;
        }
        
        
        /**
            * Initialize curso_Paralelo
            * Esta función obtiene la data del curso_paralelo que coincida con la jornada, curso, especialización 
            * y paralelo que han sido enviadas como parámetro
            * @access public
            * @param integer $jornada: id de la jornada
            * @param integer $curso: id del curso
            * @param integer $espec: id de la especialización
            * @param integer $paral: id del paralelo
            * @return array
        */
        function curso_Paralelo($jornada,$curso,$espec,$paral){
                $this->db->select("cp_id");
                $this->db->where("cp_jornada_id",$jornada);
                $this->db->where("cp_curso_id",$curso);
                $this->db->where("cp_especializacion_id",$espec);
                $this->db->where("cp_paralelo_id",$paral);
                $rs= $this->db->get("curso_paralelo");
                return $rs;
        }
        
        
        /**
            * Initialize cargar_niveles
            * Esta función carga los niveles de acuerdo a la jornada
            * @access public
            * @param integer $jornada: id de la jornada
            * @return string
        */
        function cargar_niveles($jornada){
            $this->db->distinct();
            $this->db->select("cur_nivel_id");
            $this->db->from("curso_paralelo");
            $this->db->where("cp_jornada_id",$jornada);
            $this->db->join("curso", "cp_curso_id = cur_id");
            $rs1= $this->db->get();
            $info="";
            $info .="<option value='0'>Seleccione un nivel</option>";
        
            foreach($rs1->result() as $row1){
                $this->db->distinct();
                $this->db->select("niv_id,niv_nombre"); 
                $this->db->where("niv_id",($row1->cur_nivel_id));
                $rs2= $this->db->get("nivel");
                foreach($rs2->result() as $row2){
                $info .="<option value='".$row2->niv_id."'>".$row2->niv_nombre."</option>";
                }
            }
            return $info;
        }
        
        
        /**
            * Initialize join_CursoParalelo_Curso
            * Esta función realiza el join entre las tablas curso_paralelo y curso donde
            * el  cp_jornada_id sea igual a la jornada pasada por parámetro
            * @access public
            * @param integer $jornada: id de la jornada
            * @return array
        */
        function join_CursoParalelo_Curso($jornada){
            $this->db->distinct();
            $this->db->select("cur_nivel_id");
            $this->db->from("curso_paralelo");
            $this->db->where("cp_jornada_id",$jornada);
            $this->db->join("curso", "cp_curso_id = cur_id");
            $rs= $this->db->get();
            return $rs;
        }
        
    }
?>
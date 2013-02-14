<?php
    if (! defined('BASEPATH'))
    exit ('No se puede ejecutar directamente este SCRIPT');

    class mod_alumno extends CI_Model {
        
        function __construct(){
            parent::__construct();
        }
        
        /**
            * Initialize num_matricula
            * Funci�n que retorna un numero de matricula nuevo para los alumnos
            * @access public
            * @return array
        */ 
         function num_matricula(){
            $this->db->select_max('alu_id');
            $rs=$this->db->get("alumno");
            $matri="";
            
            foreach($rs->result() as $row)
                $num=$row->alu_id;
            
            $num=$num+1;
            
            if(strlen($num)==5){$matri = date('Y')."".$num;}
            elseif(strlen($num)==4){$matri = date('Y')."0".$num;}
            elseif(strlen($num)==3){$matri = date('Y')."00".$num;}
            elseif(strlen($num)==2){$matri = date('Y')."000".$num;}
            else{$matri = date('Y')."0000".$num;}
            
            return $matri;
        }
        
        
           /**
            * Initialize cargar_categorias
            * Funci�n que retorna la consulta de todas las categor�as de un alumno
            * @access public
            * @return array
        */ 
         function cargar_categorias(){
            $this->db->order_by("cat_nombre");
            $rs=$this->db->get("categoria_alumno");
            return $rs;
        }
        
          
          /**
            * Initialize numAlumnos
            * Funci�n que obtiene el n�mero de alumnos que se encuentra en un curso paralelo
            * @access public
            * @param integer $cpId: id del curso
            * @param integer $idAnioLect: id del a�o lectivo
            * @return integer
        */ 
        function numAlumnos($cpId,$idAnioLect){
            $this->db->where("alu_curso_paralelo_id",$cpId);
            $this->db->where("alu_ano_lectivo_id",$idAnioLect);
            $this->db->from("alumno");
            $numAlumnos=$this->db->count_all_results();
            return $numAlumnos;
        }


        /**
            * Initialize numAlumnosRepetCurso
            * Funci�n que obtiene el n�mero de cincidencias entre los datos del alumno  que se 
            * quiere matricular vs. los alumnos que  ya se encuentran registrados en este curso
            * @access public
            * @param integer $cpId: id del curso
            * @param string $nombAlumn: nombres del alumno
            * @param string $apellAlumn: apellidos del alumno
            * @param integer $$AnioId: id del a�o lectivo
            * @return integer
        */ 
        function numAlumnosRepetCurso($cpId,$matricula,$AnioId)
        {
            $this->db->where("alu_curso_paralelo_id",$cpId);
            $this->db->where("alu_matricula",$matricula);
            $this->db->where("alu_ano_lectivo_id",$AnioId);
            $this->db->from("alumno");
            $numAlumnosRepet=$this->db->count_all_results();
            return $numAlumnosRepet;
            
        }
        
        
          /**
            * Initialize numAlumnosRepetOtroCurso
            * Funci�n que obtiene el n�mero de cincidencias entre los datos del alumno que se 
            * quiere matricular vs. los alumnos que  ya se encuentran registrados en otros cursos
            * @access public
            * @param integer $cpId: id del curso
            * @param string $nombAlumn: nombres del alumno
            * @param string $apellAlumn: apellidos del alumno
            * @param integer $$AnioId: id del a�o lectivo
            * @return integer
        */ 
        function numAlumnosRepetOtroCurso($cpId,$matricula,$AnioId)
        {
            $this->db->where_not_in("alu_curso_paralelo_id",$cpId);
            $this->db->where("alu_matricula",$matricula);
            $this->db->where("alu_ano_lectivo_id",$AnioId);
            $this->db->from("alumno");
            $numAlumnosRepetOtroCurso=$this->db->count_all_results();
            
            return $numAlumnosRepetOtroCurso;            
        }
        
        
          /**
            * Initialize guardar_Alumno
            * Funci�n que guarda un alumno
            * @access public
            * @return void
        */ 
        function guardar_Alumno($matricula,$nombres,$apellidos,$domicilio,$telef,$pais,$lugarNac,$mifecha,$rbSexo,$edad,$nombMadre,$ocupMadre,$paisMadre,$nombPadre,$ocupPadre,$paisPadre,$rbRepresent,$check,$comentarios,$categoria,$repId,$cpId,$AnioId)
        {
            $data = array(
                            "alu_matricula"=>$matricula,
                            "alu_nombres"=>$nombres,
                            "alu_apellidos"=>$apellidos,
                            "alu_domicilio"=>$domicilio,
                            "alu_telefono"=>$telef,
                            "alu_pais"=>$pais,
                            "alu_lugar_nacimiento"=>$lugarNac,
                            "alu_fecha_nacimiento"=>$mifecha,
                            "alu_sexo"=>$rbSexo,
                            "alu_edad"=>$edad,
                            "alu_madre_nombres"=>$nombMadre,
                            "alu_madre_ocupacion"=>$ocupMadre,
                            "alu_madre_pais"=>$paisMadre,
                            "alu_padre_nombres"=>$nombPadre,
                            "alu_padre_ocupacion"=>$ocupPadre,
                            "alu_padre_pais"=>$paisPadre,
                            "alu_principal_representante"=>$rbRepresent,
                            "alu_documentacion"=>$check,
                            "alu_comentarios"=>$comentarios,
                            "alu_categoria_alumno_id"=>$categoria,
                            "alu_representante_id"=>$repId,
                            "alu_curso_paralelo_id"=>$cpId,
                            "alu_ano_lectivo_id"=>$AnioId,
                            "alu_estado"=>"a"
                            );
                            
            $this->db->insert("alumno",$data);
        }
        
        
          /**
            * Initialize obtenerRepres
            * Obtiene el representante que coincida con el $datRepresentante
            * @access public
            * @param array $post_array: array de variables pasadas a traves del m�todo HTTP POST
            * @param integer $value: id del curso_paralelo
            * @return array
        */ 
        function obtenerRepres($dataRepresentante)
        {
            $this->db->select("rep_id");
            $this->db->where($dataRepresentante);
            $rs= $this->db->get("representante");
            return $rs;
        }
        
        
          /**
            * Initialize obtener_alumnoRepresentante
            * Funci�n que obtiene tanto los datos del alumno como el de su representante 
            * @access public
            * @param integer $idAlumno: id del alumno
            * @return array
        */ 
        function obtener_alumnoRepresentante($idAlumno){
            $this->db->from("alumno");
            $this->db->join("representante", "rep_id=alu_representante_id");
            $this->db->where("alu_matricula",$idAlumno);
            $this->db->order_by("alu_id","desc");
            $rs = $this->db->get();
            return $rs;
        }
        
          /**
            * Initialize obtener_alumno
            * Funci�n que obtiene los datos del alumno dde acuerdo con su id 
            * @access public
            * @param integer $idAlumno: id del alumno
            * @return array
        */ 
        function obtener_alumno($idAlumno){            
            $this->db->from("alumno");
            $this->db->where("alu_id",$idAlumno);
            $rs = $this->db->get();
            return $rs;
        }
        
        
          /**
            * Initialize  obtener_representante
            * Funci�n que obtiene los datos del representante de acuerdo con su id 
            * @access public
            * @param integer $idRepresentante: id del representante
            * @return array
        */ 
        function obtener_representante($idRepresentante){
            $this->db->from("representante");
            $this->db->where("rep_id",$idRepresentante);
            $rs = $this->db->get();
            return $rs;
        }
        
        
          /**
            * Initialize buscarRepres
            *Funci�n que busca cuantas coincidencias hay entre el $data_representante con los representantes que ya han sido ingresados
            * @access public
            * @param array $dataRepresentante: array de datos del representante
            * @return integer
        */ 
        function buscarRepres($dataRepresentante)
        {
            $this->db->where($dataRepresentante);
            $this->db->from("representante");
            $numResultRepres=$this->db->count_all_results();
            return $numResultRepres;
            
        }
        

         /**
            * Initialize actualizar_representante
            * Actualiza los datos del representante
            * @access public
            * @param integer $idRepres: id del representante
            * @param string $nomb_rep: nombre del representante
            * @param string $ocup_rep: ocupacion del representante
            * @param string $dom_rep: domicilio del representante
            * @param string $tel_rep:telefono del representante
            * @param string $pais_rep:pais del representante
            * @return string 
            * 
        */ 
        function actualizar_representante($idRepres,$nomb_rep, $ocup_rep, $dom_rep, $tel_rep, $pais_rep){
            $data = array(
                            "rep_nombres"=>$nomb_rep,
                            "rep_ocupacion"=>$ocup_rep,
                            "rep_telefono"=>$tel_rep,
                            "rep_domicilio"=>$dom_rep,
                            "rep_pais"=>$pais_rep
                        );
                            
            $this->db->where('rep_id', $idRepres);
            $this->db->update('representante', $data); 
        }
      
      
          /**
            * Initialize actualizar_curso_paralelo_doc_Alumno
            * Actualiza el curso_paralelo del alumno as� como tambi�n si tiene o no docuentaci�n
            * @access public
            * @param integer $pkAlumno: id del alumno
            * @param integer $idCursParal: id del curso_paralelo
            * @param integer $alu_documentacion: 0 si no tienen documentaci�n y 1 si es si la tiene
            * @return string
        */ 
        function actualizar_curso_paralelo_doc_Alumno($pkAlumno,$idCursParal, $alu_documentacion){

            $data = array(
                            "alu_documentacion"=>$alu_documentacion,
                            "alu_curso_paralelo_id"=>$idCursParal
                        );
                            
            $this->db->where('alu_id', $pkAlumno);
            $this->db->update('alumno', $data); 
        }
        
        
        function listado_alumnos1(){
            $this->db->select("alu_nombres,alu_apellidos,alu_edad");
            $this->db->from("alumno");
            return $this->db->get();
        
        }
        
        /**
            * Initialize busqAlumnoId
            * Obtiene la data de la consulta de un alumno por su id
            * @access public
            * @param integer $idAlumno
            * @return void 
            * 
        */ 
        function busqAlumnoId($idAlumno)
        {
             $this->db->where("alu_id",$idAlumno);
             $this->db->from("alumno");
             $rs= $this->db->get();
             return $rs;
        }
        
        function update_EstadoARetirado($primary_key){
             $data = array(
                            "alu_estado"=>"r"
                            );
                            
            $this->db->where('alu_id', $primary_key);
            $this->db->update('alumno', $data);   
        }
        
        
          /**
            * Initialize guardarRepresentante
            * Guarda un representante
            * @access public
            * @param array $dataRepresentante
            * @return void 
            * 
        */ 
        
        function guardarRepresentante($dataRepresentante)
        {
            $this->db->insert("representante",$dataRepresentante);
        }
        
    }
?>
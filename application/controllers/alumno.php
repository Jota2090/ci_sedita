<?php
    if (! defined('BASEPATH'))
    exit ('No se puede ejecutar directamente este SCRIPT');

    /**
    * alumno
    *
    * @package CodeIgniter
    * @subpackage Controllers
    * @author Sedita
    */    
    class alumno extends General {
        
        function __construct(){
            parent::__construct();
            $this->load->library('grocery_CRUD');
            $this->load->model("mod_alumno","alumno");
            $this->load->model("mod_general","general");
            $this->load->helper("country_helper");
            $this->load->helper("form");
        }
        
        function _remap($m){
            if(!$this->clslogin->check())
            {
		redirect(site_url("login"));
            }
            else
            {
                if($m == "guardar"){
                    $this->validarAlumno();
                    //$this->guardar();
                }
                elseif($m == "num_matricula"){
                    $r=$this->alumno->num_matricula();
                    echo "<input style='width: 80px;' type='text' name='txtMatricula' id='txtMatricula' disabled='disabled' value='$r' />";
                }
                elseif($m == "num_Alumnos"){
                    $m= $this->input->post("jornada");
                    $n= $this->input->post("curso");
                    $o= $this->input->post("espec");
                    $p= $this->input->post("paral");
                    $anl= $this->input->post("anl");
                    $r=$this->num_Alumnos($m,$n,$o,$p,$anl);
                    echo $r;
                }
                elseif($m == "autocompletar_alumno"){
                    $m= $this->input->post("alu_matricula");
                    $r=$this->autocompletar_alumno($m);
                    echo $r;
                }
                elseif($m == "listado_alumnos"){
                    $j = $this->input->post("jornada");
                    $c = $this->input->post("curso");
                    $e = $this->input->post("espec");
                    $p = $this->input->post("paral");
                    $anioLect= $this->input->post("strAnioLect");
                    $indBachill=$this->input->post("indBachill");
                    $this->listado_alumnos($j,$c,$e,$p,$anioLect,$indBachill);       
                }
                elseif($m == "consultar"){    
                    $j = $this->input->post("jornada");
                    $c = $this->input->post("curso");
                    $e = $this->input->post("espec");
                    $p = $this->input->post("paral");
                    $anioLect= $this->input->post("strAnioLect");
                    $indBachill=$this->input->post("indBachill");
                    $indInicio = $this->input->post("indInicio");
                    $this->consultar_alumnos($j,$c,$e,$p,$anioLect,$indBachill,$indInicio);
                }
                else{    
                     $this->nuevoAlumno(); 
                }
            }
            
        }
        
        
        
         /**
            * Initialize cargar_categorias
            * Esta funci�n permite obtener un array con los nombres de las categor&iaacute;s de un alumno 
            * @access public
            * @return array
         */ 
        function cargar_categorias()
        {
            $info=array();
            $rs=$this->alumno->cargar_categorias();
            foreach ($rs->result() as $fila){
                $info[$fila->cat_id] = $fila->cat_nombre;
            }
            return $info;
        }
        
            /**
            * Initialize nuevoAlumno
            * Esta funci�n permite cargar la vista de registro de un alumno, cargando por ende
            * las categor&iacute;s y las jornadas 
            * @access public
            * @return void
            */  
        function nuevoAlumno(){    
            $data["categoria_alumno"]= $this->cargar_categorias(); 
            $data["jornada"]= $this->cargar_jornadas();
            $data["anLects"] = $this->cargar_anios_registro();
            $data["matricula"] = $this->alumno->num_matricula();
            $this->load->view("alumno/view_registro",$data);       
        }
        
        
        
            /**
            * Initialize num_Alumnos
            * Esta funci�n permite recorrer el array devuelto de la consulta realizada que retorna el n�mero de alumnos
            * de acuerdo a los par�metros enviados
            * @access public
            * @param integer $jornada: id de la jornada
            * @param integer $curso: id del curso
            * @param integer $espec: id de la especializaci�n
            * @param integer $paral: id del paralelo
            * @param string $anioLect: a�o lectivo
            * @return integer
            */  
        function num_Alumnos($jornada,$curso,$espec,$paral,$anl){
                
            $rs=$this->general->curso_Paralelo($jornada,$curso,$espec,$paral);
            
            $strCpId="";      
            foreach($rs->result() as $row){
                $strCpId .="".$row->cp_id."";
            }
            $cpId = $strCpId;
            
            if($anl==0||$anl==null)
                $anl = $this->get_idAnioLect(date('Y'));
            
            $numAlumnos=$this->alumno->numAlumnos($cpId,$anl);
             
            return $numAlumnos;
        }
        
        
        
         /**
            * Initialize autocompletar_alumno
            * Esta funci�n realiza la b�squeda de los datos personales de cada alumno y los devuelve en uan cadena concatenada 
            * @access public
            * @param integer $idAlumno: id de la jornada
            * @return string
            */  
        function autocompletar_alumno($idAlumno){
            
            $rs=$this->alumno->obtener_alumnoRepresentante($idAlumno);
            
            $info="";

            foreach($rs->result() as $row){
                $info .="".$row->alu_documentacion."_".
                            $row->alu_nombres."_".
                            $row->alu_apellidos."_".
                            $row->alu_categoria_alumno_id."_".
                            $row->alu_domicilio."_".
                            $row->alu_telefono."_".
                            $row->alu_pais."_".
                            $row->alu_lugar_nacimiento."_".
                            $row->alu_fecha_nacimiento."_".
                            $row->alu_edad."_".
                            $row->alu_sexo."_".
                            $row->alu_madre_nombres."_".
                            $row->alu_madre_ocupacion."_".
                            $row->alu_madre_pais."_".
                            $row->alu_padre_nombres."_".
                            $row->alu_padre_ocupacion."_".
                            $row->alu_padre_pais."_".
                            $row->alu_principal_representante."_".
                            $row->alu_comentarios."_".
                            $row->alu_representante_id."_".
                            $row->alu_curso_paralelo_id."_".
                            $row->rep_nombres."_".
                            $row->rep_ocupacion."_".
                            $row->rep_telefono."_".
                            $row->rep_domicilio."_".
                            $row->rep_pais."_".
                            $row->alu_matricula.""
                ;
                break;     
            }
            
            return $info;
        }
        
        
        
        function listado_alumnos($j,$c,$e,$p,$anioLect,$indBachill)
        {
            $idAnioLect = $this->get_idAnioLect($anioLect);
            $crud = new grocery_CRUD();
            $crud->set_subject('Alumnos');  
            $crud->set_theme('datatables');
              
            $crud->set_table('alumno');
                        
            $crud->set_relation('alu_curso_paralelo_id','curso_paralelo','cp_id');
            $crud->set_relation('alu_representante_id','representante','rep_id');
            $crud->set_model('alumRepres_join');
            
            $crud->columns('alu_nombres','alu_apellidos');
            //$crud->columns('alu_nombres','alu_apellidos','alu_domicilio','alu_telefono','rep_nombres','rep_apellidos');
            
            $crud->where('cp_jornada_id',$j);
            $crud->where('cp_curso_id',$c);
                if($indBachill==1)
                {
                    $crud->where('cp_especializacion_id',$e);
                }
            $crud->where('cp_paralelo_id',$p);
            $crud->where('alu_ano_lectivo_id',$idAnioLect);
            
             
            $crud->display_as('alu_nombres','Nombres del Alumno');
            $crud->display_as('alu_apellidos','Apellidos del Alumno');
            //$crud->order_by('alu_apellidos','desc'); 
            $crud->unset_operations();
            
            $output = $crud->render();
            
            $output->categoria_alumno= $this->cargar_categorias();
            $output->jornada=$this->cargar_jornadas();  
            $this->load->view('view_cruds.php',$output);      
        }
        
        
         /**
            * Initialize validarAlumno
            * Esta funci�n valida que si otra persona ser� el representante del alumno, estos datos se conviertan en 
            * campos obligatorios , por el contrario si no existe ning�n problema guardar� dicho alumno
            * @access public
            * @return integer
            */  
        function validarAlumno(){
            $opcRepresent=$this->input->post("rbRepresent");
            $nombOtraPers = $this->input->post("txtNombPerson");
            $domOtraPers = $this->input->post("txtDomicilioPerson");
            $telefOtraPers = $this->input->post("txtTelefPerson");
            $ocupOtraPers = $this->input->post("txtOcupPerson");
            
            $longNombOtraPers=strlen($telefOtraPers);
            $longDomOtraPers=strlen($telefOtraPers);
            $longTelefOtraPers=strlen($telefOtraPers);
            $longOcupOtraPers=strlen($telefOtraPers);
   
            if(($opcRepresent=="o")&&(($longNombOtraPers==0)||($longNombOtraPers>51)||($longDomOtraPers==0)||($longDomOtraPers>100)||($longTelefOtraPers==0)||($longTelefOtraPers>10)||($longOcupOtraPers>30)))
            {
                echo 3; 
            }
            else
            {
                $inforInsertAlu=$this->guardar_Alumno();
                echo $inforInsertAlu; 
            }
  
        }
        
        
        /**
            * Initialize guardarRepresentante
            * Esta funci�n registra un representante en caso de no estar a�n registrado y retorna el id de dicho representante
            * ya sea el que se ha ingresado o el  id del represnetante que ya constaba en la base
            * @access public
            * @param string $opcRepresent: opci�n del representante del alumno, mam�, pap� u otra persona
            * @return integer
            */
        function guardarRepresentante($opcRepresent)
        {
                if($opcRepresent=="m")
                {
                    $dataRepresentante = array(
                                                "rep_nombres"=>$this->input->post("txtNombMadre"),
                                                "rep_ocupacion"=>$this->input->post("txtOcupMadre"),
                                                "rep_telefono"=>$this->input->post("txtTelef"),
                                                "rep_domicilio"=>$this->input->post("txtDomicilio"),
                                                //"rep_celular"=>$this->input->post("txtTelef"),
                                                "rep_pais"=>$this->input->post("cmbPaisMadre")

                                                );
                                                    
                        $dataExisteRepres= array(
                                                    "rep_nombres"=>$this->input->post("txtNombMadre"),

                                                 );
                }
                                            
                elseif($opcRepresent=="p")
                {
                        $dataRepresentante = array(
                                                                "rep_nombres"=>$this->input->post("txtNombPadre"),
                                                                "rep_ocupacion"=>$this->input->post("txtOcupPadre"),
                                                                "rep_telefono"=>$this->input->post("txtTelef"),
                                                                "rep_domicilio"=>$this->input->post("txtDomicilio"),
                                                                //"rep_celular"=>$this->input->post("txtTelef"),
                                                                "rep_pais"=>$this->input->post("cmbPaisPadre")
                                                    
                                                    );
                                                    
                        $dataExisteRepres= array(
                                                                "rep_nombres"=>$this->input->post("txtNombPadre")
                                                    );
                }
                                            
                else
                {
                        $dataRepresentante = array(
                                                            "rep_nombres"=>$this->input->post("txtNombPerson"),
                                                            "rep_ocupacion"=>$this->input->post("txtOcupPerson"),
                                                            "rep_telefono"=>$this->input->post("txtTelefPerson"),
                                                            "rep_domicilio"=>$this->input->post("txtDomicilioPerson"),
                                                            
                                                            "rep_pais"=>$this->input->post("cmbPaisPerson")
                                                
                                                );
                                                
                        $dataExisteRepres= array(
                                                            "rep_nombres"=>$this->input->post("txtNombPerson"),
                                                );
                }
                
                 $numResultRepres=$this->alumno->buscarRepres($dataRepresentante);

                 if($numResultRepres==0)
                 {
                        $this->alumno->guardarRepresentante($dataRepresentante);
                 }
  
                 $strRepId="";
                 $rs1=$this->alumno->obtenerRepres($dataRepresentante);
                                            
                 foreach($rs1->result() as $row){
                    $strRepId .="".$row->rep_id."";
                 }
                 
                 $repId = (int)$strRepId;
                 
                 return $repId;
                
        }
        
        
        /**
            * Initialize guardar_Alumno
            * Esta funci�n registra un alumno en caso de no estar a�n registrado en el curso en que se desea matricular,
            * o que no se encuentre registrado en otro curso y que a�n no se haya superado el l�mite de estudiantes en un 
            * curso, retornando un entero que nos indica que caso se cumpli�
            * @access public
            * @return integer
        */
        
        function guardar_Alumno()
        {
            $infoInsertAlu="";
            
            $matricula=$this->input->post("txtMatricula");
            $AnioId=$this->input->post("cmbAnioLectivo");
            $jornada=$this->input->post("cmbJornada");
            $curso=$this->input->post("cmbCurso");
            $especializacion=$this->input->post("cmbEspec");
            $paralelo=$this->input->post("cmbParalelo");
            
            //Encontrar alu_curso_paralelo_id
            $cpId=$this->encontrarIdCursoParalelo($jornada,$curso,$especializacion,$paralelo); 
                
            $nombAlumn=$this->input->post("txtNombres");
            $apellAlumn=$this->input->post("txtApellidos");            
 
            $numAlumnosRepet=$this->alumno->numAlumnosRepetCurso($cpId,$matricula,$AnioId);
            
            if($numAlumnosRepet>0)
            {
                //$infoInsertAlu.="Este Alumno ya est&aacute; registrado en este curso";
                $infoInsertAlu=0;
            }   
            else
            { 
                 $numAlumnosRepetOtroCurso=$this->alumno->numAlumnosRepetOtroCurso($cpId,$matricula,$AnioId);
                   
                 //$numAlumnosRepetOtroCurso>0 se encuentra en otro curso
                 if($numAlumnosRepetOtroCurso>0)
                 {
                       $infoInsertAlu=1; 
                 }  
                 else
                 {
                        $opcRepresent=$this->input->post("rbRepresent");
                        $repId=$this->guardarRepresentante($opcRepresent);
                          
                        
                        $domicilio=$this->input->post("txtDomicilio");
                        $telef=$this->input->post("txtTelef");
                        $pais=$this->input->post("cmbPais");
                        $lugarNac=$this->input->post("txtLugarNac");
                        
                        $txtFecha=$this->input->post("dateArrival");
                        $objetoFecha = DateTime::createFromFormat("d/m/Y", $txtFecha );
                        $mifecha = $objetoFecha ->format("Y-m-d"); 
                        
                        $rbSexo=$this->input->post("rbSexo");
                        $edad=$this->input->post("txtEdad");
                        $nombMadre=$this->input->post("txtNombMadre");
                        $ocupMadre=$this->input->post("txtOcupMadre");
                        $paisMadre=$this->input->post("cmbPaisMadre");
                        $nombPadre=$this->input->post("txtNombPadre");
                        $ocupPadre=$this->input->post("txtOcupPadre");
                        $paisPadre=$this->input->post("cmbPaisPadre");
                        $rbRepresent=$this->input->post("rbRepresent");
                        $check = $this->input->post('chkDocument',TRUE)==null ? 0 : 1;
                        $comentarios=$this->input->post("txtComentarios");
                        $categoria=$this->input->post("cmbCategoria");
                                                                       
                        $this->alumno->guardar_Alumno($matricula,$nombAlumn,$apellAlumn,$domicilio,$telef,$pais,$lugarNac,$mifecha,$rbSexo,$edad,$nombMadre,$ocupMadre,$paisMadre,$nombPadre,$ocupPadre,$paisPadre,$rbRepresent,$check,$comentarios,$categoria,$repId,$cpId,$AnioId);

                        //$infoInsertAlu.="Los datos han sido guardados con &eacute;xito";
                        $infoInsertAlu=2;
                 }    
                
            }
            
            return $infoInsertAlu;
        }
        

        /**
            * Initialize alpha_space_tildes
            * Funci�n que valida que un string solo contenga letras del alfabeto y espacios 
            * @access public
            * @param string $str: cadena a ser analizada
            * @return boolean
        */
        function alpha_space_tildes($str)
        {
            
            $str1=utf8_decode(stripcslashes($str)); 
            if (! preg_match("/^[a-zA-Z\ \xf1\xd1\xe1\xe9\xed\xf3\xfa\xc1\xc9\xcd\xd3\xda\xfc\xdc]+$/", $str1))
            {
                $this->form_validation->set_message('alpha_space_tildes', 'El campo %s solo debe contener caracteres del alfabeto');
                return FALSE;
            }
            else
            {
                return TRUE;
            }
           
        }
                                 
         /**
            * Initialize consultar_alumnos
            * A trav�s de esta funci�n se podr� obtener los resultados de las respectivas consultas de alumnos
            * de acuerdo a la jornada,curso,especializaci�n y a�o lectivo
            * @access public
            * @param integer $j: id de la jornada
            * @param integer $c: id del curso
            * @param integer $e: id de la especializaci�n
            * @param integer $p: id del paralelo
            * @param string $anioLect
            * @param integer $indBachill: nos indica si la consulta de alumnos es de 2do. o 3ero. de bachillerato
            * @param integer $indInicio: 0 si a�n no s eha realizado ninguna consulta y 1 si se ha procedido ha 
            *                           realizar alguna consulta
            * @return void
            */
        function consultar_alumnos($j,$c,$e,$p,$anioLect,$indBachill,$indInicio)
        {
            $idAnioLect = $this->get_idAnioLect($anioLect);

            $crud = new grocery_CRUD();
            $crud->set_subject('Alumnos');  
            $crud->set_theme('datatables');
              
            $crud->set_table('alumno');
            $crud->set_relation('alu_curso_paralelo_id','curso_paralelo','cp_id');
            $crud->set_relation('alu_categoria_alumno_id','categoria_alumno','cat_nombre');
      
            $crud->set_relation('alu_representante_id','representante','rep_id');
       
            $crud->set_model('alumRepres_join');
      
            $crud->columns('alu_nombres','alu_apellidos','alu_domicilio','alu_telefono','rep_nombres','rep_telefono');
                
            $crud->where('cp_jornada_id',$j);
            $crud->where('cp_curso_id',$c);
                if($indBachill==1)
                {
                    $crud->where('cp_especializacion_id',$e);
                }
            $crud->where('cp_paralelo_id',$p);
            $crud->where('alu_ano_lectivo_id',$idAnioLect);
             
            $crud->display_as('alu_nombres','Nombres del Alumno');
            $crud->set_rules('alu_nombres','Nombres del Alumno','required|max_length[25]|callback_alpha_space_tildes');
           
            $crud->display_as('alu_apellidos','Apellidos del Alumno');
            $crud->set_rules('alu_apellidos','Apellidos del Alumno','required|max_length[25]|callback_alpha_space_tildes');
           
            $crud->display_as('alu_domicilio','Domicilio');
            $crud->change_field_type('alu_domicilio', 'string');
            $crud->set_rules('alu_domicilio','Domicilio','required|max_length[50]');
           
            $crud->display_as('alu_telefono','Telefono');
            $crud->set_rules('alu_telefono','tel&eacute;fono','required|max_length[10]|integer');
            
            $crud->display_as('alu_pais','Pa&iacute;s');
            $crud->set_rules('alu_pais','Pa&iacute;s','required');            
            //$crud->callback_edit_field('alu_pais',array($this,'edit_field_callback_Pais'));
            $crud->set_rules('alu_fecha_nacimiento','Fecha de nacimiento','required');            
            
            $crud->display_as('alu_lugar_nacimiento','Lugar de nacimiento');
            $crud->set_rules('alu_lugar_nacimiento','Lugar de nacimiento','required|max_length[25]|callback_alpha_space_tildes');            
                        
                        
            $crud->display_as('alu_edad','Edad');
            $crud->set_rules('alu_edad','edad','required||max_length[2]|is_natural_no_zero');
          
            $crud->display_as('alu_fecha_nacimiento','Fecha de nacimiento');
            $crud->set_rules('alu_fecha_nacimiento','Fecha de nacimiento','required');
                      
            $crud->display_as('alu_sexo','Sexo');
            $crud->callback_edit_field('alu_sexo',array($this,'edit_field_callback_Sexo'));
            
            $crud->display_as('alu_principal_representante','Representante');
            $crud->callback_edit_field('alu_principal_representante',array($this,'edit_field_callback_Represent'));
            
            
            $crud->display_as('alu_comentarios','Comentarios');
            $crud->change_field_type('alu_comentarios', 'string');            
            
            $crud->display_as('alu_madre_nombres','Nombres de la madre');
            $crud->set_rules('alu_madre_nombres','Nombres de la madre','required|max_length[40]|callback_alpha_space_tildes');
                                 
            $crud->display_as('alu_madre_ocupacion','Ocupaci&oacute;n de la madre');
            $crud->set_rules('alu_madre_ocupacion','Ocupaci&oacute;n de la madre','max_length[25]|callback_alpha_space_tildes');
                      
            $crud->display_as('alu_madre_pais','Pa&iacute;s de la madre');
            $crud->set_rules('alu_madre_pais','Pa&iacute;s de la madre','required');
          
            $crud->display_as('alu_padre_nombres','Nombres del padre');
            $crud->set_rules('alu_padre_nombres','Nombres de padre','required|max_length[40]|callback_alpha_space_tildes');
                                  
            $crud->display_as('alu_padre_ocupacion','Ocupaci&oacute;n del padre');
            $crud->set_rules('alu_padre_ocupacion','Ocupaci&oacute;n del padre','max_length[25]|callback_alpha_space_tildes');
                      
            $crud->display_as('alu_padre_pais','Pa&iacute;s del padre');
            $crud->set_rules('alu_padre_pais','Pa&iacute;s del padre','required');
          
            $crud->display_as('alu_documentacion','Con Documentaci&oacute;n');
            $crud->callback_edit_field('alu_documentacion',array($this,'edit_field_callback_Doc'));
    
            $crud->display_as('alu_representante_id','Datos del Representante');
            $crud->callback_edit_field('alu_representante_id',array($this,'edit_field_callback_DatosRepresent'));
               
            $crud->display_as('alu_categoria_alumno_id','Categor&iacute;a del alumno');
            
            $crud->display_as('alu_curso_paralelo_id','Curso Paralelo');
            $crud->callback_edit_field('alu_curso_paralelo_id',array($this,'edit_field_callback_CursoParalelo'));
            
            $crud->display_as('alu_ano_lectivo_id','A&ntilde;o Lectivo');
            $crud->callback_edit_field('alu_ano_lectivo_id',array($this,'edit_field_callback_AnoLectivo'));

            
            $crud->callback_before_update(array($this,'update_before_callback'));
 
            $crud->unset_add(); 
            //$crud->unset_delete();  
            //$crud->add_action('Retirado', '', 'ui-icon-image',array($this,'alumno_Retirado'));         
            $output = $crud->render();
             
            if($indInicio == 0)
            {
                
             $output->anio_lectivo= $this->cargar_aniosLectivos();
             $output->jornada=$this->cargar_jornadas(); 
             $output->menu=$this->load->view("view_menu_administrador");
                
                $this->load->view('alumno/view_consulta',$output);
                //$this->load->view('view_ajax_listado_alumnos',$output);
            }else
            
            {
                
                $this->load->view('view_ajax_listado_alumnos',$output);
            }
            //$this->_view_crud($output);        
        }
        
        function cambiar_EstadoARetirado($post_array,$primary_key,$row)
        {
                $this->alumno->update_EstadoARetirado($primary_key);
                return $post_array;
        }
       

        /**
            * Initialize edit_field_callback_DatosRepresent
            * Callback que ser� ejecutado al editar un alumno
            * para modificar el formulario mostrado por grocery crud en la opci�n 
            * curso paralelo
            * @access public
            * @param integer $value: id del curso_paralelo
            * @param array $primary_key: id del Alumno que fue seleccionado para ser modificado
            * @return string
        */ 
        function  edit_field_callback_DatosRepresent($value, $primary_key)
        { 
             $strIdRepres="";
             $rsAlumno = $this->alumno->obtener_alumno($primary_key);
                
                foreach($rsAlumno->result() as $row){
                            $opcRepres .="".$row->alu_principal_representante."";
                }
                
             
                 if(($opcRepres=="m")||($opcRepres=="p"))
                 {
                  
                        $info .="<br /><br />Nombres del Representante  <input type='text' id='txtNombPerson' name='txtNombPerson' value='' /><br /><br />"
                               ."Ocupaci&oacute;n  <input type='text' id='txtOcupPerson' name='txtOcupPerson' value='' /><br /><br />"
                               ."Direcci&oacute;n  <input type='text' id='txtDomicilioPerson' name='txtDomicilioPerson' value='' /><br /><br />"
                               ."Tel&eacute;fono  <input type='text' id='txtTelefPerson' name='txtTelefPerson' value='' /><br /><br />"
                               ."Pa&iacute;s  <input type='text' id='cmbPaisPerson' name='cmbPaisPerson' value='' /><br /><br />";
                    
                 }
                else
                 {
                        $rs = $this->alumno->obtener_representante($value);
                        
                        foreach($rs->result() as $row)
                        {
                        $info .="Nombres del Representante  <input type='text' id='txtNombPerson' name='txtNombPerson' value='".$row->rep_nombres."' /><br /><br />"
                               ."Ocupaci&oacute;n  <input type='text' id='txtOcupPerson' name='txtOcupPerson' value='".$row->rep_ocupacion."' /><br /><br />"
                               ."Direcci&oacute;n  <input type='text' id='txtDomicilioPerson' name='txtDomicilioPerson' value='".$row->rep_domicilio."' /><br /><br />"
                               ."Tel&eacute;fono  <input type='text' id='txtTelefPerson' name='txtTelefPerson' value='".$row->rep_telefono."' /><br /><br />"
                               ."Pa&iacute;s  <input type='text' id='cmbPaisPerson' name='cmbPaisPerson' value='".$row->rep_pais."' /><br /><br />";
                        }
                   
                   
                   
                 }
             
             
            return $info;
        
        }
       
       /**
            * Initialize edit_field_callback_CursoParalelo
            * Callback que ser� ejecutado al editar un alumno
            * para modificar el formulario mostrado por grocery crud en la opci�n 
            * curso paralelo
            * @access public
            * @param array $post_array: array de variables pasadas a traves del m�todo HTTP POST
            * @param integer $value: id del curso_paralelo
            * @return string
        */ 
        function edit_field_callback_CursoParalelo($value, $primary_key)
        {
                $info="";
                $opcRepres="";
                
                $strIdJornada="";
                $strIdCurso="";
                $strIdEspec="";
                $strIdPar="";
                
                $rsCurPar = $this->general->obtener_CursoParalelo($value);
   
                    foreach($rsCurPar->result() as $row){
                                $strIdJornada .="".$row->cp_jornada_id."";
                                $strIdCurso .="".$row->cp_curso_id."";
                                $strIdEspec .="".$row->cp_especializacion_id."";
                                $strIdPar .="".$row->cp_paralelo_id.""; 
                                
                    }
                
                $idJornada = (int)$strIdJornada;
                $idCurso = (int)$strIdCurso;
                $idEspec = (int)$strIdEspec;
                $idPar = (int)$strIdPar;
                
              
                $rsJornada =$this->general->cargar_jornadas();                
                $info .="Jornada: <select id='cmbJornadaEdit' name='cmbJornadaEdit' onchange='funcCmbJornadaEdit()'>";
                    foreach($rsJornada->result() as $row)
                    {
                        if(($row->jor_id)==$idJornada)
                        {
                            $info .="<option selected='selected' value='".$row->jor_id."'>".$row->jor_nombre."</option>";
                        }
                        else
                        {
                            $info .="<option value='".$row->jor_id."'>".$row->jor_nombre."</option>";
                        }
                              
                              
                    }   
                $info .="</select>";
                
                
                $rsCurso =$this->general->cargar_cursosEdit($idJornada);  
                $info .="Curso: <select id='cmbCursoEdit' name='cmbCursoEdit' onchange='funcCmbCursoEdit()' >";
                foreach($rsCurso->result() as $row)
                {
                    if(($row->cur_id)==$idCurso)
                    {
                        $info .="<option selected='selected' value='".$row->cur_id."'>".$row->cur_nombre."</option>";
                    }
                    else
                    {
                        $info .="<option value='".$row->cur_id."'>".$row->cur_nombre."</option>";
                    }    
                }  
                $info .="</select>";
                           
    
                
                $rsEspec=$this->general->cargar_especializaciones($idJornada,$idCurso);
                $info .="Especializaci&oacute;n: <select id='cmbEspecEdit' name='cmbEspecEdit' onchange='funcCmbEspecEdit()' >";
                foreach($rsEspec->result() as $row)
                {
                    if(($row->esp_id)==$idEspec)
                    {
                        $info .="<option selected='selected' value='".$row->esp_id."'>".$row->esp_nombre."</option>";
                    }
                    else
                    {
                        $info .="<option value='".$row->esp_id."'>".$row->esp_nombre."</option>";
                    }
                }  
                $info .="</select>";
               
               
           
                if(($idCurso==12)||($idCurso==13))
                {
                     $rsPar=$this->general->cargar_paralBachill($idJornada,$idCurso,$idEspec);
                }
                else
                {
                     $rsPar=$this->general->cargar_paralelos($idJornada,$idCurso);
                }
                 
                $info .="Paralelo: <select id='cmbParalEdit' name='cmbParalEdit' >";
                foreach($rsPar->result() as $row)
                {
                    if(($row->par_id)==$idPar)
                    {
                        $info .="<option selected='selected' value='".$row->par_id."'>".$row->par_nombre."</option>";
                    }
                    else
                    {
                        $info .="<option value='".$row->par_id."'>".$row->par_nombre."</option>";
                    }
                       
                }  
                $info .="</select>";
                
                
           return $info;
                
                
            
        }
        
        /**
            * Initialize edit_field_callback_AnoLectivo
            * Callback que ser� ejecutado al editar un alumno
            * para modificar el formulario mostrado por grocery crud en la opci�n 
            * a�o lectivo
            * @access public
            * @return string
        */ 
        function edit_field_callback_AnoLectivo()
        {
            $info="";
           
            $rsAnioLectivo = $this->general->cargar_aniosLectivos();
               
            $info .="<select id='alu_ano_lectivo_id' name='alu_ano_lectivo_id' >";
            foreach($rsAnioLectivo->result() as $row)
            {
                if(($row->anl_id)==$id_anioLectivo)
                {
                    $info .="<option selected='selected' value='".$row->anl_id."'>".$row->anl_periodo." - ".(($row->anl_periodo)+1)."</option>";
                }
                else
                {
                    $info .="<option value='".$row->anl_id."'>".$row->anl_periodo." - ".(($row->anl_periodo)+1)."</option>";
                }
                      
                      
            }   
            $info .="</select>";
            
            return $info;
            
        }
        
        
        
        function edit_field_callback_Pais($value, $primary_key)
        {
            //))return '+30 <input type="text" maxlength="50" value="'.$value.'" name="phone" style="width:462px">';
        
             return country_dropdown('cmbPais','cmbPais',
                            array('US','CA','GB','DE','BR','IT','ES','AU','NZ','HK'));
        
        }
        
        /**
            * Initialize edit_field_callback_Sexo
            * Callback que ser� ejecutado al editar un alumno
            * para modificar el formulario mostrado por grocery crud en la opci�n 
            * sexo del alumno
            * @access public
            * @return string
        */
        function edit_field_callback_Sexo()
        {
            if($value=="M")
            {
                return ' <input type="radio" name="alu_sexo" value="M" checked="checked" />Masculino <br />
                         <input type="radio" name="alu_sexo" value="F"/>Femenino';
            }
            else
            {
                return ' <input type="radio" name="alu_sexo" value="M"   />Masculino <br />
                         <input type="radio" name="alu_sexo" value="F" checked="checked" />Femenino';
            }
            
        
        }
        
        
        
        /**
            * Initialize edit_field_callback_Doc
            * Callback que ser� ejecutado al editar un alumno
            * para modificar el formulario mostrado por grocery crud en la opci�n 
            * documentaci�n
            * @access public
            * @param string $value: valor de alu_documentacion, 0 si es que el alumno no ha entregado toda la documentaci�n
            *                                                   1 si es que si la tiene completa
            * @return string
        */ 
        function edit_field_callback_Doc($value, $primary_key)
        {
            if($value==0)
            {
                return '<input type="checkbox" name="alu_documentacion" value="0" />';
            }
            else
            {
                return '<input type="checkbox" name="alu_documentacion" value="1" checked="checked" />';
            }
            
        
        }
        
        
        
        /**
            * Initialize edit_field_callback_Represent
            * Callback que ser� ejecutado al editar un alumno
            * para modificar el formulario mostrado por grocery crud en la opci�n 
            * Datos del representante
            * @access public    
            * @return string
        */ 
        function edit_field_callback_Represent()
        {
            if($value=="m")
            {
                return ' <input type="radio" id="rbRepresentM" name="alu_principal_representante" value="m" checked="checked" onclick="toggle_otra_persona(this)" />Madre <br />
                         <input type="radio" id="rbRepresentP" name="alu_principal_representante" value="p" onclick="toggle_otra_persona(this)"/>Padre <br />
                         <input type="radio" id="rbRepresentO" name="alu_principal_representante" value="o" onclick="toggle_otra_persona(this)"/>Otra persona ';
            }
            elseif($value=="p")
            {
                return ' <input type="radio" id="rbRepresentM" name="alu_principal_representante" value="m" onclick="toggle_otra_persona(this)"/>Madre <br />
                         <input type="radio" id="rbRepresentP" name="alu_principal_representante" value="p" checked="checked" onclick="toggle_otra_persona(this)" />Padre <br />
                         <input type="radio" id="rbRepresentO" name="alu_principal_representante" value="o" onclick="toggle_otra_persona(this)"/>Otra persona ';
            }
            elseif($value=="o")
            {
                return ' <input type="radio" id="rbRepresentM" name="alu_principal_representante" value="m" onclick="toggle_otra_persona(this)"/>Madre <br />
                         <input type="radio" id="rbRepresentP" name="alu_principal_representante" value="p" onclick="toggle_otra_persona(this)"/>Padre <br />
                         <input type="radio" id="rbRepresentO" name="alu_principal_representante" value="o" checked="checked" onclick="toggle_otra_persona(this)" />Otra persona ';
            }
            
        
        }
        
        
        /**
            * Initialize actualizar_DatosRepresentante
            * Funci�n que actualiza los datos del representante de determinado alumno
            * @access public
            * @param array $post_array: array de variables pasadas a traves del m�todo HTTP POST
            * @param integer $pk_alumno: id del alumno
            * @return array
        */
        
        function actualizar_DatosRepresentante($post_array,$pk_alumno)
        {
                $opcRepres=$post_array['alu_principal_representante'];
            
                if($opcRepres=="m")
                {
                    $nomb_rep=$post_array['alu_madre_nombres'];
                    $ocup_rep=$post_array['alu_madre_ocupacion'];
                    $dom_rep=$post_array['alu_domicilio'];
                    $tel_rep=$post_array['alu_telefono'];
                    $pais_rep=$post_array['alu_madre_pais'];
                    
                }
                elseif($opcRepres=="p")
                {
                    $nomb_rep=$post_array['alu_padre_nombres'];
                    $ocup_rep=$post_array['alu_padre_ocupacion'];
                    $dom_rep=$post_array['alu_domicilio'];
                    $tel_rep=$post_array['alu_telefono'];
                    $pais_rep=$post_array['alu_padre_pais'];
                    
                }
                
                elseif($opcRepres=="o")
                {
                    $nomb_rep=$post_array['txtNombPerson'];
                    $ocup_rep=$post_array['txtOcupPerson'];
                    $dom_rep=$post_array['txtDomicilioPerson'];
                    $tel_rep=$post_array['txtTelefPerson'];
                    $pais_rep=$post_array['cmbPaisPerson'];
                    
                }
                    
            $strIdRepres="";
            $rsAlumno=$this->alumno->obtener_alumno($pk_alumno);
            foreach($rsAlumno->result() as $row){
                            $strIdRepres .="".$row->alu_representante_id."";
                }
            $idRepres = (int)$strIdRepres;
            $this->alumno->actualizar_representante($idRepres,$nomb_rep, $ocup_rep, $dom_rep, $tel_rep, $pais_rep);
        
        }
        
        /**
            * Initialize actualizar_CursoParaleloDoc
            * Funci�n que actualiza el curso y docuemntaci�n de un alumno
            * @access public
            * @param array $post_array: array de variables pasadas a traves del m�todo HTTP POST
            * @param integer $pk_alumno: id del alumno
            * @return array
        */
        function actualizar_CursoParaleloDoc($post_array, $pk_alumno) {
            
            $jornada=$post_array['cmbJornadaEdit'];
            $curso=$post_array['cmbCursoEdit'];
            if(($curso!=12)&&($curso!=13))
            {
                $espec=-1;
            }
            else
            {
                $espec=$post_array['cmbEspecEdit'];
                            
            }            
            
            $paral=$post_array['cmbParalEdit'];
            $documentacion=$post_array['alu_documentacion'];
           
            $strIdCursParal="";
            $rsCursParal=$this->general->curso_Paralelo($jornada,$curso,$espec,$paral);
                foreach($rsCursParal->result() as $row){
                            $strIdCursParal .="".$row->cp_id."";
                }
            $idCursParal = (int)$strIdCursParal;
            
            if($documentacion)
            {
                $alu_documentacion=1;
            }
            else
            {
                $alu_documentacion=0;
            }

            $this->alumno->actualizar_curso_paralelo_doc_Alumno($pkAlumno,$idCursParal, $alu_documentacion);

        }
        
        
        /**
            * Initialize update_before_callback
            * Funci�n que actualiza los datos de un alumno antes de que se ejecute la funci�n de 
            * actualizaci�n de groocery crud
            * @access public
            * @param array $post_array: array de variables pasadas a traves del m�todo HTTP POST
            * @param integer $primary_key: id del alumno
            * @return array
        */
        
        function  update_before_callback($post_array, $primary_key) {
            
            $this->actualizar_DatosRepresentante($post_array,$primary_key);

            $this->actualizar_CursoParaleloDoc($post_array, $primary_key); 

            return $post_array;
        }
        
        
    }
?>
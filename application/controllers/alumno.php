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
    class alumno extends CI_Controller {
        
        function __construct(){
            parent::__construct();
            $this->load->library('grocery_CRUD');
            $this->load->model("mod_alumno","alumno");
            $this->load->model("mod_general","general");
            $this->load->helper("country_helper");
            $this->load->helper("form");
        }
        
        function datosRepetidos(){
            $rs=$this->alumno->datosRepetidos();
            echo $rs;
        }
       
        function cargar_categorias(){
            if(!$this->clslogin->check()) redirect(site_url("login"));
            
            $info=array();
            $rs=$this->alumno->cargar_categorias();
            foreach ($rs->result() as $fila){
                $info[$fila->cat_id] = $fila->cat_nombre;
            }
            return $info;
        }
        
        function nuevo(){
            if(!$this->clslogin->check()) redirect(site_url("login"));
            $funcion = $this->uri->segment(3);
            $data["link"]=base_url()."alumno/".$funcion;
            $this->load->view("view_plantilla",$data);
        }
        
        function matricular(){
            $general=new General();
            if(!$this->clslogin->check()) redirect(site_url("login"));
            $data["categoria_alumno"]= $this->cargar_categorias(); 
            $data["jornada"]= $general->cargar_jornadas();
            $data["anLects"] = $general->cargar_anios_registro();
            $this->load->view("alumno/view_registro",$data);
        }
        
        function num_Alumnos(){
            if(!$this->clslogin->check()) redirect(site_url("login"));
            $jornada= $this->input->post("jornada");
            $curso= $this->input->post("curso");
            $espec= $this->input->post("espec");
            $paral= $this->input->post("paral");
            $anl= $this->input->post("anl");
            
            $rs=$this->general->curso_Paralelo($jornada,$curso,$espec,$paral);
            
            $strCpId="";      
            foreach($rs->result() as $row) $strCpId .="".$row->cp_id."";
            $cpId = $strCpId;
            
            if($anl==0||$anl==null) $anl=$this->get_idAnioLect(date('Y'));
            
            $numAlumnos=$this->alumno->numAlumnos($cpId,$anl);
             
            echo $numAlumnos;
        }
        
        function autocompletar_alumno($m=''){
            if(!$this->clslogin->check()) redirect(site_url("login"));
            
            if($m=='') $matricula= $this->input->post("alu_matricula");
            else $matricula=$m;
            $rs=$this->alumno->obtener_alumnoRepresentante($matricula);
            
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
                            $row->rep_cedula."_".
                            $row->rep_ocupacion."_".
                            $row->rep_telefono."_".
                            $row->rep_domicilio."_".
                            $row->rep_pais."_".
                            $row->alu_matricula."_".
                            $row->alu_madre_cedula."_".
                            $row->alu_padre_cedula."_".
                            $row->alu_representante_cedula
                ;
                break;     
            }
            
            if($m=='') echo $info;
            else return $info;
        }
        
        function listado_alumnos(){
            if(!$this->clslogin->check()) redirect(site_url("login"));
            
            $j = $this->input->post("jornada");
            $c = $this->input->post("curso");
            $e = $this->input->post("espec");
            $p = $this->input->post("paral");
            $anioLect= $this->input->post("strAnioLect");
            $indBachill=$this->input->post("indBachill");
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
            if($indBachill==1) $crud->where('cp_especializacion_id',$e);
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
        
        
       function guardarRepresentante($opcRepresent){
            if(!$this->clslogin->check()) redirect(site_url("login"));
            if($opcRepresent=="m")
            {
                $dataRepresentante = array(
                                            "rep_nombres"=>utf8_encode(strtoupper($this->input->post("txtNombMadre"))),
                                            "rep_cedula"=>$this->input->post("txtCedMadre"),
                                            "rep_ocupacion"=>utf8_encode(strtoupper($this->input->post("txtOcupMadre"))),
                                            "rep_telefono"=>$this->input->post("txtTelef"),
                                            "rep_domicilio"=>utf8_encode(strtoupper($this->input->post("txtDomicilio"))),
                                            "rep_pais"=>$this->input->post("cmbPaisMadre")

                                            );

                $dataExisteRepres= array("rep_nombres"=>utf8_encode(strtoupper($this->input->post("txtNombMadre"))));
            }

            elseif($opcRepresent=="p")
            {
                    $dataRepresentante = array(
                                                "rep_nombres"=>utf8_encode(strtoupper($this->input->post("txtNombPadre"))),
                                                "rep_cedula"=>$this->input->post("txtCedPadre"),
                                                "rep_ocupacion"=>utf8_encode(strtoupper($this->input->post("txtOcupPadre"))),
                                                "rep_telefono"=>$this->input->post("txtTelef"),
                                                "rep_domicilio"=>utf8_encode(strtoupper($this->input->post("txtDomicilio"))),
                                                "rep_pais"=>$this->input->post("cmbPaisPadre")
                                                );

                    $dataExisteRepres= array("rep_nombres"=>utf8_encode(strtoupper($this->input->post("txtNombPadre"))));
            }

            else
            {
                    $dataRepresentante = array(
                                                "rep_nombres"=>utf8_encode(strtoupper($this->input->post("txtNombPerson"))),
                                                "rep_cedula"=>$this->input->post("txtCedPerson"),
                                                "rep_ocupacion"=>utf8_encode(strtoupper($this->input->post("txtOcupPerson"))),
                                                "rep_telefono"=>$this->input->post("txtTelefPerson"),
                                                "rep_domicilio"=>utf8_encode(strtoupper($this->input->post("txtDomicilioPerson"))),
                                                "rep_pais"=>$this->input->post("cmbPaisPerson")
                                            );

                    $dataExisteRepres= array("rep_nombres"=>utf8_encode(strtoupper($this->input->post("txtNombPerson"))));
            }

             $numResultRepres=$this->alumno->buscarRepres($dataRepresentante);

             if($numResultRepres==0){$this->alumno->guardarRepresentante($dataRepresentante);}

             $strRepId="";
             $rs1=$this->alumno->obtenerRepres($dataRepresentante);

             foreach($rs1->result() as $row){
                $strRepId .="".$row->rep_id."";
             }

             return $strRepId;
        }
        
        function guardar(){
            if(!$this->clslogin->check()) redirect(site_url("login"));
            $general=new General();
            $keys= array_keys($_POST);
            for($i=0; $i<count($keys); $i++):       $$keys[$i]= trim($_POST[$keys[$i]]);
            endfor;
            
            if($cmbCurso<12&&$cmbCurso!==13){$cmbEspec=0;}
            $cpId=$general->encontrarIdCursoParalelo($cmbJornada,$cmbCurso,$cmbEspec,$cmbParalelo);
            $repId=$this->guardarRepresentante($rbRepresent);
            $alu=$this->alumno->guardar_Alumno($_POST,$cpId,$repId);
            
            $this->load->library('export_pdf');
            $curso = $general->get_nom_curso($cpId);
            $jornada = $general->get_nom_jornada($cmbJornada);
            $ano_lectivo = $general->get_anio_lectivo($cmbAnioLectivo);
            $alumno = $this->alumno->obtener_alumno($alu);
          
            foreach($alumno->result() as $alu){
                $datos_alu = $this->autocompletar_alumno($alu->alu_matricula);}
                
            $pdf = new export_pdf();
            $pdf->exportToPDF_Hoja_Matricula($datos_alu,$ano_lectivo,$curso,$jornada);
        }
        
        function alumnoRepetidoCurso(){
            if(!$this->clslogin->check()) redirect(site_url("login"));
            $general=new General();
            $cmbJornada=$this->input->post("jornada"); $cmbCurso=$this->input->post("curso");
            $cmbParalelo=$this->input->post("paralelo"); $cmbEspec=$this->input->post("especializacion");
            $cmbAnioLectivo=$this->input->post("anl"); $txtMatricula=$this->input->post("matricula");
            
            $cpId=$general->encontrarIdCursoParalelo($cmbJornada,$cmbCurso,$cmbEspec,$cmbParalelo);
            $data1 = array("alu_matricula"=>$txtMatricula,"alu_curso_paralelo_id"=>$cpId,
                          "alu_ano_lectivo_id"=>$cmbAnioLectivo);
            $rs1=$this->alumno->alumnoRepetCurso($data1);
            if($rs1>0){return 1;}
            
            $data = array("alu_matricula"=>$txtMatricula,"alu_ano_lectivo_id"=>$cmbAnioLectivo);
            $rs=$this->alumno->numAlumnosRepetOtroCurso($cpId,$data);
            if($rs>0){return 2;}
            
            return 0;
        }
        

        function alpha_space_tildes($str){
            if(!$this->clslogin->check()) redirect(site_url("login"));
            
            $str1=utf8_decode(stripcslashes($str)); 
            if (! preg_match("/^[a-zA-Z\ \xf1\xd1\xe1\xe9\xed\xf3\xfa\xc1\xc9\xcd\xd3\xda\xfc\xdc]+$/", $str1))
            {
                $this->form_validation->set_message('alpha_space_tildes', 'El campo %s solo debe contener caracteres del alfabeto');
                return FALSE;
            }
            else return TRUE;
        }
                                 
         function consultar(){
            if(!$this->clslogin->check()) redirect(site_url("login"));
            
            $general=new General();
            $j = $this->input->post("jornada");
            $c = $this->input->post("curso");
            $e = $this->input->post("espec");
            $p = $this->input->post("paral");
            $anioLect= $this->input->post("strAnioLect");
            $indBachill=$this->input->post("indBachill");
            $indInicio = $this->input->post("indInicio");
            $idAnioLect = $general->get_idAnioLect($anioLect);

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
            if($indBachill==1) $crud->where('cp_especializacion_id',$e);
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
            $crud->display_as('alu_madre_cedula','C&eacute; de la Madre');
            $crud->set_rules('alu_madre_cedula','C&eacute; de la Madre','required||max_length[10]|is_natural_no_zero');                     
            $crud->display_as('alu_madre_ocupacion','Ocupaci&oacute;n de la madre');
            $crud->set_rules('alu_madre_ocupacion','Ocupaci&oacute;n de la madre','max_length[25]|callback_alpha_space_tildes');
            $crud->display_as('alu_madre_pais','Pa&iacute;s de la madre');
            $crud->set_rules('alu_madre_pais','Pa&iacute;s de la madre','required');
            $crud->display_as('alu_padre_nombres','Nombres del padre');
            $crud->set_rules('alu_padre_nombres','Nombres de padre','required|max_length[40]|callback_alpha_space_tildes');
            $crud->display_as('alu_padre_cedula','C&eacute; del Padre');
            $crud->set_rules('alu_padre_cedula','C&eacute; del Padre','required||max_length[10]|is_natural_no_zero');
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
             
            if($indInicio == 0){   
             $output->anio_lectivo= $general->cargar_aniosLectivos();
             $output->jornada=$general->cargar_jornadas(); 
             $output->menu=$this->load->view("view_menu_administrador");
             $this->load->view('alumno/view_consulta',$output);
            }
            else{
                $this->load->view('view_ajax_listado_alumnos',$output);
            }      
        }
        
        function cambiar_EstadoARetirado($post_array,$primary_key,$row){
            if(!$this->clslogin->check()) redirect(site_url("login"));
            $this->alumno->update_EstadoARetirado($primary_key);
            return $post_array;
        }
       
        function  edit_field_callback_DatosRepresent($value, $primary_key){
            if(!$this->clslogin->check()) redirect(site_url("login"));
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
            else{
                $rs = $this->alumno->obtener_representante($value);

                foreach($rs->result() as $row)
                {
                $info .="Nombres del Representante  <input type='text' id='txtNombPerson' name='txtNombPerson' value='".$row->rep_nombres."' /><br /><br />"
                       ."C&eacute;dula  <input type='text' id='txtCedPerson' name='txtCedPerson' value='".$row->rep_cedula."' /><br /><br />"
                       ."Ocupaci&oacute;n  <input type='text' id='txtOcupPerson' name='txtOcupPerson' value='".$row->rep_ocupacion."' /><br /><br />"
                       ."Direcci&oacute;n  <input type='text' id='txtDomicilioPerson' name='txtDomicilioPerson' value='".$row->rep_domicilio."' /><br /><br />"
                       ."Tel&eacute;fono  <input type='text' id='txtTelefPerson' name='txtTelefPerson' value='".$row->rep_telefono."' /><br /><br />"
                       ."Pa&iacute;s  <input type='text' id='cmbPaisPerson' name='cmbPaisPerson' value='".$row->rep_pais."' /><br /><br />";
                }
            }
       return $info;
    }

    function edit_field_callback_CursoParalelo($value, $primary_key){
        if(!$this->clslogin->check()) redirect(site_url("login"));
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
        
        function edit_field_callback_AnoLectivo(){
            if(!$this->clslogin->check()) redirect(site_url("login"));
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
        
        function edit_field_callback_Pais($value, $primary_key){
            if(!$this->clslogin->check()) redirect(site_url("login"));
            return country_dropdown('cmbPais','cmbPais',
                            array('US','CA','GB','DE','BR','IT','ES','AU','NZ','HK'));
        }
        
        function edit_field_callback_Sexo(){
            if(!$this->clslogin->check()) redirect(site_url("login"));
            if($value=="M"){
                return ' <input type="radio" name="alu_sexo" value="M" checked="checked" />Masculino <br />
                         <input type="radio" name="alu_sexo" value="F"/>Femenino';
            }
            else{
                return ' <input type="radio" name="alu_sexo" value="M"   />Masculino <br />
                         <input type="radio" name="alu_sexo" value="F" checked="checked" />Femenino';
            }
        }
        
        function edit_field_callback_Doc($value, $primary_key){
            if(!$this->clslogin->check()) redirect(site_url("login"));
            if($value==0){
                return '<input type="checkbox" name="alu_documentacion" value="0" />';
            }
            else{
                return '<input type="checkbox" name="alu_documentacion" value="1" checked="checked" />';
            }
        }
        
        function edit_field_callback_Represent(){
            if(!$this->clslogin->check()) redirect(site_url("login"));
            if($value=="m"){
                return ' <input type="radio" id="rbRepresentM" name="alu_principal_representante" value="m" checked="checked" onclick="toggle_otra_persona(this)" />Madre <br />
                         <input type="radio" id="rbRepresentP" name="alu_principal_representante" value="p" onclick="toggle_otra_persona(this)"/>Padre <br />
                         <input type="radio" id="rbRepresentO" name="alu_principal_representante" value="o" onclick="toggle_otra_persona(this)"/>Otra persona ';
            }
            elseif($value=="p"){
                return ' <input type="radio" id="rbRepresentM" name="alu_principal_representante" value="m" onclick="toggle_otra_persona(this)"/>Madre <br />
                         <input type="radio" id="rbRepresentP" name="alu_principal_representante" value="p" checked="checked" onclick="toggle_otra_persona(this)" />Padre <br />
                         <input type="radio" id="rbRepresentO" name="alu_principal_representante" value="o" onclick="toggle_otra_persona(this)"/>Otra persona ';
            }
            elseif($value=="o"){
                return ' <input type="radio" id="rbRepresentM" name="alu_principal_representante" value="m" onclick="toggle_otra_persona(this)"/>Madre <br />
                         <input type="radio" id="rbRepresentP" name="alu_principal_representante" value="p" onclick="toggle_otra_persona(this)"/>Padre <br />
                         <input type="radio" id="rbRepresentO" name="alu_principal_representante" value="o" checked="checked" onclick="toggle_otra_persona(this)" />Otra persona ';
            }
        }
        
        function actualizar_DatosRepresentante($post_array,$pk_alumno){
            if(!$this->clslogin->check()) redirect(site_url("login"));
            $opcRepres=$post_array['alu_principal_representante'];

            if($opcRepres=="m"){
                $nomb_rep=$post_array['alu_madre_nombres'];
                $ced_rep=$post_array['alu_madre_cedula'];
                $ocup_rep=$post_array['alu_madre_ocupacion'];
                $dom_rep=$post_array['alu_domicilio'];
                $tel_rep=$post_array['alu_telefono'];
                $pais_rep=$post_array['alu_madre_pais'];
            }
            elseif($opcRepres=="p"){
                $nomb_rep=$post_array['alu_padre_nombres'];
                $ced_rep=$post_array['alu_padre_cedula'];
                $ocup_rep=$post_array['alu_padre_ocupacion'];
                $dom_rep=$post_array['alu_domicilio'];
                $tel_rep=$post_array['alu_telefono'];
                $pais_rep=$post_array['alu_padre_pais'];
            }
            elseif($opcRepres=="o"){
                $nomb_rep=$post_array['txtNombPerson'];
                $ced_rep=$post_array['txtCedPerson'];
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
            $this->alumno->actualizar_representante($idRepres,$nomb_rep, $ced_rep, $ocup_rep, $dom_rep, $tel_rep, $pais_rep);
        }
        
        
        function actualizar_CursoParaleloDoc($post_array, $pk_alumno) {
            if(!$this->clslogin->check()) redirect(site_url("login"));
            $jornada=$post_array['cmbJornadaEdit'];
            $curso=$post_array['cmbCursoEdit'];
            if(($curso!=12)&&($curso!=13)){
                $espec=-1;
            }
            else{
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
            
            if($documentacion){
                $alu_documentacion=1;
            }
            else{
                $alu_documentacion=0;
            }

            $this->alumno->actualizar_curso_paralelo_doc_Alumno($pkAlumno,$idCursParal, $alu_documentacion);
        }
        
        function  update_before_callback($post_array, $primary_key) {
            if(!$this->clslogin->check()) redirect(site_url("login"));
            $this->actualizar_DatosRepresentante($post_array,$primary_key);
            $this->actualizar_CursoParaleloDoc($post_array, $primary_key); 
            return $post_array;
        }
        
    }
?>
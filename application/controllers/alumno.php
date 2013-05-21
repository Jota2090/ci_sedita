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
        
        function nuevo(){
            if(!$this->clslogin->check()) redirect(site_url("login"));
            $funcion = $this->uri->segment(3);
            $data["link"]=base_url()."alumno/".$funcion;
            $this->load->view("view_plantilla",$data);
        }
        
        function matricular(){
            if(!$this->clslogin->check()){redirect(site_url("login/login2"));}
            $general=new General();
            $data["categoria_alumno"]= $this->cargar_categorias(); 
            $data["jornada"]= $general->cargar_jornadas();
            $data["anLects"] = $general->cargar_anios_registro();
            $this->load->view("alumno/view_registro",$data);
        }
        
        function consultar(){
            if(!$this->clslogin->check()){redirect(site_url("login/login2"));}
            $general=new General();
            $data["anioLect"] = $general->cargar_aniosLectivos();
            $data["anlId"] = $general->cargar_anlActual();
            $this->load->view('alumno/view_consulta',$data);
        }
        
        function editar(){
            if(!$this->clslogin->check()){redirect(site_url("login/login2"));}
            $id=$this->uri->segment(3);
            $general=new General();
            $data["categoria_alumno"]= $this->cargar_categorias(); 
            $data["jornada"]= $general->cargar_jornadas();
            $data["anLects"]=$general->cargar_aniosLectivos();
            $data["editar"]="editar";
            $data["query"]=$this->alumno->obtener_alumno($id)->row();
            $this->load->view('alumno/view_registro',$data);
        }
        
        function eliminar(){
            if(!$this->clslogin->check()){redirect(site_url("login/login2"));}
            $id=$this->uri->segment(3); $eliminar=$this->uri->segment(4);
            
            if($eliminar=="eliminar"){
                $this->alumno->eliminar_alumno($id);
                echo "<script>alert('El Alumno ha sido ELIMINADO con exito');
                         window.location.href='".base_url()."alumno/consultar/';
                       </script>";
            }else{
                echo "<script>if(!confirm('Esta seguro que desea eliminar a este alumno?')){window.history.back() }
                              else{window.location.href='".base_url()."alumno/eliminar/".$id."/eliminar';};
                      </script>";
            }
        }
        
        function reactivar(){
            if(!$this->clslogin->check()){redirect(site_url("login/login2"));}
            $id=$this->uri->segment(3); $reactivar=$this->uri->segment(4);
            
            if($reactivar=="reactivar"){
                $this->alumno->reactivar_alumno($id);
                echo "<script>alert('El Alumno ha sido REACTIVADO con exito');
                         window.location.href='".base_url()."alumno/consultar/';
                       </script>";
            }else{
                echo "<script>if(!confirm('Esta seguro que desea reactivar a este alumno?')){window.history.back() }
                              else{window.location.href='".base_url()."alumno/reactivar/".$id."/reactivar';};
                      </script>";
            }
        }
        
        function datosRepetidos(){
            if(!$this->clslogin->check()){redirect(site_url("login/login2"));}
            $rs=$this->alumno->datosRepetidos();
            echo $rs;
        }
       
        function cargar_categorias(){
            if(!$this->clslogin->check()){redirect(site_url("login/login2"));}
            $info=array();
            $rs=$this->alumno->cargar_categorias();
            foreach ($rs->result() as $fila){
                $info[$fila->cat_id] = $fila->cat_nombre;
            }
            return $info;
        }
        
        function num_Alumnos(){
            if(!$this->clslogin->check()){redirect(site_url("login/login2"));}
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
            if(!$this->clslogin->check()){redirect(site_url("login/login2"));}
            if($m=='') $matricula= $this->input->post("alu_matricula");
            else $matricula=$m;
            $rs=$this->alumno->obtener_alumnoRepresentante($matricula);
            
            $info="";

            foreach($rs->result() as $row){
                $info .="".$row->alu_documentacion."_".$row->alu_nombres."_".$row->alu_apellidos."_".
                        $row->alu_categoria_alumno_id."_".$row->alu_domicilio."_".$row->alu_telefono."_".
                        $row->alu_pais."_".$row->alu_lugar_nacimiento."_".$row->alu_fecha_nacimiento."_".
                        $row->alu_edad."_".$row->alu_sexo."_".$row->alu_madre_nombres."_".
                        $row->alu_madre_ocupacion."_".$row->alu_madre_pais."_".$row->alu_padre_nombres."_".
                        $row->alu_padre_ocupacion."_".$row->alu_padre_pais."_".$row->alu_principal_representante."_".
                        $row->alu_comentarios."_".$row->alu_representante_id."_".$row->alu_curso_paralelo_id."_".
                        $row->rep_nombres."_".$row->rep_cedula."_".$row->rep_ocupacion."_".$row->rep_telefono."_".
                        $row->rep_domicilio."_".$row->rep_pais."_".$row->alu_matricula."_".$row->alu_madre_cedula."_".
                        $row->alu_padre_cedula."_".$row->alu_representante_cedula;
                break;     
            }
            
            if($m=='') echo $info;
            else return $info;
        }
        
        function guardar(){
            if(!$this->clslogin->check()){redirect(site_url("login/login2"));}
            $general=new General();
            $keys= array_keys($_POST);
            for($i=0; $i<count($keys); $i++):       $$keys[$i]= trim($_POST[$keys[$i]]);
            endfor;
            
            if($cmbCurso<12&&$cmbCurso!==13){$cmbEspec=0;}
            $cpId=$general->encontrarIdCursoParalelo($cmbJornada,$cmbCurso,$cmbEspec,$cmbParalelo);
            $repId=$this->guardarRepresentante($rbRepresent,$txtIdRepre);
            $alu=$this->alumno->guardar_Alumno($_POST,$cpId,$repId);
            
            if($txtId===""){
                $this->load->library('export_pdf');
                $curso = $general->get_nom_curso($cpId);
                $jornada = $general->get_nom_jornada($cmbJornada);
                $ano_lectivo = $general->get_anio_lectivo($cmbAnioLectivo);
                $alumno = $this->alumno->obtener_alumno($alu);

                foreach($alumno->result() as $alu){
                    $datos_alu = $this->autocompletar_alumno($alu->alu_matricula);}

                $pdf = new export_pdf();
                $pdf->exportToPDF_Hoja_Matricula($datos_alu,$ano_lectivo,$curso,$jornada);
            }else{
                echo "<script>alert('El Alumno ha sido modificado con exito');
                        window.location.href='".base_url()."alumno/editar/".$txtId."';
                      </script>";
            }
        }
        
        function guardarRepresentante($opcRepresent,$txtIdRepre){
            if(!$this->clslogin->check()){redirect(site_url("login/login2"));}
            if($opcRepresent=="m")
            {
                $dataRepresentante = array(
                                            "rep_nombres"=>trim(strtoupper($this->input->post("txtNombMadre"))),
                                            "rep_cedula"=>$this->input->post("txtCedMadre"),
                                            "rep_ocupacion"=>trim(strtoupper($this->input->post("txtOcupMadre"))),
                                            "rep_telefono"=>$this->input->post("txtTelef"),
                                            "rep_domicilio"=>trim(strtoupper($this->input->post("txtDomicilio"))),
                                            "rep_pais"=>$this->input->post("cmbPaisMadre")

                                            );

                $dataExisteRepres= array("rep_nombres"=>trim(strtoupper($this->input->post("txtNombMadre"))));
            }

            elseif($opcRepresent=="p")
            {
                    $dataRepresentante = array(
                                                "rep_nombres"=>trim(strtoupper($this->input->post("txtNombPadre"))),
                                                "rep_cedula"=>$this->input->post("txtCedPadre"),
                                                "rep_ocupacion"=>trim(strtoupper($this->input->post("txtOcupPadre"))),
                                                "rep_telefono"=>$this->input->post("txtTelef"),
                                                "rep_domicilio"=>trim(strtoupper($this->input->post("txtDomicilio"))),
                                                "rep_pais"=>$this->input->post("cmbPaisPadre")
                                                );

                    $dataExisteRepres= array("rep_nombres"=>trim(strtoupper($this->input->post("txtNombPadre"))));
            }

            else
            {
                    $dataRepresentante = array(
                                                "rep_nombres"=>trim(strtoupper($this->input->post("txtNombPerson"))),
                                                "rep_cedula"=>$this->input->post("txtCedPerson"),
                                                "rep_ocupacion"=>trim(strtoupper($this->input->post("txtOcupPerson"))),
                                                "rep_telefono"=>$this->input->post("txtTelefPerson"),
                                                "rep_domicilio"=>trim(strtoupper($this->input->post("txtDomicilioPerson"))),
                                                "rep_pais"=>$this->input->post("cmbPaisPerson")
                                            );

                    $dataExisteRepres= array("rep_nombres"=>trim(strtoupper($this->input->post("txtNombPerson"))));
            }
            
             if($txtIdRepre=="") $numResultRepres=$this->alumno->buscarRepres($dataRepresentante);
             else $numResultRepres=$txtIdRepre;

             if($numResultRepres==0){
                $this->alumno->guardarRepresentante($dataRepresentante,$txtIdRepre);
                $strRepId="";
                $rs1=$this->alumno->obtenerRepres($dataRepresentante);

                foreach($rs1->result() as $row){
                   $strRepId .="".$row->rep_id."";
                }
             }else{
                 $strRepId=$txtIdRepre;
             }

             return $strRepId;
        }
        
        function alumnoRepetidoCurso(){
            if(!$this->clslogin->check()){redirect(site_url("login/login2"));}
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
        
    }
?>
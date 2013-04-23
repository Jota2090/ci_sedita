<?php
    if (! defined('BASEPATH'))
    exit ('No se puede ejecutar directamente este SCRIPT');

    class Libreta extends Alumno {
        
        function __construct(){
            parent::__construct();
            $this->load->library('grocery_CRUD');
            $this->load->model("mod_personal","personal");
            $this->load->model("mod_libreta","libreta");
        }
        
        function _remap($m){
            if(!$this->clslogin->check())
            {
                redirect(site_url("login"));
            }
            elseif($m=="generar_libreta"){
                $c = $this->input->post("cur");
                
                if($c=="")
                    $this->libreta_vacia();
                else
                    $this->ver_libretas($c);
            }
            elseif($m=="imprimir_libretas"){
                $t = $this->input->post("cmbTrimestre");
                
                if($t=="")
                    $this->libreta_vacia();
                else
                    $this->imprimir_libretas($t);
            }
            elseif($m=="agregar_faltas"){
                $t = $this->input->post("tri");
                
                if($t=="")
                    echo "";
                else
                    $this->add_faltas($t);
            }
            elseif($m=="agregar_observaciones"){
                $t = $this->input->post("tri");
                
                if($t=="")
                    echo "";
                else
                    $this->add_observaciones($t);
            }
            elseif($m=="guardar_faltas"){
                $t = $this->input->post("tri");
                
                if($t=="")
                    echo "";
                else
                    $this->faltas($t);
            }
            elseif($m=="guardar_observaciones"){
                $t = $this->input->post("tri");
                
                if($t=="")
                    echo "";
                else
                    $this->observaciones($t);
            }
            else{
                $this->libreta_vacia();
            }
        }
        
        
        function libreta_vacia(){
            $data["menu"]=$this->load->view("view_menu_administrador");
            $data["jornada"]= $this->cargar_jornadas();
            $data["anioLect"]=$this->cargar_aniosLectivos();
            $data["anlId"]=$this->cargar_anlActual();
            $data["mensaje"] = "";
            
            $this->load->view("libretas/consultar", $data); 
        }
        
        
        function ver_libretas($c){
            $ind = $this->input->post("ind");
            $j = $this->input->post("jor");
            $e = $this->input->post("esp");
            $p = $this->input->post("par");
            $mod = $this->input->post("mod");
            
            /**if($ind>0 || $ind!=null){
                $this->load->library('export_pdf');     
                
                $vc=$this->input->post("curso_paralelo");
                $anl=$this->input->post("anio_lectivo"); 
                $conducta=$this->input->post("conducta");
                $alu=$this->input->post("alumno");
                
                $dirigente=$this->acta->cargar_personal($c, $e, $p, $j);
                $curso = $this->acta->nombre_curso($vc);
                $jornada = $this->acta->nombre_jornada($j); 
                $calificaciones = $this->libreta->calificaciones_actas($t, $anl, $alu);
                $materias = $this->libreta->listar_materias_curso($c, $e);

                $fecha_actual = date('Y');
                $fecha_despues = date('Y')+1;
                $anio = $fecha_actual ." - " .$fecha_despues ;           
            
                $pdf = new export_pdf();
                $pdf->exportToPDF_LibretaAlumno($calificaciones,$materias,$dirigente,$anio,$anl,$curso,
                                                                            $jornada,$t,$conducta,$alu);        
            }**/
            //else{
                $data["conducta"]="";
                $alu = $this->input->post("alu");
                $anl = $this->input->post("anl");
        
                if($e==0)
                    $e=-1;
                
                $calificaciones = $this->libreta->calificaciones_actas($mod, $anl, $alu);
                $materias = $this->libreta->listar_materias_curso($c, $e);
                
                if($materias->num_rows == $calificaciones->num_rows){
                    $cp=$this->encontrarIdCursoParalelo($j, $c, $e, $p);
                    $md = $this->personal->mat_prof_dirigente($cp, $anl);
                    
                    $data["conducta"] = $this->libreta->calificacion_conducta($mod,$md,$anl,$alu);
                    $data["calificaciones"] = $calificaciones;
                    $data["materias"] = $materias;
                    $data["alumno"] = $alu;
                    $data["periodo"] = $mod;
                    $data["anio_lectivo"] = $anl;  
                    $data["curso_paralelo"] = $cp;
                    $data["jornada"] = $j;
                    $data["curso"] = $c;
                    $data["paralelo"] = $p;
                    $data["especializacion"] = $e;  
                    
                    $this->load->view("libretas/visualizar", $data);   
                }
                else{
                    $this->load->view("alertas/actas_vacias");
                }
            //}
        }
        
        function imprimir_libretas($t){
            $c = $this->input->post("cmbCurso");
            $e = $this->input->post("cmbEspecializacion");
            $p = $this->input->post("cmbParalelo");
            $j = $this->input->post("cmbJornada");
            $anl = $this->input->post("cmbAnioLectivo");
            $conducta="";
            
            if($e==0)
                $e=-1;
            
            $vc = $this->acta->verificar_curso($c, $e, $p, $j);
            $list_alumnos=$this->acta->listar_alumnos($vc,$anl);
        
            if($list_alumnos->num_rows>0){
                 $listado=array();
                 foreach($list_alumnos->result() as $lstAlu){
                     $listado[0]= $lstAlu->alu_id;
                     break;
                 }
                                  
                 $calificaciones = $this->libreta->calificaciones_actas($t, $anl, $listado[0]);
                 $materias = $this->libreta->listar_materias_curso($c, $e);
                 
                 if($materias->num_rows == $calificaciones->num_rows){
                    $this->load->library('export_pdf');      
                    
                    $dir = $this->libreta->dir_curso($c, $e, $p, $j);
                    $mc=$this->acta->materia_curso($dir,$vc);
                    $conducta = $this->libreta->calificacion_conducta($t,$mc,$anl,$alu);
                    
                    $dirigente=$this->acta->cargar_personal($c, $e, $p, $j);
                    $curso = $this->acta->nombre_curso($vc);
                    $jornada = $this->acta->nombre_jornada($j); 
                    
                    $anio = $this->libreta->nom_anl($anl);           
                
                    $pdf = new export_pdf();
                    $pdf->exportToPDF_Libretas($list_alumnos,$materias,$dirigente,$anio,$anl,$curso,
                                                $jornada,$t,$mc,$c);
                 }
                 else{
                     $this->load->view("alertas/actas_vacias");
                 }
             }
             else{
                 $this->load->view("alertas/actas_vacias");
            }
        }
        
        function add_faltas($t){
            $alu=$this->input->post("alu");
            $anl=$this->input->post("anl");
            $data["fob"]=$this->libreta->verificar_fob($t,$alu,$anl);
            $data["tri"]=$t;
            
            $this->load->view("ajax/libreta_faltas",$data);
        }
        
        function add_observaciones($t){
            $alu=$this->input->post("alu");
            $anl=$this->input->post("anl");
            $data["fob"]=$this->libreta->verificar_fob($t,$alu,$anl);
            
            $this->load->view("ajax/libreta_observacion",$data);
        }
        
        function faltas($t){
            $alu=$this->input->post("alu");
            $anl=$this->input->post("anl");
            $vfob=$this->libreta->verificar_fob($t,$alu,$anl);
            
            $nt1=$this->input->post("nt1");
            $nt2=$this->input->post("nt2");
            $nt3=$this->input->post("nt3");
            $exa=$this->input->post("exa");
            
            if($vfob->num_rows==0)
                $this->libreta->insertar_faltas($nt1,$nt2,$nt3,$exa,$alu,$t,$anl);
            else{
                foreach($vfob->result() as $fila)
                    $this->libreta->actualizar_faltas($fila->fob_id,$nt1,$nt2,$nt3,$exa);
            }
                
                
            $this->load->view("alertas/libreta_exito_faltas");
        }
        
        function observaciones($t){
            $alu=$this->input->post("alu");
            $anl=$this->input->post("anl");
            $vfob=$this->libreta->verificar_fob($t,$alu,$anl);
            
            $obs=$this->input->post("obs");
            
            if($vfob->num_rows==0)
                $this->libreta->insertar_observacion($obs,$alu,$t,$anl);
            else{
                foreach($vfob->result() as $fila)
                    $this->libreta->actualizar_observacion($fila->fob_id,$obs);
            }
                
            $this->load->view("alertas/libreta_exito_faltas");
        }
    }
?>
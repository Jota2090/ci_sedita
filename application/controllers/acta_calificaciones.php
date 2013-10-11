<?php
    if (! defined('BASEPATH'))
    exit ('No se puede ejecutar directamente este SCRIPT');

    class Acta_Calificaciones extends General {
        
        function __construct(){
            parent::__construct();
            $this->load->library('grocery_CRUD');
            $this->load->model("mod_acta_calificaciones","acta");
            $this->load->model("mod_libreta","libreta");
        }
        
        function _remap($m){
            if(!$this->clslogin->check())
            {
                redirect(site_url("login"));
            }
            elseif($m=="generar_acta"){
                $c = $this->input->post("cur");
                
                if($c==0 || $c==null)
                   $this->acta_nueva();
                else
                    $this->generar_acta($c);
            }
            elseif($m=="guardar"){
                $mod = $this->input->post("mod");
                
                if($mod == "")
                    $this->acta_nueva();
                else
                    $this->guardar_acta($mod);
            }
            elseif($m=="actualizar"){
                $mod = $this->input->post("mod");
                
                if($mod == "")
                    $this->acta_nueva();
                else
                    $this->actualizar_acta($mod);
            }
            elseif($m=="expActa"){
                $mod = $this->input->post("mod");
                
                if($mod == "")
                    $this->acta_nueva();
                else
                    $this->exp_acta($mod);
            }
            elseif($m=="cargar_materias"){
                $c=$this->input->post("cur");
                $e=$this->input->post("esp");
                
                if($c<11||$c>14)
                    $e=-1;
                
                echo $this->acta->cargar_materias($c,$e);
            }
            else{
                $this->acta_nueva();
            }
        }
        
        function nuevo(){
            if(!$this->clslogin->check()) redirect(site_url("login"));
            $funcion = $this->uri->segment(3);
            $data["link"]=base_url()."acta_calificaciones/".$funcion;
            $this->load->view("view_plantilla",$data);
        }
        
        function acta_nueva(){
            $general=new General();
            $data["jornada"]= $general->cargar_jornadas();
            $data["anioLect"] = $general->cargar_aniosLectivos();
            $data["anlId"] = $general->cargar_anlActual();
            $this->load->view("acta_calificaciones/view_ingreso", $data);
        }
        
        
        function generar_acta($c){
            $j = $this->input->post("jor");
            $e = $this->input->post("esp");
            $p = $this->input->post("par");
            $mod = $this->input->post("mod");
            $anl = $this->input->post("anl");
            $mat = $this->input->post("mat");
            
            $idCp = $this->encontrarIdCursoParalelo($j,$c,$e,$p);
            $vac = $this->acta->verificar_acta_creada($mod, $mat, $anl);
            
            $data["resultado"] = $this->acta->listar_alumnos($idCp,$anl);
            $data["anl"] = $anl;
            $data["mat_cur"] = $mat;
            $data["cur_par"] = $idCp;
            $data["mod"] = $mod;
            $data["jor"] = $j;
            print_r($data["resultado"]);
            if($vac==""){
                $this->load->view("acta_calificaciones/view_generar", $data);
            }
            else{
                $data["calificaciones"] = $this->acta->obtener_calificaciones($mod, $mat, $anl);
                $this->load->view("acta_calificaciones/view_consultar", $data);
            }
        }
        
        
        function guardar_acta($mod){
            $cp = $this->input->post("cur_par");
            $mc = $this->input->post("mat_cur");
            $anl = $this->input->post("anl");
            $resultado = $this->acta->listar_alumnos($cp,$anl);
            
            $this->acta->insertar_notas_acta($resultado, $mod, $mc, $anl);
           
            $this->acta_nueva();
        }
        
        
        function actualizar_acta($mod){
            $cp = $this->input->post("cur_par");
            $mc = $this->input->post("mat_cur");
            $anl = $this->input->post("anl");
            $resultado = $this->acta->listar_alumnos($cp,$anl);
            $calificaciones = $this->acta->obtener_calificaciones($mod, $mc, $anl);
            
            $this->acta->actualizar_notas_acta($resultado, $calificaciones, $mod, $mc, $anl);
            
            $this->acta_nueva();
        }
        
        
        function exp_acta($mod){
            $num = $this->input->post("ind");
            $cp = $this->input->post("cur_par");
            $mc = $this->input->post("mat_cur");
            $anl = $this->input->post("anl");
            $j = $this->input->post("jor");
            
            $alumnos = $this->acta->listar_alumnos($cp,$anl);
            $calificaciones = $this->acta->obtener_calificaciones($mod, $mc, $anl);
            $periodo = $this->get_nom_periodo($mod);
            $curso = $this->get_nom_curso($cp);
            $jornada = $this->get_nom_jornada($j);
            $ano_lectivo = $this->get_anio_lectivo($anl);
            
            if($num == 0 || $num == null){
                $this->load->library('export_pdf');                 
                
                $pdf = new export_pdf();
                
                $pdf->exportToPDF_Actas($alumnos,$calificaciones,$periodo,$ano_lectivo,$curso,$jornada,$mod);
            }
            else{
                $this->load->library('export_excel');
                
                $excel = new export_excel();
                $excel->exportToExcel_Acta($alumnos,$calificaciones,"ActaAlumnos.xls",
                                            $periodo,$ano_lectivo,$curso,$jornada);
            }   
        }
    }
?>
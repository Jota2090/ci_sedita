<?php
    if (! defined('BASEPATH'))
    exit ('No se puede ejecutar directamente este SCRIPT');

    class Acta_Calificaciones extends CI_Controller {
        
        function __construct(){
            parent::__construct();
            $this->load->library('grocery_CRUD');
            $this->load->model("mod_acta_calificaciones","acta");
            $this->load->model("mod_alumno2","alumno");
            $this->load->model("mod_libreta","libreta");
        }
        
        function _remap($m){
            if(!$this->clslogin->check())
            {
				redirect(site_url("login"));
			}
            if($this->clslogin->getTipoUser() == 1){
                $this->load->view("view_administrador");
            }
            elseif($m=="generar_acta"){
                $mat = $this->input->post("mat");
                $c = $this->input->post("cur");
                $t = $this->input->post("tri");
                $this->generar_acta($mat, $c, $t);
            }
            elseif($m=="consultar_acta"){
                $mat = $this->input->post("mat");
                $c = $this->input->post("cur");
                $t = $this->input->post("tri");
                $this->consultar_acta($mat, $c, $t);
            }
            elseif($m=="actualizar"){
                $t = $this->input->post("tri");

                if($t == "")
                    redirect(site_url("acta_calificaciones"));
                else
                    $this->actualizar_acta($t);
            }
            elseif($m=="cargar_curso"){
                $m = $this->input->post("mat");
                echo $this->acta->cargar_personal_curso($m,$this->clslogin->getId());
            }
            elseif($m=="expActa"){
                $this->exp_acta();
            }
            elseif($m=="guardar"){
                $trim = $this->input->post("tri");
                
                if($trim == "")
                    redirect(site_url("acta_calificaciones"));
                else
                    $this->guardar_acta($trim);
            }
            else{
                $this->acta_nueva(1, "");
            }
        }
        
        function generar_acta($mat, $c, $t){
            $mc = $this->acta->materia_curso($mat, $c);
            $anl = $this->input->post("anl");
            $data["anio_lectivo"] = $anl;
            $data["materia_curso"] = $mc;
            
            $vac = $this->acta->verificar_acta_creada($t, $mc, $anl);
                
            if($vac == ""){
                                
                $data["resultado"] = $this->acta->listar_alumnos($c,$anl);
                $data["curso_paralelo"] = $c;
                $data["tri"] = $t;
                
                $this->load->view("ajax/actas_generar", $data);
            }
            else{
                echo "2";
            }
        }
        
        
        function consultar_acta($mat, $c, $t){
            $mc = $this->acta->materia_curso($mat, $c);
            $anl = $this->input->post("anl");
            $data["anio_lectivo"] = $anl;
            $data["materia_curso"] = $mc;
            
            $vac = $this->acta->verificar_acta_creada($t, $mc, $anl);
                
            if($vac == ""){
                echo "2";
            }
            else{
                $data["alumnos"] = $this->acta->listar_alumnos($c,$anl);
                $data["calificaciones"] = $this->acta->listar_acta_alumnos($t, $mc, $anl);
                $data["curso_paralelo"] = $c;
                $data["tri"] = $t;
                
                $this->load->view("ajax/actas_consultar", $data);
            }
        }
        
        
        function acta_nueva($j, $mensaje){
            $id_per = $this->clslogin->getId();
            $data["materia"] = $this->acta->cargar_materias_personal($id_per);
            $data["trimestre"] = $this->acta->cargar_trimestre();
            $data["mensaje"] = $mensaje;
            $data["per_lectivos"]=$this->libreta->cargar_anl();
            $data["anio_lectivo"] = $this->libreta->verificar_anl(date('Y'));
            $data["menu"]=$this->load->view("view_menu_profesor");
            $this->load->view("view_acta_calificaciones", $data);
        }
        
        
        function guardar_acta($trim){
            $cp = $this->input->post("curso_paralelo");
            $mc = $this->input->post("materia_curso");
            $anl = $this->input->post("anio_lectivo");
            $resultado = $this->acta->listar_alumnos($cp,$anl);
            
            $this->acta->insertar_notas_acta($resultado, $trim, $mc, $anl);
            
            $mensaje = $this->load->view("alertas/acta_exito_guardado");
            $this->acta_nueva(1,$mensaje);
        }
        
        function actualizar_acta($trim){
            $cp = $this->input->post("curso_paralelo");
            $mc = $this->input->post("materia_curso");
            $anl = $this->input->post("anio_lectivo");
            $resultado = $this->acta->listar_alumnos($cp,$anl);
            $calificaciones = $this->acta->listar_acta_alumnos($trim, $mc, $anl);
            
            $this->acta->actualizar_notas_acta($resultado, $calificaciones, $trim, $mc, $anl);
            
            $mensaje = $this->load->view("alertas/acta_exito_actualizado");
            $this->acta_nueva(1,$mensaje);
        }
        
        function exp_acta(){
            $num = $this->input->post("indicador");
            $t = $this->input->post("tri");
            $cp = $this->input->post("curso_paralelo");
            $mc = $this->input->post("materia_curso");
            $j = $this->input->post("jornada");
            $anl = $this->input->post("anio_lectivo");
            
            $alumnos = $this->acta->listar_alumnos($cp,$anl);
            $calificaciones = $this->acta->listar_acta_alumnos($t, $mc, $anl);
            $periodo = $this->acta->nombre_trimestre($t);
            $curso = $this->acta->nombre_curso($cp);
            $jornada = $this->acta->nombre_jornada($j);
            
            $fecha_actual = date('Y');
            $fecha_despues = date('Y')+1;
            $ano_lectivo = $fecha_actual ." - " .$fecha_despues;
            
            if($num == 0 || $num == null){
                $this->load->library('export_pdf');                 
                
                $pdf = new export_pdf();
                
                $pdf->exportToPDF_Actas($alumnos,$calificaciones,$periodo,$ano_lectivo,$curso,$jornada,$t);
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
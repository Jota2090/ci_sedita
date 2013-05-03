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
        
        function generar_ruta(){
            if(!$this->clslogin->check()){ redirect(site_url("login"));}
            
            $keys= array_keys($_POST);
            for($i=0; $i<count($keys); $i++):       $$keys[$i]= trim($_POST[$keys[$i]]);
            endfor;
            $id = $this->uri->segment(3);
            if($id=="cobros"){
                if($matricula=="") $matricula=0; if($nombres=="") $nombres=0;
                if($apellidos=="") $apellidos=0;
                $ruta=  base_url()."listados/buscar_alumnos/cobros/".$matricula."/".$nombres."/".$apellidos."/".$anl;
            }
            echo $ruta;
        }
        
        function cargar_niveles(){
            if(!$this->clslogin->check()){
                redirect(site_url("login"));
            }
            
            $m= $this->input->post("jornada");
            $r=$this->general->cargar_niveles($m);
            echo $r;
        }
        
        function cargar_anlActual(){
            if(!$this->clslogin->check()){
                redirect(site_url("login"));
            }
            
            $anl_id = $this->general->verificar_anl(date("Y"));
            return $anl_id;
        }

        function cargar_jornadas()
        {
            if(!$this->clslogin->check()){
                redirect(site_url("login"));
            }
            
            $info=array();
            $info['0']="Seleccione una jornada";
            $rs=$this->general->cargar_jornadas();
             foreach ($rs->result() as $fila){
                $info[$fila->jor_id] = $fila->jor_nombre;
            }
            return $info;
        }
                  
        function cargar_anios_registro()
        {
            if(!$this->clslogin->check()){
                redirect(site_url("login"));
            }
            
            $info=array();
            $rs=$this->general->cargar_anios_registro();
             foreach ($rs->result() as $fila){
                $info[$fila->anl_id] = $fila->anl_periodo." - " .(($fila->anl_periodo)+1);
            }
            return $info;
        }
                 
        function cargar_aniosLectivos()
        {
            if(!$this->clslogin->check()){
                redirect(site_url("login"));
            }
            
            $info=array();
            $rs=$this->general->cargar_aniosLectivos();
             foreach ($rs->result() as $fila){
                $info[$fila->anl_id] = $fila->anl_periodo." - " .(($fila->anl_periodo)+1);
            }
            return $info;
        }
        
        function get_idAnioLect($anioLect)
        {
            if(!$this->clslogin->check()){
                redirect(site_url("login"));
            }
            
            if(date('n')<3)
                $anioLect=$anioLect-1;
                
            $rs=$this->general->get_idAnioLect($anioLect);
            $strAnLectId="";
            foreach($rs->result() as $row){
                $strAnLectId=$row->anl_id;
            }
            
            return $strAnLectId;
        }
        
        function cargar_cursos()
        {
            if(!$this->clslogin->check()){
                redirect(site_url("login"));
            }
            
            $jornada= $this->input->post("jornada");
            $nivel= $this->input->post("nivel");
            $rs=$this->general->cargar_cursos($jornada,$nivel);
            $info="";
            $info .="<option value='0'>Seleccione un curso</option>";
            foreach($rs->result() as $row){
                $info .="<option value='".$row->cur_id."'>".$row->cur_nombre."</option>";
            }
            echo $info;
        }
        
        
        function cargar_especializaciones()
        {
            if(!$this->clslogin->check()){
                redirect(site_url("login"));
            }
            
            $jornada= $this->input->post("jornada");
            $curso= $this->input->post("curso");
            $rs=$this->general->cargar_especializaciones($jornada,$curso);
            $info="";
            
            $info .="<option value='0'>Seleccione una especializaci&oacute;n</option>";
                        
            foreach($rs->result() as $row){
                $info .="<option value='".$row->esp_id."'>".$row->esp_nombre."</option>";
            }
            echo $info;
        }
        
        function cargar_paralelos()
        {
            if(!$this->clslogin->check()){
                redirect(site_url("login"));
            }
            
            $jornada= $this->input->post("jornada");
            $curso= $this->input->post("curso");
            $rs=$this->general->cargar_paralelos($jornada,$curso);

            $info="";
            $info .="<option value='0'>Seleccione un paralelo</option>";
                        
            foreach($rs->result() as $row){
                $info .="<option value='".$row->par_id."'>".$row->par_nombre."</option>";
            }
            echo $info;
        }
        
        function cargar_paralBachill()
        {
            if(!$this->clslogin->check()){
                redirect(site_url("login"));
            }
            
            $jornada= $this->input->post("jornada");
            $curso= $this->input->post("curso");
            $espec= $this->input->post("espec");
            $rs=$this->general->cargar_paralBachill($jornada,$curso,$espec);
            
            $info="";
            $info .="<option value='0'>Seleccione un paralelo</option>";
                        
            foreach($rs->result() as $row){
                $info .="<option value='".$row->par_id."'>".$row->par_nombre."</option>";
            }
            echo $info;
        }
        
        function encontrarIdCursoParalelo($jornada,$curso,$especializacion,$paralelo)
        {
            if(!$this->clslogin->check()){
                redirect(site_url("login"));
            }
            
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
            if(!$this->clslogin->check()){
                redirect(site_url("login"));
            }
            
            $info = "";
            $rs=$this->general->nombre_periodo($mod);
            foreach ($rs->result() as $fila){
                $info = $fila->pes_nombre;
            }
            
            return $info;
        }
        
        
        function get_nom_jornada($j){
            if(!$this->clslogin->check()){
                redirect(site_url("login"));
            }
            
            $info = "";
            $rs=$this->general->nombre_jornada($j);
            foreach ($rs->result() as $fila){
                $info = $fila->jor_nombre;
            }
            return $info;
        }
        
        
        function get_nom_curso($cp){
            if(!$this->clslogin->check()){
                redirect(site_url("login"));
            }
            
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
            if(!$this->clslogin->check()){
                redirect(site_url("login"));
            }
            
            $info="";
            $rs=$this->general->nombre_especializacion($e);
            foreach ($rs->result() as $fila){
                $info = $fila->esp_nombre;
            }
            
            return $info;
        }
        
        
        function get_anio_lectivo($anl){
            if(!$this->clslogin->check()){
                redirect(site_url("login"));
            }
            
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
            if(!$this->clslogin->check()){
                redirect(site_url("login"));
            }
            
            $rs=$this->acta->listar_alumnos($cp,$anl);
            $info="";
            foreach($rs->result() as $row){
                $info .="<option value='".$row->alu_id."'>".$row->alu_apellidos." ".$row->alu_nombres."</option>";
            }
            return $info;
        }
        
        
        function listar_alumnos(){
            if(!$this->clslogin->check()){
                redirect(site_url("login"));
            }
            
            $c = $this->input->post("cur");
            $j = $this->input->post("jor");
            $e = $this->input->post("esp");
            $p = $this->input->post("par");
            $anl=$this->input->post("anl");
            
            if($c<11||$c>14)
                $e=-1;
            
            $cp = $this->encontrarIdCursoParalelo($j, $c, $e, $p);
            $alu = $this->lista_alumnos($cp,$anl);
            
            echo $alu;
        }
        
    } 
?>
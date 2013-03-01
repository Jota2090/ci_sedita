<?php
    if (! defined('BASEPATH'))
    exit ('No se puede ejecutar directamente este SCRIPT');

    class mod_acta_calificaciones extends CI_Model {
        
        function __construct(){
            parent::__construct();
        }
        
        function listar_alumnos($vc,$anl){
            $this->db->select("alu_id, alu_nombres, alu_apellidos");
            $this->db->from("alumno");
            $this->db->where("alu_curso_paralelo_id",$vc);
            $this->db->where("alu_ano_lectivo_id",$anl);
            $this->db->order_by("alu_apellidos, alu_nombres");
            
            $rs = $this->db->get();
            
            return $rs;
        }
        
        
        function obtener_calificaciones($mod, $mat, $anl){
            $this->db->select("cal_id, cal_nota1, cal_nota2, cal_nota3, cal_examen, cal_total, cal_promedio, cal_conducta, cal_alumno_id");
            $this->db->from("calificaciones");
            $this->db->where("cal_periodo_escolar_id",$mod);
            $this->db->where("cal_materia_curso_id",$mat);
            $this->db->where("cal_anio_lectivo_id",$anl);
            $this->db->order_by("cal_id");
            
            $rs = $this->db->get();
            
            return $rs;
        }
        
        
        function verificar_acta_creada($mod, $mc, $anl){
            $this->db->select("cal_id");
            $this->db->from("calificaciones");
            $this->db->where("cal_periodo_escolar_id",$mod);
            $this->db->where("cal_materia_curso_id",$mc);
            $this->db->where("cal_anio_lectivo_id",$anl);
            
            $rs = $this->db->get();
            $info = "";
            
            foreach($rs->result() as $row){
                $info = $row->cal_id;
            }
            
            return $info;
        }
        
        
        function insertar_notas_acta($resultado, $mod, $mc, $anl){
            foreach($resultado->result() as $alumno){
                $nota1 = $this->input->post("nt1" .$alumno->alu_id);
                $nota2 = $this->input->post("nt2" .$alumno->alu_id);
                $nota3 = $this->input->post("nt3" .$alumno->alu_id);
                $examen = $this->input->post("exa" .$alumno->alu_id);
                $total = $this->input->post("tot" .$alumno->alu_id);
                $promedio = $this->input->post("pro" .$alumno->alu_id);
                $conducta = $this->input->post("cond" .$alumno->alu_id);
                
                $data = array(
                   'cal_nota1' => $nota1 ,
                   'cal_nota2' => $nota2 ,
                   'cal_nota3' => $nota3 ,
                   'cal_examen' => $examen ,
                   'cal_total' => $total ,
                   'cal_promedio' => $promedio ,
                   'cal_conducta' => $conducta ,
                   'cal_periodo_escolar_id' => $mod,
                   'cal_materia_curso_id' => $mc ,
                   'cal_anio_lectivo_id' => $anl ,
                   'cal_alumno_id' => $alumno->alu_id
                );
                
                $this->db->insert('calificaciones', $data); 
            }
        }
        
        function actualizar_notas_acta($resultado, $calificaciones, $mod, $mc, $anl){
            foreach($resultado->result() as $alumno){
                foreach($calificaciones->result() as $cal){
                    if($alumno->alu_id == $cal->cal_alumno_id){
                       
                        $cal_id = $this->input->post("cal" .$cal->cal_id);
                        $nota1 = $this->input->post("nt1" .$alumno->alu_id);
                        $nota2 = $this->input->post("nt2" .$alumno->alu_id);
                        $nota3 = $this->input->post("nt3" .$alumno->alu_id);
                        $examen = $this->input->post("exa" .$alumno->alu_id);
                        $total = $this->input->post("tot" .$alumno->alu_id);
                        $promedio = $this->input->post("pro" .$alumno->alu_id);
                        $conducta = $this->input->post("cond" .$alumno->alu_id);
                        
                        $data = array(
                           'cal_nota1' => $nota1 ,
                           'cal_nota2' => $nota2 ,
                           'cal_nota3' => $nota3 ,
                           'cal_examen' => $examen ,
                           'cal_total' => $total ,
                           'cal_promedio' => $promedio ,
                           'cal_conducta' => $conducta ,
                           'cal_periodo_escolar_id' => $mod,
                           'cal_materia_curso_id' => $mc ,
                           'cal_anio_lectivo_id' => $anl ,
                           'cal_alumno_id' => $alumno->alu_id
                        );
                        
                        $this->db->where("cal_id", $cal_id);
                        $this->db->update('calificaciones', $data);            
                    }
                }
            }
        }
        
        
        function nombre_alumno($alu){
            $this->db->select("alu_nombres, alu_apellidos");
            $this->db->from("alumno");
            $this->db->where("alu_id",$alu);
            $rs = $this->db->get();
            
            $info = "";
            
            foreach ($rs->result() as $fila){
                $info = $fila->alu_apellidos." ".$fila->alu_nombres;
            }
                
            return $info;
        }
        
        function nombre_materia($mc){
            $this->db->select("mat_nombre");
            $this->db->where("mc_id", $mc);
            $this->db->join("materia", "mc_materia_id=mat_id");
            $rs=$this->db->get("materia_curso");
            
            $info = "";
            
            foreach ($rs->result() as $fila){
                $info = $fila->mat_nombre;
            }
                
            return $info;
        }
        
        function cur_esp($cp){
            $this->db->where("cp_id", $cp);
            $this->db->join("curso", "cp_curso_id=cur_id");
            $this->db->join("especializacion", "cp_especializacion_id=esp_id");
            $this->db->join("paralelo", "cp_paralelo_id=par_id");
            $this->db->join("jornada", "cp_jornada_id=jor_id");
            $rs=$this->db->get("curso_paralelo");

            return $rs;
        }
        
        
        function nom_cur($cp){
            $this->db->select("cur_nombre, esp_id, esp_nombre, par_nombre");
            $this->db->where("cp_id", $cp);
            $this->db->join("curso", "cp_curso_id=cur_id");
            $this->db->join("especializacion", "cp_especializacion_id=esp_id");
            $this->db->join("paralelo", "cp_paralelo_id=par_id");
            $this->db->join("jornada", "cp_jornada_id=jor_id");
            $rs=$this->db->get("curso_paralelo");
            
            $info = "";
            
            foreach ($rs->result() as $fila){
                $info = $fila->cur_nombre ." " .$fila->par_nombre;
            }
                
            return $info;
        }
        
        function nom_esp($e){
            $info="";
            
            $this->db->select("esp_nombre, esp_id");
            $this->db->from("especializacion");
            $this->db->where("esp_id", $e);
            $rs = $this->db->get();
            
            foreach ($rs->result() as $fila){
                $info = $fila->esp_nombre;
            }
                
            return $info;
        }
        
        
        function cargar_id_anio_lectivo(){
            $this->db->where("anl_periodo", date('Y'));
            $rs=$this->db->get("anio_lectivo");
            
            $info = "";
            
            foreach ($rs->result() as $fila){
                $info .= $fila->anl_id;
            }
                
            return $info;
        }
         
        function cargar_personal($c,$e,$p,$j){
            $this->db->where("pc_curso_id", $c);
            $this->db->where("pc_especializacion_id", $e);
            $this->db->where("pc_paralelo_id", $p);
            $this->db->where("pc_jornada_id", $j);
            $this->db->where("pc_dirigente", "SI");
            $this->db->join("personal","pc_personal_id=per_id");
            $rs=$this->db->get("personal_curso");
            
            $info = "";
            foreach ($rs->result() as $fila){
                $info = $fila->per_apellidos." ".$fila->per_nombres;
            }
                
            return $info;
        }
        
        function cargar_trimestre(){
            $this->db->order_by("pes_nombre");
            $rs = $this->db->get("periodo_escolar");
            $info=array();
            
            foreach ($rs->result() as $fila){
                $info[$fila->pes_id] = $fila->pes_nombre;
            }
                
            return $info;
        }
        
        function cargar_materias_personal($id_per){
            $this->db->order_by("mat_id");
            $this->db->select("mat_id, mat_nombre");
            $this->db->join("materia", "pc_materia_id = mat_id");
            $this->db->where("pc_personal_id", $id_per);
            $rs=$this->db->get("personal_curso");
            
            $info=array();
            $info[0]="Seleccione una materia";
            foreach ($rs->result() as $fila){
                $info[$fila->mat_id] = $fila->mat_nombre;
            }
                
            return $info;
        }
        
        function cursos_personal($id_per){
            $this->db->order_by("mat_id");
            $this->db->select("mat_id, mat_nombre");
            $this->db->join("materia", "pc_materia_id = mat_id");
            $this->db->where("pc_personal_id", $id_per);
            $rs=$this->db->get("personal_curso");
            
            $info=array();
            $info[0]= "Elija Curso";
                        
            foreach ($rs->result() as $fila){
                $this->db->order_by("cur_id");
                $this->db->join("curso", "pc_curso_id = cur_id");
                $this->db->join("especializacion", "pc_especializacion_id = esp_id");
                $this->db->join("paralelo", "pc_paralelo_id = par_id");
                $this->db->join("jornada", "pc_jornada_id = jor_id");
                $this->db->where("pc_personal_id", $id_per);
                $this->db->where("pc_materia_id", $fila->mat_id);
                $rs=$this->db->get("personal_curso");
                
                foreach ($rs->result() as $fila){
                    $cp=$this->verificar_curso($fila->cur_id,$fila->esp_id,$fila->par_id,$fila->jor_id);
                    
                    if($fila->esp_id==-1)
                        $info[$cp]=$fila->cur_nombre." ".$fila->par_nombre." ".$fila->jor_nombre;
                    else
                        $info[$cp]=$fila->cur_nombre." ".$fila->esp_nombre." ".$fila->par_nombre." ".$fila->jor_nombre;
                }
            }
                
            return $info;
        }
        
        function cargar_personal_curso($m, $id_per){
            $this->db->order_by("cur_id");
            $this->db->join("curso", "pc_curso_id = cur_id");
            $this->db->join("especializacion", "pc_especializacion_id = esp_id");
            $this->db->join("paralelo", "pc_paralelo_id = par_id");
            $this->db->join("jornada", "pc_jornada_id = jor_id");
            $this->db->where("pc_personal_id", $id_per);
            $this->db->where("pc_materia_id", $m);
            $rs=$this->db->get("personal_curso");
            
            $info="";
            
            $info .= "<option value='0'>Elija Curso</option>";
            
            foreach ($rs->result() as $fila){
                $cp=$this->verificar_curso($fila->cur_id,$fila->esp_id,$fila->par_id,$fila->jor_id);
                
                if($fila->esp_id==-1)
                    $info .="<option value='".$cp."'>".$fila->cur_nombre." ".$fila->par_nombre." ".$fila->jor_nombre."</option>";
                else
                    $info .="<option value='".$cp."'>".$fila->cur_nombre." ".$fila->esp_nombre." ".$fila->par_nombre." ".$fila->jor_nombre."</option>";
            }
                
            return $info;
        }
        
        function materia_curso($mat, $c){
            $this->db->from("curso_paralelo");
            $this->db->where("cp_id",$c);
            $cp= $this->db->get();
            
            foreach($cp->result() as $fila){
                $this->db->from("materia_curso");
                $this->db->where("mc_materia_id",$mat);
                $this->db->where("mc_curso_id",$fila->cp_curso_id);
                
                $rs= $this->db->get();
                $info="";
                
                foreach($rs->result() as $row){
                    $info = $row->mc_id;
                }
            }
            
            return $info;
        }
        
        function materia_personal($per,$c,$e,$p,$j,$anl){
            $this->db->from("personal_curso");
            $this->db->where("pc_personal_id",$per);
            $this->db->where("pc_curso_id",$c);
            $this->db->where("pc_especializacion_id",$e);
            $this->db->where("pc_jornada_id",$j);
            $this->db->where("pc_paralelo_id",$p);
            $this->db->where("pc_anio_lectivo_id",$anl);
            $this->db->where("pc_dirigente","SI");
            $mp= $this->db->get();
            $info="";
            foreach($mp->result() as $fila){
                $info.=$fila->pc_materia_id;
            }
            
            return $info;
        }
        
        function verificar_materia_profesor($p){
            $this->db->from("materia_profesor");
            $this->db->where("mp_personal_id",$p);
            
            $rs= $this->db->get();
            
            return $rs;
        }
        
        function verificar_curso($c, $e, $p, $j){
            $this->db->from("curso_paralelo");
            $this->db->where("cp_paralelo_id",$p);
            $this->db->where("cp_curso_id",$c);
            $this->db->where("cp_especializacion_id",$e);
            $this->db->where("cp_jornada_id",$j);
            
            $rs= $this->db->get();
            $info="";
            
            foreach($rs->result() as $row){
                $info = $row->cp_id;
            }
            
            return $info;
        }
 
        
        function listar_rep($cp,$anl){
            $this->db->select("alu_nombres, alu_apellidos,rep_nombres");
            $this->db->from("alumno");
            $this->db->where("alu_curso_paralelo_id",$cp);
            $this->db->where("alu_ano_lectivo_id",$anl);
            $this->db->join("representante", "alu_representante_id=rep_id");
            $this->db->order_by("alu_apellidos, alu_nombres");
            
            $rs = $this->db->get();
            
            return $rs;
        }
        
        function listar_materias($c,$e){
            $this->db->select("mat_id, mat_nombre");
            $this->db->from("materia_curso");
            $this->db->where("mc_curso_id",$c);
            $this->db->where("mc_especializacion_id",$e);
            $this->db->join("materia", "mc_materia_id = mat_id");
            $this->db->order_by("mat_nombre");
            
            $rs = $this->db->get();
            $info="";
            $info .="<option value='0'>Seleccione una materia</option>";
                        
            foreach($rs->result() as $row){
                $info .="<option value='".$row->mat_id."'>".$row->mat_nombre."</option>";
            }
            return $info;
        }
        
    }
?>
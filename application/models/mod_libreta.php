<?php
    if (! defined('BASEPATH'))
    exit ('No se puede ejecutar directamente este SCRIPT');

    class mod_libreta extends CI_Model {
        
        function __construct(){
            parent::__construct();
        }
        
        
        function calificaciones_actas($mod, $anl, $alu){
            $this->db->order_by("cal_periodo_escolar_id");
            $this->db->from("calificaciones");
            $this->db->where("cal_anio_lectivo_id", $anl);
            $this->db->where("cal_alumno_id", $alu);
            
            if($mod>0)
                $this->db->where("cal_periodo_escolar_id", $mod);
            
            $rs = $this->db->get();
            
            return $rs;
        }
        
        
        function listar_materias_curso($c, $e){
            $this->db->select("mc_id, mat_nombre");
            $this->db->from("materia_curso");
            $this->db->join("materia", "mc_materia_id=mat_id");
            $this->db->where("mc_curso_id", $c);
            $this->db->where("mc_especializacion_id", $e);
                        
            $rs = $this->db->get();
            
            return $rs;
        }
        
        
        function calificacion_conducta($mod, $mc, $anl, $alu){
            $this->db->from("calificaciones");
            $this->db->where("cal_periodo_escolar_id", $mod);
            $this->db->where("cal_materia_curso_id", $mc);
            $this->db->where("cal_anio_lectivo_id", $anl);
            $this->db->where("cal_alumno_id", $alu);
            
            $rs = $this->db->get();
            $info="";
            
            foreach($rs->result() as $cal){
                $info = $cal->cal_conducta;
            }
            return $info;
        }
        
        function promedios_alumnos($t, $anl, $alu){
            $this->db->from("promedios");
            $this->db->where("pro_periodo_escolar_id", $t);
            $this->db->where("pro_anio_lectivo_id", $anl);
            $this->db->where("pro_alumno_id", $alu);
            
            $rs = $this->db->get();
            
            return $rs;
        }
        
        
        function insertar_promedios_alumnos($t, $anl, $mc, $alu){
            $data = array(
                   'pro_nota1' => 0 ,
                   'pro_nota2' => 0 ,
                   'pro_nota3' => 0 ,
                   'pro_promedio' => 0 ,
                   'pro_periodo_escolar_id' => $t,
                   'pro_materia_curso_id' => $mc ,
                   'pro_anio_lectivo_id' => $anl ,
                   'pro_alumno_id' => $alu
                );
                
                $this->db->insert('promedios', $data);
        }
        
        
        function verificar_fob($t,$alu,$anl){
            $this->db->from("faltas_observaciones");
            $this->db->where("fob_alumno_id",$alu);
            $this->db->where("fob_periodo_escolar_id",$t);
            $this->db->where("fob_anio_lectivo_id",$anl);
            
            $rs= $this->db->get();
            
            return $rs;
        }
        
        function insertar_faltas($nt1,$nt2,$nt3,$exa,$alu,$t,$anl){
            $datos = array(
                'fob_nota1' => $nt1,
                'fob_nota2' => $nt2,
                'fob_nota3' => $nt3,
                'fob_examen' => $exa,
                'fob_alumno_id' => $alu,
                'fob_periodo_escolar_id' => $t,
                'fob_anio_lectivo_id' => $anl
            );
                
            $this->db->insert('faltas_observaciones', $datos);
        }
        
        function actualizar_faltas($vfob,$nt1,$nt2,$nt3,$exa){
            $datos = array(
                'fob_nota1' => $nt1,
                'fob_nota2' => $nt2,
                'fob_nota3' => $nt3,
                'fob_examen' => $exa
            );
            
            $this->db->where('fob_id',$vfob);
            $this->db->update('faltas_observaciones', $datos);
        }
        
        function insertar_observacion($obs,$alu,$t,$anl){
            $datos = array(
                'fob_observacion' => htmlentities($obs),
                'fob_alumno_id' => $alu,
                'fob_periodo_escolar_id' => $t,
                'fob_anio_lectivo_id' => $anl
            );
                
            $this->db->insert('faltas_observaciones', $datos);
        }
        
        function actualizar_observacion($vfob,$obs){
            $datos = array(
                'fob_observacion' => htmlentities($obs)
            );
            
            $this->db->where('fob_id',$vfob);
            $this->db->update('faltas_observaciones', $datos);
        }
    }
?>
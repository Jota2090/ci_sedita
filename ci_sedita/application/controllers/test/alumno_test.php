<?php

        require_once(APPPATH . '/controllers/test/Toast.php');
        
        class Alumno_test extends Toast
        {
        	function Alumno_test()
        	{
        		parent::Toast(__FILE__); // Remember this
                $this->load->model('mod_alumno','alumno');
        	}
        
        	function test_cargar_categorias()
        	{
                $categorias=array();
                $rsCategorias=$this->alumno->cargar_categorias();
                 foreach ($rsCategorias->result() as $fila)
                 {
                    $categorias[$fila->cat_id] = $fila->cat_nombre;
                 }

                $numCategorias=count($categorias);
                $esperado=4;
                
                
                if($this->_assert_equals($numCategorias,$esperado))
                {
                    $this->message = 'El n&uacute;mero de categor&iacute;as coincide con el esperado. 
                    <br  /> Valor esperado:  ' . $esperado.
                    '<br /> Valor retornado:  ' . $numCategorias; 
                }
                else
                {
                   $this->message = 'El n&uacute;mero de categor&iacute;as no coincide con el esperado. 
                    <br  /> Valor esperado:  ' . $esperado.
                    '<br /> Valor retornado:  ' . $numCategorias; 
                 
                }
                
                
        	}
        
        	function test_numAlumnos()
        	{
                    //$cpId,$idAnioLect
                    $numAlumnos=$this->alumno->numAlumnos(22,4);
                    $esperado=9;
                    if($this->_assert_equals($numAlumnos,$esperado))
                    {
                        $this->message = 'El n&uacute;mero de alumnos coincide con el esperado. 
                        <br  /> Valor esperado:  ' . $esperado.
                        '<br /> Valor retornado:  ' . $numAlumnos; 
                    }
                    else
                    {
                       $this->message = 'El n&uacute;mero de alumnos no coincide con el esperado. 
                        <br  /> Valor esperado:  ' . $esperado.
                        '<br /> Valor retornado:  ' . $numAlumnos; 
                     
                    }
                    
        	}
            
            function test_numAlumnosRepetCurso()
            {
                //Parámetros: $cpId,$nombAlumn,$apellAlumn,$AnioId
                //$numAlumnosRepetCurso=$this->alumno->numAlumnosRepetCurso(22,"Nicole Melanie","Guevara Cruz",4);//true
                $numAlumnosRepetCurso=$this->alumno->numAlumnosRepetCurso(22,"Carmen","Guevara Cruz",4);//false
               
                $esperado=0;
                
                    if($this->_assert_equals($numAlumnosRepetCurso,$esperado))
                    {
                        $this->message = 'Este alumno no est&aacute; registrado en este curso. 
                        <br  /> Valor esperado:  ' . $esperado.
                        '<br /> Valor retornado:  ' . $numAlumnosRepetCurso; 
                    }
                    else
                    {
                       $this->message = 'Este alumno ya fue registrado en este curso. 
                        <br  /> Valor esperado:  ' . $esperado.
                        '<br /> Valor retornado:  ' . $numAlumnosRepetCurso; 
                     
                    }
                    
            }
            
            
             function test_numAlumnosRepetOtroCurso()
            {
                //Parámetros: $cpId,$nombAlumn,$apellAlumn,$AnioId
                
                $numAlumnosRepetOtroCurso=$this->alumno->numAlumnosRepetOtroCurso(22,"Evelyn Cristina","Medina Toala",4);//true
                //$numAlumnosRepetOtroCurso=$this->alumno->numAlumnosRepetCurso(22,"Fernanda","Carpio Mendoza",4);//false
                $esperado=0;
                
                    if($this->_assert_equals($numAlumnosRepetOtroCurso,$esperado))
                    {
                        $this->message = 'Este alumno no est&aacute; registrado en otro curso. 
                        <br  /> Valor esperado:  ' . $esperado.
                        '<br /> Valor retornado:  ' . $numAlumnosRepetOtroCurso; 
                    }
                    else
                    {
                       $this->message = 'Este alumno ya fue registrado en otro curso. 
                        <br  /> Valor esperado:  ' . $esperado.
                        '<br /> Valor retornado:  ' . $numAlumnosRepetOtroCurso; 
                     
                    }
              
            
            }
            
            
           /*
             function test_guardar_Alumno()
                        {
                            //Parámetros$nombres,$apellidos,$domicilio,$telef,$pais,$lugarNac,$mifecha,$rbSexo,$edad,$nombMadre,$ocupMadre,$paisMadre,$nombPadre,$ocupPadre,$paisPadre,$rbRepresent,$check,$comentarios,$categoria,$repId,$cpId,$AnioId
                            $tipo=array();
                            $alumno=$this->alumno->guardarAlumno("José Ismael","Mendieta Cáceres","24 y Portete","042583089","Ecuador","Guayaquil","2000-12-1","m",12,"Brenda Cáceres","Ama de casa","Ecuador","Ismael Mendieta","Arquitecto","Ecuador","o",0,"",1,10,22,4);
                            $this->unit->run($alumno,is_array,'Prueba tipo de dato de guardar');
                            
                            
                            
                            
                        }
            */
            
            
            function test_obtener_alumnoRepresentante()
            {
                //Parámetro: $idAlumno
                 $rsAlumno=$this->alumno->obtener_alumnoRepresentante(1);
                 
                 $alumno=array();
                
                 foreach ($rsAlumno->result() as $fila)
                 {
                    $alumno[$fila->alu_id] = $fila->alu_nombres.$fila->alu_apellidos;
                 }
                
                $esperado=0;
                
                    if($this->_assert_equals($numAlumnosRepetOtroCurso,$esperado))
                    {
                        $this->message = 'Este alumno no est&aacute; registrado en otro curso. 
                        <br  /> Valor esperado:  ' . $esperado.
                        '<br /> Valor retornado:  ' . $numAlumnosRepetOtroCurso; 
                    }
                    else
                    {
                       $this->message = 'Este alumno ya fue registrado en otro curso. 
                        <br  /> Valor esperado:  ' . $esperado.
                        '<br /> Valor retornado:  ' . $numAlumnosRepetOtroCurso; 
                     
                    }
                
                
            }
            
            
            
        }

?>
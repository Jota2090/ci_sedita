<?php
 
    function footer_pdf($orientation = 'portrait')
    {   
        $meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
	
    	$CI = & get_instance();
    	
    	$CI->cezpdf->selectFont(base_url() . '/fonts');	
    	
    	$all = $CI->cezpdf->openObject();
    	$CI->cezpdf->saveState();
    	$CI->cezpdf->setStrokeColor(0,0,0,1);
        
    	if($orientation == 'portrait') {
    		$CI->cezpdf->ezSetMargins(50,70,50,50);
    		$CI->cezpdf->ezStartPageNumbers(540,28,8,'','{PAGENUM}',1);
            $CI->cezpdf->line(220,50,380,50);
            $CI->cezpdf->addText(278,40,8,'Secretaria');
    		$CI->cezpdf->addText(50,32,8,$meses[date('n')-1]."  " .date('d').",   ".date('y'));
    		$CI->cezpdf->addText(50,22,8,"    ".date('h:i:s a'));
    	}
    	else {
    		$CI->cezpdf->ezStartPageNumbers(750,28,8,'','{PAGENUM}',1);
    		$CI->cezpdf->line(20,40,800,40);
    		$CI->cezpdf->addText(50,32,8,'Printed on ' . date('m/d/Y h:i:s a'));
    		$CI->cezpdf->addText(50,22,8,'CI PDF Tutorial - http://www.christophermonnat.com');
    	}
        
    	$CI->cezpdf->restoreState();
    	$CI->cezpdf->closeObject();
    	$CI->cezpdf->addObject($all,'all');
    }
    
    function header_pdf($orientation = 'portrait')
    {
    	$CI = & get_instance();
    	
    	$CI->cezpdf->selectFont(base_url() . '/fonts');	
    	
    	$all = $CI->cezpdf->openObject();
    	$CI->cezpdf->saveState();
    	$CI->cezpdf->setStrokeColor(0,0,0,1);
        
    	$CI->cezpdf->ezSetMargins(50,70,50,50); // margenes del documento
        $CI->cezpdf->ezImage(site_url("images/logo-escuela.jpg"), 0, 50, 5, 'left');
        ob_end_clean();
        
        $CI->cezpdf->addText(228,798,10,"Colegio  Particular  Evangélico");
        $CI->cezpdf->addText(235,770,14,"<b>&quot;La  Luz  de  Dios&quot;</b>");
	    
        
    	$CI->cezpdf->restoreState();
    	$CI->cezpdf->closeObject();
    	$CI->cezpdf->addObject($all,'all');
        
        /**
 * $CI->cezpdf->ezSetMargins(50,70,50,50); // margenes del documento
 *         $CI->cezpdf->ezImage(site_url("images/logo-escuela2.jpg"), 0, 100, 5, 'left');
 *         ob_end_clean();
 *         $CI->cezpdf->ezSetMargins(50,70,50,50);
 *         $CI->cezpdf->addText(228,798,10,"Colegio  Particular  Evangélico");
 *         $CI->cezpdf->addText(235,770,14,"<b>&quot;La  Luz  de  Dios&quot;</b>");
 *         $CI->cezpdf->ezText("NÓMINA DE ALUMNOS",9, array('justification'=>'center'));
 *         $CI->cezpdf->line(98,702,290,702);
 *         $CI->cezpdf->line(425,702,525,702);
 *         $CI->cezpdf->addText(57,704,8,"<b>Inspector:</b>");
 *         $CI->cezpdf->addText(405,704,8,"<b>Mes:</b>");
 *         $CI->cezpdf->setStrokeColor(0,0,0);            
 *         $CI->cezpdf->rectangle(53,677,42,15);
 *         $CI->cezpdf->setStrokeColor(0,0,0);
 *         $CI->cezpdf->rectangle(95,677,58,15);
 *         $CI->cezpdf->setStrokeColor(0,0,0);            
 *         $CI->cezpdf->rectangle(153,677,36,15);
 *         $CI->cezpdf->setStrokeColor(0,0,0);
 *         $CI->cezpdf->rectangle(189,677,100,15);
 *         $CI->cezpdf->setStrokeColor(0,0,0);
 *         $CI->cezpdf->rectangle(289,677,35,15);
 *         $CI->cezpdf->setStrokeColor(0,0,0);
 *         $CI->cezpdf->rectangle(324,677,100,15);
 *         $CI->cezpdf->setStrokeColor(0,0,0);            
 *         $CI->cezpdf->rectangle(424,677,48,15);
 *         $CI->cezpdf->setStrokeColor(0,0,0);
 *         $CI->cezpdf->rectangle(472,677,60,15);
 *         $CI->cezpdf->addText(57,682,8,"<b>Jornada:</b>    ".$jornada);
 *         $CI->cezpdf->addText(157,682,8,"<b>Curso:</b>      ".$curso);
 *         $CI->cezpdf->addText(293,682,8,"<b>Esp. :</b>       "."Fisico-Matematico");
 *         $CI->cezpdf->addText(428,682,8,"<b>Año / Lec:</b>     ".$año_lectivo);
 */
    }

?>
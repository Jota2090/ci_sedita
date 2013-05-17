<?php
class Cursoparalelopersonal_join extends grocery_CRUD_Model
{
    function get_list()
    {
    	if($this->table_name === null)
    		return false;
    	
    	$select = "{$this->table_name}.*";
        $select .= ", curso.cur_nombre, especializacion.esp_nombre, paralelo.par_nombre, jornada.jor_nombre";
		
		
    	if(!empty($this->relation))
    		foreach($this->relation as $relation)
    		{
    			list($field_name , $related_table , $related_field_title) = $relation;
    			$unique_join_name = $this->_unique_join_name($field_name);
    			$unique_field_name = $this->_unique_field_name($field_name);
    			
				if(strstr($related_field_title,'{'))
    				$select .= ", CONCAT('".str_replace(array('{','}'),array("',COALESCE({$unique_join_name}.",", ''),'"),str_replace("'","\\'",$related_field_title))."') as $unique_field_name";
    			else    			
    				$select .= ", $unique_join_name.$related_field_title as $unique_field_name";
    			
    			if($this->field_exists($related_field_title))
    				$select .= ", {$this->table_name}.$related_field_title as '{$this->table_name}.$related_field_title'";
    		}
    		
    	$this->db->select($select, false);
        $this->db->join('curso_paralelo','curso_paralelo.cp_id = personal_curso.pc_curso_paralelo_id');
        $this->db->join('curso','curso.cur_id = curso_paralelo.cp_curso_id');
        $this->db->join('especializacion','especializacion.esp_id = curso_paralelo.cp_especializacion_id');
        $this->db->join('paralelo','paralelo.par_id = curso_paralelo.cp_paralelo_id');
        $this->db->join('jornada','jornada.jor_id = curso_paralelo.cp_jornada_id');
		
    	$results = $this->db->get($this->table_name)->result();
    	
    	return $results;
    }
}
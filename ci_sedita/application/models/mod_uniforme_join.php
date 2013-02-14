<?php
class Mod_uniforme_join extends grocery_CRUD_Model
{
    function get_list()
    {
    	if($this->table_name === null)
    		return false;
    	
    	$select = "{$this->table_name}.*";
    	
		// ADD YOUR SELECT FROM JOIN HERE <------------------------------------------------------
		// for example $select .= ", user_log.created_date, user_log.update_date";
        //$select .= ", representante.rep_nombres";
        $select .= ", estado_activos.estado_id , estado_activos.estado_nombre, tipo_activos.tipo_id , tipo_activos.tipo_nombre, talla_uniforme.talla_id , talla_uniforme.talla_nombre";
		
		
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
    	
		// ADD YOUR JOIN HERE for example: <------------------------------------------------------
		// $this->db->join('user_log','user_log.user_id = users.id');
        $this->db->join('estado_activos','estado_activos.estado_id = uniforme.uniforme_estado');
        $this->db->join('tipo_activos','tipo_activos.tipo_id = uniforme.uniforme_tipo');
        $this->db->join('talla_uniforme','talla_uniforme.talla_id = uniforme.uniforme_talla');
		
    	$results = $this->db->get($this->table_name)->result();
    	
    	return $results;
    }
    
}
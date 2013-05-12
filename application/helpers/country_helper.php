 <?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('country_dropdown'))
{
    function  country_dropdown ( $name="country",$id="country", $top_countries=array(), $selection=NULL, $disabled="", $show_all=TRUE )  {
        // You may want to pull this from an array within the helper
        $CI =& get_instance();
        $CI->config->load('form');
        $countries = $CI->config->item('country_list');
        
        $html = "<select disabled='{$disabled}' name='{$name}' id='{$id}' style='width:138px;'>";
        $selected = NULL;
    
        if($show_all)  {
            foreach($countries as $key => $country)  {
                if($country === $selection)  {
                    $selected = "SELECTED";
                }
                $html .= "<option value='{$country}' {$selected}>{$country}</option>";
                $selected = NULL;
             }
        }
    
        $html .= "</select>";
        return $html;
    }
}
?>  
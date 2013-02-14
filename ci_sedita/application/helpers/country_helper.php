 <?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('country_dropdown'))
{
    function  country_dropdown ( $name="country",$id="country", $top_countries=array(), $selection=NULL, $show_all=TRUE )  {
        // You may want to pull this from an array within the helper
        $CI =& get_instance();
        $CI->config->load('form');
        $countries = $CI->config->item('country_list');
        
        if (empty($top_countries))
            $top_countries = $CI->config->item('top_countries');
    
        $html = "<select name='{$name}' id='{$id}' style='width:138px;'>";
        $selected = NULL;
        if(in_array($selection,$top_countries))  {
            $top_selection = $selection;
            $all_selection = NULL;
            }
        else  {
            $top_selection = NULL;
            $all_selection = $selection;
            }
    
        if(!empty($top_countries))  {
            foreach($top_countries as $value)  {
                if(array_key_exists($value, $countries))  {
                    if($value === $top_selection)  {
                        $selected = "SELECTED";
                        }
                     //$html .= "<option value='{$value}' {$selected}>{$countries[$value]}</option>";
                    $selected = NULL;
                    }
                }
            //$html .= "<option>----------</option>";
            }
    
        if($show_all)  {
            foreach($countries as $key => $country)  {
                if($key === "EC")  {
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
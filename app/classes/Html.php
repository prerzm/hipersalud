<?php

class Html {

    public static function select_options($data_array, $id, $name, $selected_id="") {

        $str = "";
        if(is_array($data_array) && count($data_array)>0) {
            foreach($data_array as $d) {
                $str .= ((int)$d[$id]==(int)$selected_id) ? "<option value=\"".$d[$id]."\" selected=\"selected\">".$d[$name]."</option>\n" : "<option value=\"".$d[$id]."\">".$d[$name]."</option>\n";
            }
        }
        return $str;
    }

    function form_select_options_numbers($start=0, $end=10, $steps=1, $selected_id="") {

        # vars
        $str_options	= "";
        
        # process
        for($i=$start; $i<=$end; $i+=$steps) {
    
            if($i==$selected_id) {
                $str_options .= '<option value="'.$i.'" selected>'.$i.'</option>'."\n";
            } else {
                $str_options .= '<option value="'.$i.'">'.$i.'</option>'."\n";
            }
    
        }
        
        # return formed string
        return $str_options;
    
    }
    
    
    # Return the html code for a select of hours
    function form_select_options_hours($start=9, $end=19, $steps=30, $selected_id="") {
    
        # vars
        $str_options	= "";
        
        # process
        for($i=$start; $i<=$end; $i++) {
    
            if($steps>0) {
                for($j=0; $j<60; $j+=$steps) {
                    $hours = ($i<10) ? "0".$i : $i;
                    $value = ($j==0) ? $hours.":00" : $hours.":".$j;
                    if($value==$selected_id) {
                        $str_options .= '<option value="'.$value.'" selected>'.$value.'</option>'."\n";
                    } else {
                        $str_options .= '<option value="'.$value.'">'.$value.'</option>'."\n";
                    }
                }
            }
        }
        
        # return formed string
        return $str_options;
    
    }    
    
}
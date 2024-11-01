<?php
    /**
    * Author: Agile Infoways
    * Author URI: http://agileinfoways.com
    */
?>
<?php
    //Global Query
    function wcmb_meta_getquery($query){
        global $wpdb;  
        $wpdb->query( $wpdb->prepare( $query,""));
    }
    //Get Queries
    function wcmb_meta_select_data($tablename,$where,$select = '*'){
        global $wpdb;  
        $q = "SELECT $select FROM $tablename WHERE $where";    
        $result = $wpdb->get_results($q);
        return $result;
    }
    //Update Queries
    function wcmb_meta_update_data($tablename,$values,$where){
        global $wpdb;  
        $q = $wpdb->update($tablename, $values, $where);
        wcmb_meta_getquery($q);
        return ;
    }
    //Insert Queries
    function wcmb_meta_insert_data($tablename,$fields,$format){
        global $wpdb;
        $q = $wpdb->insert($tablename,$fields,$format);
        wcmb_meta_getquery($q);
        return $lastid = $wpdb->insert_id;
    }
    //Delete Queries
    function wcmb_meta_delete_data($tablename,$field,$value,$format){
        global $wpdb;
        if(is_array($value)){
            for ($i=0; $i<=count($value); $i++){
                $q = $wpdb->delete($tablename, array($field=>sanitize_text_field($value[$i])), array($format));
                wcmb_meta_getquery($q);
            }
        }else{
            $q = $wpdb->delete($tablename, array($field=>sanitize_text_field($value)), array($format));
            wcmb_meta_getquery($q);
        }
    }
    function wcmb_meta_delete_postdeta_data($tablename,$field,$meta_field,$value,$format){
        global $wpdb;
        for ($i=0; $i<count($value); $i++){
            $q = $wpdb->delete($tablename, array($field=>$meta_field.sanitize_text_field($value[$i])), array($format));
            wcmb_meta_getquery($q);
        }
    }
?>
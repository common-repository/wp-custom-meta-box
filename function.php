<?php
    /**
    * Author: Agile Infoways
    * Author URI: http://agileinfoways.com
    */
?>
<?php
    function wcmb_metabox_menu(){
        $my_plugins_page = add_menu_page('Wp Custom Meta Box', 'Wp Custom Meta Box', 'manage_options', 'metabox-listing', 'wcmb_metabox_listing');
        add_submenu_page('metabox-listing', 'Wp Custom Meta Box', 'Wp Custom Meta Box', 'manage_options', 'metabox-listing', 'wcmb_metabox_listing');
        add_submenu_page('metabox-listing', 'Help',               'Help',               'manage_options', 'custom_meta_help','wcmb_custom_meta_help' );
    }

    //This Function will add script/css for admin section
    function wcmb_metabox_adminscripts(){
        wp_enqueue_script('metabox_script',  plugins_url('/wp_custom_meta_box/js/metabox_js.js'));
        wp_register_style('metabox_css',     plugins_url('/wp_custom_meta_box/css/metabox_css.css'));
        wp_enqueue_style('metabox_css');
    }
    //add script for particular page
    if($_GET['page']=='metabox-listing' || $_GET['post']!=''){
        add_action( 'init', 'wcmb_metabox_adminscripts' );
    }

    //This function called when plugin installed
    function wcmb_metabox_install(){
        if ( is_plugin_active('wp_multiple_meta_box/multiple_meta_box.php') ) {
            echo 'Please Deactivate Multiple metabox plugin to activate this plugin'; 
            exit;
        }
        global $wpdb;
        global $table_metabox_metabox;
        global $table_metabox_fields;
        global $table_metabox_fieldtype;

        $sql_exist = "DROP TABLE IF EXISTS $table_metabox_metabox";
        require_once(ABSPATH .'wp-admin/includes/upgrade.php');
        dbDelta($sql_exist);

        $sql = "CREATE TABLE  $table_metabox_metabox (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        metabox_field_type VARCHAR(150),    
        metabox_field_title VARCHAR(150),
        metabox_field_created_date  datetime,
        UNIQUE KEY id (id)
        );";
        require_once(ABSPATH .'wp-admin/includes/upgrade.php');
        dbDelta($sql);

        $sql_exist = "DROP TABLE IF EXISTS $table_metabox_fields";
        require_once(ABSPATH .'wp-admin/includes/upgrade.php');
        dbDelta($sql_exist);

        $sql = "CREATE TABLE  $table_metabox_fields (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        metabox_field_label VARCHAR(150),
        metabox_field_type VARCHAR(150),
        metabox_field_title VARCHAR(50),
        metabox_field_field_type VARCHAR(150),
        metabox_field_value VARCHAR(150),
        metabox_field_post_type VARCHAR(150),
        metabox_field_required BOOLEAN,
        metabox_field_placeholder VARCHAR(50),
        metabox_field_minlength int,
        metabox_field_maxlength int,
        metabox_field_status  BOOLEAN,
        metabox_field_created_date  datetime,
        UNIQUE KEY id (id)
        );";
        require_once(ABSPATH .'wp-admin/includes/upgrade.php');
        dbDelta($sql);

        $sql_exist = "DROP TABLE IF EXISTS $table_metabox_fieldtype";
        require_once(ABSPATH .'wp-admin/includes/upgrade.php');
        dbDelta($sql_exist);

        $sql = "CREATE TABLE  $table_metabox_fieldtype (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        metabox_field_type_id mediumint(9),
        metabox_field_fieldtype VARCHAR(150),
        metabox_field_fieldvalue VARCHAR(150),
        metabox_field_created_date  datetime,
        UNIQUE KEY id (id)
        );";
        require_once(ABSPATH .'wp-admin/includes/upgrade.php');
        dbDelta($sql);

        //insert data in metebox_metabox table.
        $format   = array("%s","%s","%s");
        $fields   = array(
            "metabox_field_type"         => "textbox", 
            "metabox_field_title"        => "Text Box",
            "metabox_field_created_date" => date("Y-m-d", strtotime("now"))
            );
        wcmb_meta_insert_data($table_metabox_metabox,$fields,$format);
        $fields   = array(
            "metabox_field_type"         => "textarea", 
            "metabox_field_title"        => "Text Area",
            "metabox_field_created_date" => date("Y-m-d", strtotime("now"))
            );
        wcmb_meta_insert_data($table_metabox_metabox,$fields,$format);
        $fields   = array(
            "metabox_field_type"         => "checkbox", 
            "metabox_field_title"        => "Check Box",
            "metabox_field_created_date" => date("Y-m-d", strtotime("now"))
            );
        wcmb_meta_insert_data($table_metabox_metabox,$fields,$format);
        $fields   = array(
            "metabox_field_type"         => "dropdown", 
            "metabox_field_title"        => "Drop Down",
            "metabox_field_created_date" => date("Y-m-d", strtotime("now"))
            );
        wcmb_meta_insert_data($table_metabox_metabox,$fields,$format);
        $fields   = array(
            "metabox_field_type"         => "radio",
            "metabox_field_title"        => "Radio Button",
            "metabox_field_created_date" => date("Y-m-d", strtotime("now"))
            );
        wcmb_meta_insert_data($table_metabox_metabox,$fields,$format);

        // insert data metabox_fieldtype.
        $format  = array("%d","%s","%s","%s");
        $fields  = array(
            "metabox_field_type_id"      => "1",
            "metabox_field_fieldtype"    => "text",
            "metabox_field_fieldvalue"   => "Text",
            "metabox_field_created_date" => date("Y-m-d", strtotime("now")),
            );
        wcmb_meta_insert_data($table_metabox_fieldtype,$fields,$format);
        $fields  = array(
            "metabox_field_type_id"      => "1",
            "metabox_field_fieldtype"    => "email",
            "metabox_field_fieldvalue"   => "Email Address",
            "metabox_field_created_date" => date("Y-m-d", strtotime("now")),
            );
        wcmb_meta_insert_data($table_metabox_fieldtype,$fields,$format);
        $fields  = array(
            "metabox_field_type_id"      => "1",
            "metabox_field_fieldtype"    => "password",
            "metabox_field_fieldvalue"   => "Password",
            "metabox_field_created_date" => date("Y-m-d", strtotime("now")),
            );
        wcmb_meta_insert_data($table_metabox_fieldtype,$fields,$format);
        $fields  = array(
            "metabox_field_type_id"      => "1",
            "metabox_field_fieldtype"    => "number",
            "metabox_field_fieldvalue"   => "Number",
            "metabox_field_created_date" => date("Y-m-d", strtotime("now")),
            );
        wcmb_meta_insert_data($table_metabox_fieldtype,$fields,$format);
        $fields  = array(
            "metabox_field_type_id"      => "1",
            "metabox_field_fieldtype"    => "file",
            "metabox_field_fieldvalue"   => "File",
            "metabox_field_created_date" => date("Y-m-d", strtotime("now")),
            );
        wcmb_meta_insert_data($table_metabox_fieldtype,$fields,$format);
    }

    //This function called when plugin uninstalled.
    function wcmb_metabox_uninstall(){
        global $wpdb;
        global $table_metabox_fields;
        global $table_metabox_metabox;
        global $table_metabox_fieldtype;
        global $table_postmeta;

        $metaidList = $wpdb->get_results("SELECT id FROM ".$table_metabox_fields." WHERE metabox_field_status='1'", ARRAY_A);
        //Delete meta box data from postmeta table.
        for($i=0; $i<count($metaidList); $i++){
            $field= 'meta_key';
            wcmb_meta_delete_data($table_postmeta,$field,"meta_field_".$metaidList[$i][id], "%s");
        }
        $sql = "DROP TABLE $table_metabox_metabox";
        require_once(ABSPATH .'wp-admin/includes/upgrade.php');
        $wpdb->query($sql);
        $sql = "DROP TABLE $table_metabox_fields";
        require_once(ABSPATH .'wp-admin/includes/upgrade.php');
        $wpdb->query($sql);
        $sql = "DROP TABLE $table_metabox_fieldtype";
        require_once(ABSPATH .'wp-admin/includes/upgrade.php');
        $wpdb->query($sql);
    }

    function wcmb_custom_meta_help(){
        include('admin/help.php');
    }

    //This function for database and redirct to link when menu called 
    function wcmb_metabox_listing(){
        global $wpdb;
        global $table_metabox_fields;
        global $table_metabox_metabox;
        global $table_metabox_fieldtype;
        global $table_postmeta;

        $metabox_field_value = implode(",",(array)$_POST['metabox_field_post_type']);

        if($_POST['my_meta_box_select']!='textbox'){
            $_POST['metabox_field_field_type']="";
        }
        $metabox_field_value1 = array_unique((explode(',',sanitize_text_field($_POST['metabox_field_value1']))));
        $metabox_field_value1 = implode(',', array_filter(array_map('trim',$metabox_field_value1),'strlen'));
        //insert record in database
        if($_POST['original_publish']=='Add'){
            $fields  = array(
                "id"                         => "NULL",
                "metabox_field_label"        => trim(sanitize_text_field($_POST['metabox_field_label'])),
                "metabox_field_type"         => sanitize_text_field($_POST['my_meta_box_select']),
                "metabox_field_title"        => trim(sanitize_text_field($_POST['metabox_field_id'])),
                "metabox_field_field_type"   => sanitize_text_field($_POST['metabox_field_field_type']),
                "metabox_field_value"        => $metabox_field_value1,
                "metabox_field_post_type"    => sanitize_text_field($metabox_field_value),
                "metabox_field_required"     => sanitize_text_field($_POST['metabox_field_required']),
                "metabox_field_placeholder"  => trim(sanitize_text_field($_POST['metabox_field_placeholder'])),
                "metabox_field_minlength"    => sanitize_text_field($_POST['metabox_field_minlength']),
                "metabox_field_maxlength"    => sanitize_text_field($_POST['metabox_field_maxlength']),
                "metabox_field_status"       => sanitize_text_field($_POST['metabox_field_status']),
                "metabox_field_created_date" => date("Y-m-d", strtotime("now"))
                );
            $position = array( "%d", "%s", "%s", "%s", "%s", "%s", "%s", "%s", "%s", "%s", "%s", "%s", "%s"
                );
            wcmb_meta_insert_data($table_metabox_fields,$fields,$position);
            $message            = '<span style="color:green;"><b>Inserted Successfully.</b></span>';
            $_REQUEST['action'] = '';
        }
        //update record in database
        if($_POST['original_publish']=='Update'){

            $fields  = array(
                "metabox_field_label"       => trim(sanitize_text_field($_POST['metabox_field_label'])),
                "metabox_field_type"        => sanitize_text_field($_POST['my_meta_box_select']),
                "metabox_field_title"       => trim(sanitize_text_field($_POST['metabox_field_id'])),
                "metabox_field_field_type"  => sanitize_text_field($_POST['metabox_field_field_type']),
                "metabox_field_value"       => $metabox_field_value1,
                "metabox_field_post_type"   => sanitize_text_field($metabox_field_value),
                "metabox_field_required"    => sanitize_text_field($_POST['metabox_field_required']),
                "metabox_field_placeholder" => trim(sanitize_text_field($_POST['metabox_field_placeholder'])),
                "metabox_field_minlength"   => sanitize_text_field($_POST['metabox_field_minlength']),
                "metabox_field_maxlength"   => sanitize_text_field($_POST['metabox_field_maxlength']),
                "metabox_field_status"      => sanitize_text_field($_POST['metabox_field_status'])
                );
            $where   = array(
                'id' => sanitize_text_field($_POST['id']));
            wcmb_meta_update_data($table_metabox_fields,$fields,$where);  
            $message = '<span style="color:green;"><b>Updated Successfully.</b></span>';
            $_REQUEST['action'] ='';
        }
        //delete record from database
        if($_REQUEST['action']=='delete' || $_REQUEST['action2']=='delete'){
            if($_REQUEST['id']!=''){
                wcmb_meta_delete_data($table_metabox_fields,'id',sanitize_text_field($_REQUEST['id']), "%d");
                wcmb_meta_delete_data($table_postmeta,'meta_key',"meta_field_".sanitize_text_field($_REQUEST['id']), "%s");
                $message = '<span style="color:red;"><b>Deleted Successfully.</b></span>';
            }elseif(count($_REQUEST['item'])>0){
                wcmb_meta_delete_data($table_metabox_fields,'id',$_REQUEST['item'], "%d");
                wcmb_meta_delete_postdeta_data($table_postmeta,'meta_key',"meta_field_",$_REQUEST['item'], "%s");
                $message = '<span style="color:red;"><b>Deleted Successfully.</b></span>';
            }else{
                $message = '<span style="color:red;"><b>No Data Found.</b></span>';
            }
            $_REQUEST['action'] = '';
        }
        //Page Redirction
        if($_REQUEST['action']=='add' || $_REQUEST['action']=='edit'){
            include('admin/edit_metabox.php');
        }else{
            include('admin/metabox_inventory_details.php');
        }
    }
    /**
    * Adds a box to the main column on the Post and Page edit screens.
    */
    function wcmb_adding_custom_meta_boxes($post){
        global $wpdb;
        global $table_metabox_fields;
        global $table_metabox_metabox;

        $fieldtypeList = $wpdb->get_results("SELECT * FROM ".$table_metabox_fields." WHERE metabox_field_status='1' ORDER BY id ASC");
        foreach($fieldtypeList as $fieldtype):
            $screens = explode(',',$fieldtype->metabox_field_post_type);

            foreach ($screens as $screen ):
                add_meta_box(
                    $fieldtype->id,                       // Unique ID
                    $fieldtype->metabox_field_label,      // Box title
                    'wcmb_render_my_meta_box',            // Content callback
                    $screen,                              // Post types
                    'normal',                             // Section Should Be Shown
                    'low',                                // Priority
                    array('id' => $fieldtype->id)         // Args
                );
            endforeach;
        endforeach;
    }
    add_action('add_meta_boxes','wcmb_adding_custom_meta_boxes');

    /**
     * Prints the box content.
     * 
     * @param WP_Post $post The object for the current post/page.
     */
    function wcmb_render_my_meta_box($post, $metabox){
        global $wpdb;
        global $table_metabox_fields;
        global $table_metabox_metabox;

        // Add a nonce field so we can check for it later.
        wp_nonce_field('wcmb_custom_meta_box_save_data', 'wcmb_custom_meta_box_nonce');

        $fieldtypeList = $wpdb->get_results("SELECT * FROM ".$table_metabox_fields." WHERE metabox_field_status='1' ORDER BY id ASC");
        
        foreach($fieldtypeList as $fieldtype):
            if($metabox['args']['id']==$fieldtype->id){
                //Geting value useing get_post_meta() to retrieve an existing value
                echo '<div id="custom_meta_field" >';
                $value = get_post_meta( $post->ID, 'meta_field_'.$fieldtype->id, true );
                echo '<label for="custommetabox_new_field">';
                _e( $fieldtype->metabox_field_title, 'custommetabox_textdomain' );
                echo '</label> ';
                if($fieldtype->metabox_field_type=="textbox"){
                    if($fieldtype->metabox_field_field_type=="file"){
                        echo '<input value="'.esc_attr( $value ).'" type="text" '. (($fieldtype->metabox_field_minlength>0)?' minlength="'.$fieldtype->metabox_field_minlength.'"':"").' '. (($fieldtype->metabox_field_maxlength>0)?'maxlength="'.$fieldtype->metabox_field_maxlength.'"':"").' name="'.$fieldtype->id.'" id="'.$fieldtype->metabox_field_title.'" '. (($fieldtype->metabox_field_required=='1')?'required="required"':"").'   placeholder="'.$fieldtype->metabox_field_placeholder.'" size="25" class="meta_box_file" /><br/>';
                    }else{
                        echo '<input value="'.esc_attr( $value ).'" type="'.$fieldtype->metabox_field_field_type.'" '. (($fieldtype->metabox_field_minlength>0)?'minlength="'.$fieldtype->metabox_field_minlength.'"':"").' '. (($fieldtype->metabox_field_maxlength>0)?'maxlength="'.$fieldtype->metabox_field_maxlength.'"':"").' name="'.$fieldtype->id.'" id="'.$fieldtype->metabox_field_title.'" '. (($fieldtype->metabox_field_required=='1')?'required="required"':"").'   placeholder="'.$fieldtype->metabox_field_placeholder.'" size="25" class="meta_box_text" /><br/>';
                    }
                }if($fieldtype->metabox_field_type=="textarea"){
                    echo '<textarea class="meta_box_textarea" name="'.$fieldtype->id.'" id="'.$fieldtype->metabox_field_title.'" '.(($fieldtype->metabox_field_required=='1')?'required="required"':"").'   placeholder="'.$fieldtype->metabox_field_placeholder.'">'.esc_attr( $value ).'</textarea>' ;
                }if($fieldtype->metabox_field_type=="dropdown"){
                    $option_value= explode(',',$fieldtype->metabox_field_value);
                    echo '<select class="meta_box_dropdown" name="'.$fieldtype->id.'" id="'.$fieldtype->metabox_field_title.'" '.(($fieldtype->metabox_field_required=='1')?'required="required"':"").'> ';
                    echo '<option value="">Select</option>';
                    foreach($option_value as $optionvalue):
                        if(trim($optionvalue)!=""){
                            ?><option value="<?php  echo trim(esc_attr($optionvalue)); ?>" <?php if(trim($optionvalue)==$value){?>selected="selected"<?php } ?> ><?php echo trim($optionvalue); ?></option><?php
                        }
                    endforeach;
                    echo '</select>';
                }if($fieldtype->metabox_field_type=="checkbox"){
                    $option_value= explode(',',trim($fieldtype->metabox_field_value));
                    echo '<br/>';
                    foreach($option_value as $optionvalue):
                        if(trim($optionvalue)!=""){
                            ?><input class="meta_box_checkbox" type="<?php echo $fieldtype->metabox_field_type; ?>" id="<?php echo $fieldtype->metabox_field_title; ?>" name="<?php echo $fieldtype->id.'[]'; ?>" value="<?php echo trim(esc_attr($optionvalue)); ?>" <?php if(in_array(trim($optionvalue),explode(',',$value))){?>checked="checked"<?php } ?> ><?php echo trim(esc_attr($optionvalue)).' ';?><?php
                        }
                    endforeach;

                }if($fieldtype->metabox_field_type=="radio"){
                    $option_value= explode(',',$fieldtype->metabox_field_value);
                    echo '<br/>';
                    foreach($option_value as $optionvalue):
                    if(trim($optionvalue)!=""){
                        ?><input class="meta_box_radio" type="<?php echo $fieldtype->metabox_field_type; ?>" id="<?php echo $fieldtype->metabox_field_title; ?>" name="<?php echo $fieldtype->id; ?>" value="<?php echo trim(esc_attr($optionvalue)); ?>" <?php if(trim($optionvalue)==$value){?>checked="checked"<?php } ?> ><?php echo trim(esc_attr($optionvalue)).' ';?><?php
                    }
                    endforeach;
                }
                echo '</div>';
            }
        endforeach;
    }

    /**
     * When the post is saved, saves our custom data.
     *
     * @param int $post_id The ID of the post being saved.
     */
    function wcmb_custom_meta_box_save_data($post_id){
        global $wpdb;
        global $table_metabox_fields;
        global $table_metabox_metabox;

        /*
         * We need to verify this came from our screen and with proper authorization,
         * because the save_post action can be triggered at other times.
         */
        // Check if our nonce is set.
        if (!isset($_POST['wcmb_custom_meta_box_nonce'])){
            return;
        }
        // Verify that the nonce is valid.
        if (!wp_verify_nonce($_POST['wcmb_custom_meta_box_nonce'], 'wcmb_custom_meta_box_save_data')){
            return;
        }
        // If this is an autosave, our form has not been submitted, so we don't want to do anything.
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE){
            return;
        }
        // Check the user's permissions.
        if(isset($_POST['post_type']) && 'page' ==$_POST['post_type']){
            if (!current_user_can('edit_page', $post_id)){
                return;
            }
        }else{
            if (!current_user_can('edit_post', $post_id)){
                return;
            }
        }
        
        //Save and Update Data.
        $fieldtypeList = $wpdb->get_results("SELECT * FROM ".$table_metabox_fields." WHERE metabox_field_status='1'");
        foreach( $fieldtypeList as $fieldtype ):
            if($fieldtype->metabox_field_type=='checkbox' ){
                //Check if checkbox set multivalue
                foreach($_POST[$fieldtype->id] as $check) {
                    echo $check.'<br>';
                    $my_value[]= $check;
                }
                $my_data = implode(',', $my_value);
                $my_value = array();
            }else{
                $my_data = sanitize_text_field($_POST[$fieldtype->id]);
            }
            // Update the meta field in the database.
            update_post_meta($post_id,'meta_field_'.$fieldtype->id, $my_data);
        endforeach;
        
    }
    add_action('save_post','wcmb_custom_meta_box_save_data');

    function wcmb_custom_meta_display_the_content($content){
        global $wpdb;
        global $table_metabox_fields;
        global $table_metabox_metabox;
        
        //for checked post type
        $post  = get_post_type();
        
        $data  = "";
        $data .= $content;

        $fieldtypeList = $wpdb->get_results("SELECT * FROM ".$table_metabox_fields." WHERE metabox_field_status='1' AND metabox_field_post_type LIKE '%".$post."%' ORDER BY id ASC");
        foreach( $fieldtypeList as $fieldtype ):
            $should_hide_content = get_post_meta(get_the_ID(),'meta_field_'.$fieldtype->id,true);
            if($fieldtype->metabox_field_field_type=='file' && $should_hide_content!=""){
                    $data .= '<div id="custom_metabox_id" class="custom_metabox">';
                    $data .= '<h3 class="custom_metabox_title">'.$fieldtype->metabox_field_title.'</h3>';
                    $data .= '<a class="custom_metabox_href" href="'.esc_attr($should_hide_content).'" target="_blank">'.esc_attr(end(split('/',$should_hide_content))).'</a> ';
                    $data .= '</div>';
            }
            else if($should_hide_content!=""){
                $data .= '<div id="custom_metabox_id" class="custom_metabox" >';
                $data .= '<h3 class="custom_metabox_title" >'.$fieldtype->metabox_field_label.'</h3>';
                if($fieldtype->metabox_field_field_type=='password'){
                    $length = strlen(esc_attr($should_hide_content));
                    $data  .= '<label class="custom_metabox_label">'.esc_attr($fieldtype->metabox_field_title).': <span class="custom_metabox_value">';
                    for($i=0; $i<$length; $i++){
                        $data .= '*';
                    }
                    $data  .= '</span>';
                }else if($fieldtype->metabox_field_field_type=='email'){
                    $data  .= '<label class="custom_metabox_label" >'.esc_attr($fieldtype->metabox_field_title).': <a class="custom_metabox_value" href="mailto:'.esc_attr($should_hide_content).'">'.esc_attr($should_hide_content).' </a>' ;

                }else{
                    $data .= '<label class="custom_metabox_label">'.esc_attr($fieldtype->metabox_field_title).':</label>  <span class="custom_metabox_value">'.esc_attr($should_hide_content).'</span>' ;
                }
                $data .= '</div>';
            }
        endforeach;
        return $data;
    }
    add_filter('the_content','wcmb_custom_meta_display_the_content');
?>

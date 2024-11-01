<?php
    /**
    * Author: Agile Infoways
    * Author URI: http://agileinfoways.com
    */
?>
<?php
   $metaboxItem = $wpdb->get_results($wpdb->prepare("SELECT * FROM ".$table_metabox_fields." where id = %d",sanitize_text_field($_REQUEST['id'])));
	if($_REQUEST['action']=='add'){
        $title ='Add New';
        $label ='Add';
    }else{
        $title ='Edit';
        $label ='Update';
    }
	$fieldtypeList = $wpdb->get_results("SELECT * FROM ".$table_metabox_metabox);
		$args = array(
			'public'   => true,
			'_builtin' => false,
		);
    ?>
    <div style="overflow: hidden;" id="wpbody-content" aria-label="Main content" tabindex="0">
	    <div class="wrap">
	    	<h2><?php echo $title;?> Metabox</h1>
	    	<form name="post" action="<?php echo home_url().'/wp-admin/admin.php?page=metabox-listing' ?>" method="post" id="post">
	    		<input type="hidden" name="id" value="<?php echo $metaboxItem[0]->id;?>">
	    		<div id="poststuff">
                	<div id="post-body" class="metabox-holder columns-2">
                		<div id="post-body-content">

					        <label for="metabox_field_label">Meta Box Label:</label>
					        <div id="titlediv">
			                	<div id="titlewrap" class="boxclass">
					        		<input name="metabox_field_label" value="<?php echo $metaboxItem[0]->metabox_field_label; ?>" id="metabox_field_label" type="text" class="textbox length">
					        	</div>
					    	</div>
					        <label for="my_meta_box_post_type">Field Type: 	</label><br/>
					        <select name='my_meta_box_select' id='my_meta_box_select' class="selectclass">
					        	<option value="" >Select Option</option>
					            <?php foreach( $fieldtypeList as $fieldtype ): ?>
					            	<option value="<?php  echo $fieldtype->metabox_field_type; ?>" <?php if($metaboxItem[0]->metabox_field_type==$fieldtype->metabox_field_type){echo 'selected="selected"';}?>  ><?php  echo $fieldtype->metabox_field_title; ?></option>
					            <?php endforeach; ?>
					        </select>
					        <div id="textbox_display" style="display: none;">
				        		<label for="metabox_field_field_type">Meta Field Type: </label><br/>
				        		<select name="metabox_field_field_type" id="metabox_field_field_type">
				        			<?php $textfieldList = $wpdb->get_results("SELECT * FROM ".$table_metabox_fieldtype." WHERE metabox_field_type_id=1");
				        				foreach ($textfieldList as $texttype): ?>
				        				<option value="<?php echo $texttype->metabox_field_fieldtype; ?>" <?php if($metaboxItem[0]->metabox_field_field_type==$texttype->metabox_field_fieldtype){echo 'selected="selected"';}?>><?php echo $texttype->metabox_field_fieldvalue;?></option>
				        			<?php endforeach; ?>
				        		</select>
					        </div>
					        
					        <div>
						        <label for="metabox_field_id">Meta Field Title: </label>
						        <div id="titlediv">
				                	<div id="titlewrap" class="boxclass">
						        		<input name="metabox_field_id" value="<?php echo $metaboxItem[0]->metabox_field_title; ?>" id="metabox_field_id" type="text" class="textbox length1">
						        	</div>
						    	</div>
					    	</div>
					    	<div id="dropdown_display" style="display: none;">
					        <label for="metabox_field_value">Meta Field Value: </label>
					        	<input name="metabox_field_value1" value="<?php echo $metaboxItem[0]->metabox_field_value; ?>" id="metabox_field_value" type="text" class="textbox length">
					        	<p style="color:red">Note: Please Put Value with Comma Separated  Ex: Gender Male,Female</p>
					        </div>

					        <label for="metabox_field_post_type">Meta Field Post Type: </label><br/>
						        <?php $metaboxItem[0]->metabox_field_post_type; 
						         $field_post_type = explode(",",$metaboxItem[0]->metabox_field_post_type);
						          if(count($field_post_type)>=1){ ?>
							        <fieldset id="checkArray">
										<input  type="checkbox" <?php if(in_array('post', $field_post_type)){echo 'checked="checked"';}?> name="metabox_field_post_type[]"  value="post"><b>Posts&nbsp;&nbsp;</b>
										<input  type="checkbox" <?php if(in_array('page', $field_post_type)){echo 'checked="checked"';}?> name="metabox_field_post_type[]" value="page"><b>Pages&nbsp;&nbsp;</b>
									</fieldset>
									<?php }else{ ?>
									<fieldset id="checkArray">
										<input  type="checkbox"  name="metabox_field_post_type[]" value="post"><b>Posts&nbsp;&nbsp;</b>
										<input  type="checkbox"  name="metabox_field_post_type[]" value="page"><b>Pages</b>&nbsp;&nbsp;</b>
									</fieldset>
								<?php } ?>
							<div id="required" >	
						        <label for="metabox_field_required">Meta Field Required: </label><br/>
						        <select name="metabox_field_required" id="metabox_field_required">
						        	<option value="1" <?php if($metaboxItem[0]->metabox_field_required==1){echo 'selected="selected"';}?>>True</option>
						        	<option value="0" <?php if($metaboxItem[0]->metabox_field_required==0){echo 'selected="selected"';}?>>False</option>
						    	</select><br/>
					    	</div>
					       	
					       	<div id="textbox_textarea_display" style="display: none;">
						        <label for="metabox_field_placeholder">Meta Field Place Holder: </label>
						        <input name="metabox_field_placeholder" value="<?php echo $metaboxItem[0]->metabox_field_placeholder; ?>" id="metabox_field_placeholder" type="text" class="textbox length">
						        <div id="minlength_maxlength" >
							        <label for="metabox_field_minlength">Meta Field Min Length: </label>
							        <input name="metabox_field_minlength" value="<?php if($metaboxItem[0]->metabox_field_minlength!=0)echo $metaboxItem[0]->metabox_field_minlength; ?>"  onkeypress="return isNumber(event)" maxlength="3" id="metabox_field_minlength" type="text" class="textbox length">
							        <label for="metabox_field_maxlength">Meta Field Max Length: </label>
							        <input name="metabox_field_maxlength" value="<?php if($metaboxItem[0]->metabox_field_maxlength!=0)echo $metaboxItem[0]->metabox_field_maxlength; ?>"  onkeypress="return isNumber(event)" maxlength="3" id="metabox_field_maxlength" type="text" class="textbox length">
						        </div>
					        </div>
					        
					        <label for="metabox_field_status">Status: </label><br/>	
					       	<select name="metabox_field_status" id="metabox_field_status">
					        	<option  <?php if($_REQUEST['action']=='add'){echo 'selected="selected"'; } ?> value="1" <?php if($metaboxItem[0]->metabox_field_status==1){echo 'selected="selected"';}?>>Available</option>
					        	<option value="0" <?php if($_REQUEST['action']!='add'){ if($metaboxItem[0]->metabox_field_status==0){echo 'selected="selected"'; }} ?> >Un Available</option>
					    	</select><br/>
		        		</div>
			   			<div id="postbox-container-1" class="postbox-container">
	                        <div id="side-sortables" class="meta-box-sortables ui-sortable">
	                            <div id="submitdiv" class="postbox ">
	                                <h3 class="hndle"><span>Publish</span></h3>
	                                <div class="inside">
	                                    <div class="submitbox" id="submitpost">
	                                        <div id="major-publishing-actions">
	                                            <div id="publishing-action">
	                                                <span class="spinner"></span>
	                                                <input name="original_publish" id="original_publish" value="<?php echo $label;?>" type="hidden">
	                                                <input name="publish" id="publish" class="button button-primary button-large" value="<?php echo $label;?>" accesskey="p" type="button">
	                                            </div>
	                                            <div class="clear"></div>
	                                        </div>
	                                    </div>
	                                </div>
	                            </div>
	                        </div>
	                    </div>
	                </div>
	                <br class="clear">
	            </div><!-- /poststuff -->
        </form>
 <div class="clear"></div>
</div>
<div class="clear"></div>
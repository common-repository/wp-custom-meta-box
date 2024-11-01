
/**
* Author: Agile Infoways
* Author URI: http://agileinfoways.com
*/

    jQuery(document).ready(function() { 
    //Global Code//
    jQuery('#publish').click(function(){
        var error = validateCustomMeta();
        //for checking file type on custom post page.
        var fileerror = validateFileData();
        if(fileerror==1){
            return false;
        }
        if(error==0){
            jQuery('#post').submit();
        }
    });

    jQuery('.numberbox').keydown(function(event) {
        // Allow special chars + arrows 
        if (event.keyCode == 46 || event.keyCode == 8 || event.keyCode == 9
        || event.keyCode == 27 || event.keyCode == 13
        || (event.keyCode == 65 && event.ctrlKey === true)
        || (event.keyCode >= 35 && event.keyCode <= 39)){
            return;
        }else {
            //If it's not a number stop the keypress
            if (event.shiftKey || (event.keyCode < 48 || event.keyCode > 57) && (event.keyCode < 96 || event.keyCode > 105 )) {
                event.preventDefault();
            }
        }
    });

    function validateFileData () {
        var fileerror  = 0;
        jQuery('.fileerror').hide();
        //Checking for the valid file type
        jQuery("input[class=meta_box_file]").each(function() {
            if(jQuery(this).val()!=''){
                var file_value = jQuery(this).val();
                var filename   = file_value.split('/').pop();
                if(filename.indexOf('.')>'-1'){
                    var filename_ext = filename.split('.').pop();
                    uploaded_permitted_type = ['pdf','jpg','gif','jpeg','rar','doc','png','webm','mkv','flv','vob','ogv','gifv','mng','avi','mp4','mp3','3gp','nsv'];
                    if(jQuery.inArray(filename_ext,uploaded_permitted_type)==-1){
                        fileerror = 1;
                    }
                }else{  
                    fileerror = 1;
                }if(isValid(file_value)){
                    //valid
                }else{
                    fileerror = 1;
                }if(fileerror== 1){
                    jQuery(this).after("<p class='fileerror' style='color: red; font-weight: bold;'>Please Provide valid File type</p>");
                }
            }
        });

        function isValid(text) {
            return /\b(http|https)/.test(text);
        }
        
        return fileerror;
    }

    function validateCustomMeta () {
        var error = 0;

        jQuery( ".boxclass" ).each(function() {
            jQuery( this).children('.errormessage').text('');
        }); 

        var v1 = jQuery.trim(jQuery( ".boxclass").children('.length').val());
        if(v1=='' ){
            jQuery( ".boxclass").children('.errortitle').hide();
            jQuery( ".boxclass").children('.length').after("<p class='errortitle' style='color: red; font-weight: bold; margin: 0 0 !important;'>This Field is Required. </p>");
            error=1;
        }else if(v1.length<3 || v1.length>100){
            jQuery( ".boxclass").children('.errortitle').hide();
            jQuery( ".boxclass").children('.length').after("<p class='errortitle' style='color: red; font-weight: bold; margin: 0 0 !important;'>Please Enter Between 3 to 100 Characters.</p>");
            error=1;
        }
        else{
            jQuery( ".boxclass").children('.errortitle').hide();
        }

        var v2 = jQuery.trim(jQuery( ".boxclass").children('.length1').val());
        if(v2=='' ){
            jQuery( ".boxclass").children('.errortitle1').hide();
            jQuery( ".boxclass").children('.length1').after("<p class='errortitle1' style='color: red; font-weight: bold; margin: 0 0 !important;'>This Field is Required. </p>");
            error=1;
        }else if(v2.length<3 || v2.length>100){
            jQuery( ".boxclass").children('.errortitle1').hide();
            jQuery( ".boxclass").children('.length1').after("<p class='errortitle1' style='color: red; font-weight: bold; margin: 0 0 !important;'>Please Enter Between 3 to 100 Characters.</p>");
            error=1;
        }
        else{
            jQuery( ".boxclass").children('.errortitle1').hide();
        }

        if(jQuery('#my_meta_box_select').val()==''){
            jQuery('.errorfieldtype').hide();
            jQuery('#my_meta_box_select').after("<p class='errorfieldtype' style='color:red; font-weight: bold; margin: 0 0 !important;'> Please Select any Fieldtype.</p> ");
            error=1;
        }else{
            jQuery('.errorfieldtype').hide();
        }

        if(jQuery('#checkArray :checkbox:checked').length==0){
            jQuery('.errorcheckbox').hide();
            jQuery('#checkArray').after("<p class='errorcheckbox' style='color:red; font-weight: bold; margin: 0 0 !important;'> Please Check at least One Checkbox.</p> ");
            error=1;
        }else{
            jQuery('.errorcheckbox').hide();
        }

        if(jQuery('#metabox_field_minlength').val()!='' &&jQuery('#metabox_field_minlength').val()<1){
            jQuery('.errorminlength').hide();
            jQuery('#metabox_field_minlength').after("<p class='errorminlength' style='color:red; font-weight: bold; margin: 0 0 !important;'> Please Enter atleast 1 or Grater then 1. </p> ");
            error=1;
        }else{
            jQuery('.errorminlength').hide();
        }

        if(jQuery('#metabox_field_maxlength').val()>255){
            jQuery('.errormaxlength').hide();
            jQuery('#metabox_field_maxlength').after("<p class='errormaxlength' style='color:red; font-weight: bold; margin: 0 0 !important;'> Not Allowed Greater then 100.</p> ");
            error=1;
        }else if( parseInt(jQuery('#metabox_field_maxlength').val()) <  parseInt(jQuery('#metabox_field_minlength').val()) && jQuery('#metabox_field_maxlength').val()!=''){
            jQuery('.errormaxlength').hide();
            jQuery('#metabox_field_maxlength').after("<p class='errormaxlength' style='color:red; font-weight: bold; margin: 0 0 !important;'> Max-length should be Greater then Min-Length.</p> ");
            error=1;
        }
        else{
            jQuery('.errormaxlength').hide();
        }
        
        jQuery(".selectclass").each(function() { 
            if (jQuery( this).children('.errormessage').text()=='' && jQuery( this).children('select').val()==''){
                jQuery( this).children('.errormessage').text("Please Select Option.");
                jQuery( this).children('.errormessage').show();                            
                error=1;
            }
        });
        return error;
        }
    });
   
    //Function that restric other data then number to enter in textbox.
    function isNumber(evt) {
        evt = (evt) ? evt : window.event;
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if (charCode > 31 && (charCode < 48 || charCode > 57)) {
            return false;
        }
        return true;
    }

    jQuery(document).ready(function() {
        //Fuction for dropdown selectchanges
        jQuery("#required").css('display','block');
        if(jQuery('#my_meta_box_select').val()=='textbox'){
            jQuery("#textbox_display").css('display','block');
            jQuery("#textbox_textarea_display").css('display','block');
            jQuery("#minlength_maxlength").css('display','block');
        }if(jQuery('#my_meta_box_select').val()=='checkbox' || jQuery('#my_meta_box_select').val()=='radio'|| jQuery('#my_meta_box_select').val()=='dropdown'){
            jQuery("#dropdown_display").css('display','block');
        }if(jQuery('#my_meta_box_select').val()=='textarea'){
            jQuery("#textbox_textarea_display").css('display','block');
            jQuery("#minlength_maxlength").css('display','none');
        }if(jQuery('#my_meta_box_select').val()=='checkbox' || jQuery('#my_meta_box_select').val()=='radio'){
            jQuery("#required").css('display','none');
        }

        jQuery('#my_meta_box_select').change(function () {
            jQuery("#textbox_display").css('display','none');
            jQuery("#dropdown_display").css('display','none');
            jQuery("#textbox_textarea_display").css('display','none');
            jQuery("#checkbox_radio_display").css('display','none');
            jQuery("#required").css('display','block');
            if(this.value=="textbox"){
                jQuery("#textbox_display").css('display','block');
                jQuery("#textbox_textarea_display").css('display','block');
                jQuery("#minlength_maxlength").css('display','block');
            }if(this.value=="textarea"){
                jQuery("#minlength_maxlength").css('display','none');
                jQuery("#textbox_textarea_display").css('display','block');
            }if(this.value=="checkbox" ||this.value=="radio" || this.value=="dropdown"){
                jQuery("#dropdown_display").css('display','block');
            }if(this.value=="checkbox" ||this.value=="radio" ){
                jQuery("#required").css('display','none');
            }
        });
    });

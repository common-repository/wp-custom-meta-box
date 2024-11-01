<?php
    /**
    * Author: Agile Infoways
    * Author URI: http://agileinfoways.com
    */
?>
<?php
    if(!class_exists('WP_List_Table')){
        require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
    }

    class Metabox_List_Table extends WP_List_Table {
        
        function getAllRecords(){
            global $wpdb;
            global $table_metabox_fields;
            $metaboxList = $wpdb->get_results("SELECT * FROM ".$table_metabox_fields ." ORDER BY id ASC");
            $i=0;
            foreach ( $metaboxList as $metabox ) {
                $metaboxArray[$i]['id']                         = $metabox->id;
                $metaboxArray[$i]['metabox_field_label']        = $metabox->metabox_field_label;
                $metaboxArray[$i]['metabox_field_title']        = $metabox->metabox_field_title;
                $metaboxArray[$i]['metabox_field_type']         = $metabox->metabox_field_type;
                $status                                         = 'Not Available';
                if($metabox->metabox_field_status=='1')
                $status                                         = 'Available';
                $metaboxArray[$i]['metabox_field_status']       = $status;
                $metaboxArray[$i]['metabox_field_post_type']    = $metabox->metabox_field_post_type;
                $metaboxArray[$i]['metabox_field_created_date'] = $metabox->metabox_field_created_date;
                $i++;
            }
            return $metaboxArray;
        }
        function __construct(){
            global $status, $page;

            //Set parent defaults
            parent::__construct( array(
            'singular'  => 'item',     //singular name of the listed records
            'plural'    => 'items',    //plural name of the listed records
            'ajax'      => false       //does this table support ajax?
            ) );
        }
        function column_default($item, $column_name){
            switch($column_name){
                case 'id':
                case 'metabox_field_label':
                case 'metabox_field_title':
                case 'metabox_field_type':
                case 'metabox_field_status':
                case 'metabox_field_post_type':
                case 'metabox_field_created_date':
                    return $item[$column_name];
                default:
                    return print_r($item,true);  //Show the whole array for troubleshooting purposes
            }
        }

        function column_title($item){
            //Build row actions
            $actions = array(
            'edit'      => sprintf(
                 '<a href="?page=%s&action=%s&id=%s">Edit</a>','metabox-listing','edit',$item['id']
                ),
            'delete'    => sprintf(
                '<a  href="?page=%s&action=%s&id=%s"  class="deleteitem">Delete</a>','metabox-listing','delete',$item['id']
                ),
            );
            ?>
            
            <?php
            //Return the cattitle contents
            return sprintf('%1$s <span style="color:silver">%2$s</span>',
            /*$1%s*/ $item['id'],            
            /*$3%s*/ $this->row_actions($actions)
            );
        }

        function column_cb($item){
            return sprintf(
            '<input type="checkbox" name="%1$s[]" value="%2$s" />',
            /*$1%s*/ $this->_args['singular'],  //Let's simply repurpose the table's singular label ("movie")
            /*$2%s*/ $item['id']                //The value of the checkbox should be the record's id
            );
        }
        function get_columns(){
            $columns = array(
            'cb'                          => '<input type="checkbox" />', //Render a checkbox instead of text
            'title'                       => 'Id',
            'metabox_field_label'         => 'Field Label',
            'metabox_field_title'         => 'Field Title',
            'metabox_field_type'          => 'Field Type',
            'metabox_field_status'        => 'Status',
            'metabox_field_post_type'     => 'Post Type ',
            'metabox_field_created_date'  => 'Created Date & Time',
            );
            return $columns;
        }
        function get_sortable_columns() {
            $sortable_columns = array(
            'id'     => array('id',false)
            );
            return $sortable_columns;
        }
        function get_bulk_actions() {
            $actions = array(
            'delete'    => 'Delete'
            );
            return $actions;
        }
        function process_bulk_action() {
            if( 'delete'===$this->current_action() ) {
                wp_die('Items deleted (or they would be if we had items to delete)!');
            }
        }
        function prepare_items() {
            global $wpdb; //This is used only if making any database queries
            /**
            * First, lets decide how many records per page to show
            */
            $per_page     = 10;
            $example_data = $this->getAllRecords();
            $columns      = $this->get_columns();
            $hidden       = array();
            $sortable     = $this->get_sortable_columns();

            $this->_column_headers = array($columns, $hidden, $sortable);
            $this->process_bulk_action();
            $data         = $this->getAllRecords();
            $current_page = $this->get_pagenum();
            $total_items  = count($data);
            $data         = @array_slice($data,(($current_page-1)*$per_page),$per_page);
            $this->items  = $data;
            $this->set_pagination_args( array(
            'total_items' => $total_items,                  //WE have to calculate the total number of items
            'per_page'    => $per_page,                     //WE have to determine how many items to show on a page
            'total_pages' => ceil($total_items/$per_page)   //WE have to calculate the total number of pages
            ) );
        }
    }
    $customads = new  Metabox_List_Table();
    $customads->prepare_items();

?>
<div class="wrap">
    <div id="icon-users" class="icon32"><br/></div>
    <h2>Wp Custom Metabox Listing <a class="add-new-h2" href="?page=metabox-listing&action=add">Add New</a></h2>
    <?php echo @$message;?>
    <form id="zipcode-filter" method="post">
        <input type="hidden" name="page" value="<?php echo $_GET['page'] ?>" />
        <?php echo $customads->display() ?>
    </form>
</div>
<script type="text/javascript">
    jQuery('#doaction,#doaction2').click(function(){

        d = jQuery('.bulkactions select[name="action"]').val();
        d1 = jQuery('.bulkactions select[name="action2"]').val();
        if(d==-1 && d1==-1){
            alert("Please Select Action to Delete Data.");
            return false;
        }
        if(d=='delete' || d1=='delete'){
            var sList = 1;
            jQuery('input[type=checkbox]:checked').each(function () {
                sList++;
            });
            if(sList==1){
                alert("Please Select Checkbox to Delete Items.");
                return false;
            }
            if (!confirm('Are you Sure, you want to delete items?')) {
                return false;
            }
        }
    } );
    jQuery('.deleteitem').click(function(){
        if (!confirm('Are you Sure, you want to delete Items?')) {
            return false;
        }
    });
</script>
<?php

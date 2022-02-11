<?php

class AdminTodo {

    public function __construct(){

        add_action( 'init', array($this, 'init') );
/*         add_action( 'admin_menu', array($this, 'linked_url') );
        add_action( 'admin_menu' , array($this,'linkedurl_function') ); */
       

        //Below functions are used for ajax call
        add_action( 'wp_ajax_nopriv_todo_ajax', array($this,'ajax') );
        add_action( 'wp_ajax_todo_ajax', array($this, 'ajax') );

        add_filter( "manage_todo_posts_columns", array($this, 'change_columns'));
        add_action( "manage_posts_custom_column", array($this, 'custom_columns') , 10, 2 );
    }

    public function init(){
        
        if( preg_match('/\/todo\/?$/',$_SERVER['REQUEST_URI'])){
            $base_url = plugins_url( 'app/' , AD_TODO_FILE);
            require AD_TODO_PATH.'/app/index.php';
            exit;
        }

        $this->add_post_type();
    }

/*     public function linked_url() {
        add_menu_page( 'linked_url', 'My To Dos', 'read', 'todo', '', 'dashicons-text', 1 );
    } */

  /*   public function linkedurl_function() {
        global $menu;
        $menu[1][2] = get_site_url() . '/todo';

    } */


    public function ajax(){
        $action = '';
        $data = '';
        $response = array();
        $post = null;

        if(isset( $_POST['task'] )){
            $task = $_POST['task'];
        }

        if(isset( $_POST['data'] )){
            $data = $_POST['data'];
        }

        if(isset( $_POST['id'] )){
            $id = $_POST['id'];
        }

        if( $id > 0 ) {
            $post = get_post($id);
        }  

        switch ( $task ){
            case 'save':
                $todo_item = array(
                    'post_title' => $data,
                    'post_content' => '',
                    'post_status' => 'publish',
                    'post_type' => 'admin_todo',
                );

                if( $post->ID > 0 ) {
                    $todo_item['ID'] = $post->ID;
                } 

                $response['post'] = wp_insert_post( $todo_item ) ;
            break;

            case 'check':
                if( $post ) {
                    update_post_meta($post->ID, 'status', 'Completed');
                    $response['task'] = 'marked';
                }

            break;

            case 'uncheck':
                if( $post ) {
                    delete_post_meta($post->ID, 'status');
                    $response['task'] = 'unmarked';
                }

            break;

            case 'delete':
                if( $post ) {
                    wp_delete_post($post->ID);
                    $response['task'] = 'deleted';
                }

            break;
        }
        echo json_encode($response);
       die();        
    }

    private function add_post_type(){

        register_post_type( 'admin_todo',
            array(
                'labels' => array(
                    'name' => __( 'Todo items' ),
                    'singular_name' => __( 'Todo item' )
                ),
                'public' => true,
                'supports' => array('title'),
            )
        );
    }

    public function change_columns($cols){

        $cols = array(
            'cb'       => '<input type="checkbox" />',
            'title'      => __( 'Task' ),
            'status' => __( 'Status' ),
            'date'     => __( 'Date' ),
        );

        return $cols;
    }

    public function custom_columns( $column, $post_id ) {

        switch ( $column ) {

            case "status":

                $status = get_post_meta( $post_id, 'status', true);

                if($status != 'Completed'){
                    $status = 'Not completed';
                }

                echo $status;

            break;
        }
    }

  
}
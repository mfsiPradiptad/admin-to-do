<?php
/**
 * Plugin Name: Admin To Do List
 * Plugin URI: pradiptadas
 * Description: This plugin adds to do list on admin panel.
 * Version: 1.0.1
 * Author: Pradipta Das
 * Author URI: http://pradiptadas.sites
 * License: GPL2
 */

define('AD_TODO_FILE', __FILE__);
define('AD_TODO_PATH', plugin_dir_path(__FILE__));

require AD_TODO_PATH.'includes/class-admin-todo.php';

new AdminTodo();

add_action( 'admin_menu', 'my_plugin_menu'  );

function my_plugin_menu() {
    add_menu_page( 'My Tasks', 'My Tasks', 'manage_options', 'my-todo-tasks', 'my_plugin_tasks', 'dashicons-text', 1 );
}

function my_plugin_tasks() { ?>
    <div class="wrap">
        <h1>My To Dos</h1><?php
        include_once plugin_dir_path( __FILE__ ) . 'app/index.php';
        ?>
    </div>
 <?php
} 
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>Todo App</title>

        <base href="<?php echo $base_url ?>"></base>

        <!-- The stylesheets -->
        <link rel="stylesheet" href="<?php echo WP_PLUGIN_URL . '/admin-to-do/app/assets/css/style.css'; ?>" />
        <link rel="stylesheet" href="<?php echo WP_PLUGIN_URL . '/admin-to-do/app/assets/css/bootstrap.min.css'; ?>" type="text/css" media="all" />

    </head>

    <body>

        <div class="row mt-1 ml-1" id="todo">
            <div class="col-sm-12">
                <h4> <a href="javascript:void(0);" class="add"
                    title="Add new todo item!"> ✚ </b></a>(Click '+' to Add)</h4>
                    <p>* Check the box, if the task has Completed. Click &#10004;to save or ✖ to remove your task.</h6>
                <ul>
                    <?php

                        $query = new WP_Query(
                            array( 'post_type'=>'admin_todo', 'order'=>'ASC')
                        );

                        if( $query->have_posts() ):
                            
                        while ( $query->have_posts() ) :
                            $query->the_post();
                            $done = get_post_meta(get_the_ID(), 'status', true) ==
                                'Completed';
                        ?>
                            <li data-id="<?php echo get_the_ID();?>"
                                class="<?php echo ($done ? 'done' : ''); ?>">
                                <input type="checkbox" title="Mark as Complete"
                                    <?php echo ($done ? 'checked="true"' : '');?> />
                                <input type="text" class="todoInput"
                                    value="<?php htmlspecialchars(the_title())?>"
                                    placeholder="Write your todo here" />
                                    <?php $visibility = $done ? 'invisible' : 'visible' ?>
                                <a href="javascript:void(0);" class ="save-item <?php echo $visibility; ?>" title="Save To Do">&#10004;</a>
                                <a href="
                                javascript:void(0);" class="delete" title="Delete">✖</a>
                            </li>

                        <?php 
                        endwhile; else:
                            ?>
                            <li class="nodos">No To Dos have been added yet! Add now.</li>
                            <?php
                        endif;
                        
                        ?>
                </ul>
            </div>
        </div>


        <!-- JavaScript includes.  -->
        <script  src="https://code.jquery.com/jquery-2.2.4.min.js"  integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44="  crossorigin="anonymous"></script>
        <script type="text/javascript" src="<?php echo WP_PLUGIN_URL . '/admin-to-do/app/assets/js/bootstrap.min.js';?>"></script>
        <script>
            var ajaxurl = '<?php echo admin_url('admin-ajax.php')?>';
        </script>
        <script src="<?php echo WP_PLUGIN_URL . '/admin-to-do/app/assets/js/script.js'; ?>"></script>

    </body>
</html>
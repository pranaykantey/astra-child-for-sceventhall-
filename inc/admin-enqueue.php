<?php 
    // add admin script 
    add_action('admin_enqueue_scripts', 'conv_admin_enqueue_scripts_func');
    function conv_admin_enqueue_scripts_func() {


        wp_register_script( 'conv-admin-script', get_theme_file_uri("assets/js/admin.js"), array('jquery'), true );
        
        wp_localize_script( 'conv-admin-script', 'conventionalEmailAjax', array( 'ajaxurl' => admin_url( 'admin-ajax.php' )));   

        wp_enqueue_script( 'conv-admin-script' );

    }
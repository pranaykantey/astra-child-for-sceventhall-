<?php 

    add_action('wp_enqueue_scripts','conv_wp_enqueue_scripts');

    function conv_wp_enqueue_scripts() {
        wp_enqueue_style( 'astra-child-theme', get_theme_file_uri("assets/css/theme.css") );

        wp_register_script( "appointment_frontend_script", get_theme_file_uri("assets/js/appointment-frontend.js"), array('jquery') );
        
        wp_localize_script( 'appointment_frontend_script', 'appointmentAjax', array( 'ajaxurl' => admin_url( 'admin-ajax.php' )));        
     
        // wp_enqueue_script( 'jquery' );
        wp_enqueue_script( 'appointment_frontend_script' );
    }
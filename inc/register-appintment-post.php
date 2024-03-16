<?php 
    function convension_center_appointment_post_type_register() {

        /**
         * Post Type: Appointments.
         */
    
        $labels = [
            "name" => esc_html__( "Appointments", "custom-post-type-ui" ),
            "singular_name" => esc_html__( "Appointment", "custom-post-type-ui" ),
        ];
    
        $args = [
            "label" => esc_html__( "Appointments", "custom-post-type-ui" ),
            "labels" => $labels,
            "description" => "",
            "public" => true,
            "publicly_queryable" => true,
            "show_ui" => true,
            "show_in_rest" => true,
            "rest_base" => "",
            "rest_controller_class" => "WP_REST_Posts_Controller",
            "rest_namespace" => "wp/v2",
            "has_archive" => true,
            "show_in_menu" => true,
            "show_in_nav_menus" => true,
            "delete_with_user" => false,
            "exclude_from_search" => false,
            "capability_type" => "post",
            "map_meta_cap" => true,
            "hierarchical" => false,
            "can_export" => false,
            "rewrite" => [ "slug" => "appointments_booking", "with_front" => true ],
            "query_var" => true,
            "supports" => [ "title" ],
            "show_in_graphql" => false,
        ];
    
        register_post_type( "appointments_booking", $args );
    }
    
    add_action( 'init', 'convension_center_appointment_post_type_register' );
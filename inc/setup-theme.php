<?php
add_action( 'init', 'after_setup_pk_astra_child' );

function after_setup_pk_astra_child() {

    function get_meta_values( $meta_key = '', $post_type = 'post', $post_status = 'publish' ) {
    
        global $wpdb;
        
        if( empty( $meta_key ) )
            return;
        
        $meta_values = $wpdb->get_col( $wpdb->prepare( "
            SELECT pm.meta_value FROM {$wpdb->postmeta} pm
            LEFT JOIN {$wpdb->posts} p ON p.ID = pm.post_id
            WHERE pm.meta_key = %s 
            AND p.post_type = %s 
            AND p.post_status = %s 
        ", $meta_key, $post_type, $post_status ) );
        
        return $meta_values;
    }
    
}


    // mail sending format change 
    add_action( 'init', 'mail_sending_function' );
    function mail_sending_function() {
        function wpse27856_set_content_type(){
            return "text/html";
        }
        add_filter( 'wp_mail_content_type','wpse27856_set_content_type' );
    }
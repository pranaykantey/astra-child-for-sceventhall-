<?php 
    


    /****
     * Save form data
     */
    function my_save_custom_form() {
        // global $wpdb;

        $first_name     = isset( $_POST['first_name'] ) ? $_POST['first_name'] : NULL;
        $last_name      = isset( $_POST['last_name'] ) ? $_POST['last_name'] : NULL;
        $starting_date  = isset( $_POST['starting_date'] ) ? $_POST['starting_date'] : NULL;
        $ending_date    = isset( $_POST['ending_date'] ) ? $_POST['ending_date'] : NULL;
        $email          = isset( $_POST['email'] ) ? $_POST['email'] : NULL;
        $phone          = isset( $_POST['phone'] ) ? $_POST['phone'] : NULL;

        $args = array(
            'post_type' =>'appointments_booking',
            'posts_per_page' => 1
        );

        $recent_post = wp_get_recent_posts($args, OBJECT);


        $id = $recent_post[0]->ID;
        $id = $id + 1;

        if ( 
            !empty( $first_name ) && 
            !empty($last_name) && 
            !empty($starting_date) && 
            !empty($ending_date) && 
            !empty($email) && 
            !empty($phone) 
        ) {

            wp_insert_post(array(
                'post_type'     => 'appointments_booking',
                'post_title'    => 'Appintment-Request--'.$id,
            ));
            
            update_post_meta($id, 'conv_first-name', $first_name );
            update_post_meta($id, 'conv_last-name', $last_name );
            update_post_meta($id, 'conv_starting-date', $starting_date );
            update_post_meta($id, 'conv_ending-date', $ending_date );
            update_post_meta($id, 'conv_email', $email );
            update_post_meta($id, 'conv_phone', $phone );
            // $message = 'Appointment added successfylly. We will contact to you soon.';
            
            $redirect = add_query_arg( 'appointment_message', 'success', $_SERVER["HTTP_REFERER"] );
            wp_redirect( $redirect );
        }else {
            $redirect = add_query_arg( 'appointment_message', 'error', $_SERVER["HTTP_REFERER"] );
            wp_redirect( $redirect );
        }

        // wp_redirect( site_url('/') );
        die;
    }
    
    add_action( 'admin_post_nopriv_save_appointment', 'my_save_custom_form' );
    add_action( 'admin_post_save_appointment', 'my_save_custom_form' );
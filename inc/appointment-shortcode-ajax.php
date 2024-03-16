<?php 

add_action("wp_ajax_appointment_ajax", "add_appointment_ajax");
add_action("wp_ajax_nopriv_appointment_ajax", "add_appointment_ajax");

function add_appointment_ajax() {

    if ( !wp_verify_nonce( $_REQUEST['nonce'], "appointment_nonce")) {
        exit("No naughty business please");
    }   

    // var_dump($_REQUEST['formDatas']);
    $datas = $_REQUEST['formDatas'];


    
    $first_name     = isset( $datas['first_name'] ) ? $datas['first_name'] : NULL;
    $last_name      = isset( $datas['last_name'] ) ? $datas['last_name'] : NULL;
    $starting_date  = isset( $datas['date_starting'] ) ? $datas['date_starting'] : NULL;
    $ending_date    = isset( $datas['date_ending'] ) ? $datas['date_ending'] : NULL;
    $email          = isset( $datas['email'] ) ? $datas['email'] : NULL;
    $phone          = isset( $datas['phone'] ) ? $datas['phone'] : NULL;

    $args = array(
        'post_type' =>'appointments_booking',
        'posts_per_page' => 1
    );

    $recent_post = wp_get_recent_posts($args, OBJECT);


    $idOld = $recent_post[0]->ID;
    $id = $idOld + 1;

    // echo '<p> first_name: '. $first_name.'</p>';
    // echo '<p> last_name: '. $last_name.'</p>';
    // echo '<p> starting_date: '. $starting_date.'</p>';
    // echo '<p> ending_date: '. $ending_date.'</p>';
    // echo '<p> email: '. $email.'</p>';
    // echo '<p> phone: '. $phone.'</p>';

    // var_dump($recent_post);

    if ( 
        !empty( $first_name ) && 
        !empty($last_name) && 
        !empty($starting_date) && 
        !empty($ending_date) && 
        !empty($email) && 
        !empty($phone) 
    ) {

        // update_post_meta( post_id, meta_key, meta_value, prev_value )
        $old_first_name = get_post_meta( $idOld, 'conv_first-name', true );
        $old_last_name = get_post_meta( $idOld, 'conv_last-name', true );
        $old_starting_date = get_post_meta( $idOld, 'conv_starting-date', true );
        $old_ending_date = get_post_meta( $idOld, 'conv_ending-date', true );
        $old_email = get_post_meta( $idOld, 'conv_email', true );
        $old_phone = get_post_meta( $idOld, 'conv_phone', true );

        // echo $old_first_name;

        if( 
            $old_first_name != $first_name &&
            $old_last_name != $last_name &&
            $old_starting_date != $starting_date &&
            $old_ending_date != $ending_date &&
            $old_email != $email &&
            $old_phone != $phone
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

            $emali_message = '';
            $emali_message .= sprintf('You recieved a appointment request from: <br> Name: %s %s. <br> Email: %s <br> Phone: %s<br> Thank you.', $first_name, $last_name, $email, $phone);
            
            wp_mail( get_option( 'admin_email' ), 'appointemnt-'.$id, $emali_message );
            echo 'success';
        }else {
            echo 'aleready';
        }
        
    }else {
        echo 'error';
    }
    

    // header("Location: ".$_SERVER["HTTP_REFERER"]);
    die();

}

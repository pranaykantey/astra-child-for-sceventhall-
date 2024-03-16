<?php

    require_once('inc/setup-theme.php');
    require_once('inc/register-appintment-post.php');
    require_once('inc/save-appointment-data.php');
    
    /* End Save form data */

    require_once('lib/conv-post-meta.php');
    require_once('inc/shortcodes/appointment-shortcode.php');

    require_once('inc/admin-enqueue.php');

    require_once('inc/enqueue-frontend-scirpts.php');

    require_once('inc/appointment-shortcode-ajax.php');


    add_action( 'admin_menu', 'linked_url' );
        function linked_url() {
        add_menu_page( 'linked_url', 'Quote Requests', 'read', 'my_slug', '', 'dashicons-text', 1 );
        }

        add_action( 'admin_menu' , 'linkedurl_function' );
        function linkedurl_function() {
        global $menu;
        $menu[1][2] = "https://sceventhall.com/wp-admin/admin.php?page=forminator-entries&form_type=forminator_forms&form_id=1304";
    }


    add_action( 'init', function(){


        add_action( 'forminator_form_after_save_entry', 'my_form_submit' );
        function my_form_submit( $form_id ) {
            if( $form_id == 1304 ) {
                $entry = Forminator_Form_Entry_Model::get_latest_entry_by_form_id( $form_id );
                $formArray = $entry->meta_data;

                $formFName = isset($formArray['name-1']['value']['first-name']) ? $formArray['name-1']['value']['first-name'] : '';
                $formLName = isset($formArray['name-1']['value']['last-name']) ? $formArray['name-1']['value']['last-name'] : '';
                $fullName = $formFName . ' ' . $formLName;
                $formEmail = isset($formArray['email-1']['value']) ? $formArray['email-1']['value'] : '';
                $formPhone = isset($formArray['phone-1']['value']) ? $formArray['phone-1']['value'] : '';
                $formSDate = isset($formArray['date-1']['value']) ? $formArray['date-1']['value'] : '';
                $formLDate = isset($formArray['date-2']['value']) ? $formArray['date-2']['value'] : '';

                $args = array(
                    'post_type' =>'appointments_booking',
                    'posts_per_page' => 1
                );

                $recent_post = wp_get_recent_posts($args, OBJECT);


                $idOld = $recent_post[0]->ID;
                $newId = isset($idOld) ? $idOld : 0;
                $id = $newId + 1;

                
                wp_insert_post(array(
                    'post_type'     => 'appointments_booking',
                    'post_title'    => 'Appintment-Request--'.$id
                ));
                
                
                update_post_meta($id, 'conv_first-name', $formFName );
                update_post_meta($id, 'conv_last-name', $formLName );
                update_post_meta($id, 'conv_starting-date', $formSDate );
                update_post_meta($id, 'conv_ending-date', $formLDate );
                update_post_meta($id, 'conv_email', $formEmail );
                update_post_meta($id, 'conv_phone', $formPhone );

                
                error_log( print_r( $entry, true ) );
            }
            
            // if ( $form_id == 1304 ) {
            
            //     $entry = Forminator_Form_Entry_Model::get_latest_entry_by_form_id( $form_id );
            
            //     error_log( print_r( $entry, true ) );
                    
            // }
        }

        add_action("wp_ajax_conventionalEmailAjax", "func_conventionalEmailAjax");
        add_action("wp_ajax_nopriv_conventionalEmailAjax", "func_conventionalEmailAjax");
        function func_conventionalEmailAjax() {
            
            if ( !wp_verify_nonce( $_REQUEST['nonce'], "conv_send_email")) {
                exit("No naughty business please");
            } 
            $req = $_REQUEST['postData'];
            $post_id = $req['id'];
            $post_id = (int)$post_id;

            $mailTo = get_post_meta( $post_id, 'conv_email', true );
            $fName = get_post_meta($post_id, 'conv_first-name', true );
            $lName = get_post_meta($post_id, 'conv_last-name', true );
            $approval = get_post_meta( $post_id, 'conv_approval', true );
            
            $message = 'Hi,';
            $message .= $fName . ' ' . $lName;
            $message .= '<br> You quotation request status for ';
            $message .= '<a style="color: blue;" href="https://sceventhall.com/">sceventhall</a> is <span style="color: lightgreen;">'. $approval;
            $message .= '</span>.<br>';
            $message .= '<b> Please email us at <a href="mailto:info@sceventhall.com"> info@sceventhall.com </a> for any query. <br> Thank you.';

            $headers = array('Content-Type: text/html; charset=UTF-8','From: SceventHall <info@sceventhall.com>');
            // wp_mail( $mailTo, 'sceventhall', $message, $headers)
            if( wp_mail( $mailTo, 'sceventhall', $message, $headers) ) {
                echo 'success';
            }else {
                echo 'error';
            }

            wp_die( );
        }
        // add_action( "save_post_appointments_booking", function($post_id, $post){

        //     $send_email = get_post_meta( $post_id, 'conv_send_email', true );

        //     if( "YES" == $send_email ) {
        //         $mailTo = get_post_meta( $post_id, 'conv_email', true );
        //         $fName = get_post_meta($post_id, 'conv_first-name', true );
        //         $lName = get_post_meta($post_id, 'conv_last-name', true );
        //         $approval = get_post_meta( $post_id, 'conv_approval', true );
                
        //         $message = 'Hi,';
        //         $message .= $fName . ' ' . $lName;
        //         $message .= '<br> You quotation request status for ';
        //         $message .= '<a style="color: blue;" href="https://sceventhall.com/">sceventhall</a> is <span style="color: lightgreen;">'. $approval;
        //         $message .= '</span>.<br>';
        //         $message .= '<b> Please email us at <a href="mailto:info@sceventhall.com"> info@sceventhall.com </a> for any query. <br> Thank you.';

        //         $headers = array('Content-Type: text/html; charset=UTF-8','From: SceventHall <info@sceventhall.com>');

        //         wp_mail( $mailTo, 'sceventhall', $message, $headers);

        //     }
        // }, 90, 2 );

    } );

    // var_dump(Forminator_API::get_polls());

    
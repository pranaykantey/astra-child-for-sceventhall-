<?php 
add_shortcode( 'appointment_shortcode', array( 'AppointmentShortcode', 'apppointment_shortcode_func' ) );
class AppointmentShortcode {
	public static function apppointment_shortcode_func( $atts, $content = "" ) {
        ob_start();
        ?>
        <link rel="stylesheet" href="<?php echo get_theme_file_uri("assets/css/jquery-ui.css"); ?>">
        <script src="<?php echo get_theme_file_uri("assets/js/jquery-ui.js"); ?>"></script> 
        <?php
            $args = array(
                'post_type' =>'appointments_booking',
                'posts_per_page' => 1
            );
            $recent_post = wp_get_recent_posts($args, OBJECT);
            
            if( isset($recent_post[0]) ) {
                $idOld = $recent_post[0]->ID;
            }else {
                $idOld = null;
            }

        ?>
        <div class="appointment-form">
            <div class="appointment-conainer">
                <div class="message">

                <?php if ( filter_input( INPUT_GET, 'appointment_message' ) === 'success' ) : ?>
                    Appointment request sent succesfully, Please wait for confirmation.
                <?php endif ?>
                <?php if ( filter_input( INPUT_GET, 'appointment_message' ) === 'error' ) : ?>
                    <p>
                        Please Fill all the Fields.
                    </p>
                <?php endif ?>

                </div>
                <form action="<?php echo esc_attr( admin_url('admin-post.php') ); ?>" method="POST" >
                <input type="hidden" name="action" value="save_appointment" />
                <div class="row">
                    <div class="half">
                        <label>
                            <h6>First Name:</h6>
                            <input id="first_name" type="text" name="first_name">
                        </label>
                    </div>
                    <div class="half">
                        <label>
                            <h6>Last Name:</h6>
                            <input id="last_name" type="text" name="last_name">
                        </label>
                    </div>
                </div>
                <?php
                    
                    $startingDAteArrayAll = get_meta_values('conv_starting-date','appointments_booking','publish');
                    $endingDateArrayAll = get_meta_values('conv_ending-date','appointments_booking','publish');

                    // var_dump( $startingDAteArrayAll );
                    // var_dump( $endingDateArrayAll );
                    
                    $i = 0;
                    $allDates = '[';

                    while( $i < count($startingDAteArrayAll) ) {
                        if( isset( $startingDAteArrayAll[$i]) ) {
                            $sdate = date_create($startingDAteArrayAll[$i]);

                            $edate = date_create($endingDateArrayAll[$i]);

                            $interval = new DateInterval('P1D');

                            $date_range = new DatePeriod($sdate, $interval, $edate);

                            // var_dump($date_range);

                            foreach ($date_range as $date) {
                                $d = $date->format('Y-m-d');
                                $allDates .= "'".$d."',";
                            }

                            $allDates .= "'".$edate->format('Y-m-d')."',";
                        }
                        $i++;
                    }

                    $allDates = rtrim($allDates, ",");
                    $allDates .= ']';

                ?>
                <div class="row">
                    <div class="half">
                        <label>
                            <h6>Starting date:</h6>
                            <input data-dates="<?php echo $allDates; ?>" id="date_starting" type="text" name="starting_date">
                        </label>
                    </div>
                    <div class="half">
                        <label>
                            <h6>Ending date:</h6>
                            <input  id="date_ending" type="text" name="ending_date">
                        </label>
                    </div>
                </div>
                <div class="row">
                    <div class="half">
                        <label>
                            <h6>Email address</h6>
                            <input id="email" type="text" name="email">
                        </label>
                    </div>
                    <div class="half">
                        <label>
                            <h6>Phone Numbar</h6>
                            <input  id="phone" type="text" name="phone">
                        </label>
                    </div>
                </div>
                <div class="row">
                    <div class="full">
                        <!-- <label>
                            <input type="submit" name="submit" value="Request Appointment">
                        </label> -->
                        <?php
                            // $nonce = wp_create_nonce("add_appintment_ajax");
                            // $link = admin_url('admin-ajax.php?action=add_appintment_ajax&nonce='.$nonce);
                            // echo '<a class="button button-prmary btn btn-primary d-inline-block" data-nonce="' . $nonce . '"  href="' . $link . '">Request for Appintment</a>';
                        ?>
                        <?php
                            $nonce = wp_create_nonce("appointment_nonce");
                        ?>
                        <a data-nonce="<?php echo $nonce ?>" class="button button-prmary btn btn-primary d-inline-block appointment-ajax-button" >Request for Appintment</a>
                    </div>
                </div>
            </form>
            </div>
        </div>

        <script>
            (function($){
                $(document).ready(function(){
                    // var dates = ['2024-03-14', '2024-03-15', '2024-03-16'];
                    var dates = $('#date_starting').attr('data-dates');
                    
                    $('#date_starting').datepicker({
                        beforeShowDay: function(date)
                        {
                            var string = jQuery.datepicker.formatDate('yy-mm-dd', date);
                            return [dates.indexOf(string) == -1];
                        },
                        onSelect:function(dateText) {
                            $("#date_ending").datepicker('option','minDate',dateText);
                        },
                        orientation: "bottom left",
                    });
                    
                    $('#date_ending').datepicker({
                        beforeShowDay: function(date)
                        {
                            var string = jQuery.datepicker.formatDate('yy-mm-dd', date);
                            return [dates.indexOf(string) == -1];
                        },
                        onSelect:function(dateText) {
                            $("#date_starting").datepicker('option','maxDate',dateText);
                        }
                    });
                });
            }(jQuery));
        </script>
        <?php
        $content = ob_get_clean();
		return $content;
	}
}
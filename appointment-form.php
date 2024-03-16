<?php
    /*
        Template Name: Appointment Form Page
    */
?>

<?php get_header(); ?>
        <link rel="stylesheet" href="<?php echo get_theme_file_uri("assets/css/jquery-ui.css"); ?>">
        <script src="<?php echo get_theme_file_uri("assets/js/jquery-ui.js"); ?>"></script>
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
                <div class="row">
                    <div class="half">
                        <label>
                            <h6>Starting date:</h6>
                            <input id="date_starting" type="text" name="starting_date">
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
                        <label>
                            <input type="submit" name="submit" value="Request Appointment">
                        </label>
                    </div>
                </div>
            </form>
            </div>
        </div>


        <script>
            (function($){
                $(document).ready(function(){
                    var dates = ['2024-03-14', '2024-03-15', '2024-03-16'];
                    $('#date_starting').datepicker({
                        beforeShowDay: function(date)
                        {
                            var string = jQuery.datepicker.formatDate('yy-mm-dd', date);
                            return [dates.indexOf(string) == -1];
                        }
                    });
                    $('#date_ending').datepicker();
                });
            }(jQuery));
        </script>
<?php get_footer(); ?>
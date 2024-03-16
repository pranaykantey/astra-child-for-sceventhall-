(function($){
    jQuery(document).ready( function() {
        // appointement ajax. 
        jQuery(".appointment-ajax-button").click( function(e) {
            e.preventDefault();
            var itIs = $(this);
            var first_name          = $("#first_name").val();
            var last_name           = $("#last_name").val();
            var date_starting       = $("#date_starting").val();
            var date_ending         = $("#date_ending").val();
            var email               = $("#email").val();
            var phone               = $("#phone").val();

            $(this).removeClass('appointment-ajax-button');

            nonce = jQuery(this).attr("data-nonce");

            jQuery.ajax({
                type : "post",
                url : appointmentAjax.ajaxurl,
                data : {
                    type: 'post',
                    action: "appointment_ajax",
                    formDatas: {
                        'first_name':       first_name,
                        'last_name':        last_name,
                        'date_starting':    date_starting,
                        'date_ending':      date_ending,
                        'email':            email,
                        'phone':            phone,
                    },
                    nonce: nonce
                },
                success: function(response) {
                    successMessage = '<p class="alert alert-success">Successfyll sent Booking Request. We will contact you soon.</p>';
                    errorMessage = '<p class="alert alert-danger">Please check all the fields.</p>';
                    aleready = '<p class="alert alert-danger">Data already sent.</p>';
                    if( response == 'success' ) {
                        $('.appointment-conainer .message').html(successMessage);
                    }else if( response == 'error') {
                        $('.appointment-conainer .message').html(errorMessage);
                        
                        itIs.removeClass('appointment-ajax-button');
                    }else if( response == 'aleready') {
                        $('.appointment-conainer .message').html(aleready);
                    }else {
                        $('.appointment-conainer .message').html(response);
                    }
                }
            });
     
        });


        // disable a on disable attribute add 
        // $('a[disabled]').click(function(e){
        //     e.preventDefault();
        // });


 // sticky header 
// When the user scrolls the page, execute myFunction
window.onscroll = function() {myFunction()};

    // Get the header
var header = document.getElementsByClassName("ast-main-header-wrap")[0];
// var header = document.getElementById("ast-desktop-header");

    // Get the offset position of the navbar
var sticky = header.offsetTop;

    // Add the sticky class to the header when you reach its scroll position. Remove "sticky" when you leave the scroll position
function myFunction() {
    if (document.documentElement.scrollTop > sticky || window.scrollY > sticky) {
        header.classList.add("sticky");
    } else {
        header.classList.remove("sticky");
    }
} 
       
     
     });
}(jQuery));


// forminator form add calss to .forminator-row class. 
(function($){
	$('.forminator-row').each(function(i, item){
		$(this).addClass('item-class-'+i);
	});
}(jQuery));





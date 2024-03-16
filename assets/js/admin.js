(function($){
    $(document).ready(function(){
        $('.enable-edit').click(function(e){
            e.preventDefault();
            // var attributeDisabled = $('input')
            $('.regular-text').each(function(){
                var attrDisabled = $(this).attr('disabled');
                if( attrDisabled == 'disabled' ) {
                    $(this).removeAttr('disabled');
                }else {
                    $(this).attr('disabled','disabled');
                }
            });


            // $('input').toggleClass('disabled');
        });


        
        // send email button ajax 
        jQuery("#conv-send-email").click(function(e){
            e.preventDefault();
            var postId = $(this).attr('data-id');
            var nonce = $(this).attr('data-nonce');
            itIs = $(this);
            $.ajax({
                type: "post",
                url: conventionalEmailAjax.ajaxurl,
                data: {
                    type: "post",
                    action: "conventionalEmailAjax",
                    postData: {
                        id: postId
                    },
                    nonce: nonce
                },
                success: function(response) {
                    if( response == 'success' ) {
                        itIs.parent('span').append('<span class="success"  style="color: green; padding: 10px 20px; display: inline-block;"> Email sent succesfylly. </span>');
                    }else {
                        itIs.parent('span').append('<span class="error" style="color: red; padding: 10px 20px; display: inline-block;"> Failed to send email. </span>');
                    }
                }
            });
        });

    });
}(jQuery));
jQuery(document).ready(function(){
	    
	 $('#close').click(function(){
		 console.log('something');
       window.close();
     });

        var hashUrl =   window.location.hash.substring(1);
        $(".small_container").show();
        $("#sentForm").hide()
        $("#hashValue").val(hashUrl);

    if($("#pill_email").size() > 0){
    	
    	jQuery.post('mylightbox/getEmailData',{
    			hash : hashUrl    			
    			
    	},function(data){
		    		data = JSON.parse(data);
		    		$('#user_name').val(data.user_name);
		    		$('#user_email').val(data.user_email);
		    		$('#subject').val(data.lightbox_name);
		    		$('#submitEmail').val('Share Lightbox "'+data.lightbox_name+'"');
    	});
    	
    	
	    $("#pill_email").validate({
	
	        errorClass: 'customError',
	        errorPlacement: function(error, element) {
	
	            error.appendTo( element.parent().append());
	        },
	
	        rules: {
	            recipient_email : { required: true },
	            user_name       : { required: true },
	            user_email      : { required: true, email: true  },
	            subject         : { required: true },
	            message         : { required: true }
	        },
	        messages: {
	
	            recipient_email : {
	                required: 'Please, provide a valid email.'
	            },
	            user_name       : {
	                required: 'Please, use a valid username.'
	            },
	            user_email      : {
	                required: 'Please, provide a valid email.',
	                email: 'Please, provide a valid email.'
	            },
	            subject         : { required: 'Please, write a valid subject.' },
	            message         : { required: 'Please, write a message.' }
	        },
	        submitHandler: function(form) {
	
	            var recipient_email     =   $("#recipient_email").val();
	            var user_name           =   $("#user_name").val();
	            var user_email          =   $("#user_email").val();
	            var send_copy           =   ($("#send_copy:checked").size() > 0)?$("#send_copy").val():"no";
	            var subject             =   $("#subject").val();
	            var message             =   $("#message").val();
	            var hashValue           =   $("#hashValue").val();
	            var formType            =   $("#formType").val();
	
	            jQuery.post(
	                'mylightbox/sendShareEmail',{
	
	                    recipient_email: recipient_email,
	                    user_name: user_name,
	                    user_email: user_email,
	                    send_copy: send_copy,
	                    subject: subject,
	                    message: message,
	                    hashValue:  hashValue,
	                    formType:  formType
	
	                },function(data){
	
	                    var response    = eval('(' + data + ')');;
	
	                    if(response.results.success){
	                        $("#pill_email").hide();
	                        $("#sentForm").show();
	
	                        if(formType == "email"){
	                            $(".nameSent").html(user_name);
	                            $(".emailSent").html(user_email);
	                            $(".lightboxNameSent").html(response.results.lightboxName);
	                            $(".recipientsSent").html(recipient_email);
	                        }
	
	                    } else {
	                        $("#pill_email").show()
	                        $("#sentForm").hide()
	                    }
	                    
	                    setTimeout(function(){window.close();}, 15000);
	                }
	            );
	            //$(form).submit();
	        }
	
	    })
    }

    $(".terms_use").click(function(){
        var url = $(this).attr("href")
        window.open(url,'terms','height=700,width=960,scrollbars=yes,resizable=yes,menubar=no,location=no,directories=no,status=yes');
        return false;
    });


})


var Login = function () {

	var handleLogin = function() {
		$('.login-form').validate({
	            errorElement: 'label', //default input error message container
	            errorClass: 'help-inline', // default input error message class
	            focusInvalid: false, // do not focus the last invalid input
	            rules: {
	                email: {
	                    required: true,
	                    email: true
	                },
	                password: {
	                    required: true
	                },
	                remember: {
	                    required: false
	                }
	            },

	            messages: {
	                email: {
	                    required: "Email is required."
	                },
	                password: {
	                    required: "Password is required."
	                }
	            },

	            invalidHandler: function (event, validator) { //display error alert on form submit   
	                $('.alert-error', $('.login-form')).show();
	            },

	            highlight: function (element) { // hightlight error inputs
	                $(element)
	                    .closest('.control-group').addClass('error'); // set error class to the control group
	            },

	            success: function (label) {
	                label.closest('.control-group').removeClass('error');
	                label.remove();
	            },

	            errorPlacement: function (error, element) {
	                error.addClass('help-small no-left-padding').insertAfter(element.closest('.input-icon'));
	            },

	            submitHandler: function (form) {
	                form.submit();
	            }
	        });

	        $('.login-form input').keypress(function (e) {
	            if (e.which == 13) {
	                if ($('.login-form').validate().form()) {
	                    $('.login-form').submit();
	                }
	                return false;
	            }
	        });
	}

	var handleForgetPassword = function () {
		$('.forget-form').validate({
	            errorElement: 'label', //default input error message container
	            errorClass: 'help-inline', // default input error message class
	            focusInvalid: false, // do not focus the last invalid input
	            ignore: "",
	            rules: {
	                email: {
	                    required: true,
	                    email: true
	                }
	            },

	            messages: {
	                email: {
	                    required: "Email is required."
	                }
	            },

	            invalidHandler: function (event, validator) { //display error alert on form submit   

	            },

	            highlight: function (element) { // hightlight error inputs
	                $(element)
	                    .closest('.control-group').addClass('error'); // set error class to the control group
	            },

	            success: function (label) {
	                label.closest('.control-group').removeClass('error');
	                label.remove();
	            },

	            errorPlacement: function (error, element) {
	                error.addClass('help-small no-left-padding').insertAfter(element.closest('.input-icon'));
	            },

	            submitHandler: function (form) {
	                form.submit();
	            }
	        });

	        $('.forget-form input').keypress(function (e) {
	            if (e.which == 13) {
	                if ($('.forget-form').validate().form()) {
	                    $('.forget-form').submit();
	                }
	                return false;
	            }
	        });

            /*
                jQuery('#forget-password').click(function () {
                    jQuery('.login-form').hide();
                    jQuery('.forget-form').show();
                });

                jQuery('#back-btn').click(function () {
                    jQuery('.login-form').show();
                    jQuery('.forget-form').hide();
                });
            */

	}

	var handleRegister = function ($absolute_path) {

        function format(state) {
            if (!state.id) return state.text; // optgroup
            //return "<img class='flag' src='http://localhost/topthird_dashboard/zf_application/app_views/index/view_client/zf_view_global/view_files/view_images/flags/" + state.id.toLowerCase() + ".png'/>&nbsp;&nbsp;" + state.text;
            return "<img class='flag' src='" + $absolute_path + "zf_client/zf_app_global/app_global_files/app_global_images/flags/" + state.id.toLowerCase() + ".png'/>&nbsp;&nbsp;" + state.text;
        }

            $("#select2_sample4").select2({
		  	placeholder: '<i class="icon-flag"></i>&nbsp;Select a Country',
            allowClear: true,
            formatResult: format,
            formatSelection: format,
            escapeMarkup: function (m) {
                return m;
            }
        });


			$('#select2_sample4').change(function () {
                $('.register-form').validate().element($(this)); //revalidate the chosen dropdown value and show error or success message for the input
            });



         $('.register-form').validate({
	            errorElement: 'label', //default input error message container
	            errorClass: 'help-inline', // default input error message class
	            focusInvalid: false, // do not focus the last invalid input
	            ignore: "",
	            rules: {
	                
	                companyName: {
	                    required: true
	                },
	                companySerial: {
	                    required: true
	                },
	                companyEmail: {
	                    required: true,
	                    email: true
	                },
	                companyAddress: {
	                    required: true
	                },
	                companyTelephone: {
	                    required: true
	                },
	                city: {
	                    required: true
	                },
	                country: {
	                    required: true
	                },

	                username: {
	                    required: true
	                },
                        email: {
	                    required: true,
	                    email: true
	                },
                        mobile: {
	                    required: true
	                },
	                password: {
	                    required: true
	                },
	                rpassword: {
	                    equalTo: "#register_password"
	                },

	                tnc: {
	                    required: true
	                }
	            },

	            messages: { // custom messages for radio buttons and checkboxes
	                tnc: {
	                    required: "Please accept TNC first."
	                }
	            },

	            invalidHandler: function (event, validator) { //display error alert on form submit   

	            },

	            highlight: function (element) { // hightlight error inputs
	                $(element)
	                    .closest('.control-group').addClass('error'); // set error class to the control group
	            },

	            success: function (label) {
	                label.closest('.control-group').removeClass('error');
	                label.remove();
	            },

	            errorPlacement: function (error, element) {
	                if (element.attr("name") == "tnc") { // insert checkbox errors after the container                  
	                    error.addClass('help-small no-left-padding').insertAfter($('#register_tnc_error'));
	                } else if (element.closest('.input-icon').size() === 1) {
	                    error.addClass('help-small no-left-padding').insertAfter(element.closest('.input-icon'));
	                } else {
	                	error.addClass('help-small no-left-padding').insertAfter(element);
	                }
	            },

	            submitHandler: function (form) {
	                form.submit();
	            }
	        });

			$('.register-form input').keypress(function (e) {
	            if (e.which == 13) {
	                if ($('.register-form').validate().form()) {
	                    $('.register-form').submit();
	                }
	                return false;
	            }
	        });

             /*
                jQuery('#register-btn').click(function () {
                    jQuery('.login-form').hide();
                    jQuery('.register-form').show();
                });

                jQuery('#register-back-btn').click(function () {
                    jQuery('.login-form').show();
                    jQuery('.register-form').hide();
                });
             */
 
	}
    
    return {
        
        //main function to initiate the module
        init: function ($page_selector, $absolute_path) {
       
       
           if($page_selector === "login"){
                handleLogin();
           }
           
           if($page_selector === "reset_password"){
                handleForgetPassword();
           }
           
           if($page_selector === "sign_up"){
                handleRegister($absolute_path);
           }
           
           
            $.backstretch([
                        //$absolute_path +"zf_application/app_views/index/view_client/zf_view_global/view_files/view_images/background_images/background.png",
 		        //$absolute_path + "zf_application/app_views/index/view_client/zf_view_global/view_files/view_images/background_images/1.jpg",
   		        //$absolute_path + "zf_application/app_views/index/view_client/zf_view_global/view_files/view_images/background_images/2.jpg",
    		        //$absolute_path + "zf_application/app_views/index/view_client/zf_view_global/view_files/view_images/background_images/3.jpg",
    		        //$absolute_path + "zf_application/app_views/index/view_client/zf_view_global/view_files/view_images/background_images/4.jpg"
    		        
    		        ], {
    		          fade: 1000,
    		          duration: 8000
            });
	       
        }

    };

}();
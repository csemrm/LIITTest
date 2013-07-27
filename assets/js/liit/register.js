$(function() {
    //Validation for submit ajax form
    $("#register").validate({
        errorClass: 'register-error',
        errorPlacement: function(error, element) {
            error.appendTo(element.parent().append());
        },
        rules: {
            user_name: {
                required: true,
                login: true,
                minlength: 3
            },
            password: {
                required: true,
                password_create: true,
                minlength: 6
            }, confirm_password: {
                equalTo: "#password"
            },
            first_name: {
                required: true,
                alpha: true
            },
            last_name: {
                required: true,
                alpha: true
            },
            email: {
                required: true,
                email: true
            },
            country: {
                required: true
            }
        },
        messages: {
            user_name: {
                minlength: 'You should enter at least 3 characters',
                login: 'Username must contain only letters or numbers'
            }
        }
    });


    $.validator.addMethod("login", function(value, element) {
        return this.optional(element) || /^[a-zA-Z0-9]+$/.test(value);
    }, "Username must contain only letters, numbers, or -.");
    $.validator.addMethod("password_create", function(value, element) {
        return this.optional(element) || /^[a-zA-Z0-9]+$/.test(value);
    }, "Password must contain only letters, numbers or -.");

    $.validator.addMethod("alphanumeric", function(value, element) {
        return this.optional(element) || /^[A-Za-z][a-z0-9\-\s]*$/i.test(value);
    }, "Username must contain only letters or numbers.");

    $.validator.addMethod("alpha", function(value, element) {
        return this.optional(element) || /^[A-Za-z\s]*$/.test(value);
    }, "Username must contain only letters.");

  
    $('#reset').click(function() {
        location.href = '/';
    });
    $('#password').keyup(function() {
        if ($('#confirm_password').attr('value') !== '' && ($('#confirm_password').attr('value') === $('#password').attr('value')) && /^[a-zA-Z0-9]+$/.test($('#password').attr('value'))) {
            $('#password_matched').css('visibility', 'visible');
            $("#password_matched").empty().html('Password Matched');
        } else {
            $("#password_matched").empty();
            $('#password_matched').css('visibility', 'hidden');
        }

    });
    $('#confirm_password').keyup(function() {
        if ($('#confirm_password').attr('value') !== '' && $('#confirm_password').attr('value') === $('#password').attr('value') && /^[a-zA-Z0-9]+$/.test($('#confirm_password').attr('value'))) {
            $('#password_matched').css('visibility', 'visible');
            $("#password_matched").empty().html('Password Matched');
        } else {
            $("#password_matched").empty();
            $('#password_matched').css('visibility', 'hidden');
        }

    });
    $('#user_name').keyup(function() {
        inputString = $(this).attr('value');
        if (inputString.length > 3) {
            $.ajax({
                type: "POST",
                url: "/register/usernameCheck",
                data: "inputString=" + inputString,
                success: function(msg) {
                    if (msg == 'no') {
                        $('#user_name_check').css('visibility', 'hidden');
                        $('#user_name_check').empty().html('');
                        $('#Register').removeAttr("disabled");
                    } else {
                        $('#user_name_check').css('visibility', 'visible');
                        $('#user_name_check').empty().html('Username already exists');
                        $('#Register').attr("disabled", "disabled");

                    }

                }
            });
        }

    });

    $('#email').keyup(function() {
        inputString = $(this).attr('value');
        if (inputString.length > 3) {

            $.ajax({
                type: "POST",
                url: "/register/emailCheck",
                data: "inputString=" + inputString,
                success: function(msg) {
                    if (msg == 'no') {
                        $('#email_check').empty().html('');
                        $('#Register').removeAttr("disabled");
                    } else {
                        $('#email_check').css('visibility', 'visible');
                        $('#email_check').empty().html('Email already exists');
                        $('#Register').attr("disabled", "disabled");
                    }

                }
            });
        }

    });

});
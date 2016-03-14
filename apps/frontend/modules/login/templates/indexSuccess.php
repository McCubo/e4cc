<div class="login-panel panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title">Please Sign In</h3>
    </div>
    <div class="panel-body">
        <form id="login_form" role="form" data-action_url="<?php echo url_for("login/doLogin"); ?>" data-redirect_url="<?php echo url_for("dashboard/index"); ?>" data-student="<?php echo url_for("student/index"); ?>">
            <fieldset>
                <div class="form-group">
                    <input id="username" class="form-control" placeholder="Type your username or Email" name="username" type="text" autofocus>
                </div>
                <div class="form-group">
                    <input id="password" class="form-control" placeholder="Password goes here" name="password" type="password" value="">
                </div>
                <button type="submit" id="login_button" class="btn btn-success"><i class="fa fa-arrow-circle-o-right"></i> Login</button>                				
                <!-- Split button -->
                <div class="btn-group">
                    <button id="create_acc_button" type="button" class="btn btn-info"><i class="fa fa-user-plus"></i> Create my Account </a></button>
                    <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="caret"></span>
                        <span class="sr-only">Toggle Dropdown</span>
                    </button>
                    <ul class="dropdown-menu">
                        <li><a style="cursor: pointer;" id="reset_password_link"><i class="fa fa-key"></i> Reset Password my account's password</a></li>
                    </ul>
                </div>				
            </fieldset>
        </form>
    </div>
</div>
<script>
    $(document).ready(function () {
        $("#reset_password_link").click(function () {
            $("#reset_modal").modal("show");
        });
        $("#create_acc_button").on('click', function () {
            $("#singup_modal").modal('show');
        });

        $("#reset_modal").on('hide.bs.modal', function (e) {
            $(':input').not(':button, :submit, :reset, :hidden, :checkbox, :radio').val('');
        });

        $('#singup_modal').on('hide.bs.modal', function (e) {
            $(':input').not(':button, :submit, :reset, :hidden, :checkbox, :radio').val('');
        });

        $("#reset_pwd_button").on("click", function (event) {
            event.preventDefault();
            $("#reset_pwd_button").prop('disabled', 'disabled');
            var oResetForm = {
                username_email: $("#username_mail_text").val()
            };
            $.ajax({
                url: $("#reset_form").data("action_url"),
                dataType: 'json',
                type: 'post',
                data: {oResetForm: oResetForm},
                success: function (oData) {
                    if (oData.message_list.length > 0) {
                        $("#reset_modal").modal("hide");
                        for (var i = 0; i < oData.message_list.length; i++) {
                            $.growl.error({message: oData.message_list[i]});
                        }
                    } else {
                        $("#reset_modal").modal("hide");
                        $.growl({title: "Information", message: "An email with the required information has been sent to the email address provided."});
                    }
                    $("#reset_pwd_button").prop('disabled', '');
                }
            });
        });

        $("#singup_button").on("click", function (event) {
            event.preventDefault();
            $("#singup_button").prop('disabled', 'disabled');

            // validate form
            var aValidationMessage = [];
            if (!validateRequired($("#fname").val())) {
                aValidationMessage.push("Firt Name is required");
            }
            if (!validateRequired($("#singup_username").val())) {
                aValidationMessage.push("Username is required");
            }
            if (!validateRequired($("#lname").val())) {
                aValidationMessage.push("Last Name is required");
            }
            if (!validateRequired($("#bdate").val())) {
                aValidationMessage.push("Birth Date is required");
            }
            if (!validateRequired($("#singup_password").val())) {
                aValidationMessage.push("Password is required");
            }
            if (!validateEmail($("#usermail").val())) {
                aValidationMessage.push("Please type a valid email account");
            }
            if (!validateRequired($("#usermail").val())) {
                aValidationMessage.push("Email is required");
            }
            if (!validateRequired($("#udui").val())) {
                aValidationMessage.push("DUI is required");
            }
            if (!validateDUI($("#udui").val())) {
                aValidationMessage.push("Please enter a valid DUI");
            }
            if (!validateRequired($("#conf_password").val())) {
                aValidationMessage.push("Confirmation password is required");
            }
            if ($("#conf_password").val() != $("#singup_password").val()) {
                aValidationMessage.push("Password and Confirmation Password do not match");
            }
            if (aValidationMessage.length > 0) {
                for (var i = 0; i < aValidationMessage.length; i++) {
                    $.growl.error({title: "Validation Error", message: aValidationMessage[i]});
                }
                $("#singup_button").prop('disabled', '');
                return false;
            }
            var oSingupForm = {
                fname: $("#fname").val(),
                username: $("#singup_username").val(),
                lname: $("#lname").val(),
                bdate: $("#bdate").val(),
                password: calcSHA1(calcMD5($("#singup_password").val())),
                usermail: $("#usermail").val(),
                udui: $("#udui").val()
            };
            $.ajax({
                url: $("#singup_form").data("action_url"),
                dataType: 'json',
                data: {oSingupForm: oSingupForm},
                type: 'POST',
                success: function (oData, sTextStatus, oQXHR) {
                    console.log(oData);
                    if (oData.message_list.length == 0) {
                        $.growl({title: "Information", message: "An email has been sent to the email address."});
                        $("#singup_modal").modal('hide')
                    } else {
                        for (var c = 0; c < oData.message_list.length; c++) {
                            $.growl.error({message: oData.message_list[c]});
                        }
                    }
                    $("#singup_button").prop('disabled', '');
                }
            });
        });

        $("#login_form").submit(function (event) {
            $("#login_button").prop('disabled', 'disabled');
            event.preventDefault();
            var sPassword = $("#password").val().length > 0 ? $("#password").val() : null;
            var oLoginForm = {};
            oLoginForm.username = $("#username").val();
            if (sPassword) {
                oLoginForm.password = calcSHA1(calcMD5(sPassword));
            } else {
                oLoginForm.password = '';
            }
            $.ajax({
                url: $("#login_form").data("action_url"),
                dataType: 'json',
                data: {user: oLoginForm},
                type: 'POST',
                success: function (oData, sTextStatus, oQXHR) {
                    console.log(oData);
                    if (oData.message_list.length == 0) {
                        if (oData.is_student) {
                            window.location.replace($("#login_form").data('student'));
                        } else {
                            window.location.replace($("#login_form").data('redirect_url'));
                        }
                    } else {
                        for (var c = 0; c < oData.message_list.length; c++) {
                            $.growl.error({message: oData.message_list[c]});
                        }
                    }
                    $("#login_button").prop('disabled', '');
                }
            }
            );
        });
    });
</script>
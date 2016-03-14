<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />        
        <?php include_http_metas(); ?>
        <?php include_metas(); ?>
        <?php include_title(); ?>
        <?php include_stylesheets() ?>
        <?php include_javascripts() ?>
    </head>
    <body>
        <div id="wrapper">
            <!-- Navigation -->
            <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <?php if ($sf_user->hasCredential("admin") || $sf_user->hasCredential("coach")): ?>
                        <a class="navbar-brand" href="<?php echo url_for("dashboard/index"); ?>">Evaluation System</a>
                    <?php endif; ?>
                    <?php if ($sf_user->hasCredential("student")): ?>
                        <a class="navbar-brand" href="<?php echo url_for("student/index"); ?>">English 4 Call Centers</a>
                    <?php endif; ?>
                </div>
                <!-- /.navbar-header -->

                <ul class="nav navbar-top-links navbar-right">
                    <!-- /.dropdown -->
                    <li class="dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                            Signed as: <?php echo $sf_user->getAttribute("username") . " (" . $sf_user->getAttribute("fullname") . ")"; ?><i class="fa fa-user fa-fw"></i><i class="fa fa-caret-down"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-user">
                            <li>
                                <a href="#" id="edit_profile_link" data-get_data="<?php echo url_for("profile/getMyProfile"); ?>" data-save_method="<?php echo url_for("profile/doSave"); ?>">
                                    <i class="fa fa-user fa-fw"></i> View My Profile
                                </a>
                            </li>
                            <li class="divider"></li>
                            <li><a href="<?php echo url_for("login/logout"); ?>"><i class="fa fa-sign-out fa-fw"></i> Logout</a></li>
                            <!--<li><a href="login.html"><i class="fa fa-bug fa-fw"></i> Report Bug</a></li>-->
                        </ul>
                        <!-- /.dropdown-user -->
                    </li>
                    <!-- /.dropdown -->
                </ul>
                <!-- /.navbar-top-links -->

                <div class="navbar-default sidebar" role="navigation">
                    <div class="sidebar-nav navbar-collapse">
                        <ul class="nav" id="side-menu">
                            <?php if ($sf_user->hasCredential("admin") || $sf_user->hasCredential("coach")): ?>
                                <li>
                                    <a href="<?php echo url_for("dashboard/index"); ?>"><i class="fa fa-home fa-fw"></i> Home</a>
                                </li>
                            <?php endif; ?>
                            <?php if ($sf_user->hasCredential("admin")): ?>
                                <li>
                                    <a href="#"><i class="fa fa-tasks fa-fw"></i> Control Panel<span class="fa arrow"></span></a>
                                    <ul class="nav nav-second-level">
                                        <li>
                                            <a href="<?php echo url_for("cp_user/index"); ?>">1. Users</a>
                                        </li>
                                        <li>
                                            <a href="<?php echo url_for("cp_level/index"); ?>">2. Levels</a>
                                        </li>
                                        <li>
                                            <a href="<?php echo url_for("cp_site/index"); ?>">3. Sites</a>
                                        </li>
                                        <li>
                                            <a href="<?php echo url_for("cp_class_room/index"); ?>">4. Class Rooms</a>
                                        </li>
                                        <li>
                                            <a href="<?php echo url_for("cp_schedule/index"); ?>">5. Schedules</a>
                                        </li>
                                    </ul>
                                    <!-- /.nav-second-level -->
                                </li>
                            <?php endif; ?>
                            <?php if ($sf_user->hasCredential("student")): ?>
                                <li>
                                    <a href="<?php echo url_for("student/index"); ?>"><i class="fa fa-line-chart"></i> My Personal Progress</a>
                                </li>
                            <?php endif; ?>
                            <?php if ($sf_user->hasCredential("admin") || $sf_user->hasCredential("coach")): ?>
                                <li>
                                    <a href="<?php echo url_for("lookup/index"); ?>"><i class="fa fa-search"></i> Students Lookup</a>
                                </li>
                            <?php endif; ?>
                            <?php if ($sf_user->hasCredential("admin") || $sf_user->hasCredential("coach")): ?>
                                <li>
                                    <a href="<?php echo url_for("course_coach/index"); ?>"><i class="fa fa-book"></i> My Courses</a>
                                </li>
                            <?php endif; ?>
                            <?php if ($sf_user->hasCredential("admin")): ?>
                                <li>
                                    <a href="<?php echo url_for("course/index"); ?>"><i class="fa fa-gears"></i> Manage Courses</a>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </div>
                    <!-- /.sidebar-collapse -->
                </div>
                <!-- /.navbar-static-side -->
            </nav>

            <div id="page-wrapper">
                <?php echo $sf_content ?>
            </div>
            <!-- /#page-wrapper -->

        </div>      
    </body>

    <!-- Modal -->
    <div class="modal fade" id="profile_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">My Profile</h4>
                </div>
                <div class="modal-body">
                    <form method="post" action="<?php echo url_for("login/doInsertStudent"); ?>" id="singup_form" data-action_url="<?php echo url_for("login/doInsertStudent"); ?>">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="fname">First Name:</label>
                                    <input type="text" id="fname" class="form-control" placeholder="Your first name goes here!" tabindex="1" />
                                </div>
                                <div class="form-group">
                                    <label for="username">Username: </label>
                                    <input type="text" id="username" class="form-control" placeholder="Type your username" tabindex="3" />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="lname">Last Name:</label>
                                    <input type="text" id="lname" class="form-control" placeholder="Your last name goes here!" tabindex="2" />
                                </div>
                                <div class="form-group">
                                    <label for="bdate">Birthdate:</label>
                                    <input type="date" id="bdate" class="form-control" tabindex="4" />
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="password">Password: </label>
                            <input type="password" id="password" class="form-control" placeholder="Password" tabindex="5" />
                        </div>
                        <div class="form-group">
                            <label for="cpassword">Confirm Password: </label>
                            <input type="password" id="cpassword" class="form-control" placeholder="Confirm Password" tabindex="6" />
                        </div>                        
                        <div class="form-group">
                            <label for="usermail">Email:</label>
                            <input type="email" id="usermail" class="form-control" placeholder="Your personal Email" tabindex="7" />
                        </div>
                        <?php if ($sf_user->hasCredential("student")): ?>
                            <div class="form-group">
                                <label for="udui">DUI:</label>
                                <input type="text" id="udui" class="form-control" placeholder="DUI" tabindex="7" />
                            </div>
                        <?php endif; ?>
                    </form>
                </div>
                <div class="modal-footer">
                    <button id="save_profile_button" type="button" class="btn btn-success">Save changes</button>
                </div>
            </div>
        </div>
    </div>
</html>
<script>
    $(document).ready(function () {
        $("#edit_profile_link").click(function (event) {
            $.ajax({
                url: $("#edit_profile_link").data("get_data"),
                dataType: 'json',
                success: function (oData, sStatus, oXMLResponse) {
                    $("#fname").val(oData.personal_info.fname);
                    $("#lname").val(oData.personal_info.lname);
                    $("#username").val(oData.personal_info.username);
                    $("#bdate").val(oData.personal_info.bdate);
                    $("#usermail").val(oData.personal_info.email);
                    if (oData.is_student) {
                        $("#udui").val(oData.personal_info.dui);
                    }
                    $("#profile_modal").modal("show");
                },
                error: function (oData, sCode, sStatus) {
                    $.growl.error({title: sStatus, message: sCode + " : " + oData.status});
                }
            });
            event.preventDefault();
        });

        $("#save_profile_button").click(function (event) {
            $("#save_profile_button").prop('disabled', 'disabled');
            // validate form
            var aValidationMessage = [];
            if (!validateRequired($("#fname").val())) {
                aValidationMessage.push("Firt Name is required");
            }
            if (!validateRequired($("#username").val())) {
                aValidationMessage.push("Username is required");
            }
            if (!validateRequired($("#lname").val())) {
                aValidationMessage.push("Last Name is required");
            }
            if (!validateRequired($("#bdate").val())) {
                aValidationMessage.push("Birth Date is required");
            }
            if (!validateEmail($("#usermail").val())) {
                aValidationMessage.push("Please type a valid email account");
            }
            if (!validateRequired($("#usermail").val())) {
                aValidationMessage.push("Email is required");
            }
            if ($("#udui").length > 0) {
                if (!validateRequired($("#udui").val())) {
                    aValidationMessage.push("DUI is required");
                }
                if (!validateDUI($("#udui").val())) {
                    aValidationMessage.push("Please enter a valid DUI");
                }
            }
            if ($("#cpassword").val() != $("#password").val()) {
                aValidationMessage.push("Password and Confirmation Password do not match");
            }
            if (aValidationMessage.length > 0) {
                for (var i = 0; i < aValidationMessage.length; i++) {
                    $.growl.error({title: "Validation Error", message: aValidationMessage[i]});
                }
                $("#save_profile_button").prop('disabled', '');
                return false;
            }
            var oProfile = {
                fname: $("#fname").val(),
                username: $("#username").val(),
                lname: $("#lname").val(),
                bdate: $("#bdate").val(),
                email: $("#usermail").val()
            };
            if ($("#password").val().length > 0) {
                oProfile.password = calcSHA1(calcMD5($("#password").val()));
            }
            if ($("#udui").length > 0) {
                oProfile.dui = $("#udui").val();
            }
            console.log(oProfile);
            $.ajax({
                url: $("#edit_profile_link").data("save_method"),
                dataType: 'json',
                type: 'post',
                data: {
                    oProfile: oProfile
                },
                success: function (oData, sStatus, oXMLResponse) {
                    $("#save_profile_button").prop('disabled', '');
                    if (oData.message_list.length == 0) {
                        $.growl({title: "Success", message: "Your profile has been updated."});
                        $("#cpassword").val("");
                        $("#password").val("");
                        $("#profile_modal").modal("hide");
                    } else {
                        for (var i = 0; i < oData.message_list.length; i++) {
                            $.growl.error({message: oData.message_list[i]});
                        }
                    }
                },
                error: function (oData, sCode, sStatus) {
                    $("#profile_modal").modal("hide");
                    $("#save_profile_button").prop('disabled', '');
                    $.growl.error({title: sStatus, message: sCode + " : " + oData.status});
                }
            });
            event.preventDefault();
        });
    });
</script>

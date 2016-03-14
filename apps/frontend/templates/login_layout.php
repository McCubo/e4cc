<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <?php include_http_metas(); ?>
        <?php include_metas(); ?>
        <?php include_title(); ?>
        <?php include_stylesheets() ?>
        <?php include_javascripts() ?>    
        <style>
            body { 
                background: url(<?php echo image_path('score.jpg'); ?>) no-repeat fixed; 
                -webkit-background-size: cover;
                -moz-background-size: cover;
                -o-background-size: cover;
                background-size: cover;
            }            
        </style>
    </head>
    <body>
        <div class="container" style="opacity: 0.94"> 
            <div class="row">
                <div class="col-md-4 col-md-offset-4">
                    <?php echo $sf_content ?>
                </div>
            </div>
        </div>
    </body>

    <!-- Modal for registrations-->
    <div class="modal fade" id="singup_modal" tabindex="-1" role="dialog" >
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel"><i class="fa fa-terminal"></i> Sing up to English 4 Call Centers</h4>
                </div>
                <div class="modal-body">
                    <form method="post" action="<?php echo url_for("login/doInsertStudent"); ?>" id="singup_form" data-action_url="<?php echo url_for("login/doInsertStudent"); ?>">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="fname">First Name:</label>
                                    <input name="oSingupForm[fname]]" type="text" id="fname" class="form-control" placeholder="Your first name goes here!" tabindex="1">
                                </div>
                                <div class="form-group">
                                    <label for="username">Username: </label>
                                    <input name="oSingupForm[username]" type="text" id="singup_username" class="form-control" placeholder="Type your username" tabindex="3">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="lname">Last Name:</label>
                                    <input name="oSingupForm[lname]" type="text" id="lname" class="form-control" placeholder="Your last name goes here!" tabindex="2">
                                </div>
                                <div class="form-group">
                                    <label for="bdate">Birthdate:</label>
                                    <input name="oSingupForm[bdate]" type="date" id="bdate" class="form-control" tabindex="4">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="password">Password: </label>
                            <input name="oSingupForm[password]" type="password" id="singup_password" class="form-control" placeholder="Password" tabindex="5">
                        </div>
                        <div class="form-group">
                            <label for="conf_password">Confirm Password:</label>
                            <input type="password" id="conf_password" class="form-control" placeholder="Confirm your password" tabindex="6">
                        </div>
                        <div class="form-group">
                            <label for="usermail">Email:</label>
                            <input name="oSingupForm[usermail]" type="email" id="usermail" class="form-control" placeholder="Your personal Email" tabindex="7">
                        </div>
                        <div class="form-group">
                            <label for="udui">DUI:</label>
                            <input name="oSingupForm[udui]" type="text" id="udui" class="form-control" placeholder="DUI" tabindex="7">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-ban"></i> Cancel</button>
                    <button id="singup_button" type="button" class="btn btn-primary"><i class="fa fa-user-plus"></i> Create Account</button>                    
                </div>
            </div>
        </div>
    </div>

    <!-- Modal for reset password-->
    <div class="modal fade" id="reset_modal" tabindex="-1" role="dialog" >
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel"><i class="fa fa-keyboard-o"></i> Reset my account's password</h4>
                </div>
                <div class="modal-body">
                    <form method="post" id="reset_form" data-action_url="<?php echo url_for("login/resetPassword"); ?>">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="username_mail_text">Type your username or email:</label>
                                    <input type="text" id="username_mail_text" class="form-control" placeholder="Your Email address or username!" tabindex="1">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-ban"></i> Cancel</button>
                    <button id="reset_pwd_button" type="button" class="btn btn-primary"><i class="fa fa-reply-all"></i> Send me a new password!</button>                    
                </div>
            </div>
        </div>
    </div>
</html>
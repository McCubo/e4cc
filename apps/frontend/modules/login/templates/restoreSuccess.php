<div class="login-panel panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-life-ring"></i> Restore my Password</h3>
    </div>
    <div class="panel-body">
        <form id="reset_form" role="form" data-action_url="<?php echo url_for("login/doRestorePassword"); ?>" data-redirect_url="<?php echo url_for("login/index"); ?>">
            <fieldset>
                <div class="form-group">
                    <input class="form-control" type="text" disabled="disabled" value="<?php echo $sf_request->getParameter("token"); ?>">
                    <input id="token" type="hidden" disabled="disabled" value="<?php echo $sf_request->getParameter("token"); ?>">
                </div>
                <div class="form-group">
                    <input id="fpassword" class="form-control" placeholder="Type your new password" name="username" type="password" autofocus>
                </div>
                <div class="form-group">
                    <input id="cpassword" class="form-control" placeholder="Confirm password" name="password" type="password" value="">
                </div>
                <button type="button" id="reset_pwd_button" class="btn btn-danger"><i class="fa fa-expeditedssl"></i> Update my password</button>
            </fieldset>
        </form>
    </div>
</div>
<script>
    $(document).ready(function () {
        $("#reset_pwd_button").on("click", function (e) {
            var oForm = {
                token: $("#token").val(),
                password: calcSHA1(calcMD5($("#fpassword").val())),
                cpassword: calcSHA1(calcMD5($("#cpassword").val()))
            }
            $.ajax({
                url: $("#reset_form").data("action_url"),
                dataType: 'json',
                type: 'post',
                data: {oForm: oForm},
                success: function (oData, sXMLResponse, oXML) {
                    if (oData.message_list.length == 0) {
                        alert("Password was updated successfully!\nYou will be redirect to the login page");
                        window.location.replace($("#reset_form").data('redirect_url'));
                    } else {
                        for (var i = 0; i < oData.message_list.length; i++) {
                            $.growl.error({message: oData.message_list[i]});
                        }
                    }
                }
            });
            e.preventDefault();
        });
    });
</script>
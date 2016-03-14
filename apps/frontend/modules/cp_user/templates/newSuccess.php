<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">New User</h1>
    </div>
    <!-- /.col-lg-12 -->
</div>

<ol class="breadcrumb">
    <li><a href="<?php echo url_for("cp_user/index"); ?>">Users List</a></li>
    <li class="active">New User</li>
</ol>

<form class="form-horizontal" id="form_data">
    <div class="form-group">
        <label for="input_first_name" class="col-sm-2 control-label">First Name</label>
        <div class="col-sm-6">
            <input type="text" class="form-control" name="input_first_name" id="input_first_name" placeholder="First Name">
        </div>
    </div>
    <div class="form-group">
        <label for="input_last_name" class="col-sm-2 control-label">Last Name</label>
        <div class="col-sm-6">
            <input type="text" class="form-control" name="input_last_name" id="input_last_name" placeholder="Last Name">
        </div>
    </div>
    <div class="form-group">
        <label for="input_birthdate" class="col-sm-2 control-label">Birthdate</label>
        <div class="col-sm-6">
            <input type="date" class="form-control" name="input_birthdate" id="input_birthdate" placeholder="Birthdate">
        </div>
    </div>
    <div class="form-group">
        <label for="input_email" class="col-sm-2 control-label">Email</label>
        <div class="col-sm-6">
            <input type="text" class="form-control" name="input_email" id="input_email" placeholder="Email">
        </div>
    </div>
    <div class="form-group">
        <label for="input_username" class="col-sm-2 control-label">Username</label>
        <div class="col-sm-6">
            <input type="text" class="form-control" name="input_username" id="input_username" placeholder="Username">
        </div>
    </div>
    <div class="form-group">
        <label for="select_role_id" class="col-sm-2 control-label">Role</label>
        <div class="col-sm-6">
            <select class="form-control" id="select_role_id">
                <option value="">Select one option</option>
                <?php
                foreach ($roleArray as $record) {
                    $role = new Role();
                    $role = (object) $record;

                    echo "<option value='{$role->getId()}'>{$role->getRoleName()}</option>";
                }
                ?>
            </select>
        </div>
    </div>
    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-6">
            <button type="button" class="btn btn-danger" id="btn_cancel"><span class="glyphicon glyphicon-ban-circle"></span> Cancel</button>
            <button type="button" class="btn btn-primary" id="btn_save"><span class="glyphicon glyphicon-ok-circle"></span> Save</button>
        </div>
    </div>
</form>

<script>
    $(document).ready(function () {
        /*listeners*/
        $("#btn_cancel").click(function () {
            $(location).attr("href", "<?php echo url_for("cp_user/index"); ?>");
        });

        $("#btn_save").click(function () {
            if (isValid()) {
                save();
            }
        });

        /*functions*/
        function save() {
            var first_name = $("#input_first_name").val();
            var last_name = $("#input_last_name").val();
            var birthdate = $("#input_birthdate").val();
            var email = $("#input_email").val();
            var username = $("#input_username").val();
            var role_id = $("#select_role_id").val();
            $.ajax({
                url: "<?php echo url_for("cp_user/save"); ?>",
                type: "POST",
                data: {
                    first_name: first_name,
                    last_name: last_name,
                    birthdate: birthdate,
                    email: email,
                    username: username,
                    password: calcSHA1(calcMD5(username)),
                    role_id: role_id
                },
                success: function () {
                    $(location).attr("href", "<?php echo url_for("cp_user/index"); ?>");
                },
                error: function () {
                    $.growl.error({message: "An error has occured"});
                }
            });
        }

        function isValid() {
            var form_id = "form_data";

            $("#" + form_id).find(".has-error").find(".control-label").remove();
            $("#" + form_id).find(".has-error").removeClass("has-error");

            var validator = new FormValidator(form_id, [{
                    name: "input_first_name",
                    display: "First Name",
                    rules: "required"
                }], function (errors, event) {
                isValidCallbackUser(errors);
            });
            var isFirstNameValid = validator._validateForm();

            var validator = new FormValidator(form_id, [{
                    name: "input_last_name",
                    display: "Last Name",
                    rules: "required"
                }], function (errors, event) {
                isValidCallbackUser(errors);
            });
            var isLastNameValid = validator._validateForm();

            var validator = new FormValidator(form_id, [{
                    name: "input_birthdate",
                    display: "Birthdate",
                    rules: "required"
                }], function (errors, event) {
                isValidCallbackUser(errors);
            });
            var isBirthdateValid = validator._validateForm();

            var validator = new FormValidator(form_id, [{
                    name: "input_email",
                    display: "Emil",
                    rules: "required|valid_email"
                }], function (errors, event) {
                isValidCallbackUser(errors);
            });
            var isEmilValid = validator._validateForm();

            var validator = new FormValidator(form_id, [{
                    name: "select_role_id",
                    display: "Role",
                    rules: "required"
                }], function (errors, event) {
                isValidCallbackUser(errors);
            });
            var isRoleValid = validator._validateForm();

            var validator = new FormValidator(form_id, [{
                    name: "input_username",
                    display: "Username",
                    rules: "required"
                }], function (errors, event) {
                isValidCallbackUser(errors);
            });
            var isUsernameValid = validator._validateForm() ? isUserValid() : false;

            var isValidReturn = false;
            if (isFirstNameValid && isLastNameValid && isBirthdateValid && isEmilValid && isRoleValid && isUsernameValid) {
                isValidReturn = true;
            }

            return isValidReturn;
        }

        function isValidCallbackUser(errors) {
            if (errors.length > 0) {
                for (key in errors) {
                    var element = $("#" + errors[key].id);
                    var parent = element.parent("div");
                    parent.addClass("has-error");
                    parent.prepend("<label class='control-label' for='" + errors[key].id + "'>" + errors[key].message + "</label>");
                }
            }
        }

        function isUserValid() {
            var isValidReturn = false;
            var username = $("#input_username").val();
            $.ajax({
                async: false,
                url: "<?php echo url_for("cp_user/validateUser"); ?>",
                type: "POST",
                data: {
                    username: username
                },
                success: function (data) {
                    if (data === "1") {
                        isValidReturn = true;
                    } else {
                        var element = $("#input_username");
                        var parent = element.parent("div");
                        parent.addClass("has-error");
                        parent.prepend("<label class='control-label' for='input_username'>The Username already exists</label>");
                    }
                },
                error: function () {
                    $.growl.error({message: "An error has occured"});
                }
            });
            return isValidReturn;
        }
    });
</script>
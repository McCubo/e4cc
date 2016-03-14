<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Edit Student</h1>
    </div>
    <!-- /.col-lg-12 -->
</div>

<ol class="breadcrumb">
    <li><a href="<?php echo url_for("lookup/index"); ?>">Students Lookup</a></li>
    <li class="active">Edit Student</li>
</ol>

<form class="form-horizontal" id="form_data">
    <div class="form-group">
        <label for="input_dui" class="col-sm-2 control-label">Dui</label>
        <div class="col-sm-6">
            <input type="text" class="form-control" name="input_dui" id="input_dui" placeholder="Dui" maxlength="9" value="<?php echo $student->getDui(); ?>">
        </div>
    </div>
    <div class="form-group">
        <label for="input_first_name" class="col-sm-2 control-label">First Name</label>
        <div class="col-sm-6">
            <input type="text" class="form-control" name="input_first_name" id="input_first_name" placeholder="First Name" value="<?php echo $person->getFirstName(); ?>">
        </div>
    </div>
    <div class="form-group">
        <label for="input_last_name" class="col-sm-2 control-label">Last Name</label>
        <div class="col-sm-6">
            <input type="text" class="form-control" name="input_last_name" id="input_last_name" placeholder="Last Name" value="<?php echo $person->getLastName(); ?>">
        </div>
    </div>
    <div class="form-group">
        <label for="input_birthdate" class="col-sm-2 control-label">Birthdate</label>
        <div class="col-sm-6">
            <input type="date" class="form-control" name="input_birthdate" id="input_birthdate" placeholder="Birthdate" value="<?php echo $person->getBirthdate(); ?>">
        </div>
    </div>
    <div class="form-group">
        <label for="input_email" class="col-sm-2 control-label">Email</label>
        <div class="col-sm-6">
            <input type="text" class="form-control" name="input_email" id="input_email" placeholder="Email" value="<?php echo $person->getEmail(); ?>">
        </div>
    </div>
    <div class="form-group">
        <label for="radio_is_active" class="col-sm-2 control-label">Status</label>
        <div class="col-sm-6">
            <label class="radio-inline">
                <input type="radio" name="radio_is_active" id="radio_is_active_active" value="1" <?php echo $student->getIsActive() ? "checked='checked'" : "" ?>> Active
            </label>
            <label class="radio-inline">
                <input type="radio" name="radio_is_active" id="radio_is_active_inactive" value="0" <?php echo $student->getIsActive() ? "" : "checked='checked'" ?>> Inactive
            </label>
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
            $(location).attr("href", "<?php echo url_for("lookup/index"); ?>");
        });

        $("#btn_save").click(function () {
            if (isValid()) {
                save();
            }
        });

        /*functions*/
        function save() {
            var id = "<?php echo $student->getId(); ?>";
            var dui = $("#input_dui").val();
            var first_name = $("#input_first_name").val();
            var last_name = $("#input_last_name").val();
            var birthdate = $("#input_birthdate").val();
            var email = $("#input_email").val();
            var is_active = $("input[name=radio_is_active]:checked").val();
            $.ajax({
                url: "<?php echo url_for("lookup/update"); ?>",
                type: "POST",
                data: {
                    id: id,
                    dui: dui,
                    first_name: first_name,
                    last_name: last_name,
                    birthdate: birthdate,
                    email: email,
                    is_active: is_active
                },
                success: function () {
                    $(location).attr("href", "<?php echo url_for("lookup/index"); ?>");
                },
                error: function () {
                    $.growl.error({message: "An error has occured"});
                }
            });
        }

        function isValid() {
            var form_id = "form_data";
            var validator = new FormValidator(form_id, [{
                    name: "input_dui",
                    display: "Dui",
                    rules: "required|integer|exact_length[9]"
                }, {
                    name: "input_first_name",
                    display: "First Name",
                    rules: "required"
                }, {
                    name: "input_last_name",
                    display: "Last Name",
                    rules: "required"
                }, {
                    name: "input_birthdate",
                    display: "Birthdate",
                    rules: "required"
                }, {
                    name: "input_email",
                    display: "Email",
                    rules: "required|valid_email"
                }], function (errors, event) {
                isValidCallback(form_id, errors, event);
            });
            return validator._validateForm();
        }

    });
</script>
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Edit Level</h1>
    </div>
    <!-- /.col-lg-12 -->
</div>

<ol class="breadcrumb">
    <li><a href="<?php echo url_for("cp_level/index"); ?>">Levels List</a></li>
    <li class="active">Edit Level</li>
</ol>

<form class="form-horizontal" id="form_data">
    <div class="form-group">
        <label for="input_level_name" class="col-sm-2 control-label">Level Name</label>
        <div class="col-sm-6">
            <input type="text" class="form-control" name="input_level_name" id="input_level_name" placeholder="Level Name" value="<?php echo $level->getLevelName(); ?>">
        </div>
    </div>
    <div class="form-group">
        <label for="radio_is_active" class="col-sm-2 control-label">Status</label>
        <div class="col-sm-6">
            <label class="radio-inline">
                <input type="radio" name="radio_is_active" id="radio_is_active_active" value="1" <?php echo $level->getIsActive() ? "checked='checked'" : "" ?>> Active
            </label>
            <label class="radio-inline">
                <input type="radio" name="radio_is_active" id="radio_is_active_inactive" value="0" <?php echo $level->getIsActive() ? "" : "checked='checked'" ?>> Inactive
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
            $(location).attr("href", "<?php echo url_for("cp_level/index"); ?>");
        });

        $("#btn_save").click(function () {
            if (isValid()) {
                save();
            }
        });

        /*functions*/
        function save() {
            var id = "<?php echo $level->getId(); ?>";
            var level_name = $("#input_level_name").val();
            var is_active = $("input[name=radio_is_active]:checked").val();
            $.ajax({
                url: "<?php echo url_for("cp_level/update"); ?>",
                type: "POST",
                data: {
                    id: id,
                    level_name: level_name,
                    is_active: is_active
                },
                success: function () {
                    $(location).attr("href", "<?php echo url_for("cp_level/index"); ?>");
                },
                error: function () {
                    $.growl.error({message: "An error has occured"});
                }
            });
        }

        function isValid() {
            var form_id = "form_data";
            var validator = new FormValidator(form_id, [{
                    name: "input_level_name",
                    display: "Level Name",
                    rules: "required"
                }], function (errors, event) {
                isValidCallback(form_id, errors, event);
            });
            return validator._validateForm();
        }
    });
</script>
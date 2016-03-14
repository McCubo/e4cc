<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">New Level</h1>
    </div>
    <!-- /.col-lg-12 -->
</div>

<ol class="breadcrumb">
    <li><a href="<?php echo url_for("cp_level/index"); ?>">Levels List</a></li>
    <li class="active">New Level</li>
</ol>

<form class="form-horizontal" id="form_data">
    <div class="form-group">
        <label for="input_level_name" class="col-sm-2 control-label">Level Name</label>
        <div class="col-sm-6">
            <input type="text" class="form-control" name="input_level_name" id="input_level_name" placeholder="Level Name">
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
            var level_name = $("#input_level_name").val();
            $.ajax({
                url: "<?php echo url_for("cp_level/save"); ?>",
                type: "POST",
                data: {
                    level_name: level_name
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
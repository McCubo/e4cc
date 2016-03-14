<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">New Schedule</h1>
    </div>
    <!-- /.col-lg-12 -->
</div>

<ol class="breadcrumb">
    <li><a href="<?php echo url_for("cp_schedule/index"); ?>">Schedules List</a></li>
    <li class="active">New Schedule</li>
</ol>

<form class="form-horizontal" id="form_data">
    <div class="form-group">
        <label for="input_start" class="col-sm-2 control-label">Start Time</label>
        <div class="col-sm-6">
            <input type="time" class="form-control" name="input_start" id="input_start" placeholder="Start Time">
        </div>
    </div>
    <div class="form-group">
        <label for="input_end" class="col-sm-2 control-label">End Time</label>
        <div class="col-sm-6">
            <input type="time" class="form-control" name="input_end" id="input_end" placeholder="End Time">
        </div>
    </div>
    <div class="form-group">
        <label for="input_description" class="col-sm-2 control-label">Description</label>
        <div class="col-sm-6">
            <input type="text" class="form-control" name="input_description" id="input_description" placeholder="Description">
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
            $(location).attr("href", "<?php echo url_for("cp_schedule/index"); ?>");
        });

        $("#btn_save").click(function () {
            if (isValid()) {
                save();
            }
        });

        /*functions*/
        function save() {
            var start = $("#input_start").val();
            var end = $("#input_end").val();
            var description = $("#input_description").val();
            $.ajax({
                url: "<?php echo url_for("cp_schedule/save"); ?>",
                type: "POST",
                data: {
                    start: start,
                    end: end,
                    description: description
                },
                success: function () {
                    $(location).attr("href", "<?php echo url_for("cp_schedule/index"); ?>");
                },
                error: function () {
                    $.growl.error({message: "An error has occured"});
                }
            });
        }

        function isValid() {
            var form_id = "form_data";
            var validator = new FormValidator(form_id, [{
                    name: "input_start",
                    display: "Start Time",
                    rules: "required"
                }, {
                    name: "input_end",
                    display: "End Time",
                    rules: "required"
                }], function (errors, event) {
                isValidCallback(form_id, errors, event);
            });
            return validator._validateForm();
        }
    });
</script>
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">New Class Room</h1>
    </div>
    <!-- /.col-lg-12 -->
</div>

<ol class="breadcrumb">
    <li><a href="<?php echo url_for("cp_class_room/index"); ?>">Class Rooms List</a></li>
    <li class="active">New Class Room</li>
</ol>

<form class="form-horizontal" id="form_data">
    <div class="form-group">
        <label for="select_site_id" class="col-sm-2 control-label">Site</label>
        <div class="col-sm-6">
            <select class="form-control" name="select_site_id" id="select_site_id">
                <option value="">Select one option</option>
                <?php
                foreach ($siteArray as $record) {
                    $site = new Site();
                    $site = (object) $record;

                    echo "<option value='{$site->getId()}'>{$site->getSiteName()}</option>";
                }
                ?>
            </select>
        </div>
    </div>
    <div class="form-group">
        <label for="input_class_room_name" class="col-sm-2 control-label">Class Room Name</label>
        <div class="col-sm-6">
            <input type="text" class="form-control" name="input_class_room_name"  id="input_class_room_name" placeholder="Class Room Name">
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
            $(location).attr("href", "<?php echo url_for("cp_class_room/index"); ?>");
        });

        $("#btn_save").click(function () {
            if (isValid()) {
                save();
            }
        });

        /*functions*/
        function save() {
            var site_id = $("#select_site_id").val();
            var class_room_name = $("#input_class_room_name").val();
            $.ajax({
                url: "<?php echo url_for("cp_class_room/save"); ?>",
                type: "POST",
                data: {
                    site_id: site_id,
                    class_room_name: class_room_name
                },
                success: function () {
                    $(location).attr("href", "<?php echo url_for("cp_class_room/index"); ?>");
                },
                error: function () {
                    $.growl.error({message: "An error has occured"});
                }
            });
        }

        function isValid() {
            var form_id = "form_data";
            var validator = new FormValidator(form_id, [{
                    name: "select_site_id",
                    display: "Site",
                    rules: "required"
                }, {
                    name: "input_class_room_name",
                    display: "Class Room Name",
                    rules: "required"
                }], function (errors, event) {
                isValidCallback(form_id, errors, event);
            });
            return validator._validateForm();
        }
    });
</script>
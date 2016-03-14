<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Edit Class Room</h1>
    </div>
    <!-- /.col-lg-12 -->
</div>

<ol class="breadcrumb">
    <li><a href="<?php echo url_for("cp_class_room/index"); ?>">Class Rooms List</a></li>
    <li class="active">Edit Class Room</li>
</ol>

<form class="form-horizontal" id="form_data">
    <div class="form-group">
        <label for="select_site_id" class="col-sm-2 control-label">Site</label>
        <div class="col-sm-6">
            <select class="form-control" name="select_site_id" id="select_site_id">
                <?php
                foreach ($siteArray as $record) {
                    $site = new Site();
                    $site = (object) $record;

                    $selected = $classRoom->getSite()->getId() == $site->getId() ? "selected='selected'" : "";

                    echo "<option value='{$site->getId()}' {$selected}>{$site->getSiteName()}</option>";
                }
                ?>
            </select>
        </div>
    </div>
    <div class="form-group">
        <label for="input_class_room_name" class="col-sm-2 control-label">Class Room Name</label>
        <div class="col-sm-6">
            <input type="text" class="form-control" name="input_class_room_name" id="input_class_room_name" placeholder="Class Room Name" value="<?php echo $classRoom->getClassRoomName(); ?>">
        </div>
    </div>
    <div class="form-group">
        <label for="radio_is_active" class="col-sm-2 control-label">Status</label>
        <div class="col-sm-6">
            <label class="radio-inline">
                <input type="radio" name="radio_is_active" id="radio_is_active_active" value="1" <?php echo $classRoom->getIsActive() ? "checked='checked'" : "" ?>> Active
            </label>
            <label class="radio-inline">
                <input type="radio" name="radio_is_active" id="radio_is_active_inactive" value="0" <?php echo $classRoom->getIsActive() ? "" : "checked='checked'" ?>> Inactive
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
            $(location).attr("href", "<?php echo url_for("cp_class_room/index"); ?>");
        });

        $("#btn_save").click(function () {
            if (isValid()) {
                save();
            }
        });

        /*functions*/
        function save() {
            var id = "<?php echo $classRoom->getId(); ?>";
            var site_id = $("#select_site_id").val();
            var class_room_name = $("#input_class_room_name").val();
            var is_active = $("input[name=radio_is_active]:checked").val();
            $.ajax({
                url: "<?php echo url_for("cp_class_room/update"); ?>",
                type: "POST",
                data: {
                    id: id,
                    site_id: site_id,
                    class_room_name: class_room_name,
                    is_active: is_active
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
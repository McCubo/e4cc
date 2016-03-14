<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">New Course</h1>
    </div>
    <!-- /.col-lg-12 -->
</div>

<ol class="breadcrumb">
    <li><a href="<?php echo url_for("course/index"); ?>">Manage Courses</a></li>
    <li class="active">New Course</li>
</ol>

<form class="form-horizontal" id="form_data">
    <div class="form-group">
        <label for="input_course_name" class="col-sm-2 control-label">Course Name</label>
        <div class="col-sm-6">
            <input type="text" class="form-control" name="input_course_name"  id="input_course_name" placeholder="Course Name">
        </div>
    </div>
    <div class="form-group">
        <label for="select_level_id" class="col-sm-2 control-label">Level</label>
        <div class="col-sm-6">
            <select class="form-control" name="select_level_id" id="select_level_id">
                <option value="">Select one option</option>
                <?php
                foreach ($levelArray as $record) {
                    $level = new Level();
                    $level = (object) $record;

                    echo "<option value='{$level->getId()}'>{$level->getLevelName()}</option>";
                }
                ?>
            </select>
        </div>
    </div>
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
        <label for="select_class_room_id" class="col-sm-2 control-label">Class Room</label>
        <div class="col-sm-6">
            <select class="form-control" name="select_class_room_id" id="select_class_room_id">
                <option value="">Select one option</option>
            </select>
        </div>
    </div>
    <div class="form-group">
        <label for="select_schedule_id" class="col-sm-2 control-label">Schedule</label>
        <div class="col-sm-6">
            <select class="form-control" name="select_schedule_id" id="select_schedule_id">
                <option value="">Select one option</option>
                <?php
                foreach ($scheduleArray as $record) {
                    $schedule = new Schedule();
                    $schedule = (object) $record;

                    echo "<option value='{$schedule->getId()}'>{$schedule->getScheduleName()}</option>";
                }
                ?>
            </select>
        </div>
    </div>
    <div class="form-group">
        <label for="select_user_id" class="col-sm-2 control-label">Coach</label>
        <div class="col-sm-6">
            <select class="form-control" name="select_user_id" id="select_user_id">
                <option value="">Select one option</option>
                <?php
                foreach ($userArray as $record) {
                    $user = new User();
                    $user = (object) $record;

                    $person = new Person();
                    $person = (object) $user->getPerson();

                    echo "<option value='{$user->getId()}'>{$person->getFullName()}</option>";
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
        var course_id = 4;

        /*listeners*/
        $("#btn_cancel").click(function () {
            $(location).attr("href", "<?php echo url_for("course/index"); ?>");
        });

        $("#select_site_id").change(function () {
            var site_id = $(this).val();
            getClassRoom(site_id);
        });

        $("#btn_save").click(function () {
            if (isValid()) {
                save();
            }
        });

        $("#course_modal").on("hidden.bs.modal", function () {
            loadContent("div_container", "<?php echo url_for("course/edit?id="); ?>" + course_id);
        });

        /*functions*/
        function getClassRoom(site_id) {
            $.ajax({
                url: "<?php echo url_for("course/getClassRoom"); ?>",
                type: "POST",
                dataType: "HTML",
                data: {
                    site_id: site_id
                },
                success: function (data) {
                    $("#select_class_room_id").html(data);
                },
                error: function () {
                    $.growl.error({message: "An error has occured"});
                }
            });
        }

        function save() {
            var course_name = $("#input_course_name").val();
            var level_id = $("#select_level_id").val();
            var class_room_id = $("#select_class_room_id").val();
            var schedule_id = $("#select_schedule_id").val();
            var user_id = $("#select_user_id").val();
            $.ajax({
                url: "<?php echo url_for("course/save"); ?>",
                type: "POST",
                dataType: "TEXT",
                data: {
                    course_name: course_name,
                    level_id: level_id,
                    class_room_id: class_room_id,
                    schedule_id: schedule_id,
                    user_id: user_id
                },
                success: function (data) {
                    course_id = data;
                    $("#course_modal").find(".modal-body").html("The Course has been created successfully!");
                    $("#course_modal").modal("show");
                },
                error: function () {
                    $.growl.error({message: "An error has occured"});
                }
            });
        }

        function isValid() {
            var form_id = "form_data";
            var validator = new FormValidator(form_id, [{
                    name: "input_course_name",
                    display: "Course Name",
                    rules: "required"
                }, {
                    name: "select_level_id",
                    display: "Level",
                    rules: "required"
                }, {
                    name: "select_site_id",
                    display: "Site",
                    rules: "required"
                }, {
                    name: "select_class_room_id",
                    display: "Class Room",
                    rules: "required"
                }, {
                    name: "select_schedule_id",
                    display: "Schedule",
                    rules: "required"
                }, {
                    name: "select_user_id",
                    display: "Coach",
                    rules: "required"
                }], function (errors, event) {
                isValidCallback(form_id, errors, event);
            });
            return validator._validateForm();
        }
    });
</script>

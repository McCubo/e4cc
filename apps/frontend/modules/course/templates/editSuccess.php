<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Edit Course</h1>
    </div>
    <!-- /.col-lg-12 -->
</div>

<ol class="breadcrumb">
    <li><a href="<?php echo url_for("course/index"); ?>">Manage Courses</a></li>
    <li class="active">Edit Course</li>
</ol>

<div>
    <!-- Nav tabs -->
    <ul class="nav nav-tabs" role="tablist">
        <li role="presentation" class="active"><a href="#course" aria-controls="course" role="tab" data-toggle="tab"><span class="fa fa-mortar-board"></span> Course Information</a></li>
        <li role="presentation"><a href="#student" aria-controls="student" role="tab" data-toggle="tab"><span class="fa fa-user"></span> Add Student</a></li>
    </ul>

    <!-- Tab panes -->
    <div class="tab-content">
        <div role="tabpanel" class="tab-pane active" id="course">
            <div class="row">&nbsp;</div>
            <div class="col-sm-12 col-xs-12">
                <form class="form" id="form_data">                
                    <div class="row">
                        <div class="form-group col-sm-6 col-xs-12">
                            <label for="input_course_name" class="control-label">Course Name</label>
                            <div>
                                <input type="text" class="form-control" name="input_course_name"  id="input_course_name" placeholder="Course Name" value="<?php echo $course->getCourseName(); ?>">
                            </div>
                        </div>
                        <div class="form-group col-sm-6 col-xs-12">
                            <label for="select_level_id" class="control-label">Level</label>
                            <div>
                                <select class="form-control" name="select_level_id" id="select_level_id">
                                    <option value="">Select one option</option>
                                    <?php
                                    foreach ($levelArray as $record) {
                                        $level = new Level();
                                        $level = (object) $record;

                                        $selected = $course->getLevelId() == $level->getId() ? "selected='selected'" : "";

                                        echo "<option value='{$level->getId()}' {$selected}>{$level->getLevelName()}</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-sm-6 col-xs-12">
                            <label for="select_site_id" class="control-label">Site</label>
                            <div>
                                <select class="form-control" name="select_site_id" id="select_site_id">
                                    <option value="">Select one option</option>
                                    <?php
                                    foreach ($siteArray as $record) {
                                        $site = new Site();
                                        $site = (object) $record;

                                        $selected = $course->getClassRoom()->getSiteId() == $site->getId() ? "selected='selected'" : "";

                                        echo "<option value='{$site->getId()}' {$selected}>{$site->getSiteName()}</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group col-sm-6 col-xs-12">
                            <label for="select_class_room_id" class="control-label">Class Room</label>
                            <div>
                                <select class="form-control" name="select_class_room_id" id="select_class_room_id">
                                    <option value="">Select one option</option>
                                    <?php
                                    foreach ($classRoomArray as $record) {
                                        $classRoom = new ClassRoom();
                                        $classRoom = (object) $record;

                                        $selected = $course->getClassRoomId() == $classRoom->getId() ? "selected='selected'" : "";

                                        echo "<option value='{$classRoom->getId()}' {$selected}>{$classRoom->getClassRoomName()}</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-sm-6 col-xs-12">
                            <label for="select_schedule_id" class="control-label">Schedule</label>
                            <div>
                                <select class="form-control" name="select_schedule_id" id="select_schedule_id">
                                    <option value="">Select one option</option>
                                    <?php
                                    foreach ($scheduleArray as $record) {
                                        $schedule = new Schedule();
                                        $schedule = (object) $record;

                                        $selected = $course->getScheduleId() == $schedule->getId() ? "selected='selected'" : "";

                                        echo "<option value='{$schedule->getId()}' {$selected}>{$schedule->getScheduleName()}</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group col-sm-6 col-xs-12">
                            <label for="select_user_id" class="control-label">Coach</label>
                            <div>
                                <select class="form-control" name="select_user_id" id="select_user_id">
                                    <option value="">Select one option</option>
                                    <?php
                                    foreach ($userArray as $record) {
                                        $user = new User();
                                        $user = (object) $record;

                                        $person = new Person();
                                        $person = (object) $user->getPerson();

                                        $selected = $course->getUserId() == $user->getId() ? "selected='selected'" : "";

                                        echo "<option value='{$user->getId()}' {$selected}>{$person->getFullName()}</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-sm-6 col-xs-12">
                            <label for="radio_is_active" class="control-label">Status</label>
                            <label class="radio-inline">
                                <input type="radio" name="radio_is_active" id="radio_is_active_active" value="1" <?php echo $course->getIsActive() ? "checked='checked'" : "" ?>> Active
                            </label>
                            <label class="radio-inline">
                                <input type="radio" name="radio_is_active" id="radio_is_active_inactive" value="0" <?php echo $course->getIsActive() ? "" : "checked='checked'" ?>> Inactive
                            </label>
                        </div>
                        <div class="form-group col-sm-6 col-xs-12">
                            <button type="button" class="btn btn-primary" id="btn_save"><span class="fa fa-save"></span> Save Information</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="row">&nbsp;</div>
        </div>
        <div role="tabpanel" class="tab-pane" id="student">
            <div class="row">&nbsp;</div>
            <form class="form" id="form_evaluation_data">
                <!-- left -->
                <div class="col-sm-5 col-xs-12">
                    <div class="form-group">
                        <label for="input_student" class="control-label">Student's Name or DUI</label>
                        <div class="control_group">
                            <div class="input-group">
                                <input type="text" class="form-control" name="input_student"  id="input_student" data-key="" placeholder="Type the student's name or DUI to search">
                                <span class="input-group-addon"><span class="glyphicon glyphicon-search"></span></span>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /left -->
                <!-- right -->
                <div class="col-sm-7 col-xs-12">
                    <div class="row">
                        <div class="form-group col-sm-12 col-xs-12">
                            <label for="input_course" class="control-label">Actual Course</label>
                            <div class="control_group">
                                <input type="text" class="form-control" name="input_course"  id="input_course" readonly="readonly">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-sm-6 col-xs-12">
                            <label for="input_firstname" class="control-label">Firstname</label>
                            <div class="control_group">
                                <input type="text" class="form-control" name="input_firstname"  id="input_firstname" readonly="readonly">
                            </div>
                        </div>
                        <div class="form-group col-sm-6 col-xs-12">
                            <label for="input_lastname" class="control-label">Lastname</label>
                            <div class="control_group">
                                <input type="text" class="form-control" name="input_lastname"  id="input_lastname" readonly="readonly">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-sm-6 col-xs-12">
                            <label for="input_dui" class="control-label">Dui</label>
                            <div class="control_group">
                                <input type="text" class="form-control" name="input_dui"  id="input_dui" readonly="readonly">
                            </div>
                        </div>
                        <div class="form-group col-sm-6 col-xs-12">
                            <label for="input_email" class="control-label">Email</label>
                            <div class="control_group">
                                <input type="text" class="form-control" name="input_email"  id="input_email" readonly="readonly">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-sm-12 col-xs-12">
                            <button type="button" class="btn btn-primary" id="btn_ebroll"><span class="fa fa-group"></span> Enroll Student</button>
                        </div>
                    </div>
                </div>
                <!-- /right -->
            </form>
            <div class="row">&nbsp;</div>
        </div>
    </div>
</div>

<div class="well">
    <form class="form-inline">
        <div class="form-group">
            <div class="checkbox"><label><input type="checkbox" id="checkbox_checkall">Check All / Uncheck All</label></div>
        </div>
        &nbsp;
        <div class="form-group">
            <div class="control_group" id="select_action_control_group">
                <select class="form-control" name="select_action" id="select_action">
                    <option value="0">Select one action</option>
                    <option value="1">Move</option>
                    <option value="2">Delete</option>
                </select>
            </div>
        </div>
        &nbsp;
        <div class="form-group">
            <button type="button" class="btn btn-default" id="btn_execute"><span class="fa fa-check-square-o"></span> Execute Action</button>
        </div>
    </form>
</div>

<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12" id="div_list">
            <div id="datatables_export_buttons" class="datatables_export_buttons"></div>
            <table class="table table-bordered table-hover table-striped" id="table_list">
                <thead>
                    <tr>
                        <th>N°</th>
                        <th>FIRST NAME</th>
                        <th>LAST NAME</th>
                        <th>LAST EVALUATION DATE</th>
                        <th>LAST EVALUATION SCORE</th>
                        <th>TOTAL EVALUATIONS</th>
                        <th>AVERAGE SCORE</th>
                        <th>SELECT</th>
                        <th>ACTION</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i = 0;
                    foreach ($list as $record) {
                        ++$i;

                        echo "<tr>";
                        echo "<td>{$i}</td>";
                        echo "<td>{$record["first_name"]}</td>";
                        echo "<td>{$record["last_name"]}</td>";
                        echo "<td>{$record["last_evaluation_date"]}</td>";
                        echo "<td>" . OutputFormat::formatScore($record["last_evaluation_score"]) . "</td>";
                        echo "<td>{$record["total_evaluations"]}</td>";
                        echo "<td>" . OutputFormat::formatScore($record["average_score"]) . "</td>";
                        echo "<td><div class='checkbox'><label><input type='checkbox' class='checkbox_student' value='{$record["student_id"]}'>select</label></div></td>";
                        echo "<td>";
                        echo "<div><a href='javascript:void(0)' onclick='evaluateAction({$record["student_id"]})'><span class='fa fa-file-text-o'></span> Evaluate</a></div>";
                        echo "<div><a href='javascript:void(0)' onclick='viewAction({$record["student_id"]})'><span class='fa fa-list'></span> View</a></div>";
                        echo "<div><a href='javascript:void(0)' onclick='moveAction({$record["student_id"]})'><span class='fa fa-exchange'></span> Move</a></div>";
                        echo "<div><a href='javascript:void(0)' onclick='deleteAction({$record["student_id"]})'><span class='fa fa-trash'></span> Delete</a></div>";
                        echo "</td>";
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    var course_id = <?php echo $course->getId(); ?>;
    var student_id;
    var student_course_id;

    $(document).ready(function () {
        /*listeners*/
        $("#table_list").DataTable({
            buttons: [
                'copy', 'excel', 'pdf'
            ]
        }).buttons().container().appendTo($('#datatables_export_buttons'));

        $("#btn_execute").click(function () {
            var selectedAction = $("#select_action").val();
            var checkedArray = $("input:checkbox:checked.checkbox_student").map(function () {
                return this.value;
            }).get();

            if (0 == selectedAction) {
                if (!$("#select_action_control_group").hasClass("has-error")) {
                    $("#select_action_control_group").addClass("has-error");
                }
            } else {
                if ($("#select_action_control_group").hasClass("has-error")) {
                    $("#select_action_control_group").removeClass("has-error");
                }
            }

            if (0 == checkedArray.length) {
                $("#course_modal").find(".modal-body").html("You must select at least one Student");
                $("#course_modal").modal("show");
            }

            if ((0 != selectedAction) && (0 != checkedArray.length)) {
                switch (selectedAction) {
                    case '1': //move
                        moveAll(checkedArray);
                        break;
                    case '2': //delete
                        deleteAll(checkedArray);
                        break;
                }
            }
        });

        $("#checkbox_checkall").click(function () {
            if ($(this).prop("checked")) {
                $(".checkbox_student").prop("checked", true);
            } else {
                $(".checkbox_student").prop("checked", false);
            }
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
            //do nothing
        });

        $("#form_evaluation_data").submit(function (e) {
            e.preventDefault();
        });

        $("#btn_ebroll").click(function () {
            confirmEnroll();
        });

        $("#btn_confirm_modal_cancel").click(function () {
            $("#confirm_course_modal").modal("hide");
        });

        $("#btn_view_evaluations_modal_accept").click(function () {
            $("#view_evaluations_modal").modal("hide");
        });

        //autocomplete
        $("#input_student").autoComplete({
            source: function (term, response) {
                $.ajax({
                    url: "<?php echo url_for("course/getStudent"); ?>",
                    type: "POST",
                    dataType: "JSON",
                    data: {
                        term: term
                    },
                    success: function (data) {
                        response(data);
                    },
                    error: function () {
                        $.growl.error({message: "An error has occured"});
                    }
                });
            },
            renderItem: function (item, search) {
                // escape special characters
                search = search.replace(/[-\/\\^$*+?.()|[\]{}]/g, '\\$&');
                var re = new RegExp("(" + search.split(' ').join('|') + ")", "gi");
                var div = '<div class="autocomplete-suggestion"';
                div += ' data-key="' + item.key + '"';
                div += ' data-val="' + item.val + '"';
                div += ' data-firstname="' + item.firstname + '"';
                div += ' data-lastname="' + item.lastname + '"';
                div += ' data-dui="' + item.dui + '"';
                div += ' data-email="' + item.email + '"';
                div += ' data-student_id="' + item.student_id + '"';
                div += ' data-course_id="' + item.course_id + '"';
                div += ' data-course_name="' + item.course_name + '">';
                div += (item.val + ' [' + item.dui + ']').replace(re, "<b>$1</b>");
                div += '</div>';
                return div;
            },
            onSelect: function (e, term, item) {
                $("#input_student").attr("data-key", item.attr("data-key"));
                $("#input_course").val(item.attr("data-course_name"));
                $("#input_firstname").val(item.attr("data-firstname"));
                $("#input_lastname").val(item.attr("data-lastname"));
                $("#input_dui").val(item.attr("data-dui"));
                $("#input_email").val(item.attr("data-email"));
                student_id = item.attr("data-student_id");
                student_course_id = item.attr("data-course_id");
            }
        });

        /*functions*/
        function confirmEnroll() {
            if (student_course_id == course_id) {
                $("#course_modal").find(".modal-body").html("The Student is already enrolled in this Course");
                $("#course_modal").modal("show");
            } else if (student_course_id.length > 0 && /^[1-9]*$/.test(student_course_id)) {
                //corfirm dialog actions
                $("#btn_confirm_modal_accept").click(function () {
                    $("#confirm_course_modal").modal("hide");
                    enroll(true);
                });
                $("#confirm_course_modal").find(".modal-body").html("The Student is already enrolled in another Course. Do you want to change anyway?");
                $("#confirm_course_modal").modal("show");
            } else {
                enroll(false);
            }
        }

        function enroll(delete_inscription) {
            $.ajax({
                url: "<?php echo url_for("course/enroll"); ?>",
                type: "POST",
                dataType: "HTML",
                data: {
                    course_id: course_id,
                    student_id: student_id,
                    delete_inscription: delete_inscription
                },
                success: function () {
                    $("#input_student").attr("data-key", null);
                    $("#input_student").val(null);
                    $("#input_course").val(null);
                    $("#input_firstname").val(null);
                    $("#input_lastname").val(null);
                    $("#input_dui").val(null);
                    $("#input_email").val(null);
                    student_id = null;
                    student_course_id = null;
                    getListInscription();
                },
                error: function () {
                    $.growl.error({message: "An error has occured"});
                }
            });
        }

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
            var is_active = $("input[name=radio_is_active]:checked").val();
            $.ajax({
                url: "<?php echo url_for("course/update"); ?>",
                type: "POST",
                data: {
                    id: course_id,
                    course_name: course_name,
                    level_id: level_id,
                    class_room_id: class_room_id,
                    schedule_id: schedule_id,
                    user_id: user_id,
                    is_active: is_active
                },
                success: function () {
                    $("#course_modal").find(".modal-body").html("The Course has been updated successfully!");
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
                    rules: "required"
                }, {
                    name: "select_level_id",
                    rules: "required"
                }, {
                    name: "select_site_id",
                    rules: "required"
                }, {
                    name: "select_class_room_id",
                    rules: "required"
                }, {
                    name: "select_schedule_id",
                    rules: "required"
                }, {
                    name: "select_user_id",
                    rules: "required"
                }], function (errors, event) {
                isValidCallback(form_id, errors, event);
            });
            return validator._validateForm();
        }
    });

    /* external functions */

    function getListInscription() {
        $.ajax({
            url: "<?php echo url_for("course/getListInscription"); ?>",
            type: "POST",
            dataType: "HTML",
            data: {
                id: course_id
            },
            success: function (data) {
                $("#div_list").html(data);
            },
            error: function () {
                $.growl.error({message: "An error has occured"});
            }
        });
    }

    /* action functions */

    function evaluateAction(student_id) {
        $.ajax({
            url: "<?php echo url_for("evaluation/index"); ?>",
            type: "POST",
            dataType: "HTML",
            data: {
                course_id: course_id,
                student_id: student_id
            },
            success: function (data) {
                $("#div_container").html(data);
                $("#evaluation_modal").on("hidden.bs.modal", function () {
                    loadContent("div_container", "<?php echo url_for("course/edit?id=") . $course->getId() ?>");
                });
                $("#btn_evaluation_cancel").click(function () {
                    loadContent("div_container", "<?php echo url_for("course/edit?id=") . $course->getId() ?>");
                });
            },
            error: function () {
                $.growl.error({message: "An error has occured"});
            }
        });
    }

    function viewAction(student_id) {
        $.ajax({
            url: "<?php echo url_for("course/viewAction"); ?>",
            type: "POST",
            dataType: "HTML",
            data: {
                course_id: course_id,
                student_id: student_id
            },
            success: function (data) {
                $("#view_evaluations_modal").find(".modal-body").html(data);
                $("#view_evaluations_modal").modal("show");
            },
            error: function () {
                $.growl.error({message: "An error has occured"});
            }
        });
    }

    function deleteAction(student_id) {
        //corfirm dialog actions
        $("#btn_confirm_modal_accept").click(function () {
            $("#confirm_course_modal").modal("hide");
            $.ajax({
                url: "<?php echo url_for("course/deleteAction"); ?>",
                type: "POST",
                dataType: "HTML",
                data: {
                    student_id: student_id
                },
                success: function () {
                    getListInscription();
                },
                error: function () {
                    $.growl.error({message: "An error has occured"});
                }
            });
        });
        $("#confirm_course_modal").find(".modal-body").html("The Student will removed from the actual Course. Do you want to continue anyway?");
        $("#confirm_course_modal").modal("show");
    }

    function moveAction(student_id) {
        var student_id_array = [student_id.toString()];
        moveAll(student_id_array);
    }

    function deleteAll(student_id_array) {
        //corfirm dialog actions
        $("#btn_confirm_modal_accept").click(function () {
            $("#confirm_course_modal").modal("hide");
            $.ajax({
                url: "<?php echo url_for("course/deleteAll"); ?>",
                type: "POST",
                dataType: "HTML",
                data: {
                    student_id: student_id_array
                },
                success: function () {
                    getListInscription();
                },
                error: function () {
                    $.growl.error({message: "An error has occured"});
                }
            });
        });
        $("#confirm_course_modal").find(".modal-body").html("The Students will removed from the actual Course. Do you want to continue anyway?");
        $("#confirm_course_modal").modal("show");
    }

    function moveAll(student_id_array) {
        $("#select_move_site_id").val("0");
        $("#select_move_level_id").html('<option value="0">Select one option</option>');
        $("#table_move_course").find("tbody").html('<tr><td colspan="6"><div class="text-center">Filter the options to show data</div></td></tr>');
        $("#btn_move_students_modal_cancel").click(function () {
            $("#move_students_modal").modal("hide");
        });
        $("#btn_move_students_modal_accept").click(function () {
            var move_course_id = $("input[name=radio_course]:checked").val();
            $("#move_students_modal").modal("hide");
            $.ajax({
                url: "<?php echo url_for("course/moveAll"); ?>",
                type: "POST",
                dataType: "HTML",
                data: {
                    course_id: move_course_id,
                    student_id: student_id_array
                },
                success: function () {
                    getListInscription();
                },
                error: function () {
                    $.growl.error({message: "An error has occured"});
                }
            });
        });
        $("#select_move_site_id").change(function () {
            var move_site_id = $("#select_move_site_id").val();
            $("#table_move_course").find("tbody").html('<tr><td colspan="6"><div class="text-center">Filter the options to show data</div></td></tr>');
            if (0 > move_site_id) {
                $("#select_move_level_id").html('<option value="0">Select one option</option>');
            } else {
                $.ajax({
                    url: "<?php echo url_for("course/getMoveLevel"); ?>",
                    type: "POST",
                    dataType: "HTML",
                    data: {
                        course_id: course_id,
                        site_id: move_site_id
                    },
                    success: function (data) {
                        $("#select_move_level_id").html(data);
                    },
                    error: function () {
                        $.growl.error({message: "An error has occured"});
                    }
                });
            }
        });
        $("#select_move_level_id").change(function () {
            var move_site_id = $("#select_move_site_id").val();
            var move_level_id = $("#select_move_level_id").val();
            var tableBody = $("#table_move_course").find("tbody");
            if (0 > move_level_id) {
                tableBody.html('<tr><td colspan="5"><div class="text-center">Filter the options to show data</div></td></tr>');
            } else {
                $.ajax({
                    url: "<?php echo url_for("course/getMoveCourse"); ?>",
                    type: "POST",
                    dataType: "HTML",
                    data: {
                        course_id: course_id,
                        site_id: move_site_id,
                        level_id: move_level_id
                    },
                    success: function (data) {
                        tableBody.html(data);
                    },
                    error: function () {
                        $.growl.error({message: "An error has occured"});
                    }
                });
            }
        });
        $("#move_students_modal").modal("show");
    }
</script>

<!-- View Evaluations Modal -->
<div class="modal fade" tabindex="-1" id="view_evaluations_modal" role="dialog" >
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><i class="fa fa-list"></i> Evaluations</h4>
            </div>
            <div class="modal-body">

            </div>
            <div class="modal-footer">
                <button id="btn_view_evaluations_modal_accept" type="button" class="btn btn-primary"><i class="fa fa-check"></i> Accept</button>                    
            </div>
        </div>
    </div>
</div>

<!-- Move Students Modal -->
<div class="modal fade" tabindex="-1" id="move_students_modal" role="dialog" >
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><i class="fa fa-exchange"></i> Course Movement</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-6 col-xs-12">
                        <label for="select_move_site_id" class="control-label">Site</label>
                        <div class="control_group">
                            <select class="form-control" name="select_move_site_id" id="select_move_site_id">
                                <option value="0">Select one option</option>
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
                    <div class="col-sm-6 col-xs-12">
                        <label for="select_move_level_id" class="control-label">Level</label>
                        <div class="control_group">
                            <select class="form-control" name="select_move_level_id" id="select_move_level_id">
                                <option value="0">Select one option</option>
                            </select>
                        </div>
                    </div>
                </div>
                <br/>
                <div class="row">
                    <div class="col-sm-12 col-xs-12">
                        <table id="table_move_course" class="table table-striped table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>COURSE</th>
                                    <th>SCHEDULE</th>
                                    <th>COACH</th>
                                    <th>STUDENTS</th>
                                    <th>ACTION</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr><td colspan="6"><div class="text-center">Filter the options to show data</div></td></tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button id="btn_move_students_modal_cancel" type="button" class="btn btn-danger"><i class="fa fa-ban"></i> Cancel</button> 
                <button id="btn_move_students_modal_accept" type="button" class="btn btn-primary"><i class="fa fa-check"></i> Accept</button>                    
            </div>
        </div>
    </div>
</div>
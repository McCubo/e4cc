<div id="div_container">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Manage Courses</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>

    <ol class="breadcrumb">
        <li class="active">Manage Courses</li>
    </ol>

    <div class="well">
        <div class="row">
            <div class="col-xs-6">
                <strong>Show records: </strong>
                <label class="radio-inline">
                    <input type="radio" name="radio_showlist" id="radio_showlist_active" value="1" checked> Active <samp class="badge badge-success"><?php echo $list->count(); ?></samp>
                </label>
                <label class="radio-inline">
                    <input type="radio" name="radio_showlist" id="radio_showlist_inactive" value="0"> Inactive <samp class="badge badge-danger"><?php echo $listInactive->count(); ?></samp>
                </label>
            </div>
            <div class="col-xs-6 text-right">
                <button type="button" class="btn btn-default" id="btn_new"><span class="glyphicon glyphicon-plus"></span> New Course</button>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12 col-sm-12">
                <form class="form-inline">

                    <div class="form-group">
                        <label>Site</label>
                        <select class="form-control" name="select_site" id="select_site">
                            <option value="0">All</option>
                            <?php
                            foreach ($siteArray as $record) {
                                echo "<option value='{$record["id"]}'>{$record["site_name"]}</option>";
                            }
                            ?>
                        </select>
                    </div>

                    &nbsp;

                    <div class="form-group">
                        <label>Level</label>
                        <select class="form-control" name="select_level" id="select_level">
                            <option value="0">All</option>
                            <?php
                            foreach ($levelArray as $record) {
                                echo "<option value='{$record["id"]}'>{$record["level_name"]}</option>";
                            }
                            ?>
                        </select>
                    </div>

                    &nbsp;

                    <div class="form-group">
                        <label>Coach</label>
                        <select class="form-control" name="select_coach" id="select_coach">
                            <option value="0">All</option>
                            <?php
                            foreach ($userArray as $record) {
                                echo "<option value='{$record["id"]}'>{$record["first_name"]} {$record["last_name"]}</option>";
                            }
                            ?>
                        </select>
                    </div>

                    &nbsp;

                    <div class="form-group">
                        <button type="button" class="btn btn-primary" id="btn_filter"><span class="glyphicon glyphicon-filter"></span> Filter</button> 
                        <button type="button" class="btn btn-default" id="btn_clear"><span class="fa fa-undo"></span> Clear Filter</button>
                    </div>

                </form>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12" id="div_list">
                <table class="table table-bordered table-hover table-striped" id="table_list">
                    <thead>
                        <tr>
                            <th>N°</th>
                            <th>SITE</th>
                            <th>LEVEL</th>
                            <th>COURSE NAME</th>
                            <th>SCHEDULE</th>
                            <th>COACH</th>
                            <th>STUDENTS</th>
                            <th>ACTION</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i = 0;
                        foreach ($list as $record) {
                            $course = new Course();
                            $course = (object) $record;

                            $classRoom = new ClassRoom();
                            $classRoom = (object) $course->getClassRoom();

                            $schedule = new Schedule();
                            $schedule = (object) $course->getSchedule();

                            $site = new Site();
                            $site = (object) $classRoom->getSite();

                            $level = new Level();
                            $level = (object) $course->getLevel();

                            $user = new User();
                            $user = (object) $course->getUser();

                            $person = new Person();
                            $person = (object) $user->getPerson();

                            ++$i;

                            echo "<tr>";
                            echo "<td>{$i}</td>";
                            echo "<td>{$site->getSiteName()}</td>";
                            echo "<td>{$level->getLevelName()}</td>";
                            echo "<td>{$course->getCourseName()}</td>";
                            echo "<td>{$schedule->getScheduleName()}</td>";
                            echo "<td>{$person->getFullName()}</td>";
                            echo "<td>{$course->getTotalInscription()}</td>";
                            echo "<td><a href='javascript:void(0)' onclick='loadContent(\"div_container\", \"" . url_for("course/edit?id=") . $course->getId() . "\")'><span class='glyphicon glyphicon-edit'></span> Edit</a></td>";
                            echo "</tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        var is_active = 1;

        $(document).ready(function () {
            //listeners
            $("#table_list").DataTable();

            $("input:radio[name=radio_showlist]").click(function () {
                if (is_active != $(this).val()) {
                    is_active = $(this).val();
                    $("#select_site").val(0);
                    $("#select_level").val(0);
                    $("#select_coach").val(0);
                    getLevel(0);
                    getCoach(0, 0);
                    getList(0, 0, 0);
                }
            });

            $("#btn_new").click(function () {
                loadContent("div_container", "<?php echo url_for("course/new"); ?>");
            });

            $("#select_site").change(function () {
                var site_id = $(this).val();
                getLevel(site_id);
                getCoach(site_id, 0);
            });

            $("#select_level").change(function () {
                var site_id = $("#select_site").val();
                var level_id = $("#select_level").val();
                getCoach(site_id, level_id);
            });

            $("#btn_filter").click(function () {
                var site_id = $("#select_site").val();
                var level_id = $("#select_level").val();
                var user_id = $("#select_coach").val();
                getList(site_id, level_id, user_id);
            });

            $("#btn_clear").click(function () {
                $("#select_site").val(0);
                $("#select_level").val(0);
                $("#select_coach").val(0);
                getLevel(0);
                getCoach(0, 0);
                getList(0, 0, 0);
            });

            $("#btn_modal_accept").click(function () {
                $("#course_modal").modal("hide");
            });
        });

        //functions
        function getLevel(site_id) {
            $.ajax({
                url: "<?php echo url_for("course/getLevel"); ?>",
                type: "POST",
                dataType: "HTML",
                data: {
                    site_id: site_id
                },
                success: function (data) {
                    $("#select_level").html(data);
                },
                error: function () {
                    $.growl.error({message: "An error has occured"});
                }
            });
        }

        function getCoach(site_id, level_id) {
            $.ajax({
                url: "<?php echo url_for("course/getCoach"); ?>",
                type: "POST",
                dataType: "HTML",
                data: {
                    site_id: site_id,
                    level_id: level_id
                },
                success: function (data) {
                    $("#select_coach").html(data);
                },
                error: function () {
                    $.growl.error({message: "An error has occured"});
                }
            });
        }

        function getList(site_id, level_id, user_id) {
            $.ajax({
                url: "<?php echo url_for("course/getList"); ?>",
                type: "POST",
                dataType: "HTML",
                data: {
                    site_id: site_id,
                    level_id: level_id,
                    user_id: user_id,
                    is_active: is_active
                },
                success: function (data) {
                    $("#div_list").html(data);
                },
                error: function () {
                    $.growl.error({message: "An error has occured"});
                }
            });
        }

    </script>
</div>

<!-- Modal -->
<div class="modal fade" tabindex="-1" id="course_modal" role="dialog" >
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><i class="fa fa-info-circle"></i> Information</h4>
            </div>
            <div class="modal-body">

            </div>
            <div class="modal-footer">
                <button id="btn_modal_accept" type="button" class="btn btn-primary"><i class="fa fa-check"></i> Accept</button>                    
            </div>
        </div>
    </div>
</div>

<!-- Confirm Modal -->
<div class="modal fade" tabindex="-1" id="confirm_course_modal" role="dialog" >
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><i class="fa fa-question-circle"></i> Confirmation</h4>
            </div>
            <div class="modal-body">

            </div>
            <div class="modal-footer">
                <button id="btn_confirm_modal_cancel" type="button" class="btn btn-danger"><i class="fa fa-ban"></i> Cancel</button> 
                <button id="btn_confirm_modal_accept" type="button" class="btn btn-primary"><i class="fa fa-check"></i> Accept</button>
            </div>
        </div>
    </div>
</div>
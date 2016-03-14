<div id="div_container">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Students Lookup</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>

    <ol class="breadcrumb">
        <li class="active">Students Lookup</li>
    </ol>

    <div class="well">
        <div class="row">
            <div class="col-sm-12 col-xs-12">
                <strong>Show records: </strong>
                <label class="radio-inline">
                    <input type="radio" name="radio_showlist" id="radio_showlist_active" value="1" checked> Active <samp class="badge badge-success"><?php echo $list->rowCount(); ?></samp>
                </label>
                <label class="radio-inline">
                    <input type="radio" name="radio_showlist" id="radio_showlist_inactive" value="0"> Inactive <samp class="badge badge-danger"><?php echo $listInactive->count(); ?></samp>
                </label>
            </div>
        </div><!-- /row -->
        <div class="row">&nbsp;</div>
        <div class="row">
            <div class="col-xs-12 col-sm-12">
                <form class="form-inline">

                    <div class="form-group">
                        <label>Site</label>
                        <select class="form-control" name="select_site" id="select_site">
                            <option value="0">All</option>
                            <?php
                            foreach ($siteList as $record) {
                                $value = is_null($record["site_id"]) ? "NULL" : $record["site_id"];
                                $text = is_null($record["site_name"]) ? "" : $record["site_name"];
                                echo "<option value='{$value}'>{$text}</option>";
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
                            foreach ($levelList as $record) {
                                $value = is_null($record["level_id"]) ? "NULL" : $record["level_id"];
                                $text = is_null($record["level_name"]) ? "" : $record["level_name"];
                                echo "<option value='{$value}'>{$text}</option>";
                            }
                            ?>
                        </select>
                    </div>

                    &nbsp;

                    <div class="form-group">
                        <label>Course</label>
                        <select class="form-control" name="select_course" id="select_course">
                            <option value="0">All</option>
                            <?php
                            foreach ($courseList as $record) {
                                $value = is_null($record["course_id"]) ? "NULL" : $record["course_id"];
                                $text = is_null($record["course_name"]) ? "" : $record["course_name"];
                                echo "<option value='{$value}'>{$text}</option>";
                            }
                            ?>
                        </select>
                    </div>

                    &nbsp;

                    <div class="form-group">
                        <label>Schedule</label>
                        <select class="form-control" name="select_schedule" id="select_schedule">
                            <option value="0">All</option>
                            <?php
                            foreach ($scheduleList as $record) {
                                $value = is_null($record["schedule_id"]) ? "NULL" : $record["schedule_id"];
                                $text = is_null($record["schedule"]) ? "" : $record["schedule"];
                                echo "<option value='{$value}'>{$text}</option>";
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
                            foreach ($coachList as $record) {
                                $value = is_null($record["coach_id"]) ? "NULL" : $record["coach_id"];
                                $text = is_null($record["coach"]) ? "" : $record["coach"];
                                echo "<option value='{$value}'>{$text}</option>";
                            }
                            ?>
                        </select>
                    </div>

                    &nbsp;

                    <div class="form-group">
                        <label>Evaluator</label>
                        <select class="form-control" name="select_evaluator" id="select_evaluator">
                            <option value="0">All</option>
                            <?php
                            foreach ($evaluatorList as $record) {
                                $value = is_null($record["evaluator_id"]) ? "NULL" : $record["evaluator_id"];
                                $text = is_null($record["evaluator"]) ? "" : $record["evaluator"];
                                echo "<option value='{$value}'>{$text}</option>";
                            }
                            ?>
                        </select>
                    </div>

                    &nbsp;

                    <div class="form-group">
                        <label>Score</label>
                        <select class="form-control" name="select_score" id="select_score">
                            <option value="0">All</option>
                            <?php
                            foreach ($scoreList as $record) {
                                $value = is_null($record["score"]) ? "NULL" : $record["score"];
                                $text = is_null($record["score"]) ? "" : $record["score"];
                                echo "<option value='{$value}'>{$text}</option>";
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
        </div><!-- /row -->
    </div>

    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12" id="div_list">
                <div id="datatables_export_buttons" class="datatables_export_buttons"></div>
                <table class="table table-bordered table-hover table-striped" id="table_list">
                    <thead>
                        <tr>
                            <th>DUI</th>
                            <th>F NAME</th>
                            <th>L NAME</th>
                            <th>USER</th>
                            <th>SITE</th>
                            <th>LEVEL</th>
                            <th>COURSE</th>
                            <th>SCHEDULE</th>
                            <th>COACH</th>
                            <th>EVALUATOR</th>
                            <th>SCORE</th>
                            <th>ACTION</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($list as $record) {
                            echo "<tr>";
                            echo "<td>{$record["dui"]}</td>";
                            echo "<td>{$record["first_name"]}</td>";
                            echo "<td>{$record["last_name"]}</td>";
                            echo "<td>{$record["username"]}</td>";
                            echo "<td>{$record["site_name"]}</td>";
                            echo "<td>{$record["level_name"]}</td>";
                            echo "<td>{$record["course_name"]}</td>";
                            echo "<td>{$record["schedule"]}</td>";
                            echo "<td>{$record["coach"]}</td>";
                            echo "<td>{$record["evaluator"]}</td>";
                            echo "<td>{$record["score"]}</td>";
                            echo "<td>";
                            echo "<div><a href='javascript:void(0)' onclick='evaluateAction({$record["course_id"]},{$record["id"]})'><span class='fa fa-file-text-o'></span> Evaluate</a></div>";
                            echo "<div><a href='javascript:void(0)' onclick='loadContent(\"div_container\", \"" . url_for("lookup/edit?id=") . $record["id"] . "\")'><span class='glyphicon glyphicon-edit'></span> Edit</a></div>";
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
        var is_active = 1;

        $(document).ready(function () {
            //listeners
            $("#table_list").DataTable({
                pageLength: 50,
                buttons: [
                    'copy', 'excel', 'pdf'
                ]
            }).buttons().container().appendTo($('#datatables_export_buttons'));

            $("input:radio[name=radio_showlist]").click(function () {
                if (is_active != $(this).val()) {
                    is_active = $(this).val();
                    getList();
                }
            });

            $("#btn_filter").click(function () {
                getList();
            });

            $("#btn_clear").click(function () {
                $("#select_site").val(0);
                $("#select_level").val(0);
                $("#select_course").val(0);
                $("#select_schedule").val(0);
                $("#select_coach").val(0);
                $("#select_evaluator").val(0);
                $("#select_score").val(0);
                getList();
            });

        });

        //functions
        function getList() {
            var site_id = $("#select_site").val();
            var level_id = $("#select_level").val();
            var course_id = $("#select_course").val();
            var schedule_id = $("#select_schedule").val();
            var coach_id = $("#select_coach").val();
            var evaluator_id = $("#select_evaluator").val();
            var score = $("#select_score").val();
            $.ajax({
                url: "<?php echo url_for("lookup/getList"); ?>",
                type: "POST",
                dataType: "HTML",
                data: {
                    site_id: site_id,
                    level_id: level_id,
                    course_id: course_id,
                    schedule_id: schedule_id,
                    coach_id: coach_id,
                    evaluator_id: evaluator_id,
                    score: score,
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

        function evaluateAction(course_id, student_id) {
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
                        $(location).attr("href", "<?php echo url_for("lookup/index"); ?>");
                    });
                    $("#btn_evaluation_cancel").click(function () {
                        $(location).attr("href", "<?php echo url_for("lookup/index"); ?>");
                    });
                },
                error: function () {
                    $.growl.error({message: "An error has occured"});
                }
            });
        }
    </script>

</div>

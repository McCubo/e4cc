<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">View Course</h1>
    </div>
    <!-- /.col-lg-12 -->
</div>

<ol class="breadcrumb">
    <li><a href="<?php echo url_for("course_coach/index"); ?>">Courses</a></li>
    <li class="active">View Course</li>
</ol>

<div class="panel panel-default">
    <div class="panel-heading"><span class="fa fa-mortar-board"></span> Course Information</div>
    <div class="panel-body">
        <div class="row">
            <div class="col-sm-12 col-xs-12"><h4><strong>Coach:</strong> <?php echo $course->getUser()->getPerson()->getFullName(); ?></h4></div>
        </div>
        <div class="row">
            <div class="col-sm-6 col-xs-6"><strong>Course Name:</strong><br/><?php echo $course->getCourseName(); ?></div>
            <div class="col-sm-6 col-xs-6"><strong>Schedule:</strong><br/><?php echo $course->getSchedule()->getScheduleName(); ?></div>
        </div>
        <div class="row">
            <div class="col-sm-6 col-xs-6"><strong>Site:</strong><br/><?php echo $course->getClassRoom()->getSite()->getSiteName(); ?></div>
            <div class="col-sm-6 col-xs-6"><strong>Class Room:</strong><br/><?php echo $course->getClassRoom()->getClassRoomName(); ?></div>
        </div>
        <div class="row">
            <div class="col-sm-6 col-xs-6"><strong>Level:</strong><br/><?php echo $course->getLevel()->getLevelName(); ?></div>
            <div class="col-sm-6 col-xs-6"><strong>Students:</strong><br/><?php echo $list->rowCount(); ?></div>
        </div>
    </div>
</div><!-- / .panel-default -->

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
                        echo "<td>";
                        echo "<div><a href='javascript:void(0)' onclick='evaluateAction({$record["student_id"]})'><span class='fa fa-file-text-o'></span> Evaluate</a></div>";
                        echo "<div><a href='javascript:void(0)' onclick='viewAction({$record["student_id"]})'><span class='fa fa-list'></span> View</a></div>";
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

    $(document).ready(function () {
        $("#table_list").DataTable({
            buttons: [
                'copy', 'excel', 'pdf'
            ]
        }).buttons().container().appendTo($('#datatables_export_buttons'));
    });

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
                    loadContent("div_container", "<?php echo url_for("course_coach/view?id=") . $course->getId() ?>");
                });
                $("#btn_evaluation_cancel").click(function () {
                    loadContent("div_container", "<?php echo url_for("course_coach/view?id=") . $course->getId() ?>");
                });
            },
            error: function () {
                $.growl.error({message: "An error has occured"});
            }
        });
    }

    function viewAction(student_id) {
        //set listener
        $("#btn_view_evaluations_modal_accept").click(function () {
            $("#view_evaluations_modal").modal("hide");
        });
        //ajax call
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
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Evaluation's Form</h1>
    </div>
    <!-- /.col-lg-12 -->
</div>

<div class="panel panel-default">
    <div class="panel-heading">
        <span class="glyphicon glyphicon-user"></span> Student's Information
    </div>
    <div class="panel-body">
        <div class="row">
            <div class="col-xs-12">
                <strong>Name: </strong> <?php echo $person->getFullName(); ?><br/>
                <strong>Site: </strong> <?php echo $course->getClassRoom()->getSite()->getSiteName(); ?><br/>
                <strong>Course: </strong> <?php echo $course->getCourseName(); ?><br/>
                <strong>Level: </strong> <?php echo $course->getLevel()->getLevelName(); ?><br/>
            </div>
        </div>
    </div><!-- /.panel-body -->
</div>

<div class="alert alert-warning" role="alert" id="div_alert">
    <div class="row">
        <div class="col-xs-12 col-sm-12">
            <span id="span_alert_message"><strong><span class="glyphicon glyphicon-info-sign"></span> Information!</strong> You must select at least one option per question.</span>
        </div>
    </div>
</div>

<div class="row container-fluid">
    <table class="table table-striped table-hover">
        <thead>
            <tr>
                <th></th>
                <th style="width: 75px">Low(0)</th>
                <th style="width: 175px">Needs to improve (0,5)</th>
                <th style="width: 125px">Acceptable (1)</th>
                <th style="width: 90px">Good (1,5)</th>
                <th style="width: 100px">Excellent (2)</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $tr_class = "info";
            foreach ($questionArray as $object) {
                $question = new Question();
                $question = (object) $object;

                echo "<tr>";
                echo "  <td>{$question->getQuestionName()}</td>";
                echo "  <td><div class='radio'><label><input type='radio' name='radio_question_{$question->getId()}' data-id='{$question->getId()}' data-score='0' class='radio_question'/> Low</label></div></td>";
                echo "  <td><div class='radio'><label><input type='radio' name='radio_question_{$question->getId()}' data-id='{$question->getId()}' data-score='0.5' class='radio_question'/> Needs to improve</label></div></td>";
                echo "  <td><div class='radio'><label><input type='radio' name='radio_question_{$question->getId()}' data-id='{$question->getId()}' data-score='1' class='radio_question'/> Acceptable</label></div></td>";
                echo "  <td><div class='radio'><label><input type='radio' name='radio_question_{$question->getId()}' data-id='{$question->getId()}' data-score='1.5' class='radio_question'/> Good</label></div></td>";
                echo "  <td><div class='radio'><label><input type='radio' name='radio_question_{$question->getId()}' data-id='{$question->getId()}' data-score='2' class='radio_question'/> Excellent</label></div></td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>
    <?php
    $qNum = 1;
    foreach ($questionArray as $object) {
        $question = new Question();
        $question = (object) $object;

        echo "<div class='panel panel-default'>";
        echo "<div class='panel-heading'>{$qNum}. {$question->getQuestionName()}</div>";
        echo "<div class='panel-body'>";

        echo "<div class='form-group'>";
        echo "<label>{$question->getQuestionName()} Mistakes</label>";
        echo "<p class='help-block'>";

        $checkboxes = $question->getCheckboxes();
        if ($checkboxes->count() > 0) {
            foreach ($checkboxes as $cObject) {
                $checkboxes = new Checkboxes();
                $checkboxes = (object) $cObject;

                echo "<div class='checkbox'>";
                echo "<label>";
                echo "<input type='checkbox' class='checkbox_comment' data-qid='{$checkboxes->getQuestionId()}' data-cid='{$checkboxes->getId()}'> {$checkboxes->getCheckboxName()}";
                echo "</label>";
                echo "</div>";
            }
        }
        echo "</p>";
        echo "</div>";

        echo "<div class='form-group'>";
        echo "<label>Comments about {$question->getQuestionName()}</label>";
        echo "<p class='help-block'> {$question->getDescription()}</p>";
        echo "<textarea rows='2' class='form-control' id='textarea_{$question->getId()}'></textarea>";
        echo "</div>";
        echo "</div>";
        echo "</div>";
        $qNum++;
    }
    ?>

    <div class="form-group">
        <button type="button" class="btn btn-danger" id="btn_evaluation_cancel"><span class="glyphicon glyphicon-ban-circle"></span> Cancel</button>
        <button type="button" class="btn btn-primary" id="btn_evaluation_finish"><span class="glyphicon glyphicon-ok-circle"></span> Finish the Evaluation</button>
    </div>
</div>

<div id="message_box" class="alert alert-info" style="text-align:center;position:fixed;z-index:9999;width:230px;font-weight:bolder;opacity: 0.7;padding:0!important;margin:0!important">
    <span style="font-size: 45px">Score: </span><span id="span_score" style="font-size: 50px">0</span>
</div>

<script>
    $(document).ready(function () {
        setScorePos();
        $(window).scroll(function () {
            setScorePos();
        });
        $(window).resize(function () {
            setScorePos();
        });
        //listeners
        $("#btn_confirm_modal_cancel").click(function () {
            $("#confirm_evaluation_modal").modal("hide");
        });
        $("#btn_confirm_modal_accept").click(function () {
            save();
        });
        $("#btn_modal_accept").click(function () {
            $("#evaluation_modal").modal("hide");
        });
        $("#btn_evaluation_finish").click(function () {
            if (isValid()) {
                $("#confirm_evaluation_modal").modal("show");
            }
        });
        $(".radio_question").click(function () {
            var qSel = $(".radio_question:checked").length;
            if (qSel == 5) {
                $("#div_alert").removeClass("alert-warning").addClass("alert-info");
                $("#span_alert_message").html("<strong><span class='glyphicon glyphicon-ok-sign'></span> Ready!</strong> You can now finish the evaluation");
            }
            var score = 0;
            $(".radio_question:checked").each(function () {
                score += parseFloat($(this).attr("data-score"));
                $("#span_score").html(score);
            });
        });
    });

    //functions
    function save() {
        $("#confirm_evaluation_modal").modal("hide");
        var course_id = <?php echo $course->getId(); ?>;
        var student_id = <?php echo $student->getId(); ?>;
        var addCom = new Array();
        $(".checkbox_comment:checked").each(function () {
            var qId = $(this).attr("data-qid");
            var cId = $(this).attr("data-cid");
            addCom.push([qId, cId]);
        });
        var qScore = new Array();
        $(".radio_question:checked").each(function () {
            var id = $(this).attr("data-id");
            var score = $(this).attr("data-score");
            var com = $("#textarea_" + id).val();
            qScore.push([id, score, com]);
        });
        $.ajax({
            url: "<?php echo url_for("evaluation/save"); ?>",
            type: "POST",
            dataType: "TEXT",
            data: {
                course_id: course_id,
                student_id: student_id,
                grade_array: qScore,
                additional_comments_array: addCom
            },
            success: function () {
                $("#evaluation_modal").modal("show");
            },
            error: function () {
                $.growl.error({message: "An error has occured"});
            }
        });
    }

    function isValid() {
        var isValid = true;
        var qSel = $(".radio_question:checked").length;
        if (qSel < 5) {
            isValid = false;
            $("html, body").animate({
                scrollTop: $("#div_alert").offset().top
            }, 500);
        }
        return isValid;
    }

    function setScorePos() {
        $("#message_box").css({top: $(window).height() - ($("#message_box").height() + 10), left: $(window).width() - ($("#message_box").width() + 10)});
    }
</script>

<!-- Modal -->
<div class="modal fade" tabindex="-1" id="evaluation_modal" role="dialog" >
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><i class="fa fa-info-circle"></i> Information</h4>
            </div>
            <div class="modal-body">
                The evaluation has been saved successfully!
            </div>
            <div class="modal-footer">
                <button id="btn_modal_accept" type="button" class="btn btn-primary"><i class="fa fa-check"></i> Accept</button>                    
            </div>
        </div>
    </div>
</div>

<!-- Confirm Modal -->
<div class="modal fade" tabindex="-1" id="confirm_evaluation_modal" role="dialog" >
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><i class="fa fa-question-circle"></i> Confirmation</h4>
            </div>
            <div class="modal-body">
                Do you really want to save this evaluation?
            </div>
            <div class="modal-footer">
                <button id="btn_confirm_modal_cancel" type="button" class="btn btn-danger"><i class="fa fa-ban"></i> Cancel</button> 
                <button id="btn_confirm_modal_accept" type="button" class="btn btn-primary"><i class="fa fa-check"></i> Accept</button>
            </div>
        </div>
    </div>
</div>
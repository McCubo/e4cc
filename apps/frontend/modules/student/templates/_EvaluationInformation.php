<div class="modal-content">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Evaluation Date: <?php echo date("l g:i A - F jS, Y", strtotime($oEvaluation->getEvaluationDate())); ?> <i class="fa fa-line-chart"></i></h4>
    </div>
    <div class="modal-body">
        <div class="row">
            <div class="col-lg-10">
                <h1>Final Score <i class="fa fa-angle-double-right"></i> <?php echo $oEvaluation->getFinalScore(); ?>
                    <small>
                        Coach <i class="fa fa-angle-double-right"></i> <?php echo $oEvaluation->getUser()->getPerson()->getFullName(); ?> (<?php echo $oEvaluation->getUser()->getPerson()->getUsername(); ?>)
                    </small>
                </h1>
            </div>
        </div>
        <?php $oGrade = new Grade(); ?>
        <?php foreach ($oEvaluation->getGrade() as $oGrade) : ?>
            <div class="panel panel-default">
                <div class="panel-body panel-green">                    
                    <h4>
                        <p style="color: <?php echo $oGrade->getGradeColor(); ?>" >
                            <?php echo $oGrade->getQuestion()->getQuestionName(); ?> <i class="fa fa-long-arrow-right"></i> <?php echo $oGrade->getGradeScore(); ?>
                        </p>
                    </h4>
                    <small>
                        <?php echo $oGrade->getQuestionComment(); ?>
                        <ul>
                            <?php foreach ($oGrade->getAdditionalComments() as $oAdditionalComment) : ?>
                                <li><?php echo $oAdditionalComment->getAdditionalComment(); ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </small>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
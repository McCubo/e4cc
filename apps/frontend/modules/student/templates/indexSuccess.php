<style type="text/css">
    /* Isotope Transitions
    ------------------------------- */
    .isotope,
    .isotope .item {
        -webkit-transition-duration: 0.8s;
        -moz-transition-duration: 0.8s;
        -ms-transition-duration: 0.8s;
        -o-transition-duration: 0.8s;
        transition-duration: 0.8s;
    }

    .isotope {
        -webkit-transition-property: height, width;
        -moz-transition-property: height, width;
        -ms-transition-property: height, width;
        -o-transition-property: height, width;
        transition-property: height, width;
    }

    .isotope .item {
        -webkit-transition-property: -webkit-transform, opacity;
        -moz-transition-property:    -moz-transform, opacity;
        -ms-transition-property:     -ms-transform, opacity;
        -o-transition-property:         top, left, opacity;
        transition-property:         transform, opacity;
    }


    /* responsive media queries */

    @media (max-width: 768px) {


        .isotope .item {
            position: static ! important;
            -webkit-transform: translate(0px, 0px) ! important;
            -moz-transform: translate(0px, 0px) ! important;
            transform: translate(0px, 0px) ! important;
        }
    }


</style>

<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">
            My Progress Information
            <div class="btn-group">
                <a href="<?php echo url_for("student/viewFullHistory"); ?>" class="btn btn-success btn-xs">
                    View Full History <i class="fa fa-external-link"></i>
                </a>
            </div>
        </h1>
    </div>
    <!-- /.col-lg-12 -->
</div>
<div class="row">
    <div class="col-md-7">
        <div class="panel <?php echo $oEvaluation->getPanelClass(); ?>">
            <div class="panel-heading">
                Last evaluation: <strong><?php echo date("F jS, Y", strtotime($oEvaluation->getEvaluationDate())); ?></strong> 
                [Grade: <strong><?php echo $oEvaluation->getFinalScore(); ?></strong>].
                Evaluated by: <strong><?php echo $oEvaluation->getUser()->getPerson()->getUsername(); ?></strong>
            </div>
            <div class="panel-body">
                <div id="grades" class="row">
                    <?php foreach ($oEvaluation->getGrade() as $oGrade): ?>
                        <div class="item col-md-4">
                            <div class="panel <?php echo $oGrade->getPanelClass(); ?>">
                                <div class="panel-heading">
                                    <?php echo $oGrade->getQuestion()->getQuestionName(); ?> [<small><strong><?php echo $oGrade->getGradeScore(); ?></strong></small>]
                                </div>
                                <div class="panel-body">
                                    <?php echo $oGrade->getQuestionComment(); ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div> 
            </div>
        </div>
    </div>
    <div class="col-md-5">
        <div id="my_grades_line" data-get_data_url="<?php echo url_for("student/buildLineChart"); ?>"></div> 
    </div>
</div>     
<script>
    $(function () {        
        $.ajax({
            url: $("#my_grades_line").data("get_data_url"),
            type: 'post',
            dataType: 'json',
            success: function (oData) {
                console.log(oData.serie_data.target);
                console.log(oData.serie_data.last_eva);
                $('#my_grades_line').highcharts({
                    chart: {
                        type: 'line'
                    },
                    title: {
                        text: '',
                        x: -80
                    },
                    pane: {
                        size: '80%'
                    },
                    xAxis: {
                        categories: oData.categories,
                        tickmarkPlacement: 'on',
                        lineWidth: 0
                    },
                    yAxis: {
                        gridLineInterpolation: 'polygon',
                        lineWidth: 0,
                        min: 0
                    },
                    tooltip: {
                        shared: true
                    },
                    legend: {
                        align: 'right',
                        verticalAlign: 'top',
                        y: 70,
                        layout: 'vertical'
                    },
                    series: [oData.serie_data.target, oData.serie_data.last_eva]

                });
            }
        });

        $.getScript('//cdnjs.cloudflare.com/ajax/libs/jquery.isotope/2.0.0/isotope.pkgd.min.js', function () {
            /* activate jquery isotope */
            $('#grades').isotope({
                itemSelector: '.item'
            });
        });
    });
</script>
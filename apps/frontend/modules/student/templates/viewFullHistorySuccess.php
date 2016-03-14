<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">My Evaluations History <i class="fa fa-area-chart"></i></h1>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <?php $aEvaluationGradesArray = $sf_data->getRaw('aEvaluationGrades'); ?>
        <table class="table table-bordered dataTable no-footer">
            <?php $i = 0; ?>
            <?php foreach ($aEvaluationGradesArray as $aEvaluarionRecord) : ?>
                <?php if ($i == 0): ?>
                    <thead>
                        <tr>
                            <?php foreach (array_keys($aEvaluarionRecord) as $sHeader): ?>
                                <th><?php echo $sHeader; ?></th>
                            <?php endforeach; ?>
                        </tr>
                    </thead>
                    <tbody>
                    <?php endif; ?>
                    <tr style="cursor: help;" class="detail_row" data-eva_id="<?php echo $aEvaluarionRecord["Evaluation Number"]; ?>" data-render_partial="<?php echo url_for("student/renderEvaluation"); ?>">
                        <?php foreach (array_values($aEvaluarionRecord) as $sGrade) : ?>
                            <td><?php echo $sGrade; ?></td>
                        <?php endforeach; ?>
                    </tr>
                    <?php $i++; ?>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<div class="row">
    <div class="col-lg-9">
        <div id="my_progress_chart" data-build_chart="<?php echo url_for("student/buildLineChartOverall"); ?>"></div>
    </div>
</div>
<script>
    $(document).ready(function () {
        $.ajax({
            url: $("#my_progress_chart").data("build_chart"),
            type: 'post',
            dataType: 'json',
            success: function (oData, sStatus, oXMLResponse) {
                console.log(oData.serie_data)
                $('#my_progress_chart').highcharts({
                    title: {
                        text: '',
                        x: -20 //center
                    },
                    subtitle: {
                        text: '',
                        x: -20
                    },
                    xAxis: {
                        categories: oData.categories
                    },
                    yAxis: {
                        title: {
                            text: 'Grade Obtained'
                        },
                        plotLines: [{
                                value: 0,
                                width: 1,
                                color: '#808080'
                            }]
                    },
                    legend: {
                        layout: 'vertical',
                        align: 'right',
                        verticalAlign: 'middle',
                        borderWidth: 0
                    },
                    series: oData.serie_data
                });
            }
        });

        $(".detail_row").click(function () {
            var iEvaluationId = $(this).data('eva_id');
            var sMethodUrl = $(this).data('render_partial');
            $.ajax({
                url: sMethodUrl,
                dataType: 'json',
                data: {eva_id: iEvaluationId},
                type: 'post',
                success: function (oData, sXMLResponse, sStatus) {
                    $("#partial_container").html(oData.html);
                    $('#myModal').modal('show');
                }
            });
        });
    });
</script>

<!-- Modal -->
<div class="modal fade bs-example-modal-lg" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div id="partial_container">

        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Main Dashboard</h1>
    </div>
    <!-- /.col-lg-12 -->
</div>
<!-- /.row -->
<div class="row">
    <?php $i = 0; ?>
    <?php foreach ($aSite as $sKey => $aSiteRecord): ?>
        <div class="col-lg-4 col-md-6">
            <div class="panel <?php echo $aSiteRecord['panel_color']; ?>">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3">
                            <i class="fa fa-building fa-5x"></i>
                        </div>
                        <div class="col-xs-9 text-right">
                            <div class="huge"><?php echo $aSiteRecord['counter']; ?></div>
                            <div>Subscribed people</div>
                        </div>
                    </div>
                </div>
                <div class="panel-footer">
                    <span class="pull-left"><?php echo $sKey; ?></span>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
        <?php $i++; ?>
    <?php endforeach; ?>
</div>
<!-- /.row -->
<div class="row">
    <div class="col-lg-6">
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-bar-chart-o fa-fw"></i> Trends by Coach
            </div>
            <ul id="trend_tabs" class="nav nav-tabs">
                <?php $p = 0; ?>
                <?php foreach ($oSiteCollection as $oSite): ?>
                    <?php if ($p == 0): ?>
                        <li class="active"><a data-toggle="tab" href="<?php echo "#" . $oSite->getSiteNoSpcaeName(); ?>"><?php echo $oSite->getSiteName(); ?></a></li>
                    <?php else: ?>
                        <li><a data-toggle="tab" href="<?php echo "#" . $oSite->getSiteNoSpcaeName(); ?>"><?php echo $oSite->getSiteName(); ?></a></li>
                    <?php endif; ?>
                    <?php $p++; ?>
                <?php endforeach; ?>               
            </ul>
            <div class="tab-content">
                <?php $c = 0; ?>
                <?php foreach ($oSiteCollection as $oSite): ?>
                    <div id="<?php echo $oSite->getSiteNoSpcaeName(); ?>" class="tab-pane fade in <?php echo $c == 0 ? "active" : ""; ?>">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div id="<?php echo "site_" . $oSite->getId(); ?>" data-site_id="<?php echo $oSite->getId(); ?>" data-get_data_url="<?php echo url_for("dashboard/buildTrendChart"); ?>"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php $c++; ?>
                <?php endforeach; ?>
            </div>
            <!-- /.panel-body -->
        </div>
        <!-- /.panel -->
    </div>
    <!-- /.col-lg-8 -->
    <div class="col-lg-6">
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-bar-chart-o fa-fw"></i> Percentage of students by level
            </div>
            <div class="panel-body">
                <div id="students_by_level_pie" data-get_data_url="<?php echo url_for("dashboard/buildPieChart"); ?>"></div>
            </div>
            <!-- /.panel-body -->
        </div>
        <!-- /.panel -->
        <!-- /.panel .chat-panel -->
    </div>
    <!-- /.col-lg-4 -->
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-bar-chart-o fa-fw"></i> Total Evaluations per Month
            </div>
            <div class="panel-body">
                <div class="row">
                    <!-- /.col-lg-4 (nested) -->
                    <div class="col-lg-12">
                        <div id="level_per_site_bar" data-get_data_url="<?php echo url_for("dashboard/buildBarChart"); ?>"></div>
                    </div>
                    <!-- /.col-lg-8 (nested) -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /.panel-body -->
        </div>
    </div>
</div>
<!-- /.row -->
<script type="text/javascript">
    $(function () {
        $('#trend_tabs').click(function (e) {            
            $(window).resize();
        });
        $.ajax({
            url: $('#level_per_site_bar').data("get_data_url"),
            type: 'post',
            dataType: 'json',
            success: function (oData) {
                $('#level_per_site_bar').highcharts({
                    chart: {
                        type: 'bar'
                    },
                    title: {
                        text: ''
                    },
                    xAxis: {
                        categories: oData.xAxis
                    },
                    yAxis: {
                        min: 0,
                        title: {
                            text: 'Total Evaluations'
                        }
                    },
                    legend: {
                        reversed: false
                    },
                    plotOptions: {
                        series: {
                            stacking: 'normal'
                        }
                    },
                    series: oData.series
                });
            }
        });

        $.ajax({
            url: $("#site_1").data("get_data_url"),
            type: 'post',
            data: {
                site_id: $("#site_1").data("site_id")
            },
            dataType: 'json',
            success: function (oData) {
                $('#site_1').highcharts({
                    chart: {
                        type: 'line'
                    },
                    title: {
                        text: 'Comparation Trend'
                    },
                    subtitle: {
                        text: 'Grades given by each coach'
                    },
                    xAxis: {
                        categories: oData.xAxis
                    },
                    yAxis: {
                        title: {
                            text: 'Grade'
                        }
                    },
                    plotOptions: {
                        line: {
                            dataLabels: {
                                enabled: true
                            },
                            enableMouseTracking: true
                        }
                    },
                    series: oData.series
                });
            }
        });

        $.ajax({
            url: $("#site_2").data("get_data_url"),
            type: 'post',
            data: {
                site_id: $("#site_2").data("site_id")
            },
            dataType: 'json',
            success: function (oData) {
                $('#site_2').highcharts({
                    chart: {
                        type: 'line'
                    },
                    title: {
                        text: 'Comparation Trend'
                    },
                    subtitle: {
                        text: 'Grades given by each coach'
                    },
                    xAxis: {
                        categories: oData.xAxis
                    },
                    yAxis: {
                        title: {
                            text: 'Grade'
                        }
                    },
                    plotOptions: {
                        line: {
                            dataLabels: {
                                enabled: true
                            },
                            enableMouseTracking: true
                        }
                    },
                    series: oData.series
                });
            }
        });

        $.ajax({
            url: $("#site_3").data("get_data_url"),
            type: 'post',
            data: {
                site_id: $("#site_3").data("site_id")
            },
            dataType: 'json',
            success: function (oData) {
                $('#site_3').highcharts({
                    chart: {
                        type: 'line'
                    },
                    title: {
                        text: 'Comparation Trend'
                    },
                    subtitle: {
                        text: 'Grades given by each coach'
                    },
                    xAxis: {
                        categories: oData.xAxis
                    },
                    yAxis: {
                        title: {
                            text: 'Grade'
                        }
                    },
                    plotOptions: {
                        line: {
                            dataLabels: {
                                enabled: true
                            },
                            enableMouseTracking: true
                        }
                    },
                    series: oData.series
                });
            }
        });

        $.ajax({
            url: $("#students_by_level_pie").data('get_data_url'),
            type: 'post',
            dataType: 'json',
            success: function (oData) {
                var categories = oData.categories;
                var iColor = 2;
                var data = [];
                for (var obj in oData.aData) {
                    if (oData.aData.hasOwnProperty(obj)) {
                        data.push({
                            y: oData.aData[obj].y,
                            color: Highcharts.getOptions().colors[iColor],
                            drilldown: {
                                categories: oData.aData[obj].aCategories,
                                data: oData.aData[obj].aData,
                                color: Highcharts.getOptions().colors[iColor]
                            }
                        });
                    }
                    iColor++;
                }
                var siteData = [], levelData = [], i, j, dataLen = data.length, drillDataLen, brightness;
                for (i = 0; i < dataLen; i += 1) {
                    siteData.push({
                        name: categories[i],
                        y: data[i].y,
                        color: data[i].color
                    });
                    drillDataLen = data[i].drilldown.data.length;
                    for (j = 0; j < drillDataLen; j += 1) {
                        brightness = 0.2 - (j / drillDataLen) / 5;
                        levelData.push({
                            name: data[i].drilldown.categories[j],
                            y: data[i].drilldown.data[j],
                            color: Highcharts.Color(data[i].color).brighten(brightness).get()
                        });
                    }
                }
                // Create the chart
                $('#students_by_level_pie').highcharts({
                    chart: {
                        type: 'pie'
                    },
                    title: {
                        text: ''
                    },
                    plotOptions: {
                        pie: {
                            shadow: false,
                            center: ['50%', '50%']
                        }
                    },
                    tooltip: {
                        valueSuffix: '%'
                    },
                    series: [{
                            name: 'Total students',
                            data: siteData,
                            size: '60%',
                            dataLabels: {
                                formatter: function () {
                                    return this.y > 5 ? this.point.name : null;
                                },
                                color: 'black',
                                distance: -30
                            }
                        }, {
                            name: 'Students',
                            data: levelData,
                            size: '80%',
                            innerSize: '60%',
                            dataLabels: {
                                formatter: function () {
                                    // display only if larger than 1
                                    return this.y > 1 ? '<b>' + this.point.name + ':</b> ' + this.y + '%' : null;
                                }
                            }
                        }]
                });
            }
        });
    });

</script>
<div id="div_container">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Courses</h1>
        </div>
    </div>

    <ol class="breadcrumb">
        <li class="active">Courses</li>
    </ol>

    <div>
        <!-- nav tabs -->
        <ul class="nav nav-tabs" role="tablist">
            <li role="presentation" class="active"><a href="#courses_self" aria-controls="courses_self" role="tab" data-toggle="tab"><span class="fa fa-user"></span> My Courses</a></li>
            <li role="presentation"><a href="#courses_all" aria-controls="courses_all" role="tab" data-toggle="tab"><span class="fa fa-group"></span> All Courses</a></li>
        </ul>

        <!-- tab panes -->
        <div class="tab-content">
            <!-- tab 1 -->
            <div role="tabpanel" class="tab-pane active" id="courses_self">
                <div class="row">&nbsp;</div>
                <div class="well">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12">
                            <form class="form-inline">
                                <div class="form-group">
                                    <label>Site</label>
                                    <select class="form-control select_site" name="select_site_self" id="select_site_self" data-type="self">
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
                                    <select class="form-control select_level" name="select_level_self" id="select_level_self" data-type="self">
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
                                    <button type="button" class="btn btn-primary btn_filter" id="btn_filter_self" data-type="self"><span class="glyphicon glyphicon-filter"></span> Filter</button> 
                                    <button type="button" class="btn btn-default btn_clear" id="btn_clear_self" data-type="self"><span class="fa fa-undo"></span> Clear Filter</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div><!-- /well -->
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-12" id="div_list_self">
                            <table class="table table-bordered table-hover table-striped" id="table_list_self">
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
                                        echo "<td><a href='javascript:void(0)' onclick='loadContent(\"div_container\", \"" . url_for("course_coach/view?id=") . $course->getId() . "\")'><span class='glyphicon glyphicon-list'></span> View</a></td>";
                                        echo "</tr>";
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- tab 2 -->
            <div role="tabpanel" class="tab-pane" id="courses_all">
                <div class="row">&nbsp;</div>
                <div class="well">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12">
                            <form class="form-inline">
                                <div class="form-group">
                                    <label>Site</label>
                                    <select class="form-control select_site" name="select_site_all" id="select_site_all" data-type="all">
                                        <option value="0">All</option>
                                        <?php
                                        foreach ($siteAllArray as $record) {
                                            echo "<option value='{$record["id"]}'>{$record["site_name"]}</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                                &nbsp;
                                <div class="form-group">
                                    <label>Level</label>
                                    <select class="form-control select_level" name="select_level_all" id="select_level_all" data-type="all">
                                        <option value="0">All</option>
                                        <?php
                                        foreach ($levelAllArray as $record) {
                                            echo "<option value='{$record["id"]}'>{$record["level_name"]}</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                                &nbsp;
                                <div class="form-group">
                                    <label>Coach</label>
                                    <select class="form-control select_coach" name="select_coach_all" id="select_coach_all" data-type="all">
                                        <option value="0">All</option>
                                        <?php
                                        foreach ($userAllArray as $record) {
                                            echo "<option value='{$record["id"]}'>{$record["first_name"]} {$record["last_name"]}</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                                &nbsp;
                                <div class="form-group">
                                    <button type="button" class="btn btn-primary btn_filter" id="btn_filter_all" data-type="all"><span class="glyphicon glyphicon-filter"></span> Filter</button> 
                                    <button type="button" class="btn btn-default btn_clear" id="btn_clear_all" data-type="all"><span class="fa fa-undo"></span> Clear Filter</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div><!-- /well -->
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-12" id="div_list_all">
                            <table class="table table-bordered table-hover table-striped" id="table_list_all">
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
                                    foreach ($listAll as $record) {
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
                                        echo "<td><a href='javascript:void(0)' onclick='loadContent(\"div_container\", \"" . url_for("course_coach/view?id=") . $course->getId() . "\")'><span class='glyphicon glyphicon-list'></span> View</a></td>";
                                        echo "</tr>";
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- /tab panes -->
    </div>

    <script>
        $(document).ready(function () {
            //listeners
            $('#table_list_self').DataTable();
            $("#table_list_all").DataTable();

            $(".select_site").change(function () {
                var type = $(this).attr("data-type");
                var site_id = $(this).val();
                getLevel(type, site_id);
                if ("all" === type) {
                    getCoach(type, site_id, 0);
                }
            });

            $(".select_level").change(function () {
                var type = $(this).attr("data-type");
                var site_id = $("#select_site_" + type).val();
                var level_id = $("#select_level_" + type).val();
                if ("all" === type) {
                    getCoach(type, site_id, level_id);
                }
            });

            $(".btn_filter").click(function () {
                var type = $(this).attr("data-type");
                var site_id = $("#select_site_" + type).val();
                var level_id = $("#select_level_" + type).val();
                var user_id = $("#select_coach_" + type).val();
                getList(type, site_id, level_id, user_id);
            });

            $(".btn_clear").click(function () {
                var type = $(this).attr("data-type");
                clearFilter(type);
            });

            //functions
            function getLevel(type, site_id) {
                $.ajax({
                    url: "<?php echo url_for("course_coach/getLevel"); ?>",
                    type: "POST",
                    dataType: "HTML",
                    data: {
                        type: type,
                        site_id: site_id
                    },
                    success: function (data) {
                        $("#select_level_" + type).html(data);
                    },
                    error: function () {
                        $.growl.error({message: "An error has occured"});
                    }
                });
            }

            function getCoach(type, site_id, level_id) {
                $.ajax({
                    url: "<?php echo url_for("course_coach/getCoach"); ?>",
                    type: "POST",
                    dataType: "HTML",
                    data: {
                        type: type,
                        site_id: site_id,
                        level_id: level_id
                    },
                    success: function (data) {
                        $("#select_coach_" + type).html(data);
                    },
                    error: function () {
                        $.growl.error({message: "An error has occured"});
                    }
                });
            }

            function getList(type, site_id, level_id, user_id) {
                $.ajax({
                    url: "<?php echo url_for("course_coach/getList"); ?>",
                    type: "POST",
                    dataType: "HTML",
                    data: {
                        type: type,
                        site_id: site_id,
                        level_id: level_id,
                        user_id: user_id
                    },
                    success: function (data) {
                        $("#div_list_" + type).html(data);
                    },
                    error: function () {
                        $.growl.error({message: "An error has occured"});
                    }
                });
            }

            function clearFilter(type) {
                $("#select_site_" + type).val(0);
                $("#select_level_" + type).val(0);
                getLevel(0);
                if ("all" === type) {
                    $("#select_coach_" + type).val(0);
                    getCoach(0, 0);
                }
                getList(type, 0, 0, 0);
            }
        });
    </script>
</div><!-- /container -->
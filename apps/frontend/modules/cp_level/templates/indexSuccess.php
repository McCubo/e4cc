<div id="div_container">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Levels List</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>

    <ol class="breadcrumb">
        <li class="active">Levels List</li>
    </ol>

    <div class="well">
        <div class="row">
            <div class="col-xs-8">
                <strong>Show records: </strong>
                <label class="radio-inline">
                    <input type="radio" name="radio_showlist" id="radio_showlist_active" value="1" checked> Active <samp class="badge badge-success"><?php echo $list->count(); ?></samp>
                </label>
                <label class="radio-inline">
                    <input type="radio" name="radio_showlist" id="radio_showlist_inactive" value="0"> Inactive <samp class="badge badge-danger"><?php echo $listInactive->count(); ?></samp>
                </label>
            </div>
            <div class="col-xs-4 text-right">
                <button type="button" class="btn btn-default" id="btn_new"><span class="glyphicon glyphicon-plus"></span> New Register</button> 
            </div>
        </div>
    </div>

    <br/>

    <div id="div_list">
        <table class="table table-bordered table-hover table-striped" id="table_list">
            <thead>
                <tr>
                    <td>N°</td>
                    <td>SITE NAME</td>
                    <td>ACTION</td>
                </tr>
            </thead>
            <tbody>
                <?php
                $i = 0;
                foreach ($list as $record) {
                    $level = new Level();
                    $level = (object) $record;
                    ++$i;

                    echo "<tr>";
                    echo "<td>{$i}</td>";
                    echo "<td>{$level->getLevelName()}</td>";
                    echo "<td><a href='javascript:void(0)' onclick='loadContent(\"div_container\", \"" . url_for("cp_level/edit?id=") . $level->getId() . "\")'><span class='glyphicon glyphicon-edit'></span> Edit</a></td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <script>
        $(document).ready(function () {
            var is_active = 1;

            $("#table_list").DataTable();

            /*listeners*/
            $("input:radio[name=radio_showlist]").click(function () {
                if (is_active != $(this).val()) {
                    is_active = $(this).val();
                    showInactive();
                }
            });

            $("#btn_new").click(function () {
                loadContent("div_container", "<?php echo url_for("cp_level/new"); ?>");
            });

            //functions
            function showInactive() {
                $.ajax({
                    url: "<?php echo url_for("cp_level/getList"); ?>",
                    type: "POST",
                    dataType: "HTML",
                    data: {
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
        });
    </script>
</div>
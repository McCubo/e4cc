<div class="navbar navbar-fixed-top">
    <div class="navbar-inner">
        <div class="container-fluid">
            <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </a>

            <a class="brand" href="<?php echo url_for('home/index'); ?>">Administration</a>
            <?php if ($sf_user->getAttribute("has_access") == true): ?>
                <div class="nav-collapse">
                    <p class="navbar-text pull-right"><a href="<?php echo url_for("home/logout"); ?>">Logout</a></p>
                </div>
            <?php endif ?>
        </div>
    </div>
</div>

<div class="container-fluid">
    <?php if ($sf_user->getAttribute("has_access") == true): ?>
        <div class="row-fluid">
            <h1>System Tables List</h1>

            <table class="datatable table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Nº</th>
                        <th>Table Name</th>
                        <th>Rows</th>
                        <th>Size</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr><th colspan="6"><div style="float: left;font-weight: bold;line-height: 34px;margin-left: 10px;position: relative;width: auto;"><?php echo $resultData->rowCount(); ?> results</div></th></tr></tfoot>
                <tbody>
                    <?php
                    $i = 1;
                    foreach ($resultData as $row) {
                        echo '<tr>';
                        echo '<td>' . $i++ . '</td>';
                        echo '<td>' . $row[0] . '</td>';
                        echo '<td>' . $row[1] . '</td>';
                        echo '<td>' . $row[2] . '</td>';
                        echo '<td><a class="btn btn-small" href="' . url_for($row[0]) . '"><i class="icon-list icon-black"></i> Show</a></td>';
                        echo '</tr>';
                    }
                    ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
    <?php if ($sf_user->getAttribute("has_access") != true): ?>
        <br/>
        <div>
            <strong>Username</strong>
        </div>
        <input type="text" id="usr"/>
        <div>
            <strong>Password</strong>
        </div>
        <input type="password" id="pas" class="input-large"/> <input type="button" id="btn_login" value="Login"/>
        <script>
            $(document).ready(function () {
                $("#btn_login").click(function () {
                    var usr = $("#usr").val();
                    var pas = $("#pas").val();
                    $.ajax({
                        url: "<?php echo url_for("home/login"); ?>",
                        type: "POST",
                        dataType: "TEXT",
                        data: {
                            usr: usr,
                            pas: pas
                        },
                        success: function (data) {
                            if (data == "FALSE") {
                                $.growl.error({message: "Credentials are incorrect"});
                            } else {
                                $(location).attr("href", "<?php echo url_for("home/index"); ?>");
                            }
                        },
                        error: function () {
                            $.growl.error({message: "An error has occured"});
                        }
                    });
                });
            });
        </script>
    <?php endif; ?>
</div>

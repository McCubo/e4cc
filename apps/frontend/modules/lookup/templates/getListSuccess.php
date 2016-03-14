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
            echo "<td><a href='javascript:void(0)' onclick='loadContent(\"div_container\", \"" . url_for("lookup/edit?id=") . $record["id"] . "\")'><span class='glyphicon glyphicon-edit'></span> Edit</a></td>";
            echo "</tr>";
        }
        ?>
    </tbody>
</table>

<script>
    $(document).ready(function () {
        $("#table_list").DataTable({
            pageLength: 50,
            buttons: [
                'copy', 'excel', 'pdf'
            ]
        }).buttons().container().appendTo($('#datatables_export_buttons'));
    });
</script>
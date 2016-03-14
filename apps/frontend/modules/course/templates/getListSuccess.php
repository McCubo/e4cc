<table class="table table-bordered table-hover table-striped" id="table_list">
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
            $dateTimeStart = new DateTime($record["start"]);
            $start_time = date_format($dateTimeStart, "h:i a");

            $dateTimeEnd = new DateTime($record["end"]);
            $end_time = date_format($dateTimeEnd, "h:i a");

            $description = $record["description"] != null ? " (" . $record["description"] . ")" : "";
            $scheduleName = $start_time . " - " . $end_time . $description;

            ++$i;

            echo "<tr>";
            echo "<td>{$i}</td>";
            echo "<td>{$record["site_name"]}</td>";
            echo "<td>{$record["level_name"]}</td>";
            echo "<td>{$record["course_name"]}</td>";
            echo "<td>{$scheduleName}</td>";
            echo "<td>{$record["first_name"]} {$record["last_name"]}</td>";
            echo "<td>{$record["total_inscription"]}</td>";
            echo "<td><a href='javascript:void(0)' onclick='loadContent(\"div_container\", \"" . url_for("course/edit?id=") . $record["id"] . "\")'><span class='glyphicon glyphicon-edit'></span> Edit</a></td>";
            echo "</tr>";
        }
        ?>
    </tbody>
</table>

<script>
    $(document).ready(function () {
        $("#table_list").DataTable();
    });
</script>
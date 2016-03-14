<div id="datatables_export_buttons" class="datatables_export_buttons"></div>
<table class="table table-bordered table-hover table-striped" id="table_list">
    <thead>
        <tr>
            <th>N°</th>
            <th>FIRST NAME</th>
            <th>LAST NAME</th>
            <th>LAST EVALUATION DATE</th>
            <th>LAST EVALUATION SCORE</th>
            <th>TOTAL EVALUATIONS</th>
            <th>AVERAGE SCORE</th>
            <th>SELECT</th>
            <th>ACTION</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $i = 0;
        foreach ($list as $record) {
            ++$i;

            echo "<tr>";
            echo "<td>{$i}</td>";
            echo "<td>{$record["first_name"]}</td>";
            echo "<td>{$record["last_name"]}</td>";
            echo "<td>{$record["last_evaluation_date"]}</td>";
            echo "<td>" . OutputFormat::formatScore($record["last_evaluation_score"]) . "</td>";
            echo "<td>{$record["total_evaluations"]}</td>";
            echo "<td>" . OutputFormat::formatScore($record["average_score"]) . "</td>";
            echo "<td><div class='checkbox'><label><input type='checkbox' class='checkbox_student' value='{$record["student_id"]}'>select</label></div></td>";
            echo "<td>";
            echo "<div><a href='javascript:void(0)' onclick='evaluateAction({$record["student_id"]})'><span class='fa fa-file-text-o'></span> Evaluate</a></div>";
            echo "<div><a href='javascript:void(0)' onclick='viewAction({$record["student_id"]})'><span class='fa fa-list'></span> View</a></div>";
            echo "<div><a href='javascript:void(0)' onclick='moveAction({$record["student_id"]})'><span class='fa fa-exchange'></span> Move</a></div>";
            echo "<div><a href='javascript:void(0)' onclick='deleteAction({$record["student_id"]})'><span class='fa fa-trash'></span> Delete</a></div>";
            echo "</td>";
            echo "</tr>";
        }
        ?>
    </tbody>
</table>

<script>
    $(document).ready(function () {
        $("#table_list").DataTable({
            buttons: [
                'copy', 'excel', 'pdf'
            ]
        }).buttons().container().appendTo($('#datatables_export_buttons'));
    });
</script>
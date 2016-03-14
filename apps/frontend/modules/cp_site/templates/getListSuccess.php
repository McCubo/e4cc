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
            $site = new Site();
            $site = (object) $record;

            ++$i;
            $label = $site->getIsActive() ? "" : " <span class='label label-danger'>inactive</span>";

            echo "<tr>";
            echo "<td>{$i}{$label}</td>";
            echo "<td>{$site->getSiteName()}</td>";
            echo "<td><a href='javascript:void(0)' onclick='loadContent(\"div_container\", \"" . url_for("cp_site/edit?id=") . $site->getId() . "\")'><span class='glyphicon glyphicon-edit'></span> Edit</a></td>";
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
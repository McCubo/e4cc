<table class="table table-bordered table-hover table-striped" id="table_list">
    <thead>
        <tr>
            <td>N°</td>
            <td>SITE NAME</td>
            <td>CLASS ROOM NAME</td>
            <td>ACTION</td>
        </tr>
    </thead>
    <tbody>
        <?php
        $i = 0;
        foreach ($list as $record) {
            $classRoom = new ClassRoom();
            $classRoom = (object) $record;
            
            $site = new Site();
            $site = $classRoom->getSite();
            
            ++$i;
            $label = $classRoom->getIsActive() ? "" : " <span class='label label-danger'>inactive</span>";
            
            echo "<tr>";
            echo "<td>{$i}{$label}</td>";
            echo "<td>{$site->getSiteName()}</td>";
            echo "<td>{$classRoom->getClassRoomName()}</td>";
            echo "<td><a href='javascript:void(0)' onclick='loadContent(\"div_container\", \"" . url_for("cp_class_room/edit?id=") . $classRoom->getId() . "\")'><span class='glyphicon glyphicon-edit'></span> Edit</a></td>";
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
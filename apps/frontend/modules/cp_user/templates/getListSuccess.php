<table class="table table-bordered table-hover table-striped" id="table_list">
    <thead>
        <tr>
            <td>N°</td>
            <td>USERNAME</td>
            <td>ROLE</td>
            <td>FULL NAME</td>
            <td>ACTION</td>
        </tr>
    </thead>
    <tbody>
        <?php
        $i = 0;
        foreach ($list as $record) {
            $user = new User();
            $user = (object) $record;

            $role = new Role();
            $role = (object) $user->getRole();

            $person = new Person();
            $person = (object) $user->getPerson();

            ++$i;
            $label = $user->getIsActive() ? "" : " <span class='label label-danger'>inactive</span>";

            echo "<tr>";
            echo "<td>{$i}{$label}</td>";
            echo "<td>{$person->getUsername()}</td>";
            echo "<td>{$role->getRoleName()}</td>";
            echo "<td>{$person->getFullName()}</td>";
            echo "<td><a href='javascript:void(0)' onclick='loadContent(\"div_container\", \"" . url_for("cp_user/edit?id=") . $user->getId() . "\")'><span class='glyphicon glyphicon-edit'></span> Edit</a></td>";
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
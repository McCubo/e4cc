<option value='0'>All</option>
<?php
foreach ($list as $record) {
    echo "<option value='{$record["id"]}'>{$record["first_name"]} {$record["last_name"]}</option>";
}


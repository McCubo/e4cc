<option value='0'>All</option>
<?php
foreach ($list as $record) {
    echo "<option value='{$record["id"]}'>{$record["level_name"]}</option>";
}
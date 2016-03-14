<option value="0">Select one option</option>
<?php
foreach ($list as $record) {
    echo "<option value='{$record["id"]}'>{$record["level_name"]}</option>";
}
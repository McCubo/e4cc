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
    $checked = $i == 1 ? "checked='checked'" : "";

    echo "<tr>";
    echo "<td>{$i}</td>";
    echo "<td>{$record["course_name"]}</td>";
    echo "<td>{$scheduleName}</td>";
    echo "<td>{$record["first_name"]} {$record["last_name"]}</td>";
    echo "<td>{$record["total_inscription"]}</td>";
    echo "<td><div class='radio'><label><input type='radio' name='radio_course' value='{$record["id"]}' {$checked}>Select</label></div></td>";
    echo "</tr>";
}
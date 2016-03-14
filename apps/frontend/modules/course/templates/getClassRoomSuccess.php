<option value=''>Select one option</option>
<?php
foreach ($list as $object) {
    $classRoom = new ClassRoom();
    $classRoom = (object) $object;
    echo "<option value='{$classRoom->getId()}'>{$classRoom->getClassRoomName()}</option>";
}
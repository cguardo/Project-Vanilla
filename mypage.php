<?php

$sql = "SELECT * FROM MyTable";

if ($_GET['sort'] == 'type')
{
    $sql .= " ORDER BY type";
}
?>
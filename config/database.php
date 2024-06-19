<?php

$db = new mysqli("localhost", "root", "", "uprak_rama");

$query = "SELECT * FROM siswa";
$result = $db->query($query);

$siswa = [];

while ($item = $result->fetch_assoc()) {
    $siswa[] = $item;
};

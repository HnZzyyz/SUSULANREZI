<?php 

include "../../config/database.php";

$rezi = 'DELETE FROM siswa where nis =' .$_GET['nis'];

$db->query($rezi);

header('location: index.php');

?>
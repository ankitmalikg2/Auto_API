<?php
echo "\nTest script started .........\n";

$config =include dirname(__FILE__). '/config/config.php';
include "file_reader/FileReader.php";
include "lib/main.php";
include "execute.php";
$response =run_script($config);

echo "Result=$response";

echo "\nTest script finished ........... \n";
?>

<?php
echo "\nTest script started .........\n".

include "config/config.php";
include "validation/Validation.php";
include "file_reader/FileReader.php";
include "functions/Functions.php";
include "execute.php";
$response =run_script();
print_r($response);

echo "\nTest script finished ........... \n";
?>

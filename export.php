<?php

include('database.php');

//EXPORT TABLE "PROBLEME"
$filename = 'probleme.csv';
$export_data = unserialize($_POST['export_data']);

// file creation
$file = fopen($filename,"w");

foreach($export_data as $line){
  fputcsv($file,$line,";");
}

fclose($file); 

// download
header("Content-Description: File Transfer");
header("Content-Disposition: attachment; filename=".$filename);
header("Content-Type: application/csv; "); 

readfile($filename);

// deleting file
unlink($filename);
//exit();

//EXPORT TABLE "SOLUTIONS"
$filename = 'solution.csv';
$export_data2 = unserialize($_POST['export_data2']);

// file creation
$file = fopen($filename,"w");

foreach($export_data as $line){
  fputcsv($file,$line,";");
}

fclose($file); 

// download
header("Content-Description: File Transfer");
header("Content-Disposition: attachment; filename=".$filename);
header("Content-Type: application/csv; "); 

readfile($filename);

// deleting file
unlink($filename);
//exit();

?>
<?php

include('database.php');


//EXPORT TABLEAU 1

if(isset($_POST['export_data'])){ 
  $filename = 'probleme.csv'; //commetn on va nommer le fichier
  $export_data = unserialize($_POST['export_data']); //crée une variable php à partir de la valeur linéarisée

  $file = fopen($filename,"w"); //on écrit le fichier

  foreach ($export_data as $line){  //formate chaque ligne en csv (la virgule est le séparateur par défaut)
    fputcsv($file,$line);
  }

  fclose($file); 

  // Téléchargement
  header("Content-Description: File Transfer");
  header("Content-Disposition: attachment; filename=".$filename);
  header("Content-Type: application/csv; "); 

  readfile($filename);  //lecture simple du fichier

  unlink($filename); //on efface le fichier
  //exit();
}

//EXPORT TABLEAU 2

if(isset($_POST['export_data2'])){
  
  $filename = 'solution.csv';
  $export_data2 = unserialize($_POST['export_data2']);

  $file = fopen($filename,"w");

  foreach ($export_data2 as $line){
    fputcsv($file,$line);
  }

  fclose($file); 

  header("Content-Description: File Transfer");
  header("Content-Disposition: attachment; filename=".$filename);
  header("Content-Type: application/csv; "); 

  readfile($filename);

  unlink($filename);
  exit();
}
?>
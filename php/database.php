<?php

	define('HOST','localhost');
	define('DB_NAME','edt');
	define('USER','root');
	define('PASS','');

	try{
		$db = new PDO("mysql:host=".HOST.";dbname=".DB_NAME, USER, PASS);
		$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		//echo "Connexion établie! ";
	}catch(PDOException $e){
		echo "La connexion a échoué: ".$e-> getMessage();
	}

?>
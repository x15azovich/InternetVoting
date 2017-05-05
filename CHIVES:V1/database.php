<?php
	try{
		$db = new PDO("mysql:host=127.0.0.1; dbname=election", "root", "jsg752");
		$db -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$db -> exec("SET NAMES 'utf8'");
		echo "<h1>works</h1>";
	}
	catch(Exception $e){
		echo "not Working";
	}
?>
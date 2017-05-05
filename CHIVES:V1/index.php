<?php
	session_start();

echo ($random_number);
	$listOfCompanies = ['Alpha', 'Band', 'Bravo', 'Charlie', 'Delta', 
		'Echo', 'F-Troop', 'Golf', 'Hotel', 'India',
		'Kilo', 'Lima', 'Mike', 'November', 'Oscar', 
		'Palmetto Battery', 'Papa', 'Romeo', 'Sierra', 
		'Tango', 'Victor'];
	if(isset($_POST['Elect1'])){
		$_SESSION['companyName'] = $_POST['Elect1'];
		header('Location: Alpha.php');
		
	}




	
?>
<!DOCTYPE html>
<html>
<head>

<script language="JavaScript" type="text/javascript" src="jsbn.js"></script>
        <script language="JavaScript" type="text/javascript" src="random.js"></script>
        <script language="JavaScript" type="text/javascript" src="hash.js"></script>
        <script language="JavaScript" type="text/javascript" src="rsa.js"></script>
        <script language="JavaScript" type="text/javascript" src="aes.js"></script>
        <script language="JavaScript" type="text/javascript" src="api.js"></script>

<title>Voting-System</title>
<style>
body {
background-color: lightblue;
font-family: Helvetica;
}

</style>
<link rel="stylesheet" type="text/css" href="election.css">


</head>



<body>
<div id="main"><!-- open main div -->
<div id="header"><!-- open header div -->
<h1>CHIVES: Citadel Honor court Internet Voting Encryption System</h1>
<img src="knobsign.jpg" alt="KobView" style="width:100%; height:80%;">
</div><!-- close header div -->
<form  id="form1" action="index.php" method="Post">
<p>Please Select Your Company</p>


<?php
$arrayLength = sizeof($listOfCompanies);
	/*
	This created html statement created by this loop for all companies
	
	<input type="radio" name="Elect1" value="Alpha" />Alpha<br />
	*/
	for($i = 0; $i < $arrayLength; $i++){
		$createRadioButton = '<input type="radio" name="Elect1" value="' .
			$listOfCompanies[$i] . '" />' . $listOfCompanies[$i] . '</br >';
	echo $createRadioButton;	
	}

echo $random_number;
?>
<br>
<button type="submit" name="submit" id="submit">Submit</button>
</br>
</form>




<?php
	session_start();
	$companyPick = $_SESSION['companyName'];
	$random_number = mt_rand();



	if($_SESSION['companyName'] == "Band"){
		$companyLetter = "BD";
	}
	elseif($_SESSION['companyName']=="Palmetto Battery"){
		$companyLetter ="PB";
	}
	else{
	$companyLetter = $companyPick[0];
}
	$_SESSION['candidateCompany'] = $companyLetter;
	//$output = 0;
	//$voteCounter = 1;
	
	if(isset($_POST['login'])){
		$cwid = $_POST['CWID'];
	}
	
	//include database.php;
	try{
		$db = new PDO("mysql:host=127.0.0.1; dbname=VoteDB", "root", "Eoeg47052695");
		$db -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$db -> exec("SET NAMES 'utf8'");
		
		$results = $db -> prepare("SELECT * 
									FROM Master
									WHERE cwid = ?
									AND company = ?");
									
		$results -> bindParam(1, $cwid);
		$results -> bindParam(2, $companyLetter);
		$results -> execute();
		
		$exist = $results -> fetch(PDO::FETCH_ASSOC);
		$doesItExist = sizeof($exist);
		
		
		$findingNumberOfVotes = $db -> prepare("SELECT count(cwid) as counter
												FROM Votes 
												WHERE cwid = ?");
		$findingNumberOfVotes -> bindParam(1, $cwid);
		$findingNumberOfVotes -> execute();
		$castedVotes = $findingNumberOfVotes -> fetch(PDO::FETCH_ASSOC);
		$output = intval($castedVotes[counter]);
		
		
		if($output >= 2){
			header('Location: ThankYou.php');
		}
		
		else if($doesItExist > 1 ){
			$_SESSION['companyCWID'] = $exist[cwid];
			header('Location: election.php');
		}
		
	}
	catch(Exception $e){
		echo "not Working";
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


 <script>

        function print(string)
        {
            document.write(string + "\n\n");
        }

        print("<h1>Encryption test Public Key and Random Number:</h1>");

	//Initialize Everything
        var rnumber= '<?php echo $random_number; ?>' ;
	var cwid= "<?php echo $_POST['CWID'];?>";
        var PassPhrase = rnumber ;
        var Bits = 512;
	//place server public key here
	var ServerPass= "Zovich";

	//print the pass phrase and the bits
        print("Zovich's passphrase: " + PassPhrase);
        print("<br> Bit length: " + Bits + "</br>");


	 //Randomly Generate a client RSA KEY (passphrase is random)
        var ZovichRSAkey = cryptico.generateRSAKey(PassPhrase, Bits);
	//Create the public key for the client
        var ZovichPublicKeyString = cryptico.publicKeyString(ZovichRSAkey);       
        
        print("<br> Zovich's public key string: </br>");
	
        print(ZovichPublicKeyString);
        

	//generate the server RSA Key
	var ServerRSAKey= cryptico.generateRSAKey("Zovich", 512);
	print("<br>The SERVER RSA KEy IS : </br>");
	print(ServerRSAKey);


	//generate the server Public Key
	var ServerPublicKey= cryptico.publicKeyString(ServerRSAKey);
	print("<br> The server Public Key IS :  </br> ");
	print(ServerPublicKey);
	
	
       
	

//plain text
var plaintext = ZovichPublicKeyString + " " + PassPhrase + " " + cwid;
	print("<br> The Plain TExt IS : </br> " );
	print(plaintext);
//encryption
var EncryptionResult = cryptico.encrypt(plaintext, ServerPublicKey);
	print("<br> The Encryption Result IS: </br> " );

//encryption.cipher
var PublicEncryption=EncryptionResult.cipher;	
print(PublicEncryption); 

	document.cookie="PublicEncryption="+EncryptionResult.cipher;
//decryption
/*var DecryptionResult = cryptico.decrypt(PublicEncryption, ServerRSAKey);
        
        print("<br> The decrypted message: </br> ");
        print(DecryptionResult.plaintext);
*/

//decryption
var DecryptionMessage= cryptico.decrypt(PublicEncryption, ServerRSAKey);
print("<br> Server Public Key : </br> ");
print(ServerPublicKey);

print("<br> The decrypted message: </br> ");
        print(DecryptionMessage.plaintext);
	print(DecryptionMessage.signature);




        </script>
<body>
<div id="main"><!-- open main div -->
<div id="header"><!-- open header div -->
<h1>Citadel Election</h1>
<img src="knobsign.jpg" alt="KobView" style="width:935px;height:350px;">
<h3><?php echo $companyPick; ?></h3>
</div><!-- close header div -->
<form id = "form1" action="Alpha.php" method="POST">
<p>Please Enter Your CWID</p>

CWID: <input type = "text" id = "CWID" name ="CWID" ><br>
<input type="submit" value="login" name="login">


</form>



</div><!-- close main div -->
</body>
</html>

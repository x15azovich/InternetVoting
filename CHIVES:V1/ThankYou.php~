<?php
	session_start();
	$EncryptedCandidate= $_COOKIE['ListOfCandidatesMessage'];
	$EncryptedBallot = $_COOKIE['EncryptedBallot'];
	echo "<br> Encrypted Ballot IS: </br>";
	echo $EncryptedBallot;
	echo "<br> Encrypted Candidate IS: </br>";
	echo $EncryptedCandidate;




//try{
		/*		
		
		$db = new PDO("mysql:host=192.168.85.133; dbname=VoteDB", "root", "Eoeg47052695");
		$db -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$db -> exec("SET NAMES 'utf8'");
		
		$results = $db -> prepare("SELECT name, cid
									FROM Candidate
									WHERE company = ?");
									
		$results -> bindParam(1, $companyCandidates);
		$results -> execute();		
		
		
		
		
		
		
		
		
	}
	catch(Exception $e){
		echo "not Working";
	}
	
	
	if(isset($_POST['submit'])){
		
		$placedVotes = $_POST['Elect'];
		
		try{
			foreach($placedVotes as $checkedVotes){
				$sql = "INSERT INTO Votes(cwid, cid)
					VALUES('" . $voterCWID ."','" . $checkedVotes . "')";
			
			$db -> exec($sql);
			}
			header('location: ThankYou.php');
		}
		catch(Exception $e){
			echo "not Working";
		}
	}
*/
	

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
	<script type="text/javascript" src="jshash-2.2/md5-min.js"></script>

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
document.write("<br> Hi </br>");

var EncryptedBallot= '<?php echo $EncryptedBallot ?>';
var EncryptedCandidate= '<?php echo $EncryptedCandidate ?>';


//fix the cookie method
EncryptedBallot=EncryptedBallot.replace(/\s+/g, '+');
EncryptedCandidate=EncryptedCandidate.replace(/\s+/g, '+');

//print tests
document.write ("<br><b> Encrypted Ballot IS: </b> </br>");
document.write(EncryptedBallot);
document.write("<br><b> Encrypted Candidate IS: </b> </br>");
document.write(EncryptedCandidate);


//decrypt the list of candidates


//decrypt the Vote

var PassPhrase="reportingkey";
var Bits= 512;

//create the server rsa keys
var ReportingServerKey=cryptico.generateRSAKey("reportingkey", Bits);
var ReportingServerPublicKey=cryptico.publicKeyString(ReportingServerKey);
//document.write(ReportingServerKey);


var DecryptVoteInfo = cryptico.decrypt(EncryptedBallot, ReportingServerKey);

document.write("<br><b> Encrypted Vote Message Is </b> </br> ");
document.write(DecryptVoteInfo.plaintext);
//get the data and store it
var key=DecryptVoteInfo.plaintext;
var keys = key.split(" ");

var SessionKey= keys[0];
var VoteEncryption= keys[1];
var TimeStamp = keys[2];
var ClientPublicKey= keys[3];
var randomNumber = keys[4];
var hash = keys[5];

var m= SessionKey + " " + VoteEncryption + " " +TimeStamp + " " + ClientPublicKey + " " + randomNumber;

var hash2 = hex_md5(m);

document.write("<br><b> THIS IS THE VOTE ENCRYPTION </b></br>");
document.write(VoteEncryption);
//create the session key

document.write("<br><b> THIS IS THE SESSION KEY </b> </br>");
document.write(SessionKey);
document.write("<br><b> THIS IS THE Vote Encryption KEY </b></br>");
document.write(VoteEncryption);
document.write("<br><b> THIS IS THE TimeStamp KEY </b></br>");
document.write(TimeStamp);
document.write("<br><b> THIS IS THE ClientPublicKey KEY </b></br>");
document.write(ClientPublicKey);
document.write("<br><b> THIS IS THE randomNumber KEY</b> </br>");
document.write(randomNumber);
document.write("<br> <b>THIS IS THE Hash Sent</b> </br>");
document.write(hash);
document.write("<br> <b>THIS IS THE Second Hash Sent</b> </br>");
document.write(hash2);

if(hash===hash2){
document.write("<br><b> The Intergrity of the vote was not compromised</b></br>");
}
else
document.write("<br><b> The Vote was compromised, Please try again</b></br>");


var sessionkey=cryptico.generateRSAKey(SessionKey, Bits);
var SessionKeyPublicKey=cryptico.publicKeyString(sessionkey);

var DecryptVoteWithSessionKey= cryptico.decrypt(VoteEncryption, sessionkey);
document.write("<br><b> This is the Vote Congratulations </b></br>");
document.write(DecryptVoteWithSessionKey.plaintext);




</script>




<div id="main"><!-- open main div -->
<div id="header"><!-- open header div -->
<h1>Citadel Election</h1>
<img src="knobsign.jpg" alt="KobView" style="width:935px;height:350px;">
</div><!-- close header div -->
<form id = "form1" name = "form1" action=" ">
<p>Thank you for your vote</p>

</form>

</div><!-- close main div -->
</body>
</html>


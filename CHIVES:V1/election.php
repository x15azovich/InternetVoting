<?php
	session_start();
	$companyCandidates = $_SESSION['candidateCompany'];
	$companyPick = $_SESSION['companyName'];
	$voterCWID = $_SESSION['companyCWID'];
	$EncryptedMessage= $_COOKIE['PublicEncryption'];
	echo $EncryptedMessage;
	$Candidates= "Zovich FaYED Gibson Not Zovich";
/*
if (isset ($_SESSION['counter'] )){
		$_SESSION['counter'] += 1;
	header ('location: index.php');
		}
	else {
		$_SESSION['counter'] = 1;
	}

*/
	try{
				
		
		$db = new PDO("mysql:host=127.0.0.1; dbname=VoteDB", "root", "Eoeg47052695");
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

        function print(string)
        {
            document.write(string + "\n\n");
        }



var PassPhrase="Zovich";
var Bits= 512;
var message = '<?php echo $EncryptedMessage;?>';
print("<br> The new Message is </br>");
print("<br></br>");
print(message);
print("<br></br>");

//since cookie is an asshole and replaces a + with a space, use this to fix
message=message.replace(/\s+/g, '+');

print("<br></br>");
print("<br></br>");

print("New Message Edit");
print("<br></br>");

print(message);


//create the keys to decrypt the message
var ServerRSAKey= cryptico.generateRSAKey(PassPhrase, Bits);


//decrypt the message with the server keys.
print("Works");
var DecryptionMessage= cryptico.decrypt(message, ServerRSAKey);
print("<br></br>");
print("<br> The decrypted message: </br> ");
        print(DecryptionMessage.plaintext);


//encrypt the candidate list with the client public key. 
var key=DecryptionMessage.plaintext;
var ListOfCandidates = '<?php echo $Candidates; ?>';
var keys = key.split(" ");
//store public key of client and the random number
var ClientPublicKey = keys[0];
var randomNumber=keys[1];
print("<br></br>");
print(keys[1]);
print("<br></br>");
//establish variables for encryption

var PassPhrase= "reportingkey";
var Bits =512;

//create reporting server public key
var ReportingServerKey=cryptico.generateRSAKey("reportingkey", Bits);
var ReportingServerPublicKey=cryptico.publicKeyString(ReportingServerKey);
print("<br>Reporting Server Public Key</br>");
print(ReportingServerPublicKey);
print("<br></br>");

//data
var PlainText = ReportingServerPublicKey +" " +  randomNumber + " " + ListOfCandidates;
print("<br>Message Being Sent</br>");
print(PlainText);
print("<br></br>");

//encrypt data with cleints public key
var EncryptedMessage=cryptico.encrypt(PlainText, ClientPublicKey);
print("<br> The Encrypted Message Back is : </br>");
print(EncryptedMessage.cipher);
print("<br></br>");
//store the message as a cookie to send to the thankyou page
document.cookie="ListOfCandidatesMessage="+EncryptedMessage.cipher;












</script>














<body>
<div id="main"><!-- open main div -->
<div id="header"><!-- open header div -->
<h1>Citadel Election</h1>
<img src="knobsign.jpg" alt="KobView" style="width:935px;height:350px;">
<h3><?php echo $companyPick; ?></h3>
</div><!-- close header div -->
<form id = "form1" name = "form1" action="election.php" method="POST">
<p>Please Select Your Candidate. By selecting submit you agree that you are a Freshman, Sophomore, or Junior cadet. *Official Statement*</p>
<!--<input type="checkbox" id = "Elect1" name="Elect1" onClick= "return KeepCount()">Smith Gaddy-->
<?php

	$count = 0;
	while($row = $results -> fetch(PDO::FETCH_ASSOC)){
		$count++;
		$nameID = 'Elect' . $count;
		$checkboxName = 'Elect[]';
		
		$displayCandidate = '<input type="checkbox" id="' . $nameID . '"
			name="' . $checkboxName . '" value="' . $row[cid] . '" ><label for="' . $nameID . '" >'
				. $row[name] . '</label>';
				
		echo $displayCandidate;	
		echo '&nbsp;';

	}
?>
<br>
<br><input type="submit" value="submit" id="submit" onClick = "return KeepCount()" name="submit">
</br>
</br>
</form>



<script language = "javascript">

function KeepCount(){
var it = "<?php echo $count ?>";
var CandidateID= "";
var x=0;
var inputs = document.getElementsByTagName('input'); 


//document.write("outside");
checked=0;

var count=1;
var i;

do{
i = "Elect" +count;
if(document.form1[i].checked){
	checked = checked +1;
}
//get the ID of the candidates chosen
if(inputs[i].type == 'checkbox' && inputs[i].checked) {
CandidateID += (inputs[i].value + " ")
}
count ++;
x=x+1;



}

while( count <= it);
if(checked>2){
alert('Please Just Pick 2');
document.form1; return false;
}
if(checked<2){
alert('Please Pick 2');
document.form1; return false;
}
//bits

var Bits=512;

//get timestamp
var TimeStamp= Date.now();



//get session key

var SessionKey= Math.random().toString(36).substr(2, 9);
//document.write(SessionKey);


//encrypt vote with session key

var SendVoteKey = cryptico.generateRSAKey(SessionKey, Bits);
//document.write(SendVoteKey);
var SendVoteEncryptionKey= cryptico.publicKeyString(SendVoteKey);
//document.write(SendVoteEncryptionKey);
var VotePlainText= CandidateID;
//document.write(CandidateID);
var VoteEncryption= cryptico.encrypt(VotePlainText, SendVoteEncryptionKey);
//document.write(VoteEncryption.cipher);
var encryptedVote=VoteEncryption.cipher;

//data to be sent

//document.write("<br> CLEINT PUBLIC KEY</br>");
//document.write(ClientPublicKey);


//store message as m
var m = SessionKey + " " + encryptedVote + " " + TimeStamp+ " " + ClientPublicKey+ " " + randomNumber;

//create an md5 hash of message
var hash = hex_md5(m);


//send ecryption and hash
var SendInfoPlaintext= (m + " " + hash) ; 
//encrypt with the public key of the reporting server (from uptop) 

var EncryptedBallot= cryptico.encrypt(SendInfoPlaintext, ReportingServerPublicKey);
//document.write("<br> ENCRYPTED BALLOT </br>");
//document.write(EncryptedBallot.cipher);

//send the encrypted ballot to the reporting server

document.cookie="EncryptedBallot="+EncryptedBallot.cipher;

//document.write("<br> ENCRYPTION BALLOT </br>");
//document.write(EncryptedBallot.cipher);
}




</script>

<!--
<script>
/*var checked=0;
var NumberOfCandidates= "<?php echo $count ?>";
var NumberOfCandidatesInteger= Number(NumberOfCandidates);
document.write(NumberOfCandidatesInteger);
var ElectId;
var i=1;
var ElectId= "Elect1";
var ElectId2= "Elect2";
if(document.form1[ElectId].checked){
	checked = checked +1;
}*/

Elect1=0;
Elect2=0;
Elect3=0;
Elect4=0;
document.getElementById("form1").onsubmit=function() {
if(document.getElementById("Elect1").checked){
	Elect1 = Elect1 +1;
	document.getElementById("grade").innerHTML = Elect1;
}

	
if(document.getElementById("Elect2").checked){
	Elect2 = Elect2 +1;
	document.getElementById("grade2").innerHTML = Elect2;

}
if(document.getElementById("Elect3").checked){
	Elect3 = Elect3 +1;
	document.getElementById("grade3").innerHTML = Elect3;

}
if(document.getElementById("Elect4").checked){
	Elect4 = Elect4 +1;
	document.getElementById("grade4").innerHTML = Elect4;

}

window.location="ThankYou.html";
return false;
/*
	    Elect1 = parseInt(document.querySelector('input[name = "Elect1"]:checked').value);
	    if (Elect1 == 1){
	    result1 += 1;
	document.getElementById("grade").innerHTML = result1;

	    //from here redirect to complete screen
	   }
	    if (Elect1 == 2){
	    result2 += 1;
	    //from here redirect to complete screen
	    document.getElementById("grade2").innerHTML = result2;

	   }
	   if (Elect1 == 3){
	    result3 += 1;
	    //from here redirect to complete screen
	    document.getElementById("grade3").innerHTML = result3;

	   }
	   if (Elect1 == 4){
	    result4 += 1;
	    //from here redirect to complete screen
	    document.getElementById("grade4").innerHTML = result4;

	   }
*/
} //this ends the submit function

</script>
-->
</div><!-- close main div -->
</body>
</html>

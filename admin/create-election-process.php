<?php
include '../unitelections-info.php';

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error);
}


if (isset($_POST['unitNumber'])) {
	$unitNumber = $_POST['unitNumber'];
} else {
	$unitNumber = "";
}
if (isset($_POST['unitCommunity'])) {
	$unitCommunity = $_POST['unitCommunity'];
} else {
	$unitCommunity = "";
}
if (isset($_POST['numRegisteredYouth'])) {
	$numRegisteredYouth = $_POST['numRegisteredYouth'];
} else {
	$numRegisteredYouth = "";
}
if (isset($_POST['dateOfElection'])) {
	$dateOfElection = $_POST['dateOfElection'];
} else {
	$dateOfElection = "";
}
if (isset($_POST['chapter'])) {
	$chapter = $_POST['chapter'];
} else {
	$chapter = "";
}

if (isset($_POST['sm_name'])) {
	$sm_name = $_POST['sm_name'];
} else {
	$sm_name = "";
}
if (isset($_POST['sm_address_line1'])) {
	$sm_address_line1 = $_POST['sm_address_line1'];
} else {
	$sm_address_line1 = "";
}
if (isset($_POST['sm_address_line2'])) {
	$sm_address_line2 = $_POST['sm_address_line2'];
} else {
	$sm_address_line2 = "";
}
if (isset($_POST['sm_city'])) {
	$sm_city = $_POST['sm_city'];
} else {
	$sm_city = "";
}
if (isset($_POST['sm_state'])) {
	$sm_state = $_POST['sm_state'];
} else {
	$sm_state = "";
}
if (isset($_POST['sm_zip'])) {
	$sm_zip = $_POST['sm_zip'];
} else {
	$sm_zip = "";
}
if (isset($_POST['sm_email'])) {
	$sm_email = $_POST['sm_email'];
} else {
	$sm_email = "";
}
if (isset($_POST['sm_phone'])) {
	$sm_phone = $_POST['sm_phone'];
} else {
	$sm_phone = "";
}


$createElection = $conn->prepare("INSERT INTO unitElections(unitNumber, unitCommunity, chapter, sm_name, sm_address_line1, sm_address_line2, sm_city, sm_state, sm_zip, sm_email, sm_phone, numRegisteredYouth, dateOfElection) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?)");
$createElection->bind_param("sssssssssssss", $unitNumber, $unitCommunity, ucfirst($chapter), $sm_name, $sm_address_line1, $sm_address_line2, $sm_city, $sm_state, $sm_zip, $sm_email, $sm_phone, $numRegisteredYouth, $dateOfElection);
$createElection->execute();
$createElection->close();


include '../unitelections-info.php';
require '../vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

$conn2 = new mysqli($servername, $username, $password, $dbname);
$getUnitElectionsQuery = $conn2->prepare("SELECT * from unitElections ORDER BY id DESC LIMIT 1");
$getUnitElectionsQuery->execute();
$getUnitElectionsQ = $getUnitElectionsQuery->get_result();
$getUnitElections = $getUnitElectionsQ->fetch_assoc();

$mail = new PHPMailer(true);
$mail->IsSMTP();        //Sets Mailer to send message using SMTP
$mail->Host = $host;  //Sets the SMTP hosts
$mail->Port = $port;        //Sets the default SMTP server port
$mail->SMTPAuth = true;       //Sets SMTP authentication. Utilizes the Username and Password variables
$mail->Username = $musername;     //Sets SMTP username
$mail->Password = $mpassword;     //Sets SMTP password
$mail->SMTPSecure = 'tls';       //Sets connection prefix. Options are "", "ssl" or "tls"
$mail->From = $mfrom;     //Sets the From email address for the message
$mail->FromName = $mfromname;    //Sets the From name of the message
$mail->AddAddress($sm_email); //Adds a "To" address
$mail->WordWrap = 50;       //Sets word wrapping on the body of the message to a given number of characters
$mail->IsHTML(true);       //Sets message type to HTML    
$mail->Subject = 'Time to Submit Adult Nominations for the Order of the Arrow';    //Sets the Subject of the message
$mail->Body = '<table cellspacing="0" cellpadding="0" border="0" width="600px" style="margin:auto">
									  <tbody>
										<tr>
										  <td style="text-align:center;padding:10px 0 20px 0"><a href="%%7Brecipient.ticket_link%7D" target="_blank"> <img src="https://lodge104.net/wp-content/uploads/2018/09/Horizontal-Brand-Color.png" alt="Occonechee Lodge Support" width="419" height="69" data-image="xoo68adcoon5"></a></td>
										</tr>
										<tr>
										  <td><table cellspacing="0" cellpadding="0" border="0" width="100%">
											  <tbody>
												<tr>
												  <td style="text-align:center;color:#ffffff;background-color:#2d3e4f;padding:8px 0;font-size:13px"> Occoneechee Lodge Unit Elections </td>
												</tr>
												<tr>
												  <td style="text-align:left;border:1px solid #2d3e4f;padding:10px 30px;background-color:#fefefe;line-height:18px;color:#2d3e4f;font-size:13px"> 
													<table width="100%" cellpadding="0" cellspacing="0" border="0">
													  <tbody>
														<tr>
														  <td style="padding:15px 0; width:100%"><table width="100%" cellpadding="0" cellspacing="0" border="0" style="table-layout:fixed">
															  <tbody>
																<tr>
																  <td style="width:100%" valign="top">
																	<br>
																	Dear ' . $getUnitElections['sm_name'] . ',<br>
                                  <br>
                                  Your unit has sucessfully completed the unit election.
                                  <br>
                                  As part of the election process, you, as the unit leader, may now submit adult nominations for membership in the Order of the Arrow. Please click the link below to access the Unit Leader dashboard for your unit and begin working on your adult nominations.<br>
                                  <br>
                                  <b>This link is only for the unit leader.</b> After you submit your nomination(s), your unit chair will receive a seperate invitation to review the nominations on behalf of your unit committee.
																	</td>
																</tr>
															  </tbody>
															  <tbody>
																<tr>
																  <td style="width:100%;text-align:center">
																  <a href="https://nominate.lodge104.net/unitleader/?accessKey=' . $getUnitElections['accessKey'] . '" target="_blank">
																  <p>https://nominate.lodge104.net/unitleader/?accessKey=' . $getUnitElections['accessKey'] . '</p>
																  </a>
																  </td>
																</tr>
															  </tbody>
															</table></td>
														</tr>
													  </tbody>
													</table></td>
												</tr>
											  </tbody>
											</table></td>
										</tr>
									  </tbody>
									</table>';   //An HTML or plain text message body
$mail->Send();        //Send an Email. Return true on success or false on error

include '../unitelections-info.php';
require '../vendor/autoload.php';

use Twilio\Rest\Client;

$sid = $sidp;
$token = $tokenp;
$client = new Client($sid, $token);
$phone = preg_replace('/\D+/', '', $sm_phone);

// Use the client to do fun stuff like send text messages!
$client->messages->create(
    // the number you'd like to send the message to
    '+1'. $phone .'',
    [
        // A Twilio phone number you purchased at twilio.com/console
        'from' => '+19842050909',
        // the body of the text message you'd like to send
        'body' => 'Hi ' . $sm_name . '! Its time to submit your unit\'s adult nominations to the Order of the Arrow. See the email we just sent to ' . $sm_email . ' to get started! Check your spam folder it\'s not in your inbox.'
    ]
);


	header("Location: index.php?status=1");

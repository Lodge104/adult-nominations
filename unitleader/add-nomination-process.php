<?php
include '../unitelections-info.php';
require '../vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;


$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


if (isset($_POST['unitId'])) { $unitId = $_POST['unitId']; } else { die("No unit id."); }
if (isset($_POST['accessKey'])) { $accessKey = $_POST['accessKey']; } else { die("No unit key."); }
if (isset($_POST['unitCommunity'])) {  $unitCommunity = $_POST['unitCommunity']; } else { $unitCommunity = ""; }
if (isset($_POST['unitNumber'])) {  $unitNumber = $_POST['unitNumber']; } else { $unitNumber = ""; }
if (isset($_POST['firstName'])) {  $firstName = $_POST['firstName']; } else { $firstName = ""; }
if (isset($_POST['lastName'])) {  $lastName = $_POST['lastName']; } else { $lastName = ""; }
if (isset($_POST['address_line1'])) {  $address_line1 = $_POST['address_line1']; } else { $address_line1 = ""; }
if (isset($_POST['address_line2'])) {  $address_line2 = $_POST['address_line2']; } else { $address_line2 = ""; }
if (isset($_POST['city'])) {  $city = $_POST['city']; } else { $city = ""; }
if (isset($_POST['state'])) {  $state = $_POST['state']; } else { $state = ""; }
if (isset($_POST['zip'])) {  $zip = $_POST['zip']; } else { $zip = ""; }
if (isset($_POST['email'])) {  $email = $_POST['email']; } else { $email = ""; }
if (isset($_POST['phone'])) {  $phone = $_POST['phone']; } else { $phone = ""; }
if (isset($_POST['position'])) {  $position = $_POST['position']; } else { $position = ""; }
if (isset($_POST['bsa_id'])) {  $bsa_id = $_POST['bsa_id']; } else { $bsa_id = ""; }
if (isset($_POST['dob'])) {  $dob = $_POST['dob']; } else { $dob = ""; }
if (isset($_POST['years_adult'])) {  $years_adult = $_POST['years_adult']; } else { $years_adult = ""; }

if (isset($_POST['training'])) {  $training = $_POST['training']; } else { $training = ""; }
if (isset($_POST['position_held'])) {  $position_held = $_POST['position_held']; } else { $position_held = ""; }
if (isset($_POST['youth_rank'])) {  $youth_rank = $_POST['youth_rank']; } else { $youth_rank = ""; }
if (isset($_POST['community_activities'])) {  $community_activities = $_POST['community_activities']; } else { $community_activities = ""; }
if (isset($_POST['employment'])) {  $employment = $_POST['employment']; } else { $employment = ""; }
if (isset($_POST['short_term'])) {  $short_term = $_POST['short_term']; } else { $short_term = ""; }
if (isset($_POST['long_term'])) {  $long_term = $_POST['long_term']; } else { $long_term = ""; }
if (isset($_POST['abilities'])) {  $abilities = $_POST['abilities']; } else { $abilities = ""; }
if (isset($_POST['purpose'])) {  $purpose = $_POST['purpose']; } else { $purpose = ""; }
if (isset($_POST['role_modal'])) {  $role_modal = $_POST['role_modal']; } else { $role_modal = ""; }
if (isset($_POST['leader_signature'])) {  $leader_signature = "1"; } else { $leader_signature = "1"; }


if (isset($_POST['uc_name'])) {  $uc_name = $_POST['uc_name']; } else { $uc_name = ""; }
if (isset($_POST['uc_address_line1'])) {  $uc_address_line1 = $_POST['uc_address_line1']; } else { $uc_address_line1 = ""; }
if (isset($_POST['uc_address_line2'])) {  $uc_address_line2 = $_POST['uc_address_line2']; } else { $uc_address_line2 = ""; }
if (isset($_POST['uc_city'])) {  $uc_city = $_POST['uc_city']; } else { $uc_city = ""; }
if (isset($_POST['uc_state'])) {  $uc_state = $_POST['uc_state']; } else { $uc_state = ""; }
if (isset($_POST['uc_zip'])) {  $uc_zip = $_POST['uc_zip']; } else { $uc_zip = ""; }
if (isset($_POST['sm_email'])) {  $sm_email = $_POST['sm_email']; } else { $sm_email = ""; }
if (isset($_POST['uc_email'])) {  $uc_email = $_POST['uc_email']; } else { $uc_email = ""; }
if (isset($_POST['uc_phone'])) {  $uc_phone = $_POST['uc_phone']; } else { $uc_phone = ""; }




$createAdult = $conn->prepare("INSERT INTO adultNominations(unitId, firstName, lastName, address_line1, address_line2, city, state, zip, email, phone, position, bsa_id, dob, years_adult, training, position_held, youth_rank, community_activities, employment, short_term, long_term, abilities, purpose, role_modal, leader_signature, leader_email, chair_email) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
$createAdult->bind_param("sssssssssssssssssssssssssss", $unitId, $firstName, $lastName, $address_line1, $address_line2, $city, $state, $zip, $email, $phone, $position, $bsa_id, $dob, $years_adult, $training, $position_held, $youth_rank, $community_activities, $employment, $short_term, $long_term, $abilities, $purpose, $role_modal, $leader_signature, $sm_email, $uc_email);
$createAdult->execute();
$createAdult->close();

$updateElection = $conn->prepare("UPDATE unitElections SET uc_name=?,uc_address_line1=?,uc_address_line2=?,uc_city=?,uc_state=?,uc_zip=?,uc_email=?,uc_phone=? WHERE id = ?");
$updateElection->bind_param("sssssssss", $uc_name, $uc_address_line1, $uc_address_line2, $uc_city, $uc_state, $uc_zip, $uc_email, $uc_phone, $unitId);
$updateElection->execute();
$updateElection->close();


include '../unitelections-info.php';
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
  $mail->AddAddress($uc_email);//Adds a "To" address
  $mail->WordWrap = 50;       //Sets word wrapping on the body of the message to a given number of characters
  $mail->IsHTML(true);       //Sets message type to HTML    
  $mail->Subject = 'Please review OA Adult Nomination for ' . $firstName . ' ' . $lastName;    //Sets the Subject of the message
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
                                Dear '.$uc_name.',<br>
                                <br>
                                The unit leader, from '.$unitCommunity.' '.$unitNumber.' has submitted an Adult Nomination for consideration of candidacy in the Order of the Arrow. This nomination is for '.$firstName.' '.$lastName.'. Before the nomination can be reviewed by the Lodge Selection Committee it must be independently reviewed and approved by the Unit Chair. Please click the link below to access the Unit Chair dashboard for your unit and review the nomination.<br>
                                <br>
								Additional nominations may be submitted and will be viewable on the same link.
								</td>
                            </tr>
                          </tbody>
                          <tbody>
                            <tr>
                              <td style="width:100%;text-align:center">
							  <a href="https://nominate.lodge104.net/unitchair/?accessKey=' . $accessKey . '" target="_blank">
							  <p>https://nominate.lodge104.net/unitchair/?accessKey=' . $accessKey . '</p>
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
  if($mail->Send())        //Send an Email. Return true on success or false on error


header("Location: index.php?accessKey=" . $accessKey . "&status=2");

?>
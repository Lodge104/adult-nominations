<?php
include '../unitelections-info.php';

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


if (isset($_POST['unitId'])) { $unitId = $_POST['unitId']; } else { die("No unit id."); }
if (isset($_POST['accessKey'])) { $accessKey = $_POST['accessKey']; } else { die("No unit key."); }
if (isset($_POST['sm_email'])) {  $leader_email = $_POST['sm_email']; } else { $leader_email = ""; }
if (isset($_POST['uc_email'])) {  $chair_email = $_POST['uc_email']; } else { $chair_email = ""; }
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
if (isset($_POST['chair_signature'])) {  $chair_signature = "1"; } else { $chair_signature = "1"; }




$createAdult = $conn->prepare("UPDATE adultNominations SET training=?,position_held=?,youth_rank=?,community_activities=?,employment=?,short_term=?,long_term=?,abilities=?,purpose=?,role_modal=?,chair_signature=? WHERE id = ?");
$createAdult->bind_param("ssssssssssss", $training, $position_held, $youth_rank, $community_activities, $employment, $short_term, $long_term, $abilities, $purpose, $role_modal, $chair_signature, $unitId);
$createAdult->execute();
$createAdult->close();



require '../vendor/phpmailer/phpmailer/PHPMailerAutoload.php';
include '../unitelections-info.php';
  $mail = new PHPMailer;
  $mail->IsSMTP();        //Sets Mailer to send message using SMTP
  $mail->Host = $host;  //Sets the SMTP hosts
  $mail->Port = $port;        //Sets the default SMTP server port
  $mail->SMTPAuth = true;       //Sets SMTP authentication. Utilizes the Username and Password variables
  $mail->Username = $musername;     //Sets SMTP username
  $mail->Password = $mpassword;     //Sets SMTP password
  $mail->SMTPSecure = 'tls';       //Sets connection prefix. Options are "", "ssl" or "tls"
  $mail->From = $mfrom;     //Sets the From email address for the message
  $mail->FromName = $mfromname;    //Sets the From name of the message
  $mail->AddAddress($chair_email);//Adds a "To" address
  $mail->AddAddress($leader_email);//Adds a "To" address
  $mail->AddBCC('admin@lodge104.com');//Adds a "To" address
  $mail->AddReplyTo($leader_email);//Adds a "To" address
  $mail->IsHTML(true);       //Sets message type to HTML    
  $mail->Subject = 'OA Adult Nomination Update for ' . $firstName . ' ' . $lastName;    //Sets the Subject of the message
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
                                Dear Unit Leader and Unit Chair,<br>
                                <br>
                                The adult nomination for '.$firstName.' '.$lastName.' has been fully submitted to the Lodge Selection Committee. Please expect a response within 15 business days. If approved, the nominee will be able to register for their Ordeal event with us.<br>
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


header("Location: index.php?status=1");

?>
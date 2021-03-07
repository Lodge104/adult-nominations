<?php
include '../unitelections-info.php';
require '../vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
use Twilio\Rest\Client;



// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

?>


<!DOCTYPE html>
<html>
<?php

$userInfo = $auth0->getUser();

if (!$userInfo) : ?>

  <head>
    <meta http-equiv=X-UA-Compatible content="IE=Edge,chrome=1" />
    <meta name=viewport content="width=device-width,initial-scale=1.0,maximum-scale=1.0" />

    <title>Adult Nomination Portal | Occoneechee Lodge - Order of the Arrow, BSA</title>

    <link rel="stylesheet" href="../libraries/bootstrap-4.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="../libraries/fontawesome-free-5.12.0/css/all.min.css">
    <link rel="stylesheet" href="https://use.typekit.net/awb5aoh.css" media="all">
    <link rel="stylesheet" href="../style.css">


  </head>

  <?php include "../header.php"; ?>

  <body class="d-flex flex-column h-100" id="section-conclave-report-form" data-spy="scroll" data-target="#scroll" data-offset="0">
    <div class="wrapper">
      <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="https://lodge104.net">
          <img src="/assets/lodge-logo.png" alt="Occoneechee Lodge" class="d-inline-block align-top">
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar-main">
          <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse c-navbar-content" id="navbar-main">
          <div class="navbar-nav ml-auto">
            <a class="nav-item nav-link" href="https://lodge104.net" target="_blank">Occoneechee Lodge Home</a>
          </div>
        </div>
      </nav>

      <main class="container-fluid flex-shrink-0">

        <div class="wrapper">

          <main class="container-fluid col-xl-11">
            <?php
            if ($_GET['error'] == 'unauthorized') { ?>
              <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
              <div class="alert alert-danger" role="alert">
                <strong>Error!</strong> You do not have the required role to access the Nomination Portal!
                <button type="button" class="close" data-dismiss="alert"><i class="fas fa-times"></i></button>
              </div>
            <?php } ?>
            <div class="row justify-content-center">
              <div class="card col-md-11">
                <div class="card-body">
                  <h3 class="form-signin-heading text-center">Administrator Login</h3>
                  <a role="button" class="btn btn-lg btn-primary btn-block" href="/login.php">Login</a>
                </div>
              </div>
            </div>

        </div>
    </div>
    </div>
    </main>


  <?php else : ?>

    <head>
      <meta http-equiv=X-UA-Compatible content="IE=Edge,chrome=1" />
      <meta name=viewport content="width=device-width,initial-scale=1.0,maximum-scale=1.0" />

      <title>Edit Unit Election | Occoneechee Lodge - Order of the Arrow, BSA</title>

      <link rel="stylesheet" href="../libraries/bootstrap-4.4.1/css/bootstrap.min.css">
      <link rel="stylesheet" href="../libraries/fontawesome-free-5.12.0/css/all.min.css">
      <link rel="stylesheet" href="https://use.typekit.net/awb5aoh.css" media="all">
      <link rel="stylesheet" href="../style.css">
    </head>

    <?php include "../header.php"; ?>

    <body class="dashboard d-flex flex-column h-100" id="section-conclave-report-form" data-spy="scroll" data-target="#scroll" data-offset="0">
      <div class="wrapper">
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
          <a class="navbar-brand" href="https://lodge104.net">
            <img src="/assets/lodge-logo.png" alt="Occoneechee Lodge" class="d-inline-block align-top">
          </a>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar-main">
            <span class="navbar-toggler-icon"></span>
          </button>

          <div class="collapse navbar-collapse c-navbar-content" id="navbar-main">
            <div class="navbar-nav ml-auto">
              <a class="nav-item nav-link" href="https://lodge104.net" target="_blank">Occoneechee Lodge Home</a>
            </div>
          </div>
        </nav>
        <main class="container-fluid">

          <?php
          if (isset($_GET['accessKey'])) {
            if (preg_match("/^([a-z\d]){8}-([a-z\d]){4}-([a-z\d]){4}-([a-z\d]){4}-([a-z\d]){12}$/", $_GET['accessKey'])) {
              $accessKey = $_POST['accessKey'] = $_GET['accessKey'];
          ?>
              <section class="row">
                <div class="col-12">
                  <h2>Unit Election Administration</h2>
                </div>
              </section>
              <?php
              $getUnitElectionsQuery = $conn->prepare("SELECT * from unitElections where accessKey = ?");
              $getUnitElectionsQuery->bind_param("s", $accessKey);
              $getUnitElectionsQuery->execute();
              $getUnitElectionsQ = $getUnitElectionsQuery->get_result();
              if ($getUnitElectionsQ->num_rows > 0) {
                //print election info
              ?>
                <div class="card mb-3">
                  <div class="card-body">
                    <h3 class="card-title d-inline-flex">Edit Unit Election Information</h3>
                    <?php $getUnitElections = $getUnitElectionsQ->fetch_assoc(); ?>

                    <?php
                    if (isset($_POST['button1'])) {

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
                      $mail->AddAddress($getUnitElections['sm_email']); //Adds a "To" address
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
                      if ($mail->Send()) {        //Send an Email. Return true on success or false on error

                        echo "<script src='https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js'></script>
        <div class='alert alert-success' role='alert'>
            <strong>Sent!</strong> Your email has been sent! Thanks!
            <button type='button' class='close' data-dismiss='alert'><i class='fas fa-times'></i></button>
        </div>"; } else {
          echo "<script src='https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js'></script>
        <div class='alert alert-danger' role='alert'>
            <strong>Error!</strong> Your email didn't send! Check the email address and try again!
            <button type='button' class='close' data-dismiss='alert'><i class='fas fa-times'></i></button>
        </div>";
        }
                      
                      $sid = $sidp;
                      $token = $tokenp;
                      $client = new Client($sid, $token);
                      $phone = preg_replace('/\D+/', '', $getUnitElections['sm_phone']);

                      // Use the client to do fun stuff like send text messages!
                      if ($client->messages->create(
                          // the number you'd like to send the message to
                          '+1'. $phone .'',
                          [
                              // A Twilio phone number you purchased at twilio.com/console
                              'from' => '+19842050909',
                              // the body of the text message you'd like to send
                              'body' => 'Hi ' . $getUnitElections['sm_name'] . '! Its time to submit your unit\'s adult nominations to the Order of the Arrow. See the email we just sent to ' . $getUnitElections['sm_email'] . ' to get started! Check your spam folder it\'s not in your inbox.'
                          ]
                      )) {
                        echo "<script src='https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js'></script>
        <div class='alert alert-success' role='alert'>
            <strong>Sent!</strong> Your text message has been sent! Thanks!
            <button type='button' class='close' data-dismiss='alert'><i class='fas fa-times'></i></button>
        </div>";
                      } else {
                        echo "<script src='https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js'></script>
        <div class='alert alert-danger' role='alert'>
            <strong>Error!</strong> Your text message didn't send! Check the phone number formate and try again!
            <button type='button' class='close' data-dismiss='alert'><i class='fas fa-times'></i></button>
        </div>";
                      }
                    }
                    ?>

<?php
                    if (isset($_POST['button2'])) {

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
                      $mail->AddAddress($getUnitElections['uc_email']); //Adds a "To" address
                      $mail->WordWrap = 50;       //Sets word wrapping on the body of the message to a given number of characters
                      $mail->IsHTML(true);       //Sets message type to HTML    
                      $mail->Subject = 'Review your Unit\'s Adult Nominations for the Order of the Arrow';    //Sets the Subject of the message
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
																	Dear ' . $getUnitElections['uc_name'] . ',<br>
                                  <br>
                                  Your unit leader has recently submitted a nomination for consideration of candidacy in the Order of the Arrow.<br>
                                  <br>
                                  As part of the election process, you, as the unit chair, may now review adult nomination(s) for membership in the Order of the Arrow as the representative of the entire unit committee. This step is required for the nomination to progress. Please click the link below to access the Unit Chair dashboard for your unit and begin reviewing your adult nomination(s).<br>
                                  <br>
                                  <b>This link is only for the unit chair.</b> After you review the nomination(s), the lodge selection committee will receive a notification to review the nominations.
																	</td>
																</tr>
															  </tbody>
															  <tbody>
																<tr>
																  <td style="width:100%;text-align:center">
																  <a href="https://nominate.lodge104.net/unitchair/?accessKey=' . $getUnitElections['accessKey'] . '" target="_blank">
																  <p>https://nominate.lodge104.net/unitchair/?accessKey=' . $getUnitElections['accessKey'] . '</p>
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
                  if ($mail->Send()) {        //Send an Email. Return true on success or false on error

                    echo "<script src='https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js'></script>
    <div class='alert alert-success' role='alert'>
        <strong>Sent!</strong> Your email has been sent! Thanks!
        <button type='button' class='close' data-dismiss='alert'><i class='fas fa-times'></i></button>
    </div>"; } else {
      echo "<script src='https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js'></script>
    <div class='alert alert-danger' role='alert'>
        <strong>Error!</strong> Your email didn't send! Check the email address and try again!
        <button type='button' class='close' data-dismiss='alert'><i class='fas fa-times'></i></button>
    </div>";
    }
                  
                  $sid = $sidp;
                  $token = $tokenp;
                  $client = new Client($sid, $token);
                  $phone = preg_replace('/\D+/', '', $getUnitElections['uc_phone']);

                  // Use the client to do fun stuff like send text messages!
                  if ($client->messages->create(
                      // the number you'd like to send the message to
                      '+1'. $phone .'',
                      [
                          // A Twilio phone number you purchased at twilio.com/console
                          'from' => '+19842050909',
                          // the body of the text message you'd like to send
                          'body' => 'Hi ' . $getUnitElections['uc_name'] . '! Friendly reminder that it\'s time to review your unit\'s Order of the Arrow Adult Nominations. See the email we just sent to ' . $getUnitElections['uc_email'] . ' to get started! Check your spam folder it\'s not in your inbox.'
                      ]
                  )) {
                    echo "<script src='https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js'></script>
    <div class='alert alert-success' role='alert'>
        <strong>Sent!</strong> Your text message has been sent! Thanks!
        <button type='button' class='close' data-dismiss='alert'><i class='fas fa-times'></i></button>
    </div>";
                  } else {
                    echo "<script src='https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js'></script>
    <div class='alert alert-danger' role='alert'>
        <strong>Error!</strong> Your text message didn't send! Check the phone number formate and try again!
        <button type='button' class='close' data-dismiss='alert'><i class='fas fa-times'></i></button>
    </div>";
                  }
                }
                    ?>
                    <form method="post">
                      <?php if(!empty($getUnitElections['sm_email']) && !empty($getUnitElections['sm_name']) && !empty($getUnitElections['sm_phone'])) { ?>
                      <input type="submit" name="button1" value="Resend Invitation Email to Unit Leader" class="btn btn-primary" role="button" />
                      <?php } else { echo "<span class=\"badge bg-warning text-dark\">Unit Leader Incomplete</span>"; } ?>
                      <?php if(!empty($getUnitElections['uc_email']) && !empty($getUnitElections['uc_name']) && !empty($getUnitElections['uc_phone'])) { ?>
                      <input type="submit" name="button2" value="Resend Invitation Email to Unit Chair" class="btn btn-primary" role="button" />
                      <?php } else { echo "<span class=\"badge bg-warning text-dark\">Unit Chair Incomplete</span>"; } ?>
                    </form>
                    <div class="my-2"><small class="text-muted">Note: Double check the email addresses and phone numbers below before hitting either button. If you edit an email or phone number, save the page first before pushing either button.</small></div>

                    <br>

                    <form action="edit-election-process.php" method="post">
                      <input type="hidden" id="unitId" name="unitId" value="<?php echo $getUnitElections['id']; ?>">
                      <input type="hidden" id="accessKey" name="accessKey" value="<?php echo $getUnitElections['accessKey']; ?>">
                      <div class="form-row">
                        <div class="col-md-3">
                          <div class="form-group">
                            <label for="unitNumber" class="required">Unit Number</label>
                            <input id="unitNumber" name="unitNumber" type="number" class="form-control" value="<?php echo $getUnitElections['unitNumber']; ?>" required>
                          </div>
                        </div>
                        <div class="col-md-3">
                          <div class="form-group">
                            <label for="unitCommunity" class="required">Unit Type</label>
                            <select id="unitCommunity" name="unitCommunity" class="custom-select" required>
                              <option></option>
                              <?php $host = $_SERVER['SERVER_NAME'];
                              if($host == 'nominate-test.lodge104.net') : ?>
                              <option value="Test Unit" <?php echo ($getUnitElections['unitCommunity'] == 'Test Unit' ? 'selected' : ''); ?>>Test Unit</option>
                              <?php else : ?>
                              <?php endif ?>
                              <option value="Boy Troop" <?php echo ($getUnitElections['unitCommunity'] == 'Boy Troop' ? 'selected' : ''); ?>>Boy Troop</option>
                              <option value="Girl Troop" <?php echo ($getUnitElections['unitCommunity'] == 'Girl Troop' ? 'selected' : ''); ?>>Girl Troop</option>
                              <option value="Team" <?php echo ($getUnitElections['unitCommunity'] == 'Team' ? 'selected' : ''); ?>>Team</option>
                              <option value="Crew" <?php echo ($getUnitElections['unitCommunity'] == 'Crew' ? 'selected' : ''); ?>>Crew</option>
                              <option value="Ship" <?php echo ($getUnitElections['unitCommunity'] == 'Ship' ? 'selected' : ''); ?>>Ship</option>
                            </select>
                          </div>
                        </div>
                      </div>
                      <div class="form-row">
                        <div class="col-md-3">
                          <div class="form-group">
                            <label for="numRegisteredYouth" class="required"># of Youth Elected</label>
                            <input id="numRegisteredYouth" name="numRegisteredYouth" type="number" class="form-control" value="<?php echo $getUnitElections['numRegisteredYouth']; ?>" required>
                          </div>
                        </div>
                        <div class="col-md-3">
                          <div class="form-group">
                            <label for="dateOfElection" class="required">Date of Unit Election</label>
                            <input id="dateOfElection" name="dateOfElection" type="date" class="form-control" value="<?php echo $getUnitElections['dateOfElection']; ?>" required>
                          </div>
                        </div>
                        <div class="col-md-4">
                          <div class="form-group">
                            <label for="chapter" class="required">Chapter</label>
                            <select id="chapter" name="chapter" class="custom-select" required>
                              <option></option>
                              <option value="eluwak" <?php echo ($getUnitElections['chapter'] == 'Eluwak' ? 'selected' : ''); ?>>Eluwak</option>
                              <option value="ilaumachque" <?php echo ($getUnitElections['chapter'] == 'Ilaumachque' ? 'selected' : ''); ?>>Ilau Machque</option>
                              <option value="kiowa" <?php echo ($getUnitElections['chapter'] == 'Kiowa' ? 'selected' : ''); ?>>Kiowa</option>
                              <option value="lauchsoheen" <?php echo ($getUnitElections['chapter'] == 'Lauchsoheen' ? 'selected' : ''); ?>>Lauchsoheen</option>
                              <option value="mimahuk" <?php echo ($getUnitElections['chapter'] == 'Mimahuk' ? 'selected' : ''); ?>>Mimahuk</option>
                              <option value="netami" <?php echo ($getUnitElections['chapter'] == 'Netami' ? 'selected' : ''); ?>>Netami</option>
                              <option value="netopalis" <?php echo ($getUnitElections['chapter'] == 'Netopalis' ? 'selected' : ''); ?>>Netopalis</option>
                              <option value="neusiok" <?php echo ($getUnitElections['chapter'] == 'Neusiok' ? 'selected' : ''); ?>>Neusiok</option>
                              <option value="saponi" <?php echo ($getUnitElections['chapter'] == 'Saponi' ? 'selected' : ''); ?>>Saponi</option>
                              <option value="temakwe" <?php echo ($getUnitElections['chapter'] == 'Temakwe' ? 'selected' : ''); ?>>Temakwe</option>
                            </select>
                          </div>
                        </div>
                      </div>
                      <hr>
                      </hr>
                      <h4 class="card-title">Unit Leader Information</h4>
                      <div class="form-row">
                        <div class="col-md-3">
                          <div class="form-group">
                            <input id="sm_name" name="sm_name" type="text" class="form-control" placeholder="Name" value="<?php echo $getUnitElections['sm_name']; ?>" required>
                          </div>
                        </div>
                        <div class="col-md-3">
                          <div class="form-group">
                            <input id="sm_address_line1" name="sm_address_line1" type="text" class="form-control" placeholder="Address" value="<?php echo $getUnitElections['sm_address_line1']; ?>">
                          </div>
                          <div class="form-group">
                            <input id="sm_address_line2" name="sm_address_line2" type="text" class="form-control" placeholder="Address Line 2 (optional)" value="<?php echo $getUnitElections['sm_address_line2']; ?>">
                          </div>
                        </div>
                        <div class="col-md-3">
                          <div class="form-group">
                            <input id="sm_city" name="sm_city" type="text" class="form-control" placeholder="City" value="<?php echo $getUnitElections['sm_city']; ?>">
                          </div>
                          <div class="form-row">
                            <div class="col-md-4">
                              <div class="form-group">
                                <input id="sm_state" name="sm_state" type="text" class="form-control" placeholder="State" value="<?php echo $getUnitElections['sm_state']; ?>">
                              </div>
                            </div>
                            <div class="col-md-8">
                              <div class="form-group">
                                <input id="sm_zip" name="sm_zip" type="text" class="form-control" placeholder="Zip" value="<?php echo $getUnitElections['sm_zip']; ?>">
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="col-md-3">
                          <div class="form-group">
                            <input id="sm_email" name="sm_email" type="email" class="form-control" placeholder="Email" value="<?php echo $getUnitElections['sm_email']; ?>" required>
                          </div>
                          <div class="form-group">
                            <input id="sm_phone" name="sm_phone" type="text" class="form-control" placeholder="Phone (###-###-####)" pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}" value="<?php echo $getUnitElections['sm_phone']; ?>" required>
                          </div>
                        </div>
                      </div>
                      <hr>
                      </hr>
                      <h4 class="card-title">Unit Chair Information</h4>
                      <div class="form-row">
                        <div class="col-md-3">
                          <div class="form-group">
                            <input id="uc_name" name="uc_name" type="text" class="form-control" placeholder="Name" value="<?php echo $getUnitElections['uc_name']; ?>">
                          </div>
                        </div>
                        <div class="col-md-3">
                          <div class="form-group">
                            <input id="uc_address_line1" name="uc_address_line1" type="text" class="form-control" placeholder="Address" value="<?php echo $getUnitElections['uc_address_line1']; ?>">
                          </div>
                          <div class="form-group">
                            <input id="uc_address_line2" name="uc_address_line2" type="text" class="form-control" placeholder="Address Line 2 (optional)" value="<?php echo $getUnitElections['uc_address_line2']; ?>">
                          </div>
                        </div>
                        <div class="col-md-3">
                          <div class="form-group">
                            <input id="uc_city" name="uc_city" type="text" class="form-control" placeholder="City" value="<?php echo $getUnitElections['uc_city']; ?>">
                          </div>
                          <div class="form-row">
                            <div class="col-md-4">
                              <div class="form-group">
                                <input id="uc_state" name="uc_state" type="text" class="form-control" placeholder="State" value="<?php echo $getUnitElections['uc_state']; ?>">
                              </div>
                            </div>
                            <div class="col-md-8">
                              <div class="form-group">
                                <input id="uc_zip" name="uc_zip" type="text" class="form-control" placeholder="Zip" value="<?php echo $getUnitElections['uc_zip']; ?>">
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="col-md-3">
                          <div class="form-group">
                            <input id="uc_email" name="uc_email" type="email" class="form-control" placeholder="Email" value="<?php echo $getUnitElections['uc_email']; ?>">
                          </div>
                          <div class="form-group">
                            <input id="uc_phone" name="uc_phone" type="text" class="form-control" placeholder="Phone (###-###-####)" pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}" value="<?php echo $getUnitElections['uc_phone']; ?>">
                          </div>
                        </div>
                      </div>
                      <a href="index.php" class="btn btn-secondary">Cancel</a>
                      <input type="submit" class="btn btn-primary" value="Save">
                    </form>
                  </div>
                </div>
              <?php
              } else {
              ?>
                <div class="alert alert-danger" role="alert">
                  There are no elections in the database.
                </div>
              <?php
              }
            } else {
              //accesskey bad
              ?>
              <div class="alert alert-danger" role="alert">
                <h5 class="alert-heading">Invalid Access Key</h5>
                You have an invalid access key. Please use the personalized link provided in your email, or enter your access key below.
              </div>
              <div class="card col-md-6 mx-auto">
                <div class="card-body">
                  <h5 class="card-title">Access Key </h5>
                  <form action='' method="get">
                    <div class="form-group">
                      <label for="accessKey">Access Key</label>
                      <input type="text" id="accessKey" name="accessKey" class="form-control">
                    </div>
                    <input type="submit" class="btn btn-primary" value="Submit">
                  </form>
                </div>
              </div>
            <?php
            }
          } else {
            //no accessKey
            ?>
            <div class="card col-md-6 mx-auto">
              <div class="card-body">
                <h5 class="card-title">Access Key </h5>
                <form action='' method="get">
                  <div class="form-group">
                    <label for="accessKey">Access Key</label>
                    <input type="text" id="accessKey" name="accessKey" class="form-control">
                  </div>
                  <input type="submit" class="btn btn-primary" value="Submit">
                </form>
              </div>
            </div>
          <?php
          }
          ?>
        </main>
      </div>
    <?php endif ?>
    <?php include "../footer.php"; ?>

    <script src="../libraries/jquery-3.4.1.min.js"></script>
    <script src="../libraries/popper-1.16.0.min.js"></script>
    <script src="../libraries/bootstrap-4.4.1/js/bootstrap.min.js"></script>

    </body>

</html>
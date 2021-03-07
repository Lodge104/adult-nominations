<?php
include '../unitelections-info.php';
require '../vendor/autoload.php';


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

      <title>Create Unit Election | Occoneechee Lodge - Order of the Arrow, BSA</title>

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
          <div class="card mb-3">
            <div class="card-body">
              <h3 class="card-title">New Unit Election</h3>
              <form action="create-election-process.php" method="post">
                <div class="form-row">
                  <div class="col-md-3">
                    <div class="form-group">
                      <label for="unitNumber" class="required">Unit Number</label>
                      <input id="unitNumber" name="unitNumber" type="number" class="form-control" required>
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-group">
                      <label for="unitCommunity" class="required">Unit Type</label>
                      <select id="unitCommunity" name="unitCommunity" class="custom-select" required>
                        <option></option>
                        <?php $host = $_SERVER['SERVER_NAME'];
                        if($host == 'nominate-test.lodge104.net') : ?>
                        <option value="Test Unit">Test Unit</option>
                        <?php else : ?>
                        <?php endif ?>
                        <option value="Boy Troop">Boy Troop</option>
                        <option value="Girl Troop">Girl Troop</option>
                        <option value="Team">Team</option>
                        <option value="Crew">Crew</option>
                        <option value="Ship">Ship</option>
                      </select>
                    </div>
                  </div>
                </div>
                <div class="form-row">
                  <div class="col-md-3">
                    <div class="form-group">
                      <label for="numRegisteredYouth" class="required"># of Elected Youth</label>
                      <input id="numRegisteredYouth" name="numRegisteredYouth" type="number" class="form-control" required>
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-group">
                      <label for="dateOfElection" class="required">Date of Unit Election</label>
                      <input id="dateOfElection" name="dateOfElection" type="date" class="form-control" required>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="chapter" class="required">Chapter</label>
                      <select id="chapter" name="chapter" class="custom-select" required>
                        <option></option>
                        <option value="eluwak">Eluwak</option>
                        <option value="ilaumachque">Ilau Machque</option>
                        <option value="kiowa">Kiowa</option>
                        <option value="lauchsoheen">Lauchsoheen</option>
                        <option value="mimahuk">Mimahuk</option>
                        <option value="netami">Netami</option>
                        <option value="netopalis">Netopalis</option>
                        <option value="neusiok">Neusiok</option>
                        <option value="saponi">Saponi</option>
                        <option value="temakwe">Temakwe</option>
                      </select>
                    </div>
                  </div>
                </div>
                <hr>
                </hr>
                <h6 class="card-title required">Unit Leader Information</h6>
                <div class="form-row">
                  <div class="col-md-3">
                    <div class="form-group">
                      <input id="sm_name" name="sm_name" type="text" class="form-control" placeholder="Name" required>
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-group">
                      <input id="sm_address_line1" name="sm_address_line1" type="text" class="form-control" placeholder="Address">
                    </div>
                    <div class="form-group">
                      <input id="sm_address_line2" name="sm_address_line2" type="text" class="form-control" placeholder="Address Line 2 (optional)">
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-group">
                      <input id="sm_city" name="sm_city" type="text" class="form-control" placeholder="City">
                    </div>
                    <div class="form-row">
                      <div class="col-md-4">
                        <div class="form-group">
                          <input id="sm_state" name="sm_state" type="text" class="form-control" placeholder="State">
                        </div>
                      </div>
                      <div class="col-md-8">
                        <div class="form-group">
                          <input id="sm_zip" name="sm_zip" type="text" class="form-control" placeholder="Zip">
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-group">
                      <input id="sm_email" name="sm_email" type="email" class="form-control" placeholder="Email" required>
                    </div>
                    <div class="form-group">
                      <input id="sm_phone" name="sm_phone" type="tel" class="form-control" placeholder="Phone (###-###-####)" pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}" required>
                    </div>
                  </div>
                </div>
                <a href="index.php" class="btn btn-secondary">Cancel</a>
                <input type="submit" class="btn btn-primary" value="Submit">
              </form>
              <div class="my-2"><small class="text-muted">Note: Hitting submit will instantly send the invitation email and text message. Double check that the email address and phone number are correct.</small></div>
            </div>
          </div>
      </div>
      </main>
      </div>
    <?php endif ?>
    <?php include "../footer.php"; ?>

    <script src="../libraries/jquery-3.4.1.min.js"></script>
    <script src="../libraries/popper-1.16.0.min.js"></script>
    <script src="../libraries/bootstrap-4.4.1/js/bootstrap.min.js"></script>

    </body>

</html>
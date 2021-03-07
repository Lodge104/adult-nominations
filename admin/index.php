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

      <title>Unit Election Administration | Occoneechee Lodge - Order of the Arrow, BSA</title>

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
              <a class="nav-item nav-link" href="/">Nomination Review</a>
              <a class="nav-item nav-link" href="https://lodge104.net" target="_blank">Occoneechee Lodge Home</a>
            </div>
          </div>
        </nav>
        <main class="container-fluid col-xl-11">
          <?php
          if ($_GET['status'] == 1) { ?>
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
            <div class="alert alert-success" role="alert">
              <strong>Saved!</strong> Your data has been saved! Thanks!
              <button type="button" class="close" data-dismiss="alert"><i class="fas fa-times"></i></button>
            </div>
          <?php } ?>
          <?php
          if ($_GET['status'] == 3) { ?>
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
            <div class="alert alert-danger" role="alert">
              <strong>Error!</strong> Something went wrong and your submission did not finish successfully!
              <button type="button" class="close" data-dismiss="alert"><i class="fas fa-times"></i></button>
            </div>
          <?php } ?>
          <div class="row">
            <div class="col-auto mr-auto">
              <h2>Unit Elections</h2>
            </div>
            <div class="col-auto">
              <a class="btn btn-primary" href="../admin/create-unit-election.php" role="button">Create Unit Election</a>
            </div>
          </div>

          <?php
          $host = $_SERVER['SERVER_NAME'];
          if($host == 'nominate-test.lodge104.net') {
          $getUnitElectionsQuery = $conn->prepare("SELECT * from unitElections ORDER BY dateOfElection ASC");
          } else {
          $getUnitElectionsQuery = $conn->prepare("SELECT * from unitElections where unitCommunity != 'Test Unit' AND (date(dateOfElection) BETWEEN date(date_add(now(), INTERVAL -183 day)) AND date(now()) or date(dateOfElection) BETWEEN date(now()) AND date(date_add(now(), INTERVAL 120 day))) ORDER BY dateOfElection ASC");
          }
          $getUnitElectionsQuery->execute();
          $getUnitElectionsQ = $getUnitElectionsQuery->get_result();
          if ($getUnitElectionsQ->num_rows > 0) {
            //print election info
          ?>
            <!--<div class="collapse" id="online">-->
            <div class="card mb-3">
              <div class="card-body">
                <h3 class="card-title">Units</h3>
                <div class="table-responsive">
                  <table class="table">
                    <thead>
                      <tr>
                        <th scope="col">Unit</th>
                        <th scope="col">Date of Election</th>
                        <th scope="col">Chapter</th>
                        <th scope="col">Access Key</th>
                        <th scope="col"># of Nominations</th>
                        <th scope="col">Manage Election</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php while ($getUnitElections = $getUnitElectionsQ->fetch_assoc()) {
                      ?><tr>
                          <td><?php echo $getUnitElections['unitCommunity'] . " " . $getUnitElections['unitNumber']; ?></td>
                          <td><?php echo date("m-d-Y", strtotime($getUnitElections['dateOfElection'])); ?></td>
                          <td><?php echo $getUnitElections['chapter']; ?></td>
                          <td><input id="key" type="text" value="<?php echo $getUnitElections['accessKey']; ?>" disabled><button class="btn btn-primary" id="btn" data-clipboard-text="<?php echo $getUnitElections['accessKey']; ?>">Copy</button></td>                       
                          <?php
                          $adultNominationQuery = $conn->prepare("SELECT * from adultNominations where unitId = ?");
                          $adultNominationQuery->bind_param("s", $getUnitElections['id']);
                          $adultNominationQuery->execute();
                          $adultNominationQ = $adultNominationQuery->get_result();
                            //print election info
                          ?>
                          <td><?php echo $adultNominationQ->num_rows; ?></td>
                          <td><a href="../admin/edit-unit-election.php?accessKey=<?php echo $getUnitElections['accessKey']; ?>" class="btn btn-primary" role="button">Manage</a></td>
                        </tr>
                      <?php } ?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
            <!--</div>-->
          <?php } else {
          ?>
            <div class="alert alert-danger" role="alert">
              There are no elections in the database.
            </div>
          <?php
          }
          ?>

          <div class="card mb-3">
            <div class="card-body">
              <p>Use the forms below to access the unit leader and unit chair portals using the access keys above.</p>
            </div>
          </div>
          <div class="row justify-content-center pb-5">
            <div class="card col-md-5">
              <div class="card-body">
                <form action="/unitleader/" method="get">
                  <h3 class="form-signin-heading text-center">Unit Leader Login</h3>
                  <div class="form-group">
                    <label for="accessKey" class="required">Access Key</label>
                    <input type="text" id="accessKey" name="accessKey" class="form-control" autocomplete="off" required>
                  </div>
                  <input type="submit" class="btn btn-lg btn-primary btn-block" value="Submit">
                </form>
              </div>
            </div>
            <div class="col-md-1"></div>
            <div class="card col-md-5">
              <div class="card-body">
                <form action="/unitchair/" method="get">
                  <h3 class="form-signin-heading text-center">Unit Chair Login</h3>
                  <div class="form-group">
                    <label for="accessKey" class="required">Access Key</label>
                    <input type="text" id="accessKey" name="accessKey" class="form-control" autocomplete="off" required>
                  </div>
                  <input type="submit" class="btn btn-lg btn-primary btn-block" value="Submit">
                </form>
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
    <script src="../dist/clipboard.min.js"></script>

    <script>
      var clipboard = new ClipboardJS('.btn');

      clipboard.on('success', function(e) {
        console.log(e);
      });

      clipboard.on('error', function(e) {
        console.log(e);
      });
    </script>

    </body>

</html>
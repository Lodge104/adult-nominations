<?php

header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

include 'unitelections-info.php';
require 'vendor/autoload.php';

?>

<!DOCTYPE html>
<html>

<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-37461006-19"></script>
<script>
  window.dataLayer = window.dataLayer || [];

  function gtag() {
    dataLayer.push(arguments);
  }
  gtag('js', new Date());

  gtag('config', 'UA-37461006-19');
</script>

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

      <title>Adult Nomination Portal | Occoneechee Lodge - Order of the Arrow, BSA</title>

      <link rel="stylesheet" href="../libraries/bootstrap-4.4.1/css/bootstrap.min.css">
      <link rel="stylesheet" href="../libraries/fontawesome-free-5.12.0/css/all.min.css">
      <link rel="stylesheet" href="https://use.typekit.net/awb5aoh.css" media="all">
      <link rel="stylesheet" href="../style.css">


    </head>

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

            <?php

            include 'unitelections-info.php';

            // Create connection
            $conn = new mysqli($servername, $username, $password, $dbname);
            // Check connection
            if ($conn->connect_error) {
              die("Connection failed: " . $conn->connect_error);
            }

            ?>
            <main class="container-fluid col-xl-11">
              <?php
              if ($_GET['status'] == 1) { ?>
                <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
                <div class="alert alert-success" role="alert">
                  <strong>Saved!</strong> Your data has been saved! Thanks!
                  <button type="button" class="close" data-dismiss="alert"><i class="fas fa-times"></i></button>
                </div>
              <?php } ?>
              <section class="row">
                <div class="col-12">
                  <h2>Review Adult Nominations</h2>
                </div>
              </section>

              <?php
              $adultNominationQuery = $conn->prepare("SELECT * from adultNominations");
              $adultNominationQuery->execute();
              $adultNominationQ = $adultNominationQuery->get_result();
              if ($adultNominationQ->num_rows > 0) {
                //print election info
              ?>
                <!--<div class="collapse" id="online">-->
                <div class="card mb-3">
                  <div class="card-body">
                    <h3 class="card-title">Adult Nominations</h3>
                    <div class="table-responsive">
                      <table class="table">
                        <thead>
                          <tr>
                            <th scope="col">Unit</th>
                            <th scope="col">Name</th>
                            <th scope="col">BSA ID</th>
                            <th scope="col">Position</th>
                            <th scope="col">Review and Approve</th>
                            <th scope="col">Status</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php while ($getAdult = $adultNominationQ->fetch_assoc()) {

                          ?><tr>
                              <?php
                              $submissionsQuery = $conn->prepare("SELECT * from unitElections WHERE id=?");
                              $submissionsQuery->bind_param("s", $getAdult['unitId']);
                              $submissionsQuery->execute();
                              $submissionsQ = $submissionsQuery->get_result();
                              if ($submissionsQ->num_rows > 0) {
                                $submissions = $submissionsQ->fetch_assoc();
                              ?>
                                <td><?php echo $submissions['unitCommunity']; ?> <?php echo $submissions['unitNumber']; ?></td>
                              <?php }
                              $submissionsQuery->close();
                              ?>
                              <td><?php echo $getAdult['firstName'] . " " . $getAdult['lastName']; ?></td>
                              <td><?php echo $getAdult['bsa_id']; ?></td>
                              <td><?php echo $getAdult['position']; ?></td>
                              <td><?php
                                  if (($getAdult['advisor_signature'] == '1')) { ?>
                                  <a href="approve-nomination.php?accessKey=<?php echo $getAdult['accessKey']; ?>" class="btn btn-primary" role="button">Review Again</a>
                                <?php } elseif (($getAdult['advisor_signature'] == '2')) { ?>
                                  <a href="approve-nomination.php?accessKey=<?php echo $getAdult['accessKey']; ?>" class="btn btn-primary" role="button">Review Again</a>
                                <?php } elseif (($getAdult['chair_signature'] == '1')) { ?>
                                  <a href="approve-nomination.php?accessKey=<?php echo $getAdult['accessKey']; ?>" class="btn btn-primary" role="button">Review and Approve</a>
                                  <? } else { ?>
                                  <span class="text-muted">Not Ready</span>
                                <?php } ?>
                              <td>
                                <?php
                                if (($getAdult['leader_signature'] == '1' && (($getAdult['chair_signature'] == '1') && ($getAdult['advisor_signature'] == '2')))) { ?>
                                  <span class="badge badge-warning">Not Approved</span>
                                <?php } elseif (($getAdult['leader_signature'] == '1' && (($getAdult['chair_signature'] == '1') && ($getAdult['advisor_signature'] == '1')))) { ?>
                                  <span class="badge badge-success">Approved</span>
                                <?php } elseif (($getAdult['leader_signature'] == '1' && $getAdult['chair_signature'] == '1')) { ?>
                                  <span class="badge badge-danger">Waiting for Selection Committee</span>
                                <?php } elseif (($getAdult['leader_signature'] == '1')) { ?>
                                  <span class="badge badge-danger">Waiting for Unit Chair Approval</span>
                                <?php } ?>
                              </td>
                            </tr>
                          <?php } ?>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
                <!--</div>-->
              <?php
              } else {
              ?>
                <div class="alert alert-danger" role="alert">
                  There are no elections in the database.
                </div>
              <?php
              }
              ?>
          </div>
      </div>
      </main>
    <?php endif ?>


    <?php include "footer.php"; ?>

    <script src="../libraries/jquery-3.4.1.min.js"></script>
    <script src="../libraries/popper-1.16.0.min.js"></script>
    <script src="../libraries/bootstrap-4.4.1/js/bootstrap.min.js"></script>
    <script src="https://elections.lodge104.net/login/js/login.js"></script>
    </body>

</html>
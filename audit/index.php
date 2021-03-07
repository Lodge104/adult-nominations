<?php

header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

include '../unitelections-info.php';

?>

<!DOCTYPE html>
<html>

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
          <section class="row">
            <div class="col-12">
              <h2>Adult Nominations in Progress</h2>
            </div>
          </section>

          <?php
          $adultNominationQuery = $conn->prepare("SELECT * from adultNominations INNER JOIN unitElections ON adultNominations.unitId=unitElections.id WHERE unitElections.unitCommunity != 'Test Unit'");
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
                        <th scope="col">Position</th>
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
                            $sname = substr($getAdult["firstName"], 0, 1);
                          ?>
                            <td><?php echo $submissions['unitCommunity']; ?> <?php echo $submissions['unitNumber']; ?></td>
                          <?php }
                          $submissionsQuery->close();
                          ?>
                          <td><?php echo $sname . ". " . $getAdult['lastName']; ?></td>
                          <td><?php echo $getAdult['position']; ?></td>
                          <td>
                            <?php
                            if (($getAdult['leader_signature'] == '1' && (($getAdult['chair_signature'] == '1') && ($getAdult['advisor_signature'] == '2')))) { ?>
                              <span class="badge badge-warning">Not Approved by Selection Committee</span>
                            <?php } elseif (($getAdult['leader_signature'] == '1' && (($getAdult['chair_signature'] == '1') && ($getAdult['advisor_signature'] == '1')))) { ?>
                              <span class="badge badge-success">Approved by Selection Committee</span>
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

  <?php include "../footer.php"; ?>

  <script src="../libraries/jquery-3.4.1.min.js"></script>
  <script src="../libraries/popper-1.16.0.min.js"></script>
  <script src="../libraries/bootstrap-4.4.1/js/bootstrap.min.js"></script>
  <script src="https://elections.lodge104.net/login/js/login.js"></script>
</body>

</html>
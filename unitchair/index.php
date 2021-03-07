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

  <title>Unit Chair's Dashboard | Occoneechee Lodge - Order of the Arrow, BSA</title>

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
      <?php
      include '../unitelections-info.php';
      // Create connection
      $conn = new mysqli($servername, $username, $password, $dbname);
      // Check connection
      if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
      }

      if (isset($_GET['accessKey'])) {
        if (preg_match("/^([a-z\d]){8}-([a-z\d]){4}-([a-z\d]){4}-([a-z\d]){4}-([a-z\d]){12}$/", $_GET['accessKey'])) {
          $accessKey = $_POST['accessKey'] = $_GET['accessKey'];
      ?>
          <section class="row">
            <div class="col-12">
              <h2>Unit Chair's Adult Nomination Dashboard</h2>
            </div>
          </section>
          <div class="card mb-3">
            <div class="card-body">
              <h3 class="card-title d-inline-flex">Instructions</h3>
              <p>This is the unit chair's dashboard for adult nominations to the Order of the Arrow. When the unit leader of your unit submits a new adult nomination, you will be notified to come to this page. You must then go down below, review the submission and approve it. Once approved, the nomination will go to the selection committee of the lodge. The status will be updated on this dashboard; use the link from the email you received to check back routinely.</p>
            </div>
          </div>
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
                <h3 class="card-title d-inline-flex">Unit Election Information</h3>
                <div class="table-responsive">
                  <table class="table">
                    <thead>
                      <tr>
                        <th scope="col">Unit Type</th>
                        <th scope="col">Unit Number</th>
                        <th scope="col"># of Youth Elected</th>
                        <th scope="col">Chapter</th>
                        <th scope="col">Date of Election</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php $getUnitElections = $getUnitElectionsQ->fetch_assoc(); ?>
                      <tr>
                        <td><?php echo $getUnitElections['unitCommunity']; ?></td>
                        <td><?php echo $getUnitElections['unitNumber']; ?></td>
                        <td><?php echo $getUnitElections['numRegisteredYouth']; ?></td>
                        <td><?php echo $getUnitElections['chapter']; ?></td>
                        <td><?php echo date("m-d-Y", strtotime($getUnitElections['dateOfElection'])); ?></td>
                      </tr>
                    </tbody>
                  </table>
                </div>
                <h5 class="card-title">Unit Leader's Information</h5>
                <div class="row">
                  <div class="col-md-3">
                    <?php echo $getUnitElections['sm_name']; ?><br>
                  </div>
                  <div class="col-md-3">
                    <?php echo $getUnitElections['sm_address_line1']; ?><br>
                    <?php echo ($getUnitElections['sm_address_line2'] == "" ? '' : $getUnitElections['sm_address_line2'] . "<br>"); ?>
                    <?php echo $getUnitElections['sm_city']; ?>, <?php echo $getUnitElections['sm_state']; ?> <?php echo $getUnitElections['sm_zip']; ?><br>
                  </div>
                  <div class="col-md-3">
                    <?php echo $getUnitElections['sm_email']; ?><br>
                    <?php echo $getUnitElections['sm_phone']; ?><br>
                  </div>
                </div>
                <h5 class="card-title">Unit Chair's Information</h5>
                <div class="row">
                  <div class="col-md-3">
                    <?php echo $getUnitElections['uc_name']; ?><br>
                  </div>
                  <div class="col-md-3">
                    <?php echo $getUnitElections['uc_address_line1']; ?><br>
                    <?php echo ($getUnitElections['uc_address_line2'] == "" ? '' : $getUnitElections['uc_address_line2'] . "<br>"); ?>
                    <?php echo $getUnitElections['uc_city']; ?>, <?php echo $getUnitElections['uc_state']; ?> <?php echo $getUnitElections['uc_zip']; ?><br>
                  </div>
                  <div class="col-md-3">
                    <?php echo $getUnitElections['uc_email']; ?><br>
                    <?php echo $getUnitElections['uc_phone']; ?><br>
                  </div>
                </div>

              </div>
            </div>

            <?php
            $adultNominationQuery = $conn->prepare("SELECT * from adultNominations where unitId = ?");
            $adultNominationQuery->bind_param("s", $getUnitElections['id']);
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
                            <td><?php echo $getAdult['firstName'] . " " . $getAdult['lastName']; ?></td>
                            <td><?php echo $getAdult['bsa_id']; ?></td>
                            <td><?php echo $getAdult['position']; ?></td>
                            <td><?php
                                if (($getAdult['chair_signature'] == '1')) { ?>
                                <span class="text-muted">Already Approved</span>
                                <? } else { ?>
                                <a href="../unitchair/approve-nomination.php?accessKey=<?php echo $getAdult['accessKey']; ?>" class="btn btn-primary" role="button">Review and Approve</a>
                              <?php } ?>
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
            }
          }
        } else {
          ?>
          <div class="alert alert-danger" role="alert">
            There are no elections in the database.
          </div>
        <?php
        }
        ?>

      <?php
      } else {
        //accesskey bad
      ?>
        <div>
        <?php
      }
        ?>

    </main>
  </div>
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
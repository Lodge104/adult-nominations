<?php
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

include '../unitelections-info.php';

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_POST['unitId'])) { $unitId = $_POST['unitId']; } else { die("No unit id."); }
if (isset($_POST['accessKey'])) { $accessKey = $_POST['accessKey']; } else { die("No unit key."); }
if (isset($_POST['unitNumber'])) {  $unitNumber = $_POST['unitNumber']; } else { $unitNumber = ""; }
if (isset($_POST['unitCommunity'])) {  $unitCommunity = $_POST['unitCommunity']; } else { $unitCommunity = ""; }
if (isset($_POST['onlinevote'])) {  $onlinevote = $_POST['onlinevote']; } else { $onlinevote = ""; }
if (isset($_POST['numRegisteredYouth'])) {  $numRegisteredYouth = $_POST['numRegisteredYouth']; } else { $numRegisteredYouth = ""; }
if (isset($_POST['dateOfElection'])) {  $dateOfElection = $_POST['dateOfElection']; } else { $dateOfElection = ""; }
if (isset($_POST['chapter'])) {  $chapter = $_POST['chapter']; } else { $chapter = ""; }

if (isset($_POST['open'])) {  $open = $_POST['open']; } else { $open = ""; }
if (isset($_POST['sm_name'])) {  $sm_name = $_POST['sm_name']; } else { $sm_name = ""; }
if (isset($_POST['sm_address_line1'])) {  $sm_address_line1 = $_POST['sm_address_line1']; } else { $sm_address_line1 = ""; }
if (isset($_POST['sm_address_line2'])) {  $sm_address_line2 = $_POST['sm_address_line2']; } else { $sm_address_line2 = ""; }
if (isset($_POST['sm_city'])) {  $sm_city = $_POST['sm_city']; } else { $sm_city = ""; }
if (isset($_POST['sm_state'])) {  $sm_state = $_POST['sm_state']; } else { $sm_state = ""; }
if (isset($_POST['sm_zip'])) {  $sm_zip = $_POST['sm_zip']; } else { $sm_zip = ""; }
if (isset($_POST['sm_email'])) {  $sm_email = $_POST['sm_email']; } else { $sm_email = ""; }
if (isset($_POST['sm_phone'])) {  $sm_phone = $_POST['sm_phone']; } else { $sm_phone = ""; }

if (isset($_POST['uc_name'])) {  $uc_name = $_POST['uc_name']; } else { $uc_name = ""; }
if (isset($_POST['uc_address_line1'])) {  $uc_address_line1 = $_POST['uc_address_line1']; } else { $uc_address_line1 = ""; }
if (isset($_POST['uc_address_line2'])) {  $uc_address_line2 = $_POST['uc_address_line2']; } else { $uc_address_line2 = ""; }
if (isset($_POST['uc_city'])) {  $uc_city = $_POST['uc_city']; } else { $uc_city = ""; }
if (isset($_POST['uc_state'])) {  $uc_state = $_POST['uc_state']; } else { $uc_state = ""; }
if (isset($_POST['uc_zip'])) {  $uc_zip = $_POST['uc_zip']; } else { $uc_zip = ""; }
if (isset($_POST['uc_email'])) {  $uc_email = $_POST['uc_email']; } else { $uc_email = ""; }
if (isset($_POST['uc_phone'])) {  $uc_phone = $_POST['uc_phone']; } else { $uc_phone = ""; }


$updateElection = $conn->prepare("UPDATE unitElections SET sm_name=?,sm_address_line1=?,sm_address_line2=?,sm_city=?,sm_state=?,sm_zip=?,sm_email=?,sm_phone=?,numRegisteredYouth=? WHERE id = ?");
$updateElection->bind_param("ssssssssss", $sm_name, $sm_address_line1, $sm_address_line2, $sm_city, $sm_state, $sm_zip, $sm_email, $sm_phone, $numRegisteredYouth, $unitId);
$updateElection->execute();
$updateElection->close();

$updateElection1 = $conn->prepare("UPDATE unitElections SET unitNumber=?, unitCommunity=?, onlinevote=?, dateOfElection=?, chapter=? WHERE id = ?");
$updateElection1->bind_param("ssssss", $unitNumber, $unitCommunity, $onlinevote, $dateOfElection, ucfirst($chapter), $unitId);
$updateElection1->execute();
$updateElection1->close();

$updateElection2 = $conn->prepare("UPDATE unitElections SET uc_name=?,uc_address_line1=?,uc_address_line2=?,uc_city=?,uc_state=?,uc_zip=?,uc_email=?,uc_phone=?,numRegisteredYouth=? WHERE id = ?");
$updateElection2->bind_param("ssssssssss", $uc_name, $uc_address_line1, $uc_address_line2, $uc_city, $uc_state, $uc_zip, $uc_email, $uc_phone, $numRegisteredYouth, $unitId);
$updateElection2->execute();
$updateElection2->close();


header("Location: /admin/?status=1");

?>

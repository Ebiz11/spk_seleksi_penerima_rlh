<?php
session_start();
include ("cek_level.php");
require("library.php");
$individu=new individu();

$status="";
$sql=$individu->detail_ksm($_POST['id']);
$row=$sql->fetch(PDO::FETCH_ASSOC);
if ($row['status']=="Y") {
  $status="N";
}else {
  $status="Y";
}
?>

<input type="hidden" value="<?php echo $row['id_ksm'] ?>" name="id_ksm"  class="form-control" required>
<input type="hidden" value="<?php echo $status ?>" name="status"  class="form-control" required>
<center><h3> Anda yakin ingin mengupdate status dana KSM <?php echo $row['nama_ksm'] ?>?</h3></center>

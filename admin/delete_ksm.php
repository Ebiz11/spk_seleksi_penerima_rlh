<?php
session_start();
include ("cek_session.php");
require("library.php");
$individu=new individu();
$sql=$individu->detail_ksm($_POST['id']);
$row=$sql->fetch(PDO::FETCH_ASSOC);
?>
<input type="hidden" value="<?php echo $row['id_ksm'] ?>" name="id_ksm"  class="form-control" required>
<center><h3> Anda yakin ingin menghapus KSM <?php echo $row['nama_ksm'] ?> ?</h3></center>

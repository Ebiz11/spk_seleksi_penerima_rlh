<?php
session_start();
include ("cek_level.php");
require("library.php");
$individu=new individu();
$cek_penduduk=$individu->detail_penduduk($_POST['id']);
$hasil_cek=$cek_penduduk->fetch(PDO::FETCH_ASSOC);
?>
<input type="hidden" value="<?php echo $hasil_cek['nik'] ?>" name="username"  class="form-control" required>
<center><h3> Anda yakin ingin menghapus <?php echo $hasil_cek['nama'] ?> ?</h3></center>

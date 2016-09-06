<?php
session_start();
include ("cek_session.php");
require("library.php");
$individu=new individu();
$sql=$individu->detail_calon_penerima($_POST['id']);
$row=$sql->fetch(PDO::FETCH_ASSOC);
?>
<input type="hidden" value="<?php echo $row['id_calon_penerima'] ?>" name="id_calon_penerima"  class="form-control" required>
<center><h3> Anda yakin ingin menghapus <?php echo $row['nama_calon_penerima'] ?>?</h3></center>

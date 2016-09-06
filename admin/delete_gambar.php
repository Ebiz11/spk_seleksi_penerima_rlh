<?php
session_start();
include ("cek_session.php");
require("library.php");
$individu=new individu();
$sql= $individu->detail_foto($_POST['id']);
$row=$sql->fetch(PDO::FETCH_ASSOC);
?>
<input type="hidden" value="<?php echo $row['id_foto'] ?>" name="id_foto"  class="form-control" required>
<center><h3> Anda yakin ingin menghapus foto <?php echo $row['nama_foto'] ?> ?</h3></center>

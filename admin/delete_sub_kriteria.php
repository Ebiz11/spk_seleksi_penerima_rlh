<?php
session_start();
include ("cek_level.php");
require("library.php");
$profile_matching=new profile_matching();
$sql= $profile_matching-> detail_sub_kriteria($_POST['id']);
$row=$sql->fetch(PDO::FETCH_ASSOC);
?>
<input type="hidden" value="<?php echo $row['id_sub_kriteria'] ?>" name="id_sub_kriteria"  class="form-control" required>
<center><h3> Anda yakin ingin menghapus sub kriteria <?php echo $row['nama_sub_kriteria'] ?> ?</h3></center>

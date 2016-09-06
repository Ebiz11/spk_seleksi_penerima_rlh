<?php
session_start();
include ("cek_level.php");
?>
<input type="hidden" value="<?php echo $_POST['id'] ?>" name="id_analisa"  class="form-control" required>
<center><h3> Anda yakin ingin menghapus data analisa ?</h3></center>

<?php
session_start();
include ("cek_level.php");
require("library.php");
$profile_matching=new profile_matching();

$sql=$profile_matching->edit_kriteria($_POST['id']);
$row=$sql->fetch(PDO::FETCH_ASSOC);
?>

<div class="form-group"><label class="col-sm-2 control-label">Id Kriteria</label>
<div class="col-sm-10">
<input type="text" disabled="" value="<?php echo $row['id_kriteria'] ?>" name="id_kriteria"  class="form-control" required>
<input type="hidden" value="<?php echo $row['id_kriteria'] ?>" name="id_kriteria"  class="form-control" required>
</div>
</div>
<div class="form-group"><label class="col-sm-2 control-label">Nama Kriteria</label>
<div class="col-sm-10"><input type="text"  value="<?php echo $row['nama_kriteria'] ?>" name="nama_kriteria"  class="form-control" required></div>
</div>
<div class="form-group"><label  class="col-sm-2 control-label">Jenis Kriteria</label>
<div class="col-sm-10">
<?php
if($row['jenis_kriteria']=="cf"){ ?>
<div class="radio i-checks"><label> <input type="radio" checked="" value="1" name="jenis_kriteria"> <i></i> Core Factor </label></div>
<div class="radio i-checks"><label> <input type="radio" value="2" name="jenis_kriteria"> <i></i> Secondary Factor </label></div>
<?php }else{ ?>
<div class="radio i-checks">
  <label> <input type="radio"  value="1" name="jenis_kriteria"> <i></i> Core Factor </label>
  <label> <input type="radio" checked="" value="2" name="jenis_kriteria"> <i></i> Secondary Factor </label>
</div>
<?php } ?>
</div>
</div>

<script src="../js/jquery-2.1.1.js"></script>
<script src="../js/bootstrap.min.js"></script>
<script src="../js/plugins/metisMenu/jquery.metisMenu.js"></script>
<script src="../js/plugins/slimscroll/jquery.slimscroll.min.js"></script>
<script src="../js/inspinia.js"></script>
<script src="../js/plugins/pace/pace.min.js"></script>
<script src="../js/plugins/iCheck/icheck.min.js"></script>
<script>
    $(document).ready(function () {
        $('.i-checks').iCheck({
            checkboxClass: 'icheckbox_square-green',
            radioClass: 'iradio_square-green',
        });
    });
</script>

<?php
require("library.php");
$profile_matching=new profile_matching();
$sql= $profile_matching-> detail_sub_kriteria($_POST['id']);
$row=$sql->fetch(PDO::FETCH_ASSOC);
?>

<div class="form-group"><label class="col-sm-2 control-label">Id SubKriteria</label>
<div class="col-sm-10">
  <input type="text" value="<?php echo $row['id_sub_kriteria'] ?> " disabled="" class="form-control">
  <input type="hidden" value="<?php echo $row['id_sub_kriteria'] ?>" name="id_sub_kriteria"  class="form-control" required>
</div>
</div>
<div class="form-group"><label class="col-sm-2 control-label">Nama Sub Kriteria</label>
<div class="col-sm-10"><input type="text" value="<?php echo $row['nama_sub_kriteria'] ?> " name="nama_sub_kriteria" class="form-control"></div>
</div>
<div class="form-group"><label class="col-sm-2 control-label">Kriteria</label>
<div class="col-sm-10">
<?php
$checked = "";
$kriteria=$profile_matching->show_kriteria();
while ($data_kriteria=$kriteria->fetch(PDO::FETCH_ASSOC)) {
if ($data_kriteria['id_kriteria'] == $row['id_kriteria']) {
$checked = "checked";
}else {
$checked = "";
}
?>
<div class="radio i-checks"><label>
<input type="radio"  value="<?php echo $data_kriteria['id_kriteria'] ?>" name="id_kriteria" <?php echo $checked; ?>> <i></i><?php echo $data_kriteria['nama_kriteria'] ?></label>
</div>
<?php } ?>
</div>
</div>
<div class="form-group"><label class="col-sm-2 control-label">Nilai</label>
<div class="col-sm-10"><input type="number" min="1" max="5" value=<?php echo $row['nilai']; ?>  name="nilai" class="form-control"></div>
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

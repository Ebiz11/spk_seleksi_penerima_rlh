<?php
session_start();
include ("cek_session.php");
require("library.php");
$individu=new individu();
$sql=$individu->detail_calon_penerima($_POST['id']);
$row=$sql->fetch(PDO::FETCH_ASSOC);
$data_penduduk=$individu->detail_penduduk($row['no_ktp']);
$tampil_penduduk=$data_penduduk->fetch(PDO::FETCH_ASSOC);
?>
<div class="form-group"><label class="col-sm-2 control-label">Nama</label>
    <div class="col-sm-10">
      <input type="text"  disabled="" class="form-control" value="<?php echo $tampil_penduduk['nama'] ?>">
      <input type="hidden" name="id_calon_penerima" value="<?php echo $row['id_calon_penerima'] ?>" class="form-control">
    </div>
</div>
<div class="form-group"><label class="col-sm-2 control-label">No Ktp</label>
    <div class="col-sm-10"><input type="text"  disabled="" class="form-control" value="<?php echo $row['no_ktp'] ?>"></div>
</div>
<div class="form-group"><label class="col-sm-2 control-label">Biaya</label>
    <div class="col-sm-10"><input type="number" name="biaya" value="<?php echo $row['biaya'] ?>" class="form-control"></div>
</div>

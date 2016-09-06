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
<div class="form-group"><label class="col-sm-2 control-label">No Ktp</label>
<div class="col-sm-10">
<input type="text" disabled="" name="no_ktp" value="<?php echo $row['no_ktp'] ?>" class="form-control">
<input type="hidden" name="id_calon_penerima" value="<?php echo $row['id_calon_penerima'] ?>" class="form-control">
</div>
</div>
<div class="form-group"><label class="col-sm-2 control-label">Nama</label>
<div class="col-sm-10"><input type="text" disabled="" name="nama_calon_penerima" value="<?php echo $tampil_penduduk['nama'] ?>" class="form-control"></div>
</div>
<div class="form-group"><label class="col-sm-2 control-label">No kk</label>
<div class="col-sm-10"><input type="text" disabled="" name="no_kk" value="<?php echo $tampil_penduduk['no_kk'] ?>" class="form-control"></div>
</div>
<div class="form-group"><label class="col-sm-2 control-label">No Warmis</label>
<div class="col-sm-10"><input type="text" name="no_warmis" value="<?php echo $row['no_warmis'] ?>" class="form-control"></div>
</div>
<div class="form-group"><label class="col-sm-2 control-label">Alamat</label>
<div class="col-sm-10"><input type="text" disabled="" name="alamat" value="<?php echo $tampil_penduduk['alamat'] ?>" class="form-control"></div>
</div>
<div class="form-group"><label class="col-sm-2 control-label">RT</label>
<div class="col-sm-10"><input type="text" disabled="" name="rt" value="<?php echo $tampil_penduduk['rt'] ?>" class="form-control"></div>
</div>
<div class="form-group"><label class="col-sm-2 control-label">RW</label>
<div class="col-sm-10"><input type="text" disabled="" name="rw" value="<?php echo $tampil_penduduk['rw'] ?>" class="form-control"></div>
</div>
<div class="form-group"><label class="col-sm-2 control-label">Longitude</label>
<div class="col-sm-10"><input type="text" name="long" value="<?php echo $row['longitude'] ?>" class="form-control"></div>
</div>
<div class="form-group"><label class="col-sm-2 control-label">Latitude</label>
<div class="col-sm-10"><input type="text" name="lat" value="<?php echo $row['latitude'] ?>" class="form-control"></div>
</div>

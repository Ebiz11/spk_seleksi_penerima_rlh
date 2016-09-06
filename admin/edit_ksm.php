<?php
session_start();
include ("cek_session.php");
require("library.php");
$individu=new individu();
$sql=$individu->detail_ksm($_POST['id']);
$row=$sql->fetch(PDO::FETCH_ASSOC);
?>

<div class="form-group"><label class="col-sm-2 control-label">Id KSM</label>
<div class="col-sm-10">
<input type="text" value="<?php echo $row['id_ksm'] ?> " disabled="" name="id_ksm" class="form-control">
<input type="hidden" value="<?php echo $row['id_ksm'] ?>" name="id_ksm"  class="form-control" required>
</div>
</div>
<div class="form-group"><label class="col-sm-2 control-label">Nama KSM</label>
<div class="col-sm-10"><input type="text" value="<?php echo $row['nama_ksm'] ?> " name="nama_ksm" class="form-control" required></div>
</div>
<div class="form-group"><label class="col-sm-2 control-label">Nama Pekerjaan</label>
<div class="col-sm-10"><input type="text" value="<?php echo $row['jenis_pekerjaan'] ?> " name="jenis_pekerjaan" class="form-control" required></div>
</div>
<div class="form-group"><label class="col-sm-2 control-label">PNPM-MP</label>
<div class="col-sm-10"><input type="text" value="<?php echo $row['pnpm_mp'] ?> " name="pnpm_mp" class="form-control" required></div>
</div>
<div class="form-group"><label class="col-sm-2 control-label">Swadaya</label>
<div class="col-sm-10"><input type="text" value="<?php echo $row['swadaya'] ?> " name="swadaya" class="form-control" required></div>
</div>
<div class="form-group"><label class="col-sm-2 control-label">Lokasi</label>
<div class="col-sm-10"><input type="text" value="<?php echo $row['lokasi'] ?> " name="lokasi" class="form-control" required></div>
</div>
<div class="hr-line-dashed"></div>
<div class="form-group"><label class="col-sm-2 control-label">No Ktp Ketua</label>
<div class="col-sm-10"><input type="text" list="penduduk" id="nik_ketua_edit" value="<?php echo $row['no_ktp_ketua'] ?>" name="ktp_ketua" class="form-control" required></div>
<datalist id="penduduk">
<select class="form-control m-b">
<?php
$list_penduduk = $individu->list_penduduk();
while($row1 = $list_penduduk->fetch(PDO::FETCH_ASSOC)){?>
<option><?php echo $row1['nik'] ?></option>
<?php } ?>
</select>
<datalist>
</div>
<?php
$detail_penduduk_ketua=$individu->detail_penduduk($row['no_ktp_ketua']);
$tampil_penduduk_ketua=$detail_penduduk_ketua->fetch(PDO::FETCH_ASSOC);
 ?>
<div class="form-group"><label class="col-sm-2 control-label">Nama Ketua</label>
<div class="col-sm-10"><input type="text" id="nama_ketua_edit" value="<?php echo $tampil_penduduk_ketua['nama'] ?>" name="nama_ketua" class="form-control" required></div>
</div>
<div class="form-group"><label class="col-sm-2 control-label">Alamat Ketua</label>
<div class="col-sm-10"><input type="text" id="alamat_ketua_edit" value="<?php echo $tampil_penduduk_ketua['alamat']; ?>" name="alamat_ketua" class="form-control" required></div>
</div>
<div class="hr-line-dashed"></div>
<div class="form-group"><label class="col-sm-2 control-label">No Ktp Sekertaris</label>
<div class="col-sm-10"><input type="text" list="penduduk" id="nik_sekertaris_edit" value="<?php echo $row['no_ktp_sekertaris'] ?>" name="ktp_sekertaris" class="form-control" required></div>
<datalist id="penduduk">
<select class="form-control m-b" >
<?php
$list_penduduk = $individu->list_penduduk();
while($row2 = $list_penduduk->fetch(PDO::FETCH_ASSOC)){?>
<option><?php echo $row2['nik'] ?></option>
<?php } ?>
</select>
<datalist>
</div>
<?php
$detail_penduduk_sekertaris=$individu->detail_penduduk($row['no_ktp_sekertaris']);
$tampil_penduduk_sekertaris=$detail_penduduk_sekertaris->fetch(PDO::FETCH_ASSOC);
 ?>
<div class="form-group"><label class="col-sm-2 control-label">Nama Sekertaris</label>
<div class="col-sm-10"><input type="text" id="nama_sekertaris_edit" value="<?php echo $tampil_penduduk_sekertaris['nama'] ?>"  name="nama_sekertaris" class="form-control" required></div>
</div>
<div class="form-group"><label class="col-sm-2 control-label">Alamat Sekertaris</label>
<div class="col-sm-10"><input type="text" id="alamat_sekertaris_edit" value="<?php echo $tampil_penduduk_sekertaris['alamat'] ?>" name="alamat_sekertaris" class="form-control" required></div>
</div>
<div class="hr-line-dashed"></div>
<div class="form-group"><label class="col-sm-2 control-label">No Ktp Bendahara</label>
<div class="col-sm-10"><input type="text" list="penduduk" id="nik_bendahara_edit" value="<?php echo $row['no_ktp_bendahara'] ?>" name="ktp_bendahara" class="form-control" required></div>
<datalist id="penduduk">
<select class="form-control m-b">
<?php
$list_penduduk = $individu->list_penduduk();
while($row3 = $list_penduduk->fetch(PDO::FETCH_ASSOC)){?>
<option><?php echo $row3['nik'] ?></option>
<?php } ?>
</select>
<datalist>
</div>
<?php
$detail_penduduk_bendahara=$individu->detail_penduduk($row['no_ktp_bendahara']);
$tampil_penduduk_bendahara=$detail_penduduk_bendahara->fetch(PDO::FETCH_ASSOC);
 ?>
<div class="form-group"><label class="col-sm-2 control-label">Nama Bendahara</label>
<div class="col-sm-10"><input type="text" id="nama_bendahara_edit" value="<?php echo $tampil_penduduk_bendahara['nama'] ?>"  name="nama_bendahara" class="form-control" required></div>
</div>
<div class="form-group"><label class="col-sm-2 control-label">Alamat Bendahara</label>
<div class="col-sm-10"><input type="text" id="alamat_bendahara_edit" value="<?php echo $tampil_penduduk_bendahara['alamat'] ?>" name="alamat_bendahara" class="form-control" required></div>
</div>


<script src="../js/jquery-2.1.1.js"></script>
<script language="javascript">

 $(document).ready(function() {
   $("#nik_ketua_edit").keyup(function() {
       var nik = $('#nik_ketua_edit').val();
   $.post('load_data.php', // request ke file load_data.php
   {parent_id: nik},
   function(data){
      $('#nama_ketua_edit').val(data[0].nama);
      $('#alamat_ketua_edit').val(data[0].alamat);
   },'json'
     );
  });
  });

 $(document).ready(function() {
   $("#nik_bendahara_edit").keyup(function() {
       var nik = $('#nik_bendahara_edit').val();
   $.post('load_data.php', // request ke file load_data.php
   {parent_id: nik},
   function(data){
      $('#nama_bendahara_edit').val(data[0].nama);
      $('#alamat_bendahara_edit').val(data[0].alamat);
   },'json'
     );
  });
  });

 $(document).ready(function() {
   $("#nik_sekertaris_edit").keyup(function() {
       var nik = $('#nik_sekertaris_edit').val();
   $.post('load_data.php', // request ke file load_data.php
   {parent_id: nik},
   function(data){
      $('#nama_sekertaris_edit').val(data[0].nama);
      $('#alamat_sekertaris_edit').val(data[0].alamat);
   },'json'
     );
  });
  });
 </script>
<!-- edit ksm -->

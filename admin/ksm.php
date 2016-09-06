<?php
include ("cek_session.php");
require ("library.php");
$individu= new individu();
unset($_SESSION['data']);
$tanggal=date("Y-m-d");

if(isset($_POST['tambah'])){

  // data post
  $nama_ksm=$_POST['nama_ksm'];
  $pnpm_mp=$_POST['pnpm_mp'];
  $swadaya=$_POST['swadaya'];
  $jenis_pekerjaan=$_POST['jenis_pekerjaan'];
  $lokasi=$_POST['lokasi'];
  $no_ktp_ketua=$_POST['ktp_ketua'];
  $no_ktp_sekertaris=$_POST['ktp_sekertaris'];
  $no_ktp_bendahara=$_POST['ktp_bendahara'];
  // ======

// cek duplikasi data
  $cek_ksmnya=$individu->cek_ksm($nama_ksm, $no_ktp_ketua, $lokasi);
  $dataksm=$cek_ksmnya->fetch(PDO::FETCH_ASSOC);

  $nama_ksmnya=empty($dataksm['nama_ksm'])?'':$dataksm['nama_ksm'];
  $lokasinya=empty($dataksm['lokasi'])?'':$dataksm['lokasi'];
  $ktp_ketuanya=empty($dataksm['no_ktp_ketua'])?'':$dataksm['no_ktp_ketua'];
  $ktp_sekertarisnya=empty($dataksm['no_ktp_sekertaris'])?'':$dataksm['no_ktp_sekertaris'];
  $ktp_bendaharanya=empty($dataksm['no_ktp_bendahara'])?'':$dataksm['no_ktp_bendahara'];

  // cek ke tabelpenduduk
  // cek ketua
  $cek_penduduk_ketua=$individu->detail_penduduk($no_ktp_ketua);
  $hasil_cek_ketua=$cek_penduduk_ketua->fetch(PDO::FETCH_ASSOC);
  $has_ketua=$hasil_cek_ketua['nik'];
  // cek sekertaris
  $cek_penduduk_sekertaris=$individu->detail_penduduk($no_ktp_sekertaris);
  $hasil_cek_sekertaris=$cek_penduduk_sekertaris->fetch(PDO::FETCH_ASSOC);
  $has_sekertaris=$hasil_cek_sekertaris['nik'];
  // cek sekertaris
  $cek_penduduk_bendahara=$individu->detail_penduduk($no_ktp_bendahara);
  $hasil_cek_bendahara=$cek_penduduk_bendahara->fetch(PDO::FETCH_ASSOC);
  $has_bendahara=$hasil_cek_bendahara['nik'];
  // === end===

  if ($no_ktp_ketua!=$has_ketua) {
    $_SESSION['gagal'] = '<b>GAGAL MENYIMPAN: No Ktp Ketua tidak terdaftar sebagai penduduk.</b>';
    $_SESSION['data'] =$_POST;
  }elseif ($no_ktp_sekertaris!=$has_sekertaris) {
    $_SESSION['gagal'] = '<b>GAGAL MENYIMPAN: No Ktp Sekertaris tidak terdaftar sebagai penduduk.</b>';
    $_SESSION['data'] =$_POST;
  }elseif ($no_ktp_bendahara!=$has_bendahara) {
    $_SESSION['gagal'] = '<b>GAGAL MENYIMPAN: No Ktp Bendahara tidak terdaftar sebagai penduduk.</b>';
    $_SESSION['data'] =$_POST;
  }elseif (strtolower(trim($nama_ksm))==strtolower(trim($nama_ksmnya)) AND strtolower(trim($lokasi))==strtolower(trim($lokasinya))
  AND strtolower(trim($no_ktp_ketua))==strtolower(trim($ktp_ketuanya)) AND strtolower(trim($no_ktp_sekertaris))==strtolower(trim($ktp_sekertarisnya))
  AND strtolower(trim($no_ktp_bendahara))==strtolower(trim($ktp_bendaharanya))) {
    $_SESSION['gagal'] = '<b>Gagal Menyimpan:</b> Data KSM sudah ada.';
    $_SESSION['data'] = $_POST;

  }else {
    $tahun=date("Y");
    $id_periode="";
    $cek=$individu->cek_tahun($tahun);
    $terus=$cek->fetch(PDO::FETCH_ASSOC);
    $haha=$cek->rowCount();
    if ($haha>=1) {
      $id_periode=$terus['id_periode'];
    }else{
      $add_periode=$individu->add_periode();
      $id_periode=$individu->dbh->lastInsertId();
    }

    $add=$individu->add_ksm($id_periode, $nama_ksm, $pnpm_mp, $swadaya,$jenis_pekerjaan, $lokasi, $no_ktp_ketua,$no_ktp_sekertaris, $no_ktp_bendahara, $tanggal);
    $_SESSION['berhasil'] = '<b>BERHASIL MENYIMPAN:</b> Data KSM berhasil ditambahkan, silahkan lengkapi data calon penerimanya.';
    $last_id=$individu->dbh->lastInsertId();
    echo "<script>document.location='index.php?page=anggota&id_ksm=$last_id';</script>";
  }
  }

// edit
  if(isset($_POST['edit'])){

  // data post
  $id_ksm=$_POST['id_ksm'];
  $nama_ksm=$_POST['nama_ksm'];
  $jenis_pekerjaan=$_POST['jenis_pekerjaan'];
  $pnpm_mp=$_POST['pnpm_mp'];
  $swadaya=$_POST['swadaya'];
  $lokasi=$_POST['lokasi'];
  $no_ktp_ketua=$_POST['ktp_ketua'];
  $no_ktp_sekertaris=$_POST['ktp_sekertaris'];
  $no_ktp_bendahara=$_POST['ktp_bendahara'];
  // =============

  // cek duplikasi data
  $cek_ksmnya=$individu->cek_ksm($nama_ksm, $no_ktp_ketua, $lokasi);
  $dataksm=$cek_ksmnya->fetch(PDO::FETCH_ASSOC);

  $id_ksmnya=empty($dataksm['id_ksm'])?'':$dataksm['id_ksm'];
  $nama_ksmnya=empty($dataksm['nama_ksm'])?'':$dataksm['nama_ksm'];
  $lokasinya=empty($dataksm['lokasi'])?'':$dataksm['lokasi'];
  $ktp_ketuanya=empty($dataksm['no_ktp_ketua'])?'':$dataksm['no_ktp_ketua'];
  $ktp_sekertarisnya=empty($dataksm['no_ktp_sekertaris'])?'':$dataksm['no_ktp_sekertaris'];
  $ktp_bendaharanya=empty($dataksm['no_ktp_bendahara'])?'':$dataksm['no_ktp_bendahara'];

  // cek ke tabelpenduduk
  // cek ketua
  $cek_penduduk_ketua=$individu->detail_penduduk($no_ktp_ketua);
  $hasil_cek_ketua=$cek_penduduk_ketua->fetch(PDO::FETCH_ASSOC);
  $has_ketua=$hasil_cek_ketua['nik'];
  // cek sekertaris
  $cek_penduduk_sekertaris=$individu->detail_penduduk($no_ktp_sekertaris);
  $hasil_cek_sekertaris=$cek_penduduk_sekertaris->fetch(PDO::FETCH_ASSOC);
  $has_sekertaris=$hasil_cek_sekertaris['nik'];
  // cek sekertaris
  $cek_penduduk_bendahara=$individu->detail_penduduk($no_ktp_bendahara);
  $hasil_cek_bendahara=$cek_penduduk_bendahara->fetch(PDO::FETCH_ASSOC);
  $has_bendahara=$hasil_cek_bendahara['nik'];
  // === end===

  if ($no_ktp_ketua!=$has_ketua) {
    $_SESSION['gagal'] = '<b>GAGAL MENYIMPAN: No Ktp Ketua tidak terdaftar sebagai penduduk.</b>';
  }elseif ($no_ktp_sekertaris!=$has_sekertaris) {
    $_SESSION['gagal'] = '<b>GAGAL MENYIMPAN: No Ktp Sekertaris tidak terdaftar sebagai penduduk.</b>';
  }elseif ($no_ktp_bendahara!=$has_bendahara) {
    $_SESSION['gagal'] = '<b>GAGAL MENYIMPAN: No Ktp Bendahara tidak terdaftar sebagai penduduk.</b>';
  }elseif (strtolower(trim($nama_ksm))==strtolower(trim($nama_ksmnya))
  AND strtolower(trim($lokasi))==strtolower(trim($lokasinya))
  AND strtolower(trim($no_ktp_ketua))==strtolower(trim($ktp_ketuanya))
  AND strtolower(trim($no_ktp_sekertaris))==strtolower(trim($ktp_sekertarisnya))
  AND strtolower(trim($no_ktp_bendahara))==strtolower(trim($ktp_bendaharanya))
  AND $id_ksm!=$id_ksmnya) {
    $_SESSION['gagal'] = '<b>Gagal Menyimpan:</b> Data KSM sudah ada.';
    $_SESSION['data'] = $_POST;
  }else{
  $update=$individu->update_ksm($id_ksm, $nama_ksm, $pnpm_mp, $swadaya, $jenis_pekerjaan, $lokasi, $no_ktp_ketua, $no_ktp_sekertaris, $no_ktp_bendahara);
    $_SESSION['berhasil']='<b>BERHASIL MENGUPDATE:</b> Data KSM Berhasil diupdate.';
  }
}

// status dana
  if (isset($_POST['update'])) {
    $id_ksm=$_POST['id_ksm'];
    $status=$_POST['status'];
    $update_status=$individu->update_status_ksm($status,$id_ksm);
    $_SESSION['berhasil']='<b>BERHASIL MENGUPDATE:</b> Status dana berhasil di update.';
  }

// hapus
  if (isset($_POST['hapus'])) {
	$del=$individu->del_ksm($_POST['id_ksm']);
	$_SESSION['berhasil']='<b>BERHASIL DIHAPUS:</b> Data KSM berhasil dihapus.';
  }
?>

<div class="row wrapper border-bottom white-bg page-heading">
<div class="col-lg-9"><h2>Daftar KSM</h2>
    <ol class="breadcrumb">
      <li>
      <a href="index?page=home">Home</a>
      </li>
      <li class="active">
      <strong>Daftar KSM</strong>
      </li>
    </ol>
</div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
<div class="row">
<div class="col-lg-12">
<div class="ibox float-e-margins">
<div class="ibox-title">
    <!-- <h5>Daftar KSM</h5> -->
    <div class="ibox-tools">
        <a class="collapse-link">
            <i class="fa fa-chevron-up"></i>
        </a>
        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
            <i class="fa fa-wrench"></i>
        </a>
        <ul class="dropdown-menu dropdown-user">
            <li><a href="#">Config option 1</a>
            </li>
            <li><a href="#">Config option 2</a>
            </li>
        </ul>
        <a class="close-link">
            <i class="fa fa-times"></i>
        </a>
    </div>
</div>
<div class="ibox-content">
  <!-- notifikasi --> <?php include ("notifikasi.php") ?> <!--  -->
<button class="add-record btn btn-sm btn-primary" href="#">Tambah Data</button>
<table class="table table-striped table-bordered table-hover dataTables-example" >
<thead>
<tr>
  <th>No</th>
  <th>Nama Ksm</th>
  <th>Pnpm-mp</th>
  <th>Swadaya</th>
  <th>Total</th>
  <th>Anggota</th>
  <th>Status</th>
  <th>Aksi</th>
</tr>
</thead>
<tbody>
<?php
$no=1;
$ksm=$individu->show_ksm();
while ($dataksm=$ksm->fetch(PDO::FETCH_ASSOC)){
?>
<tr class="gradeX">
  <td><?php echo $no++ ?></td>
  <td><a href="index?page=detail_ksm&id_ksm=<?php echo $dataksm['id_ksm'] ?>"><?php echo $dataksm['nama_ksm'] ?></a></td>
  <td><?php echo number_format($dataksm['pnpm_mp'],0,',','.'); ?></td>
  <td><?php echo number_format ($dataksm['swadaya'] ,0,',','.'); ?></td>
  <?php
  $totalbiaya1=$dataksm['pnpm_mp']+$dataksm['swadaya'];
   ?>
  <td><?php echo number_format ($totalbiaya1,0,',','.') ?></td>
  <td><a type="button" class="btn btn-info btn-sm" href="index.php?page=anggota&id_ksm=<?php echo $dataksm['id_ksm'] ?>">lihat</a> </td>
  <td>
    <?php if($dataksm['status'] == "Y") { ?>
      <?php if ($_SESSION['level'] == "1") {?>
    <button class="update-record btn btn-info btn-sm" data-id="<?php echo $dataksm['id_ksm'] ?>"><i class="fa fa-check-square-o"></i></button>
    <?php }else{} ?>
    <span class="label label-info">Terpenuhi</span>
    <?php } else { ?>
      <?php if ($_SESSION['level'] == "1") {?>
    <button class="update-record btn btn-warning btn-sm" data-id="<?php echo $dataksm['id_ksm'] ?>"><i class="fa fa-square-o"></i></button>
    <?php }else{} ?>
    <span class="label label-warning">Belum Terpenuhi</span>
    <?php } ?>
  </td>
  <td>
    <button class="edit-record btn btn-sm btn-warning"  href="#" data-id="<?php echo $dataksm['id_ksm'] ?>"><i class="fa fa-pencil-square-o"></i></button>
    <button class="hapus-record btn btn-sm btn-danger" href="#" data-id="<?php echo $dataksm['id_ksm'] ?>"><i class="fa fa-trash"></i></button>
  </td>
</tr>
<?php } ?>
</tbody>
<tfoot>
<tr>
</tr>
</tfoot>
</table>
</div>
</div>
</div>
</div>
</div>

<!-- modal tambah -->
    <div class="modal inmodal fade" data-backdrop="static" id="add_ksm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog">
      <div class="modal-content">
      <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
      <h4 class="modal-title">Tambah KSM</h4>
      <small class="font-bold"></small>
      </div>
      <form method="post" name="formulir" class="form-horizontal" enctype="multipart/form-data" >
      <div class="modal-body">
      <div class="form-group"><label class="col-sm-2 control-label">Nama KSM</label>
      <div class="col-sm-10"><input type="text" value="<?php echo @$_SESSION['data']['nama_ksm'] ?>"  name="nama_ksm" class="form-control" required></div>
      </div>
      <div class="form-group"><label class="col-sm-2 control-label">PNPM-MP</label>
      <div class="col-sm-10"><input type="number" name="pnpm_mp" value="<?php echo @$_SESSION['data']['pnpm_mp'] ?>" class="form-control" required></div>
      </div>
      <div class="form-group"><label class="col-sm-2 control-label">Swadaya</label>
      <div class="col-sm-10"><input type="number" name="swadaya" value="<?php echo @$_SESSION['data']['swadaya'] ?>" class="form-control" required></div>
      </div>
      <div class="form-group"><label class="col-sm-2 control-label">Jenis Pekerjaan</label>
      <div class="col-sm-10"><input type="text" name="jenis_pekerjaan" value="<?php echo @$_SESSION['data']['jenis_pekerjaan'] ?>" class="form-control" required></div>
      </div>
      <div class="form-group"><label class="col-sm-2 control-label">Lokasi</label>
      <div class="col-sm-10"><input type="text" value="<?php echo @$_SESSION['data']['lokasi'] ?>" name="lokasi" class="form-control" required></div>
      </div>
      <div class="hr-line-dashed"></div>
      <div class="form-group"><label class="col-sm-2 control-label">No Ktp Ketua</label>
      <div class="col-sm-10"><input type="text" list="penduduk" id="nik_ketua" value="<?php echo @$_SESSION['data']['ktp_ketua'] ?>"  name="ktp_ketua" class="form-control" required></div>
      <datalist id="penduduk">
      <select class="form-control m-b">
      <?php
      $list_penduduk = $individu->list_penduduk();
      while($row = $list_penduduk->fetch(PDO::FETCH_ASSOC)){?>
      <option><?php echo $row['nik'] ?></option>
      <?php } ?>
      </select>
      <datalist>
      </div>
      <div class="form-group"><label class="col-sm-2 control-label">Nama Ketua</label>
      <div class="col-sm-10"><input type="text" id="nama_ketua" name="nama_ketua" value="<?php echo @$_SESSION['data']['nama_ketua'] ?>" class="form-control" required></div>
      </div>
      <div class="form-group"><label class="col-sm-2 control-label">Alamat Ketua</label>
      <div class="col-sm-10"><input type="text" id="alamat_ketua" name="alamat_ketua" value="<?php echo @$_SESSION['data']['alamat_ketua'] ?>" class="form-control" required></div>
      </div>
      <div class="hr-line-dashed"></div>
      <div class="form-group"><label class="col-sm-2 control-label">No Ktp Sekertaris</label>
      <div class="col-sm-10"><input type="text" list="penduduk" id="nik_sekertaris"  name="ktp_sekertaris" value="<?php echo @$_SESSION['data']['ktp_sekertaris'] ?>" class="form-control" required></div>
      <datalist id="penduduk">
      <select class="form-control m-b" >
      <?php
      $list_penduduk = $individu->list_penduduk();
      while($row = $list_penduduk->fetch(PDO::FETCH_ASSOC)){?>
      <option><?php echo $row['nik'] ?></option>
      <?php } ?>
      </select>
      <datalist>
      </div>
      <div class="form-group"><label class="col-sm-2 control-label">Nama Sekertaris</label>
      <div class="col-sm-10"><input type="text" id="nama_sekertaris" name="nama_sekertaris" value="<?php echo @$_SESSION['data']['nama_sekertaris'] ?>" class="form-control" required></div>
      </div>
      <div class="form-group"><label class="col-sm-2 control-label">Alamat Sekertaris</label>
      <div class="col-sm-10"><input type="text" id="alamat_sekertaris" name="alamat_sekertaris" value="<?php echo @$_SESSION['data']['alamat_sekertaris'] ?>" class="form-control" required></div>
      </div>
      <div class="hr-line-dashed"></div>
      <div class="form-group"><label class="col-sm-2 control-label">No Ktp Bendahara</label>
      <div class="col-sm-10"><input type="text" list="penduduk" id="nik_bendahara" name="ktp_bendahara" value="<?php echo @$_SESSION['data']['ktp_bendahara'] ?>" class="form-control" required></div>
      <datalist id="penduduk">
      <select class="form-control m-b">
      <?php
      $list_penduduk = $individu->list_penduduk();
      while($row = $list_penduduk->fetch(PDO::FETCH_ASSOC)){?>
      <option><?php echo $row['nik'] ?></option>
      <?php } ?>
      </select>
      <datalist>
      </div>
      <div class="form-group"><label class="col-sm-2 control-label">Nama Bendahara</label>
      <div class="col-sm-10"><input type="text" id="nama_bendahara" name="nama_bendahara" value="<?php echo @$_SESSION['data']['nama_bendahara'] ?>" class="form-control" required></div>
      </div>
      <div class="form-group"><label class="col-sm-2 control-label">Alamat Bendahara</label>
      <div class="col-sm-10"><input type="text" id="alamat_bendahara" name="alamat_bendahara" value="<?php echo @$_SESSION['data']['alamat_bendahara'] ?>" class="form-control" required></div>
      </div>
      </div>
      <div class="modal-footer">
      <button type="button" class="btn btn-white" data-dismiss="modal">Batal</button>
      <button class="btn btn-primary" type="submit" name="tambah">Simpan</button>
      </div>
      </form>
      </div>
      </div>
    </div>
<!-- -->

    <!-- modal edit -->
    <div class="modal inmodal fade" data-backdrop="static" id="modal_edit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog">
      <div class="modal-content">
      <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
      <h4 class="modal-title">Edit KSM</h4>
      <small class="font-bold"></small>
      </div>
      <form method="post" name="formulir" class="form-horizontal" enctype="multipart/form-data" >
      <div class="modal-body"> <div class="edit"> </div> </div>
      <div class="modal-footer">
      <button type="button" class="btn btn-white" data-dismiss="modal">Batal</button>
      <button class="btn btn-primary" type="submit" name="edit">Simpan</button>
      </div>
      </form>
      </div>
      </div>
    </div>
    <!--  -->

    <!-- modal hapus -->
    <div class="modal inmodal fade" data-backdrop="static" id="modal_hapus" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog">
      <div class="modal-content">
      <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
      <h4 class="modal-title">Hapus KSM</h4>
      <small class="font-bold"></small>
      </div>
      <form method="post" name="formulir" class="form-horizontal" enctype="multipart/form-data" >
      <div class="modal-body"> <div class="hapus"> </div> </div>
      <div class="modal-footer">
      <button type="button" class="btn btn-white" data-dismiss="modal">Batal</button>
      <button class="btn btn-primary" type="submit" name="hapus">Ya</button>
      </div>
      </form>
      </div>
      </div>
    </div>
    <!--  -->

    <!-- modal update status -->
    <div class="modal inmodal fade" data-backdrop="static" id="modal_status" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog">
      <div class="modal-content">
      <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
      <h4 class="modal-title">Update Status KSM</h4>
      <small class="font-bold"></small>
      </div>
      <form method="post" name="formulir" class="form-horizontal" enctype="multipart/form-data" >
      <div class="modal-body">
      <div class="status"> </div>
      </div>
      <div class="modal-footer">
      <button type="button" class="btn btn-white" data-dismiss="modal">Batal</button>
      <button class="btn btn-primary" type="submit" name="update">Ya</button>
      </div>
      </form>
      </div>
      </div>
    </div>
    <!--  -->

<script language="javascript">

$(document).ready(function() {
  $("#nik_ketua").keyup(function() {
      var nik = $('#nik_ketua').val();
  $.post('load_data.php', // request ke file load_data.php
  {parent_id: nik},
  function(data){
     $('#nama_ketua').val(data[0].nama);
     $('#alamat_ketua').val(data[0].alamat);
  },'json'
    );
 });
 });

$(document).ready(function() {
  $("#nik_bendahara").keyup(function() {
      var nik = $('#nik_bendahara').val();
  $.post('load_data.php', // request ke file load_data.php
  {parent_id: nik},
  function(data){
     $('#nama_bendahara').val(data[0].nama);
     $('#alamat_bendahara').val(data[0].alamat);
  },'json'
    );
 });
 });

$(document).ready(function() {
  $("#nik_sekertaris").keyup(function() {
      var nik = $('#nik_sekertaris').val();
  $.post('load_data.php', // request ke file load_data.php
  {parent_id: nik},
  function(data){
     $('#nama_sekertaris').val(data[0].nama);
     $('#alamat_sekertaris').val(data[0].alamat);
  },'json'
    );
 });
 });

 $(function(){
     $(document).on('click','.edit-record',function(e){
         e.preventDefault();
         $("#modal_edit").modal('show');
         $.post('edit_ksm.php',
             {id:$(this).attr('data-id')},
             function(html){
                 $(".edit").html(html);
             }
         );
     });
 });

 $(function(){
     $(document).on('click','.hapus-record',function(e){
         e.preventDefault();
         $("#modal_hapus").modal('show');
         $.post('delete_ksm.php',
             {id:$(this).attr('data-id')},
             function(html){
                 $(".hapus").html(html);
             }
         );
     });
 });

 $(function(){
     $(document).on('click','.update-record',function(e){
         e.preventDefault();
         $("#modal_status").modal('show');
         $.post('update_status_ksm.php',
             {id:$(this).attr('data-id')},
             function(html){
                 $(".status").html(html);
             }
         );
     });
 });

 $(function(){
     $(document).on('click','.add-record',function(e){
         e.preventDefault();
         $("#add_ksm").modal('show');
     });
 });
</script>

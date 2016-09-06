<?php
include ("cek_session.php");
require ("library.php");
$individu= new individu();
$tanggal=date("Y-m-d");
$id_ksm=$_GET['id_ksm'];
unset($_SESSION['data']);
$query_ksm=$individu->detail_ksm($id_ksm);
$data_ksm=$query_ksm->fetch(PDO::FETCH_ASSOC);

// tambah
if(isset($_POST['tambah'])){

  $no_ktp= $_POST['no_ktp'];
  $no_warmis= $_POST['no_warmis'];
  $lat=$_POST['lat'];
  $long=$_POST['long'];

  $id_ksm_nya=$data_ksm['id_ksm'];
  $querypenerima=$individu->cek_calon_penerimanya($id_ksm, $no_ktp);
  $data_calon_penerima=$querypenerima->fetch(PDO::FETCH_ASSOC);

  $ktpnya=empty($data_calon_penerima['no_ktp'])?'':$data_calon_penerima['no_ktp'];
  $ksmnya=empty($data_calon_penerima['id_ksm'])?'':$data_calon_penerima['id_ksm'];

  // cek riwayat
  $tahun_sekarang=date("Y");
  $riwayat=$individu->show_riwayat_penerima($no_ktp);
  $data_riwayat=$riwayat->fetch(PDO::FETCH_ASSOC);
  $jum=$riwayat->rowCount();
  // end riwayat

  // cek ke tabelpenduduk
  $cek_penduduk=$individu->detail_penduduk($no_ktp);
  $hasil_cek=$cek_penduduk->fetch(PDO::FETCH_ASSOC);
  // ===
  if ($no_ktp!=$hasil_cek['nik']) {
    $_SESSION['gagal'] = '<b>GAGAL MENYIMPAN:</b> ' .$_POST['nama_calon_penerima'].' tidak terdaftar sebagai penduduk.';
    $_SESSION['data'] =$_POST;
  }elseif($no_ktp==$ktpnya){
    $_SESSION['gagal'] = '<b>GAGAL MENYIMPAN:</b> '.$_POST['nama_calon_penerima'].' sudah menjadi anggota.';
    $_SESSION['data'] =$_POST;
  }else {
    $add=$individu->add_calon_penerima($id_ksm_nya,$no_ktp,$no_warmis, $long,$lat, $tanggal);
    $_SESSION['berhasil'] = '<b>BERHASIL MENYIMPAN:</b> Data calon penerima berhasil ditambahkan.';
    $tglnya=empty($data_riwayat['tanggal'])?'':$data_riwayat['tanggal'];
    $statusnya=empty($data_riwayat['status'])?'':$data_riwayat['status'];

    if (date("Y",strtotime($tglnya))==($tahun_sekarang-1) AND $statusnya=="Y") {
      $_SESSION['warning']=''.$nama_penerima.' Tahun '.($tahun_sekarang-1).' sudah pernah mendapatkan bantuan, silahkan cek riwayat bantuannya.';
    }
  }
}

// edit
if (isset($_POST['edit'])) {
  $id_calon_penerima=$_POST['id_calon_penerima'];
  $lat=$_POST['lat'];
  $long=$_POST['long'];
  $no_warmis=$_POST['no_warmis'];
  // $jenis_bantuan=$_POST['jenis_bantuan'];
  $update=$individu->update_calon_penerima($id_calon_penerima, $lat, $long, $no_warmis);
  $_SESSION['berhasil'] = '<b>BERHASIL MENYIMPAN:</b> Data berhasil diupdate.';
}

// update
if(isset($_POST['edit_biaya'])){
  $id_penerima=$_POST['id_calon_penerima'];
  $biaya=$_POST['biaya'];
  $add=$individu->update_biaya($id_penerima, $biaya);
  $_SESSION['berhasil'] = '<b>BERHASIL MENGUPDATE:</b> Data berhasil diupdate.';
}

// delete
if(isset($_POST['hapus'])){
  $del=$individu->delete_calon_penerima($_POST['id_calon_penerima']);
  $_SESSION['berhasil']='<b>BERHASIL DIHAPUS:</b> Data anggota berhasil dihapus.';
}
?>
<div class="row wrapper border-bottom white-bg page-heading">
  <div class="col-lg-9">
    <h2><?php echo $data_ksm['nama_ksm']; ?></h2>
    <ol class="breadcrumb">
        <li>
            <a href="index?page=home">Home</a>
        </li>
        <li class="active">
            <strong>Daftar Anggota</strong>
        </li>
    </ol>
  </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
  <div class="row">
    <div class="col-lg-12">
      <div class="ibox float-e-margins">
<div class="ibox-title">
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
  <?php include ("notifikasi.php"); ?>
<br>
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#add_calon_penerima">Tambah Data</button>
<br><br>
<table class="table table-striped table-bordered table-hover dataTables-example" >
<thead>
<tr>
    <th>No</th>
    <th>Nama</th>
    <th>No Ktp</th>
    <th>Riwayat</th>
    <th>Foto</th>
    <th>Biaya</th>
    <th>Status</th>
    <th>Aksi</th>
</tr>
</thead>
<tbody>

  <?php
  $no=1;
  $jum=0;
      $qcalon_penerima=$individu->detail_calon_penerima_ksm($_GET['id_ksm']);
			while ($datacalon_penerima = $qcalon_penerima->fetch(PDO::FETCH_ASSOC))
			{ ?>
    <tr class="gradeX">
        <td><?php echo $no++ ?></td>
        <?php
        $data_penduduk=$individu->detail_penduduk($datacalon_penerima['no_ktp']);
        $tampil_penduduk=$data_penduduk->fetch(PDO::FETCH_ASSOC);
         ?>
        <td><a href="index?page=detail_calon_penerima&id_calon_penerima=<?php echo $datacalon_penerima['id_calon_penerima'] ?>"><?php echo $tampil_penduduk['nama'] ?></a></td>
        <td><?php echo $datacalon_penerima['no_ktp'] ?></td>
        <td><a href="index?page=riwayat_penerima&no_ktp=<?php echo $datacalon_penerima['no_ktp'] ?>">Lihat</a></td>
        <td><a href="index?page=gambar&id_calon_penerima=<?php echo $datacalon_penerima['id_calon_penerima'] ?>">Lihat</a></td>
        <td>
          <?php if ($datacalon_penerima['biaya']==0) { ?>
          <a class="edit-record_biaya btn btn-xs btn-info" href="#" data-id="<?php echo $datacalon_penerima['id_calon_penerima'] ?>" ><i class="fa fa-pencil-square-o"></i> Input</a>
          <?php }else{ ?>
          <a class="edit-record_biaya" href="#" data-id="<?php echo $datacalon_penerima['id_calon_penerima'] ?>"><?php echo number_format($datacalon_penerima['biaya'],0,',','.') ?></a>
          <?php } ?>
          <?php $jum=$jum+$datacalon_penerima['biaya']; ?>
        </td>
        <td>
          <?php
          if ($datacalon_penerima['status_diterima']=="Y") { ?> <span class="label label-info">Diterima</span>
          <?php } elseif ($datacalon_penerima['status_diterima']=="N"){ ?> <span class="label label-danger">Ditolak</span>
          <?php }else {?> <span class="label label-warning">Belum dianalisa</span> <?php }?>
        </td>
        <td>
          <a class="edit-record btn btn-sm btn-warning"  href="#" data-id="<?php echo $datacalon_penerima['id_calon_penerima'] ?>"><i class="fa fa-pencil-square-o"></i></a>
          <a class="hapus-record btn btn-sm btn-danger" href="#" data-id="<?php echo $datacalon_penerima['id_calon_penerima'] ?>"><i class="fa fa fa-trash"></i></a>
        </td>
      </tr>
      <?php } ?>
      </tbody>
      <tfoot>
      <tr>
      <td colspan="5"><center>TOTAL</ center></td>
      <td><center><?php echo number_format($jum,0,',','.') ?></center></td>
      <td colspan="2"></td>
      </tr>
      </tfoot>
      </table>
      </div>
    </div>
  </div>
</div>
</div>

<!-- tambah modal -->
<div class="modal inmodal fade" data-backdrop="static" id="add_calon_penerima" tabindex="-1" role="dialog"  aria-hidden="true">
  <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title">Tambah Anggota</h4>
        <small class="font-bold"></small>
        </div>
        <div class="modal-body">
        <form method="post" class="form-horizontal">
        <div class="form-group"><label class="col-sm-2 control-label">No Ktp</label>
        <div class="col-sm-10"><input type="text" id="nik" list="penduduk" value="<?php echo @$_SESSION['data']['no_ktp'] ?>" name="no_ktp" class="form-control"  required></div>
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
        <div class="form-group"><label class="col-sm-2 control-label">Nama</label>
        <div class="col-sm-10"><input type="text" id="nama_calon_penerima" value="<?php echo @$_SESSION['data']['nama_calon_penerima'] ?>" name="nama_calon_penerima"  class="form-control" required></div>
        </div>
        <div class="form-group"><label class="col-sm-2 control-label">No kk</label>
        <div class="col-sm-10"><input type="text" id="no_kk" value="<?php echo @$_SESSION['data']['no_kk'] ?>" name="no_kk" class="form-control" required></div>
        </div>
        <div class="form-group"><label class="col-sm-2 control-label">No Warmis</label>
        <div class="col-sm-10"><input type="text" value="<?php echo @$_SESSION['data']['no_warmis'] ?>" name="no_warmis" class="form-control"></div>
        </div>
        <div class="form-group"><label class="col-sm-2 control-label">Alamat</label>
        <div class="col-sm-10"><input type="text" id="alamat" value="<?php echo @$_SESSION['data']['alamat'] ?>" name="alamat"  class="form-control" required></div>
        </div>
        <div class="form-group"><label class="col-sm-2 control-label">RT</label>
        <div class="col-sm-10"><input type="number" id="rt" value="<?php echo @$_SESSION['data']['rt'] ?>" name="rt"  class="form-control" required></div>
        </div>
        <div class="form-group"><label class="col-sm-2 control-label">RW</label>
        <div class="col-sm-10"><input type="number" id="rw" value="<?php echo @$_SESSION['data']['rw'] ?>" name="rw"  class="form-control" required></div>
        </div>
        <div class="form-group"><label class="col-sm-2 control-label">Longitude</label>
        <div class="col-sm-10"><input type="text" placeholder="110.41803342895514" name="long" class="form-control" ></div>
        </div>
        <div class="form-group"><label class="col-sm-2 control-label">Latitude</label>
        <div class="col-sm-10"><input type="text" placeholder="-7.7506225431682125" name="lat" class="form-control" ></div>
        </div>
        <div class="modal-footer">
        <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
        <button class="btn btn-primary" type="submit" name="tambah">Simpan</button>
        </div>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- modal edit -->
<div class="modal inmodal fade" data-backdrop="static" id="modal_edit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
  <div class="modal-content">
  <div class="modal-header">
  <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
  <h4 class="modal-title">Edit Anggota</h4>
  <small class="font-bold"></small>
  </div>
  <form method="post" name="formulir" class="form-horizontal" enctype="multipart/form-data" >
  <div class="modal-body">
  <div class="edit"> </div> </div>
  <div class="modal-footer">
  <button type="button" class="btn btn-white" data-dismiss="modal">Batal</button>
  <button class="btn btn-primary" type="submit" name="edit">Simpan</button>
  </div>
  </form>
  </div>
  </div>
</div>
<!--  -->

<!-- edit_biaya -->
<div class="modal inmodal fade" data-backdrop="static" id="modal_edit_biaya" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
  <div class="modal-content">
  <div class="modal-header">
  <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
  <h4 class="modal-title">Edit Biaya</h4>
  <small class="font-bold"></small>
  </div>
  <form method="post" name="formulir" class="form-horizontal" enctype="multipart/form-data" >
  <div class="modal-body">
  <div class="edit_biaya"> </div>
  </div>
  <div class="modal-footer">
  <button type="button" class="btn btn-white" data-dismiss="modal">Batal</button>
  <button class="btn btn-primary" type="submit" name="edit_biaya">Simpan</button>
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
  <h4 class="modal-title">Hapus Anggota</h4>
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

<script language="javascript">
$(document).ready(function() {
$("#nik").keyup(function() {
var nik = $('#nik').val();
$.post('load_data.php', // request ke file load_data.php
{parent_id: nik},
function(data){
$('#nama_calon_penerima').val(data[0].nama);
$('#no_kk').val(data[0].no_kk);
$('#alamat').val(data[0].alamat);
$('#rt').val(data[0].rt);
$('#rw').val(data[0].rw);
},'json'
);
});
});

    $(function(){
        $(document).on('click','.edit-record',function(e){
            e.preventDefault();
            $("#modal_edit").modal('show');
            $.post('edit_anggota.php',
                {id:$(this).attr('data-id')},
                function(html){
                    $(".edit").html(html);
                }
            );
        });
    });

    $(function(){
        $(document).on('click','.edit-record_biaya',function(e){
            e.preventDefault();
            $("#modal_edit_biaya").modal('show');
            $.post('edit_biaya.php',
                {id:$(this).attr('data-id')},
                function(html){
                    $(".edit_biaya").html(html);
                }
            );
        });
    });

    $(function(){
        $(document).on('click','.hapus-record',function(e){
            e.preventDefault();
            $("#modal_hapus").modal('show');
            $.post('delete_anggota.php',
                {id:$(this).attr('data-id')},
                function(html){
                    $(".hapus").html(html);
                }
            );
        });
    });

    // $(function(){
    //     $(document).on('click','.add-record',function(e){
    //         e.preventDefault();
    //         $("#add_kriteria").modal('show');
    //     });
    // });
</script>

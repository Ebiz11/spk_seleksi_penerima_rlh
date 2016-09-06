<?php
include ("cek_level.php");
require ("library.php");
$login= new login();
$profile_matching= new profile_matching();
$id_kriteria_GET=$_GET['id_kriteria'];
unset($_SESSION['data']);
unset($_SESSION['gagal']);
unset($_SESSION['berhasil']);
$no=1;

// tambah sub_kriteria
if(isset($_POST['tambah'])){

  $nama_sub_kriteria=$login->input_form($_POST['nama_sub_kriteria']);
  $id_kriteria=$login->input_form($_POST['id_kriteria']);
  $nilai=$login->input_form($_POST['nilai']);

  // cek data
  $validasi_nama_sub_kriteria=$profile_matching->validasi_sub_kriteria_nama($id_kriteria, $nama_sub_kriteria);
  $data_validasi_nama=$validasi_nama_sub_kriteria->fetch(PDO::FETCH_ASSOC);
  $nama_sub_kriteria_validasi=empty($data_validasi_nama['nama_sub_kriteria'])?'':$data_validasi_nama['nama_sub_kriteria'];
  $id_sub_kriteria_validasi_nama=empty($data_validasi_nama['id_sub_kriteria'])?'':$data_validasi_nama['id_sub_kriteria'];
  // end cek data

  // cek data nilai
  $validasi_nilai_sub_kriteria=$profile_matching->validasi_sub_kriteria_nilai($id_kriteria, $nilai);
  $data_validasi_nilai=$validasi_nilai_sub_kriteria->fetch(PDO::FETCH_ASSOC);
  $nilai_sub_kriteria_validasi=empty($data_validasi_nilai['nilai'])?'':$data_validasi_nilai['nilai'];
  $id_sub_kriteria_validasi_nilai=empty($data_validasi_nilai['id_sub_kriteria'])?'':$data_validasi_nilai['id_sub_kriteria'];
  // end cek data nilai

  if(empty($nama_sub_kriteria) || empty($id_kriteria) || empty($nilai)){
    $_SESSION['gagal'] = '<b>GAGAL MENYIMPAN:</b> Data yang anda masukan tidak lengkap.';
    $_SESSION['data'] =$_POST;

  }elseif($nilai==$nilai_sub_kriteria_validasi){
    $_SESSION['gagal'] = '<b>GAGAL MENYIMPAN:</b> Nilai sub kriteria sudah digunakan. ';
    $_SESSION['data'] =$_POST;

  }elseif ($nama_sub_kriteria==$nama_sub_kriteria_validasi) {
    $_SESSION['gagal'] = '<b>GAGAL MENYIMPAN:</b> Nama sub kriteria sudah digunakan. ';
    $_SESSION['data'] =$_POST;

  }else {
    $add=$profile_matching->add_sub_kriteria($nama_sub_kriteria, $id_kriteria, $nilai);
    $_SESSION['berhasil'] = '<b>BERHASIL MENYIMPAN:</b> Data Sub kriteria berhasil ditambahkan.';
  }
}

// edit sub_kriteria
if(isset($_POST['edit'])){

  $id_sub_kriteria=$_POST['id_sub_kriteria'];
  $nama_sub_kriteria=$_POST['nama_sub_kriteria'];
  $id_kriteria=$_POST['id_kriteria'];
  $nilai=$_POST['nilai'];

  // cek data
  $validasi_nama_sub_kriteria=$profile_matching->validasi_sub_kriteria_nama($id_kriteria, $nama_sub_kriteria);
  $data_validasi_nama=$validasi_nama_sub_kriteria->fetch(PDO::FETCH_ASSOC);
  $nama_sub_kriteria_validasi=empty($data_validasi_nama['nama_sub_kriteria'])?'':$data_validasi_nama['nama_sub_kriteria'];
  $id_sub_kriteria_validasi_nama=empty($data_validasi_nama['id_sub_kriteria'])?'':$data_validasi_nama['id_sub_kriteria'];
  // end cek data

  // cek data nilai
  $validasi_nilai_sub_kriteria=$profile_matching->validasi_sub_kriteria_nilai($id_kriteria, $nilai);
  $data_validasi_nilai=$validasi_nilai_sub_kriteria->fetch(PDO::FETCH_ASSOC);
  $nilai_sub_kriteria_validasi=empty($data_validasi_nilai['nilai'])?'':$data_validasi_nilai['nilai'];
  $id_sub_kriteria_validasi_nilai=empty($data_validasi_nilai['id_sub_kriteria'])?'':$data_validasi_nilai['id_sub_kriteria'];
  // end cek data nilai

  if($nilai==$nilai_sub_kriteria_validasi AND $id_sub_kriteria != $id_sub_kriteria_validasi_nilai) {
    $_SESSION['gagal'] = '<b>GAGAL MENYIMPAN:</b> Nilai sub kriteria sudah digunakan. ';
    $_SESSION['data'] =$_POST;

  }elseif($nama_sub_kriteria==$nama_sub_kriteria_validasi AND $id_sub_kriteria != $id_sub_kriteria_validasi_nama) {
    $_SESSION['gagal'] = '<b>GAGAL MENYIMPAN:</b> Nama sub kriteria sudah ada. ';
    $_SESSION['data'] =$_POST;

  }else {
    $update = $profile_matching->update_sub_kriteria ($id_sub_kriteria, $nama_sub_kriteria, $id_kriteria, $nilai);
    $_SESSION['berhasil'] = '<b>BERHASIL MENYIMPAN:</b> Data sub kriteria berhasil diupdate.';
  }
}

// hapus sub_kriteria
if (isset($_POST['hapus'])) {
  $id_sub_kriteria=$_POST['id_sub_kriteria'];
  $del=$profile_matching->delete_sub_ktiteria($id_sub_kriteria);
  if ($del=="Y") {
    $_SESSION['berhasil']='<b>BERHASIL MENGHAPUS:</b> Data sub kriteria berhasil dihapus.';
  }else{
  $_SESSION['gagal']='<b>GAGAL MENGHAPUS:</b> Data sub kriteria digunakan di standar profile.';
  }
}

?>
<div class="row wrapper border-bottom white-bg page-heading">
  <div class="col-lg-9">
    <?php
    $kriteria=$profile_matching->edit_kriteria($id_kriteria_GET);
    $datakriteria=$kriteria->fetch(PDO::FETCH_ASSOC);
    ?>
      <h2>Sub Kriteria (<?php echo $datakriteria['nama_kriteria']; ?>)</h2>
      <ol class="breadcrumb">
          <li>
              <a href="index?page=home">Home</a>
          </li>
          <li class="active">
              <strong>Sub Kriteria</strong>
          </li>
      </ol>
  </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
  <div class="row">
    <div class="col-lg-12">
      <div class="ibox float-e-margins">
        <div class="ibox-title">
          <!-- <h5>SUB KRITERIA</h5> -->
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
            <!-- notifikasi -->
            <?php
            include ("notifikasi.php");
            $sub_kriteria= $profile_matching-> view_sub_kriteria($id_kriteria_GET);
            $sum_sub=count($sub_kriteria);
            if($sum_sub==5){
              echo  '<div class="alert alert-warning alert-dismissable ">
              <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button><i class="fa fa-exclamation-circle"></i>
               <b>Data Sub Kriteria Maksimal 5 </b></div>';
            }else{?>
              <button class="add-record btn btn-sm btn-primary" href="#">Tambah Data</button>
            <?php } ?>
            <!--  -->
            
            <table class="table table-striped table-bordered table-hover dataTables-example" >
            <thead>
            <tr>
                <th>No</th>
                <th>Nama Sub Kriteria</th>
                <th>Nilai</th>
                <th>Aksi</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($sub_kriteria as $datasub_kriteria) { ?>
            <tr class="gradeX">
            <td><?php echo $no++ ?></td>
            <td><?php echo $datasub_kriteria['nama_sub_kriteria']?></td>
            <td><?php echo $datasub_kriteria['nilai'] ?></td>
            <td>
              <a class="edit-record btn btn-sm btn-warning"  href="#" data-id="<?php echo $datasub_kriteria['id_sub_kriteria'] ?>"><i class="fa fa-pencil-square-o"></i></a>
              <a class="hapus-record btn btn-sm btn-danger" href="#" data-id="<?php echo $datasub_kriteria['id_sub_kriteria'] ?>"><i class="fa fa fa-trash"></i></a></td>
            </tr>
            <?php }; ?>
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
<div class="modal inmodal fade" data-backdrop="static" id="add_sub_kriteria" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="modal-dialog">
<div class="modal-content">
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
<h4 class="modal-title">Tambah Sub Kriteria</h4>
<small class="font-bold"></small>
</div>
<form method="post" name="formulir" class="form-horizontal" enctype="multipart/form-data" >
<div class="modal-body">
  <div class="form-group"><label class="col-sm-2 control-label">Nama Sub Kriteria</label>
  <div class="col-sm-10">
  <div class="col-sm-10"><input type="text" maxlength="30" value="<?php echo @$_SESSION['data']['nama_sub_kriteria'] ?>" name="nama_sub_kriteria" class="form-control" required></div>
  </div>
  </div>
  <div class="form-group"><label class="col-sm-2 control-label">Kriteria</label>
  <div class="col-sm-10">
  <?php
  // $checked = "";
  $kriteria=$profile_matching->edit_kriteria($id_kriteria_GET);
  while ($data_kriteria=$kriteria->fetch(PDO::FETCH_ASSOC)) {
  ?>
  <div class="radio i-checks"><label>
  <input type="radio"  value="<?php echo $data_kriteria['id_kriteria'] ?>" name="id_kriteria" checked > <i></i><?php echo $data_kriteria['nama_kriteria'] ?></label>
  </div>
  <?php } ?>
  </div>
</div>
<div class="form-group"><label class="col-sm-2 control-label">Nilai</label>
<div class="col-sm-10">
<div class="col-sm-10"><input type="number" min="1" max="5" value="<?php echo @$_SESSION['data']['nilai'] ?>"  name="nilai" class="form-control" name="number" required></div>
</div>
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
<!--  -->
<!-- modal edit -->
<div class="modal inmodal fade" data-backdrop="static" id="modal_edit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
  <div class="modal-content">
  <div class="modal-header">
  <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
  <h4 class="modal-title">Edit Sub Kriteria</h4>
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

<!-- modal hapus -->
<div class="modal inmodal fade" data-backdrop="static" id="modal_hapus" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
  <div class="modal-content">
  <div class="modal-header">
  <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
  <h4 class="modal-title">Hapus Sub Kriteria</h4>
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

<script>
    $(function(){
        $(document).on('click','.edit-record',function(e){
            e.preventDefault();
            $("#modal_edit").modal('show');
            $.post('edit_sub_kriteria.php',
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
            $.post('delete_sub_kriteria.php',
                {id:$(this).attr('data-id')},
                function(html){
                    $(".hapus").html(html);
                }
            );
        });
    });

    $(function(){
        $(document).on('click','.add-record',function(e){
            e.preventDefault();
            $("#add_sub_kriteria").modal('show');
        });
    });
</script>

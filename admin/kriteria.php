<?php
include ("cek_level.php");
require ("library.php");
$login= new login();
$profile_matching= new profile_matching();

unset($_SESSION['data']);

// tambah kriteria
  if(isset($_POST['tambah'])){

    $nama_kriteria=$login->input_form($_POST['nama_kriteria']);
    $jenis_kriteria=$login->input_form($_POST['jenis']);

    // cek data
    $cek_kriteria=$profile_matching->cek_kriteria($nama_kriteria);
    $data_kriteria=$cek_kriteria->fetch(PDO::FETCH_ASSOC);
    $cek_nama_kriteria=empty($data_kriteria['nama_kriteria'])?'':$data_kriteria['nama_kriteria'];
    $cek_jenis_kriteria=empty($data_kriteria['jenis_kriteria'])?'':$data_kriteria['jenis_kriteria'];
    // end cek data

    if(empty($nama_kriteria) || empty($jenis_kriteria)){
      $_SESSION['gagal'] = '<b>GAGAL MENYIMPAN:</b> Data yang anda masukan tidak lengkap.';
      $_SESSION['data'] =$_POST;

    }elseif (strtolower($nama_kriteria)==strtolower($cek_nama_kriteria)) {
      $_SESSION['gagal'] = '<b>GAGAL MENYIMPAN:</b> Nama kriteria sudah digunakan. ';
      $_SESSION['data'] =$_POST;

    }else {
      $add=$profile_matching->add_kriteria($nama_kriteria,$jenis_kriteria);
      $_SESSION['berhasil'] = '<b>BERHASIL MENYIMPAN:</b> Data kriteria berhasil ditambahkan.';
    }
  }

// edit kriteria
  if(isset($_POST['edit'])){
    $id_kriteria=$_POST['id_kriteria'];
    $nama_kriteria=$_POST['nama_kriteria'];
    $jenis_kriteria=$_POST['jenis_kriteria'];

    // cek data
    $cek_kriteria=$profile_matching->cek_kriteria($nama_kriteria);
    $data_kriteria=$cek_kriteria->fetch(PDO::FETCH_ASSOC);
    $cek_nama_kriteria=empty($data_kriteria['nama_kriteria'])?'':$data_kriteria['nama_kriteria'];
    $cek_jenis_kriteria=empty($data_kriteria['jenis_kriteria'])?'':$data_kriteria['jenis_kriteria'];
    $cek_id=empty($data_kriteria['id_kriteria'])?'':$data_kriteria['id_kriteria'];
    // end cek data

    if (trim(strtolower($nama_kriteria))==trim(strtolower($cek_nama_kriteria)) AND $cek_id!=$id_kriteria) {
      $_SESSION['gagal'] = '<b>GAGAL MENYIMPAN:</b> Nama kriteria sudah digunakan. ';
      $_SESSION['data'] =$_POST;

    }else {
      $update=$profile_matching->update_kriteria($id_kriteria, $nama_kriteria, $jenis_kriteria);
      $_SESSION['berhasil'] = '<b>BERHASIL MENGUPDATE:</b> Data kriteria berhasil diupdate.';
    }
  }

// hapus kriteria
  if (isset($_POST['hapus'])) {
    $id_kriteria_delete=$_POST['id_kriteria'];
    $del = $profile_matching->delete_kriteria($id_kriteria_delete);
    $_SESSION['berhasil']='<b>BERHASIL MENGHAPUS:</b> Data Kriteria Berhasil Dihapus.';
  }
?>

<div class="row wrapper border-bottom white-bg page-heading">
  <div class="col-lg-9"><h2>Kriteria</h2>
    <ol class="breadcrumb">
      <li>
        <a href="index?page=home">Home</a>
      </li>
      <li class="active">
        <strong>Kriteria</strong>
      </li>
    </ol>
  </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
          <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>KRITERIA</h5>
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
                <th>Nama Kriteria</th>
                <th>Jenis Kriteria</th>
                <th>Sub Kriteria</th>
                <th>Aksi</th>
            </tr>
            </thead>
            <tbody>
              <?php
              $no=1;
              $show_kriteria=$profile_matching->show_kriteria();
              while ($datakriteria=$show_kriteria->fetch(PDO::FETCH_ASSOC)){
      		    ?>
            <tr class="gradeX">
                <td><?php echo $no++ ?></td>
                <td><?php echo $datakriteria['nama_kriteria'] ?> </td>
                <?php if($datakriteria['jenis_kriteria'] == "cf") { ?> <td>Core Factor</td>
                <?php }else { ?><td>Secondary Factor</td> <?php  } ?>
                <td><a typ="button" class="btn btn-sm btn-info" href="index?page=sub_kriteria&id_kriteria=<?php echo $datakriteria['id_kriteria'] ?>">Detail</a></td>
                <td>
                  <a class="edit-record btn btn-sm btn-warning"  href="#" data-id="<?php echo $datakriteria['id_kriteria'] ?>"><i class="fa fa-pencil-square-o"></i></a>
                  <a class="hapus-record btn btn-sm btn-danger" href="#" data-id="<?php echo $datakriteria['id_kriteria'] ?>"><i class="fa fa fa-trash"></i></a>
                </td>
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
    <div class="modal inmodal fade" data-backdrop="static" id="add_kriteria" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog">
      <div class="modal-content">
      <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
      <h4 class="modal-title">Tambah Kriteria</h4>
      <small class="font-bold"></small>
      </div>
      <form method="post" name="formulir" class="form-horizontal" enctype="multipart/form-data" >
      <div class="modal-body">
      <div class="form-group"><label class="col-sm-2 control-label">Nama Kriteria</label>
      <div class="col-sm-10"><input type="text"  value="<?php echo @$_SESSION['data']['nama_kriteria'] ?>" name="nama_kriteria"  class="form-control" required></div>
      </div>
      <div class="form-group"><label  class="col-sm-2 control-label">Jenis Kriteria</label>
      <div class="col-sm-10">
      <div class="radio i-checks">
        <label> <input type="radio" value="cf" name="jenis" required> <i></i> Core Factor </label>
        <label> <input type="radio" value="sf" name="jenis" required> <i></i> Secondary factor </label>
      </div>
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
<!-- -->

<!-- modal edit -->
<div class="modal inmodal fade" data-backdrop="static" id="modal_edit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
  <div class="modal-content">
  <div class="modal-header">
  <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
  <h4 class="modal-title">Edit Kriteria</h4>
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
  <h4 class="modal-title">Hapus Kriteria</h4>
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
            $.post('edit_kriteria.php',
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
            $.post('delete_kriteria.php',
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
            $("#add_kriteria").modal('show');
        });
    });
</script>

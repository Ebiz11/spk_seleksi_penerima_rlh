<?php
include ("cek_level.php");
require ("library.php");
$login= new login();
$individu= new individu();
unset($_SESSION['data']);
unset($_SESSION['gagal']);
unset($_SESSION['berhasil']);

// tambah
// if(isset($_POST['tambah'])){
//
// $username=$login->input_form($_POST['username']);
// $password=$login->input_form($_POST['password']);
// $nama_lengkap=$login->input_form($_POST['nama_lengkap']);
// $encrypt=$login->encrypt($password);
// $cek=$login->cek_username($username);
// $data_username=$cek->fetch(PDO::FETCH_ASSOC);
// $usernamenya=empty($data_username['username'])?'':$data_username['username'];
//
// if ($usernamenya==$_POST['username']) {
//     $_SESSION['gagal'] = '<b>GAGAL DISIMPAN:</b> username sudah ada yang menggunakan ';
//     $_SESSION['data'] =$_POST;
//
// }else{
//     $add=$login->add_user($username,$encrypt,$nama_lengkap,$_POST['level']);
//     $_SESSION['berhasil'] = '<b>BERHASIL DISIMPAN:</b>Data Admin berhasil ditambahkan.';
//   }
// }

if (isset($_POST['tambah'])) {
  $username=$login->input_form($_POST['username']);
  $password=$login->input_form($_POST['password']);

  $cek_penduduk=$individu->detail_penduduk($username);
  $hasil_cek=$cek_penduduk->fetch(PDO::FETCH_ASSOC);

  $encrypt=$login->encrypt($password);
  $cek=$login->cek_username($username);
  $data_username=$cek->fetch(PDO::FETCH_ASSOC);
  $usernamenya=empty($data_username['username'])?'':$data_username['username'];
  if ($hasil_cek['nik']!=$username) {
    $_SESSION['gagal'] = '<b>GAGAL DISIMPAN:</b> No Ktp tidak terdaftar! ';
    $_SESSION['data'] =$_POST;
  }elseif ($usernamenya==$_POST['username']) {
      $_SESSION['gagal'] = '<b>GAGAL DISIMPAN:</b> username sudah ada yang menggunakan ';
      $_SESSION['data'] =$_POST;

  }else{
      $add=$login->add_user($username,$encrypt,$_POST['level']);
      $_SESSION['berhasil'] = '<b>BERHASIL DISIMPAN:</b>Data Admin berhasil ditambahkan.';
    }
}

// hapus
if(isset($_POST['hapus'])){
  $del=$login->del_user($_POST['username']);
  $_SESSION['berhasil'] = '<b>BERHASIL MENGHAPUS:</b> Data Admin berhasil dihapus.';
}
?>
<div class="row wrapper border-bottom white-bg page-heading">
  <div class="col-lg-9">
      <h2>Daftar Admin</h2>
      <ol class="breadcrumb">
          <li>
              <a href="index.html">Home</a>
          </li>
          <li>
              <a>User</a>
          </li>
          <li class="active">
              <strong>Manajemen User</strong>
          </li>
      </ol>
  </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
      <div class="row">
          <div class="col-lg-12">
          <div class="ibox float-e-margins">
              <div class="ibox-title">
                  <!-- <h5>Daftar Admin</h5> -->
                  <div class="ibox-tools">
                      <a class="collapse-link">
                          <i class="fa fa-chevron-up"></i>
                      </a>
                      <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                          <i class="fa fa-wrench"></i>
                      </a>
                      <ul class="dropdown-menu dropdown-login">
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
                <th>No Ktp</th>
                <th>Nama Lengkap</th>
                <th>Level</th>
                <th>Tanggal</th>
                <th>Aksi</th>
              </tr>
              </thead>
              <tbody>

              <?php
              $no=1;
              foreach ($login->users() as $data_user) {

              ?>

              <tr class="gradeX">
                  <td><?php echo $no++ ?></td>
                  <td><?php echo $data_user['username'] ?></td>
                  <?php
                  $cek_penduduk=$individu->detail_penduduk($data_user['username']);
                  $hasil_cek=$cek_penduduk->fetch(PDO::FETCH_ASSOC);
                   ?>
                  <td><?php echo $hasil_cek['nama'] ?></td>
                  <td> <?php if ($data_user['level']==1) { echo "Super Admin"; }else { echo "User Admin"; } ?> </td>
                  <td><?php echo date("d-m-Y", strtotime($data_user['tanggal'])) ?></td>
                  <td> <a class="hapus-record btn btn-sm btn-danger" href="#" data-id="<?php echo $data_user['username'] ?>"><i class="fa fa fa-trash"></i></a></td>
              </tr>
              <?php }?>
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

<!-- tambah user -->
      <div class="modal inmodal fade" data-backdrop="static" id="add_user" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog">
      <div class="modal-content">
      <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
      <h4 class="modal-title">Tambah User</h4>
      <small class="font-bold"></small>
      </div>
      <form method="post" name="formulir" class="form-horizontal" enctype="multipart/form-data" >
      <div class="modal-body">
          <div class="form-group"><label class="col-sm-2 control-label">No Ktp</label>
            <div class="col-sm-10">
              <div class="col-sm-10"><input type="text" list="penduduk" id="nik" value="<?php echo @$_SESSION['data']['username'] ?>" name="username" class="form-control" maxlength="16" required></div>
          </div>
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
          <div class="form-group"><label class="col-sm-2 control-label">Password</label>
            <div class="col-sm-10">
              <div class="col-sm-10"><input type="password" value="<?php echo @$_SESSION['data']['password'] ?>" name="password" placeholder="Maksimal 20 karakter" class="form-control" maxlength="20" required></div>
          </div>
          </div>
          <div class="form-group"><label class="col-sm-2 control-label">Nama Lengkap</label>
            <div class="col-sm-10">
              <div class="col-sm-10"><input type="text" id="username" value="<?php echo @$_SESSION['data']['nama_lengkap'] ?>" name="nama_lengkap" placeholder="Maksimal 30 karakter" maxlength="30" class="form-control" required></div>
          </div>
          </div>
          <div class="form-group"><label class="col-sm-2 control-label">Level</label>
            <div class="col-sm-10">
            <div class="radio i-checks">
              <label> <input type="radio" value="1" name="level" required> <i></i>Super Admin</label>
              <label> <input type="radio" value="2" name="level" required> <i></i>Admin</label></div>
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

      <!-- modal hapus -->
      <div class="modal inmodal fade" data-backdrop="static" id="modal_hapus" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title">Hapus User</h4>
        <small class="font-bold"></small>
        </div>
        <form method="post" name="formulir" class="form-horizontal" enctype="multipart/form-data" >
        <div class="modal-body"> <div class="hapus"> </div> </div>
        <div class="modal-footer">
        <button type="button" class="btn btn-white" data-dismiss="modal">Batal</button>
        <button class="btn btn-primary" type="submit" name="hapus">Simpan</button>
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
      $('#username').val(data[0].nama);
      },'json'
      );
      });
      });

          $(function(){
              $(document).on('click','.hapus-record',function(e){
                  e.preventDefault();
                  $("#modal_hapus").modal('show');
                  $.post('delete_user.php',
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
                  $("#add_user").modal('show');
              });
          });
      </script>

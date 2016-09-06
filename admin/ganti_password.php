<?php
include ("cek_session.php");
require ("library.php");
$login= new login();

if(isset($_POST['button'])){
 $tampil_password=$login->login($_SESSION['login']);
 $data_password=$tampil_password->fetch(PDO::FETCH_ASSOC);

 $password=$login->input_form($_POST['password_lama']);
 $encrypt=$login->encrypt($password);
 $password_baru=$login->encrypt($_POST['password_baru']);

 $passwordnya=empty($data_password['password'])?'':$data_password['password'];
    if ($encrypt==$passwordnya AND $_POST['password_baru']==$_POST['password_konfirm']) {
      $update=$login->update_password($_SESSION['login'], $password_baru);
      $_SESSION['success'] = '<b>BERHASIL MENYIMPAN:<b> Password anda telah diperbaharui.';

    }elseif ($_POST['password_baru']==$_POST['password_konfirm'])  {
      $_SESSION['gagal'] = '<b>GAGAL MENYIMPAN:<b> Password lama anda salah.';
    }else {
      $_SESSION['gagal'] = '<b>GAGAL MENYIMPAN<b:<b> Password baru dan konfirmasi password anda tidak sama.';
    }
     //echo "<script>document.location='index.php?page=ganti_password';</script>";
 }
?>

<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Ganti Password</h2>
        <ol class="breadcrumb">
            <li>
                <a href="index.html">Home</a>
            </li>
            <li>
                <a>User</a>
            </li>
            <li class="active">
                <strong>Ganti Password</strong>
            </li>
        </ol>
    </div>
    <div class="col-lg-2">
    </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
<div class="row">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <!-- <h5>Ganti Password</h5> -->
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
                <form method="post" class="form-horizontal">
                    <div class="form-group"><label class="col-sm-2 control-label">Password Baru</label>
                      <div class="col-sm-10">
                        <div class="col-sm-10"><input type="password" name="password_baru" placeholder="Masukan password baru" class="form-control" required></div>
                    </div>
                    </div>
                    <div class="form-group"><label class="col-sm-2 control-label">Konfirmasi Password</label>
                      <div class="col-sm-10">
                        <div class="col-sm-10"><input type="password"  name="password_konfirm" placeholder="Masukan kembali password baru" class="form-control" required></div>
                    </div>
                    </div>
                    <div class="form-group"><label class="col-sm-2 control-label">Password Lama</label>
                      <div class="col-sm-10">
                        <div class="col-sm-10"><input type="password" name="password_lama" placeholder="Masukan password lama" class="form-control" required></div>
                    </div>
                    </div>
                    <div class="hr-line-dashed"></div>
                    <div class="form-group">
                        <div class="col-sm-4 col-sm-offset-2">
                            <a href="index?page=home" type="button" class="btn btn-white" >Cancel</a>
                            <button class="btn btn-primary" type="submit" name="button">Save</button>
                            <button class="btn btn-warning" type="reset" name="reset">Reset</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function(){setTimeout(function(){$(".success").fadeIn('slow');}, 500);});
    setTimeout(function(){$(".success").fadeOut('slow');}, 2000);

</script>

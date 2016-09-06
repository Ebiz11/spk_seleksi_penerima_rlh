<?php
include ("cek_level.php");
require ("library.php");
$individu= new individu();
$profile_matching= new profile_matching();
$qrey=$profile_matching->show_standar_profile();
$jum_standar_profile=$qrey->rowCount();
$qrey3=$profile_matching->show_kriteria();
$jum_kriteria=$qrey3->rowCount();
if ($jum_kriteria==$jum_standar_profile) {
 ?>
<div class="row wrapper border-bottom white-bg page-heading">
  <div class="col-lg-9">
    <h2>Analisa SPK </h2>
    <ol class="breadcrumb">
    <li>
        <a href="index?page=home">Home</a>
    </li>
    <li class="active">
        <strong>Analisa SPK </strong>
    </li>
    </ol>
  </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
  <div class="row">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <!-- <h5>Analisa SPK Profil Matching</h5> -->
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
              <!-- notifikasi --> <?php include ("notifikasi.php"); $no=1; ?> <!--  -->
            <form method="post" class="form-horizontal" action="index.php?page=hasil_analisis">
              <div class="col-lg-2">
              <button type="submit" class="btn btn-info">Analisa</button>
              </div><br><br><br>
              <table class="table table-striped">
              <thead>
                <tr>
                  <th></th>
                  <th>No</th>
                  <th>Nama </th>
                  <th>No KTP</th>
                  <th>KSM</th>
                  <th>Keterangan</th>
              </tr>
              </thead>
              <tbody>
              <?php
              $analisa=$individu->show_calon_penerima_analisa("P", "Y");
              while ($data_analisa=$analisa->fetch(PDO::FETCH_ASSOC)){
              ?>
              <tr class="gradeX">
                <!-- cek penilaian, standar profile dan kriteria -->
                <?php
                $qrey1=$profile_matching->cek_penilaian($data_analisa['id_calon_penerima']);
                $jum_nilai_individu=$qrey1->rowCount();
                if ($jum_standar_profile==$jum_nilai_individu) { $b="checked"; $c=""; $d=1; }else{ $b=""; $c="disabled"; $d=2;}
                ?>
                <!--  -->
                <td><input type="checkbox" <?php echo $b; echo $c; ?> class="i-checks" name="pilih[]" value="<?php echo $data_analisa['id_calon_penerima'] ?>"></td>
                <?php
      					$data_penduduk=$individu->detail_penduduk($data_analisa['no_ktp']);
      					$tampil_penduduk=$data_penduduk->fetch(PDO::FETCH_ASSOC);
                 ?>
                <td><?php echo $no++ ?></td>
                <td><a href="index?page=detail_calon_penerima&id_calon_penerima=<?php echo $data_analisa['id_calon_penerima'] ?> "> <?php echo $tampil_penduduk['nama'] ?></a></td>
                <td><?php echo $data_analisa['no_ktp'] ?></td>
                <?php $cek_ksm=$individu->detail_ksm($data_analisa['id_ksm']);
                $data_ksm=$cek_ksm->fetch(PDO::FETCH_ASSOC); ?>
                <td><a href="index?page=detail_ksm&id_ksm=<?php echo $data_ksm['id_ksm'] ?> "><?php echo $data_ksm['nama_ksm'] ?></a></td>
                <td>
                  <?php
                  $cek_status=$profile_matching->status_penilaian($data_analisa['id_calon_penerima']);
                  if ($d==1) { ?> <span class="label label-info">Data Penilaian Lengkap</span>
                  <?php }else{ ?> <a href="index?page=nilai_calon_penerima&id_calon_penerima=<?php echo $data_analisa['id_calon_penerima'] ?>"> <span class="label label-danger">Data Penilaian Tidak Lengkap</span></a>
                  <?php } ?>
               </td>
              </tr>
              <?php } ?>
              </tbody>
            </table>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
<?php }else{
  $_SESSION['gagal']='Silahkan Lengkapi Data Standar Profile';
  echo "<script>document.location='index.php?page=standar_profile';</script>";
} ?>

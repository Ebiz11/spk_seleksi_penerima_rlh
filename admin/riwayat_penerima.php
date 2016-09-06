<?php
include ("cek_session.php");
require ("library.php");
$profile_matching= new profile_matching();
$individu=new individu();
$no_ktp=$_GET['no_ktp'];
?>
<div class="row wrapper border-bottom white-bg page-heading">
              <div class="col-lg-9">
                  <h2>Riwayat Pengajuan</h2>
                  <ol class="breadcrumb">
                      <li>
                          <a href="index?page=home">Home</a>
                      </li>
                      <li class="active">
                          <strong>Riwayat Pengajuan</strong>
                      </li>
                  </ol>
              </div>
          </div>
<div class="wrapper wrapper-content animated fadeInRight">
      <div class="row">
          <div class="col-lg-12">
          <div class="ibox float-e-margins">
              <div class="ibox-title">
                  <h5>Riwayat Pengajuan</h5>
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
              <table class="table table-striped table-bordered table-hover dataTables-example" >
              <thead>
              <tr>
                <th>No</th>
                <th>Nama</th>
                <th>No Ktp</th>
                <th>KSM</th>
                <th>Status</th>
                <th>Tanggal</th>
              </tr>
              </thead>
              <tbody>

                <?php
                    $no=1;
                    $riwayat=$individu->show_riwayat_penerima($no_ktp);
                    while ($data_calon_penerima = $riwayat->fetch(PDO::FETCH_ASSOC)){

                    $data_penduduk=$individu->detail_penduduk($data_calon_penerima['no_ktp']);
                    $tampil_penduduk=$data_penduduk->fetch(PDO::FETCH_ASSOC);
                ?>
                  <tr class="gradeX">
                      <td><?php echo $no++ ?></td>
                      <td><a href="index?page=detail_calon_penerima&id_calon_penerima=<?php echo $data_calon_penerima['id_calon_penerima'] ?>">
                        <?php echo $tampil_penduduk['nama']; ?></a>
                      </td>
                      <td><?php echo $data_calon_penerima['no_ktp'] ?></td>
                      <td><a href="index?page=detail_ksm&id_ksm=<?php echo $data_calon_penerima['id_ksm'] ?>">
                        <?php
                        $ambil_ksm=$individu->detail_ksm($data_calon_penerima['id_ksm']);
                        $data_ksm=$ambil_ksm->fetch(PDO::FETCH_ASSOC);
                        echo $data_ksm['nama_ksm']
                        ?></a>
                      </td>
                      <td>
                        <?php if ($data_calon_penerima['status_diterima']=="Y") { ?> <span class="label label-info">Diterima</span>
                        <?php } elseif($data_calon_penerima['status_diterima']=="N"){ ?> <span class="label label-danger">Ditolak</span>
                        <?php }else {?> <span class="label label-warning">Belum dianalisa</span>
                        <?php } ?>
                      </td>
                      <td><?php echo date("d-m-Y", strtotime($data_calon_penerima['tanggal'])) ?></td>
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

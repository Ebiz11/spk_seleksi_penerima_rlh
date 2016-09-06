<?php
include ("cek_session.php");
$id_analisa=$_GET['id_analisa'];
 ?>
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-9">
        <h2>Hasil Analisa</h2>
        <ol class="breadcrumb">
            <li>
                <a href="index?page=home">Home</a>
            </li>
                <li>
                    <a href="index?page=home">Laporan</a>
                </li>
            <li class="active">
                <strong>Hasil Analisa</strong>
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
          <table class="table table-striped table-bordered table-hover dataTables-example" >
          <thead>
          <tr>
              <th>Ranking </th>
              <th>Nama </th>
              <th>KSM</th>
              <th>No Ktp</th>
              <?php if ($_SESSION['level'] == "1") {?>
              <th>Nilai Profile</th>
              <?php } else{}?>
              <th>Riwayat Bantuan</th>
              <th>Status</th>
              <th>Tanggal</th>
          </tr>
          </thead>
          <tbody>

            <?php
            require ("library.php");
        		$individu= new individu();
            $no=1;
            $jum_tot_nilai=0;
            $jum_cal_penerima=0;
            foreach ($individu->lap_update_id_analisa($id_analisa) as $data_calon_penerima) {
            ?>

            <tr class="gradeX">
            <td><?php echo $no++ ?></td>
            <?php extract($individu->det_penduduk($data_calon_penerima['no_ktp'])); ?>
            <td><a href="index?page=detail_calon_penerima&id_calon_penerima=<?php echo $data_calon_penerima['id_calon_penerima'] ?>"><?php echo $nama ?></a> </td>
            <?php
            $ksm=$individu->detail_ksm($data_calon_penerima['id_ksm']);
            $dataksm=$ksm->fetch(PDO::FETCH_ASSOC);
             ?>
            <td><a href="index?page=detail_ksm&id_ksm=<?php echo $dataksm['id_ksm'] ?>"> <?php echo $dataksm['nama_ksm'] ?></a></td>
            <td><?php echo $data_calon_penerima['no_ktp'] ?></td>
            <?php if ($_SESSION['level'] == "1") {?>
            <td><a href="index?page=detail_nilai&id_calon_penerima=<?php echo $data_calon_penerima['id_calon_penerima'] ?>"><?php echo number_format($data_calon_penerima['tot_nilai'],2) ?></a></td>
            <?php } else{}?>
            <td><a href="index?page=riwayat_penerima&no_ktp=<?php echo $data_calon_penerima['no_ktp'] ?>">Lihat</a></td>
            <td>
              <?php
              if ($data_calon_penerima['status_diterima']=="Y") { ?>
                <span class="label label-info">Diterima</span>
              <?php } elseif($data_calon_penerima['status_diterima']=="N"){ ?>
                  <span class="label label-danger">Ditolak</span>
              <?php }else {?>
                  <span class="label label-warning">Belum dianalisa</span>
              <?php } ?>
            </td>
            <td><?php echo date("d-m-Y", strtotime($data_calon_penerima['tanggal_proses'])) ?></td>
            </tr>
            <?php
            $jum_cal_penerima=$jum_cal_penerima+1;
            $jum_tot_nilai=$jum_tot_nilai+$data_calon_penerima['tot_nilai'];
            $rata2=$jum_tot_nilai/$jum_cal_penerima;
            }; ?>

          </tbody>
          <?php if ($_SESSION['level'] == "1") {?>
          <tfoot>
          <tr>
            <th colspan="4"><center>RATA-RATA</center></th>
            <th><?php echo number_format($rata2,2) ?></th>
            <th colspan="3"></th>
          </tr>
          </tfoot>
          <?php } else{}?>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

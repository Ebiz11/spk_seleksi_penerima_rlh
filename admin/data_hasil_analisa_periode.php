<?php
include ("cek_session.php"); ?>
<div class="row wrapper border-bottom white-bg page-heading">
  <div class="col-lg-9">
    <h2>Hasil Analisa</h2>
    <ol class="breadcrumb">
      <li>
          <a href="index?page=home">Home</a>
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
          <h5>Hasil Analisa</h5>
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
          <th>Periode</th>
          <th>Diterima</th>
          <th>Ditolak</th>
          <th>Total</th>
          <th>Detail</th>
          <th>Tanggal Analisa</th>
        </tr>
        </thead>
          <tbody>
            <?php
            require ("library.php");
            $individu= new individu();
            $profile_matching= new profile_matching();
            $no=1;
            $lap_analisa=$profile_matching->lap_analisa();
            while ($data_analisa = $lap_analisa->fetch(PDO::FETCH_ASSOC)){
            ?>
            <tr class="gradeX">
              <td><?php echo $no++ ?></td>
              <td><?php echo $data_analisa['jumlah_diterima'] ?></td>
              <td><?php echo $data_analisa['jumlah_ditolak'] ?></td>
              <td><?php echo $jum_tot=$data_analisa['jumlah_ditolak']+$data_analisa['jumlah_diterima']; ?></td>
              <td><a href="index?page=lap_detail_analisa&id_analisa=<?php echo $data_analisa['id_analisa'] ?>">Lihat</a></td>
              <td><?php echo date("d-m-Y", strtotime($data_analisa['tanggal_proses'])) ?></td>
            </tr>
            <?php } ?>
          </tbody>
        </table>
        </div>
      </div>
    </div>
  </div>
</div>

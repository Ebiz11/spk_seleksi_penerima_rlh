<?php
include ("cek_session.php");
 ?>
 <div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-9">
        <h2>Data Calon Penerima</h2>
        <ol class="breadcrumb">
            <li>
                <a href="index?page=home">Home</a>
            </li>
            <li class="active">
                <strong>Data Calon Penerima</strong>
            </li>
        </ol>
    </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
  <div class="row">
    <div class="col-lg-12">
      <div class="ibox float-e-margins">
        <div class="ibox-title">
          <!-- <h5>Calon Penerima</h5> -->
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
                <th>No </th>
                <th>Nama</th>
                <th>No Ktp</th>
                <th>KSM</th>
                <th>Tanggal</th>
            </tr>
            </thead>
            <tbody>
              <?php
              require ("library.php");
          		$individu= new individu();
              $no=1;
              $calon_penerima = $individu->show_calon_penerima("P");
              while ($data_calon_penerima = $calon_penerima->fetch(PDO::FETCH_ASSOC)){
              ?>
              <tr class="gradeX">
                <td><?php echo $no++ ?> </td>
                <?php
                $data_penduduk=$individu->detail_penduduk($data_calon_penerima['no_ktp']);
                $tampil_penduduk=$data_penduduk->fetch(PDO::FETCH_ASSOC);
                 ?>
                <td><a href="index?page=detail_calon_penerima&id_calon_penerima=<?php echo $data_calon_penerima['id_calon_penerima'] ?>"><?php echo $tampil_penduduk['nama'] ?></a></td>
                <?php
                $ksm = $individu->detail_ksm($data_calon_penerima['id_ksm']);
                $dataksm = $ksm->fetch(PDO::FETCH_ASSOC);
                 ?>
                <td><?php echo $data_calon_penerima['no_ktp'] ?></td>
                <td><a href="index?page=detail_ksm&id_ksm=<?php echo $dataksm['id_ksm'] ?>"><?php echo $dataksm['nama_ksm'] ?></a></td>
                <td><?php echo date("d-m-Y",strtotime($data_calon_penerima['tanggal'])) ?></td>
              </tr>
              <?php }; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

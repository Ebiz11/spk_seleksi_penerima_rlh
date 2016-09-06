<?php
include ("cek_level.php");
require "library.php";
$individu=new individu();
unset ($_SESSION['cari']);

if (isset($_POST['cari'])) {

  $start=date("Y-m-d", strtotime($_POST['start']));
  $end=date("Y-m-d", strtotime($_POST['end']));

  $lap_penerima=$individu->cari_penerima($start, $end, "Y");
  $_SESSION['berhasil']='<b>Hasil filter data dari '.date("d-m-Y",strtotime($start)).' sampai '.date("d-m-Y",strtotime($end)).'</b>';
  $row=$lap_penerima->rowCount();
  if ($row < 1) { $_SESSION['warning']='<b>Tidak ada data yang dapat ditampilkan. </b>'; }
}else {
  $lap_penerima=$individu->show_calon_penerima("Y");
}

 ?>
 <div class="row wrapper border-bottom white-bg page-heading">
   <div class="col-lg-9">
       <h2>Laporan Penerima Manfaat</h2>
       <ol class="breadcrumb">
           <li>
               <a href="index?page=home">Home</a>
           </li>
           <li class="active">
               <strong>Laporan Penerima Manfaat</strong>
           </li>
       </ol>
   </div>
  </div>
<div class="wrapper wrapper-content animated fadeInRight">
      <div class="row">
          <div class="col-lg-12">
          <div class="ibox float-e-margins">
              <div class="ibox-title">
                  <!-- <h5>Laporan Penerima Manfaat</h5> -->
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
                <form method="post">
                  <div class="form-group" id="data_5">
                  <label class="font-noraml">Filter Data</label>
                  <div class="input-daterange input-group" id="datepicker">
                  <input type="text" class="input-sm form-control"  name="start" value="<?php date("d-m-Y") ?>" required />
                  <span class="input-group-addon"> sampai </span>
                  <input type="text" class="input-sm form-control"  name="end" value="<?php date("d-m-Y") ?>" required />
                  </div>
                  </div>
                  <button type="submit" name="cari" class="btn btn-primary">Tampil</button><br>
                </form>
                <form action="invoice_penerima.php" method="post">
                    <input type="hidden" name="start" value="<?php echo $start ?>">
                    <input type="hidden" name="end" value="<?php echo $end ?>">
                    <input type="hidden" name="status" value="Y">
                  <button target="_blank" class="btn btn-info" type="submit"><i class="fa fa-print"></i> Print </button>
                </form>
                <br><br>
              <table class="table table-striped table-bordered table-hover dataTables-example" >
              <thead>
              <tr>
                  <th>No </th>
                  <th>Nama </th>
                  <th>No Ktp</th>
                  <th>KSM</th>
                  <th>Tanggal Analisa</th>
              </tr>
              </thead>
              <tbody>

                <?php
                    $no=1;
                    while ($datalap_penerima = $lap_penerima->fetch(PDO::FETCH_ASSOC))
                    {
                ?>
                  <tr class="gradeX">
                      <td><?php echo $no++ ?></td>
                      <?php
                      $data_penduduk=$individu->detail_penduduk($datalap_penerima['no_ktp']);
                      $tampil_penduduk=$data_penduduk->fetch(PDO::FETCH_ASSOC);
                       ?>
                      <td><a href="index?page=detail_calon_penerima&id_calon_penerima=<?php echo $datalap_penerima['id_calon_penerima'] ?>"><?php echo $tampil_penduduk['nama'] ?></a></td>
                      <td><?php echo $datalap_penerima['no_ktp']; ?></td>
                      <?php
                      $ksm = $individu->detail_ksm($datalap_penerima['id_ksm']);
                      $dataksm = $ksm->fetch(PDO::FETCH_ASSOC);
                      ?>
                      <td><a href="index?page=detail_ksm&id_ksm=<?php echo $dataksm['id_ksm'] ?> "> <?php echo $dataksm['nama_ksm'] ?></a></td>
                      <td><?php echo date("d/m/Y", strtotime($datalap_penerima['tanggal_proses'])) ?></td>

                  </tr>
                  <?php } ?>
              </tbody>
              <tfoot>
              </tfoot>
              </table>

              </div>
          </div>
      </div>
      </div>
      </div>

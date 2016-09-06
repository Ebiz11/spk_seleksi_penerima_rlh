<?php

if(empty($_POST['start']) OR empty($_POST['end']) OR empty($_POST['status'])){
echo "<script>document.location='index.php?page=home';</script>";
}else{

session_start();
include ("cek_level.php");
require "library.php";
$individu=new individu();
$start=$_POST['start'];
$end=$_POST['end'];
$status=$_POST['status'];
$no=1;

if($start==0 AND $end==0 AND $status=="Y"){
  $lap_penerima=$individu->show_calon_penerima("Y");
}elseif ($start==0 AND $end==0 AND $status=="N") {
  $lap_penerima=$individu->show_calon_penerima("N");
}else {
  $lap_penerima=$individu->cari_penerima($start, $end, $status);
}

 ?>
<!DOCTYPE html>
<html>
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Cetak Data</title>

    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <link href="../font-awesome/css/font-awesome.css" rel="stylesheet">

    <link href="../css/animate.css" rel="stylesheet">
    <link href="../css/style.css" rel="stylesheet">

</head>

<body class="white-bg">
<div class="wrapper wrapper-content p-xl">
  <?php
  if ($status=="Y") {?>
    <center><h2>LAPORAN PENERIMA MANFAAT</h2></center>
  <?php }else{ ?>
    <center><h2>LAPORAN PENGAJUAN DITOLAK</h2></center>
  <?php } ?>
    <div class="ibox-content p-xl">
            <div class="row">
                <div class="col-sm-6">
                    <h5>From:</h5>
                    <address>
                        <strong>Tamanmartani</strong><br>
                        Sleman<br>
                        D.I. Yogyakarta<br>
                        Telp: +62 274 492008<br>
                    </address>
                </div>

                <div class="col-sm-6 text-right">
                    <h4></h4>
                    <h4 class="text-navy"></h4>
                    <span></span>
                    <address>
                        <strong></strong><br>
                        <br>
                        <br>
                        <abbr title="Phone"></abbr>
                    </address>
                    <p>
                        <span><strong></strong></span><br/>
                        <span><strong>Tanggal: </strong><?php echo date("d-m-Y"); ?></span>
                    </p>
                </div>
            </div>
            <hr>
            <div class="table-responsive m-t">
                <table class="table table-hover">
                    <thead>
                    <tr>
                      <th>No </th>
                      <th>Nama </th>
                      <th>Alamat</th>
                      <th>No Ktp</th>
                      <th>KSM</th>
                      <th>Tanggal Analisa</th>
                    </tr>
                    </thead>
                    <tbody>
                      <?php
                      while ($datalap_penerima = $lap_penerima->fetch(PDO::FETCH_ASSOC)) {
                      ?>
                    <tr>
                      <td><?php echo $no++ ?></td>
                      <?php
                      $data_penduduk=$individu->detail_penduduk($datalap_penerima['no_ktp']);
                      $tampil_penduduk=$data_penduduk->fetch(PDO::FETCH_ASSOC);
                       ?>
                      <td><?php echo $tampil_penduduk['nama'] ?></td>
                      <td><?php echo $tampil_penduduk['alamat']; ?></td>
                      <td><?php echo $datalap_penerima['no_ktp']; ?></td>
                      <?php
                      $ksm = $individu->detail_ksm($datalap_penerima['id_ksm']);
                      $dataksm = $ksm->fetch(PDO::FETCH_ASSOC);
                      ?>
                      <td> <?php echo $dataksm['nama_ksm'] ?></td>
                      <td><?php echo date("d/m/Y", strtotime($datalap_penerima['tanggal_proses'])) ?></td>
                    </tr>
                    <?php } ?>
                    </tbody>
                </table>
                <hr>
            </div><!-- /table-responsive -->

            <table class="table invoice-total">
                <tbody>
                <tr>
                    <td><strong>Total :</strong></td>
                    <td><?php echo $jum= $lap_penerima->rowCount();?> Orang</td>
                </tr>
                <tr>
                    <td><strong>Dicetak Oleh :</strong></td>
                    <td><?php echo $_SESSION['nama']?></td>
                </tr>
                </tbody>
            </table>
            <!-- <div class="well m-t"><strong>Comments</strong>
                It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less
            </div> -->
        </div>
    </div>

    <!-- Mainly scripts -->
    <script src="../js/jquery-2.1.1.js"></script>
    <script src="../js/bootstrap.min.js"></script>
    <script src="../js/plugins/metisMenu/jquery.metisMenu.js"></script>
    <!-- Custom and plugin javascript -->
    <script src="../js/inspinia.js"></script>

    <script type="text/javascript">
        window.print();
    </script>
</body>
</html>
<?php } ?>

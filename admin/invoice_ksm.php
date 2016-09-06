<?php
session_start();
include ("cek_level.php");
require "library.php";
$individu=new individu();
$no=1;

if($_POST['start']==0 AND $_POST['end']==0){
  $lap_ksm=$individu->show_ksm_status("Y");
}else {
  $start=$_POST['start'];
  $end=$_POST['end'];
  $lap_ksm=$individu->cari_ksm($start, $end);
}

 ?>
<!DOCTYPE html>
<html>
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>INSPINIA | Invoice Print</title>

    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <link href="../font-awesome/css/font-awesome.css" rel="stylesheet">

    <link href="../css/animate.css" rel="stylesheet">
    <link href="../css/style.css" rel="stylesheet">

</head>

<body class="white-bg">
<div class="wrapper wrapper-content p-xl">
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
                    <th>No</th>
                    <th>Nama KSM</th>
                    <th>Lokasi</th>
                    <th>PNPM-MP</th>
                    <th>REALISASI SWADAYA</th>
                    <th>JUMLAH BIAYA</th>
                    <th>Tanggal</th>
                  </tr>
                  </thead>
                  <tbody>
                    <?php
                    $jum1=0;$jum2=0;$jum3=0;
                        while ($data_ksm=$lap_ksm->fetch(PDO::FETCH_ASSOC)){
                    ?>
                  <tr>
                    <td><?php echo $no++ ?></td>
                    <td><?php echo $data_ksm['nama_ksm'] ?></td>

                    <td><?php echo $data_ksm['lokasi'] ?> </td>
                    <td><?php echo number_format ($data_ksm['pnpm_mp'],0,',','.'); ?></td>
                    <td><?php echo number_format ($data_ksm['swadaya'],0,',','.'); ?></td>
                    <?php
                    $jum_biaya=$data_ksm['pnpm_mp']+$data_ksm['swadaya'];
                     ?>
                    <td><?php echo number_format ($jum_biaya,0,',','.') ?></td>
                    <?php $jum1=$jum1+$data_ksm['pnpm_mp']; ?>
                    <?php $jum2=$jum2+$data_ksm['swadaya']; ?>
                    <?php $jum3=$jum3+$jum_biaya; ?>
                    <td><?php echo date("d/m/Y", strtotime($data_ksm['tanggal'])) ?></td>
                  </tr>
                  <?php } ?>
                  </tbody>
                  <tr>
                    <th colspan="3"><center>TOTAL</ center></th>
                    <th><?php echo number_format($jum1,0,',','.') ?></th>
                    <th><?php echo number_format($jum2,0,',','.') ?></th>
                    <th><?php echo number_format($jum3,0,',','.') ?></th>
                    <th></th>
                  </tr>
                  </tfoot>
              </table>
              <hr>
          </div><!-- /table-responsive -->

          <table class="table invoice-total">
              <tbody>
              <tr>
                  <td><strong>TOTAL PNPM :</strong></td>
                  <td><?php echo number_format($jum1,0,',','.') ?></td>
              </tr>
              <tr>
                  <td><strong>SWADAYA :</strong></td>
                  <td><?php echo number_format($jum2,0,',','.') ?></td>
              </tr>
              <tr>
                  <td><strong>JUMLAH TOTAL :</strong></td>
                  <td><?php echo number_format($jum3,0,',','.') ?></td>
              </tr>
              <tr>
                  <td><strong>JUMLAH KSM :</strong></td>
                  <td><?php echo $jum= $lap_ksm->rowCount();?> KSM</td>
              </tr>
              <tr>
                  <td><strong>Dicetak Oleh :</strong></td>
                  <td><?php echo $_SESSION['nama']?></td>
              </tr>

              </tbody>
          </table>
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

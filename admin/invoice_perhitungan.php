<?php
if(empty($_POST['id'])){
echo "<script>document.location='index.php?page=home';</script>";
}else{
session_start();
include ("cek_level.php");
require ("library.php");
$individu= new individu();
//$login= new login();
$profile_matching= new profile_matching();
$id_calon_penerima=$_POST['id'];
//$id_calon_penerima="2";
$detail=$individu->detail_calon_penerima($id_calon_penerima);
$data_detail=$detail->fetch(PDO::FETCH_ASSOC);
$ksm=$individu->detail_ksm($data_detail['id_ksm']);
$data_ksm=$ksm->fetch(PDO::FETCH_ASSOC);

 ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rincian Perhitungan</title>
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
                  <strong>Kelurahan Tamanmartani</strong><br>
                  Sleman<br>
                  D.I. Yogyakarta<br>
                  <abbr title="Phone">Telp: </abbr> +62 274 492008
              </address>
          </div>

          <div class="col-sm-6 text-right">
              <span>To:</span>
              <address>
              <?php
              $data_penduduk=$individu->detail_penduduk($data_detail['no_ktp']);
              $tampil_penduduk=$data_penduduk->fetch(PDO::FETCH_ASSOC);
               ?>
                  <strong><?php echo $tampil_penduduk['nama'] ?></strong><br>
                  <?php echo $tampil_penduduk['alamat'] ?><br>
                  <?php echo $data_ksm['nama_ksm'] ?><br>
              </address>
              <p>
                  <span><strong>Tanggal Analisa:</strong> <?php echo date("d-m-Y", strtotime($data_detail['tanggal_proses'])) ?></span><br/>
              </p>
          </div>
      </div>

      <div class="table-responsive m-t">
        <div class="table-responsive m-t">
            <table class="table table-hover table-bordered">
                <thead>
                <tr>
                    <th><center>Nama Kriteria</center></th>
                    <th><center>Jenis Kriteria</center></th>
                    <th><center>Nilai Profile Individu</center></th>
                    <th><center>Nilai Standar Profile</center></th>
                    <th><center>Nilai GAP</center></th>
                    <th><center>Bobot Nilai GAP</center></th>
                </tr>
                </thead>
                <tbody>
                  <?php
                  $total_gap_core=0;
                  $total_gap_secondary=0;
                  $penilaian=$profile_matching->log_penilaian($id_calon_penerima);
                  while ($data_nilai=$penilaian->fetch(PDO::FETCH_ASSOC)){
                  ?>
                <tr>
                    <td><center><?php echo $data_nilai['nama_kriteria'] ?></center></td>
                    <td> <center> <?php if ($data_nilai['jenis_kriteria']=="cf"){ echo "Core"; }else{ echo "Secondary"; } ?> </center> </td>
                    <td><center><?php echo $data_nilai['nilai_profile_individu'] ?></center> </td>
                    <td><center><?php echo $data_nilai['nilai_standar_profile'] ?></center></td>
                    <td><center><?php echo $Gap=$profile_matching->gap($data_nilai['nilai_profile_individu'],$data_nilai['nilai_standar_profile']); ?></td>
                    <td><center>
                      <?php
                        echo $bobot_nilai_gap=$profile_matching->bobot_nilai_gap($Gap);
                        if ($data_nilai['jenis_kriteria']=="cf") {
                          $total_gap_core=$profile_matching->tambah($total_gap_core, $bobot_nilai_gap);
                        }else {
                          $total_gap_secondary=$profile_matching->tambah($total_gap_secondary, $bobot_nilai_gap);
                        }
                      ?></center>
                    </td>
                  </tr>
                <?php  }?>
                </tbody>
            </table>
            <hr>
        </div><!-- /table-responsive -->

        <table class="table invoice-total">
            <tbody>
            <tr>
                <td><strong>Total Nilai Core Factor :</strong></td>
                <td><?php echo $total_gap_core; ?></td>
            </tr>
            <tr>
                <td><strong>Total Nilai Secondary Factor :</strong></td>
                <td><?php echo $total_gap_secondary; ?></td>
            </tr>
            <tr>
                <td><strong>Rata-Rata Nilai Core Factor :</strong></td>
                <td>
                <?php
                $rata_core=$profile_matching->rata_rata_nilai("cf", $id_calon_penerima, $total_gap_core);
                echo number_format($rata_core,2);
                ?>
                </td>
            </tr>
            <tr>
                <td><strong>Rata-Rata Nilai Secondary Factor :</strong></td>
                <td>
                <?php
                $rata_secondary=$profile_matching->rata_rata_nilai("sf", $id_calon_penerima,$total_gap_secondary );
                echo number_format($rata_secondary,2);
                ?>
                </td>
            </tr>
            <tr>
                <td><strong>Total Nilai :</strong></td>
                <td><?php $total_nilai=$profile_matching->total_nilai($rata_core, $rata_secondary); echo number_format($total_nilai,2); ?></td>
            </tr>
            <tr>
                <td><strong>Status :</strong></td>
                <td> <?php if ($data_detail['status_diterima']=="Y") { echo "<b> DITERIMA </b>" ; }else{ echo "<b> DITOLAK </b>"; } ?> </td>
            </tr>
            <tr>
                <td><strong>Dicetak :</strong></td>
                <td> <?php echo date("d-m-Y"); ?> </td>
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

<?php } ?>

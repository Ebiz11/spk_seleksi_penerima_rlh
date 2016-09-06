<?php
if(empty($_POST['id'])){
echo "<script>document.location='index.php?page=home';</script>";
}else{
session_start();
include ("cek_level.php");
require ("library.php");
$individu= new individu();
$profile_matching= new profile_matching();
$id_analisa=$_POST['id'];
$tampil=$profile_matching->lap_analisa($id_analisa);

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
  <center><h2>LAPORAN PERHITUNGAN</h2></center>
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

                  <p>
                      <span><strong> </strong> </span><br/>

                  </p>
              </div>
          </div>
          <table class="table table-bordered">
          <thead>
        	<tr>
        	<th>Nama penerima</th>
        	<th>Keterangan</th>
          <?php
          $querykriteria=$profile_matching->lap_perhitungan_kriteria($id_analisa);
          while ($datakriteria = $querykriteria->fetch(PDO::FETCH_ASSOC)){
           ?>
        	<th><?php echo $datakriteria['nama_kriteria'] ?></th>
           <?php } ?>
        	</tr>
          </thead>
          <tbody>

            <!--  -->
        <?php
      	$i=0;
        $rata_rata_total_nilai=0;
        $jumlah_calon=0;
        $querypenerima=$individu->lap_hasil_analisa($id_analisa);
      	while ($datapenerima = $querypenerima ->fetch(PDO::FETCH_ASSOC)) {
        $tampil_calon_penerima=$individu->detail_calon_penerima($datapenerima['id_calon_penerima']);
        $data_calon_penerima=$tampil_calon_penerima->fetch(PDO::FETCH_ASSOC);
        $data_penduduk=$individu->detail_penduduk($data_calon_penerima['no_ktp']);
        $tampil_penduduk=$data_penduduk->fetch(PDO::FETCH_ASSOC);
        $nama_calon=empty($tampil_penduduk['nama'])?'':$tampil_penduduk['nama'];
    		 ?>
          <td rowspan="7"><?php if(empty($nama_calon)){ echo "data tidak tersedia";} else { echo $nama_calon; } ?></td>

        <tr>
        <td>Nilai Profile</td>
        <?php
        $standar_nilai_baru=$profile_matching->log_penilaiannya($datapenerima['id_calon_penerima']);
        while ($data_standar_nilai = $standar_nilai_baru->fetch(PDO::FETCH_ASSOC)) { ?>
  			<td> <center><?php echo $data_standar_nilai['nilai_profile_individu']; ?> </center></td>
        <?php } ?>
        </tr>

        <tr>
        <td>Standar Profile</td>
        <?php
        $standar_nilai_baru=$profile_matching->log_penilaiannya($datapenerima['id_calon_penerima']);
    		while ($data_standar_nilai = $standar_nilai_baru->fetch(PDO::FETCH_ASSOC)) { ?>
        <td><center><?php echo $data_standar_nilai['nilai_standar_profile']; ?></center></td>
        <?php } ?>
        </tr>

        <tr>
          <td>Gap </td>
          <?php
          $standar_nilai_baru=$profile_matching->log_penilaiannya($datapenerima['id_calon_penerima']);
      		while ($data_standar_nilai = $standar_nilai_baru->fetch(PDO::FETCH_ASSOC)) { ?>
          <td><center><?php echo $gap= $data_standar_nilai['nilai_profile_individu']-$data_standar_nilai['nilai_standar_profile']; ?></center></td>
          <?php } ?>
        </tr>

        <tr>
          <td>Bobot Gap</td>
          <?php
          $standar_nilai_baru=$profile_matching->log_penilaiannya($datapenerima['id_calon_penerima']);
      		while ($data_standar_nilai = $standar_nilai_baru->fetch(PDO::FETCH_ASSOC)) {
          $gap= $data_standar_nilai['nilai_profile_individu']-$data_standar_nilai['nilai_standar_profile'];
          ?>
          <td><center><?php echo $bobot_gap=$profile_matching->bobot_nilai_gap($gap); ?></center></td>
          <?php } ?>
        </tr>

        <tr>
          <td>Rata-Rata</td>
          <?php
          $jumlah_core=0;
          $jumlah_secondary=0;
          $rata_core=0;
          $rata_secondary=0;
          $standar_nilai_baru=$profile_matching->log_penilaiannya($datapenerima['id_calon_penerima']);
      		while ($data_standar_nilai = $standar_nilai_baru->fetch(PDO::FETCH_ASSOC)) {
              $gap= $data_standar_nilai['nilai_profile_individu']-$data_standar_nilai['nilai_standar_profile'];
              $bobot_gap=$profile_matching->bobot_nilai_gap($gap);
            if ($data_standar_nilai['jenis_kriteria']=="cf") {
              $rata_core=$rata_core+$bobot_gap;
              $jumlah_core++;
            }elseif ($data_standar_nilai['jenis_kriteria']=="sf") {
              $rata_secondary=$rata_secondary+$bobot_gap;
              $jumlah_secondary++;
            }
          }
          ?>
          <?php if($jumlah_core>0){ ?>
          <td colspan="<?php echo $jumlah_core?>"><center>Core Factor: <?php $jum_core= $rata_core/$jumlah_core; echo number_format($jum_core,2); ?></center></td>
          <?php }?>
          <?php if($jumlah_secondary>0){ ?>
          <td colspan="<?php echo $jumlah_secondary?>"><center>Secondary Factor: <?php $jum_sec=$rata_secondary/$jumlah_secondary; echo number_format($jum_sec,2)?></center></td>
          <?php $total_nilai=($jum_core*0.6)+($jum_sec*0.4); }?>
        </tr>

        <tr>
          <?php $col=($jumlah_core+$jumlah_secondary)/2; ?>
          <td >Total Nilai</td>
          <td colspan="<?php echo $col ?>"><center><?php echo number_format($total_nilai,2); $jumlah_calon++;  $rata_rata_total_nilai=$rata_rata_total_nilai+$total_nilai; ?></center></td>
          <td colspan="<?php echo $col ?>"><center> Status =
          <?php
          $status_diterimanya=empty($data_calon_penerima['status_diterima'])?'':$data_calon_penerima['status_diterima'];
          if(empty($status_diterimanya)){ echo "data tidak tersedia";}
          if ($status_diterimanya=="Y") { echo "Diterima"; }
          if ($status_diterimanya=="N") { echo "Ditolak"; }
          ?>
          </center></td>
        </tr>
        <?php } ?>
        </tbody>
    	</table>

        <table class="table invoice-total">
            <tbody>
            <tr>
                <td><strong>Rata-Rata Total Nilai: </strong></td>
                <td>
                  <?php
                  $tresholt=$rata_rata_total_nilai/$jumlah_calon;
                  echo number_format($tresholt,2);
                   ?>
                 </td>
            </tr>
            <tr>
                <td><strong>Total Pengajuan: </strong></td>
                <td><?php
                $jum_diterima=$profile_matching->invoice_analisa($id_analisa);
                $tampil=$jum_diterima->fetch(PDO::FETCH_ASSOC);
                echo $peng=$tampil['jumlah_diterima']+$tampil['jumlah_ditolak']; ?></td>
            </tr>
            <tr>
                <td><strong>Total Diterima: </strong></td>
                <td><?php echo $tampil['jumlah_diterima']; ?></td>
            </tr>
            <tr>
                <td><strong>Total Ditolak: </strong></td>
                <td><?php  echo $tampil['jumlah_ditolak']; ?></td>
            </tr>
            <tr>
                <td><strong>Tanggal Analisa: </strong></td>
                <td><?php echo date("d-m-Y", strtotime($tampil['tanggal_proses'])) ?></td>
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

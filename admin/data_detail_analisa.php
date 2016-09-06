<?php
include ("cek_level.php");
require("library.php");
$individu=new individu();
$profile_matching= new profile_matching();
$id_analisa=$_GET['id_analisa'];
?>
<div class="row wrapper border-bottom white-bg page-heading">
  <div class="col-lg-9">
      <h2>Laporan Detail Perhitungan</h2>
      <ol class="breadcrumb">
          <li>
              <a href="index?page=home">Home</a>
          </li>
          <li class="active">
              <strong>Laporan Detail Perhitungan</strong>
          </li>
      </ol>
  </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
  <div class="row">
      <div class="col-lg-12">
      <div class="ibox float-e-margins">
          <div class="ibox-title">
              <!-- <h5>Laporan Detail Perhitungan</h5> -->
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
          $rata2_tot_nilai=0;
          $jum_cal=0;
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
            <td>Rata2</td>
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
              }else{
                $rata_secondary=$rata_secondary+$bobot_gap;
                $jumlah_secondary++;
              }
            }
            ?>
            <?php if($jumlah_core>0){ ?>
            <td colspan="<?php echo $jumlah_core?>"><center>Core Factor= <?php $jum_core= $rata_core/$jumlah_core; echo number_format($jum_core,2); ?></center></td>
            <?php }?>
            <?php if($jumlah_secondary>0){ ?>
            <td colspan="<?php echo $jumlah_secondary ?>"><center>Secondary Factor= <?php $jum_sec=$rata_secondary/$jumlah_secondary; echo number_format($jum_sec,2)?></center></td>
            <?php $total_nilai=($jum_core*0.6)+($jum_sec*0.4); }?>
          </tr>

          <tr>
            <?php
            $jum_cal++;
            $rata2_tot_nilai=$rata2_tot_nilai+$total_nilai;
            $rata2_nilai_akhir=$rata2_tot_nilai/$jum_cal;

            $col=($jumlah_core+$jumlah_secondary)/2; ?>
            <td>Total Nilai</td>
            <td colspan="<?php echo $col ?>"><?php echo number_format($total_nilai,2); ?></td>
            <td colspan="<?php echo $col ?>">Status:
            <?php
            $status_diterimanya=empty($data_calon_penerima['status_diterima'])?'':$data_calon_penerima['status_diterima'];
              if(empty($status_diterimanya)){ echo "data tidak tersedia";}
              if ($status_diterimanya=="Y") { echo "Diterima"; }
              if ($status_diterimanya=="N") { echo "Ditolak"; }
            ?>
            </td>
          </tr>
          <?php } ?>
          </tbody>
          <tfoot>
          <tr>
            <td colspan="12"><center>Rata-rata total nilai= <?php echo number_format($rata2_nilai_akhir,2) ?></center></td>
          </tr>
          </tfoot>
        	</table>
            <center>
            <form method="post" action="invoice_rincian_perhitungan.php">
              <input type="hidden" name="id" value="<?php echo $id_analisa ?>" >
            <button  type="submit" target="_blank" class="btn btn-info"><i class="fa fa-print"></i> Print </button>
            </form>
          </center>
          </div>
        </div>
      </div>
    </div>
  </div>

<?php
include ("cek_level.php");
if (empty($_POST['pilih'])) {
  $_SESSION['gagal']= '<b>GAGAL MENGANALISA:</b> Tidak ada data yang dapat dianalisa.';
  echo "<script>document.location='index.php?page=analisis';</script>";

}else{
require ("library.php");
$individu=new individu();
$profile_matching=new profile_matching();
$tanggal=date("Y-m-d");
$id_calon_penerima=@$_POST['pilih'];
$jum_data=$individu->sql_where(@$_POST['pilih']);
$hasil_data=$jum_data->rowCount();


if(isset($_POST['semua']))
{
  $sql_where=$individu->sql_where($_POST['semua']);
  $jumlahnya=$sql_where->rowCount();

  $pilih = @$_POST['pilih'];
  while ($datapenerima=$sql_where->fetch(PDO::FETCH_ASSOC))
  {
    $ketemu= false;
    for($i=0;$i<count($pilih);$i++){
      if ($pilih[$i] == $datapenerima['id_calon_penerima']) {
      $ketemu=true;
      }
    }

    if($ketemu == true) {
    $update=$individu->update_status_calon_penerima("Y", $datapenerima['id_calon_penerima'], $tanggal);
    }else {
    $update=$individu->update_status_calon_penerima("N", $datapenerima['id_calon_penerima'], $tanggal );
    }

  }

  // add analisa
  $diterima_jum=$individu->sql_where($_POST['pilih']);
  $jum_diterima=$diterima_jum->rowCount();
  $diterima=$jum_diterima;
  $ditolak=$jumlahnya-$jum_diterima;
  $tahun=date("Y");
  // add_periode
  $id_periode="";
  $cek=$individu->cek_tahun($tahun);
  $terus=$cek->fetch(PDO::FETCH_ASSOC);
  $haha=$cek->rowCount();
  if ($haha>=1) {
    $id_periode=$terus['id_periode'];
  }else{
    $add_periode=$individu->add_periode();
    $id_periode=$individu->dbh->lastInsertId();
  }
  //end_periode
  $add_analisa=$profile_matching->add_analisa($diterima, $ditolak, $id_periode, $tanggal);
  $last_id=$profile_matching->dbh->lastInsertId();

//start->log_penilaian
  $querypenerima=$individu->sql_where($_POST['semua']);
  $i=0;
    while ($datapenerima = $querypenerima ->fetch(PDO::FETCH_ASSOC))
    {
      $id_calon_penerima = $datapenerima['id_calon_penerima'];
      $kriteria=$profile_matching->show_kriteria();
      $del=$profile_matching->del_log_penilaian($id_calon_penerima);
      while ($data_kriteria=$kriteria->fetch(PDO::FETCH_ASSOC))
      {
          $update_id=$individu->update_id_analisa($last_id,$id_calon_penerima);//add_id_analisa===================>>>>
        //cek standar profile
        $cek_nilai_standar=$profile_matching->lihat_standar_profile($data_kriteria['id_kriteria']);
        $data_standar=$cek_nilai_standar->fetch(PDO::FETCH_ASSOC);
        // revisi
        $nilai_standar_sub_kriteria=$profile_matching->detail_sub_kriteria($data_standar['id_sub_kriteria']);
        $data_nilai_standar_sub_kriteria=$nilai_standar_sub_kriteria->fetch(PDO::FETCH_ASSOC);
        $nilai_standar=empty($data_nilai_standar_sub_kriteria['nilai'])?'':$data_nilai_standar_sub_kriteria['nilai'];
        //
        //cek nilai penerima
        $nilai_penerima=$profile_matching->nilai_profile_analisis($id_calon_penerima, $data_kriteria['id_kriteria']);
        $data_nilai=$nilai_penerima->fetch(PDO::FETCH_ASSOC);
        // revisi
        $nilai_sub_kriteria=$profile_matching->detail_sub_kriteria($data_nilai['id_sub_kriteria']);
        $data_nilai_sub_kriteria=$nilai_sub_kriteria->fetch(PDO::FETCH_ASSOC);
        $nilai_profilenya=empty($data_nilai_sub_kriteria['nilai'])?'':$data_nilai_sub_kriteria['nilai'];
        //
        $add_log=$profile_matching->add_log_penilaian($id_calon_penerima, $last_id, $data_kriteria['nama_kriteria'], $data_kriteria['jenis_kriteria'],$nilai_profilenya, $nilai_standar, $tanggal);
      }
  }
//end-> log_penilaian
  echo "<script>document.location='index.php?page=lap_detail_analisa&id_analisa=$last_id';</script>";
}
?>
<!--  -->
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
                      <!-- <h5>Hasil Analisa SPK</h5> -->
                        <div class="ibox-tools">
                          <a class="collapse-link"> <i class="fa fa-chevron-up"></i> </a>
                                <a class="dropdown-toggle" data-toggle="dropdown" href="#"> <i class="fa fa-wrench"></i> </a>
                                    <ul class="dropdown-menu dropdown-user">
                                    <li><a href="#">Config option 1</a></li>
                                    <li><a href="#">Config option 2</a> </li>
                                </ul>
                                <a class="close-link">
                                    <i class="fa fa-times"></i>
                                </a>
                            </div>
                        </div>
                        <div class="ibox-content">
                        <div class="row">

              <div id="perhitungan" style="display:none;">
              		<br />
                  <!-- start hitung -->
              <?php
              $nilai_profil_standar = array();
            	$total_nilai = array();
            	$id_penerima = array();
            	$nama_penerima = array();
            	$jumlah_kriteria_core_factor = array();
            	$jumlah_kriteria_secondary_factor = array();
            	$total_nilai_gap_core_factor = array();
            	$total_nilai_gap_secondary_factor = array();
            	$rata2_nilai_gap_core_factor = array();
            	$rata2_nilai_gap_secondary_factor = array();

              // mendapatkan nilai standar profile
            	$i=0;
              $querykriteria = $profile_matching->show_kriteria_analisa();
              while($datakriteria = $querykriteria->fetch(PDO::FETCH_ASSOC))
              {
                $querystandarprofile=$profile_matching->lihat_standar_profile($datakriteria['id_kriteria']);
                if ($datastandarkriteria = $querystandarprofile->fetch(PDO::FETCH_ASSOC))
                {
                  $querysubkriteria=$profile_matching->detail_sub_kriteria($datastandarkriteria['id_sub_kriteria']);
                  if ($datasubkriteria = $querysubkriteria ->fetch(PDO::FETCH_ASSOC)) {
                    $nilai_profil_standar[$i] = $datasubkriteria['nilai'];
                  }
                }
            		$i++;
            	}
              // end

            	$i=0;
              $querypenerima=$individu->sql_where($_POST['pilih']);//tampil calon penerima yang akan dianalisa
            	while ($datapenerima = $querypenerima ->fetch(PDO::FETCH_ASSOC))
            	{

      					$data_penduduk=$individu->detail_penduduk($datapenerima['no_ktp']);
      					$tampil_penduduk=$data_penduduk->fetch(PDO::FETCH_ASSOC);

            		$nama_penerima[$i] = $tampil_penduduk['nama'];
            		$id_penerima[$i] = $datapenerima['id_calon_penerima'];
            		$total_nilai[$i]= 0;
            		$jumlah_kriteria_core_factor[$i] = 0;
            		$jumlah_kriteria_secondary_factor[$i] = 0;
            		$total_nilai_gap_core_factor[$i] = 0;
            		$total_nilai_gap_secondary_factor[$i] = 0;
            		$rata2_nilai_gap_core_factor[$i] = 0;
            		$rata2_nilai_gap_secondary_factor[$i] = 0;

            		$n=0;
                $querykriteria=$profile_matching->show_kriteria_analisa();//tampil kriteria
                $jmlkriteria=$querykriteria->rowCount();
            		while ($datakriteria = $querykriteria->fetch(PDO::FETCH_ASSOC))
            		{
            			$querynilaiprofilpenerima=$profile_matching->nilai_profile_analisis($datapenerima['id_calon_penerima'], $datakriteria['id_kriteria']);//mendapatkan nilai profile calon penerima
                  $datanilaiprofilpenerima=$querynilaiprofilpenerima->fetch(PDO::FETCH_ASSOC);

                  // revisi
                  $nilai_sub_kriteria=$profile_matching->detail_sub_kriteria($datanilaiprofilpenerima['id_sub_kriteria']);
                  $data_nilai_sub_kriteria=$nilai_sub_kriteria->fetch(PDO::FETCH_ASSOC);
                  //

                  $nilai_profilenya=empty($data_nilai_sub_kriteria['nilai'])?'':$data_nilai_sub_kriteria['nilai'];
            			$nilai_profil_penerima = $nilai_profilenya;
            			$gap = $profile_matching->gap($nilai_profil_penerima, $nilai_profil_standar[$n]); //hitung gap
            			$nilai_gap= $profile_matching->bobot_nilai_gap($gap);//hitung nilai bobot gap

                  if ($datakriteria['jenis_kriteria'] == 'cf') {
            				$total_nilai_gap_core_factor[$i] = $total_nilai_gap_core_factor[$i] + $nilai_gap;//hitung total nilai gap core factor
            				$jumlah_kriteria_core_factor[$i]++;
            			} else {
            				$total_nilai_gap_secondary_factor[$i] = $total_nilai_gap_secondary_factor[$i] + $nilai_gap;//hitung total nilai gap secondary factor
            				$jumlah_kriteria_secondary_factor[$i]++;
            			}

            			$n++;
            		}

                if ($jumlah_kriteria_core_factor[$i] > 0) {
                $rata2_nilai_gap_core_factor[$i]=$profile_matching->rata_rata_analisa($jumlah_kriteria_core_factor[$i], $total_nilai_gap_core_factor[$i]); //hitung rata_rata nilai
                }//hitung rata2 nilai gap core

                if ($jumlah_kriteria_secondary_factor[$i] > 0) {
                $rata2_nilai_gap_secondary_factor[$i]=$profile_matching->rata_rata_analisa( $jumlah_kriteria_secondary_factor[$i], $total_nilai_gap_secondary_factor[$i]); //hitung rata_rata nilai
                }//hitung rata2 nilai gap secondary

                $total_nilai[$i]=$profile_matching->total_nilai($rata2_nilai_gap_core_factor[$i], $rata2_nilai_gap_secondary_factor[$i]);//hitung total nilai akhir
            		$i++;
            	} ?>

              <!-- end hitung -->
              <?php $standar=0; ?>
            	<table class="table  table-striped">
            	<tr>
            	<th>Nama penerima</th>
            	<th>Kriteria</th>
            	<th>Nilai Calon Penerima</th>
            	<th>Standar Profile</th>
            	<th>Nilai Gap</th>
            	<th>Bobot Nilai Gap</th>
            	<th>Rata-Rata</th>
            	<th>Total Nilai</th>
            	</tr>

              <?php
            	$i=0;
              $querypenerima=$individu->sql_where($_POST['pilih']);
            	while ($datapenerima = $querypenerima->fetch(PDO::FETCH_ASSOC))
            	{
                $querykriteria=$profile_matching->show_kriteria_analisa();
                $jmlkriteria=$querykriteria->rowCount();
            		$n=0;
            		while ($datakriteria = $querykriteria->fetch(PDO::FETCH_ASSOC))
            		{ ?>
            			<tr>
                  <?php
            			if ($n==0) {
          					$data_penduduk=$individu->detail_penduduk($datapenerima['no_ktp']);
          					$tampil_penduduk=$data_penduduk->fetch(PDO::FETCH_ASSOC);
                    ?>

                  <td rowspan="<?php echo $jmlkriteria ?>"><?php echo $tampil_penduduk['nama'] ?></td>
                  <?php } ?>

                  <td>
                  <?php echo $datakriteria['nama_kriteria'] ?> (
                  <?php
                  if ($datakriteria['jenis_kriteria']=="cf") {
                    echo "core";
                  }else {
                    echo "secondary";
                  }
                   ?>)
                  </td>

                  <?php
            			$jenis_kriteria = $datakriteria['jenis_kriteria'];
                  $querynilaiprofilpenerima=$profile_matching->nilai_profile_analisis($datapenerima['id_calon_penerima'], $datakriteria['id_kriteria']);
                  $datanilaiprofilpenerima=$querynilaiprofilpenerima->fetch(PDO::FETCH_ASSOC);

                  // revisi
                  $nilai_sub_kriteria=$profile_matching->detail_sub_kriteria($datanilaiprofilpenerima['id_sub_kriteria']);
                  $data_nilai_sub_kriteria=$nilai_sub_kriteria->fetch(PDO::FETCH_ASSOC);
                  //

                  $nilai_profilenya=empty($data_nilai_sub_kriteria['nilai'])?'':$data_nilai_sub_kriteria['nilai'];//Trying to get property of non-object in
            			$nilai_profil_penerima = $nilai_profilenya;
                  ?>

            			<td><center>
                    <?php
                  // $nilai_profilenya=empty($datanilaiprofilpenerima->nilai_profil)?'':$datanilaiprofilpenerima->nilai_profil;//Trying to get property of non-object in
                  //  echo $nilai_profilenya
                  echo $nilai_profil_penerima;
                   ?>
                 </center></td>

                  <td><center><?php echo $nilai_profil_standar[$n] ?></center></td>
                  <td><center><?php echo $gap = $profile_matching->gap($nilai_profil_penerima, $nilai_profil_standar[$n]);?></center></td> <!--hitung gap-->

                  <?php $nilai_gap= $profile_matching->bobot_nilai_gap($gap); //hitung nilai bobot gap ?>

            			<td><center><?php echo $nilai_gap ?></center></td>

                  <?php
            			if ($n == 0) {
                  ?>
                  <td ><center><?php echo number_format($rata2_nilai_gap_core_factor[$i],2) ?></center></td>

            			<?php }else if ($n == $jumlah_kriteria_core_factor[$i]) { ?>

                  <td ><center><?php echo number_format($rata2_nilai_gap_secondary_factor[$i],2) ?></center></td>
                	<?php }

            			if ($n==0) {?>
                    <td rowspan="<?php echo $jmlkriteria ?>"><center><?php echo number_format($total_nilai[$i],2) ?></center></td>

                  <?php
                  //$standar=$standar+$total_nilai[$i];// rata2 nilai total(tresholt)
                  $standar=$profile_matching->tambah($standar, $total_nilai[$i]);
                  } ?>
            			</tr>
                  <?php
            			$n++;
            		}
            		$i++;
            	}
              ?>
            	</table>

              <?php
              @$querypenerima=$individu->sql_where($_POST['semua']);
            	$id_penerima_rangking = array();
            	$nama_penerima_rangking = array();
            	$total_nilai_rangking = array();

            	for ($i=0;$i<count($nama_penerima);$i++)
            	{
            		$id_penerima_rangking[$i] = $id_penerima[$i];
            		$nama_penerima_rangking[$i] = $nama_penerima[$i];
            		$total_nilai_rangking[$i] = $total_nilai[$i];
            	}

            	for ($i=0;$i<count($nama_penerima);$i++)
            	{
            		for ($n=$i;$n<count($nama_penerima);$n++)
            		{
            			if ($total_nilai_rangking[$n] > $total_nilai_rangking[$i])
            			{
            				$tmp_total_nilai = $total_nilai_rangking[$i];
            				$tmp_nama_penerima = $nama_penerima_rangking[$i];
            				$tmp_id_penerima = $id_penerima_rangking[$i];

            				$total_nilai_rangking[$i] = $total_nilai_rangking[$n];
            				$nama_penerima_rangking[$i] = $nama_penerima_rangking[$n];
            				$id_penerima_rangking[$i] = $id_penerima_rangking[$n];

            				$total_nilai_rangking[$n] = $tmp_total_nilai;
            				$nama_penerima_rangking[$n] = $tmp_nama_penerima;
            				$id_penerima_rangking[$n] = $tmp_id_penerima;
            			}
            		}
            	}

            ?>
            <br />
            </div>
            <br />
            <input type="button" class="btn btn-info" value="Perhitungan" onclick="document.getElementById('perhitungan').style.display='block';"/>
            <!-- <br />
            <br />
            <br /> -->

            <!-- tabel -->
              <form method="post" class="form-horizontal">
                <table class="table table-striped">
                    <thead>
                      <tr>
                        <th>Rangking </th>
                        <th>Nama</th>
                        <th>No Ktp</th>
                        <th>KSM</th>
                        <th>Total Nilai</th>
                        <th>Saran</th>
                        <th>Diterima</th>
                    </tr>
                    </thead>
                    <tbody>
            <?php
                //$bagi=($standar/$hasil_data);
                $standar_nilai=$profile_matching->rata_rata_analisa($hasil_data, $standar);
            	for ($i=0;$i<count($nama_penerima_rangking);$i++)
            	{
                $querypenerima=$individu->detail_calon_penerima($id_penerima_rangking[$i]);
                $datapenerima=$querypenerima->fetch(PDO::FETCH_ASSOC);

                $queryksm=$individu->detail_ksm($datapenerima['id_ksm']);
                $dataksm=$queryksm->fetch(PDO::FETCH_ASSOC);
            ?>
                <tr class="gradeX">
                    <td><?php echo ($i+1); ?></td>
                    <td><?php echo $nama_penerima_rangking[$i]; ?></td>
                    <td><?php echo $datapenerima['no_ktp'] ?></td>
                    <td><?php echo $dataksm['nama_ksm']; $a=0;?></td>
                    <td><?php echo number_format($total_nilai_rangking[$i],2) ?></td>
                    <td>
                      <?php
                      if($total_nilai_rangking[$i] >= $standar_nilai){
                        echo "Diterima";
                        $check="checked";
                      } else {
                        echo "Ditolak";
                        $check="";
                      }
                     ?>
                     </td>
                      <td>
                        <input type="checkbox"  <?php echo $check ?> class="i-checks" name="pilih[]" value="<?php echo $datapenerima['id_calon_penerima'] ?>">
                        <input type="hidden" name="semua[]" value="<?php echo $datapenerima['id_calon_penerima'] ?>">
                        <!--  -->
                        <?php $update_nilai=$individu->update_tot_nilai_calon_penerima($datapenerima['id_calon_penerima'], $total_nilai_rangking[$i]); ?>
                        <!--  -->
                      </td>

                </tr>
                <?php } ?>
            </tbody>
            <tfoot>
            <tr>
              <td colspan="4"><center>RATA-RATA</center></td>
              <td><?php echo number_format($standar_nilai,2) ?></td>
              <td colspan="2"></td>
            </tr>
            </tfoot>
            </table>
            <div class="col-lg-2">
                          <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
            </form>

            <br><br><br>
            <br />
            <br />
            <br />
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<script src="../js/plugins/iCheck/icheck.min.js"></script>
    <script>
        $(document).ready(function () {
            $('.i-checks').iCheck({
                checkboxClass: 'icheckbox_square-green',
                radioClass: 'iradio_square-green',
            });
        });
    </script>
    <?php } ?>

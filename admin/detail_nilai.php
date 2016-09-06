<?php
include ("cek_level.php");
require ("library.php");
$individu= new individu();
$profile_matching= new profile_matching();
$id_calon_penerima=$_GET['id_calon_penerima'];
$detail=$individu->detail_calon_penerima($id_calon_penerima);
$data_detail=$detail->fetch(PDO::FETCH_ASSOC);
 ?>
 <div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-9">
        <h2>Data Perhitungan</h2>
            <ol class="breadcrumb">
                <li>
                    <a href="index?page=home">Home</a>
                       </li>
                       <li class="active">
                           <strong>Data Perhitungan</strong>
                       </li>
                   </ol>
               </div>
           </div>
        <div class="wrapper wrapper-content p-xl">
    <div class="ibox-content p-xl">
      <div class="row">
          <div class="col-sm-6">
              <h5></h5>
              <address>
                  <strong>Data Individu</strong><br><br>
                  <?php
                  $data_penduduk=$individu->detail_penduduk($data_detail['no_ktp']);
                  $tampil_penduduk=$data_penduduk->fetch(PDO::FETCH_ASSOC);
                   ?>
                  No Ktp: <?php echo $data_detail['no_ktp'] ?><br>
                  Nama: <?php echo $tampil_penduduk['nama'] ?><br>
                  Alamat: <?php echo $tampil_penduduk['alamat'] ?><br>
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
                  <span><strong>Tanggal: </strong><?php echo date("d F Y") ?></span>
              </p>
          </div>
      </div>
      <hr>
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
                    <td>
                      <?php
                      if ($data_detail['status_diterima']=="Y") { ?> <span class="label label-info"><b> DITERIMA </b></span>
                      <?php }else{ ?> <span class="label label-danger"><b> DITOLAK </b></span> <?php } ?>
                     </td>
                </tr>
                </tbody>
            </table>
            <div class="well m-t"><strong>Keterangan: </strong>
              <?php
              $tanggal=$profile_matching->log_penilaian($id_calon_penerima);
              $data_tanggal=$tanggal->fetch(PDO::FETCH_ASSOC);?>
                  Dinilai pada tanggal:  <?php echo date("d-m-Y", strtotime($data_tanggal['tanggal'])) ?>
              </div>

        <form method="post" action="invoice_perhitungan.php">
          <input type="hidden" name="id" value="<?php echo $id_calon_penerima ?>" >
        <button  type="submit" target="_blank" class="btn btn-primary"><i class="fa fa-print"></i> Print </button>
        </form>
        </div>
</div>

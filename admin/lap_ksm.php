<?php
include ("cek_level.php");
require "library.php";
$individu=new individu();
$no=1;
unset ($_SESSION['cari']);
if (isset($_POST['cari'])) {

  $start=date("Y-m-d", strtotime($_POST['start']));
  $end=date("Y-m-d", strtotime($_POST['end']));
  $lap_ksm=$individu->cari_ksm($start, $end);
  $_SESSION['berhasil']='<b>Hasil filter data dari '.date("d-m-Y",strtotime($start)).' sampai '.date("d-m-Y",strtotime($end)).'</b>';
  $row=$lap_ksm->rowCount();
  if ($row < 1) { $_SESSION['warning']='<b>Tidak ada data yang dapat ditampilkan. </b>'; }
}else {
  $lap_ksm=$individu->show_ksm_status("Y");
}

 ?>
 <div class="row wrapper border-bottom white-bg page-heading">
   <div class="col-lg-9">
       <h2>Laporan KSM</h2>
       <ol class="breadcrumb">
           <li>
               <a href="index?page=home">Home</a>
           </li>
           <li class="active">
               <strong>laporan KSM</strong>
           </li>
       </ol>
   </div>
 </div>
<div class="wrapper wrapper-content animated fadeInRight">
  <div class="row">
    <div class="col-lg-12">
      <div class="ibox float-e-margins">
          <div class="ibox-title">
              <h5></h5>
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
            <?php
            include ("notifikasi.php");
             ?>
            <form method="post">
              <div class="form-group" id="data_5">
              <label class="font-noraml">Filter Data</label>
              <div class="input-daterange input-group" id="datepicker">
              <input type="text" class="input-sm form-control"  name="start" value="<?php date("d-m-Y") ?> " required/>
              <span class="input-group-addon"> sampai </span>
              <input type="text" class="input-sm form-control"  name="end" value="<?php date("d-m-Y") ?>" required/>
              </div>
              </div>
              <button type="submit" name="cari" class="btn btn-primary">Tampil</button><br>
            </form>
            <form action="invoice_ksm.php" method="post">
                <input type="hidden" name="start" value="<?php echo $start ?>">
                <input type="hidden" name="end" value="<?php echo $end ?>">
              <button target="_blank" class="btn btn-info" type="submit"><i class="fa fa-print"></i> Print </button>
            </form>
            <br><br>
          <table class="table table-striped table-bordered table-hover dataTables-example" >
          <thead>
          <tr>
            <th>No</th>
            <th>Nama KSM</th>
            <th>Lokasi</th>
            <th>PNPM-MP</th>
            <th>Swadaya</th>
            <th>Jumlah Biaya</th>
            <th>Tanggal</th>
          </tr>
          </thead>
          <tbody>
            <?php
            $jum1=0;$jum2=0;$jum3=0;
                while ($data_ksm=$lap_ksm->fetch(PDO::FETCH_ASSOC)){
            ?>
              <tr class="gradeX">
                  <td><?php echo $no++ ?></td>
                  <td><a href="index?page=detail_ksm&id_ksm=<?php echo $data_ksm['id_ksm'] ?> "><?php echo $data_ksm['nama_ksm'] ?></a></td>

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
              <?php
            };
              ?>
          </tbody>

          <tfoot>
          <tr>
            <th colspan="3"><center>TOTAL</ center></th>
            <th><?php echo number_format($jum1,0,',','.') ?></th>
            <th><?php echo number_format($jum2,0,',','.') ?></th>
            <th><?php echo number_format($jum3,0,',','.') ?></th>
            <th></th>
          </tr>
          </tfoot>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

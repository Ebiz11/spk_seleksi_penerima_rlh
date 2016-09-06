<?php
include ("cek_session.php");
  require ("library.php");
  $individu= new individu();
  $id_ksm=$_GET['id_ksm'];
  $view=$individu->detail_ksm($id_ksm);
  $data_ksm=$view->fetch(PDO::FETCH_ASSOC);
?>
<div class="row wrapper border-bottom white-bg page-heading">
  <div class="col-lg-9">
    <h2>Detail KSM</h2>
    <ol class="breadcrumb">
        <li>
            <a href="index?page=home">Home</a>
        </li>
        <li class="active">
            <strong>Detail KSM</strong>
        </li>
    </ol>
  </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
  <div class="row">
    <div class="col-lg-12">
      <div class="ibox float-e-margins">
        <div class="ibox-title">
          <h5>Detail KSM <?php echo $data_ksm['nama_ksm']; ?></h5>
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
          <form method="get" class="form-horizontal">
          <div class="form-group"><label class="col-sm-2 control-label">Id KSM</label>
              <div class="col-sm-5"><input type="text" disabled="" class="form-control" value="<?php echo $data_ksm['id_ksm'] ?>"></div>
          </div>
          <div class="form-group"><label class="col-sm-2 control-label">Nama KSM</label>
              <div class="col-sm-5"><input type="text" disabled="" class="form-control" value="<?php echo $data_ksm['nama_ksm'] ?>"></div>
          </div>
          <div class="form-group"><label class="col-sm-2 control-label">Nama Pekerjaan</label>
              <div class="col-sm-5"><input type="text" disabled="" class="form-control" value="<?php echo $data_ksm['jenis_pekerjaan'] ?>"></div>
          </div>
          <div class="form-group"><label class="col-sm-2 control-label">PNPM-MP</label>
              <div class="col-sm-5"><input type="text"  disabled="" class="form-control" value="<?php echo number_format($data_ksm['pnpm_mp'],0,',','.') ?>"></div>
          </div>
          <div class="form-group"><label class="col-sm-2 control-label">Swadaya</label>
              <div class="col-sm-5"><input type="text" disabled="" class="form-control" value="<?php echo number_format($data_ksm['swadaya'],0,',','.') ?>"></div>
          </div>
          <div class="form-group"><label class="col-sm-2 control-label">Lokasi</label>
              <div class="col-sm-5"><input type="text"  disabled="" class="form-control" value="<?php echo $data_ksm['lokasi'] ?>"></div>
          </div>
          <div class="form-group"><label class="col-sm-2 control-label">No KTP Ketua</label>
              <div class="col-sm-5"><input type="text"  disabled="" class="form-control" value="<?php echo $data_ksm['no_ktp_ketua'] ?>"></div>
          </div>
          <?php
          $detail_penduduk_ketua=$individu->detail_penduduk($data_ksm['no_ktp_ketua']);
          $tampil_penduduk_ketua=$detail_penduduk_ketua->fetch(PDO::FETCH_ASSOC);
           ?>
          <div class="form-group"><label class="col-sm-2 control-label">Nama Ketua</label>
              <div class="col-sm-5"><input type="text"  disabled="" class="form-control" value="<?php echo $tampil_penduduk_ketua['nama'] ?>"></div>
          </div>
          <div class="form-group"><label class="col-sm-2 control-label">Alamat Ketua</label>
              <div class="col-sm-5"><input type="text"  disabled="" class="form-control" value="<?php echo $tampil_penduduk_ketua['alamat'] ?>"></div>
          </div>
          <?php
          $detail_penduduk_sekertaris=$individu->detail_penduduk($data_ksm['no_ktp_sekertaris']);
          $tampil_penduduk_sekertaris=$detail_penduduk_sekertaris->fetch(PDO::FETCH_ASSOC);
           ?>
          <div class="form-group"><label class="col-sm-2 control-label">No KTP Sekertaris</label>
              <div class="col-sm-5"><input type="text"  disabled="" class="form-control" value="<?php echo $data_ksm['no_ktp_sekertaris'] ?>"></div>
          </div>
          <div class="form-group"><label class="col-sm-2 control-label">Nama Sekertaris</label>
              <div class="col-sm-5"><input type="text"  disabled="" class="form-control" value="<?php echo $tampil_penduduk_sekertaris['nama'] ?>"></div>
          </div>
          <div class="form-group"><label class="col-sm-2 control-label">Alamat Sekertaris</label>
              <div class="col-sm-5"><input type="text"  disabled="" class="form-control" value="<?php echo $tampil_penduduk_sekertaris['alamat'] ?>"></div>
          </div>
          <?php
          $detail_penduduk_bendahara=$individu->detail_penduduk($data_ksm['no_ktp_bendahara']);
          $tampil_penduduk_bendahara=$detail_penduduk_bendahara->fetch(PDO::FETCH_ASSOC);
           ?>
          <div class="form-group"><label class="col-sm-2 control-label">No KTP Bendahara</label>
              <div class="col-sm-5"><input type="text"  disabled="" class="form-control" value="<?php echo $data_ksm['no_ktp_bendahara'] ?>"></div>
          </div>
          <div class="form-group"><label class="col-sm-2 control-label">Nama Bendahara</label>
              <div class="col-sm-5"><input type="text"  disabled="" class="form-control" value="<?php echo $tampil_penduduk_bendahara['nama'] ?>"></div>
          </div>
          <div class="form-group"><label class="col-sm-2 control-label">Alamat Bendahara</label>
              <div class="col-sm-5"><input type="text"  disabled="" class="form-control" value="<?php echo $tampil_penduduk_bendahara['alamat'] ?>"></div>
          </div>
          <div class="form-group"><label class="col-sm-2 control-label">Tanggal</label>
              <div class="col-sm-5"><input type="text"  disabled="" class="form-control" value="<?php echo date("d-m-Y",strtotime($data_ksm['tanggal'])) ?>"></div>
          </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

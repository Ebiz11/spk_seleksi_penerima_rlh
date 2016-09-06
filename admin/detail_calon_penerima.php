<?php include ("cek_session.php"); ?>
<div class="row wrapper border-bottom white-bg page-heading">
  <div class="col-lg-9">
    <h2>Detail Calon Penerima</h2>
    <ol class="breadcrumb">
        <li>
            <a href="index?page=home">Home</a>
        </li>
        <li class="active">
            <strong>Detail Calon Penerima</strong>
        </li>
    </ol>
  </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
<div class="row">
<div class="col-lg-12">
  <div class="ibox float-e-margins">
    <div class="ibox-title">
        <h5>Detail Calon Penerima</h5>
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
      require ("library.php");
  		$individu= new individu();
      $id_calon_penerima=$_GET['id_calon_penerima'];
      extract($individu->det_calon_penerima($id_calon_penerima));
      extract($individu->det_penduduk($no_ktp));
    ?>
    <form method="get" class="form-horizontal">
      <div class="form-group"><label class="col-sm-2 control-label">Id</label>
          <div class="col-sm-5"><input type="text" disabled="" class="form-control" value="<?php echo $id_calon_penerima ?>"></div>
      </div>
      <div class="form-group"><label class="col-sm-2 control-label">Nama</label>
          <div class="col-sm-5"><input type="text"  disabled="" class="form-control" value="<?php echo $nama ?>"></div>
      </div>
      <div class="form-group"><label class="col-sm-2 control-label">No Ktp</label>
          <div class="col-sm-5"><input type="text" disabled="" class="form-control" value="<?php echo $nik ?>"></div>
      </div>
      <div class="form-group"><label class="col-sm-2 control-label">No kk</label>
          <div class="col-sm-5"><input type="text" disabled="" class="form-control" value="<?php echo $no_kk ?>"></div>
      </div>
      <div class="form-group"><label class="col-sm-2 control-label">No Warmis</label>
          <div class="col-sm-5"><input type="text" disabled="" class="form-control" value="<?php echo $no_warmis ?>"></div>
      </div>
      <div class="form-group"><label class="col-sm-2 control-label">Alamat</label>
          <div class="col-sm-5"><input type="text" disabled="" class="form-control" value="<?php echo $alamat ?>"></div>
      </div>
      <div class="form-group"><label class="col-sm-2 control-label">Dusun</label>
          <div class="col-sm-5"><input type="text" disabled="" class="form-control" value="<?php echo $dusun ?>"></div>
      </div>
      <div class="form-group"><label class="col-sm-2 control-label">Rt</label>
          <div class="col-sm-5"><input type="text" disabled="" class="form-control" value="<?php echo $rt ?>"></div>
      </div>
      <div class="form-group"><label class="col-sm-2 control-label">Rw</label>
          <div class="col-sm-5"><input type="text" disabled="" class="form-control" value="<?php echo $rw ?>"></div>
      </div>
      <div class="form-group"><label class="col-sm-2 control-label">Latitude</label>
          <div class="col-sm-5"><input type="text" disabled="" class="form-control" value="<?php echo $latitude ?>"></div>
      </div>
      <div class="form-group"><label class="col-sm-2 control-label">longitude</label>
          <div class="col-sm-5"><input type="text" disabled="" class="form-control" value="<?php echo $longitude ?>"></div>
      </div>
      <div class="form-group"><label class="col-sm-2 control-label">Tanggal</label>
          <div class="col-sm-5"><input type="text" disabled="" class="form-control" value="<?php echo date("d-m-Y",strtotime($tanggal)) ?>"></div>
      </div>
      <div class="form-group"><label class="col-sm-2 control-label">Status</label>
        <?php
        if ($status_diterima=="Y") {?> <div class="col-sm-5"><span class="label label-info">Diterima</span></div>
        <?php }elseif ($status_diterima=="N") { ?> <div class="col-sm-5"><span class="label label-danger">Ditolak</span></div>
        <?php  }else{ ?> <div class="col-sm-5"><span class="label label-warning">Belum di analisa</span></div>
        <?php }  ?>
      </div>
    </form>
  </div>
</div>

</div>
</div>
</div>

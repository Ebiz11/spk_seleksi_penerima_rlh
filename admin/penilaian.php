<div class="row wrapper border-bottom white-bg page-heading">
  <div class="col-lg-9">
      <h2>Penilaian Profile</h2>
      <ol class="breadcrumb">
        <li>
          <a href="index?page=home">Home</a>
        </li>
        <li class="active">
          <strong>Penilaian Profile</strong>
        </li>
      </ol>
  </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
  <div class="row">
    <div class="col-lg-12">
      <div class="ibox float-e-margins">
        <div class="ibox-title">
          <!-- <h5>Penilaian Profile</h5> -->
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
              <?php include ("notifikasi.php"); ?>
          <table class="table table-striped table-bordered table-hover dataTables-example" >
          <thead>
          <tr>
              <th>No </th>
              <th>Nama </th>
              <th>No Ktp</th>
              <th>KSM</th>
              <th>Status</th>
              <th>Aksi</th>
          </tr>
          </thead>
          <tbody>
            <?php
            include ("cek_session.php");
            require ("library.php");
        		$individu= new individu();
        		$profile_matching= new profile_matching();
            $no=1;
            $penilaian=$individu->show_calon_penerima("P");
            while ($data_penilaian=$penilaian->fetch(PDO::FETCH_ASSOC)){
            ?>
            <tr class="gradeX">
                <td><?php echo $no++ ?></td>
                <?php
                $data_penduduk=$individu->detail_penduduk($data_penilaian['no_ktp']);
                $tampil_penduduk=$data_penduduk->fetch(PDO::FETCH_ASSOC);
                 ?>
                <td><a href="index?page=detail_calon_penerima&id_calon_penerima=<?php echo $data_penilaian['id_calon_penerima'] ?>"><?php echo $tampil_penduduk['nama'] ?></a></td>
                <td><?php echo $data_penilaian['no_ktp'] ?></td>
                <?php $ksm=$individu->detail_ksm($data_penilaian['id_ksm']);
                $data_ksm=$ksm->fetch(PDO::FETCH_ASSOC); ?>
                <td><a href="index?page=detail_ksm&id_ksm=<?php echo $data_ksm['id_ksm'] ?>"><?php echo $data_ksm['nama_ksm'] ?></a></td>
                <td> <?php if ($data_penilaian['status_penilaian']=="Y") { ?> <span class="label label-info">Sudah Dinilai</span>
                <?php }else{ ?> <span class="label label-danger">Belum Dinilai</span> <?php } ?> </td>
                <td><a type="button" class="btn btn-success btn-sm" href="index?page=nilai_calon_penerima&id_calon_penerima=<?php echo $data_penilaian['id_calon_penerima'] ?>">Nilai</a>
            </tr>
            <?php }; ?>
          </tbody>
          <tfoot>
          <tr>
          </tr>
          </tfoot>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

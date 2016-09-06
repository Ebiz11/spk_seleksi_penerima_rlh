<?php
include ("cek_session.php");
require ("library.php");
$profile_matching= new profile_matching();
$individu=new individu();
$id_calon_penerima=$_GET['id_calon_penerima'];
  if(isset($_POST['button']))
  {

      $del=$profile_matching->del_nilai_profil($id_calon_penerima);
      $kriteria=$profile_matching->show_kriteria();
      $i=0;
      $jum_post=0;
      while ($datakriteria=$kriteria->fetch(PDO::FETCH_ASSOC))
      {
          $i++;
          $post_id_kriteria=$_POST[$datakriteria['id_kriteria']];
          $sub_kriteria= $profile_matching->detail_sub_kriteria($post_id_kriteria);
          $datasubkriteria= $sub_kriteria->fetch(PDO::FETCH_ASSOC);
          $cek_nilai_standar=$profile_matching->lihat_standar_profile($datakriteria['id_kriteria']);
          $data_standar=$cek_nilai_standar->fetch(PDO::FETCH_ASSOC);
          @$add=$profile_matching->add_nilai_profile_penerima($id_calon_penerima, $datakriteria['id_kriteria'], @$_POST[$datakriteria['id_kriteria']]);

      }
      // status Penilaian
      $update=$individu->status_penilaian($id_calon_penerima);
      $_SESSION['berhasil'] = '<b>BERHASIL MENYIMPAN:</b> Data penilaian berhasil disimpan.';
      echo "<script>document.location='index.php?page=penilaian';</script>";
  }
?>
<div class="row wrapper border-bottom white-bg page-heading">
  <div class="col-lg-9">
      <h2><?php extract($individu->det_calon_penerima($id_calon_penerima)); extract($individu->det_penduduk($no_ktp)); echo $nama; ?></h2>
      <ol class="breadcrumb">
          <li>
              <a href="index?page=home">Home</a>
          </li>
          <li class="active">
              <strong>Penilaian Calon Penerima</strong>
          </li>
      </ol>
  </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
                <div class="col-lg-12">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>Penilaian Calon Penerima</h5>
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
                            <form method="post" class="form-horizontal" action="">
                              <?php
                                $kriterianya=$profile_matching->show_kriteria();
                                while ($datakriteria = $kriterianya->fetch(PDO::FETCH_ASSOC)) {

                          		?>
                                <div class="form-group"><label class="col-sm-2 control-label"><?php echo $datakriteria['nama_kriteria'] ?><br/></label>
                                    <div class="col-sm-10">
                                      <?php

                                        $sub_kriterianya= $profile_matching->relasi_sub_kriteria($datakriteria['id_kriteria']);
                                        while ($datasubkriteria=$sub_kriterianya->fetch(PDO::FETCH_ASSOC)) {

                                          $checked = "";
                                          $id_kriteria=$datakriteria['id_kriteria'];
                                          $id_sub_kriterianya=$datasubkriteria['id_sub_kriteria'];

                                          $nilai_profil_penerima=$profile_matching->nilai_profile($id_calon_penerima, $id_kriteria, $id_sub_kriterianya);
                                          if ($datanilaiprofilpenerima= $nilai_profil_penerima->fetch(PDO::FETCH_ASSOC))
                                          {
                                            $checked = " checked";
                                          }
                                    ?>
                                      <div class="radio i-checks"><label> <input type="radio" disabled="" value="<?php echo $datasubkriteria['id_sub_kriteria'] ?>" name="<?php echo $datakriteria['id_kriteria'] ?>" <?php echo $checked; ?>> <i></i><?php echo $datasubkriteria['nama_sub_kriteria'] ?></label></div>
                                    <?php } ?>
                                    </div>
                                </div>
                                <div class="hr-line-dashed"></div>
                                <?php
                                }
                                ?>
                                <input type="hidden" name="id_calon_penerima" value="<?php echo $_GET['id_calon_penerima']; ?>">
                                <div class="form-group">
                                    <div class="col-sm-4 col-sm-offset-2">
                                      <a href="index.php?page=penilaian" type="button" class="btn btn-white" type="submit">Kembali</a>
                                        <a type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal5">Edit Penilaian</a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

<!-- modal edit -->
<div class="modal inmodal fade" data-backdrop="static" id="myModal5" tabindex="-1" role="dialog"  aria-hidden="true">
      <div class="modal-dialog">
          <div class="modal-content">
              <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                  <h4 class="modal-title">Profile Calon Penerima</h4>
                  <small class="font-bold">Profile Calon Penerima adalah kriteria-kriteria yang dimiliki oleh calon penerima.</small>

              </div>
              <div class="modal-body">
                <form method="post" class="form-horizontal" action="">
                  <?php

                    $kriterianya=$profile_matching->show_kriteria();
                    while ($datakriteria = $kriterianya->fetch(PDO::FETCH_ASSOC)) {

                  ?>
                    <div class="form-group"><label class="col-sm-2 control-label"><?php echo $datakriteria['nama_kriteria'] ?><br/></label>
                        <div class="col-sm-10">
                          <?php

                            $sub_kriterianya= $profile_matching->relasi_sub_kriteria($datakriteria['id_kriteria']);
                            while ($datasubkriteria=$sub_kriterianya->fetch(PDO::FETCH_ASSOC)) {

                              $checked = "";
                              $id_kriteria=$datakriteria['id_kriteria'];
                              $id_sub_kriterianya=$datasubkriteria['id_sub_kriteria'];

                              $nilai_profil_penerima=$profile_matching->nilai_profile($id_calon_penerima, $id_kriteria, $id_sub_kriterianya);
                              if ($datanilaiprofilpenerima= $nilai_profil_penerima->fetch(PDO::FETCH_ASSOC))
                              {
                                $checked = " checked";
                              }
                        ?>
                          <div class="radio i-checks"><label> <input type="radio" value="<?php echo $datasubkriteria['id_sub_kriteria'] ?>" name="<?php echo $datakriteria['id_kriteria'] ?>" <?php echo $checked; ?> required> <i></i><?php echo $datasubkriteria['nama_sub_kriteria'] ?></label></div>
                        <?php } ?>
                        </div>
                    </div>
                    <div class="hr-line-dashed"></div>
                    <?php
                    }
                    ?>
                    <input type="hidden" name="id_calon_penerima" value="<?php echo $_GET['id_calon_penerima']; ?>">
                    <div class="form-group">
                        <div class="col-sm-4 col-sm-offset-2">
                                <button type="button" class="btn btn-white" data-dismiss="modal">Batal</button>
                                <button class="btn btn-primary" type="submit" name="button">Simpan</button>
                        </div>
                    </div>
                </form>
          </div>
      </div>
</div>
</div>

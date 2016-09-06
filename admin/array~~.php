<?php
  require ("library.php");
  $individu= new individu();
  $profile_matching= new profile_matching();
  $id_calon_penerima=31;
  $detail_penerima=$individu->detail_calon_penerima($id_calon_penerima);
  $data_penerima=$detail_penerima->fetch(PDO::FETCH_OBJ);
  $data_penduduk=$individu->det_penduduk($data_penerima->no_ktp);
  extract($data_penduduk);
  echo print_r($data_penduduk);
  // echo $alamat;

?>

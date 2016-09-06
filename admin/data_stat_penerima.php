<?php

session_start();
include ("cek_session.php");
require ("library.php");
$individu=new individu();
$sql=$individu->chart_hasil_seleksi();
$tampil=$sql->fetch(PDO::FETCH_ASSOC);
$jumlah_penerima=$tampil['diterima'];
$jumlah_ditolak=$tampil['ditolak'];
$rows = array(["Diterima",$jumlah_penerima],["Ditolak",$jumlah_ditolak]);
print json_encode($rows, JSON_NUMERIC_CHECK);
?>

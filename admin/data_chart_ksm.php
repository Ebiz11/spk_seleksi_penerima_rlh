<?php
require ("library.php");
$individu=new individu();
$penjualan=$individu->chart_ksm();
$rows = array();
while($data_penjualan = $penjualan->fetch(PDO::FETCH_ASSOC)) {
	$row[0] = $data_penjualan['nama_ksm'];
	$row[1] = $data_penjualan['total_pnpm_mp']+$data_penjualan['total_swadaya'];
	array_push($rows,$row);//memasukan data ke dalam $rows array
}

print json_encode($rows, JSON_NUMERIC_CHECK);

?>

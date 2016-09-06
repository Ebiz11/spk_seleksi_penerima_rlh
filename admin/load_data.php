<?php
session_start();
include ("cek_session.php");
require ("library.php");
$individu= new individu();
$data=$individu->penduduk($_POST['parent_id']);
$response=array();
$jumlah=$data->rowCount();
		if($data){
			if($jumlah > 0){
				while($row = $data->fetch(PDO::FETCH_ASSOC)){
					$response[] = $row;
				}
			}else{
				$response['error'] = 'Data kosong';
			}
		}else{
		}
		die(json_encode($response));
?>

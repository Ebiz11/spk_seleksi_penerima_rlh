<?php
include ("cek_session.php");
require "library.php";
$individu=new individu();

$tampil_ksm=$individu->show_ksm();
$jumlah_ksm=$tampil_ksm->rowCount();

$tampil_pengajuan=$individu->show_calon_penerima("P");
$belum_diproses=$tampil_pengajuan->rowCount();

$sql=$individu->chart_hasil_seleksi();
$tampil=$sql->fetch(PDO::FETCH_ASSOC);
$jumlah_penerima=$tampil['diterima'];
$jumlah_ditolak=$tampil['ditolak'];

$jumlah_pengajuan=$jumlah_ditolak+$jumlah_penerima+$belum_diproses;
 ?>
 <div class="row wrapper border-bottom white-bg page-heading">
     <div class="col-lg-10">
         <h2>Home</h2>
         <ol class="breadcrumb">
             <li class="active">
                 <strong>Home</strong>
             </li>
         </ol>
     </div>
     <div class="col-lg-2">
     </div>
 </div>
<div class="wrapper wrapper-content">
        <div class="row">
                    <div class="col-lg-3">
                        <div class="ibox float-e-margins">
                            <div class="ibox-title">
                                <span class="label label-success pull-right"></span>
                                <h5>KSM</h5>
                            </div>
                            <div class="ibox-content">
                                <h1 class="no-margins"><?php echo $jumlah_ksm ?></h1>
                                <small>Total KSM</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="ibox float-e-margins">
                            <div class="ibox-title">
                                <span class="label label-info pull-right"></span>
                                <h5>Pengajuan</h5>
                            </div>
                            <div class="ibox-content">
                                <h1 class="no-margins"><?php echo $jumlah_pengajuan ?></h1>
                                <small>Total pengajuan</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="ibox float-e-margins">
                            <div class="ibox-title">
                                <span class="label label-primary pull-right"></span>
                                <h5>Penerima Manfaat</h5>
                            </div>
                            <div class="ibox-content">
                                <h1 class="no-margins"><?php echo $jumlah_penerima ?></h1>
                                <small>Total penerima manfaat</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="ibox float-e-margins">
                            <div class="ibox-title">
                                <span class="label label-danger pull-right"></span>
                                <h5>Pengajuan Ditolak</h5>
                            </div>
                            <div class="ibox-content">
                                <h1 class="no-margins"><?php echo $jumlah_ditolak ?></h1>
                                <small>Total calon penerima ditolak</small>
                            </div>
                        </div>
                      </div>
                    </div>
                    <div class="ibox-content">

        		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        		<title>Highcharts Pie Chart</title>
        		<script type="text/javascript">
        		$(document).ready(function() {
        			var options = {
        				chart: {
        	                renderTo: 'container',
        	                plotBackgroundColor: null,
        	                plotBorderWidth: null,
        	                plotShadow: false
        	            },
        	            title: {
        	                text: 'Statistik Hasil Seleksi'
        	            },
        	            tooltip: {
        	                formatter: function() {
        	                    return '<b>'+ this.point.name +'</b>: '+ this.percentage +' %';
        	                }
        	            },
        	            plotOptions: {
        	                pie: {
        	                    allowPointSelect: true,
        	                    cursor: 'pointer',
        	                    dataLabels: {
        	                        enabled: true,
        	                        color: '#000000',
        	                        connectorColor: '#000000',
        	                        formatter: function() {
        	                            return '<b>'+ this.point.name +'</b>: '+ this.percentage +' %';
        	                        }
        	                    }
        	                }
        	            },
        	            series: [{
        	                type: 'pie',
        	                name: 'Browser share',
        	                data: []
        	            }]
        	        }

        	        $.getJSON("data_stat_penerima.php", function(json) {
        				options.series[0].data = json;
        	        	chart = new Highcharts.Chart(options);
        	        });

              	});
        		</script>
        		<script src="../js/highchart.js"></script>
                <script src="../js/exporting.js"></script>
        	<body>
        		<div id="container" style="min-width: 400px; height: 400px; margin: 0 auto"></div>
        	</body>
        </div>
        </div>

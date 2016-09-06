<?php
include ("cek_session.php"); ?>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
          <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>Statistik </h5>
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
            <div class="ibox-content"><br><br>

<script type="text/javascript">
	var chart1;
$(document).ready(function() {
      chart1 = new Highcharts.Chart({
         chart: {
            renderTo: 'container',
            type: 'column'
         },
         title: {
            text: 'Grafik Dana PNPM-MP per KSM'
         },
         xAxis: {
            categories: ['Nama KSM']
         },
         yAxis: {
            title: {
               text: 'Jumlah'
            }
         },
              series:
            [
<?php

    require ("library.php");
    $penjualan=new individu();
    $tampil_barang=$penjualan->show_ksm();
    while ($ambil=$tampil_barang->fetch(PDO::FETCH_ASSOC)) {
    $nama=$ambil['nama_ksm'];
    $stok=$penjualan->chart_ksm_pnpm($nama);
    while ($data=$stok->fetch(PDO::FETCH_ASSOC)) {
	   $stokx = $data['pnpm_mp'];
	  }

	  ?>
	  {
		  name: '<?php echo $nama; ?>',
		  data: [<?php echo $stokx; ?>]
	  },
	  <?php } ?>
]
});
});
</script><br><br>

<script src="../js/highchart.js"></script>
<script src="../js/exporting.js"></script>

<body>
<div id="container" style="min-width: 400; height: 400; margin: 10 auto"></div>
</body>
</div>
</div>
</div>
</div>
</div>

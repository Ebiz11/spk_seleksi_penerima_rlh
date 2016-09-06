<?php
include ("cek_session.php"); ?>
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-9">
        <h2>Statistik</h2>
        <ol class="breadcrumb">
            <li>
                <a href="index?page=home">Home</a>
            </li>
            <li class="active">
                <strong>Statstik</strong>
            </li>
        </ol>
    </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
  <div class="row">
      <div class="col-lg-12">
      <div class="ibox float-e-margins">
          <div class="ibox-title">
              <h5></h5>
              <div class="ibox-tools">
                  <a class="collapse-link">
                      <i class="fa fa-chevron-up"></i>
                  </a>
                  <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                      <i class="fa fa-wrench"></i>
                  </a>
                  <ul class="dropdown-menu dropdown-login">
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
        <script src="../js/highchart.js"></script>
        <script src="../js/exporting.js"></script>
        <div class="grafik" style="width:100%; height:400px;"></div>

        <?php
        require ("library.php");
        $individu=new individu();
        $array_periode = array();
        $array_kategori = array();
        $array_series = array();
        $array_datas = array();
        $array_attribute = array('PNPM', 'SWADAYA');
        $ambil=$individu->data_chart_periode();
        while ($data_chart=$ambil->fetch(PDO::FETCH_ASSOC)){
        $periode_id = $data_chart['id_periode'];
        $periode = $data_chart['tahun'];
        array_push($array_periode, array('id'=>$periode_id, 'periode'=>$periode));
        array_push($array_kategori, $periode);
        }

        foreach($array_periode as $key=>$val){
        $array_datas[$val['periode']] = array();
        $values=intval($val['id']);
        $hasil=$individu->hasil_chart_dana($values);
        while ($data_hasil=$hasil->fetch(PDO::FETCH_ASSOC)) {
        $pnpm = $data_hasil['pnpm'];
        $swadaya = $data_hasil['swadaya'];
        $array_datas[$val['periode']]['PNPM'] = intval($pnpm);
        $array_datas[$val['periode']]['SWADAYA'] = intval($swadaya);
        }
        }
        foreach($array_attribute as $attribute){
        array_push($array_series, array('name'=>$attribute, 'data'=>array()));
        }
        foreach($array_kategori as $kategori){
        $i = 0;
        foreach($array_attribute as $attribute){
        array_push($array_series[$i]['data'], $array_datas[$kategori][$attribute]);
        $i++;
        }
        }
        ?>
            <script type="text/javascript">
            $('.grafik').highcharts({
            chart: {
            type: 'column',
            marginTop: 80
            },
            credits: {
            enabled: false
            },
            tooltip: {
            shared: true,
            crosshairs: true,
            headerFormat: '<b>{point.key}</b>< br />'
            },
            title: {
            text: 'Statistik Dana Pnpm & Swadaya'
            },
            subtitle: {
            text: ''
            },
            xAxis: {
            categories: <?php echo json_encode($array_kategori); ?>,
            labels: {
            rotation: 0,
            align: 'right',
            style: {
            fontSize: '10px',
            fontFamily: 'Verdana, sans-serif'
            }
            }
            },
            legend: {
            enabled: true
            },
            series: <?php echo json_encode($array_series); ?>
            });
            </script>
        </div>
      </div>
    </div>
  </div>
</div>

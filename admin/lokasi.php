<?php include ("cek_session.php"); ?>
<div class="row wrapper border-bottom white-bg page-heading">
  <div class="col-lg-9">
      <h2>Data Lokasi</h2>
      <ol class="breadcrumb">
          <li>
              <a href="index?page=home">Home</a>
          </li>
          <li class="active">
              <strong>Data Lokasi</strong>
          </li>
      </ol>
  </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <!-- <h5>Data Lokasi</h5> -->
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

<script src="http://maps.google.com/maps/api/js?sensor=false"></script>

<script type="text/javascript">
	var peta;
	var gambar_tanda;
	gambar_tanda = '../img/marker.png';

	function peta_awal(){
		// posisi default peta saat diload
	    var lokasibaru = new google.maps.LatLng(-7.8, 110.3666667);
    	var petaoption = {
			zoom: 13,
			center: lokasibaru,
			mapTypeId: google.maps.MapTypeId.ROADMAP
        };

	    peta = new google.maps.Map(document.getElementById("map_canvas"),petaoption);

	    // ngasih fungsi marker buat generate koordinat latitude & longitude
	    tanda = new google.maps.Marker({
	        position: lokasibaru,
	        map: peta,
	        icon: gambar_tanda,
	        draggable : true
	    });

	    // ketika markernya didrag, koordinatnya langsung di selipin di textfield
	    google.maps.event.addListener(tanda, 'dragend', function(event){
				document.getElementById('latitude').value = this.getPosition().lat();
				document.getElementById('longitude').value = this.getPosition().lng();
		});
	}

	function setpeta(x,y,id){
		// mengambil koordinat dari database
		var lokasibaru = new google.maps.LatLng(x, y);
		var petaoption = {
			zoom: 14,
			center: lokasibaru,
			mapTypeId: google.maps.MapTypeId.ROADMAP
		};

		peta = new google.maps.Map(document.getElementById("map_canvas"),petaoption);

		 // ngasih fungsi marker buat generate koordinat latitude & longitude
		tanda = new google.maps.Marker({
			position: lokasibaru,
			icon: gambar_tanda,
			draggable : true,
			map: peta
		});

		// ketika markernya didrag, koordinatnya langsung di selipin di textfield
		google.maps.event.addListener(tanda, 'dragend', function(event){
				document.getElementById('latitude').value = this.getPosition().latitude();
				document.getElementById('longitude').value = this.getPosition().longitude();
		});
	}
</script>

<body onload="peta_awal()">
	 <div id="map_canvas" style="width:100%; height:500px"></div>
      <br/>
      <br/>
      <table class="table table-striped table-bordered table-hover dataTables-example" >
      <thead>

        <tr>
            <th>No </th>
            <th>Nama </th>
            <th>No Ktp</th>
            <th>Foto</th>
            <th>Detail</th>
        </tr>
        </thead>
        <tbody>
          <?php
          require ("library.php");
          $individu= new individu();

          $no=1;
              $querycalon_penerima=$individu->show_calon_penerima("Y");
              while ($datacalon_penerima = $querycalon_penerima->fetch(PDO::FETCH_ASSOC)) {
              if($datacalon_penerima['latitude']==0 AND $datacalon_penerima['longitude']==0){ }else{
          ?>
            <tr class="gradeX">
                <td><?php echo $no++; ?></td>
                <?php
                $data_penduduk=$individu->detail_penduduk($datacalon_penerima['no_ktp']);
                $tampil_penduduk=$data_penduduk->fetch(PDO::FETCH_ASSOC);
                 ?>
                <td><?php echo "<a href=\"javascript:setpeta(".$datacalon_penerima['latitude'].",".$datacalon_penerima['longitude'].",".$datacalon_penerima['id_calon_penerima'].")\">".$tampil_penduduk['nama']."</a>"; ?></td>
                <td><?php echo $datacalon_penerima['no_ktp'] ?></td>
                <td><a href="index?page=gambar&id_calon_penerima=<?php echo $datacalon_penerima['id_calon_penerima'] ?>">Lihat</a></td>
                <td><a href="index?page=detail_calon_penerima&id_calon_penerima=<?php echo $datacalon_penerima['id_calon_penerima'] ?>">Lihat</a></td>

            </tr>
            <?php }} ?>
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

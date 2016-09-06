<?php
include ("cek_session.php");
require ("library.php");
$individu= new individu();
$id_calon_penerima=$_GET['id_calon_penerima'];

// tambah
if( isset($_POST['tambah']) ){
	$nama  = $_POST['nama_foto'];
	$kondisi = $_POST['kondisi'];
	$keterangan  = $_POST['keterangan'];
	$lokasi_file  = $_FILES["foto"]["tmp_name"];
	$nama_file    = $_FILES["foto"]["name"];
	move_uploaded_file($lokasi_file,"foto/$nama_file");
	$add_file=$individu->add_foto($nama,$id_calon_penerima,$kondisi,$keterangan,$nama_file);
	$_SESSION['berhasil'] = '<b>BERHASIL MENYIMPAN:</b> Data foto berhasil ditambahkan.';
}

// delete
if( isset($_POST['hapus']) ){
	$foto=$individu->detail_foto($_POST['id_foto']);
	$data  = $foto->fetch(PDO::FETCH_ASSOC);

	$nama_folder="foto/";
	@unlink($nama_folder.$data['foto']);
	$del=$individu->del_foto($_POST['id_foto']);
	$_SESSION['berhasil'] = '<b>BERHASIL MENGHAPUS:</b> Data foto berhasil dihapus.';
}
?>

    <link href="css/plugins/blueimp/css/blueimp-gallery.min.css" rel="stylesheet">
		<div class="row wrapper border-bottom white-bg page-heading">
      <div class="col-lg-9">
          <h2>Data Foto
					<?php
					$tampil_foto=$individu->detail_calon_penerima($id_calon_penerima);
					$dt=$tampil_foto->fetch(PDO::FETCH_ASSOC);
					$data_penduduk=$individu->detail_penduduk($dt['no_ktp']);
					$tampil_penduduk=$data_penduduk->fetch(PDO::FETCH_ASSOC);
					echo '<b>'.$tampil_penduduk['nama'].'</b>';
					 ?></h2>
          <ol class="breadcrumb">
              <li>
                  <a href="index?page=home">Home</a>
              </li>
              <li class="active">
                  <strong>Data Foto</strong>
              </li>
          </ol>
      </div>
  </div>
<div class="wrapper wrapper-content">
    <div class="row">
        <div class="col-lg-12">
        <div class="ibox float-e-margins">

            <div class="ibox-content">
							<!-- notifikasi --> <?php include ("notifikasi.php") ?> <!--  -->
							<div class="lightBoxGallery">
							<button class="add-record btn btn-sm btn-primary" href="#">Tambah Data</button>
								<table class="table table-striped table-bordered table-hover dataTables-example" >
	              <thead>
	              <tr>
	                <th>No</th>
	                <th>Nama</th>
	                <th>Kondisi</th>
	                <th>Keterangan</th>
	                <th>Foto</th>
	                <th>Aksi</th>
	              </tr>
	              </thead>
	              <tbody>

	                <?php
											$no=1;
											$tampil_foto=$individu->show_foto($id_calon_penerima);
											while($data  = $tampil_foto->fetch(PDO::FETCH_ASSOC))
											{
	                ?>
	                  <tr class="gradeX">
												<td><?php echo $no++ ?></td>
	                      <td scr="foto/<?php echo $data['foto'] ?>"><?php echo $data['nama_foto'] ?></td>
	                      <td><?php echo $data['kondisi'] ?></td>
	                      <td><?php echo $data['keterangan'] ?></td>
												<td><a href="foto/<?php echo $data['foto'] ?>" title="Image from Unsplash" data-gallery=""> <img src="foto/<?php echo $data['foto'] ?>" width="100px" height="100px"> </td>
												<td>
	                        <a class="hapus-record btn btn-sm btn-danger" href="#" data-id="<?php echo $data['id_foto'] ?>"><i class="fa fa fa-trash"></i></a></td>
	                    </td>
	                  </tr>
	                  <?php } ?>
	              </tbody>
	              <tfoot>
	              <tr>
	              </tr>
	              </tfoot>
	              </table>
								<div id="blueimp-gallery" class="blueimp-gallery">
										<div class="slides"></div>
										<h3 class="title"></h3>
										<a class="prev">‹</a>
										<a class="next">›</a>
										<a class="close">×</a>
										<a class="play-pause"></a>
										<ol class="indicator"></ol>
								</div>
						</div>
            </div>
        </div>
    </div>
</div>
<!-- modal tambah -->
<div class="modal inmodal fade" data-backdrop="static" id="add_gambar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="modal-dialog">
<div class="modal-content">
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
<h4 class="modal-title">Tambah Gambar</h4>
<small class="font-bold"></small>
</div>
<form method="post" name="formulir" class="form-horizontal" enctype="multipart/form-data" >
<div class="modal-body">
	<div class="form-group"><label class="col-sm-2 control-label">Nama</label>
		<div class="col-sm-10">
			<div class="col-sm-10"><input type="text" name="nama_foto" class="form-control" required></div>
	</div>
	</div>
	<div class="form-group"><label class="col-sm-2 control-label">Kondisi</label>
		<div class="col-sm-10">
			<div class="col-sm-10"><input type="text" name="kondisi" class="form-control" required></div>
	</div>
	</div>
	<div class="form-group"><label class="col-sm-2 control-label">Keterangan</label>
		<div class="col-sm-10">
			<div class="col-sm-10"><input type="text" name="keterangan" class="form-control" required></div>
	</div>
	</div>
	<div class="form-group"><label class="col-sm-2 control-label">Upload</label>
		<div class="col-sm-10">
			<div class="col-sm-10"><input type="file" name="foto"  required></div>
	</div>
	</div>
		</div>
		<div class="modal-footer">
		<button type="button" class="btn btn-white" data-dismiss="modal">Batal</button>
		<button class="btn btn-primary" type="submit" name="tambah">Simpan</button>
		</div>
		</form>
		</div>
		</div>
		</div>

<!-- modal hapus -->
<div class="modal inmodal fade" data-backdrop="static" id="modal_hapus" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
	<div class="modal-content">
	<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
	<h4 class="modal-title">Hapus Gambar</h4>
	<small class="font-bold"></small>
	</div>
	<form method="post" name="formulir" class="form-horizontal" enctype="multipart/form-data" >
	<div class="modal-body"> <div class="hapus"> </div> </div>
	<div class="modal-footer">
	<button type="button" class="btn btn-white" data-dismiss="modal">Batal</button>
	<button class="btn btn-primary" type="submit" name="hapus">Simpan</button>
	</div>
	</form>
	</div>
	</div>
</div>
<!--  -->

</div>
    <script src="js/plugins/blueimp/jquery.blueimp-gallery.min.js"></script>

		<script>
		    // $(function(){
		    //     $(document).on('click','.edit-record',function(e){
		    //         e.preventDefault();
		    //         $("#modal_edit").modal('show');
		    //         $.post('edit_sub_kriteria.php',
		    //             {id:$(this).attr('data-id')},
		    //             function(html){
		    //                 $(".edit").html(html);
		    //             }
		    //         );
		    //     });
		    // });

		    $(function(){
		        $(document).on('click','.hapus-record',function(e){
		            e.preventDefault();
		            $("#modal_hapus").modal('show');
		            $.post('delete_gambar.php',
		                {id:$(this).attr('data-id')},
		                function(html){
		                    $(".hapus").html(html);
		                }
		            );
		        });
		    });

		    $(function(){
		        $(document).on('click','.add-record',function(e){
		            e.preventDefault();
		            $("#add_gambar").modal('show');
		        });
		    });
		</script>

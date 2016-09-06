<?php
include ("cek_level.php");
require ("library.php");
$individu= new individu();
$profile_matching= new profile_matching();

if(isset($_POST['hapus'])){
  $del=$profile_matching->del_analisa($_POST['id_analisa']);
  $update=$profile_matching->update_status_diterima($_POST['id_analisa']);
  if ($del==true AND $update==true) {
    $_SESSION['berhasil'] = '<b>BERHASIL MENGHAPUS:</b> Data Analisa berhasil dihapus.';
  }else {
    $_SESSION['gagal'] = '<b>GAGAL MENGHAPUS:</b> Data Analisa gagal dihapus.';
  }
}

?>
<div class="row wrapper border-bottom white-bg page-heading">
  <div class="col-lg-9">
      <h2>Laporan Hasil Analisa</h2>
      <ol class="breadcrumb">
          <li>
              <a href="index?page=home">Home</a>
          </li>
          <li class="active">
              <strong>Laporan Hasil Analisa</strong>
          </li>
      </ol>
  </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
      <div class="row">
          <div class="col-lg-12">
          <div class="ibox float-e-margins">
              <div class="ibox-title">
                  <!-- <h5>Laporan Hasil Analisa</h5> -->
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
                <?php include("notifikasi.php"); ?>
              <table class="table table-striped table-bordered table-hover dataTables-example" >
              <thead>
              <tr>
                <th>Periode</th>
                <th>Diterima</th>
                <th>Ditolak</th>
                <th>Total</th>
                <th>Detail</th>
                <th>Perhitungan</th>
                <th>Tanggal Analisa</th>
                <th>Aksi</th>
              </tr>
              </thead>
              <tbody>

                <?php
                  $no=1;
                  $lap_analisa=$profile_matching->lap_analisa();
                  while ($data_analisa = $lap_analisa->fetch(PDO::FETCH_ASSOC)){
                ?>
                  <tr class="gradeX">
                      <td><?php echo $no++ ?></td>
                      <td><?php echo $data_analisa['jumlah_diterima'] ?></td>
                      <td><?php echo $data_analisa['jumlah_ditolak'] ?></td>
                      <td><?php echo $jumtot=$data_analisa['jumlah_ditolak']+$data_analisa['jumlah_diterima']; ?></td>
                      <td><a href="index?page=lap_detail_analisa&id_analisa=<?php echo $data_analisa['id_analisa'] ?>">Lihat</a></td>
                      <td><a href="index?page=data_detail_analisa&id_analisa=<?php echo $data_analisa['id_analisa'] ?>">Lihat</a></td>
                      <td><?php echo date("d-m-Y", strtotime($data_analisa['tanggal_proses'])) ?></td>
                      <td> <a class="hapus_id_analisa btn btn-sm btn-danger" href="#" data-id="<?php echo $data_analisa['id_analisa'] ?>"><i class="fa fa fa-trash"></i></a></td>
                  </tr>
                  <?php } ?>
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

<!-- modal hapus -->
<div class="modal inmodal fade" data-backdrop="static" id="modal_hapus" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
  <div class="modal-content">
  <div class="modal-header">
  <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
  <h4 class="modal-title">Hapus User</h4>
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
<script>
$(function(){
    $(document).on('click','.hapus_id_analisa',function(e){
        e.preventDefault();
        $("#modal_hapus").modal('show');
        $.post('hapus_id_analisa.php',
            {id:$(this).attr('data-id')},
            function(html){
                $(".hapus").html(html);
            }
        );
    });
});
</script>

<?php
include ("cek_session.php");
require ("library.php");
$individu= new individu();
 ?>
 <div class="row wrapper border-bottom white-bg page-heading">
               <div class="col-lg-9">
                   <h2>Galeri Foto</h2>
                   <ol class="breadcrumb">
                       <li>
                           <a href="index?page=home">Home</a>
                       </li>
                       <li class="active">
                           <strong>Galeri Foto</strong>
                       </li>
                   </ol>
               </div>
           </div>
<div class="wrapper wrapper-content">
    <div class="row">
        <div class="col-lg-12">
        <div class="ibox float-e-margins">

            <div class="ibox-content">
              <div class="lightBoxGallery">
              <?php
              $no=1;
              $tampil_galery_foto=$individu->show_galery_foto();
              while($data  = $tampil_galery_foto->fetch(PDO::FETCH_ASSOC)) {
              ?>
              <a href="foto/<?php echo $data['foto'] ?>" title="Kondisi <?php echo $data['kondisi']?>" data-gallery="">
              <img src="foto/<?php echo $data['foto'] ?>" width="100px" height="100px"></a>

                    <?php } ?>
                    <!-- The Gallery as lightbox dialog, should be a child element of the document body -->
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

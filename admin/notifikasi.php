
<?php
// berhasil
if (isset($_SESSION['berhasil']) && $_SESSION['berhasil'] <> '') {
echo  '<div class="berhasil alert alert-success "><i class="fa fa-check-circle"></i> '.$_SESSION['berhasil'].'</div>';
}
$_SESSION['berhasil'] = '';
//

// peringatan
if (isset($_SESSION['warning']) && $_SESSION['warning'] <> '') {
echo  '<div class="warning alert alert-warning alert-dismissable ">
<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button><i class="fa fa-exclamation-circle"></i>
'.$_SESSION['warning'].'</div>';
}
$_SESSION['warning'] = '';
//

// gagal
if (isset($_SESSION['gagal']) && $_SESSION['gagal'] <> '') {
echo  '<div class="gagal alert alert-danger alert-dismissable ">
<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button><i class="fa fa-exclamation-circle"></i>
'.$_SESSION['gagal'].'</div>';
}
$_SESSION['gagal'] = '';
//

?>

<script>
    $(document).ready(function(){setTimeout(function(){$(".berhasil").fadeIn('slow');}, 1000);});
    setTimeout(function(){$(".berhasil").fadeOut('slow');}, 10000);

    $(document).ready(function(){setTimeout(function(){$(".gagal").fadeIn('slow');}, 1000);});
    setTimeout(function(){$(".gagal").fadeOut('slow');}, 20000);

    $(document).ready(function(){setTimeout(function(){$(".warning").fadeIn('slow');}, 1000);});
    setTimeout(function(){$(".warning").fadeOut('slow');}, 20000);
</script>

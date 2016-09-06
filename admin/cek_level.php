<?php
if (isset($_SESSION['level']) AND $_SESSION['nama']){
   if ($_SESSION['level'] == "1") {
   } elseif ($_SESSION['level'] == "2") {
     session_unset('login');
     session_destroy();
    echo "<script>document.location='../404';</script>";
    }
} elseif (!isset($_SESSION['level'])){
header('location:../index.php');
}
?>

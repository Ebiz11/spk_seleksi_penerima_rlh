<?php
if (isset($_SESSION['level']) AND $_SESSION['nama']){
} else if (!isset($_SESSION['level'])){
header('location:../index.php');
}
?>

<?php
include("session.php");
//session_start();
session_unset('login');
session_unset('nama');
session_unset('level');
session_destroy();
header("location: ../");
?>

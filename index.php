<?php
include("admin/session.php");
?>
<!DOCTYPE html>
<html>
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet">
    <link href="css/animate.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
</head>

<body class="gray-bg">

    <div class="middle-box text-center loginscreen  animated fadeInDown">
        <div>
<br><br><br><br><br><br><br><br><br><br><br><br>
            <p>Login in. To see it in action.</p>
            <form action="" class="m-t" role="form" method="POST">
                <div class="form-group">
                    <input type="text" name="username" class="form-control" placeholder="No Ktp" maxlength="50" required="">
                </div>
                <div class="form-group">
                    <input type="password" name="password" class="form-control" placeholder="Password" required="">
                </div>

								<?php
	if(isset($_POST['login'])){
	// include("koneksi-pdo.php");

	require("admin/library.php");
	$baru=new login();

		$username=$baru->input_form($_POST['username']);
		$password=$baru->input_form($_POST['password']);

		$cek_login=$baru->login($username);
		$login=$cek_login->fetch(PDO::FETCH_ASSOC);

		$usernamenya=empty($login['username'])?'':$login['username'];
		$passwordnya=empty($login['password'])?'':$login['password'];

		//$pass_baru=$baru->encrypt_pertama($password);
		$encrypt=$baru->encrypt($password);
    $individu=new individu;

		if($encrypt == $passwordnya && $username == $usernamenya){

			$_SESSION['login'] = $_POST['username'];
      $cek_penduduk=$individu->detail_penduduk($_SESSION['login'] );
      $hasil_cek=$cek_penduduk->fetch(PDO::FETCH_ASSOC);
      $_SESSION['nama'] = $hasil_cek['nama'];
			$_SESSION['level'] = $login['level'];
			login_validasi();
			header("location: admin");

		} else { ?>
			<div class="alert alert-warning alert-dismissible" role="alert">
			<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
			<strong>Maaf:</strong> Kombinasi username dan password salah.
			</div>
		<?php } } ?>
        <button type="submit" name="login" class="btn btn-primary block full-width m-b">Login</button>
        </form>
        <p class="m-t"> <small>Tamanmartani &copy; <?php echo date("Y") ?></small> </p>
    </div>
</div>
<!-- Mainly scripts -->
<script src="js/jquery-2.1.1.js"></script>
<script src="js/bootstrap.min.js"></script>
</body>
</html>

<?php
	session_start();
	require '../function/function.php';
	if (!isset($_SESSION['login_admin'])){
		header("Location: ../user/login.php");
		exit;
	}	
?>
<!DOCTYPE html>
<html>
<head>
	<title>Admin</title>
	<link rel="stylesheet" type="text/css" href="../../asset/materialize/css/materialize.min.css">
	<link rel="stylesheet" type="text/css" href="../../asset/css/admin_custom.css">
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
</head>
<body class="grey lighten-3">
	<div class="navbar-fixed">
		<nav>
		    <div class="nav-wrapper grey lighten-4">
		      <a href="#!" class="brand-logo _logo-padding"><img src="../../asset/img/logo_web/logo.png" width="250"></a>
		      <ul class="hide-on-med-and-down _search-padding">
		        <li class="right"><a class="waves-effect waves-light btn" href="../function/logout.php">log out</a></li>
		      </ul>
		    </div>
	  	</nav>
	</div>

	<div class="container">
		<h3 class="blue-text center">Selamat Datang Admin Elektronika</h3>
		<div class="_content">
			<div>
				<h4 class="center-align">Pilih Opsi</h4><br>
			</div>
			<div class="_edit left">
				<a href="barang.php" class="tooltipped" data-position="top" data-tooltip="Edit Barang"><img src="../../asset/img/logo_web/barang.jpg" width="300px"></a>
			</div>
			
			<div class="_edit left">
				<a href="toko.php" class="tooltipped" data-position="top" data-tooltip="Edit Toko"><img src="../../asset/img/logo_web/toko.jpg" width="300px"></a>
			</div>
			<div class="_edit left">
				<a href="customer.php" class="tooltipped" data-position="top" data-tooltip="Edit Customer"><img src="../../asset/img/logo_web/customer.png" width="300px"></a>
			</div>
		</div>
	</div>


	<script type="text/javascript" src="../../asset/materialize/js/materialize.min.js"></script>
	<script type="text/javascript">
		var elems = document.querySelectorAll('.tooltipped');
		var instances = M.Tooltip.init(elems); 
	</script>
</body>
</html>
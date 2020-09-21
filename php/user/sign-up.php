<?php
	require '../function/function.php';
  if (isset($_POST['buat_akun'])) 
  {
      if (buat_akun($_POST,$_FILES) > 0) 
      {
        echo "<script>alert('akun berhasil di buat')</script>";
        header("Location: login.php");
      }
      else
      {
        echo "<script>alert('akun gagal di buat')</script>";
      }
  }
?>


<!DOCTYPE html>
<html>
<head>
	<title>Sign-Up</title>
	<link rel="stylesheet" type="text/css" href="../../asset/materialize/css/materialize.min.css">
	<link rel="stylesheet" type="text/css" href="../../asset/css/sign-up_custom.css">
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
</head>
<body class="grey lighten-2">
	<div class="container">
		<div class="_content-sign-up grey lighten-5">
			<div class="_content">
               <h4 class="center">Sign Up</h4>

               <form action="" method="post" enctype="multipart/form-data">
	            <!-- USERNAME -->
	                  <div class="input-field">
	                      <i class="material-icons prefix">person</i>
	                      <input type="text" id="username" name="username">
	                      <label for="username">username</label>
	                  </div>

	            <!-- Password -->
	                  <div class="input-field">
	                      <i class="material-icons prefix">lock</i>
	                      <input type="password" id="password" name="password">
	                      <label for="password">password</label>
	                  </div>

	            <!-- konfirmasi password -->
	                  <div class="input-field">
	                      <i class="material-icons prefix">https</i>
	                      <input type="password" id="k_password" name="k_password">
	                      <label for="k_password">konfirmasi password</label>
	                  </div>

	            <!-- SALDO -->
	                  <div class="input-field">
	                      <i class="material-icons prefix">local_atm</i>
	                      <input type="text" id="saldo" name="saldo">
	                      <label for="saldo">saldo anda</label>
	                  </div>

	            <!-- foto profile-->
	                  <div class="input-field">
	                      <i class="material-icons prefix">photo_camera</i>
	                      <input type="file" id="gambar" name="gambar">
	                      <label for="gambar"></label>
	                  </div>
	                  <div class="_submit center"><button class="btn" type="submit" name="buat_akun">submit</button></div>
	            </form>
			</div>
		</div>	
	</div>


	<script type="text/javascript" src="../../asset/js/materialize.min.js"></script>
</body>
</html>
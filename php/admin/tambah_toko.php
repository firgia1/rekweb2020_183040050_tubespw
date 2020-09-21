<?php
  session_start();
  require '../function/function.php';
  if (!isset($_SESSION['login_admin'])){
    header("Location: ../user/login.php");
    exit;
  }
  if (isset($_POST['tambah_toko'])) 
  {
      if (tambah_toko($_POST,$_FILES) > 0) 
      {
          echo "<script>alert('Data Toko berhasil di tambahkan')</script>";
          header("Location: toko.php");
      }
      else
      {
          echo "<script>alert('Data Toko gagal di tambahkan')</script>";
      }
  }
  $query_kurir = mysqli_query(koneksi(),"SELECT * FROM kurir");
?>



<!DOCTYPE html>
<html>
<head>
	<title>Tambah Toko</title>
	<link rel="stylesheet" type="text/css" href="../../asset/materialize/css/materialize.min.css">
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <style type="text/css">
    ._content{
      border:1px solid grey;
      padding: 20px;
      border-radius: 10px;
      box-shadow: 10px 10px 10px black;
      margin-top: 30px;
      margin-bottom: 30px;
    }
    ._content button
    {
      margin-left: 400px;
      margin-top: 20px;
      margin-bottom: 20px;
    }
  </style>
</head>
<body class="grey lighten-3">

	<div class="container">
   <div class="_content grey lighten-5">
    <h3 class="blue-text">Tambah Toko</h3><br>
		<form action="" method="post" enctype="multipart/form-data">
       <div class="input-field">
          <i class="material-icons prefix">person</i>
          <input type="file" id="gambar" name="gambar">
          <label for="gambar"></label>
       </div>
	     <div class="input-field">
          <input type="text" id="nama_toko" name="nama_toko">
          <label for="nama_toko">nama toko</label>
        </div>

        <h5 class="blue-text">alamat</h5>
        <div class="input-field">
          <input type="text" id="jln_toko" name="jln_toko">
          <label for="jln_toko">jln</label>
        </div>    

        <div class="input-field">
          <input type="text" id="kota_toko" name="kota_toko">
          <label for="kota_toko">kota</label>
        </div>    


        <div>
          <h5 class="blue-text">Kurir</h5>
          <?php while ($data = mysqli_fetch_assoc($query_kurir)) { ?>
          <label>
        	  <input type="checkbox" class="filled-in" name="<?=$data['id_kurir']?>">
           	<span><?=$data['nama_kurir']?></span><br>
      	  </label>
        <?php } ?>
        </div>

        <div><button class="btn" name="tambah_toko">tambah</button></div>
		</form>
   </div>
	</div>


	<script type="text/javascript" src="../../asset/js/materialize.min.js"></script>
</body>
</html>
<?php
  session_start();
  require '../function/function.php';
  if (!isset($_SESSION['login_admin'])){
    header("Location: ../user/login.php");
    exit;
  }
  if (isset($_POST['tambah_barang'])) 
  {
      if (tambah_barang($_POST,$_FILES) > 0) 
      {
        echo "<script>alert('Data Barang berhasil di tambahkan')</script>";
        header("Location: barang.php");
      }
      else
      {
        echo "<script>alert('Data barang gagal di tambahkan')</script>";
      }
  }
  
  $query_toko = mysqli_query(koneksi(),"SELECT * FROM toko INNER JOIN alamat ON toko.id_toko = alamat.id_toko");
  $query_kondisi = mysqli_query(koneksi(),"SELECT * FROM kondisi");
?>
<!DOCTYPE html>
<html>
<head>
	<title>Tambah Barang</title>
	<link rel="stylesheet" type="text/css" href="../../asset/materialize/css/materialize.min.css">
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <style type="text/css">
    ._content
    {
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
    <h3 class="blue-text">Tambah barang</h3><br>
		<form action="" method="post" enctype="multipart/form-data">
            <div class="input-field"> <br>
              <i class="material-icons prefix">person</i>
              <input type="file" id="gambar" name="gambar" required>
              <label for="gambar"></label>
            </div> 

		      	<div class="input-field">
              <input type="text" id="nama_barang" name="nama_barang" required>
              <label for="nama_barang">nama barang</label>
            </div>

            <div class="input-field">
              <input type="text" id="merk_barang" name="merk_barang" required>
              <label for="merk_barang">merk barang</label>
            </div>

            <div>
              <h5 class="blue-text">kondisi</h5>
              <?php while($data_kondisi = mysqli_fetch_assoc($query_kondisi)) {?>
              <label>
                <input type="radio" class="filled-in" name="kondisi" value="<?=$data_kondisi['id_kondisi']?>" required>
                <span><?=$data_kondisi['kondisi']?></span><br>
              </label>
              <?php }?>
            </div>


            <div class="input-field">
              <input type="text" id="stok_barang" name="stok_barang" required>
              <label for="stok_barang">stok barang</label>
            </div>

            <div class="input-field">
              <input type="text" id="harga_barang" name="harga_barang" required>
              <label for="harga_barang">harga barang</label>
            </div> <br>

            

            <div>
              <h5 class="blue-text">Pilih Toko</h5>
              <?php while($data = mysqli_fetch_assoc($query_toko)) {?>
              <label>
    	        	<input type="radio" class="filled-in" name="toko" value="<?= $data['id_toko']?>" required>
    	        	<span><?= $data['nama_toko'] ?> (<?=$data['kota']?>)</span>
  	      	  </label> <br>
              <?php }?>
            </div> <br> <br>

            <div class="input-field">
              <h5 class="blue-text">deskripsi barang</h5>
              <textarea class="materialize-textarea" name="deskripsi_barang" id="deskripsi_barang" rows="10" placeholder="tulis deskripsi barang anda sesuai barang yang anda jual"></textarea>
            </div>
            <div><button class="btn center" name="tambah_barang">tambah</button></div>
		</form>
   </div>
	</div>

	<script type="text/javascript" src="../../asset/js/materialize.min.js"></script>
</body>
</html>
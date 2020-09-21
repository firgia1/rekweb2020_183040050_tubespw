<?php
 session_start();
  require '../function/function.php';
  if (!isset($_SESSION['login_admin'])){
    header("Location: ../user/login.php");
    exit;
  }
  if (isset($_POST['ubah_barang'])) 
  {
      if (ubah_barang($_POST,$_FILES) > 0) 
      {
       echo "<script>
             alert('Data Barang berhasil di Ubah');
            </script>";
       header("Location: barang.php");exit;
      }
      else
      {
        echo "<script>alert('Data Barang tidak di Ubah');</script>";
      }   
  }

  $id_barang = $_GET['id_barang'];
  $data_barang = query("SELECT * FROM barang WHERE id_barang = $id_barang")[0];
  $data_kondisi_barang = query("SELECT * FROM kondisi_barang WHERE id_barang = $id_barang")[0];
  $query_toko = query("SELECT * FROM toko INNER JOIN alamat ON toko.id_toko = alamat.id_toko");
  $query_kondisi = query("SELECT * FROM kondisi");
?>
<!DOCTYPE html>
<html>
<head>
	<title>Ubah Barang</title>
	<link rel="stylesheet" type="text/css" href="../../asset/materialize/css/materialize.min.css">
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <style type="text/css">
    ._content{
      border:1px solid grey;
      padding: 20px;
      border-radius: 10px;
      box-shadow: 10px 10px 10px black;
      margin-top: 30px;
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
    <h3 class="blue-text">Ubah barang</h3><br>
		<form action="" method="post" enctype="multipart/form-data">

            <input type="hidden" name="id_barang" value="<?=$data_barang['id_barang']?>">
            <input type="hidden" name="gambar_barang_lama" value="<?=$data_barang['gambar_barang']?>">
            
            <div class="input-field">
              <img src="../../asset/img/database/barang/<?= $data_barang['gambar_barang']?>" width = "200px">
              <input type="file" id="gambar" name="gambar">
              <label for="gambar"></label>
            </div>

		      	<div class="input-field">
              <input type="text" id="nama_barang" name="nama_barang" value="<?=$data_barang['nama_barang']?>" required>
              <label for="nama_barang">nama barang</label>    
            </div>

            <div class="input-field">
              <input type="text" id="merk_barang" name="merk_barang" value="<?= $data_barang['merk_barang']?>" required>
              <label for="merk_barang">merk barang</label>
            </div>

            <div>   
                <?php foreach($query_kondisi as $data_kondisi) {?>
                  <?php if($data_kondisi_barang['id_kondisi'] == $data_kondisi['id_kondisi']){?>
                  <label>
                    <input type="radio" class="filled-in" name="kondisi" value="<?= $data_kondisi['id_kondisi']?>" checked>
                    <span><?=$data_kondisi['kondisi']?></span>
                  </label> <br>
                  <?php } else { ?>
                  <label>
                    <input type="radio" class="filled-in" name="kondisi" value="<?= $data_kondisi['id_kondisi']?>">
                    <span><?=$data_kondisi['kondisi']?></span>
                  </label> <br>
                  <?php }?>
                <?php }?>
            </div>

            <div class="input-field">
              <input type="text" id="stok_barang" name="stok_barang" value="<?= $data_barang['stok_barang']?>" required>
              <label for="stok_barang">stok barang</label>
            </div>

            
            
            <div class="input-field">
              <input type="text" id="harga_barang" name="harga_barang" value="<?= $data_barang['harga_barang']?>" required>
              <label for="harga_barang">harga barang</label>
            </div> 


            <div>     
              <?php foreach($query_toko as $data_toko) { ?>
                <?php if($data_toko['id_toko'] == $data_barang['id_toko']){ ?>
                    <label>
                      <input type="radio" class="filled-in" name="toko" value="<?= $data_toko['id_toko']?>" checked>
                      <span><?=$data_toko['nama_toko']?> (<?=$data_toko['kota']?>)</span>
                    </label> <br>
                <?php  } else { ?>
                    <label>
                      <input type="radio" class="filled-in" name="toko" value="<?= $data_toko['id_toko']?>">
                      <span><?=$data_toko['nama_toko']?> (<?=$data_toko['kota']?>)</span>
                    </label> <br>
                <?php  } ?>
              <?php }?> 
            </div><br>

            <div class="input-field">
              <h5 class="blue-text">deskripsi barang</h5>
               <textarea class="materialize-textarea" name="deskripsi_barang" id="deskripsi_barang" rows="10" placeholder="tulis deskripsi barang anda sesuai barang yang anda jual" required><?= $data_barang['deskripsi_barang']?>     
               </textarea>
            </div>
            <div><button class="btn center" name="ubah_barang">Ubah</button></div>
		</form>
   </div>
	</div>

	<script type="text/javascript" src="../../asset/js/materialize.min.js"></script>
</body>
</html>
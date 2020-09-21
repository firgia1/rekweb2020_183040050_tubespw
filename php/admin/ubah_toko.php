<?php
  session_start();
  require '../function/function.php';
  if (!isset($_SESSION['login_admin']))
  {
    header("Location: ../user/login.php");
    exit;
  }

  $id_toko = $_GET['id'];
  $query_toko = query("SELECT * FROM toko INNER JOIN alamat ON toko.id_toko = alamat.id_toko WHERE toko.id_toko = $id_toko");
  $query_kurir = query("SELECT * FROM kurir");
  $query_kurirtoko = query("SELECT * FROM kurir_toko INNER JOIN kurir ON kurir.id_kurir = kurir_toko.id_kurir WHERE kurir_toko.id_toko = $id_toko");
  
  if (isset($_POST['ubah_toko'])) 
  {
      if(ubah_toko($_POST,$_FILES) > 0)
      {
        header("Location: toko.php");
      }  
  }
  
  $kurir_toko = [];
  foreach ($query_kurirtoko as $data)
  {
    $kurir_toko[] = $data['id_kurir'];
  }
?>

<!DOCTYPE html>
<html>
<head>
	<title>ubah Toko</title>
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
    <h3 class="blue-text">Ubah Toko</h3><br>

		<form action="" method="post" enctype="multipart/form-data">
      
      <?php foreach($query_toko as $data_toko) {?>
        <input type="hidden" name="id_toko" value="<?=$data_toko['id_toko']?>">
        <input type="hidden" name="gambar_barang_lama" value="<?=$data_toko['gambar_toko']?>">

         <div class="input-field">
            <img src="../../asset/img/database/toko/<?= $data_toko['gambar_toko']?>" width="200"><br>
            <input type="file" id="gambar" name="gambar">
            <label for="gambar"></label>
         </div>
    
  	     <div class="input-field">
            <input type="text" id="nama_toko" name="nama_toko" value="<?= $data_toko['nama_toko']?>">
            <label for="nama_toko">nama toko</label>
          </div>

          <div class="input-field">
            <input type="text" id="jln_toko" name="jln_toko" value="<?= $data_toko['jalan']?>">
            <label for="jln_toko">jln</label>
          </div>   

          <div class="input-field">
            <input type="text" id="kota_toko" name="kota_toko" value="<?= $data_toko['kota']?>">
            <label for="kota_toko">kota</label>
          </div>  

          <div>
            <h5 class="blue-text">Kurir</h5>
              <?php foreach ($query_kurir as $data_kurir){?>
                <?php if(in_array($data_kurir['id_kurir'], $kurir_toko)){?>
                   <label>
                    <input type="checkbox" class="filled-in" name="<?=$data_kurir['id_kurir']?>" checked>
                    <span><?=$data_kurir['nama_kurir']?></span><br>
                   </label>
                <?php } else { ?>
                   <label>
                    <input type="checkbox" class="filled-in" name="<?=$data_kurir['id_kurir']?>">
                    <span><?= $data_kurir['nama_kurir']?></span><br>
                   </label>
                <?php } ?>
              <?php } ?>            
          </div>
      <?php }?>
        <div><button class="btn" name="ubah_toko">ubah</button></div>
		</form>
   </div>
	</div>
	<script type="text/javascript" src="../../asset/js/materialize.min.js"></script>
</body>
</html>
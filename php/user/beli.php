<?php
	session_start();
	require '../function/function.php';
	if (!isset($_SESSION['login'])){
		header("Location: login.php");
		exit;
	}	
	$id_barang = $_GET['id_barang'];
	$id_toko = $_GET['id_toko'];
	$username = $_GET['username'];
	$query_barang = query("SELECT * FROM barang INNER JOIN toko ON toko.id_toko = barang.id_toko INNER JOIN alamat ON toko.id_toko = alamat.id_toko INNER JOIN kondisi_barang ON barang.id_barang = kondisi_barang.id_barang INNER JOIN kondisi ON kondisi_barang.id_kondisi = kondisi.id_kondisi WHERE barang.id_barang = $id_barang");
	$query_kurir = query("SELECT * FROM kurir INNER JOIN kurir_toko ON kurir.id_kurir = kurir_toko.id_kurir WHERE kurir_toko.id_toko = $id_toko");
	$query_customer = query("SELECT * FROM customer WHERE username = '$username'");
?>
<!DOCTYPE html>
<html>
<head>
	<title>Beli</title>
	<link rel="stylesheet" type="text/css" href="../../asset/materialize/css/materialize.min.css">
	<link rel="stylesheet" type="text/css" href="../../asset/css/beli_custom.css">
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
</head>
<body class="grey lighten-3">
	<!-- Navbar -->
	<div class="navbar-fixed">
		<nav>
		    <div class="nav-wrapper grey lighten-4">
		      <a href="index.php?username=<?=$username?>" class="brand-logo _logo-padding"><img src="../../asset/img/logo_web/logo.png" width="250"></a>
		      <form>
			      <ul class="hide-on-med-and-down _search-padding">
			        <li class="right"><a class='dropdown-trigger grey-text' href='#' data-target='dropdown2'>
  					<i class="material-icons">account_circle</i>
            		</a></li>		        
			      </ul>
		  	  </form>
		    </div>
	  	</nav>
	</div>

	<form>
		<ul id='dropdown2' class='dropdown-content'>
			<?php foreach ($query_customer as $cs) { ?>
			<img class="left" src="../../asset/img/database/customer/<?=$cs['foto'];?>" width="50px">	
			<div class="right"><h6 class="blue-text left"><?=$cs['username'];?></h6></div>
	    	<p class="red-text">Saldo: Rp<?=$cs['saldo'];?></p>
	    	<a class="waves-effect waves-light btn right _logout" href="../function/logout.php">log out</a>
	    	<?php }?>
		</ul>
	</form>

	<div class="container">
		

		<!-- SIDEBAR TOKO -->
		<?php foreach ($query_barang as $data_barang) { ?>
		<div class="right grey lighten-4 _side-bar _padding-sidebar">
			
			<div class="center"><img src="../../asset/img/database/toko/<?=$data_barang['gambar_toko']?>" width="100"></div>
			<div class="center">
				<h6><?=$data_barang['nama_toko']?></h6> 
				
			</div><hr><br> <br>
			<div>
				<h7 class="left">Dukungan Pengiriman : </h7><br>
				<ol>
					<?php foreach ($query_kurir as $data_kurir) { ?>
					<li><?=$data_kurir['nama_kurir']?></li>
					<?php }?>
				</ol>
			</div><hr><br> <br>
			<div>
				<h7 class="left">Alamat : </h7><br>
				<p><?= $data_barang['jalan']?></p>
			</div><hr><br> <br>
		</div> 

		<!-- Spesifikasi Barang-->
		<div class="left _spek-barang grey lighten-5">
			<div class="left _gambar-barang grey lighten-3"><img src="../../asset/img/database/barang/<?= $data_barang['gambar_barang']?>" width="400px" class ="materialboxed" ></div>
			<div class="_nama-barang"><h5><?= $data_barang['nama_barang']?></h5></div>
			<div class="left">
				<p>Merk     : <?= $data_barang['merk_barang']?></p>
				<p>Stok : <?= $data_barang['stok_barang']?></p>
				<p>Kondisi : <?= $data_barang['kondisi']?> </p>
				<a class="btn modal-trigger" href="" data-target="beli"> Beli</a>
			</div> <br> <br>
			<div class="left _spek-barang-harga"><h4 class="center blue-text">Rp. <?= $data_barang['harga_barang']?></h4></div>
		</div>

		<div class="left _deskripsi grey lighten-5">
			<h5>Deskripsi Barang</h5>
			<p>
				<span>
					<?= $data_barang['deskripsi_barang']?>
				</span>    
			</p>
		</div>

		<!-- proses pembelian  -->
		<div class="modal" id="beli">
            <div class="modal-content">
              <h4 class="center">Beli Barang</h4><br>
               <form action="bayar.php?username=$_GET['username']&id_barang=$_GET['id_barang']&kurir=<?=$_GET['kurir']?>&jumlah_barang=<?=$_GET['jumlah_barang']?>" method="get">
               	<input type="hidden" name="username" value="<?=$username?>">
               	<input type="hidden" name="id_barang" value="<?=$id_barang?>">
               	<input type="hidden" name="id_toko" value="<?=$id_toko?>">
               	<table>
               		<tr>
               			<th class="center">barang</th>
               			<th class="center">harga</th>
               			<th class="center">jumlah</th>
               			<th class="center">Pengiriman</th>
               		</tr>

               		<tr>
               			<td class="center"><?= $data_barang['nama_barang']?><br><img src="../../asset/img/database/barang/<?= $data_barang['gambar_barang']?>" width= "100px"><br></td>
               			<td class="center">RP. <?= $data_barang['harga_barang']?></td>
               			<td class="center"><div class="input-field _beli-barang-jumlah">
	                      		<input type="text" id="jumlah_beli" name="jumlah_beli" required>
	                      		<label for="jumlah_beli">beli</label>
	                		</div></td>
	                	<td>
	                		<?php foreach ($query_kurir as $kurir) { ?>
						      <label>
						        <input type="radio" class="filled-in" name="kurir" value="<?=$kurir['nama_kurir']?>" required>
						        <span><?= $kurir['nama_kurir']?></span>
						      </label><br>
						  	 <?php } ?>
	                	</td>
               		</tr>     		
               	</table>     
	               <!-- <div>
	                    <h6 class="red-text center"><i class="material-icons prefix">warning</i>mohon maaf saldo anda tidak cukup</h6>
	               </div> -->
				   <div class="center"><button type="submit" name="bayar" class="btn">Bayar</button></div>                                              
               </form>
               
            </div>
        </div>
		<?php }?>
	</div>

	<script type="text/javascript" src="../../asset/js/materialize.min.js"></script>
	<script type="text/javascript">	
	const modal = document.querySelectorAll('.modal');
    M.Modal.init(modal);

  	const dropdown = document.querySelectorAll('.dropdown-trigger')
      M.Dropdown.init(dropdown,
      {
        constrainWidth : false,
        hover : true,
        coverTrigger : false
      });

    document.addEventListener('DOMContentLoaded', function() {
    var elems = document.querySelectorAll('.materialboxed');
    var instances = M.Materialbox.init(elems);
	});
	</script>
	
</body>
</html>
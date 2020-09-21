<?php
	session_start();
	require '../function/function.php';
	if (!isset($_SESSION['login'])){
		header("Location: login.php");
		exit;
	}
	$username = $_GET['username'];
	$_SESSION['username'] = $username;
	$lokasi = [['lokasi' => 'bandung'],['lokasi' => 'jakarta'],['lokasi' => 'surabaya']];
	$query_kondisi = query("SELECT * FROM kondisi");
	$customer = query("SELECT * FROM customer WHERE username = '$username'");
	$query_cari_categori = null; $query_urutkan = null;
	if (isset($_GET['urutkan'])) {
		$query_urutkan .= urutkan($_GET['urutkan']);
	}
	if (isset($_GET['cari'])){
		$query_cari_categori .= cari_kategori();
	}
	$query = $query_cari_categori .$query_urutkan;
	$query_barang = query("SELECT * FROM barang INNER JOIN toko ON toko.id_toko = barang.id_toko INNER JOIN alamat ON toko.id_toko = alamat.id_toko INNER JOIN kondisi_barang ON barang.id_barang = kondisi_barang.id_barang INNER JOIN kondisi ON kondisi_barang.id_kondisi = kondisi.id_kondisi $query");
?>

<!DOCTYPE html>
<html>
<head>
	<title>User</title>
	<link rel="stylesheet" type="text/css" href="../../asset/materialize/css/materialize.min.css">
	<link rel="stylesheet" type="text/css" href="../../asset/css/user_custom.css">
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
			        <li><label for="keyword" ><i class="material-icons">search</i></label></li>
			        <li><input type="text" name="keyword" id="keyword" autofocus placeholder="cari barang"></li>
			        <li class="right"><a class='dropdown-trigger grey-text' href='#' data-target='dropdown2'>
  					<i class="material-icons">account_circle</i>
            		</a></li>
			        <li class="right"><a class='dropdown-trigger grey-text' href='#' data-target='dropdown1'>urutkan</a></li>
			      </ul>
		  	  </form>
		    </div>
	  	</nav>
	</div>
<!-- Akhir Navbar -->


<!-- Dropdown urutan -->
	<form>
		<ul id='dropdown1' class='dropdown-content'>
	    	<li><a href="index.php?username=<?=$username?>&&urutkan=termurah">termurah</a></li>
	    	<li><a href="index.php?username=<?=$username?>&&urutkan=termahal">termahal</a></li>
		</ul>
	</form>
<!-- Akhir Dropdown urutan -->


<!-- Dropdown akun -->
	<form>
		<ul id='dropdown2' class='dropdown-content'>
			<?php foreach ($customer as $cs) { ?>
			<img class="left" src="../../asset/img/database/customer/<?=$cs['foto'];?>" width="50px">	
			<div class="right"><h6 class="blue-text left"><?=$cs['username'];?></h6></div>
	    	<p class="red-text">Saldo: Rp<?=$cs['saldo'];?></p>
	    	<a class="waves-effect waves-light btn right _logout" href="../function/logout.php">log out</a>
	    	<?php }?>
		</ul>
	</form>
<!-- Akhir Dropdown akun -->


<!-- container -->
	<div class="container">
	<!-- SIDEBAR -->
		<div class="left grey lighten-5 _side-bar _padding-sidebar">
			<!-- Sidebar content -->
			<div>
				<form class="_padding-sidebar" action="" method="get">
				<!-- Harga -->
					<input type="hidden" name="username" value="<?=$username?>">
					<h6>Harga</h6> 
					<div class="input-field">
	                      <input type="text" id="h_minimum" name="h_minimum">
	                      <label for="h_minimum">minimum</label>
	                </div>
					<div class="input-field">
	                      <input type="text" id="h_maximum" name="h_maximum">
	                      <label for="h_maximum">maximum</label>
	                </div><br><hr><br>
                <!-- Akhir Harga -->

	            <!-- Lokasi -->
					<h6>Lokasi</h6>
					<p>
					<?php foreach ($lokasi as $data_lokasi) { ?>
				      <label>
				        <input type="checkbox" class="filled-in" name="<?= $data_lokasi['lokasi']?>" value="<?= $data_lokasi['lokasi']?>">
				        <span><?= $data_lokasi['lokasi']?></span>
				      </label><br>
				    <?php } ?>
				    </p><br> <hr> <br>
			    <!-- Akhir Lokasi -->

			    <!-- Kondisi -->
				    <h6>Kondisi</h6>
				    <p>
				    <?php foreach ($query_kondisi as $kondisi) { ?>
				      <label>
				        <input type="checkbox" class="filled-in" name="<?= $kondisi['kondisi']?>" value="<?= $kondisi['id_kondisi']?>">
				        <span><?= $kondisi['kondisi']?></span>
				      </label><br>
				  	 <?php } ?>
				      <button type="submit" name="cari">cari!</button>
				    </p>
			    <!-- Akhir Kondisi -->
				</form>
			</div> 
			<!-- Akhir Sidebar content -->
		</div>
	<!-- Akhir SIDEBAR -->


	<!-- Content barang yang akan di jual -->
		<div class="right grey lighten-4 _content">	
			<div id="container">
			<?php foreach($query_barang as $data_barang){ 
				$id_barang = $data_barang['id_barang'];
				 $query_kondisi = query("SELECT * FROM kondisi INNER JOIN kondisi_barang on kondisi.id_kondisi = kondisi_barang.id_kondisi WHERE kondisi_barang.id_barang = $id_barang");
					foreach ($query_kondisi as $data_kondisi) { ?>
						
				<div class="left grey lighten-5 _content-data" >
					<a href="beli.php?id_barang=<?=$data_barang['id_barang']?>&id_toko=<?=$data_barang['id_toko']?>&username=<?=$username?>">
					<div>
						<div class="center"><img src="../../asset/img/database/barang/<?=$data_barang['gambar_barang']?>"width=150px></div>
						<div class="_nama-barang black-text"><h5><?= $data_barang['nama_barang']?></h5></div>
						<div class="left red-text lighten-4 _content-harga ">RP <?= $data_barang['harga_barang']?></div>
					</div>
					<div class="right grey-text lighten-4 _content-kondisi">(<?= $data_kondisi['kondisi']?>)</div><br>
					<div class="left _lokasi-barang black-text"><?=$data_barang['kota']?></div></a>
				</div>
				<?php } ?>
			<?php } ?>		
			</div>
		</div>
	<!-- Akhir Content barang yang akan di jual -->
	</div>
<!-- Akhir container -->

	<script type="text/javascript" src="../../asset/js/materialize.min.js"></script>
	<script type="text/javascript">	
  	const dropdown = document.querySelectorAll('.dropdown-trigger')
      M.Dropdown.init(dropdown,
      {
        constrainWidth : false,
        hover : true,
        coverTrigger : false
      });

		var keyword = document.getElementById('keyword');
		var container = document.getElementById('container');

		keyword.addEventListener('keyup', function() 
		{
			var xhr = new XMLHttpRequest();
			xhr.onreadystatechange = function()
			{
				if (xhr.readyState == 4 && xhr.status == 200) 
				{
					container.innerHTML = xhr.responseText;
				}
			}
			xhr.open('GET', '../ajax/ajax_index.php?username=<?=$username?>&keyword='+keyword.value,true);
			xhr.send();
		});
	</script>
</body>
</html>
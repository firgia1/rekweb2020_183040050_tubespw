<?php
	session_start();
	require '../function/function.php';
	if (!isset($_SESSION['login_admin'])){
		header("Location: ../user/login.php");
		exit;
	}

	$query_toko = mysqli_query(koneksi(),"SELECT * FROM toko INNER JOIN alamat ON toko.id_toko = alamat.id_toko");
?>

<!DOCTYPE html>
<html>
<head>
	<title>Toko</title>
	<link rel="stylesheet" type="text/css" href="../../asset/materialize/css/materialize.min.css">
	<link rel="stylesheet" type="text/css" href="../../asset/css/toko_custom.css">
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
</head>
<body class="grey lighten-3">

	<div class="navbar-fixed">
		<nav>
		    <div class="nav-wrapper grey lighten-4">
		      <a href="admin.php" class="brand-logo _logo-padding"><img src="../../asset/img/logo_web/logo.png" width="250"></a>
		      <form>
			      <ul class="hide-on-med-and-down _search-padding">
			        <li><label for="keyword" ><i class="material-icons">search</i></label></li>
			        <li><input type="text" name="keyword" id="keyword" autofocus placeholder="cari toko"></li>
			        <li class="right "><a class="waves-effect waves-light btn" href="../function/logout.php">log out</a></li>
			      </ul>
		  	  </form>
		    </div>
	  	</nav>
	</div>
	

	<div class="container">
	  <a href="tambah_toko.php" class="btn blue left _tambah-btn">tambahkan toko baru</a> <br> <br>
	  <div class="_content">
		<table border="2px" cellpadding="10px" cellspacing="0px" class="centered grey-striped" id="container">		
			<thead class="grey lighten-2">
				<tr>
					<th>No.</th>
					<th>Gambar Toko</th>
					<th>Nama Toko</th>
					<th>Kota Toko</th>
					<th>Kurir toko</th>
					<th>Opsi</th>
				</tr>
			</thead>

			<tbody>
				<?php $i=1; while ($datatoko = mysqli_fetch_assoc($query_toko)) { ?>
				<tr>
					<td><?=$i++;?></td>
					<td><img src="../../asset/img/database/toko/<?= $datatoko['gambar_toko']?>" width="100"></td>
					<td><?= $datatoko['nama_toko']?></td>
					<td><?= $datatoko['kota'];?></td>
				    <td>
				    	<ul>
				    		<?php 
				    		$id_toko= $datatoko['id_toko'];
				    		$query_kurirtoko = mysqli_query(koneksi(),"SELECT * FROM kurir_toko INNER JOIN kurir 
				    			ON kurir.id_kurir = kurir_toko.id_kurir WHERE kurir_toko.id_toko = $id_toko");
							while ($datakurir = mysqli_fetch_assoc($query_kurirtoko)) {?>
				    		<li><?=$datakurir['nama_kurir']?></li>
				    		<?php }?>
				    	</ul>
				    </td> 
				    <td>
				    	<a href="ubah_toko.php?id=<?=$datatoko['id_toko']?>" class="btn blue">ubah</a>
				    	<a href="../function/hapus.php?id_toko=<?=$datatoko['id_toko']?>" class="btn red">hapus</a>
				    </td>
				</tr>
				<?php }?>
			</tbody>
		</table>
	   </div>
	</div>

	<script type="text/javascript" src="../../asset/js/materialize.min.js"></script>

	<script type="text/javascript">
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
			xhr.open('GET', '../ajax/ajax_toko.php?keyword='+keyword.value,true);
			xhr.send();
		});
	</script>
</body>
</html>
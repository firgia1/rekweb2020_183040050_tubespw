<?php
	session_start();
	require '../function/function.php';
	if (!isset($_SESSION['login_admin'])){
		header("Location: ../user/login.php");
		exit;
	}	
	$query_barang = query("SELECT * FROM barang");
?>

<!DOCTYPE html>
<html>
<head>
	<title>Barang</title>
	<link rel="stylesheet" type="text/css" href="../../asset/materialize/css/materialize.min.css">
	<link rel="stylesheet" type="text/css" href="../../asset/css/barang_custom.css">
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
</head>
<body class="grey lighten-3">
	<div class="navbar-fixed">
		<nav>
		    <div class="nav-wrapper grey lighten-4">
		      <a href="admin.php" class="brand-logo _logo-padding"><img src="../../asset/img/logo_web/logo.png" width="250"></a>
		      <form action="" method="post">
			      <ul class="hide-on-med-and-down _search-padding">
			        <li><label for="keyword" ><i class="material-icons">search</i></label></li>
			        <li><input type="text" name="keyword" id="keyword" autofocus placeholder="cari barang"></li>
			        <li class="right "><a class="waves-effect waves-light btn" href="../function/logout.php">log out</a></li>
			      </ul>
		  	  </form>
		    </div>
	  	</nav>
	</div>


	<div class="container">
	  <a href="tambah_barang.php" class="btn blue left _tambah-btn">tambahkan barang baru</a> <br> <br>
	  <div class="_content">
		<table border="2px" cellpadding="10px" cellspacing="0px" class="centered grey-striped" id="container">		
			<thead class="grey lighten-2">
				<tr>
					<th>No.</th>
					<th>Gambar Barang</th>
					<th>Nama Barang</th>
					<th>Merk Barang</th>
					<th>Harga Barang</th>
					<th>Opsi</th>
				</tr>
			</thead>

			<tbody>
				<?php $i=1; foreach($query_barang as $data_barang) { ?>
				<tr>
					<td><?=$i++?></td>
					<td><img src="../../asset/img/database/barang/<?=$data_barang['gambar_barang']?>" width="100"></td>
					<td><?= $data_barang['nama_barang']?></td>
					<td><?= $data_barang['merk_barang']?></td>
				    <td>Rp. <?= $data_barang['harga_barang']?></td>
				    <td>
				    	<a href="ubah_barang.php?id_barang=<?=$data_barang['id_barang']?>" class="btn blue">ubah</a>
				    	<a href="../function/hapus.php?id_barang=<?=$data_barang['id_barang']?>" class="btn red">hapus</a>
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
			xhr.open('GET', '../ajax/ajax_barang.php?keyword='+keyword.value,true);
			xhr.send();
		});
	</script>
</body>
</html>
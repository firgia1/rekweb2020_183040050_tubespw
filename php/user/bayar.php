<?php
	session_start();
	require '../function/function.php';
	if (!isset($_SESSION['login'])){
		header("Location: login.php");
		exit;
	}	
	$username = $_GET['username'];
	$id_toko = $_GET['id_toko'];
	$id_barang = $_GET['id_barang'];
	$jumlah_beli = $_GET['jumlah_beli'];
	$kurir = $_GET['kurir'];
	$kode_pembelian = uniqid();
	$query_customer = query("SELECT * FROM customer WHERE username = '$username'")[0];
	$query_kurir = query("SELECT * FROM kurir where nama_kurir = '$kurir'")[0];
	$query_barang = query("SELECT * FROM barang WHERE id_barang = $id_barang")[0];
	$query_toko = query("SELECT * FROM toko INNER JOIN alamat ON toko.id_toko = alamat.id_toko WHERE toko.id_toko = $id_toko")[0];
	$total_harga_barang = $query_barang['harga_barang'] * $jumlah_beli;
	$sisa_saldo = $query_customer['saldo'] - $total_harga_barang - $query_kurir['harga_kurir'];
?>

<!DOCTYPE html>
<html>
<head>
	<title></title>
	<link rel="stylesheet" type="text/css" href="../../asset/materialize/css/materialize.min.css">
	<link rel="stylesheet" type="text/css" href="../../asset/css/bayar_custom.css">	
  	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
</head>
<body class="grey lighten-3">
	<div class="container">
		
		<div class="center _struk-pembelian grey lighten-5">
			<a href="../function/cetak.php?username=<?=$username?>&id_barang=<?=$id_barang?>&kurir=<?=$kurir?>&jumlah_barang=<?=$jumlah_beli?>&id_toko=<?=$id_toko?>" target="_blank"><i class="material-icons">print</i></a>
			<div  class="_toko">
				<h5><?= $query_toko['nama_toko'] ?></h5>
				<h6><?= $query_toko['kota'] ?></h6>

			</div>========================================================
			<div>
				<table>
					<tr>
						<th>Kode. Pembelian</th>
						<td  class="right"><?= $kode_pembelian ?></td>
					</tr>
					<tr>
						<th>tgl beli</th>
						<td class="right"><?= date('d / M / y')?></td>
					</tr>
				</table>
			</div>======================================================== <br><br>
			<div>
				<h6 class="left">Rincian pembelian </h6>
				<table>
					<tr>
						<th>Nama barang</th>
						<td  class="right"><?= $query_barang['nama_barang'] ?></td>
					</tr>
					<tr>
						<th>Harga satuan </th>
						<td class="right">Rp. <?= $query_barang['harga_barang'] ?></td>
					</tr>
					<tr>
						<th>Jumlah Pembelian</th>
						<td class="right"><?= $jumlah_beli ?></td>
					</tr>
					<tr>
						<th>Kurir</th>
						<td class="right"><?= $kurir ?></td>
					</tr>
					<tr>
						<th>Estimasi sampai tujuan</th>
						<td class="right"><?= $query_kurir['durasi_kurir'] ?></td>
					</tr>
				</table>
			</div>
			<div class="_struk-pembelian-content">
				<table>
					<tr>
						<th>saldo anda</th>
						<td  class="right">Rp. <?= $query_customer['saldo'] ?></td>
					</tr>
					<tr>
						<th>total harga barang</th>
						<td  class="right">Rp. <?= $total_harga_barang ?></td>
					</tr>
					<tr>
						<th>biaya kurir</th>
						<td class="right">Rp. <?= $query_kurir['harga_kurir'] ?></td>
					</tr>
				</table>
				<div>
					<h3 class="right">-</h3><br><br><br><hr>
				</div>	
				<table>
					<tr>
						<th class="center">sisa saldo anda</th>
						<td class="right">Rp. <?= $sisa_saldo ?></td>
					</tr>
				</table>
			</div>========================================================
			<p>terima kasih sudah menggunakan jasa dari Elektronika <br>
				harap simpan struk pembayaran ini sebagai bukti pembayaran <br></p>
				<img src="../../asset/img/logo_web/logo.png" width="100">
		</div>
	</div>
</body>
</html>

<?php
require '../../vendor/autoload.php';
require 'function.php';
$username = $_GET['username'];
$id_toko = $_GET['id_toko'];
$id_barang = $_GET['id_barang'];
$jumlah_beli = $_GET['jumlah_barang'];
$kurir = $_GET['kurir'];
$kode_pembelian = uniqid();
$query_customer = query("SELECT * FROM customer WHERE username = '$username'")[0];
$query_kurir = query("SELECT * FROM kurir where nama_kurir = '$kurir'")[0];
$query_barang = query("SELECT * FROM barang WHERE id_barang = $id_barang")[0];
$query_toko = query("SELECT * FROM toko INNER JOIN alamat ON toko.id_toko = alamat.id_toko WHERE toko.id_toko = $id_toko")[0];
$total_harga_barang = $query_barang['harga_barang'] * $jumlah_beli;
$sisa_saldo = $query_customer['saldo'] - $total_harga_barang - $query_kurir['harga_kurir'];

$html = '
	<!DOCTYPE html>
	<html>
	<head>
		<title></title>
		<link rel="stylesheet" type="text/css" href="../../asset/materialize/css/materialize.min.css">
		<link rel="stylesheet" type="text/css" href="../../asset/css/cetak_custom.css">
		<style>
		._struk-pembelian{
			border: 1px solid black;
		}
		</style>
	</head>
	<body>
		<div>
			<div class="center _struk-pembelian">
				<div  class="_toko">
					<h5>' .$query_toko["nama_toko"].'</h5>
					<h6>' .$query_toko["kota"].'</h6>
				</div>=======================================================
				<div>
					<table>
						<tr>
							<th>Kode. Pembelian</th>
							<td  class="right">'.$kode_pembelian.'</td>
						</tr>
						<tr>
							<th>tgl beli</th>
							<td class="right">'.date("d / M / y").'</td>
						</tr>
					</table>
				</div>=======================================================
				<div>
					<h6 class="left">Rincian pembelian </h6>
					<table>
						<tr>
							<th>Nama barang</th>
							<td  class="right">'.$query_barang["nama_barang"].'</td>
						</tr>
						<tr>
							<th>Harga satuan </th>
							<td class="right">Rp. ' .$query_barang["harga_barang"].'</td>
						</tr>
						<tr>
							<th>Jumlah Pembelian</th>
							<td class="right">'. $jumlah_beli .'</td>
						</tr>
						<tr>
							<th>Kurir</th>
							<td class="right">'. $kurir .'</td>
						</tr>
						<tr>
							<th>Estimasi sampai tujuan</th>
							<td class="right">'. $query_kurir["durasi_kurir"].'</td>
						</tr>
					</table>
				</div>
				<div class="_struk-pembelian-content">
					<table>
						<tr>
							<th>saldo anda</th>
							<td  class="right">Rp. '. $query_customer["saldo"] .'</td>
						</tr>
						<tr>
							<th>total harga barang</th>
							<td  class="right">Rp. '. $total_harga_barang .'</td>
						</tr>
						<tr>
							<th>biaya kurir</th>
							<td class="right">Rp. '. $query_kurir["harga_kurir"] .'</td>
						</tr>
					</table><hr>
					<table>
						<tr>
							<th>sisa saldo anda</th>
							<td class="right">Rp. '. $sisa_saldo .'</td>
						</tr>
					</table>
				</div>=======================================================
				<p>terima kasih sudah menggunakan jasa dari Elektronika <br>
					harap simpan struk pembayaran ini sebagai bukti pembayaran <br></p>
					<img src="../../asset/img/logo_web/logo.png" width="100">
			</div>
		</div>
	</body>
	</html>';

$mpdf = new \Mpdf\Mpdf();
$mpdf->WriteHTML($html);
$mpdf->Output();
?>



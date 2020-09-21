<?php
	require '../function/function.php';
	$keyword = $_GET['keyword'];
	$username = $_GET['username'];
	$query = "SELECT * FROM barang INNER JOIN toko ON toko.id_toko = barang.id_toko INNER JOIN alamat ON toko.id_toko = alamat.id_toko WHERE nama_barang LIKE '%$keyword%' OR kota LIKE '%$keyword%'";
	$query_barang = query($query);
?>


<div id="container">
<?php foreach($query_barang as $data_barang){ 
	$id_barang = $data_barang['id_barang'];
	 $query_kondisi = mysqli_query(koneksi(),"SELECT * FROM kondisi INNER JOIN kondisi_barang on kondisi.id_kondisi = kondisi_barang.id_kondisi WHERE kondisi_barang.id_barang = $id_barang");
		while ($data_kondisi = mysqli_fetch_assoc($query_kondisi)) { ?>
			
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

<?php
	require '../function/function.php';
	$keyword = $_GET['keyword'];
	$query = "SELECT * FROM barang WHERE nama_barang LIKE '%$keyword%' OR merk_barang LIKE '%$keyword%'";
	$query_barang = query($query);
?>

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
		<?php $i=1; foreach($query_barang as $data_barang ) { ?>
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
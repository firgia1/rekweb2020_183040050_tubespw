<?php
	require '../function/function.php';
	$keyword = $_GET['keyword'];
	$query = "SELECT * FROM toko INNER JOIN alamat ON toko.id_toko = alamat.id_toko WHERE nama_toko LIKE '%$keyword%' or kota LIKE '%$keyword%'";
	$query_toko = query($query);
?>

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
		<?php $i=1; foreach ($query_toko as $datatoko) { ?>
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
		    	<a href="" class="btn red">hapus</a>
		    </td>
		</tr>
		<?php }?>
	</tbody>
</table>
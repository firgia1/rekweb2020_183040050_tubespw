<?php
	require '../function/function.php';
	$keyword = $_GET['keyword'];
	$query_customer = query("SELECT * FROM customer WHERE username LIKE '%$keyword%' ");
?>


<table border="2px" cellpadding="10px" cellspacing="0px" class="centered grey-striped" id="container">		
	<thead class="grey lighten-2">
		<tr>
			<th>No.</th>
			<th>foto</th>
			<th>username</th>
			<th>Opsi</th>
		</tr>
	</thead>

	<tbody>
		<?php $i=1; foreach($query_customer as $customer) { ?>
		<tr>
			<td><?=$i++?></td>
			<td><img src="../../asset/img/database/customer/<?=$customer['foto']?>" width="100"></td>
			<td><?= $customer['username']?></td>
			
		    <td>
		    	<a href="../function/hapus.php?id_customer=<?=$customer['id_customer']?>" class="btn red">blokir</a>
		    </td>
		</tr>
		<?php } ?>
	</tbody>
</table>

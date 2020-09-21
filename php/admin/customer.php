<?php
	session_start();
	require '../function/function.php';
	if (!isset($_SESSION['login_admin'])){
		header("Location: ../user/login.php");
		exit;
	}
	$query_customer = query("SELECT * FROM customer");
?>

<!DOCTYPE html>
<html>
<head>
	<title></title>
	<link rel="stylesheet" type="text/css" href="../../asset/materialize/css/materialize.min.css">
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
	<style type="text/css">
		._content
		{
			border:1px solid grey;
			margin-bottom: 50px;
		}
		.btn
		{
			border-radius: 5px;
		}
		._search-padding
		{
			margin-left: 300px;
		}
		._logo-padding
		{
			margin-top: 5px;
			margin-left: 30px;
			font-color: blue;
		}

	</style>
</head>
<body class="grey lighten-3">
	<div class="navbar-fixed">
		<nav>
		    <div class="nav-wrapper grey lighten-4">
		      <a href="admin.php" class="brand-logo _logo-padding"><img src="../../asset/img/logo_web/logo.png" width="250"></a>
		      <form action="" method="post">
			      <ul class="hide-on-med-and-down _search-padding">
			        <li><label for="keyword" ><i class="material-icons">search</i></label></li>
			        <li><input type="text" name="keyword" id="keyword" autofocus placeholder="cari customer"></li>
			        <li class="right "><a class="waves-effect waves-light btn" href="../function/logout.php">log out</a></li>
			      </ul>
		  	  </form>
		    </div>
	  	</nav>
	</div>

	<div class="container" ><br><br>
	  <div class="_content">
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
			xhr.open('GET', '../ajax/ajax_customer.php?keyword='+keyword.value,true);
			xhr.send();
		});
	</script>
</body>
</html>
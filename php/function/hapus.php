<?php
	require 'function.php';
	if (isset($_GET['id_barang'])) 
	{
		$id_barang = $_GET['id_barang'];
		if(hapus_barang($id_barang) > 0){
			header("Location: ../admin/barang.php");
		}
	}
	
	if (isset($_GET['id_customer'])) 
	{
		$id_customer = $_GET['id_customer'];
		if(hapus_customer($id_customer) > 0){
			header("Location: ../admin/customer.php");
		}
	}

	if (isset($_GET['id_toko'])) 
	{
		$id_toko = $_GET['id_toko'];
		if(hapus_toko($id_toko) > 0){
			header("Location: ../admin/toko.php");
		}
	}
?>
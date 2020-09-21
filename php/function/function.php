<?php
	function koneksi()
	{
		$koneksi = mysqli_connect("localhost","root","","pw_183040050");
		return $koneksi;
	}

	function query($sql)
	{
		$conn = koneksi();
		$results = mysqli_query($conn,$sql);
		$rows = [];
		while ($row = mysqli_fetch_assoc($results)) {
			$rows[] = $row;
		}
		return $rows;
	}

	function buat_akun($data)
	{
		$conn = koneksi();
		$username = htmlspecialchars($data['username']);
		$password =htmlspecialchars($data['password']);
		$k_password =htmlspecialchars($data['k_password']);
		$saldo	= htmlspecialchars($data['saldo']);
		$username = strtolower($username);

		// untuk mengecek apakah username sudah pernah di gunakan di database
		$dataUsername = mysqli_query($conn,"SELECT username FROM customer WHERE username = '$username'");
		if (mysqli_fetch_assoc($dataUsername)) 
		{
			echo "<script>
		 			alert('username sudah digunakan');
		 		 </script>";
		 		return false;
		}


		$gambar = upload_customer();
		if (!$gambar) 
		{
			return false;
		}

		if ($password !== $k_password) 
		{
			echo "<script>
					alert('konfirmasi password tidak sesuai dengan password');
				 </script>";
			return false;
		}

		$password = password_hash($password, PASSWORD_DEFAULT);
		$tambah_akun = "INSERT INTO customer VALUES('','$username','$password','$saldo','$gambar')";
		mysqli_query($conn,$tambah_akun);
		return mysqli_affected_rows($conn);
	}

	function tambah_toko($data)
	{
		$conn = koneksi();
		$nama = htmlspecialchars($data['nama_toko']);
		
		$alamat_jln = htmlspecialchars($data['jln_toko']);
		$alamat_kota = htmlspecialchars($data['kota_toko']);

		$gambar = upload_toko();
		if (!$gambar) 
		{
			return false;
		}

		// menambahkan toko di tabel toko
		$tambah_toko = mysqli_query($conn,"INSERT INTO toko VALUES ('','$nama','$gambar')");
		
		// mengambil data id toko yang baru di tambahkan
		$max_data = mysqli_fetch_assoc(mysqli_query($conn,"SELECT MAX(id_toko) as 'max_id_toko' FROM toko"));
		$id_toko = $max_data['max_id_toko'];


		$tambah_alamat_toko = mysqli_query($conn,"INSERT INTO alamat VALUES ($id_toko,'','$alamat_jln','$alamat_kota')");
		
		// menambahkan beberapa kurir untuk toko menggunakan pengulangan 
		$kurir_toko;
		$query_kurir = mysqli_query($conn, "SELECT * FROM kurir");
		While($data_kurir = mysqli_fetch_assoc($query_kurir))
		{
			$kurir_toko = $data_kurir['id_kurir'];
			if (isset($_POST[$data_kurir['id_kurir']])) 
			{
				$tambah_kurirtoko = mysqli_query($conn, "INSERT INTO kurir_toko VALUES (
				'$kurir_toko',$id_toko, '')");
			}
		}
		return mysqli_affected_rows($conn);
	}

	function ubah_toko($data)
	{
		$conn = koneksi();
		$id_toko = $data['id_toko'];
		$nama = htmlspecialchars($data['nama_toko']);
		$alamat_jln = htmlspecialchars($data['jln_toko']);
		$alamat_kota = htmlspecialchars($data['kota_toko']);
		$gambarLama = htmlspecialchars($data['gambar_barang_lama']);
		$gambar;

		if($_FILES['gambar']['error'] === 4){
			$gambar = $gambarLama;
		}else{
			$gambar = upload_toko();
		}

		// menambahkan toko di tabel toko
		mysqli_query($conn,"UPDATE toko SET 
					nama_toko = '$nama',
					gambar_toko = '$gambar'
					WHERE id_toko = $id_toko");
		
		// mengambil data id toko yang baru di tambahkan
		mysqli_query($conn,"UPDATE alamat SET 
					jalan = '$alamat_jln',
					kota = '$alamat_kota'
					WHERE id_toko = $id_toko");
		// menambahkan beberapa kurir untuk toko menggunakan pengulangan 
		

		mysqli_query($conn,"DELETE FROM kurir_toko WHERE id_toko = $id_toko");
		$kurir_toko;
		$query_kurir = mysqli_query($conn, "SELECT * FROM kurir");
		
		While($data_kurir = mysqli_fetch_assoc($query_kurir))
		{
			$kurir_toko = $data_kurir['id_kurir'];
			if (isset($_POST[$data_kurir['id_kurir']])) 
			{

				$tambah_kurirtoko = mysqli_query($conn, "INSERT INTO kurir_toko VALUES (
				'$kurir_toko',$id_toko, '')");
			}
		}
		return mysqli_affected_rows($conn);
	}



	function tambah_barang($data)
	{
		$conn = koneksi();
		$nama = htmlspecialchars($data['nama_barang']);
		$merk = htmlspecialchars($data['merk_barang']);
		$stok = htmlspecialchars($data['stok_barang']);
		$deskripsi = htmlspecialchars($data['deskripsi_barang']);
		$harga = htmlspecialchars($data['harga_barang']);

		$gambar = upload_barang();
		if (!$gambar) 
		{
			return false;
		}

		// mengolah semua data id di dalam toko
		$query_toko = mysqli_query($conn, "SELECT * FROM toko");	
		$id_toko;
		

		// mengulang penambahan barang berdasarkan toko yang di tentukan
		While ($data_barang = mysqli_fetch_assoc($query_toko)) 
		{
			$id_toko = $data_barang['id_toko'];
			if ($_POST['toko'] == $id_toko)
			{
				$tambah_barang = mysqli_query($conn, "INSERT INTO barang VALUES(
					'$id_toko','','$gambar','$nama','$merk',$stok,'$deskripsi',$harga)");
			}
		}
		$query_kondisi = mysqli_query($conn, "SELECT * FROM kondisi");
		$max = mysqli_fetch_assoc(mysqli_query($conn,"SELECT MAX(id_barang) as 'max_id_barang' FROM barang"));
		$id_barang = $max['max_id_barang'];

		$id_kondisi;
		While($data_kondisi = mysqli_fetch_assoc($query_kondisi))
		{
			$id_kondisi = $data_kondisi['id_kondisi'];
			if ($_POST['kondisi'] == $id_kondisi) 
			{
				$kondisi = mysqli_query($conn,"INSERT INTO kondisi_barang VALUES ($id_barang,$id_kondisi,'')");
			}
		}
		return mysqli_affected_rows($conn);
	}


	function ubah_barang($data)
	{
		$conn = koneksi();
		$id_barang = $data['id_barang'];
		$nama = htmlspecialchars($data['nama_barang']);
		$merk = htmlspecialchars($data['merk_barang']);
		$stok = htmlspecialchars($data['stok_barang']);
		$deskripsi = htmlspecialchars($data['deskripsi_barang']);
		$harga = htmlspecialchars($data['harga_barang']);
		$toko = $data['toko'];
		$kondisi = $data['kondisi'];
		$gambarLama = htmlspecialchars($data['gambar_barang_lama']);
		
		$gambar;
		if($_FILES['gambar']['error'] === 4){
			$gambar = $gambarLama;
		}else{
			$gambar = upload_barang();
		}
		// mengolah semua data id di dalam toko
		$query_toko = mysqli_query($conn, "SELECT * FROM toko");
		// mengulang penambahan barang berdasarkan toko yang di tentukan
		While ($data_barang = mysqli_fetch_assoc($query_toko)) 
		{
			$id_toko = $data_barang['id_toko'];
			if ($toko == $id_toko)
			{
				mysqli_query($conn, "UPDATE barang SET
					id_toko = '$id_toko',
					gambar_barang = '$gambar',
					nama_barang = '$nama',
					merk_barang = '$merk',
					stok_barang = $stok,
					deskripsi_barang = '$deskripsi',
					harga_barang = $harga
					WHERE id_barang = $id_barang");
			}	
		}
		$ubah_barang = mysqli_affected_rows($conn);
		$query_kondisi = mysqli_query($conn, "SELECT * FROM kondisi");
		While($data_kondisi = mysqli_fetch_assoc($query_kondisi))
		{
			$id_kondisi = $data_kondisi['id_kondisi'];
			if ($kondisi == $id_kondisi) 
			{
				mysqli_query($conn,"UPDATE kondisi_barang SET 
					id_kondisi = $id_kondisi
					WHERE id_barang = $id_barang");
			}
		}	
		$ubah_kondisi =  mysqli_affected_rows($conn);
		if ($ubah_barang === 1 || $ubah_kondisi === 1) {
			return 1;
		}else{
			return 0;
		}

		
	}


	

	function hapus_barang($data)
	{
		$conn = koneksi();
		$id_barang = $data;
		$delete_barang = mysqli_query($conn,"DELETE FROM barang WHERE id_barang = $id_barang");
		return mysqli_affected_rows($conn);
	}

	function hapus_toko($data)
	{
		$conn = koneksi();
		$id_toko = $data;
		$delete_barang = mysqli_query($conn,"DELETE FROM toko WHERE id_toko = $id_toko");
		return mysqli_affected_rows($conn);
	}

	function hapus_customer($data)
	{
		$conn = koneksi();
		$id_customer = $data;
		$delete_barang = mysqli_query($conn,"DELETE FROM customer WHERE id_customer = $id_customer");
		return mysqli_affected_rows($conn);
	}

	function urutkan($urutkan)
	{
		$query = null;
		if ($urutkan == "termurah") {
			$query = "ORDER BY barang.harga_barang ASC";
		}else if($urutkan == "termahal")
		{
			$query = "ORDER BY barang.harga_barang DESC";
		}
		return $query;
	}
	
	function cari_kategori()
	{
		$lokasi = [['lokasi' => 'bandung'],['lokasi' => 'jakarta'],['lokasi' => 'surabaya']];
		//$query_barang = query("SELECT * FROM barang INNER JOIN toko ON toko.id_toko = barang.id_toko INNER JOIN alamat ON toko.id_toko = alamat.id_toko");
		$query_kondisi = query("SELECT * FROM kondisi");
		$query = null;$and = null;$or = null;$where = null;$tambah_query = null;
		$h_minimum = $_GET['h_minimum'];
		$h_maximum = $_GET['h_maximum'];
		
		if ($h_minimum && $h_maximum){
			$query .="(";
			$query .= "barang.harga_barang >= $h_minimum AND barang.harga_barang <= $h_maximum";
			$query .=")";
			$and = " AND ";
			$tambah_query = 1;
		}

		if (isset($_GET['bandung']) || isset($_GET['jakarta']) || isset($_GET['surabaya'])) 
		{
			if ($tambah_query == 1) {
				$query .="$and";
			}
			$query .="(";
			
			foreach ($lokasi as $data_lokasi)
				{	
					if (isset($_GET[$data_lokasi['lokasi']])) 
					{
						$lokasi_barang = $data_lokasi['lokasi'];	
						$query .= "$or alamat.kota LIKE '%$lokasi_barang%'";
						$and = null;
						$or = " OR ";
						$and = " AND ";
					}
				}
			$tambah_query = 2;
			$query .=")";	
		}
		
		if (isset($_GET['baru']) || isset($_GET['bekas'])) 
		{
			if ($tambah_query == 1 || $tambah_query == 2) {
				$query .="$and";
			}
			$or = null;
			$query .="(";
			foreach ($query_kondisi as $kondisi_barang) 
			{
				if (isset($_GET[$kondisi_barang['kondisi']]))
				{
					$kondisi = $kondisi_barang['id_kondisi'];
					$query .= "$or kondisi.id_kondisi = $kondisi";
					$or = " OR ";
				}
			}	
			$query .=")";	
		}
		if (isset($query)){
			$where = "WHERE ";
		}
		$query = $where . $query;
		return $query;
	}



	function upload_toko()
	{
		$namaFile = $_FILES['gambar']['name'];
		$ukuranFile = $_FILES['gambar']['size'];
		$error = $_FILES['gambar']['error'];
		$tmpName = $_FILES['gambar']['tmp_name'];

		if ($error === 4) {
			echo "<script>
					alert('gambar belum di tambahkan');
			 	 </script>";
			return false;
		}
		$gambarValid = ['jpg','jpeg','png'];
		$gambar = explode('.', $namaFile);
		$gambar = strtolower(end($gambar));

		if (!in_array($gambar, $gambarValid)) 
		{
			echo "<script>
					alert('tipe gambar yang diperbolehkan hanya jpg , jpeg, png');
			 	 </script>";
			return false;
		}

		if ($ukuranFile > 2000000) 
		{
			echo "<script>
					alert('Ukuran gambar terlalu besar);
			 	 </script>";
			return false;
		}

		$namaFileBaru = uniqid() .'.' .$gambar;

		move_uploaded_file($tmpName,'../../asset/img/database/toko/' .$namaFileBaru);
		return $namaFileBaru;
	}

	function upload_barang()
	{
		$namaFile = $_FILES['gambar']['name'];
		$ukuranFile = $_FILES['gambar']['size'];
		$error = $_FILES['gambar']['error'];
		$tmpName = $_FILES['gambar']['tmp_name'];

		if ($error === 4) {
			echo "<script>
					alert('gambar belum di tambahkan');
			 	 </script>";
			return false;
		}
		$gambarValid = ['jpg','jpeg','png'];
		$gambar = explode('.', $namaFile);
		$gambar = strtolower(end($gambar));

		if (!in_array($gambar, $gambarValid)) 
		{
			echo "<script>
					alert('tipe gambar yang diperbolehkan hanya jpg , jpeg, png');
			 	 </script>";
			return false;
		}

		if ($ukuranFile > 2000000) 
		{
			echo "<script>
					alert('Ukuran gambar terlalu besar);
			 	 </script>";
			return false;
		}

		$namaFileBaru = uniqid() .'.' .$gambar;

		move_uploaded_file($tmpName,'../../asset/img/database/barang/' .$namaFileBaru);
		return $namaFileBaru;
	}

	function upload_customer()
	{
		$namaFile = $_FILES['gambar']['name'];
		$ukuranFile = $_FILES['gambar']['size'];
		$error = $_FILES['gambar']['error'];
		$tmpName = $_FILES['gambar']['tmp_name'];

		if ($error === 4) {
			echo "<script>
					alert('gambar belum di tambahkan');
			 	 </script>";
			return false;
		}
		$gambarValid = ['jpg','jpeg','png'];
		$gambar = explode('.', $namaFile);
		$gambar = strtolower(end($gambar));

		if (!in_array($gambar, $gambarValid)) 
		{
			echo "<script>
					alert('tipe gambar yang diperbolehkan hanya jpg , jpeg, png');
			 	 </script>";
			return false;
		}

		if ($ukuranFile > 2000000) 
		{
			echo "<script>
					alert('Ukuran gambar terlalu besar);
			 	 </script>";
			return false;
		}

		$namaFileBaru = uniqid() .'.' .$gambar;

		move_uploaded_file($tmpName,'../../asset/img/database/customer/' .$namaFileBaru);
		return $namaFileBaru;
	}
?>
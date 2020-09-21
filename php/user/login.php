<?php
  session_start();
  require '../function/function.php';$alert_error = false;
  if (isset($_SESSION['login'])) {
    $username = $_SESSION['username'];
    header("Location: index.php?username=$username");
    exit;
  }
  if (isset($_SESSION['login_admin'])) {
    header("Location: ../admin/admin.php");
    exit;
  }

  if (isset($_POST['login'])) 
  {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if ($username == "admin" && $password == "admin") {
        $_SESSION['login_admin'] = 'masuk';
        header("Location: ../admin/admin.php");
        exit; 
    }

    $customer = query("SELECT * FROM customer WHERE username = '$username'");
    if (isset($customer[0]['username'])) {
        $password_database = $customer[0];
        if (password_verify($password, $password_database["password"])) {
           $_SESSION['login'] = 'masuk';
           header("Location: index.php?username=$username");
           exit;
        }
    }
    $alert_error = true;
  }

  if (isset($_POST['buat_akun'])) 
  {
      if (buat_akun($_POST,$_FILES) > 0) 
      {
        echo "<script>alert('akun berhasil di buat')</script>";
      }
      else
      {
        echo "<script>alert('akun gagal di buat')</script>";
      }
  }
?>


<!DOCTYPE html>
<html>
<head>
	<title>Login</title>
	<link rel="stylesheet" type="text/css" href="../../asset/materialize/css/materialize.min.css">
	<link rel="stylesheet" type="text/css" href="../../asset/css/login_custom.css">
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
</head>
<body class="grey lighten-2">
<!-- LOGIN -->  
	<div class="container">		
      <div class="_login-content grey lighten-5">
         <h4 class="center">Login</h4>
         <form action="" method="post">

      <!-- USERNAME -->
            <div class="input-field">
                <i class="material-icons prefix">person</i>
                <input type="text" id="username" name="username">
                <label for="username">username</label>
            </div>
      <!-- AKHIR USERNAME -->


  	  <!-- PASSWORD -->
            <div class="input-field">
                <i class="material-icons prefix">lock</i>
                <input type="password" id="pass" name="password">
                <label for="pass">password</label>
            </div>                
      <!-- AKHIR PASSWORD -->

      <!-- BUAT AKUN-->                 
  				  <div class="center">                 
                  <a class="modal-trigger" href="" data-target="sign-up">Belum punya akun / Buat akun baru</a> <br> <br>
                  <button class="btn" name="login">Login</button>                        
            </div>
         </form>
      <!-- AKHIR BUAT AKUN -->
      </div>    
  </div>
<!-- AKHIR LOGGIN -->

        <div class="modal modal-signup _content-sign-up grey lighten-5" id="sign-up">
            <div class="modal-content center">
               <h4 class="center">Sign Up</h4>
               <form action="" method="post" enctype="multipart/form-data">
              <!-- USERNAME -->
                    <div class="input-field">
                        <i class="material-icons prefix">person</i>
                        <input type="text" id="username-signup" name="username">
                        <label for="username-signup">username</label>
                    </div>

              <!-- Password -->
                    <div class="input-field">
                        <i class="material-icons prefix">lock</i>
                        <input type="password" id="password-signup" name="password">
                        <label for="password-signup">password</label>
                    </div>

              <!-- konfirmasi password -->
                    <div class="input-field">
                        <i class="material-icons prefix">https</i>
                        <input type="password" id="k_password-signup" name="k_password">
                        <label for="k_password-signup">konfirmasi password</label>
                    </div>

              <!-- SALDO -->
                    <div class="input-field">
                        <i class="material-icons prefix">local_atm</i>
                        <input type="text" id="saldo" name="saldo">
                        <label for="saldo">saldo anda</label>
                    </div>

              <!-- foto profile-->
                    <div class="input-field">
                        <i class="material-icons prefix">photo_camera</i>
                        <input type="file" id="gambar" name="gambar">
                        <label for="gambar"></label>
                    </div>
                    <button class="btn" type="submit" name="buat_akun">submit</button>
              </form>
            </div>
        </div>
                    
        <div class="modal modal-alert_error">
            <div class="modal-content center">
              <h4 class="center">Login Gagal</h4>
              <i class="red-text medium material-icons prefix">error</i>
              <p class="red-text">username atau password yang anda masukan salah</p>
              <a class="btn blue" href="login.php"><i class="material-icons prefix">loop</i></a>
            </div>
        </div>
                     

  <script type="text/javascript" src="../../asset/js/materialize.min.js"></script>

  <script>
    const modal_signup = document.querySelectorAll('.modal-signup');
      M.Modal.init(modal_signup);
  </script>

<?php if($alert_error) {  $alert_error = null; ?>  
  <script>
    var modal = document.querySelector('.modal-alert_error');
    var instance = M.Modal.init(modal);
    instance.open();
  </script>
<?php  } ?>

</body>
</html>
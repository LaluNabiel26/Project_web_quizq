<?php
include 'koneksi.php';

$error = "";

if(isset($_POST['submit'])){

    $nama = trim($_POST['nama']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    if(empty($nama) || empty($email) || empty($password)){
        $error = "Semua field wajib diisi!";
    }else{

        $cek = mysqli_query($koneksi,"SELECT * FROM users WHERE email='$email'");

        if(mysqli_num_rows($cek) > 0){
            $error = "Email sudah terdaftar!";
        }else{

            $password_hash = password_hash($password, PASSWORD_DEFAULT);

            mysqli_query($koneksi,"
            INSERT INTO users(nama,email,password)
            VALUES('$nama','$email','$password_hash')
            ");

            header("Location: login.php");
            exit;
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Register</title>

<style>

body{
    font-family:Arial, sans-serif;
    background:linear-gradient(135deg,#4facfe,#00f2fe);
    display:flex;
    justify-content:center;
    align-items:center;
    min-height:100vh;
    margin:0;
}

.card{
    background:white;
    width:400px;
    padding:30px;
    border-radius:20px;
    box-shadow:0 10px 25px rgba(0,0,0,0.2);
}

h2{
    text-align:center;
    margin-bottom:20px;
    color:#333;
}

input{
    width:100%;
    padding:12px;
    margin:10px 0;
    border:1px solid #ccc;
    border-radius:8px;
    box-sizing:border-box;
}

button{
    width:100%;
    padding:12px;
    border:none;
    background:#198754;
    color:white;
    border-radius:8px;
    cursor:pointer;
    font-size:16px;
}

button:hover{
    background:#157347;
}

.error{
    background:#f8d7da;
    color:#842029;
    padding:10px;
    border-radius:8px;
    margin-bottom:15px;
}

.login-link{
    text-align:center;
    margin-top:15px;
}

.login-link a{
    text-decoration:none;
    color:#0d6efd;
}

</style>

</head>
<body>

<div class="card">

    <h2>📝 Register Akun</h2>

    <?php if($error != ""){ ?>
        <div class="error">
            <?php echo $error; ?>
        </div>
    <?php } ?>

    <form method="POST">

        <input
            type="text"
            name="nama"
            placeholder="Nama Lengkap"
            required
        >

        <input
            type="email"
            name="email"
            placeholder="Email"
            required
        >

        <input
            type="password"
            name="password"
            placeholder="Password"
            required
        >

        <button type="submit" name="submit">
            Daftar
        </button>

    </form>

    <div class="login-link">
        Sudah punya akun?
        <a href="login.php">Login</a>
    </div>

</div>

</body>
</html>
<?php
session_start();

include '../koneksi.php';

if(isset($_POST['login'])){

    $email = $_POST['email'];
    $password = $_POST['password'];

    if($email == "admin@gmail.com" && $password == "123456"){
        $_SESSION['admin'] = true;

        header("Location: soal.php");
        exit;
    }else{
        $error = "Email atau Password salah!";
    }
}

if(isset($_GET['hapus'])){

    $id = (int) $_GET['hapus'];

    if(isset($koneksi)){
        mysqli_query($koneksi, "DELETE FROM soal WHERE id=$id");
    }

    header("Location: soal.php");
    exit;
}

if(!isset($_SESSION['admin'])){
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Login Admin</title>

<style>

body{
    font-family:Arial;
    background:linear-gradient(135deg,#4facfe,#00f2fe);
    display:flex;
    justify-content:center;
    align-items:center;
    height:100vh;
}

.card{
    background:white;
    padding:30px;
    width:400px;
    border-radius:15px;
    box-shadow:0 5px 20px rgba(0,0,0,.2);
    box-sizing:border-box;
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
    background:#0d6efd;
    color:white;
    border:none;
    border-radius:8px;
    box-sizing:border-box;
}

.error{
    color:red;
}

</style>
</head>
<body>

<div class="card">

<h2>Login Admin</h2>

<?php
if(isset($error)){
    echo "<p class='error'>$error</p>";
}
?>

<form method="POST">

<input type="email" name="email" placeholder="Email" required>

<input type="password" name="password" placeholder="Password" required>

<button type="submit" name="login">Login</button>

</form>

</div>

</body>
</html>

<?php
exit;
}

if(isset($_POST['simpan'])){

    $p = $_POST['pertanyaan'];
    $a = $_POST['a'];
    $b = $_POST['b'];
    $c = $_POST['c'];
    $d = $_POST['d'];
    $j = strtoupper($_POST['jawaban']);

    if(isset($koneksi)){
        mysqli_query(
            $koneksi,
            "INSERT INTO soal
            (pertanyaan,pilihan_a,pilihan_b,pilihan_c,pilihan_d,jawaban_benar)
            VALUES
            ('$p','$a','$b','$c','$d','$j')"
        );
    }

} // 

if(isset($_POST['save_waktu'])){

    $w = (int) $_POST['waktu'];

    if(isset($koneksi)){
        mysqli_query(
            $koneksi,
            "UPDATE setting SET waktu='$w' WHERE id='1'"
        );
    }
}

if(isset($koneksi)){
    $data = mysqli_query(
        $koneksi,
        "SELECT * FROM soal"
    );
} else {
    $data = false;
}

if(isset($koneksi)){
    $querySetting = mysqli_query(
        $koneksi,
        "SELECT * FROM setting WHERE id='1'"
    );

    $set = mysqli_fetch_assoc($querySetting);
} else {
    $set = null;
}

if(!$set){

    if(isset($koneksi)){
        mysqli_query(
            $koneksi,
            "INSERT INTO setting(id,waktu)
             VALUES('1','300')"
        );
    }

    $set = [
        'waktu' => 300
    ];
}
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Admin Panel</title>

<style>

body{
    font-family:Arial;
    background:#f4f6f9;
    margin:0;
    padding:20px;
}

.container{
    max-width:1100px;
    margin:auto;
}

.card{
    background:white;
    padding:20px;
    margin-bottom:20px;
    border-radius:15px;
    box-shadow:0 5px 15px rgba(0,0,0,.1);
    width:100%;
    box-sizing:border-box;
}

input{
    width:100%;
    padding:12px;
    margin:10px 0;
    border:1px solid #ddd;
    border-radius:8px;
    box-sizing:border-box;
}

button{
    padding:10px 15px;
    background:#198754;
    color:white;
    border:none;
}

table{
    width:100%;
    border-collapse:collapse;
    table-layout:fixed;
}

th{
    background:#0d6efd;
    color:white;
    padding:10px;
}

th:nth-child(1){
    width:8%;
}

th:nth-child(2){
    width:60%;
}

th:nth-child(3){
    width:12%;
}

th:nth-child(4){
    width:20%;
}

td{
    border:1px solid #ddd;
    padding:10px;
    word-wrap:break-word;
    overflow-wrap:break-word;
}

.logout{
    color:black;
    padding:10px;
    text-decoration:none;
    float:right;
}

</style>
</head>
<body>

<div class="container">

<h2>
Admin Panel
<a href="/logout.php" class="logout">Logout</a>
</h2>

<div class="card">

<h3>Tambah Soal</h3>

<form method="POST">

<input type="text" name="pertanyaan" placeholder="Pertanyaan" required>

<input type="text" name="a" placeholder="Pilihan A" required>

<input type="text" name="b" placeholder="Pilihan B" required>

<input type="text" name="c" placeholder="Pilihan C" required>

<input type="text" name="d" placeholder="Pilihan D" required>

<input type="text" name="jawaban" placeholder="Jawaban Benar (A/B/C/D)" required>

<button type="submit" name="simpan">
Simpan Soal
</button>

</form>

</div>

<div class="card">

<h3>Atur Waktu Quiz</h3>

<form method="POST">

<input type="number"
name="waktu"
value="<?php echo $set['waktu']; ?>">

<button type="submit" name="save_waktu">
Simpan Waktu
</button>

</form>

</div>

<div class="card">

<h3>Daftar Soal</h3>

<table>

<tr>
<th>No</th>
<th>Pertanyaan</th>
<th>Jawaban</th>
<th>Aksi</th>
</tr>

<?php
$no = 1;

while($r = mysqli_fetch_assoc($data)){
?>

<tr>

<td><?php echo $no++; ?></td>

<td><?php echo $r['pertanyaan']; ?></td>

<td><?php echo $r['jawaban_benar']; ?></td>

<td>
<a href="?hapus=<?php echo $r['id']; ?>"
onclick="return confirm('Yakin hapus?')">
Hapus
</a>
</td>

</tr>

<?php
}
?>

</table>

</div>

</div>

</body>
</html>

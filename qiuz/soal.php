<?php
include '../koneksi.php';

if (!isset($koneksi)) {
    die("Koneksi database gagal!");
}

$data = mysqli_query($koneksi, "SELECT * FROM soal");

$querySetting = mysqli_query($koneksi, "SELECT * FROM setting WHERE id=1");
$set = mysqli_fetch_assoc($querySetting);

$waktu = 300;

if ($set) {
    $waktu = (int)$set['waktu'];
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Quiz Online</title>

    <style>
        *{
            margin:0;
            padding:0;
            box-sizing:border-box;
            font-family:Arial, sans-serif;
        }

        body{
            background:linear-gradient(135deg,#4facfe,#00f2fe);
            min-height:100vh;
            display:flex;
            justify-content:center;
            align-items:center;
            padding:20px;
        }

        .container{
            width:100%;
            max-width:800px;
            background:white;
            border-radius:20px;
            padding:30px;
            box-shadow:0 10px 25px rgba(0,0,0,0.2);
        }

        h2{
            text-align:center;
            color:#333;
            margin-bottom:10px;
        }

        #timer{
            text-align:center;
            color:#dc3545;
            margin-bottom:25px;
            font-size:20px;
        }

        .slide{
            display:none;
        }

        .active{
            display:block;
        }

        .soal{
            background:#f8f9fa;
            padding:20px;
            border-radius:10px;
            margin-bottom:20px;
        }

        .soal b{
            color:#0d6efd;
        }

        .pilihan{
            padding:15px;
            margin:10px 0;
            border:1px solid #ddd;
            border-radius:10px;
            transition:0.3s;
        }

        .pilihan:hover{
            background:#f1f7ff;
            border-color:#0d6efd;
        }

        input[type=radio]{
            margin-right:10px;
        }

        .button-group{
            margin-top:25px;
            text-align:center;
        }

        .btn{
            border:none;
            padding:12px 25px;
            margin:5px;
            border-radius:8px;
            color:white;
            cursor:pointer;
            font-size:15px;
        }

        .prev{
            background:#6c757d;
        }

        .next{
            background:#0d6efd;
        }

        .submit{
            background:#198754;
        }

        .btn:hover{
            opacity:0.9;
        }
    </style>
</head>
<body>

<div class="container">

    <h2>📝 Quiz Online</h2>

    <h3 id="timer"></h3>

    <form method="POST" action="hasil.php" id="formQuiz">

        <?php
        $no = 0;
        while($row = mysqli_fetch_assoc($data)){
        ?>

        <div class="slide <?php echo $no == 0 ? 'active' : ''; ?>">

            <div class="soal">
                <b>Soal <?php echo $no + 1; ?></b>
                <hr style="margin:10px 0;">
                <?php echo $row['pertanyaan']; ?>
            </div>

            <label class="pilihan">
                <input type="radio" name="jawaban[<?php echo $row['id']; ?>]" value="A">
                <?php echo $row['pilihan_a']; ?>
            </label>

            <label class="pilihan">
                <input type="radio" name="jawaban[<?php echo $row['id']; ?>]" value="B">
                <?php echo $row['pilihan_b']; ?>
            </label>

            <label class="pilihan">
                <input type="radio" name="jawaban[<?php echo $row['id']; ?>]" value="C">
                <?php echo $row['pilihan_c']; ?>
            </label>

            <label class="pilihan">
                <input type="radio" name="jawaban[<?php echo $row['id']; ?>]" value="D">
                <?php echo $row['pilihan_d']; ?>
            </label>

        </div>

        <?php
        $no++;
        }
        ?>

        <div class="button-group">
            <button type="button" class="btn prev" onclick="prev()">⬅ Prev</button>
            <button type="button" class="btn next" onclick="next()">Next ➡</button>
            <button type="submit" class="btn submit">✔ Submit</button>
        </div>

    </form>

</div>

<script>
let current = 0;
let slides = document.querySelectorAll(".slide");

function showSlide(i){
    slides[current].classList.remove("active");
    current = i;
    slides[current].classList.add("active");
}

function next(){
    if(current < slides.length - 1){
        showSlide(current + 1);
    }
}

function prev(){
    if(current > 0){
        showSlide(current - 1);
    }
}

let waktu = <?php echo $waktu; ?>;
let timer = document.getElementById("timer");

let hitung = setInterval(function(){

    let menit = Math.floor(waktu / 60);
    let detik = waktu % 60;

    timer.innerHTML = "⏳ Sisa Waktu: " + menit + " menit " + detik + " detik";

    waktu--;

    if(waktu < 0){
        clearInterval(hitung);
        alert("Waktu habis!");
        document.getElementById("formQuiz").submit();
    }

},1000);
</script>

</body>
</html>
<?php 
session_start();
if( !isset($_SESSION['session_login'])){
    header('Location: login.php');
    exit;
}

require "function.php";

if(isset($_POST['submit'])){
    if (tambah_data($_POST) > 0 ) {
         echo "<script>
            alert('Data berhasil ditambahkan');
            document.location.href= 'index.php';
            </script>";
    } else {
        echo "<script>
            alert('Data gagal ditambahkan');
            </script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">


    <title>Tambah Data Penjualan</title>
    <link rel="stylesheet" href="style.css">
</head>


<body class="page-form">


<div class="container">


    <div class="form-card">


        <h3>Tambah Data Penjualan</h3>


        <form action="" method="post" enctype="multipart/form-data">


            <div class="form-group">
                <label for="code">CODE</label>
                <input type="text" name="code" placeholder="Masukkan code">
            </div>


            <div class="form-group">
                <label for="nama_member">Nama Member</label>
                <input type="text" name="nama_member" placeholder="Masukkan nama member">
            </div>

            
            <div class="form-group">
                <label for="nama_grup">Nama Grup</label>
                <input type="text" name="nama_grup" placeholder="Masukkan nama grup member">
            </div>


            <div class="form-group">
                <label for="album_era">Album Era</label>
                <input type="text" name="album_era" placeholder="Masukkan album era">
            </div>


            <div class="form-group">
                <label for="harga">Harga (Rp)</label>
                <input type="text" name="harga" placeholder="Masukkan harga">
            </div>


            <div class="form-group">
                <label for="gambar">Gambar</label>
                <input type="file" name="gambar">
            </div>


            <div class="button-group">
                <button type="submit" name="submit" class="btn btn-tambah"> Tambah Data </button>
                <a href="index.php" class="btn btn-kembali"> Kembali </a>
            </div>


        </form>


    </div>


</div>


</body>
</html>

<?php
session_start();
if( !isset($_SESSION['session_login'])){
    header('Location: login.php');
    exit;
}

    require 'function.php';

    $id = $_GET['id'];

    $cards = query_db("SELECT * FROM cards WHERE id = $id")[0];

    if(isset($_POST['submit'])) {

         if (edit_data($_POST) > 0 ) {
         echo "<script>
            alert('Data berhasil diubah');
            document.location.href= 'index.php';
            </script>";
    } else {
        echo "<script>
            alert('Data gagal diubahb');
            </script>";
    }

    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">


    <title>Edit Data Photocard</title>
    <link rel="stylesheet" href="style.css">
</head>
<body class="page-form">
<div class="container">
    <div class="form-card">

        <h3>Edit Data Photocard</h3>

        <form action="" method="post" enctype ="multipart/form-data">

            <input type="hidden" name="id" value="<?php echo $cards["id"] ?>">

            <div class="form-group">
                <label for="nim">Code</label>
                <input type="text" name="code" value="<?php echo $cards["code"]  ?>" readonly>
            </div>


            <div class="form-group">
                <label for="nama_member">Nama Member</label>
                <input type="text" name="nama_member" value="<?php echo $cards["nama_member"]  ?>">
            </div>


            <div class="form-group">
                <label for="nama_grup">Nama Grup</label>
                <input type="text" name="nama_grup" value="<?php echo $cards["nama_grup"]  ?>">
            </div>


            <div class="form-group">
                <label for="album_era">Album Era</label>
                <input type="text" name="album_era" value="<?php echo $cards["album_era"]  ?>">
            </div>


            <div class="form-group">
                <label for="harga">Harga</label>
                <input type="text" name="harga" value="<?php echo $cards["harga"]  ?>">
            </div>


            <div class="form-group">
                <label for="gambar">Gambar</label>
                <!-- <input type="text" name="gambar" value="<?php echo $cards["gambar"]  ?>"> -->
                <input type="file" name="gambar">
                <br>
                <img src="img/<?php echo $cards["gambar"]  ?>" alt="" width="150" height="250">
            </div>


            <div class="button-group">
                <button type="submit" name="submit" class="btn btn-edit"> Edit Data </button>
                <a href="index.php" class="btn btn-kembali"> Kembali </a>
            </div>


        </form>


    </div>


</div>


</body>
</html>

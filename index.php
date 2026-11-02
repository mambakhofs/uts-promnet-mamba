<?php 
session_start();
if( !isset($_SESSION['session_login'])){
    header('Location: login.php');
    exit;
}
require 'function.php';

//jumlah data perhalaman 
$jumlahDataPerHalaman = 5;

//hitung keseluruhan data di dalam table
$jumlahData = count(query_db("SELECT * FROM cards"));

//hitung jumlah halaman 
$jumlahHalaman = ceil($jumlahData / $jumlahDataPerHalaman);

//mengecek halaman aktif 
$halamanAktif = isset($_GET["halaman"]) ? (int) $_GET["halaman"] : 1; 

//variable menentukan awal data 
$awalData = ($jumlahDataPerHalaman * $halamanAktif) - $jumlahDataPerHalaman;

//mengambil data cards berdasarkan pagination 
$cards = query_db(
    "SELECT * FROM cards LIMIT $awalData, $jumlahDataPerHalaman"
);

if(isset($_POST["cari"])){
    $keyword = $_POST["keyword"];
    $cards = cari_data($keyword);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List Penjualan Photocard</title>
    <link rel="stylesheet" href="style.css">
</head>
<body class="page-index">

    <div class="container">
     
        <div class="header-top">
       <a href="logout.php" style="float: right; background-color: #dc3545; color: white; padding: 8px 16px; text-decoration: none; border-radius: 5px; font-weight: bold; display: inline-block;">Logout</a>
        </div>

        <h2 style="text-align: center">Halo, Selamat Datang <?php echo $_SESSION['username'] ?></h2>
        <h3 style="text-align : center">Daftar Penjualan Photocard</h3>

        <div class="top-bar">
            <!-- Searching -->
            <form action="" method="post" class="search-box">
                <input type="text" name="keyword" placeholder="Cari photocard...">
                <button type="submit" name="cari" class="btn btn-cari">Cari</button>
            </form>


            <!-- Tambah Data -->
            <a href="tambah_data.php" class="btn btn-tambah">+ Tambah Data</a>
        </div>

        <table>
            <thead>
                <tr>
                    <th>No.</th>
                    <th>ID</th>
                    <th>Code</th>
                    <th>Nama Member</th>
                    <th>Nama Grup</th>
                    <th>Album Era</th>
                    <th>Harga(Rp)</th>
                    <th>Gambar</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php $no=1; ?>
                <?php foreach($cards as $data): ?>
                <tr>
                    <td><?php echo $no; ?></td>
                    <td><?php echo $data["id"]; ?></td>
                    <td><?php echo $data["code"]; ?></td>
                    <td><?php echo $data["nama_member"]; ?></td>
                    <td><?php echo $data["nama_grup"]; ?></td>
                    <td><?php echo $data["album_era"]; ?></td>
                    <td><?php echo $data["harga"]; ?></td>
                    <td>
                       <img src="img/<?php echo $data["gambar"]; ?>" alt="" width=""100 height="100">
                    <td>
                        <a href="edit_data.php?id=<?php echo $data['id']; ?>" class="btn btn-edit">Edit</a>
                        <a href ="hapus_data.php?id=<?php echo $data['id']; ?>" class="btn btn-hapus">Hapus </a>
                    </td>
                </tr>
                <?php $no++; ?>
                <?php endforeach ?>
            </tbody>
        </table>
        
        <br>
        <br>

        <!-- ================ -->
        <!-- Fitur Pagination -->
        <!-- ================ -->

        <div class="pagination-wrapper">
            <div class="pagination">
                <!-- previous -->
                 <?php if($halamanAktif > 1) :?>
                <a href="?halaman=<?php echo $halamanAktif - 1 ;?>" class="prev">
                        &larr; Prev
                </a>
                <?php else: ?>
                    <span class="pagination-disabled"> &larr; Prev</span>
                <?php endif; ?>


                <!-- no halaman -->
                 <?php for($i=1; $i <= $jumlahHalaman; $i++ ):  ?>
                    <?php if($i == $halamanAktif): ?>
                        <a href="?halaman=<?php echo $i; ?>" class="active">
                            <?php echo $i; ?>
                        </a>
                <?php else :?>
                    <a href="?halaman=<?php echo $i; ?>" >
                        <?php echo $i; ?>
                    </a>
                <?php endif; ?>
                <?php endfor; ?>


                <!-- next -->
                 <?php if($halamanAktif < $jumlahHalaman): ?>
                 <a href="?halaman=<?php echo $halamanAktif + 1 ?>" class="next">
                        Next &rarr;
                </a>
                <?php else : ?>
                    <span class ="pagination-disabled">
                        Next &rarr;
                    </span>
                <?php endif; ?>
        </div>
        </div>
        <!-- ================ -->
        <!--   End Pagination -->
        <!-- ================ -->
    </div> 
    
</body>
</html>
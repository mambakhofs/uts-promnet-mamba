<?php 
$conn = mysqli_connect("localhost", "root", "", "photocard");

function query_db($query) {
    global $conn;
    $result = mysqli_query($conn, $query);
    $rows = [];
    while( $row = mysqli_fetch_assoc($result) ) {
        $rows[] = $row;
    }
    return $rows;
}

function tambah_data($data){
    global $conn;

    $code = $data['code'];
    $nama_member = $data['nama_member'];
    $nama_grup = $data['nama_grup'];
    $album_era = $data['album_era'];
    $harga = $data['harga'];

    $gambar = upload_gambar($code, $nama_member);
    if( !$gambar ){
        return false;
    }

    $query = "INSERT INTO cards(code, nama_member, nama_grup, album_era, harga, gambar) 
            VALUES('$code', '$nama_member', '$nama_grup', '$album_era', '$harga', '$gambar')";

    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}

function edit_data($data){
    global $conn;

    $id = $data['id'];
    $code = $data['code'];
    $nama_member = $data['nama_member'];
    $nama_grup = $data['nama_grup'];
    $album_era = $data['album_era'];
    $harga = $data['harga'];
    // $gambar = $data['gambar'];

    $gambar = upload_gambar($code, $nama_member);
    if( !$gambar ){
        return false;
    }

    $query = "UPDATE cards SET
                code = '$code',
                nama_member = '$nama_member',
                nama_grup = '$nama_grup',
                album_era = '$album_era',
                harga = '$harga',
                gambar = '$gambar'
                WHERE id = $id
    ";

    mysqli_query($conn, $query);
    return mysqli_affected_rows($conn);
}

function hapus_data($id){
    global $conn;

    $query = "DELETE FROM cards WHERE id =$id";

    mysqli_query($conn, $query);
    return mysqli_affected_rows($conn);
}

function cari_data($keyword) {
    global $conn;


    $keyword = mysqli_real_escape_string($conn, $keyword);


    $query = "SELECT * FROM cards
              WHERE
              code LIKE '%$keyword%' OR
              nama_member LIKE '%$keyword%' OR
              nama_grup LIKE '%$keyword%' OR
              album_era LIKE '%$keyword%' OR
              harga LIKE '%$keyword%'";


    return query_db($query);
}

function upload_gambar($code, $nama_member) {

    $namaFile = $_FILES['gambar']['name'];
    $ukuranFile = $_FILES['gambar']['size'];
    $error = $_FILES['gambar']['size'];
    //untuk menyimpan nama file sementara
    $tmpName = $_FILES['gambar']['tmp_name'];

    //cek gambar saat user isi form 
    if( $error === 4 ){
        echo "<script>
        alert('Silahkan upload gambar terlebih dahulu');
        </script>";
        return false;
    } 

    //cek yang user upload, harus berupa gambar
    $esktensiGambarValid = ['jpg', 'jpeg', 'png'];
    $ekstensiGambar = explode('.', $namaFile);
    $ekstensiGambar = strtolower(end($ekstensiGambar));
    if( !in_array($ekstensiGambar, $esktensiGambarValid)) {
        echo "<script>
        alert('File yang diupload bukan format gambar');
        </script>";
        return false;
    }

    //buat aturan terkait ukuran file, maks 5mb
    if( $ukuranFile > 5000000 ){
        echo "<script>
        alert('File yang diupload terlalu besar ukurannya');
        </script>";
        return false;
    } 

    //file yang di input akan siap di upload setelah melewati beberapa if 
    $namaFileBaru = $code . "-" . $nama_member;
    $namaFileBaru .= '.';
    $namaFileBaru .= $ekstensiGambar;
    
    move_uploaded_file($tmpName, 'img/' . $namaFileBaru);

    return $namaFileBaru;

}

function registrasi($data){
    global $conn;

    $username = strtolower(stripslashes($data["username"]));
    $password = mysqli_real_escape_string($conn, $data["password"]);
    $konfirmasi_password = mysqli_real_escape_string($conn, $data["konfirmasi_password"]);

    //cek usn udh ada apa blm di database, sehingga tdk menyebabkan redundan 
    $result = mysqli_query($conn, "SELECT username FROM user WHERE username = '$username'");

    if(mysqli_fetch_assoc($result)){
        echo "<script>
            alert('username sudah terdaftar, gunakan usn lain :D');
            </script>";
        return false; 
    }

    //cek konfirmasi password apakah udah sesuai dengan password 
    if($password !== $konfirmasi_password ){
        echo "<script>
            alert('konfrimasi password tidak sesuai!');
            </script>";
        return false; 
    }

    //enkripsi password untuk merahasiakan password
    $password = password_hash($password, PASSWORD_DEFAULT);

    mysqli_query($conn, "INSERT INTO user VALUES('', '$username', '$password')");
    return mysqli_affected_rows($conn);

}
?> 
<?php
$host       = "localhost";
$user       = "root";
$pass       = "";
$db         = "rumahsakit";

$koneksi    = mysqli_connect($host, $user, $pass, $db);

$nomor_registrasi = "";
$nama             = "";
$alamat           = "";
$dokter           = "";
$sukses           = "";
$error            = "";

if (isset($_GET['op'])) {
    $op = $_GET['op'];
} else {
    $op = "";
}
if($op == 'delete'){
    $id         = $_GET['id'];
    $sql1       = "delete from pasien where id = '$id'";
    $q1         = mysqli_query($koneksi,$sql1);
    if($q1){
        $sukses = "Berhasil hapus data";
    }else{
        $error  = "Gagal melakukan delete data";
    }
}
if ($op == 'edit') {
    $id               = $_GET['id'];
    $sql1             = "select * from pasien where id = '$id'";
    $q1               = mysqli_query($koneksi, $sql1);
    $r1               = mysqli_fetch_array($q1);
    $nomor_registrasi = $r1['nomor_registrasi'];
    $nama             = $r1['nama'];
    $alamat           = $r1['alamat'];
    $dokter           = $r1['dokter'];

    if ($nomor_registrasi == '') {
        $error = "Data tidak ditemukan";
    }
}
if (isset($_POST['simpan'])) { 
    $nomor_registrasi = $_POST['nomor_registrasi'];
    $nama             = $_POST['nama'];
    $alamat           = $_POST['alamat'];
    $dokter           = $_POST['dokter'];

    if ($nomor_registrasi && $nama && $alamat && $dokter) {
        if ($op == 'edit') { 
            $sql1       = "update pasien set nomor_registrasi = '$nomor_registrasi',nama='$nama',alamat = '$alamat',dokter='$dokter' where id = '$id'";
            $q1         = mysqli_query($koneksi, $sql1);
            if ($q1) {
                $sukses = "Data berhasil diupdate";
            } else {
                $error  = "Data gagal diupdate";
            }
        } else { //untuk insert
            $sql1           = "insert into pasien(nomor_registrasi,nama,alamat,dokter) values ('$nomor_registrasi','$nama','$alamat','$dokter')";
            $q1             = mysqli_query($koneksi, $sql1);
            if ($q1) {
                $sukses     = "Berhasil memasukkan data baru";
            } else {
                $error      = "Gagal memasukkan data";
            }
        }
    } else {
        $error = "Silakan masukkan semua data";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Pasien</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
    <style>
        .mx-auto {
            width: 800px
        }

        .card {
            margin-top: 10px;
        }
    </style>
</head>

<body>
    <div class="mx-auto">
        <!-- untuk memasukkan data -->
        <div class="card">
            <h5 class="card-header text-black bg-warning" </h5>
                Formulir Pendaftaran
            </div>
            <div class="card-body">
                <?php
                if ($error) {
                ?>
                    <div class="alert alert-danger" role="alert">
                        <?php echo $error ?>
                    </div>
                <?php
                    header("refresh:6;url=index.php");//5 : detik
                }
                ?>
                <?php
                if ($sukses) {
                ?>
                    <div class="alert alert-success" role="alert">
                        <?php echo $sukses ?>
                    </div>
                <?php
                    header("refresh:6;url=index.php");
                }
                ?>
                <form action="" method="POST">
                    <div class="mb-3 ">
                        <label for="nomor_registrasi" class="col-sm-2 col-form-label">Nomor Registrasi</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="nomor_registrasi" name="nomor_registrasi" value="<?php echo $nomor_registrasi ?>">
                        </div>
                    </div>
                    <div class="mb-3 ">
                        <label for="nama" class="col-sm-2 col-form-label">Nama</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="nama" name="nama" value="<?php echo $nama ?>">
                        </div>
                    </div>
                    <div class="mb-3 ">
                        <label for="alamat" class="col-sm-2 col-form-label">Alamat</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="alamat" name="alamat" value="<?php echo $alamat ?>">
                        </div>
                    </div>
                    <div class="mb-3 ">
                        <label for="dokter" class="col-sm-2 col-form-label">Dokter</label>
                        <div class="col-sm-12">
                            <select class="form-control" name="dokter" id="dokter">
                                <option value="">- Pilih Dokter -</option>
                                <option value="Gigi" <?php if ($dokter == "Gigi") echo "selected" ?>>Gigi</option>
                                <option value="Umum" <?php if ($dokter == "Umum") echo "selected" ?>>Umum</option>
                                <option value="Kulit" <?php if ($dokter == "Kulit") echo "selected" ?>>Kulit</option>
                                <option value="Kandungan" <?php if ($dokter == "Kandungan") echo "selected" ?>>Kandungan</option>

                            </select>
                        </div>
                    </div>
                    <div class="col-12">
                        <input type="submit" name="simpan" value="Submit" class="btn btn-outline-primary" />
                    </div>
                </form>
            </div>
        </div>

        <div class="mx-auto">
        <!-- untuk mengeluarkan data -->
        <div class="card">
            <h5 class="card-header text-white bg-success" </h5>
                Data Pasien
            </div>
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">Nomor Registrasi</th>
                            <th scope="col">Nama</th>
                            <th scope="col">Alamat</th>
                            <th scope="col">Dokter</th>
                            <th scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql2   = "select * from pasien order by id desc";
                        $q2     = mysqli_query($koneksi, $sql2);
                        $urut   = 1;
                        while ($r2 = mysqli_fetch_array($q2)) {
                            $id               = $r2['id'];
                            $nomor_registrasi = $r2['nomor_registrasi'];
                            $nama             = $r2['nama'];
                            $alamat           = $r2['alamat'];
                            $dokter           = $r2['dokter'];

                        ?>
                            <tr>
                                <th scope="row"><?php echo $urut++ ?></th>
                                <td scope="row"><?php echo $nomor_registrasi ?></td>
                                <td scope="row"><?php echo $nama ?></td>
                                <td scope="row"><?php echo $alamat ?></td>
                                <td scope="row"><?php echo $dokter ?></td>
                                <td scope="row">
                                    <a href="index.php?op=edit&id=<?php echo $id ?>"><button type="button" class="btn btn-outline-success">Edit</button></a>
                                    <a href="index.php?op=delete&id=<?php echo $id?>" onclick="return confirm('Apakah anda akan delete data?')"><button type="button" class="btn btn-outline-danger">Delete</button></a>            
                                </td>
                            </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                    
                </table>
            </div>
        </div>
    </div>
</body>

</html>
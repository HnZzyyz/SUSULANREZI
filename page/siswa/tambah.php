<?php

include "../../config/database.php";

$date = date('y');
$tahun =  $date - 3;

$sql = "SELECT * FROM jurusan";
$jurusan = $db->query($sql);

$sql = "SELECT * FROM spp WHERE tahun > $tahun";
$hasil = $db->query($sql);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nis = $_POST['nis'];
    $nama_lengkap = $_POST['nama_lengkap'];
    $tanggal_lahir = $_POST['tanggal_lahir'];
    $jenis_kelamin = $_POST['jenis_kelamin'];
    $alamat = $_POST['alamat'];
    $no_hp = $_POST['no_hp'];
    $kelas_id = $_POST['kelas_id'];
    $spp_id = $_POST['spp_id'];

    $check_nis_sql = "SELECT * FROM siswa WHERE nis = ?";
    $check_stmt = $db->prepare($check_nis_sql);
    $check_stmt->bind_param("s", $nis);
    $check_stmt->execute();
    $check_stmt->store_result();

    if ($check_stmt->num_rows > 0) {
        $nis_error = "NIS sudah terdaftar. Silakan gunakan NIS yang berbeda.";
    } else {
        $stmt = $db->prepare("INSERT INTO siswa (nis, nama_lengkap, tanggal_lahir, jenis_kelamin, alamat, no_hp, kelas_id, spp_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssssii", $nis, $nama_lengkap, $tanggal_lahir, $jenis_kelamin, $alamat, $no_hp, $kelas_id, $spp_id);

        if ($stmt->execute()) {
            header("Location: index.php");
            exit();
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    }

    $check_stmt->close();
}

$db->close();
?>

<?php include "../../layout/header.php"; ?>

<?php include "../../layout/sidebar.php"; ?>

<main id="main" class="main">

    <div class="pagetitle">
        <h1>siswa</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                <li class="breadcrumb-item ">siswa</li>
                <li class="breadcrumb-item active">Tambah</li>
            </ol>
        </nav>
    </div>

    <section class="section">

        <div class="container">

            <div class="card p-5">
                <form action="" method="post">
                    <div class="mb-3">
                        <label for="nis" class="form-label">NIS</label>
                        <input type="text" class="form-control" id="nis" name="nis" autocomplete="off" required>
                        <?php if (!empty($nis_error)) echo "<p class='text-danger'>$nis_error</p>"; ?>
                    </div>
                    <div class="mb-3">
                        <label for="nama_lengkap" class="form-label">Nama Lengkap</label>
                        <input type="text" class="form-control" id="nama_lengkap" name="nama_lengkap" autocomplete="off" required>
                    </div>
                    <div class="mb-3">
                        <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
                        <input type="date" class="form-control" id="tanggal_lahir" name="tanggal_lahir" required>
                    </div>
                    <div class="mb-3">
                        <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                        <select class="form-control" id="jenis_kelamin" name="jenis_kelamin" required>
                            <option value="Laki-laki">Laki-laki</option>
                            <option value="Perempuan">Perempuan</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="alamat" class="form-label">Alamat</label>
                        <input type="text" class="form-control" id="alamat" name="alamat" autocomplete="off" required>
                    </div>
                    <div class="mb-3">
                        <label for="no_hp" class="form-label">No HP</label>
                        <input type="text" class="form-control" id="no_hp" name="no_hp" autocomplete="off" required>
                    </div>
                    <div class="mb-3">
                        <label for="kelas_id" class="form-label">Kelas</label>
                        <select name="kelas_id" id="kelas_id" class="form-control">
                            <?php foreach ($jurusan as $j ) { ?>
                                <option value="<?= $j['id']; ?>"><?= $j['kode_jurusan']; ?></option> 
                            <?php } ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="spp_id" class="form-label">SPP</label>
                        <select name="spp_id" id="spp_id" class="form-control" required>
                            <?php foreach ($hasil as $h) { ?>
                                <option value="<?= $h['id']; ?>"><?= $h['tahun'] . ' - ' . $h['nominal']; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>

    </section>


</main>

<?php include "../../layout/footer.php"; ?>
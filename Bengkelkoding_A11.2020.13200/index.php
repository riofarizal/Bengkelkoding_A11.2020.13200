<?php
include 'db.php';

// Tambah Data
if (isset($_POST['add'])) {
    $kegiatan = $_POST['kegiatan'];
    $tanggal_awal = $_POST['tanggal_awal'];
    $tanggal_akhir = $_POST['tanggal_akhir'];
    $status = $_POST['status'];

    $sql = "INSERT INTO tasks (kegiatan, tanggal_awal, tanggal_akhir, status) VALUES ('$kegiatan', '$tanggal_awal', '$tanggal_akhir', '$status')";
    $conn->query($sql);
}

// Hapus Data
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $sql = "DELETE FROM tasks WHERE id=$id";
    $conn->query($sql);
    header("Location: index.php");
}

// Ambil Data untuk Edit
$editData = null;
if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $result = $conn->query("SELECT * FROM tasks WHERE id=$id");
    $editData = $result->fetch_assoc();
}

// Update Data
if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $kegiatan = $_POST['kegiatan'];
    $tanggal_awal = $_POST['tanggal_awal'];
    $tanggal_akhir = $_POST['tanggal_akhir'];
    $status = $_POST['status'];

    $sql = "UPDATE tasks SET kegiatan='$kegiatan', tanggal_awal='$tanggal_awal', tanggal_akhir='$tanggal_akhir', status='$status' WHERE id=$id";
    $conn->query($sql);
    header("Location: index.php");
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD Sederhana</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h3>To Do List CRUD</h3>

    <!-- Formulir Tambah / Edit -->
    <form method="POST" action="index.php">
        <input type="hidden" name="id" value="<?= $editData['id'] ?? '' ?>">
        <div class="row">
            <div class="col-md-3">
                <input type="text" name="kegiatan" class="form-control" placeholder="Kegiatan" value="<?= $editData['kegiatan'] ?? '' ?>" required>
            </div>
            <div class="col-md-3">
                <input type="date" name="tanggal_awal" class="form-control" value="<?= $editData['tanggal_awal'] ?? '' ?>" required>
            </div>
            <div class="col-md-3">
                <input type="date" name="tanggal_akhir" class="form-control" value="<?= $editData['tanggal_akhir'] ?? '' ?>" required>
            </div>
            <div class="col-md-2">
                <select name="status" class="form-select" required>
                    <option value="Belum" <?= (isset($editData['status']) && $editData['status'] == 'Belum') ? 'selected' : '' ?>>Belum</option>
                    <option value="Sudah" <?= (isset($editData['status']) && $editData['status'] == 'Sudah') ? 'selected' : '' ?>>Sudah</option>
                </select>
            </div>
            <div class="col-md-1">
                <?php if (isset($editData)): ?>
                    <button type="submit" name="update" class="btn btn-primary">Update</button>
                <?php else: ?>
                    <button type="submit" name="add" class="btn btn-success">Tambah</button>
                <?php endif; ?>
            </div>
        </div>
    </form>

    <!-- Tabel Data -->
    <table class="table table-bordered mt-4">
        <thead>
            <tr>
                <th>#</th>
                <th>Kegiatan</th>
                <th>Tanggal Awal</th>
                <th>Tanggal Akhir</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $result = $conn->query("SELECT * FROM tasks");
            while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= $row['id'] ?></td>
                    <td><?= $row['kegiatan'] ?></td>
                    <td><?= $row['tanggal_awal'] ?></td>
                    <td><?= $row['tanggal_akhir'] ?></td>
                    <td><span class="badge bg-<?= $row['status'] == 'Sudah' ? 'success' : 'warning' ?>"><?= $row['status'] ?></span></td>
                    <td>
                        <a href="index.php?edit=<?= $row['id'] ?>" class="btn btn-info btn-sm text-white">Ubah</a>
                        <a href="index.php?delete=<?= $row['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus?')">Hapus</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

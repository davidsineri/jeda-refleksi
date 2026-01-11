<?php
require "../config/database.php";

// TAMBAH DATA
if (isset($_POST['tambah'])) {
    $stmt = $db->prepare("INSERT INTO kondisi (nama, bobot) VALUES (?, ?)");
    $stmt->execute([
        $_POST['nama'],
        $_POST['bobot']
    ]);
    header("Location: kondisi.php");
    exit;
}

// HAPUS DATA
if (isset($_GET['hapus'])) {
    $stmt = $db->prepare("DELETE FROM kondisi WHERE id = ?");
    $stmt->execute([$_GET['hapus']]);
    header("Location: kondisi.php");
    exit;
}

// AMBIL DATA UNTUK EDIT
$editData = null;
if (isset($_GET['edit'])) {
    $stmt = $db->prepare("SELECT * FROM kondisi WHERE id = ?");
    $stmt->execute([$_GET['edit']]);
    $editData = $stmt->fetch();
}

// UPDATE DATA
if (isset($_POST['update'])) {
    $stmt = $db->prepare("UPDATE kondisi SET nama=?, bobot=? WHERE id=?");
    $stmt->execute([
        $_POST['nama'],
        $_POST['bobot'],
        $_POST['id']
    ]);
    header("Location: kondisi.php");
    exit;
}

// AMBIL SEMUA DATA
$data = $db->query("SELECT * FROM kondisi")->fetchAll();
?>

<h2>CRUD Kondisi</h2>

<form method="post">
    <input type="hidden" name="id" value="<?= $editData['id'] ?? '' ?>">
    <input type="text" name="nama" placeholder="Nama kondisi"
           value="<?= $editData['nama'] ?? '' ?>" required>
    <input type="number" step="0.1" name="bobot" placeholder="Bobot"
           value="<?= $editData['bobot'] ?? '' ?>" required>

    <?php if ($editData): ?>
        <button name="update">Update</button>
    <?php else: ?>
        <button name="tambah">Tambah</button>
    <?php endif; ?>
</form>

<hr>

<table border="1" cellpadding="5">
<tr>
    <th>No</th>
    <th>Nama</th>
    <th>Bobot</th>
    <th>Aksi</th>
</tr>
<?php foreach ($data as $i => $row): ?>
<tr>
    <td><?= $i + 1 ?></td>
    <td><?= $row['nama'] ?></td>
    <td><?= $row['bobot'] ?></td>
    <td>
        <a href="?edit=<?= $row['id'] ?>">Edit</a> |
        <a href="?hapus=<?= $row['id'] ?>" onclick="return confirm('Hapus?')">Hapus</a>
    </td>
</tr>
<?php endforeach; ?>
</table>


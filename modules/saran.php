<?php
require "../config/database.php";

// TAMBAH DATA
if (isset($_POST['tambah'])) {
    $stmt = $db->prepare("INSERT INTO saran (judul, deskripsi) VALUES (?, ?)");
    $stmt->execute([
        $_POST['judul'],
        $_POST['deskripsi']
    ]);
    header("Location: saran.php");
    exit;
}

// HAPUS DATA
if (isset($_GET['hapus'])) {
    $stmt = $db->prepare("DELETE FROM saran WHERE id = ?");
    $stmt->execute([$_GET['hapus']]);
    header("Location: saran.php");
    exit;
}

// AMBIL DATA UNTUK EDIT
$editData = null;
if (isset($_GET['edit'])) {
    $stmt = $db->prepare("SELECT * FROM saran WHERE id = ?");
    $stmt->execute([$_GET['edit']]);
    $editData = $stmt->fetch();
}

// UPDATE DATA
if (isset($_POST['update'])) {
    $stmt = $db->prepare("UPDATE saran SET judul=?, deskripsi=? WHERE id=?");
    $stmt->execute([
        $_POST['judul'],
        $_POST['deskripsi'],
        $_POST['id']
    ]);
    header("Location: saran.php");
    exit;
}

// AMBIL SEMUA DATA
$data = $db->query("SELECT * FROM saran")->fetchAll();
?>

<h2>CRUD Saran</h2>

<form method="post">
    <input type="hidden" name="id" value="<?= $editData['id'] ?? '' ?>">
    <input type="text" name="judul" placeholder="Judul saran"
           value="<?= $editData['judul'] ?? '' ?>" required><br>
    <textarea name="deskripsi" placeholder="Deskripsi saran" required><?= $editData['deskripsi'] ?? '' ?></textarea><br>

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
    <th>Judul</th>
    <th>Deskripsi</th>
    <th>Aksi</th>
</tr>
<?php foreach ($data as $i => $row): ?>
<tr>
    <td><?= $i + 1 ?></td>
    <td><?= $row['judul'] ?></td>
    <td><?= $row['deskripsi'] ?></td>
    <td>
        <a href="?edit=<?= $row['id'] ?>">Edit</a> |
        <a href="?hapus=<?= $row['id'] ?>" onclick="return confirm('Hapus?')">Hapus</a>
    </td>
</tr>
<?php endforeach; ?>
</table>


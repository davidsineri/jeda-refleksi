<?php
require "../config/database.php";

$kondisi = $db->query("SELECT * FROM kondisi")->fetchAll();
$hasil = [];

if (isset($_POST['proses'])) {
    $dipilih = $_POST['kondisi'] ?? [];

    foreach ($dipilih as $id_kondisi) {
        $stmt = $db->prepare("
            SELECT saran.judul, rule.cf
            FROM rule
            JOIN saran ON rule.saran_id = saran.id
            WHERE rule.kondisi_id = ?
        ");
        $stmt->execute([$id_kondisi]);

        foreach ($stmt->fetchAll() as $row) {
            if (!isset($hasil[$row['judul']])) {
                $hasil[$row['judul']] = $row['cf'];
            } else {
                // CF combine
                $hasil[$row['judul']] =
                    $hasil[$row['judul']] + $row['cf'] * (1 - $hasil[$row['judul']]);
            }
        }
    }
}
?>

<h2>Diagnosa & Rekomendasi</h2>

<form method="post">
<?php foreach ($kondisi as $k): ?>
    <label>
        <input type="checkbox" name="kondisi[]" value="<?= $k['id'] ?>">
        <?= $k['nama'] ?>
    </label><br>
<?php endforeach; ?>

<button name="proses">Proses</button>
</form>

<?php if ($hasil): ?>
<hr>
<h3>Hasil Rekomendasi</h3>
<ul>
<?php foreach ($hasil as $saran => $cf): ?>
    <li><b><?= $saran ?></b> (CF: <?= round($cf,2) ?>)</li>
<?php endforeach; ?>
</ul>
<?php endif; ?>

<?php
require "config/database.php";

$db->exec("
CREATE TABLE IF NOT EXISTS users (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    username TEXT UNIQUE,
    password TEXT
);

CREATE TABLE IF NOT EXISTS kondisi (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    nama TEXT,
    bobot REAL
);

CREATE TABLE IF NOT EXISTS saran (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    judul TEXT,
    deskripsi TEXT
);

CREATE TABLE IF NOT EXISTS rule (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    kondisi_id INTEGER,
    saran_id INTEGER,
    cf REAL
);
");

echo "Database berhasil di-setup";

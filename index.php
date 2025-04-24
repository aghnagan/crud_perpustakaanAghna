<?php  
session_start();
if (!isset($_SESSION["login"])) {
    header("Location: login.php");
    exit;
}
include 'db.php';

// Tambah buku
if (isset($_POST['tambah'])) {
    $judul = $_POST['judul'];
    $pengarang = $_POST['pengarang'];
    $tahun = $_POST['tahun'];
    $conn->query("INSERT INTO buku (judul, pengarang, tahun) VALUES ('$judul', '$pengarang', $tahun)");
}

// Edit buku
$editMode = false;
if (isset($_GET['edit'])) {
    $editMode = true;
    $idEdit = $_GET['edit'];
    $result = $conn->query("SELECT * FROM buku WHERE id = $idEdit");
    $dataEdit = $result->fetch_assoc();
}

// Update buku
if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $judul = $_POST['judul'];
    $pengarang = $_POST['pengarang'];
    $tahun = $_POST['tahun'];
    $conn->query("UPDATE buku SET judul='$judul', pengarang='$pengarang', tahun=$tahun WHERE id=$id");
    header("Location: index.php");
    exit;
}

// Hapus buku
if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    $conn->query("DELETE FROM buku WHERE id=$id");
}

$buku = $conn->query("SELECT * FROM buku");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Perpustakaan Ceria</title>
    <style>
        body {
            font-family: 'Comic Sans MS', cursive, sans-serif;
            background: #fffbf2;
            padding: 20px;
            color: #444;
            position: relative;
        }
        .navbar {
            background: #ffd6e0;
            padding: 15px;
            border-radius: 15px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }
        .navbar a {
            text-decoration: none;
            background: #ff9aa2;
            color: white;
            padding: 10px 15px;
            border-radius: 10px;
            font-weight: bold;
            transition: 0.3s;
        }
        .navbar a:hover {
            background: #ff6f91;
        }
        h2 {
            color: #ff6f61;
            font-size: 28px;
        }
        form {
            background: #fff3f3;
            padding: 20px;
            border-radius: 15px;
            box-shadow: 0 0 10px rgba(0,0,0,0.05);
            max-width: 600px;
            margin-bottom: 30px;
        }
        input, button {
            padding: 10px;
            margin: 10px 0;
            width: 100%;
            border: 2px solid #ffd6d6;
            border-radius: 10px;
        }
        button {
            background: #ffb6b9;
            color: white;
            font-weight: bold;
            cursor: pointer;
            transition: 0.3s;
        }
        button:hover {
            background: #fa709a;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            background: #fff;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 0 10px rgba(0,0,0,0.05);
        }
        th, td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #f0f0f0;
        }
        th {
            background: #ffe0e9;
        }
        .btn-aksi {
            display: inline-block;
            background: #ffb6b9;
            padding: 6px 12px;
            border-radius: 8px;
            text-decoration: none;
            color: white;
            margin-right: 5px;
        }
        .btn-aksi:hover {
            background: #ff6f91;
        }

        /* Hello Kitty GIF */
        .hello-kitty-fixed {
            position: fixed;
            bottom: 20px;
            right: 20px;
            width: 100px;
            z-index: 999;
            animation: bounce 2s infinite;
        }

        .hello-kitty-sidebar {
            width: 120px;
            position: absolute;
            top: 90px;
            right: 20px;
            animation: float 3s ease-in-out infinite;
        }

        @keyframes bounce {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }

        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-15px); }
        }
    </style>
</head>
<body>

<div class="navbar">
    <div><strong>📚 Perpustakaan Ceria</strong></div>
    <div>
        <a href="logout.php">🚪 Logout</a>
    </div>
</div>

<!-- Hello Kitty samping form -->
<img src="https://media3.giphy.com/media/cjK465g6BmFmAYZYsm/200.webp" alt="Hello Kitty lucu" class="hello-kitty-sidebar">

<h2><?= $editMode ? "✏️ Edit Buku" : "✨ Tambah Buku Baru ✨" ?></h2>
<form method="post">
    <input type="hidden" name="id" value="<?= $editMode ? $dataEdit['id'] : '' ?>">
    <input type="text" name="judul" placeholder="Judul Buku" required value="<?= $editMode ? htmlspecialchars($dataEdit['judul']) : '' ?>">
    <input type="text" name="pengarang" placeholder="Nama Pengarang" required value="<?= $editMode ? htmlspecialchars($dataEdit['pengarang']) : '' ?>">
    <input type="number" name="tahun" placeholder="Tahun Terbit" required value="<?= $editMode ? $dataEdit['tahun'] : '' ?>">
    <button type="submit" name="<?= $editMode ? 'update' : 'tambah' ?>">
        <?= $editMode ? '💾 Update Buku' : '+ Tambahkan Buku' ?>
    </button>
</form>

<h2>📖 Daftar Buku</h2>
<table>
    <tr><th>No</th><th>Judul</th><th>Pengarang</th><th>Tahun</th><th>Aksi</th></tr>
    <?php $no=1; while($row = $buku->fetch_assoc()): ?>
    <tr>
        <td><?= $no++ ?></td>
        <td><?= htmlspecialchars($row['judul']) ?></td>
        <td><?= htmlspecialchars($row['pengarang']) ?></td>
        <td><?= $row['tahun'] ?></td>
        <td>
            <a class="btn-aksi" href="?edit=<?= $row['id'] ?>">✏️ Edit</a>
            <a class="btn-aksi" href="?hapus=<?= $row['id'] ?>" onclick="return confirm('Yakin ingin menghapus buku ini?')">🗑️ Hapus</a>
        </td>
    </tr>
    <?php endwhile; ?>
</table>

<!-- Hello Kitty pojok bawah kanan -->
<img src="https://media2.giphy.com/media/JqK1kph1aSkCEuvAeN/200.webp" alt="Hello Kitty" class="hello-kitty-fixed">

</body>
</html>

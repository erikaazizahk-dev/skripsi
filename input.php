<?php
$title = "Input Data Wilayah";
include_once "header.php";
?>

<!-- Google Font -->
<link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">

<!-- CSS Kustom -->
<style>
  body {
    font-family: 'Poppins', sans-serif;
    background-color: #f8f9fc;
  }
  .form-card {
    background: white;
    padding: 30px;
    border-radius: 12px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    margin-top: 30px;
    margin-bottom: 40px;
  }
  .form-card h2, .form-card h3 {
    text-align: center;
    color: #2c3e50;
  }
  label {
    font-weight: 500;
    margin-top: 15px;
    color: #34495e;
  }
  input[type="text"], input[type="number"], input[type="file"] {
    width: 100%;
    padding: 10px;
    margin-top: 5px;
    border: 1px solid #ccc;
    border-radius: 6px;
  }
  button {
    background-color: #3498db;
    color: white;
    padding: 12px 25px;
    margin-top: 20px;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    transition: background 0.3s;
  }
  button:hover {
    background-color: #2980b9;
  }
  .info {
    font-size: 14px;
    color: #555;
    margin-top: 10px;
  }
  hr {
    margin: 40px 0;
  }
</style>

<div class="container">
  <div class="form-card">
    <h2>Input Data Wilayah untuk Weighted Overlay</h2>

    <!-- Form Manual -->
    <h3>📝 Input Manual</h3>
    <form action="proses_skor.php" method="POST">
      <div class="row">
        <div class="col-md-6">
          <label>Nama Wilayah:</label>
          <input type="text" name="wilayah" required>
        </div>
        <div class="col-md-6">
          <label>Luas Wilayah (km²):</label>
          <input type="number" step="0.01" name="luas" required>
        </div>
        <div class="col-md-6">
          <label>Jumlah Industri:</label>
          <input type="number" name="industri" required>
        </div>
        <div class="col-md-6">
          <label>Jumlah Penduduk:</label>
          <input type="number" name="penduduk" required>
        </div>
        <div class="col-md-6">
          <label>Jarak ke Transportasi (km):</label>
          <input type="number" step="0.1" name="jarak_transport" required>
        </div>
        <div class="col-md-6">
          <label>Jarak ke Pusat Kota (km):</label>
          <input type="number" step="0.1" name="jarak_pusat" required>
        </div>
      </div>
      <button type="submit" name="submit_manual">💾 Hitung & Simpan Manual</button>
    </form>

    <hr>

    <!-- Upload CSV -->
    <h3>📁 Upload CSV</h3>
    <form action="proses_skor.php" method="POST" enctype="multipart/form-data">
      <label>Upload File CSV:</label>
      <input type="file" name="csv_file" accept=".csv" required>
      <button type="submit" name="submit_csv">📤 Upload & Proses CSV</button>
    </form>

    <p class="info"><b>Format CSV:</b> wilayah, luas, industri, penduduk, jarak_transport, jarak_pusat</p>
  </div>
</div>

<?php include_once "footerr.php"; ?>

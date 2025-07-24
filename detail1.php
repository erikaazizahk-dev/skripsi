<?php
$id = $_GET['id'];
$data = json_decode(file_get_contents('data/data.geojson'), true);
$feature = null;

foreach ($data['features'] as $f) {
  if ((int)$f['properties']['id_industri'] == (int)$id){
    $feature = $f;
    break;
  }
}

if (!$feature) die("Data tidak ditemukan.");

$p = $feature['properties'];
$lat = $feature['geometry']['coordinates'][1];
$lng = $feature['geometry']['coordinates'][0];
$title = "Detail dan Lokasi : " . $p['nama_industri'];

include_once "header.php";
?>

<!-- Leaflet -->
<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

<style>
  /* ✅ Tambahan CSS biar rapi tapi bentuk tetap */
  .panel-dashboard h4 {
    font-size: 16px;
    font-family: 'Segoe UI', sans-serif;
    margin: 0;
    font-weight: 500;
    color: #333;
  }

  .table td, .table th {
    vertical-align: top;
    word-break: break-word;
    overflow-wrap: break-word;
    font-size: 15px;
    font-family: 'Segoe UI', sans-serif;
  }

  .table th {
    width: 30%;
    background-color: #f2f2f2;
  }

  #map-canvas {
    border: 1px solid #ccc;
    border-radius: 8px;
    margin-bottom: 10px;
  }

  .table a {
    color: #007BFF;
    text-decoration: none;
    font-size: 14px;
  }

  .table a:hover {
    text-decoration: underline;
  }

  .panel-heading h2, .panel-heading h3 {
    font-size: 18px;
    margin: 5px 0;
  }
</style>

<div class="row">
  <div class="col-md-5">
    <div class="panel panel-info panel-dashboard">
      <div class="panel-heading centered">
        <h2 class="panel-title"><strong> - Lokasi - </strong></h2>
      </div>
      <div class="panel-body">
        <div id="map-canvas" style="width:100%;height:380px;"></div>
      </div>
    </div>
  </div>

  <div class="col-md-7">
    <div class="panel panel-info panel-dashboard">
      <div class="panel-heading centered">
        <h2 class="panel-title"><strong> - Detail - </strong></h2>
      </div>
      <div class="panel-body">
        <table class="table">
          <tr><th>Item</th><th>Detail</th></tr>
          <tr><td>Nama Industri</td><td><h4><?= $p['nama_industri'] ?></h4></td></tr>
          <tr><td>Kabupaten</td><td><h4><?= $p['kabupaten'] ?></h4></td></tr>
          <tr><td>Subsektor</td><td><h4><?= $p['subsektor'] ?></h4></td></tr>
          <tr><td>Alamat</td><td><h4><?= $p['alamat_industri'] ?></h4></td></tr>
          <tr><td>Link</td><td><a href="<?= $p['link'] ?>" target="_blank"><?= $p['link'] ?></a></td></tr>
        </table>
      </div>
    </div>
  </div>
</div>

<script>
  const map = L.map('map-canvas').setView([<?= $lat ?>, <?= $lng ?>], 15);
  L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '&copy; OpenStreetMap contributors'
  }).addTo(map);

  const marker = L.marker([<?= $lat ?>, <?= $lng ?>]).addTo(map)
    .bindPopup("<b><?= $p['nama_industri'] ?></b><br><?= $p['alamat_industri'] ?>")
    .openPopup();
</script>

<?php include_once "footerr.php"; ?>

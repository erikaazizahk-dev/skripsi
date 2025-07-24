<?php 
$title = "Upload CSV & Lihat Titik di Peta";
include_once "header.php"; 
?>

<!-- Leaflet & PapaParse CDN -->
<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/PapaParse/5.4.1/papaparse.min.js"></script>

<!-- Custom Style -->
<style>
  .upload-container {
    display: flex;
    justify-content: space-between;
    align-items: center;
    background: #fff3e0;
    border: 2px dashed #ffa726;
    padding: 20px 30px;
    border-radius: 15px;
    margin-bottom: 20px;
    box-shadow: 0 4px 8px rgba(255, 152, 0, 0.1);
  }

  .upload-label {
    background: #ff9800;
    color: white;
    padding: 12px 20px;
    border-radius: 30px;
    cursor: pointer;
    font-weight: 600;
    transition: 0.3s;
    display: inline-flex;
    align-items: center;
    gap: 10px;
  }

  .upload-label:hover {
    background: #fb8c00;
  }

  .upload-label i {
    font-size: 16px;
  }

  #csvFile {
    display: none;
  }

  #map {
    height: 550px;
    border-radius: 10px;
    border: 1px solid #ddd;
    animation: fadeIn 1s ease;
  }

  @keyframes fadeIn {
    from {opacity: 0;}
    to {opacity: 1;}
  }

  .info-message {
    margin: 15px 0;
    padding: 10px 15px;
    border-left: 5px solid #ffa726;
    background: #fff8e1;
    color: #555;
    font-size: 14px;
  }
</style>

<div class="row">
  <div class="col-md-12">
    <div class="panel panel-default panel-dashboard">
      <div class="panel-heading d-flex justify-content-between align-items-center">
        <h3 class="panel-title"><strong>Upload CSV untuk Lihat Persebaran Industri Kreatif</strong></h3>
      </div>

      <div class="panel-body">

        <!-- Upload UI -->
        <div class="upload-container">
          <label class="upload-label">
            <i class="fa fa-upload"></i> Pilih File CSV
            <input type="file" id="csvFile" accept=".csv">
          </label>
          <div style="font-size: 13px; color: #555">
            Format CSV: <br><code>nama_industri, alamat_industri, subsektor, latitude, longitude</code>
          </div>
        </div>

        <!-- Info Box -->
        <div id="info" class="info-message" style="display:none"></div>

        <!-- Peta -->
        <div id="map"></div>

        <!-- Script: Leaflet + PapaParse -->
        <script>
          const map = L.map('map').setView([-7.8, 110.36], 10);
          L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap contributors'
          }).addTo(map);
          const markerGroup = L.layerGroup().addTo(map);
          const info = document.getElementById('info');

          document.getElementById('csvFile').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (!file) return;

            Papa.parse(file, {
              header: true,
              skipEmptyLines: true,
              complete: function(results) {
                const data = results.data;
                markerGroup.clearLayers();

                let count = 0;
                data.forEach(row => {
                  const lat = parseFloat(row.latitude);
                  const lng = parseFloat(row.longitude);
                  if (!lat || !lng) return;

                  count++;
                  const popupHTML = `
                    <b>${row.nama_industri || 'Tanpa Nama'}</b><br>
                    ${row.alamat_industri || 'Tanpa Alamat'}<br>
                    <small><i>${row.subsektor || 'Subsektor Tidak Diketahui'}</i></small>
                  `;

                  L.circleMarker([lat, lng], {
                    radius: 6,
                    color: "#ff9800",
                    fillColor: "#ffb74d",
                    fillOpacity: 0.9
                  }).bindPopup(popupHTML).addTo(markerGroup);
                });

                info.style.display = 'block';
                info.innerHTML = `✅ ${count} titik berhasil dimuat dari file CSV.`;
              },
              error: err => alert("❌ Gagal membaca file: " + err.message)
            });
          });
        </script>

      </div>
    </div>
  </div>
</div>

<?php include_once "footerr.php"; ?>

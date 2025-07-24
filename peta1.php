<?php
$title = "Peta Pelaku Industri Kreatif";
include_once "header.php";
?>

<!-- Leaflet CSS & JS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

<div class="row">
  <div class="col-md-12">
    <div class="panel panel-info panel-dashboard centered">
      <div class="panel-heading">
        <h2 class="panel-title"><strong> - Peta Persebaran Pelaku Industri - </strong></h2>
      </div>
      <div class="panel-body">
        
        <!-- Filter dan Upload (sejajar) -->
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
          <div style="max-width: 300px;">
            <label for="filter-subsektor" style="font-weight: bold;">Filter berdasarkan Subsektor:</label>
            <select id="filter-subsektor" class="form-control">
              <option value="all">-- Tampilkan Semua --</option>
            </select>
          </div>
          <div>
            <a href="upload.php" class="btn btn-warning" style="margin-top: 23px;">
              <i class="fa fa-upload"></i> Upload CSV
            </a>
          </div>
        </div>

        <!-- Peta -->
        <div id="map" style="width:100%; height:500px;"></div>

        <script>
          var map = L.map('map').setView([-7.8, 110.3], 10);

          L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap contributors'
          }).addTo(map);

          let allFeatures = [];
          let currentLayer = L.layerGroup().addTo(map);

          function tampilkanMarker(subsektor) {
            currentLayer.clearLayers();

            L.geoJSON(allFeatures, {
              filter: function (feature) {
                return subsektor === "all" || feature.properties.subsektor === subsektor;
              },
              pointToLayer: function (feature, latlng) {
                return L.marker(latlng, {
                  icon: L.icon({
                    iconUrl: 'https://unpkg.com/leaflet@1.7.1/dist/images/marker-icon.png',
                    iconSize: [14, 24],
                    iconAnchor: [7, 24],
                    popupAnchor: [0, -24]
                  })
                });
              },
              onEachFeature: function (feature, layer) {
                const p = feature.properties;
                layer.bindPopup(
                  `<b>${p.nama_industri}</b><br>${p.alamat_industri}<br>
                   <i>${p.subsektor}</i><br>
                   <a href='detail1.php?id=${p.id_industri}'>Info Detail</a>`
                );
              }
            }).addTo(currentLayer);
          }

          // Ambil data GeoJSON
          fetch("data/data.geojson")
            .then(res => res.json())
            .then(data => {
              allFeatures = data.features;

              // Isi dropdown subsektor
              const setSub = new Set();
              data.features.forEach(f => {
                if (f.properties.subsektor) {
                  setSub.add(f.properties.subsektor);
                }
              });

              const select = document.getElementById('filter-subsektor');
              Array.from(setSub).sort().forEach(sub => {
                const opt = document.createElement('option');
                opt.value = sub;
                opt.textContent = sub;
                select.appendChild(opt);
              });

              tampilkanMarker("all");
            })
            .catch(err => console.error("Gagal load GeoJSON:", err));

          // Event ketika dropdown berubah
          document.getElementById("filter-subsektor").addEventListener("change", function () {
            tampilkanMarker(this.value);
          });
        </script>

      </div>
    </div>
  </div>
</div>

<?php include_once "footerr.php"; ?>

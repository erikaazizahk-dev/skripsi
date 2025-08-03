<?php
$title = "Peta Sentra Industri Kreatif";
include_once "header.php";
?>

<!-- Leaflet CSS & JS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<!-- DataTables Export CSS & JS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css"/>
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css"/>
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


<style>
  .stat-wrapper {
    display: flex;
    justify-content: center;
    flex-wrap: wrap;
    gap: 14px;
    margin-bottom: 20px;
  }

  .stat-box {
    background: rgba(103, 150, 177, 0.85);
    padding: 10px 14px;
    border-radius: 10px;
    color: #fff;
    display: flex;
    align-items: center;
    gap: 10px;
    font-weight: 600;
    box-shadow: 0 3px 6px rgba(0, 0, 0, 0.1);
    cursor: pointer;
  }

  .stat-icon {
    font-size: 22px;
    background: rgba(255, 255, 255, 0.2);
    padding: 6px;
    border-radius: 50%;
    width: 36px;
    height: 36px;
    display: flex;
    align-items: center;
    justify-content: center;
  }

  .stat-content {
    display: flex;
    flex-direction: column;
    font-size: 13px;
  }

  .stat-count {
    font-size: 16px;
    font-weight: bold;
  }

  #data-table {
    margin-top: 30px;
    width: 100%;
    border-collapse: collapse;
    display: none;
  }

  #data-table th, #data-table td {
    border: 1px solid #ccc;
    padding: 8px;
    text-align: left;
  }

  #data-table th {
    background-color: rgba(103, 150, 177, 0.85);
    color: white;
  }

  .filter-export-container {
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    margin: 20px 0;
    gap: 10px;
  }

  .buttons-container {
    display: flex;
    gap: 8px;
    flex-wrap: wrap;
  }

  .dt-button.btn-copy {
  background-color: #f8f9fa !important;
  color: #343a40 !important;
  border: 1px solid #ced4da !important;
}

.dt-button.btn-excel {
  background-color: #28a745 !important;
  color: white !important;
}

.dt-button.btn-csv {
  background-color: #17a2b8 !important;
  color: white !important;
}

.dt-button.btn-pdf {
  background-color: #dc3545 !important;
  color: white !important;
}

.dt-button {
  font-weight: bold !important;
  padding: 6px 14px !important;
  border-radius: 5px !important;
  margin-right: 6px !important;
  box-shadow: 0 2px 4px rgba(0,0,0,0.1);
  display: inline-flex !important;
  align-items: center;
  gap: 6px;
  border: none;
}

.dt-button i {
  font-size: 14px;
}
.custom-filter-box {
  background: #f0f9ff;
  padding: 12px 16px;
  border-radius: 12px;
  box-shadow: 0 2px 8px rgba(0,0,0,0.06);
  display: inline-block;
  margin-bottom: 20px;
}

.filter-label {
  font-weight: 600;
  color: #0077b6;
  margin-right: 10px;
  font-size: 16px;
}

.custom-select {
  padding: 8px 12px;
  border-radius: 8px;
  border: 1px solid #b0c4de;
  background-color: #ffffff;
  font-size: 14px;
  outline: none;
}

.custom-select:focus {
  border-color: #0077b6;
  box-shadow: 0 0 4px rgba(0,119,182,0.3);
}

</style>

<div class="row">
  <div class="col-md-12">
        <!-- Peta -->
        <div class="panel panel-info panel-dashboard">
  <div class="panel-heading">
    <h3 class="panel-title text-center"><strong> -Peta Persebaran Sentra -</strong></h3>
  </div>
  <div class="panel-body">
    <!-- Stat Boxes -->
    <div class="stat-wrapper" style="display: flex; flex-wrap: wrap; justify-content: center; gap: 15px; margin-bottom: 20px;">
      <div class="stat-box" onclick="applyFilter('tunggal')" style="cursor: pointer;">
        <div class="stat-icon">📍</div>
        <div class="stat-content">
          <div class="stat-count" id="count-tunggal">0</div>
          <div>Sentra Tunggal</div>
        </div>
      </div>

      <div class="stat-box" onclick="applyFilter('campuran')" style="cursor: pointer;">
        <div class="stat-icon">🎨</div>
        <div class="stat-content">
          <div class="stat-count" id="count-campuran">0</div>
          <div>Sentra Campuran</div>
        </div>
      </div>

      <div class="stat-box" onclick="applyFilter('all')" style="cursor: pointer;">
        <div class="stat-icon">📊</div>
        <div class="stat-content">
          <div class="stat-count" id="count-total">0</div>
          <div>Total Sentra</div>
        </div>
      </div>

      <div class="stat-box">
        <div class="stat-icon">🧭</div>
        <div class="stat-content">
          <div class="stat-count">438</div>
          <div>Total Desa di DIY</div>
        </div>
      </div>
    </div>

    <div id="map" style="width:100%; height:500px;"></div>
  </div>
</div>

        <!-- Filter Kabupaten + Tombol Export -->
       <div class="panel panel-info panel-dashboard">
  <div class="panel-heading">
    <h3 class="panel-title text-center"><strong> - Tabel Data Sentra Industri Kreatif -</strong></h3>
  </div>
  <div class="panel-body">
    <div class="filter-export-container">
      <div>
        <label for="filter-kabupaten"><strong>Filter Kabupaten:</strong></label>
        <select id="filter-kabupaten" class="form-control" style="width:auto; display:inline-block; margin-left:10px;" onchange="filterTableByKabupaten()">
          <option value="all">Semua Kabupaten</option>
        </select>
      </div>
      <div class="buttons-container" id="export-buttons"></div>
    </div>

    <table id="data-table">
      <thead>
        <tr>
          <th>Desa</th>
          <th>Kabupaten</th>
          <th>Klasifikasi</th>
          <th>Subsektor</th>
        </tr>
      </thead>
      <tbody id="table-body"></tbody>
    </table>
  </div>
</div>

        <script>
          const map = L.map('map').setView([-7.8, 110.4], 10);

          L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap contributors'
          }).addTo(map);

          const warnaCampuran = {
            "Aplikasi, Desain, Fotografi, Media, Musik, Periklanan": "#800000",
            "Aplikasi, Desain, Kuliner, Musik, Seni Rupa": "#c0392b",
            "Aplikasi, Fashion, Fotografi, Kriya, Kuliner, Seni Rupa": "#2980b9",
            "Fashion, Fotografi, Kriya, Kuliner, Musik": "#1f618d",
            "Fashion, Fotografi, Kriya, Media, Musik, Penerbitan": "#e67e22",
            "Fashion, Fotografi, Media, Musik, Periklanan, Seni Rupa": "#f1c40f",
            "Fashion, Kriya, Kuliner, Media, Penerbitan": "#27ae60",
            "Fashion, Kuliner": "#2ecc71",
            "Fashion, Kuliner, Media, Penerbitan": "#8e6e53",
            "Fashion, Kuliner, Penerbitan": "#e74c3c",
            "Fashion, Kuliner, Seni Rupa": "#d35400",
            "Fashion, Media, Musik, Penerbitan, Seni Rupa": "#21618c",
            "Fotografi, Periklanan": "#2c3e50",
            "Kriya, Kuliner": "#117a65",
            "Kriya, Musik, Penerbitan, Seni Rupa": "#3498db",
            "Kuliner, Periklanan": "#a93226",
            "Penerbitan, Periklanan": "#2f3640"
          };

          const warnaTunggal = {
            "Aplikasi": "#1abc9c",
            "Arsitektur": "#2ecc71",
            "Kuliner": "#e67e22",
            "Desain": "#f1c40f",
            "Kriya": "#e74c3c",
            "Media": "#9b59b6",
            "Musik": "#2980b9",
            "Penerbitan": "#34495e",
            "Periklanan": "#7f8c8d",
            "Seni Pertunjukan": "#c0392b",
            "Seni Rupa": "#d35400"
          };

          let geojsonLayer;
          let rawData;

         function applyFilter(selected) {
  if (geojsonLayer) map.removeLayer(geojsonLayer);

  if ($.fn.DataTable.isDataTable('#data-table')) {
    $('#data-table').DataTable().clear().destroy();
  }

  const tbody = document.getElementById("table-body");
  tbody.innerHTML = '';
  document.getElementById("data-table").style.display = "table";

  geojsonLayer = L.geoJSON(rawData, {
    style: function (feature) {
      const p = feature.properties;
      const klas = (p.klasifikasi || '').toLowerCase();
      const tunggal = (p.tunggal || '').trim();
      const campuran = (p.campuran || '').trim();
      let color = "#fff5f0";

      if (selected === "tunggal" && klas.includes("tunggal") && tunggal !== '') {
        color = warnaTunggal[tunggal] || "#fff5f0";
      } else if (selected === "campuran" && klas.includes("campuran") && campuran !== '') {
        color = warnaCampuran[campuran] || "#fff5f0";
      } else if (selected === "all") {
        if (klas.includes("campuran") && campuran !== '') {
          color = warnaCampuran[campuran] || "#fff5f0";
        } else if (klas.includes("tunggal") && tunggal !== '') {
          color = warnaTunggal[tunggal] || "#fff5f0";
        }
      }

      return {
        color: "#000",
        weight: 1,
        fillColor: color,
        fillOpacity: 0.7
      };
    },
    onEachFeature: function (feature, layer) {
      const p = feature.properties;
      const desa = p.desa || "-";
      const kabupaten = p.kabupaten || "-";
      const klasifikasi = (p.klasifikasi || "").trim();
      const isTunggal = klasifikasi.toLowerCase().includes("tunggal");
      const isCampuran = klasifikasi.toLowerCase().includes("campuran");
      const subsektor = isTunggal ? (p.tunggal || '').trim() : (p.campuran || '').trim();

      const validTunggal = selected === "tunggal" && isTunggal && subsektor !== "";
      const validCampuran = selected === "campuran" && isCampuran && subsektor !== "";
      const validAll = selected === "all" && subsektor !== "" && (isTunggal || isCampuran);

      if (validTunggal || validCampuran || validAll) {
        const row = `<tr><td>${desa}</td><td>${kabupaten}</td><td>${klasifikasi}</td><td>${subsektor}</td></tr>`;
        tbody.innerHTML += row;

        layer.bindPopup(`
          <strong>Desa:</strong> ${desa}<br/>
          <strong>Kabupaten:</strong> ${kabupaten}<br/>
          <strong>Klasifikasi:</strong> ${klasifikasi}<br/>
          <strong>Subsektor:</strong> ${subsektor}
        `);
      }
    }
  }).addTo(map);

  document.getElementById("filter-kabupaten").value = "all";

  // Update bar chart sesuai filter yang diklik
  updateBarChart(rawData, selected);

  setTimeout(() => {
    const dt = $('#data-table').DataTable({
      dom: 'Bfrtip',
      buttons: [
        {
          extend: 'copy',
          text: '📋 Copy',
          className: 'dt-button btn-copy'
        },
        {
          extend: 'excel',
          text: '📥 Excel',
          className: 'dt-button btn-excel'
        },
        {
          extend: 'csv',
          text: '📄 CSV',
          className: 'dt-button btn-csv'
        },
        {
          extend: 'pdf',
          text: '🧾 PDF',
          className: 'dt-button btn-pdf'
        }
      ],
      paging: false,
      searching: false,
      ordering: true,
      info: false
    });

    const exportDiv = document.getElementById("export-buttons");
    exportDiv.innerHTML = '';
    exportDiv.appendChild(document.querySelector('.dt-buttons'));
  }, 200);
}


          function filterTableByKabupaten() {
            const selectedKab = document.getElementById("filter-kabupaten").value;
            const rows = document.querySelectorAll("#table-body tr");
            rows.forEach(row => {
              const kab = row.children[1].textContent || "";
              row.style.display = (selectedKab === "all" || kab === selectedKab) ? "" : "none";
            });
          }

          fetch("data/sentra_kreatiff.geojson")
            .then(res => res.json())
            .then(data => {
              rawData = data;
              updateBarChart(data);
              let totalTunggal = 0;
              let totalCampuran = 0;
              const kabList = new Set();

              data.features.forEach(f => {
                const p = f.properties;
                const klas = (p.klasifikasi || "").toLowerCase();
                const tunggal = (p.tunggal || '').trim();
                const campuran = (p.campuran || '').trim();
                if (klas.includes("tunggal") && tunggal !== '') totalTunggal++;
                if (klas.includes("campuran") && campuran !== '') totalCampuran++;
                if (p.kabupaten) kabList.add(p.kabupaten);
              });

              document.getElementById("count-tunggal").textContent = totalTunggal;
              document.getElementById("count-campuran").textContent = totalCampuran;
              document.getElementById("count-total").textContent = totalTunggal + totalCampuran;

              const filterSelect = document.getElementById("filter-kabupaten");
              [...kabList].sort().forEach(kab => {
                const option = document.createElement("option");
                option.value = kab;
                option.textContent = kab;
                filterSelect.appendChild(option);
              });

              applyFilter('all');
            });
 let barChartInstance;
function updateBarChart(data, filter = "all") {
  const sortOrder = document.getElementById("sort-order").value;
  const counts = {};

  data.features.forEach(f => {
    const p = f.properties;
    const kab = p.kabupaten || "Lainnya";
    const klas = (p.klasifikasi || "").toLowerCase();
    const isTunggal = klas.includes("tunggal") && (p.tunggal || "").trim() !== "";
    const isCampuran = klas.includes("campuran") && (p.campuran || "").trim() !== "";

    if (
      (filter === "all" && (isTunggal || isCampuran)) ||
      (filter === "tunggal" && isTunggal) ||
      (filter === "campuran" && isCampuran)
    ) {
      counts[kab] = (counts[kab] || 0) + 1;
    }
  });

  const sorted = Object.entries(counts).sort((a, b) =>
    sortOrder === "asc" ? a[1] - b[1] : b[1] - a[1]
  );

  const labels = sorted.map(e => e[0]);
  const values = sorted.map(e => e[1]);

  if (barChartInstance) barChartInstance.destroy();
  const ctx = document.getElementById("bar-chart").getContext("2d");
  barChartInstance = new Chart(ctx, {
    type: 'bar',
    data: {
      labels: labels,
      datasets: [{
        label: 'Jumlah Sentra',
        data: values,
        backgroundColor: 'rgba(52, 152, 219, 0.7)',
        borderColor: 'rgba(41, 128, 185, 1)',
        borderWidth: 1
      }]
    },
    options: {
      indexAxis: 'y',
      plugins: {
        legend: { display: false },
        tooltip: { callbacks: { label: ctx => `${ctx.raw} sentra` } }
      },
      responsive: true,
      scales: { x: { beginAtZero: true } }
    }
  });
}

document.getElementById("sort-order").addEventListener("change", () => {
  const active = document.querySelector(".stat-box.active")?.getAttribute("data-filter") || "all";
  updateBarChart(rawData, active);
});

        </script>

    </div>
</div>

      <!-- Bar Chart & Stat Panel -->
<div class="panel panel-info panel-dashboard">
  <div class="panel-heading">
    <h3 class="panel-title text-center"><strong>- Distribusi Sentra per Kabupaten -</strong></h3>
  </div>
  <div class="panel-body">
    <!-- Filter Dropdown -->
    <div class="custom-filter-box" style="margin-bottom: 20px; text-align: center;">
      <label for="sort-order" class="filter-label" style="margin-right: 10px; font-weight: bold;">🎯 Urutkan:</label>
      <select id="sort-order" class="custom-select" style="padding: 6px 12px; border-radius: 5px; border: 1px solid #ccc;">
        <option value="desc">⬇️ Terbesar</option>
        <option value="asc">⬆️ Terkecil</option>
      </select>
    </div>

    <!-- Bar Chart -->
    <div style="overflow-x: auto;">
      <canvas id="bar-chart" height="70"></canvas>
    </div>

</div> <!-- penutup col-md-9 -->
</div> <!-- penutup container-fluid -->


<?php include_once "footerr.php"; ?>
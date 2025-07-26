<?php
$title = "Peta Hasil Weighted Overlay";
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

<style>
  .stat-wrapper { display: flex; justify-content: center; flex-wrap: wrap; gap: 14px; margin-bottom: 20px; }
  .stat-box { background: rgba(103, 150, 177, 0.85); padding: 10px 14px; border-radius: 10px; color: #fff; display: flex; align-items: center; gap: 10px; font-weight: 600; box-shadow: 0 3px 6px rgba(0, 0, 0, 0.1); cursor: pointer; }
  .stat-icon { font-size: 22px; background: rgba(255, 255, 255, 0.2); padding: 6px; border-radius: 50%; width: 36px; height: 36px; display: flex; align-items: center; justify-content: center; }
  .stat-content { display: flex; flex-direction: column; font-size: 13px; }
  .stat-count { font-size: 16px; font-weight: bold; }
  #data-table { margin-top: 30px; width: 100%; border-collapse: collapse; display: none; }
  #data-table th, #data-table td { border: 1px solid #ccc; padding: 8px; text-align: left; }
  #data-table th { background-color: rgba(103, 150, 177, 0.85); color: white; }
  .filter-export-container { display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; margin: 20px 0; gap: 10px; }
  .buttons-container { display: flex; gap: 8px; flex-wrap: wrap; }
  .dt-button.btn-copy { background-color: #f8f9fa !important; color: #343a40 !important; border: 1px solid #ced4da !important; }
  .dt-button.btn-excel { background-color: #28a745 !important; color: white !important; }
  .dt-button.btn-csv { background-color: #17a2b8 !important; color: white !important; }
  .dt-button.btn-pdf { background-color: #dc3545 !important; color: white !important; }
  .dt-button { font-weight: bold !important; padding: 6px 14px !important; border-radius: 5px !important; margin-right: 6px !important; box-shadow: 0 2px 4px rgba(0,0,0,0.1); display: inline-flex !important; align-items: center; gap: 6px; border: none; }
  .legend { line-height: 18px; color: #555; background: white; padding: 8px 10px; border-radius: 5px; box-shadow: 0 0 10px rgba(0,0,0,0.2); font-size: 13px; max-width: 200px; cursor: pointer; }
  .legend i { width: 18px; height: 18px; float: left; margin-right: 8px; opacity: 0.8; border: 1px solid #999; }
  .legend-items { display: none; margin-top: 6px; }
  .legend-items.open { display: block; }
</style>

<div class="row">
  <div class="col-md-12">
    <div class="panel panel-info panel-dashboard centered">
      <div class="panel-heading">
        <h2 class="panel-title text-center">
          <strong>– Peta Hasil Weighted Overlay –</strong>
        </h2>
      </div>
      <div class="panel-body">

        <div class="stat-wrapper">
          <div class="stat-box"><div class="stat-icon">🏭</div><div class="stat-content"><div class="stat-count">Industri</div><div>Kepadatan Industri</div></div></div>
          <div class="stat-box"><div class="stat-icon">👥</div><div class="stat-content"><div class="stat-count">Penduduk</div><div>Kepadatan Penduduk</div></div></div>
          <div class="stat-box"><div class="stat-icon">🚗</div><div class="stat-content"><div class="stat-count">Transportasi</div><div>Jarak Transportasi</div></div></div>
          <div class="stat-box"><div class="stat-icon">🏙️</div><div class="stat-content"><div class="stat-count">Pusat Kota</div><div>Jarak ke Pusat Kota</div></div></div>
        </div>

        <div id="map" style="width:100%; height:500px;"></div>

        <div class="filter-export-container">
          <div></div>
          <div class="buttons-container" id="export-buttons"></div>
        </div>

        <table id="data-table">
          <thead><tr></tr></thead>
          <tbody id="table-body"></tbody>
        </table>

<script>
const map = L.map('map').setView([-7.8, 110.4], 10);
L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', { attribution: '&copy; OpenStreetMap contributors' }).addTo(map);

const warnaKlas = ["#fff5f0", "#fcbea5", "#fb7050", "#d32020", "#67000d"];
let geojsonLayer;
let varData, weightedData;

const labelKlasifikasi = {
  industri: ["Sangat Rendah", "Rendah", "Sedang", "Tinggi", "Sangat Tinggi"],
  penduduk: ["Sangat Jarang", "Jarang", "Sedang", "Padat", "Sangat Padat"],
  transportasi: ["Sangat Jauh", "Jauh", "Sedang", "Dekat", "Sangat Dekat"],
  pusat: ["Sangat Jauh", "Jauh", "Sedang", "Dekat", "Sangat Dekat"],
  weighted: ["Sangat Rendah", "Rendah", "Sedang", "Tinggi", "Sangat Tinggi"]
};

function getColorByClass(label) {
  const index = labelKlasifikasi.industri.indexOf(label) !== -1 ? labelKlasifikasi.industri.indexOf(label)
              : labelKlasifikasi.penduduk.indexOf(label) !== -1 ? labelKlasifikasi.penduduk.indexOf(label)
              : labelKlasifikasi.transportasi.indexOf(label) !== -1 ? labelKlasifikasi.transportasi.indexOf(label)
              : labelKlasifikasi.pusat.indexOf(label) !== -1 ? labelKlasifikasi.pusat.indexOf(label)
              : labelKlasifikasi.weighted.indexOf(label);
  return warnaKlas[Math.max(0, Math.min(4, index))];
}

function applyFilter(selected) {
  if (geojsonLayer) map.removeLayer(geojsonLayer);
  if ($.fn.DataTable.isDataTable('#data-table')) $('#data-table').DataTable().clear().destroy();
  document.getElementById("table-body").innerHTML = '';
  document.getElementById("data-table").style.display = "table";

  const sourceData = selected === "weighted" ? weightedData : varData;
  let headers = "";

  geojsonLayer = L.geoJSON(sourceData, {
    style: function(f) {
      const p = f.properties;
      let label = p[`klas_${selected}`] || p.ket_klas || "";
      return { color: "#000", weight: 1, fillColor: getColorByClass(label), fillOpacity: 0.7 };
    },
 let popupContent = `<div style="line-height:1.4">
  <strong>Desa:</strong> ${p.Desa || p.DESA}<br>
  <strong>Kecamatan:</strong> ${p.kecamatan || p.KECAMATAN}<br>
  <strong>Kabupaten:</strong> ${p.kabupaten || p.KAB_KOTA}<br>`;

if (selected === "industri") {
  popupContent += `
    <strong>Klasifikasi:</strong> ${p.klas_industri}<br>
    <strong>Nilai:</strong> ${p.nilai_industri?.toFixed(3) || p.Industri?.toFixed(3) || '-'}
  `;
} else if (selected === "penduduk") {
  popupContent += `
    <strong>Klasifikasi:</strong> ${p.klas_penduduk}<br>
    <strong>Nilai:</strong> ${p.nilai_penduduk?.toFixed(3) || p.Penduduk?.toFixed(3) || '-'}
  `;
} else if (selected === "transportasi") {
  popupContent += `
    <strong>Klasifikasi:</strong> ${p.klas_transportasi}<br>
    <strong>Nilai:</strong> ${p.nilai_transportasi?.toFixed(3) || p.Transportasi?.toFixed(3) || '-'}
  `;
} else if (selected === "pusat") {
  popupContent += `
    <strong>Klasifikasi:</strong> ${p.klas_pusat}<br>
    <strong>Nilai:</strong> ${p.nilai_pusat?.toFixed(3) || p.Pusat?.toFixed(3) || '-'}
  `;
} else if (selected === "weighted") {
  popupContent += `
    <strong>Klasifikasi:</strong> ${p.ket_klas}<br>
    <strong>Nilai:</strong> ${p.nilai?.toFixed(3) || '-'}
  `;
}

popupContent += `</div>`;

layer.bindPopup(popupContent);

      if (selected === "industri") {
        headers = `<th>Desa</th><th>Kecamatan</th><th>Kabupaten</th><th>Jumlah Industri</th><th>Kepadatan Industri</th><th>Klasifikasi</th>`;
        row = `<tr><td>${p.Desa}</td><td>${p.kecamatan}</td><td>${p.kabupaten}</td><td>${p.jml_industri}</td><td>${p.Industri}</td><td>${p.klas_industri}</td></tr>`;
      } else if (selected === "penduduk") {
        headers = `<th>Desa</th><th>Kecamatan</th><th>Kabupaten</th><th>Jumlah Penduduk</th><th>Kepadatan Penduduk</th><th>Klasifikasi</th>`;
        row = `<tr><td>${p.Desa}</td><td>${p.kecamatan}</td><td>${p.kabupaten}</td><td>${p.jml_penduduk}</td><td>${p.Penduduk}</td><td>${p.klas_penduduk}</td></tr>`;
      } else if (selected === "transportasi") {
        headers = `<th>Desa</th><th>Kecamatan</th><th>Kabupaten</th><th>Klasifikasi</th>`;
        row = `<tr><td>${p.Desa}</td><td>${p.kecamatan}</td><td>${p.kabupaten}</td><td>${p.klas_transportasi}</td></tr>`;
      } else if (selected === "pusat") {
        headers = `<th>Desa</th><th>Kecamatan</th><th>Kabupaten</th><th>Klasifikasi Jarak ke Pusat Kota</th>`;
        row = `<tr><td>${p.Desa}</td><td>${p.kecamatan}</td><td>${p.kabupaten}</td><td>${p.klas_pusat}</td></tr>`;
      } else if (selected === "weighted") {
        headers = `<th>Desa</th><th>Kabupaten</th><th>Kecamatan</th><th>Hasil Klasifikasi</th>`;
        row = `<tr><td>${p.DESA}</td><td>${p.KAB_KOTA}</td><td>${p.KECAMATAN}</td><td>${p.ket_klas}</td></tr>`;
      }
      document.querySelector("#data-table thead tr").innerHTML = headers;
      document.getElementById("table-body").innerHTML += row;
    }
  }).addTo(map);

  setTimeout(() => {
    const dt = $('#data-table').DataTable({
      dom: 'Bfrtip',
      buttons: [
        { extend: 'copy', text: '📋 Copy', className: 'dt-button btn-copy' },
        { extend: 'excel', text: '📥 Excel', className: 'dt-button btn-excel' },
        { extend: 'csv', text: '📄 CSV', className: 'dt-button btn-csv' },
        { extend: 'pdf', text: '🧾 PDF', className: 'dt-button btn-pdf' }
      ],
      paging: false, searching: false, ordering: true, info: false
    });
    document.getElementById("export-buttons").innerHTML = '';
    document.getElementById("export-buttons").appendChild(document.querySelector('.dt-buttons'));
  }, 200);

  updateLegend(selected);
}

fetch("data/FIX.geojson").then(res => res.json()).then(data => {
  varData = data;
  return fetch("data/weighted.geojson");
}).then(res => res.json()).then(data => {
  weightedData = data;
  document.querySelectorAll(".stat-box")[0].onclick = () => applyFilter("industri");
  document.querySelectorAll(".stat-box")[1].onclick = () => applyFilter("penduduk");
  document.querySelectorAll(".stat-box")[2].onclick = () => applyFilter("transportasi");
  document.querySelectorAll(".stat-box")[3].onclick = () => applyFilter("pusat");
  const weightedBox = document.createElement("div");
  weightedBox.className = "stat-box";
  weightedBox.innerHTML = `<div class="stat-icon">🧲</div><div class="stat-content"><div class="stat-count">Overlay</div><div>Hasil Akhir</div></div>`;
  weightedBox.onclick = () => applyFilter("weighted");
  document.querySelector(".stat-wrapper").appendChild(weightedBox);
  const inputBox = document.createElement("div");
inputBox.className = "stat-box";
inputBox.innerHTML = `<div class="stat-icon">📥</div><div class="stat-content"><div class="stat-count">Input</div><div>Input Data</div></div>`;
inputBox.onclick = () => window.location.href = "input.php";
document.querySelector(".stat-wrapper").appendChild(inputBox);

  applyFilter("weighted");
});

const legend = L.control({ position: 'bottomright' });
legend.onAdd = function () {
  const div = L.DomUtil.create('div', 'legend');
  div.innerHTML = `<div onclick="toggleLegend()">🗺️ Klasifikasi</div><div class="legend-items" id="legend-items"></div>`;
  return div;
};
legend.addTo(map);

function updateLegend(selected) {
  const labels = labelKlasifikasi[selected];
  const container = document.getElementById("legend-items");
  container.innerHTML = "";
  for (let i = 0; i < labels.length; i++) {
    container.innerHTML += `<div><i style="background:${warnaKlas[i]}"></i> ${labels[i]}</div>`;
  }
  container.classList.add("open");
}

function toggleLegend() {
  const el = document.getElementById("legend-items");
  el.classList.toggle("open");
}
</script>

      </div>
    </div>
  </div>
</div>

<?php include_once "footerr.php"; ?>

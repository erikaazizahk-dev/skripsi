<?php 
$title = "Peta Hasil Overlay Industri Kreatif";
include_once "header.php"; 
?>

<!-- Leaflet CSS & JS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<!-- DataTables CSS & JS -->
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
  #map {
    width: 100%;
    height: 500px;
    margin-bottom: 30px;
    border-radius: 10px;
    border: 2px solid #ccc;
  }
  .legend {
    background: white;
    padding: 10px;
    font-size: 13px;
    line-height: 18px;
    color: #555;
    border-radius: 6px;
    box-shadow: 0 0 15px rgba(0,0,0,0.2);
  }
  .legend i {
    width: 18px;
    height: 18px;
    float: left;
    margin-right: 8px;
    opacity: 0.8;
    border: 1px solid #999;
  }
  .filter-export-container {
    display: flex;
    justify-content: flex-end;
    margin: 20px 0;
  }
  .dt-button.btn-copy { background-color: #f8f9fa !important; color: #343a40 !important; }
  .dt-button.btn-excel { background-color: #28a745 !important; color: white !important; }
  .dt-button.btn-csv { background-color: #17a2b8 !important; color: white !important; }
  .dt-button.btn-pdf { background-color: #dc3545 !important; color: white !important; }
  .dt-button {
    font-weight: bold !important;
    padding: 6px 14px !important;
    border-radius: 5px !important;
    margin-right: 6px !important;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    border: none;
  }
</style>

<div class="row">
  <div class="col-md-12">
    <div class="panel panel-info panel-dashboard centered">
      <div class="panel-heading">
        <h2 class="panel-title text-center">
          <strong>– Peta Hasil Overlay Industri Kreatif –</strong>
        </h2>
      </div>
      <div class="panel-body">

        <!-- PETA -->
        <div id="map"></div>

        <!-- TOMBOL EXPORT -->
        <div class="filter-export-container">
          <div class="buttons-container" id="export-buttons"></div>
        </div>

        <!-- TABEL -->
        <table id="data-table" class="display nowrap" style="width:100%">
          <thead>
            <tr>
              <th>No</th>
              <th>Desa</th>
              <th>Kepadatan Industri</th>
              <th>Kepadatan Penduduk</th>
              <th>Total Skor</th>
              <th>Klasifikasi</th>
            </tr>
          </thead>
          <tbody></tbody>
        </table>

      </div>
    </div>
  </div>
</div>

<script>
const map = L.map('map').setView([-7.8, 110.4], 10);
L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
  attribution: '&copy; OpenStreetMap contributors'
}).addTo(map);

const warnaKlas = ["#FFFFB2", "#FED976", "#FEB24C", "#BD0026", "#800026"];
const klasLabel = ["Sangat Rendah", "Rendah", "Sedang", "Tinggi", "Sangat Tinggi"];

function getColor(skor) {
  return skor > 3.9 ? warnaKlas[4] :
         skor > 2.8 ? warnaKlas[3] :
         skor > 2.1 ? warnaKlas[2] :
         skor > 1.5 ? warnaKlas[1] :
         skor >= 1 ? warnaKlas[0] :
                     "#dcdcdc";
}

let skorData = {};

fetch("data/hasil_skor.json")
  .then(res => res.json())
  .then(data => {
    data.forEach((item, i) => {
      const desaKey = item.DESA?.trim().toLowerCase();
      if (desaKey) {
        skorData[desaKey] = item;
        document.querySelector("#data-table tbody").innerHTML += `
          <tr>
            <td>${i + 1}</td>
            <td>${item.DESA}</td>
            <td>${item.kepadatan_industri}</td>
            <td>${item.kepadatan_penduduk}</td>
            <td>${item.total_skor}</td>
            <td>${item.klasifikasi}</td>
          </tr>`;
      }
    });
    initMapLayer();
    initDataTable();
  })
  .catch(err => console.error("Gagal memuat hasil_skor.json:", err));

function initMapLayer() {
  fetch("data/desa.geojson")
    .then(res => res.json())
    .then(geojson => {
      L.geoJSON(geojson, {
        style: function(feature) {
          const desa = feature.properties.DESA?.trim().toLowerCase();
          const skor = skorData[desa]?.total_skor;
          return {
            fillColor: getColor(skor),
            color: "gray",
            weight: 1,
            fillOpacity: 0.7
          };
        },
        onEachFeature: function(feature, layer) {
          const namaDesa = feature.properties.DESA?.trim();
          const data = skorData[namaDesa?.toLowerCase()];
          let popup = `<b>Desa:</b> ${namaDesa}<br/>`;

          if (data) {
            popup += `
              <b>Kepadatan Industri:</b> ${data.kepadatan_industri}<br/>
              <b>Kepadatan Penduduk:</b> ${data.kepadatan_penduduk}<br/>
              <b>Total Skor:</b> ${data.total_skor}<br/>
              <b>Klasifikasi:</b> ${data.klasifikasi}
            `;
          } else {
            popup += `<i>Data skor belum tersedia</i>`;
          }

          layer.bindPopup(popup);
        }
      }).addTo(map);
    });
}

// Legend
const legend = L.control({ position: 'bottomright' });
legend.onAdd = function () {
  const div = L.DomUtil.create('div', 'legend');
  div.innerHTML += '<b>Klasifikasi Skor</b><br>';
  for (let i = 0; i < klasLabel.length; i++) {
    div.innerHTML += `<i style="background:${warnaKlas[i]}"></i> ${klasLabel[i]}<br>`;
  }
  return div;
};
legend.addTo(map);

// Init DataTables
function initDataTable() {
  setTimeout(() => {
    const dt = $('#data-table').DataTable({
      dom: 'Bfrtip',
      buttons: [
        { extend: 'copy', text: '📋 Copy', className: 'dt-button btn-copy' },
        { extend: 'excel', text: '📥 Excel', className: 'dt-button btn-excel' },
        { extend: 'csv', text: '📄 CSV', className: 'dt-button btn-csv' },
        { extend: 'pdf', text: '🧾 PDF', className: 'dt-button btn-pdf' }
      ],
      paging: false,
      searching: false,
      ordering: true,
      info: false
    });
    document.getElementById("export-buttons").innerHTML = '';
    document.getElementById("export-buttons").appendChild(document.querySelector('.dt-buttons'));
  }, 300);
}
</script>

<?php include_once "footerr.php"; ?>

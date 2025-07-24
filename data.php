<?php 
$title = "Daftar Pelaku Industri Kreatif";
include_once "header.php"; // <head> dan <body>
?>

<!-- ✅ Panel Tabel -->
<div class="panel panel-info">
  <div class="panel-heading text-center">
    <h3 class="panel-title"><strong>Daftar Pelaku Industri Kreatif Provinsi Daerah Istimewa Yogyakarta</strong></h3>
  </div>
  <div class="panel-body">
    <div class="table-responsive">
      <table class="table table-bordered table-striped" id="tabelData">
        <thead>
          <tr>
            <th>No</th>
            <th>Nama Industri</th>
            <th>Subsektor</th>
            <th>Alamat</th>
            <th>Kabupaten/Kota</th>
            <th>Review Rating</th>
            <th>Link</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody></tbody>
      </table>
    </div>
  </div>
</div>

<!-- ✅ LIBRARY -->
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap.min.css"/>

<!-- Buttons Ekspor -->
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.bootstrap.min.css"/>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>

<!-- ✅ CSS -->
<style>
  .panel-body {
    overflow-x: auto;
  }

  table.dataTable {
    width: 100% !important;
    min-width: 1000px;
    table-layout: auto;
  }

  table.dataTable th, table.dataTable td {
    white-space: nowrap;
  }

  .dataTables_wrapper .top-tools {
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    justify-content: space-between;
    gap: 10px;
    margin-bottom: 10px;
  }

  .filter-group {
    display: flex;
    gap: 10px;
    align-items: center;
    flex-wrap: wrap;
  }

  .filter-group select {
    height: 32px;
    font-size: 13px;
    padding: 4px 10px;
    min-width: 160px;
  }

  .filter-group label {
    margin: 0;
    font-size: 13px;
    font-weight: 500;
  }

  .dt-buttons {
    gap: 6px;
  }

  .dataTables_filter {
    display: none !important;
  }
</style>

<!-- ✅ SCRIPT DataTable -->
<script>
$(document).ready(function () {
  const table = $('#tabelData').DataTable({
    ajax: {
      url: "ambildata.php",
      dataSrc: ''
    },
    dom: '<"top-tools"<"filter-group">B>rt<"bottom"flp><"clear">',
    buttons: [
      {
        extend: 'copyHtml5',
        text: '📋 Copy',
        className: 'btn btn-sm btn-secondary',
        title: 'Daftar Pelaku Industri Kreatif',
        exportOptions: {
          columns: [0, 1, 2, 3, 4, 5] // tidak termasuk kolom Link (6) dan Aksi (7)
        }
      },
      {
        extend: 'excelHtml5',
        text: '📥 Excel',
        className: 'btn btn-sm btn-success',
        title: 'Daftar Pelaku Industri Kreatif',
        exportOptions: {
          columns: [0, 1, 2, 3, 4, 5]
        }
      },
      {
        extend: 'csvHtml5',
        text: '📄 CSV',
        className: 'btn btn-sm btn-info',
        title: 'Daftar Pelaku Industri Kreatif',
        exportOptions: {
          columns: [0, 1, 2, 3, 4, 5]
        }
      },
      {
        extend: 'pdfHtml5',
        text: '🧾 PDF',
        className: 'btn btn-sm btn-danger',
        title: 'Daftar Pelaku Industri Kreatif',
        orientation: 'landscape',
        pageSize: 'A4',
        exportOptions: {
          columns: [0, 1, 2, 3, 4, 5]
        }
      }
    ],
    columns: [
      { data: null, render: (data, type, row, meta) => meta.row + 1 },
      { data: "nama_industri" },
      { data: "subsektor" },
      { data: "alamat_industri" },
      { data: "kabupaten" },
      { data: "review_rating" },
      {
        data: "link",
        render: function (data) {
          return `<a href="${data}" target="_blank">Lihat Lokasi</a>`;
        }
      },
      {
        data: "id_industri",
        render: function (data) {
          return `<a href="detail1.php?id=${data}" class="btn btn-primary btn-sm" target="_blank">
                    <i class="fa fa-map-marker"></i> Detail
                  </a>`;
        }
      }
    ],
    initComplete: function () {
      const filterHTML = `
        <label for="filterSubsektor">Subsektor</label>
        <select id="filterSubsektor" class="form-control">
          <option value="">Semua</option>
          <option value="Aplikasi">Aplikasi</option>
          <option value="Arsitektur">Arsitektur</option>
          <option value="Desain">Desain</option>
          <option value="Fashion">Fashion</option>
          <option value="Fotografi">Fotografi</option>
          <option value="Industri Media">Industri Media</option>
          <option value="Kriya">Kriya</option>
          <option value="Kuliner">Kuliner</option>
          <option value="Musik">Musik</option>
          <option value="Penerbitan">Penerbitan</option>
          <option value="Periklanan">Periklanan</option>
          <option value="Seni Pertunjukan">Seni Pertunjukan</option>
          <option value="Seni Rupa">Seni Rupa</option>
        </select>
        <label for="filterKabupaten">Kabupaten</label>
        <select id="filterKabupaten" class="form-control">
          <option value="">Semua</option>
          <option value="Kota Yogyakarta">Kota Yogyakarta</option>
          <option value="Bantul">Bantul</option>
          <option value="Gunungkidul">Gunungkidul</option>
          <option value="Kulon Progo">Kulon Progo</option>
          <option value="Sleman">Sleman</option>
        </select>`;
      
      $(".filter-group").html(filterHTML);
    }
  });

  // Filter berdasarkan dropdown
  $(document).on('change', '#filterSubsektor, #filterKabupaten', function () {
    const subsektor = $('#filterSubsektor').val();
    const kabupaten = $('#filterKabupaten').val();
    table.column(2).search(subsektor);
    table.column(4).search(kabupaten);
    table.draw();
  });
});
</script>

<?php include_once "footerr.php"; ?>

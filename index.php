<?php 
$title = "Sistem Informasi Geografis Industri Kreatif";
include_once "header.php"; 
?>

<!-- AOS Animate on Scroll -->
<link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
<script>AOS.init();</script>

<!-- CSS -->
<style>
  .desc-kecil {
    font-size: 14px;
    color: #444;
    line-height: 1.6;
    text-align: justify;
  }

  .card-subsektor {
    position: relative;
    border: none;
    border-radius: 10px;
    overflow: hidden;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    background-color: #fff;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    height: 100%;
  }

  .card-subsektor:hover {
    transform: scale(1.03);
    box-shadow: 0 8px 20px rgba(0,0,0,0.15);
  }

  .card-subsektor img {
    width: 100%;
    height: 170px;
    object-fit: cover;
  }

  .card-body {
    padding: 18px;
  }

  .card-title {
    font-size: 18px;
    font-weight: 600;
    color: #2c3e50;
    margin-bottom: 8px;
  }

  .badge-pelaku {
    position: absolute;
    top: 12px;
    right: 12px;
    background: #e74c3c;
    color: white;
    padding: 5px 10px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: bold;
  }

  .container-subsektor {
    padding: 0 20px;
  }

  /* Flexbox untuk subsektor, dengan jarak antar kolom dan baris */
  .row-subsektor {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    gap: 30px 20px; /* vertical 30px, horizontal 20px */
    margin-top: 30px;
  }

  .card-wrapper {
    flex: 0 0 calc(25% - 20px); /* 4 kolom */
    box-sizing: border-box;
  }

  @media (max-width: 992px) {
    .card-wrapper {
      flex: 0 0 calc(50% - 20px); /* 2 kolom tablet */
    }
  }

  @media (max-width: 576px) {
    .card-wrapper {
      flex: 0 0 100%; /* 1 kolom HP */
    }
  }

  h3, h4 {
    margin-top: 20px;
    margin-bottom: 10px;
  }
</style>

<!-- Panel Selamat Datang -->
<div class="row">
  <div class="col-md-12">
    <div class="panel panel-info panel-dashboard">
      <div class="panel-heading text-center">
        <h2 class="panel-title"><strong>🌍 Sistem Informasi Geografis Industri Kreatif Provinsi Daerah Istimewa Yogyakarta</strong></h2>
      </div>
      <div class="panel-body text-center">
        <p class="desc-kecil" style="max-width: 800px; margin: auto;">
          Industri kreatif adalah industri yang berasal dari pemanfaatan keterampilan, kreativitas, dan bakat yang dimiliki individu dalam menciptakan kesejahteraan dan lapangan pekerjaan serta berfokus untuk memberdayakan daya cipta dan kreasi.
        </p>
      </div>
    </div>
  </div>
</div>

<!-- Diagram Jumlah Pelaku per Subsektor -->
<div class="row" style="margin-top: 20px;">
  <div class="col-md-12">
    <div class="panel panel-info panel-dashboard">
      <div class="panel-heading text-center">
        <h3 class="panel-title"><strong>- Jumlah Industri Kreatif Berdasarkan Subsektor -</strong></h3>
      </div>
      <div class="panel-body">
        <div class="text-end mb-2">
          <label for="filterSubsektor">🎯 Filter:</label>
          <select id="filterSubsektor" onchange="updateChartSubsektor()">
            <option value="all">🔁 Semua</option>
            <option value="max">⬇️ Terbanyak</option>
            <option value="min">⬆️ Tersedikit</option>
          </select>
        </div>
        <div style="height: 400px;">
          <canvas id="barChartSubsektor"></canvas>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Diagram Pelaku Industri per Kabupaten/Kota -->
<div class="row" style="margin-top: 20px;">
  <div class="col-md-12">
    <div class="panel panel-info panel-dashboard">
      <div class="panel-heading text-center">
        <h3 class="panel-title"><strong>- Jumlah Industri Kreatif Berdasarkan Kabupaten/Kota -</strong></h3>
      </div>
      <div class="panel-body">
        <div class="text-end mb-2">
          <label for="filterKabupaten">🎯 Filter:</label>
          <select id="filterKabupaten" onchange="updateChartKabupaten()">
            <option value="all">Semua</option>
            <option value="max">⬇️ Terbesar</option>
            <option value="min">⬆️ Terkecil</option>
          </select>
        </div>
        <div style="height: 200px;">
          <canvas id="barChartKabupaten"></canvas>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Panel Subsektor -->
<div class="row" style="margin-top: 50px;">
  <div class="col-md-12">
    <div class="panel panel-info panel-dashboard">
      <div class="panel-heading text-center">
        <h3 class="panel-title"><strong>- Subsektor Industri Kreatif -</strong></h3>
      </div>
      <div class="panel-body text-center">
        <div class="row row-subsektor container-subsektor">
          <?php
         $subsektors = [
    ["Aplikasi", "img/Aplikasi.png", "Subsektor aplikasi mencakup pengembangan aplikasi website, pengolahan data, jasa cloud computing, jasa domain dan hosting", 208],
    ["Fashion", "img/Fashion.png", "Subsektor fashion mencakup butik, perancang busana, fashion tradisional seperti kebaya, butik, perancang busana, fashion tradisional", 374],
    ["Kriya", "img/Kriya.png", "Subsektor Kriya mencakup kerajinan tekstil, kerajinan kayu dan bambu, kerajinan logam dan perak, kerajinan gerabah dan kerajinan lainnya.", 670],
    ["Media", "img/Media.png", "Subsektor media mencakup produksi film, animasi, jasa dan produksi video (video komersil, iklan,dokumentasi), stasiun televisi dan radio.", 262],
    ["Arsitektur", "img/Arsitektur.png", "Subsektor arsitektur mencakup jasa desain arsitektural, perancangan bangunan gedung dan tata bangunan.", 147],
    ["Musik", "img/Musik.png", "Subsektor musik mencakup produksi dan distribusi rekaman seperti studio rekaman, penciptaan musik", 229],
    ["Desain", "img/Desain.png", "Subsektor desain mencakup jasa desain produk, desain interior dan desain komunikasi visual.", 117],
    ["Kuliner", "img/Kuliner.png", "Subsektor kuliner mencakup kuliner tradisional seperti bakpia, produk olahan dan kemasan.", 1484],
    ["Penerbitan", "img/Penerbitan.png", "Subsektor penerbitan mencakup penerbitan buku, majalah, media cetak", 164],
    ["Periklanan", "img/Periklanan.png", "Subsektor periklanan mencakup agensi iklan, desain kampanye, media promosi", 176],
    ["Fotografi", "img/Fotografi.png", "Subsektor fotografi mencakup fotografi komersial, dokumenter, dan lainnya", 419],
    ["Seni Rupa", "img/Seni Rupa.png", "Subsektor seni rupa mencakup Lukisan, patung, instalasi seni dan pameran", 303],
    ["Seni Pertunjukan", "img/Seni Pertunjukan.png", "Subsektor seni pertunjukan mencakup pentas seni, teater, tari, dan musik live", 110],

     ];

          foreach ($subsektors as $index => [$title, $img, $desc, $jumlah]) {
            echo "
            <div class='card-wrapper' data-aos='zoom-in' data-aos-delay='" . ($index * 80) . "'>
              <div class='card-subsektor'>
                <img src='$img' alt='$title'>
                <span class='badge-pelaku'>$jumlah Industri</span>
                <div class='card-body'>
                  <div class='card-title'>$title</div>
                  <p class='desc-kecil'>$desc</p>
                </div>
              </div>
            </div>
            ";
          }
          ?>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
  const dataSubsektor = {
    labels: ['Aplikasi', 'Arsitektur', 'Desain', 'Fashion', 'Fotografi', 'Kriya', 'Kuliner', 'Media', 'Musik', 'Penerbitan', 'Periklanan', 'Seni Pertunjukan', 'Seni Rupa'],
    values: [203, 147, 117, 374, 419, 670, 1484, 262, 229, 164, 176, 110, 303]
  };

  const ctxSub = document.getElementById('barChartSubsektor').getContext('2d');
  let chartSubsektor = new Chart(ctxSub, {
    type: 'bar',
    data: {
      labels: [...dataSubsektor.labels],
      datasets: [{
        label: 'Jumlah Industri',
        data: [...dataSubsektor.values],
        backgroundColor: 'rgba(52, 152, 219, 0.7)',
        borderColor: 'rgba(41, 128, 185, 1)',
        borderWidth: 1
      }]
    },
    options: {
      indexAxis: 'y',
      responsive: true,
      maintainAspectRatio: false,
      scales: { x: { beginAtZero: true } },
      plugins: {
        legend: { display: false },
        tooltip: {
          callbacks: {
            label: function(context) {
              return context.parsed.x + 'Industri';
            }
          }
        }
      }
    }
  });

  function updateChartSubsektor() {
    const filter = document.getElementById("filterSubsektor").value;
    let labels = [...dataSubsektor.labels];
    let values = [...dataSubsektor.values];
    let combined = labels.map((label, i) => ({ label, value: values[i] }));

    if (filter === "max") {
      combined.sort((a, b) => b.value - a.value);
    } else if (filter === "min") {
      combined.sort((a, b) => a.value - b.value);
    }

    chartSubsektor.data.labels = combined.map(item => item.label);
    chartSubsektor.data.datasets[0].data = combined.map(item => item.value);
    chartSubsektor.update();
  }

  const dataKabupaten = {
    labels: ['Sleman', 'Kota Yogyakarta', 'Bantul', 'Kulon Progo', 'Gunungkidul'],
    values: [1577, 1033, 1449, 324, 281]
  };

  const ctxKab = document.getElementById('barChartKabupaten').getContext('2d');
  let chartKabupaten = new Chart(ctxKab, {
    type: 'bar',
    data: {
      labels: [...dataKabupaten.labels],
      datasets: [{
        label: 'Jumlah Industri',
        data: [...dataKabupaten.values],
        backgroundColor: 'rgba(52, 152, 219, 0.7)',
        borderColor: 'rgba(52, 152, 219, 0.7)',
        borderWidth: 1
      }]
    },
    options: {
      indexAxis: 'y',
      responsive: true,
      maintainAspectRatio: false,
      scales: { x: { beginAtZero: true } },
      plugins: {
        legend: { display: false },
        tooltip: {
          callbacks: {
            label: function(context) {
              return context.parsed.x + ' Industri';
            }
          }
        }
      }
    }
  });

  function updateChartKabupaten() {
    const filter = document.getElementById("filterKabupaten").value;
    let labels = [...dataKabupaten.labels];
    let values = [...dataKabupaten.values];
    let combined = labels.map((label, i) => ({ label, value: values[i] }));

    if (filter === "max") {
      combined.sort((a, b) => b.value - a.value);
    } else if (filter === "min") {
      combined.sort((a, b) => a.value - b.value);
    }

    chartKabupaten.data.labels = combined.map(item => item.label);
    chartKabupaten.data.datasets[0].data = combined.map(item => item.value);
    chartKabupaten.update();
  }
</script>

<?php include_once "footerr.php"; ?>

<?php 
$title = "Pendahuluan - Sistem Informasi Geografis Industri Kreatif";
include_once "header.php"; 
?>

<!-- AOS Animation & Style -->
<link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
<script>AOS.init();</script>

<style>
  html {
    scroll-behavior: smooth;
  }

  .section-nav-wrapper {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    gap: 14px;
    margin: 30px 0 40px;
  }

  .section-nav-box {
    background: rgba(103, 150, 177, 0.85);
    padding: 12px 16px;
    border-radius: 12px;
    color: #fff;
    display: flex;
    align-items: center;
    gap: 10px;
    font-weight: 600;
    box-shadow: 0 3px 8px rgba(0, 0, 0, 0.1);
    cursor: pointer;
    transition: transform 0.2s, background 0.3s;
  }

  .section-nav-box:hover {
    transform: translateY(-3px);
    background: rgba(32, 94, 144, 1);
  }

  .section-icon {
    font-size: 20px;
    background: rgba(255, 255, 255, 0.2);
    padding: 6px;
    border-radius: 50%;
    width: 36px;
    height: 36px;
    display: flex;
    align-items: center;
    justify-content: center;
  }

  .section-label {
    font-size: 14px;
  }

  .panel-section {
    margin-bottom: 60px;
  }

  .toggle-boxes {
    display: flex;
    justify-content: center;
    gap: 20px;
    flex-wrap: wrap;
    margin: 20px 0;
  }

  .toggle-button {
    background-color: #3498db;
    color: white;
    padding: 12px 22px;
    border: none;
    border-radius: 10px;
    cursor: pointer;
    font-weight: bold;
    transition: background 0.3s;
  }

  .toggle-button:hover {
    background-color: #2c80b4;
  }

  .toggle-content {
    display: none;
    margin-top: 20px;
    text-align: justify;
    background-color: #f8f9fa;
    padding: 20px;
    border-radius: 10px;
    border: 1px solid #ddd;
    max-width: 900px;
    margin-left: auto;
    margin-right: auto;
    animation: fadeIn 0.5s ease-in-out;
  }

  @keyframes fadeIn {
    from { opacity: 0; transform: translateY(10px); }
    to { opacity: 1; transform: translateY(0); }
  }
</style>


<div id="permasalahan" class="panel panel-info panel-dashboard panel-section" data-aos="fade-up">
  <div class="panel-heading text-center">
    <h3 class="panel-title"><strong>Permasalahan</strong></h3>
  </div>
  <div class="panel-body">
    <div style="display: flex; flex-wrap: wrap; align-items: center; justify-content: center; gap: 30px;">
      <div style="flex: 1; min-width: 300px; max-width: 700px;">
        <p style="font-size: 15px; line-height: 1.8; text-align: justify; color: #333;">
          Industri kreatif telah menjadi salah satu pilar penting dalam pembangunan ekonomi global maupun nasional. Menurut laporan UNCTAD, sektor ini menyumbang sekitar <strong>3,1% terhadap PDB global</strong> dan menyerap lebih dari <strong>6,2% tenaga kerja dunia</strong><sup>[1]</sup>. 
        </p>
        <p style="font-size: 15px; line-height: 1.8; text-align: justify;">
          Di Indonesia, kontribusi ekonomi kreatif tidak kalah signifikan. Tahun 2023, sektor ini menyumbang lebih dari <strong>Rp1.414 triliun</strong> terhadap PDB nasional dan menyerap sekitar <strong>20,92 juta tenaga kerja</strong><sup>[2]</sup>. Hal ini menjadikan ekonomi kreatif sebagai salah satu fokus utama dalam <strong>RPJPN 2025–2029</strong> menuju <em>Indonesia Emas 2045</em><sup>[3]</sup>.
        </p>
        <p style="font-size: 15px; line-height: 1.8; text-align: justify;">
          Di tingkat lokal, Daerah Istimewa Yogyakarta (DIY) dikenal sebagai kota budaya sekaligus kota kreatif. Namun, terdapat tantangan nyata dalam pengembangan sektor ini. Meskipun potensi sangat besar, <strong>persebaran pelaku industri kreatif belum merata</strong> antar wilayah administratif. Beberapa wilayah mengalami konsentrasi tinggi, sementara lainnya belum berkembang optimal.
        </p>
        <p style="font-size: 15px; line-height: 1.8; text-align: justify;">
          Kurangnya sistem informasi spasial yang mampu memetakan dan menganalisis keberadaan industri kreatif menjadi penghambat perumusan kebijakan berbasis data. Oleh karena itu, dibutuhkan pendekatan berbasis <strong>Sistem Informasi Geografis (SIG)</strong> untuk memberikan gambaran menyeluruh mengenai distribusi, potensi, dan kesenjangan wilayah dalam pengembangan industri kreatif di DIY.
        </p>
      </div>
      <div style="flex: 0 0 260px;">
        <img src="img/pendahuluan.png" alt="Permasalahan Industri Kreatif"
             style="width: 100%; border-radius: 12px; box-shadow: 0 6px 20px rgba(0,0,0,0.1);">
      </div>
    </div>
  </div>
</div>

<!-- 🔹 Tujuan -->
<div id="tujuan" class="panel panel-info panel-dashboard panel-section" data-aos="fade-up">
  <div class="panel-heading text-center">
    <h3 class="panel-title"><strong>Tujuan</strong></h3>
  </div>
  <div class="panel-body">
    <div style="display: flex; flex-wrap: wrap; justify-content: center; max-width: 900px; margin: auto;">
      
      <!-- Bagian Kiri -->
      <div style="flex: 1 1 400px; padding: 15px 25px; text-align: justify; font-size: 15px;">
        <h4 style="font-size: 16px; color: #0d47a1;"><strong>🎯 Identifikasi Spasial</strong></h4>
        <p>
          Mengidentifikasi persebaran pelaku industri kreatif di Provinsi DIY berdasarkan subsektor dan wilayah administratif.
        </p>
      </div>

      <!-- Garis Tengah -->
      <div style="width: 1px; background-color: #ccc; margin: 0 10px;"></div>

      <!-- Bagian Kanan -->
      <div style="flex: 1 1 400px; padding: 15px 25px; text-align: justify; font-size: 15px;">
        <h4 style="font-size: 16px; color: #1b5e20;"><strong>🗺️ Sistem Informasi Geografis</strong></h4>
        <p>
          Membangun sistem informasi geografis berbasis web untuk menampilkan dan menganalisis distribusi spasial industri kreatif.
        </p>
      </div>

    </div>
  </div>
</div>

<!-- 🔹 Metodologi -->
<div id="metode" class="panel panel-info panel-dashboard panel-section" data-aos="fade-up">
  <div class="panel-heading text-center">
    <h3 class="panel-title"><strong>Metodologi Penelitian</strong></h3>
  </div>
  <div class="panel-body">

    <!-- 🌐 Ruang Lingkup -->
    <h4><strong>1. Ruang Lingkup</strong></h4>
    <p style="text-align: justify;">
      Penelitian ini dilakukan di wilayah Provinsi Daerah Istimewa Yogyakarta dengan unit analisis kecamatan. Data dikumpulkan pada bulan Januari hingga Maret 2025.
    </p>
    <p><a data-bs-toggle="collapse" href="#detailRuangLingkup" role="button" aria-expanded="false" aria-controls="detailRuangLingkup">
      ➕ Tampilkan Penjelasan Lengkap
    </a></p>
    <div class="collapse" id="detailRuangLingkup">
      <div class="card card-body" style="background: #f9f9f9;">
        Ruang lingkup penelitian meliputi seluruh kecamatan di 5 kabupaten/kota di Provinsi DIY: Kota Yogyakarta, Kabupaten Sleman, Bantul, Kulon Progo, dan Gunungkidul. Unit analisis berupa wilayah administratif kecamatan digunakan sebagai dasar pengolahan spasial dan analisis statistik. Pengumpulan data POI dilakukan pada rentang waktu Januari hingga Maret 2025.
      </div>
    </div>
    <hr>

    <!-- 📊 Data -->
    <h4><strong>2. Data</strong></h4>
    <p style="text-align: justify;">
      Data yang digunakan terdiri dari kategori subsektor industri kreatif berdasarkan KBLI dan data spasial variabel weighted overlay.
    </p>
    <p><a data-bs-toggle="collapse" href="#detailData" role="button" aria-expanded="false" aria-controls="detailData">
      ➕ Tampilkan Penjelasan Lengkap
    </a></p>
    <div class="collapse" id="detailData">
      <div class="card card-body" style="background: #f9f9f9;">
        <strong>Kategori POI Industri Kreatif:</strong>
        <div class="table-responsive">
          <table class="table table-bordered table-striped table-sm">
            <thead class="table-secondary">
              <tr>
                <th>Subsektor</th>
                <th>Kode KBLI</th>
                <th>Keyword</th>
              </tr>
            </thead>
            <tbody>
              <tr><td>Aplikasi</td><td>63112; 620012; 62019</td><td>website designer; perusahaan IT; software company</td></tr>
              <tr><td>Arsitektur</td><td>71101</td><td>arsitektur; perusahaan arsitektur</td></tr>
              <tr><td>Desain</td><td>7420; 74130; 74118</td><td>desain; desain interior; design agency</td></tr>
              <tr><td>Fashion</td><td>14111; 15201</td><td>produsen baju; konveksi; penjahit; sepatu</td></tr>
              <tr><td>Media</td><td>59111; 59112; 60101; 60102</td><td>film; stasiun TV; video editing; radio</td></tr>
              <tr><td>Fotografi</td><td>74201</td><td>fotografi; fotografer; studio foto</td></tr>
              <tr><td>Kriya</td><td>13134; 13911; 16291</td><td>batik; rajut; furnitur; bambu; rotan</td></tr>
              <tr><td>Kuliner</td><td>10710; 10796; 10794</td><td>kue; bakpia; gudeg; kerupuk</td></tr>
              <tr><td>Musik</td><td>59201; 59202</td><td>studio musik; recording studio</td></tr>
              <tr><td>Penerbitan</td><td>18111; 58110</td><td>penerbitan; book publisher</td></tr>
              <tr><td>Periklanan</td><td>73100</td><td>advertising</td></tr>
              <tr><td>Seni Pertunjukan</td><td>9000; 90011</td><td>teater; sanggar tari; wayang</td></tr>
              <tr><td>Seni Rupa</td><td>9002</td><td>galeri seni; pematung; pelukis</td></tr>
            </tbody>
          </table>
        </div>

        <strong>Variabel Weighted Overlay:</strong>
        <div class="table-responsive">
          <table class="table table-bordered table-sm">
            <thead class="table-secondary">
              <tr>
                <th>Faktor</th>
                <th>Bobot</th>
                <th>Kriteria</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td rowspan="5">Kepadatan Industri</td>
                <td rowspan="5">50%</td>
                <td>&lt; 0.5 industri/km²</td>
              </tr>
              <tr><td>0.5 – 1 industri/km²</td></tr>
              <tr><td>1 – 3 industri/km²</td></tr>
              <tr><td>3 – 5 industri/km²</td></tr>
              <tr><td>&gt; 5 industri/km²</td></tr>

              <tr>
                <td rowspan="5">Kepadatan Penduduk</td>
                <td rowspan="5">30%</td>
                <td>&lt; 500 jiwa/km²</td>
              </tr>
              <tr><td>500 – 1500 jiwa/km²</td></tr>
              <tr><td>1500 – 2500 jiwa/km²</td></tr>
              <tr><td>2500 – 5000 jiwa/km²</td></tr>
              <tr><td>&gt; 5000 jiwa/km²</td></tr>

              <tr>
                <td rowspan="5">Jarak Sarana Transportasi</td>
                <td rowspan="5">10%</td>
                <td>&gt; 7 km</td>
              </tr>
              <tr><td>5 – 7 km</td></tr>
              <tr><td>3 – 5 km</td></tr>
              <tr><td>1 – 3 km</td></tr>
              <tr><td>&lt; 1 km</td></tr>

              <tr>
                <td rowspan="5">Jarak Pusat Kota</td>
                <td rowspan="5">10%</td>
                <td>&gt; 25 km</td>
              </tr>
              <tr><td>20 – 25 km</td></tr>
              <tr><td>15 – 20 km</td></tr>
              <tr><td>10 – 15 km</td></tr>
              <tr><td>&lt; 10 km</td></tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
    <hr>

    <!-- 📈 Metode Penelitian -->
    <h4><strong>3. Metode Penelitian</strong></h4>
    <p style="text-align: justify;">
      Terdapat tiga metode utama: Average Nearest Neighbor (ANN), Weighted Overlay, dan Function Intensity Index (FII).
    </p>
    <p><a data-bs-toggle="collapse" href="#detailMetode" role="button" aria-expanded="false" aria-controls="detailMetode">
      ➕ Tampilkan Penjelasan Lengkap
    </a></p>
    <div class="collapse" id="detailMetode">
      <div class="card card-body" style="background: #f9f9f9;">
        <ul>
          <li><strong>Average Nearest Neighbor Index (ANNI):</strong> Digunakan untuk mengukur pola persebaran titik POI per kabupaten/kota apakah tersebar, acak, atau mengelompok.</li>
          <li><strong>Weighted Overlay:</strong> Menggabungkan beberapa faktor (kepadatan industri, kepadatan penduduk, jarak transportasi, dan pusat kota) untuk menentukan zona konsentrasi industri kreatif dengan pembobotan tertentu.</li>
          <li><strong>Function Intensity Index (FII):</strong> Mengidentifikasi sentra industri kreatif dengan menggabungkan hasil weighted overlay dan intensitas fungsi spasial subsektor tertentu.</li>
        </ul>
      </div>
    </div>
  </div>
</div>

<!-- 🔹 Script -->
<script>
  function toggleContent(id) {
    document.querySelectorAll('.toggle-content').forEach(el => el.style.display = 'none');
    const target = document.getElementById(id);
    if (target) target.style.display = 'block';
  }

  function scrollToSection(id) {
    const el = document.getElementById(id);
    if (el) el.scrollIntoView({ behavior: "smooth" });
  }
</script>

<!-- Tambahkan ini di bagian akhir halaman sebelum </body> jika belum pakai Bootstrap 5 -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<?php include_once "footerr.php"; ?>

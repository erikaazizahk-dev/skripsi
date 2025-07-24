<?php
$title = "Proses Skor Wilayah";
include_once "header.php";
?>

<div class="container mt-4">
  <h2 class="mb-3">📊 Hasil Perhitungan Skor Weighted Overlay</h2>

<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['csv_file'])) {
    $file = $_FILES['csv_file']['tmp_name'];
    $results = [];

    if (($handle = fopen($file, "r")) !== FALSE) {
        $header = fgetcsv($handle); // Skip header
        while (($data = fgetcsv($handle)) !== FALSE) {
            list($DESA, $penduduk, $luas, $industri, $jarak_transport, $jarak_pusat) = $data;

            $DESA = strtoupper(trim($DESA));
            $penduduk = (float) str_replace(",", ".", $penduduk);
            $luas = (float) str_replace(",", ".", $luas);
            $industri = (float) str_replace(",", ".", $industri);
            $jarak_transport = (float) str_replace(",", ".", $jarak_transport);
            $jarak_pusat = (float) str_replace(",", ".", $jarak_pusat);

            // Perhitungan kepadatan
            $kep_industri = $luas > 0 ? $industri / $luas : 0;
            $kep_penduduk = $luas > 0 ? $penduduk / $luas : 0;

            // Skor masing-masing faktor
            $skor_industri     = skorKategori($kep_industri, [0.5, 1, 3, 5]);       // 50%
            $skor_penduduk     = skorKategori($kep_penduduk, [500, 1500, 2500, 5000]); // 30%
            $skor_transportasi = skorKategoriTerbalik($jarak_transport, [7, 5, 3, 1]);  // 10%
            $skor_pusat        = skorKategoriTerbalik($jarak_pusat, [25, 20, 15, 10]);   // 10%

            // Hitung skor akhir
            $total_skor = round(
                0.5 * $skor_industri +
                0.3 * $skor_penduduk +
                0.1 * $skor_transportasi +
                0.1 * $skor_pusat, 2
            );

            $klasifikasi = klasifikasiSkor($total_skor);

            $results[] = [
                "DESA" => $DESA,
                "kepadatan_industri" => round($kep_industri, 2),
                "kepadatan_penduduk" => round($kep_penduduk, 2),
                "total_skor" => $total_skor,
                "klasifikasi" => $klasifikasi
            ];
        }
        fclose($handle);

        file_put_contents("data/hasil_skor.json", json_encode($results, JSON_PRETTY_PRINT));
        echo "<div class='alert alert-success'>✅ Data berhasil diproses dan disimpan ke <code>hasil_skor.json</code>.</div>";
        echo "<a href='map.php' class='btn btn-primary'>🌍 Lihat Peta Hasil</a>";
    } else {
        echo "<div class='alert alert-danger'>❌ Gagal membuka file.</div>";
    }
} else {
    echo "<div class='alert alert-warning'>⚠️ Silakan upload file CSV terlebih dahulu.</div>";
}

// Fungsi konversi ke skor 1–5 (semakin besar → skor tinggi)
function skorKategori($nilai, $batas) {
    if ($nilai < $batas[0]) return 1;
    elseif ($nilai < $batas[1]) return 2;
    elseif ($nilai < $batas[2]) return 3;
    elseif ($nilai < $batas[3]) return 4;
    else return 5;
}

// Fungsi konversi ke skor 1–5 (semakin kecil → skor tinggi)
function skorKategoriTerbalik($nilai, $batas) {
    if ($nilai > $batas[0]) return 1;
    elseif ($nilai > $batas[1]) return 2;
    elseif ($nilai > $batas[2]) return 3;
    elseif ($nilai > $batas[3]) return 4;
    else return 5;
}

// Fungsi klasifikasi akhir berdasarkan rentang skor total
function klasifikasiSkor($skor) {
    if ($skor < 1.6) return "Sangat Rendah";
    elseif ($skor < 2.2) return "Rendah";
    elseif ($skor < 2.9) return "Sedang";
    elseif ($skor < 4.0) return "Tinggi";
    elseif ($skor <= 5.0) return "Sangat Tinggi";
    else return "Tidak Terklasifikasi";
}
?>

</div>

<?php include_once "footerr.php"; ?>

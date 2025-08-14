from qgis.core import (
    QgsProject,
    QgsSpatialIndex,
    QgsGeometry,
)
from scipy.stats import norm
import math
import csv
import os

# ======================
# KONFIGURASI
# ======================

layer_name = "Data"  # ganti sesuai nama layer shapefile kamu di QGIS
kolom_subsektor = "subsektor"
kolom_kabupaten = "kabupaten"

# ======================
# AMBIL LAYER
# ======================

layer_list = QgsProject.instance().mapLayersByName(layer_name)
if not layer_list:
    raise Exception(f"❌ Layer '{layer_name}' tidak ditemukan.")
layer = layer_list[0]

# ======================
# GROUPING
# ======================

# Ambil semua fitur dari layer
features = list(layer.getFeatures())

# Buat struktur nested dictionary: {subsektor -> {kabupaten -> list of features}}
grouped = {}
for f in features:
    subsektor = f[kolom_subsektor]
    kab = f[kolom_kabupaten]
    if subsektor not in grouped:
        grouped[subsektor] = {}
    if kab not in grouped[subsektor]:
        grouped[subsektor][kab] = []
    grouped[subsektor][kab].append(f)

# ======================
# FUNGSI: HAPUS DUPLIKAT
# ======================

def remove_duplicate_points(points, tolerance=0.001):
    unique_points = []
    seen_coords = set()
    for point in points:
        pt = point.geometry().asPoint()
        rounded_pt = (round(pt.x(), 6), round(pt.y(), 6))
        if rounded_pt not in seen_coords:
            unique_points.append(point)
            seen_coords.add(rounded_pt)
    return unique_points

# ======================
# ANALISIS ANNI
# ======================

results = []

for subsektor in grouped:
    for kabupaten in grouped[subsektor]:
        points = grouped[subsektor][kabupaten]
        points = remove_duplicate_points(points)

        print(f"\n📍 {subsektor} - {kabupaten}")

        if len(points) <= 1:
            print("⚠️  Titik tidak cukup untuk analisis.")
            continue

        # Hitung MBR
        extent = QgsGeometry.unaryUnion([f.geometry() for f in points]).boundingBox()
        area_mbr = extent.width() * extent.height()

        # Spatial index
        sindex = QgsSpatialIndex()
        for f in points:
            sindex.insertFeature(f)

        # Cari NN untuk tiap titik
        nn_dict = {}
        for point in points:
            pt = point.geometry().asPoint()
            nearest_ids = sindex.nearestNeighbor(pt, 2)
            if point.id() in nearest_ids:
                nearest_ids.remove(point.id())
            if nearest_ids:
                nn_feat = next(p for p in points if p.id() == nearest_ids[0])
                dist = point.geometry().distance(nn_feat.geometry())
                nn_dict[point.id()] = (nearest_ids[0], dist)

        # Hitung ANNI
        N = len(nn_dict)
        total_distance = sum(d for _, d in nn_dict.values())
        d_obs = total_distance / N
        d_exp = 0.5 * math.sqrt(area_mbr / N)
        se = 0.26136 * math.sqrt(area_mbr / (N ** 2))
        z_score = (d_obs - d_exp) / se
        anni = d_obs / d_exp
        p_value = 2 * (1 - norm.cdf(abs(z_score)))

        # Interpretasi
        if anni < 1:
            pola = "Pola Mengelompok (Clustered)"
        elif abs(anni - 1) < 0.01:
            pola = "Pola Acak (Random)"
        else:
            pola = "Pola Tersebar (Dispersed)"

        signif = "Signifikan (p < 0.05)" if p_value < 0.05 else "Tidak Signifikan (p > 0.05)"

        print(f"Jumlah Titik : {N}")
        print(f"Observed R   : {d_obs:.6f}")
        print(f"Expected R   : {d_exp:.6f}")
        print(f"ANNI         : {anni:.6f}")
        print(f"Z-Score      : {z_score:.6f}")
        print(f"P-Value      : {p_value:.6f}")
        print(f"Pola         : {pola}")
        print(f"Signifikansi : {signif}")

        results.append([
            subsektor, kabupaten, N, area_mbr, d_obs, d_exp,
            anni, z_score, p_value, pola, signif
        ])

# ======================
# EXPORT HASIL KE CSV
# ======================

output_path = os.path.expanduser("~/hasil_anni_shp_per_subsektor_per_kab.csv")

with open(output_path, mode='w', newline='', encoding='utf-8') as f:
    writer = csv.writer(f)
    writer.writerow([
        'Subsektor', 'Kabupaten/Kota', 'Jumlah Titik', 'Luas Area Studi (m²)',
        'Jarak Observed (m)', 'Jarak Expected (m)', 'ANNI',
        'Z-Score', 'P-Value', 'Pola', 'Signifikansi Statistik'
    ])
    writer.writerows(results)

print(f"\n✅ Hasil disimpan ke: {output_path}")

<?php
include "koneksi.php";

// Ambil dan sanitasi parameter ID
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

$posts = array();

if ($id > 0) {
    // Query gabungan dari dua tabel: data_fix_1 dan data_fix_2
    $query = "
        (SELECT * FROM data_fix_1 WHERE id_industri = ?)
        UNION ALL
        (SELECT * FROM data_fix_2 WHERE id_industri = ?)
    ";

    $stmt = $koneksi->prepare($query);
    $stmt->bind_param("ii", $id, $id); // dua kali karena dua ? di query

    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        $posts[] = $row;
    }

    echo json_encode(array('results' => $posts));
} else {
    echo json_encode(array('results' => []));
}
?>

<?php
include "koneksi.php";

// Ambil dan sanitasi parameter ID
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

$posts = array();
$data = array();

if ($id > 0) {
    // Query dengan prepared statement
    $stmt = $koneksi->prepare("SELECT * FROM data__fix WHERE id_industri = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();

    $result = $stmt->get_result();
    while($row = $result->fetch_assoc()){
        $posts[] = $row;
    }

    $data = json_encode(array('results' => $posts));
    echo $data;
} else {
    echo json_encode(array('results' => []));
}
?>

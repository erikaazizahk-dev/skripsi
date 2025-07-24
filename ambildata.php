<?php
include "koneksi.php";

$result = mysqli_query($koneksi, "SELECT * FROM data__fix");

$posts = array();
if ($result && mysqli_num_rows($result) > 0) {
    while($row = mysqli_fetch_assoc($result)) {
        $posts[] = $row;
    }
}

echo json_encode($posts);
?>

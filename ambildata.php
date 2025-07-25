<?php
include "koneksi.php";

// Query gabungan dari dua tabel: data__fix_1 dan data__fix_2
$query = "
    (SELECT * FROM data_fix_1)
    UNION ALL
    (SELECT * FROM data_fix_2)
";

$result = mysqli_query($koneksi, $query);

$posts = array();
if ($result && mysqli_num_rows($result) > 0) {
    while($row = mysqli_fetch_assoc($result)) {
        $posts[] = $row;
    }
}

echo json_encode($posts);
?>

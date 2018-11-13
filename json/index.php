<?php
    $conn = new mysqli("localhost", "root", "", "akademik");
    $sql = "select * from mahasiswa";
    $result = $conn->query($sql);

    $arr = array();
    while($row = $result->fetch_assoc()) {
        array_push($arr, $row);
    }

    header("Content-Type: application/json");
    print_r(json_encode($arr));
?>

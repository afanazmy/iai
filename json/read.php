<?php
    $content = file_get_contents("http://localhost/json/index.php");

    $result = json_decode($content);
    echo $result->nama1."<br />";
    echo $result->nama2."<br />";


?>

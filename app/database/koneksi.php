<?php
$mysqli = new mysqli("localhost", "root", "", "kasir");

// Check connection
if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: " . $mysqli->connect_error;
    exit();
}

$sql = "CALL getPakaian()";
$result = $mysqli->query($sql);

if ($result->num_rows > 0) {
    var_dump( $result->fetch_all());
} else {
    echo "0 results";
}

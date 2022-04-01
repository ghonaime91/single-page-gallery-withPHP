<?php
$host   = 'localhost';
$user   = 'root';
$pass   = '';
$dbName ='images-gallery';

$conn = mysqli_connect($host,$user,$pass,$dbName);

if(!$conn) {
    echo "Eroor ".mysqli_connect_error();
}


?>
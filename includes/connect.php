<?php

$server = "localhost";
$user = "root";
$pass = "";
$db = "e-voting";


$conn = mysqli_connect($server,$user,$pass,$db);

if(!$conn){
    die("connection error". mysqli_connect_error());
}
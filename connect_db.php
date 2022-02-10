<?php
$username = 'vyacheslav';
$servername = 'localhost';
$password = 'Avatar1!';
$dbname = 'testDB';
$port = '3306';
$conn = mysqli_connect($servername,$username,$password,$dbname,$port );
if (!$conn){
    die("Connection failed:" . mysqli_connect_error());
}
<?php
$host = "localhost";
$username = "postgres";
$password = "admin2";
$dbName = "Payguru";
try {
    $dsn = "pgsql:host=$host;port=5432;dbname=$dbName;";
    $conn = new PDO("pgsql:host=$host;dbname=$dbName", $username, $password);
} catch (PDOException $e) {
    die($e->getMessage());
}

$gelen = file_get_contents("php://input");

if (!empty($gelen)) {
    $sql = "INSERT INTO gelen_idler (numaralar) values (:gelen)";
    $sql = $conn->prepare($sql);
    $sql->bindParam(":gelen",$gelen);
    $sql->execute();
    print_r($conn->lastInsertId());
}
if(isset($_GET['id'])){
    $id = $_GET['id'];
    $sql = "select gelen_idler from numaralar where id = :id";
    $statement = $conn->prepare($sql);
    $statement->bindParam(':id',$id);
    $statement->execute();
    $cek = $statement->fetchObject();
    //print_r($cek->toplam);
}
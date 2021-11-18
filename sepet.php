<?php
session_start();

$host = "localhost";
$username = "postgres";
$password = "admin2";
$dbName = "Payguru";
try {
    $dsn = "pgsql:host=$host;port=5432;dbname=$dbName;";
    $conn = new PDO("pgsql:host=$host;dbname=$dbName", $username, $password);
    //$pdo = new PDO($dsn,$username,$password);
} catch (PDOException $e) {
    die($e->getMessage());
}
//$result = pg_query($dsn, "SELECT * FROM urunler");
function sepeteEkle($urun){
    if (isset($_SESSION["sepet"])){
        $sepet = $_SESSION["sepet"];
        $urunler = $sepet["urunler"];
    }else{
        $urunler = array();
    }
    if(array_key_exists($urun["id"],$urunler)){
        $urunler[$urun["id"]]["count"]++;
    }else{
        $urunler[$urun["id"]]=$urun;
    }

    $toplam_fiyat =0;
    $toplam_adet = 0;
    foreach ($urunler as $urun){
        $urun["toplam_tutar"] = $urun["count"]*$urun["urun_fiyat"];
        $toplam_fiyat += $urun["toplam_tutar"];
        $toplam_adet += $urun["count"];
    }

    $toplam["toplam_tutar"] = $toplam_fiyat;
    $toplam["toplam_adet"] = $toplam_adet;
    $_SESSION["sepet"]["urunler"] = $urunler;
    $_SESSION["sepet"]["toplam"] = $toplam;
    print_r($_SESSION["sepet"]);
}
if(isset($_POST ["p"])){
    $islem = $_POST["p"];
    if($islem == "sepet"){
        $id = $_POST["urun_id"];
        $urun = $conn->query("SELECT * FROM urunler where id={$id}",PDO::FETCH_ASSOC)->fetch();
        $urun['count'] = 1;
    }
    sepeteEkle($urun);
}
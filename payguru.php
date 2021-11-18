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

//Operatörden gelen id yi al

$gelen = file_get_contents("php://input");

if (!empty($gelen)) {
    $sql = "INSERT INTO toplamlar (toplam) values (:gelen)";
    $sql = $conn->prepare($sql);
    $sql->bindParam(":gelen",$gelen);
    $sql->execute();
    print_r($conn->lastInsertId());
}

if(isset($_POST["payguru_veri"])){
    $payguru_data  = $_POST['payguru_veri'] ?? null;
    $url = 'http://localhost/PayguruProje/merchant/operator.php';
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_POSTFIELDS,$payguru_data);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);
    $data = (curl_exec($curl));
    curl_close($curl);
    header("location:operator.php?id=$data");
    print_r($data);
}
if(isset($_GET['id'])){
    $id = $_GET['id'];
    // id den çek vt den
    $sql = "select toplam from toplamlar where id = :id";
    $statement = $conn->prepare($sql);
    $statement->bindParam(':id',$id);
    $statement->execute();
    $cek = $statement->fetchObject();
    //print_r($cek->toplam);

    echo <<<EOF
    <div class="container m-5" style="width: 25rem;">
        <form action="" method="POST">
            <div class="form-group">
                <label for="tel">Telefon</label>
                <input type="text" class="form-control" id="tel" name="payguru_veri"  placeholder="Numaranızı Giriniz">
            </div>
            <div class="form-group">
                <label for="exampleInputPassword1">Ürün Fiyatı</label>
                <input type="text" class="form-control" id="toplam_fiyat" value = "$cek->toplam">
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
EOF;
}


exit();
?>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
</body>
</html>
<?php
include 'sepet.php';

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
$sql = $conn->query("SELECT * FROM urunler",PDO::FETCH_ASSOC);
?>

<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
<script src="controller.js"></script>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <script>
        function ekle(ad,fiyat) {
            $.post("http://localhost/PayguruProje/merchant/sepet.php", {ad: ad, fiyat: fiyat}, function(data){
                $("#fiyat").html(data);
                console.log(data)
            });
        }
    </script>
</head>
<body>
<div id="fiyat"></div>


    <?php
        if(isset($_POST["veri"])){
            $payguru_data  = $_POST['veri'] ?? null;
            $url = 'http://localhost/PayguruProje/merchant/payguru.php';
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_POSTFIELDS,$payguru_data);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);
            $data = (curl_exec($curl));
            curl_close($curl);
            header("location:payguru.php?id=$data");
            print_r($data);
        }
        ?>

    <div class="container">
           <div class="row">
               <?php foreach($sql as $row ){?>
               <div class="col-sm-6 col-md-3">
                   <div class="card p-3 mb-2">
                       <div class="card-body">
                           <h5 class="card-title"><?php echo $row["urun_adi"]?></h5>
                           <p class="card-text"><?php echo $row['urun_fiyat']?></p>
                           <!--<a href="#" class="btn btn-primary">Button</a>-->
                           <button urun_id="<?php echo $row['id']?>" class="btn btn-primary ekleBtn">Seç</button>
                       </div>
                   </div>
               </div>
               <?php }?>
           </div>
    </div>


<div class="container m-5" >
    <form action="" method="POST">
        <input type="text" readonly="yes" name="veri" value="<?php echo $_SESSION["sepet"]["toplam"]["toplam_tutar"] ?>">
        <!-- <input type="hidden" readonly="yes" name="veriler" value="<?php //print_r( $_SESSION["sepet"]["urunler"]) ?>">-->
        <input type="submit" value="GÖNDER">
    </form>
</div>
</body>
</html>


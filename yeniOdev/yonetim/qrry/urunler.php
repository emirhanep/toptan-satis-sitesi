<?php
$dataAdi = "urunler";
include("../ekler/fonksiyonlar.php");
include("../ekler/baglan.php");

$urunlerDataKolonlar = array('id', 'adi', 'maliyet', 'resim', 'tanim', 'drm');
$urunlerDataKolonOlculer = array('int', 'varc', 'dcml', 'varc', 'lng', 'int');
sqlDurumuBak($dataAdi, $urunlerDataKolonlar, $urunlerDataKolonOlculer);
$postdeger = "type"; if(empty(postAl($postdeger))) { $type = NULL; } else {  $type =  postAl($postdeger); }

if($type == "ekle") { 

$postdeger = "adi"; if(empty(postAl($postdeger))) { $adi = NULL; } else {  $adi =  postAl($postdeger); }
$postdeger = "maliyet"; if(empty(postAl($postdeger))) { $maliyet = "0.00"; } else {  $maliyet =  postAl($postdeger); }
$postdeger = "resim"; if(empty(postAl($postdeger))) { $resim = NULL; } else {  $resim =  postAl($postdeger); }
$postdeger = "tanim"; if(empty(postAl($postdeger))) { $tanim = NULL; } else {  $tanim =  postAl($postdeger); }
$drm = 1; 
if(empty($adi) || $maliyet == "0.00" || empty($resim)) {
    $result = array("ERR" => "Formun tamamı doldurulmak zorundadır", "resp" => ""); 
    echo json_encode($result);
    die();
}

$kistas = "`adi` = '$adi'";
$varmi = VarmiKontrol($dataAdi, $kistas);

if($varmi != 0) {
    $result = array("ERR" => "Kayıtlı Ürün  Adı", "resp" => ""); 
    echo json_encode($result);
    die();
}
$length = 4;
$imgName = substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnoprstuvwxyz', ceil($length/strlen($x)) )),1,$length);
$imgName = $imgName.date("ymdhis").".jpg";

$urunlerSaveValues = "NULL, '$adi', '$maliyet', '$imgName', '$tanim', $drm";
$columns = implode(", ",$urunlerDataKolonlar);
$sql = "INSERT INTO `$dataAdi`  ($columns)VALUES($urunlerSaveValues)";
$baglan->query($sql);

$imgFolder = "../../productImages/".$imgName;

$f = fopen($imgFolder, 'wb');
stream_filter_append($f, 'convert.base64-decode');
fwrite($f, substr($resim, strpos($resim, ',') + 1));
fclose($f);

}

if($type == "update") { 
    $postdeger = "adi"; if(empty(postAl($postdeger))) { $adi = NULL; } else {  $adi =  postAl($postdeger); }
    $postdeger = "maliyet"; if(empty(postAl($postdeger))) { $maliyet = "0.00"; } else {  $maliyet =  postAl($postdeger); }
    $postdeger = "resim"; if(empty(postAl($postdeger))) { $resim = NULL; } else {  $resim =  postAl($postdeger); }
    $postdeger = "tanim"; if(empty(postAl($postdeger))) { $tanim = NULL; } else {  $tanim =  postAl($postdeger); }
    $postdeger = "idsi"; if(empty(postAl($postdeger))) { $idsi = 0; } else {  $idsi =  postAl($postdeger); }

    if(empty($adi) || $maliyet == "0.00") {
        $result = array("ERR" => "Formun tamamı doldurulmak zorundadır", "resp" => ""); 
        echo json_encode($result);
        die();
    }

    $kistas = "`id` = '$idsi'";
    $varmi = VarmiKontrol($dataAdi, $kistas);
    if($varmi == 0) {
        $result = array("ERR" => "Sistem Hatası", "resp" => ""); 
        echo json_encode($result);
        die();
    }
    
    $kistas = "`adi` = '$adi' && `id` != '$idsi'";
    $varmi = VarmiKontrol($dataAdi, $kistas);
    
    if($varmi != 0) {
        $result = array("ERR" => "Kayıtlı Ürün  Adı", "resp" => ""); 
        echo json_encode($result);
        die();
    }

    $sql = "UPDATE `$dataAdi` SET `adi` = '$adi',  `maliyet` = '$maliyet' WHERE `$dataAdi`.`id` = '$idsi';";
    $baglan->query($sql);


    if(!empty($resim)) {
        $kistas = "`id` =  '$idsi'";
        $queryBilgiAl = "SELECT * FROM `$dataAdi` WHERE $kistas";
        $sonucBilgiAl = mysqli_query($baglan, $queryBilgiAl);
        $satirBilgiAl = $sonucBilgiAl->fetch_array(MYSQLI_ASSOC);
        $sonucBilgiAl->close(); 
        $oldImg = "../../productImages/".$satirBilgiAl['resim'] ;
        if(file_exists($oldImg)) { unlink($oldImg); }
        $length = 4;
        $imgName = substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnoprstuvwxyz', ceil($length/strlen($x)) )),1,$length);
        $imgName = $imgName.date("ymdhis").".jpg";
        $imgFolder = "../../productImages/".$imgName;
        $f = fopen($imgFolder, 'wb');
        stream_filter_append($f, 'convert.base64-decode');
        fwrite($f, substr($resim, strpos($resim, ',') + 1));
        fclose($f);
        $sql = "UPDATE `$dataAdi` SET `resim` = '$imgName' WHERE `$dataAdi`.`id` = '$idsi';";
        $baglan->query($sql);
    }
 }


 if($type == "del") { 
    $postdeger = "idsi"; if(empty(postAl($postdeger))) { $idsi = 0; } else {  $idsi =  postAl($postdeger); }

    if($idsi == 0) { 
        $result = array("ERR" => "Sistem Hatası", "resp" => ""); 
        echo json_encode($result);
        die();
    }

    $kistas = "`id` = '$idsi'";
    $varmi = VarmiKontrol($dataAdi, $kistas);

    if($varmi == 0) {
        $result = array("ERR" => "Hatalı Veri", "resp" => ""); 
        echo json_encode($result);
        die();
    }

    $yeniDrm = 0;
    $kistas = "`id` =  '$idsi'";
    $queryBilgiAl = "SELECT * FROM `$dataAdi` WHERE $kistas";
    $sonucBilgiAl = mysqli_query($baglan, $queryBilgiAl);
    $satirBilgiAl = $sonucBilgiAl->fetch_array(MYSQLI_ASSOC);
    $sonucBilgiAl->close(); 
    if($satirBilgiAl['drm'] == 0) { $yeniDrm = 1; } 
    $sql = "UPDATE `$dataAdi` SET `drm` = '$yeniDrm' WHERE `$dataAdi`.`id` = '$idsi';";
    $baglan->query($sql);

}


$kistas = "`id` !=  '0'"; 
$queryBilgiAl = "SELECT * FROM `$dataAdi` WHERE $kistas"; 
$sonucBilgiAl = mysqli_query($baglan, $queryBilgiAl);
$response = array();
while($row = mysqli_fetch_array($sonucBilgiAl)) { 
    $satirarray = array();
    foreach ($urunlerDataKolonlar as $value) {  
        $satirarray[$value] = $row[$value];  
    }
    array_push($response,$satirarray);

}

$result = array("ERR" => "", "resp" => $response); 
    echo json_encode($result);
    die();

?>
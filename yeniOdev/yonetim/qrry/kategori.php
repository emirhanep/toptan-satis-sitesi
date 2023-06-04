<?php
$dataAdi = "kategoriler";
include("../ekler/fonksiyonlar.php");
include("../ekler/baglan.php");

$kategorilerDataKolonlar = array('id', 'name', 'drm');
$kategorilerDataKolonOlculer = array('int', 'varc', 'int');

sqlDurumuBak($dataAdi, $kategorilerDataKolonlar, $kategorilerDataKolonOlculer);


$postdeger = "type"; if(empty(postAl($postdeger))) { $type = NULL; } else {  $type =  postAl($postdeger); }
//$type = "update";
if($type == "ekle") {
    $postdeger = "name"; if(empty(postAl($postdeger))) { $name = NULL; } else {  $name =  postAl($postdeger); }
    
    $drm = 1; 

    if(empty($name)) { 
        $result = array("ERR" => "Kategori Adı Boş Bırakılamaz", "resp" => ""); 
        echo json_encode($result);
        die();
    }
    $kistas = "`name` = '$name'";
    $varmi = VarmiKontrol($dataAdi, $kistas);
    if($varmi != 0) {
        $result = array("ERR" => "Kayıtlı Kategori Adı", "resp" => ""); 
        echo json_encode($result);
        die();
    }

    $kategorilerSaveValues = "NULL, '$name', '$drm'";
    $columns = implode(", ",$kategorilerDataKolonlar);
    $sql = "INSERT INTO `$dataAdi`  ($columns)VALUES($kategorilerSaveValues)";
    $baglan->query($sql); 

}

if($type == "update") {
    $postdeger = "name"; if(empty(postAl($postdeger))) { $name = NULL; } else {  $name =  postAl($postdeger); }
    $postdeger = "idsi"; if(empty(postAl($postdeger))) { $idsi = 0; } else {  $idsi =  postAl($postdeger); }
    
    if(empty($name)) { 
        $result = array("ERR" => "Kategori Adı Boş Bırakılamaz", "resp" => ""); 
        echo json_encode($result);
        die();
    }

    if($idsi == 0) { 
        $result = array("ERR" => "Sistem Hatası", "resp" => ""); 
        echo json_encode($result);
        die();
    }
    $kistas = "`name` = '$name' && `id` != '$idsi'";
    $varmi = VarmiKontrol($dataAdi, $kistas);

    if($varmi != 0) {
        $result = array("ERR" => "Kayıtlı Kategori Adı", "resp" => ""); 
        echo json_encode($result);
        die();
    }

    $sql = "UPDATE `$dataAdi` SET `name` = '$name' WHERE `$dataAdi`.`id` = '$idsi';";
    $baglan->query($sql);

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
    foreach ($kategorilerDataKolonlar as $value) {  
        $satirarray[$value] = $row[$value];  
    }
    array_push($response,$satirarray);

}

$result = array("ERR" => "", "resp" => $response); 
    echo json_encode($result);
    die();


?>
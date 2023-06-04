<?php
$dataAdi = "hammadde";
include("../ekler/fonksiyonlar.php");
include("../ekler/baglan.php");

$hammaddeDataKolonlar = array('id', 'kategori', 'adi', 'maliyet', 'drm');
$hammaddeDataKolonOlculer = array('int', 'int', 'varc', 'dcml', 'int');

sqlDurumuBak($dataAdi, $hammaddeDataKolonlar, $hammaddeDataKolonOlculer);

$postdeger = "type"; if(empty(postAl($postdeger))) { $type = NULL; } else {  $type =  postAl($postdeger); }

if($type == "ekle") { 
    $postdeger = "kategori"; if(empty(postAl($postdeger))) { $kategori = 0; } else {  $kategori =  postAl($postdeger); }
    $postdeger = "adi"; if(empty(postAl($postdeger))) { $adi = NULL; } else {  $adi =  postAl($postdeger); }
    $postdeger = "maliyet"; if(empty(postAl($postdeger))) { $maliyet = "0.00"; } else {  $maliyet =  postAl($postdeger); }
    $drm = 1; 

    if(empty($adi)) { 
        $result = array("ERR" => "Hammadde Adı Boş Bırakılamaz", "resp" => ""); 
        echo json_encode($result);
        die();
    }

    if($kategori == 0) { 
        $result = array("ERR" => "Hatalı Kategori Verisi", "resp" => ""); 
        echo json_encode($result);
        die();
    }

    $kistas = "`id` = '$kategori'";
    $varmi = VarmiKontrol("kategoriler", $kistas);

    if($varmi == 0) { 
        $result = array("ERR" => "Hatalı Kategori Verisi", "resp" => ""); 
        echo json_encode($result);
        die();
    }

    if($maliyet == "0.00") { 
        $result = array("ERR" => "Hatalı Maliyet Bildirimi", "resp" => ""); 
        echo json_encode($result);
        die();
    }

    if(empty($adi)) { 
        $result = array("ERR" => "Hammadde Adı Boş Bırakılamaz", "resp" => ""); 
        echo json_encode($result);
        die();
    }

    $kistas = "`adi` = '$adi' && `kategori` = '$kategori'";
    $varmi = VarmiKontrol($dataAdi, $kistas);

    if($varmi != 0) {
        $result = array("ERR" => "Kayıtlı Hammadde Adı", "resp" => ""); 
        echo json_encode($result);
        die();
    }

    $hammaddeSaveValues = "NULL, '$kategori', '$adi', '$maliyet', '$drm'";
    $columns = implode(", ",$hammaddeDataKolonlar);
    $sql = "INSERT INTO `$dataAdi`  ($columns)VALUES($hammaddeSaveValues)";
    $baglan->query($sql);

}

if($type == "update") { 
    $postdeger = "kategori"; if(empty(postAl($postdeger))) { $kategori = 0; } else {  $kategori =  postAl($postdeger); }
    $postdeger = "name"; if(empty(postAl($postdeger))) { $adi = NULL; } else {  $adi =  postAl($postdeger); }
    $postdeger = "maliyet"; if(empty(postAl($postdeger))) { $maliyet = "0.00"; } else {  $maliyet =  postAl($postdeger); }
    $postdeger = "idsi"; if(empty(postAl($postdeger))) { $idsi = 0; } else {  $idsi =  postAl($postdeger); }

    if(empty($adi)) { 
        $result = array("ERR" => "Hammadde Adı Boş Bırakılamaz", "resp" => ""); 
        echo json_encode($result);
        die();
    }

    if($idsi == 0) { 
        $result = array("ERR" => "Sistem Hatası", "resp" => ""); 
        echo json_encode($result);
        die();
    }

    if($kategori == 0) { 
        $result = array("ERR" => "Sistem Hatası", "resp" => ""); 
        echo json_encode($result);
        die();
    }

    $kistas = "`id` = '$kategori'";
    $varmi = VarmiKontrol("kategoriler", $kistas);

    if($varmi == 0) { 
        $result = array("ERR" => "Hatalı Kategori Verisi", "resp" => ""); 
        echo json_encode($result);
        die();
    }

    if($maliyet == "0.00") { 
        $result = array("ERR" => "Hatalı Maliyet Bildirimi", "resp" => ""); 
        echo json_encode($result);
        die();
    }

    $kistas = "`adi` = '$adi' && `id` != '$idsi' && `kategori` = '$kategori'";
    $varmi = VarmiKontrol($dataAdi, $kistas);

    if($varmi != 0) {
        $result = array("ERR" => "Kayıtlı Hammadde Adı", "resp" => ""); 
        echo json_encode($result);
        die();
    }

    $sql = "UPDATE `$dataAdi` SET   `adi` = '$adi',  `maliyet` = '$maliyet' WHERE `$dataAdi`.`id` = '$idsi';";
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
    $kategori = $satirBilgiAl['kategori'];
    $sql = "UPDATE `$dataAdi` SET `drm` = '$yeniDrm' WHERE `$dataAdi`.`id` = '$idsi';";
    $baglan->query($sql);

}

if(empty($type)) {
    $postdeger = "kategori"; if(empty(postAl($postdeger))) { $kategori = 0; } else {  $kategori =  postAl($postdeger); }
}

$kistas = "`kategori` =  '$kategori'"; 
$queryBilgiAl = "SELECT * FROM `$dataAdi` WHERE $kistas"; 
$sonucBilgiAl = mysqli_query($baglan, $queryBilgiAl);
$response = array();
while($row = mysqli_fetch_array($sonucBilgiAl)) { 
    $satirarray = array();
    foreach ($hammaddeDataKolonlar as $value) {  
        $satirarray[$value] = $row[$value];  
    }
    array_push($response,$satirarray);

}

$result = array("ERR" => "", "resp" => $response); 
    echo json_encode($result);
    die();


?>
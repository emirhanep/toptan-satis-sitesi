<?php
$dataAdi = "indirim";
include("../ekler/fonksiyonlar.php");
include("../ekler/baglan.php");
$indirimDataKolonlar = array('id', 'hammadde', 'minadet', 'yuzde', 'tur', 'drm');
$indirimDataKolonOlculer = array('int', 'int', 'int', 'dcml', 'int', 'int');
sqlDurumuBak($dataAdi, $indirimDataKolonlar, $indirimDataKolonOlculer);
$postdeger = "type"; if(empty(postAl($postdeger))) { $type = NULL; } else {  $type =  postAl($postdeger); }
$postdeger = "bag"; if(empty(postAl($postdeger))) { $hammadde = 0; } else {  $hammadde =  postAl($postdeger); }
$postdeger = "tur"; if(empty(postAl($postdeger))) { $tur = 0; } else {  $tur =  postAl($postdeger); }
if($hammadde == 0 || $tur == 0) {
    $result = array("ERR" => "Sistem Hatası", "resp" => ""); 
    echo json_encode($result);
    die();
}

if($type == "ekle") {
    $postdeger = "minadet"; if(empty(postAl($postdeger))) { $minadet = 0; } else {  $minadet =  postAl($postdeger); }
    $postdeger = "yuzde"; if(empty(postAl($postdeger))) { $yuzde = "0.00"; } else {  $yuzde =  postAl($postdeger); }
    $drm = 1; 
    
    $kistas = "`minadet` = '$minadet' && `hammadde` =  '$hammadde' && `tur` =  '$tur'";
    $varmi = VarmiKontrol($dataAdi, $kistas);

    if($varmi == 0) {
        $indirimSaveValues = "NULL, '$hammadde', '$minadet', '$yuzde', '$tur', '$drm'";
        $columns = implode(", ",$indirimDataKolonlar);
        $sql = "INSERT INTO `$dataAdi`  ($columns)VALUES($indirimSaveValues)";
        $baglan->query($sql);
    } else {
        $sql = "UPDATE `$dataAdi` SET `minadet` = '$minadet',  `yuzde` = '$yuzde' WHERE $kistas";
        $baglan->query($sql);
    }
    
}

if($type == "update") { 
    $postdeger = "minadet"; if(empty(postAl($postdeger))) { $minadet = 0; } else {  $minadet =  postAl($postdeger); }
    $postdeger = "yuzde"; if(empty(postAl($postdeger))) { $yuzde = "0.00"; } else {  $yuzde =  postAl($postdeger); }
    $postdeger = "idsi"; if(empty(postAl($postdeger))) { $idsi = 0; } else {  $idsi =  postAl($postdeger); }

    $kistas = "`id` = '$idsi' && `hammadde` =  '$hammadde' && `tur` =  '$tur'";
    $varmi = VarmiKontrol($dataAdi, $kistas);

    if($varmi == 0) {
        $result = array("ERR" => "Hatalı Veri", "resp" => ""); 
        echo json_encode($result);
        die();
    }

    
   
}

if($type == "del") { 
    $postdeger = "idsi"; if(empty(postAl($postdeger))) { $idsi = 0; } else {  $idsi =  postAl($postdeger); }

    if($idsi == 0) { 
        $result = array("ERR" => "Sistem Hatası", "resp" => ""); 
        echo json_encode($result);
        die();
    }

    $kistas = "`id` = '$idsi' && `hammadde` =  '$hammadde' && `tur` =  '$tur'";
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


$kistas = "`hammadde` =  '$hammadde' && `tur` =  '$tur' ORDER BY `indirim`.`minadet` ASC"; 
$queryBilgiAl = "SELECT * FROM `$dataAdi` WHERE $kistas"; 
$sonucBilgiAl = mysqli_query($baglan, $queryBilgiAl);
$response = array();
while($row = mysqli_fetch_array($sonucBilgiAl)) { 
    $satirarray = array();
    foreach ($indirimDataKolonlar as $value) {  
        $satirarray[$value] = $row[$value];  
    }
    array_push($response,$satirarray);

}

$result = array("ERR" => "", "resp" => $response); 
    echo json_encode($result);
    die();

?>
<?php
ob_start();
session_start();
include("../ekler/fonksiyonlar.php");
include("../ekler/baglan.php");

$dataAdi = "sepet";

$sepetDataKolonlar = array('id', 'kullanici', 'urun', 'adet', 'duzmaliyet', 'grckmlyt', 'tplmbdel', 'tur', 'bag', 'drm', 'alverno');
$sepetDataKolonOlculer = array('int', 'int', 'int', 'int', 'dcml', 'dcml', 'dcml', 'int', 'int', 'int', 'varc');
sqlDurumuBak($dataAdi, $sepetDataKolonlar, $sepetDataKolonOlculer); 
if(isset($_SESSION['user']))
    {
        $userID = $_SESSION['user'];
        $userYetki = NULL;	
                
    } else {  
        $result = array("ERR" => "Oturum Açınız", "resp" => ""); 
        echo json_encode($result);
        die();
    }

function sepetIndirimHesap($user){ 
    include("../ekler/baglan.php");
        $kistas = "`kullanici` = '$user' && `alverno` =  '' && `tur` =  '1'";
        $queryBilgiAl = "SELECT * FROM `sepet` WHERE $kistas"; 
		$sonucBilgiAl = mysqli_query($baglan, $queryBilgiAl);
		while($row = mysqli_fetch_array($sonucBilgiAl)) { 
            $sptStrIdsi = $row["id"];
            $urunIdsi = $row["urun"];
            $urunAdet = $row["adet"];
            $kistasUrn = "`id` = '$urunIdsi' && `drm` =  '1'";
            $urnVarmi = VarmiKontrol("urunler", $kistasUrn);
            if($urnVarmi == 0) { 
                $sql = "UPDATE `sepet` SET `adet` = '0' WHERE `sepet`.`id` = '$sptStrIdsi';";
                $baglan->query($sql);  
            } else {
                $urunArry = bilgiGetirArray("urunler",$kistasUrn);
                $urnMaliyet = $urunArry["maliyet"];
                $urnIndirim = 0;
                $kistaIndirim = "`hammadde` = '$urunIdsi' && `minadet` <=  '$urunAdet' && `tur` =  '1' && `drm` =  '1'";
                $indirimVarmi = VarmiKontrol("indirim", $kistaIndirim);
                if($indirimVarmi > 0) {
                    $kistaIndirim = $kistaIndirim."  ORDER BY `indirim`.`minadet` DESC";
                    $indirimArray = bilgiGetirArray("indirim", $kistaIndirim);
                    $urnIndirim = $indirimArray["yuzde"];
                }
                $regularTtl = $urunAdet * $urnMaliyet;
                $discountTtl = $regularTtl - ($regularTtl*$urnIndirim/100);
                $sql = "UPDATE `sepet` SET `duzmaliyet` = '$regularTtl', `grckmlyt` = '$discountTtl', `tplmbdel` = '$discountTtl' WHERE `sepet`.`id` = '$sptStrIdsi';";
                $baglan->query($sql);
            }        
        }
        $sonucBilgiAl->close();
        $ktgriArry = array();
        $ktgriIDArry = array();
        $adetArry = array();
        $kistas = "`kullanici` = '$user' && `alverno` =  '' && `tur` =  '2' && `bag` =  '0'";
        $queryBilgiAl = "SELECT * FROM `sepet` WHERE $kistas"; 
		$sonucBilgiAl = mysqli_query($baglan, $queryBilgiAl); 
		while($row = mysqli_fetch_array($sonucBilgiAl)) { 
            $sptStrIdsi = $row["id"];
            $urunIdsi = $row["urun"];
            $urunAdet = $row["adet"];
            $kistasUrn = "`id` = '$urunIdsi' && `drm` =  '1'";
            $urnVarmi = VarmiKontrol("kategoriler", $kistasUrn); 
            if($urnVarmi == 0) { 
                $sql = "UPDATE `sepet` SET `adet` = '0' WHERE `sepet`.`id` = '$sptStrIdsi';";
                $baglan->query($sql);  
                $sql = "UPDATE `sepet` SET `adet` = '0' WHERE `sepet`.`bag` = '$sptStrIdsi';";
                $baglan->query($sql);  
            } else { 
                array_push($ktgriArry,$urunIdsi);
                array_push($adetArry,$urunAdet);
                array_push($ktgriIDArry,$sptStrIdsi);
            }
        }
        $sonucBilgiAl->close();

        foreach ($ktgriArry as $key => $value) {
           $anaAdet = $adetArry[$key];
           $kistas = "`kullanici` = '$user' && `alverno` =  '' && `tur` =  '2' && `bag` =  '$ktgriIDArry[$key]'"; 
           $queryBilgiAl = "SELECT * FROM `sepet` WHERE $kistas"; 
           $sonucBilgiAl = mysqli_query($baglan, $queryBilgiAl);
           while($row = mysqli_fetch_array($sonucBilgiAl)) { 
                $sptStrIdsi = $row["id"];
                $urunIdsi = $row["urun"];
                $urunAdet = $row["adet"];
                $kistasUrn = "`id` = '$urunIdsi' && `kategori` =  '$value' && `drm` =  '1'";
                $urnVarmi = VarmiKontrol("hammadde", $kistasUrn);
                if($urnVarmi == 0) { 
                    $sql = "UPDATE `sepet` SET `adet` = '0' WHERE `sepet`.`id` = '$sptStrIdsi';";
                    $baglan->query($sql);  
                } else { 
                    $urunArry = bilgiGetirArray("hammadde",$kistasUrn);
                    $urnMaliyet = $urunArry["maliyet"];
                    $hesapAdet = $anaAdet * $urunAdet;
                    $urnIndirim = 0;
                    $kistaIndirim = "`hammadde` = '$urunIdsi' && `minadet` <=  '$hesapAdet' && `tur` =  '2' && `drm` =  '1'";
                    $indirimVarmi = VarmiKontrol("indirim", $kistaIndirim);
                    if($indirimVarmi > 0) {
                        $kistaIndirim = $kistaIndirim."  ORDER BY `indirim`.`minadet` DESC";
                        $indirimArray = bilgiGetirArray("indirim", $kistaIndirim);
                        $urnIndirim = $indirimArray["yuzde"];
                    }
                    $regularTtl = round($hesapAdet * $urnMaliyet,2); 
                    $discountTtl = round($regularTtl - ($regularTtl*$urnIndirim/100),2);
                    $grcjTtl = $urunAdet * $urnMaliyet;
                    $sql = "UPDATE `sepet` SET `duzmaliyet` = '$regularTtl', `grckmlyt` = '$grcjTtl', `tplmbdel` = '$discountTtl' WHERE `sepet`.`id` = '$sptStrIdsi';";
                    $baglan->query($sql);
                }
                
           }
           $sonucBilgiAl->close();

        }

         $sql = "DELETE FROM `sepet` WHERE `sepet`.`adet` = '0'";
         $baglan->query($sql);
         foreach ($ktgriIDArry as $key => $value) { 
            $kistasSepetVarmi = "`bag` = '$value'  && `alverno` =  ''";
            $hammaddeVarmi = VarmiKontrol("sepet", $kistasSepetVarmi);
            if($hammaddeVarmi == 0) { 
                $sql = "DELETE FROM `sepet` WHERE `sepet`.`id` = '$value'";
                $baglan->query($sql);
            }
         }
}

$postdeger = "type"; if(empty(postAl($postdeger))) { $type = NULL; } else {  $type =  postAl($postdeger); }

if($type == "doPayment"){
        $length = 2;
        $checkFirst = substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnoprstuvwxyz', ceil($length/strlen($x)) )),1,$length);
        $checkEnd = substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnoprstuvwxyz', ceil($length/strlen($x)) )),1,$length);
        $alverNo = $checkFirst.date("ymdhis").$checkEnd;
        $kistas = "`kullanici` = '$userID'  && `alverno` =  ''";
        $sql = "UPDATE `sepet` SET `alverno` = '$alverNo' WHERE $kistas";
        $baglan->query($sql);
}

if($type == "lineUptade") {
    $postdeger = "lineId"; if(empty(postAl($postdeger))) { $idsi = 0; } else {  $idsi =  postAl($postdeger); } 
    $postdeger = "tur"; if(empty(postAl($postdeger))) { $tur = NULL; } else {  $tur =  postAl($postdeger); } 
    $kistas = "`id` = '$idsi'  && `kullanici` = '$userID'  && `alverno` =  ''";
    $varmi = VarmiKontrol("sepet", $kistas);
    if($varmi > 0) { 
        $satirAryi = bilgiGetirArray("sepet",$kistas);
        $eskiAdet = $satirAryi["adet"];
        $yeniAdet = $eskiAdet;
        if($tur == "minus") { $yeniAdet = $eskiAdet - 1; }
        if($tur == "plus") { $yeniAdet = $eskiAdet + 1; }
        $sql = "UPDATE `sepet` SET `adet` = $yeniAdet WHERE `sepet`.`id` = '$idsi';";
        $baglan->query($sql);
    }

 }

if($type == "updtLine") {
    $postdeger = "lineId"; if(empty(postAl($postdeger))) { $idsi = 0; } else {  $idsi =  postAl($postdeger); } 
    $kistas = "`id` = '$idsi'  && `kullanici` = '$userID'  && `alverno` =  ''";
    $varmi = VarmiKontrol("sepet", $kistas);
    if($varmi > 0) {
        $sql = "UPDATE `sepet` SET `adet` = '0' WHERE `sepet`.`id` = '$idsi';";
        $baglan->query($sql);
        $sql = "UPDATE `sepet` SET `adet` = '0' WHERE `sepet`.`bag` = '$idsi';";
        $baglan->query($sql);
    }
}
if($type == "addTklf") {
    $postdeger = "kullanici"; if(empty(postAl($postdeger))) { $kullanici = 0; } else {  $kullanici =  postAl($postdeger); }
    $postdeger = "urun"; if(empty(postAl($postdeger))) { $urun = 0; } else {  $urun =  postAl($postdeger); }
    $postdeger = "adet"; if(empty(postAl($postdeger))) { $adet = 0; } else {  $adet =  postAl($postdeger); }
    $postdeger = "duzmaliyet"; if(empty(postAl($postdeger))) { $duzmaliyet = "0.00"; } else {  $duzmaliyet =  postAl($postdeger); }
    $postdeger = "grckmlyt"; if(empty(postAl($postdeger))) { $grckmlyt = "0.00"; } else {  $grckmlyt =  postAl($postdeger); }
    $postdeger = "tplmbdel"; if(empty(postAl($postdeger))) { $tplmbdel = "0.00"; } else {  $tplmbdel =  postAl($postdeger); }
    $postdeger = "tur"; if(empty(postAl($postdeger))) { $tur = 0; } else {  $tur =  postAl($postdeger); }
    $postdeger = "bag"; if(empty(postAl($postdeger))) { $bag = 0; } else {  $bag =  postAl($postdeger); }
    $postdeger = "drm"; if(empty(postAl($postdeger))) { $drm = 0; } else {  $drm =  postAl($postdeger); }
    $postdeger = "alverno"; if(empty(postAl($postdeger))) { $alverno = NULL; } else {  $alverno =  postAl($postdeger); }

    $postdeger = "idler"; if(empty(postAl($postdeger))) { $idler = NULL; } else {  $idler =  postAl($postdeger); }
    $postdeger = "adetler"; if(empty(postAl($postdeger))) { $adetler = NULL; } else {  $adetler =  postAl($postdeger); }
    $postdeger = "grckadet"; if(empty(postAl($postdeger))) { $grckAdet = 0; } else {  $grckAdet =  postAl($postdeger); }
    $postdeger = "ktgrsi"; if(empty(postAl($postdeger))) { $ktgrsi = 0; } else {  $ktgrsi =  postAl($postdeger); }
    $kistas = "`id` = '$ktgrsi' && `drm` =  '1'"; 
    $varmi = VarmiKontrol("kategoriler", $kistas);
    if($varmi == 0) {
        $result = array("ERR" => "Gecersiz Kategori Kodu, Sayfayı Yenileyiniz", "resp" => ""); 
        echo json_encode($result);
        die();
    }

    $adetlerArry = array();
    $idlerArry = array();
    $arrySay = substr_count($adetler,",");
    $adetExpl = explode(",", $adetler);
    $idsiExpl = explode(",", $idler);
    for ($i=0; $i <= $arrySay ; $i++) { 
        $adetlerArry[$i] = $adetExpl[$i];
        $idlerArry[$i] = $idsiExpl[$i];
    }
    $kntrl = 0; 
    foreach ($adetlerArry as $key => $value) {
        if($value > 0) {
            $kntrl++; 
            $hammddeIDsi = $idlerArry[$key];
            $kistas = "`id` = '$hammddeIDsi' && `kategori` = '$ktgrsi' && `drm` =  '1'"; 
            $varmi = VarmiKontrol("hammadde", $kistas);
            if($varmi == 0) { 
               $result = array("ERR" => "Gecersiz Hammadde Kodu, Sayfayı Yenileyiniz", "resp" => ""); 
                echo json_encode($result);
                die();
                break;
            }

        }
    }

    if($kntrl == 0) {
        $result = array("ERR" => "Hesap Yapılacak Hammadde Girişi Eksik. En Az Bir Adet Hammadde Miktarı Giriniz", "resp" => ""); 
            echo json_encode($result);
            die();
    }  
    $duzmaliyet = 0;   $grckmlyt = 0;  $tplmbdel = 0;
    $kullanici = $userID; $adet = $grckAdet; $urun = $ktgrsi; $tur = 2; $bag = 0; $drm = 1; $alverno = NULL;
    $sepetSaveValues = "NULL, '$kullanici', '$urun', '$adet', '$duzmaliyet', '$grckmlyt', '$tplmbdel', '$tur', '$bag', '$drm', '$alverno'";
    $columns = implode(", ",$sepetDataKolonlar);
    $sql = "INSERT INTO `$dataAdi`  ($columns)VALUES($sepetSaveValues)";
    $baglan->query($sql);
    $kistas = "`kullanici` =  '$userID' && `urun` =  '$urun' && `alverno` =  ''  ORDER BY `sepet`.`id` DESC"; 
    $ktgrStrArry = bilgiGetirArray("sepet",$kistas);
    $bag = $ktgrStrArry["id"];
    foreach ($adetlerArry as $key => $value) {
        if($value > 0) { 
            $hammddeIDsi = $idlerArry[$key];
            $sepetSaveValues = "NULL, '$kullanici', '$hammddeIDsi', '$value', '$duzmaliyet', '$grckmlyt', '$tplmbdel', '$tur', '$bag', '$drm', '$alverno'";
            $columns = implode(", ",$sepetDataKolonlar);
            $sql = "INSERT INTO `$dataAdi`  ($columns)VALUES($sepetSaveValues)";
            $baglan->query($sql);
            
        }
    }



}

if($type == "AddLine") {
    $postdeger = "urun"; if(empty(postAl($postdeger))) { $urun = 0; } else {  $urun =  postAl($postdeger); }
    $kistasUrn = "`id` =  '$urun' && `drm` =  '1'"; 
    $varmi = VarmiKontrol("urunler", $kistasUrn);
    if($varmi == 0) {
        $result = array("ERR" => "Gecersiz Ürün Kodu, Sayfayı Yenileyiniz", "resp" => ""); 
            echo json_encode($result);
            die();
    }
    $urunArry = bilgiGetirArray("urunler",$kistasUrn);
    $kistas = "`kullanici` =  '$userID' && `urun` =  '$urun' && `alverno` =  ''  && `tur` =  '1'"; 
    $varmi = VarmiKontrol($dataAdi, $kistas);
    if($varmi == 0) {
    $maliyet = $urunArry["maliyet"];
    $duzmaliyet = $maliyet;   $grckmlyt = $maliyet;  $tplmbdel = $maliyet;
    $kullanici = $userID; $adet = 1; $tur = 1; $bag = 0; $drm = 1; $alverno = NULL;
    $sepetSaveValues = "NULL, '$kullanici', '$urun', '$adet', '$duzmaliyet', '$grckmlyt', '$tplmbdel', '$tur', '$bag', '$drm', '$alverno'";
    $columns = implode(", ",$sepetDataKolonlar);
    $sql = "INSERT INTO `$dataAdi`  ($columns)VALUES($sepetSaveValues)";
    $baglan->query($sql);
    } else {
        $maliyet = $urunArry["maliyet"];
        $strArry = bilgiGetirArray($dataAdi,$kistas);
        $oncekiAdet = $strArry["adet"];
        $strID = $strArry["id"];
        $adet = $oncekiAdet + 1;

        $indirim = 0; 
        $kistas = "`hammadde` =  '$urun' && `tur` =  '1' && `drm` =  '1' && `yuzde` >  '0' && `minadet` <=  '$adet'"; 
        $varmi = VarmiKontrol("indirim", $kistas);
        if($varmi != 0) {
            $kistas = $kistas." ORDER BY `indirim`.`yuzde` DESC";
            $indrmArry = bilgiGetirArray("indirim",$kistas);
            $indirim =  $indrmArry["yuzde"];
        }

        $duzmaliyet = $adet * $maliyet;   $grckmlyt = $adet *  $maliyet;  $tplmbdel = $adet *  $maliyet;
        $grckmlyt = $grckmlyt - ($grckmlyt * $indirim / 100); 
        $tplmbdel = $tplmbdel - ($tplmbdel * $indirim / 100); 
        $sql = "UPDATE `$dataAdi` SET `adet` = '$adet', `duzmaliyet` = '$duzmaliyet', `grckmlyt` = '$grckmlyt', `tplmbdel` = '$tplmbdel' WHERE `$dataAdi`.`id` = '$strID';";
        $baglan->query($sql);
    }
	

    
}

if($type == "getTeklif"){
    $postdeger = "idler"; if(empty(postAl($postdeger))) { $idler = NULL; } else {  $idler =  postAl($postdeger); }
    $postdeger = "adetler"; if(empty(postAl($postdeger))) { $adetler = NULL; } else {  $adetler =  postAl($postdeger); }
    $postdeger = "grckAdet"; if(empty(postAl($postdeger))) { $grckAdet = 0; } else {  $grckAdet =  postAl($postdeger); }
    $postdeger = "urunAdi"; if(empty(postAl($postdeger))) { $urunAdi = NULL; } else {  $urunAdi =  postAl($postdeger); }
    $adetlerArry = array();
    $idlerArry = array();
    $arrySay = substr_count($adetler,",");
    $adetExpl = explode(",", $adetler);
    $idsiExpl = explode(",", $idler);
    for ($i=0; $i <= $arrySay ; $i++) { 
        $adetlerArry[$i] = $adetExpl[$i];
        $idlerArry[$i] = $idsiExpl[$i];
    }
    
    if($grckAdet == 0){
        $result = array("ERR" => "Kategori Adet Bildiriniz", "resp" => ""); 
            echo json_encode($result);
            die();
    }
        $teklifimizDuz = 0; 
        $teklifBedel = 0;
        $teklifKazanc = 0;
        $kntrl = 0; 
    foreach ($adetlerArry as $key => $value) {
        if($value > 0) {
           $kntrl++;
            $sqlIdsi = $idlerArry[$key];
            $kistas = "`id` =  '$sqlIdsi'"; 
            $hesapAdet = $value*$grckAdet;
            $hmmdeArry = bilgiGetirArray("hammadde",$kistas);
            $bedelDuz = $value*$grckAdet*$hmmdeArry["maliyet"];
            $kistas = "`hammadde` =  '$sqlIdsi' && `tur` =  '2' && `drm` =  '1' && `yuzde` >  '0' && `minadet` <=  '$hesapAdet'"; 
            $indirim = 0;
            $varmi = VarmiKontrol("indirim", $kistas);
            if($varmi != 0) {
                $kistas = $kistas." ORDER BY `indirim`.`yuzde` DESC";
                $indrmArry = bilgiGetirArray("indirim",$kistas);
                $indirim =  $indrmArry["yuzde"];
            }
            $bedelIndrm = $bedelDuz - ($bedelDuz * $indirim / 100); 
            $teklifimizDuz = $teklifimizDuz + $bedelDuz;
            $teklifBedel  = $teklifBedel + $bedelIndrm;
            $fark = $bedelDuz - $bedelIndrm;
            $teklifKazanc = $teklifKazanc + $fark;
        }
    }
    if($kntrl == 0) { 
        $result = array("ERR" => "Hesap Yapılacak Hammadde Girişi Eksik. En Az Bir Adet Hammadde Miktarı Giriniz", "resp" => ""); 
            echo json_encode($result);
            die();
    }

    $sonuc  = $grckAdet." Adet ".$urunAdi." için talep ettiğiniz materyallerle birlikte teklifimiz : ".$teklifBedel." TL dir.<br>Talebiniz indirimsiz Bedeli : ".$teklifimizDuz." TL<br> Kazancınız : ".$teklifKazanc." TL";
    $sonuc = $sonuc.'<br><button type="button"  id="kndnYapSptEkle" class="btn btn-danger">Sepete Ekle</button>';
    $result = array("ERR" => "", "resp" => $sonuc); 
    echo json_encode($result);
    die();
}
if($type == "getHammade") {
    if(!isset($_SESSION['user']))
    { 
        $result = array("ERR" => "Oturum Açmalısınız", "resp" => ""); 
        echo json_encode($result);
        die();
    } 
    $postdeger = "hammadde"; if(empty(postAl($postdeger))) { $hammadde = 0; } else {  $hammadde =  postAl($postdeger); }
    $postdeger = "adet"; if(empty(postAl($postdeger))) { $adet = 0; } else {  $adet =  postAl($postdeger); }

    if($adet == 0){ 
        $result = array("ERR" => "Adet Bildiriniz", "resp" => ""); 
        echo json_encode($result);
        die();
    }

    $kistas = "`id` = '$hammadde'";
    $varmi = VarmiKontrol("kategoriler", $kistas);
    if($varmi == 0) {
        $result = array("ERR" => "Kategori Seçimi Yapınız", "resp" => ""); 
        echo json_encode($result);
        die();
    }

    $kistas = "`kategori` =  '$hammadde' && `drm` =  '1'"; 
    $queryBilgiAl = "SELECT * FROM `hammadde` WHERE $kistas"; 
    $sonucBilgiAl = mysqli_query($baglan, $queryBilgiAl);
    $response = array();
    while($row = mysqli_fetch_array($sonucBilgiAl)) { 
        $satirarray = array();
        $satirarray["id"] = $row["id"];
        $satirarray["adi"] = $row["adi"];
        $satirarray["maliyet"] = $row["maliyet"];
        array_push($response,$satirarray);

}

$result = array("ERR" => "", "resp" => $response); 
    echo json_encode($result);
    die();


}

sepetIndirimHesap($userID);
$kistas = "`kullanici` =  '$userID' && `alverno` =  '' && `tur` =  '1'";
        $sptDtyArryNrml = array();
        $resimArray = array();
        $isimArray = array();
        $kodArray = array();
        $indirimsizTplm = 0;
        $tplmBedel = 0;
        $queryBilgiAl = "SELECT * FROM `$dataAdi` WHERE $kistas"; 
        $sonucBilgiAl = mysqli_query($baglan, $queryBilgiAl);
        while($row = mysqli_fetch_array($sonucBilgiAl)) { 
            $satirarray = array();
            foreach ($sepetDataKolonlar as $value) {  
                $satirarray[$value] = $row[$value];  
                
            }
            $urnIDsi = $row["urun"];
            $kistasUrn = "`id` =  '$urnIDsi'";
            $urnDtyArray = bilgiGetirArray("urunler",$kistasUrn);
            $resim = "noImage.png";
            if(!empty($urnDtyArray["resim"])) { $resim = $urnDtyArray["resim"]; }
            array_push($sptDtyArryNrml,$satirarray);
            array_push($resimArray,$resim); 
            array_push($isimArray, $urnDtyArray["adi"]); 
        
        }
        $sonucBilgiAl->close();
        //$indirimsizTplm = getSubTotal("sepet",$kistas,"duzmaliyet");

        $kistas = "`kullanici` =  '$userID' && `alverno` =  '' && `tur` =  '2' && `bag` =  '0'";
        $queryBilgiAl = "SELECT * FROM `$dataAdi` WHERE $kistas"; 
        $kndnYpKtgrDtyArry = array();
        $kndnYpresimArray = array();
        $kndnYpisimArray = array();
        $kndnYapToplamTtr = 0; 
        $kndnYapToplamTtrIndrmsiz = 0; 
        $sonucBilgiAl = mysqli_query($baglan, $queryBilgiAl);
        while($row = mysqli_fetch_array($sonucBilgiAl)) { 
            $satirarray = array();
            foreach ($sepetDataKolonlar as $value) {  
                $satirarray[$value] = $row[$value];  
                
            }
            $urnIDsi = $row["urun"];
            $kistasUrn = "`id` =  '$urnIDsi'";
            $urnDtyArray = bilgiGetirArray("kategoriler",$kistasUrn);
            $resim = "noImage.png";
            array_push($kndnYpKtgrDtyArry,$satirarray);
            array_push($kndnYpresimArray,$resim); 
            array_push($kndnYpisimArray, $urnDtyArray["name"]); 
        
        }
        $sonucBilgiAl->close();
        $kndnYapAltStrArry = array();
        $kndnYapAltStrRsmArry = array();
        $kndnYapAltStrIsimArry = array();
        foreach ($kndnYpKtgrDtyArry as $key => $value) {
            $ktgrIdsi = $kndnYpKtgrDtyArry[$key]["id"];
            $kistas = "`kullanici` =  '$userID' && `alverno` =  '' && `tur` =  '2' && `bag` =  '$ktgrIdsi'";
            $kndnYapAltStrArry[$ktgrIdsi] = array();
            $queryBilgiAl = "SELECT * FROM `$dataAdi` WHERE $kistas"; 
            $sonucBilgiAl = mysqli_query($baglan, $queryBilgiAl);
            while($row = mysqli_fetch_array($sonucBilgiAl)) { 
                $satirarray = array();
                foreach ($sepetDataKolonlar as $value) {  
                    $satirarray[$value] = $row[$value];  
                    
                }
                $urnIDsi = $row["urun"];
                $kndnYapAltStrIsimArry[$urnIDsi] = array();
                $kistasUrn = "`id` =  '$urnIDsi'";
                $urnDtyArray = bilgiGetirArray("hammadde",$kistasUrn);
                $resim = "noImage.png";
                
                array_push($kndnYapAltStrArry[$ktgrIdsi],$satirarray);
                array_push($kndnYapAltStrRsmArry,$resim); 
                array_push($kndnYapAltStrIsimArry[$urnIDsi], $urnDtyArray["adi"]); 
            }
            $sonucBilgiAl->close();
            
        }
        $kistas = "`kullanici` =  '$userID' && `alverno` =  ''";
        $sptTplm = getSubTotal("sepet",$kistas,"tplmbdel");
        $indirimsizTplm = getSubTotal("sepet",$kistas,"duzmaliyet");

        $result = array("ERR" => "", 
        "sptTplm" => $sptTplm,
        "sptDtyArryNrml" => $sptDtyArryNrml, 
        "resimArrayNrml" => $resimArray, 
        "isimArray" => $isimArray, 
        "indirimsiz" => $indirimsizTplm, 
        "kndnYpKtgrDtyArry" => $kndnYpKtgrDtyArry, 
        "kndnYpresimArray" => $kndnYpresimArray, 
        "kndnYpisimArray" => $kndnYpisimArray, 
        "kndnYapAltStrArry" => $kndnYapAltStrArry, 
        "kndnYapAltStrRsmArry" => $kndnYapAltStrRsmArry, 
        "kndnYapAltStrIsimArry" => $kndnYapAltStrIsimArry, 
        "kodArray" => $kodArray); 
        echo json_encode($result);
        die();

       



?>
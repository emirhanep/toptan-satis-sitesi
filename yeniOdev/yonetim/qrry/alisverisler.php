<?php
include("../ekler/fonksiyonlar.php");
include("../ekler/baglan.php");
$postdeger = "alverno"; if(empty(postAl($postdeger))) { $alverno = 0; } else {  $alverno =  postAl($postdeger); }
if($alverno == 0){
    $result = array("ERR" => "Hatalı Veri", "resp" => ""); 
        echo json_encode($result);
        die();
}
$dataAdi = "sepet";
$sepetDataKolonlar = array('id', 'kullanici', 'urun', 'adet', 'duzmaliyet', 'grckmlyt', 'tplmbdel', 'tur', 'bag', 'drm', 'alverno');
$kistas = "`alverno` =  '$alverno' && `tur` =  '1'";
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

        $kistas = "`alverno` =  '$alverno' && `tur` =  '2' && `bag` =  '0'";
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
            $kistas = "`alverno` =  '$alverno' && `tur` =  '2' && `bag` =  '$ktgrIdsi'";
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
        $kistas = "`alverno` =  '$alverno'";
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

        $result = array("ERR" => "", "resp" => $response); 
        echo json_encode($result);
        die();

?>
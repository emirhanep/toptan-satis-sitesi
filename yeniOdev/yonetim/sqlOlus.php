<?php
include("ekler/baglan.php");
include("ekler/fonksiyonlar.php");

$dataAdi = "sepet";

$sepetDataKolonlar = array('id', 'kullanici', 'urun', 'adet', 'duzmaliyet', 'grckmlyt', 'tplmbdel', 'tur', 'bag', 'drm', 'alverno');
$sepetDataKolonOlculer = array('int', 'int', 'int', 'int', 'dcml', 'dcml', 'dcml', 'int', 'int', 'int', 'varc');
sqlDurumuBak($dataAdi, $sepetDataKolonlar, $sepetDataKolonOlculer); 

$dataAdi = "hammadde";


$hammaddeDataKolonlar = array('id', 'kategori', 'adi', 'maliyet', 'drm');
$hammaddeDataKolonOlculer = array('int', 'int', 'varc', 'dcml', 'int');

sqlDurumuBak($dataAdi, $hammaddeDataKolonlar, $hammaddeDataKolonOlculer);

$dataAdi = "indirim";

$indirimDataKolonlar = array('id', 'hammadde', 'minadet', 'yuzde', 'tur', 'drm');
$indirimDataKolonOlculer = array('int', 'int', 'int', 'dcml', 'int', 'int');
sqlDurumuBak($dataAdi, $indirimDataKolonlar, $indirimDataKolonOlculer);

$dataAdi = "kategoriler";


$kategorilerDataKolonlar = array('id', 'name', 'drm');
$kategorilerDataKolonOlculer = array('int', 'varc', 'int');

sqlDurumuBak($dataAdi, $kategorilerDataKolonlar, $kategorilerDataKolonOlculer);

$dataAdi = "urunler";

$urunlerDataKolonlar = array('id', 'adi', 'maliyet', 'resim', 'tanim', 'drm');
$urunlerDataKolonOlculer = array('int', 'varc', 'dcml', 'varc', 'lng', 'int');
sqlDurumuBak($dataAdi, $urunlerDataKolonlar, $urunlerDataKolonOlculer);


$dataAdi = "kullanici";

$kullaniciDataKolonlar = array('id', 'isim', 'soyad', 'mail', 'sifre', 'tel', 'tarih', 'ip', 'yetki', 'durum');
$kullaniciDataKolonOlculer = array('int', 'varc', 'varc', 'varc', 'varc', 'varc', 'dtme', 'varc', 'int', 'int');
sqlDurumuBak($dataAdi, $kullaniciDataKolonlar, $kullaniciDataKolonOlculer);


?>
<?php
require 'connect.php';
require 'functions.php';

function kullaniciAdiVarMi($kullaniciAdi)
{
    global $dbh;
    $sql = $dbh->prepare("SELECT COUNT(*) FROM users WHERE username = ?");
    $sql->execute([$kullaniciAdi]);
    $result = $sql->fetchColumn();

    return ($result > 0);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Form verilerini al
    $ad = $_POST['ad'];
    $soyad = $_POST['soyad'];
    $globalAd = userName($ad);
    $globalSoyad = userName($soyad);
    $kullaniciAdi = strtolower($globalAd) . strtolower($globalSoyad);
    $kullaniciAdiOriginal = $kullaniciAdi; 

    $counter = 0;
    while (kullaniciAdiVarMi($kullaniciAdi)) {
        $counter++;
        $kullaniciAdi = $kullaniciAdiOriginal . $counter;
    }
    echo $kullaniciAdi;
}
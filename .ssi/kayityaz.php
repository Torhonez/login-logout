<?php
require_once 'connect.php';
require_once 'functions.php';

$name = $_POST["ad"];
$surname = $_POST["soyad"];
$email = $_POST["email"];
$isActive = $_POST["isActive"];



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
}

function kullaniciAdiVarMi($kullaniciAdi) {
    global $dbh;
    $sql = $dbh->prepare("SELECT COUNT(*) FROM users WHERE username = ?");
    $sql->execute([$kullaniciAdi]);
    $result = $sql->fetchColumn();

    return ($result > 0);
}
    // şifreyi hashliyoruz
    $sifre = password_hash($kullaniciAdi, PASSWORD_DEFAULT);
    // kodu oluşturuyoruz
    $code = md5(microtime());

    $sql2 = $dbh->prepare("INSERT INTO users (username, email, name, surname, password, code, isActive) VALUES (?,?,?,?,?,?,?)");

    if ($sql2->execute(array($kullaniciAdi, $email, $name, $surname, $sifre, $code, $isActive))) {
        echo true;
    } else {
        echo false;
    }
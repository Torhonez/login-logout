<?php
$page_title = "Kullanıcı Tanımlama";
$pageid = 2;
//require connect.php
require_once 'connect.php';
require_once 'functions.php';

//require head.php
require_once 'parts/head.php';
?>

<body>
    <?php
    //require headertop.php
    require_once 'parts/headertop.php';
    //require adminheader.php
    if ($admin) {
        require_once 'parts/adminheader.php';
    } else if ($bayiadmin) {
        require_once 'parts/adminheader.php';
    }
    ?>
    <div class="page-wrapper">
        <!-- Page header -->
        <div class="page-header d-print-none">
            <div class="container-xl">
                <div class="row g-2 align-items-center">
                    <div class="col">
                        <h2 class="page-title">
                            <?php echo $page_title; ?>
                        </h2>
                        <form action="" method="post" id="kullaniciekle">
                            <fieldset class="form-fieldset mt-3">
                                <label class="form-label required">Bayi</label>
                                <select id="bayiselect" name="bayi" class="form-select mb-3"
                                    aria-label="Default select example">
                                    <option selected>Atanacak Bayi Seçiniz.</option>
                                    <?php
                                    $sql = $dbh->prepare("SELECT cari_id, unvan FROM cari");
                                    $sql->execute();
                                    while ($row = $sql->fetch()) {
                                        echo "<option value='" . $row['cari_id'] . "'>" . $row['unvan'] . "</option>";
                                    }
                                    ?>

                                </select>
                                <div class="mb-3">
                                    <label class="form-label required">Adı</label>
                                    <input type="text" id="ad" name="ad" onkeyup='kullaniciAdi()' class="form-control"
                                        autocomplete="off" />
                                </div>
                                <div class="mb-3">
                                    <label class="form-label required">Soyadı</label>
                                    <input type="text" id="soyad" onkeyup='kullaniciAdi()' name="soyad"
                                        class="form-control" autocomplete="off" />
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Kullanıcı Adı</label>
                                    <input type="text" id="username" name="username" class="form-control" readonly
                                        value="" />
                                </div>
                                <input type="hidden" name="isActive" class="form-control" value="1">
                                <div class="mb-3">
                                    <label class="form-label">E-Posta</label>
                                    <input type="email" id="email" name="email" class="form-control"
                                        autocomplete="off" />
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Telefon <small>(SMS Gönderimi İçin
                                            Gereklidir!)</small></label>
                                    <input type="tel" id="telefon" name="telefon" class="form-control"
                                        data-mask="(000) 000 00 00" data-mask-visible="true"
                                        placeholder="(000) 000 00 00" autocomplete="off" />
                                </div>
                                <div class="mb-3 text-center">
                                    <button type="submit" class="btn btn-lg btn-primary rounded-pill">Kaydet</button>
                                </div>
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- Page body -->
        <div class="page-body">
            <div class="container-xl">
                <!-- Content here -->
            </div>
        </div>
        <?php //require footer.php
        require_once 'parts/footer.php'; ?>
    </div>
    </div>
    <!-- Libs JS -->
    <!-- Tabler Core -->
    <script src="./assets/js/octo.min.js?<?php echo time(); ?>" defer></script>
    <script src="./assets/js/color.min.js?<?php echo time(); ?>" defer></script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function () {
            // şifre oluştur
            var sifre = Math.floor(100000 + Math.random() * 900000);
            console.log(sifre);
            // Form submit butonuna tıklandığında
            $('#kullaniciekle').submit(function (e) {
                // Sayfa yenilemeyi engelle
                e.preventDefault();

                var inputBayi = document.getElementById("bayiselect").value;
                if (inputBayi === "Atanacak Bayi Seçiniz.") {
                    Swal.fire(
                        'Hata!',
                        "Lütfen formu eksiksiz doldurun! Bayi alanı boş bırakılamaz.",
                        'error'
                    )
                    return;
                }
                var inputAd = document.getElementById("ad").value;
                if (inputAd === "") {
                    Swal.fire(
                        'Hata!',
                        "Lütfen formu eksiksiz doldurun! Ad alanı boş bırakılamaz.",
                        'error'
                    )
                    return;
                }
                var inputSoyad = document.getElementById("soyad").value;
                if (inputSoyad === "") {
                    Swal.fire(
                        'Hata!',
                        "Lütfen formu eksiksiz doldurun! Soyad alanı boş bırakılamaz.",
                        'error'
                    )
                    return;
                }
                var inputEmail = document.getElementById("email").value;
                if (inputEmail === "") {
                    Swal.fire(
                        'Hata!',
                        "Lütfen formu eksiksiz doldurun! E-mail alanı boş bırakılamaz.",
                        'error'
                    )
                    return;
                }
                var inputTelefon = document.getElementById("telefon").value;
                if (inputTelefon === "") {
                    Swal.fire(
                        'Hata!',
                        "Lütfen formu eksiksiz doldurun! Telefon alanı boş bırakılamaz.",
                        'error'
                    )
                    return;
                }
                // Form verilerini al
                var formData = $("#kullaniciekle").serialize();
                formData += "&sifre=" + sifre;
                // jQuery AJAX kullanarak POST isteği gönder
                $.ajax({
                    type: "POST",
                    url: ".ssi/kullaniciekle.php",
                    data: formData,
                    success: function (response) {
                        // Başarılı yanıt durumunda burada işlemler yapabilirsiniz
                        if (response == true) {
                            Swal.fire({
                                title: 'Kayıt Tamamlandı!',
                                text: 'Kullanıcı Başarıyla Eklendi!',
                                icon: 'success',
                                confirmButtonText: 'Tamam'
                            })
                            $("#kullaniciekle")[0].reset();
                        } else {
                            Swal.fire({
                                title: 'Hata!',
                                text: 'Kullanıcı eklenirken hata oluştu!' + response,
                                icon: 'error',
                                confirmButtonText: 'Tamam'
                            })
                        }
                    },
                    error: function (error) {
                        // Hata durumunda burada işlemler yapabilirsiniz
                        console.log(error);
                    }
                });
            });
        });
        function kullaniciAdi() {
            $.post(
                ".ssi/kadi.php", {
                ad: $('#ad').val(),
                soyad: $('#soyad').val()
            },
                function (result) {
                    $("#username").val(result);
                }
            );
        }

    </script>
</body>

</html>
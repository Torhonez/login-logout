<?php
 include "./.ssi/connect.php"; 
 include "./.ssi/functions.php"; 
 ?>
<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kayıt Ol</title>
</head>
<!-- bootstrap5.3 css-->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
<!-- custom css -->
<!-- <link rel="stylesheet" href="./assets/css/style.css"> -->

<body>
    <div class="page-wrapper">
        <!-- Page header -->
        <div class="page-header d-print-none">
            <div class="container-xl">
                <div class="row g-2 align-items-center">
                    <div class="col">
                        <form action="" method="post" id="kullaniciekle">
                            <fieldset class="form-fieldset mt-3">
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
                                    <input type="text" id="username" name="username" class="form-control"
                                        value="" />
                                </div>
                                <input type="hidden" name="isActive" class="form-control" value="1"/>
                                <div class="mb-3">
                                    <label class="form-label">E-Posta</label>
                                    <input type="email" id="email" name="email" class="form-control"
                                        autocomplete="off" />
                                </div>
                                <!-- gsm -->
                                <!-- <div class="mb-3">
                                    <label class="form-label">Telefon <small>(SMS Gönderimi İçin
                                            Gereklidir!)</small></label>
                                    <input type="tel" id="telefon" name="telefon" class="form-control"
                                        data-mask="(000) 000 00 00" data-mask-visible="true"
                                        placeholder="(000) 000 00 00" autocomplete="off" />
                                </div> -->
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
    </div>
    </div>
    <!-- Libs JS -->
    <!-- Tabler Core -->
    <!-- <script src="./assets/js/octo.min.js?<?php echo time(); ?>" defer></script>
    <script src="./assets/js/color.min.js?<?php echo time(); ?>" defer></script> -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
    <!-- jquery cdn -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
        integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
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
                // Form verilerini al
                var formData = $("#kullaniciekle").serialize();
                formData += "&sifre=" + sifre;
                // jQuery AJAX kullanarak POST isteği gönder
                $.ajax({
                    type: "POST",
                    url: "./.ssi/kayityaz.php",
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
                "./.ssi/kadi.php", {
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
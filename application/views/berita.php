<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Info Tani - SIKeTan">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="theme-color" content="#0134d4">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <!-- The above 4 meta tags *must* come first in the head; any other head content must come *after* these tags-->
    <!-- Title-->
    <title>Info Tani - SIKeTan</title>
    <!-- Fonts-->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&amp;display=swap" rel="stylesheet">
    <!-- Favicon-->
    <link rel="icon" href="<?=base_url()?>assets/img/core-img/favicon.ico">
    <link rel="apple-touch-icon" href="<?=base_url()?>assets/img/icons/icon-96x96.png">
    <link rel="apple-touch-icon" sizes="152x152" href="<?=base_url()?>assets/img/icons/icon-152x152.png">
    <link rel="apple-touch-icon" sizes="167x167" href="<?=base_url()?>assets/img/icons/icon-167x167.png">
    <link rel="apple-touch-icon" sizes="180x180" href="<?=base_url()?>assets/img/icons/icon-180x180.png">
    <!-- CSS Libraries-->
    <link rel="stylesheet" href="<?=base_url()?>assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?=base_url()?>assets/css/animate.css">
    <link rel="stylesheet" href="<?=base_url()?>assets/css/owl.carousel.min.css">
    <link rel="stylesheet" href="<?=base_url()?>assets/css/font-awesome.min.css">
    <link rel="stylesheet" href="<?=base_url()?>assets/css/bootstrap-icons.css">
    <link rel="stylesheet" href="<?=base_url()?>assets/css/magnific-popup.css">
    <link rel="stylesheet" href="<?=base_url()?>assets/css/ion.rangeSlider.min.css">
    <link rel="stylesheet" href="<?=base_url()?>assets/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="<?=base_url()?>assets/css/apexcharts.css">
    <!-- Core Stylesheet-->
    <link rel="stylesheet" href="<?=base_url()?>assets/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.2.0/css/all.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css">
    <script src="https://cdn.ckeditor.com/ckeditor5/32.0.0/classic/ckeditor.js"></script>
  </head>
  <body>
    <!-- Preloader-->
    <div class="preloader d-flex align-items-center justify-content-center" id="preloader">
      <div class="spinner-grow text-primary" role="status">
        <div class="sr-only">Loading...</div>
      </div>
    </div>
    <!-- Internet Connection Status-->
    <div class="internet-connection-status" id="internetStatus"></div>
    <!-- Dark mode switching-->
    <div class="dark-mode-switching">
      <div class="d-flex w-100 h-100 align-items-center justify-content-center">
        <div class="dark-mode-text text-center"><svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-moon" viewBox="0 0 16 16">
<path fill-rule="evenodd" d="M14.53 10.53a7 7 0 0 1-9.058-9.058A7.003 7.003 0 0 0 8 15a7.002 7.002 0 0 0 6.53-4.47z"/>
</svg>
          <p class="mb-0">Switching to dark mode</p>
        </div>
        <div class="light-mode-text text-center"><svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-brightness-high" viewBox="0 0 16 16">
<path d="M8 11a3 3 0 1 1 0-6 3 3 0 0 1 0 6zm0 1a4 4 0 1 0 0-8 4 4 0 0 0 0 8zM8 0a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-1 0v-2A.5.5 0 0 1 8 0zm0 13a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-1 0v-2A.5.5 0 0 1 8 13zm8-5a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1 0-1h2a.5.5 0 0 1 .5.5zM3 8a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1 0-1h2A.5.5 0 0 1 3 8zm10.657-5.657a.5.5 0 0 1 0 .707l-1.414 1.415a.5.5 0 1 1-.707-.708l1.414-1.414a.5.5 0 0 1 .707 0zm-9.193 9.193a.5.5 0 0 1 0 .707L3.05 13.657a.5.5 0 0 1-.707-.707l1.414-1.414a.5.5 0 0 1 .707 0zm9.193 2.121a.5.5 0 0 1-.707 0l-1.414-1.414a.5.5 0 0 1 .707-.707l1.414 1.414a.5.5 0 0 1 0 .707zM4.464 4.465a.5.5 0 0 1-.707 0L2.343 3.05a.5.5 0 1 1 .707-.707l1.414 1.414a.5.5 0 0 1 0 .708z"/>
</svg>
          <p class="mb-0">Switching to light mode</p>
        </div>
      </div>
    </div>
    <!-- RTL mode switching-->
    <div class="rtl-mode-switching">
      <div class="d-flex w-100 h-100 align-items-center justify-content-center">
        <div class="rtl-mode-text text-center"><svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-text-right" viewBox="0 0 16 16">
        <path fill-rule="evenodd" d="M6 12.5a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5zm-4-3a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 0 1h-11a.5.5 0 0 1-.5-.5zm4-3a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5zm-4-3a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 0 1h-11a.5.5 0 0 1-.5-.5z"/>
        </svg>
          <p class="mb-0">Switching to RTL mode</p>
        </div>
        <div class="ltr-mode-text text-center"><svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-text-left" viewBox="0 0 16 16">
        <path fill-rule="evenodd" d="M2 12.5a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5zm0-3a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 0 1h-11a.5.5 0 0 1-.5-.5zm0-3a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5zm0-3a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 0 1h-11a.5.5 0 0 1-.5-.5z"/>
        </svg>
          <p class="mb-0">Switching to default mode</p>
        </div>
      </div>
    </div>
    <div id="setting-popup-overlay"></div>
    <!-- Setting Popup Card-->
    <div class="card setting-popup-card shadow-lg" id="settingCard">
      <div class="card-body">           
        <div class="container">
          <div class="setting-heading d-flex align-items-center justify-content-between mb-3">
            <p class="mb-0">Settings</p><a class="btn-close" id="settingCardClose" href="#"></a>
          </div>
          <div class="single-setting-panel">
            <div class="form-check form-switch mb-2">
              <input class="form-check-input" type="checkbox" id="availabilityStatus" checked>
              <label class="form-check-label" for="availabilityStatus">Availability status</label>
            </div>
          </div>
          <div class="single-setting-panel">
            <div class="form-check form-switch mb-2">
              <input class="form-check-input" type="checkbox" id="sendMeNotifications" checked>
              <label class="form-check-label" for="sendMeNotifications">Send me notifications</label>
            </div>
          </div>
          <div class="single-setting-panel">
            <div class="form-check form-switch mb-2">
              <input class="form-check-input" type="checkbox" id="darkSwitch">
              <label class="form-check-label" for="darkSwitch">Dark mode</label>
            </div>
          </div>
          <div class="single-setting-panel">
            <div class="form-check form-switch">
              <input class="form-check-input" type="checkbox" id="rtlSwitch">
              <label class="form-check-label" for="rtlSwitch">RTL mode</label>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- Header Area-->
    <div class="header-area" id="headerArea">
      <div class="container">
        <!-- Header Content-->
        <div class="header-content position-relative d-flex align-items-center justify-content-between">
          <!-- Back Button-->
        
          <!-- Page Title-->
          <div class="page-heading">
            <h6 class="mb-0">Info Tani</h6>
          </div>
          <!-- Settings-->
          <div class="setting-wrapper"><a class="setting-trigger-btn" id="settingTriggerBtn" href="#"><svg width="18" height="18" viewBox="0 0 16 16" class="bi bi-gear" fill="url(#gradientSettings)" xmlns="http://www.w3.org/2000/svg">
            <defs>
            <linearGradient spreadMethod="pad" id="gradientSettings" x1="0%" y1="0%" x2="100%" y2="100%">
            <stop offset="0" style="stop-color: #0134d4; stop-opacity:1;"/>
            <stop offset="100%" style="stop-color: #28a745; stop-opacity:1;"/>
            </linearGradient>
            </defs>
            <path fill-rule="evenodd" d="M8.837 1.626c-.246-.835-1.428-.835-1.674 0l-.094.319A1.873 1.873 0 0 1 4.377 3.06l-.292-.16c-.764-.415-1.6.42-1.184 1.185l.159.292a1.873 1.873 0 0 1-1.115 2.692l-.319.094c-.835.246-.835 1.428 0 1.674l.319.094a1.873 1.873 0 0 1 1.115 2.693l-.16.291c-.415.764.42 1.6 1.185 1.184l.292-.159a1.873 1.873 0 0 1 2.692 1.116l.094.318c.246.835 1.428.835 1.674 0l.094-.319a1.873 1.873 0 0 1 2.693-1.115l.291.16c.764.415 1.6-.42 1.184-1.185l-.159-.291a1.873 1.873 0 0 1 1.116-2.693l.318-.094c.835-.246.835-1.428 0-1.674l-.319-.094a1.873 1.873 0 0 1-1.115-2.692l.16-.292c.415-.764-.42-1.6-1.185-1.184l-.291.159A1.873 1.873 0 0 1 8.93 1.945l-.094-.319zm-2.633-.283c.527-1.79 3.065-1.79 3.592 0l.094.319a.873.873 0 0 0 1.255.52l.292-.16c1.64-.892 3.434.901 2.54 2.541l-.159.292a.873.873 0 0 0 .52 1.255l.319.094c1.79.527 1.79 3.065 0 3.592l-.319.094a.873.873 0 0 0-.52 1.255l.16.292c.893 1.64-.902 3.434-2.541 2.54l-.292-.159a.873.873 0 0 0-1.255.52l-.094.319c-.527 1.79-3.065 1.79-3.592 0l-.094-.319a.873.873 0 0 0-1.255-.52l-.292.16c-1.64.893-3.433-.902-2.54-2.541l.159-.292a.873.873 0 0 0-.52-1.255l-.319-.094c-1.79-.527-1.79-3.065 0-3.592l.319-.094a.873.873 0 0 0 .52-1.255l-.16-.292c-.892-1.64.902-3.433 2.541-2.54l.292.159a.873.873 0 0 0 1.255-.52l.094-.319z"/>
            <path fill-rule="evenodd" d="M8 5.754a2.246 2.246 0 1 0 0 4.492 2.246 2.246 0 0 0 0-4.492zM4.754 8a3.246 3.246 0 1 1 6.492 0 3.246 3.246 0 0 1-6.492 0z"/>
            </svg><span></span></a></div>
        </div>
      </div>
    </div>

    <div id="btn_hapus_berita" class="add-new-contact-wrap">
      <a class="shadow bg-danger" data-bs-toggle="modal" data-bs-target="#ModalHapusBerita">
        <i style="font-size: 18px;" class="fa fa-trash"></i>
    </a>
    </div>

    <div class="page-content-wrapper pt-5">
      <?php foreach ($berita as $key => $value) { 
        $id_user = $value['id_user'];
        $get_users = $this->db->get_where('users', ['id_user' => $id_user])->result_array();
        if($get_users){
          $nama_penulis = $get_users[0]['nama'];
        }else{
          $nama_penulis = null;
        }
        ?>
      <div class="container pt-2">
        <div class="card position-relative shadow-sm"><img class="card-img-top" src="<?=base_url()?>upload/berita/<?=$value['tumbnail']?>" alt="">
          <div class="card-body direction-rtl">
            <h2><?=$value['judul']?></h2>
            <p><u>Penulis : <?=$nama_penulis?></u></p>
            <p><?=$value['content_berita']?></p>
          </div>
        </div>
      </div>
      <?php } ?>
    </div>

    <div class="modal fade bottom-align-modal" id="ModalHapusBerita" tabindex="-1" aria-labelledby="ModalHapusBeritaLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" id="ModalHapusBeritaLabel">Hapus Berita</h6>
                    <button class="btn btn-close p-1 ms-auto" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">  
                  <div class="form-group mt-2">
                      <a type="button" onclick="HapusBeritaGo('<?=$berita[0]['id']?>')" href="#" class="btn btn-danger w-100">Hapus Berita</a>
                  </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-sm btn-secondary" type="button" data-bs-dismiss="modal" aria-label="Close">Keluar</button>
                </div>
            </div>
        </div>
    </div>
    <script src="<?=base_url()?>assets/js/jquery.min.js"></script>

    <script>
      $( document ).ready(function() {
            GetDataUser();
        });

        let id_user = 0;

        function GetDataUser(){
            var DataUser = "";
            if (typeof(Storage) !== "undefined") {
                DataUser = localStorage.getItem("@data_user");
                if(DataUser != null){
                  id_user = JSON.parse(DataUser).id_user
                  console.log('id_user : '+ id_user);
                  $("#btn_hapus_berita").show();
                }else{
                  $("#btn_hapus_berita").hide();
                  console.log(DataUser);
                }
            }
        }

        function HapusBeritaGo(id_berita){
          window.location = '<?=base_url()?>api/berita/hapus_teks?id_berita='+id_berita + '&id_user=' + id_user
        }

        function HitungKarakterDeskripsi(){
          let panjang_deskripsi = document.getElementById('deskripsi').value;
          console.log(panjang_deskripsi.length)
          if(panjang_deskripsi.length >= 300){
            document.getElementById('info_panjang_karakter').innerHTML = "Deskripsi sudah lebih dari 300 karakter. Total saat ini " + panjang_deskripsi.length + " karakter"
          }else{
            document.getElementById('info_panjang_karakter').innerHTML = "Total " + panjang_deskripsi.length + " karakter"
          }

        }
    </script>


    <!-- All JavaScript Files-->
    <script src="<?=base_url()?>assets/js/bootstrap.bundle.min.js"></script>
    <script src="<?=base_url()?>assets/js/default/internet-status.js"></script>
    <script src="<?=base_url()?>assets/js/waypoints.min.js"></script>
    <script src="<?=base_url()?>assets/js/jquery.easing.min.js"></script>
    <script src="<?=base_url()?>assets/js/wow.min.js"></script>
    <script src="<?=base_url()?>assets/js/owl.carousel.min.js"></script>
    <script src="<?=base_url()?>assets/js/jquery.counterup.min.js"></script>
    <script src="<?=base_url()?>assets/js/jquery.countdown.min.js"></script>
    <script src="<?=base_url()?>assets/js/imagesloaded.pkgd.min.js"></script>
    <script src="<?=base_url()?>assets/js/isotope.pkgd.min.js"></script>
    <script src="<?=base_url()?>assets/js/jquery.magnific-popup.min.js"></script>
    <script src="<?=base_url()?>assets/js/default/dark-mode-switch.js"></script>
    <script src="<?=base_url()?>assets/js/ion.rangeSlider.min.js"></script>
    <script src="<?=base_url()?>assets/js/jquery.dataTables.min.js"></script>
    <script src="<?=base_url()?>assets/js/default/active.js"></script>
    <script src="<?=base_url()?>assets/js/default/clipboard.js"></script>
  </body>
</html>
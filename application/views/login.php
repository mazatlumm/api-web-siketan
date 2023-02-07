<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Login Info Tani SIKeTan">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="theme-color" content="#0134d4">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <!-- The above 4 meta tags *must* come first in the head; any other head content must come *after* these tags-->
    <!-- Title-->
    <title>Login Info Tani SIKeTan</title>
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
    <!-- Back Button-->
<path fill-rule="evenodd" d="M12 8a.5.5 0 0 1-.5.5H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5a.5.5 0 0 1 .5.5z"/>
</svg></a></div>
    <!-- Login Wrapper Area-->
    <div class="login-wrapper d-flex align-items-center justify-content-center">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-12 col-sm-9 col-md-7 col-lg-6 col-xl-5">
            
            <!-- Register Form-->
            <div class="register-form mt-4 px-4">
              <h6 class="mb-3 text-center">Log in Info Tani</h6>
              <form method="post">
                <div class="form-group">
                  <input class="form-control" id="email" type="email" placeholder="email" required autofocus>
                </div>
                <div class="form-group">
                  <input class="form-control" id="password" type="password" placeholder="Password" required autofocus>
                </div>
                <button class="btn btn-primary w-100" onclick="onLogin()" type="button">Masuk</button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>

    <script src="<?=base_url()?>assets/js/jquery.min.js"></script>
    <script>
        $( document ).ready(function() {
            GetDataUser();
        });

        function GetDataUser(){
            var DataUser = "";
            if (typeof(Storage) !== "undefined") {
                DataUser = localStorage.getItem("@DataUser");
                console.log('Data User : ' + DataUser);
                if(DataUser != null){
                    window.location.href = "<?=base_url()?>dashboard";
                }
            }
        }

        function onLogin() {
            var email = document.getElementById('email').value;
            var password = document.getElementById('password').value;
            var formdata = new FormData();
            formdata.append("email", email);
            formdata.append("password", password);
    
            var requestOptions = {
            method: 'POST',
            body: formdata,
            redirect: 'follow'
            };
    
            fetch("<?=base_url()?>/api/login", requestOptions)
            .then(response => response.json())
            .then(result => {
                if(result.status == true){
                    console.log('berhasil login');
                    if (typeof(Storage) !== "undefined") {
                    localStorage.setItem("@data_user", JSON.stringify(result.result[0]));
                    // console.log(result.result[0]);
                    window.location.href = "<?=base_url()?>dashboard";
                    }
                }else{
                    console.log('gagal login');
                }
            })
            .catch(error => console.log('error', error));
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
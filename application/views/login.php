<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Crystallise</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="<?php echo  base_url()?>/assets/img/favicon.png" rel="icon">
  <link href="<?php echo  base_url()?>/assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="<?php echo  base_url()?>assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="<?php echo  base_url()?>assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="<?php echo  base_url()?>assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="<?php echo  base_url()?>assets/vendor/quill/quill.snow.css" rel="stylesheet">
  <link href="<?php echo  base_url()?>assets/vendor/quill/quill.bubble.css" rel="stylesheet">
  <link href="<?php echo  base_url()?>assets/vendor/remixicon/remixicon.css" rel="stylesheet">
  <link href="<?php echo  base_url()?>assets/vendor/simple-datatables/style.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="<?php echo  base_url()?>assets/css/style.css" rel="stylesheet">

 
</head>

<body>

  <main>
    <div class="container">

      <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
        <div class="container">
          <div class="row justify-content-center">
            <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">

              <div class="d-flex justify-content-center py-4">
                <a href="#" class="logo d-flex align-items-center w-auto">
                  <img src="<?php echo  base_url()?>/assets/img/logo.png" alt="">
                  <span class="d-none d-lg-block">Crystallise</span>
                </a>
              </div><!-- End Logo -->

              <div class="card mb-3">

                <div class="card-body">

                  <div class="pt-4 pb-2">
                    <h5 class="card-title text-center pb-0 fs-4">Login to Your Account</h5>
                    <p class="text-center small">Enter your email & password to login</p>
                  </div>
                  <?php 
                  if($this->session->flashdata('success_msg')){ ?>
                    <div class="alert alert-success" role="alert">
                      <?php echo $this->session->flashdata('success_msg'); ?>
                    </div>
                    <?php  
                  }
                  if($this->session->flashdata('error_msg')){ ?>
                    <div class="alert alert-danger" role="alert">
                      <?php echo $this->session->flashdata('error_msg'); ?>
                    </div>
                    <?php  
                  }
                   ?>
                  <form class="row g-3 needs-validation" novalidate action="" method="post">

                    <div class="col-12">
                      <label for="yourUsername" class="form-label">Email</label>
                      <div class="input-group has-validation">
                        <span class="input-group-text" id="inputGroupPrepend">@</span>
                        <input type="text" name="email" class="form-control" id="yourUsername" placeholder="Please enter your email" required>
                        <div class="invalid-feedback">Please enter your email.</div>
                      </div>
                    </div>

                    <div class="row-12">
                      <label for="validationDefaultUsername" class="form-label">Password</label>
                      <div class="input-group" id="show_hide_password">
                        <span class="input-group-text" id="inputGroupPrepend2"><i class="bi bi-eye-slash" aria-hidden="true"></i></span>
                        <input type="password" name="password" class="form-control" id="password" placeholder="Please enter your password"  required autocomplete="off">
                          <div class="invalid-feedback">Please enter your password minimum 8 character!</div>
                      </div>
                    </div>
                    
                    <!-- <div class="col-12">
                      <label for="yourPassword" class="form-label">Password</label>
                      <input type="password" name="password" class="form-control" id="yourPassword" placeholder="Please enter your password" required>
                      <div class="invalid-feedback">Please enter your password!</div>
                    </div> -->

                    <!-- <div class="col-12">
                      <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="remember" value="true" id="rememberMe">
                        <label class="form-check-label" for="rememberMe">Remember me</label>
                      </div>
                    </div> -->
                    <div class="col-12">
                      <button class="btn btn-primary w-100" type="submit">Login</button>
                    </div>
                    <div class="col-12">
                      <p class="small mb-0">Don't have account? <a href="<?php echo  site_url('register'); ?>">Create an account</a></p>
                    </div>
                  </form>

                </div>
              </div>
              <div class="credits">
                Designed by <a href="https://www.crystallise.com/">Crystallise</a>
              </div>
              </div>
              
             
            </div>
          </div>
        </div>

      </section>

    </div>
  </main><!-- End #main -->

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="<?php echo  base_url()?>assets/vendor/apexcharts/apexcharts.min.js"></script>
  <script src="<?php echo  base_url()?>assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="<?php echo  base_url()?>assets/vendor/chart.js/chart.min.js"></script>
  <script src="<?php echo  base_url()?>assets/vendor/echarts/echarts.min.js"></script>
  <script src="<?php echo  base_url()?>assets/vendor/quill/quill.min.js"></script>
  <script src="<?php echo  base_url()?>assets/vendor/simple-datatables/simple-datatables.js"></script>
  <script src="<?php echo  base_url()?>assets/vendor/tinymce/tinymce.min.js"></script>
  <script src="<?php echo  base_url()?>assets/vendor/php-email-form/validate.js"></script>

  <!-- Template Main JS File -->
  <script src="<?php echo  base_url()?>assets/js/main.js"></script>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<script type="text/javascript">
  $(document).ready(function() {
    $("#inputGroupPrepend2").on('click', function(event) {
      //alert()
        event.preventDefault();
        if($('#show_hide_password input').attr("type") == "text"){
            $('#show_hide_password input').attr('type', 'password');
            $('#show_hide_password i').addClass( "bi-eye-slash" );
            $('#show_hide_password i').removeClass( "bi-eye" );
        }else if($('#show_hide_password input').attr("type") == "password"){
            $('#show_hide_password input').attr('type', 'text');
            $('#show_hide_password i').removeClass( "bi-eye-slash" );
            $('#show_hide_password i').addClass( "bi-eye" );
        }
    });
});
</script>
</body>

</html>
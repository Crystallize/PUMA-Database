<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Dashboard</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="<?php echo  base_url()?>/assets/img/favicon.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="<?php echo  base_url()?>/assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="<?php echo  base_url()?>/assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <!-- <link href="<?php echo  base_url()?>/assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet"> -->
  <!-- <link href="<?php echo  base_url()?>/assets/vendor/quill/quill.snow.css" rel="stylesheet"> -->
  <!-- <link href="<?php echo  base_url()?>/assets/vendor/quill/quill.bubble.css" rel="stylesheet"> -->
  <!-- <link href="<?php echo  base_url()?>/assets/vendor/remixicon/remixicon.css" rel="stylesheet"> -->
  <!-- <link href="<?php echo  base_url()?>/assets/vendor/simple-datatables/style.css" rel="stylesheet"> -->

  <!-- Template Main CSS File -->
  <link href="<?php echo  base_url()?>/assets/css/style.css" rel="stylesheet">

 
</head>

<body>

  <!-- ======= Header ======= -->
  <header id="header" class="header fixed-top d-flex align-items-center">

    <div class="d-flex align-items-center justify-content-between">
      <a href="<?php echo site_url('dashboard') ?>" class="logo d-flex align-items-center">
        <img src="<?php echo  base_url()?>/assets/img/logo.png" alt="">
        <span class="d-none d-lg-block">PUMA</span>
      </a>
      <!-- <i class="bi bi-list toggle-sidebar-btn"></i> -->
    </div><!-- End Logo -->

   
    <nav class="header-nav ms-auto">
      <ul class="d-flex align-items-center">

        <li class="nav-item d-block d-lg-none">
          <a class="nav-link nav-icon search-bar-toggle " href="#">
            <i class="bi bi-search"></i>
          </a>
        </li><!-- End Search Icon-->

        
        <li class="nav-item dropdown pe-3">
          <a class="nav-link nav-profile d-flex align-items-center pe-0" href="https://forms.office.com/Pages/ResponsePage.aspx?id=48TPkEN-PUyFfmbfrxno_f888Njnt-VLq4hZRTyZKm1UNzJOVzZYWklUV0VWSFZQS1ExNjlFM1k5Ry4u" target="_blank">
            <span class="d-none d-md-block ">Feedback Form</span>
          </a>
        </li>
        <li class="nav-item dropdown pe-3">
          <a class="nav-link nav-profile d-flex align-items-center pe-0" href="https://crystalliselimited.sharepoint.com/:w:/r/sites/ModelDev/_layouts/15/Doc.aspx?sourcedoc=%7BB09EF23B-2907-4230-A808-3858027FDDA2%7D&file=Crystallise_BooleanSearchSyntax_V2_guide.docx&action=default&mobileredirect=true"  target="_blank">
            <span class="d-none d-md-block ">User Guide</span>
          </a>
        </li>
        
        <li class="nav-item dropdown pe-3">

          <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown" aria-expanded="false">
            <span class="d-none d-md-block dropdown-toggle ps-2"><?php
              $sess_data = $this->session->userdata('login_data');
              echo ucfirst($sess_data['user_fname']).' '.ucfirst($sess_data['user_lname']);
               ?></span>
          </a><!-- End Profile Iamge Icon -->

          <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile" style="">
            <li>
              <hr class="dropdown-divider">
            </li>

            <li>
              <a class="dropdown-item d-flex align-items-center" href="<?php echo site_url().'updatePassword/'.$sess_data['user_uid'] ?>">
                <i class="bi bi-person"></i>
                <span>My Profile</span>
              </a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li>
              <a class="dropdown-item d-flex align-items-center" href="<?php echo site_url('queryLog') ?>">
                <i class="bi bi-gear"></i>
                <span>Query Log</span>
              </a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <!--<li>
              <a class="dropdown-item d-flex align-items-center" href="pages-faq.html">
                <i class="bi bi-question-circle"></i>
                <span>Need Help?</span>
              </a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li> -->

            <li>
              <a class="dropdown-item d-flex align-items-center" href="<?php echo base_url() ?>welcome/logout">
                <i class="bi bi-box-arrow-right"></i>
                <span>Sign Out</span>
              </a>
            </li>

          </ul><!-- End Profile Dropdown Items -->
        </li>
        <!-- End Profile Nav -->

      </ul>
    </nav><!-- End Icons Navigation -->

  </header><!-- End Header -->
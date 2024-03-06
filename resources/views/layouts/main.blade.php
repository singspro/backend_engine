<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>PPD MACO</title>
  <meta content="" name="description">
  <meta content="" name="keywords">
  <meta name="csrf-token" content="{{ csrf_token() }}" />

  <!-- Favicons -->
  <link href="assets/img/favicon.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="assets/vendor/quill/quill.snow.css" rel="stylesheet">
  <link href="assets/vendor/quill/quill.bubble.css" rel="stylesheet">
  <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">
  <link href="assets/vendor/simple-datatables/style.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="assets/css/style.css" rel="stylesheet">
  <link rel="stylesheet" href="assets/css/dselect.css">
  <!-- =======================================================
  * Template Name: NiceAdmin
  * Updated: Mar 09 2023 with Bootstrap v5.2.3
  * Template URL: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body>

  <!-- ======= Header ======= -->
  <header id="header" class="header fixed-top d-flex align-items-center">

    <div class="d-flex align-items-center justify-content-between">
      <a href="/" class="logo d-flex align-items-center">
        <img src="assets/img/logo.png" alt="">
        <span class="d-none d-lg-block">PPD MACO</span>
      </a>
      <i class="bi bi-list toggle-sidebar-btn"></i>
    </div><!-- End Logo -->

    <nav class="header-nav ms-auto">
      <ul class="d-flex align-items-center">

        <li class="nav-item dropdown pe-3">

          <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
            <img src="assets/img/profile-img.jpg" alt="Profile" class="rounded-circle">
            <span class="d-none d-md-block dropdown-toggle ps-2">{{$user->name}}</span>
          </a><!-- End Profile Iamge Icon -->

          <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
            <li class="dropdown-header">
              <h6>{{$user->name}}</h6>
              {{-- <span>Web Designer</span> --}}
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            {{-- <li>
              <a class="dropdown-item d-flex align-items-center" href="users-profile.html">
                <i class="bi bi-person"></i>
                <span>My Profile</span>
              </a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li>
              <a class="dropdown-item d-flex align-items-center" href="users-profile.html">
                <i class="bi bi-gear"></i>
                <span>Account Settings</span>
              </a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li> --}}

            {{-- <li>
              <a class="dropdown-item d-flex align-items-center" href="pages-faq.html">
                <i class="bi bi-question-circle"></i>
                <span>Need Help?</span>
              </a>
            </li> --}}
            <li>
              <hr class="dropdown-divider">
            </li>

            <li>
              <form method="post" action="/janganTinggalinAkuKasih">
                @csrf
              <button type="submit" class="dropdown-item d-flex align-items-center">
                <i class="bi bi-box-arrow-right"></i>
                <span>Sign Out</span>
              </button>
            </form>
            </li>

          </ul><!-- End Profile Dropdown Items -->
        </li><!-- End Profile Nav -->

      </ul>
    </nav><!-- End Icons Navigation -->

  </header><!-- End Header -->

  <!-- ======= Sidebar ======= -->
  <aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

      <li class="nav-item">
        <a class="nav-link {{($title==='dashboard') ? '':'collapsed'}}" href="/">
          <i class="bi bi-grid"></i>
          <span>Dashboard</span>
        </a>
      </li><!-- End Dashboard Nav -->

      <li class="nav-item">
        <a class="nav-link {{($title==='manpower') ? '':'collapsed'}}" data-bs-target="#components-nav" data-bs-toggle="collapse" href="/mp">
          <i class="bi bi-people"></i><span>Manpower</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="components-nav" class="nav-content collapse {{($title==='manpower') ? 'show':''}}" data-bs-parent="#sidebar-nav">
          <li>
            <a href="/mp" class="{{($title==='manpower'&&$subTitle==='data') ? 'active':''}}">
              <i class="bi bi-circle"></i><span>Data Manpower</span>
            </a>
          </li>
          <li>
            <a href="/new-mp" class="{{($title==='manpower'&&$subTitle==='new') ? 'active':''}}">
              <i class="bi bi-circle"></i><span>New Manpower</span>
            </a>
          </li>
        </ul>
      </li><!-- End Components Nav -->

      <li class="nav-item">
        <a class="nav-link {{($title==='training') ? '':'collapsed'}}" data-bs-target="#forms-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-journal-text"></i><span>Training</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="forms-nav" class="nav-content collapse {{($title==='training') ? 'show':''}} " data-bs-parent="#sidebar-nav">
          <li>
            <a href="/tr" class="{{($title==='training' && $subTitle==='data') ? 'active':''}}">
              <i class="bi bi-circle"></i><span>Data Training</span>
            </a>
          </li>
          <li>
            <a href="/tr-new" class="{{($title==='training' && $subTitle==='new') ? 'active':''}}">
              <i class="bi bi-circle"></i><span>Input Training</span>
            </a>
          </li>
          <li>
            <a href="/tr-taf" class="{{($title==='training' && $subTitle==='taf') ? 'active':''}}">
              <i class="bi bi-circle"></i><span>TAF</span>
            </a>
          </li>
        </ul>
      </li><!-- End Forms Nav -->

      <li class="nav-item">
        <a class="nav-link {{($title==='mentor') ? '':'collapsed'}}" data-bs-target="#tables-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-layout-text-window-reverse"></i><span>Mentoring</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="tables-nav" class="nav-content collapse {{($title==='mentor') ? 'show':''}} " data-bs-parent="#sidebar-nav">
          <li>
            <a href="/mentor" class="{{($title==='mentor' && $subTitle==='data') ? 'active':''}}">
              <i class="bi bi-circle"></i><span>Data Mentoring</span>
            </a>
          </li>
          <li>
            <a href="/mentor-new" class="{{($title==='mentor' && $subTitle==='new') ? 'active':''}}">
              <i class="bi bi-circle"></i><span>Input Mentoring</span>
            </a>
          </li>
        </ul>
      </li><!-- End Tables Nav -->

      <li class="nav-item">
        <a class="nav-link {{($title==='Bank Soal') ? '':'collapsed'}}" data-bs-target="#soal-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-puzzle"></i><span>Bank Soal</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="soal-nav" class="nav-content collapse {{($title==='Bank Soal') ? 'show':''}} " data-bs-parent="#sidebar-nav">
          <li>
            <a href="/soalMain" class="{{($title==='Bank Soal' && $subTitle==='Daftar Soal') ? 'active':''}}">
              <i class="bi bi-circle"></i><span>Bank Soal</span>
            </a>
          </li>
          <li>
            <a href="/soalNew" class="{{($title==='Bank Soal' && $subTitle==='New Soal') ? 'active':''}}">
              <i class="bi bi-circle"></i><span>New Soal</span>
            </a>
          </li>
          <li>
            <a href="/soalEvent" class="{{($title==='Bank Soal' && $subTitle==='Event List') ? 'active':''}}">
              <i class="bi bi-circle"></i><span>Event</span>
            </a>
          </li>
        </ul>
      </li><!-- End Forms Nav -->

      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#charts-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-bar-chart"></i><span>KPI</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="charts-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
          <li>
            <a href="charts-chartjs.html">
              <i class="bi bi-circle"></i><span>Training</span>
            </a>
          </li>
          <li>
            <a href="charts-apexcharts.html">
              <i class="bi bi-circle"></i><span>Mentoring</span>
            </a>
          </li>
        </ul>
      </li><!-- End Charts Nav -->

      <li class="nav-item">
        <a class="nav-link {{($title==='Shorten URL') ? '':'collapsed'}}" data-bs-target="#shortenUrl" data-bs-toggle="collapse" href="#">
          <i class="bi bi-link-45deg"></i><span>Shorten Your URL's</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="shortenUrl" class="nav-content collapse {{($title==='Shorten URL') ? 'show':''}} " data-bs-parent="#sidebar-nav">
          <li>
            <a href="/shrotUrl" class="{{($title==='Shorten URL' && $subTitle==='URL') ? 'active':''}}">
              <i class="bi bi-circle"></i><span>Shorten Your URL's</span>
            </a>
          </li>
          <li>
            <a href="/newShortUrl" class="{{($title==='Shorten URL' && $subTitle==='newURL') ? 'active':''}}">
              <i class="bi bi-circle"></i><span>New</span>
            </a>
          </li>
        </ul>
      </li><!-- End Forms Nav -->

    </ul>

  </aside><!-- End Sidebar-->

  <main id="main" class="main">
    <div class="pagetitle">
        <h1>{{ucfirst($title)}}</h1>
        <nav>
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Home</a></li>
            <li class="breadcrumb-item active">{{ucfirst($title)}}</li>
          </ol>
        </nav>
      </div><!-- End Page Title -->
    @yield  ('container')
  </main><!-- End #main -->

  <!-- ======= Footer ======= -->
  <footer id="footer" class="footer">
    <div class="copyright">
      &copy; Copyright <strong><span>Plant People Development</span></strong>. All Rights Reserved
    </div>
    <div class="credits">
      <!-- All the links in the footer should remain intact. -->
      <!-- You can delete the links only if you purchased the pro version. -->
      <!-- Licensing information: https://bootstrapmade.com/license/ -->
      <!-- Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/ -->
      Designed by PPD MACO
    </div>
  </footer><!-- End Footer -->

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="https://code.jquery.com/jquery-3.6.4.min.js" integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8=" crossorigin="anonymous"></script>

  <script src="assets/vendor/apexcharts/apexcharts.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
  <script src="assets/vendor/chart.js/chart.umd.js"></script>
  <script src="assets/vendor/echarts/echarts.min.js"></script>
  <script src="assets/vendor/quill/quill.min.js"></script>
  <script src="assets/vendor/simple-datatables/simple-datatables.js"></script>
  <script src="assets/vendor/tinymce/tinymce.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>
  <!-- Template Main JS File -->
  <script src="assets/js/main.js"></script>
  <script src="assets/js/dselect.js"></script>
 

  @stack('scripts')
  @stack('scriptsxx')
  
</body>

</html>
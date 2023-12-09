<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Test Online</title>
  <meta content="" name="description">
  <meta content="" name="keywords">
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
  <link href="assets/css/styleSoal.css" rel="stylesheet">
</head>
<body>
    <header  class="header fixed-top d-flex align-items-center">

        <div class="d-flex align-items-center justify-content-between">
          <a href="#" class="logo d-flex align-items-center">
            <img src="assets/img/logo.png" alt="">
            <span class="d-none d-lg-block">PPD MACO</span>
          </a>
        </div><!-- End Logo -->   
    </header><!-- End Header -->

    <main id="main" class="main">
        <section class="section dashboard">
            <div class="row">
                <div class="col-lg-12">
                    <div class='card'>
                        <div class="card-header">
                            <div class="text-center">
                                <h1>{{$judulTest}}</h1>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="col-lg-12">
                                <p><span style="font-size:14pt;"><strong>Rules and Regulations</strong></span></p>
                                <ul>
                                    <li>Make sure that you write your name and student ID correctly. Otherwise, the system can't record your grades.</li>
                                    <li>The given time for this quiz is 45 minutes. After that, the form will be closed for you.</li>
                                    <li>Students who will not submit their answers in time will receive 0.</li>
                                    <li>You can only submit your answers once. If you wish to pause the the quiz, please use the Save and Continue Later button.</li>
                                    <li>Each question has its own grading points. After you submit your answers, we will evaluate your answers and let you know your grades later.</li>
                                    <li>If you have any technical problem during the quiz, please take a screenshot or screen recording and send us.</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class='card'>
                          <div class="card-body">
                            <div class="col-lg-12">
                                <h5 class="card-title">Data Peserta</h5>
                                <!-- Multi Columns Form -->
                                <form class="row g-3">
                                    <div class="col-md-12">
                                        <label for="inputName5" class="form-label">Nama</label>
                                        <input type="text" class="form-control" id="inputName5">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="inputEmail5" class="form-label">Jabatan</label>
                                        <input type="email" class="form-control" id="inputEmail5">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="inputEmail5" class="form-label">Perusahaan</label>
                                        <input type="email" class="form-control" id="inputEmail5">
                                    </div>
                                </form><!-- End Multi Columns Form -->
                            </div>
                        </div>
                    </div>
                    <div class='card'>
                        <div class="card-body">
                            <div class="col-lg-12">
                                <ol class="list-group list-group-numbered mt-3">
                                <li class="list-group-item">Jumlah ECMV transmissi pada unit Bulldozer D375A-6R sebanyak.....
                                    <div class="col-sm-10">
                                        <div class="form-check">
                                          <input class="form-check-input" type="radio" name="gridRadios" value="option1">
                                          <label class="form-check-label" for="gridRadios1">
                                            First radio
                                          </label>
                                        </div>
                                        <div class="form-check">
                                          <input class="form-check-input" type="radio" name="gridRadios"  value="option2">
                                          <label class="form-check-label" for="gridRadios2">
                                            Second radio
                                          </label>
                                        </div>
                                    </div>
                                </li>

                               
                                <li class="list-group-item">Jumlah ECMV transmissi pada unit Bulldozer D375A-6R sebanyak.....
                                    <div class="col-sm-10">
                                        <div class="form-check">
                                          <input class="form-check-input" type="radio" name="gridRadios1"  value="option3">
                                          <label class="form-check-label" for="gridRadios1">
                                            First radio
                                          </label>
                                        </div>
                                        <div class="form-check">
                                          <input class="form-check-input" type="radio" name="gridRadios1"  value="option4">
                                          <label class="form-check-label" for="gridRadios2">
                                            Second radio
                                          </label>
                                        </div>
                                    </div>
                                </li>
                                </ol>
                            </div>
                        </div>
                    </div>

                    
                </div>
            </div>
        </section>
    </main>

    <footer  class="footer">
        <div class="copyright">
          &copy; Copyright <strong><span>Plant People Development</span></strong>. All Rights Reserved
        </div>
        <div class="credits">
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
</body>
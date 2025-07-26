<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?php echo $title; ?></title>

  <!-- CSS -->
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="css/font-awesome.min.css">
  <link href="css/style.css" rel="stylesheet">
  <link href="css/datatable-bootstrap.css" rel="stylesheet">
  <script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

  <!-- Custom Style -->
  <style>
     body {
    background-color: #f9f9f9;
    margin: 0;
    padding: 0;
  }
    .navbar-utama {
      background-color: rgba(103, 150, 177, 0.8) !important;
      border: none;
    }

    .navbar-utama .navbar-nav {
      display: flex;
      justify-content: center;
      flex-wrap: nowrap;
      overflow-x: auto;
    }

    .navbar-utama .nav > li > a {
      color: #ffffff !important;
      font-weight: bold;
      white-space: nowrap;
      padding-left: 20px;
      padding-right: 20px;
    }

    .navbar-utama .nav > li > a:hover {
      background-color: rgba(103, 150, 177, 1) !important;
    }

   .judul-head {
    font-family: 'Poppins', sans-serif;
    font-size: 30px;
    font-weight: 700;
    color: #2b3e50;
    text-align: center;
    margin-top: 30px;
  }

  .deskripsi-head {
    font-size: 17px;
    color: #555;
    text-align: center;
    margin-bottom: 20px;
  }
  </style>
</head>

<body>
  <div class="container">
    <div class="row">
      <div class="head-depan" style="text-align: left;">
        <h1 class="judul-head">Sistem Informasi Geografis Industri Kreatif</h1>
        <p class="deskripsi-head"><i class="fa fa-map-marker fa-fw"></i> Sistem Informasi yang memuat data industri kreatif di Provinsi Daerah Istimewa Yogyakarta</p>
        <hr class="hr1 margin-b-10" />
      </div>
    </div>
  </div>

  <div class="container margin-b70">
    <nav class="navbar navbar-default navbar-utama" role="navigation">
      <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
          <span class="sr-only">Navigasi</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
      </div>

      <div class="collapse navbar-collapse navbar-ex1-collapse">
        <ul class="nav navbar-nav">
          <li><a href="index.php"><i class="fa fa-home"></i> Beranda</a></li>
          <li><a href="data.php"><i class="fa fa-list-ul"></i> Data Industri Kreatif</a></li>
          <li><a href="peta1.php"><i class="fa fa-map-marker"></i> Peta Persebaran Industri Kreatif</a></li>
          <li><a href="peta.php"><i class="fa fa-th-large"></i> Peta Sentra Industri Kreatif</a></li>
           <li><a href="peta3.php" data-toggle="modal" data-target="#about"><i class="fa fa-user"></i> Peta Konsentrasi Industri Kreatif</a></li>
            <li><a href="pendahuluan.php" data-toggle="modal" data-target="#about"><i class="fa fa-user"></i> Pendahuluan </a></li>
        </ul>
      </div>
    </nav>

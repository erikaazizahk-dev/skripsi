<!-- Creative Footer with Animation -->
<style>
  footer a {
    color: #fff;
    text-decoration: none;
    font-weight: 500;
    transition: all 0.3s ease;
  }

  footer a:hover {
    color: #FFD700;
    transform: translateY(-2px);
  }

  footer .fade-in {
    animation: fadeIn 1.2s ease-in-out;
  }

  @keyframes fadeIn {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
  }
</style>

<footer class="fade-in" style="background: rgba(103, 150, 177, 0.85); color: white; padding: 40px 0;">
  <div class="container text-center">
    <!-- Title -->
    <h3 style="font-weight: 700; margin-bottom: 10px;">
      <i class="fa fa-lightbulb-o"></i> SIG Industri Kreatif Yogyakarta
    </h3>
    <p style="font-size: 15px; max-width: 700px; margin: auto; line-height: 1.6;">
      Temukan informasi dan peta interaktif pelaku industri kreatif di Daerah Istimewa Yogyakarta untuk mendukung ekosistem ekonomi berbasis inovasi dan budaya lokal.
    </p>

    <!-- Navigation -->
    <ul class="list-inline" style="margin: 30px 0 10px;">
      <li style="margin: 0 15px;">
        <a href="index.php"><i class="fa fa-home"></i> Beranda</a>
      </li>
      <li style="margin: 0 15px;">
        <a href="data.php"><i class="fa fa-list"></i> Data Industri Kreatif</a>
      </li>
      <li style="margin: 0 15px;">
        <a href="peta1.php"><i class="fa fa-map-marker"></i> Peta Persebaran Industri Kreatif</a>
      </li>
      <li style="margin: 0 15px;">
        <a href="peta.php"><i class="fa fa-user"></i> Peta Sentra Industri Kreatif</a>
      </li>
      <li style="margin: 0 15px;">
        <a href="peta3.php"><i class="fa fa-user"></i> Peta Konsentrasi Industri Kreatif</a>
      </li>
    </ul>
    <!-- Copyright -->
    <p style="font-size: 13px; color: #eee; margin-top: 10px;">
      &copy; <?php echo date("Y"); ?> Provinsi Daerah Istimewa Yogyakarta. All rights reserved.
    </p>
  </div>
</footer>

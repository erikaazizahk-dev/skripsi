<div class="container text-center mt-5 mb-5">
  <h3 class="mb-4"><strong>13 Subsektor Industri Kreatif</strong></h3>

  <div class="d-flex flex-wrap justify-content-center">
    <?php
    $subsektor = [
      "Aplikasi" => ["Aplikasi.png", "Deskripsi aplikasi..."],
      "Arsitektur" => ["Arsitektur.png", "Deskripsi arsitektur..."],
      "Desain" => ["Desain.png", "Deskripsi desain..."],
      "Fashion" => ["Fashion.png", "Deskripsi fashion..."],
      "Media" => ["Media.png", "Deskripsi media..."],
      "Fotografi" => ["Fotografi.png", "Deskripsi fotografi..."],
      "Kriya" => ["Kriya.png", "Deskripsi kriya..."],
      "Kuliner" => ["Kuliner.png", "Deskripsi kuliner..."],
      "Musik" => ["Musik.png", "Deskripsi musik..."],
      "Penerbitan" => ["Penerbitan.png", "Deskripsi penerbitan..."],
      "Periklanan" => ["Periklanan.png", "Deskripsi periklanan..."],
      "Seni Pertunjukan" => ["SeniPertunjukan.png", "Deskripsi seni pertunjukan..."],
      "Seni Rupa" => ["SeniRupa.png", "Deskripsi seni rupa..."],
    ];

    $id = 1;
    foreach ($subsektor as $judul => [$gambar, $deskripsi]) {
    ?>
      <div class="subsektor-item text-center">
        <a href="#" data-toggle="modal" data-target="#modal<?php echo $id; ?>">
          <div class="position-relative mx-auto">
            <img src="img/<?php echo $gambar; ?>" class="img-subsektor rounded-circle shadow" alt="<?php echo $judul; ?>">
            <div class="overlay-text"><strong><?php echo $judul; ?></strong></div>
          </div>
        </a>
      </div>

      <!-- Modal -->
      <div class="modal fade" id="modal<?php echo $id; ?>" tabindex="-1" role="dialog" aria-labelledby="modalLabel<?php echo $id; ?>" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content p-3">
            <div class="modal-header border-0">
              <h5 class="modal-title mx-auto" id="modalLabel<?php echo $id; ?>"><strong><?php echo $judul; ?></strong></h5>
              <button type="button" class="close position-absolute" style="right:15px;" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <img src="img/<?php echo $gambar; ?>" alt="<?php echo $judul; ?>" class="img-fluid rounded mb-3" style="object-fit:cover; max-height:300px; width:100%;">
            <div class="modal-body text-justify">
              <p><?php echo $deskripsi; ?></p>
            </div>
            <div class="modal-footer border-0 justify-content-center">
              <a href="detail_<?php echo strtolower(str_replace([' ', ',', '&'], ['_', '', ''], $judul)); ?>.php" class="btn btn-primary">Lihat Detail</a>
            </div>
          </div>
        </div>
      </div>
    <?php
      $id++;
    }
    ?>
  </div>
</div>

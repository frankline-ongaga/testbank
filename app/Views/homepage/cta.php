 <!-- Contact Banner Area Start -->
    <section class="py-60 ">
      <div class="container">
        <div class="contact_banner">
          <h2 class="mb-8 color-white">Pass<br><span class="fm-sec">NCLEX test</span></h2>
          <p class="mb-16 color-white">on your first try</p>
          <div class="mx-auto">
            <?php
              // Compute free test URL in the same way as the header nav
              $uri = service('uri');
              $path = trim($uri->getPath(), '/');
              $segments = $uri->getSegments();
              $freeId = null;

              // If currently on a free test page, use that id
              if (!$freeId && !empty($segments) && count($segments) >= 3 && $segments[0] === 'free' && $segments[1] === 'test' && ctype_digit($segments[2])) {
                  $freeId = (int)$segments[2];
              }
              // Prefer homepage section logic: use first available free test from the list
              if (!$freeId && !empty($freeTests) && is_array($freeTests)) {
                  foreach ($freeTests as $ftTmp) {
                      if (!empty($ftTmp['id'])) { $freeId = (int)$ftTmp['id']; break; }
                  }
              }
              // Fallbacks
              if (!$freeId && !empty($activeFreeTest) && !empty($activeFreeTest['id'])) {
                  $freeId = (int)$activeFreeTest['id'];
              }
              if (!$freeId && !empty($test) && !empty($test['is_free']) && !empty($test['id'])) {
                  $freeId = (int)$test['id'];
              }
              // Absolute fallback: query DB for any active free test
              if (!$freeId) {
                  try {
                      $db = \Config\Database::connect();
                      $row = $db->table('tests')
                          ->where('is_free', 1)
                          ->where('status', 'active')
                          ->orderBy('id', 'DESC')
                          ->get(1)
                          ->getRowArray();
                      if (!empty($row['id'])) {
                          $freeId = (int)$row['id'];
                      }
                  } catch (\Throwable $e) {
                      // Silently ignore DB issues in CTA
                  }
              }
              $takeTestUrlCta = $freeId ? base_url('free/test/' . $freeId) : base_url('client/tests');
            ?>
            <a href="<?= esc($takeTestUrlCta) ?>" class="h5 phone_number">Take a Free Test</a>
          </div>
          <div class="icons">
            <img src="<?= base_url('assets/media/shapes/dots-1.png'); ?>" alt="ati" class="element-1">
            <img src="<?= base_url('assets/media/shapes/vector-3.png'); ?>" alt="teas" class="element-2">
            <img src="<?= base_url('assets/media/shapes/paint.png'); ?>" alt="nclex" class="element-3">
            <img src="<?= base_url('assets/media/shapes/vector-4.png'); ?>" alt="test banks" class="element-5">
            <img src="<?= base_url('assets/media/shapes/dots-1.png'); ?>" alt="nursing" class="element-4">
            <img src="<?= base_url('assets/media/shapes/tag.png'); ?>" alt="dnp" class="element-6">
            <img src="<?= base_url('assets/media/shapes/errow.png'); ?>" alt="bsn" class="element-7">
            <img src="<?= base_url('assets/media/shapes/circle-lines.png'); ?>" alt="entrance exams" class="element-8">
            <img src="<?= base_url('assets/media/shapes/mic-speaker.png'); ?>" alt="exit exams" class="element-9">
          </div>
        </div>
      </div>
    </section>
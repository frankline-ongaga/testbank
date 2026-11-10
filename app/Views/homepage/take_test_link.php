<?php
// Share test selection between the desktop and mobile navigation.
$uri = service('uri');
$path = trim($uri->getPath(), '/');
$segments = $uri->getSegments();
// Detect current free test page
$isFreeTest = (strpos($path, 'free/test') === 0 || strpos($path, 'index.php/free/test') === 0);
$freeId = null;
// If currently on a free test page, use that id
if (!$freeId && !empty($segments) && count($segments) >= 3 && $segments[0] === 'free' && $segments[1] === 'test' && ctype_digit($segments[2])) {
  $freeId = (int)$segments[2];
}
// Prefer homepage section logic: use first available free test from the list
if (!$freeId && !empty($freeTests) && is_array($freeTests)) {
  foreach ($freeTests as $ftTmp) { if (!empty($ftTmp['id'])) { $freeId = (int)$ftTmp['id']; break; } }
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
    // Keep navigation available when the database is unavailable
  }
}
$takeTestUrl = $freeId ? base_url('free/test/' . $freeId) : base_url('client/tests');
?>
<a href="<?= esc($takeTestUrl) ?>" class="btn btn-warning btn-sm <?= $isFreeTest ? 'active' : '' ?>" style="font-weight:700; color:#000;">Take a Test</a>

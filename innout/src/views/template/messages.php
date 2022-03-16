<?php
$errors = [];
if (isset($_SESSION['message'])) {
  $message = $_SESSION['message'];
  unset($_SESSION['message']);
} else if (isset($exception)) {
  $message = [
    'type' => 'error',
    'message' => $exception->getMessage()
  ];
}

$alertType = '';

if($message['type'] === 'error') {
  $alertType = 'danger';
} else {
  $alertType = 'success';
}
?>

<?php if($message): ?>
  <div role="alert"
  class="my-3 alert alert-<?= $alertType ?>">
    <?= $message['message']?>
  </div>
<?php endif ?>

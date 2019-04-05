<!-- <?php echo isset($iconOk) ? $iconOk : "dsd" ?> -->

<i class="bounceIn fas fa-<?= $satusState ? (isset($iconOk) ? $iconOk : "check") : (isset($iconNo) ? $iconNo : "times") ?> text-<?= $satusState ? "success" : "danger" ?> fa-9x m-5"></i>
<br />
<?php
require "checkpost.php";
require "../db/database.php";

$db = new Database();

$db->chengeDonationStatus(
    $_POST["id"],
    $_POST["adminid"],
    $_POST["status"]
);

$db->addAdminJournal($_POST["adminid"], "change_donation_status", $_POST["status"] == "open" ? 1 : 0, $_POST["id"]);

?>

<script>
history.back();
</script>


<?php
include('config.php');
$client->revokeToken();
session_destroy();

header('location:index.php');
?>
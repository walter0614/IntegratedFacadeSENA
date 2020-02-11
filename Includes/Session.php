<?php
session_start();
if (!isset($_SESSION["USER_NAME"])) {
    header('Location: index.php');
}

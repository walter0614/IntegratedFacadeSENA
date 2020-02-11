<?php
include_once("../Controller/LoginController.php");
include_once("../Connection/Connection.php");
$connection = new Connection();
$loginController = new LoginController();

$connection->OpenConnection();

if ($_POST["user"] && $_POST["pass"]) {
    $user = $_POST["user"];
    $pass = base64_encode($_POST["pass"]);
    $data = $loginController->Login($connection, $user, $pass);
    if (count($data) > 0) {
        session_start();
        for ($i = 0; $i < count($data); $i++) {
            $_SESSION["USER_NAME"] = $data[$i][LoginDAO::$NAME_COLUMN];
        }
        header('Location: ../Views/login.php');
    } else {
        $url = strtok($_SERVER['HTTP_REFERER'], '?');
        header('Location: ' . $url . '?state=' . base64_encode('error'));
    }
}





$connection->Close();

<?php
require_once("../Connection/Connection.php");
require_once('../Controller/CategoryController.php');
$connection = new Connection();
$connection->OpenConnection();

$data = json_decode(trim(file_get_contents('php://input')), true);

switch ($data['type']) {
    case 'category':
        $categoryController = new CategoryController;
        $result = $categoryController->syncCategory($connection);
        break;
}

$connection->Close();
echo json_encode($result);

<?php
require_once("../Connection/Connection.php");
require_once('../Controller/CategoryController.php');
require_once('../Controller/CourseController.php');
$connection = new Connection();
$connection->OpenConnection();

$data = json_decode(trim(file_get_contents('php://input')), true);

switch ($data['type']) {
    case 'category':
        $categoryController = new CategoryController;
        $result = $categoryController->syncCategory($connection);
        break;
    case 'course':
        $courseController = new CourseController;
        $result = $courseController->syncCourse($connection, $data['categoryId']);
        break;
}

$connection->Close();
echo json_encode($result);

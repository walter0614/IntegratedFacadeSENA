<?php
require_once("../Connection/Connection.php");
require_once('../Controller/CategoryController.php');
require_once('../Controller/CourseController.php');
require_once('../Controller/ModuleController.php');
require_once('../Controller/ActivityController.php');

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
    case 'module':
        $moduleController = new ModuleController;
        $result = $moduleController->syncModule($connection, $data['courseId']);
        break;
    case 'activity':
        $activityController = new ActivityController;
        $result = $activityController->syncActivity($connection, $data['courseId'], $data['moduleId']);
        break;
}

$connection->Close();
echo json_encode($result);

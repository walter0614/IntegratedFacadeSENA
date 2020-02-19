<?php
include_once("../DAO/CourseDAO.php");
include_once("../DAO/SyncDAO.php");
include_once("../DAO/EndPointDAO.php");
require_once("SyncController.php");

$courseDAO = new CourseDAO();
$endPointDAO = new EndPointDAO();

class CourseController
{

    function GetCoursesByCategory($conn, $parameter, $categoryId)
    {
        global $courseDAO;
        global $endPointDAO;
        if ($parameter["WS"]) {
            $data = [];
            $ws = $endPointDAO->GetEndPoint("core_course_get_courses_by_field", "field=category&value=" . $categoryId);
            $localCourses = $this->GetCoursesByCategory($conn, array("WS" => false), $categoryId);
            $rs = toStdToArray(json_decode(file_get_contents($ws), true))["courses"];
            for ($i = 0; $i < count($rs); $i++) {
                $localCourse = $this->GetStateLocalCourses($localCourses, $rs[$i]);
                array_push(
                    $data,
                    array(
                        CourseDAO::$ID_COLUMN  => $rs[$i][CourseDAO::$ID_COLUMN],
                        CourseDAO::$NAME_COLUMN  => $rs[$i][CourseDAO::$NAME_COLUMN],
                        CourseDAO::$CATEGORY_ID_COLUMN  => $rs[$i][CourseDAO::$CATEGORY_ID_COLUMN],
                        CourseDAO::$START_DATE_COLUMN  => $rs[$i][CourseDAO::$START_DATE_COLUMN],
                        CourseDAO::$END_DATE_COLUMN  => $rs[$i][CourseDAO::$END_DATE_COLUMN],
                        CourseDAO::$TIME_CREATED_COLUMN  => $rs[$i][CourseDAO::$TIME_CREATED_COLUMN],
                        CourseDAO::$TIME_MODIFIED_COLUMN  => $rs[$i][CourseDAO::$TIME_MODIFIED_COLUMN],
                        SyncDAO::$STATE_COLUMN  => $localCourse[SyncDAO::$STATE_COLUMN]
                    )
                );
            }
        } else {
            $data = $courseDAO->GetCoursesByCategory($conn, $categoryId);
        }
        return $data;
    }

    function GetStateLocalCourses($localCourses, $course)
    {
        $courseRS = array(
            SyncDAO::$STATE_COLUMN => SyncDAO::$STATE_ERROR_COLUMN,
            SyncDAO::$DESCRIPTION_COLUMN = ""
        );
        for ($i = 0; $i < count($localCourses); $i++) {
            $courseRS[SyncDAO::$STATE_COLUMN] = $course[CourseDAO::$ID_COLUMN] == $localCourses[$i][CourseDAO::$ID_COLUMN] && $course[CourseDAO::$TIME_MODIFIED_COLUMN] == $localCourses[$i][CourseDAO::$TIME_MODIFIED_COLUMN] ? SyncDAO::$STATE_OK_COLUMN : $courseRS[SyncDAO::$STATE_COLUMN];
            $courseRS[SyncDAO::$STATE_COLUMN] = $course[CourseDAO::$ID_COLUMN] == $localCourses[$i][CourseDAO::$ID_COLUMN] && $course[CourseDAO::$TIME_MODIFIED_COLUMN] != $localCourses[$i][CourseDAO::$TIME_MODIFIED_COLUMN] ? SyncDAO::$STATE_UPDATE_COLUMN : $courseRS[SyncDAO::$STATE_COLUMN];
        }
        return $courseRS;
    }

    function syncCourse($connection, int $categoryId)
    {
        global $courseDAO;

        $data = $this->GetCoursesByCategory($connection, ['WS' => true], $categoryId);
        $dataSync = SyncController::syncInEnsename($data, 'course');

        if (!$dataSync['status']) {
            return $dataSync;
        }

        $errors = [];
        foreach ($dataSync['data'] as $key => $value) {

            if ($value['status']) {

                if ($value['state'] == 'POR ACTUALIZAR') {
                    $courseDAO->updateCourse($connection, $value);
                } else {
                    $courseDAO->saveCourse($connection, $value);
                }
            } else {
                $errors[] = $value;
            }
        }

        return ['status' => true, 'msg' => 'Sincronizado exitosamente', 'errors' => $errors];
    }
}

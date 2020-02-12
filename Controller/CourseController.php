<?php
include_once("../DAO/CourseDAO.php");
include_once("../DAO/SyncDAO.php");

$courseDAO = new CourseDAO();

class CourseController
{

    function GetCoursesByCategory($conn, $parameter, $categoryId)
    {
        global $courseDAO;
        if ($parameter["WS"]) {
            $data = [];
            $localCourses = $this->GetCoursesByCategory($conn, array("WS" => false), $categoryId);
            $rs = toStdToArray(json_decode(file_get_contents("http://192.168.100.175/moodlesena/webservice/rest/server.php?wstoken=be36ba0fa968207d3e75bb00d186b636&wsfunction=core_course_get_courses_by_field&moodlewsrestformat=json&field=category&value=" . $categoryId), true))["courses"];
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
}

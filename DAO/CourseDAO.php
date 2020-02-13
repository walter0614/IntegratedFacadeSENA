<?php
include_once('../Utils/Utils.php');

class CourseDAO
{
    public static $COURSE_TABLE_NAME = "Course";
    public static $ID_COURSE_COLUMN = "id_course";
    public static $ID_COLUMN = "id";
    public static $NAME_COLUMN = "fullname";
    public static $CATEGORY_ID_COLUMN = "categoryid";
    public static $START_DATE_COLUMN = "startdate";
    public static $END_DATE_COLUMN = "enddate";
    public static $TIME_CREATED_COLUMN = "timecreated";
    public static $TIME_MODIFIED_COLUMN = "timemodified";

    public static function GetCoursesByCategory($conn, $categoryId)
    {
        $columns = array(
            CourseDAO::$ID_COURSE_COLUMN,
            CourseDAO::$ID_COLUMN,
            CourseDAO::$NAME_COLUMN,
            CourseDAO::$CATEGORY_ID_COLUMN,
            CourseDAO::$START_DATE_COLUMN,
            CourseDAO::$END_DATE_COLUMN,
            CourseDAO::$TIME_CREATED_COLUMN,
            CourseDAO::$TIME_MODIFIED_COLUMN
        );
        $query = "SELECT " . toString($columns)
            . " FROM " . CourseDAO::$COURSE_TABLE_NAME
            . " WHERE " . CourseDAO::$CATEGORY_ID_COLUMN . "=?";
        $data = $conn->Query($query, array($categoryId));
        return $data;
    }
}

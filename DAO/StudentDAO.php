<?php
include_once('../Utils/Utils.php');

class StudentDAO
{
    public static $STUDENT_TABLE_NAME = "student";
    public static $ID_COLUMN = "id";
    public static $FIRST_NAME_COLUMN = "firstname";
    public static $LAST_NAME_COLUMN = "lastname";
    public static $EMAIL_COLUMN = "email";
    public static $CUSTOM_FIELDS_COLUMN = "customfields";
    public static $ID_COURSE_COLUMN = "id_course";
    public static $DEPARTMENT_COLUMN = "department";
    public static $FIRST_ACCESS_COLUMN = "firstaccess";
    public static $LAST_ACCESS_COLUMN = "lastaccess";
    public static $LAST_ACCESS_COURSE_COLUMN = "lastcourseaccess";

    public static function GetStudentsByCourse($conn, $courseId)
    {
        $columns = array(
            StudentDAO::$ID_COLUMN,
            StudentDAO::$FIRST_NAME_COLUMN,
            StudentDAO::$LAST_NAME_COLUMN,
            StudentDAO::$EMAIL_COLUMN,
            StudentDAO::$CUSTOM_FIELDS_COLUMN,
            StudentDAO::$ID_COURSE_COLUMN
        );
        $query = "SELECT " . toString($columns)
            . " FROM " . StudentDAO::$STUDENT_TABLE_NAME
            . " WHERE " . StudentDAO::$ID_COURSE_COLUMN . "=?";
        $data = $conn->Query($query, array($courseId));
        return $data;
    }

    public static function saveStudent($conn, array $data): void
    {
        $columns = [
            StudentDAO::$ID_COLUMN,
            StudentDAO::$FIRST_NAME_COLUMN,
            StudentDAO::$LAST_NAME_COLUMN,
            StudentDAO::$EMAIL_COLUMN,
            StudentDAO::$CUSTOM_FIELDS_COLUMN,
            StudentDAO::$ID_COURSE_COLUMN
        ];

        $query = "INSERT INTO " . StudentDAO::$STUDENT_TABLE_NAME
            . " (" . toString($columns) . ")"
            . " VALUES (" . $data['id'] . ", '" . $data['firstname'] . "', '"
            . $data['lastname'] . "', '" . $data['email'] . "','" . $data['customfields'] . "'," . $data['id_course'] . ")";
        $conn->Query($query);
    }

    public static function updateStudent($conn, array $data): void
    {
        $query = "UPDATE " . StudentDAO::$STUDENT_TABLE_NAME
            . " SET " . StudentDAO::$FIRST_NAME_COLUMN . " = '" . $data['firstname'] . "', "
            . StudentDAO::$LAST_NAME_COLUMN . " = '" . $data['lastname'] . "', "
            . StudentDAO::$EMAIL_COLUMN . " = '" . $data['email'] . "',"
            . StudentDAO::$CUSTOM_FIELDS_COLUMN . " = '" . $data['customfields'] . "'"
            . " WHERE " . StudentDAO::$ID_COLUMN . " = " . $data['id'];

        $conn->Query($query);
    }
}

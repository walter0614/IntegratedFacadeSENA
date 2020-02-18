<?php
include_once('../Utils/Utils.php');

class ActivityDAO
{
    public static $COURSE_TABLE_NAME = "Activity";
    public static $ID_COLUMN = "id";
    public static $ID_ACTIVITY_COLUMN = "id_activity";
    public static $NAME_COLUMN = "name";
    public static $COURSE_ID_COLUMN = "courseid";
    public static $MODULE_ID_COLUMN = "moduleid";
    public static $TIPO_ACTIVITY = "modname";
    public static $TYPES_ACTIVITY = array("hvp","workshop","assign");

    public static function GetActivitiesByCourseAndModule($conn, $courseId, $moduleId)
    {
        $columns = array(
            ActivityDAO::$ID_COLUMN,
            ActivityDAO::$ID_ACTIVITY_COLUMN,
            ActivityDAO::$NAME_COLUMN,
            ActivityDAO::$COURSE_ID_COLUMN,
            ActivityDAO::$MODULE_ID_COLUMN
        );
        $query = "SELECT " . toString($columns)
            . " FROM " . ActivityDAO::$COURSE_TABLE_NAME
            . " WHERE " . ActivityDAO::$COURSE_ID_COLUMN . "=?"
            . " AND " . ActivityDAO::$MODULE_ID_COLUMN . "=?";
        $data = $conn->Query($query, array($courseId, $moduleId));
        return $data;
    }
}

<?php
include_once('../Utils/Utils.php');

class ModuleDAO
{
    public static $MODULE_TABLE_NAME = "Module";
    public static $ID_MODULE_COLUMN = "id_module_table";
    public static $ID_COLUMN = "id";
    public static $NAME_COLUMN = "name";
    public static $SUMARY_COLUMN = "summary";
    public static $SECTION_COLUMN = "section";
    public static $MODULE_ID_COLUMN = "id_module";
    public static $SECTION_ID_COLUMN = "id_section";
    public static $COURSE_ID_COLUMN = "id_course";

    public static function GetContentByCourse($conn, $courseId)
    {
        $columns = array(
            ModuleDAO::$ID_MODULE_COLUMN,
            ModuleDAO::$ID_COLUMN,
            ModuleDAO::$NAME_COLUMN,
            ModuleDAO::$SUMARY_COLUMN,
            ModuleDAO::$SECTION_COLUMN,
            ModuleDAO::$MODULE_ID_COLUMN,
            ModuleDAO::$SECTION_ID_COLUMN,
            ModuleDAO::$COURSE_ID_COLUMN
        );
        $query = "SELECT " . toString($columns)
            . " FROM " . ModuleDAO::$MODULE_TABLE_NAME
            . " WHERE " . ModuleDAO::$COURSE_ID_COLUMN . "=?";
        $data = $conn->Query($query, array($courseId));
        return $data;
    }
}
